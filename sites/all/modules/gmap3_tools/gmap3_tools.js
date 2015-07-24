(function ($) {

// Stores current opened infoWindow.
var currentInfoWindow = null;

/**
 * Create google map.
 *
 * @param object map
 *   Object of map options.
 * @return object
 *   On success returns gmap object.
 */
function gmap3ToolsCreateMap(map) {
  if (map.mapId === null) {
    alert(Drupal.t('gmap3_tools error: Map id element is not defined.'));
    return null;
  }

  // Create map.
  var mapOptions = map.mapOptions;
  mapOptions.center = new google.maps.LatLng(mapOptions.centerX, mapOptions.centerY);
  var gmap = new google.maps.Map(document.getElementById(map.mapId), mapOptions);
  
  // Store gmap in map element so it can be accessed later from js if needed.
$('#' + map.mapId).data('gmap', gmap);
$('#' + map.mapId).data('mapOptions', mapOptions);

  // Try HTML5 geolocation.
  if (map.gmap3ToolsOptions.geolocation && navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
      gmap.setCenter(pos);
      gmap3ToolsCreateMarkers(map, gmap);
    }, function() {
      // Geolocation service failed.
      gmap3ToolsCreateMarkers(map, gmap);
    });
  }
  else {
    // Do not use geolocation or browser do not support geolocation.
    gmap3ToolsCreateMarkers(map, gmap);
  }

  if($.type(map.legend) !== "undefined"){
      /*
       * legend control
       * https://developers.google.com/maps/documentation/javascript/controls#CustomControls
       */
      var oLegend = $('<div id="markers-legend"></div>');
      oLegend.append('<h3>'+map.legend.header+'</h3>'+
                      '<div class="outer">'+
                        '<div class="inner">'+
                          '<a class="check filter-elm withgreen" href="javascript:void(0)" data-gmap-marker-group="all_groups">All</a>'+
                        '</div>'+
                      '</div>');
      var oInnerLegend = oLegend.find('.inner');
      for(var i in map.legend.content){
        oInnerLegend.append('<a class="check filter-elm" href="javascript:void(0);" data-gmap-marker-group="'+map.legend.content[i].text+'">'+
                                '<img height="28" src="'+map.legend.content[i].iconUrl+'"/>&nbsp;' +
                                map.legend.content[i].text.substr(0, 30) + '...' +
                            '</a>');
      }
      oLegend = oLegend[0]; //add to gmap controls HTML reference NOT jQuery one
      oLegend.index = 1;
      gmap.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(oLegend);

      //click event on legend elements
      $('#'+map.mapId).on("click", '#markers-legend [data-gmap-marker-group]', {
        mapId : map.mapId,
        allValue : 'all_groups'
      }, gmap3ToolsFilterMarkers);
  }

  return gmap;
}


/**
 * set map bounds to fit markers
 * 
 * @param {type} sMapId
 */
function gmap3ToolsFit2Markers(sMapId){
    var oGmap = $('#' + sMapId).data('gmap'),
        oGmapOptions = $('#' + sMapId).data('mapOptions'),
        aMarkers = $('#' + sMapId).data('gmapMarkers'),
        oLatLngBounds = new google.maps.LatLngBounds();
    
    aMarkers.forEach(function(marker){
        //TODO extend latlng bounds for visble markers, marker.getVisible()
        oLatLngBounds.extend(marker.getPosition());
    });
    oGmap.setCenter(oLatLngBounds.getCenter());
    oGmap.fitBounds(oLatLngBounds);
}
    
/**
 * Description 
 * @param {type} event 
 * event refernce object 
 */
function gmap3ToolsFilterMarkers(event){
  var sAllValue = event.data.allValue || '',
      sMapId = event.data.mapId || '',
      sGroup = $(this).attr('data-gmap-marker-group') || '',
      aMarkers = $('#' + sMapId).data('gmapMarkers'),
      oMarkerClusterer = $('#' + sMapId).data('gmapMarkerClusterer');
    
    /*
     * set checked indicator
     */
    $('#markers-legend [data-gmap-marker-group]').removeClass('withgreen');
    $(this).addClass('withgreen');
    
  $.each(aMarkers, function(i, marker) {
      if(marker.group !== sGroup && sGroup != sAllValue)
        marker.setVisible(false);
      else
        marker.setVisible(true);
  });
//http://stackoverflow.com/a/9061734
    oMarkerClusterer.setIgnoreHidden(true);
    oMarkerClusterer.repaint();
    
    (sGroup === sAllValue) && gmap3ToolsFit2Markers(sMapId);
}
/**
 * Create markers.
 *
 * @param {object} map
 *   gmap3 tools object.
 * @param {Map} gmap
 *   Google Map object.
 */
