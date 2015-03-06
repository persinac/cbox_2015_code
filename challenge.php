<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Challenge Calendar</title>

    <!-- Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

	    <!-- Custom styles for this template -->
	<link href='dist/fullcalendar/fullcalendar.css' rel='stylesheet' />
	<link href='dist/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
	<link rel="stylesheet" href="dist/jq_ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link href="dist/css/jquery.datepick.css" rel="stylesheet">
	<link href="dist/css/first_page_css.css" rel="stylesheet">
	<link href="dist/css/tabs.css" rel="stylesheet">
	<link href="dist/css/profiles.css" rel="stylesheet">
	<link href="dist/css/tabs_ext_challenge.css" rel="stylesheet">
    <link href="dist/css/group_ext.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular.min.js"></script>
  </head>
  <body >
	
    <div class="container">
		<!--
		<div ng-controller="navigationController">
			<p dynamic="renderHtml(myHTML)"></p>
		</div>-->
		  <!-- Static navbar  -->
		  <div class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
			  <div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				  <span class="sr-only">Toggle navigation</span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Challenge Calendar</a>
			  </div>
			  <div class="navbar-collapse collapse">
				<ul id="main_nav" class="nav navbar-nav">
					<li class="dropdown" style="z-index: 9999";>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Social<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li id="nav_profile"><a href="#profile">Profile</a></li>
							<li id="nav_browse" ><a href="#browse">Social</a></li>
							<li id="nav_messageboard" ><a href="#msgboard">Messageboard</a></li>
							<li id="nav_activity_feed" ><a href="#activityfeed">Activity Feed</a></li>
							<li id="nav_account" ><a href="#account">Account</a></li>
						</ul>
					</li>
					<li class="dropdown" style="z-index: 9999";>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Workouts<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li id="nav_calendar" class="active"><a href="#calendar">Calendar</a></li>
							<li id="nav_challenges" ><a href="#challenges">Challenges</a></li>
							<li id="nav_goals" ><a href="#goals">Goals</a></li>
							<li id="nav_leaderboard" ><a href="#leaderboard">Leaderboard</a></li>
						</ul>
					</li>
				  <li id="nav_logout" ><a href="#logout">Logout</a></li>
				</ul>
			  </div>
			</div>
		  </div>
		
		<div id="dyn_content" class="">
		</div>
		
		<div id="dialog-modal" title="" class="container">
			<div id="workoutcontent" class="workout-content"></div>
			<div id="workout-footer" class="workout-footer"></div>
		  <p></p>
		</div>
		
		<div id="repeat-workout-modal" title="Choose Repeat Date" class="container-fluid">
			<div id="repeatcontent"></div>
		</div>
		
		<div id="browse_user_modal" title="" class="container-fluid">
			<div id="users"></div>
		  <p></p>
		</div>

        <div id="add-user-to-group-modal" title="" class="container">
            <div id="users-to-add" class="row workout-content"></div>
            <div id="users-to-add-footer" class="workout-footer"></div>
            <p></p>
        </div>

		<div id="login-modal" title="Login" style="display:none;" class="container-fluid">
			<div id="user_login">
			</div>
		</div>

        <div id="register-modal" title="New User" style="display:none;" class="container-fluid">
            <div id="register_new_user">
            </div>
        </div>

		<div id="goals_modal" title="" class="container-fluid">
			<div id="goal_content"></div>
		</div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins)-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	
	<script src="dist/js/angular-sanitize.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	
	<script src="dist/js/ch_edit_user_profile.js"></script>
    <script src="dist/js/edit_group.js"></script>
	<script src="dist/js/chall_utilities.js"></script>
	<script src="dist/js/getAndViewHelpers.js"></script>
    <script src="dist/js/history.min.js"></script>
    <script src="dist/js/challenge_cal_registerUser.js"></script>
	
    <script src='dist/lib/moment.min.js'></script>
	<!--<script src='dist/lib/jquery.min.js'></script>
	<script src='dist/lib/jquery-ui.custom.min.js'></script>-->
	<script src="dist/jq_ui/js/jquery-1.10.2.js"></script>
	<script src="dist/jq_ui/js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src='dist/fullcalendar/fullcalendar.js'></script>
	
	
	<!-- Required for date picker -->
	<script src="dist/js/jquery.plugin.min.js"></script>
	<script src="dist/js/jquery.datepick.min.js"></script> 
	
	<script src="dist/js/utilities.js"></script>
	
<script>
var user_id = -1;
var other_user = -1;
var noti_array = new Array();
var group_req = -1;
var fr_req = -1;
$(document).ready(function() {
	var temp = "<?php if(isset($_SESSION["MM_cal_user_id"])){ echo $_SESSION["MM_cal_user_id"]; } else { echo -1; }?>";
	console.log(temp);
	url = window.location;
	console.log(url);
	user_id = parseURL(url);
	document.location.hash = '';
	console.log("BEFORE LOGIN IF: "+user_id);
	if(user_id == -1 && temp == "-1") {
		login();
	} else if(temp != "-1"){
		setUserIDCal(temp);
	}	else {
		setUserIDCbox(user_id);
	}
	
	getCurrentDate();
});

