'use strict';

angular.module("multiUpload",['ngFileUpload']).controller('multi-upload',['$scope', 'Upload', '$timeout', '$http',  function($scope, Upload, $timeout, $http) {

    $scope.uploadList = [];
    $scope.pictureList = [];
    $scope.init = function(config) {
        $scope.config = config;
        $scope.pictureList = config.pictureList;
        $scope.buttonSave = config.buttonSave;
        $scope.loaderShow = false;
        $scope.checked = false;
    }

    $scope.$watch('files', function(){
        var data_file = { 'file':'','base64':''}
        if ($scope.form.file.$valid && $scope.files) {
            Upload.base64DataUrl($scope.files).then(function(data) {
                data_file.base64 = data;
                data_file.file = $scope.files
                $scope.uploadList.push(data_file);
            });
            console.log( $scope.uploadList );
        }
    });

    $scope.removeUploadItem = function (idx) {
        $scope.uploadList.splice(idx, 1)
    }

    $scope.uploadFiles = function () {
        var defaultButton = $scope.buttonSave;
        if ($scope.uploadList && $scope.uploadList.length) {
            for (var i = 0; i < $scope.uploadList.length; i++) {
                Upload.upload({
                    url: $scope.config.uploadPath,
                    data:  $scope.uploadList[i],
                    dataType: 'json'
                }).progress(function(e) {
                    $scope.checked = true;
                    $scope.loaderShow = true;
                }).success(function(data, status) {

                    $scope.loaderShow = false;
                    $scope.buttonSave = data.message;
                    $scope.pictureList.push(data.img);
                })
            }
        }
        $timeout( function(){
            $scope.uploadList = [];
            $scope.buttonSave = defaultButton;
            $scope.checked = false;
        }, 3000 );
    }

    $scope.deletePicture = function (idx) {

        $http.post($scope.config.deletePath, {'data':$scope.pictureList[idx]})
            .success(function(data) {
                $scope.pictureList.splice(idx, 1);
            })
    }

}]);
new AppFactory("multi-upload", "multiUploadFactory", ["multiUpload"]);