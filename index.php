<?php
include 'includes/db.php';
include 'includes/product_functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="assets/js/script.js"></script>
    <title>Lovelyz Skincare</title>
</head>

<body>
    <header>
        <nav class="main-navigation" aria-label="main-navigation">
            <input type="checkbox" id="nav-check" class="nav-check">
            <div class="nav-top">
                <a href="#" class="logo">Lovelyz</a>
                <label for="nav-check" class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
            <ul class="main-menu">
                <li><a href="#home">Home</a></li>
                <li class="has-submenu"> <a href="#Cleansers">Cleansers</a>
                    <ul class="submenu">
                        <li><a href="#FoamCleansers">Foam Cleansers</a></li>
                        <li><a href="#GelCleansers">Gel Cleansers</a></li>
                        <li><a href="#CreamCleansers">Cream Cleansers</a></li>
                        <li><a href="#MilkCleansers">Milk Cleansers</a></li>
                        <li><a href="#OilCleansers">Oil Cleansers</a></li>
                        <li><a href="#MicellarWater">Micellar Water</a></li>
                    </ul>
                </li>
                <li class="has-submenu"> <a href="#treatment">Treatment</a>
                    <ul class="submenu">
                        <li><a href="#Toners">Toners</a></li>
                        <li><a href="#Serums">Serums</a></li>
                        <li><a href="#Essences">Essence</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#suncream">Suncream</a>
                    <ul class="submenu">
                        <li><a href="#ChemicalSunscreams">Chemical Suncreams</a></li>
                        <li><a href="#PhysicalSuncreams">Physical Suncreams</a></li>
                    </ul>
                </li>
                <li class="has-submenu"> <a href="#Masks">Masks</a>
                    <ul class="submenu">
                        <li><a href="#SleepingMasks">Sleeping Masks</a></li>
                        <li><a href="#SheetMasks">Sheet Masks</a></li>
                        <li><a href="#ClayMasks">Clay Masks</a></li>
                        <li><a href="#PeelOffMasks">Peel-off Masks</a></li>
                    </ul>
                </li>

                <li><a href="pages/cart.html">Cart 🛒</a></li>
                <li><a href="#more">More</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="home" id="home">
            <div class="content">
                <img class="img" src="assets/imazhe/Untitled%20design%20(4).png" alt="ph2">
                <div class="overlay-text">
                    <h1>Hi girlies!</h1>
                    <p><b>"Your Skin, Your Confidence, Your Glow!"</b></p>
                    <p>Unlock the secret to radiant, healthy skin with Lovelyz. Our science-backed, nature-inspired products are designed to nourish and rejuvenate, leaving your skin glowing and confident. Experience skincare that works for you.</p>
                </div>
            </div>
        </section>

        <section id="Cleansers">
            <h1 id="heading">Cleansers</h1>

            <h2 id="FoamCleansers">Foam Cleansers</h2>
            <?php displayProductsByCategory($conn, 'FoamCleanser'); ?>

            <h2 id="GelCleansers">Gel Cleansers</h2>
            <?php displayProductsByCategory($conn, 'GelCleanser'); ?>

            <h2 id="CreamCleansers">Cream Cleansers</h2>
            <?php displayProductsByCategory($conn, 'CreamCleanser'); ?>

            <h2 id="MilkCleanser">Milk Cleansers</h2>
            <?php displayProductsByCategory($conn, 'MilkCleanser'); ?>

            <h2 id="OilCleansers">Oil Cleansers</h2>
            <?php displayProductsByCategory($conn, 'oilCleanser'); ?>

            <h2 id="MicellarWater">Micellar Water</h2>
            <?php displayProductsByCategory($conn, 'MicellarWater'); ?>
        </section>

        <section id="Treatment">
            <h1 id="heading">Treatment</h1>

            <h2 id="Toners">Toners</h2>
            <?php displayProductsByCategory($conn, 'Toner'); ?>

            <h2 id="Serums">Serums</h2>
            <?php displayProductsByCategory($conn, 'Serum'); ?>

            <h2 id="Essences">Essences</h2>
            <?php displayProductsByCategory($conn, 'Essence'); ?>
        </section>

        <section id="Suncreams">
            <h1 id="heading">Suncreams</h1>

            <h2 id="ChemicalSunscreams">Chemical Suncreams</h2>
            <?php displayProductsByCategory($conn, 'ChemicalSuncream'); ?>

            <h2 id="PhysicalSuncreams">Physical Suncreams</h2>
            <?php displayProductsByCategory($conn, 'PhysicalSuncream'); ?>

        </section>

        <section id="Masks">
            <h1 id="heading">Masks</h1>

            <h2 id="SleepingMasks">Sleeping Masks</h2>
            <?php displayProductsByCategory($conn, 'SleepingMask'); ?>

            <h2 id="SheetMasks">Sheet Masks</h2>
            <?php displayProductsByCategory($conn, 'SheetMask'); ?>

            <h2 id="ClayMasks">Clay Masks</h2>
            <?php displayProductsByCategory($conn, 'ClayMask'); ?>

            <h2 id="PeelOffMasks">Peel-Off Masks</h2>
            <?php displayProductsByCategory($conn, 'PeelOffMask'); ?>
        </section>
    </main>

    <footer>
        <div class="footerContainer" id="more">
            <div class="footerNav">
                <ul>
                    <li><a href="" id="home">Home</a></li>
                    <li><a href="pages/info.html#aboutus">About Us</a></li>
                    <li> <a href="">Contact Us</a>
                        <div class="footerIcons">
                            <a href=""><i class="fa-brands fa-instagram"></i></a>
                            <a href=""><i class="fa-brands fa-facebook"></i></a>
                            <a href=""><i class="fa-brands fa-twitter"></i></a>
                            <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                        </div>
                    </li>
                    <li><a href="pages/info.html">Transport and Payment</a></li>
                    <li><a href="pages/info.html#membership">Membership</a>
                </ul>
            </div>
            <div class="footerBottom">
                <p>Copyright &copy;2024; Designed by <span class="designer">KLEA DISHA</span></p>
            </div>
        </div>
    </footer>
</body>

</html>

<?php $conn->close(); ?>