
function sendMessage(id) {
	var message = $("#usr_msg_brd_input").val();
	//console.log(id + ", " + message.substring(0, 40));
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/submitToMessageBoard.php",
		data: {"id":id, "message":message},
		dataType: "text",
		success: function(response) {
			console.log(response);
			$(':input','#usr_msg_brd_input')
			 .not(':button, :submit, :reset, :hidden')
			 .val('')
			 .removeAttr('checked')
			 .removeAttr('selected');
		}
	});
}


function filter() {
	var selected = [];
	$('.activity_feed_options input:checked').each(function() {
		selected.push({"name":"option", "value":$(this).attr('value')});
	});
	var curr_text = "";
	var curr_id = -1;
	$(".individual_activity").each(function() {
		curr_text = $(this).find(".spec_activity").text();
		curr_id = $(this).find(".spec_activity").attr("id");
		$.each(selected, function(i, field) {
			console.log(i + ", " + field.name + ", " +field.value);
				if(curr_text.indexOf(field.value) > -1) {
				console.log("REMOVE: "+curr_text + ", " + curr_id);
				$("#"+curr_id+"").hide();
			}
		});
	});
}
/*
    @param id: either 1 or 2 as of now
        1 - friend request
        2 - group request
 */
function propogateNotification(id) {
    if(id == 1) {
        $("#nav_browse").addClass('notification');
        setFrReq(1);
    } else if(id == 2) {
        $("#nav_browse").addClass('notification');
        setGrReq(1);
    }
}

function propogateChallengeNotification(data, value) {
	var count = 0;
	for(var i = 0; i < data.length; i++) {
		console.log(data[i].challenge_id + ", " + data[i].given + ", " + data[i].received );
		if(data[i].given > 0 || data[i].received > 0) {
			count++;
			$("#nav_challenges").addClass('notification');
			if(value == 1) {
				$("#challenge_"+data[i].challenge_id+"").addClass('notification');
			}
		}
	}
	if(count < 1) {
		$("#nav_challenges").removeClass('notification');
	}
}

function markAsRead(c_id, u_id) {
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/userReadChallenge.php",
		data: {"cid":c_id, "uid":u_id},
		dataType: "text",
		success: function(response) {
			console.log("user has read the challenge");
		}
	});
}

function markFrAsRead(u_id) {
    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/userReadFriendRequest.php",
        data: {"uid":u_id},
        dataType: "text",
        success: function(response) {
            console.log("user has seen all friend requests");
            $('#tab_fr_req').removeClass('notification');
            $('#nav_browse').removeClass('notification');
            setFrReq(-1);
        }
    });
}

function markGrAsRead(u_id) {
    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/userReadGroupRequest.php",
        data: {"uid":u_id},
        dataType: "text",
        success: function(response) {
            console.log("user has seen all group requests");
            setGrReq(-1);
        }
    });
}

function selectUsersForChallenge() {
	var selected = "";
	$('.checkbox_select input:checked').each(function() {
		selected += $(this).attr('value') + ",";
	});
	console.log(selected.substring(0,selected.length-1));
	return selected.substring(0,selected.length-1);
}

function selectUsersForGroupInvite() {
    var selected = "";
    $('.grp_inv input:checked').each(function() {
        selected += $(this).attr('value') + ",";
    });
    //console.log(selected.substring(0,selected.length-1));
    return selected.substring(0,selected.length-1);
}

/*
 * params:
 *	id: w_<x>, str_<x>, con_<x>, spe_<x>, core_<x>, rest_<x>
 *	date: date
 *	uid: User_id
 *
 */
function nextWorkoutType(id, date, uid, other_id) {
	var t_date = date;
	var column = "";
	var rank = "";
	var bool_val = false;
	
	var nextColumn = "";
	var nextRank = 1;
	if(other_id > 0) {
		uid = other_id
	}
	//for some reason, there exist ID's that just have '1' ...
	// until I find where those ID's are coming from, just ensure 
	// that the length is greater than 2
	if(id.length > 2) {
		column = id.substring(0,id.indexOf("_"));
		rank = id.substring(id.indexOf("_")+1, id.length);
		console.log(column + ", " + rank + ", " + t_date);
		//send variables to PHP
		$.ajax({ 
			type: "POST",
			url: "/CRUD/challenge_calendar/getNextWorkoutType.php",
			data: {"col":column,"rank":rank,"date":t_date,"uid":uid},
			dataType: "text",
			success: function(response) {
				var parsedJSON = JSON.parse(response);
				console.log(parsedJSON.id + "\n" + parsedJSON.title + "\n" + parsedJSON.info + "\n" + parsedJSON.date);
				$("#dialog-modal").dialog("close");
				openModal(parsedJSON.title, parsedJSON.info, -1, -1, -1, parsedJSON.date, parsedJSON.id);
			}
		});
	}
	
}

