<?php
include_once('database.php');

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';



if(isset($_POST['rec_email']) && isset($_POST['memberType']))
{
  $email = htmlentities($_POST['rec_email']);
  $mtype = $_POST['memberType'];

  if($mtype=="reader"){
    $query = "SELECT email, password, username FROM users where email ='$email';";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

}else{
    $query = "SELECT email, password, author FROM blogger WHERE email ='$email';";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

  if($result->num_rows == 1)
  {
    foreach ($row as $k ){
    $email1 = md5($k['email']);
    $pass = md5($k['password']);
    $user = ($mtype == "reader") ? $k['username'] : $k['author'];
    $mtype1 = md5($mtype);
  }
    //$link="<a href='www.code2live.nl/reset.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
    $link="<a href='localhost:8000/reset_pass.php?key=".$email1."&reset=".$pass."&member=".$mtype1."'>click on this link</a>";
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.transip.email';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = TRUE;                               // Enable SMTP authentication
        $mail->Username = 'admin@code2live.nl';                 // SMTP username
        $mail->Password = 'Code2live';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('admin@code2live.nl', 'Admin');
        $mail->addAddress($email, $user);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Reset your password';
        $mail->Body    = "<html><body><p> Dear $user,</p>
        <p>You have requested to reset your password via our website. Please $link to create a new password.</p>
        <p>Thank you for visiting our website.</p>
        <p>Sincerely,</p>
        <p>The Code2live support team.</p></body></html>";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo "<p>Message has been sent</p>";
    } catch (Exception $e) {
        echo "<p>Message could not be sent. Mailer Error: ".$mail->ErrorInfo."</p>";
    }
  }else{
    echo "<p>We are sorry but the e-mail you entered is not in our system</p>";
  }
}

?>
