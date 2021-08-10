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

if (isset($_GET['order'])) {
    $order = $db->getItemDetails($_GET['order']);
} else {
    header("Location: db-error.php");
    exit();
}

$orderID = $_GET['order'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Order Summary | My Trades </title>

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

    <!-- Modal Cancel -->
    <div class="modal-overlay" id="cancel-modal">
        <div class="modal-body">
            <ion-icon name="close-sharp" class="close-btn close-modal"></ion-icon>
            <div class="modal-content">
                <h4> Are you sure you want to cancel your order?</h4>
                <div class="transaction-btn-container">
                    <button class="btn btn-white">Yes</button>
                    <button class="btn btn-white close-modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <main class="content">
        <!-- Stock Details -->
        <section class="section order-section">
            <h3> Order Summary </h3>
            <div class="inner-section white-container order-details-container">
                <table>
                    <tr>
                        <td colspan="2">
                            <h4> Stock Details </h4>
                        </td>
                    </tr>
                    <tr>
                        <td> <b> Stock Code: </b> </td>
                        <td> <?php echo $order['StockName']; ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Description: </b> </td>
                        <td> <?php echo $order['Description']; ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Company: </b> </td>
                        <td><?php echo $order['CompanyName']; ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Current Price: </b> </td>
                        <td> <?php echo $order['Price']; ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Previous Price: </b> </td>
                        <td> <?php echo $order['Price']; ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Price Change: </b> </td>
                        <td> <?php echo $order['Price']; ?> </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td colspan="2">
                            <h4> Order Details </h4>
                        </td>
                    </tr>
                    <tr>
                        <td> <b> Transaction: </b> </td>
                        <td> <?php echo "BUY" ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Price Amount </b> </td>
                        <td> <?php echo "100" ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Order Date: </b> </td>
                        <td> <?php echo "100" ?> </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td> <b> Total Amount: </b> </td>
                        <td> 0 </td>
                    </tr>
                </table>
            </div>
            <p>
                <b> IMPORTANT: </b>Before placing your order, please check if the details are correct as it will be
                manually
                processed by our admins. Any requests for changes will take a long time and additional processing fees.
            </p>
            <div class="order-btn-container">
                <a href="trades.php" class="btn btn-white">Return to My Trades</a>
                <a href="stock.php?stock=<?php echo $orderID;?>" class="btn btn-primary">Check Stock in Market</a>
            </div>
        </section>

    </main>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>

</body>

</html>