/*
* Crude way to handle back button functionality
* Will hvae to make more specific as time goes on
*
*/
window.addEventListener( "popstate", function( e ) {

    // the library returns the normal URL from the event object
    var cLocation = history.location || document.location;
    //alert("something: " + [ cLocation.href, history.state ] );

    if(cLocation.hash.length < 2) {
        buildCalendarPage();
        renderCalendar(user_id, false);
        $("ul").find("li.active").removeClass("active");
        $("#nav_calendar").addClass("active");
    } else if (cLocation.hash.indexOf("calendar") > -1) {
        buildCalendarPage();
        renderCalendar(user_id, false);
        $("ul").find("li.active").removeClass("active");
        $("#nav_calendar").addClass("active");
    } else if (cLocation.hash.indexOf("browse") > -1) {
        getUsers(user_id);
        $("ul").find("li.active").removeClass("active");
        $("#nav_browse").addClass("active");
    } else if (cLocation.hash.indexOf("profile") > -1) {
        getUserInfo(user_id);
        $("ul").find("li.active").removeClass("active");
        $("#nav_profile").addClass("active");
    } else if (cLocation.hash.indexOf("challenges") > -1) {
        if($("#nav_challenges").hasClass('notification')) {
            listChallenges(user_id, 1);
            $("#nav_challenges").removeClass('notification');
        } else {
            listChallenges(user_id, 0);
        }
        $("ul").find("li.active").removeClass("active");
        $("#nav_challenges").addClass("active");
    } else if (cLocation.hash.indexOf("messageboard") > -1) {
        buildMessageboard();
        $("ul").find("li.active").removeClass("active");
        $("#nav_browse").addClass("active");
    } else if (cLocation.hash.indexOf("activity") > -1) {
        buildActivityFeed();
        $("ul").find("li.active").removeClass("active");
        $("#nav_browse").addClass("active");
    } else if (cLocation.hash.indexOf("goals") > -1) {
        buildGoals(user_id);
        $("ul").find("li.active").removeClass("active");
        $("#nav_goals").addClass("active");
    }
});


$("#main_nav").on("click", "li", function() {
    history.pushState(null, null, document.location.hash);
	other_user = -1;
	var toParse = $(this).find('a').attr('href');
	$("ul").find("li.active").removeClass("active");
	$(this).addClass('active');
	console.log(toParse);
	clearInterval(activityFeedIntervalID);
	clearInterval ( wooYayIntervalId );
	if(toParse == "#profile") {
		getUserInfo(user_id);
	} else if(toParse == "#calendar") {
		buildCalendarPage();
		renderCalendar(user_id, false);
		getNotifications(user_id);
	} else if(toParse == "#challenges") {
		if($("#nav_challenges").hasClass('notification')) {
			listChallenges(user_id, 1);
			$("#nav_challenges").removeClass('notification');
		} else {
			listChallenges(user_id, 0);
		}
	} else if(toParse == "#leaderboard") {
		//openRegistration();
	} else if(toParse == "#browse") {
		getUsers(user_id);
        console.log("FR_REQ: " + fr_req + ", GROUP_REQ: " + group_req);

	} else if(toParse == "#msgboard") {
		buildMessageboard();
	} else if(toParse == "#activityfeed") {
		buildActivityFeed();
	} else if(toParse == "#logout") {
		alert("LOGGING OUT");
		console.log("logging out...");
	
		$.ajax(
		{ 
			url: "/CRUD/general/cal_logout.php",  
			success: function(response) //on recieve of reply
			{
				console.log("logged out...");
				window.location.replace("http://compete-box.com/challenge.php");
			} 
		});
	}
});

$('#user_login').keypress(function (e) {
	if (e.which == 13) {
		checkCredentials();
		return false;
	}
});

var currentAttrValue = "";
$("#dyn_content").on('click', '.tab-links a',function(e)  {
	
	currentAttrValue = $(this).attr('href');
    parentAttrValue = $(this).parent().attr('id');
    if($('#' + parentAttrValue + '').hasClass('notification')) {
        if(parentAttrValue == 'tab_fr_req') {
            console.log("FRIEND REQ : " + user_id);
            markFrAsRead(user_id);
        } else if(parentAttrValue == 'tab_gr_req') {
            console.log("GROUP REQ");
            //markGrAsRead(user_id);
        }
    }
	//console.log("currentAttrValue: "+currentAttrValue + ", parent: " + parentAttrValue);
	// Show/Hide Tabs
	$('.tabs ' + currentAttrValue).slideDown(400).siblings().slideUp(400);
	$('.tabs ' + currentAttrValue).addClass('active').siblings().removeClass('active');

	// Change/remove current tab to active
	$(this).parent('li').addClass('active').siblings().removeClass('active');

	e.preventDefault();
});

$('#dialog-modal').on('dialogclose', function () {
    $("#workoutcontent").empty();
});


function buildCalendarPage() {
	var html = '';

    html += '<div id="button_container">';
    html += '<a onclick="openNewWorkoutModal()" class="btn btn-primary btn-large" id="new_core_button" class="buttons_in_but_container">Create New Workout</a>';
    html += ' <a onclick="openUpdateModal()" class="btn btn-primary btn-large" id="new_core_button" class="buttons_in_but_container">Update Workout</a>';
    html += ' <a onclick="openRestModal()" class="btn btn-primary btn-large" id="new_rest_button" class="buttons_in_but_container">Add Rest Day</a>';
    html += ' <a onclick="openDeleteModal()" class="btn btn-primary btn-large" id="delete_button" class="buttons_in_but_container">Delete Workout</a>';
    html += ' ';
    html += '<a onclick="openUserModal()" class="btn btn-primary btn-large" id="client_button" class="buttons_in_but_container">Log Workout Results</a>';
    html += ' <a onclick="createChallenge()" class="btn btn-primary btn-large" id="challenge_button" class="buttons_in_but_container">Create a Challenge</a>';
    html += '</div><p></p>';
	html += '<div id="calendar"></div><div id="eventContent" title="Event Details">';
	html += '<div id="eventInfo"></div></div>';

	
	$("#dyn_content").html(html);
}
	
var today = new Date();
function getCurrentDate()
{
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	
	if(dd<10) {
		dd='0'+dd;
	} 
	
	if(mm<10) {
		mm='0'+mm;
	} 
	today = yyyy+'-'+mm+'-'+dd;
}
	

