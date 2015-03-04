<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
include('../../CRUD/library/friends.php');
include('../../CRUD/library/groups.php');
session_start();
$friend_util = new Friends();
$group_util = new Groups();
$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$user_id = $_POST['user_id'];


$final_html = '<div id="tabs" class="tabs tab-width-custom">';
$unorderedList = '<ul class="tab-links tab-links-custom">';

$tabs = "";
$divisions = "";

$tabs .= '<li class="active"><a href="#tab1">All Users</a></li>';
$tabs .= '<li><a href="#tab2">Friends</a></li>';
$tabs .= '<li><a href="#tab3">Groups</a></li>';
$tabs .= '<li id="tab_fr_req"><a href="#tab4">Friend Requests</a></li>';
$tabs .= '<li id="tab_gr_req"><a href="#tab5">Group Requests</a></li>';
$final_html .= $unorderedList . $tabs . '</ul> <!-- END UL -->';

$tab_content = '<div class="tab-content tab-content-custom">';

$tab_content_1 = '';
$tab_content_1 = '<div id="tab1" class="tab active">';

$query = "call getUsers($user_id);";
$challenge_win_count = 0;
if($stmt = $mysqli->prepare($query)) 
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($uid, $fn, $ln, $ge, $loc, $ms, $purl, $is_friend);
		/*
		 * First while loop is getting users
		 */
		while ($stmt->fetch()) {
			$query2 = 'call getUserAcceptedChallenges('.$uid.');';
			$mysqli->next_result();
			if($stmt2 = $mysqli->prepare($query2)) 
			{
				$stmt2->execute();
				$stmt2->store_result();
				$num_of_rows2 = $stmt2->num_rows;
				if($num_of_rows2 > 0) {
					$stmt2->bind_result($chal_id);
					/*
					 * Second while loop is getting each users' accepted challenges
					 * num_of_rows2 = num of accepted challenges
					 */
					while ($stmt2->fetch()) {
						$query3 = 'call getChallengeWinners('.$chal_id.');';
						$mysqli->next_result();
						if($stmt3 = $mysqli->prepare($query3)) 
						{
							$stmt3->execute();
							$stmt3->store_result();
							$num_of_rows3 = $stmt3->num_rows;
							if($num_of_rows3 > 0) {
								$stmt3->bind_result($challenge_id, $challengee_id, $score, $rank);
								/*
								 * Third while loop is getting the winners of the accepted challenges
								 */
								while ($stmt3->fetch()) {
									if($uid == $challengee_id) {
										$challenge_win_count++;
									}
								}
							}
						} else {
							echo "getChallengeWinners failed: " . $mysqli->error;
						}
					}
				}
			} else {
				echo "getUserAcceptedChallenges failed: " . $mysqli->error;
			}
			
			//echo "$uid, $fn, $ln, $ge, $loc, $ms, $purl\n";
			//echo "Challenges Accepted: $num_of_rows2\n";
			//echo "Challenges Won: $challenge_win_count\n\n";
			$tab_content_1 .= "<div class=\"user_information\">";
			$tab_content_1 .= "<h3>".$fn." ".$ln."</h3>";
			$tab_content_1 .= "<img src=\"".$purl."\" class=\"user_picture user-picture-ext\">";
			$tab_content_1 .= "<div id=\"basic_user_info\" class=\"user_description\">";
			$tab_content_1 .= "<p><span class=\"user_info_header\">Location:</span>".$loc."</p>";
			$tab_content_1 .= "<p><span class=\"user_info_header\">Member Since:</span>$ms</p>";
            if($user_id != $uid && $is_friend == 0) {
                $tab_content_1 .= "<p><a onclick='sendFriendRequest($user_id, $uid)' class='btn btn-primary btn-large'>Add Friend</a></p>";
            }
			$tab_content_1 .= "<p><a onclick='viewProfile($uid, \"$fn\")' class='btn btn-primary btn-large'>View Profile</a></p>";
			$tab_content_1 .= "</div>";
			$tab_content_1 .= "<div id=\"basic_user_bench\" class=\"user_description\">";
			$tab_content_1 .= "<p><span class=\"user_info_header\">Challenges Accepted:</span>$num_of_rows2</p>";
			$tab_content_1 .= "<p><span class=\"user_info_header\">Challenges Won:</span>$challenge_win_count</p>";
			$tab_content_1 .= "<p><a onclick='viewCalendar($uid, \"$fn\")' class='btn btn-primary btn-large'>View Calendar</a></p>";
			$tab_content_1 .= "</div>";
			$tab_content_1 .= "</div>";
			$tab_content_1 .= "<p style=\"clear: both;\">";
			$challenge_win_count = 0;
		}
	}
}

$tab_content_1 .= '</div>';

$friend_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
$tab_content_2 = '';
$tab_content_2 = '<div id="tab2" class="tab">';
$tab_content_2 .= '<p><b>';
if($friend_util->BuildFriends($user_id) == 1) {
    $det = $friend_util->GetFriends();
    foreach($det AS $key => $val){
        $tab_content_2 .= '';
        $tab_content_2 .= "<div class=\"individual_activity\">";
        $tab_content_2 .= "<div id=\"$count\" class=\"spec_activity\"><img src=\"".$val->picture_url."\" class=\"small_user_picture\" />";
        $tab_content_2 .= "<b>$val->name</b> ";
        $tab_content_2 .= "<p id=\"fr_btn_\"><a onclick='viewProfile($val->friend_id)' class='btn btn-primary btn-large'>View Profile</a></p>";
        $tab_content_2 .= "<p id=\"fr_btn_\"><a onclick='viewCalendar($val->friend_id, \"$val->name\")' class='btn btn-primary btn-large'>View Calendar</a></p>";
        $tab_content_2 .= "</div> <!-- END TAB 2 spec_activity -->";
        $tab_content_2 .= "</div> <!-- END TAB 2 individual_activity --><p></p>";
    }
} else {
    echo "Could not retrieve friends";
}
$tab_content_2 .= '</b></p>';
$tab_content_2 .= '</div> <!-- END TAB 2 -->';

