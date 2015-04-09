<?php
//global includes
require_once('../includes/parameters.php');
require_once('../includes/funcoes.php');
require_once('../includes/sql.php');
include('../includes/restricao.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php
include('../includes/layout_head.php');
?>

<body>

<section id="container" >
    <?php
    var_dump($_SESSION);
    include ('../includes/layout_topo.php');
    include ('../includes/layout_menu_lateral.php');
    include('../dashboards/'.$_SESSION['usuario_nivel'].'.php');
    include('../includes/footer.php');
    ?>
</section>
<?php
include('../includes/js.php');?>
</body>
</html>
