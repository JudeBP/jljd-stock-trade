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
$trades = $db->getTrades();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | JLJD</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/design.css">
    <link rel="icon" href="images/logo.png">

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
        <!-- Account Totals Summary -->
        <section class="section">
            <h2> welcome to your dashboard</h2>
            <div class="summary-container">
                <!-- Card Summary -->
                <div class="card-summary">
                    <div class="card-summary-header"></div>
                    <table>
                        <tr>
                            <td> Stocked Owned: </td>
                            <td> <b> <?php echo $db->getStocksOwned($_SESSION['User']); ?> </b> </td>
                        </tr>
                        <tr>
                            <td> Last Purchase: </td>
                            <td> <b> <?php echo $db->getLastPurchase($_SESSION['User']); ?> </b> </td>
                        </tr>
                        <tr>
                            <td> Total Transactions: </td>
                            <td> <b> <?php echo $db->getTotalTrades($_SESSION['User']); ?> </b> </td>
                        </tr>
                    </table>
                    <div class="card-summary-footer"></div>
                </div>
                <!-- Totals Pills -->
                <div class="totals-summary-container">
                    <div class="totals-summary">
                        <h4> Earnings </h4>
                        <div class="totals-number"> <?php echo $db->getTotalEarnings($_SESSION['User']); ?></div>
                    </div>
                    <div class="totals-summary">
                        <h4> Volume </h4>
                        <div class="totals-number"> <?php echo $db->getTotalVolume($_SESSION['User']); ?></div>
                    </div>
                    <div class="totals-summary">
                        <h4> Returns </h4>
                        <div class="totals-number"> <?php echo $db->getTotalReturns($_SESSION['User']); ?></div>
                    </div>
                </div>
                <!-- Totals Message -->
            </div>
            <p> This is where you will see your performance and stocks overall </p>

        </section>

        <!-- Quick Navigations -->
        <section class="section">
            <div class="inner-section white-container">
                <h3> Quick Navs</h3>
                <hr>
                <div class="quick-navs-container">
                    <div class="quick-nav" onclick="window.location.href='trades.php'">
                        <ion-icon name="receipt"></ion-icon>
                        <span> Trades </span>
                    </div>
                    <div class="quick-nav" onclick="window.location.href='inventory.php'">
                        <ion-icon name="logo-dropbox"></ion-icon>
                        <span> Inventory </span>
                    </div>
                    <div class="quick-nav" onclick="window.location.href='profile.php'">
                        <ion-icon name="person-circle"></ion-icon>
                        <span> Profile </span>
                    </div>
                    <div class="quick-nav" onclick="window.location.href='market.php'">
                        <ion-icon name="cart"></ion-icon>
                        <span> Market </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Weekly Performance Summary -->
        <section class="section">
            <div class="inner-section white-container">
                <div class="section-header">
                    <h3> Weekly Performance </h3>
                    <?php
                    $start = date('M d', strtotime('monday last week'));
                    $end = date('M d', strtotime('sunday last week'));
                    ?>
                    <p> <?php echo $start . ' - ' . $end; ?> </p>
                </div>
                <hr>
                <canvas id="chart" class="chart"></canvas>
                <div class="weekly-totals-container">
                    <div class="weekly-total">
                        <span> Totals Returns: </span>
                        <span> <?php echo $db->getWeeklyReturns($_SESSION['User'], $start, $end); ?> </span>
                    </div>
                    <div class="weekly-total">
                        <span> Earnings: </span>
                        <span> <?php echo $db->getWeeklyEarnings($_SESSION['User'], $start, $end); ?> </span>
                    </div>
                    <div class="weekly-total">
                        <span> Volume Added: </span>
                        <span> <?php echo $db->getWeeklyVolume($_SESSION['User'], $start, $end); ?> </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recent Trades Section -->
        <section class="section">
            <div class="inner-section white-container">
                <div class="section-header">
                    <h3> Recent Trades </h3>
                    <span> Number of Items: <span> <b> 0 </b></span> </span>
                </div>
                <hr>
                <table class="items-table">
                    <tr>
                        <th> Name </th>
                        <th> Trade Date </th>
                        <th> Trade Time </th>
                        <th> Type </th>
                    </tr>
                    <!-- PHP code -->
                    <?php
                    if (sizeof($trades) > 0) {
                        foreach ($trades as $trade) {
                            if ($trade['TransactionType'] == 0) {
                                $type = "Buy";
                            } else $type = "Sell";
                            echo "<tr> 
                            <td>" . $trade['StockName'] . "</td>
                            <td>" . $trade['TradeDate'] . "</td>
                            <td>" . $trade['TradeTime'] . "</td>
                            <td>" . $type . "</td>
                            </tr>";
                        }
                        echo "</table>";
                    } else echo "</table><div class = 'no-result'> No results found. </div>";

                    ?>
                    <a href="trades.php" class="btn btn-primary btn-clear"> See All Trades </a>
            </div>
        </section>

        <!-- Market Summary Section -->
        <section class="section">
            <div class="inner-section white-container">
                <div class="section-header">
                    <h3> in the market right now </h3>
                    <a href="market.php" class="btn btn-primary btn-clear"> View All </a>
                </div>
                <hr>
                <table class="items-table">
                    <tr>
                        <th> Name </th>
                        <th> Volume </th>
                        <th> Company </th>
                        <th> Price </th>
                    </tr>
                    <!-- PHP code -->
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

    <!-- Content End -->

    <!-- JS -->

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="js/chart.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
</body>

</html>