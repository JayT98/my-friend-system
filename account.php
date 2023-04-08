<?php
/* 
    Handle Account 
*/
class Account
{
    private $db;
    private $id;
    private $email;
    private $profileName;
    private $dateStarted;
    private $numOfFriends;

    /**
     * Constructor
     * 
     * @param Database $db *DB object*
     * @param int $userId *Account ID*
     */
    public function __construct($db, $userId)
    {
        $this->db = $db;
        $this->id = $userId;
        $this->email = null;
        $this->profileName = null;
        $this->dateStarted = null;
        $this->numOfFriends = null;
    }

    /**
     * Get the account's Id.
     * @return int
     */
    public function getAccId()
    {
        $dbConn = $this->db->getNewConnection();
        $accId = $this->id;

        $AccIdQuery = "SELECT friend_id FROM friends WHERE friend_id = '$accId'";
        $result = mysqli_query($dbConn, $AccIdQuery);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->id = (int)$row["friend_id"];
            }
        }

        $this->db->closeConnection();
        return $this->id;
    }

    /**
     * Get the account's email.
     * @return string
     */
    public function getEmail()
    {
        $dbConn = $this->db->getNewConnection();
        $emailId = $this->id;

        $Emailquery = "SELECT friend_email FROM friends WHERE friend_id = '$emailId'";
        $result = mysqli_query($dbConn, $Emailquery);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->email = $row["friend_email"];
            }
        }

        $this->db->closeConnection();
        return $this->email;
    }

    /**
     * Get the account's profile name.
     * @return string
     */
    public function getProfileName()
    {
        $dbConn = $this->db->getNewConnection();
        $profileNameId = $this->id;

        $ProfileNameQuery = "SELECT profile_name FROM friends WHERE friend_id = '$profileNameId'";
        $result = mysqli_query($dbConn, $ProfileNameQuery);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->profileName = $row["profile_name"];
            }
        }

        $this->db->closeConnection();
        return $this->profileName;
    }

    /**
     * Get the account's started date.
     * @return string
     */
    public function getDateStarted()
    {
        $dbConn = $this->db->getNewConnection();
        $dateId = $this->id;

        $dateQuery = "SELECT date_started FROM friends WHERE friend_id = '$dateId'";
        $result = mysqli_query($dbConn, $dateQuery);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->dateStarted = $row["date_started"];
            }
        }

        $this->db->closeConnection();
        return $this->dateStarted;
    }

    /**
     * Get the account's number of friends.
     * @return int
     */
    public function getNumOfFriends()
    {
        $dbConn = $this->db->getNewConnection();
        $numOfFriendsId = $this->id;

        $numFriendsQuery = "SELECT num_of_friends FROM friends WHERE friend_id = '$numOfFriendsId'";
        $result = mysqli_query($dbConn, $numFriendsQuery);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->numOfFriends = (int)$row["num_of_friends"];
            }
        }

        $this->db->closeConnection();
        return $this->numOfFriends;
    }

    /**
     * Set the account's number of friends.
     * @param int $num *New number of friends*
     * @return bool 
     */
    public function setNumOfFriends($num)
    {
        $dbConn = $this->db->getNewConnection();
        $numFriendsId = $this->id;

        $numFriendsQuery = "UPDATE friends SET num_of_friends = $num WHERE friend_id = '$numFriendsId'";

        if ($this->getNumOfFriends() >= 0) {
            $result = mysqli_query($dbConn, $numFriendsQuery);
            if ($result) {
                return true;
                $this->db->closeConnection();
            }
        }

        $this->db->closeConnection();
        return false;
    }
}
?>
<?php
/**
 * Get account email fron ID
 * @param Database $db *Db Object*
 * @param int $userId *Account ID*
 * @return string
 */
function getEmailFromId($db, $userId)
{
    $dbConn = $db->getNewConnection();
    $email = null;

    $emailQuery = "SELECT friend_email FROM friends WHERE friend_id = '$userId'";
    $result = mysqli_query($dbConn, $emailQuery);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $email = $row["friend_email"];
        }
    }
    $db->closeConnection();
    return $email;
}

/**
 * Get account from email.
 * @param Database $db *Database Object*
 * @param string $email *Account Email*
 * @return int
 */
function getAccFromEmail($db, $email)
{
    $dbConn = $db->getNewConnection();
    $accId = null;

    $accQuery = "SELECT friend_email FROM friends WHERE friend_email = '$email'";
    $result = mysqli_query($dbConn, $accQuery);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $accId = $row["friend_id"];
        }
    }
    $db->closeConnection();
    return $accId;
}

/**
 * Sort list of account id by profile name.
 * @param Database $db *Database Object*
 * @param array $accIdList *Account Id list*
 * @return array *Sorted account ID list*
 */
function sortAccByName($db, $accIdList)
{
    $dbConn = $db->getNewConnection();
    $accList = array();

    $sortAccQuery = "SELECT friend_id FROM friends ORDER BY profile_name ASC";
    $result = mysqli_query($dbConn, $sortAccQuery);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $accId = $row["friend_id"];
            if (in_array($accId, $accIdList)) {
                array_push($accList, $accId);
            }
        }
    }
    $db->closeConnection();
    return $accList;
}
?>