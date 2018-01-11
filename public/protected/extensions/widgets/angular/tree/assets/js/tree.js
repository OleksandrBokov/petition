'use strict';

angular.module("simpleTree", ['ui.tree']).controller('simple-tree',['$scope',  function($scope){

    $scope.init = function (config){
        $scope.list = config.tree;
    }

}]).directive('treeView',['$timeout',  function factory($timeout ){
    return {
        restrict: 'AE',
        replace: true,
        // templateUrl: 'simple-tree.html',
        link: function ($scope, element, attrs) {
            console.log($scope.list);
        }
    }
}]);
new AppFactory("simple-tree", "simpleTreeFactory", ["simpleTree"]);