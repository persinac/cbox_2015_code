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
$display_score = $_POST['display'];
$actual_score = $_POST['actual'];

/* For log, get user full name */
$query2 = "select CONCAT(first_name, ' ', last_name) as name
from user_info 
WHERE user_id = $user_id";
$name = "";
if ($result3 = $mysqli->query($query2)) {
   while ($row = $result3->fetch_assoc()) {
		$name = $row['name'];
    }
    $result3->free();
}

/* For log, get challenge title */
$query4 = "select title  
from challenge_table ct 
WHERE challenge_id = $c_id";
$title = "";
if ($result4 = $mysqli->query($query4)) {
   while ($row = $result4->fetch_assoc()) {
		$title = $row['title'];
    }
    $result4->free();
}



$stmt = $mysqli->prepare("update challenge_table set score = ?, display_score = ?
WHERE challenge_id = ? AND challengee_id = ?");

$stmt->bind_param( 'isii',  $actual_score, $display_score, $c_id, $user_id);
if($result = $stmt->execute()) {
	echo "Submitted score successfully\n";
	$stmt->close();
	
	$activity = "$name submitted a score to: $title";
	$log_date = date('Y-m-d h:i:s');
	$show_on_feed = 1;
	$stmt = $mysqli->prepare("insert into activity_feed values (?,?,?,?,?)"); 
	$stmt->bind_param( 'isssi', $user_id, $name, $activity, $log_date, $show_on_feed);
	if($result = $stmt->execute()) {
		echo "0";
		$stmt->close();
	} else {
		echo "6 ";
	}
	
} else {
	echo "1 ";
}	

$mysqli->close();
?> 