'use strict';

angular.module("sectionSchedule", []).controller('section-schedule',['$scope',  function($scope){
    $scope.init = function (init){
        $scope.config = init;

        $scope.errorList = init.errorList;
    }
}]).directive('sectionScheduleView',[ 'service','dateTime',function factory(service, dateTime){
    return {
        restrict: 'AE',
        replace: true,
        link: function ($scope, element, attrs) {
            $scope.schedule = [];
            /*** start render schedule ***/
            renderSchedule();

            function renderSchedule( step, date ) {
                var data = { step:step, date: date};
                service.update( data , $scope.config.getSchedule).then(function(response){
                    $scope.schedule = response.data;
                    $scope.hidePrevButton = dateTime.togglePreviewButton($scope.schedule.startWeek);
                });
            }
            $scope.checkAvailableItemByCurrentTime = function(item){
                var enabled = true;
                /*** доступность по текущему времени загрузки страницы  ***/
                if(!dateTime.checkInterval(item.timestamp,item.margin_of_time))
                    enabled = enabled && false;
                return enabled;
            };

            $scope.reservation = function(url, item){

                if($scope.checkAvailableItemByCurrentTime(item)){
                    location.href = url+'?id='+item.entity_id+'&date='+item.timestamp;
                }else{
                    $scope.modalFadeIn = true;
                    $scope.error = $scope.errorList[1];
                    renderSchedule();
                }
            };

            /** обновить таблицу при смене недели **/
            $scope.updateSchedule = function(step, date){
                renderSchedule( step, date );
            };
        }
    }
}]).factory('dateTime',['$filter',function($filter){
    var dt = {};
    dt.result = false;

    dt.checkInterval = function(timestamp, margin_of_time) {
        var currentDtime = new Date().getTime();
        var marginTime = currentDtime + (60*60*1000*margin_of_time);

        return (marginTime > (timestamp * 1000)) ? false : true;
    };

    dt.togglePreviewButton = function(startWeek)
    {
        var currentDtime = new Date().getTime();
        var currentDate = $filter('date')(currentDtime, 'yyyyMMdd');
        var startWeek = $filter('date')(startWeek * 1000, 'yyyyMMdd');
        return ( startWeek > currentDate ) ? false : true;
    };

    dt.findNeighborTimestamp = function(timestamp, step){
        var t = step * 60 * 60;
        return timestamp + t
    };

    return dt;
}]).factory('service', ['$http', function($http){
    var service = {};
    service.update = function(data, url){
        var result = $http.post(url, {'data':data})
            .success(function(data) {
                return data;
            }).error(function(response) {
                // Never gets called & dies with error described below.
                console.log(response);
            });
        return result;
    };
    return service;
}]).filter('orderByStack', function() {
    return function(items, field, reverse) {

        var filtered = [];
        if(typeof items !== typeof undefined) {
             angular.forEach(items, function (item) {
                 filtered.push(item);
             });
        }
        filtered.sort(function (a, b)
        {

             if(typeof a !== typeof undefined && typeof b !== typeof undefined){
                 return (parseInt(a.timestamp) > parseInt(b.timestamp) ? 1 : -1);
             }

        });
        if(reverse) filtered.reverse();
        return filtered;
    }
});

new AppFactory("section-schedule", "sectionScheduleFactory", ["sectionSchedule"]);