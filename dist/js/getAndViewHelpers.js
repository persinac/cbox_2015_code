
function getWorkoutDetailsForUpdate(id) {
	var date = $("#date").val();
	console.log(date);
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/getWorkoutDetailsForUpdate.php",
		data: {"id":id, "date":date},
		dataType: "html",
		success: function(response) {
			console.log(response);
			$("#upd_btn_get_wod").hide();
			$("#workout_descrip").append(response);
		}
	});
}

function getUsers(user_id) {
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/getUsers.php",
        data: {"user_id":user_id},
		dataType: "text",
		success: function(response) { 
			//console.log(response);
			$("#dyn_content").html(response);
            if(getFrReq() > 0) {
                $("#tab_fr_req").addClass("notification");
            }
            if(getGrReq() > 0) {
                $("#tab_gr_req").addClass("notification");
            }
		}
	});
}

function getMessageboard() {
	
	$.ajax({
		type: "GET",
		url: "/CRUD/challenge_calendar/getMessageBoard.php",
		dataType: "text",
		success: function(response) {
			console.log(response);
			$("#message_board").html(response);
		}
	});
}

function getActivityFeed() {
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/getActivityFeed.php",
		dataType: "html",
		success: function(response) {
			console.log(response);
			$("#activity_feed").html(response);
			filter();
		}
	});
}

/* @param id: User id */
function getChallengeNotifications(id, value) {
	console.log("getChallengeNotifications: " + id);
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/getChallengeNotifications.php",
		data: {"id":id},
		dataType: "json",
		success: function(response) {
			console.log("RESPONSE getChallengeNotifications: "+response);
			propogateChallengeNotification(response, value);
			//$("#activity_feed").html(response);
		}
	});
}

function getUsersToBrowseForChallenge(id) { 
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/getUsersToBrowseForChallenge.php",
		data: {"id":id},
		dataType: "html",
		success: function(response) { 
			console.log(response);
			$("#challengees").html(response);
		}
	});
}

/****************************** VIEW METHODS ******************************/
function viewProfile(id) {
	
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/getUserInformation.php",
		data: {"id":id, "public":"public"},
		dataType: "html",
		success: function(response) {
			$("#dyn_content").html(response);
		}
	});

}

function viewCalendar(id, name) {
	var html = "<h3>"+name+"'s Calendar</h3>";
	
	html += '<div id="calendar"></div><div id="eventContent" title="Event Details">';
	html += '<div id="eventInfo"></div></div>';
	$("#dyn_content").html(html);
	renderCalendar(id, true);
}

function viewGroupPage(group_id) {

    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/getGroupInformation.php",
        data: {"id":group_id, "manage": 1},
        dataType: "html",
        success: function(response) {
            $("#dyn_content").html(response);
        }
    });
}

/*
    Users fires this function off by clicking on the Workout Details
    button in the GroupWorkoutView in Calendar.

    params:
        @workout_id: the workout ID of the workout details to be viewed
        @date: needed to grab the correct workout
 */
function viewGroupWorkoutDetails(workout_id ,date) {
    //let's go ahead and parse the workout_id on the client side
    var group_id = workout_id.substring(1, workout_id.indexOf("_"))
    var wid = workout_id.substring(workout_id.indexOf("_") + 1);

    console.log("group: " + group_id + ", wid: " + wid);

    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/getGroupWorkoutDetails.php",
        data: {"group_id":group_id, "wid":wid, "date": date},
        dataType: "html",
        success: function(response) {
            $("#dialog-modal").dialog('close');
            $("#dyn_content").html(response);
        }
    });
}

function manageGroupPage(group_id) {

    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/getGroupInformation.php",
        data: {"id":group_id, "manage": 0},
        dataType: "html",
        success: function(response) {
            $("#dyn_content").html(response);
        }
    });
}

function buildAddUserToGroup(group_id) {
    //first, get users
    getUsersToBrowseForGroupAdd(group_id)
    var infoBuild = "";
    for(var i = 0; i< 100; i++) {
        //infoBuild += '<div class="col-lg-4">Person '+i+'</div>';
    }

    //$('#users-to-add').html(infoBuild);

    infoBuild = '<div class="btn-group btn-group-justified">';
    infoBuild += '<div class="btn-group"><button type="button" onclick="inviteUsersToGroup('+group_id+')" class="btn btn-default btn-lg">';
    infoBuild += 'Invite Selected Users</button></div>';
    infoBuild += '</div>';
    $('#users-to-add-footer').html(infoBuild);
    openAddUserToGroup("Invite Users to Group", group_id);
}

