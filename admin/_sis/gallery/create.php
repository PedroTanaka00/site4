<?php
$AdminLevel = 6;
if (!APP_GALLERY || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

$Read = new Read;
$Create = new Create;

$GalleryId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($GalleryId):
    $Read->ExeRead(DB_GALLERY, "WHERE gallery_id = :id", "id={$GalleryId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar uma galeria que não existe ou que foi removida recentemente!";
        header('Location: dashboard.php?wc=gallery/home');
    endif;
else:
    $GalleryCreate = ['gallery_date' => date('Y-m-d H:i:s'), 'gallery_status' => 0, 'gallery_author' => $Admin['user_id']];
    $Create->ExeCreate(DB_GALLERY, $GalleryCreate);
    header('Location: dashboard.php?wc=gallery/create&id=' . $Create->getResult());
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-new-tab">Cadastrar Nova Galeria</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=gallery/home">Galeria</a>
            <span class="crumb">/</span>
            Nova Galeria
        </p>
    </div>
</header>

<div class="dashboard_content">
    <form class="auto_save" name="gallery_create" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="Gallery"/>
        <input type="hidden" name="callback_action" value="manager"/>
        <input type="hidden" name="gallery_id" value="<?= $GalleryId; ?>"/>

        <article class="box box70">
            <div class="box_content">
                <label class="label">
                    <span class="legend">Título:</span>
                    <input style="font-size: 1.5em;" type="text" name="gallery_title" value="<?= $gallery_title; ?>" required/>
                </label>

                <label class="label">
                    <span class="legend">Categoria:</span>
                    <select name="category_id" required>
                        <?php
                        $Read->FullRead("SELECT category_id, category_name FROM " . DB_GALLERY_CATEGORY . " ORDER BY category_name");
                        if ($Read->getResult()):
                            foreach ($Read->getResult() as $Cat):
                                echo "<option";
                                if ($Cat['category_id'] == $category_id):
                                    echo " selected='selected'";
                                endif;
                                echo " value='{$Cat['category_id']}'>{$Cat['category_name']}</option>";
                            endforeach;
                        endif;
                        ?>
                    </select>
                </label>

                <label class="label">
                    <span class="legend">Galeria (JPG <?= THUMB_W; ?>x<?= THUMB_H; ?>px):</span>
                    <input type="file" name="image[]" multiple/>
                </label>
            </div>


            <!-- INICIO GALERIA DE IMAGENS -->
            <div class="post_create_cover">
                <div class="upload_progress none">0%</div>
                <?php
                $Read->ExeRead(DB_GALLERY_IMAGE, "WHERE gallery_id = :id", "id={$gallery_id}");
                if ($Read->getResult()):
                    echo '<div class="pdt_images_gallery gallery pdt_single_image">';
                    foreach ($Read->getResult() as $Image):
                        $ImageUrl = ($Image['image'] && file_exists("./uploads/{$Image['image']}") && !is_dir("./uploads/{$Image['image']}") ? "{$Image['image']}" : '_img/no_image.jpg');
                        //echo "<img rel='Gallery' id='{$Image['id']}' alt='Imagem em {$gallery_title}' title='Imagem em {$gallery_title}' src='{$ImageUrl}' width='150' height='100' />";
                        echo "<img rel='Gallery' id='{$Image['id']}' alt='Imagem em {$gallery_title}' title='Imagem em {$gallery_title}' src='" . BASE . "/tim.php?src={$Image['image']}&w=150&h=110' />";
                    endforeach;
                    echo '</div>';
                else:
                    echo '<div class="pdt_images gallery pdt_single_image"></div>';
                endif;
                ?>
            </div>
            <!-- FINAL GALERIA DE IMAGENS -->


        </article>

        <article class="box box30">


            <header>
                <h1>Publicar:</h1>
            </header>
            <div class="box_content">
                <label class="label">
                    <span class="legend">DIA:</span>
                    <input type="text" class="formTime" name="gallery_date" value="<?= $gallery_date ? date('d/m/Y H:i', strtotime($gallery_date)) : date('d/m/Y H:i'); ?>" required/>
                </label>

                <label class="label">
                    <span class="legend">AUTOR:</span>
                    <select name="gallery_author" required>
                        <option value="<?= $Admin['user_id']; ?>"><?= $Admin['user_name']; ?> <?= $Admin['user_lastname']; ?></option>
                        <?php
                        $Read->FullRead("SELECT user_id, user_name, user_lastname FROM " . DB_USERS . " WHERE user_level >= :lv AND user_id != :uid", "lv=6&uid={$Admin['user_id']}");
                        if ($Read->getResult()):
                            foreach ($Read->getResult() as $GalleryAuthors):
                                echo "<option";
                                if ($PostAuthors['user_id'] == $gallery_author):
                                    echo " selected='selected'";
                                endif;
                                echo " value='{$PostAuthors['user_id']}'>{$PostAuthors['user_name']} {$PostAuthors['user_lastname']}</option>";
                            endforeach;
                        endif;
                        ?>
                    </select>
                </label>
                
                <label class="label">
                    <span class="legend">GALERIA PRIVADA:</span>
                    <select name="gallery_private" required>
                        <option value="0" <?= ($gallery_private == 0 ? 'selected' : ''); ?>>Não Privado</option>
                        <option value="1" <?= ($gallery_private == 1 ? 'selected' : ''); ?>>Privado</option>
                    </select>
                </label>

                <div class="m_top">&nbsp;</div>
                <div class="wc_actions" style="text-align: center">
                    <label class="label_check label_publish <?= ($gallery_status == 1 ? 'active' : ''); ?>"><input style="margin-top: -1px;" type="checkbox" value="1" name="gallery_status" <?= ($gallery_status == 1 ? 'checked' : ''); ?>> Publicar Agora!</label>
                    <button name="public" value="1" class="btn btn_green icon-share">ATUALIZAR</button>
                    <img class="form_load none" style="margin-left: 10px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                </div>
                <div class="clear"></div>
            </div>
        </article>
    </form>
</div>