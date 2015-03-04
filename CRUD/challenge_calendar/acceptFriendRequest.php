<?php require_once('../../Connections/challenge_cal_Conn.php');
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 10/15/14
 * Time: 4:11 PM
 */

include('../../CRUD/library/friends.php');
session_start();

$friend_util = new Friends();
$friend_util->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);
$user_id = $_POST['user_id'];
$friend_id = $_POST['fr_id'];

$retVal = $friend_util->InsertNewFriend($user_id, $friend_id, 1);
if($retVal == 1) {
    //have to reverse the id's in order to have a mutual friendship
    $retVal = $friend_util->InsertNewFriend($friend_id, $user_id, 1);
    if($retVal == 1) {
        $retVal = $friend_util->UpdateFriendRequest($user_id, $friend_id);
    } else {
        $retVal = 3;
    }
} else {
    $retVal = 2;
}

echo $retVal;
$friend_util->CloseConnection();