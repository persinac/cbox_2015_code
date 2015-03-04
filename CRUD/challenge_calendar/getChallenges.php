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
class challenge {
	public $challenge_id = 0;
	public $challenger_name = "";
	public $challenger_id = 0;
	public $start_date = "";
	public $exp_date = "";
	public $start = "";
	public $end = "";
	public $title = "";
	public $task  = "";
	public $color = "";
	public $borderColor = "";
   }
   
$query = "select challenge_id, CONCAT(ui.first_name, ' ', ui.last_name) AS challenger_name, 
challenger_id, challengee_id, start_date,
exp_date, title, task, notify 
from challenge_table ct 
JOIN user_info ui on ui.user_id = ct.challenger_id 
WHERE challengee_id = $user_id 
 order by start_date";
//echo "QUERY: " . $query . "\nID: $user_id\n";
if ($result2 = $mysqli->query($query)) {
	$cars = array();
	$index = 1;
	$description = "";
   while ($row = $result2->fetch_assoc()) {
		$w = new challenge();
		
		$w->challenge_id = $row["challenge_id"];
		$w->challenger_name = $row["challenger_name"];
		$w->challenge_id = $row["challenge_id"];
		$w->start = $row["start_date"] . "T06:00:00";
		$w->end = $row["start_date"] . "T06:59:00";
		$w->title = "Challenge - " . $row["title"];
		$w->description = $row["task"];
		$w->color = "rgb(127,143,255)";
		if($row["notify"] == 2) {
			$w->borderStyle = "2px solid rgb(83,255,57)";
			$w->blink = "false";
		} else if ($row["notify"] == 1) {
			$w->borderStyle = "2px solid rgb(127,143,255)";
			$w->blink = "false";
		} else {
			$w->borderStyle = "2px solid rgb(255,0,0)";
			$w->blink = "true";
		}
		
		$w->description .= "<br><br>";
		$cars[] = $w;
		$description = "";
    }
	echo json_encode($cars);
    $result2->free();
}
$mysqli->close();
?> 
