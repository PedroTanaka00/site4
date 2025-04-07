<?php
$AdminLevel = 6;
if (!APP_GALLERY || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

$Read = new Read;

//AUTO DELETE POST TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_GALLERY_CATEGORY, "WHERE category_name IS NULL AND category_id >= :st", "st=1");
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-price-tags">Categorias</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=gallery/home">Galerias</a>
            <span class="crumb">/</span>
            Categorias
        </p>
    </div>

    <div class="dashboard_header_search">
        <a title="Nova Categoria" href="dashboard.php?wc=gallery/category" class="btn btn_green icon-plus">Adicionar Categoria!</a>
    </div>

</header>

<div class="dashboard_content">

    <?php
    $Read->ExeRead(DB_GALLERY_CATEGORY, "ORDER BY category_name ASC");
    if (!$Read->getResult()):
        echo Erro("<span class='al_center icon-notification'>Ainda não existem categorias cadastradas {$Admin['user_name']}. Comece agora mesmo criando sua primera categoria!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Cat):
            echo "<article class='single_category box box100' id='{$Cat['category_id']}'>
                    <header>
                        <h1 class='icon-price-tags'>{$Cat['category_name']}:</h1>
                        <br>
                        <div class='single_category_actions'>
                            <a title='Editar Categoria!' href='dashboard.php?wc=gallery/category&id={$Cat['category_id']}' class='btn btn_blue icon-pencil icon-notext'></a>
                            <span rel='single_category' class='j_delete_action btn btn_red icon-cancel-circle icon-notext' id='{$Cat['category_id']}'></span>
                            <span rel='single_category' callback='Gallery' callback_action='category_delete' class='j_delete_action_confirm btn btn_yellow icon-warning' style='display: none;' id='{$Cat['category_id']}'>Deletar Categoria?</span>
                        </div>
                    </header>";
            echo "</article>";
        endforeach;
    endif;
    ?>
</div>