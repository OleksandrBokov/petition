'use strict';

angular.module("entityMap", []).controller('entity-map',['$scope',  function($scope){
    $scope.init = function (config) {
        $scope.config = config;
        $scope.entities = config.entities;
    }
}]).directive('googleMap',['$timeout',function factory($timeout ){
    return {
        restrict: 'AE',
        link: function ($scope, element, attrs) {

            var infoBox = new google.maps.InfoWindow();
            var markerCluster;
            var imageUrl = $scope.config.imagePath+'m1.png';

            $scope.map = null;
            if ($scope.map === null) {
                initialize();

            }
            if(typeof $scope.entities !== typeof undefined && $scope.entities.length == 1){
                showInfoWindow();
            }


            function initialize()
            {
                var initMap = $scope.config.init.map;

                var defaults = {
                    center: new google.maps.LatLng(initMap.lat, initMap.lng),
                    zoom:  initMap.zoom,
                    panControl: true,
                    zoomControl: true,
                    scaleControl: true,
                    styles: [{
                        featureType: 'poi',
                        stylers: [{ visibility: 'off' }]  // Turn off POI.
                    }],
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    maxZoom: 18
                };

                $scope.map = new google.maps.Map(element[0], defaults);

            }

            setMarkers();

            function setMarkers() {
                var markers = [];
                angular.forEach($scope.entities, function(place) {

                    var imageUrl = $scope.config.imagePath+'m1.png';
                    var markerImage = new google.maps.MarkerImage(imageUrl,
                        new google.maps.Size(52, 52), new google.maps.Point(0, 0), new google.maps.Point(26, 26));//,  new google.maps.Size(24, 32)

                    var latlng = new google.maps.LatLng(place.lat, place.lng);

                    var marker = new google.maps.Marker({
                        position: latlng,
                        icon: markerImage,
                        map: $scope.map,
                        pid: place.id
                    });

                    setMarkerOnClickEvent(marker);
                    markers.push(marker);
                });

                var clusterStyles = [{
                        textColor: 'white',
                        url: imageUrl,
                        height: 52,
                        width: 52
                    },
                    {
                        textColor: 'white',
                        url: imageUrl,
                        height: 52,
                        width: 52
                    },
                    {
                        textColor: 'white',
                        url:imageUrl,
                        height: 52,
                        width: 52
                    }];
                //var options = {imagePath: $scope.config.imagePath+'m',averageCenter: true};//, gridSize:14, zoomOnClick: false,  minimumClusterSize:1, gridSize:14, zoomOnClick: false,  minimumClusterSize:1
                var options = {styles:clusterStyles, zoomOnClick: false };
                markerCluster = new MarkerClusterer($scope.map, markers, options);
            }

            $scope.map.addListener('zoom_changed', function(){
                infoBox.close();
            });


            function showInfoWindow() {
                //console.log($scope.entities);

                var plase =  $scope.entities[0];
                var latlng = new google.maps.LatLng(plase.lat, plase.lng);
                $scope.map.zoom = 14;
                $scope.map.setCenter(latlng);
                infoBox.setContent('<ul class="e-list">'+ getContent(plase)+ '</ul>');
                infoBox.setPosition(latlng);
                infoBox.open($scope.map);
            }

            function setMarkerOnClickEvent(marker) {

                google.maps.event.addListener(marker, 'click', function(event) {
                    angular.forEach($scope.entities, function(place) {
                        if(place.id  == marker.pid){
                            $scope.map.setCenter(marker.getPosition());
                            var latlng = new google.maps.LatLng(place.lat, place.lng);
                            infoBox.setContent('<ul class="e-list">'+ getContent(place)+ '</ul>');
                            infoBox.setPosition(latlng);
                            infoBox.open($scope.map);
                        }
                    });
                })
            }


            google.maps.event.addListener(markerCluster, 'clusterclick', function(cluster) {
                    var markers = cluster.getMarkers();
                    var latlng;
                    var content = '<ul class="e-list overflow">';
                    for(var i = 0; i < markers.length; i++) {
                        angular.forEach($scope.entities, function(place) {
                            if(place.id  == markers[i].pid){
                                $scope.map.setCenter(markers[i].getPosition());
                                latlng = new google.maps.LatLng(place.lat, place.lng);
                                content += getContent(place);
                            }
                        });
                    }
                    content += '</ul>';
                    infoBox.setContent(content);
                    infoBox.setPosition(latlng);
                    infoBox.open($scope.map);

                    return false;
            });




            function getContent(place)
            {
                var comment = '';
                var price ='';
                var image = '';
                if(place.countComments) {
                    comment ='<div class="comments-block" style="padding-top: 1px;"> ' +
                        '<p class="comments  pull-right">' +
                        '<i class="fa fa-comment" style="margin-right: 5px"></i>'+place.countComments+
                        '</p>' +
                        '</div>';
                }

                if($scope.config.showPrice){
                    price = '<div class="e-min-price">'+place.min_price+'</div>';
                }

                if(place.photo){
                    image = '<img src="'+ place.photo +'" >';
                }

                return '<li  class="e-item">' +
                     image + price +
                    '<div class="e-desc" >' +
                        '<a href="'+place.link+'" style="">' +
                    '<div class="e-subTitle" >' + place.name +'</div>' +
                        '</a>' +
                    '<h5 ><i class="fa fa-map-marker" style="margin-right: 10px" ></i>'  + place.address + '</h5>' +
                    '</div>' +
                    '<div class="e-comment">' +
                    '<div class="rating-stars"><div style="width: '+place.rating+'%;"></div></div>' +
                        comment
                     + '</li>';
            }

        }
    }
}]);

new AppFactory("entity-map", "entityMapFactory", ["entityMap"]);