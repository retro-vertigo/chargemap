// Allow only certain block in core/embed blocks
wp.domReady(function () {
  const allowedEmbedBlocks = [
    'youtube',
    'vimeo',
  ];
  wp.blocks.getBlockVariations('core/embed').forEach(function (blockVariation) {
    if (-1 === allowedEmbedBlocks.indexOf(blockVariation.name)) {
      wp.blocks.unregisterBlockVariation('core/embed', blockVariation.name);
    }
  });
});