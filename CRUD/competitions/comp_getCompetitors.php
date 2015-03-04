<?php require_once('../../Connections/cboxConn.php'); ?>
<?php

$c_id = $_POST['comp_id'];
$key = $_POST['key'];
class competitor {
	public $name = "";
	public $division = "";
	public $box = "";
	public $team_name = "";
}

$mysqli = new mysqli($hostname_cboxConn, $username_cboxConn, $password_cboxConn, $database_cboxConn);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$comp = new competitor();
if($key == "i") {
	if($stmt = $mysqli->prepare("select name, box, division from competition_athletes where comp_id = $c_id")) 
	{
		$stmt->execute();
		$stmt->store_result();
		$list_of_competitors = array();
		$num_of_rows = $stmt->num_rows;
		if($num_of_rows > 0) {
			$stmt->bind_result($atn, $box, $div);

			while ($stmt->fetch()) {
				$comp->name = $atn;
				$comp->division = $div;
				$comp->box = $box;
				
				//echo "BOUND: ".$wid." ". $sc ."\n ";
				//echo "LIST: ". $list->wod_id. " " .$list->score."\n ";
				
				$list_of_competitors[] = $comp;
				unset($comp);
			}
			$stmt->free_result();
			echo json_encode($list_of_competitors);
		}
		else {
			echo "1: No data";
		}
	} else {
			echo "2: " . $mysqli->error;
	}
} else {
	echo "not yet";
}
/*
if($stmt = $mysqli->prepare("select ca.name, ca.box, ca.division, ct.team_name
	from competition_athletes AS ca 
	join competition_teams AS ct on ca.team_id = ct.team_id 
	where ca.comp_id = '$c_id'")) 
{
	$stmt->execute();
	$stmt->store_result();
	$list_of_competitors = array();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($atn, $box, $div, $tna);

		while ($stmt->fetch()) {
			$comp->name = $atn;
			$comp->division = $div;
			$comp->box = $box;
			$comp->team_name = $tna;
			
			//echo "BOUND: ".$wid." ". $sc ."\n ";
			//echo "LIST: ". $list->wod_id. " " .$list->score."\n ";
			
			$list_of_competitors[] = $comp;
			unset($comp);
		}
		$stmt->free_result();
		//unset($stmt);
		echo json_encode($list_of_competitors);
	}
	else {
		echo "1: No data";
	}
} else {
		echo "2: " . $mysqli->error;
}
*/
$mysqli->close();
?>