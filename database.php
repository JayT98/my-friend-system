<?php
/* 
    Handle database 
*/
class Database
{
    private $dbHost;
    private $dbUser;
    private $dbPwd;
    private $dbName;

    private $dbConnection;

    // Constructor
    public function __construct()
    {
        include "db_config.php";

        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPwd = $dbPwd;
        $this->dbName = $dbName;
    }

    // Close the current database connection
    public function closeConnection()
    {
        if ($this->dbConnection) {
            // Check if server is alive
            if (mysqli_ping($this->dbConnection)) {
                mysqli_close($this->dbConnection);
            }
        }
    }

    // Set a new database connection
    public function setNewConnection()
    {
        $this->dbConnection = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPwd, $this->dbName);
    }

    /** 
     * Get a new database connection
     * @return mysqli
     */
    public function getNewConnection()
    {
        $this->setNewConnection();
        return $this->dbConnection;
    }

    /** 
     * Get a current database connection
     * @return mysqli
     */
    public function getConnection()
    {
        return $this->dbConnection;
    }

    /** 
     * Set up a Database
     * @return bool
     */
    public function createDatabase()
    {
        $this->setNewConnection();

        $createDbQuery = "CREATE TABLE IF NOT EXISTS friends (
            `friend_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `friend_email` VARCHAR(50) NOT NULL,
            `password` VARCHAR(20) NOT NULL,
            `profile_name` VARCHAR(30) NOT NULL,
            `date_started` DATE NOT NULL,
            `num_of_friends` INT UNSIGNED,
            UNIQUE (friend_email)
        );

        CREATE TABLE IF NOT EXISTS myfriends (
            `friend_id1` INT NOT NULL,
            `friend_id2` INT NOT NULL,
            CHECK (friend_id1 != friend_id2)
        );

        ALTER TABLE myfriends
            ADD CONSTRAINT `FK_friend_id1`
            FOREIGN KEY (`friend_id1`)
            REFERENCES `friends` (`friend_id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
            ADD CONSTRAINT `FK_friend_id2`
            FOREIGN KEY (`friend_id2`)
            REFERENCES `friends` (`friend_id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE;
        
        INSERT INTO friends (`friend_email`, `password`, `profile_name`, 
        `date_started`, `num_of_friends`)
        VALUES
        ('elfrieda.batz@utplexpotrabajos.com', '12121212', 'Walker', '2022/5/16', 2),
        ('snader@24hinbox.com', '21212121', 'Dallin', '2022/01/25', 2),
        ('madeline53@liceomajoranarho.it', '23081958', 'Joy', '2022/04/06', 2),
        ('omcclure@bizimalem-support.de', '28031973', 'Lelah', '2021/05/16', 2),
        ('czulauf@getmail.lt', '15061990', 'Myrtle', '2022/08/04', 2),
        ('schultz.jonatan@gasssmail.com', '21041972', 'Ena', '2021/06/06', 2),
        ('cassidy.aufderh@storemail.ml', '05102004', 'Madonna', '2022/09/04', 2),
        ('jaynguyen@gmail.com', '25091998', 'Trung', '2022/09/25', 2),
        ('julieduong@student.swin.edu.au', '03011998', 'Julie', '2021/03/05', 2),
        ('jastark@gamezli.com', '20121979', 'Garth', '2021/07/05', 2),
        ('rohan.arnold@betofis.net', '04101995', 'Esperanza', '2021/12/14', 2);

        INSERT INTO `myfriends` (`friend_id1`, `friend_id2`) VALUES
            (1, 3),
            (1, 6),
            (2, 5),
            (2, 8),
            (3, 4),
            (3, 7),
            (4, 2),
            (4, 9),
            (5, 4),
            (5, 6),
            (6, 10),
            (6, 8),
            (7, 1),
            (7, 4),
            (8, 11),
            (8, 4),
            (9, 2),
            (9, 1),
            (10, 7),
            (10, 5),
            (11, 3),
            (11, 6);
        ";

        $result = mysqli_multi_query($this->dbConnection, $createDbQuery);

        if ($result) {
            return true;
        }
        return false;
    }
}
