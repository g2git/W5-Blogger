<?php
session_start();

include_once('database.php');

  //Sign up blogger
  if (isset($_POST['subB'])){
    $name =htmlentities($_POST['bname']);

    //check if name already exists
    $query = "SELECT * FROM blogger WHERE author = '$name';";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);


    if($result->num_rows < 1){

      //Verify that passwords match
      $pass = htmlentities($_POST['bpass']);
      $vpass = htmlentities($_POST['vbpass']);

      if($pass == $vpass){
        $hash_pass = password_hash($pass, PASSWORD_BCRYPT);

        $query1 = "INSERT INTO blogger (author, password) VALUES ('$name', '$hash_pass');";
        $result1 = mysqli_query($connection, $query1);
        $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

      }else{
        echo "<p style=\"color:red\">Passwords do not match</p>";
      }
    }else{
      echo "<p style=\"color:red\">This bloggername is already in use, please choose a different one</p>";}
  }

  //sign up user
  if (isset($_POST['subU'])){
    $username =htmlentities($_POST['uname']);

    //check if name already exists
    $query = "SELECT * FROM users WHERE username = '$username';";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);



    if($result->num_rows < 1){

      //Verify that passwords match
      $pass = htmlentities($_POST['upass']);
      $vpass = htmlentities($_POST['vupass']);

      if($pass == $vpass){
        $hash_pass = password_hash($pass, PASSWORD_BCRYPT);

        $query1 = "INSERT INTO users (username, password) VALUES ('$username', '$hash_pass');";
        $result1 = mysqli_query($connection, $query1);
        $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

      }else{
        echo "<p style=\"color:red\">Passwords do not match</p>";
      }
    }else{
      echo "<p style=\"color:red\">This username is already in use, please choose a different one</p>";}
  }

 ?>


 <html>

 <head>

     <link rel="stylesheet" href="style.css">
     <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
     <script src="http://malsup.github.com/jquery.form.js"></script>
     <!-- <script src="signup.js"></script> -->

 </head>

 <nav>
   <a href="index.php">Home</a>
   <a href="login.php">Log in</a>
   <a href="signup.php">Sign up</a>
   <a href="#" id="goBack">Go Back</a>
 </nav>

 <body>

   <div>
   <div id = "signupb">
     <form method = "POST">
       <table>
         <tr><td></td><td><label>Sign up as blogger</label></td></tr>
         <tr><td>Choose a bloggername</td><td><input type= "text" name="bname" id ="bname" required></td></tr>
         <tr><td>Choose a password</td><td><input type= "password" name="bpass" id ="bpass" required></td></tr>
         <tr><td>Verify password</td><td><input type= "password" name="vbpass" id ="vbpass" required></td></tr>
         <tr><td></td><td><input type="submit" name="subB" id ="subB" value="Sign up"></td></tr>
       </table>
     </form>
   </div>

   <div id = "signupu">
     <form method = "POST">
       <table>
         <tr><td></td><td><label>Sign up as reader</label></td></tr>
         <tr><td>Choose a username</td><td><input type= "text" name="uname" id ="uname" required></td></tr>
         <tr><td>Choose a password</td><td><input type= "password" name="upass" id ="upass" required></td></tr>
         <tr><td>Verify password</td><td><input type= "password" name="vupass" id ="vupass" required></td></tr>
         <tr><td></td><td><input type="submit" name="subU" id ="subU" value="Sign up"></td></tr>
       </table>
   </form>
   </div>

 </div>


 </body>


 </html>
