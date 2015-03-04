<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 02/24/15
 * Time: 2:02 PM
 */

class AdminLog {
    public $mys;

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

    function InsertIntoLog($class, $function, $description) {
        $query = "INSERT INTO log VALUES(?,?,?,?)";
        $retVal = 0;
        $log_date = date('Y-m-d h:i:s');
        $stmt = $this->mys->prepare($query);
        $stmt->bind_param( 'ssss', $function, $class, $description, $log_date);
        if($result = $stmt->execute()) {
            $stmt->close();
            $retVal = 1;
        } else {
            $retVal = 0;
        }
        return $retVal;
    }
}