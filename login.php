<?php
include_once('database.php');

session_start();
?>

<head>

    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script src="login.js"></script>

</head>

<nav>
  <a href="index.php">Home</a>
  <a href="login.php">Log in</a>
  <a href="signup.html">Sign up</a>
  <a href="#" id="goBack">Go Back</a>
</nav>

<body>
  <?php

function redirect_to($newlocation)
{
    header("Location: ". $newlocation);
    exit;
}

  if (isset($_POST['submitreader'])) {
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['upassword']);

    $query = "SELECT password, id FROM users WHERE username = '$username';";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if(password_verify($password,$row['password'])){
      session_unset();
      $_SESSION['username'] = $username;
      redirect_to("index.php");
    }else{
      echo "<p style=\"color:red\">Incorrect, please try again</p>";
    }
  }

  if (isset($_POST['submitblogger'])) {
    $name = htmlentities($_POST['bloggername']);
    $password = htmlentities($_POST['bpassword']);

    $query = "SELECT authorid, password FROM blogger WHERE author = '$name';";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if(password_verify($password,$row['password'])){
      session_unset();
      $_SESSION['bloggername'] = $name;
      $_SESSION['bloggerid'] = $row['autorid'];
      redirect_to("blog.php");
    }else{
      echo "<p style=\"color:red\">Incorrect, please try again</p>";
    }
  }

  ?>
    <div id="wrapper ">

        <form id="blogger" action="" method ="POST">
            <label for="blogger">Login as blogger</label>
            <input type="text" name ="bloggername" id="bloggername" placeholder="Please enter your username" required>
            <input type="password" name ="bpassword" id="bpassword" placeholder="Please enter your password" required>
            <input type="submit" name="submitblogger" id="submitblogger" value="Enter">
        </form>

        <form id="reader" action="" method ="POST">
            <label for="reader">Login as reader</label>
            <input type="text" name ="username" id="username" placeholder="Please enter your username" required>
            <input type="password" name ="upassword" id="upassword" placeholder="Please enter your password" required>
            <input type="submit" name="submitreader" id="submitreader" value="Enter">

        </form>

    </div>
</body>
