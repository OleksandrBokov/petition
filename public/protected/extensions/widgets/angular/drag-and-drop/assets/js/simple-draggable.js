'use strict';

angular.module("simpleDraggable", []).controller('simple-draggable',['$scope', function($scope){

    $scope.init = function (config){
        $scope.config = config;
        $scope.buttonSave = config.buttonSave;
        $scope.loaderShow = false;
        $scope.checked = false;

    }

}]).directive('draggableView',['service','$timeout',  function factory(service, $timeout ){
    return {
        restrict: 'AE',
        replace: true,
        templateUrl: 'simple-draggable.html',
        link: function ($scope, element, attrs) {

            var id = $scope.config.itemId;

            $scope.items = $scope.config.items;

            $scope.toUsed = function(idx)
            {
                angular.forEach($scope.items.available, function(available){
                    if(available[id] == idx)
                    {
                        var index = $scope.items.available.indexOf(available);
                        $scope.items.used = $scope.items.used.concat($scope.items.available.splice(index, 1));
                    }
                });
            }

            $scope.toAvailable = function(idx)
            {
                angular.forEach($scope.items.used, function(used){

                    if(used[id] == idx)
                    {
                        var index = $scope.items.used.indexOf(used);
                        $scope.items.available = $scope.items.available.concat($scope.items.used.splice(index, 1));
                    }
                });
            }

            $scope.saveChanges = ('click', function(){
                $scope.checked = true;
                $scope.loaderShow = true;
                service.update($scope.items ,$scope.config.updateUrl).then(function(response){
                    $scope.loaderShow = false;
                    if(response.data.response == 'success'){

                        var defaultButton = $scope.buttonSave;
                        $scope.buttonSave = response.data.message;

                        $timeout( function(){
                            $scope.buttonSave = defaultButton;
                            $scope.checked = false;
                        }, 1000 );
                        console.log(response.data.response + ' : ' + response.data.message);
                    }else{
                        console.log(response.data.response + ' : ' + response.data.message);
                    }
                });
            });
        }
    }
}]).factory('service', ['$http', function($http){
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
new AppFactory("simple-draggable", "simpleDraggableFactory", ["simpleDraggable"]);