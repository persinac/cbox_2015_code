
function submitNewPicture(id) {
	var temp = $("#picture")[0].files[0];
	console.log(temp);
	var data = new FormData();
	data.append("upload", temp);
	data.append("id", id);
	console.log("ch_edit_user_prof id: " + id);
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/submitUserPicture.php",
		data: data,
		dataType: "text",
		success: function(response) { 
			console.log(response);
			if(response.indexOf("0") > -1) {
				alert("Error uploading photo, please refresh and try again");
			} else {
				alert("Successfully uploaded photo!");
			}
		},
		cache: false,
        contentType: false,
        processData: false
	});
}
/*
 ID: User id
*/
function submitUserEdit(value, id) {
	var data = "";
	if(value == 1) {
		data = $("#user_email").val();
	} else if(value == 2) {
		data = $("#user_city").val();
	} else if(value == 3) {
		data = $("#user_state").val();
	} else if(value == 4) {
		data = $("#user_bio").val();
	} else if(value == 5) {
		data = $("#user_fav_lift").val();
	} else if(value == 6) {
		data = $("#user_fav_exercise").val();
	}
	//console.log(id + ", " + data + ", " +value);
	$.ajax({
		type: "POST",
		url: "/CRUD/challenge_calendar/submitUserEdit.php",
		data: {"data":data,
				"field":value,
				"id":id},
		dataType: "text",
		success: function(response) { 
			console.log(response);
			if(response.indexOf("0") > -1) {
				alert("Error changing information, please refresh and try again");
			} else {
				alert("Successfully changed information!");
			}
		}
	});
}