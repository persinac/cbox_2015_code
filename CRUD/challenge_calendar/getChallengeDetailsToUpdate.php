<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$user_id = $_POST['id'];
//$user_id = $_SESSION["MM_user_id"];
$today = date('Y-m-d'); 
 
$html = "";
$score_by = "0";
$order_by = " ORDER BY score ";
$challenger_id = -1;
$query = "select * from challenge_table where challenge_id = $user_id";
//echo "QUERY1: " . $query . "\nID: $user_id\n";
if ($result2 = $mysqli->query($query)) {
    while ($row = $result2->fetch_assoc()) {
		$chal_start_date = $row['start_date'];
		if($today <= $chal_start_date) {
			$html = '<h4>Basics</h4><input type="text" name="chall_title" id="chall_title" value="'.$row["title"].'"/><br><br>';
			$html .= '<input type="text" name="up_chall_start" id="up_chall_start" value="'.$row["start_date"].'"/><br><br>';
			$html .= '<input type="text" name="up_chall_end" id="up_chall_end" value="'.$row["exp_date"].'"/><br><br>';
			$html .= '<h4>Who to challenge...?</h4><div id="challengees" class="browse_users"></div>';
			$html .= '<br><br>';
			$html .= ' <a onclick="pickRandomUser()" class="btn btn-primary btn-large" id="random_users_button">I\'m Feeling Lucky</a>';
			$html .= '<h4>What is the challenge...?</h4>';
			$html .= 'How to score: <select id="how_to_score">';
			if($row['score_by'] == 1) {
				$html .= '<option value="1" selected="selected">Fastest Time</option>'; 
				$html .= '<option value="2" >Total Reps</option>';
				$html .= '<option value="3" >Total Weight</option>';
			} else if($row['score_by'] == 2) {
				$html .= '<option value="1">Fastest Time</option>'; 
				$html .= '<option value="2" selected="selected">Total Reps</option>';
				$html .= '<option value="3">Total Weight</option>';
			} else if($row['score_by'] == 3) {
				$html .= '<option value="1">Fastest Time</option>'; 
				$html .= '<option value="2">Total Reps</option>';
				$html .= '<option value="3" selected="selected">Total Weight</option>';
			}
			$html .= '</select><br>';
			$html .= 'Details:<br><br><textarea rows="6" cols="50" name="challenge_txt_details" id="challenge_txt_details">'.insertNewlineChar($row["task"]).'</textarea>';
			$html .= '<br><br><a onclick="submitChallengeUpdate('.$user_id.')" class="btn btn-primary btn-large" id="submit_challenge_update">Update</a>';
			$html .= ' <a onclick="cancelChallenge()" class="btn btn-primary btn-large" id="cancel_challenge_button">Cancel</a>';
		}else {
			$html = '<h4 class="center_me">Cannot update challenge after the start date!</h4>';
			$html .= ' <a onclick="cancelChallenge()" class="btn btn-primary btn-large" id="cancel_challenge_button">Cancel</a>';
		}
	}
    $result2->free();
	echo $html;
} else {
	echo "3 - Query error. " .$mysqli->error;
}

$mysqli->close();

function insertNewlineChar($str) {

	$retVal = "";
	$html = array("<p>", "</p>");
	//echo $str . "\n";
	$str = str_replace("<p>", "", $str);
	//echo $str . "\n";
	$retVal = str_replace("</p>", "\n", $str);
	//echo $retVal . "\n";
	return $retVal;
}

?> 