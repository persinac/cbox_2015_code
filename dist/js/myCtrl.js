app.controller("MyController", function($scope) {
	$scope.message = function() {
		alert("hello");
	}
});

app.controller("navigationController", ['$scope', '$http', '$sce',function($scope, $http, $sce) {
    $scope.renderHtml = function (htmlCode) {
		return $sce.trustAsHtml(htmlCode);
	};
	$scope.message = function() {
		alert("hello");
		buildActivityFeed();
	}
	$scope.myHTML =
       '<!-- Static navbar -->'+
		  '<div class="navbar navbar-default" role="navigation">'+
			'<div class="container-fluid">'+
			  '<div class="navbar-header">'+
				'<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">'+
				  '<span class="sr-only">Toggle navigation</span>'+
				  '<span class="icon-bar"></span>'+
				  '<span class="icon-bar"></span>'+
				  '<span class="icon-bar"></span>'+
				'</button>'+
				'<a class="navbar-brand" href="#">Challenge Calendar</a>'+
			  '</div>'+
			  '<div class="navbar-collapse collapse">'+
				'<ul id="main_nav" class="nav navbar-nav">'+
				  '<li id="nav_profile"><a href="#profile">Profile</a></li>'+
				  '<li id="nav_browse" ><a href="#browse">Browse Users</a></li>'+
				  '<li id="nav_calendar" class="active"><a href="#calendar">Calendar</a></li>'+
				  '<li id="nav_challenges" ><a href="#challenges">Challenges</a></li>'+
				  '<li id="nav_leaderboard" ><a href="#leaderboard">Leaderboard</a></li>'+
				  '<li id="nav_messageboard" ><a href="#msgboard">Messageboard</a></li>'+
				  '<li id="nav_activity_feed" ><a href="#activityfeed" ng-click="message()">Activity Feed</a></li>'+
				'</ul>'+
			  '</div><!--/.nav-collapse -->'+
			'</div><!--/.container-fluid -->'+
		  '</div>';
	
  }]);