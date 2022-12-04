import SliderReplay from "../blocks/SliderReplay";

(function(){
  
  /**
   * initializeBlock
   *
   * Adds custom JavaScript to the block HTML.
   *
   * @param   object $block The block jQuery element.
   * @param   object attributes The block attributes (only available when editing).
   */

  const initializeBlock = function( $block ) {
    const blockPreview = $block[0];           //    acf container : <div class="acf-block-preview"></div>
    new SliderReplay(blockPreview.querySelector('[class*=block]'));
  }


  //        Init blocks in admin editor
  // ==============================================
  
  // Initialize dynamic block preview (editor).
  if( window.acf ) {
      window.acf.addAction( 'render_block_preview/type=webinar-replay', initializeBlock );
  }

})();