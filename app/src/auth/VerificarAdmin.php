<?php

if (!isset($_SESSION['IdUsuario'])) {
    header("Location: home");
    exit();
}


?>