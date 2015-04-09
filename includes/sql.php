<?php

/**
 * FUNÇÃO RESPONSÁVEL BUSCAR DADOS DE CONFIGURAÇÃO DO APP
 * @author Patryky Prado
 */
function configApp(){
    global $conn_pincel;
    $sql = 'SELECT *
    FROM config_app';
    $sql_executar = $conn_pincel->prepare($sql);
    $sql_executar->execute();
    return $sql_executar->fetch(PDO::FETCH_ASSOC);


}

/**
 * FUNÇÃO RESPONSÁVEL POR GRAVAR LOG NO SISTEMA
 * @author Patryky Prado
 */
function gerarLogPincel($usuario, $codAcao, $registro){
    global $conn_pincel;
    $ipUsuario = $_SERVER['REMOTE_ADDR'];
    $sql_log = 'INSERT INTO logs
(id_log, usuario, data_hora, cod_acao, acao, ip_usuario)
VALUES
(NULL, :usuario, NOW(), :codAcao, :registro, :ipUsuario)';
    $sql_gravar_log = $conn_pincel->prepare($sql_log);
    $sql_gravar_log->execute(
        array(
            ':usuario' => $usuario,
            ':codAcao' => $codAcao,
            ':registro' => $registro,
            ':ipUsuario' => $ipUsuario
        )
    );
}

/**
 * FUNÇÃO RESPONSÁVEL POR VERIFICAR LOGIN NA TABELA USERS
 * @author Patryky Prado
 */
function acessarUsuarioAdministrativo($usuario, $senha){
    global $conn_pincel;
    $sql = 'SELECT id_user
    FROM users WHERE
    usuario = :usuario AND senha = :senha';
    $sql_executar = $conn_pincel->prepare($sql);
    $sql_executar->execute(
        array(
            ':usuario' => $usuario,
            ':senha' => $senha
        )
    );
    if($sql_executar->rowCount()== 0) {
        return false;
    } else {
        return $sql_executar;
    }
}

/**
 * FUNÇÃO RESPONSÁVEL POR VERIFICAR LOGIN NA TABELA ACESSOS_COMPLETOS
 * @author Patryky Prado
 */
function acessarUsuarioAcademico($usuario, $senha){
    global $conn_pincel;
    $sql = 'SELECT id_user
    FROM acessos_completos WHERE
    usuario = :usuario AND senha = :senha';
    $sql_executar = $conn_pincel->prepare($sql);
    $sql_executar->execute(
        array(
            ':usuario' => $usuario,
            ':senha' => $senha
        )
    );
    if($sql_executar->rowCount()== 0) {
        return false;
    } else {
        return $sql_executar;
    }
}

/**
 * FUNÇÃO RESPONSÁVEL POR GERAR SESSÃO DOS USUÁRIOS ADMINISTRATIVOS LOGADOS
 * @author Patryky Prado
 */
function gerarSessaoUsuarioAdministrativo($idUsuario){
    global $conn_pincel;
    $sql = 'SELECT *
    FROM users WHERE
    id_user = :idUsuario';
    $sql_executar = $conn_pincel->prepare($sql);
    $sql_executar->execute(
        array(
            ':idUsuario' => $idUsuario
        )
    );
    $dados_usuario = $sql_executar->fetch(PDO::FETCH_ASSOC);
    $_SESSION['usuario_usuario'] = $dados_usuario['usuario'];
    $_SESSION['usuario_nome'] = $dados_usuario['nome'];
    $_SESSION['usuario_foto_perfil'] = $dados_usuario['foto_perfil'];
    $_SESSION['usuario_acessos'] = $dados_usuario['acessos'];
    $_SESSION['usuario_nivel'] = $dados_usuario['nivel'];
    $_SESSION['usuario_status'] = $dados_usuario['status'];
    $_SESSION['usuario_empresa'] = $dados_usuario['empresa'];
    $_SESSION['usuario_unidade'] = $dados_usuario['unidade'];
    $_SESSION['usuario_email'] = $dados_usuario['email'];
    $_SESSION['usuario_id'] = $dados_usuario['id_user'];
    $_SESSION['menu'] = '';
}

