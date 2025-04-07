<?php
$AdminLevel = 6;
if (!APP_GALLERY || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

//AUTO DELETE POST TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_GALLERY, "WHERE gallery_title IS NULL AND gallery_status = :st", "st=0");

    //AUTO TRASH IMAGES
    $Read->FullRead("SELECT image FROM " . DB_GALLERY_IMAGE . " WHERE gallery_id NOT IN(SELECT gallery_id FROM " . DB_GALLERY . ")");
    if ($Read->getResult()):
        $Delete->ExeDelete(DB_GALLERY_IMAGE, "WHERE id >= :id AND gallery_id NOT IN(SELECT gallery_id FROM " . DB_GALLERY . ")", "id=1");
        foreach ($Read->getResult() as $ImageRemove):
            if (file_exists("./uploads/{$ImageRemove['image']}") && !is_dir("./uploads/{$ImageRemove['image']}")):
                unlink("./uploads/{$ImageRemove['image']}");
            endif;
        endforeach;
    endif;
endif;

$Read = new Read;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-file-picture">Galeria</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Galeria
        </p>
    </div>

</header>
<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Paginator = new Pager('dashboard.php?wc=gallery/home&pg=', '<<', '>>', 5);
    $Paginator->ExePager($Page, 12);

    $Read->ExeRead(DB_GALLERY, "ORDER BY gallery_status ASC, gallery_date DESC LIMIT :limit OFFSET :offset", "limit={$Paginator->getLimit()}&offset={$Paginator->getOffset()}");
    if (!$Read->getResult()):
        $Paginator->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem galerias cadastradas {$Admin['user_name']}. Comece agora mesmo criando sua primeira galeria!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $GALLERY):
            extract($GALLERY);
            
            $Read->FullRead("SELECT image FROM " . DB_GALLERY_IMAGE . " WHERE gallery_id = :id ORDER BY id DESC LIMIT 1", "id={$gallery_id}");
            $gallery_cover = (!empty($Read->getResult()[0]['image']) ? $Read->getResult()[0]['image'] : '');
            $GalleryCover = (!empty($gallery_cover) && file_exists("./uploads/{$gallery_cover}") && !is_dir("./uploads/{$gallery_cover}") ? "{$gallery_cover}" : 'admin/_img/no_image.jpg');
            $GalleryStatus = ($gallery_status == 1 && strtotime($gallery_date) >= strtotime(date('Y-m-d H:i:s')) ? '<span class="btn btn_blue icon-clock icon-notext"></span>' : ($gallery_status == 1 ? '<span class="btn btn_green icon-checkmark icon-notext"></span>' : '<span class="btn btn_yellow icon-warning icon-notext"></span>'));
            $gallery_title = (!empty($gallery_title) ? $gallery_title : 'Edite esse rascunho para poder exibir como galeria em seu site!');
			$gallery_private = ($gallery_private == 0 ? '<span class="btn btn_green icon-unlocked">Não Privado</span>' : '<span class="btn btn_blue icon-lock">Privado</span>');


            echo "<article class='box box25 post_single' id='{$gallery_id}'>           
                <div class='post_single_cover'>
                    <img alt='{$gallery_title}' title='{$gallery_title}' src='./tim.php?src={$GalleryCover}&w=" . IMAGE_W / 2 . "&h=" . IMAGE_H / 2 . "'/>
                    <div class='post_single_status'>{$GalleryStatus}</div>
                </div>
                <div class='box_content'>
                    <h1 class='title'>" . Check::Chars($gallery_title, 56) . "</h1>
                    <a title='Editar Artigo' href='dashboard.php?wc=gallery/create&id={$gallery_id}' class='post_single_center icon-notext icon-pencil btn btn_blue'></a>
                    <span rel='post_single' class='j_delete_action icon-notext icon-cancel-circle btn btn_red' id='{$gallery_id}'></span>
                    <span rel='post_single' callback='Gallery' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='{$gallery_id}'>Deletar Galeria?</span>
                    " . $gallery_private . "
                </div>
            </article>";
        endforeach;

        $Paginator->ExePaginator(DB_GALLERY);
        echo $Paginator->getPaginator();
    endif;
    ?>
</div>