function renderCalendar(t_id, other_profile) {
	//user_id = t_id;
    console.log("render calendar t_id: " + t_id)
	if(other_profile  == true) {
		other_user = t_id;
	}
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: today,
		selectable: true,
		selectHelper: true,
		editable: false,
		eventSources: 
		[
			{
				url: '/CRUD/challenge_calendar/getWorkouts.php',
				type: 'POST',
				data: { "date" : "2014-05-05", "uid":t_id },
				datatype: 'json',
				success: function(data) {
					console.log("GET WORKOUTS: " + data + ", title? ");
				},
				error: function(data) {
					console.log("Error workouts: " + data);
				},
				textColor: 'black'
			},
			{
				url: '/CRUD/challenge_calendar/getWorkoutLog.php',
				type: 'POST',
				data: { "id" : t_id },
				datatype: 'json',
				success: function(data) {
					console.log("log data: " + data + "");
				},
				error: function(data) {
					console.log("Error loading workout logs: " + data);
					getLog();
				},
				textColor: 'black'
			},
			{
				url: '/CRUD/challenge_calendar/getChallenges.php',
				type: 'POST',
				data: { "id" : t_id },
				datatype: 'json',
				success: function(data) {
					console.log("log data: " + data + "");
				},
				error: function(data) {
					console.log("Error loading challenges: " + data);
					//getLog();
				},
				borderColor: 'black',
				textColor: 'black'
				
			},
            {
                url: '/CRUD/challenge_calendar/getGroupWorkouts.php',
                type: 'POST',
                data: { "date" : "2014-05-05", "uid":t_id },
                datatype: 'json',
                success: function(data) {
                    console.log("GET GROUP WORKOUTS: " + data + ", title? ");
                },
                error: function(data) {
                    console.log("Error group workouts: " + data);
                },
                textColor: 'black'
            }
		],

		eventRender: function (event, element) {
			element.attr('href', 'javascript:void(0);');
			//console.log("EVENT ID:" + event.id);
			if(typeof event.challenge_id === "undefined") {
				event.challenge_id = -1;
			} 
			height = -1;
			width = -1;
			element.attr('onclick', 'openModal("' + event.title + '","' + event.description + '","'+event.challenge_id+'","'+height+'","'+width+'","' + event.t_date + '","' + event.id + '");');
		}
	});
}
	
function submitWorkout(modified) {
    try {
        $("#repeat-workout-modal").dialog('close');
    } catch (err) {
        console.log("Repeat workout modal not open");
    }
    var mod = modified;
    if("undefined" == typeof modified){
        mod = -1;
    }
	var c_date = $("#date").val();
	$("#date").datepick('destroy');
	if(c_date.length > 0) {
		var form_data = $("#workout_descrip").serializeArray();
		var runningTotal = 0;
		form_data.push({name:"uid", value:user_id});
        console.log(mod);
        form_data.push({name:"mod", value:mod});
		$.each(form_data, function(i, field){
            if(field.name != "mod") {
                runningTotal += field.value.length;
                field.value = replaceSemiColon(field.value);
            }
		});
		if(runningTotal > 15) {
			$.ajax(
			{ 
				type:"POST",                                     
				url:"/CRUD/challenge_calendar/insertWorkout.php",         
				data: form_data,
				dataType: "text",
				success: function(response) {
					console.log(response);
                    if(response == "9") {
                        //there exists a workout on that date
                        openOverwriteWorkoutOption();
                    } else if(response == "2") {
                        console.log("Delete failed. Try again.");
                    } else if(response == "0") {
                        console.log("Insert failed. Try again.");
                    } else {
                        $('#calendar').fullCalendar('refetchEvents');
                        clearInputs("woIn");
                        alert("Successfully inserted your workout!");
                        $( "#dialog-modal" ).dialog('close');
                    }
				},
				error: function(){
					alert('error inserting workout!');
				}
			});
		} else {
			alert("Please put something in the text boxes...");
		}
	} else {
		alert("Please select a date!");
	}
}

function submitRest() {
	var c_date = $("#date").val();
	$("#date").datepick('destroy');
	if(c_date.length > 0) {
		var form_data = $("#workout_descrip").serializeArray();
		form_data.push({name:"rest", value:"T"});
		form_data.push({name:"uid", value:user_id});
		$.ajax(
		{ 
			type:"POST",                                     
			url:"/CRUD/challenge_calendar/insertRest.php",         
			data: form_data, 
			dataType: "text",      
			success: function(response)
			{
				console.log(response);
				$('#calendar').fullCalendar('refetchEvents');
				alert("Successfully added your rest day!");
				$( "#dialog-modal" ).dialog('close');
			},
			error: function(){
				alert('error inserting rest day!');
			}
		});
	} else {
		alert("Please select a date!");
	}
}

function updateWorkout() {

	var c_date = $("#date").val();
	$("#date").datepick('destroy')
	if(c_date.length > 0) {
		var form_data = $("#workout_descrip").serializeArray();
		
		form_data.push({name:"uid", value:user_id});
		$.each(form_data, function(i, field){
			field.value = replaceSemiColon(field.value);
		});

		$.ajax(
		{ 
			type:"POST",                                     
			url:"/CRUD/challenge_calendar/updateWorkout.php",         
			data: form_data,
			dataType: "text",
			success: function(response) 
			{
				console.log(response);
				$('#calendar').fullCalendar('refetchEvents');
				clearInputs("woIn");
				alert("Successfully updated your workout log!");
			},
			error: function(){
				alert('error updating workout!');
			}
		});
	} else {
		alert("Please select a date!");
	}
}

