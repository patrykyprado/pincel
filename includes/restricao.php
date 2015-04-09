<?php
//inicia a sessão
if(!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['id_usuario'])){
    if($_SESSION['id_usuario'] <= 9999) {
        if (!isset($_SESSION['usuario_usuario']) || $_SESSION['id_usuario'] != $_SESSION['usuario_id']) {
            echo "Gerado do banco";
            gerarSessaoUsuarioAdministrativo($_SESSION['id_usuario']);
        }
    } else {
        if (!isset($_SESSION['usuario_usuario']) || $_SESSION['id_usuario'] != $_SESSION['usuario_id']) {
            gerarSessaoUsuarioAcademico($_SESSION['id_usuario']);
        }
    }
} else {
    session_destroy();
    header('location: ../index.php');
}


?>