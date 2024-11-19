<?php

function estaAutenticado() : bool {
    session_start();

    // Verificar si la clave 'login' está definida
    $auth = isset($_SESSION['login']) ? $_SESSION['login'] : false;

    if ($auth) {
        return true;
    }

    return false;
}
?>