function gmap3ToolsCreateMarkers(map, gmap) {
  // Array for storing all markers that are on this map.
  var gmapMarkers = [];

  // Create markers for this map.
  var markersNum = 0;
  $.each(map.markers, function (i, markerData) {

    var markerLat = markerData.lat;
    var markerLng = markerData.lng;

    // Is marker relative from map center?
    if (markerData.markerOptions.relative) {
      var pos = gmap.getCenter();
      markerLat = pos.lat() + markerLat;
      markerLng = pos.lng() + markerLng;
    }

    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(markerLat, markerLng),
      map: gmap
    });

    // Marker options.
    var markerOptions = $.extend({}, map.markerOptions, markerData.markerOptions);
    marker.setOptions(markerOptions);

    // Title of marker.
    if (typeof markerData.title !== 'undefined') {
      marker.setTitle(markerData.title);
    }

    // If marker has content then create info window for it.
    if (typeof markerData.content !== 'undefined') {
      google.maps.event.addListener(marker, 'click', function(e) {
        if (map.gmap3ToolsOptions.closeCurrentInfoWindow &&  currentInfoWindow != null) {
          currentInfoWindow.close();
        }
        var infoWindowOptions = map.infoWindowOptions;
        infoWindowOptions.position = marker.getPosition();
        infoWindowOptions.content = markerData.content;
        infoWindowOptions.map = gmap;
        currentInfoWindow = new google.maps.InfoWindow(infoWindowOptions);
      });
    }

    // Draggable markers with lat and lng form items support.
    if (markerOptions.draggable && (markerOptions.dragLatElement || markerOptions.dragLngElement)) {
      var $latItem = $(markerOptions.dragLatElement);
      var $lngItem = $(markerOptions.dragLngElement);
      google.maps.event.addListener(marker, 'drag', function() {
        $latItem.val(marker.getPosition().lat());
        $lngItem.val(marker.getPosition().lng());
      });
    }

    ++markersNum;
    gmapMarkers.push(marker);
  });

  if (markersNum) {
    // If we are centering markers on map we should move map center near makers.
    // We are doing this so first map center (on first display) will be near
    // map center when all markers are displayed - we will avoid map move
    // when map displays markers.
    // @todo - this can be more smarter - first get exact center from markers
    // and then apply it.
    if (map.gmap3ToolsOptions.defaultMarkersPosition !== 'default') {
      map.mapOptions.center = new google.maps.LatLng(map.markers[0].lat, map.markers[0].lng);
    }

    // Default markers position on map.
    if (map.gmap3ToolsOptions.defaultMarkersPosition === 'center') {
      gmap3ToolsCenterMarkers(gmap, map.markers, markersNum);
    }
    else if (map.gmap3ToolsOptions.defaultMarkersPosition === 'center zoom') {
      var bounds = new google.maps.LatLngBounds();
      for (var i = 0; i < markersNum; i++) {
        var marker = map.markers[i];
        bounds.extend(new google.maps.LatLng(marker.lat, marker.lng));
      }
      gmap.fitBounds(bounds);
    }
  }

  // Store markers in map element so it can be accessed later from js if needed.
  $('#' + map.mapId).data('gmapMarkers', gmapMarkers);
  
/*
 * markers grouping with clusters, 
 * http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html
 */ 
  var gmapMarkerClusterer = new MarkerClusterer(gmap, gmapMarkers,{
      gridSize: 50,             //The grid size of a cluster in pixels.
      //minimumClusterSize: 4,    //The minimum number of markers to be in a cluster before the markers are hidden and a count is shown.
      maxZoom: 10,                //The maximum zoom level that a marker can be part of a cluster
      calculator : function(aMarkers, iIconStyles){
          return {
            index:1,
            text:aMarkers.length
          };
      }
  });
  //store clusterer object in map element
  $('#' + map.mapId).data('gmapMarkerClusterer', gmapMarkerClusterer);
}

/**
 * Center markers on map.
 */
