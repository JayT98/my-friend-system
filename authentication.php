<?php

/**
 * Handle Authentication
 */
class Authentication
{
    private $db;
    private $userId;
    private $authKey;

    /**
     * Constructor
     * @param Database $db *DB object*
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Updates the session
     * @param int $userId *Account ID*
     * @param string $authKey *Key*
     */
    private function updateSession($userId, $authKey)
    {
        $authSession = array();
        $authSession["USER_ID"] = $userId;
        $authSession["KEY"] = $authKey;
        $_SESSION["AUTH_SESSION"] = $authSession;
    }

    /**
     * Check an email is registered already or not.
     * @param string $email *Email*
     * @return bool
     */
    public function checkRegister($email)
    {
        $dbConn = $this->db->getNewConnection();
        $isRegister = true;

        $getEmailQuery = "SELECT friend_email FROM friends WHERE friend_email = '$email'";
        $result = mysqli_query($dbConn, $getEmailQuery);
        if (mysqli_num_rows($result) > 0) {
            $isRegister = false;
        }
        $this->db->closeConnection();
        return $isRegister;
    }

    /**
     * Register an new user
     * 
     * @param string $email *Email*
     * @param string $profileName *Profile Name*
     * @param string $password *Password*
     * @return bool
     */
    public function register($email, $profileName, $password)
    {
        $dbConn = $this->db->getNewConnection();
        $isRegister = $this->checkRegister($email);
        $result = null;

        if ($isRegister) {
            $currentDate = date("Y/m/d");
            $registerQuery = "INSERT INTO friends 
            (`friend_email`, `password`, `profile_name`, `date_started`, `num_of_friends`)
            VALUES
            ('$email', '$password', '$profileName', '$currentDate', 0);
            ";
            $result = mysqli_query($dbConn, $registerQuery);
        }

        if ($result) {
            return true;
            $this->db->closeConnection();
        }
        $this->db->closeConnection();
        return false;
    }

    /**
     * Login and update session
     * @param string $email *Email*
     * @param string @password "password"
     */
    public function login($email, $password)
    {
        $dbConn = $this->db->getNewConnection();
        $loginQuery = "SELECT friend_id FROM friends 
        WHERE 
            `friend_email` = '$email' 
            AND 
            `password` = '$password'";
        $result = mysqli_query($dbConn, $loginQuery);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->userId = $row["friend_id"];
                $this->authKey = md5(uniqid($this->userId, true));
                $this->updateSession($this->userId, $this->authKey);
            }
        }
        $this->db->closeConnection();
    }

    /**
     * Get session
     * @return array
     */
    public function getAuthSession()
    {
        return $_SESSION["AUTH_SESSION"];
    }

    /**
     * Check user is authenticated or not.
     * @return bool
     */
    public function isAuthenticated()
    {
        if (isset($_SESSION["AUTH_SESSION"])) {
            if ($_SESSION["AUTH_SESSION"]["USER_ID"]) {
                return true;
            }
        }
        return false;
    }

    /**
     * Logout and update session
     */
    public function logout()
    {
        $this->userId = null;
        $this->authKey = null;

        $this->updateSession($this->userId, $this->authKey);
    }
}
