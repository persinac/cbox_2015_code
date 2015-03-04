<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/19/14
 * Time: 4:08 PM
 */

include('../../CRUD/library/groups.php');

$group_id = $_POST['group_id'];
$wid = $_POST['wid'];
$date = $_POST['date'];

$final_html = "";

$group_util = New Group_Workouts();
$group_util->NewConnection($hostname_challenge_cal,
    $username_challenge_cal,
    $password_challenge_cal,
    $database_challenge_cal);

$value = $group_util->BuildGroupWorkoutDetails($group_id, $wid, $date);

//static variables:
$group_name = '';
$desc = '';
$warm_up = '';
$strength = '';
$conditioning = '';
$speed = '';
$core = '';
$mob = '';

if($value == 1) {
    $det = $group_util->GetGroupWorkouts();
    foreach($det AS $key => $val) {
        $group_name = $val->group_name;
        $date = $val->t_date;

        $warm_up = $val->warmup;
        $strength = $val->strength;
        $conditioning = $val->conditioning;
        $speed = $val->speed;
        $core = $val->core;
        $mob = $val->mobility;
    }
    $final_html .= '<div class="row">';
    $final_html .= '<div class="col-lg-6">';
    $final_html .= '<h3>' . $group_name . '</h3>';
    $final_html .= '<h3>' . $date . '</h3>';
    $final_html .= '</div>';
    $final_html .= '</div>';

    $final_html .= '<div class="row">';
    $final_html .= '<div class="col-lg-4">';
    $final_html .= '<h4>Warm-up</h4>';
    $final_html .= $warm_up;
    $final_html .= '</div>';
    $final_html .= '<div class="col-lg-4">';
    $final_html .= '<h4>Strength</h4>';
    $final_html .= $strength;
    $final_html .= '</div>';
    $final_html .= '<div class="col-lg-4">';
    $final_html .= '<h4>Conditioning</h4>';
    $final_html .= $conditioning;
    $final_html .= '</div>';
    $final_html .= '</div>';

    $final_html .= '<div class="row">';
    $final_html .= '<div class="col-lg-4">';
    $final_html .= '<h4>Speed</h4>';
    $final_html .= $speed;
    $final_html .= '</div>';
    $final_html .= '<div class="col-lg-4">';
    $final_html .= '<h4>Core</h4>';
    $final_html .= $core;
    $final_html .= '</div>';
    $final_html .= '<div class="col-lg-4">';
    $final_html .= '<h4>Mobility</h4>';
    $final_html .= $mob;
    $final_html .= '</div>';
    $final_html .= '</div>';
}
echo $final_html;
$group_util->CloseConnection();