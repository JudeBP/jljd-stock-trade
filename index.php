<?php
if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

session_start();
if (isset($_SESSION['LoggedIn'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JLJD Website </title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/design.css">
    <link rel="icon" href="images/logo.png">
</head>

<body>

    <!-- Header -->
    <header class="header no-margin-header">
        <div class="inner-header">

            <!-- Header with Hamburger Menu -->
            <div class="header-container">
                <a href="index.php">
                    <img src="/images/logo.png" alt="logo" class="header-logo">
                </a>
                <button class="header-toggle">
                    <ion-icon name="menu"></ion-icon>
                </button>
            </div>

            <!-- Header Links -->
            <div class="links-container">
                <ul class="header-links">
                    <li> <a href="#whyJLJD" class="scroll"> Why JLJD? </a></li>
                    <li> <a href="#features" class="scroll"> Features </a></li>
                    <li> <a href="#services" class="scroll"> Services </a></li>
                    <li> <a href="#contact" class="scroll"> Contact </a></li>
                    <li> <a href="login.php"> Sign In </a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">

        <!-- Landing Cover -->
        <div class="landing-cover">
            <h1> Become a JLJD Trader Now! </h1>
            <h3> sign up and invest with us </h3>
            <a href="register.php" class="btn btn-primary landing-btn"> Become a Trader </a>
            <a href="about.php" class="btn btn-transparent learn-more-btn"> LEARN MORE </a>
        </div>

        <!-- Features -->
        <section class="section" id="features">
            <h3> Make the best out of your investments with all the features </h3>
            <div class="features-container">
                <div class="feature">
                    <img src="/images/dollar-symbol.png" alt="dollar">
                    <hr>
                    <p>
                        Invest using all our stock options to help you benefit in our business or personally.
                        Make your money grow in no time with the ever-increasing values of the stocks.
                    </p>
                </div>
                <div class="feature">
                    <img src="/images/line-chart.png" alt="chart">
                    <hr>
                    <p>
                        Invest using all our stock options to help you benefit in our business or personally.
                        Make your money grow in no time with the ever-increasing values of the stocks.
                    </p>
                </div>
                <div class="feature">
                    <img src="/images/check.png" alt="check">
                    <hr>
                    <p>
                        Invest using all our stock options to help you benefit in our business or personally.
                        Make your money grow in no time with the ever-increasing values of the stocks.
                    </p>
                </div>
            </div>
        </section>

        <!-- Why JLJD -->
        <section class="section blue-section" id="whyJLJD">
            <ion-icon name="information-circle" class="info-icon"></ion-icon>
            <h2> Why JLJD? </h2>
            <div class="reasons-container">
                <div class="reason">
                    <ion-icon name="lock-closed"></ion-icon>
                    <span> Secured Details </span>
                </div>
                <div class="reason">
                    <ion-icon name="cash"></ion-icon>
                    <span> Legit Earnings </span>
                </div>
                <div class="reason">
                    <ion-icon name="card"></ion-icon>
                    <span> User Transparency </span>
                </div>
                <div class="reason">
                    <ion-icon name="phone-portrait-outline"></ion-icon>
                    <span>Responsive to mobile</span>
                </div>
                <div class="reason">
                    <ion-icon name="list"></ion-icon>
                    <span> Many investments to choose</span>
                </div>
                <hr>
            </div>
            <p>
                The JLJD website is an online trading platform and serves as the broker which allows the user or a
                trader to freely buy and sells a financial product online.
                Bonds, stocks (shares), futures, international currencies, and other financial products are among
                the many financial instruments that can be traded online.
                The platforms also provide information about the different products and market available online
                which enable the user to learn more about the financial instrument or any updates about the online
                market.
            </p>
        </section>

        <!-- Services -->
        <section class="section" id="services">
            <h3>Become a trader easily and benefit from our services</h3>
            <!-- Service 1 -->
            <div id="service-bg1">
                <div class="service-container">
                    <div class="service-header">
                        <h4>Comprehensive and user-friendly Trading Interface</h4>
                        <a href="about.php" class="btn btn-primary"> <b> Learn More </b></a>
                    </div>
                    <p>
                        User and system interactivity is one thing that gets us engaged in using the system. When you
                        become
                        a JLJD trader, you will have access to the simple yet detail-filled interface that lets you
                        easily
                        view, buy, sell, and more, easily.
                    </p>
                    <hr>
                    <div class="service-checks-container">
                        <div class="service">
                            <ion-icon name="checkmark-circle"></ion-icon>
                            <p>
                                The dashboard lets you see the summary of your weekly and all-time performance which
                                will
                                help you improve your future investments.
                            </p>
                        </div>
                        <div class="service">
                            <ion-icon name="checkmark-circle"></ion-icon>
                            <p>
                                The dashboard lets you see the summary of your weekly and all-time performance which
                                will
                                help you improve your future investments.
                            </p>
                        </div>
                        <div class="service">
                            <ion-icon name="checkmark-circle"></ion-icon>
                            <p>
                                The dashboard lets you see the summary of your weekly and all-time performance which
                                will
                                help you improve your future investments.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Service 2 -->
            <div id="service-bg2">
                <div class="service-container">
                    <div class="service-header">
                        <h4> Lots of stocks to choose from </h4>
                        <a href="about.php" class="btn btn-primary"> <b> Learn More</b> </a>
                    </div>
                    <p>
                        User and system interactivity is one thing that gets us engaged in using the system. When you
                        become
                        a JLJD trader, you will have access to the simple yet detail-filled interface that lets you
                        easily
                        view, buy, sell, and more, easily.
                    </p>
                    <hr>
                    <div class="service-checks-container">
                        <div class="service">
                            <ion-icon name="checkmark-circle"></ion-icon>
                            <p>
                                The dashboard lets you see the summary of your weekly and all-time performance which
                                will
                                help you improve your future investments.
                            </p>
                        </div>
                        <div class="service">
                            <ion-icon name="checkmark-circle"></ion-icon>
                            <p>
                                The dashboard lets you see the summary of your weekly and all-time performance which
                                will
                                help you improve your future investments.
                            </p>
                        </div>
                        <div class="service">
                            <ion-icon name="checkmark-circle"></ion-icon>
                            <p>
                                The dashboard lets you see the summary of your weekly and all-time performance which
                                will
                                help you improve your future investments.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="section contact-section" id="contact">
            <h3>Become a trader and find solutions to your investments now.</h3>
            <h4> Stay connected with us to learn more</h4>
            <a href="register.php" class="btn btn-primary landing-btn"> Become a Trader </a>
            <a href="about.php" class="btn btn-transparent contact-us-btn"> Contact Us</a>
        </section>

    </main>

    <!-- Footer -->
    <footer>
        <p>
            Only fully competent adults are permitted to conduct transactions on this Website. Trading with financial
            instruments supplied on the Website entails a high level of risk; as a result, trading can be extremely
            dangerous. If you use the financial instruments offered on this Website to perform transactions, you risk
            losing a significant amount of money or perhaps losing your whole account balance.
            instruments offered on the Website.
        </p>
        <ul class="footer-links">
            <li> <a href="about.php"> About JLJD </a> </li>
            <li> <a href="about.php"> Community </a> </li>
            <li> <a href="about.php"> FAQ </a> </li>
            <li> <a href="about.php"> Partnerships </a> </li>
        </ul>

        <!-- Join Btn with Social Media Links -->
        <div class="vertical-line"></div>
        <div class="footer-join-container">
            <a href="register.php" class="btn footer-btn"> Join Us Now</a>
            <div class="footer-sm-container">
                <ion-icon name="logo-facebook" class="sm-icon"></ion-icon>
                <ion-icon name="logo-instagram" class="sm-icon"></ion-icon>
                <ion-icon name="logo-twitter" class="sm-icon"></ion-icon>
            </div>
        </div>
    </footer>

    <!-- Back to Top Btn -->
    <button class="btn top-btn">
        <ion-icon name="arrow-up"></ion-icon>
    </button>

    <!-- JS -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
    <script type="text/javascript" src="js/scroll.js"></script>
</body>

</html>