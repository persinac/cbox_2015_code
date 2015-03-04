<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();
include('../../CRUD/library/workouts_utility.php');

$t_new_date = $_POST['newDate'];
$t_old_date = $_POST['oldDate'];
$t_user_id = $_POST['uid'];
$type_of_workout = $_POST['w'];
$wid = $_POST['wid'];

$column = "";
$detail = "";

$workoutUtil = new WorkoutsUtility();
$workoutUtil->NewConnection($hostname_challenge_cal,
		$username_challenge_cal, 
		$password_challenge_cal, 
		$database_challenge_cal);

if($type_of_workout == 'w') {
	$detail = $workoutUtil->GetWarmups($t_user_id, $t_old_date, $wid);
	$column = "warmup";
} else if($type_of_workout == 'str') {
	$detail = $workoutUtil->GetStrength($t_user_id, $t_old_date, $wid);
	$column = "strength";
} else if($type_of_workout == 'con') {
	$detail = $workoutUtil->GetConditioning($t_user_id, $t_old_date, $wid);
	$column = "conditioning";
} else if($type_of_workout == 'spe') {
	$detail = $workoutUtil->GetSpeed($t_user_id, $t_old_date, $wid);
	$column = "speed";
} else if($type_of_workout == 'core') {
	$detail = $workoutUtil->GetCore($t_user_id, $t_old_date, $wid);
	$column = "core";
}

$retVal = -1;
$opt = " AND date = '$t_new_date'";
$workouts = $workoutUtil->BuildWorkouts($t_user_id, $opt);
$t_warmup = "";
$t_strength = "";
$t_conditioning = "";
$t_speed = "";
$t_core = "";
if(sizeof($workouts) > 0) {
    foreach ($workouts AS $key => $val) {
        //echo "ID: ".$val->id . "\n";
        //echo $val->description."\n";
        if (strpos($val->id, "w_") > -1) {
            $t_warmup = $val->description;
            if($column == "warmup") {
                $t_warmup .= "<p></p>" . $detail;
            }
        } else if (strpos($val->id, "str") > -1) {
            $t_strength = $val->description;
            if($column == "strength") {
                $t_strength .= "<p></p>" .$detail;
            }
        } else if (strpos($val->id, "con") > -1) {
            $t_conditioning = $val->description;
            if($column == "conditioning") {
                $t_conditioning .= "<p></p>" .$detail;
            }
        } else if (strpos($val->id, "spe") > -1) {
            $t_speed = $val->description;
            if($column == "speed") {
                $t_speed .= "<p></p>" . $detail;
            }
        } else if (strpos($val->id, "core") > -1) {
            $t_core = $val->description;
            if($column == "core") {
                $t_core .= "<p></p>" . $detail;
            }
        }
    }
    $retVal = $workoutUtil->DeleteWorkout($t_user_id, $t_new_date);
    //echo "Delete workout on: $t_new_date ";
    //echo "If delete fails, return 2. Else insert workout with the following values: \n";
    //echo "$t_user_id, $t_warmup, $t_strength, $t_conditioning, $t_speed, $t_core, $t_rest, $t_new_date";
    if($retVal == 1) {
        $retVal = $workoutUtil->InsertWorkout($t_user_id, $t_warmup, $t_strength, $t_conditioning, $t_speed, $t_core, $t_rest, $t_new_date);
    } else {
        $retVal = 2;
    }
} else {
    //echo "No existing workout, so just perform an insert: $t_user_id, $t_new_date, $detail, $column\n";
    $retVal = $workoutUtil->InsertSpecificWorkout($t_user_id, $t_new_date, $detail, $column);
}

echo $retVal;
$workoutUtil->CloseConnection();
?>