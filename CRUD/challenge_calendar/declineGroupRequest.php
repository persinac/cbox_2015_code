<?php require_once('../../Connections/challenge_cal_Conn.php');
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/07/14
 * Time: 11:38 AM
 *
 * Returns:
 *  0 if could not decline group request
 *  1 if successful
 */


include('../../CRUD/library/groups.php');
session_start();

$group = new Groups();
$group->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);
$user_id = $_POST['user_id'];
$group_id = $_POST['gr_id'];

$retVal = $group->DeclineGroupRequest($user_id, $group_id);
echo $retVal;
$group->CloseConnection();