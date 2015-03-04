<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 10/16/14
 * Time: 11:25 AM
 */

include('../../CRUD/library/groups.php');
session_start();
$group_util = new Groups();

try {
    $group_util->CloseConnection();
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$group_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
$user_id = $_POST['user_id'];
//$friend_id = $_POST['fr_id'];
$group_name = $_POST['group_name'];
$invite_only = $_POST['invite'];
if($invite_only == "yes") {
    $invite_only = 1;
} else {
    $invite_only = 0;
}
//echo "INVITE: " . $invite_only . "\n";
$location = $_POST['group_location'];
$group_util->SetMaxGroupID();
$retVal = $group_util->CreateNewGroup($user_id);
if($retVal == 1) {
    $retVal = $group_util->InsertNewGroupDetail($user_id,$group_name,$invite_only,$location);
} else {
    $retVal = 99;
}
echo $retVal;
$group_util->CloseConnection();