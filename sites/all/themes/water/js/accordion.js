jQuery(document).ready(function() {
        var expCollapse;
        expCollapse = jQuery('<p><a id="expand" href="#">Expand All</a>/<a id="collapse" href="#">Collapse all</a><a class="print-toc" href="/printpdf/booktree" target="_blank">pdf</a><a class="print-toc" href="/print/booktree" target="_blank">print TOC</a></p>');
        
        var bookContainer = jQuery('#block-system-main > div > ul.booktree');
        bookContainer.before(expCollapse);
	/*add parent class for styling*/
        /*var els = jQuery('ul.booktree li.booktree');
        els.each(function(){
            if(jQuery(this).next().hasClass('container'))
                jQuery(this).addClass('parent');
        });*/
    jQuery('ul.booktree > li.booktree').click(function(e) {
  	e.preventDefault();
    var $this = jQuery(this);
    if ($this.next('li.container').hasClass('show')) {
        $this.removeClass('active');
        $this.next('li.container').removeClass('show');
        $this.next('li.container').slideUp(350);
    } else {
        /*
        //do not close already open
        $this.parent().find('li.container').removeClass('show');
        $this.parent().find('li.container').slideUp(350);
        */
       if ($this.next().hasClass('container')) {
        $this.addClass('active');
        }
        $this.next('li.container').toggleClass('show');
        $this.next('li.container').slideToggle(350);
    }
	});
	jQuery('ul.booktree > li.booktree a').click(function(e) {
            var $next = jQuery(this).parent().next();
            if(!$next.hasClass('container'))
                e.stopPropagation();
	});
        jQuery('#expand').click(function(e) {
            bookContainer.find('li.container').slideDown();
            jQuery('ul.booktree li.booktree.parent').addClass('active');
            jQuery('ul.booktree li.container').addClass('show');
	});
        jQuery('#collapse').click(function(e) {
            bookContainer.find('li.container').slideUp();
            jQuery('ul.booktree li.booktree.parent').removeClass('active');
            jQuery('ul.booktree li.container').removeClass('show');
	});
});