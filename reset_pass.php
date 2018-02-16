<?php

include_once('database.php');

session_start();



if ($_GET['key'] && $_GET['reset'] && $_GET['member']) {
    $email = $_GET['key'];
    $pass = $_GET['reset'];
    //$mtype = $_GET['member'];
    $mtype = ($_GET['member'] == md5("reader")) ? "reader" : "blogger";
    $table = ($mtype == "reader") ? 'users' : 'blogger';

    //Verify link
    $query = "SELECT email, password FROM $table WHERE md5(email) ='$email' AND md5(password)='$pass';";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);


    if ($result->num_rows == 1) {

        if (isset($_POST['submitPassword']) && $_POST['changePass']) {
            $pass=htmlentities($_POST['changePass']);
            $hash_pass = password_hash($pass, PASSWORD_BCRYPT);

            $sql = "UPDATE $table SET password = '$hash_pass' WHERE md5(email) = '$email';";
            $result = mysqli_query($connection, $sql);
            $row1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

            redirect_to("login.php");
        } ?>

        <html>

        <head>

          <link rel="stylesheet" href="style.css">
          <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
          <script src="http://malsup.github.com/jquery.form.js"></script>
          <script src="reset_pass.js"></script>

        </head>

        <body>

        <div id="Change">
          <form method="post">
              <table>
                <tr><td><label>Enter new password</label></td></tr>
                <tr><td><input type="password" name="changePass" id="changePass"></td></tr>
                <tr><td><input type="submit" name="submitPassword" id="submitPassword" value="Change Password"></td></tr>
              </table>
          </form>
        </div>

        </body>

        </html>


    <?php
    }
}

function redirect_to($newlocation)
{
    header("Location: ". $newlocation);
    exit;
}

?>
