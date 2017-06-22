angular.module("myApp")
        .controller("indexController", ["$scope", "$http", function ($scope, $http) {
                $http({
                    method: "GET",
                    url: "/POS/js/json/settings.json",
                    headers: {
                        "Content-Type": "application/json"
                    }
                }).then(function successCallback(response) {
                    var data = response.data;
                    $(".company-name").text(data.name);
                });
            }]);

