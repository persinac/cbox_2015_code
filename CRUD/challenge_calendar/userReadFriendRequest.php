<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/06/14
 * Time: 1:21 PM
 */

include('../../CRUD/library/friends.php');

$user_id = $_POST['uid'];
$friend_util = new Friends();
$friend_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
echo "user id: $user_id\n";
$retVal = $friend_util->UpdateAllFriendRequests($user_id);
echo $retVal;
$friend_util->CloseConnection();