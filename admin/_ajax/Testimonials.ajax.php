<?php

session_start();
require '../_app/Config.inc.php';
$NivelAcess = LEVEL_WC_TESTIMONIALS;

if (!APP_TESTIMONIALS || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPPSSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

usleep(50000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Testimonials';
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//VALIDA AÇÃO
if ($PostData && $PostData['callback_action'] && $PostData['callback'] == $CallBack):
    //PREPARA OS DADOS
    $Case = $PostData['callback_action'];
    unset($PostData['callback'], $PostData['callback_action']);

    // AUTO INSTANCE OBJECT READ
    if (empty($Read)):
        $Read = new Read;
    endif;

    // AUTO INSTANCE OBJECT CREATE
    if (empty($Create)):
        $Create = new Create;
    endif;

    // AUTO INSTANCE OBJECT UPDATE
    if (empty($Update)):
        $Update = new Update;
    endif;
    
    // AUTO INSTANCE OBJECT DELETE
    if (empty($Delete)):
        $Delete = new Delete;
    endif;

    //SELECIONA AÇÃO
    switch ($Case):
        //DELETE
        case 'delete':
            $PostData['test_id'] = $PostData['del_id'];
            $Read->FullRead("SELECT test_cover FROM " . DB_TESTIMONIALS . " WHERE test_id = :ps", "ps={$PostData['test_id']}");
            if ($Read->getResult() && file_exists("../uploads/{$Read->getResult()[0]['test_cover']}") && !is_dir("../uploads/{$Read->getResult()[0]['test_cover']}")):
                unlink("../uploads/{$Read->getResult()[0]['test_cover']}");
            endif;

            $Delete->ExeDelete(DB_TESTIMONIALS, "WHERE test_id = :id", "id={$PostData['test_id']}");
            $jSON['success'] = true;
            break;

        case 'manager':
            $TestId = $PostData['test_id'];
            unset($PostData['test_id']);

            $Read->ExeRead(DB_TESTIMONIALS, "WHERE test_id = :id", "id={$TestId}");
            $ThisTest = $Read->getResult()[0];

            if (!empty($_FILES['test_cover'])):
                $File = $_FILES['test_cover'];

                if ($ThisTest['test_cover'] && file_exists("../uploads/{$ThisTest['test_cover']}") && !is_dir("../uploads/{$ThisTest['test_cover']}")):
                    unlink("../uploads/{$ThisTest['test_cover']}");
                endif;

                $Upload = new Upload('../uploads/');
                $Upload->Image($File, $TestId . '-' . time(), IMAGE_W, 'testimonials');
                if ($Upload->getResult()):
                    $PostData['test_cover'] = $Upload->getResult();
                else:
                    $jSON['trigger'] = AjaxErro("<b class='icon-image'>ERRO AO ENVIAR CAPA:</b> Olá {$_SESSION['userLogin']['user_name']}, selecione uma imagem JPG ou PNG para enviar como capa!", E_USER_WARNING);
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['test_cover']);
            endif;

            $PostData['test_status'] = (!empty($PostData['test_status']) ? '1' : '0');
            $PostData['test_date'] = (!empty($PostData['test_date']) ? Check::Data($PostData['test_date']) : date('Y-m-d H:i:s'));

            $Update->ExeUpdate(DB_TESTIMONIALS, $PostData, "WHERE test_id = :id", "id={$TestId}");
            $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>TUDO CERTO: </b> O post <b>{$PostData['test_title']}</b> foi atualizado com sucesso!");
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
