<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/04/14
 * Time: 3:22 PM
 */
include('../../CRUD/library/friends.php');
include('../../CRUD/library/groups.php');

$group_id = $_POST['id'];
$loc = $_POST['loc'];

$group_util = new Groups();

$group_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
echo $group_util->UpdateGroupLocation($group_id, $loc);
