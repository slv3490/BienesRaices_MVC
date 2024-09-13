<?php

$db = conectarDB();

$email = "admin@admin.com";
$password = "administrador";
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

$query = "INSERT INTO usuarios (email, password) VALUES ('${email}', '${passwordHash}')";
mysqli_query($db, $query);