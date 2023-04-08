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
    <title>Assignment 2 - Friend List</title>
</head>

<body>
    <div class="site">
        <?php
        include "header.php";
        $navItem = "friendlist";
        include "navbar.php";

        $session = $auth->getAuthSession();
        $acc = new Account($db, $session["USER_ID"]);
        $friends = new Friends($db);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            if (isset($_POST["unfriend"]) && $_POST["unfriend"] != NULL) {
                $friendId = filter_var($_POST["unfriend"]);
                $friendAcc = new Account($db, $friendId);
                $friends->removeFriends($acc, $friendAcc);
                header("Location: friendlist.php");
            }
        }

        $friendList = $friends->getFriendList($acc->getAccId());
        $friendList = sortAccByName($db, $friendList);
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
            if (!empty($friendList)) {
                echo "<div id='friendTable' class='table'>";
                foreach ($friendList as $friend) {
                    $friendAcc = new Account($db, $friend);

                    echo "<div class='tableRow'>";
                    echo "<div class='tableItem'>{$friendAcc->getProfileName()}</div>";
                    echo "
                        <div class='tableItem'>
                        <form action='' method='POST'>
                        <input type='hidden' name='unfriend' value='{$friendAcc->getAccId()}' />
                        <button class='unfriendBtn' type='submit'>Unfriend</button>
                        </form>
                        </div>
                    ";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>You have no friends. Try to add more friend.</p>";
            }
            ?>
        </div>
        <?php
        include "footer.php";
        ?>
    </div>
</body>

</html>