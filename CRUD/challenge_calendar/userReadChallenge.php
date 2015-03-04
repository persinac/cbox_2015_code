<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$c_id = $_POST['cid'];
$user_id = $_POST['uid'];
//$user_id = $_SESSION["MM_user_id"];
$notify = 1;
$stmt = $mysqli->prepare("update challenge_table set notify = ? 
WHERE challenge_id = ? AND challengee_id = ?");

$stmt->bind_param( 'iii',  $notify, $c_id, $user_id);
if($result = $stmt->execute()) {
	echo "success!";
	$stmt->close();
} else {
	echo "1 ";
}	

$mysqli->close();
?> 