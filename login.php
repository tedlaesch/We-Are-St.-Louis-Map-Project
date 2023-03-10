<!DOCTYPE html>
<?php 
session_start(); 
$invalid = false;
if (isset($_SESSION['user'])) {
    header("Location:admin.php");
}
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $mysqli = new mysqli('localhost', 'root', '', 'map');

    if ($mysqli->connect_errno) {
        // May be good to have a proper error display here
        exit();
    } 

    $stmt = $mysqli->prepare('SELECT account_hash FROM accounts WHERE account_name = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    $stmt->close();
    $mysqli->close();

    if ($hashed_password == "") {
        $invalid = true;
    } else {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user'] = $username;
            header("Location:admin.php");
        } else {
            $invalid = true;
        }
    }

    //if (password_verify($password, $hashed_password)) {

    //}
}
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Log In</title>

    <!-- Tab Icon -->
    <link rel="icon" type="image/x-icon" href="assets/tabicon.png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 d-flex justify-content-center pt-5">
                    <h1 class="text-center">Administrator Login</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6">
                    <form action="" method="post" id="sign-in">
                        <!-- Username input -->
                        <div class="form-group mb-4 mt-5">
                        <input type="username" id="username" name="username" class="form-control" />
                        <label class="form-label mt-1" for="username">Username</label>
                        </div>
                    
                        <!-- Password input -->
                        <div class="form-group mb-4">
                        <input type="password" id="password" name="password" class="form-control" />
                        <label class="form-label mt-1" for="password">Password</label>
                        </div>

                        <?php
                        if ($invalid == true) {
                        ?>  
                        <div class="text-danger text-center mb-2">Username or password is incorrect</div>
                        <?php
                        }
                        ?>
                    
                        <!-- Submit button -->
                        <div class="row col mx-auto">
                            <button id="submit_button" type="submit" class="btn btn-primary btn-block mt-4">Sign in</button>
                            <button id="back_button" type="button" onclick="buttonBack()" class="btn btn-primary btn-block btn-danger mt-4 mb-4">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function buttonBack() {
                window.location.href = "map.php";
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
