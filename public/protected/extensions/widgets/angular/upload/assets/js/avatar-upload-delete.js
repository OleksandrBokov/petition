'use strict';

angular.module("avatarUpload",['ngFileUpload'])
    .controller('avatar-upload',['$scope', 'Upload', '$timeout', '$http',  function($scope, Upload, $timeout, $http) {

        $scope.init = function(config){
            $scope.photo = config;
        };

        $scope.$watch('files', function(){
            if( $scope.avatarForm.file ){
                if ($scope.avatarForm.file.$valid && $scope.files) {
                    Upload.base64DataUrl($scope.files).then(function(data) {
                        $scope.photo.base64 = data;
                        $scope.photo.file = $scope.avatarForm.file;
                        $scope.defaultPhoto = false;
                    });
                }
            }
        });

        document.getElementById('close-coach-form').onclick = function() {
            angular.forEach(
                angular.element("input[type='file']"),
                function(inputElem) {
                    angular.element(inputElem).val(null);
                });
            $scope.init('');
        };

    }]);
new AppFactory("avatar-upload", "avatarUploadFactory", ["avatarUpload"]);