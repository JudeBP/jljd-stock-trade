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
        $stocks = $db->searchInventory(clean($_POST['search-txt']));
    } else $stocks = $db->getInventory();
} else $stocks = $db->getInventory();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory | JLJD</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/design.css">
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

    <!-- Content -->
    <main class="content">
        <!-- Inventory Table -->
        <section class="section account-section">
            <div class="section-header">
                <h3> Inventory </h3>
                <form class="search-container" method="POST">
                    <button name="search-btn" class="btn btn-secondary"> Search</button>
                    <input type="text" name="search-txt" placeholder="Search Item..">
                </form>
            </div>
        </section>

        <section class="section">
            <div class="inner-section white-container">
                <div class="section-header">
                    <!-- Table Summary -->
                    <div class="table-summary-container">
                        <div class="table-summary">
                            <span> Total Stocks: </span>
                            <h4> <?php echo count($stocks); ?> </h4>
                        </div>
                        <div class="table-summary">
                            <span> Total Volume: </span>
                            <h4> <?php echo count($stocks); ?> </h4>
                        </div>
                    </div>
                    <!-- Filter dropdown -->
                    <select>
                        <option value="most-recent"> Most Recent </option>
                    </select>
                </div>
                <table class="items-table">
                    <tr>
                        <th> Name </th>
                        <th> Volume </th>
                        <th> Company </th>
                        <th> Quantity </th>
                    </tr>
                    <?php
                    if (sizeof($stocks) > 0) {
                        foreach ($stocks as $stock) {
                            $stockID = $stock['StockID'];
                            echo "<tr class = 'border-bottom'> 
                            <td>" . $stock['StockName'] . "</td>
                            <td>" . $stock['Volume'] . "</td>
                            <td>" . $stock['CompanyName'] . "</td>
                            <td>" . $stock['Quantity'] . "</td>
                            <td><a href='stock.php?stock=$stockID' class='btn btn-white btn-table'> View in Market </a> </td>
                            </tr>";
                        }
                        echo "</table>";
                    } else echo "</table><div class = 'no-result'> No result found. </div>";
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