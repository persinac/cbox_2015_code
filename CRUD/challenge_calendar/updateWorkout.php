<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();
include('../../CRUD/library/activity_feed_util.php');
$testDB = new ActivityLogConnection();
$date = $_POST['date'];
$warmup = replaceNewLine($_POST['warmUp']);
$strength = replaceNewLine($_POST['strength']);
$conditioning = replaceNewLine($_POST['conditioning']);
$speed = replaceNewLine($_POST['speed']);
$core = replaceNewLine($_POST['core']);
$rest = "";
$user_id = $_POST['uid'];
//$user_id = $_SESSION["MM_user_id"];
$temp_activites = Array(
	"warmup"=>$warmup,
	"strength"=>$strength,
	"conditioning"=>$conditioning,
	"speed"=>$speed,
	"core"=>$core
);
$testDB->SetNewWorkoutActivities($temp_activites);
$testDB->NewConnection($hostname_challenge_cal, 
			$username_challenge_cal, 
			$password_challenge_cal, 
			$database_challenge_cal);
$testDB->SetUserFullName($user_id);
$testDB->SetUserID($user_id);	
		
$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

if(strlen($warmup) > 0) {
	$stmt = $mysqli->prepare("update workouts set warmup = ? where date = ? AND user_id = ?"); 

	$stmt->bind_param( 'ssi',  $warmup, $date, $user_id);
	
	if($result = $stmt->execute()) {
		echo "Updated warmup successfully\n";
		$stmt->close();
		$string = "updated their warmup for " . $date . "";
		$testDB->SubmitToActivityLog($string, 1);
		
	} else {
		echo "1 ";
	}	
}

if(strlen($strength) > 0) {
    //echo "$strength, $date, $user_id";
	$stmt = $mysqli->prepare("update workouts set strength = ? where date = ? AND user_id = ?"); 

	$stmt->bind_param( 'ssi',  $strength, $date, $user_id);
	
	if($result = $stmt->execute()) {
		echo "Updated strength successfully\n";
		$stmt->close();
		$string = "updated their strength workout for " . $date . "";
		$testDB->SubmitToActivityLog($string, 1);
	} else {
		echo "1 ";
	}
}

if(strlen($conditioning) > 0) {
	$stmt = $mysqli->prepare("update workouts set conditioning = ? where date = ? AND user_id = ?"); 

	$stmt->bind_param( 'ssi',  $conditioning, $date, $user_id);
	
	if($result = $stmt->execute()) {
		echo "Updated conditioning successfully\n";
		$stmt->close();
		$string = "updated their conditioning workout for " . $date . "";
		$testDB->SubmitToActivityLog($string, 1);
	} else {
		echo "1 ";
	}
}

if(strlen($speed) > 0) {
	$stmt = $mysqli->prepare("update workouts set speed = ? where date = ? AND user_id = ?"); 

	$stmt->bind_param( 'ssi',  $speed, $date, $user_id);
	
	if($result = $stmt->execute()) {
		echo "Updated speed successfully\n";
		$stmt->close();
		$string = "updated their speed workout for " . $date . "";
		$testDB->SubmitToActivityLog($string, 1);
	} else {
		echo "1 ";
	}
}

if(strlen($core) > 0) {
	$stmt = $mysqli->prepare("update workouts set core = ? where date = ? AND user_id = ?"); 

	$stmt->bind_param( 'ssi',  $core, $date, $user_id);
	
	if($result = $stmt->execute()) {
		echo "Updated core successfully\n";
		$stmt->close();
		$string = "updated their core workout for " . $date . "";
		$testDB->SubmitToActivityLog($string, 1);
	} else {
		echo "1 ";
	}
}

$mysqli->close();
$testDB->CloseConnection();

function replaceNewLine($str) {
	$t_desc = $str;
	$found_newline = false;
	$string_builder = "";
	$emergency_exit = 0;
	while(strstr($t_desc, PHP_EOL)) {
		$string_builder .= "<p>" . substr($t_desc, 0, strpos($t_desc, PHP_EOL)-1) . "</p>";
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
	return $string_builder;
}

?>