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
        <!-- Animation init try -->
        <script>AOS.init();</script>

        <?php
            session_start();
            include('dbconnect.php');

            $email = $_POST['email'];
            $password = $_POST['password'];

            $cmd = "SELECT * FROM users WHERE email = ?";
            $stmt = $connect->prepare($cmd);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if($user){
                if(password_verify($password,$user['password'])){
                    $_SESSION['user'] = $user['username'];
                    $_SESSION['email'] = $user['email'];

                    $stmt->close();

                    $cmd = "INSERT INTO `session`(email) VALUES(?)";
                    $stmt = $connect -> prepare($cmd);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();

                    $sessionId = $connect -> insert_id;
                    $_SESSION['session'] = $sessionId;

                    $stmt->close();

                    header('Location: order.php');
                }else{
                    die('
                        <div class="modal fade" id="warning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="warning" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content poppins-semibold">
                                    <div class="modal-header border-0">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">There\'s something wrong</h1>
                                    </div>
                                    <div class="modal-body fs-4">
                                        The password you entered doesn\'t match our records. Please try again. 
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
            }else{
                die('
                    <div class="modal fade" id="warning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="warning" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content poppins-semibold">
                                <div class="modal-header border-0">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">There\'s something wrong</h1>
                                </div>
                                <div class="modal-body fs-4">
                                    Looks like you have not signed up yet. Let\'s sign you up. 
                                </div>
                                <div class="modal-footer poppins-semibold border-0">
                                    <a href="signup.html" class="back-btn d-flex align-items-center gap-2">
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
        ?>