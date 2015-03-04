<?php require_once('../../Connections/challenge_cal_Conn.php');
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/07/14
 * Time: 2:25 PM
 *
 * Returns:
 *  99 if GetMaxWorkoutID doesn't execute correctly
 *  -1 if InsertWorkout didn't even execute
 *  0 if InsertWorkout executed but encountered an error
 *  1 if InsertWorkout executed successfully
 */
include('../../CRUD/library/groups.php');
$date = $_POST['date'];
$warmup = replaceNewLine($_POST['warmUp']);
$strength = replaceNewLine($_POST['strength']);
$conditioning = replaceNewLine($_POST['conditioning']);
$speed = replaceNewLine($_POST['speed']);
$core = replaceNewLine($_POST['core']);
$mob = replaceNewLine($_POST['mob']);
$rest = "";
$group_id = $_POST['gid'];

$retVal = -1;

$group = New Group_Workouts();

$group->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);

$wid = $group->GetMaxWorkoutID($group_id, $date);
if($wid == -1) {
    $retVal = $group->InsertWorkout($group_id, 1, $date, $warmup, $strength,
        $conditioning, $speed, $core, $mob);
} else if($wid > -1 && $wid < 99) {
    $retVal = $group->InsertWorkout($group_id, ($wid + 1), $date, $warmup, $strength,
        $conditioning, $speed, $core, $mob);
} else {
    $retVal = 99;
}

echo $retVal;

$group->CloseConnection();

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
