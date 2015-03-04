<?php 
class ChallengeCalendarUtility {
	public $mys;
	var $chall_user_id = 0;
	
	function NewConnection($host, $user, $pass, $database) {
		$this->mys = mysqli_connect($host, $user, $pass, $database);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
	
	function CloseConnection() {
		try {
			mysqli_close($this->mys);
			return true;
		} catch (Exception $e) {
			printf("Close connection failed: %s\n", $this->mys->error);
		}
	}
	
	/*************** GETTERS AND SETTERS *****************/
	
	/*
	 * Sets chall_user_id
	 * params:
	 *	@u - user_id, passes in the current MAX chall_user_id, so I must add 1
	 */
	function SetChallengeUserID($u) {
		$this->chall_user_id = $u + 1;
	}
	
	function GetChallengeUserID() {
		return $this->chall_user_id;
	}
	
	function GetMaxChallengeUserID() {
		$max_id = -1;
		$query = "select max(user_id) AS user_id from user_info";		
		if ($result = $this->mys->query($query)) {
		   while ($row = $result->fetch_assoc()) {
				$max_id = $row['user_id'];
			}
			$result->free();
		}
		return $max_id;
	}

	function GetUserGoals($uid) {
		$x = array();
		$query = "SELECT goal_id, create_date, goal,
				current, completed_date,
				target_date
				FROM goals WHERE user_id = $uid";
		if ($result = $this->mys->query($query)) {
			while ($row = $result->fetch_assoc()) {
				$detail = (object) array('goal_id'=>'', 'create_date' => '',
					'goal' => '', 'current'=>''
				, 'completed_date' => '', 'target_date'=>'');
				$detail->goal_id = $row["goal_id"];
				$detail->create_date = $row["create_date"];
				$detail->goal = $row["goal"];
				$detail->current = $row["current"];
				$detail->completed_date = $row["completed_date"];
				$detail->target_date = $row["target_date"];
				$x[] = $detail;
			}
			$result->free();
		}
		return $x;
	}

	function GetGoalByID($gid) {
		$x = array();
		$query = "SELECT create_date, goal,
				current, completed_date,
				target_date
				FROM goals WHERE goal_id = $gid";
		if ($result = $this->mys->query($query)) {
			while ($row = $result->fetch_assoc()) {
				$detail = (object) array('create_date' => '',
					'goal' => '', 'current'=>''
				, 'completed_date' => '', 'target_date'=>'');
				$detail->create_date = $row["create_date"];
				$detail->goal = $row["goal"];
				$detail->current = $row["current"];
				$detail->completed_date = $row["completed_date"];
				$detail->target_date = $row["target_date"];
				$x[] = $detail;
			}
			$result->free();
		}
		return $x;
	}

	function InsertNewUser($cbox_id, $args) {
		//echo "\n".$cbox_id .', '.$args['un'].', '.$args['pw']."\n";
		$this->InsertIntoLogin($cbox_id, $args['un'], $args['pw']);
		$this->InsertIntoUserInfo(
			$args['first'],
			$args['last'],
			$args['email'],
			$args['gen'],
			$args['city'],
			$args['state']
		);
		$this->InsertIntoUserPubInfo($this->chall_user_id);
	}
	
	function InsertIntoLogin($cbox_id, $un, $pw) {
		//echo "\n$cbox_id, $un, $pw\n";
		$stmt = $this->mys->prepare("insert into login values (?, ?, ?, ?)");
		$stmt->bind_param( 'issi', $this->chall_user_id, $un, $pw, $cbox_id);
		if($result = $stmt->execute()) {
			$stmt->close();
		} else {
			echo "Error: Could not insert into Challenge Calendar Login";
		}
	}
	
	function InsertIntoUserInfo($fn, $ln, $em, $gen, $city, $state) {
		$stmt = $this->mys->prepare("insert into user_info values (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param( 'issssss', $this->chall_user_id, $fn, $ln, $em, $gen, $city, $state);
		if($result = $stmt->execute()) {
			$stmt->close();
		} else {
			echo "Error: Could not insert into Challenge Calendar User Info";
		}
	}
	
	function InsertIntoUserPubInfo() {
		$t_val = '-';
		$stmt = $this->mys->prepare("insert into user_pub_info values (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param( 'isssss', $this->chall_user_id, $t_val, $t_val, $t_val, $t_val, $t_val, $t_val);
		if($result = $stmt->execute()) {
			$stmt->close();
		} else {
			echo "Error: Could not insert into Challenge Calendar User Pub Info";
		}
	}

	function UpdateUserGoal($gid, $targ, $comp, $act, $curr) {
		//echo "update: $gid, $targ, $comp, $act, $curr";
		$stmt = $this->mys->prepare("UPDATE goals
		 	SET goal = ?,
		 	current = ?,
		 	completed_date = ?,
			target_date = ?
			WHERE goal_id = ?");
		$stmt->bind_param( 'ssssi', $act, $curr, $comp, $targ, $gid);
		if($result = $stmt->execute()) {
			$stmt->close();
			return 1;
		} else {
			return 0;
		}
	}

	function InsertNewGoal($uid, $create_date, $goal, $current, $comp_date, $targ_date) {
		$new_id = $this->GetMaxGoalID();
		$measure = 1;
		if($new_id > 0) {
			$stmt = $this->mys->prepare("insert into goals values (?, ?,
										?, ?, ?,
										?, ?, ?)");
			$stmt->bind_param( 'iississs', $new_id, $uid, $create_date, $goal
				, $measure, $current, $comp_date, $targ_date);
			if($result = $stmt->execute()) {
				$stmt->close();
				return 1;
			} else {
				return 0;
			}
		} else {
			return 2;
		}
	}

	function DeleteGoal($gid) {
		$stmt = $this->mys->prepare("DELETE FROM goals WHERE goal_id = ?");
		$stmt->bind_param( 'i', $gid);
		if($result = $stmt->execute()) {
			$stmt->close();
			return 1;
		} else {
			return 0;
		}
	}

	function GetMaxGoalID() {
		$x = -1;
		$query = "SELECT MAX(goal_id) AS goal_id
				FROM goals";
		$this->mys->next_result();
		if ($result = $this->mys->query($query)) {
			while ($row = $result->fetch_assoc()) {
				$x = $row['goal_id'] + 1;
			}
			$result->free();
		}
		return $x;
	}
}
?>