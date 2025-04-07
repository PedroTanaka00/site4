<?php
$AdminLevel = 6;
if (!APP_VIDEO || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

$Read = new Read;
$Create = new Create;

$VideoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($VideoId):
    $Read->ExeRead(DB_VIDEO, "WHERE video_id = :id", "id={$VideoId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um vídeo que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=video/home');
    endif;
else:
    $VideoCreate = ['video_date' => date('Y-m-d H:i:s'), 'video_status' => 0, 'video_author' => $Admin['user_id']];
    $Create->ExeCreate(DB_VIDEO, $VideoCreate);
    header('Location: dashboard.php?wc=video/create&id=' . $Create->getResult());
endif;
?>

<style>
.video-container {
	position:relative;
	padding-bottom:56.25%;
	padding-top:30px;
	height:0;
	overflow:hidden;
}

.video-container iframe, .video-container object, .video-container embed {
	position:absolute;
	top:0;
	left:0;
	width:100%;
	height:100%;
}
</style>
<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-new-tab">Cadastrar Novo Vídeo</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=video/home">Vídeo</a>
            <span class="crumb">/</span>
            Novo Vídeo
        </p>
    </div>
</header>

<div class="dashboard_content">
    <form class="auto_save" name="video_create" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="Video"/>
        <input type="hidden" name="callback_action" value="manager"/>
        <input type="hidden" name="video_id" value="<?= $VideoId; ?>"/>

        <article class="box box70">
            <div class="box_content">
                <label class="label">
                    <span class="legend">Título:</span>
                    <input style="font-size: 1.5em;" type="text" name="video_title" value="<?= $video_title; ?>" required/>
                </label>
                
                <label class="label">
                    <span class="legend">Link do vídeo:</span>
                    <input style="font-size: 1.5em;" type="text" name="video_link" value="<?= $video_link; ?>" required/>
                </label>
            </div>


            <!-- INICIO VÍDEO -->
            <div class="post_create_cover">
                <div class="upload_progress none">0%</div>
                <?php
                	if($video_link != ""):
                
                	$url = $video_link;
					$url = explode("watch?v=", $url);
                ?>
                <div style="padding: 2.5% 0 0 0;">
	                <!--<a class="video" target="_blank" title="<?= $video_title; ?>" href="http://www.youtube.com/embed/<?= $url[1]; ?>?fs=1&amp;autoplay=1">
	        			<img alt="<?= $video_title; ?>" title="<?= $video_title; ?>" src="http://i1.ytimg.com/vi/<?= $url[1]; ?>/0.jpg">
	    		  	</a>-->
	    		  	<div class="video-container"><iframe style="border: 5px solid #CCC;" width="420" height="315" src="https://www.youtube.com/embed/<?= $url[1]; ?>"></iframe></div>
    		  	</div>
    		  	<?php endif; ?>
            </div>
            <!-- FINAL VÍDEO -->


        </article>

        <article class="box box30">


            <header>
                <h1>Publicar:</h1>
            </header>
            <div class="box_content">
                <label class="label">
                    <span class="legend">DIA:</span>
                    <input type="text" class="formTime" name="video_date" value="<?= $video_date ? date('d/m/Y H:i', strtotime($video_date)) : date('d/m/Y H:i'); ?>" required/>
                </label>

                <label class="label">
                    <span class="legend">AUTOR:</span>
                    <select name="video_author" required>
                        <option value="<?= $Admin['user_id']; ?>"><?= $Admin['user_name']; ?> <?= $Admin['user_lastname']; ?></option>
                        <?php
                        $Read->FullRead("SELECT user_id, user_name, user_lastname FROM " . DB_USERS . " WHERE user_level >= :lv AND user_id != :uid", "lv=6&uid={$Admin['user_id']}");
                        if ($Read->getResult()):
                            foreach ($Read->getResult() as $VideoAuthors):
                                echo "<option";
                                if ($PostAuthors['user_id'] == $video_author):
                                    echo " selected='selected'";
                                endif;
                                echo " value='{$PostAuthors['user_id']}'>{$PostAuthors['user_name']} {$PostAuthors['user_lastname']}</option>";
                            endforeach;
                        endif;
                        ?>
                    </select>
                </label>
                
                <label class="label">
                    <span class="legend">VÍDEO PRIVADO:</span>
                    <select name="video_private" required>
                        <option value="0" <?= ($video_private == 0 ? 'selected' : ''); ?>>Não Privado</option>
                        <option value="1" <?= ($video_private == 1 ? 'selected' : ''); ?>>Privado</option>
                    </select>
                </label>

                <div class="m_top">&nbsp;</div>
                <div class="wc_actions" style="text-align: center">
                    <label class="label_check label_publish <?= ($video_status == 1 ? 'active' : ''); ?>"><input style="margin-top: -1px;" type="checkbox" value="1" name="video_status" <?= ($video_status == 1 ? 'checked' : ''); ?>> Publicar Agora!</label>
                    <button name="public" value="1" class="btn btn_green icon-share">ATUALIZAR</button>
                    <img class="form_load none" style="margin-left: 10px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                </div>
                <div class="clear"></div>
            </div>
        </article>
    </form>
</div>