/*
 * params:
 *	id: w_<x>, str_<x>, con_<x>, spe_<x>, core_<x>, rest_<x>
 *	date: date
 *	uid: User_id
 *
 */
function prevWorkoutType(id, date, uid, other_id) {
	var t_date = date;
	var column = "";
	var rank = "";
	var bool_val = false;
	if(other_id > 0) {
		uid = other_id
	}
	var nextColumn = "";
	var nextRank = 1;
	if(id.length > 2) {
		column = id.substring(0,id.indexOf("_"));
		rank = id.substring(id.indexOf("_")+1, id.length);
		console.log(column + ", " + rank + ", " + t_date);
		$.ajax({ 
			type: "POST",
			url: "/CRUD/challenge_calendar/getPrevWorkoutType.php",
			data: {"col":column,"rank":rank,"date":t_date,"uid":uid},
			dataType: "text",
			success: function(response) {
				console.log(response);
				var parsedJSON = JSON.parse(response);
				console.log(parsedJSON.id + "\n" + parsedJSON.title + "\n" + parsedJSON.info + "\n" + parsedJSON.date);
				$("#dialog-modal").dialog("close");
				openModal(parsedJSON.title, parsedJSON.info, -1, -1, -1, parsedJSON.date, parsedJSON.id);
			}
		});
	}
}

function nextDayWorkout(id, date, uid, other_id) {
	var rank = 1;
	//console.log("NEXTDAY: " + date);
    if(other_id > 0) {
		uid = other_id
	}
	$.ajax({ 
		type: "POST",
		url: "/CRUD/challenge_calendar/getNextDayWorkout.php",
		data: {"date":date,"rank":rank,"uid":uid},
		dataType: "text",
		success: function(response) {
			console.log(response);
			var parsedJSON = JSON.parse(response);
			console.log(parsedJSON.id + "\n" + parsedJSON.title + "\n" + parsedJSON.info + "\n" + parsedJSON.date);
			$("#dialog-modal").dialog("close");
			openModal(parsedJSON.title, parsedJSON.info, -1, -1, -1, parsedJSON.date, parsedJSON.id);
		}
	});
}

function previousDayWorkout(id, date, uid, other_id) {
	var rank = 1;
	if(other_id > 0) {
		uid = other_id
	}
	$.ajax({ 
		type: "POST",
		url: "/CRUD/challenge_calendar/getPrevDayWorkout.php",
		data: {"date":date,"rank":rank,"uid":uid},
		dataType: "text",
		success: function(response) {
			console.log(response);
			var parsedJSON = JSON.parse(response);
			console.log(parsedJSON.id + "\n" + parsedJSON.title + "\n" + parsedJSON.info + "\n" + parsedJSON.date);
			$("#dialog-modal").dialog("close");
			openModal(parsedJSON.title, parsedJSON.info, -1, -1, -1, parsedJSON.date, parsedJSON.id);
		}
	});
}

function repeatWorkout(oldDate, uid, wid) {
	var column = "";
	var rank = "";
	var newDate = $("#date_repeat").val();
	console.log(uid +", "+ wid);
	column = wid.substring(0,wid.indexOf("_"));
	rank = wid.substring(wid.indexOf("_")+1, wid.length);
	console.log(column + ", " + rank + ", " + oldDate);
	$.ajax({ 
		type: "POST",
		url: "/CRUD/challenge_calendar/repeatWorkout.php",
		data: {"oldDate":oldDate,
			"newDate":newDate,
			"uid":uid,
			"w":column,
			"wid":rank
		},
		dataType: "text",
		success: function(response) {
			console.log(response);
			$("#repeat-workout-modal").dialog('close');
			$("#repeatcontent").empty();
			if(response == "1") {
				alert("Successfully repeated workout " + oldDate + " on " + newDate);
				$("#dialog-modal").dialog('close');
				$('#calendar').fullCalendar('refetchEvents');
			} else {
                alert("Could not replace workout on " + oldDate + " with " + newDate);
            }
		}
	});
}

function acceptFriendRequest(user_id, friend_id) {
    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/acceptFriendRequest.php",
        data: {"user_id":user_id,"fr_id":friend_id},
        dataType: "text",
        success: function(response) {
            console.log(response);
            if(response == 1) {
                alert("Friend Accepted");
                getUsers(user_id);
            } else {
                alert("Error!");
            }
        }
    });
}

function declineFriendRequest(user_id, friend_id) {
     $.ajax({
         type: "POST",
         url: "/CRUD/challenge_calendar/declineFriendRequest.php",
         data: {"user_id":user_id,"fr_id":friend_id},
         dataType: "text",
         success: function(response) {
            console.log(response);
             if(response == 1) {
                 alert("'Friend' Declined - they'll never know");
                 getUsers(user_id);
             } else {
                 alert("Error!");
             }
         }
     });
}

