<?php
session_start();

?>

<head>

    <link rel="stylesheet" href="style.css">
    <script src="../jquery-3.2.0.min.js"></script>

</head>
<body>
  <?php

function redirect_to($newlocation){
header("Location: ". $newlocation);
exit;
}
  //htmlentities
  if(isset($_POST['submitreader'])){
    $_SESSION['username'] = htmlentities($_POST['username']);
    redirect_to("reader.php");
  }
  ?>
    <div id="wrapper ">

        <form id="blogger" action="blog.php">
            <label for="blogger">Login as blogger</label>
            <input type="submit" id="submitblogger" value="Enter">
        </form>

        <form id="reader" action="r" method ="POST">
            <label for="reader">Login as reader</label>
           <input type="text" name ="username" id="username" placeholder="Please enter your username">
            <input type="submit" name="submitreader" id="submitreader" value="Enter">

        </form>

    </div>
</body>
