<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$content = "";
if($stmt = $mysqli->prepare("SELECT ui.user_id, CONCAT(first_name, ' ' ,last_name) AS name, picture_url, warmup,strength,conditioning,
speed,core,rest,date FROM workouts w
JOIN user_info ui ON w.user_id = ui.user_id
JOIN user_pub_info upi ON ui.user_id = upi.user_id
ORDER BY date DESC")) 
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($uid, $n, $purl, $w, $str, $cond, $speed,
			$core, $rest, $date);
		$content = "";
		$count = 0;
		while ($stmt->fetch()) {
			$content .= "<div class=\"individual_activity\"><div id=\"$count\" class=\"spec_activity\"><img src=\"".$purl."\" class=\"small_user_picture\"/> ";
			$content .= "<b>$n</b> ";
			if(strlen($rest) > 0) {
				$content .= " took a rest day ";
			} else {
				if(strlen($w) > 0 ) {
					$content .= " did a warmup, then";
				}
				$content .= " performed ";
				if(strlen($str) > 0 ) {
					$content .= "strength";
				}
				if(strlen($cond) > 0 ) {
					if(strlen($str) > 0 ) {
						$content .= ", and ";
					}
					$content .= "conditioning";
				}
				if(strlen($speed) > 0 ) {
					if(strlen($cond) > 0 || strlen($str) > 0 ) {
						$content .= ", and ";
					}
					$content .= "speed";
				}
				if(strlen($core) > 0 ) {
					if(strlen($speed) > 0 || strlen($cond) > 0 || strlen($str) > 0 ) {
						$content .= ", and ";
					}
					$content .= "core ";
				}
			}
			$content .= " on: $date<p></p>";
			$content .= "<p id=\"v_btn_\"><a onclick='viewProfile($uid, \"$n\")' class='btn btn-primary btn-large'>View $n's Profile</a></p>";
			$content .= "<p id=\"v_btn_\"><a onclick='viewCalendar($uid, \"$n\")' class='btn btn-primary btn-large'>View $n's Calendar</a></p>";
			$content .= "</div></div><p></p>";
			$content .= '<hr>';
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