<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
</head>
<body>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</body>
</html>
<?php
// this is toastr notification class

class ToastrNotification {
    public static function displayError($message) {
        echo "<script>toastr.error('$message');</script>";
    }
    
    public static function displaySuccess($message) {
        echo "<script>toastr.success('$message');</script>";
    }
    
    public static function displayInfo($message) {
        echo "<script>toastr.info('$message');</script>";
    }
    
    public static function displayWarning($message) {
        echo "<script>toastr.warning('$message');</script>";
    }
}
?>