/**
 * FUNÇÃO RESPONSÁVEL POR GERAR SESSÃO DOS USUÁRIOS ACADÊMICOS LOGADOS
 * @author Patryky Prado
 */
function gerarSessaoUsuarioAcademico($idUsuario){
    global $conn_pincel;
    $sql = 'SELECT *
    FROM acessos_completos WHERE
    id_user = :idUsuario';
    $sql_executar = $conn_pincel->prepare($sql);
    $sql_executar->execute(
        array(
            ':idUsuario' => $idUsuario
        )
    );
    $dados_usuario = $sql_executar->fetch(PDO::FETCH_ASSOC);
    $_SESSION['usuario_usuario'] = $dados_usuario['usuario'];
    $_SESSION['usuario_nome'] = $dados_usuario['nome'];
    $_SESSION['usuario_foto_perfil'] = $dados_usuario['foto_perfil'];
    $_SESSION['usuario_acessos'] = $dados_usuario['acessos'];
    $_SESSION['usuario_nivel'] = $dados_usuario['nivel'];
    $_SESSION['usuario_empresa'] = $dados_usuario['empresa'];
    $_SESSION['usuario_unidade'] = $dados_usuario['unidade'];
    $_SESSION['usuario_email'] = $dados_usuario['email'];
    $_SESSION['usuario_id'] = $dados_usuario['id_user'];
    $_SESSION['menu'] = '';
}



/**
 * FUNÇÃO RESPONSÁVEL POR GERAR MENU DO USUÁRIO ATIVO
 * @author Patryky Prado
 */
function gerarMenuUsuario($usuarioAcessos, $idUsuario){
    global $conn_pincel;
    $sql = 'SELECT * FROM ced_menu WHERE (acessos LIKE :usuarioAcessos OR id_pessoas LIKE :idUsuario) ORDER BY ordem';
    $sql_executar = $conn_pincel->prepare($sql);
    $sql_executar->execute(
        array(
            ':idUsuario' => $idUsuario,
            ':usuarioAcessos' => $usuarioAcessos
        )
    );
    return $sql_executar;
}

/**
 * FUNÇÃO RESPONSÁVEL POR GERAR SUBMENU 1 DO USUÁRIO ATIVO
 * @author Patryky Prado
 */
function gerarSubMenu1Usuario($usuarioAcessos, $idUsuario, $menuId){
    global $conn_pincel;
    $sql = 'SELECT * FROM ced_submenu
  WHERE id_menu = :menuId AND id_submenu = 0
  AND (acessos LIKE "%:usuarioAcessos%" OR id_pessoas LIKE "%:idUsuario%") ORDER BY ordem';
    $sql_executar = $conn_pincel->prepare($sql);
    $sql_executar->execute(
        array(
            ':idUsuario' => $idUsuario,
            ':usuarioAcessos' => $usuarioAcessos,
            ':menuId' => $menuId
        )
    );
    return $sql_executar;
}

/**
 * FUNÇÃO RESPONSÁVEL POR GERAR SUBMENU 2 DO USUÁRIO ATIVO
 * @author Patryky Prado
 */
function gerarSubMenu2Usuario($usuarioAcessos, $idUsuario, $menuId, $submenuId)
{
    global $conn_pincel;
    $sql = 'SELECT *
FROM ced_submenu
WHERE id_menu = :menuId AND id_submenu = :submenuId
AND (acessos LIKE ":usuarioAcessos%" OR id_pessoas LIKE "%:idUsuario%")
ORDER BY ordem';
    $sql_executar = $conn_pincel->prepare($sql);
    $sql_executar->execute(
        array(
            ':idUsuario' => $idUsuario,
            ':usuarioAcessos' => $usuarioAcessos,
            ':submenuId' => $submenuId,
            ':menuId' => $menuId
        )
    );
    return $sql_executar;
}