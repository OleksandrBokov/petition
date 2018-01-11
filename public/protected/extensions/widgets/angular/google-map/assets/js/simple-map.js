'use strict';

angular.module("simpleMap", []).controller('simple-map',['$scope',  function($scope){
    $scope.init = function (config) {
        $scope.config = config;
        $scope.buttonSave = config.buttonSave;
        $scope.loaderShow = false;
        $scope.checked = false;
    }

}]).directive('googleMap',['service','$timeout', function factory( service , $timeout ){

    return {
        restrict: 'AE',

        link: function ($scope, element, attrs) {

            var geocoder = new google.maps.Geocoder();
            var infoBox = new google.maps.InfoWindow({
                maxWidth: 350
            });
            $scope.map = null;

            var initMap = $scope.config.init.map;
            $scope.markers = [];

            var marker;

            if ($scope.map === null) {
                initialize();
            }

            $scope.reload = function(){
                initialize();
            };

            function initialize() {

                var defaults = {
                    center: new google.maps.LatLng(initMap.lat, initMap.lng),
                    zoom:  initMap.zoom,
                    panControl: true,
                    zoomControl: true,
                    scaleControl: true,

                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                $scope.map = new google.maps.Map(element[0], defaults);

                if($scope.config.init.marker.lat !== '' && $scope.config.init.marker.lng !== ''){
                    var latlng = new google.maps.LatLng($scope.config.init.marker.lat, $scope.config.init.marker.lng);
                    putMarker(latlng);
                }

            }

            $scope.findAddress = function(){
                var address = document.getElementById("find-to-map").value;
                if(typeof address !== typeof undefined && address != ''){
                    $scope.extractAddress(address)
                }
            }

            $scope.extractAddress = function(address){
                geocoder.geocode({'address': address },
                    function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK && results.length > 0) {

                            var extract = extractAddress(results);
                            var latlng = new google.maps.LatLng(extract.lat, extract.lng);

                            $scope.clearMarker();
                            putMarker(latlng);
                        }
                    });
            }

            google.maps.event.addListener($scope.map, 'click', function(event) {

                var obj = [];
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();

                geocoder.geocode( {'latLng': new google.maps.LatLng(lat, lng)},
                    function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK && results.length > 0) {

                            obj[0] = results[0];
                            var extract = extractAddress(obj);

                            var latlng = new google.maps.LatLng(extract.lat, extract.lng);

                            $scope.clearMarker();
                            putMarker(latlng);
                        }
                    });
            })

            $scope.clearMarker = function(){
                while($scope.markers.length){
                    $scope.markers.pop().setMap(null);
                }
            }

            function putMarker(latlng) {
                marker = new google.maps.Marker({
                    map : $scope.map,
                    position : latlng,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    zoom: initMap.zoom
                });


                /*** create marker ***/
                $scope.markers.push( marker );
                setMarkerOnClickEvent(marker);



                /** set marker to center map **/
                var bounds = new google.maps.LatLngBounds( latlng );
                $scope.map.setCenter(bounds.getCenter());
                $scope.map.setZoom(16);

                if($scope.config.showInfoBox){
                /** create info **/
                    infoBox.close( $scope.map );
                    infoBox.setContent( getContent( $scope.config.init.marker ) );

                    $timeout( function(){
                        infoBox.open( $scope.map, marker);
                    }, 1000 );
                }
            }



            google.maps.event.addListener(infoBox, 'domready', function() {

                if($scope.config.showInfoBox){

                    var iwOuter = $('.gm-style-iw');

                    /* Since this div is in a position prior to .gm-div style-iw.
                     * We use jQuery and create a iwBackground variable,
                     * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
                     */
                    var iwBackground = iwOuter.prev();

                    // Removes background shadow DIV
                    iwBackground.children(':nth-child(2)').css({'display' : 'none'});

                    // Removes white background DIV
                    iwBackground.children(':nth-child(4)').css({'display' : 'none'});

                    // Moves the infowindow 115px to the right.
                    iwOuter.parent().parent().css({left: '115px'});

                    // Moves the shadow of the arrow 76px to the left margin.
                    iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px !important;'});

                    // Moves the arrow 76px to the left margin.
                    iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px !important;'});

                    // Changes the desired tail shadow color.
                    // iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});

                    // Reference to the div that groups the close button elements.
                    var iwCloseBtn = iwOuter.next();


                    // Apply the desired effect to the close button
                    iwCloseBtn.css({opacity: '1',
                        right: '42px',
                        top: '6px',
                        width: '20px',
                        height: '20px',
                        // border: '13px solid #fff',
                        'border-radius': '10px',
                        // 'box-shadow': '0 0 5px #3990B9'
                    });
                    iwCloseBtn.append($('<i class="iw-close fa fa-close">  </i>'));
                    //border: '7px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'

                    // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
                    if($('.iw-content').height() < 140){
                        $('.iw-bottom-gradient').css({display: 'none'});
                    }

                    // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
                    iwCloseBtn.mouseout(function(){
                        $(this).css({opacity: '1'});
                    });
                }
            })

            $scope.saveMarker = ('click',function(){

                if(typeof marker !== typeof undefined){

                    $scope.checked = true;
                    $scope.loaderShow = true;

                    var data = {
                        'id'  : $scope.config.id,
                        'lat' : marker.getPosition().lat(),
                        'lng' : marker.getPosition().lng()
                    };

                    service.update(data ,$scope.config.updateUrl).then(function(response){
                        $scope.loaderShow = false;
                        if(response.data.response == 'success'){

                            var defaultButton = $scope.buttonSave;
                            $scope.buttonSave = response.data.message;

                            $timeout( function(){
                                $scope.buttonSave = defaultButton;
                                $scope.checked = false;
                            }, 3000 );
                            console.log(response.data.response + ' : ' + response.data.message);
                        }else{
                            console.log(response.data.response + ' : ' + response.data.message);
                        }
                    })

                }else{
                    console.log('click');
                }
            });

            function setMarkerOnClickEvent(marker) {

                if($scope.config.infoBox){
                    google.maps.event.addListener(marker, 'click', function(event) {
                        infoBox.open( $scope.map, marker);
                    })
                }
            }

            function getContent(marker) {

                var content = '';
                if($scope.config.showInfoBox){
                    //console.log(marker);
                    /*  var content = '<div class="info-box-wrap">' +
                     '<img src="'+marker.src+'" />' +
                     '<div class="info-box-text-wrap">' +
                     '<h4>'  + marker.title + '</h4>' +
                     '<h6><i class="fa fa-map-marker"></i>'  + marker.address + '</h6>' +
                     '</div>' +
                     '</div>';*/

                    content = '<div id="iw-container">' +
                        '<div class="iw-content">' +
                        '<img src="'+ marker.src +'"  height="115" width="83">' +
                        '<div class="iw-subTitle">' + marker.title +'</div>' +
                        '<h6><i class="fa fa-map-marker"></i>'  + marker.address + '</h6>' +
                        // '<div class="iw-subTitle">Contacts</div>' +
                        // '<p>VISTA ALEGRE ATLANTIS, SA<br>3830-292 Ílhavo - Portugal<br>'+
                        // '<br>Phone. +351 234 320 600<br>e-mail: geral@vaa.pt<br>www: www.myvistaalegre.com</p>'+
                        // '</div>' +
                        '<div class="iw-bottom-gradient"></div>' +
                        '</div>';
                }


                return content;
            }

            function extractAddress(addresses) {

                var address, component, result, _i, _j, _len, _len1, _ref;
                result = {};
                for (_i = 0, _len = addresses.length; _i < _len; _i++) {
                    address = addresses[_i];
                    result.fullAddress || (result.fullAddress = address.formatted_address);
                    result.coord || (result.coord = [address.geometry.location.ob, address.geometry.location.pb]);
                    _ref = address.address_components;
                    for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
                        component = _ref[_j];

                        result.lat = address.geometry.location.lat();
                        result.lng = address.geometry.location.lng();
                        result.short_name = component.short_name;


                        if (component.types[0] === "street_number") {
                            result.street_number || (result.street_number = component.long_name);
                        }

                        if (component.types[0] === "route") {
                            result.street || (result.street = component.long_name);
                        }
                        if (component.types[0] === "locality") {
                            result.city || (result.city = component.long_name);
                        }
                        if (component.types[0] === "postal_code") {
                            result.zip || (result.zip = component.long_name);
                        }
                        if (component.types[0] === "country") {
                            result.country || (result.country = component.long_name);
                        }
                        if(component.types[0] = 'administrative_area_level_3'){
                            result.administrative3 || (result.administrative3 = component.long_name);
                        }
                        if(component.types[0] = 'administrative_area_level_1'){
                            result.administrative1 || (result.administrative1 = component.long_name);
                        }
                    }
                }
                return result;
            };

        }
    }
}]).directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            if(event.which === 13) {
                scope.$apply(function(){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
}).factory('service', ['$http', function($http){
    var service = {};
    service.update = function(data, url){
        var result = $http.post(url, {'data':data})
            .success(function(data) {
                return data;
            })
        return result;
    }
    return service;
}]);

new AppFactory("simple-map", "simpleMapFactory", ["simpleMap"]);