/* 
* Patched sites/all/modules/scroll_to_destination_anchors/scroll_to_destination_anchors.js 
* in order to work ok the accordion effect (see git)
*/
(function ($) {
Drupal.behaviors.chapterAccordion = {
  attach: function (context, settings) {
    $(document).ready(function(){
    $('.toc-list > ul li a', context).each(function(){
	if($(this).next('ul').length) {
	    $(this).addClass('inactive');
	    $(this).parent().addClass('parent');
	}
    });
    $('.toc-list > ul li a.inactive').on('click', function(e) {
    var $this = $(this);
	e.preventDefault();
    if ($this.next().hasClass('show')) {
        $this.removeClass('active');
	$this.parent().removeClass('active');
        $this.next().removeClass('show');
        $this.next().slideUp(350);
    } else {
	if ($(this).next('ul').length) {
        $this.parent().toggleClass('active');
        }
        $this.next().toggleClass('show');
        $this.next().slideToggle(350);
    }
    });
    $('#block-views-persons-view-tables-block h2').click(function() {
    
    var $this = $(this);
    if ($this.next().hasClass('show')) {
        $this.removeClass('active');
        $this.next().removeClass('show');
        $this.next().slideUp(400);
    } else {
        //do not close already open
        $this.parent().find('.table-wrapper.show').removeClass('show').slideUp(400);
	$this.parent().find('h2.active').removeClass('active');
	$this.toggleClass('active')
        $this.next().toggleClass('show');
        $this.next().slideToggle(400, function(){
	    $('html, body').animate({
	    scrollTop: $this.offset().top - 35
	    }, 900);
	});
    }
    });
    });
  }
}
})(jQuery);