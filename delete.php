<?php
    $id = $_GET["id"];
    $connection = mysqli_connect("localhost","root","","map") or die("Error " . mysqli_error($connection));
    $sql = "DELETE FROM posts WHERE id = $id";
    mysqli_query($connection, $sql);
?>
