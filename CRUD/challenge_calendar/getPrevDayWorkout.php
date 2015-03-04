<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();
include('../../CRUD/library/workouts_utility.php');

$t_rank = $_POST['rank'];
$t_date = $_POST['date'];
$t_user_id = $_POST['uid'];
//$t_user_id = $_SESSION["MM_user_id"];
$retWOD = "";
$retTitle = "";
$retID = "";

$detail = (object) array('id' => '', 'date' => '', 'info' => '',
							'title' => '');
							
$tomorrow = new DateTime($t_date);
$tomorrow->sub(new DateInterval('P1D'));
$date_to_use = $tomorrow->format('Y-m-d');

$test = new WorkoutsUtility();
$test->NewConnection($hostname_challenge_cal, 
		$username_challenge_cal, 
		$password_challenge_cal, 
		$database_challenge_cal);
		
//echo "Checking warmups: $t_user_id, $date_to_use, $t_rank\n";	
$retWOD = $test->GetWarmups($t_user_id, $date_to_use, $t_rank);
$retTitle = "Warm up " . $t_rank;
$retID = "w_" . $t_rank;
if($retWOD == '-') {
	$t_rank = 1;
	//echo "Checking strength: $t_user_id, $date_to_use, $t_rank\n";	
	$retWOD = $test->GetStrength($t_user_id, $date_to_use, $t_rank);
	$retTitle = "Strength " . $t_rank;
	$retID = "str_" . $t_rank;
	if($retWOD == '-') {
		//echo "Checking cond: $t_user_id, $date_to_use, $t_rank\n";	
		$retWOD = $test->GetConditioning($t_user_id, $date_to_use, $t_rank);
		$retTitle = "Conditioning " . $t_rank;
		$retID = "con_" . $t_rank;
		if($retWOD == '-') {
			//echo "Checking speed: $t_user_id, $date_to_use, $t_rank\n";	
			$retWOD = $test->GetSpeed($t_user_id, $date_to_use, $t_rank);
			$retTitle = "Speed " . $t_rank;
			$retID = "spe_" . $t_rank;
			if($retWOD == '-') {
				//echo "Checking core: $t_user_id, $date_to_use, $t_rank\n";	
				$retWOD = $test->GetCore($t_user_id, $date_to_use, $t_rank);
				$retTitle = "Core " . $t_rank;
				$retID = "core_" . $t_rank;
				if($retWOD == '-') {
					//echo "Checking rest: $t_user_id, $date_to_use, $t_rank\n";	
					$retWOD = $test->GetRest($t_user_id, $date_to_use, $t_rank);
					$retTitle = "Rest";
					$retID = "rest_" . $t_rank;
					if($retWOD == '-') {
						$retWOD = "No more workouts for $date_to_use, go to another day!";
						$retTitle = "No Workout";
						$retID = "w_1";
					}
				}
			}
		}
	}
}
 

$detail->id = $retID;
$detail->date = $date_to_use;
$detail->info = $retWOD;
$detail->title = $date_to_use . " " . $retTitle;

echo json_encode($detail);
$test->CloseConnection();
?>