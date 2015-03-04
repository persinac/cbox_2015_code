
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

function propogateChallengeNotification(data, value) {
	for(var i = 0; i < data.length; i++) {
		console.log(data[i].challenge_id + ", " + data[i].given + ", " + data[i].received );
		if(data[i].given > 0 || data[i].received > 0) {
			$("#nav_challenges").addClass('notification');
			if(value == 1) {
				$("#challenge_"+data[i].challenge_id+"").addClass('notification');
			}
		}
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

function notYetImplemented() {
	alert("This function is not yet implemented!");
}