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
$date = $_POST['date'];
echo "$user_id, $date";
$content = "";
if($stmt = $mysqli->prepare("SELECT warmup, strength, conditioning, speed, core, rest FROM workouts
		WHERE user_id = $user_id
		AND date = '$date'")) 
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($w, $str, $cond, $speed, $core, $rest);
		$content = "";
		while ($stmt->fetch()) {
			if(strlen($rest) > 0) {
				$content = "Rest day, would you like to remove rest day and add a workout?";
				$content .= '<a onclick="deleteWorkout()" class="btn btn-primary btn-large" id="remove_rest_day_yes" class="buttons_in_but_container"> Yes </a>';
				$content .= '<a onclick="cancelChallenge()" class="btn btn-primary btn-large" id="remove_rest_day_no" class="buttons_in_but_container"> No </a>';
			} else {
				$content .= '<h3>Warm Up</h3><textarea rows="4" cols="100" id="warmUp" name="warmUp">'.insertNewlineChar($w).'</textarea><p></p>';
				$content .= '<h3>Strength</h3><textarea rows="4" cols="100" id="strength" name="strength">'.insertNewlineChar($str).'</textarea><p></p>';
				$content .= '<h3>Conditioning</h3><textarea rows="4" cols="100" id="conditioning" name="conditioning">'.insertNewlineChar($cond).'</textarea>';
				$content .= '<p></p>';
				$content .= '<h3>Speed</h3><textarea rows="4" cols="100" id="speed" name="speed">'.insertNewlineChar($speed).'</textarea><p></p>';
				$content .= '<h3>Core</h3><textarea rows="4" cols="100" id="core" name="core">'.insertNewlineChar($core).'</textarea><p></p>';
				$content .= '<a onclick="updateWorkout()" class="btn btn-primary btn-large" id="update_workout_button" class="buttons_in_but_container">Update</a>';
			}
		}
	} else {
		$content = "No workout found selected date, please select a date with a workout";
	}
}
echo $content;
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