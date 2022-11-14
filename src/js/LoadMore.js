import SmoothScroll from "./utils/SmoothScroll";

export default class LoadMore {

    constructor() {
        this.containerPosts = document.getElementById('js-container-posts');
        this.btnLoadMore    = document.getElementById('js-btn-loadmore');
        this.menuFilters    = document.getElementById('js-menu-filters');
        this.btnsFilter     = document.querySelectorAll('.js-btn-filter');

        // get query params from PHP page
        this.paged        = this.containerPosts.dataset.paged;         // useless ??
        this.pagesMax     = this.containerPosts.dataset.pagesMax;
        this.postsPerPage = this.containerPosts.dataset.postsPerPage;
        this.termId       = this.containerPosts.dataset.termId;
        this.postType     = this.containerPosts.dataset.postType;      // 'post' or 'project'
        this.taxonomy     = this.containerPosts.dataset.taxonomy;      // 'category' or 'cat_project'
        this.cardPartial  = this.containerPosts.dataset.cardPartial;   // 'card-news' or 'card-project'

        this.init();
    }

    init() {
        // console.log('init', this.paged, this.pagesMax);
        this.btnLoadMore.addEventListener('click', e => this.clickLoadMore(e) );

        this.btnsFilter.forEach(  el => {  
            el.addEventListener('click', e => this.clickFilter(e) );    
        });
    }

    // Update current page and get new posts
    clickLoadMore(e) {
        this.paged++;
        this.containerPosts.dataset.paged = this.paged;
        this.loadAjaxPosts();
    }

    // Select / deselect filter
    clickFilter(e) {
        const currentBtn = e.currentTarget;
        
        // deselect all items
        this.btnsFilter.forEach(  el => {   el.classList.remove('is-selected'); });

        // select filter
        currentBtn.classList.add('is-selected');    

        // update term id
        this.termId = currentBtn.dataset.termId;
        this.containerPosts.dataset.termId = this.termId;

        // reset paged
        this.paged = 1;

        // clean posts container
        while (this.containerPosts.hasChildNodes()) {
            this.containerPosts.removeChild(this.containerPosts.lastChild);
        }
        
        // load new posts
        this.loadAjaxPosts();
    }


    // load posts
    loadAjaxPosts() {
        // this.debug();

        const data = {
            'action'        : 'load_more_posts',
            'paged'         : this.paged,
            'posts_per_page': this.postsPerPage,
            'term_id'       : this.termId,
            'taxonomy'      : this.taxonomy,
            'post_type'     : this.postType,
            'card_partial'  : this.cardPartial,
            'security'      : loadmore_params.security
        };
        
        $.ajax({ 
            url : loadmore_params.ajaxurl,
            data: data,
            type: 'POST',
            // dataType: 'json',
            beforeSend: (xhr) => {
                this.btnLoadMore.removeAttribute('disabled');
                this.btnLoadMore.classList.add('is-loading');
                this.menuFilters.style.pointerEvents = 'none';
            }	
        })
        .done( (data) => {
            if(data) { 
                this.btnLoadMore.classList.remove('is-loading');
                this.btnLoadMore.blur();
                this.menuFilters.removeAttribute('style');

                
                // console.log('get data', data);
                if (typeof data === 'object') {
                    // console.log('#is object');          // dont JSON.parse if its object -> when dataType: 'json'
                } else if (typeof data === 'string') {
                    // console.log('#is string');          // JSON.parse if its string -> when no dataType
                    data = JSON.parse(data);
                }

                // data = JSON.parse(data);
                // console.log('get data', data);
                
                // update pages max
                this.pagesMax = data.pages_max;
                this.containerPosts.dataset.pagesMax = this.pagesMax;
                
                
                // render posts (join data.posts array)
                const content = data.posts.join('');
                this.containerPosts.insertAdjacentHTML('beforeend', content);

                // reveal animation
                this.revealPosts();
                // this.scrollToNewPosts();

                if (this.paged >= this.pagesMax) {
                    this.btnLoadMore.disabled = true; 	// if last page, hide button
                    // console.log('max page reached');
                }                 
            } else {
                this.menuFilters.removeAttribute('style');
                console.log('no datas');
            }
        })
        .fail(function(error) {
            this.menuFilters.removeAttribute('style');
        });
    }

    debug() {
        console.log('\n• paged / pagesMax', this.paged, "/",  this.pagesMax );
        console.log('• termId', this.termId );
        console.log('• postsPerPage', this.postsPerPage );
        console.log('• menuFilters', this.menuFilters );
    }

    //        Animations
    // ==============================================

	// animate new articles loaded
	revealPosts() {
        const items = document.querySelectorAll('.card-post.reveal-init:not(.reveal)');
        
		for (let i=0; i < items.length; i++) {
			// get function in closure, so i can iterate
			let addRevealClass = this.getAddRevealClass( items[i] );
			let delay = 100 + i * 100;
			setTimeout( addRevealClass, delay );
		}
	}

	// closure function to get article
	getAddRevealClass(el) {
		return function() {
            el.classList.add('reveal');
		}
	}

    // scroll to new articles loaded
	scrollToNewPosts() {
        const target = document.querySelector('.card-post.reveal-init:not(.reveal)');
        setTimeout( () => {
            SmoothScroll.scrollToTarget(target);
        }, 200 );
	}
}
