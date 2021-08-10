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

$stocks = array();
if (isset($_POST['search-btn'])) {
    if (!empty($_POST['search-txt'])) {
        $stocks = $db->searchItem(clean($_POST['search-txt']));
    } else $stocks = $db->getItems();
} else $stocks = $db->getItems();

$fave_stocks = $db->getFavoriteStocks();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace | JLJD</title>

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
        <!-- Market Top -->

        <section class="section account-section">

            <h2 class="market-header">marketplace </h2>
            <h3 class="favorites-header">favorites right now!</h3>
            <div class="favorites-container">
                <div class="favorite-item" onclick="window.location.href='stock.php?stock=<?php echo $fave_stocks[0]['StockID']; ?>'">
                    <div class="favorite-details">
                        <span> <b> <?php echo $fave_stocks[0]["StockName"]; ?></b> </span>
                        <span><?php echo $fave_stocks[0]["Price"]; ?> </span>
                        <span><?php echo $fave_stocks[0]["Volume"]; ?> </span>
                    </div>
                    <ion-icon name="bar-chart-sharp"></ion-icon>
                </div>
                <div class="favorite-item" onclick="window.location.href='stock.php?stock=<?php echo $fave_stocks[1]['StockID']; ?>'">
                    <div class="favorite-details">
                        <span> <b> <?php echo $fave_stocks[1]["StockName"]; ?> </b> </span>
                        <span> <?php echo $fave_stocks[1]["Price"]; ?> </span>
                        <span> <?php echo $fave_stocks[1]["Volume"]; ?></span>
                    </div>
                    <ion-icon name="bar-chart-sharp"></ion-icon>
                </div>
                <div class="favorite-item" onclick="window.location.href='stock.php?stock=<?php echo $fave_stocks[2]['StockID']; ?>'">
                    <div class="favorite-details">
                        <span> <b> <?php echo $fave_stocks[2]["StockName"]; ?> </b> </span>
                        <span> <?php echo $fave_stocks[2]["Price"]; ?> </span>
                        <span><?php echo $fave_stocks[2]["Volume"]; ?> </span>
                    </div>
                    <ion-icon name="bar-chart-sharp"></ion-icon>
                </div>

            </div>
        </section>
        <!-- Items Table Market -->
        <section class="section">
            <div class="inner-section white-container">
                <h3> in the market</h3>
                <div class="section-header">
                    <!-- Market Table Tabs -->
                    <div class="market-tabs-container">
                        <button class="btn btn-dark"> All </button>
                        <button class="btn btn-dark btn-disabled"> Trending </button>
                        <button class="btn btn-dark btn-disabled"> New </button>
                    </div>
                    <!-- Search -->
                    <form class="search-container" method="POST">
                        <button name="search-btn" class="btn btn-secondary">Search</button>
                        <input type="text" name="search-txt" placeholder="Search item..">
                    </form>
                </div>
                <table class="items-table">
                    <tr>
                        <th> Name </th>
                        <th> Trade Date </th>
                        <th> Trade Time </th>
                        <th> Transaction Type </th>
                    </tr>
                    <?php
                    if (count($stocks) > 0) {
                        foreach ($stocks as $stock) {
                            echo "<tr> 
                            <td>" . $stock['StockName'] . "</td>
                            <td>" . $stock['Volume'] . "</td>
                            <td>" . $stock['CompanyName'] . "</td>
                            <td>" . $stock['Price'] . "</td>
                            <td><a href='stock.php?stock=" . $stock['StockID'] . "' class='btn btn-white btn-table'> View Details </a> </td>
                            </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "</table>
                        <div class = 'no-result'> No results for your search. </div>";
                    }
                    ?>

                <!-- Pages -->
                <div class="pages-container">
                    <ion-icon name="chevron-back"></ion-icon>
                    <div class="page-numbers">
                        <span> 1 </span>
                        <span> 2 </span>
                    </div>
                    <ion-icon name="chevron-forward"></ion-icon>
                </div>
            </div>
        </section>

    </main>

    <!-- Content End -->

    <!-- JS -->

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
</body>

</html>