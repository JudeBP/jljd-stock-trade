<?php
if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

include 'php/dbconn.php';
include 'php/functions.class.php';
include 'php/functions.php';
$db = new DBHandler();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | JLJD</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/design.css">
    <link rel="icon" href="images/logo.png">

    <!-- Data errors functions -->
    <script src="js/errors.js"></script>
</head>

<body>

    <!-- Header -->
    <header class="header">
        <div class="inner-header">
            <!-- Header with Hamburger Menu -->
            <div class="header-container">
                <a href="index.php">
                    <img src="/images/logo.png" alt="logo" class="header-logo">
                </a> <button class="header-toggle">
                    <ion-icon name="menu"></ion-icon>
                </button>
            </div>
            <!-- Header Links -->
            <div class="links-container">
                <ul class="header-links">
                    <li> <a href="index.php"> Home </a></li>
                    <li> <a href="about.php"> About JLJD </a></li>
                    <li> <a href="register.php"> Register </a></li>
                    <li> <a href="login.php"> Sign In </a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">

        <!-- Section for login -->
        <section class="section login-section">
            <!-- Login Form -->
            <form class="login-form" method="POST">
                <h3>Sign In to JLJD </h3>
                <p> Input your username and password </p>
                <div class="submit-error"> </div>
                <input type="text" class="input-field" name="user-email" placeholder="Username or Email" value="<?php echo (isset($_POST['user-email']) ? $_POST['user-email'] : ''); ?>">
                <input type="password" class="input-field" name="password" placeholder="Password">
                <div class="field-error"></div>
                <button name="login-btn" class="btn btn-primary"> Sign-in</button>
                <a href="#"> Forgot your password? </a>
            </form>

            <?php

            // Login PHP Functions
            if (isset($_POST['login-btn'])) {
                $user = clean($_POST['user-email']);
                $pass = clean($_POST['password']);

                // Checks if the input username or email exists first
                if ($db->usernameExists($user) || $db->emailExists($user)) {
                    $userID = $db->getID($user);

                    // If user exists, check if locked

                    // --not locked condition
                    if (!$db->userLocked($userID)) {
                        $date = date('Y-m-d');
                        $time = date('H:i:s');

                        // Get the no. of attempts, last attempt (time)
                        // and check if less the user can log-in
                        $login_attempts = $db->getLoginAttempts($userID, $date);
                        $last_attempt = $db->getLastLogin($userID, $date);
                        $minutes = (strtotime($time) - strtotime($last_attempt)) / 60;
                        // 3 attempts, lock account for 10mins
                        if ($login_attempts == 3 && $minutes <= 10) {
                            $mindiff = round(10 - $minutes, 0);
                            echo "<script> lockedAccount('Too many failed attempts. Please try again after $mindiff minutes'); </script>";
                        } 
                        // 5 attempts, lock account for 1hr
                        else if ($login_attempts == 5 && $minutes <= 60) {
                            $mindiff = round(60 - $minutes, 0);
                            echo "<script> lockedAccount('Too many failed attempts. Please try again after $mindiff minutes'); </script>";
                        } 
                        // 8 attempts - lock account permanently
                        else if ($login_attempts == 8) {
                            $db->lockAccount($userID);
                            echo "<script> lockedAccount('This accound is locked due to too many failed attempts.'); </script>";
                        } else {
                            $correct_password = $db->validatePassword($user, $pass);
                            if ($correct_password) {
                                session_start();
                                session_regenerate_id();
                                $_SESSION['LoggedIn'] = true;
                                $_SESSION['User'] = $userID;
                                $_SESSION['username-email'] = $user;
                                $db->clearAttempts($userID, $date);
                                header("Location: dashboard.php");
                            } else {
                                $db->loginAttempt($userID, $date, $time);
                                echo "<script> incorrectLogin() </script>";
                            }
                        }
                    }
                    // --locked condition
                    else {
                        echo "<script> lockedAccount('This accound is locked due to too many failed attempts.'); </script>";
                    }
                }
                // User does not exist
                else {
                    echo "<script> incorrectLogin()</script>";
                }
            }
            ?>

            <!-- Sign Up Steps Container -->
            <div class="sign-up-container">
                <h3> Don't have an account yet?</h3>
                <div class="register-step">
                    <span class="step-number"> 1 </span>
                    <p> <b> SIGN UP: </b> Providing your basic information and create an account easily </p>
                </div>
                <div class="register-step">
                    <span class="step-number"> 2 </span>
                    <p> <b> EXPLORE THE PLATFORM: </b> Take a look at what it’s like to invest without risking your
                        money </p>
                </div>
                <div class="register-step">
                    <span class="step-number"> 3 </span>
                    <p> <b> INVEST AND EARN PROFIT: </b> Choose an asset to invest in and make your money work for you
                    </p>
                </div>
                <b> Easily Join us to be a trader. Some of the benefits you’ll get are: </b>
                <ul>
                    <li> Lifetime assistance</li>
                    <li> Annual increases no matter what account</li>
                    <li> Easy monitoring and predictions for your investments </li>
                </ul>
                <a href="register.php" class="btn btn-primary btn-create-account"> Create an Account </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>
            Only fully competent adults are permitted to conduct transactions on this Website. Trading with financial
            instruments supplied on the Website entails a high level of risk; as a result, trading can be extremely
            dangerous. If you use the financial instruments offered on this Website to perform transactions, you risk
            losing a significant amount of money or perhaps losing your whole account balance.
            instruments offered on the Website.
        </p>
        <ul class="footer-links">
            <li> <a href="about.php"> About JLJD </a> </li>
            <li> <a href="about.php"> Community </a> </li>
            <li> <a href="about.php"> FAQ </a> </li>
            <li> <a href="about.php"> Partnerships </a> </li>
        </ul>

        <!-- Join Button with Social Media Links -->
        <div class="vertical-line"></div>
        <div class="footer-join-container">
            <a href="register.php" class="btn footer-btn"> Join Us Now</a>
            <div class="footer-sm-container">
                <ion-icon name="logo-facebook" class="sm-icon"></ion-icon>
                <ion-icon name="logo-instagram" class="sm-icon"></ion-icon>
                <ion-icon name="logo-twitter" class="sm-icon"></ion-icon>
            </div>
        </div>
    </footer>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
    <script>
        // Login Form Validation
        const form = document.querySelector('.login-form')
        const fieldError = document.querySelector('.field-error')
        const submitError = document.querySelector('.submit-error')
        
        form.addEventListener('submit', (ev) => {
            if (!completeForm(form) || !minmaxInputs(form)) {
                ev.preventDefault();
                errorMsg = '';
                if (!completeForm(form)) {
                    errorMsg = '* Please fill in all missing fields'
                } else {
                    errorMsg = '* Username should contain at least 3 characters'
                }
                fieldError.textContent = errorMsg
                fieldError.style.display = 'block'
            }
        })

        // Check if all fields are complete
        function completeForm(form) {
            const inputs = form.querySelectorAll('.input-field')
            let complete = true;
            inputs.forEach((input) => {
                if (input.value === '' || input.value === null) {
                    complete = false;
                }
            })
            return complete;
        }

        // Check if all fields have minimum chars
        function minmaxInputs(form) {
            const inputs = form.querySelectorAll('.input-field')
            let correct = true;
            inputs.forEach((input) => {
                if (input.value.length < 3) {
                    correct = false;
                }
            })
            return correct;
        }
    </script>
</body>

</html>