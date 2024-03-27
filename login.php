<?php
session_start();
include './includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Query database to check if username exists
  $stmt = $conn->prepare("SELECT id, username, password, is_admin FROM users WHERE username = ? OR email = ?");
  $stmt->bind_param("ss", $username, $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    // Password is correct, set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_type'] = 'user';  // Default user type

    // Check if user is admin and set username only for users
    if ($user['is_admin'] != 1) {
      $_SESSION['username'] = $user['username'];
    }

    // Redirect to appropriate page
    if ($user['is_admin'] == 1) {
        // $_SESSION['login_success_message'] = "Admin Login successful!";
      header("Location: ./admin/index.php");
    } else {
        $_SESSION['login_success_message'] = "Login successful!";
      header("Location: ./index.php");
    }
    exit();
  } else {
    // Incorrect username/email or password
    $login_error = "Wrong username/email or password entered.";
  }
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
                            <h2>Login</h2>
                            <ul class="breadcrumb-menu list-style">
                                <li><a href="./">Home </a></li>
                                <li>Login</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Breadcrumb End -->

                <!-- Alert for wrong details -->
                
                <style>
                    .alert {
                    position: relative;
                    margin-top: 20px; /* Adjust this value as needed */
                }

                    .fade-line {
                    height: 2px;
                    background-color: #f00;
                    width: 100%;
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    animation: fade 5s linear forwards;
                }

                @keyframes fade {
                    from {
                        width: 100%;
                    }
                    to {
                        width: 0%;
                    }
                }

                </style>

                <?php if (isset($login_error)): ?>
                    <div class="alert alert-danger mt-3 fade show" role="alert" style="width: 30%; position: fixed; top: -10px; right: 0; z-index: 9999;">
                        <div class="alert-content">
                            <?php echo $login_error; ?>
                            <div class="fade-line"></div>
                        </div>
                    </div>
                    <script>
                        // Fade out the alert after 10 seconds
                        setTimeout(function() {
                            $('.alert').alert('close');
                        }, 5000);
                    </script>
                <?php endif; ?>

                


                <!-- Account Section start -->
                <section class="Login-wrap pt-100 pb-75">
                    <div class="container">
                        <div class="row gx-5">
                            <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                                <div class="login-form-wrap">
                                    <div class="login-header">
                                        <h3>Login</h3>
                                    </div>
                                    <form class="login-form" method="post" action="login.php">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="text" id="text" name="username"  placeholder="Username Or Email Address" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="password" id="pwd" name="password" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                <div class="checkbox style3">
                                                    <input type="checkbox" id="test_1">
                                                    <label for="test_1">
                                                        Remember Me</a>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-end mb-20">
                                                <a href="recover-password.php" class="link style1">Forgot Password?</a>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn style1 w-100 d-block">
                                                        Login Now
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="mb-0">Don't have an Account? <a class="link style1" href="register.php">Create One</a></p>
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