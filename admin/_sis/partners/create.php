<?php
$AdminLevel = 6;
if (!APP_PARTNERS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

$Read = new Read;
$Create = new Create;

$PartnerId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($PartnerId):
    $Read->ExeRead(DB_PARTNERS, "WHERE partner_id = :id", "id={$PartnerId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um parceiro que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=partners/home');
    endif;
else:
    $CreatePartnerDefault = [
        "partner_registration" => date('Y-m-d H:i:s')
    ];
    $Create->ExeCreate(DB_PARTNERS, $CreatePartnerDefault);
    header("Location: dashboard.php?wc=partners/create&id={$Create->getResult()}");
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-user-plus">Novo Parceiro</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=partners/home">Parceiros</a>
            <span class="crumb">/</span>
            Novo Parceiro
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $PartnerId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $PartnerId; ?>'>Deletar Parceiro!</span>
        <span rel='dashboard_header_search' callback='Partners' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $PartnerId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box70">
        <article class="wc_tab_target wc_active" id="profile">
            <div class="box_content">
                <form class="auto_save" class="j_tab_home tab_create" name="user_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Partners"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="partner_id" value="<?= $PartnerId; ?>"/>
                    <label class="label">
                        <span class="legend">Primeiro nome:</span>
                        <input value="<?= $partner_name; ?>" type="text" name="partner_name" placeholder="Primeiro Nome:" required />
                    </label>

                    <label class="label">
                        <span class="legend">Sobrenome:</span>
                        <input value="<?= $partner_lastname; ?>" type="text" name="partner_lastname" placeholder="Sobrenome:" required />
                    </label>
                    
                    <label class="label">
                        <span class="legend">Breve descrição:</span>
                        <input value="<?= $partner_desc; ?>" type="text" name="partner_desc" placeholder="Breve descrição:" />
                    </label>

                    <label class="label">
                        <span class="legend">Foto (<?= AVATAR_W; ?>x<?= AVATAR_H; ?>px, JPG ou PNG):</span>
                        <input type="file" name="partner_thumb" class="wc_loadimage" />
                    </label>
                    
                    <label class="label">
                        <span class="legend">Link:</span>
                        <input value="<?= $partner_link; ?>" type="text" name="partner_link" placeholder="http://www.?????.com.br" />
                    </label>
                    
                    <label class="label">
                        <span class="legend">Status:</span>
                        <select name="partner_status" required>
                            <option selected disabled value="">Selecione o Status do Parceiro:</option>
                            <option value="1" <?= ($partner_status == 1 ? 'selected="selected"' : ''); ?>>Ativo</option>
                            <option value="2" <?= ($partner_status == 2 ? 'selected="selected"' : ''); ?>>Inativo</option>
                        </select>
                    </label>

                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Parceiro!</button>
                    <div class="clear"></div>
                </form>
            </div>
        </article>
    </div>

    <div class="box box30">
        <?php
        $Image = (file_exists("./uploads/{$partner_thumb}") && !is_dir("./uploads/{$partner_thumb}") ? "{$partner_thumb}" : 'admin/_img/no_avatar.jpg');
        ?>
        <div class="box_content">
            <img class="partner_thumb" style="width: 100%;" src="./tim.php?src=<?= $Image; ?>&w=400&h=400" alt="" title=""/>

            <div class="box_conf_menu">
                <a class='conf_menu wc_tab wc_active' href='#profile'>Perfil</a>
            </div>
        </div>
    </div>
</div>