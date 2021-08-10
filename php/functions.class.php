<?php

/*
NOTES
Fields with true/false or 1/0 values
    *LockStatus (trader) -> 1 = locked, 0 = not locked
    *TransactionType (trade) -> 1 = sell, 0 = buy
*/
class DBHandler extends dbConn
{
    private $conn;

    private function disconnect()
    {
        $this->conn->close();
    }

    // ---------------------------------------------------------------------------------------------------- 
    //              USER CREDENTIALS VALIDATIONS - for login, register, and validations
    // ----------------------------------------------------------------------------------------------------

    // Check if username exists
    public function usernameExists($username)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT Username FROM trader WHERE Username = ? LIMIT 1";

            $exists = false;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $username);
                $stmnt->execute();
                $stmnt->store_result();
                $num_row = $stmnt->num_rows;
                if ($num_row > 0) {
                    $exists = true;
                }
                $stmnt->close();
            }
            
            $this->disconnect();
            return $exists;
        }
    }

    // Check if email exists
    public function emailExists($email)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT Email FROM trader WHERE Email = ?";

            $exists = false;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $email);
                $stmnt->execute();
                $stmnt->store_result();
                $num_row = $stmnt->num_rows;
                if ($num_row > 0) {
                    $exists = true;
                }
                $stmnt->close();
            }
            
            $this->disconnect();
            return $exists;
        }
    }

    // Decrypt hashed password from DB 
    public function validatePassword($user, $password)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT Userpassword FROM trader WHERE Username = ? OR Email = ? OR TraderID =?;";

            $valid = false;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("sss", $user, $user, $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $hashed_pass = $row['Userpassword'];
                }
                $stmnt->close();
                // VALIDATING INPUT PASSWORD WITH ENCRYPTED ONE
                if (password_verify($password, $hashed_pass)) {
                    $valid = true;
                }
            }
            $this->disconnect();
            return $valid;
        }
    }

    // Get ID from Email/Username
    public function getID($user)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT TraderID FROM trader WHERE Username = ? OR Email = ?";

            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("ss", $user, $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $id = $row['TraderID'];
                }
                $stmnt->close();
            }

            $this->disconnect();
            return $id;
        }
    }

    // Register user
    public function insertUser($data)
    {
        if ($this->conn = $this->connect()) {
            $sql = "INSERT INTO trader VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            if ($stmnt = $this->conn->prepare($sql)) {
                $id = $this->getLastID();
                $signUpDate = date('Y/m/d');
                $lock = 0;

                // BCRYPT ENCRYPTION
                $hashed_pass = password_hash($data['password'], PASSWORD_DEFAULT);
                $stmnt->bind_param(
                    "ssssssssssssss",
                    $id,
                    $data['lastName'],
                    $data['firstName'],
                    $data['midName'],
                    $data['bday'],
                    $data['street'],
                    $data['city'],
                    $data['zipcode'],
                    $data['contact'],
                    $data['email'],
                    $signUpDate,
                    $data['username'],
                    $hashed_pass,
                    $lock
                );
                if ($stmnt->execute()) {
                    $stmnt->close();
                }
            }
            $this->disconnect();
        }
    }

    // get user profile
    public function getUserProfile($user)
    {
        if ($this->conn = $this->connect()) {
            $sql = 'SELECT TraderID, FirstName, LastName, Username, SignUpDate, Email, ContactNo, Street, City, Zipcode FROM trader WHERE TraderID = ?;';

            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param('s', $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $id = $row['TraderID'];
                    $fName = $row['FirstName'];
                    $lName = $row['LastName'];
                    $username = $row['Username'];
                    $signUpDate = $row['SignUpDate'];
                    $email = $row['Email'];
                    $contact = $row['ContactNo'];
                    $street = $row['Street'];
                    $city = $row['City'];
                    $zipcode = $row['Zipcode'];
                    $data = [
                        'TraderID' => $id,
                        'FirstName' => $fName,
                        'LastName' => $lName,
                        'Username' => $username,
                        'SignUpDate' => $signUpDate,
                        'Email' => $email,
                        'Contact' => $contact,
                        'Street' => $street,
                        'City' => $city,
                        'Zipcode' => $zipcode
                    ];
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $data;
        }
    }

    // Updates account details (Profile, first tab)
    public function updateAccountDetails($data)
    {
        if ($this->conn = $this->connect()) {
            $sql = "UPDATE trader SET
                FirstName = ?,
                LastName = ? 
                WHERE TraderID = ?;";

            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param(
                    "sss",
                    $data['FirstName'],
                    $data['LastName'],
                    $data['TraderID']
                );
                if ($stmnt->execute()) {
                    $stmnt->close();
                }
            }
            $this->disconnect();
        }
    }

    // Updates account info (Profile page, 2nd tab) 
    public function updateUserInfo($data)
    {
        if ($this->conn = $this->connect()) {
            $sql = "UPDATE trader SET
                Email = ?,
                ContactNo = ?,
                Street = ?,
                City = ?,
                Zipcode = ?
                WHERE TraderID = ?;";

            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param(
                    "ssssss",
                    $data['Email'],
                    $data['ContactNo'],
                    $data['Street'],
                    $data['City'],
                    $data['Zipcode'],
                    $data['TraderID']
                );
                if ($stmnt->execute()) {
                    $stmnt->close();
                }
            }
            $this->disconnect();
        }
    }

    public function updatePassword($data)
    {
        if ($this->conn = $this->connect()) {
            $sql = "UPDATE trader SET
                Userpassword = ? 
                WHERE TraderID = ?;";
            $hashed_pass = password_hash($data['password'], PASSWORD_DEFAULT);
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param(
                    "ss",
                    $hashed_pass,
                    $data['TraderID']
                );
                if ($stmnt->execute()) {
                    $stmnt->close();
                }
            }
            $this->disconnect();
        }
    }

    public function addBank($data)
    {
        if ($this->conn = $this->connect()) {
            $sql = "INSERT INTO bank_details VALUES (?,?,?,?,?)";
            $added = false;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param(
                    "sssss",
                    $data['AccountNumber'],
                    $data['AccountName'],
                    $data['TraderID'],
                    $data['BankName'],
                    $data['DateLinked']
                );
                if ($stmnt->execute()) {
                    $added = true;
                    $stmnt->close();
                }
            }
            $this->disconnect();
            return $added;
        }
    }

    public function removeBank($user, $accountNum, $accountName)
    {
        if ($this->conn = $this->connect()) {
            $sql = "DELETE FROM bank_details 
                WHERE TraderID = ? AND AccountNumber = ? AND AccountName = ? ;";
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("sss", $user, $accountNum, $accountName);
                if ($stmnt->execute()) {
                    $stmnt->close();
                }
            }
            $this->disconnect();
        }
    }

    public function bankTaken($accountNum, $accountName)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT * FROM bank_details WHERE AccountNumber = ? AND AccountName = ? ;";
            $taken = false;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("ss", $accountNum, $accountName);
                $stmnt->execute();
                if ($stmnt->get_result()->num_rows > 0) {
                    $taken = true;
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $taken;
        }
    }

    public function getBankAccounts($user)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT * FROM bank_details WHERE TraderID = ?;";
            $banks = array();
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $bank = array();
                    $bank['AccountNumber'] = $row['AccountNumber'];
                    $bank['AccountName'] = $row['AccountName'];
                    $bank['BankName'] = $row['BankName'];
                    $bank['DateLinked'] = $row['DateLinked'];
                    array_push($banks, $bank);
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $banks;
        }
    }

    // -------------------- Functions for user login attempts checking -------------------------//

    function userLocked($user)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT LockStatus FROM trader WHERE TraderID = ?;";
            $status = false;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                if ($result->fetch_assoc()['LockStatus'] == 1) {
                    $status = true;
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $status;
        }
    }

    function lockAccount($user)
    {
        if ($this->conn = $this->connect()) {
            $sql = "UPDATE trader set LockStatus = 1 WHERE TraderID = ?;";
            $status = false;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $stmnt->close();
            }
            $this->disconnect();
        }
    }

    // get login attempts
    function getLoginAttempts($user, $date)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT COUNT(*) AS 'LoginCount' FROM login_log WHERE TraderID = ? AND Try_date =? ;";
            $attempts = 0;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("ss", $user, $date);
                $stmnt->execute();
                $result = $stmnt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $attempts = $row['LoginCount'];
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $attempts;
        }
    }

    // Clear attempts of user if login succeeds
    function clearAttempts($user, $date)
    {
        if ($this->conn = $this->connect()) {
            $sql = "DELETE FROM login_log WHERE TraderID = ? AND Try_date = ?;";
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("ss", $user, $date);
                if ($stmnt->execute()) {
                    $stmnt->close();
                }
            }
            $this->disconnect();
        }
    }

    // Get the last login time of the user
    function getLastLogin($user, $date)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT Try_time FROM login_log WHERE TraderID=? AND Try_date=? ORDER BY Try_time DESC LIMIT 1;";
            $lastLogin = "0";
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("ss", $user, $date);
                $stmnt->execute();
                $result = $stmnt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $lastLogin = $row['Try_time'];
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $lastLogin;
        }
    }

    // insert login attempt
    function loginAttempt($user, $date, $time)
    {
        if ($this->conn = $this->connect()) {
            $date_trimmed = date('mdy', strtotime($date));
            $time_trimmed = date('His', strtotime($time));
            $log_attempt_id = substr($user, 4) . $date_trimmed . $time_trimmed;
            $sql = "INSERT INTO login_log VALUES (?,?,?,?);";
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("ssss", $log_attempt_id, $user, $date, $time);
                $stmnt->execute();
            }
            $stmnt->close();
            $this->disconnect();
        }
    }

    // ---------------------------------------------------------------------------------------------------- 
    //              STOCK/ITEM FUNCTIONS - to select,insert, update, and delete the stocks/items 
    // ----------------------------------------------------------------------------------------------------


    // gets items limit 10
    public function getItems()
    {
        if ($this->conn = $this->connect()) {
            $sql = 'SELECT stock.*, Price FROM stock LEFT JOIN stock_price ON stock_price.StockID = stock.StockID ORDER BY StockID ASC LIMIT 10;';
            $result = mysqli_query($this->conn, $sql);
            $stocks = array();
            if (mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    $stock = array();
                    $stock['StockID'] = $row['StockID'];
                    $stock['StockName'] = $row['StockName'];
                    $stock['Description'] = $row['Description'];
                    $stock['CompanyName'] = $row['CompanyName'];
                    $stock['Volume'] = $row['Volume'];
                    $stock['Availability'] = $row['Availability'];
                    $stock['Price'] = $row['Price'];
                    array_push($stocks, $stock);
                }
            }
            $result->close();
            $this->disconnect();
            return $stocks;
        }
    }

    // Favorite stocks to display in market
    public function getFavoriteStocks()
    {
        if ($this->conn = $this->connect()) {
            $sql = 'SELECT stock.*, Price FROM stock LEFT JOIN stock_price ON stock_price.StockID = stock.StockID ORDER BY StockID ASC LIMIT 3;';
            $result = mysqli_query($this->conn, $sql);
            $stocks = array();
            if (mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    $stock = array();
                    $stock['StockID'] = $row['StockID'];
                    $stock['StockName'] = $row['StockName'];
                    $stock['Description'] = $row['Description'];
                    $stock['CompanyName'] = $row['CompanyName'];
                    $stock['Volume'] = $row['Volume'];
                    $stock['Availability'] = $row['Availability'];
                    $stock['Price'] = $row['Price'];
                    array_push($stocks, $stock);
                }
            }
            $result->close();
            $this->disconnect();
            return $stocks;
        }
    }

    // Get stocks of user in inventory
    public function getStocksOwned($user)
    {
        if ($this->conn = $this->connect()) {
            $num = 0;
            $sql = "SELECT COUNT(*) as 'total' FROM inventory WHERE TraderID = ?; ";
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                $num = $result->fetch_assoc()['total'];
                $stmnt->close();
            }
            $this->disconnect();
            return $num;
        }
    }

    // Get summary of order/trader 
    public function getOrderSummary($order)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT trade.*, StockName, Description, CompanyName, Price FROM trade 
            LEFT JOIN stock ON stock.StockID = trade.StockID
            LEFT JOIN stock_price ON stock_price.StockID = trade.StockID
            WHERE TransactionID = ?;";
            $summary = array();
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $order);
                $stmnt->execute();
                $result = $stmnt->get_result();
                $row = $result->fetch_assoc();
                $summary['TradeDate'] = $row['TradeDate'];
                $summary['TradeTime'] = $row['TradeTime'];
                $summary['Amount'] = $row['Amount'];
                $summary['TransactionType'] = $row['TransactionType'];
                $summary['StockID'] = $row['StockID'];
                $summary['CompanyName'] = $row['CompanyName'];
                $summary['StockName'] = $row['StockName'];
                $summary['Description'] = $row['Description'];
                $summary['Price'] = $row['Price'];
                $stmnt->close();
            }
            $this->disconnect();
            return $summary;
        }
    }

    // Get total amount of all earnings
    public function getTotalAmount($user)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT SUM(Amount) AS 'Total' FROM trade WHERE TraderID = ? AND TransactionType =0 ;";
            $total = 0;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                if ($result->num_rows > 0) {
                    $total = $result->fetch_assoc()['Total'];
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $total;
        }
    }

    // Get DATE of last purchase
    public function getLastPurchase($user)
    {
        if ($this->conn = $this->connect()) {
            $lastDate = '--/--/----';
            $sql = "SELECT TradeDate FROM trade WHERE TraderID = ? ORDER BY TradeDate DESC LIMIT 1";
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                if ($result->num_rows > 0) {
                    $lastDate = $result->fetch_assoc()['TradeDate'];
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $lastDate;
        }
    }

    // Get TOTAL number of TRADES or TRANSACTIONS by the user
    public function getTotalTrades($user)
    {
        if ($this->conn = $this->connect()) {
            $total = 0;
            $sql = "SELECT COUNT(*) as 'total' FROM trade WHERE TraderID =? ;";
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                $total = $result->fetch_assoc()['total'];
                $stmnt->close();
            }
            $this->disconnect();
            return $total;
        }
    }

    // Get the trades of the user
    public function getTrades()
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT trade.*, StockName, Volume, CompanyName FROM trade 
            LEFT JOIN stock ON stock.StockID = trade.StockID
            WHERE TraderID = ? 
            ORDER BY TradeDate DESC;";
            $user = $_SESSION['User'];
            $items = array();
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $item = array();
                    $item['TransactionID'] = $row['TransactionID'];
                    $item['StockID'] = $row['StockID'];
                    $item['StockName'] = $row['StockName'];
                    $item['CompanyName'] = $row['CompanyName'];
                    $item['TradeDate'] = $row['TradeDate'];
                    $item['TradeTime'] = $row['TradeTime'];
                    $item['TransactionType'] = $row['TransactionType'];
                    $item['Volume'] = $row['Volume'];
                    array_push($items, $item);
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $items;
        }
    }

    // Get the stocks in the user's inventory
    public function getInventory()
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT inventory.*, StockName, Volume, CompanyName FROM inventory 
            LEFT JOIN stock ON stock.StockID = inventory.StockID
            WHERE TraderID = ?;";
            $user = $_SESSION['User'];
            $items = array();
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $item = array();
                    $item['StockID'] = $row['StockID'];
                    $item['StockName'] = $row['StockName'];
                    $item['CompanyName'] = $row['CompanyName'];
                    $item['Volume'] = $row['Volume'];
                    $item['Quantity'] = $row['Quantity'];
                    array_push($items, $item);
                }
                $stmnt->close();
            }

            $this->disconnect();
            return $items;
        }
    }

    // Get details of stocks
    public function getItemDetails($itemID)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT * FROM stock 
            LEFT JOIN stock_price ON stock_price.StockID = stock.StockID 
            WHERE stock.StockID = ?;";
            $item = array();
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $itemID);
                $stmnt->execute();
                $result = $stmnt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $item['StockID'] = $row['StockID'];
                    $item['StockName'] = $row['StockName'];
                    $item['Description'] = $row['Description'];
                    $item['CompanyName'] = $row['CompanyName'];
                    $item['Price'] = $row['Price'];
                    $item['PriceStart'] = $row['StartDate'];
                    $item['PriceEnd'] = $row['EndDate'];
                    $item['Volume'] = $row['Volume'];
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $item;
        }
    }

    // Check if user possesses the stock
    public function stockExists($stockID, $userID)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT StockID FROM Inventory WHERE StockID = ? AND TraderID = ?";

            $exists = false;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("ss", $stockID, $userID);
                $stmnt->execute();
                $stmnt->store_result();
                $num_row = $stmnt->num_rows;
                if ($num_row > 0) {
                    $exists = true;
                }
                $stmnt->close();
            }

            $this->disconnect();
            return $exists;
        }
    }

    // Check the stock quantity
    public function stockQuantity($stockID, $userID)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT Quantity FROM inventory WHERE StockID = ? AND TraderID = ?";

            $sQty = 0;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("ss", $stockID, $userID);
                $stmnt->execute();
                $result = $stmnt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $sQty = $row['Quantity'];
                }
                $stmnt->close();
            }

            $this->disconnect();
            return $sQty;
        }
    }

    // Update the number of stocks in the user's inventory if he/she already has it
    public function updateInventory($user, $item, $qty)
    {
        if ($this->conn = $this->connect()) {
            $sql = "UPDATE inventory SET `Quantity` = ? , `DateAdded` = ? WHERE TraderID = ? AND StockID = ?";
            if ($stmnt = $this->conn->prepare($sql)) {
                $date = date('Y-m-d');
                $stmnt->bind_param("ssss", $qty, $date, $user, $item);
                $stmnt->execute();
                $stmnt->close();
            }
            $this->disconnect();
        }
    }


    // Get the total earnings 
    public function getTotalEarnings($user)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT SUM(Price) as 'Total' FROM trade
                 LEFT JOIN stock_price ON stock_price.StockID = trade.StockID
                 WHERE TraderID = ? ;";
            $total = 0.000;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                $total = $result->fetch_assoc()['Total'];
                if ($total == '' || $total == null) {
                    $total = 0.00;
                }

                $stmnt->close();
            }
            $this->disconnect();
            return $total;
        }
    }

    // Get the total volume
    public function getTotalVolume($user)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT SUM(Volume) as 'Total' FROM inventory 
             LEFT JOIN stock ON stock.StockID = inventory.StockID 
             WHERE TraderID = ?";
            $total = 0.000;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                if (!$total = $result->fetch_assoc()['Total']) {
                    $total = 0.000;
                }

                $stmnt->close();
            }
            $this->disconnect();
            return $total;
        }
    }

    // Get the total returns
    public function getTotalReturns($user)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT SUM(Price) as 'Total' FROM trade 
             LEFT JOIN stock_price ON stock_price.StockID = trade.StockID 
             WHERE TraderID = ? AND TransactionType = 1;";
            $total = 0.000;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("s", $user);
                $stmnt->execute();
                $result = $stmnt->get_result();
                if (!$total = $result->fetch_assoc()['Total']) {
                    $total = 0.000;
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $total;
        }
    }

    // ------------- WEEKLY TOTALS ------------------ // 

    public function getWeeklyEarnings($user, $start, $end)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT SUM(Price) as 'Total' FROM trade
                 LEFT JOIN stock_price ON stock_price.StockID = trade.StockID
                 WHERE TraderID = ? 
                 AND (TradeDate BETWEEN ? AND ?);";
            $total = 0.000;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("sss", $user, $start, $end);
                $stmnt->execute();
                $result = $stmnt->get_result();
                $total = $result->fetch_assoc()['Total'];
                if ($total == '' || $total == null) {
                    $total = 0.00;
                }

                $stmnt->close();
            }
            $this->disconnect();
            return $total;
        }
    }

    public function getWeeklyReturns($user, $start, $end)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT SUM(Price) as 'Total' FROM trade 
             LEFT JOIN stock_price ON stock_price.StockID = trade.StockID 
             WHERE TraderID = ? AND TransactionType = 1 
             AND (TradeDate BETWEEN ? AND ?);";
            $total = 0.000;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("sss", $user, $start, $end);
                $stmnt->execute();
                $result = $stmnt->get_result();
                if (!$total = $result->fetch_assoc()['Total']) {
                    $total = 0.000;
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $total;
        }
    }

    public function getWeeklyVolume($user, $start, $end)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT SUM(Volume) as 'Total' FROM inventory 
             LEFT JOIN stock ON stock.StockID = inventory.StockID 
             WHERE TraderID = ? 
             AND (TradeDate BETWEEN ? AND ?)";
            $total = 0.000;
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("sss", $user, $start, $end);
                $stmnt->execute();
                $result = $stmnt->get_result();
                if (!$total = $result->fetch_assoc()['Total']) {
                    $total = 0.000;
                }

                $stmnt->close();
            }
            $this->disconnect();
            return $total;
        }
    }

    // ------------------------- Search functions ---------------------------------------//

    // Search stock/item in stocks for MARKET
    public function searchItem($keyword)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT stock.*, Price FROM stock 
            LEFT JOIN stock_price ON stock_price.StockID = stock.StockID
            WHERE StockName LIKE ? OR CompanyName LIKE ? OR  Volume LIKE ? LIMIT 10";

            $name_param = "%{$keyword}%";
            $stocks = array();
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("sss", $keyword, $name_param, $keyword);
                $stmnt->execute();
                $result = $stmnt->get_result();
                $stocks = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $stock = array();
                        $stock['StockID'] = $row['StockID'];
                        $stock['StockName'] = $row['StockName'];
                        $stock['Description'] = $row['Description'];
                        $stock['CompanyName'] = $row['CompanyName'];
                        $stock['Volume'] = $row['Volume'];
                        $stock['Availability'] = $row['Availability'];
                        $stock['Price'] = $row['Price'];
                        array_push($stocks, $stock);
                    }
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $stocks;
        }
    }

    // Search stock/item in trade table for TRADES
    public function searchTrade($keyword)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT * FROM trade 
                LEFT JOIN stock ON stock.StockID = trade.StockID
                WHERE StockName LIKE ? OR CompanyName LIKE ? OR  Volume LIKE ? LIMIT 10";

            $name_param = "%{$keyword}%";
            $stocks = array();
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("sss", $name_param, $name_param, $name_param);
                $stmnt->execute();
                $result = $stmnt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $stock = array();
                        $stock['StockID'] = $row['StockID'];
                        $stock['StockName'] = $row['StockName'];
                        $stock['Description'] = $row['Description'];
                        $stock['CompanyName'] = $row['CompanyName'];
                        $stock['Volume'] = $row['Volume'];
                        $stock['TradeDate'] = $row['TradeDate'];
                        $stock['TradeTime'] = $row['TradeTime'];
                        $stock['TransactionType'] = $row['TransactionType'];
                        array_push($stocks, $stock);
                    }
                }
                $stmnt->close();
            }

            $this->disconnect();
            return $stocks;
        }
    }

    // Search stock/item in inventory table for INVENTORY
    public function searchInventory($keyword)
    {
        if ($this->conn = $this->connect()) {
            $sql = "SELECT * FROM inventory
                LEFT JOIN stock ON stock.StockID = inventory.StockID
                WHERE StockName LIKE ? OR CompanyName LIKE ? OR  Volume LIKE ? LIMIT 10";

            $name_param = "%{$keyword}%";
            $stocks = array();
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("sss", $name_param, $name_param, $name_param);
                $stmnt->execute();
                $result = $stmnt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $stock = array();
                        $stock['StockID'] = $row['StockID'];
                        $stock['StockName'] = $row['StockName'];
                        $stock['Description'] = $row['Description'];
                        $stock['CompanyName'] = $row['CompanyName'];
                        $stock['Volume'] = $row['Volume'];
                        $stock['Quantity'] = $row['Quantity'];
                        array_push($stocks, $stock);
                    }
                }
                $stmnt->close();
            }
            $this->disconnect();
            return $stocks;
        }
    }

    // ------------------------- Stock updating functions ---------------------------------------//


    // Place order to user
    public function placeOrder($item, $amount, $type)
    {
        if ($this->conn = $this->connect()) {
            $sql = "INSERT INTO trade VALUES (?,?,?,?,?,?,?);";
            if ($stmnt = $this->conn->prepare($sql)) {
                $user = $_SESSION['User'];
                $tradeDate = date('Y-m-d');
                $tradeTime = date('H:i');
                $transacID = $this->createTransactionID($user, $item, date('mdy'), date('Hi'), $type);
                $stmnt->bind_param("sssssss", $transacID, $user, $item, $amount, $tradeDate, $tradeTime, $type);
                if ($stmnt->execute()) {
                    $stmnt->close();
                }
            }

            $this->disconnect();
        }
    }

    // Add stock to inventory
    public function addToInventory($user, $item, $qty)
    {
        if ($this->conn = $this->connect()) {
            $sql = "INSERT INTO inventory VALUES (?,?,?,?);";
            if ($stmnt = $this->conn->prepare($sql)) {
                $date = date('Y-m-d');
                $stmnt->bind_param("ssss", $user, $item, $qty, $date);
                if ($stmnt->execute()) {
                    $stmnt->close();
                }
            }
            $this->disconnect();
        }
    }

    // Remove stock from inventory
    public function removeFromInventory($user, $item)
    {
        if ($this->conn = $this->connect()) {
            $sql = "DELETE FROM inventory WHERE TraderID = ? AND StockID = ?;";
            if ($stmnt = $this->conn->prepare($sql)) {
                $stmnt->bind_param("ss", $user, $item);
                $stmnt->execute();
                $stmnt->close();
            }
            $this->disconnect();
        }
    }


    // ---------------------------------------------------------------------------------------------------- 
    //              PRIVATE FUNCTIONS - Don't need to establish connections 
    // ----------------------------------------------------------------------------------------------------

    // create transaction ID - TraderID + StockID + Date + Type
    protected function createTransactionID($trader, $item, $date, $time, $type)
    {
        $traderNum = substr($trader, 4);
        $itemNum = substr($item, 4);
        if ($type == 0) {
            $typeletter = 'B';
        } else {
            $typeletter = "S";
        }
        return $traderNum . '-' . $itemNum . '-' . $date . $time . '-' . $typeletter;
    }


    // get last User ID and increment
    protected function getLastID()
    {
        $sql = "SELECT TraderID FROM trader ORDER BY TraderID desc LIMIT 1";
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $newID = substr($row['TraderID'], 4);
                $newID++;
                $result->close();
                $pad = strlen($newID);
                return 'USER' . str_pad($newID, 9 - $pad, "0", STR_PAD_LEFT);
            }
        } else {
            return 'USER00000001';
        }
    }
}
