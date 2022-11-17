<?php 
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $mysqli = new mysqli('localhost', 'root', '', 'auth');

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } 

    $stmt = $mysqli->prepare('INSERT INTO accounts (account_name, account_hash) VALUES (?, ?)');
    $stmt->bind_param('ss', $username, $hashed_password);
    $stmt->execute();

    $stmt->close();
    $mysqli->close();
}
?>
<html>
<body>

<form action="" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="text" name="password"><br>
<input type="submit">
</form>

</body>
</html>