function submitClientLog() {

	var c_date = $("#date_client").val();
	$("#date_client").datepick('destroy');
	if(c_date.length > 0) {
		var form_data = $("#client_workout_descrip").serializeArray();
		form_data.push({name:"id", value:user_id});
		
		$.each(form_data, function(i, field){
			console.log("DATA: " + field.name + " : " + field.value);
			field.value = replaceSemiColon(field.value);
		});
		
		$.ajax(
		{ 
			type:"POST",                                     
			url:"/CRUD/challenge_calendar/insertWorkoutLog.php",         
			data: form_data,
			dataType: "text", 
			success: function(response) {
				console.log(response);
				if(response.indexOf("1") < 0) {
					$( "#dialog-modal" ).dialog("close");
					clearInputs("wolIn");
					$('#calendar').fullCalendar('refetchEvents');
					alert("Successfully updated your workout log!");
				}
			},
			error: function(){
				alert('error inserting workout log!');
			}
		});
	} else {
		alert("Please select a date!");
	}	
}

function openRestModal() {
	title = "New Rest Day";
    $( "#dialog-modal" ).dialog({
      height: 400,
	  width: 300,
      modal: true
    });
	var html = "";
	
	html += '<form id="workout_descrip">';
	html += '<h3>Date for Rest</h3><input type="text" name="date" id="date" placeholder="YYYY-MM-DD"/>';
	html += '</form><p></p>';
	html += '<a onclick="submitRest()" class="btn btn-primary btn-large" id="new_core_button" class="buttons_in_but_container">Submit</a>';

	$( "#dialog-modal" ).dialog('option', 'title', title);
	$('#workoutcontent').html(html);
    html = '';
    $('#workout-footer').html(html);

	$("#date").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
	});
}

function openDeleteModal() {
	title = "Delete Workout";
    $( "#dialog-modal" ).dialog({
      height: 400,
	  width: 300,
      modal: true
    });
	var html = "";
	
	html += '<form id="workout_descrip">';
	html += '<h3>Date to Delete</h3><input type="text" name="date" id="date" placeholder="YYYY-MM-DD"/>';
	html += '</form><p></p>';
	html += '<a onclick="deleteWorkout()" class="btn btn-primary btn-large" class="buttons_in_but_container">Delete</a>';
	
	$( "#dialog-modal" ).dialog('option', 'title', title);
	$('#workoutcontent').html(html);
    html = '';
    $('#workout-footer').html(html);
	$("#date").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
	});
}

function openUpdateModal() {
	title = "Update Workout";
    $( "#dialog-modal" ).dialog({
      height: 500,
	  width: 800,
      modal: true
    });
	var html = "";
	
	html += '<form id="workout_descrip">';
	html += '<h3>Date of Workout</h3><input type="text" name="date" id="date" placeholder="YYYY-MM-DD"/><p></p>';
	html += '<a onclick="getWorkoutDetailsForUpdate('+user_id+')" class="btn btn-primary btn-large" id="upd_btn_get_wod" class="buttons_in_but_container"> Get Workout </a>';
	html += '</form>';
	html += '';
	
	$( "#dialog-modal" ).dialog('option', 'title', title);
	$('#workoutcontent').html(html);
    html = '';
    $('#workout-footer').html(html);
	$("#date").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
	});
	//getWorkoutDetailsForUpdate()
}

function openNewWorkoutModal() {
	title = "New Workout";
    $( "#dialog-modal" ).dialog({
      height: 600,
	  width: 900,
      modal: true
    });
	var html = "";
	
	html += '<form id="workout_descrip">';
	html += '<h3>Date for workout</h3><input type="text" name="date" id="date" placeholder="YYYY-MM-DD"/>';
	html += '<h3>Warm Up</h3><textarea rows="4" cols="100" id="warmUp" name="warmUp"></textarea><p></p>';
	html += '<h3>Strength</h3><textarea rows="4" cols="100" id="strength" name="strength"></textarea><p></p>';
	html += '<h3>Conditioning</h3><textarea rows="4" cols="100" id="conditioning" name="conditioning"></textarea>';
	html += '<p></p>';
	html += '<h3>Speed</h3><textarea rows="4" cols="100" id="speed" name="speed"></textarea><p></p>';
	html += '<h3>Core</h3><textarea rows="4" cols="100" id="core" name="core"></textarea><p></p>';
	html += '</form>';

	$( "#dialog-modal" ).dialog('option', 'title', title);
	$('#workoutcontent').html(html);
    html = '<a onclick="submitWorkout()" class="btn btn-primary btn-large" id="client_log_button" class="buttons_in_but_container">Submit Workout</a>';
    $('#workout-footer').html(html);
	
	$("#date").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
	});
    //add an "Assign to:" button
}

function openUserModal(title) {

    $( "#dialog-modal" ).dialog({
      height: 500,
	  width: 1000,
      modal: true
    });
	var html = "";
	
	html += '<form id="client_workout_descrip"><h3>Date for workout</h3>';
	html += '<input type="text" name="date" id="date_client" placeholder="YYYY-MM-DD"/>';
	html += '<h3>Strength</h3><textarea rows="4" cols="100" id="strength" name="strength"></textarea><p></p>';
	html += '<h3>Conditioning</h3><textarea rows="4" cols="100" id="conditioning" name="conditioning"></textarea><p></p>';
	html += '<h3>Speed</h3><textarea rows="4" cols="100" id="speed" name="speed"></textarea><p></p>';
	html += '<h3>Core</h3><textarea rows="4" cols="100" id="core" name="core"></textarea><p></p>';
	html += '</form>';

	
	$( "#dialog-modal" ).dialog('option', 'title', title);
	$('#workoutcontent').html(html);
    html = '<a onclick="submitClientLog()" class="btn btn-primary btn-large" id="client_log_button" class="buttons_in_but_container">Submit Log</a>';
    $('#workout-footer').html(html);
	
	$("#date_client").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
	});
}

