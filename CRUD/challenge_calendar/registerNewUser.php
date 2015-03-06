<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 03/06/15
 * Time: 10:08 AM
 */
include_once("../../CRUD/library/ChallengeCalendarUtility.php");


$ccu = new ChallengeCalendarUtility();

$ccu->NewConnection($hostname_challenge_cal
    , $username_challenge_cal
    , $password_challenge_cal
    , $database_challenge_cal);

$ccu->SetChallengeUserID($ccu->GetMaxChallengeUserID());

$t_firstname = mysql_real_escape_string($_POST['first_name']);
$t_lastname = mysql_real_escape_string($_POST['last_name']);
$t_email = mysql_real_escape_string($_POST['email']);
$t_city = mysql_real_escape_string($_POST['city']);
$t_state= mysql_real_escape_string($_POST['state']);
$t_gender = mysql_real_escape_string($_POST['gender']);

$t_username = mysql_real_escape_string($_POST['username']);
$t_password = mysql_real_escape_string($_POST['password']);

$opts = Array(
    "un"=>$t_username,
    "pw"=>$t_password,
    "first"=>$t_firstname,
    "last"=>$t_lastname,
    "email"=>$t_email,
    "gen"=>$t_gender,
    "city"=>$t_city,
    "state"=>$t_state
);

$retVal = $ccu->InsertNewUser(0, $opts);
//echo "RETVAL: ".$retVal;

echo $retVal;
$ccu->CloseConnection();

