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

$col_name = "";
//echo "$t_user_id, $t_date, $col_name, $t_rank\n";

if($t_col == 'w') {
	if($t_rank > 1) {
		$retWOD = $test->GetWarmups($t_user_id, $t_date, ($t_rank-1));
		$c = $t_rank - 1;
		$retTitle = "Warm Up " . $c;
		$retID = "w_" . $c;
	} else if($t_rank == 1) {
		$retWOD = $test->GetWarmups($t_user_id, $t_date, $t_rank);
		$retTitle = "Warm Up " . $t_rank;
		$retID = "w_" . $t_rank;
	} else {
		$retWOD = "No more workouts for $t_date, go to another day!";
		$retTitle = "No Workout";
		$retID = "w_1";
	}
} else if($t_col == 'str') {
	if($t_rank > 1) {
		$retWOD = $test->GetStrength($t_user_id, $t_date, ($t_rank-1));
		$c = $t_rank - 1;
		$retTitle = "Strength " . $c;
		$retID = "str_" . $c;
	} else {
		$col_name = "warmup";
		$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name);
		//echo "get prev workout: $t_user_id, $t_date, $col_name\n"; 
		$retWOD = $t_arr->info;
		$retTitle = "Warm Up " . $t_arr->rank;
		$retID = "w_" . $t_arr->rank;
	}
}else if($t_col == 'con') {
	if($t_rank > 1) {
		$retWOD = $test->GetConditioning($t_user_id, $t_date, ($t_rank-1));
		$c = $t_rank - 1;
		$retTitle = "Conditioning " . $c;
		$retID = "con_" . $c;
	} else {
		$col_name = "strength";
		$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name);
		$retWOD = $t_arr->info;
		$retTitle = "Strength " . $t_arr->rank;
		$retID = "str_" . $t_arr->rank;
		if($retWOD == '-') {
			$col_name = "warmup";
			$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name); 
			$retWOD = $t_arr->info;
			$retTitle = "Warm Up " . $t_arr->rank;
			$retID = "w_" . $t_arr->rank;
			if($retWOD == '-') {
				$retWOD = "No more workouts for $t_date, go to another day!";
				$retTitle = "No Workout";
				$retID = "w_1";
			}
		}
	}	
} else if($t_col == 'spe') {
	if($t_rank > 1) {
		$retWOD = $test->GetSpeed($t_user_id, $t_date, ($t_rank-1));
		$c = $t_rank - 1;
		$retTitle = "Speed " . $c;
		$retID = "spe_" . $c;
	} else {
		$col_name = "conditioning";
		$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name);
		$retWOD = $t_arr->info;
		$retTitle = "Conditioning " . $t_arr->rank;
		$retID = "con_" . $t_arr->rank;
		if($retWOD == '-') {
			$col_name = "strength";
			$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name);
			$retWOD = $t_arr->info;
			$retTitle = "Strength " . $t_arr->rank;
			$retID = "str_" . $t_arr->rank;
			if($retWOD == '-') {
				$col_name = "warmup";
				$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name);
				$retWOD = $t_arr->info;
				$retTitle = "Warm Up " . $t_arr->rank;
				$retID = "w_" . $t_arr->rank;
				if($retWOD == '-') {
					$retWOD = "No more workouts for $t_date, go to another day!";
					$retTitle = "No Workout";
					$retID = "w_1";
				}
			}
		}
	}
} else if($t_col == 'core') {
	if($t_rank > 1) {
		$retWOD = $test->GetCore($t_user_id, $t_date, ($t_rank-1));
		$c = $t_rank - 1;
		$retTitle = "Core " . $c;
		$retID = "core_" . $c;
	} else {
		$col_name = "speed";
		$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name);
		$retWOD = $t_arr->info;
		$retTitle = "Speed " . $t_arr->rank;
		$retID = "spe_" . $t_arr->rank;
		if($retWOD == '-') {
			$col_name = "conditioning";
			$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name);
			$retWOD = $t_arr->info;
			$retTitle = "Conditioning " . $t_arr->rank;
			$retID = "con_" . $t_arr->rank;
			if($retWOD == '-') {
				$col_name = "strength";
				$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name);
				$retWOD = $t_arr->info;
				$retTitle = "Strength " . $t_arr->rank;
				$retID = "str_" . $t_arr->rank;
				if($retWOD == '-') {
					$col_name = "warmup";
					$t_arr = $test->GetPrevWorkout($t_user_id, $t_date, $col_name);
					$retWOD = $t_arr->info;
					$retTitle = "Warm Up " . $t_arr->rank;
					$retID = "w_" . $t_arr->rank;
					if($retWOD == '-') {
						$retWOD = "No more workouts for $t_date, go to another day!";
						$retTitle = "No Workout";
						$retID = "w_1";
					}
				}
			}
		}
	}
}	

$detail->id = $retID;
$detail->date = $t_date;
$detail->info = $retWOD;
$detail->title = $retTitle;

echo json_encode($detail);
$test->CloseConnection();

?>