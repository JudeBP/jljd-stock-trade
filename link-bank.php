<?php
if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

session_start();
if (!isset($_SESSION['LoggedIn'])) {
    header("Location: login.php");
    exit;
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
    <title> Link a bank account | JLJD </title>

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
                <a href="dashboard.php">
                    <img src="/images/logo.png" alt="logo" class="header-logo">
                </a>
                <button class="header-toggle">
                    <ion-icon name="menu"></ion-icon>
                </button>
            </div>
            <!-- Header Links -->
            <div class="links-container">
                <ul class="header-links">
                    <li> <a href="dashboard.php"> Dashboard </a></li>
                    <li> <a href="market.php"> Market </a></li>
                    <li> <a href="#"> My Stocks </a>
                        <ul>
                            <li> <a href="trades.php"> Trades </a> </li>
                            <li> <a href="inventory.php"> Inventory </a> </li>
                        </ul>
                    </li>
                    <li> <a href="#"> Account </a>
                        <ul>
                            <li> <a href="profile.php"> Profile </a></li>
                            <li> <a href="profile.php"> My Banks </a></li>
                            <li> <a href="/php/logout.php"> Sign Out </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">

        <section class="section">
            <form class="link-bank-container" id="bank-form" method="POST">
                <h3> link a bank account </h3>
                <ion-icon name="link-outline" class="link-bank-icon"></ion-icon>
                <input type="text" name="account-num" class="input-field" placeholder="Account Number" value="<?php echo (isset($_POST['account-num']) ? $_POST['account-num'] : ''); ?>">
                <input type="text" name="account-name" class="input-field" placeholder="Account Name" value="<?php echo (isset($_POST['account-name']) ? $_POST['account-name'] : ''); ?>">
                <input type="text" name="bank-name" class="input-field" placeholder="Bank Name" value="<?php echo (isset($_POST['bank-name']) ? $_POST['bank-name'] : ''); ?>">
                <div class="field-error"></div>
                <button name="link-btn" class="btn btn-primary btn-save">Link Bank</button>
                <div class="submit-error"> The bank account has already been taken! </div>
            </form>
        </section>
    </main>

    <?php

    if (isset($_POST['link-btn'])) {
        $account_num = $_POST['account-num'];
        $account_name = $_POST['account-name'];
        $bank_name = $_POST['bank-name'];
        $data = array();
        $date = date("Y-m-d");
        $user = $_SESSION['User'];
        $data['AccountNumber'] = $account_num;
        $data['AccountName'] = $account_name;
        $data['TraderID'] = $user;
        $data['DateLinked'] = $date;
        $data['BankName'] = $bank_name;
        if (!$db->bankTaken($account_num, $account_name)) {
            $db->addBank($data);
            echo "<script> alert('Linked Successfully!'); 
                window.location.href='profile.php';</script>";
        } else {
            echo "<script> bankTaken(); </script>";
        }
    }

    ?>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
    <script>
        const form = document.getElementById('bank-form')
        const error = document.querySelector('.field-error')

        form.addEventListener('submit', (ev)=>{
            const inputs = document.querySelectorAll('.input-field')
            inputs.forEach((input)=> {
                if(input.value === '' || input.value === null){
                    ev.preventDefault();
                    error.textContent = '* Please fill in all the missing fields'
                    error.style.display = 'block'
                }
            })
        })
    </script>
</body>

</html>