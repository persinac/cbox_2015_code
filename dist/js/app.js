var phonecatApp = angular.module('phonecatApp', [
	'ngRoute',
	'phonecatControllers'
]);

phonecatApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/angularTest', {
        templateUrl: 'partials/comp_team_list.html',
        controller: 'TeamListCtrl'
      }).
      when('/angularTest/teams/:team_id', {
        templateUrl: 'partials/comp_team_detail.html',
        controller: 'TeamDetailCtrl'
      }).
      otherwise({
        redirectTo: '/angularTest'
      });
  }]);