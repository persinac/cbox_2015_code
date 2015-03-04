<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$content = "";
if($stmt = $mysqli->prepare("SELECT name, message, displaydate
							FROM message_board 
							ORDER BY actualdate"))
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($n, $msg,  
			$date);
		$content = "";
		while ($stmt->fetch()) {
			$content .= "<b>$n</b> $date: $msg<p></p>";
		}
		$stmt->free_result();
		echo $content;
	}
} else {
		echo "2: " . $mysqli->error;
}
$mysqli->close();
?>