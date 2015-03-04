<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 01/19/15
 * Time: 3:21 PM
 */

include('../../CRUD/library/ChallengeCalendarUtility.php');

$ccu = new ChallengeCalendarUtility();
$ccu->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);

$targ_date = $_POST['goal_targ_date'];
$comp_date = $_POST['goal_comp_date'];
$goal = $_POST['goal_act_goal'];
$current = $_POST['goal_current'];
$gid = $_POST['gid'];

echo $ccu->UpdateUserGoal($gid, $targ_date, $comp_date, $goal, $current);

$ccu->CloseConnection();