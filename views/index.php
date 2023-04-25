<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
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
            <section id="about">
                <h2 class="about-us-title" style="text-align: center;">About Us</h2>
                <div class="container-student">
                    <div class="img-file">
                        <img src="../images/50426-removebg-preview.png" class="illustration-about" alt="">
                    </div>
                    <div class="description">
                        <h3 style="margin-bottom:1rem; margin-top: 4rem;">Student <img src="../images/graduated.png"
                                width="20px" alt=""></h3>
                        <p>Student will able to get easily get their
                            schdeuled pick up after they sign in. They
                            are required to sign in with a valid location
                            they live in for correct bus location pick up
                        </p>
                    </div>
                </div>
                <div class="container-admin">
                    <div class="img-file container-admin-img">
                        <img src="../images/5437683.jpg" class="illustration-about" alt="">
                    </div>
                    <div class="description container-admin-des">
                        <h3 style="margin-bottom:1rem; margin-top: 4rem;">Teacher <img src="../images/teacher.png"
                                width="20px" alt=""></h3>
                        <p>Admin will be able to manage the pickUps through customized dashboard.
                            Admin will be able to see the details of the students and as well as
                            drivers. Admin will have every access rights and will be able easily manage
                            the students as well as provide schdelued pickUps.
                        </p>
                    </div>
                </div>
            </section>
            <!-- end of the about section -->

            <!-- start of the feature section -->
            <section class="features">
                <h2 style="text-align: center;">How to get started <br> With Our Application</h2>

                <div class="grid-container">
                    <div class="grid-child child-1">
                        <figure>
                            <div class="img-container-sign-up">
                                <img src="../images/sign-up-form-css-html.png" alt="">
                            </div>

                            <figcaption class="sign-up-form"><span>1</span> <h2>Create an Acc</h2></figcaption>
                        </figure>
                    </div>
                    <div class="grid-child child-2">

                    </div>
                    <div class="grid-child child-3">

                    </div>
                    <div class="grid-child child-4">
                        <figure>
                            <div class="img-container-sign-up">
                                <img src="../images/dashboard_image-removebg-preview.png" alt="">
                            </div>

                            <figcaption class="dashboard-caption"><span>2</span> <h2>Manage Using Dashboard</h2></figcaption>
                        </figure>
                    </div>
                    <div class="grid-child child-5">

                    </div>
                    <div class="grid-child child-6">

                    </div>
                </div>
            </section>
              
            <!-- end of the feature section -->

            <!-- start of the contact section -->
            <section id="contact">

            </section>
            <!-- end of the contact section -->
        </main>

        <!-- this is the end of te main section -->
        <footer id="footer-section">

        </footer>
    </div>
    <script src="index.js"></script>
    <!-- <script src="https://kit.fontawesome.com/adae769a6b.js" crossorigin="anonymous"></script> -->
</body>

</html>