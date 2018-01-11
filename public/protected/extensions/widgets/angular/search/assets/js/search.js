'use strict';

angular.module("categorySearch", []).controller('category-search',['$scope', function($scope){

    $scope.init = function (data){

        $scope.categories = data.categories;
        $scope.sport = data.sport;
        angular.forEach($scope.categories, function(item) {
            if(item.url == $scope.sport){$scope.query =item.name; }
        });
        if($scope.query){ $scope.done = true;}
    };

    $scope.setQuery = function(item){
        $scope.query = item.name;
        $scope.sport = item.url;
        $scope.done = true;
    }
    $scope.clearQuery = function () {
        $scope.sport = '';
        $scope.query = '';
        $scope.done = false;
    }
}]).filter('search',  function() {
    return function(data,  scope) {

        var results = [];
        if( scope.done ){
            return;
        }else{

            if(!scope.query ){
                return data;
            }
            var field = scope.query.toLowerCase();
            angular.forEach(data, function(item) {
                if (item.name.toLowerCase().indexOf(field) !== -1) {
                    results.push( item );
                }
            });
        }
        return results;
    }

}).filter('highlight', function($sce) {
    return function(item, phrase) {
        if (phrase){
            var text = item.name.replace(new RegExp('('+phrase+')', 'gi'), '<strong>$&</strong>' );
            return $sce.trustAsHtml(text);
        }
    }
});

new AppFactory("category-search", "categorySearchFactory", ["categorySearch"]);