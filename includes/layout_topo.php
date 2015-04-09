<?php
$dados_app = configApp();
if($dados_app["modo_manutencao"]==1){
    session_destroy();
    header("Location: ../manutencao.php" );
}
?>
<!--header start-->
<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Menu de Navegação"></div>
    </div>
    <!--logo start-->
    <?php echo $config_nome_app;?>
    <!--logo end-->

    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- inbox dropdown end -->
            <!-- inbox dropdown start-->


        </ul>
    </div>
    </div>
    <div class="top-nav ">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li>
                <center><?php echo date("d/m/Y");?></center> <div id="datahora2" style="margin-top:10px;"></div>
            </li>
            <li>
                <a data-placement="bottom" data-original-title="Imprimir a Página Atual" data-toggle="tooltip" class="tooltips" href="javascript:window.print();"><i class="fa fa-print"></i></a>
            </li>

            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img class="img_perfil" alt="" src="../<?php echo $_SESSION['usuario_foto_perfil'];?>">
                    <span class="username"><?php echo $_SESSION['usuario_nome']?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li><a href="perfil.php"><i class=" fa fa-suitcase"></i>Perfil</a></li>
                    <li><a href="config.php"><i class="fa fa-cog"></i> Configurações</a></li>
                    <li><a href="index.php?logOut=1"><i class="fa fa-key"></i> Sair</a></li>
                </ul>
            </li>
            <li class="sb-toggle-right">
                <i class="fa  fa-align-right"></i>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
    </div>
</header>
<!--header end--