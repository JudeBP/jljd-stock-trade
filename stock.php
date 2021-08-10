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

if (isset($_GET['stock'])) {
    $item = array();
    $item = $db->getItemDetails($_GET['stock']);
    $stocks = $db->getItems();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Stock </title>

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
    <div class="modal-overlay">
        <div class="modal-body">
            <ion-icon name="close-sharp" class="close-btn close-modal"></ion-icon>
            <form class="modal-content" method="POST">
                <h4> Transaction Details </h4>
                <table class="table-transaction-details">
                    <tr>
                        <td> <b> Stock Name: </b> </td>
                        <td> <?php echo $item['StockName']; ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Volume: </b> </td>
                        <td> <?php echo $item['Volume']; ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Current Price: </b> </td>
                        <td> <?php echo $item['Price']; ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Previous Price: </b> </td>
                        <td> <?php echo $item['Price']; ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Transaction: </b> </td>
                        <td>
                            <input type="text" value="BUY" name="buy-sell" id="buy-sell">
                        </td>
                    </tr>
                    <tr>
                        <td> <b> Purchase Date: </b> </td>
                        <td> <?php echo date('m/d/Y'); ?> </td>
                    </tr>
                    <tr>
                        <td> <b> Amount/Price: </b> </td>
                        <td> <input type="number" name="amount" value="0.001" step=".100" min="0.001" pattern="^\d*(\.\d{0,3})?$" class="amount-input"> </td>
                    </tr>
                </table>

                <div class="transaction-btn-container">
                    <button name="proceed-btn" class="btn btn-white"> Proceed </button>
                    <button type="button" class="btn btn-white close-modal"> Cancel </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Content -->
    <main class="content">
        <!-- Stock Details -->
        <section class="section">
            <!-- Stock Header with Name and Buy/Sell Buttons -->
            <div class="stock-header">
                <div class="stock-name-container">
                    <div class="stock-name">
                        <h3> <?php echo $item['StockName']; ?> </h3>
                        <span> <?php echo $item['CompanyName']; ?> </span>
                    </div>
                    <span><?php echo $item['Description']; ?> </span>
                </div>

                <!-- Buy Sell Btns -->
                <div class="buy-sell-container">
                    <button class="btn btn-primary modal-btn" id="buy-btn"> BUY </button>
                    <button class="btn btn-white modal-btn" id="sell-btn"> SELL </button>
                </div>
            </div>

            <!-- Prices and Volume -->
            <div class="stock-prices-container">
                <div class="stock-price">
                    <span> Prev. Price </span>
                    <span> <b> <?php echo $item['Price']; ?></b></span>
                </div>
                <div class="stock-price">
                    <span> Current Price </span>
                    <span> <b> <?php echo $item['Price']; ?></b></span>
                </div>
                <div class="stock-price">
                    <span> Volume </span>
                    <span> <b> <?php echo $item['Volume']; ?></b></span>
                </div>
                <div class="stock-price">
                    <span> Times Bought </span>
                    <span> <b> 0 </b></span>
                </div>
            </div>
            <div class="submit-error"></div>
        </section>

        <!-- Other Stock Details -->
        <section class="section">
            <div class="inner-section white-container">
                <div class="tabs-section">
                    <!-- Tab btns -->
                    <div class="stock-details-tabs">
                        <button class="btn btn-secondary active"> Summary </button>
                        <button class="btn btn-secondary"> Price History </button>
                        <button class="btn btn-secondary"> Comparisons </button>
                    </div>
                    <hr>
                    <!-- Tabs -->
                    <!-- Summary -->
                    <div class="stock-tab" id="summary-tab">
                        <table>
                            <tr>
                                <td colspan="2">
                                    <h4> Details </h4>
                                </td>
                            </tr>
                            <tr>
                                <td> Code: </td>
                                <td> <b><?php echo $item['StockName']; ?> </b> </td>
                            </tr>
                            <tr>
                                <td> Volume: </td>
                                <td> <b> <?php echo $item['Volume']; ?> </b> </td>
                            </tr>
                            <tr>
                                <td> Price: </td>
                                <td> <b> <?php echo $item['Price']; ?> </b> </td>
                            </tr>
                            <tr>
                                <td> Company: </td>
                                <td> <b> <?php echo $item['CompanyName']; ?> </b> </td>
                            </tr>
                            <tr>
                                <td> Description: </td>
                                <td> <b> <?php echo $item['Description']; ?> </b> </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td colspan="2">
                                    <h4> Recent Prices </h4>
                                </td>
                            </tr>
                            <tr>
                                <td> Current: </td>
                                <td> <b> <?php echo $item['Price']; ?> </b> </td>
                            </tr>
                            <tr>
                                <td> 24h: </td>
                                <td> <b><?php echo $item['Price']; ?> </b> </td>
                            </tr>
                            <tr>
                                <td> 3day: </td>
                                <td> <b> <?php echo $item['Price']; ?> </b> </td>
                            </tr>
                            <tr>
                                <td> 1week: </td>
                                <td> <b> <?php echo $item['Price']; ?> </b> </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Price History -->

                    <!-- Comparisons -->

                </div>
            </div>
        </section>

        <!-- Other Stocks in Market -->
        <section class="section">
            <div class="inner-section white-container">
                <div class="section-header">
                    <h4> check out other stocks available</h4>
                    <a href="market.php" class="btn btn-secondary btn-clear"> View All </a>
                </div>
                <hr>
                <table class="items-table">
                    <tr>
                        <th> Name </th>
                        <th> Volume </th>
                        <th> Company </th>
                        <th> Current Price </th>
                        <th></th>
                    </tr>
                    <?php
                    foreach ($stocks as $stock) {
                        echo "<tr> 
                            <td>" . $stock['StockName'] . "</td>
                            <td>" . $stock['Volume'] . "</td>
                            <td>" . $stock['CompanyName'] . "</td>
                            <td>" . $stock['Price'] . "</td>
                            <td><a href='stock.php?stock=" . $stock['StockID'] . "' class='btn btn-white btn-table'> View Details </a> </td>
                            </tr>";
                    }
                    ?>
                </table>
            </div>
        </section>
    </main>

    <?php
    if (isset($_POST['proceed-btn'])) {
        $amount = $_POST['amount'];
        $stock = $item['StockID'];
        $buy_sell = $_POST['buy-sell'];
        if ($buy_sell == 'SELL') {
            $qty = $db->stockQuantity($stock, $_SESSION['User']);
            if ($qty == 0) {
                echo "<script> cantSell(); </script>";
            } else {
                echo "<script> window.location.href='order-page.php?order=$stock&amount=$amount&type=$buy_sell' </script>";
            }
        } else {
            echo "<script> window.location.href='order-page.php?order=$stock&amount=$amount&type=$buy_sell' </script>";
        }
    }
    ?>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
    <script>

        // Modal 
        const modalBtn = document.querySelectorAll('.modal-btn');
        const modal = document.querySelector('.modal-overlay');
        const closemodal = document.querySelectorAll('.close-modal');
        const buy_sell = document.getElementById('buy-sell');


        modalBtn.forEach((btn) => {
            btn.addEventListener('click', () => {
                modal.classList.add('open-modal');
                if (btn.id == 'buy-btn') {
                    buy_sell.value = 'BUY'
                    buy_sell.style.backgroundColor = "var(--clr-primary)";

                } else {
                    buy_sell.value = 'SELL'
                    buy_sell.style.backgroundColor = "var(--clr-primary-light)";
                }
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