function sendFriendRequest(user_id, friend_id) {
    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/sendFriendRequest.php",
        data: {"user_id":user_id,"fr_id":friend_id},
        dataType: "text",
        success: function(response) {
            console.log(response);
            if(response == 1) {
                alert("Friend request sent");
                getUsers(user_id);
            } else {
                alert("Error!");
            }
        }
    });
}

function createGroup(user_id) {
    var form_data = $("#create_new_group").serializeArray();
    form_data.push({name:"user_id", value:user_id});

    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/createGroup.php",
        data: form_data,
        dataType: "text",
        success: function(response) {
            console.log(response);
            if(response == 2) {
                alert("Group created! Now go to Social->Groups->(Your Group Name) to manage your group!");
                getUsers(user_id);
            } else {
                alert("Error creating group!");
            }
        }
    });
}

function acceptGroupRequest(user_id, group_id) {
    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/acceptGroupRequest.php",
        data: {"user_id":user_id,"gr_id":group_id},
        dataType: "text",
        success: function(response) {
            console.log(response);
            if(response == 1) {
                alert("Joined group!");
                getUsers(user_id);
            } else {
                alert("Error!");
            }
        }
    });
}

function declineGroupRequest(user_id, group_id) {
    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/declineGroupRequest.php",
        data: {"user_id":user_id,"gr_id":group_id},
        dataType: "text",
        success: function(response) {
            console.log(response);
            if(response == 1) {
                alert("Group request ignored");
                getUsers(user_id);
            } else {
                alert("Error!");
            }
        }
    });
}

function notYetImplemented() {
	alert("This function is not yet implemented!");
}

function editGoal(gid) {
	$( "#goals_modal" ).dialog({
		height: 600,
		width: 900,
		modal: true
	});
	//$("#goal_create_date").datepick('destroy');
	$("#goal_targ_date").datepick('destroy');
	$("#goal_comp_date").datepick('destroy');
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/editGoal.php",
		data: {"gid":gid},
		dataType: "json",
		success: function(response) {
			//console.log(response);
			var json = response;
			title = json["title"];
			html = json["html"].replace(/\\/g, '');
			$( "#goals_modal" ).dialog('option', 'title', title);
			$("#goal_content").html(html);

			$("#goal_targ_date").datepick({
				dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
			});
			$("#goal_comp_date").datepick({
				dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true
			});
		}
	});

}

function deleteGoal(gid) {
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/deleteGoal.php",
		data: {"gid":gid},
		dataType: "text",
		success: function(response) {
			console.log(response);
			if(response == 1) {
				alert("Successfully deleted!");
				buildGoals(-1)
			} else {
				alert("Failed to delete!");
			}
		}
	});
}

function addGoal() {
	$( "#goals_modal" ).dialog({
		height: 600,
		width: 900,
		modal: true
	});

	var title = "New Goal";
	var html = "";
	var id = -1;
	html += '<form id="new_goal">';
	html += 'Created on: <input type="text" name="goal_create_date" id="goal_create_date">';
	html += '<p></p>Target Completion: <input type="text" name="goal_targ_date" id="goal_targ_date">';
	html += '<p></p>Actual Completion: <input type="text" name="goal_comp_date" id="goal_comp_date">';
	html += '<p></p>Goal: <p></p><textarea rows="4" cols="100" id="goal_act_goal" name="goal_act_goal">';
	html += '</textarea>';
	html += 'Current (where are you at now?): <p></p><textarea rows="4" cols="100" id="goal_current" name="goal_current">';
	html += '</textarea></form>';
	html += '<a onclick="submitGoal(' + id + ')" class="btn btn-primary btn-large" > Submit Goal </a>';


	$( "#goals_modal" ).dialog('option', 'title', title);
	$("#goal_content").html(html);

	$("#goal_create_date").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: true, autoSize: true
	});

	$("#goal_targ_date").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: true, autoSize: true
	});
	$("#goal_comp_date").datepick({
		dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: true, autoSize: true
	});

}

/**
 *
 * @param id - Goal ID, if -1, then insert
 */
function submitGoal(id) {
	console.log(id);

	var url = "";
	if(id == -1) {
		url  = "/CRUD/challenge_calendar/submitNewGoal.php";
		var t_arr = $("#new_goal").serializeArray();
		t_arr.push({"gid":id});
	} else {
		url  = "/CRUD/challenge_calendar/submitGoalUpdate.php";
		var t_arr = $("#update_goal").serializeArray();
		t_arr.push({"name":"gid", "value":id});
	}
	$.ajax({
		type: "POST",
		url: url,
		data: t_arr,
		dataType: "text",
		success: function(response) {
			console.log(response);
			if(response == 1) {
				alert("Successfully updated!");
				buildGoals(-1)
			} else {
				alert("Failed to update!");
			}
			$( "#goals_modal" ).dialog('close');
		}
	});
}