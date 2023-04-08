<nav class="navBar">
    <?php
    $db = new Database();
    $auth = new Authentication($db);
    $isAuth = $auth->isAuthenticated();

    if ($isAuth) {
        $session = $auth->getAuthSession();
        $acc = new Account($db, $session["USER_ID"]);
    }
    ?>

    <ul class="navLeft">
        <?php
        if ($isAuth) {
            if ($navItem == "friendlist") {
                echo "<li class='itemActive'>";
            } else {
                echo "<li class=''>";
            }

            echo "<a href='friendlist.php'>Friend List</a>";
            echo "</li>";

            if ($navItem == "friendadd") {
                echo "<li class='itemActive'>";
            } else {
                echo "<li class=''>";
            }

            echo "<a href='friendadd.php'>Add Friends</a>";
            echo "</li>";
        } else {
            if ($navItem == "signup") {
                echo "<li class='itemActive'>";
            } else {
                echo "<li class=''>";
            }
            echo "<a href='signup.php'>Sign up</a>";
            echo "</li>";
        }
        ?>

        <li class="<?php
                    if ($navItem == "login")
                        echo "itemActive";
                    ?>">
            <?php
            if ($isAuth) {
                echo "<a href='logout.php'>Log out ({$acc->getProfileName()})</a>";
            } else {
                echo "<a href='login.php'>Login</a>";
            }
            ?>
        </li>
    </ul>
    <ul class="navRight">
        <li class="<?php
                    if ($navItem == "about")
                        echo "itemActive";
                    ?>">
            <a href="about.php">About</a>
        </li>
    </ul>
</nav>