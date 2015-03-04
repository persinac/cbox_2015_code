var phonecatControllers = angular.module('phonecatControllers', []);

phonecatControllers.controller('TeamListCtrl', function ($scope, $http) {
	$scope.comp_id = 10000000;
	$scope.orderProp = 'name';
	$http({
		url: "../../comp_getTeams.php",
		method: "POST",
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		data: $.param({comp_id:$scope.comp_id})
		}).success(function(data, status, headers, config) {
			$scope.data = data;
		}).error(function(data, status, headers, config) {
			$scope.status = status;
	});
});

phonecatControllers.controller('TeamDetailCtrl', ['$scope', '$routeParams',
  function($scope, $routeParams) {
    $scope.team_id = $routeParams.team_id;
  }]);

phonecatControllers.controller('TableListCtrl', function ($scope) {
  $scope.numbers = [
    {'value': '1'},
    {'value': '2'},
    {'value': '5'}
  ];
  
});