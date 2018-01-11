'use strict';

angular.module("selectTree", ['ui.tree']).controller('select-tree',['$scope',  function($scope){

    $scope.init = function (config){
        $scope.list = config.tree;
    }



}]).directive('selectTreeView',['$timeout',  function factory($timeout ){

    return {
        restrict: 'AE',
        replace: true,
        link: function ($scope, element, attrs) {

            $scope.visible = function (item) {
                return !($scope.query && $scope.query.length > 0
                && item.title.indexOf($scope.query) == -1);

            };

            $scope.checkChildNode = function(node)
            {
                if(node.nodes)
                    return true;
                else
                    return false;
            }
        }
    }

}]);
new AppFactory("select-tree", "selectTreeFactory", ["selectTree"]);