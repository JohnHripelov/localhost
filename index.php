<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>URL shortener</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
   <h1 class="title">URL shortener</h1>
<?php
  if(isset($_SESSION['feedback'])) {
   echo "<p>".$_SESSION['feedback']."</p>";
   unset($_SESSION['feedback']);
  }
?>
   <form action="shorten.php" method="post">
    <input type="text" name="url" placeholder="Insert URL" autocomplete="off">
    <input type="submit" value="Shorten">
   </form>
  </div>
</body>
</html>