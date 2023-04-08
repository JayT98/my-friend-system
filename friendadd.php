<?php
include_once "session.php";

$db = new Database();
$auth = new Authentication($db);

if (!$auth->isAuthenticated()) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="php">
    <meta name="author" content="Trung Nguyen">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Assignment 2 - Friend Add</title>
</head>

<body>
    <div class="site">
        <?php
        include "header.php";
        $navItem = "friendadd";
        include "navbar.php";

        $session = $auth->getAuthSession();
        $acc = new Account($db, $session["USER_ID"]);
        $friends = new Friends($db);

        $pageNum = 0;
        if (isset($_GET["page"])) {
            $pageNum = $_GET["page"];
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            if (isset($_POST["addFriend"]) && $_POST["addFriend"] != NULL) {
                $id = filter_var($_POST["addFriend"]);
                $friendAcc = new Account($db, $id);
                $friends->addFriends($acc, $friendAcc);
                header("Location: friendadd.php?page=$pageNum");
            }
        }

        $allAccountList = $friends->getAccList($acc->getAccId());
        $friendList = $friends->getFriendList($acc->getAccId());
        $accList = array_diff($allAccountList, $friendList);
        $pages = array_chunk($accList, 5, TRUE);
        $pageList = array();

        if (array_key_exists(($pageNum), $pages)) {
            $pageList = $pages[$pageNum];
        }
        ?>
        <div class="sideContent">
            <div class="pageHeader">
                <?php
                echo "<h1>Hello {$acc->getProfileName()}!</h1>";
                echo "<p>Your friend list:</p>";
                echo "<p>You have {$acc->getNumOfFriends()} friends.</p>";
                ?>
            </div>
            <div class="sideBar">
            </div>
        </div>
        <div class="pageContent">
            <?php
            $accCount = count($accList);
            if ($accCount >= 1) {
                echo "<p>We found $accCount account.</p>";
            }

            if (!empty($pageList)) {
                echo "<div id='addTable' class='table'>";
                foreach ($pageList as $page) {
                    $friendAcc = new Account($db, $page);

                    $mutualFriendCount = $friends->getMutualFriendNum($acc->getAccId(), $friendAcc->getAccId());
                    $mutualFriendStr =   $mutualFriendCount == 1 ? " $mutualFriendCount mutual friend" : " $mutualFriendCount mutual friends";

                    echo "<div class='tableRow'>";
                    echo "<div class='tableItem'>{$friendAcc->getProfileName()}</div>";
                    echo "<div class='tableItem'>$mutualFriendStr</div>";
                    echo "<div class='tableItem'>
                            <form action='' method='POST'>
                            <input type='hidden' name='addFriend' value='{$friendAcc->getAccId()}' />
                            <button class='addFriendBtn' type='submit'>Add as friend</button>
                            </form>
                        </div>
                        ";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No accounts found!</p>";
            }
            $pages;
            $pageNum;
            include "pagination.php";
            ?>
        </div>
        <?php
        include "footer.php";
        ?>
    </div>
</body>

</html>