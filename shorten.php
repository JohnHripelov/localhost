<?php
  session_start();
  require_once "classes/shortener.php";

  $s = new Shortener();

  if(isset($_POST['url'])) {
   $url = $_POST['url'];

   if($code = $s->makeCode($url)) {
    $_SESSION['feedback'] = "Shortened URL: <a href='http://localhost/test/$code'>http://localhost/test/$code</a>";
   } else {
    $_SESSION['feedback'] = "An error has occured. Please check your URL";
   }
  }
  header('Location: index.php');
?>