function getUsersToBrowseForGroupAdd(group_id) {

    $.ajax({
        type:"POST",
        url:"/CRUD/challenge_calendar/getUsersToBrowseForGroupAdd.php",
        data:{"group_id":group_id},
        dataType: "html",
        success: function(response) {
            console.log(response);
            $('#users-to-add').html(response);
        }
    });
}

function openAddUserToGroup(title, group_id) {
    $("#add-user-to-group-modal").dialog({
        height: 600,
        width: 600,
        modal: true
    });
    $("#add-user-to-group-modal").dialog('option', 'title', title);
}

function inviteUsersToGroup(group_id) {
    var user_ids = selectUsersForGroupInvite();
    console.log(user_ids);
    $.ajax({
        type:"POST",
        url:"/CRUD/challenge_calendar/inviteUsersToGroup.php",
        data:{"group_id":group_id, "user_ids":user_ids},
        dataType: "text",
        success: function(response) {
            //console.log("RESPONSE: "+response);
            var success = true;
            var temp = response.split(",");
            for(var i = 0; i < temp.length - 1; i++) {
                //console.log("temp["+i+"]: "+temp[i]);
                if(temp[i] != 1) {
                    success = false;
                }
            }
            //console.log(success);
            if(success == true) {
                alert("Invitations sent!");
                $("#add-user-to-group-modal").dialog('close');
            } else {
                alert("Invitations failed, please try again!");
            }
        }
    });
}

/*
    @params
        id: user id to check if has friend notifications
 */
function getFriendNotifications(id) {
    console.log("getFriendNotifications: " + id);
    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/getFriendNotifications.php",
        data: {"id":id},
        dataType: "json",
        success: function(response) {
            console.log("RESPONSE getFriendNotifications: "+response);
            if(response == 1) { propogateNotification(1); }
            //$("#activity_feed").html(response);
        }
    });
}

/*
    @params
        id: user id to check if has group notifications
 */
function getGroupNotifications(id) {
    console.log("getGroupNotifications: " + id);
    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/getGroupNotifications.php",
        data: {"id":id},
        dataType: "json",
        success: function(response) {
            console.log("RESPONSE getGroupNotifications: "+response);
            if(response == 1) { propogateNotification(2); }
            //$("#activity_feed").html(response);
        }
    });
}

function openNewGroupWorkout(group_id) {
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
    html += '<h3>Mobility</h3><textarea rows="4" cols="100" id="mob" name="mob"></textarea><p></p>';
    html += '</form>';
    html += '<a onclick="submitGroupWorkout('+group_id+')" class="btn btn-primary btn-large" id="new_core_button" class="buttons_in_but_container">Create</a>';

    $( "#dialog-modal" ).dialog('option', 'title', title);
    $('#workoutcontent').html(html);

    $("#date").datepick({
        dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
    });
}

function openNewGroupChallenge(group_id) {

}

function submitGroupWorkout(group_id) {
    try {
        $("#repeat-workout-modal").dialog('close');
    } catch (err) {
        console.log("Repeat workout modal not open");
    }

    var c_date = $("#date").val();
    $("#date").datepick('destroy');
    if(c_date.length > 0) {
        var form_data = $("#workout_descrip").serializeArray();
        var runningTotal = 0;
        form_data.push({name:"gid", value:group_id});
        $.each(form_data, function(i, field) {
            if(field.name != "date") {
                if(field.name != "gid") {
                    runningTotal += field.value.length;
                }
                //field.value = replaceSemiColon(field.value);
            }
        });
        if(runningTotal > 15) {
            $.ajax(
                {
                    type:"POST",
                    url:"/CRUD/challenge_calendar/insertGroupWorkout.php",
                    data: form_data,
                    dataType: "text",
                    success: function(response) {
                        console.log(response);
                        if(response == "99") {
                            console.log("GetMaxWorkoutID didn't execute correctly");
                        } else if(response == "-1") {
                            console.log("InsertWorkout didn't execute");
                        } else if(response == "0") {
                            console.log("InsertWorkout executed but encountered an error");
                        } else if(response == "1") {
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

function buildGoals(user_id) {
    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/getUserGoals.php",
        data: {"user_id":user_id},
        dataType: "html",
        success: function(response) {
            //console.log("RESPONSE getUserGoals: "+response);
            $("#dyn_content").html(response)
        }
    });
}