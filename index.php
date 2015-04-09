<?php
require_once('includes/parameters.php');
require_once('includes/sql.php');
//teste

$erro = 0;
$logo_sistema = 'img_sys/logo_pincel.png';
$modo_manutencao = 0;
if($_SERVER['REQUEST_METHOD']=="POST"){
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $dados_app = configApp();
    if($dados_app['modo_manutencao'] == 1){
        $modo_manutencao = 1;
    }
    if($modo_manutencao == 0)
    {
        $acessar = acessarUsuarioAdministrativo($usuario, $senha);
        if($acessar != false){
            $dados_acesso = $acessar->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['id_usuario'] = $dados_acesso['id_user'];
            gerarLogPincel($usuario,1,'Acessou o sistema pelo módulo administrativo.');
            header('location: acesso/index.php');
        } else {
            $acessar_academico = acessarUsuarioAcademico($usuario,$senha);
            if($acessar_academico == false){
                $erro = 1;
                gerarLogPincel($usuario,2,'Acesso negado, usuário ou senha inválidos.');
            }
            if($acessar_academico != false){
                $dados_acesso = $acessar_academico->fetch(PDO::FETCH_ASSOC);
                session_start();
                $_SESSION['id_usuario'] = $dados_acesso['id_user'];
                gerarLogPincel($usuario,1,'Acessou o sistema pelo módulo acadêmico.');
                header('location: acesso_academico/index.php');
            }
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Patryky Prado">
    <meta name="keyword" content="PINCEL ATOMICO SISTEMA ACADÊMICO">
    <link rel="shortcut icon" href="img_sys/favicon.png">

    <title>Pincel At&ocirc;mico - Sistema Acad&ecirc;mico</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="css/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <style type="text/css">
        body,td,th {
            font-family: "Open Sans", sans-serif;
        }
    </style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="lock-screen" onload="startTime()">

<div class="lock-wrapper">




    <div class="lock-box text-center">
        <img style="position:relative; left:0px; top:0px; border:0px;" src="<?php echo $logo_sistema?>" alt="LOGO SISTEMA">
        <h1><div id="time2"></div></h1>
        <?php
        if($erro==1){
            echo "<div class=\"erro\">Usuário ou senha inválida!</div><br>";
        }
        if($erro==2){
            echo "<div class=\"erro\">Usuário bloqueado.</div><br>";
        }
        ?>

        <?php
        if($modo_manutencao==1){
            echo "<div class=\"erro\">Estamos em manutenção temporária, tente novamente em alguns minutos.</div><br>";
        } else {
            echo "
             <form role=\"form\" class=\"form-inline\" action=\"#\" method=\"post\">
            
            	<table>
                <tr>
                	<td align=\"right\"><b><font color=\"black\">Usuário:</font></b></td>
                    <td> <input type=\"text\" required=\"required\" placeholder=\"Usuário / Matrícula\" name=\"usuario\" id=\"exampleInputPassword2\" class=\"form-control lock-input\"></td>
                </tr>
                <tr>
                	<td  align=\"right\"><b><font color=\"black\">Senha:</font></b></td>
                    <td><input type=\"password\" required=\"required\" placeholder=\"Senha\" name=\"senha\" id=\"exampleInputPassword2\" class=\"form-control lock-input\"></td>
                </tr>
				
                <tr>
                <td colspan=\"2\" align=\"center\" style=\"padding-left:40px;\"><br><button class=\"btn btn-lock\" type=\"submit\">
                        Acessar
                    </button></td>
                </tr>
                </table>
               
            </form>
  
 ";
        }
        ?>
        <a style="color:#FFFFFF" href="recuperar_senha.php">Esqueceu a sua senha? Clique aqui e recupere.</a>
    </div>
</div>
<script>
    function startTime()
    {
        var today=new Date();
        var h=today.getHours();
        var m=today.getMinutes();
        var s=today.getSeconds();
        // add a zero in front of numbers<10
        m=checkTime(m);
        s=checkTime(s);
        document.getElementById('time2').innerHTML=h+":"+m+":"+s;
        t=setTimeout(function(){startTime()},500);
    }

    function checkTime(i)
    {
        if (i<10)
        {
            i="0" + i;
        }
        return i;
    }
</script>
</body>
</html>
