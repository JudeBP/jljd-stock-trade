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
    <title>Create an Account | JLJD</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/design.css">
    <link rel="icon" href="/images/logo.png">

    <!-- Data errors functions -->
    <script src="js/errors.js"></script>
</head>

<body class="registration-body">


    <form class="register-container" id="register" method="POST">
        <a href="index.php">
            <img src="/images/logo.png" alt="logo" class="register-logo">
        </a>
        <h3> register</h3>
        <p> Fill in your basic information to register </p>
        <div class="register-form show-form" id="basic-register">
            <input type="text" name="firstName" class="input-field" placeholder="First Name" value="<?php echo (isset($_POST['firstName']) ? $_POST['firstName'] : ''); ?>">
            <input type="text" name="lastName" class="input-field" placeholder="Last Name" value="<?php echo (isset($_POST['lastName']) ? $_POST['lastName'] : ''); ?>">
            <input type="text" name="midName" class="input-field" placeholder="Middle Name" value="<?php echo (isset($_POST['midName']) ? $_POST['midName'] : ''); ?>">
            <input type="date" name="bday" class="input-field" value="<?php echo (isset($_POST['bday']) ? $_POST['bday'] : ''); ?>">
            <input type="text" name="street" class="input-field" placeholder="Street" value="<?php echo (isset($_POST['street']) ? $_POST['street'] : ''); ?>">
            <input type="text" name="city" class="input-field" placeholder="City" value="<?php echo (isset($_POST['city']) ? $_POST['city'] : ''); ?>">
            <input type="text" name="zipcode" class="input-field" placeholder="Zipcode" value="<?php echo (isset($_POST['zipcode']) ? $_POST['zipcode'] : ''); ?>">
            <input type="text" name="contact" class="input-field" placeholder="Contact No." value="<?php echo (isset($_POST['contact']) ? $_POST['contact'] : ''); ?>">
            <div class="field-error"></div>
            <div class="register-btn-container">
                <button type="button" class="btn btn-white" id="next">Next</button>
            </div>
        </div>
        <div class="register-form" id="account-register">
            <div class="submit-error"></div>
            <input type="text" class="input-field" name="email" placeholder="Email (example@hotmail.com)" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
            <input type="text" class="input-field" name="username" placeholder="Username" value="<?php echo (isset($_POST['username']) ? $_POST['username'] : ''); ?>">
            <input type="password" class="input-field" name="password" placeholder="Password">
            <input type="password" class="input-field" name="password-retype" placeholder="Re-type Password">
            <div class="field-error"></div>
            <div class="register-btn-container">
                <button type="submit" name="submit-btn" class="btn btn-primary"> Submit </button>
                <button type="button" class="btn btn-white" id="back">Back</button>
            </div>
        </div>
        <div class="have-account-container">
            <p> Already have an account? </p>
            <a href="login.php"> Sign In </a>
        </div>

    </form>

    <?php

    if (isset($_POST['submit-btn'])) {

        $fName = clean($_POST['firstName']);
        $lName = clean($_POST['lastName']);
        $midName = clean($_POST['midName']);
        $bday = clean($_POST['bday']);
        $street = clean($_POST['street']);
        $city = clean($_POST['city']);
        $zipcode = clean($_POST['zipcode']);
        $contact = clean($_POST['contact']);
        $email = $_POST['email'];
        $username = clean($_POST['username']);
        $password = $_POST['password'];

        $data = [
            'firstName' => $fName,
            'lastName' => $lName,
            'midName' => $midName,
            'bday' => $bday,
            'street' => $street,
            'city' => $city,
            'zipcode' => $zipcode,
            'contact' => $contact,
            'email' => $email,
            'username' => $username,
            'password' => $password
        ];

        $db = new DBHandler();
        $email_exists = $db->emailExists($email);
        if (!$email_exists) {
            $username_exists = $db->usernameExists($username);
            if (!$username_exists) {
                $db->insertUser($data);
                echo "<script> alert('Account Created!'); </script>";
                echo "<script> window.location.href='login.php'; </script>";
            } else {
                echo "<script> usernameTaken() 
                document.getElementById('basic-register').classList.remove('show-form')
                document.getElementById('account-register').classList.add('show-form')
                </script>";
            }
        } else {
            echo "<script> emailTaken()
            document.getElementById('basic-register').classList.remove('show-form')
            document.getElementById('account-register').classList.add('show-form')  
            </script>";
        }
    }
    ?>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script>
        // Next and back form buttons
        const nextBtn = document.getElementById('next')
        const backBtn = document.getElementById('back')
        const basicForm = document.getElementById('basic-register')
        const accountForm = document.getElementById('account-register')
        const form = document.getElementById('register')

        const fieldError = document.querySelectorAll('.field-error')
        const incompleteMsg = '* Please fill in all the missing fields'
        const minmaxMsg = '* All fields need at least 3 characters'
        // Next Button
        nextBtn.addEventListener('click', (ev) => {
            if (!completeForm(basicForm) || !minmaxInputs(basicForm)) {
                let errorMsg = '';
                if (!completeForm(basicForm)) {
                    errorMsg = incompleteMsg
                } else errorMsg = minmaxMsg
                ev.preventDefault()
                displayError(errorMsg)
            } else {
                basicForm.classList.remove('show-form')
                accountForm.classList.add('show-form')
                fieldError.forEach((fr) => {
                    if (fr.style.display == 'block') {
                        fr.style.display = 'none';
                    }
                })
            }
        })
        // Back Button
        backBtn.addEventListener('click', () => {
            if (accountForm.classList.contains('show-form')) {
                accountForm.classList.remove('show-form')
                basicForm.classList.add('show-form')
            }
        })

        form.addEventListener('submit', (ev) => {
            // Incomplete Fields error
            const errorContainer = document.querySelector('.field-error')
            const email = document.getElementsByName('email')[0]
            const username = document.getElementsByName('username')[0]
            const password = document.getElementsByName('password')[0]
            const passwordRetype = document.getElementsByName('password-retype')[0]
            var errorMsg = '';
            var error = false;
            if (!completeForm(accountForm) || !minmaxInputs(accountForm)) {
                if (!completeForm(accountForm)) {
                    errorMsg = incompleteMsg
                } else errorMsg = minmaxMsg
                error = true
            } else if (!validateEmail(email)) {
                errorMsg = 'Invalid Email Format [example@hotmail.com]'
                error = true
            } else if (!validatePassword(password)) {
                errorMsg = 'Password should contain 8-20 characters, at least one uppercase and one lowercase character, and one special character [ ! @ # $ % ^ & * ]'
                error = true
            } else if (!passMatch(password, passwordRetype)) {
                errorMsg = 'Passwords do not match'
                error = true
            }

            if (error) {
                ev.preventDefault();
                displayError(errorMsg)
            }
        })



        // Validation Functions
        function validateEmail(email) {
            var validFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/; // format for email
            if (email.value.match(validFormat)) {
                return true;
            } else return false;
        }

        function validatePassword(password) {
            // passFormat -> should contain at least one UPPERCASE, one LOWERCASE, one NUMBER, 
            // and one special character: ! @ # $ % ^ & *
            var passFormat = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
            if (passFormat.test(password.value)) {
                return true;
            } else {
                return false;
            }
        }

        function passMatch(password, password2) {
            // const password = document.getElementById('')
            if (password.value == password2.value) {
                return true;
            } else return false;

        }

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

        function displayError(msg) {
            fieldError.forEach((fr) => {
                fr.textContent = msg
                fr.style.display = 'block'
            })

        }
    </script>
</body>

</html>