<?php

$AdminLevel = 6;
if (!APP_GALLERY || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

$Read = new Read;
$Create = new Create;

$CategoryId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($CategoryId):
    $Read->ExeRead(DB_GALLERY_CATEGORY, "WHERE category_id = :id", "id={$CategoryId}");
    if ($Read->getResult()):
        $FormData = array_map("htmlspecialchars", $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar uma galeria que não existe ou que foi removida recentemente!";
        header('Location: dashboard.php?wc=gallery/categories');
    endif;
else:
    $CategoryCreate = ['category_date' => date('Y-m-d H:i:s')];
    $Create->ExeCreate(DB_GALLERY_CATEGORY, $CategoryCreate);
    header('Location: dashboard.php?wc=gallery/category&id=' . $Create->getResult());
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-new-tab">Cadastrar Categoria</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=gallery/home">Galeria</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=gallery/categories">Categorias</a>
            <span class="crumb">/</span>
            Nova Categoria
        </p>
    </div>
</header>


<div class="dashboard_content">
    <form class="auto_save" name="category_create" action="" method="post">
        <input type="hidden" name="callback" value="Gallery"/>
        <input type="hidden" name="callback_action" value="category_create"/>
        <input type="hidden" name="category_id" value="<?= $CategoryId; ?>"/>

        <article class="box box70">
            <div class="box_content">
                <label class="label">
                    <span class="legend">Título:</span>
                    <input style="font-size: 1.5em;" type="text" name="category_name" value="<?= $category_name; ?>" required/>
                </label>
            </div>
        </article>

        
        <article class="box box30">
            

            <header>
                <h1>Publicar:</h1>
            </header>
            <div class="box_content">
                <label class="label">
                    <span class="legend">DIA:</span>
                    <input type="text" class="formTime" name="category_date" value="<?= $category_date ? date('d/m/Y H:i', strtotime($category_date)) : date('d/m/Y H:i'); ?>" required/>
                </label>
                

                <div class="m_top">&nbsp;</div>
                <div class="wc_actions" style="text-align: center">
                    <button name="public" value="1" class="btn btn_green icon-share">ATUALIZAR</button>
                    <img class="form_load none" style="margin-left: 10px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                </div>
                <div class="clear"></div>
            </div>
        </article>
    </form>
</div>