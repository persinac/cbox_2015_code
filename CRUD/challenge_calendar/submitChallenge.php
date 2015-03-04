<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$c_id = $_POST['challenger_id'];
//$c_id = $_SESSION["MM_user_id"];
$challengees = $_POST['challengees'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$details = $_POST['details'];
$score_by = $_POST['score_by'];

echo "$c_id\n \n $title\n $start\n $end\n $details\n $score_by\n\n";

$max_chall_id = -1;
if($stmt = $mysqli->prepare("select MAX(challenge_id) from challenge_table")) 
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($ct);
		
		while ($stmt->fetch()) {
			$max_chall_id = $ct + 1;
		}
		$stmt->free_result();
	}
	else {
		echo "1: No data";
	}
} else {
	echo "2: " . $mysqli->error;
}
$a_d = "";
$score = 0;
$display_score = "-";

$t_desc = $details;
$found_newline = false;
$string_builder = "";
$emergency_exit = 0;
while(strstr($t_desc, PHP_EOL)) {
	//echo "found newline @ " . strpos($t_desc, PHP_EOL) . "\n";
	$string_builder .= "<p>" . substr($t_desc, 0, strpos($t_desc, PHP_EOL)) . "</p>";
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
	$string_builder = $details;
}

/* For log, get user full name */
$query2 = "select CONCAT(first_name, ' ', last_name) as name
from user_info 
WHERE user_id = $c_id";
$name = "";
if ($result3 = $mysqli->query($query2)) {
   while ($row = $result3->fetch_assoc()) {
		$name = $row['name'];
    }
    $result3->free();
}


$notify = 2;
if($max_chall_id > -1) {
	$challengees_array = explode(",", $challengees);
	foreach ($challengees_array as $value) {
		echo "$value \n";
		
		$stmt = $mysqli->prepare("insert into challenge_table values(?,?,?,?,?,?,?,?,?,?,?,?)");

		$stmt->bind_param( 'iiisssssisss',  $max_chall_id, $c_id, $value, $start, 
			$end, $title, $string_builder, $a_d, $score, $score_by, $display_score,
			$notify);
		if($result = $stmt->execute()) {
			echo "0";
			$stmt->close();
			
			$activity = "$name challenged $value to $title";
			$log_date = date('Y-m-d h:i:s');
			$show_on_feed = 1;
			$stmt = $mysqli->prepare("insert into activity_feed values (?,?,?,?,?)"); 
			$stmt->bind_param( 'isssi', $c_id, $name, $activity, $log_date, $show_on_feed);
			if($result = $stmt->execute()) {
				echo "0";
				$stmt->close();
			} else {
				echo "6 ";
			}
			
		} else {
			echo "1";
		}
	}
} else {
	echo "3 - Could not retrieve max id. Please try again.";
}
/*
$stmt = $mysqli->prepare("update challenge_table set score = ?, display_score = ?
WHERE challenge_id = ? AND challengee_id = ?");

$stmt->bind_param( 'isii',  $actual_score, $display_score, $c_id, $user_id);
if($result = $stmt->execute()) {
	echo "Submitted score successfully\n";
	$stmt->close();
} else {
	echo "1 ";
}	

*/
$mysqli->close();
?> 