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
$stocks = $db->getItems();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Order Details </title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/design.css">
    <link rel="icon" href="images/logo.png">
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

    <!-- MODAL transaction -->
    <div class="modal-overlay" id="transaction-modal">
        <div class="modal-body">
            <ion-icon name="close-sharp" class="close-btn close-modal"></ion-icon>
            <div class="modal-header"></div>

            <div class="modal-content">
                <form>
                    <label for="password"> Confirm Password: </label>
                    <input type="password" id="password">
                    <div class="transaction-btn-container">
                        <button class="btn btn-secondary"> Confirm </button>
                        <button type="button" class="btn btn-white close-modal"> Cancel </button>
                    </div>
                </form>
            </div>


            <div class="modal-footer"></div>
        </div>
    </div>

    <!-- Content -->
    <main class="content">

        <!-- Success Section -->
        <section class="section">
            <div class="inner-section success-order-section">
                <ion-icon name="checkmark-circle-outline"></ion-icon>
                <h4> your order was placed successfully!</h4>
                <p> Please wait for a few days for your order to be processed to be added to your inventory. Happy
                    Trading!</p>
                <div class="order-btn-container">
                    <a href="dashboard.php" class="btn btn-primary">Return to dashboard</a>
                    <a href="market.php" class="btn btn-white">Continue to market</a>
                </div>
            </div>
        </section>

        <!-- Other Stocks Section -->
        <section class="section">
            <div class="inner-section white-container">
                <div class="section-header">
                    <h4> check out other stocks in the market </h4>
                    <a href="market.php" class="btn btn-secondary btn-clear">View All</a>
                </div>
                <hr>
                <table class="items-table">
                    <tr>
                        <th> Name </th>
                        <th> Volume </th>
                        <th> Company </th>
                        <th> Current Price </th>
                    </tr>
                    <?php 
                    foreach ($stocks as $stock) {
                        echo "<tr> 
                                <td>" . $stock['StockName'] . "</td>
                                <td>" . $stock['Volume'] . "</td>
                                <td>" . $stock['CompanyName'] . "</td>
                                <td>" . $stock['Price'] . "</td>
                                <td><a href='item.php?stock=" . $stock['StockID'] . "' class='btn btn-white btn-table'> View Details </a> </td>
                                </tr>";
                    }
                    ?>
                </table>
            </div>
        </section>


    </main>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>

</body>

</html>