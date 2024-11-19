<?php

// Importar la conexión
require 'includes/config/database.php';
$db = conectarDB();

$email = "correo@correo.com";
$password = "adminadmin";

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO usuarios (email, password) VALUES ('${email}', '${passwordHash}');";

mysqli_query($db, $query);