<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$content = "";
/*
if($stmt = $mysqli->prepare("SELECT ui.user_id, CONCAT(first_name, ' ' ,last_name) AS name, picture_url, warmup,strength,conditioning,
speed,core,rest,date FROM workouts w
JOIN user_info ui ON w.user_id = ui.user_id
JOIN user_pub_info upi ON ui.user_id = upi.user_id
ORDER BY date DESC")) 
{
*/
if($stmt = $mysqli->prepare("select af.user_id, user_full_name, 
activity, af.date, picture_url
FROM activity_feed af
JOIN user_pub_info upi ON af.user_id = upi.user_id
WHERE show_on_feed = 1 
ORDER BY af.date DESC"))
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($uid, $n, $act, $d, $purl);
		$content = "";
		$count = 0;
		while ($stmt->fetch()) {
			$content .= "<div class=\"individual_activity\"><div id=\"$count\" class=\"spec_activity\"><img src=\"".$purl."\" class=\"small_user_picture\"/> ";
			$content .= "<b>$n</b> ";
			$content .= " $act<p></p>";
			$content .= "<p id=\"v_btn_\"><a onclick='viewProfile($uid, \"$n\")' class='btn btn-primary btn-large'>View $n's Profile</a></p>";
			$content .= "<p id=\"v_btn_\"><a onclick='viewCalendar($uid, \"$n\")' class='btn btn-primary btn-large'>View $n's Calendar</a></p>";
			$content .= "</div></div><p></p>";
			$content .= '';
			$count += 1;
		}
		$stmt->free_result();
		echo $content;
	}
} else {
		echo "2: " . $mysqli->error;
}
$mysqli->close();
?>