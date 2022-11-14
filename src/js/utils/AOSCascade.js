
export default class AOSCascade {

    constructor(el) {
        this.el                = el;         // container group for cascade items  (data-aos-cascade-container)
        this.items             = el.querySelectorAll('[data-aos-cascade-breakpoints]'); 
        this.currentBreakpoint = 'xs';

        this.breakpoints = [ 
            { name: 'xs',   mq: '(min-width: 0) and (max-width: 575px)' },
            { name: 'sm',   mq: '(min-width: 576px) and (max-width: 767px)' },
            { name: 'md',   mq: '(min-width: 768px) and (max-width: 939px)' },
            { name: 'lg',   mq: '(min-width: 940px) and (max-width: 1199px)' },
            { name: 'xl',   mq: '(min-width: 1200px) and (max-width: 1599px)' },
            { name: 'xxl',  mq: '(min-width: 1600px)' }
        ];
        this.itemsList = [];
        this.init();
    }

    init () {

        // detect current media query
        for (let i=this.breakpoints.length-1; i >= 0; i--) {
            if (window.matchMedia(this.breakpoints[i]['mq']).matches) {
                this.currentBreakpoint = this.breakpoints[i]['name'];
            }
            window.matchMedia(this.breakpoints[i]['mq']).addListener(e => this.detectMqChange(e, this.breakpoints[i]['name']));
        }
        // console.log('media is', this.currentBreakpoint);

        this.initItemsList();
    }  


    detectMqChange(e, mqName) {
        if (e.matches) {
            // console.log('detectMqChange', mqName, e);
            this.currentBreakpoint = mqName;
            this.updateAosDelay();
        } 
    }

    // change aos delay on item when window resize 
    updateAosDelay() {
        this.itemsList.forEach(entry => {
            const el = entry['element'];
            const grid = entry['grids'];

            for (let i=0; i < grid.length; i++) {
                if (grid[i]['bp'] == this.currentBreakpoint) {
                    el.dataset.aosDelay = grid[i]['delay'];
                }
            }
        });
    }


    initItemsList() {
        let count = 0;
        this.items.forEach(el => {
            let obj = new Object();
            obj['element'] = el;

            let dataGrids = el.dataset.aosCascadeBreakpoints;   // 'xs-2 md-3 xl-4'
            let grids = dataGrids.split(' ');                   // ['xs-2', 'md-3', 'xl-4']

            obj['grids'] = [];
            let z = 0;
            // parse all global breakpoints and fill grid with bp found in item 
            for (let i=0; i < this.breakpoints.length; i++) {
                let objGrid = new Object();
                let name = this.breakpoints[i]['name'];     // xs
                let pair = grids[z].split("-");             // ['xs', 2]
                // console.log(i, name, "(z:", z ,")");

                if (pair[0] == name) {   // bp found in item
                    objGrid['bp'] = pair[0];                // 'xs', 'sm', 'md, 'lg'
                    objGrid['col'] = parseInt(pair[1]);     // 1, 2, 3, 4
                    
                    let baseDelay = parseInt(el.dataset.aosCascadeBaseDelay);      // calcul item delay with col numbers, item position in  grid and base delay
                    let coefDelay = count % objGrid['col'];
                    objGrid['delay'] = coefDelay * baseDelay;
                    
                    // console.log('  >> bp found', z);
                    if (z < grids.length-1) z++;
                } else {        // no bp found in item -> copy the last bp
                    let objCopy = obj['grids'].map(x => ({...x}));          // copy without reference
                    objGrid = objCopy[i-1];
                    objGrid['bp'] = name;           // identical obj except prefix
                    // console.log('  >> copy');
                }
                obj['grids'].push(objGrid);

                // if current bp set data-aos-delay on item
                if (objGrid['bp'] == this.currentBreakpoint) {
                    el.dataset.aosDelay = objGrid['delay'];
                }
            }


            this.itemsList.push(obj);
            count++;
        });

        // console.table(this.itemsList);
        // console.log(this.itemsList[0]);
    }
}