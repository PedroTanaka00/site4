<?php

session_start();
require '../_app/Config.inc.php';
$NivelAcess = 6;

if (!APP_VIDEO || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPPSSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

usleep(50000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Video';
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//VALIDA AÇÃO
if ($PostData && $PostData['callback_action'] && $PostData['callback'] = $CallBack):
    //PREPARA OS DADOS
    $Case = $PostData['callback_action'];
    unset($PostData['callback'], $PostData['callback_action']);

    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $Upload = new Upload('../uploads/');

    //SELECIONA AÇÃO
    switch ($Case):
        //DELETE
        case 'delete':
            $PostData['video_id'] = $PostData['del_id'];
            $Read->FullRead("SELECT video_title FROM " . DB_VIDEO . " WHERE video_id = :ps", "ps={$PostData['video_id']}");
            $titulo = $Read->getResult();

            $Delete->ExeDelete(DB_VIDEO, "WHERE video_id = :id", "id={$PostData['video_id']}");
            $jSON['success'] = true;
            break;
			
        case 'manager':
            $PostId = $PostData['video_id'];
            unset($PostData['video_id']);

            $Read->ExeRead(DB_VIDEO, "WHERE video_id = :id", "id={$PostId}");
            $ThisPost = $Read->getResult()[0];

            $PostData['video_name'] = (!empty($PostData['video_name']) ? Check::Name($PostData['video_name']) : Check::Name($PostData['video_title']));
            $PostData['video_name'] = "{$PostData['video_name']}-{$PostId}";

            $PostData = array_filter($PostData);
            $PostData['video_status'] = (!empty($PostData['video_status']) ? '1' : '0');
			$PostData['video_private'] = (!empty($PostData['video_private']) ? '1' : '0');
            $PostData['video_date'] = (!empty($PostData['video_date']) ? Check::Data($PostData['video_date']) : date('Y-m-d H:i:s'));
            
            $Update->ExeUpdate(DB_VIDEO, $PostData, "WHERE video_id = :id", "id={$PostId}");
            $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>TUDO CERTO: </b> O vídeo <b>" . (!empty($PostData['video_title']) ? $PostData['video_title'] : 'Sem Titulo') . "</b> foi atualizado com sucesso!");
            break;
    endswitch;

    //RETORNA O CALLBACK
    if ($jSON):
        echo json_encode($jSON);
    else:
        $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Desculpe. Mas uma ação do sistema não respondeu corretamente. Ao persistir, contate o desenvolvedor!', E_USER_ERROR);
        echo json_encode($jSON);
    endif;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;
