/**
 * Created by APersinger on 11/04/14.
 */


function submitNewGroupPicture(id) {
    var temp = $("#picture")[0].files[0];
    console.log("SUBMIT NEW GROUP PICTURE");
    console.log(temp);
    var data = new FormData();
    data.append("upload", temp);
    data.append("id", id);

    $.ajax({
        type: "POST",
        url: "/CRUD/profiles/submitGroupPicture.php",
        data: data,
        dataType: "text",
        success: function(response) {
            console.log(response);
            if(response == '1') {
                alert("Successfully uploaded photo!");
                manageGroupPage(id);
            } else {
                alert("Failed to upload photo! Please contact administrator");
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function updateGroupLocation(id) {
    var location = $("#group_edit_location").val();
    //$("#user_email").val();
    $.ajax({
       type:"POST",
        url:"/CRUD/challenge_calendar/updateGroupLocation.php",
        data: {"id":id, "loc":location},
        dataType:"text",
        success: function(response) {
            console.log(response);
            if(response == '1') {
                alert("Successfully updated location!");
                manageGroupPage(id);
            } else {
                alert("Failed to update location! Please try again");
            }
        }
    });
}
