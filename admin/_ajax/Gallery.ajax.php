<?php

session_start();
require '../_app/Config.inc.php';
$NivelAcess = 6;

if (!APP_GALLERY || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPPSSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

usleep(50000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Gallery';
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
            $PostData['gallery_id'] = $PostData['del_id'];
            $Read->FullRead("SELECT gallery_title FROM " . DB_GALLERY . " WHERE gallery_id = :ps", "ps={$PostData['gallery_id']}");
            $titulo = $Read->getResult();

            $Read->FullRead("SELECT image FROM " . DB_GALLERY_IMAGE . " WHERE gallery_id = :ps", "ps={$PostData['gallery_id']}");
            if ($Read->getResult()):
                foreach ($Read->getResult() as $PostImage):
                    $ImageRemove = "../uploads/{$PostImage['image']}";
                    if (file_exists($ImageRemove) && !is_dir($ImageRemove)):
                        unlink($ImageRemove);
                    endif;
                endforeach;
            endif;

            $Delete->ExeDelete(DB_GALLERY, "WHERE gallery_id = :id", "id={$PostData['gallery_id']}");
            $Delete->ExeDelete(DB_GALLERY_IMAGE, "WHERE gallery_id = :id", "id={$PostData['gallery_id']}");
            $jSON['success'] = true;
            break;

        case 'manager':
            $PostId = $PostData['gallery_id'];
            unset($PostData['gallery_id']);

            $Read->ExeRead(DB_GALLERY, "WHERE gallery_id = :id", "id={$PostId}");
            $ThisPost = $Read->getResult()[0];

            $PostData['gallery_name'] = (!empty($PostData['gallery_name']) ? Check::Name($PostData['gallery_name']) : Check::Name($PostData['gallery_title']));
            $Read->ExeRead(DB_GALLERY, "WHERE gallery_id != :id AND gallery_name = :name", "id={$PostId}&name={$PostData['gallery_name']}");
            if ($Read->getResult()):
                $PostData['gallery_name'] = "{$PostData['gallery_name']}-{$PostId}";
            endif;

            if (!empty($_FILES['image'])):
                $File = $_FILES['image'];
                $gbFile = array();
                $gbCount = count($File['type']);
                $gbKeys = array_keys($File);
                $gbLoop = 0;

                for ($gb = 0; $gb < $gbCount; $gb++):
                    foreach ($gbKeys as $Keys):
                        $gbFiles[$gb][$Keys] = $File[$Keys][$gb];
                    endforeach;
                endfor;

                $jSON['gallery'] = null;
                foreach ($gbFiles as $UploadFile):
                    $gbLoop ++;
                    $Upload->Image($UploadFile, "{$PostId}-{$gbLoop}-" . time() . base64_encode(time()), 1000, 'gallery');
                    if ($Upload->getResult()):
                        $gbCreate = ['gallery_id' => $PostId, "image" => $Upload->getResult()];
                        $Create->ExeCreate(DB_GALLERY_IMAGE, $gbCreate);
                        $jSON['gallery'] .= "<img rel='Gallery' id='{$Create->getResult()}' alt='Imagem em {$PostData['gallery_title']}' title='Imagem em {$PostData['gallery_title']}' src='" . BASE . "/tim.php?src={$Upload->getResult()}&w=150&h=110'/>";
                    endif;
                endforeach;
            endif;

            unset($PostData['image']);

            $PostData = array_filter($PostData);
            $PostData['gallery_status'] = (!empty($PostData['gallery_status']) ? '1' : '0');
            $PostData['gallery_date'] = (!empty($PostData['gallery_date']) ? Check::Data($PostData['gallery_date']) : date('Y-m-d H:i:s'));
			$PostData['gallery_private'] = (!empty($PostData['gallery_private']) ? '1' : '0');

            //var_dump($PostData);

            $Update->ExeUpdate(DB_GALLERY, $PostData, "WHERE gallery_id = :id", "id={$PostId}");
            $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>TUDO CERTO: </b> A galeria <b>" . (!empty($PostData['gallery_title']) ? $PostData['gallery_title'] : 'Sem Titulo') . "</b> foi atualizado com sucesso!");
            break;

        case 'gbremove':
            $Read->FullRead("SELECT image FROM " . DB_GALLERY_IMAGE . " WHERE id = :id", "id={$PostData['img']}");
            if ($Read->getResult()):
                $ImageRemove = "../uploads/{$Read->getResult()[0]['image']}";
                if (file_exists($ImageRemove) && !is_dir($ImageRemove)):
                    unlink($ImageRemove);
                endif;
                $Delete->ExeDelete(DB_GALLERY_IMAGE, "WHERE id = :id", "id={$PostData['img']}");
                $jSON['success'] = true;
            endif;
            break;

        /*
         * Categoria da Galeria (Nome)
         */
        case 'category_create':
            $PostData = array_map('strip_tags', $PostData);
            $CatId = $PostData['category_id'];
            unset($PostData['category_id']);

            $PostData['category_date'] = (!empty($PostData['category_date']) ? Check::Data($PostData['category_date']) : date('Y-m-d H:i:s'));
            
            $Update->ExeUpdate(DB_GALLERY_CATEGORY, $PostData, "WHERE category_id = :id", "id={$CatId}");
            $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>TUDO CERTO:</b> A categoria <b>" . (!empty($PostData['category_name']) ? $PostData['category_name'] : 'Sem Titulo') . "</b> foi atualizado com sucesso!");
            break;
        
        case 'category_delete':
            // EXCLUIR A CATEGORIA
            // MAS VERIFICAR SE NÂO EXISTE GALERIA VINCULADA A CATEGORIA, CASO EXISTIR NAO DEIXAR EXCLUIR
            $PostData['category_id'] = $PostData['del_id'];
            
            $Read->ExeRead(DB_GALLERY, "WHERE category_id = :id", "id={$PostData['category_id']}");
            if($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}, não é possível remover categorias quando existem galeria cadastradas na mesma!<b>", E_USER_ERROR);
            else:
                $Delete->ExeDelete(DB_GALLERY_CATEGORY, "WHERE category_id = :cat", "cat={$PostData['category_id']}");
                $jSON['success'] = true;
            endif;
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
