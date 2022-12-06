<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add Admins</title>
        <!-- Tab Icon-->
        <link rel="icon" type="image/x-icon" href="assets/tabicon.png" />
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>

        <?php
            if (!isset($_SESSION['user'])) {
                header("Location:login.php");
            } else {
                $userexists = false;
                $accountcreated = false;
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $connection = mysqli_connect("localhost","root","","map") or die("Error " . mysqli_error($connection));
                    $sql = "select account_name from accounts";
                    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
                    $accounts = array();
                    while($row =mysqli_fetch_assoc($result))
                    {
                        $accounts[] = $row["account_name"];
                    }
                    mysqli_close($connection);



                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    if (!in_array($username, $accounts, false)) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        $mysqli = new mysqli('localhost', 'root', '', 'map');

                        if ($mysqli->connect_error) {
                            die("Connection failed: " . $mysqli->connect_error);
                        } 

                        $stmt = $mysqli->prepare('INSERT INTO accounts (account_name, account_hash) VALUES (?, ?)');
                        $stmt->bind_param('ss', $username, $hashed_password);
                        $stmt->execute();

                        $stmt->close();
                        $mysqli->close();
                        $accountcreated = true;
                    } else {
                        $userexists = true;
                    }
                }
                ?>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-6 d-flex justify-content-center pt-5">
                            <h1 class="text-center">Add Administrator Account</h1>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <form action="" method="post" id="sign-up">
                                <!-- Username input -->
                                <div class="form-group mb-4 mt-5">
                                <input type="username" id="username" name="username" class="form-control" />
                                <label class="form-label mt-1" for="username">Username</label>
                                </div>
                            
                                <!-- Password input -->
                                <div class="form-group mb-1">
                                <input type="password" id="password" name="password" class="form-control" />
                                <label class="form-label mt-1" for="password">Password</label>
                                </div>

                                <!-- Password confirm -->
                                <div class="form-group mb-2">
                                <input type="password" id="password2" name="password2" class="form-control" />
                                <label class="form-label mt-1" for="password2">Confirm password</label>
                                </div>

                                <div class="text-danger text-center mb-2" style = "display: none" id="passwordMessage">Passwords do not match</div>
                                <?php
                                if ($userexists == true) {
                                ?>  
                                <div class="text-danger text-center mb-2">Username already exists</div>
                                <?php
                                }
                                ?>

                                <?php
                                if ($accountcreated == true) {
                                ?>  
                                <div class="text-success text-center mb-2">Account created!</div>
                                <?php
                                }
                                ?>
                            
                                <!-- Submit button -->
                                <div class="row col mx-auto">
                                    <button id="submit_button" type="submit" disabled="true" class="btn btn-primary btn-block mt-4">Register</button>
                                    <button id="back_button" type="button" onclick="buttonBack()" class="btn btn-primary btn-block btn-danger mt-4 mb-4">Back</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>
        <script>
            function buttonBack() {
                window.location.href = "admin.php";
            }

            submitButton = document.getElementById('submit_button');
            passwordBox = document.getElementById('password');
            confirmBox = document.getElementById('password2');
            errorMsg = document.getElementById('passwordMessage');

            confirmBox.addEventListener("keyup", function (e) {
                if (confirmBox.value == passwordBox.value) {
                    submitButton.disabled = false;
                    errorMsg.style = "display: none";
                } else {
                    submitButton.disabled = true;
                    errorMsg.style = "";
                }
            });
        </script>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS-->
        <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>