'use strict';

angular.module("scheduleForm", []).controller('schedule-form',['$scope',  function($scope){

    $scope.init = function (config){
        $scope.config = config;
    }

}]).directive('scheduleFormView',['service', '$timeout', function factory( service , $timeout){
    return {
        restrict: 'AE',
        replace: true,
        link: function ($scope, element, attrs) {

            $scope.schedule = null;

            if(!$scope.schedule){
                initialize();
            }

            function initialize() {
                $scope.price = '';
                service.update('',$scope.config.getData).then(function(response){
                    $scope.schedule = response.data;
                })
            }

            /**** toggle class selected to item ****/
            $scope.toggleSelected = function( hour, day )  {
                $scope.schedule.items[hour+day]['selected'] = (!$scope.schedule.items[hour+day]['selected']) ? 1 : 0;
            };

            $scope.toggleClass = function( hour, day) {
               return (!$scope.schedule.items[hour+day]['selected']) ?'':'selected';
            };


            /**** toggle class selected to column ****/
            $scope.toggleColumnSelected = function( day ){
                $scope.schedule.days[day]['selected'] = (!$scope.schedule.days[day]['selected']) ? 1 : 0;
                setToggleItemsByDay(day, $scope.schedule.days[day]['selected']);
            };

            $scope.toggleColumnClass = function( day) {
                return (!$scope.schedule.days[day]['selected']) ? '' :'selected';
            };


            /*** toggle selected column item by day ***/
            function setToggleItemsByDay(day, selected){
                angular.forEach($scope.schedule.items, function(item){
                    if(item['day_id'] == day){
                        item['selected'] = selected;
                    }
                })
            }


            /**** toggle class selected to row ****/
            $scope.toggleRowSelected =  function( hour ){
                $scope.schedule.times[hour]['selected'] = (!$scope.schedule.times[hour]['selected']) ? 1 : 0;
                 setToggleItemsByTime( hour, $scope.schedule.times[hour]['selected'] );
            };

            $scope.toggleRowClass = function( hour ) {
                return (!$scope.schedule.times[hour]['selected']) ? '' :'selected';
            };


            /*** toggle selected column item by day ***/
            function setToggleItemsByTime(hour, selected){
                angular.forEach($scope.schedule.items, function(item){
                    if(item['time_id'] == hour){
                        item['selected'] = selected;
                    }
                })
            }


            /*** set value price by items ***/
            $scope.setItem = function( hour, day) {
                if($scope.schedule.items[hour+day]['price'] !== '0'){
                    return $scope.schedule.items[hour+day]['price'];
                }
            };

            $scope.updateSchedule = function(price)
            {
                var data = [];
                $scope.loaderShow = true;
                angular.forEach($scope.schedule.items, function(item){
                    if(item['selected']){
                        item['price'] = price;
                        data.push(item)
                    }
                });

                service.update( data ,$scope.config.setData).then(function(response){

                    $scope.loaderShow = false;
                    if(response.data.response == 'success'){

                        var defaultButton = $scope.config.buttonSave;
                        $scope.config.buttonSave = response.data.message;
                        initialize();
                        $timeout( function(){
                            $scope.config.buttonSave = defaultButton;
                        }, 1000 );
                        console.log(response.data.response + ' : ' + response.data.message);
                    }else{
                        console.log(response.data.response + ' : ' + response.data.message);
                    }
                })
            }
        }
    }
}]).factory('service', ['$http', function($http){
    var service = {};
    service.update = function(data, url){
        var result = $http.post(url, {'data':data})
            .success(function(data) {
                return data;
            });
        return result;
    }
    return service;
}]);
new AppFactory("schedule-form", "scheduleFormFactory", ["scheduleForm"]);