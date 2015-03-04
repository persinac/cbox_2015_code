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
$final_html = '<div id="tabs" class="tabs">';
$unorderedList = '<ul class="tab-links">';

$tabs = "";
$divisions = "";

$tabs .= '<li class="active"><a href="#tab1">Given</a></li>';
$tabs .= '<li><a href="#tab2">Received</a></li>';
$tabs .= '<li><a href="#tab3">Accepted</a></li>';
$tabs .= '<li><a href="#tab4">Declined</a></li>';
$tabs .= '<li><a href="#tab5">Pending</a></li>';
$final_html .= $unorderedList . $tabs . '</ul> <!-- END UL -->';

$tab_content = '<div class="tab-content">';

$temp = "P";
$retVal = 0; //0 is good to go, anything else - ERROR
$query1 = "select challenge_id, start_date, exp_date, title, a_d from challenge_table 
	where challenger_id = $user_id AND challengee_id = $user_id 
	GROUP BY challenge_id";
//echo "$query1\n";
$tab_content_1 = '';
$tab_content_1 = '<div id="tab1" class="tab active">';
$tab_content_1 .= '<table>';
if($stmt = $mysqli->prepare($query1)) 
{
	//echo "\$stmt = true\n";
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		//echo "num_of_rows > 0\n";
		$stmt->bind_result($cid, $sd, $ed, $t, $a);
		//echo "Results bound\n";
		while ($stmt->fetch()) {
			$tab_content_1 .= '<tr id="challenge_'.$cid.'">';
			$tab_content_1 .= '<td><a onclick="viewChallengeDetails('.$cid.')" class="">'.$t.'</a></td>';
			$tab_content_1 .= '<td><b>Start Date: </b> '.$sd.' </td><td><b>Expiration Date: </b> '.$ed.'</td>';
			if($a == "a") {
				$temp = "A";
			} else if($a == "d") {
				$temp = "D";
			} else {
				$temp = "P";
			}
			$tab_content_1 .= '<td><b>Acc/Dec? </b> '. $temp .'</td>';
			$tab_content_1 .= '<td> </td>';
			$tab_content_1 .= '</tr>';
		}
		$stmt->free_result();
		
	} else {
		$retVal = 1;
	}
} else {
	echo "Error: " . $mysqli->error;
}
$tab_content_1 .= '</table>';
$tab_content_1 .= '</div>';

$query1 = "select challenge_id, start_date, exp_date, title, a_d from challenge_table 
	where challenger_id <> $user_id AND challengee_id = $user_id 
	GROUP BY challenge_id";
//echo "$query1\n";
$tab_content_2 = '';
$tab_content_2 = '<div id="tab2" class="tab">';
$tab_content_2 .= '<table>';
if($stmt = $mysqli->prepare($query1)) 
{

	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($cid, $sd, $ed, $t, $a);
		while ($stmt->fetch()) {
			$tab_content_2 .= '<tr id="challenge_'.$cid.'">';
			$tab_content_2 .= '<td><a onclick="viewChallengeDetails('.$cid.')" class="">'.$t.'</a></td>';
			$tab_content_2 .= '<td><b>Start Date: </b> '.$sd.' </td><td><b>Expiration Date: </b> '.$ed.'</td>';
			if($a == "a") {
				$temp = "A";
			} else if($a == "d") {
				$temp = "D";
			} else {
				$temp = "P";
			}
			$tab_content_2 .= '<td><b>Acc/Dec? </b> '. $temp .'</td>';
			$tab_content_2 .= '<td> </td>';
			$tab_content_2 .= '</tr>';
		}
		$stmt->free_result();
		
	} else {
		$retVal = 1;
	}
} else {
	echo "Error: " . $mysqli->error;
}
$tab_content_2 .= '</table>';
$tab_content_2 .= '</div>';



$query1 = "select challenge_id, start_date, exp_date, title, a_d from challenge_table 
	where challengee_id = $user_id AND challengee_id = $user_id AND a_d = 'a' 
	GROUP BY challenge_id";
