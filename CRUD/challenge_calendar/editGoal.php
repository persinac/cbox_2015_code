<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 01/19/15
 * Time: 1:34 PM
 */


include('../../CRUD/library/ChallengeCalendarUtility.php');

$ccu = new ChallengeCalendarUtility();
$ccu->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);

$gid = $_POST['gid'];
$final_html = "";
$final_retVal = (object) array('html'=>'', 'title'=>'','fileNames'=>'');

$final_html .= '<div><form id="update_goal">';
$det = $ccu->GetGoalByID($gid);
for($i = 0; $i < 1; $i++) {
    $n_create_date = $det[$i]->create_date;
    $n_targ_date = $det[$i]->target_date;
    $n_comp_date = $det[$i]->completed_date;

    $final_retVal->title = $n_create_date;
    $final_html .= 'Created on: <b>'.$n_create_date.'</b>';
    $final_html .= '<p></p>Target Completion: <input type="text" name="goal_targ_date" id="goal_targ_date" value="';
    if($n_targ_date == "" || $n_targ_date == "0000-00-00") {
        $final_html .= '">';
    } else {
        $final_html .= '' . $n_targ_date . '">';
    }

    $final_html .= '<p></p>Actual Completion: ';
    $final_html .= '<input type="text" name="goal_comp_date" id="goal_comp_date" value="';
    if($n_comp_date == "" || $n_comp_date == "0000-00-00") {
        $final_html .= '">';
    } else {
        $final_html .= '' . $n_comp_date . '">';
    }
    $final_html .= '<p></p>Goal: <p></p><textarea rows="4" cols="100" id="goal_act_goal" name="goal_act_goal">';
    $final_html .= $det[$i]->goal;
    $final_html .= '</textarea>';
    $final_html .= 'Current (where are you at now?): <p></p><textarea rows="4" cols="100" id="goal_current" name="goal_current">';
    $final_html .= $det[$i]->current;
    $final_html .= '</textarea>';
    $final_html .= '';
}

$final_html .= '</form>';
$final_html .= '<a onclick="submitGoal('.$gid.')" class="btn btn-primary btn-large" > Update Goal </a>';
$final_html .= '<a onclick="deleteGoal('.$gid.')" class="btn btn-primary btn-large" > Delete Goal </a>';
$final_html .= '</div>';
$final_retVal->html = $final_html;
echo json_encode($final_retVal);
$ccu->CloseConnection();