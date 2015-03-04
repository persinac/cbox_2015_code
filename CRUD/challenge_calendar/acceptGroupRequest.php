<?php require_once('../../Connections/challenge_cal_Conn.php');
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/07/14
 * Time: 11:25 AM
 *
 * Returns:
 *  0 if could not accept friend request
 *  1 if successful
 *  2 if could accept group request but not join the group
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

$join_date = Date('Y-m-d');

$retVal = $group->AcceptGroupRequest($user_id, $group_id);
if($retVal == 1) {
    $retVal = $group->JoinGroup($user_id, $group_id, $join_date);
    if($retVal != 1) {
        $retVal = 2;
    }
}
echo $retVal;
$group->CloseConnection();