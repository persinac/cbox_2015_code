<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/05/14
 * Time: 2:22 PM
 */
include('../../CRUD/library/friends.php');
include('../../CRUD/library/groups.php');

$group_id = $_POST['group_id'];
$user_ids = $_POST['user_ids'];
$group_util = new Groups();
/*
 * if manage == 0... the page is being managed by an admin
 * else... the page is being viewed
 */
$group_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);

$ids = explode(',', $user_ids);
foreach ($ids as $value) {
    if($value > 0) {
        $retVal = $group_util->GroupRequestUser($group_id, $value);
        echo $retVal . ",";
    }

}