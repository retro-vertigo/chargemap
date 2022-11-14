  'use strict';

// ---------------------------------------
//   Required / Import plugins
// ---------------------------------------

import gulp  from 'gulp';
const browser             = require('browser-sync').create();

// --- css
const sass                = require('gulp-sass')(require('sass'));
import bulkSass           from 'gulp-sass-bulk-import';
import postcss            from 'gulp-postcss';
import autoprefixer       from 'autoprefixer';
import pxtorem            from 'postcss-pxtorem';
import easings            from 'postcss-easings';
import discardDuplicates  from 'postcss-discard-duplicates';
import objectFitImages    from 'postcss-object-fit-images';
import cssnano            from 'cssnano';

// --- js
import webpack            from 'webpack';
import webpackStream      from 'webpack-stream';
import named              from 'vinyl-named';

// --- assets, images, svg
import imagemin           from 'gulp-imagemin';
import pngquant           from 'imagemin-pngquant';
import webp               from 'imagemin-webp';
import svgmin             from 'gulp-svgmin';
import svgstore           from 'gulp-svgstore';
import cheerio            from 'gulp-cheerio';
import newer              from 'gulp-newer';


// --- tools pipe
import plumber            from 'gulp-plumber';
import gulpif             from 'gulp-if';
import filter             from 'gulp-filter';
import notify             from 'gulp-notify';
import colors             from 'ansi-colors';
import debug              from 'gulp-debug';

// --- utils
import path               from 'path';
import fs                 from 'fs';
import rename             from 'gulp-rename';
import del                from 'del';
import yargs              from 'yargs';
import yaml               from 'js-yaml';
import zip                from 'gulp-zip';
import dateformat         from 'dateformat';



// ---------------------------------------
//   Config
// ---------------------------------------
// Get CLI arguments ( --production )
const PRODUCTION = !!(yargs.argv.production);

// Load path structure and plugins config from gulpconfig.yaml
const { CONF, PATHS } = yaml.load(fs.readFileSync('gulpconfig.yaml', 'utf8'));

// filter(Boolean) -> remove all falsy values from array (when not in production) 
const postCssPlugins = [
  PRODUCTION && discardDuplicates(),
  PRODUCTION && pxtorem(),
  PRODUCTION && objectFitImages(),
  PRODUCTION && cssnano(),
  // autoprefixer({ cascade: false, grid: 'autoplace' }),
  autoprefixer({ cascade: false }),
  easings(),
].filter(Boolean);



// ---------------------------------------
//   Webpack
// ---------------------------------------

// Webpack config for prod and dev
const webpackConfig = {
  mode: PRODUCTION ? 'production' : 'development',
  // ΩΩΩΩ devtool: !PRODUCTION && 'source-map',

  // entry: {
  //   app: path.resolve(__dirname, 'src/js/main.js'),
  //   'blocks-admin/': path.resolve(__dirname, 'src/js/blocks-admin/block-accordion.js'),
  // },
  output: {
    path:  path.resolve(__dirname, 'dist'),
    // filename: (pathData) => {
    //   return pathData.chunk.name === 'main' ? '[name].min.js' : 'blocks-admin/[name].min.js';
    // },
    // filename: "[name].min.js",
  },


  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
            compact: false
          }
        }
      },
    ],
  },

  externals: {
    jquery: 'jQuery'
  },

  stats: {
    version: false,
    modules: false
  }
}


// 🧽 Build js with webpack
function javascript(){
  return gulp.src(PATHS.src.entries)
  .pipe(plumber( { errorHandler: onPlumberError }))
  .pipe(named())
  .pipe(webpackStream( webpackConfig, webpack ))
  .pipe(gulpif('block-*', rename( { dirname: '/blocks-admin' } )))
  .pipe(rename( { suffix: '.min' } ))
  .pipe(gulp.dest(PATHS.dest.js))
};



// ---------------------------------------
//   Convert Sass files to CSS
// ---------------------------------------
// Create sourcemaps, convert to css, autoprefix, add .min extension, move to DEST and inject styles
function styles(){
  return gulp.src(PATHS.src.css, { sourcemaps: true })
    .pipe(bulkSass())
    .pipe(plumber( { errorHandler: onPlumberError }))
    .pipe(sass.sync({ outputStyle: 'compressed' }))
    .pipe(postcss(postCssPlugins))
    .pipe(rename( { suffix: '.min' }))
    .pipe(gulp.dest(PATHS.dest.css, { sourcemaps: 'maps' }))
    .pipe(browser.stream());
};



