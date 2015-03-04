<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/06/14
 * Time: 11:14 AM
 */

include('../../CRUD/library/friends.php');

$user_id = $_POST['id'];
$friend_util = new Friends();
$friend_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);

$friend_util->BuildUnreadFriendRequests($user_id);
//echo $friend_util->GetUnreadFriendRequests();
if($friend_util->HasUnreadFriendRequests() == true) {
    echo 1;
} else {
    echo 0;
}
$friend_util->CloseConnection();