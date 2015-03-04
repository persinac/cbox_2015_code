<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 10/16/14
 * Time: 9:40 AM
 */

include('../../CRUD/library/friends.php');
session_start();
$friend_util = new Friends();
$friend_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
$user_id = $_POST['user_id'];
$friend_id = $_POST['fr_id'];

$retVal = $friend_util->SendFriendRequest($user_id, $friend_id);
echo $retVal;
$friend_util->CloseConnection();