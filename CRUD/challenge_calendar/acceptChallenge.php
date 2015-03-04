<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();
include('../../CRUD/library/activity_feed_util.php');
include('../../CRUD/library/challenge_utility.php');

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
//this is editing live files
$user_id = $_POST['uid'];
$c_id = $_POST['cid'];

// $user_id = $_SESSION["MM_user_id"] 


/* let's set up the challenge for log */
$challenge = new ChallengeUtility();
$challenge->NewConnection($hostname_challenge_cal, 
			$username_challenge_cal, 
			$password_challenge_cal, 
			$database_challenge_cal);
$challenge->SetChallengeID($c_id);
$challenge->SetTitle($challenge->GetChallengeID());
$challenge->SetStartDateByID($challenge->GetChallengeID());
$challenge->CloseConnection();

$currDate = date('Y-m-d');
$chal_start_date = $challenge->GetStartDate();
$beforeStartDate = -1;

if($currDate <= $chal_start_date) {
	$beforeStartDate = 0;
} else if($currDate > $chal_start_date) {
	$beforeStartDate = 1;
} else {
	$beforeStartDate = 9;
}

if($beforeStartDate == 0) {
	$stmt = $mysqli->prepare("update challenge_table set a_d = 'a' where challenge_id = ? AND challengee_id = ?"); 

	$stmt->bind_param( 'ii',  $c_id, $user_id);

	if($result = $stmt->execute()) {
		echo "0";
		$stmt->close();
		
		$testDB = new ActivityLogConnection();
		$testDB->NewConnection($hostname_challenge_cal, 
			$username_challenge_cal, 
			$password_challenge_cal, 
			$database_challenge_cal);
		$testDB->SetUserFullName($user_id);
		$testDB->SetUserID($user_id);
		$testDB->SetAcceptedChallenge("accepted challenge: " . $challenge->GetTitle() . "");
		$testDB->SubmitToActivityLog($testDB->GetAcceptedChallenge(), 1);
		$testDB->CloseConnection();
	} else {
		echo "1 ";
	}
} else {
	echo "3";
}

$mysqli->close();
?> 