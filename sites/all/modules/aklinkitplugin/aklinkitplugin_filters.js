jQuery.expr[':'].contains = function(a,i,m) {
	      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
	  };
jQuery(document).ready(function() {
	jQuery('body').on( "focus", '#edit-linkit-search', function() {
		var $filters = '<a href="#" id="refine-filters-btn">Filter</a><div id="refine-filters" style="display:none;"><span><label>Name</label><input id="name" type="text" /></span><span><label>Year</label><input id="year" type="text" /></span></div>';
		if(jQuery(this).parent().find('#refine-filters').length == 0) {
		jQuery(this).next().before($filters);
		}
	});
	jQuery('body').on( "click", '#refine-filters-btn', function() {
		jQuery(this).next().toggle();
		return false;
	});
	jQuery('body').on( "focus", '#refine-filters input', function() {
		jQuery(this).closest('div#refine-filters').next().show();
	});
	jQuery('body').on( "keyup", '#refine-filters input', function() {
		filterResults(jQuery(this).closest('div#refine-filters').next());
	});
});

function filterResults(element) {
	var nameVal = jQuery('#refine-filters #name').val();
	var yearVal = jQuery('#refine-filters #year').val();
	if(nameVal || yearVal) {
		element.find('li').hide();
		if(nameVal)
		element.find("span.name:contains('"+nameVal+"')").closest('li').show();
		if(yearVal && !nameVal)
		element.find("span.year:contains('"+yearVal+"')").closest('li').show();
		if(yearVal && nameVal) {
		element.find("span.name:contains('"+nameVal+"')").closest('li').hide();
		element.find("span.name:contains('"+nameVal+"')").closest('li').find("span.year:contains('"+yearVal+"')").closest('li').show();
		}
	}
	if(!nameVal && !yearVal) {
		element.find('li').show();
	}
}