function openCreateGroup() {
    var title = "New Group";
    $( "#dialog-modal" ).dialog({
        height: 500,
        width: 500,
        modal: true
    });
    var html = "";

    html += '<form id="create_new_group">';
    html += '<h3>Group Name</h3><input type="text" name="group_name" id="group_name"/><p></p>';
    html += '<h3>Location</h3><input type="text" name="group_location" id="group_location"/<p></p>';
    html += '<h3>Invite Only?</h3><input type="radio" name="invite" value="yes" checked>Yes ';
    html += '<input type="radio" name="invite" value="no">No<br>';
    html += '</form>';
    html += '<a onclick="createGroup(user_id)" class="btn btn-primary btn-large" id="create_group_btn" class="buttons_in_but_container">Create Group</a>';

    $( "#dialog-modal" ).dialog('option', 'title', title);
    $('#workoutcontent').html(html);
    html = '';
    $('#workout-footer').html(html);
}

function replaceSemiColon(str) {
	
	var t_string = "";
	var t_index = t_string.indexOf(";");

	t_string = str.replace(/;/g, "<p></p>");	
	return t_string;
}

function openModal(title, info, ch_id, height, width, date, id) {
	(height > 0) ? height : height = 500;
	(width > 0) ? width : width = 400;
	$( "#dialog-modal" ).dialog({
      height: height,
	  width: width,
      modal: true
    });
	$( "#dialog-modal" ).dialog('option', 'title', title);

	if(ch_id > 0) {
        info += '<a onclick="viewChallengeDetails(' + ch_id + ')" class="btn btn-primary btn-large" ';
        info += 'id="challenge_details_button" >Challenge Details</a>';
    }

	var infoBuild = '<p>  '+info+' </p>';
	$('#workoutcontent').html(infoBuild);
	infoBuild = '<div class="btn-group btn-group-justified">';
	infoBuild += '<div class="btn-group"><button type="button" onclick="previousDayWorkout(\''+id+'\',\''+date+'\',\''+user_id+'\',\''+other_user+'\')" class="btn btn-default btn-lg">';
	infoBuild += '<span class="glyphicon glyphicon-chevron-left"></span></button></div>';
	infoBuild += '<div class="btn-group"><button type="button" onclick="nextWorkoutType(\''+id+'\',\''+date+'\',\''+user_id+'\',\''+other_user+'\')" class="btn btn-default btn-lg">';
	infoBuild += '<span class="glyphicon glyphicon-chevron-down"></span></button></div>';
	infoBuild += '<div class="btn-group"><button type="button" onclick="openRepeatWorkout(\''+date+'\',\''+user_id+'\',\''+id+'\')" class="btn btn-default btn-lg">';
	infoBuild += '<span class="glyphicon glyphicon-repeat"></span></button></div>';
	infoBuild += '<div class="btn-group"><button type="button" class="btn btn-default btn-lg">';
	infoBuild += '<span class="glyphicon glyphicon-star"></span></button></div>';
	infoBuild += '<div class="btn-group"><button type="button" onclick="prevWorkoutType(\''+id+'\',\''+date+'\',\''+user_id+'\',\''+other_user+'\')" class="btn btn-default btn-lg">';
	infoBuild += '<span class="glyphicon glyphicon-chevron-up"></span></button></div>';
	infoBuild += '<div class="btn-group"><button type="button" onclick="nextDayWorkout(\''+id+'\',\''+date+'\',\''+user_id+'\',\''+other_user+'\')" class="btn btn-default btn-lg">';
	infoBuild += '<span class="glyphicon glyphicon-chevron-right"></span></button></div>';
	infoBuild += '</div>';

    if(typeof id === "undefined") {
        infoBuild = "";
        console.log("OPEN MODAL id is UNDEFINED");
    } else if(id.indexOf("g") == 0) {
        infoBuild = '<a onclick="viewGroupWorkoutDetails(\'' + id + '\',\'' + date + '\')" class="btn btn-primary btn-large"';
        infoBuild += 'id="group_workout_details_button" >Workout Details</a>';
    }
    $('#workout-footer').html(infoBuild);
}

function openRepeatWorkout(date, user_id, wid) {
	
	$( "#repeat-workout-modal" ).dialog({
      height: 300,
	  width: 300,
      modal: true
    });
	var html = "";
	
	html += '<input type="text" name="date" id="date_repeat" placeholder="YYYY-MM-DD"/>';
	html += '<br><br><a onclick="repeatWorkout(\''+date+'\',\''+user_id+'\',\''+wid+'\')" class="btn btn-primary btn-large" id="client_log_button" class="buttons_in_but_container"> Submit </a>';
	
	$( "#repeat-workout-modal" ).dialog();
	$('#repeatcontent').html(html);
	
	$("#date_repeat").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
	});
}

function openOverwriteWorkoutOption() {

    $( "#repeat-workout-modal" ).dialog({
        height: 300,
        width: 400,
        modal: true
    });
    var html = "";

    html += 'A workout already exists on the selected day. Choose from an option below:';
    html += '<a onclick="closeDialog(2)" class="btn btn-primary btn-large" id="client_log_button" class="buttons_in_but_container"> Cancel Action </a>';
    html += '<a onclick="submitWorkout(1)" class="btn btn-primary btn-large" id="client_log_button" class="buttons_in_but_container"> Add to Workout </a>';
    html += '<a onclick="submitWorkout(2)" class="btn btn-primary btn-large" id="client_log_button" class="buttons_in_but_container"> Overwrite Existing </a>';

    $( "#repeat-workout-modal" ).dialog();
    $('#repeatcontent').html(html);

    $("#date_repeat").datepick({
        dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
    });
}

function pickRandomUser() {
	notYetImplemented();
}

function getLog() {
	console.log("getting logs...");
	$.ajax(
	{ 
		type:"POST",                                     
		url:"getWorkoutLog.php",         
		data: { "id" : user_id },
		dataType: "text",  
		success: function(response)
		{
			console.log(response);
		}
	});
}

