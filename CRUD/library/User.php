<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 11/06/14
 * Time: 10:55 AM
 */

class User {
    public $mys;
    private $user_id;
    private $first_name;
    private $last_name;
    private $email;

    private $host, $user, $pass, $database;

    function NewConnection() {
        $this->mys = mysqli_connect($this->host, $this->user, $this->pass, $this->database);
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

    function __construct($id = -1, $host = "", $user = "", $pass = "", $database = "") {
        $this->id = $id;
        $this->host = $host;
        $this->host = $user;
        $this->host = $pass;
        $this->host = $database;
    }

    function SetUserID($i) {
        $this->user_id = $i;
    }

    function GetUserID() {
        return $this->user_id;
    }

    function BuildFriendRequests() {

    }

    function BuildGroupRequests() {

    }

    function GetFriendRequests(){

    }

    function GetGroupRequests()
    {

    }
}
class NewUser extends User
{

}