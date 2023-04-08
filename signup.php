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
    <title>Assignment 2 - Sign Up</title>
</head>

<body>
    <div class="site">
        <?php
        include "header.php";
        $navItem = "signup";
        include "navbar.php";
        ?>
        <div class="sideContent">
            <div class="pageHeader">
                <h1>Sign up</h1>
                <p>Register for My Friend System.</p>
            </div>
            <div class="sideBar">
                <form action="" method="POST">
                    <?php
                    $email = NULL;
                    $profileName = NULL;
                    $password = NULL;
                    $confirmPassword = NULL;
                    $formError = array();
                    $error = array();

                    if (isset($_SESSION["email"])) {
                        $email = $_SESSION["email"];
                    }
                    if (isset($_SESSION["profileName"])) {
                        $profileName = $_SESSION["profileName"];
                    }
                    if (isset($_SESSION["formError"])) {
                        $formError = $_SESSION["formError"];
                    }
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
                        if (isset($_POST["email"]) && $_POST['email'] != NULL) {
                            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $formError["email"] = "Please enter a valid email";
                            }
                        } else {
                            $formError["email"] = "Please enter your email";
                        }

                        if (isset($_POST["profileName"]) && $_POST["profileName"] != NULL) {
                            $profileName = filter_var($_POST["profileName"]);
                            $profileName = trim($profileName);
                            if (!preg_match("/^[a-zA-Z]{0,40}$/", $profileName)) {
                                $formError["profileName"] = "Please enter a valid profile name (Profile name can only contain letters)";
                            }
                        } else {
                            $formError["profileName"] = "Please enter your profile name";
                        }

                        if (isset($_POST["password"]) && $_POST["password"] != NULL) {
                            $password = filter_var($_POST["password"]);
                            $password = trim($password);
                            if (!preg_match("/^[a-zA-Z\d]{0,20}$/", $password)) {
                                $formError["password"] = "Please enter a valid password (Password can only contain letters and numbers)";
                            }
                        } else {
                            $formError["password"] = "Please enter your password";
                        }

                        if (isset($_POST["confPassword"]) && $_POST["confPassword"] != NULL) {
                            $confirmPassword = filter_var($_POST["confPassword"]);
                            if ($password != $confirmPassword) {
                                $formError["confPassword"] = "Your confirm password does not match";
                            }
                        } else {
                            $formError["confPassword"] = "Please confirm your password";
                        }

                        if (empty($formError)) {
                            if ($auth->checkRegister($email)) {
                                $isRegisterSuccess = $auth->register($email, $profileName, $password);
                                if ($isRegisterSuccess) {
                                    $auth->login($email, $password);
                                    if ($auth->isAuthenticated()) {
                                        echo "<div class='boxSuccess' role='alert'>";
                                        echo "<h1>Your Account registered</h1>";
                                        echo "<p>You will be shortly redirected.</p>";
                                        echo "</div>";
                                        header("Refresh: 3, url=friendadd.php");
                                    }
                                } else {
                                    $error["Registration Error"] = "Your Registration failed!";
                                }
                            } else {
                                $error["Registration Error"] = "Your email already registered";
                            }
                        }

                        $_SESSION["email"] = $email;
                        $_SESSION["profileName"] = $profileName;
                        $_SESSION["errors"]["formError"] = $formError;
                        $_SESSION["errors"]["error"] = $error;
                    }

                    unset($_SESSION["email"]);
                    unset($_SESSION["profileName"]);
                    unset($_SESSION["errors"]);

                    if ($error) {
                        echo "<div class='boxError' role='alert'>";
                        foreach ($error as $key => $value) {
                            echo "<h1>$key</h1>";
                            echo "<p>$value<p>";
                        }
                        echo "</div>";
                    }
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
                        <label for="profileName">Profile Name</label>
                        <input id="profileName" class="form-control" type="text" name="profileName" placeholder="Your Profile Name" require="required" value="<?php echo $profileName; ?>" />
                        <?php
                        if (array_key_exists("profileName", $formError)) {
                            echo "<div class='invalidForm'>" . $formError["profileName"] . "</div>";
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

                    <div class="formElement">
                        <label for="confPassword">Confirm Password</label>
                        <input id="confPassword" class="form-control" type="password" name="confPassword" placeholder="Your Password Confirm" require="required" />
                        <?php
                        if (array_key_exists("confPassword", $formError)) {
                            echo "<div class='invalidForm'>" . $formError["confPassword"] . "</div>";
                        }
                        ?>
                    </div>
                    <button type="reset" class="clrBtn">Clear</button>
                    <button type="submit" class="submitBtn">Register</button>
                </form>
            </div>
        </div>
        <div class="pageContent">
            <img id="addFriendImg" src="img/signup.png" alt="signup-img" />
        </div>
        <?php include "footer.php"; ?>
    </div>
</body>

</html>