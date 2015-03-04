<?php require_once('../../Connections/challenge_cal_Conn.php'); ?>
<?php
session_start();

$mysqli = new mysqli($hostname_challenge_cal, $username_challenge_cal, $password_challenge_cal, $database_challenge_cal);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$user_id = $_POST['id'];
//$user_id = $_SESSION["MM_user_id"];
$public = $_POST['public'];
$content = "";
if($stmt = $mysqli->prepare("SELECT first_name, email, city, state, 
		 picture_url, bio, fav_lift, fav_exercise
		FROM user_info ui JOIN user_pub_info upi ON ui.user_id = upi.user_id 
		WHERE ui.user_id = $user_id")) 
{
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	if($num_of_rows > 0) {
		$stmt->bind_result($fn, $email,  
			$city, $state, $purl, $bio, $fl, $fe);
		$content = "";
		while ($stmt->fetch()) {
			$content .= "<div>";
			if($public == "public") {
				$content .= "<h3>".$fn."'s Profile</h3>";
				
				$content .= "<img src=\"".$purl."\" class=\"user_picture\"/></div><div>";
				
				$content .= "<div id=\"basic_user_info\" class=\"user_update user_update_ext\">";
				$content .= "<p><span class=\"user_info_header\">Email: $email</span>";
				$content .= "<p><span class=\"user_info_header\">City: $city</span>";
				$content .= "<p><span class=\"user_info_header\">State: $state</span>";
				$content .= "</div>";
				
				$content .= "<div id=\"user_fav\" class=\"user_update user_update_ext\">";
				$content .= "<p><span class=\"user_info_header\">Bio: $bio</span>";
				$content .= "<p><span class=\"user_info_header\">Favorite Lift: $fl</span>";
				$content .= "<p><span class=\"user_info_header\">Favorite Exercise: $fe</span>";
				$content .= "</div>";
			} else {
				$content .= "<h3>Welcome, ".$fn."!</h3>";
				
				$content .= "<img src=\"".$purl."\" class=\"user_picture user_update_ext\"/>";
				$content .= '<input type="file" name="picture" id="picture"><br>';
				$content .= '<input type="button" value="Upload" onclick="submitNewPicture('.$user_id.')" /><p></p>';
				$content .= "<div id=\"user_fav\" class=\"user_update user_update_ext\">";
				$content .= "<p><span class=\"user_info_header\">Bio:</span>";
				$content .= "<textarea rows=\"6\" cols=\"75\" name=\"user_bio\" id=\"user_bio\"> ".$bio." </textarea><input type=\"submit\" value=\"Update Bio\" onclick=\"submitUserEdit(4, ".$user_id.");\"/></p>";
				$content .= "<p><span class=\"user_info_header\">Favorite Lift:</span>";
				$content .= "<input name=\"user_fav_lift\" id=\"user_fav_lift\" type=\"text\" value=\"".$fl."\"/><input type=\"submit\" value=\"Update Favorite Lift\" onclick=\"submitUserEdit(5, ".$user_id.");\"/></p>";
				$content .= "<p><span class=\"user_info_header\">Favorite Girl:</span>";
				$content .= "<input name=\"user_fav_exercise\" id=\"user_fav_exercise\" type=\"text\" value=\"".$fe."\"/><input type=\"submit\" value=\"Update Favorite Exercise\" onclick=\"submitUserEdit(6, ".$user_id.");\"/></p>";
				$content .= "</div>";
				
				
				
				
				$content .= "<div id=\"basic_user_info\" class=\"user_update \">";
				$content .= "<p><span class=\"user_info_header\">Email:</span>";
				if($email == '-') {
					$email = '';
				}
				if($city == '-') {
					$city = '';
				}
				if($state == '-') {
					$state = '';
				}
				if($bio == '-') {
					$bio = '';
				}
				if($fl == '-') {
					$fl = '';
				}
				if($fe == '-') {
					$fe = '';
				}
				$content .= "<input name=\"user_email\" id=\"user_email\" type=\"text\" value=\"".$email."\"/><input type=\"submit\" value=\"Change Email\" onclick=\"submitUserEdit(1, ".$user_id.");\"/></p>";
				$content .= "<p><span class=\"user_info_header\">City:</span>";
				$content .= "<input name=\"user_city\" id=\"user_city\" type=\"text\" value=\"".$city."\"/><input type=\"submit\" value=\"Update City\" onclick=\"submitUserEdit(2, ".$user_id.");\"/></p>";
				$content .= "<p><span class=\"user_info_header\">State:</span>";
				$content .= "<input name=\"user_state\" id=\"user_state\" type=\"text\" value=\"".$state."\"/><input type=\"submit\" value=\"Update State\" onclick=\"submitUserEdit(3, ".$user_id.");\"/></p>";
				$content .= "</div>";
			}
		}
		$stmt->free_result();
		echo $content;
	}
	else {
		echo "1: No data";
	}
} else {
		echo "2: " . $mysqli->error;
}

$mysqli->close();
?>