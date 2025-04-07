<?php

session_start();
require '../_app/Config.inc.php';
$NivelAcess = 6;

if ((!APP_PARTNERS) || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

usleep(50000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Partners';
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//VALIDA AÇÃO
if ($PostData && $PostData['callback_action'] && $PostData['callback'] == $CallBack):
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
        case 'manager':
            $PartnerId = $PostData['partner_id'];
            unset($PostData['partner_id'], $PostData['partner_thumb']);

            if (!empty($_FILES['partner_thumb'])):
                $PartnerThumb = $_FILES['partner_thumb'];
                $Read->FullRead("SELECT partner_thumb FROM " . DB_PARTNERS . " WHERE partner_id = :id", "id={$PartnerId}");
                if ($Read->getResult()):
                    if (file_exists("../uploads/{$Read->getResult()[0]['partner_thumb']}") && !is_dir("../uploads/{$Read->getResult()[0]['partner_thumb']}")):
                        unlink("../uploads/{$Read->getResult()[0]['partner_thumb']}");
                    endif;
                endif;

                $Upload->Image($PartnerThumb, $PartnerId . "-" . Check::Name($PostData['partner_name'] . $PostData['partner_lastname']) . '-' . time(), 600);
                if ($Upload->getResult()):
                    $PostData['partner_thumb'] = $Upload->getResult();
                else:
                    $jSON['trigger'] = AjaxErro("<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$_SESSION['userLogin']['user_name']}, selecione uma imagem JPG ou PNG para enviar como foto!", E_USER_WARNING);
                    echo json_encode($jSON);
                    return;
                endif;
            endif;

            $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>TUDO CERTO:</b> Olá {$_SESSION['userLogin']['user_name']}. O parceiro {$PostData['partner_name']} {$PostData['partner_lastname']} foi atualizado com sucesso!");

            //ATUALIZA PARCEIRO
            $Update->ExeUpdate(DB_PARTNERS, $PostData, "WHERE partner_id = :id", "id={$PartnerId}");
            if (!empty($SesseionRenew)):
                $Read->ExeRead(DB_PARTNERS, "WHERE partner_id = :id", "id={$PartnerId}");
                if ($Read->getResult()):
                    $_SESSION['userLogin'] = $Read->getResult()[0];
                endif;
            endif;

            break;

        case 'delete':
            $PartnerId = $PostData['del_id'];
            $Read->ExeRead(DB_PARTNERS, "WHERE partner_id = :partner", "partner={$PartnerId}");
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>PARCEIRO NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar um parceiro que não existe ou já foi removido!", E_USER_WARNING);
            else:
                extract($Read->getResult()[0]);

                if (file_exists("../uploads/{$partner_thumb}") && !is_dir("../uploads/{$partner_thumb}")):
                    unlink("../uploads/{$partner_thumb}");
                endif;

                $Delete->ExeDelete(DB_PARTNERS, "WHERE partner_id = :partner", "partner={$partner_id}");
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>PARCEIRO REMOVIDO COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=partners/home";

            endif;
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