// ---------------------------------------
//   Optimize SVG icons
// ---------------------------------------
// 🧽 Compress SVG sources, combine in one file with symbol,
// inlineSvg: true -> remove <?xml ?> and DOCTYPE to use inline
function svg(){
  const inSprite = filter(['**', '!**/external/**/*']);     // exclude big external SVG from sprite build

  return gulp.src(PATHS.src.svg)
    .pipe(plumber( { errorHandler: onPlumberError }))
    
    // Minify each svg file (all svg files)
    .pipe(svgmin( CONF.svgmin ))
    .pipe(gulp.dest(PATHS.dest.svg))
  
    // Build one sprite with each svg (except external folder)
    .pipe(inSprite)
    // .pipe(debug({ title: colors.bgGreen('[ debug ]') }))
    .pipe(svgstore( { inlineSvg: true } ))
    .pipe(rename('sprite.svg'))
    .pipe(cheerio({
      run: function($, file) {
        // $('svg').addClass('sprite-svg visually-hidden');    // if svg has mask
        $('svg').addClass('sprite-svg').attr('style', 'display:none;');
        $('symbol[id^="icon"] *').removeAttr('fill');
      },
      parserOptions: { xmlMode: true }
    }))
    .pipe(gulp.dest(PATHS.dest.svg));
};



// ---------------------------------------
//   Optimize images
// ---------------------------------------
// 🧽 Compress images only if necessary and move to DEST
function images(){
  // console.log('🔥 PRODUCTION', PRODUCTION);
  return gulp.src(PATHS.src.images)
    .pipe(newer(PATHS.dest.images))
    // .pipe(imagemin({verbose: true}))   // default settings
    .pipe(gulpif(PRODUCTION, imagemin([
      imagemin.mozjpeg({quality: 90, progressive: true}),     // lossy
      pngquant({quality: [0.5, 0.5]}),  // lossy
    ], {verbose : true})))
    .pipe(gulp.dest(PATHS.dest.images))

    // decomment if images are copied and converted to webp format
    // TOUPDATE
    /*.pipe(gulpif(PRODUCTION, imagemin([
      webp({quality: 70})
    ], {verbose : true})))
    .pipe(rename( { extname: '.webp' }))
    .pipe(gulp.dest(PATHS.dest.images));*/
};



// ---------------------------------------
//   Copy, clean tasks
// ---------------------------------------
// Copy other files and folders and move to DEST
// base option to tell gulp where to start copying from
function copy(){
  return gulp.src(PATHS.src.copy, { base: PATHS.src_dir })
    .pipe(gulp.dest(PATHS.dest.copy));
};


// Create a .zip archive of the theme
function archive(){
  const time  = dateformat(new Date(), "yyyy-mm-dd_HH-MM");
  const pkg   = JSON.parse(fs.readFileSync('./package.json'));
  const title = pkg.name + '_' + time + '.zip';

  return gulp.src(PATHS.src.archive)
    .pipe(zip(title))
    .pipe(gulp.dest(PATHS.dest.archive));
}


// Clean out all files and folders from build folder (but don't delete dist/ folder)
function clean(){
  return del(PATHS.dest.clean);
};



// ---------------------------------------
//   Browser-Sync
// ---------------------------------------
// Init browserSync server
function startBrowser(done){
  browser.init(CONF.browserSync);
  done();
};

// Reload browser after files changes (all files except scss)
function reload(done) {
  browser.reload();
  done();
};



// Watch files changes
function watchFiles(){
  gulp.watch(PATHS.src.css, styles);
  gulp.watch(PATHS.src.js, gulp.series(javascript, reload));  
  gulp.watch(PATHS.src.images, gulp.series(images, reload));
  gulp.watch(PATHS.src.svg, gulp.series(svg, reload));
  gulp.watch(PATHS.src.copy, gulp.series(copy, reload));
  gulp.watch(PATHS.src.pages, gulp.series(reload));
};



// ---------------------------------------
//   Error handlers
// ---------------------------------------

function onPlumberError(err){
  console.log(colors.white.bgRed('\n💀💀💀 onPlumberError \n'));
  // console.log(colors.yellow(err.toString()));
  notify.onError({
    title  : "💀 Error in [<%= error.plugin %>]",
    message: err.message,
    sound  : "Pop",
  })(err);
  this.emit('end');
  console.log(colors.white.bgRed('\n💀💀💀 end onPlumberError \n'));
};




// ---------------------------------------
//  Tasks list
// ---------------------------------------
exports.styles     = styles;
exports.javascript = javascript;
exports.images     = images;
exports.svg        = svg;
exports.copy       = copy;
exports.clean      = clean;
exports.archive    = archive;
exports.build      = gulp.series(clean, gulp.parallel(styles, javascript, images, copy, svg));
exports.dev        = gulp.series(exports.build, startBrowser, watchFiles);
exports.default    = exports.dev;


// ∆∆∆∆∆∆∆ unused - only for dev ∆∆∆∆∆∆∆
// exports.watchFiles = watchFiles;
// exports.justscript = gulp.series(cleanScript, javascript);

// function cleanScript(){
//   return del(PATHS.dest.js + '**/*');
// };



// ---------------------------------------
//  Notes
// ---------------------------------------
// *** gulp-cached : 
// check if file in src has a newer timestamp than file in dest
// and check if the content has changed


// *** gulp-newer : 
// check if file in src has a newer timestamp than file in dest
// don't check if the content has changed or not
// can be used in multiple gulp runs, not just watcher (like gulp-cached)