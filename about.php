<?php include_once "session.php" ?>
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
    <title>Assignment 2 - About</title>
</head>

<body>
    <div class="site">
        <?php
        include "header.php";
        $navItem = "about";
        include "navbar.php";
        ?>
        <div class="sideContent">
            <div class="pageHeader">
                <h1>About</h1>
            </div>
            <div class="sideBar">
            </div>
        </div>
        <div class="pageContent">
            <p><strong>"What tasks you have not attempted or not completed?"</strong></p>
            <ul>
                <li>I attempted to implement all tasks.</li>
            </ul>
            <p><strong>What special features have you done, or attempted, in creating the site that we should know about?</strong></p>
            <ul>
                <li>Return home page by clicking the logo</li>
                <li>Split "header.php" & "footer.php"</li>
                <li>Changing navigation button depends on where the user are in the website.</li>
                <li>Pagination for Add Friend Page</li>
                <li>Mutual Friend Count in Add Friend Page</li>
            </ul>
            <p><strong>Which parts did you have trouble with?</strong></p>
            <ul>
                <li>Implement create the database table when update the friends with myfriends table.</li>
                <li>Update mutual friend count feature.</li>
            </ul>
            <p><strong>What would you like to do better next time?</strong></p>
            <ul>
                <li>Create more feature like facebook website such as avartar, profile's user.</li>
                <li>Create animation for button and style website better.</li>
            </ul>
            <p><strong>What additional features did you add to the assignment? (if any)</strong></p>
            <ul>
                <li>Responsive website</li>
            </ul>
            <p><strong>"A screen shot of a discussion response that answered someone’s thread in the unit’s discussion
                    board for Assignment 2?"</strong></p>
            <ul>
                <li><img src='img/discussion.png' alt='Discussion' /></li>
            </ul>

            <h1>Links<h1>
                    <ul>
                        <li>Friend List - <a href="friendlist.php">friendlist.php</a></li>
                        <li>Add Friends - <a href="friendadd.php">friendadd.php</a></li>
                        <li>Home Page - <a href="index.php">index.php</a></li>
                    </ul>
        </div>
        <?php include "footer.php"; ?>
        </div>
</body>

</html>