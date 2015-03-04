<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/05/14
 * Time: 1:46 PM
 */
include('../../CRUD/library/friends.php');
include('../../CRUD/library/groups.php');

$group_id = $_POST['group_id'];

$group_util = new Groups();
/*
 * if manage == 0... the page is being managed by an admin
 * else... the page is being viewed
 */
$group_util->NewConnection($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
$group_util->BuildMembersNotInGroup($group_id);
$final_html = "";

$det = $group_util->GetGroupMembers();
//var_dump($det);
$final_html = '';
foreach($det AS $key => $val) {
    $final_html .= '<div class="col-lg-4 text-center grp_inv">';
    $final_html .= '<img src="'.$val->picture_url.'" class="user_picture_browse"><br>';
    $final_html .= '<b>' . $val->full_name . '</b><br>';
    if($val->invited == 1){
        $final_html .= '<input type="checkbox" name="chkbox_user_to_add" disabled="disabled" checked="checked" value="-1">';
    } else {
        $final_html .= '<input type="checkbox" name="chkbox_user_to_add" value="'.$val->user_id.'">';
    }
    $final_html .= '</div>';
}

echo $final_html;
$group_util->CloseConnection();