$group_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
$tab_content_3 = '';
$tab_content_3 .= '<div id="tab3" class="tab">';
$tab_content_3 .= '<p></p>';
if($group_util->BuildGroups($user_id) == 1) {
    $det = $group_util->GetGroups();
    foreach($det AS $key => $val){
        $tab_content_3 .= '';
        $tab_content_3 .= "<div class=\"individual_activity\">";
        $tab_content_3 .= "<div id=\"$count\" class=\"spec_activity\"><img src=\"".$val->picture_url."\" class=\"small_user_picture\"/> ";
        $tab_content_3 .= "<b>$val->group_name</b> ";
        $tab_content_3 .= "<p>Admin: $val->creator_name </p>";
        $temp_id = $val->group_id;
        $tab_content_3 .= "<p id=\"gr_btn_\"><a onclick='viewGroupPage($temp_id)' class='btn btn-primary btn-large'>View Group Page</a></p>";
        if(trim($val->creator_id) == trim($user_id)) {
            //echo $val->creator_id .", ". $user_id . ", ". $val->group_id ."?\n";
            $tab_content_3 .= "<p id=\"gr_btn_\"><a onclick='manageGroupPage($temp_id)' class='btn btn-primary btn-large'>Manage Group Page</a></p>";
        }
        $tab_content_3 .= "</div> <!-- END spec_activity -->";
        $tab_content_3 .= "</div> <!-- END individual_activity --><p></p>";
    }
} else {
    echo "Could not retrieve groups";
}
$tab_content_3 .= "<p id=\"fr_btn_\"><a onclick='openCreateGroup()' class='btn btn-primary btn-large'>Create a Group</a>";
$tab_content_3 .= "  <a onclick='browseGroups()' class='btn btn-primary btn-large'>Browse All Groups</a></p>";
$tab_content_3 .= '</div>';

$tab_content_4 = '';
$tab_content_4 = '<div id="tab4" class="tab">';
$tab_content_4 .= '<p><b>';
if($friend_util->BuildFriendRequests($user_id) == 1) {
    $det = $friend_util->GetFriendRequests();
    if(sizeof($det) < 1) {
        $tab_content_4 .= '<p><b>No Friend requests</b></p>';
    } else {
        foreach ($det AS $key => $val) {
            $tab_content_4 .= '';
            $tab_content_4 .= "<div class=\"individual_activity\"><div id=\"$count\" class=\"spec_activity\"><img src=\"" . $val->picture_url . "\" class=\"small_user_picture\"/> ";
            $tab_content_4 .= "<b>$val->name</b> ";
            $tab_content_4 .= "<p id=\"fr_btn_\"><a onclick='acceptFriendRequest($user_id, $val->user_id)' class='btn btn-primary btn-large'>Accept Friend Request</a></p>";
            $tab_content_4 .= "<p id=\"fr_btn_\"><a onclick='declineFriendRequest($user_id, $val->user_id)' class='btn btn-primary btn-large'>Decline Friend Request</a></p>";
            $tab_content_4 .= "</div></div><p></p>";
        }
    }
} else {
    echo "Could not get friend requests";
}
$tab_content_4 .= '</b></p>';
$tab_content_4 .= '</div>';


$tab_content_5 = '';
$tab_content_5 = '<div id="tab5" class="tab">';
if($group_util->BuildGroupRequests($user_id) == 1) {
    $det = $group_util->GetGroupRequests();
    if(sizeof($det) < 1) {
        $tab_content_5 .= '<p><b>No group requests</b></p>';
    } else {
        foreach ($det AS $key => $val) {
            $tab_content_5 .= '';
            $tab_content_5 .= "<div class=\"individual_activity\"><div id=\"$count\" class=\"spec_activity\"><img src=\"" . $val->picture_url . "\" class=\"small_user_picture\"/> ";
            $tab_content_5 .= "<b>$val->group_name</b> ";
            $tab_content_5 .= "<p id=\"fr_btn_\"><a onclick='acceptGroupRequest($user_id, $val->group_id)' class='btn btn-primary btn-large'>Accept Group Request</a></p>";
            $tab_content_5 .= "<p id=\"fr_btn_\"><a onclick='declineGroupRequest($user_id, $val->group_id)' class='btn btn-primary btn-large'>Ignore Group Request</a></p>";
            $tab_content_5 .= "</div></div><p></p>";
        }
    }
} else {
    echo "Could not get group requests";
}
$tab_content_5 .= '</div>';

$group_util->CloseConnection();
$friend_util->CloseConnection();
$tab_content .= $tab_content_1 . $tab_content_2 . $tab_content_3 . $tab_content_4 . $tab_content_5;// . $tab_content_x . $tab_content_y;

$tab_content .= '</div>';

$final_html .= $tab_content . '</div>';
echo $final_html;
$mysqli->close();
?>