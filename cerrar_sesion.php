<?php

session_start();

$_SESSION = [];
session_destroy();

header('Location: /programacion-internet/elrinconcito/');