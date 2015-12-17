/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function() {
    jQuery('.toc-list > ul li a').click(function(e) {
    
    var $this = jQuery(this);
    
    if($this.next('ul').length) {
	e.preventDefault();
    }
    if ($this.next().hasClass('show')) {
        $this.removeClass('active');
        $this.next().removeClass('show');
        $this.next().slideUp(350);
    } else {
        /*
        //do not close already open
        $this.parent().find('li.container').removeClass('show');
        $this.parent().find('li.container').slideUp(350);
        */
//       if ($this.next().hasClass('container')) {
//        $this.addClass('active');
//        }
        $this.next().toggleClass('show');
        $this.next().slideToggle(350);
    }
    });
});