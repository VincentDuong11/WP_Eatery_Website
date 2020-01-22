<?php

class WebsiteUser
{
    /* Host address for the database */

    protected static $DB_HOST = 'localhost:8889';
    protected static $DB_USERNAME = 'root';
    protected static $DB_PASSWORD = 'root';
    protected static $DB_DATABASE = 'wp_eatery';
    
    private $username;
    private $password;
    private $mysqli;
    private $dbError;
    private $authenticated = false;
    private $lastLogin;
    private $adminId;
    
    public function __construct()
    {
        $this->mysqli = new mysqli(
            self::$DB_HOST,
            self::$DB_USERNAME,
                self::$DB_PASSWORD,
            self::$DB_DATABASE
        );
        if ($this->mysqli->errno) {
            $this->dbError = true;
        } else {
            $this->dbError = false;
        }
    }
    public function authenticate($username, $password)
    {
        $loginQuery = "SELECT * FROM adminusers WHERE username = ? AND password = ?";
        $stmt = $this->mysqli->prepare($loginQuery);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $this->username = $username;
            $this->password = $password;
            $this->authenticated = true;
        }
        $stmt->free_result();
    }

    public function getData()
    {
        $loginQuery = "SELECT * FROM adminusers WHERE username = ? AND password = ?";
        $stmt = $this->mysqli->prepare($loginQuery);
        $stmt->bind_param('ss', $this->username, $this->password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public function isAuthenticated()
    {
        return $this->authenticated;
    }
    public function hasDbError()
    {
        return $this->dbError;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getAdminId()
    {
        $res = $this->getData();
        $admin = mysqli_fetch_assoc($res);
        return $admin['AdminID'];
    }

    public function getLastLogin()
    {
        $res = $this->getData();
        $admin = mysqli_fetch_assoc($res);
        return $admin['LastLogin'];
    }
    public function updateLoginDate()
    {
        $loginQuery = "UPDATE adminusers SET LastLogin = now() WHERE Username = ?";
        $stmt = $this->mysqli->prepare($loginQuery);
        $stmt->bind_param('s', $this->username);
        $stmt->execute();
    }
}
