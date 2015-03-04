<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 01/19/15
 * Time: 11:38 AM
 */
session_start();
include('../../CRUD/library/ChallengeCalendarUtility.php');

$ccu = new ChallengeCalendarUtility();
$ccu->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);

$final_html = "";

$final_html .= '<div id="goal_hdr_row" class="row">';
$final_html .= '<div id="goal_hdr_col" class ="col-lg-12"> <h3>Goals: </h3>';
$final_html .='</div><!-- END hdr col --></div><!-- END hdr row -->';

$final_html .= '<div id="goal_gls_row" class="row">';
$final_html .= '<table id="list_of_goals" class="table table-striped">';
$final_html .= '<thead><tr>';
$final_html .= '<th>Created</th>';
$final_html .= '<th>Target Date</th>';
$final_html .= '<th>Goal</th>';
$final_html .= '<th>Current</th>';
$final_html .= '<th>Completed On</th>';
$final_html .= '<th> </th>';
$final_html .= '<th></th>';
$final_html .= '</tr></thead>';
$final_html .= '<tbody>';

if($_POST['user_id'] > -1 ) {
    $uid = $_POST['user_id'];
} else {
    $uid = $_SESSION['MM_cal_user_id'];
}
$det = $ccu->GetUserGoals($uid);
foreach($det AS $i=>$val) {
    $target_date = $val->target_date;
    $compl_date = $val->completed_date;

    $final_html .= '<tr>';
    $final_html .= '<td>' . $val->create_date . '</td>';
    $final_html .= '<td>';
    if($target_date == "" || $target_date == "0000-00-00") {
        $final_html .= ' - ';
    } else {
        $final_html .= $target_date;
    }
    $final_html .= '</td>';
    $final_html .= '<td>' . $val->goal . '</td>';
    $final_html .= '<td>' . $val->current . '</td>';
    $final_html .= '<td>';
    if($compl_date == "" || $compl_date == "0000-00-00") {
        $final_html .= ' - ';
    } else {
        $final_html .= $compl_date;
    }
    $final_html .= '</td>';
    $final_html .= '<td> <button type="button" class="btn btn-default btn-sm" onclick="editGoal('.$val->goal_id.')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td> ';
    $final_html .= '</tr>';
}
$final_html .= '<tr>';
$final_html .= '<td> </td>';
$final_html .= '<td> </td>';
$final_html .= '<td> </td>';
$final_html .= '<td> </td>';
$final_html .= '<td> </td>';
$final_html .= '<td><button type="button" class="btn btn-default btn-sm" onclick="addGoal()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></td>';
$final_html .= '</tr>';
$final_html .= '</tbody></table>';
$final_html .='</div><!-- END hdr row -->';


echo $final_html;
$ccu->CloseConnection();