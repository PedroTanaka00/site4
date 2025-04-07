<?php
$AdminLevel = 6;
if (!APP_VIDEO || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

//AUTO DELETE POST TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_VIDEO, "WHERE video_title IS NULL AND video_status = :st", "st=0");
endif;

$Read = new Read;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-video-camera">Vídeo</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Vídeo
        </p>
    </div>

</header>
<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Paginator = new Pager('dashboard.php?wc=video/home&pg=', '<<', '>>', 5);
    $Paginator->ExePager($Page, 12);

    $Read->ExeRead(DB_VIDEO, "ORDER BY video_status ASC, video_date DESC LIMIT :limit OFFSET :offset", "limit={$Paginator->getLimit()}&offset={$Paginator->getOffset()}");
    if (!$Read->getResult()):
        $Paginator->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem vídeos cadastrados {$Admin['user_name']}. Comece agora mesmo criando seu primeirao vídeo!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $VIDEO):
            extract($VIDEO);

            $VideoStatus 	= ($video_status == 1 && strtotime($video_date) >= strtotime(date('Y-m-d H:i:s')) ? '<span class="btn btn_blue icon-clock icon-notext"></span>' : ($video_status == 1 ? '<span class="btn btn_green icon-checkmark icon-notext"></span>' : '<span class="btn btn_yellow icon-warning icon-notext"></span>'));
            $video_title 	= (!empty($video_title) ? $video_title : 'Edite esse rascunho para poder exibir como vídeo em seu site!');
			$video_private 	= ($video_private == 0 ? '<span class="btn btn_green icon-unlocked">Não Privado</span>' : '<span class="btn btn_blue icon-lock">Privado</span>');

			$url = $video_link;
			$url = explode("watch?v=", $url);
			
			if($video_link != ""):
				$video_image = 'http://i1.ytimg.com/vi/'.$url[1].'/0.jpg';
			else:
				$video_image = '_img/no_image.jpg';
			endif;

            echo "<article class='box box25 post_single' id='{$video_id}'>           
                <div class='post_single_cover'>
                    <img alt='{$video_title}' title='{$video_title}' src='{$video_image}' />
                    <div class='post_single_status'>{$VideoStatus}</div>
                </div>
                <div class='box_content'>
                    <h1 class='title'>" . Check::Chars($video_title, 56) . "</h1>
                    <a title='Editar Artigo' href='dashboard.php?wc=video/create&id={$video_id}' class='post_single_center icon-notext icon-pencil btn btn_blue'></a>
                    <span rel='post_single' class='j_delete_action icon-notext icon-cancel-circle btn btn_red' id='{$video_id}'></span>
                    <span rel='post_single' callback='Video' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='{$video_id}'>Deletar Vídeo?</span>
                	" . $video_private . "
                </div>
            </article>";
        endforeach;

        $Paginator->ExePaginator(DB_VIDEO);
        echo $Paginator->getPaginator();
    endif;
    ?>
</div>