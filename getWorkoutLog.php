<?php require_once('Connections/cboxConn.php'); ?>
<?php
class log {
	public $id = 0;
	public $title = "";
	public $start = "";
	public $end = "";
	public $description  = "";
	public $color = "";
   }

$mysqli = new mysqli($hostname_cboxConn, $username_cboxConn, $password_cboxConn, $database_cboxConn);
$t_id = $_POST['id'];
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$table = "alex";
if($t_id == "1") {
	$table = "bryce";
}

$query = "select  DISTINCT DATE_FORMAT(date, '%Y-%m-%d') AS date,
strength,
conditioning,
speed,
core
from  workout_log where user_id = $t_id";
///echo "QUERY: " . $query;
if ($result2 = $mysqli->query($query)) {
	$cars = array();
	$index = 1;
	$description = "";
	 /* fetch associative array */
   while ($row = $result2->fetch_assoc()) {
		$w = new log();
		if(strlen($row["strength"]) > 0) {
			$description .= "<h4>Strength</h4>".$row["strength"]."<p></p>";
		}
		if(strlen($row["conditioning"]) > 0) {
			$description .= "<h4>Conditioning</h4>".$row["conditioning"]."<p></p>";
		}
		if(strlen($row["speed"]) > 0) {
			$description .= "<h4>Speed</h4>".$row["speed"]."<p></p>";
		}
		if(strlen($row["core"]) > 0) {
			$description .= "<h4>Core</h4>".$row["core"]."<p></p>";
		}
		
			$w->id = $index;
			$w->start = $row["date"] . "T12:00:00";
			$w->end = $row["date"] . "T12:59:00";
			$w->title = "Log for " . $row["date"];
			$w->description = $description;
			$w->color = "red";
		
			$w->description = $description;
			$cars[] = $w;
			$description = "";
    }
	//echo "END";
	echo json_encode($cars);
	    /* free result set */
    $result2->free();
}
/* close connection */
$mysqli->close();
?>