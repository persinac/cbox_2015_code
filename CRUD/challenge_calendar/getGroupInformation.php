<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 10/16/14
 * Time: 4:05 PM
 */
include('../../CRUD/library/friends.php');
include('../../CRUD/library/groups.php');

$group_id = $_POST['id'];
$manage = $_POST['manage'];

$group_util = new Group_Workouts();
/*
 * if manage == 0... the page is being managed by an admin
 * else... the page is being viewed
 */
$group_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
$group_util->BuildGroupDetails($group_id);
$final_html = "";
/*
$final_html = '<div class="row">';
$final_html .= '<div class="col-xs-1">SIDE BAR HERE</div>';
$final_html .= '</div>';
*/
$det = $group_util->GetGroupDetails();
$group_util->CloseConnection();
//echo var_dump($det);
$purl = "";
$creator = "";
$inception = "";
$location = "";
$numOfMems = "";
$bio = "";
$group_name = "";
$creator_id = -1;
foreach($det AS $key => $val) {
    $purl = $val->picture_url;
    $creator = $val->creator;
    $creator_id = $val->creator_id;
    $inception = $val->inception;
    $location = $val->location;
    $numOfMems = $val->numOfMems;
    $bio = $val->bio;
    $group_name = $val->group_name;
}
/* Group picture and info first */
$final_html .= '<div class="row">';
    $final_html .= '<div class="col-lg-5 "><img src="'.$purl.'" class="user_picture"/>';
    if($manage == 0) {
        $final_html .= '<input type="file" name="picture" id="picture" class="btn btn-primary btn-large"/><br>';
        //$final_html .= '<input type="button" value="Upload" onclick="submitNewGroupPicture(' . $group_id . ')" />';
        $final_html .= '<a onclick="submitNewGroupPicture(' . $group_id . ')" class="btn btn-primary btn-large">Upload</a>';
    }
    $final_html .= '</div>';
    $final_html .= '<div class="col-lg-7">';
        $final_html .= '<div class="row">';
            $final_html .= '<div class="col-lg-6">';
                $final_html .= '<p><h3>'.$creator.'</h3></p>';
                $final_html .= '<p><h3>'.$inception.'</h3></p>';
                $final_html .= '<p>';
                if($manage == 0) {
                    $final_html .= '<input type="text" id="group_edit_location" name="group_edit_location" value="'.$location.'" /><br>';
                    $final_html .= " <a onclick='updateGroupLocation($group_id)' class='btn btn-primary btn-large'>Update Location</a>";
                } else {
                    $final_html .= '<h3>'.$location.'</h3>';
                }
                $final_html.='</p>';
                $final_html .= '<p><h3>Number of members: '.$numOfMems.'</h3></p>';
            $final_html .= '</div>';
            $final_html .= '<div class="col-lg-6">' . $bio . '</div>';
        $final_html .= '</div>';
    $final_html .= '</div>';
$final_html .= '</div><br><br>';



/* Group workouts and challenges next */
if($manage == 0) {
    $final_html .= '<div class="row"><div class="col-lg-3">';
    $final_html .= " <a onclick='openNewGroupWorkout($group_id)' class='btn btn-primary btn-large'>Create New Workout</a><br><br>";
    $final_html .= " <a onclick='openNewGroupChallenge($group_id)' class='btn btn-primary btn-large'>Create New Challenge</a>";
    $final_html .= '</div>';
    $final_html .= '<div class="col-lg-9"><div class="row">';
}

$final_html .= '<div class="row border_ext wrkout_chal_size_control">';
$final_html .= '<div class="col-lg-6"><table id="list_of_workouts" class="table table-striped table-hover">';
$final_html .= '<thead><tr><th>Date of workout</th></tr></thead>';
$final_html .= '<tbody>';

$group_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
$temp = $group_util->BuildGroupWorkoutDates($group_id);
//echo "temp: " . $temp . "\n";
if($temp == 1) {
    $det = $group_util->GetGroupWorkoutDates();
    //echo var_dump($det);
    foreach($det AS $key => $val) {
        $final_html .= '<tr><td>' . $val->date;
        $final_html .= '</td></tr>';
        //$purl = $val->picture_url;
    }
}
$final_html .= '<tr></tr>';
$final_html .= '</tbody>';
$final_html .= '</table></div>';

$final_html .= '<div class="col-lg-6"><table id="list_of_challenges" class="table table-striped table-hover">';
$final_html .= '<thead><tr><th>Date of Challenge</th><th># of Participants</th></tr></thead>';
$final_html .= '<tbody><tr><td>2014-06-14</td><td>10</td></tr>';
$final_html .= '<tr><td>2014-11-07</td><td>6</td></tr>';
$final_html .= '<tr><td>2014-11-08</td><td>13</td></tr></tbody>';
$final_html .= '</table></div>';
$final_html .= '</div>';
if($manage == 0) {
    $final_html .= '</div></div></div><br>';
}

/* Group members last (as of now) */
$final_html .= '<div class="row"><h3>Members:</h3>';
if($manage == 0) {
    $final_html .= '<div class="col-lg-3">';
    $final_html .= " <a onclick='buildAddUserToGroup($group_id)' class='btn btn-primary btn-large'>Add Users</a>";
    $final_html .= '</div>';
    $final_html .= '<div class="col-lg-9"><div class="row">';
}
$group_util->mys->next_result();
$retval = $group_util->BuildMembersOfGroup($group_id);
//echo "VAL: $retval ... Group ID: $group_id\n";
if($retval == 1) {
    $det = $group_util->GetGroupMembers();
    foreach($det AS $key => $val) {
        $final_html .= "<div class=\"col-xs-12 individual_activity\">";
            $final_html .= "<div class=\"spec_activity\">";
                $final_html .= "<img src=\"".$val->picture_url."\" class=\"small_user_picture\"/> ";
                $final_html .= "<b>$val->user_name</b> ";
                $final_html .= "<b>Member Since: $val->join_date</b> ";
                if($creator_id != $val->user_id && $manage == 0) {
                    $final_html .= " <a onclick='removeUserFromGroup($group_id, $val->user_id)' class='btn btn-primary btn-large'>Remove User</a>";
                }
            $final_html .= "</div> <!-- END spec_activity -->";
        $final_html .= "</div> <!-- END individual_activity --><p></p>";
    }
}
if($manage == 0) {
    $final_html .= '</div></div>';
}
$final_html .= '</div>';
$group_util->CloseConnection();
echo $final_html;
