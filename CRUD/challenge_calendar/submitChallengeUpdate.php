<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$c_id = $_POST['challenge_id'];
$challengees = $_POST['challengees'];
$challenger_id = $_POST['challenger_id'];
//$challenger_id = $_SESSION["MM_user_id"];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$details = $_POST['details'];
$score_by = $_POST['score_by'];

$total = 0;

$a_d = "";
$score = 0;
$display_score = "-";

$t_desc = $details;
$found_newline = false;
$string_builder = "";
$emergency_exit = 0;
while(strstr($t_desc, PHP_EOL)) {
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
WHERE user_id = $challenger_id";
$name = "";
if ($result3 = $mysqli->query($query2)) {
   while ($row = $result3->fetch_assoc()) {
		$name = $row['name'];
    }
    $result3->free();
}

$challengees_array = explode(",", $challengees);
foreach ($challengees_array as $value) {
	//echo "$value \n";
	
	$sel_challengee_id = $mysqli->prepare("SELECT challengee_id FROM challenge_table WHERE challenge_id = ? AND challengee_id = ?");
	$sel_challengee_id->bind_param( 'ii', $c_id, $value);
	if($result = $sel_challengee_id->execute()){
		$sel_challengee_id->store_result();
		$num_of_rows = $sel_challengee_id->num_rows;
		//echo "num rows: $num_of_rows\n";
		if($num_of_rows > 0) {
			$sel_challengee_id->bind_result($d);
			$stmt = $mysqli->prepare("UPDATE challenge_table SET 
									start_date = ?,
									exp_date = ?, 
									title = ?, 
									task = ?, 
									score_by = ? 
									WHERE challenge_id = ? AND challengee_id = ?");
			//echo "$start, $end, $title, $string_builder, $score_by, $c_id, $value\n";
			$stmt->bind_param( 'sssssii', $start, $end, $title, $string_builder, $score_by, $c_id, $value);
			if($result = $stmt->execute()) {
				$stmt->close();
				
				$activity = "$name updated challenge: $title";
				$log_date = date('Y-m-d h:i:s');
				$show_on_feed = 1;
				$stmt = $mysqli->prepare("insert into activity_feed values (?,?,?,?,?)"); 
				$stmt->bind_param( 'isssi', $challenger_id, $name, $activity, $log_date, $show_on_feed);
				if($result = $stmt->execute()) {
					$stmt->close();
				} else {
					$total += 6;
				}
				
			} else {
				$total += 1;
			}
		} else {
			//new person, so add them.
			$stmt = $mysqli->prepare("insert into challenge_table values(?,?,?,?,?,?,?,?,?,?,?)");

			$stmt->bind_param( 'iiisssssiss',  $c_id, $challenger_id, $value, $start, 
				$end, $title, $string_builder, $a_d, $score, $score_by, $display_score);
			if($result = $stmt->execute()) {
				$stmt->close();
			} else {
				$total += 1;
			}
		}
	} else {
		$total += 9;
		echo "Error: " . $mysqli->error;
	}
}
echo $total;
$mysqli->close();
?> 