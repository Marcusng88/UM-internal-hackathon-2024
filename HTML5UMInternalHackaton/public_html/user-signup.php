<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <title>Sign Up for Kimseng</title>
        <link rel="icon" href="assets/Images/ChapterHut Logo.png">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- assets/CSS -->
        <link href = "assets/CSS/custom.css" rel="stylesheet">
        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="assets/JS/aos.js"></script>
        <script src="https://accounts.google.com/gsi/client" async></script>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- Poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
        <!-- Pinyon Script -->
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Pinyon+Script&display=swap" rel="stylesheet">
    </head>

    <body>
        <!-- Animation init -->
        <script>AOS.init();</script>

        <?php
            include('dbconnect.php');

            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


            $cmd = "SELECT email FROM users WHERE email = '".$email."'";
            $result = mysqli_fetch_array(mysqli_query($connect,$cmd));

            if($result){
                die('
                    <div class="modal fade" id="warning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="warning" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content poppins-semibold">
                                <div class="modal-header border-0">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">That won\'t do.</h1>
                                </div>
                                <div class="modal-body fs-4">
                                    This email was already registered with us. Let\'s sign you in instead.
                                </div>
                                <div class="modal-footer poppins-semibold border-0">
                                    <a href="login.html" class="back-btn d-flex align-items-center gap-2">
                                        <span class="material-symbols-outlined fs-3">task_alt</span>
                                        <span class="fs-5">Okay</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        window.onload = function() {
                            var myModal = new bootstrap.Modal(document.getElementById("warning"));
                            myModal.show();
                        };
                    </script>
                ');
            }

            $cmd = "INSERT INTO users(`email`, `username`, `password`) VALUES ('".$email."','".$username."','".$hashedPassword."')";
            $exec = mysqli_query($connect, $cmd);

            if($exec){
                echo '
                    <div class="modal fade" id="warning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="warning" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content poppins-semibold">
                                <div class="modal-header border-0">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">All done!</h1>
                                </div>
                                <div class="modal-body fs-4">
                                    Your account is ready. Now let\'s sign you in.
                                </div>
                                <div class="modal-footer poppins-semibold border-0">
                                    <a href="login.html" class="back-btn d-flex align-items-center ms-3">
                                        <i class="bi bi-check2 fs-3"></i>
                                        <span class="ms-3 fs-5">Okay</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        window.onload = function() {
                            var myModal = new bootstrap.Modal(document.getElementById("warning"));
                            myModal.show();
                        };
                    </script>
                ';
            }
        ?>