<?php
include './includes/config.php';

    // Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $agree_terms = isset($_POST["agree_terms"]) ? 1 : 0; // Check if terms and conditions checkbox is checked

    // Check if passwords match
    if (!$agree_terms) {
        echo "Error: Please agree to the terms and conditions.";
    } else if ($password != $confirm_password) {
        echo "Error: Passwords do not match.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert user data
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, agree_terms) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $email, $hashed_password, $agree_terms);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
                    $(document).ready(function(){
                        $('#successModal').modal('show');
                    });
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>

<style>
.modal{
    background-color: #636363;
}
.modal-confirm {		
	color: #636363;
	width: 325px;
	font-size: 14px;
}
.modal-confirm .modal-content {
	padding: 20px;
	border-radius: 5px;
	border: none;
}
.modal-confirm .modal-header {
	border-bottom: none;   
	position: relative;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 26px;
	margin: 30px 0 -15px;
}
.modal-confirm .form-control, .modal-confirm .btn {
	min-height: 40px;
	border-radius: 3px; 
}
.modal-confirm .close {
	position: absolute;
	top: -5px;
	right: -5px;
}	
.modal-confirm .modal-footer {
	border: none;
	text-align: center;
	border-radius: 5px;
	font-size: 13px;
}	
.modal-confirm .icon-box {
	color: #fff;		
	position: absolute;
	margin: 0 auto;
	left: 0;
	right: 0;
	top: -70px;
	width: 95px;
	height: 95px;
	border-radius: 50%;
	z-index: 9;
	background: #82ce34;
	padding: 15px;
	text-align: center;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
}
.modal-confirm .icon-box i {
	font-size: 58px;
	position: relative;
	top: 3px;
}
.modal-confirm.modal-dialog {
	margin-top: 80px;
}
.modal-confirm .btn {
	color: #fff;
	border-radius: 4px;
	background: #82ce34;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	border: none;
}
.modal-confirm .btn:hover, .modal-confirm .btn:focus {
	background: #6fb32b;
	outline: none;
}
.trigger-btn {
	display: inline-block;
	margin: 100px auto;
}
</style>

<!-- Header Start -->
            <?php include './includes/header.php'; ?>
            <!-- Header End -->

            <!-- Content Wrapper Start -->
            <div class="content-wrapper">

                <!-- Breadcrumb Start -->
                <div class="breadcrumb-wrap bg-f br-1">
                    <div class="container">
                        <div class="breadcrumb-title">
                            <h2>Register</h2>
                            <ul class="breadcrumb-menu list-style">
                                <li><a href="./">Home </a></li>
                                <li>Register</li>
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
                                        <h3>Register</h3>
                                    </div>
                                    <form class="login-form" id="registrationForm" method="post">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input id="username" name="username" type="text" placeholder="Username" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input id="email" name="email" type="text" placeholder="Email" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="password" id="pwd" name="password" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="password" id="pwd_2" name="confirm_password" placeholder="Confirm Password">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-12 mb-20">
                                                <div class="checkbox style3">
                                                    <input type="checkbox" name="agree_terms" id="test_1">
                                                    <label for="test_1">
                                                        I Agree with the <a class="link style1" href="terms-of-service.php">Terms &amp; conditions</a>
                                                    </label>
                                                </div>
                                            </div>

                                            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                                            <!-- Error message area, initially hidden -->

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button type="button" id="registerBtn" class="btn style1 w-100 d-block">
                                                        Register 
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="mb-0">Have an Account? <a class="link style1" href="login.php">Sign In</a></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- Success Modal -->
                    <!-- <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                            <h5>Registration Successful!</h5>
                            <p>You can now login.</p>
                            <button class="btn btn-primary" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">Close</span>
                            </button>
                            </div>
                        </div>
                        </div>
                    </div> -->

                    <div id="successModal" class="modal fade">
                        <div class="modal-dialog modal-confirm modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="icon-box">
                                    <i class="fas fa-check"></i>
                                    </div>				
                                    <h4 class="modal-title w-100">Awesome!</h4>	
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">Your Registration Was Successful</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success btn-block text-center" data-dismiss="modal">OK</button>
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

        <!-- <script src="jquery.min.js"></script> -->
         <!-- Script to prevent the page from refreshing -->
         <script>
            $(document).ready(function(){
                $(document).on('click', '#registerBtn', function(e){
                    e.preventDefault(); // Prevent default form submission
                    console.log("Register button clicked");
                    
                    $.ajax({
                        type: 'POST',
                        url: 'register.php',
                        data: $('#registrationForm').serialize(),
                        success: function(response) {
                            console.log("Success response:", response);
                            // Check if the response contains an error message
                            if (response.trim().startsWith('Error:')) {
                                // Display error message in the modal with danger class
                                $('#errorMessage').html(response.trim()).addClass('alert-danger');
                                $('#errorMessage').show();
                            } else {
                                // No errors, show success modal
                                $('#successModal').modal('show');
                                // Clear any previous error message
                                $('#errorMessage').html('').removeClass('alert-danger').hide();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("Error:", error);
                            // Display error message in the modal with danger class
                            $('#errorMessage').html(xhr.responseText).addClass('alert-danger');
                            $('#errorMessage').show();
                        },
                        complete: function(xhr, status) {
                            console.log("AJAX request completed");
                        }
                    });
                });
                 // Close button for the modal
                 $('#closeModalBtn').click(function() {
                    $('#successModal').modal('hide');
            });
        });
            </script>

        <!-- <script src="./assets/js/modal.js"></script> -->
        <!-- <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery.min.js"></script> -->
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