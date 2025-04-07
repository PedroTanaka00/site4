<?php
$AdminLevel = LEVEL_WC_USERS;
if (!APP_USERS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;

$UserId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($UserId):
    $Read->ExeRead(DB_USERS, "WHERE user_id = :id", "id={$UserId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ($user_level > $_SESSION['userLogin']['user_level']):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=users/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=users/home');
        exit;
    endif;
else:
    $CreateUserDefault = [
        "user_registration" => date('Y-m-d H:i:s'),
        "user_level" => 1
    ];
    $Create->ExeCreate(DB_USERS, $CreateUserDefault);
    header("Location: dashboard.php?wc=users/create&id={$Create->getResult()}");
    exit;
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-user-plus">Novo Usuário</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=users/home">Usuários</a>
            <span class="crumb">/</span>
            Novo Usuário
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $UserId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $UserId; ?>'>Deletar Usuário!</span>
        <span rel='dashboard_header_search' callback='Users' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $UserId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box70">
        <article class="wc_tab_target wc_active" id="profile">

            <div class="panel_header default">
                <h2 class="icon-user-plus">Dados de <?= $user_name; ?></h2>
            </div>

            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="user_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Users"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="user_id" value="<?= $UserId; ?>"/>
                    <label class="label">
                        <span class="legend">Primeiro nome:</span>
                        <input value="<?= $user_name; ?>" type="text" name="user_name" placeholder="Primeiro Nome:" required />
                    </label>

                    <label class="label">
                        <span class="legend">Sobrenome:</span>
                        <input value="<?= $user_lastname; ?>" type="text" name="user_lastname" placeholder="Sobrenome:" required />
                    </label>

                    <label class="label">
                        <span class="legend">Foto (<?= AVATAR_W; ?>x<?= AVATAR_H; ?>px, JPG ou PNG):</span>
                        <input type="file" name="user_thumb" class="wc_loadimage" />
                    </label>

                    <label class="label">
                        <span class="legend">CPF:</span>
                        <input value="<?= $user_document; ?>" type="text" name="user_document" class="formCpf" placeholder="CPF:" />
                    </label>

                    <div class="label_50">
                        <label class="label">
                            <span class="legend">Telefone:</span>
                            <input value="<?= $user_telephone; ?>" class="formPhone" type="text" name="user_telephone" placeholder="(55) 5555.5555" />
                        </label>

                        <label class="label">
                            <span class="legend">Celular:</span>
                            <input value="<?= $user_cell; ?>" class="formPhone" type="text" name="user_cell" placeholder="(55) 5555.5555" />
                        </label>
                    </div>

                    <label class="label">
                        <span class="legend">E-mail:</span>
                        <input value="<?= $user_email; ?>" type="email" name="user_email" placeholder="E-mail:" required />
                    </label>

                    <label class="label">
                        <span class="legend">Senha:</span>
                        <input value="" type="password" name="user_password" placeholder="Senha:" />
                    </label>

                    <?php if ($user_level < 10 || $_SESSION['userLogin']['user_level'] == 10): ?>
                        <div class="label_50">
                            <label class="label">
                                <span class="legend">Nível de acesso:</span>
                                <select name="user_level" required>
                                    <option selected disabled value="">Selecione o nível de acesso:</option>
                                    <?php
                                    $NivelDeAcesso = getWcLevel();
                                    foreach ($NivelDeAcesso as $Nivel => $Desc):
                                        if ($Nivel <= $_SESSION['userLogin']['user_level']):
                                            echo "<option";
                                            if ($Nivel == $user_level):
                                                echo " selected='selected'";
                                            endif;
                                            echo " value='{$Nivel}'>{$Desc}</option>";
                                        endif;
                                    endforeach;
                                    ?>
                                </select>
                            </label>

                            <label class="label">
                                <span class="legend">Gênero do Usuário:</span>
                                <select name="user_genre" required>
                                    <option selected disabled value="">Selecione o Gênero do Usuário:</option>
                                    <option value="1" <?= ($user_genre == 1 ? 'selected="selected"' : ''); ?>>Masculino</option>
                                    <option value="2" <?= ($user_genre == 2 ? 'selected="selected"' : ''); ?>>Feminino</option>
                                </select>
                            </label>
                        </div>
                    <?php else: ?>
                        <label class="label">
                            <span class="legend">Gênero do Usuário:</span>
                            <select name="user_genre" required>
                                <option selected disabled value="">Selecione o Gênero do Usuário:</option>
                                <option value="1" <?= ($user_genre == 1 ? 'selected="selected"' : ''); ?>>Masculino</option>
                                <option value="2" <?= ($user_genre == 2 ? 'selected="selected"' : ''); ?>>Feminino</option>
                            </select>
                        </label>
                    <?php endif; ?>
                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Usuário!</button>
                    <div class="clear"></div>
                </form>
            </div>
        </article>
    </div>

    <div class="box box30">
        <?php
        $Image = (file_exists("./uploads/{$user_thumb}") && !is_dir("./uploads/{$user_thumb}") ? "{$user_thumb}" : 'admin/_img/no_avatar.jpg');
        ?>
        <img class="user_thumb" style="width: 100%;" src="./tim.php?src=<?= $Image; ?>&w=400&h=400" alt="" title=""/>
        
        <div class="panel">
            <div class="box_conf_menu">
                <a class='conf_menu wc_tab wc_active' href='#profile'>Perfil</a>
            </div>
        </div>
    </div>
</div>