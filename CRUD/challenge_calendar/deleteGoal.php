<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 01/19/15
 * Time: 4:14 PM
 */


include('../../CRUD/library/ChallengeCalendarUtility.php');

$ccu = new ChallengeCalendarUtility();
$ccu->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);

echo $ccu->DeleteGoal($_POST['gid']);

$ccu->CloseConnection();