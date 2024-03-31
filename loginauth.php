<?php
    session_start();
    include 'koneksi.php';

    if (isset($_POST['login'])){
        $username = htmlentities(strip_tags($_POST['username']));
        $password = htmlentities(strip_tags($_POST['password']));
        
        //query ke database untuk mengecek apakah username dan password yang diinputkan sama atau tidak
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) !== 0){
            $query = "SELECT * FROM users WHERE password = '$password'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) !== 0){
                $row = mysqli_fetch_assoc($result);
                $_SESSION['users'] = $row['id_user'];
                $_SESSION['nama_user'] = $row['nama_user'];
                header('location: index.php');
            } else {
                echo "<script>alert('Password salah!')
                document.location = 'loginauth.php';
                </script>";
            }
        } else {
            echo "<script>alert('User tidak tersedia!')
            document.location = 'loginauth.php';
            </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" href="foto/logos.png" type="images/x-icon">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested row within card body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img width="100%" height="100%" src="img/smk3.jpg" alt="#">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1>
                                    </div>
                                    <form action="" class="user" method="POST">
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" required name="username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Username...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" autocomplete="off" required name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Enter Password...">
                                        </div>
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script>
        $('input').attr('autocomplete', 'off');
    </script>
</body>