function deleteWorkout() {
	
	var c_date = $("#date").val();
	if(c_date.length > 0) {
		$.ajax(
		{ 
			type:"POST",                                     
			url:"/CRUD/challenge_calendar/deleteWorkout.php",         
			data: {"uid":user_id, "c_date":c_date}, 
			dataType: "text",      
			success: function(response)
			{
				console.log(response);
				if(response.indexOf("1") < 0) {
					$('#calendar').fullCalendar('refetchEvents');
					alert("Successfully deleted workout!");
					$("#dialog-modal").dialog('close');
				} else { 
					alert('error deleting workout!');
				}
			},
			error: function(){
				alert('error inserting rest day!');
			}
		});
	} else {
		alert("Please select a date!");
	}
}

function viewChallengeDetails(id) {
	try {
		$( "#dialog-modal" ).dialog("close");
	}
	catch(err) {
		console.log(err.message);
	}
	
	markAsRead(id, user_id);
	getChallengeNotifications(user_id, 1);
	if($("#challenge_"+id+"").hasClass('notification')) {
		$("#challenge_"+id+"").removeClass('notification');
	}
	
	$("ul").find("li.active").removeClass("active");
	$("#nav_challenges").addClass("active");
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/getChallengeDetails.php",
		data: {"id":id, "uid":user_id},
		dataType: "html",
		success: function(response) {
			var t_var = response.substring(response.indexOf("****")+4);
			var accDec = t_var.substring(0,1);
			var type = t_var.substring(t_var.indexOf("?")+1,t_var.indexOf("?")+2);
			var challenger_id = t_var.substring(t_var.indexOf("?")+3);
			$("#dyn_content").html(response.substring(0,response.indexOf("****")));
			if(accDec.trim() == "e") {
				$("#dyn_content").append('<br><a onclick="acceptChallenge('+id+')" class="btn btn-primary btn-large" id="acc_cal_button">Accept Challenge</a>');
				$("#dyn_content").append(' <a onclick="declineChallenge('+id+')" class="btn btn-primary btn-large" id="dec_cal_button">Decline Challenge</a>');
			} else if (accDec.trim() == "a") {
				$("#dyn_content").append('<br><a onclick="inputScore('+id+','+type+')" class="btn btn-primary btn-large" id="sub_score_button">Submit Score</a>');
			} 
			if(challenger_id.trim() == user_id.trim()) {
				$("#dyn_content").append('<br><a onclick="updateChallenge('+id+')" class="btn btn-primary btn-large" id="update_challenge_button">Update Challenge</a>');
			}
			$("#dyn_content").append(' <a onclick="backToCalendar()" class="btn btn-primary btn-large" id="b2cal_button">Back To Calendar</a>');
		}
	});
}

function backToCalendar() {
	$("#nav_calendar").addClass("active");
	$("ul").find("li.active").removeClass("active");
	buildCalendarPage();
	renderCalendar(user_id, false);
}

function acceptChallenge(id) {
	console.log("ACCEPT UID: " +user_id + ", CID: " + id);
	
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/acceptChallenge.php",
		data: { "uid":user_id, "cid":id },
		dataType: "text",
		success: function(response) {
			if(response.trim() == "0") {
				alert("Challenge ACCEPTED");
			} else if(response.trim() == "3") {
				alert("You must accept challenges either the day of or before the challenge date!");
			} else {
				alert("Error accepting challenge, please refresh your browser and try again!");
			}
		}
	});
}

function declineChallenge(id) {
	console.log("UID: " +user_id + ", CID: " + id);
	
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/declineChallenge.php",
		data: { "uid":user_id, "cid":id },
		dataType: "text",
		success: function(response) {
			if(response.trim() == "0") {
				alert("Challenge Declined. Pussy.");
			} else if(response.trim() == "3") {
				alert("You must decline challenges either the day of or before the challenge date!");
			} else {
				alert("Error declining challenge, I guess you'll just have to accept it!");
			}
		}
	});
}

function getChallenges() {
	
	$.ajax({
		url: '/CRUD/challenge_calendar/getChallenges.php',
		type: 'POST',
		data: { "id" : user_id },
		datatype: 'json',
		success: function(data) {
			console.log("log data: " + data + "");
			//listChallenges(data);
		},
		error: function(data) {
			console.log("Error loading challenges: " + data);
		}
	});
}

function listChallenges(data, value) {
	console.log(data);
	$("#dyn_content").empty();
	
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/listChallenges.php",
		data: {"id":data},
		dataType: "html",
		success: function(response) {
			console.log(response);
			$("#dyn_content").html(response);
			if(value == 1) {
				getChallengeNotifications(user_id, 1);
			}
		}	
	});
}

/*
 * 
 * @param data: the id of the challenge
 * @param type: the type of measurement for scoring (time, total reps, or weight) 
 */
function inputScore(data, type) {
	var html = 'Score:';
	if(type == 1) {
		//method to construct dropdowns
		html += generateTimeDropDowns(1,1,1);
	} else {
		html += ' <input type="text" name="score" id="score">';
	}
	html += '<br><br><a onclick="submitScore('+data+','+type+')" class="btn btn-primary btn-large" id="submit_score_button">Submit</a>';
	openModal("Submit Score", html, -1, -1, -1);
}

