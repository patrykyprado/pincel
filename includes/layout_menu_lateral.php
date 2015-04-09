<?php
if(empty($_SESSION['menu'])){
    $_SESSION['menu'] = '
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">
    ';
    $sql_menu = gerarMenuUsuario($_SESSION['usuario_acessos'], $_SESSION['usuario_id']);
    while($dados_menu = $sql_menu->fetch(PDO::FETCH_ASSOC)){
        $menu_id =$dados_menu["id_menu"];
        $menu_nome =$dados_menu["menu"];
        $menu_submenu =$dados_menu["submenu"];
        $menu_link =$dados_menu["link"];
        if($menu_submenu == 0){
            $_SESSION['menu'] .= '<li><a class="active" href="'.$menu_link.'"><i class="fa fa-home"></i><span>'.$menu_nome.'</span></a></li>';
        } else {
            $_SESSION['menu'] .= '<li class="sub-menu"><a href="javascript:;" ><i class="fa fa-laptop"></i><span>' . $menu_nome . '</span></a><ul class="sub">';
        }
        $sql_submenu = gerarSubMenu1Usuario($_SESSION['usuario_acessos'], $_SESSION['usuario_id'],$menu_id);
        $contar_submenu = $sql_submenu->rowCount();
        while($dados_submenu = $sql_submenu->fetch(PDO::FETCH_ASSOC)){
            $submenu_nome = $dados_submenu["nome_submenu"];
            $submenu_link = $dados_submenu["link"];
            $submenu_id = $dados_submenu["id_sub"];
            $submenu_submenu = $dados_submenu["submenu"];
            $submenu_id_submenu = $dados_submenu["id_submenu"];
            if($submenu_submenu == 0){
                $_SESSION['menu'].= '<li><a  href="'.$submenu_link.'" target="_self">'.$submenu_nome.'</a></li>';
            } else {
                $_SESSION['menu'].= '<li class="sub-menu"><a  href="'.$submenu_link.'" target="_self">'.$submenu_nome.'</a><ul class="sub">';
                $sql_submenu2 = gerarSubMenu2Usuario($_SESSION['usuario_acessos'], $_SESSION['usuario_id'], $menu_id, $submenu_id);
                $contar_submenu2 = $sql_submenu2->rowCount();
                while($dados_submenu2 = $sql_submenu2->fetch(PDO::FETCH_ASSOC)){
                    $submenu2_nome = $dados_submenu2["nome_submenu"];
                    $submenu2_link = $dados_submenu2["link"];
                    $_SESSION['menu'] .= '<li><a  href="'.$submenu2_link.'" target="_self">'.$submenu2_nome.'</a></li>';
                    $contar_submenu2 -=1;
                    if($contar_submenu2 == 0){
                        $_SESSION['menu'] .= '</li></ul>';
                    }
                }
            }
            $contar_submenu -= 1;
            if($contar_submenu == 0){
                $_SESSION['menu'] .= '</ul></li>';
            }
        }
    }
    $_SESSION['menu'] .= '</ul></div></aside>';
}

print_r($_SESSION['menu']);
?>