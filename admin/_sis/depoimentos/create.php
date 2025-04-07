<?php
$AdminLevel = LEVEL_WC_TESTIMONIALS;
if (!APP_TESTIMONIALS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT CREATE
if (empty($Create)):
    $Create = new Create;
endif;

$TestId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($TestId):
    $Read->ExeRead(DB_TESTIMONIALS, "WHERE test_id = :id", "id={$TestId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um depoimento que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=depoimentos/home');
    endif;
else:
    $TestCreate = ['test_date' => date('Y-m-d H:i:s'), 'test_status' => 0];
    $Create->ExeCreate(DB_TESTIMONIALS, $TestCreate);
    header('Location: dashboard.php?wc=depoimentos/create&id=' . $Create->getResult());
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-new-tab"><?= $test_title ? $test_title : "Novo Depoimento"; ?></h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=depoimentos/home">Depoimentos</a>
            <span class="crumb">/</span>
            Gerenciar Depoimentos
        </p>
    </div>
</header>

<div class="workcontrol_imageupload none" id="post_control">
    <div class="workcontrol_imageupload_content">
        <form name="workcontrol_post_upload" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="callback" value="Testimonials"/>
            <input type="hidden" name="callback_action" value="sendimage"/>
            <input type="hidden" name="post_id" value="<?= $TestId; ?>"/>
            <div class="upload_progress none" style="padding: 5px; background: #00B594; color: #fff; width: 0%; text-align: center; max-width: 100%;">0%</div>
            <div style="overflow: auto; max-height: 300px;">
                <img class="image image_default" alt="Nova Imagem" title="Nova Imagem" src="./tim.php?src=admin/_img/no_image.jpg&w=<?= IMAGE_W; ?>&h=<?= IMAGE_H; ?>" default="./tim.php?src=admin/_img/no_image.jpg&w=<?= IMAGE_W; ?>&h=<?= IMAGE_H; ?>"/>
            </div>
            <div class="workcontrol_imageupload_actions">
                <input class="wc_loadimage" type="file" name="image" required/>
                <span class="workcontrol_imageupload_close icon-cancel-circle btn btn_red" id="post_control" style="margin-right: 8px;">Fechar</span>
                <button class="btn btn_green icon-image">Enviar e Inserir!</button>
                <img class="form_load none" style="margin-left: 10px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<div class="dashboard_content">

    <form class="auto_save" name="test_create" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="Testimonials"/>
        <input type="hidden" name="callback_action" value="manager"/>
        <input type="hidden" name="test_id" value="<?= $TestId; ?>"/>

        <div class="box box70">
            <div class="panel_header default">
                <h2 class="icon-blog">Dados sobre o Depoimento</h2>
            </div>
            <div class="panel">
                <label class="label">
                    <span class="legend">Título:</span>
                    <input style="font-size: 1.4em;" type="text" name="test_title" value="<?= $test_title; ?>" required/>
                </label>
                
                <label class="label">
                    <span class="legend">Autor:</span>
                    <input style="font-size: 1.4em;" type="text" name="test_author" value="<?= $test_author; ?>" required/>
                </label>

                <label class="label">
                    <span class="legend">Capa: (JPG <?= IMAGE_W; ?>x<?= IMAGE_H; ?>px)</span>
                    <input type="file" class="wc_loadimage" name="test_cover"/>
                </label>

                <label class="label">
                    <span class="legend">Depoimento:</span>
                    <textarea class="wc_tinyMCE_basic" rows="5" name="test_content"><?= $test_content; ?></textarea>
                </label>
            </div>
        </div>

        <div class="box box30">

            <div class="post_create_cover">
                <div class="upload_progress none">0%</div>
                <?php
                $TestCover = (!empty($test_cover) && file_exists("./uploads/{$test_cover}") && !is_dir("./uploads/{$test_cover}") ? "{$test_cover}" : 'admin/_img/no_image.jpg');
                ?>
                <img class="post_thumb test_cover" alt="Capa" title="Capa" src="./tim.php?src=<?= $TestCover; ?>&w=<?= IMAGE_W; ?>&h=<?= IMAGE_H; ?>" default="./tim.php?src=<?= $TestCover; ?>&w=<?= IMAGE_W; ?>&h=<?= IMAGE_H; ?>"/>
            </div>

            <div class="panel_header default">
                <h2>Publicar:</h2>
            </div>

            <div class="panel">
                <label class="label">
                    <span class="legend">DIA:</span>
                    <input type="text" class="jwc_datepicker" data-timepicker="true" readonly="readonly" name="test_date" value="<?= $test_date ? date('d/m/Y H:i', strtotime($test_date)) : date('d/m/Y H:i'); ?>" required/>
                </label>

                <div class="m_top">&nbsp;</div>
                <div class="wc_actions" style="text-align: center">
                    <label class="label_check label_publish <?= ($test_status == 1 ? 'active' : ''); ?>"><input style="margin-top: -1px;" type="checkbox" value="1" name="test_status" <?= ($test_status == 1 ? 'checked' : ''); ?>> Publicar Agora!</label>
                    <button name="public" value="1" class="btn btn_green icon-share">ATUALIZAR</button>
                    <img class="form_load none" style="margin-left: 10px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </form>
</div>