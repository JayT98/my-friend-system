<?php
include_once "session.php";
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
    <title>Assignment 2 - Home Page</title>
</head>

<body>
    <div class="site">
        <?php
        include "header.php";
        $navItem = NULL;
        include "navbar.php";
        ?>
        <div class="sideContent">
            <div class="pageHeader">
                <h1>My Friend System</h1>
                <p>Assignment Home Page</p>
            </div>
            <div class="sideBar">
                <p>Name: Trung Nguyen</p>
                <p>Student ID: 102604543 </p>
                <p>Email: <a href="mailto: 102604543@gstudent.swin.edu.au">102604543@student.swin.edu.au</a></p>
                <p>I declare that this assignment is my individual work.
                    I have not worked collaboratively
                    nor have I copied from any other student’s work or from any other source </p>
            </div>
        </div>
        <div class="pageContent">
            <?php
            $db = new Database();
            if ($db->createDatabase()) {
                echo "<p class='noticeSuccess'>Tables successfully created and populated.</p>";
            } else {
                echo "<p class='noticeError'>Unable to create tables.</p>";
            }
            ?>
        </div>
        <?php include "footer.php"; ?>
    </div>
</body>

</html>