'use strict';

angular.module("categorySelect", []).controller('category-select',['$scope',  function($scope){

    $scope.init = function (config){
        $scope.list = config.tree;
        $scope.updateUrl = config.updateUrl;
        $scope.buttonSave = config.buttonSave;
        $scope.loaderShow = false;
        $scope.checked = false;
    }



}]).directive('categorySelectView',['$timeout','service',  function factory($timeout,service ){
    return {
        restrict: 'AE',
        replace: true,
        link: function ($scope, element, attrs) {
            $scope.category = [];
            var ingredients;
            init($scope.list);

            function init(list) {

                ingredients = document.querySelectorAll('ol.checkbox-list input');

                angular.forEach(list, function(item){
                    if(item.nodes){
                        $scope.category.push({'id':item.id,'checked':item.checked, 'usedBefore':item.usedBefore});
                        init(item.nodes);
                    }else{
                        $scope.category.push({'id':item.id,'checked':item.checked, 'usedBefore':item.usedBefore});
                    }
                });
            }
            $scope.setToggleChecked = function(id){
                angular.forEach($scope.category, function(item){
                    if(item.id == id){
                        item.checked = (item.checked) ? false : true;
                    }
                })
            }

            $scope.saveChanges = ('click', function(){
                $scope.checked = true;
                $scope.loaderShow = true;
                service.update($scope.category ,$scope.updateUrl).then(function(response){

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
new AppFactory("category-select", "categorySelectFactory", ["categorySelect"]);