//echo "$query1\n";
$tab_content_3 = '';
$tab_content_3 = '<div id="tab3" class="tab">';
$tab_content_3 .= '<table>';
if($stmt = $mysqli->prepare($query1)) 
{
	//echo "\$stmt = true\n";
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		//echo "num_of_rows > 0\n";
		$stmt->bind_result($cid, $sd, $ed, $t, $a);
		//echo "Results bound\n";
		while ($stmt->fetch()) {
			$tab_content_3 .= '<tr id="challenge_'.$cid.'">';
			$tab_content_3 .= '<td><a onclick="viewChallengeDetails('.$cid.')" class="">'.$t.'</a></td>';
			$tab_content_3 .= '<td><b>Start Date: </b> '.$sd.' </td><td><b>Expiration Date: </b> '.$ed.'</td>';
			$tab_content_3 .= '<td><b>Acc/Dec? </b> A </td>';
			$tab_content_3 .= '<td> </td>';
			$tab_content_3 .= '</tr>';
		}
		$stmt->free_result();
		
	} else {
		$retVal = 1;
	}
} else {
	echo "Error: " . $mysqli->error;
}
$tab_content_3 .= '</table>';
$tab_content_3 .= '</div>';

$query1 = "select challenge_id, start_date, exp_date, title, a_d from challenge_table 
	where challengee_id = $user_id AND challengee_id = $user_id AND a_d = 'd' 
	GROUP BY challenge_id";
//echo "$query1\n";
$tab_content_4 = '';
$tab_content_4 = '<div id="tab4" class="tab">';
$tab_content_4 .= '<table>';
if($stmt = $mysqli->prepare($query1)) 
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($cid, $sd, $ed, $t, $a);

		while ($stmt->fetch()) {
			$tab_content_4 .= '<tr id="challenge_'.$cid.'">';
			$tab_content_4 .= '<td><a onclick="viewChallengeDetails('.$cid.')" class="">'.$t.'</a></td>';
			$tab_content_4 .= '<td><b>Start Date: </b> '.$sd.' </td><td><b>Expiration Date: </b> '.$ed.'</td>';
			$tab_content_4 .= '<td><b>Acc/Dec? </b> D </td>';
			$tab_content_4 .= '<td> </td>';
			$tab_content_4 .= '</tr>';
		}
		$stmt->free_result();
		
	} else {
		$retVal = 1;
	}
} else {
	echo "Error: " . $mysqli->error;
}
$tab_content_4 .= '</table>';
$tab_content_4 .= '</div>';

$query1 = "select challenge_id, start_date, exp_date, title, a_d from challenge_table 
	where challengee_id = $user_id AND challengee_id = $user_id AND a_d = '' 
	GROUP BY challenge_id";
//echo "$query1\n";
$tab_content_5 = '';
$tab_content_5 = '<div id="tab5" class="tab">';
$tab_content_5 .= '<table>';
if($stmt = $mysqli->prepare($query1)) 
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($cid, $sd, $ed, $t, $a);
		while ($stmt->fetch()) {
			$tab_content_5 .= '<tr id="challenge_'.$cid.'">';
			$tab_content_5 .= '<td><a onclick="viewChallengeDetails('.$cid.')" class="">'.$t.'</a></td>';
			$tab_content_5 .= '<td><b>Start Date: </b> '.$sd.' </td><td><b>Expiration Date: </b> '.$ed.'</td>';
			$tab_content_5 .= '<td><b>Acc/Dec? </b> P </td>';
			$tab_content_5 .= '<td> </td>';
			$tab_content_5 .= '</tr>';
		}
		$stmt->free_result();
		
	} else {
		$retVal = 1;
	}
} else {
	echo "Error: " . $mysqli->error;
}
$tab_content_5 .= '</table>';
$tab_content_5 .= '</div>';
$tab_content .= $tab_content_1 . $tab_content_2 . $tab_content_3 . $tab_content_4 . $tab_content_5;

$tab_content .= '</div>';

$final_html .= $tab_content . '</div>';
echo $final_html;
$mysqli->close();
?>