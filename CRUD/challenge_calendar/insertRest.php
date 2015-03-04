<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();
include('../../CRUD/library/activity_feed_util.php');
include('../../CRUD/library/challenge_utility.php');

$date = $_POST['date'];
$warmup = "";
$strength = "";
$conditioning = "";
$speed = "";
$core = "";
$rest = $_POST['rest'];
$user_id = $_POST['uid'];
//$user_id = $_SESSION["MM_user_id"];

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$stmt = $mysqli->prepare("insert into workouts values (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param( 'isssssss', $user_id, $warmup, $strength, $conditioning, $speed, $core, $rest, $date);

if($result = $stmt->execute()) {
	echo "Entered data successfully\n";
	$stmt->close();
	
	$testDB = new ActivityLogConnection();
	$testDB->NewConnection($hostname_challenge_cal, 
		$username_challenge_cal, 
		$password_challenge_cal, 
		$database_challenge_cal);
	$testDB->SetUserFullName($user_id);
	$testDB->SetUserID($user_id);
	$testDB->SetRest("added a rest day on " . $date . "");
	$testDB->SubmitToActivityLog($testDB->GetRest(), 1);
	$testDB->CloseConnection();
} else {
	echo "1 ";
}
$mysqli->close();

?>