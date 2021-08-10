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

    <!-- MODAL transaction -->
    <div class="modal-overlay" id="transaction-modal">
        <div class="modal-body">
            <ion-icon name="close-sharp" class="close-btn close-modal"></ion-icon>
            <div class="modal-header"></div>

            <form class="modal-content" method="POST">
                <label for="password"> Confirm Password: </label>
                <input type="password" name="password" id="password">
                <div class="transaction-btn-container">
                    <button class="btn btn-secondary" name="confirm-btn"> Confirm </button>
                    <button type="button" class="btn btn-white close-modal"> Cancel </button>

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
                    <a href="market.php" class="btn btn-primary">Yes</a>
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
                        <td> <?php echo $_GET['type'] ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Price Amount </b> </td>
                        <td> <?php echo $_GET['amount'] ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Order Date: </b> </td>
                        <td> <?php echo date('m/d/Y'); ?> </td>
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
                        <td><?php echo $_GET['amount']; ?> </td>
                    </tr>
                </table>
            </div>
            <p>
                <b> IMPORTANT: </b>Before placing your order, please check if the details are correct as it will be
                manually
                processed by our admins. Any requests for changes will take a long time and additional processing fees.
            </p>
            <div class="submit-error"></div>
            <div class="order-btn-container">
                <button class="btn btn-white" id="confirm-btn">Confirm Order</button>
                <button class="btn btn-white" id="cancel-order-btn">Cancel Order</button>
            </div>
        </section>
    </main>

    <!-- Content End -->

    <?php
    if (isset($_POST['confirm-btn'])) {
        $type = 0;
        if ($_GET['type'] == 'SELL') {
            $type = 1;
        }
        if ($db->validatePassword($_SESSION['User'], $_POST['password'])) {
            $db->placeOrder($order['StockID'], $_GET["amount"], $type);
            $qty = $db->stockQuantity($order['StockID'], $_SESSION['User']);
            if ($type == 0) {
                if ($qty > 0) {
                    $db->updateInventory($_SESSION['User'], $order['StockID'], ($qty + 1));
                } else {
                    $db->addToInventory($_SESSION['User'], $order['StockID'], 1);
                }
            } else {
                if ($qty == 1) {
                    $db->removeFromInventory($_SESSION['User'], $order['StockID']);
                } else {
                    $db->updateInventory($_SESSION['User'], $order['StockID'], ($qty - 1));
                }
            }
            echo "<script> window.location.href='order-placed.php'; </script>";
        } else {
            echo "<script> incorrectPassword(); </script>";
        }
    }
    ?>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
    <script>
        
        // Modal 
        const orderModal = document.getElementById('transaction-modal');
        const cancelModal = document.getElementById('cancel-modal');

        document.getElementById('confirm-btn').addEventListener('click', function() {
            orderModal.classList.add('open-modal');
        });

        document.getElementById('cancel-order-btn').addEventListener('click', function() {
            cancelModal.classList.add('open-modal');
        });

        document.querySelectorAll('.close-modal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (orderModal.classList.contains('open-modal')) {
                    orderModal.classList.remove('open-modal');
                }
                if (cancelModal.classList.contains('open-modal')) {
                    cancelModal.classList.remove('open-modal');
                }
            })
        })

        // document.getElementById('yesBtn').addEventListener('click', () => {
        //     window.location.href = "market.php";
        // })
    </script>
</body>

</html>