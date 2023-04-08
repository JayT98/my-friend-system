<?php
include_once "session.php";

$db = new Database();
$auth = new Authentication($db);

if ($auth->isAuthenticated()) {
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
    <title>Assignment 2 - Login</title>
</head>

<body>
    <div class="site">
        <?php
        include "header.php";
        $navItem = "login";
        include "navbar.php";
        ?>
        <div class="sideContent">
            <div class="pageHeader">
                <h1>Login</h1>
                <p>Login to your My friend System</p>
            </div>
            <div class="sideBar">
                <form action="" method="POST">
                    <?php
                    $email = NULL;
                    $password = NULL;
                    $formError = array();
                    $error = array();

                    if (isset($_SESSION["email"])) {
                        $email = $_SESSION["email"];
                    }
                    if (isset($_SESSION["formError"])) {
                        $formError = $_SESSION["formError"];
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
                        if (isset($_POST["email"]) && $_POST["email"] != NULL) {
                            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $formError["email"] = "Please enter a valid email";
                            }
                        } else {
                            $formError["email"] = "Please enter your email";
                        }

                        if (isset($_POST["password"]) && $_POST["password"] != NULL) {
                            $password = filter_var($_POST["password"]);
                            $password = trim($password);
                            if (!preg_match("/^[a-zA-Z\d]{0,20}$/", $password)) {
                                $formError["password"] = "Please enter your valid password";
                            }
                        } else {
                            $formError["password"] = "Please enter your password";
                        }

                        if (empty($formError)) {
                            if (!$auth->checkRegister($email)) {
                                $auth->login($email, $password);
                                if ($auth->isAuthenticated()) {
                                    header("Location: friendlist.php");
                                } else {
                                    $error["Login Faild"] = "Please enter your email and password correctly";
                                }
                            } else {
                                $error["Login Error"] = "Your account can not found!";
                            }
                        }

                        $_SESSION["email"] = $email;
                        $_SESSION["errors"]["formError"] = $formError;
                        $_SESSION["errors"]["error"] = $error;
                    }
                    unset($_SESSION["email"]);
                    unset($_SESSION["errors"]);
                    ?>

                    <div class="formElement">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" type="text" name="email" placeholder="Your Email" require="required" value="<?php echo $email; ?>" />
                        <?php
                        if (array_key_exists("email", $formError)) {
                            echo "<div class='invalidForm'>" . $formError["email"] . "</div>";
                        }
                        ?>
                    </div>
                    <div class="formElement">
                        <label for="password">Password</label>
                        <input id="password" class="form-control" type="password" name="password" placeholder="Your Password" require="required" />
                        <?php
                        if (array_key_exists("password", $formError)) {
                            echo "<div class='invalidForm'>" . $formError["password"] . "</div>";
                        }
                        ?>
                    </div>
                    <button type="reset" class="clrBtn">Clear</button>
                    <button type="submit" class="submitBtn">Log in</button>
                </form>
            </div>
        </div>
        <div class="pageContent">
            <?php
            if ($error) {
                echo "<div class='boxError' role='alert'>";
                foreach ($error as $key => $value) {
                    echo "<h1>$key</h1>";
                    echo "<p>$value</p>";
                }
                echo "</div>";
            }
            ?>
            <img id="addFriendImg" src="img/login.png" alt="login-img" />
        </div>
        <?php include "footer.php" ?>
    </div>
</body>

</html>