function submitScore(data, type) {
	//console.log(data + ", "+ type);
	var sendRequest = false;
	var num_reg = /^[0-9]*$/;
	var display_score = "";
	var actual_score = 0;
	if(type == 1) {
		var hrs = 0;
		var min = 0;
		var sec = 0;
		display_score = $("#rft_hr_selector").val() + ":"+$("#rft_min_selector").val() + ":"+$("#rft_sec_selector").val();
		hrs = parseInt($("#rft_hr_selector").val());
		min = parseInt($("#rft_min_selector").val());
		//hours to seconds
		actual_score = (hrs * 60 * 60);
		//minutes to seconds
		actual_score += (min * 60);
		//add seconds to score
		actual_score += parseInt($("#rft_sec_selector").val());
		console.log(display_score + " vs " + actual_score);
	} else {
		display_score = actual_score = $("#score").val();
		if(!num_reg.test(display_score)) {
			$("#score").addClass("input_error");
			sendRequest = false;
		} else {
			$("#score").removeClass("input_error");
			sendRequest = true;
		}
	}
	
	$.ajax({
		type: "POST",
		url : "/CRUD/challenge_calendar/submitScore.php",
		data: { "cid": data, 
				"uid": user_id, 
				"display": display_score,
				"actual": actual_score
			},
		dataType: "text",
		success: function(response) {
			console.log(response);
			viewChallengeDetails(data);
		}
	});
	
}

function createChallenge() {
	console.log("Create challenge");
	var html = '';
	
	html = '<h4>Basics</h4><input type="text" name="chall_title" id="chall_title" placeholder="Title"/><br><br>';
	html += '<input type="text" name="chall_start" id="chall_start" placeholder="Start Date"/><br><br>';
	html += '<input type="text" name="chall_end" id="chall_end" placeholder="End Date"/><br><br>';
	html += '<h4>Who to challenge...?</h4><div id="challengees" class="browse_users"></div>';
	html += '<br><br>';
	html += ' <a onclick="pickRandomUser()" class="btn btn-primary btn-large" id="random_users_button">I\'m Feeling Lucky</a>';
	html += '<h4>What is the challenge...?</h4>';
	html += 'How to score: <select id="how_to_score"><option value="1">Fastest Time</option>';
	html += '<option value="2">Total Reps</option><option value="3">Total Weight</option></select><br>';
	html += 'Details:<br><br><textarea rows="6" cols="50" name="challenge_txt_details" id="challenge_txt_details"></textarea>';
	html += '<br><br><a onclick="submitChallenge()" class="btn btn-primary btn-large" id="submit_challenge_button">Create</a>';
	html += ' <a onclick="cancelChallenge()" class="btn btn-primary btn-large" id="cancel_challenge_button">Cancel</a>';	

	openModal("New Challenge", html, -1, 800, 600);
	
	$("#chall_start").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
	});
	$("#chall_end").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
	});
	getUsersToBrowseForChallenge(user_id);
}

/*
 *
 * @param data - The ID of the challenge being updated
 */
function updateChallenge(data) {
	console.log("Update challenge");
	var html = '';
	
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/getChallengeDetailsToUpdate.php",
		data: {"id":data},
		dataType: "html",
		success: function(response) {
			console.log(response);
			openModal("Update Challenge", response, -1, 800, 600);
	
			$("#up_chall_start").datepick({
				dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
			});
			$("#up_chall_end").datepick({
				dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
			});
			getUsersToBrowseForChallenge(user_id);
		}
	});
}

function cancelChallenge() {
	$( "#dialog-modal" ).dialog("close");
}

function submitChallenge() {
	var data = new Array();
	var title = $("#chall_title").val();
	var start = $("#chall_start").val();
	var end = $("#chall_end").val();
	var challengees = selectUsersForChallenge();
	var score_by = $("#how_to_score").val();
	var details = $("#challenge_txt_details").val();
	
	data.push({name:"challenger_id", value:user_id});
	data.push({name:"title", value:title});
	data.push({name:"start", value:start});
	data.push({name:"end", value:end});
	data.push({name:"challengees", value:challengees});
	data.push({name:"score_by", value:score_by});
	data.push({name:"details", value:details});
	
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/submitChallenge.php",
		data: data,
		dataType: "text",
		success: function(response) {
			console.log(response);
			$("#chall_start").datepick('destroy');
			$("#chall_end").datepick('destroy');
		}
	});
}

function submitChallengeUpdate(id) {
	var data = new Array();
	var title = $("#chall_title").val();
	var start = $("#up_chall_start").val();
	var end = $("#up_chall_end").val();
	var challengees = "1,2,3,4,5,6,7";
	var score_by = $("#how_to_score").val();
	var details = $("#challenge_txt_details").val();
	
	data.push({name:"challenge_id", value:id});
	data.push({name:"challenger_id", value:user_id});
	data.push({name:"title", value:title});
	data.push({name:"start", value:start});
	data.push({name:"end", value:end});
	data.push({name:"challengees", value:challengees});
	data.push({name:"score_by", value:score_by});
	data.push({name:"details", value:details});
	
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/submitChallengeUpdate.php",
		data: data,
		dataType: "text",
		success: function(response) {
			console.log("submitChallengeUpdate: "+response);
			if(response == 0) {
				alert("Successfully updated challenge!");
				$( "#dialog-modal" ).dialog("close");
				$("#up_chall_start").datepick('destroy');
				$("#up_chall_end").datepick('destroy');
				viewChallengeDetails(id);
			} else {
				alert("Error updating challenge! Code: " + response);
			}
		}
	});
	
}

function getUserInfo(id) {
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/getUserInformation.php",
		data: {"id":id, "public":""},
		dataType: "html",
		success: function(response) {
			$("#dyn_content").html(response);
		}
	});
}
var wooYayIntervalId;
function buildMessageboard() {
	var html = "";
	
	html += '<div class="msg_board_display wordwrap" name="message_board" id="message_board"></div><p></p>';
	html += '<input type="text" name="usr_msg_brd_input" id="usr_msg_brd_input" class="msg_brd_input"/><br><br>';
	html += "<a onclick='sendMessage("+user_id+")' class='btn btn-primary btn-large' id='send_msg_button'>Send Message</a>";
	$("#dyn_content").html(html);
	wooYayIntervalId = setInterval ( "getMessageboard()", 500 );
}

