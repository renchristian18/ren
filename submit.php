<?php

include 'php/config.php';
if($conn->connect_error){
    die ('Connection Failed'. $conn->connect_error);
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];
    session_start();
    mysqli_query($conn,"INSERT INTO tbl_message (message_id,name,email,contact,message)VALUES('1101','$name','$email','$phone','$message')") or die("Error Occured");
    sendToGmail($name, $email, $phone, $message);
    echo json_encode(array("success" => 1));
    

}
function sendToGmail($name,$email, $phone,$message)
{
    $companyEmail = "renchristian18@gmail.com";

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'loyalsun.rc@gmail.com';
        $mail->Password = 'lnjxdtfqzsqerzac';
        $mail->SMTPSecure = "ssl"; //PHPMailer::ENCRYPTION_STARTTLS;//"ssl";
        $mail->Port = 465; //587;//465
        $mail->setFrom($companyEmail);
        $mail->addAddress($companyEmail);
        $mail->setFrom($companyEmail, 'Virtual Lift[WEBSITE]');
        $mail->isHTML(true);
        $mail->Subject = "Customer's Message";
        $content = "
    
    <body style='background-color:#F9F9F9;'>
        <div class='container' style='margin:0px auto;max-width:640px;'>
            <div class='box form-box' style='margin:30px auto;'>
                <form action='' method='post' style='padding:20px; font-size: 15px;margin:0px auto;background:white;border-radius: 20px;'>
                    <div class='field'>
                        <h2 style='color: #229FDA;'>Customer's Information</h2>
                        <p style='font-family: 'Poppins', sans-serif;'>Name: $name</p>
                        <p style='font-family: 'Poppins', sans-serif;'>Email: $email</p>
                        <p style='font-family: 'Poppins', sans-serif;'>Contact #: $phone</p>
                        <p style='font-family: 'Poppins', sans-serif;'>Message: $message</p>
                        
                        
                    </div>
                </form>
            </div>
        </div>
    </body>
    
    ";
        $mail->MsgHTML($content);
        $mail->send();
    } catch (Exception $err) {
        $err_message = $err->getMessage();
        echo "
        <script>
            alert('Error ');
        </script>
        ";

        echo "
    <div style='display:flex;margin-left:10px;margin-right:10px;border:1px solid red;padding:5px;border-radius:10px;width:90%px;font-size:16px;'>
        <img src='images/message_icons/remove.png' style='width: 25px;margin-right:5px;'>
        <p style='font-size:16px;'><b>Error!</b> $err_message</p>
    </div>
    <script>
    console.log($err_message);
    </scrip>
    ";
    }

}
?>