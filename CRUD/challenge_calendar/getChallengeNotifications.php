<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

class notification {
	public $challenge_id = 0;
	public $given = "";
	public $received = "";
}

$user_id = $_POST['id'];
//$user_id = $_SESSION["MM_user_id"];   
$query = "select challenge_id, challenger_id, notify 
from challenge_table ct 
JOIN user_info ui on ui.user_id = ct.challenger_id 
WHERE challengee_id = $user_id";
//echo "QUERY: " . $query . "\nID: $user_id\n";
if ($result2 = $mysqli->query($query)) {
	$cars = array();
	while ($row = $result2->fetch_assoc()) {
		$w = new notification();
		$w->challenge_id = $row["challenge_id"];
		if($row["notify"] == 2) {
			if($row["challenger_id"] == $user_id) {
				$w->given = 1;
			} else {
				$w->received = 1;
			}
		} 
		$cars[] = $w;
    }
	echo json_encode($cars);
    $result2->free();
}
$mysqli->close();
?> 