<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 12/15/14
 * Time: 2:55 PM
 */

include('../../CRUD/library/riot_api.php');
include('../../CRUD/library/array_utilities.php');

$all_champs = new LeagueChampions();
$all_champs->SetRegion("na");

$retVal = $all_champs->PrintAllChampions();

$obj = json_decode($retVal);

foreach($obj AS $i=>$val) {
    $final_html .= '<div class="col-lg-12">';
    $final_html .= "<p>I: $i, VAL: $val</p>";
    $final_html .= '</div>';
}
