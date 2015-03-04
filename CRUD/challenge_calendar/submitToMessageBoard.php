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
$msg = $_POST['message'];
$t_name = "";
if($stmt = $mysqli->prepare("SELECT first_name, last_name FROM user_info WHERE user_id = $user_id")) {
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($fn, $ln);
		$content = "";
		while ($stmt->fetch()) {
			$t_name = $fn . " " . $ln;
		}
	}
}
$date = date('d-M-Y H:i:s');
$act_date = date('Y-m-d H:i:s');
$stmt = $mysqli->prepare("insert into message_board values(?, ?, ?, ?)");

$stmt->bind_param( 'sss',  $t_name, $msg, $date, $act_date);
if($result = $stmt->execute()) {
	echo "Submitted msg successfully\n";
	$stmt->close();
} else {
	echo "1 ";
}	

$mysqli->close();
?> 