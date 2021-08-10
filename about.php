<?php
if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About JLJD Trades</title>

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
                    <li> <a href="index.php"> Home </a></li>
                    <li> <a href="register.php"> Register </a></li>
                    <li> <a href="login.php"> Sign In </a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">

        <section class="section contents-table-section">
            <div class="table-of-contents-container">
                <h3> table of contents </h3>
                <ul>
                    <li> <a href="#about" class="scroll"> About JLJD Trading </a> </li>
                    <li> <a href="#howtrade" class="scroll"> How to Trade and Invest </a> </li>
                    <li> <a href="#safety" class="scroll"> Trading Safety in JLJD </a> </li>
                    <li> <a href="#methods" class="scroll"> Investment Methods </a> </li>
                </ul>
            </div>
            <img src="/images/logo.png" alt="logo" class="logo-image">
        </section>

        <section class="section about-section" id="about">
            <h2> About JLJD Trading </h2>
            <p> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloribus at nobis neque libero qui pariatur.
                Id beatae magni ut! Minus eum nulla laudantium? Quam expedita totam at amet quasi. Nobis facere neque
                deleniti saepe beatae illum ullam dicta omnis labore quasi quia obcaecati itaque ex cum at, eius ipsum
                numquam id pariatur corporis cumque magni qui dolore vitae. Ipsum deserunt obcaecati laudantium dolorem
                eos, totam incidunt praesentium fuga placeat officiis dolore repudiandae a eligendi vel commodi fugit
                culpa recusandae voluptas ipsa accusamus quia soluta tempora! Debitis minima autem dignissimos nihil
                error eos, soluta reprehenderit vel corporis excepturi temporibus maxime aliquid.</p>
            <hr>
        </section>

        <section class="section about-section" id="howtrade">
            <h2> How do I trade and invest? </h2>
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras a felis tortor. Nullam aliquam, magna a
                vestibulum tempor, nibh sapien bibendum libero, sit amet molestie lectus risus id libero. Sed eget velit
                enim. Proin pellentesque, leo a sodales gravida, enim sapien rutrum arcu, faucibus ornare risus dui et
                urna. Nunc lectus tortor, semper sit amet sagittis at, hendrerit non dolor. Pellentesque augue arcu,
                viverra vitae odio ut, faucibus facilisis libero. Integer id lectus ornare, iaculis nisl accumsan,
                hendrerit nibh. In hac habitasse platea dictumst. Integer sollicitudin convallis odio non sagittis.
                Proin molestie faucibus nisl vitae facilisis.
            </p>
            <ul>
                <li> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li> Aenean a velit sed massa hendrerit dapibus et mattis nulla. </li>
                <li> Mauris faucibus felis nec tellus luctus, ac dictum mi vestibulum.</li>
                <li> Sed tincidunt massa a commodo pretium.</li>
                <br>
                <li> In at orci ut leo condimentum convallis ut quis nulla. </li>
                <li> Morbi vehicula libero hendrerit erat molestie, sed ornare est viverra.</li>
                <li> Maecenas molestie erat quis consequat accumsan.</li>
                <br>
                <li> Etiam pharetra tortor ut volutpat bibendum.</li>
                <li> Vestibulum sodales ipsum eget hendrerit vehicula.</li>
                <li> Cras eleifend massa ut tortor vestibulum molestie.</li>
            </ul>
            <hr>
        </section>
        <section class="section about-section" id="safety">
            <h2> Is it safe to put my money here? </h2>
            <p> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloribus at nobis neque libero qui pariatur.
                Id beatae magni ut! Minus eum nulla laudantium? Quam expedita totam at amet quasi. Nobis facere neque
                deleniti saepe beatae illum ullam dicta omnis labore quasi quia obcaecati itaque ex cum at, eius ipsum
                numquam id pariatur corporis cumque magni qui dolore vitae. Ipsum deserunt obcaecati laudantium dolorem
                eos, totam incidunt praesentium fuga placeat officiis dolore repudiandae a eligendi vel commodi fugit
                culpa recusandae voluptas ipsa accusamus quia soluta tempora! Debitis minima autem dignissimos nihil
                error eos, soluta reprehenderit vel corporis excepturi temporibus maxime aliquid.</p>
            <div class="safety-checks-container">
                <div class="safety">
                    <ion-icon name="checkmark-circle"></ion-icon>
                    <h4> Assurance and Security </h4>
                    <p>
                        The dashboard lets you see the summary of your weekly and all-time performance which will help
                        you improve your future investments.
                    </p>
                </div>
                <div class="safety">
                    <ion-icon name="checkmark-circle"></ion-icon>
                    <h4> Privacy </h4>
                    <p>
                        The prices and availability of stocks can change every day or even every hour. JLJD UI lets you
                        easily be up to date with any updates on the stocks.
                    </p>
                </div>
                <div class="safety">
                    <ion-icon name="checkmark-circle"></ion-icon>
                    <h4> Encryption </h4>
                    <p>
                        From PHP to USD and many more, different stocks/currencies are available for you to choose and
                        invest in!
                    </p>
                </div>
            </div>
            <hr>
        </section>

        <section class="section about-section" id="methods">
            <h2> What are our investment options? </h2>
            <p> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloribus at nobis neque libero qui pariatur.
                Id beatae magni ut! Minus eum nulla laudantium? Quam expedita totam at amet quasi. Nobis facere neque
                deleniti saepe beatae illum ullam dicta omnis labore quasi quia obcaecati itaque ex cum at, eius ipsum
                numquam id pariatur corporis cumque magni qui dolore vitae. Ipsum deserunt obcaecati laudantium dolorem
                eos, totam incidunt praesentium fuga placeat officiis dolore repudiandae a eligendi vel commodi fugit
                culpa recusandae voluptas ipsa accusamus quia soluta tempora! Debitis minima autem dignissimos nihil
                error eos, soluta reprehenderit vel corporis excepturi temporibus maxime aliquid.
            </p>
        </section>

        <section class="section contact-section">
            <h4> Interested in becoming a JLJD Trader?</h4>
            <a href="register.php" class="btn btn-primary landing-btn"> Become a Trader </a>
            <button class="btn btn-transparent contact-us-btn"> Contact Us</button>
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

    <button class="btn top-btn">
        <ion-icon name="arrow-up"></ion-icon>
    </button>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="js/scroll.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
</body>

</html>