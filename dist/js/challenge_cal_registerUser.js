/**
 * Created by APersinger on 03/02/15.
 */
function registerNewUser() {
    var html = '<p>Basics:</p>';
    html += '<form id="new_user">';
    html += '<input type="text" name="first_name" id="first_name" placeholder="First Name"/><p></p>';
    html += '<input type="text" name="last_name" id="last_name" placeholder="Last Name"/><p></p>';
    html += '<input type="text" name="email" id="email" placeholder="Email"/><p></p>';
    html += ' Gender: <select id="gender"><option value="M">Male</option>';
    html += '<option value="F">Female</option></select><br>';

    html += '<input type="text" name="city" id="city" placeholder="City"/><p></p>';
    html += '<input type="text" name="state" id="state" placeholder="State (2-letter code)"/><p></p>';

    html += '<p>Login:</p>';
    html += '<input type="text" name="username" id="username" placeholder="Username"/><p></p>';
    html += '<input type="password" name="password" id="password" placeholder="Password"/><br></form>';

    html += '<br><button class="btn btn-success" id="register_button_1" onclick="submitNewUser();">Submit</button>';
    html += '   <button class="btn btn-success" id="register" onclick="cancel_register();">Cancel</button>';

    $( "#register-modal" ).dialog({
        height: 320,
        width: 400,
        modal: true
    });
    $( "#register-modal" ).dialog();
    $("#register_new_user").html(html);
}

function submitNewUser() {
    var form_data = $("#new_user").serializeArray();
    var gender = $( "#gender option:selected" ).val();
    form_data.push({name:"gender", value:gender});

    $.ajax({
        type: "POST",
        url: "/CRUD/challenge_calendar/registerNewUser.php",
        data: form_data,
        dataType: "text",
        success: function(response) {
            console.log(response);
        }
    });

}

function cancel_register() {
    $( "#register-modal" ).dialog('close');
}