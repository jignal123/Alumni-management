<?php
$dsn = "mysql:host=localhost;dbname=alumni_portal";
$user = "root";
$pwd = "";

$con = new PDO($dsn, $user, $pwd);
function query($query, $array = null)
{
    global $con;
    $a = $con->prepare($query);
    $a->execute($array);
    return $a;
}

// function dbQuery($qry){
//     $result = mysqli_query($con,$qry) or die("Error");
//     return $result;
// }

// function dbRows($pdostatement){
//     //return $pdostatement->rowCount();
//     return mysqli_num_rows($pdostatement);
// }

// function dbArray($result){
//     return mysqli_fetch_array($result);
// }
date_default_timezone_set("Asia/Kolkata");
function send_email($email, $msg, $sub)
{
    define('AuthEmail', "Youremail");
    define('Reply_email', AuthEmail);
    define('Reply_Name', "Aumni_Portal");
    require 'PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = AuthEmail;                 // SMTP username
    $mail->Password = '<Your password>';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(AuthEmail, 'Alumni Portal');
    $mail->addAddress($email);         // Add a recipient    
    $mail->addReplyTo(Reply_email, Reply_Name);


    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $sub;
    $mail->Body = $msg;
    $mail->AltBody = 'You Have Registred Succesfully!';

    if (!$mail->send()) {
        return 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        return 'Email has been sent';
    }
}

function studentlogin()
{
    session_start();
    if (
        !isset($_SESSION['alumni'])
    ) {
        header("Location: ../login.php");
    }
}

function adminlogin()
{
    session_start();
    if (
        !isset($_SESSION['admin'])
    ) {
        header("Location: ../login.php");
    }
}

function filter($data)
{
    foreach ($data as $key => $value) {
        $value = trim($value);
        $value = stripcslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $data[$key] = $value;
    }
    return $data;
}
?>
