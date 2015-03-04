<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();
$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$user_id = $_POST['id'];
$where = $_POST['where'];
$my_id = -1;
//echo "\n getuserID.php \n $user_id .... $where\n";
if($where == 1) {
	$my_id = $user_id;
} else {
	$query = "select user_id  
	from login 
	WHERE cbox_id = $user_id";
	if ($result2 = $mysqli->query($query)) {
	   while ($row = $result2->fetch_assoc()) {
			$my_id = $row['user_id'];
		}
		$result2->free();
	}
}
$_SESSION["MM_cal_user_id"] = $my_id;
echo $my_id;
$mysqli->close();
?> 