function gmap3ToolsCenterMarkers(map, markers, markersNum) {
  var centerLat = 0;
  var centerLng = 0;
  $.each(markers, function (i, markerData) {
    centerLat += parseFloat(markerData.lat);
    centerLng += parseFloat(markerData.lng);
  });
  centerLat /= markersNum;
  centerLng /= markersNum;
  map.setCenter(new google.maps.LatLng(centerLat, centerLng));
}

/**
 * Attach gmap3_tools maps.
 */
Drupal.behaviors.gmap3_tools = {
  attach: function (context, settings) {
    // Create all defined google maps.
    if (Drupal.settings.gmap3_tools === undefined) {
      return;
    }
    $.each(Drupal.settings.gmap3_tools.maps, function(i, map) {
      // @todo - we should really use css selector here and not only element id.
      var $mapElement = $('#' + map.mapId, context);
      if ($mapElement.length === 0 || $mapElement.hasClass('gmap3-tools-processed')) {
        return;
      }
      $mapElement.addClass('gmap3-tools-processed');
      //var gmap, oGeocoder = new google.maps.Geocoder();
        oGeocoder = new google.maps.Geocoder();
        if($.type(map.geocodeAddress) === "string"){
            oGeocoder.geocode({address:map.geocodeAddress}, function(results, status) {
              if(status == google.maps.GeocoderStatus.OK){
                  console.log("result:"+results[0].geometry.location+" for address:"+map.geocodeAddress);
                  map.markers[0].lat = results[0].geometry.location.k;
                  map.markers[0].lng = results[0].geometry.location.D;
                  /*new google.maps.Marker({
                      map:new google.maps.Map(document.getElementById("organization-gmap-canvas"), {zoom: 10,center:results[0].geometry.location}),
                      position:results[0].geometry.location
                  });*/
                  gmap = gmap3ToolsCreateMap(map);
              }else{
                console.log("Geocode was not successful for the following reason: " + status);
              }
            });
        }
        else if($.type(map.geocodeAddress) === "array"){
          //var iGeocodeResultCnt = -1;
          var oData = {
              addressesLen : map.geocodeAddress.length,
              geocodeResultCnt : -1
          };
          console.log("geocode addresses:"+oData.addressesLen);
          for(var i=0; i<oData.addressesLen; i++){
            (function(iIdx) {
            /*
             * self-invoking function to force evaluation of i through function call,
             * http://stackoverflow.com/a/6979149
             */
                if($.type(map.geocodeAddress[iIdx]) === "string" && map.geocodeAddress[iIdx] !== ""){
                    console.log("invoke geocode API for address:"+map.geocodeAddress[iIdx]);
                    //invokeGeoCodeAPI(map.geocodeAddress[iIdx], iIdx, map, oData);
                    setTimeout(function(){
                        invokeGeoCodeAPI(map.geocodeAddress[iIdx], iIdx, map, oData);
                    }, iDelayBetweenCalls*iIdx);
                }
            })(i);
          }          
        }
        else{
          gmap = gmap3ToolsCreateMap(map);
        }
      
    });
  }
};
    var gmap, oGeocoder, sOverQueryLimit = "OVER_QUERY_LIMIT", iDelayBetweenCalls = 100, iDelayAfterOverQueryLimit = 1000;
    function invokeGeoCodeAPI(sAddress, iIdx, map, oData){
        oGeocoder.geocode({address:sAddress}, function(results, status) {
            if(status == sOverQueryLimit){
                console.log("Geocode for address:"+sAddress+" was not successful due to "+sOverQueryLimit+" reached. Invoke after "+iDelayAfterOverQueryLimit+" ms.");
                setTimeout(function(){
                    invokeGeoCodeAPI(sAddress, iIdx, map, oData);
                }, iDelayAfterOverQueryLimit);
                return;
            }
            oData.geocodeResultCnt++;
            if(status == google.maps.GeocoderStatus.OK){
                console.log("result:"+results[0].geometry.location+" for address: "+sAddress);
                map.markers[iIdx].lat = results[0].geometry.location.k;
                map.markers[iIdx].lng = results[0].geometry.location.D;
            }else{
              console.log("Geocode for address:"+sAddress+" was not successful for the following reason: " + status);
            }
            if(oData.geocodeResultCnt === (oData.addressesLen-1)){
              gmap = gmap3ToolsCreateMap(map);
            }
        });
    }

})(jQuery);
