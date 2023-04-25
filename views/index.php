<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Bus Route</title>
</head>
<body>
    <div id="container">
        <?php
            include "nav_bar.php";
        ?>
        <!-- this is the main section -->
        <main class="main-content">
            <?php include "hero_section.php"?>
            <!-- start of the about section -->
             <?php
                include "about_section.php";
             ?>
            <!-- end of the about section -->

            <!-- start of the feature section -->
            <section class="features" id="Features">
                <h2 style="text-align: center;margin-top: 4em;">How to get started <br> With Our Application</h2>

                <div class="grid-container">
                    <div class="grid-child child-1">
                        <figure>
                            <div class="img-container-sign-up">
                                <img src="../images/sign-up-form-css-html.png" alt="">
                            </div>

<!--                            <figcaption class="sign-up-form"><span>1</span> <h2>Create an Acc</h2></figcaption>-->
                        </figure>
                    </div>
                    <div class="grid-child child-2">
                        <span>1. &nbsp; Create an Acc</span>
                    </div>
                    <div class="grid-child child-3">
                        <span>2. &nbsp; Manage Using dashboard </span>
                        <div class="connecting-line"></div>
                    </div>
                    <div class="grid-child child-4">
                        <figure>
                            <div class="img-container-sign-up">
                                <img src="../images/dashboard_image-removebg-preview.png" alt="">
                            </div>

<!--                            <figcaption class="dashboard-caption"><span>2</span> <h2>Manage Using Dashboard</h2></figcaption>-->
                        </figure>
                    </div>
                    <div class="grid-child child-5">
                        <figure>
                            <div class="img-container-sign-up">
                                <img src="../images/web-3120321_640.png" alt="">
                            </div>

<!--                            <figcaption class="dashboard-caption"><span>3</span><h2>Get your Location in latitude and longitude</h2></figcaption>-->
                        </figure>
                    </div>
                    <div class="grid-child child-6">
                        <span>3. &nbsp; Get Your location in latitude and longitude</span>
                    </div>
                </div>
            </section>
              
            <!-- end of the feature section -->

            <!-- start of the contact section -->
<!--            <section id="contact">-->
<!--                    -->
<!--            </section>-->
            <!-- end of the contact section -->
        </main>

        <!-- this is the end of te main section -->
        <footer class="footer">
            <div class="container-footer">
                <div class="row">
                    <div class="footer-col">
                        <h4>company</h4>
                        <ul>
                            <li><a href="#">about us</a></li>
                            <li><a href="#">our services</a></li>
                            <li><a href="#">privacy policy</a></li>
                            <li><a href="#">affiliate program</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>get help</h4>
                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">shipping</a></li>
                            <li><a href="#">returns</a></li>
                            <li><a href="#">order status</a></li>
                            <li><a href="#">payment options</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>online shop</h4>
                        <ul>
                            <li><a href="#">watch</a></li>
                            <li><a href="#">bag</a></li>
                            <li><a href="#">shoes</a></li>
                            <li><a href="#">dress</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>follow us</h4>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="index.js"></script>
    <!-- <script src="https://kit.fontawesome.com/adae769a6b.js" crossorigin="anonymous"></script> -->
</body>

</html>