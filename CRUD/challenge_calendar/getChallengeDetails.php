<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$t_id = $_POST['id']; 
$user_id = $_POST['uid'];
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
   }
 
$html = "";
$score_by = "0";
$order_by = " ORDER BY score ";
$challenger_id = -1;
$query = "select CONCAT(ui.first_name, ' ', ui.last_name) AS challenger_name, challenger_id, 
title, start_date, exp_date, task, score_by 
from challenge_table ct  
JOIN user_info ui on ui.user_id = ct.challenger_id 
WHERE challenge_id = $t_id 
GROUP BY challenger_name";
//echo "QUERY1: " . $query . "\nID: $t_id\n";
if ($result2 = $mysqli->query($query)) {
   while ($row = $result2->fetch_assoc()) {
		$challenger_id = $row['challenger_id'];
		$html .= '<div id="challenge_info">';
		$html .= '<h3 id="challenge_title">'.$row["title"].'</h3>';
		$html .= '<h4 id="challenger"> Challenger: '.$row["challenger_name"].'</h4>';
		$html .= '<h4 id="start_date"> Start Date: '.$row["start_date"].'</h4>';
		$html .= '<h4 id="end_date">Must complete by: '.$row["exp_date"].'</h4>';
		$html .= '<h4 id="information">'.$row["task"].'</h4>';
		$html .= '<h4 id="information"> Score by: ';
		if($row['score_by'] == 1) {
			$html .= 'Fastest Time';
			$order_by .= ' ASC';
		} else if($row['score_by'] == 2) {
			$html .= 'Total rounds/reps';
			$order_by .= ' DESC';
		} else if($row['score_by'] == 3) {
			$html .= 'Total Tonnage lifted';
			$order_by .= ' DESC';
		} else {
			$html .= 'Not Set';
			$order_by = ' ORDER BY challenger_name';
		}
		$html .= '</h4>';
    }
    $result2->free();
	
}

$query = "select CONCAT(ui.first_name, ' ', ui.last_name) AS challenger_name,
ui.user_id AS user_id, a_d, 
score, score_by, display_score from challenge_table ct 
JOIN user_info ui on ui.user_id = ct.challengee_id 
WHERE challenge_id = $t_id " . $order_by;

$ad_var = "e";
//echo "QUERY2: " . $query . "\nID: $t_id\n";
if ($result2 = $mysqli->query($query)) {
	$description = "";
	$html .= '<table class="competitors2" id="competitors"><tr><th>Name</th><th>Accepted</th><th>Declined</th><th>Score</th></tr>';
   while ($row = $result2->fetch_assoc()) {
		$score_by = $row['score_by'];
		$html .= "<tr>";
		$html .="<td>".$row['challenger_name']."</td>";
		if($row['a_d'] == "a") {
			$html .="<td><b> X </b></td>";
			$html .="<td> - </td>";
			if(trim($user_id) == trim($row['user_id'])) {
				$ad_var	= $row['a_d'];
			}
		} else if($row['a_d'] == "d") {
			$html .="<td> - </td>";
			$html .="<td><b> X </b></td>";
			if(trim($user_id) == trim($row['user_id'])) {
				$ad_var	= $row['a_d'];
			}
		} else {
			$html .="<td> - </td>";
			$html .="<td> - </td>";
		}
		$html .="<td>".$row['display_score']."</td>";
		
    }
	$html .="</tr></div>";
    $result2->free();
	echo $html;
}
echo "****$ad_var?$score_by?$challenger_id";
$mysqli->close();
?> 