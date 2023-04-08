<?php
/**
 * Handle friends relationships.
 */
class Friends{
    private $db;

    /**
     * Constructor
     * @param Database $db *Database Object*
     */
    public function __construct($db)
    {   
        $this->db = $db;
    }

    /**
     * get list of all the registered accounts except the authenticated user.
     * @param int $accId *Account ID*
     * @return array
     */
    public function getAccList($accId){
        $dbConn = $this->db->getNewConnection();
        $accList= array();

        $accQuery = "SELECT friend_id FROM friends 
                    WHERE friend_id != $accId 
                    ORDER BY profile_name ASC";
        $result = mysqli_query($dbConn, $accQuery);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                array_push($accList, $row["friend_id"]);
            }
        }
        $this->db->closeConnection();
        return $accList;
    }

    /**
     * get list of all friends of the authenticated user.
     * @param int $accId *Account ID*
     * @return array
     */
    public function getFriendList($accId){
        $dbConn = $this->db->getNewConnection();
        $friendsList= array();

        $friendsQuery = "SELECT friend_id2 FROM myfriends 
                    WHERE friend_id1 = '$accId'";
        $result = mysqli_query($dbConn, $friendsQuery);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                array_push($friendsList, $row["friend_id2"]);
            }
            $friendsList = array_unique($friendsList);
        }
        $this->db->closeConnection();
        return $friendsList;
    }

    /**
     * get list of all the mutual friends of two users.
     * @param int $userId1 *Account ID 1*
     * @param int $userId2 *Account ID 2*
     * @return array
     */
    public function getMutualFriendList($userId1, $userId2){
        $mutualFriendsList = array();
        $userFriendsList1 = $this->getFriendList($userId1);
        $userFriendsList2 = $this->getFriendList($userId2);

        $mutualFriendsList= array_intersect($userFriendsList1,$userFriendsList2);

        return $mutualFriendsList;
    }

    /**
     * get the number of all the mutual friends of two users.
     * @param int $userId1 *Account ID 1*
     * @param int $userId2 *Account ID 2*
     * @return int
     */
    public function getMutualFriendNum($userId1,$userId2){
        $numOfFriends = 0;
        $numOfFriends = count($this->getMutualFriendList($userId1,$userId2));
        return $numOfFriends;
    }

    /**
     * Add a friend
     * @param Account $user *Authenticated user Object*
     * @param Account $friends *friends user Object*
     * @return bool
     */
    public function addFriends($user, $friends){
        $dbConn = $this->db->getNewConnection();
        $userId = $user->getAccId();
        $friendId = $friends->getAccId();
        $friendList = $this->getFriendList($userId);

        if (!in_array($friendId, $friendList)){
            $addQuery = "INSERT INTO myfriends
                        (friend_id1, friend_id2)
                        VALUES
                        ($userId, $friendId)";
            $result = mysqli_query($dbConn, $addQuery);
            if ($result){
                $friendsNum = count($this->getFriendList($userId));
                if ($user->setNumOfFriends($friendsNum))
                {
                    return true;
                }
            }
        }
        $this->db->closeConnection();
        return false;
    }

    /**
     * Remove a friend
     * @param Account $user *Authenticated user Object*
     * @param Account $friends *friends user Object*
     * @return bool
     */
    public function removeFriends($user, $friends){
        $dbConn = $this->db->getNewConnection();
        $userId = $user->getAccId();
        $friendId = $friends->getAccId();
        $friendList = $this->getFriendList($userId);

        if (in_array($friendId, $friendList)){
            $removeQuery = "DELETE FROM myfriends
                        WHERE friend_id1 = $userId
                        AND friend_id2 = $friendId";
            $result = mysqli_query($dbConn, $removeQuery);
            if ($result){
                $friendsNum = count($this->getFriendList($userId));
                if ($user->setNumOfFriends($friendsNum))
                {
                    return true;
                }
            }
        }
        $this->db->closeConnection();
        return false;
    }
}
