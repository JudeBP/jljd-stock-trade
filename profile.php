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

$user_data = $db->getUserProfile($_SESSION['User']);
$banks = $db->getBankAccounts($_SESSION['User']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | JLJD</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/design.css">
    <link rel="icon" href="/images/logo.png">

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

    <!-- Modal -->
    <div class="modal-overlay">
        <div class="modal-body">
            <ion-icon name="close-sharp" class="close-btn close-modal"></ion-icon>
            <div class="modal-header"></div>

            <form class="modal-content" method="POST">
                <label for="password"> Confirm Password: </label>
                <input type="password" name="password" id="password">
                <div class="transaction-btn-container">
                    <button name="confirm-btn" class="btn btn-secondary"> Confirm </button>
                    <button type="button" class="btn btn-white close-modal"> Cancel </button>
                </div>
            </form>
            <div class="modal-footer"></div>
        </div>
    </div>

    <!-- Content -->
    <main class="content">
        <!-- Profiile Section -->
        <section class="section profile-section">
            <h3>My Account</h3>
            <!-- Tabs -->
            <div class="inner-section profile-tabs-container">
                <button class="btn btn-profile-tab selected" data-id="account"> Account </button>
                <button class="btn btn-profile-tab" data-id="basic"> User Information </button>
                <button class="btn btn-profile-tab" data-id="banks"> Linked Banks </button>
                <button class="btn btn-profile-tab" data-id="change-pass"> Change Password </button>
            </div>
            <!-- Containers -->

            <!-- Account Information -->
            <div class="inner-section white-container profile-content active" id="account">
                <h4> account information </h4>
                <form class="profile-container">
                    <div class="profile-img-container">
                        <img src="/images/male_default.jpg" alt="image">
                        <button type="button" class="btn btn-white"> Select Picture </button>
                    </div>
                    <div class="profile-inputs-container">
                        <div class="profile-input">
                            <label> User ID: </label>
                            <input type="text" value="<?php echo $user_data['TraderID']; ?>" disabled>
                        </div>
                        <div class="profile-input">
                            <label> First Name: </label>
                            <input type="text" value="<?php echo $user_data['FirstName']; ?>">
                        </div>
                        <div class="profile-input">
                            <label> Last Name: </label>
                            <input type="text" value="<?php echo $user_data['LastName']; ?>">
                        </div>
                        <div class="profile-input">
                            <label> Username: </label>
                            <input type="text" value="<?php echo $user_data['Username']; ?>">
                        </div>
                        <div class="profile-input">
                            <label> Sign-up Date: </label>
                            <input type="text" value="<?php echo $user_data['SignUpDate']; ?>" disabled>
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary btn-save modal-btn" id="save-account-info"> SAVE CHANGES </button>
                <!-- <div class="submit-error"></div> -->
            </div>

            <!-- Basic Info -->
            <div class="inner-section white-container profile-content" id="basic">
                <h4> basic information and contact details </h4>
                <form class="profile-container">
                    <div class="profile-inputs-container">
                        <div class="profile-input">
                            <label> Email: </label>
                            <input type="text" value="<?php echo $user_data['Email']; ?>">
                        </div>
                        <div class="profile-input">
                            <label> Contact Number: </label>
                            <input type="text" value="<?php echo $user_data['Contact']; ?>">
                        </div>
                        <div class="profile-input">
                            <label> Street: </label>
                            <input type="text" value="<?php echo $user_data['Street']; ?>">
                        </div>
                        <div class="profile-input">
                            <label> City: </label>
                            <input type="text" value="<?php echo $user_data['City']; ?>">
                        </div>
                        <div class="profile-input">
                            <label> Zipcode: </label>
                            <input type="text" value="<?php echo $user_data['Zipcode']; ?>">
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary btn-save modal-btn" id="save-account-info"> SAVE CHANGES </button>
            </div>

            <!-- Linked Banks -->
            <div class="inner-section white-container profile-content" id="banks">
                <h4> Linked Bank Accounts </h4>
                <a href="link-bank.php" class="btn btn-secondary"> +Link an account </a>
                <table class="items-table table-banks">
                    <tr>
                        <th> Bank </th>
                        <th> Account Number </th>
                        <th> Account Name </th>
                        <th> Date Linked </th>
                        <th></th>
                    </tr>
                    <?php
                    $index = 0;
                    if (sizeof($banks) > 0) {
                        foreach ($banks as $bank) {
                            echo "<tr> 
                                <td>" . $bank['BankName'] . "</td>
                                <td>" . hideBank($bank['AccountNumber']) . "</td>
                                <td>" . $bank['AccountName'] . "</td>
                                <td>" . $bank['DateLinked'] . "</td>
                                <td>
                                    <div class='flex'>
                                    <form method='post'>
                                        <button class='btn btn-primary btn-table' name='removeBank$index'> Remove</button>
                                    </form>
                                </div>                            
                                </td>
                                </tr>";
                            $bankNum = "removeBank" . $index;
                            $bankBtn = "bank-details-btn" . $index;
                            if (isset($_POST[$bankNum])) {
                                $db->removeBank($_SESSION['User'], $bank['AccountNumber'], $bank['AccountName']);
                                echo "<script> alert('Bank Account Unlinked!');</script>";
                                exit();
                            }
                            $index++;
                        }

                        echo "</table>";
                    } else echo "</table><div class = 'no-result'> No result found. </div>";

                    ?>


                </table>
            </div>

            <!-- Change Password -->
            <div class="inner-section white-container profile-content" id="change-pass">
                <h4> change your password</h4>
                <form class="profile-container">
                    <div class="profile-inputs-container">
                        <div class="profile-input">
                            <label> Old Password: </label>
                            <input type="password">
                        </div>
                        <div class="profile-input">
                            <label> New Password: </label>
                            <input type="password">
                        </div>
                        <div class="profile-input">
                            <label> Confirm New Password: </label>
                            <input type="password">
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary btn-save"> Change Password </button>
            </div>
        </section>

        <div class="submit-error"></div>
    </main>

    <?php

    if (isset($_POST['confirm-btn'])) {
        $pass = $_POST['password'];
        $user = $_SESSION['username-email'];
        if ($db->validatePassword($user, $pass)) {
        } else {
            echo "<script> incorrectPassword(); </script>";
        }
    }

    ?>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
    <script>

        // Profile Tabs
        const tabBtns = document.querySelectorAll('.btn-profile-tab')
        const profileSection = document.querySelector('.profile-section')
        const profileTabs = document.querySelectorAll('.profile-content')

        profileSection.addEventListener('click', (event) => {
            const id = event.target.dataset.id;
            if (id) {
                // remove active btn
                // replace profile content
                tabBtns.forEach((btn) => {
                    btn.classList.remove("selected");
                    event.target.classList.add('selected');
                });

                profileTabs.forEach((content) => {
                    content.classList.remove("active");
                })

                const element = document.getElementById(id);
                element.classList.add("active");
            }
        })

        // Modal 
        const modalBtn = document.querySelectorAll('.modal-btn');
        const modal = document.querySelector('.modal-overlay');
        const closemodal = document.querySelectorAll('.close-modal');

        modalBtn.forEach((btn) => {
            btn.addEventListener('click', () => {
                modal.classList.add('open-modal');
            })
        });
        closemodal.forEach((btn) => {
            btn.addEventListener('click', () => {
                modal.classList.remove('open-modal')
            })
        });
    </script>
</body>

</html>