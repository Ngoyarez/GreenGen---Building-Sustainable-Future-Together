<?php
// Start Session
session_start();

// Include the PHPMailer autoload file
require 'vendor/autoload.php';
// require 'includes/PDOConn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include your database connection file
// require './includes/config.php';
$dsn = 'mysql:host=localhost;dbname=clim_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // SMTP server
    $mail->SMTPAuth   = true;                 // Enable SMTP authentication
    $mail->Username   = 'brianngoya3667@gmail.com';  // SMTP username
    $mail->Password   = 'jgdt yrax rhgi ruqr';       // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;
    // $mail->SMTPSecure = 'tls';
    // $mail->SMTPDebug  = SMTP::DEBUG_OFF;                  // TCP port to connect to

    // Validate and sanitize user input
    $recipientEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$recipientEmail) {
        throw new Exception('Invalid email address');
    }

    // Check if the email exists in the database
    $stmt = $pdo->prepare("SELECT username, email FROM users WHERE email = ?");
    $stmt->execute([$recipientEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Add recipient
        $mail->setFrom('greengen@gmail.com', 'GreenGen');
        $mail->addAddress($user['email'], $user['username']);

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Password Reset Instructions for your GreenGen Account';

        // Password reset email template
        $message = "
            <html>
            <head>
                <title>Password Reset</title>
            </head>
            <body>
                <p>Dear {$user['username']},</p>
                <p>We received a request to reset your password for your GreenGen account. To reset your password, please follow the instructions below:</p>
                <p>Click on the following link to reset your password<br>
                <a href='[Reset Password Link]'>Reset Password</a>
                <em>Note: This link is valid for 10 minutes. After this time, you will need to submit another password reset request.</em>
                <p>If you did not request a password reset, please ignore this email. Your password will remain unchanged.</p>
                <p>Thank you for using GreenGen.</p>
                <p>Best regards,<br>GreenGen Team</p>
            </body>
            </html>
        ";

        // Replace [Reset Password Link] with the actual reset password link
        $resetPasswordLink = 'localhost/clim/recover-password.php';
        $message = str_replace('[Reset Password Link]', $resetPasswordLink, $message);

        // Set the email message body
        $mail->Body = $message;

        // Send the email
        $mail->send();

        $_SESSION['login_success_message'] = "Login successful!";
    } else {
        echo 'Sorry! We could not find any user with that email address. Please try again.';
    }
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
}
?>



            <!-- Header Start -->
            <?php include './includes/header.php'; ?>
            <!-- Header End -->

            <!-- Content Wrapper Start -->
            <div class="content-wrapper">

                <!-- Breadcrumb Start -->
                <div class="breadcrumb-wrap bg-f br-1">
                    <div class="container">
                        <div class="breadcrumb-title">
                            <h2>Recover Password</h2>
                            <ul class="breadcrumb-menu list-style">
                                <li><a href="./">Home </a></li>
                                <li>Recover Password</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Breadcrumb End -->

                <!-- Account Section start -->
                <section class="Login-wrap pt-100 pb-75">
                    <div class="container">
                        <div class="row gx-5">
                            <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                                <div class="login-form-wrap">
                                    <div class="login-header">
                                        <h3>Recover Password</h3>
                                    </div>
                                    <form class="login-form" action="recover-password.php" method="POST">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input id="text" name="email" type="email" placeholder="Email Address" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn style1 w-100 d-block">
                                                       Submit
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="mb-0">Don't have an Account? <a class="link style1" href="register.php">Sign Up</a></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </section>
                <!-- Account Section end -->

            </div>
            <!-- Content wrapper end -->

            <!-- Footer Start -->
            <?php include './includes/footer.php'; ?>
             <!-- Footer End -->
        
        </div>
        <!-- Page Wrapper End -->
        
        <!-- Back-to-top button Start -->
         <a href="javascript:void(0)" class="back-to-top bounce"><i class="ri-arrow-up-s-line"></i></a>
        <!-- Back-to-top button End -->

        <!-- Link of JS files -->
        <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/form-validator.min.js"></script>
        <script src="assets/js/contact-form-script.js"></script>
        <script src="assets/js/aos.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/owl-thumb.min.js"></script>
        <script src="assets/js/odometer.js"></script>
        <script src="assets/js/circle-progressbar.min.js"></script>
        <script src="assets/js/fancybox.js"></script>
        <script src="assets/js/jquery.appear.js"></script>
        <script src="assets/js/tweenmax.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>