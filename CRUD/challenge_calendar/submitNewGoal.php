<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 01/19/15
 * Time: 3:47 PM
 */
session_start();
include('../../CRUD/library/ChallengeCalendarUtility.php');

$ccu = new ChallengeCalendarUtility();
$ccu->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);

$create_date = $_POST['goal_create_date'];
$targ_date = $_POST['goal_targ_date'];
$comp_date = $_POST['goal_comp_date'];
$goal = $_POST['goal_act_goal'];
$current = $_POST['goal_current'];
$uid = $_SESSION["MM_cal_user_id"];

//echo "$uid, $create_date, $goal, $current, $comp_date, $targ_date";

echo $ccu->InsertNewGoal($uid, $create_date, $goal, $current, $comp_date, $targ_date);

$ccu->CloseConnection();