var activityFeedIntervalID;
function buildActivityFeed() {
	var html = "";
	
	html += '<div class="activity_feed_display wordwrap" name="activity_feed" id="activity_feed"></div><p></p>';
	html += "<div class='activity_feed_options'>";
	html += '<h4> Filter Options </h4>';
	html += '<input id="option" type="checkbox" name="option" value="rest">Rest<br>';
	html += '<input id="option" type="checkbox" name="option" value="warm">Warm Up<br>';
	html += '<input id="option" type="checkbox" name="option" value="stre">Strength<br>';
	html += '<input id="option" type="checkbox" name="option" value="cond">Conditioning<br>';
	html += '<input id="option" type="checkbox" name="option" value="spee">Speed<br>';
	html += '<input id="option" type="checkbox" name="option" value="core">Core<br>';
	html += "<a onclick='filter();' class='btn btn-primary btn-large' id='apply_filter_button'>Apply Filter</a><p></p> ";
	html += "<a onclick='getActivityFeed();' class='btn btn-primary btn-large' id='update_filter_button'>Update Filter</a><p></p> ";
	html += "<a onclick='notYetImplemented();' class='btn btn-primary btn-large' id='new_act_button'>New Activity</a></div>";
	//html = "{{firstName + \" \" + lastName}}";
	$("#dyn_content").html(html);
	getActivityFeed();
	activityFeedIntervalID = setInterval ( "getActivityFeed()", 60000 );
}

function getNotifications(id) {
	console.log("getNotifications: " + id);
	getChallengeNotifications(id, 0);
    getFriendNotifications(id);
    getGroupNotifications(id);
}

function setFrReq(num) {
    fr_req = num;
}

function setGrReq(num){
    group_req = num;
}

function getFrReq() {
    return fr_req;
}

function getGrReq(){
    return group_req;
}


	/***** Login stuff - keep at bottom *****/
	function login(data) {
		if(user_id == -1) {
			var html = '<p>Please login:</p>';
			if(data == 0) {
				html += '<input type="text" name="username" id="username" placeholder="Username"/><p></p>';
				html += '<input type="password" name="password" id="password" placeholder="Password"/><br>';
				html += '<p class="invalid_credentials">Invalid credentials! Try agin</p>';
			} else {
				html += '<input type="text" name="username" id="username" placeholder="Username"/><p></p>';
				html += '<input type="password" name="password" id="password" placeholder="Password"/><br>';
			}
			html += '<br><button class="btn btn-success" id="login_button_1" onclick="checkCredentials();">Login</button>';
			html += '<br><br><button class="btn btn-success" id="register" onclick="registerNewUser();">Register</button>';

			$( "#login-modal" ).dialog({
			  height: 320,
			  width: 400,
			  modal: true
			});
			$( "#login-modal" ).dialog();
			$("#user_login").html(html);
		} else {
			getCompInfo(user_id);
		}
	}
	
	function checkCredentials() {
        console.log();
		var t_html = "Logging in...";
		var username = $("#username").val();
		var password = $("#password").val();
		$.ajax({
			type:"POST",
			url: "/CRUD/challenge_calendar/checkCredentials.php",
			data: {"un":username, "pw":password},
			datatype: "text",
			success: function(response) {
				console.log("Check credentials response: " +response);
				if(response == 0) {
					login(response);
				} else {
					$( "#login-modal" ).dialog('close');
					user_id = response;
					/*buildCalendarPage();
					renderCalendar(user_id, false);
					getNotifications(user_id);*/
					setUserIDCal(user_id);
				}
			}
		});
	}

	function parseURL(data) {
		var temp = data.toString();
		var retVal = -1;
		console.log(temp);
		if(temp.indexOf("=") > -1) {
			var id = temp.substring(temp.indexOf("=")+1);
			console.log(id);
			if(id.length > 0) {
				console.log(id);
				retVal = id;
			}
		}
		return retVal;
	}
	
	/* Sets the userID calendar login */
	function setUserIDCal(id) { 
		console.log("setUserIDCal");
		$.ajax({
			type: "POST",
			url: "/CRUD/challenge_calendar/getUserID.php",
			data: {"id":id, "where":"1"},
			dataType: "text",
			success: function(response) {
				user_id = response;
				buildCalendarPage();
				renderCalendar(response, false);
				getNotifications(response);
			}
		});
	}
	
	/* Sets the userID based on cbox login */
	function setUserIDCbox(id) { 
		console.log("setUserIDCbox");
		$.ajax({
			type: "POST",
			url: "/CRUD/challenge_calendar/getUserID.php",
			data: {"id":id, "where":"2"},
			dataType: "text",
			success: function(response) {
				user_id = response;
				buildCalendarPage();
				renderCalendar(response, false);
				getNotifications(response);
			}
		});
	}
	
	function clearInputs(s) {
		if(s == "woIn") {
			$(':input','#workout_descrip')
			 .not(':button, :submit, :reset, :hidden')
			 .val('')
			 .removeAttr('checked')
			 .removeAttr('selected');
		 } else if(s == "wolIn") {
			$(':input','#client_workout_descrip')
			 .not(':button, :submit, :reset, :hidden')
			 .val('')
			 .removeAttr('checked')
			 .removeAttr('selected');
		 }
	}

    function closeDialog(num) {
        if(num == 2){
            $("#repeat-workout-modal").dialog('close');
        }

    }

	</script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  /*TEST SERVER*/
  ga('create', 'UA-50665970-1', 'cboxbeta.com');
  
  /* LIVE SERVER */
  //ga('create', 'UA-50665970-2', 'compete-box.com');
  
  ga('send', 'pageview');

</script>
  </body>
</html>
	