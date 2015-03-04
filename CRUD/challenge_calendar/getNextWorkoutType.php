<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();
include('../../CRUD/library/workouts_utility.php');

$t_col = $_POST['col'];
$t_rank = $_POST['rank'];
$t_date = $_POST['date'];
$t_user_id = $_POST['uid'];
//$t_user_id = $_SESSION["MM_user_id"];
$retWOD = "";
$retTitle = "";
$retID = "";

$detail = (object) array('id' => '', 'date' => '', 'info' => '',
							'title' => '');

$test = new WorkoutsUtility();
$test->NewConnection($hostname_challenge_cal, 
		$username_challenge_cal, 
		$password_challenge_cal, 
		$database_challenge_cal);
		
if($t_col == 'w') {
	$retWOD = $test->GetWarmups($t_user_id, $t_date, ($t_rank+1));
	//echo "checking warmups: $t_user_id, $t_date, ".($t_rank+1)."\n";
	$c = $t_rank + 1;
	$retTitle = "Warm up " . $c;
	$retID = "w_" . $c;
	if($retWOD == '-') {
		$t_rank = 1;
		//echo "checking strength...$t_user_id, $t_date, $t_rank\n";
		$retWOD = $test->GetStrength($t_user_id, $t_date, $t_rank);
		$retTitle = "Strength " . $t_rank;
		$retID = "str_" . $t_rank;
		if($retWOD == '-') {
			//echo "checking Conditioning...$t_user_id, $t_date, $t_rank\n";
			$retWOD = $test->GetConditioning($t_user_id, $t_date, $t_rank);
			$retTitle = "Conditioning " . $t_rank;
			$retID = "con_" . $t_rank;
			if($retWOD == '-') {
				$retWOD = $test->GetSpeed($t_user_id, $t_date, $t_rank);
				//echo "checking speed...$t_user_id, $t_date, $t_rank\n";
				$retTitle = "Speed " . $t_rank;
				$retID = "spe_" . $t_rank;
				if($retWOD == '-') {
					//echo "checking core...$t_user_id, $t_date, $t_rank\n";
					$retWOD = $test->GetCore($t_user_id, $t_date, $t_rank);
					$retTitle = "Core " . $t_rank;
					$retID = "core_" . $t_rank;
					if($retWOD == '-') {
						$retWOD = "No more workouts for $t_date, go to another day!";
						$retTitle = "No Workout";
						$retID = "w_1";
					}
				}
			}
		}
	}
} else if($t_col == 'str') {
	//echo "STRENGTH\n";
	$retWOD = $test->GetStrength($t_user_id, $t_date, ($t_rank+1));
	//echo "$retWOD\n";
	$c = $t_rank + 1;
	$retTitle = "Strength " . $c;
	$retID = "str_" . $c;
	if($retWOD == '-') {
		$t_rank = 1;
		//echo "started at strength, checking Conditioning...$t_user_id, $t_date, $t_rank\n";
		$retWOD = $test->GetConditioning($t_user_id, $t_date, $t_rank);
		$retTitle = "Conditioning " . $t_rank;
		$retID = "con_" . $t_rank;
		if($retWOD == '-') {
			$retWOD = $test->GetSpeed($t_user_id, $t_date, $t_rank);
			$retTitle = "Speed " . $t_rank;
			$retID = "spe_" . $t_rank;
			if($retWOD == '-') {
				$retWOD = $test->GetCore($t_user_id, $t_date, $t_rank);
				$retTitle = "Core " . $t_rank;
				$retID = "core_" . $t_rank;
				if($retWOD == '-') {
					$retWOD = "No more workouts for $t_date, go to another day!";
					$retTitle = "No Workout";
					$retID = "w_1";
				}
			}
		}
	}
} else if($t_col == 'con') {
	$retWOD = $test->GetConditioning($t_user_id, $t_date, ($t_rank+1));
	$c = $t_rank + 1;
	$retTitle = "Conditioning " . $c;
	$retID = "con_" . $c;
	if($retWOD == '-') {
		$t_rank = 1;
		$retWOD = $test->GetSpeed($t_user_id, $t_date, $t_rank);
		$retTitle = "Speed " . $t_rank;
		$retID = "spe_" . $t_rank;
		if($retWOD == '-') {
			$retWOD = $test->GetCore($t_user_id, $t_date, $t_rank);
			$retTitle = "Core " . $t_rank;
			$retID = "core_" . $t_rank;
			if($retWOD == '-') {
				$retWOD = "No more workouts for $t_date, go to another day!";
				$retTitle = "No Workout";
				$retID = "w_1";
			}
		}
	}
} else if($t_col == 'spe') {
	$retWOD = $test->GetSpeed($t_user_id, $t_date, ($t_rank+1));
	$c = $t_rank + 1;
	$retTitle = "Speed " . $c;
	$retID = "spe_" . $c;
	if($retWOD == '-') {
		$t_rank = 1;
		$retWOD = $test->GetCore($t_user_id, $t_date, $t_rank);
		$retTitle = "Core " . $t_rank;
		$retID = "core_" . $t_rank;
		if($retWOD == '-') {
			$retWOD = "No more workouts for $t_date, go to another day!";
			$retTitle = "No Workout";
			$retID = "w_1";
		}
	}
} else if($t_col == 'core') {
	$retWOD = $test->GetCore($t_user_id, $t_date, $t_rank);
	$c = $t_rank + 1;
	$retTitle = "Core " . $c;
	$retID = "core_" . $c;
	if($retWOD == '-') {
		$retWOD = "No more workouts for $t_date, go to another day!";
		$retTitle = "No Workout";
		$retID = "w_1";
	}
}

$detail->id = $retID;
$detail->date = $t_date;
$detail->info = $retWOD;
$detail->title = $retTitle;

echo json_encode($detail);
$test->CloseConnection();
?>