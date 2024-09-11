<?php
session_start();


if (!isset($_SESSION['Username'])) {
    header("Location: http://localhost/joespizzashop/login.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="home5.css">
</head>
<body>
  <section class="s2">
<div class="topnav">
  <a href="menu.php">Menu</a>
  <a href="orderdetail.php">Order</a>
  <a href="Contact.php">Contact Us</a>
  <a href="FAQ.php">FAQ</a>
  <a href="logout.php">Logout</a>
</div>
</section>
<section class="s1">
<div class="body1">

</div>
</section >
<section class="s3">
<footer>
<?php
include "footer.php";
?>
</footer>
</section>
</body>
</html>