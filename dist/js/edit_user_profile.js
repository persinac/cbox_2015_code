
function submitNewPicture() {
	var temp = $("#picture")[0].files[0];
	console.log(temp);
	var data = new FormData();
	data.append("upload", temp);
	
	$.ajax({
		type: "POST",
		url: "/CRUD/profiles/submitUserPicture.php",
		data: data,
		dataType: "text",
		success: function(response) { 
			console.log(response);
			//alert("Allo!!");
		},
		cache: false,
        contentType: false,
        processData: false
	});
}

function submitUserEdit(value) {
	var data = "";
	if(value == 1) {
		data = $("#user_reg").val();
	} else if(value == 2) {
		data = $("#user_cf_exp").val();
	} else if(value == 3) {
		data = $("#user_fav_lift").val();
	} else if(value == 4) {
		data = $("#user_fav_girl").val();
	} else if(value == 5) {
		data = $("#user_fav_hero").val();
	} else if(value == 6) {
		data = $("#user_fav_mvmt").val();
	}
	
	$.ajax({
		type: "POST",
		url: "/CRUD/profiles/submitUserEdit.php",
		data: {"data":data,
				"value":value},
		dataType: "text",
		success: function(response) { 
			console.log(response);
		}
	});
}
/*
function submitNewExp(data) {
	
}

function submitNewLift(data) {
	
}

function submitNewGirl(data) {
	
}

function submitNewHero(data) {
	
}

function submitNewMvmt(data) {
	
}
*/