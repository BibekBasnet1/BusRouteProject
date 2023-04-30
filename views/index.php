<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Bus Route</title>
</head>
<body>
    <div id="container">
        <?php
            include_once "nav_bar.php";
        ?>
        <!-- this is the main section -->
        <main class="main-content">
            <?php include_once "hero_section.php"?>

            <!-- start of the about section -->
             <?php
                include_once "about_section.php";
             ?>
            <!-- end of the about section -->

            <!-- start of the feature section -->
            <?php
                include_once "feature_des.php";
            ?>

            <!-- end of the feature section -->
            <?php
                include_once "login.php";
            ?>

            <?php
                include_once "sign_in.php";
            ?>
        </main>

        <!-- this is the end of te main section -->
        <!--        this is footer section-->
        <?php
            include_once "footer.php";
        ?>
        <!--        end of the footer section -->
    <script src="../resources/style.js"></script>
    <!-- <script src="https://kit.fontawesome.com/adae769a6b.js" crossorigin="anonymous"></script> -->
</body>

</html>