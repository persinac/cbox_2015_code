<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();
include('../../CRUD/library/activity_feed_util.php');
$testDB = new ActivityLogConnection();
$date = $_POST['date'];
$strength = replaceNewLine($_POST['strength']);
$conditioning = replaceNewLine($_POST['conditioning']);
$speed = replaceNewLine($_POST['speed']);
$core = replaceNewLine($_POST['core']);
$rest = "";
$user_id = $_POST['id'];
//$user_id = $_SESSION["MM_user_id"];

$temp_activites = Array(
	"strength"=>$strength,
	"conditioning"=>$conditioning,
	"speed"=>$speed,
	"core"=>$core
);
$testDB->SetNewWorkoutActivities($temp_activites);

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$stmt = $mysqli->prepare("insert into workout_log values (?, ?, ?, ?, ?, ?)");
$stmt->bind_param( 'isssss', $user_id, $date, $strength, $conditioning, $speed, $core);

if($result = $stmt->execute()) {
	echo "Entered data successfully\n";
	$stmt->close();
	
	$testDB->NewConnection($hostname_challenge_cal, 
		$username_challenge_cal, 
		$password_challenge_cal, 
		$database_challenge_cal);
	$testDB->SetUserFullName($user_id);
	$testDB->SetUserID($user_id);
	$string = "logged: " . $testDB->GetWorkout() . " on " . $testDB->GetLogTimeStamp() . "";
	$testDB->SubmitToActivityLog($string, 1);
	$testDB->CloseConnection();
} else {
	echo "1 ";
}
$mysqli->close();

function replaceNewLine($str) {
	$t_desc = trim($str);
	$found_newline = false;
	$string_builder = "";
	$emergency_exit = 0;
	//echo "replaceNewLine: ".$t_desc."\n";
	while(strstr($t_desc, PHP_EOL)) {
		//echo "PHP_EOL: " . strpos($t_desc, PHP_EOL) . ", n: " .strpos($t_desc, "\n"). ", r: " .strpos($t_desc, "\r")."\n";
		$string_builder .= "<p>" . substr($t_desc, 0, strpos($t_desc, PHP_EOL)-1) . "</p>";
		//echo "PHP_EOL: " . strpos($string_builder, PHP_EOL) . ", n: " .strpos($string_builder, "\n"). ", r: " .strpos($string_builder, "\r")."\n";
		$t_desc = substr($t_desc, strpos($t_desc, PHP_EOL)+1);
		$found_newline = true;
		$emergency_exit = $emergency_exit + 1;
		if($emergency_exit == 100) {
			echo "Too many new lines, exiting...";
			exit();
		}
	}
	if($found_newline == true) {
		$string_builder .= "<p>" . $t_desc . "</p>";
		
	} else {
		$string_builder = $t_desc;
	}
	//echo "replaceNewLine: ".$string_builder."\n";
	return $string_builder;
}

?>