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
$final_html = '<table class="list_of_users_for_chall">';


$content = '<div class="">';

$query = 'call getUsers('.$user_id.');';
$challenge_win_count = 0;
if($stmt = $mysqli->prepare($query)) 
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($uid, $fn, $ln, $ge, $loc, $ms, $purl, $nf);
		/*
		 * First while loop is getting users
		 */
		while ($stmt->fetch()) {
			$query2 = 'call getUserAcceptedChallenges('.$uid.');';
			$mysqli->next_result();
			if($stmt2 = $mysqli->prepare($query2)) 
			{
				$stmt2->execute();
				$stmt2->store_result();
				$num_of_rows2 = $stmt2->num_rows;
				if($num_of_rows2 > 0) {
					$stmt2->bind_result($chal_id);
					/*
					 * Second while loop is getting each users' accepted challenges
					 * num_of_rows2 = num of accepted challenges
					 */
					while ($stmt2->fetch()) {
						$query3 = 'call getChallengeWinners('.$chal_id.');';
						$mysqli->next_result();
						if($stmt3 = $mysqli->prepare($query3)) 
						{
							$stmt3->execute();
							$stmt3->store_result();
							$num_of_rows3 = $stmt3->num_rows;
							if($num_of_rows3 > 0) {
								$stmt3->bind_result($challenge_id, $challengee_id, $score, $rank);
								/*
								 * Third while loop is getting the winners of the accepted challenges
								 */
								while ($stmt3->fetch()) {
									if($uid == $challengee_id) {
										$challenge_win_count++;
									}
								}
							}
						} else {
							echo "getChallengeWinners failed: " . $mysqli->error;
						}
					}
				}
			} else {
				echo "getUserAcceptedChallenges failed: " . $mysqli->error;
			}

			$content.= "<tr>";
			$content .= "<td><img src=\"".$purl."\" class=\"user_picture_browse\"></td>";
			$content .= "<td>".$fn." ".$ln."</td>";
			$content .= "<td><span>Challenges Acc:</span>$num_of_rows2</td>";
			if($num_of_rows2 > 0) {
				$content .= "<td><span>Win %:</span>".number_format(100*($challenge_win_count / $num_of_rows2),0)."</td>";
			} else {
			 $content .= "<td><span>Win %:</span>0</td>";
			}
			
			if($uid == $user_id) {
				$content .= "<td class='checkbox_select'><input type=\"checkbox\" name=\"select_user\" value=\"".$uid."\" checked></td>";
			} else {
				$content .= "<td class='checkbox_select'><input type=\"checkbox\" name=\"select_user\" value=\"".$uid."\"></td>";
			}
			$content .= "</tr>";
			$challenge_win_count = 0;
		}
	}
}

$final_html .= $content . '</table>';
//$final_html .= '<a onclick="selectUsersForChallenge()" class="btn btn-primary btn-large"> OK </a>';
echo $final_html;
$mysqli->close();
?>