<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();
include('../../CRUD/library/activity_feed_util.php');
include('../../CRUD/library/workouts_utility.php');
$testDB = new ActivityLogConnection();
$workoutUtil = new WorkoutsUtility();
$date = $_POST['date'];
$warmup = replaceNewLine($_POST['warmUp']);
$strength = replaceNewLine($_POST['strength']);
$conditioning = replaceNewLine($_POST['conditioning']);
$speed = replaceNewLine($_POST['speed']);
$core = replaceNewLine($_POST['core']);
$rest = "";
$user_id = $_POST['uid'];
$modify = $_POST['mod'];

$retVal = -1;

$temp_activites = Array(
	"warmup"=>$warmup,
	"strength"=>$strength,
	"conditioning"=>$conditioning,
	"speed"=>$speed,
	"core"=>$core
);
$testDB->SetNewWorkoutActivities($temp_activites);
$testDB->NewConnection($hostname_challenge_cal, 
		$username_challenge_cal, 
		$password_challenge_cal, 
		$database_challenge_cal);
$workoutUtil->NewConnection($hostname_challenge_cal, 
		$username_challenge_cal, 
		$password_challenge_cal, 
		$database_challenge_cal);
$testDB->SetUserFullName($user_id);
$testDB->SetUserID($user_id);

$opt = " AND date = '$date'";
$workouts = $workoutUtil->BuildWorkouts($testDB->GetUserID(), $opt);
$t_warmup = "";
$t_strength = "";
$t_conditioning = "";
$t_speed = "";
$t_core = "";
if(sizeof($workouts) > 0) {
    if($modify == -1) {
        $retVal = 9; //will cause prompt to open up for user to choose "cancel", "add", or "overwrite"
    } else if($modify > 0) { //user has chosen "add" or "overwrite"
        echo "modify: $modify";
        if($modify == 1) {
            foreach ($workouts AS $key => $val) {
                echo "ID: ".$val->id . "\n";
                echo $val->description."\n";
                if (strpos($val->id, "w_") > -1) {
                    $t_warmup = $val->description . "<p></p>" . $warmup;
                    $warmup = $t_warmup;
                } else if (strpos($val->id, "str") > -1) {
                    $t_strength = $val->description . "<p></p>" . $strength;
                    $strength = $t_strength;
                } else if (strpos($val->id, "con") > -1) {
                    $t_conditioning = $val->description . "<p></p>" . $conditioning;
                    $conditioning = $t_conditioning;
                } else if (strpos($val->id, "spe") > -1) {
                    $t_speed = $val->description . "<p></p>" . $speed;
                    $speed = $t_speed;
                } else if (strpos($val->id, "core") > -1) {
                    $t_core = $val->description . "<p></p>" . $core;
                    $core = $t_core;
                }
            }
        }
        $retVal = $workoutUtil->DeleteWorkout($user_id, $date);
        if($retVal == 1) {
            $retVal = $workoutUtil->InsertWorkout($user_id, $warmup, $strength, $conditioning, $speed, $core, $rest, $date);
        } else {
            $retVal = 2;
        }

    }
} else {
    $retVal = $workoutUtil->InsertWorkout($user_id, $warmup, $strength, $conditioning, $speed, $core, $rest, $date);
}

echo $retVal;

$workoutUtil->CloseConnection();
$testDB->CloseConnection();

function replaceNewLine($str) {
	$t_desc = trim($str);
	$found_newline = false;
	$string_builder = "";
	$emergency_exit = 0;
	//echo "replaceNewLine: ".$t_desc."\n";
	while(strstr($t_desc, PHP_EOL)) {
		//echo "PHP_EOL: " . strpos($t_desc, PHP_EOL) . ", n: " .strpos($t_desc, "\n"). ", r: " .strpos($t_desc, "\r")."\n";
		$string_builder .= "<p>" . substr($t_desc, 0, strpos($t_desc, PHP_EOL)-1) . "</p>";
		//echo "PHP_EOL: " . strpos($string_builder, PHP_EOL) . ", n: " .strpos($string_builder, "\n"). ", r: " .strpos($string_builder, "\r")."\n";
		$t_desc = substr($t_desc, strpos($t_desc, PHP_EOL)+1);
		$found_newline = true;
		$emergency_exit = $emergency_exit + 1;
		if($emergency_exit == 100) {
			echo "Too many new lines, exiting...";
			exit();
		}
	}
	if($found_newline == true) {
		$string_builder .= "<p>" . $t_desc . "</p>";
		
	} else {
		$string_builder = $t_desc;
	}
	//echo "replaceNewLine: ".$string_builder."\n";
	return $string_builder;
}


?>