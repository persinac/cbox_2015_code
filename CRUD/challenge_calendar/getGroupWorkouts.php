<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/13/14
 * Time: 3:59 PM
 */

include('../../CRUD/library/groups.php');

$t_date = $_POST['date'];
$t_user_id = $_POST['uid'];
//$t_user_id = $_SESSION["MM_user_id"];
$test = new Group_Workouts();
$test->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);

$opt = "";
if($test->BuildGroupWorkouts($t_user_id, $opt) == 1) {
    echo json_encode($test->GetGroupWorkouts());
}


function replaceNewLine($str) {
    $t_desc = $str;
    $found_newline = false;
    $string_builder = "";
    $emergency_exit = 0;
    while(strstr($t_desc, PHP_EOL)) {
        $string_builder .= "<p>" . substr($t_desc, 0, strpos($t_desc, PHP_EOL)) . "</p>";
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
    return $string_builder;
}