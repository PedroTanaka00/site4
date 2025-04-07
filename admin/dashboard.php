<?php
ob_start();
session_start();
require './_app/Config.inc.php';
require './_cdn/cronjob.php';

if (isset($_SESSION['userLogin']) && isset($_SESSION['userLogin']['user_level']) && $_SESSION['userLogin']['user_level'] >= 6):
    $Read = new Read;
    $Read->FullRead("SELECT user_level FROM " . DB_USERS . " WHERE user_id = :user", "user={$_SESSION['userLogin']['user_id']}");
    if (!$Read->getResult() || $Read->getResult()[0]['user_level'] < 6):
        unset($_SESSION['userLogin']);
        header('Location: ./index.php');
        exit;
    else:
        $Admin = $_SESSION['userLogin'];
        $Admin['user_thumb'] = (!empty($Admin['user_thumb']) && file_exists("../uploads/{$Admin['user_thumb']}") && !is_dir("../uploads/{$Admin['user_thumb']}") ? $Admin['user_thumb'] : '../admin/_img/no_avatar.jpg');
        $DashboardLogin = true;
    endif;
else:
    unset($_SESSION['userLogin']);
    header('Location: ./index.php');
    exit;
endif;

$AdminLogOff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
if ($AdminLogOff):
    $_SESSION['trigger_login'] = Erro("<b>LOGOFF:</b> Olá {$Admin['user_name']}, você desconectou com sucesso do " . ADMIN_NAME . ", volte logo!");
    unset($_SESSION['userLogin']);
    header('Location: ./index.php');
    exit;
endif;

$getViewInput = filter_input(INPUT_GET, 'wc', FILTER_DEFAULT);
$getView = ($getViewInput == 'home' ? 'home' . ADMIN_MODE : $getViewInput);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title><?= ADMIN_NAME; ?> - <?= SITE_NAME; ?></title>
        <meta name="description" content="<?= ADMIN_DESC; ?>"/>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
        <meta name="robots" content="noindex, nofollow"/>

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Source+Code+Pro:300,500' rel='stylesheet' type='text/css'>
        <link rel="base" href="<?= BASE; ?>/admin/">
        <link rel="shortcut icon" href="_img/favicon.ico" />

        <link rel="stylesheet" href="./_cdn/datepicker/datepicker.min.css"/>
        <link rel="stylesheet" href="./_cdn/pickr.min.css"/>
        <link rel="stylesheet" href="_css/reset.css"/>
        <link rel="stylesheet" href="_css/workcontrol.css"/>
        <link rel="stylesheet" href="_css/freights.css"/>
        <link rel="stylesheet" href="_css/workcontrol-860.css" media="screen and (max-width: 860px)"/>
        <link rel="stylesheet" href="_css/workcontrol-480.css" media="screen and (max-width: 480px)"/>
        <link rel="stylesheet" href="./_cdn/bootcss/fonticon.css"/>

        <script src="./_cdn/jquery.js"></script>
        <script src="./_cdn/jquery.form.js"></script>
        <script src="./_cdn/pickr.es5.min.js"></script>
        <script src="./_cdn/jquery.maskMoney.min.js"></script>
        <script src="_js/workcontrol.js"></script>

        <script src="_js/tinymce/tinymce.min.js"></script>
        <script src="_js/maskinput.js"></script>
        <script src="_js/workplugins.js"></script>

        <script src="./_cdn/highcharts.js"></script>
        <script src="./_cdn/datepicker/datepicker.min.js"></script>
        <script src="./_cdn/datepicker/datepicker.pt-BR.js"></script>
    </head>
    
    <body class="dashboard_main">
        <div class="workcontrol_upload workcontrol_loadmodal">
            <div class="workcontrol_upload_bar">
                <img class="m_botton" width="50" src="_img/load_w.gif" alt="Processando requisição!" title="Processando requisição!"/>
                <p><span class="workcontrol_upload_progrees">0%</span> - Processando requisição!</p>
            </div>
        </div>

        <div class="dashboard_fix">
            <?php
            if (isset($_SESSION['trigger_controll'])):
                echo "<div class='trigger_modal' style='display: block'>";
                Erro("<span class='icon-warning'>{$_SESSION['trigger_controll']}</span>", E_USER_ERROR);
                echo "</div>";
                unset($_SESSION['trigger_controll']);
            endif;
            ?>

            <?php require("menu.php"); ?>

            <div class="dashboard">
                <?php
            
                if (ADMIN_MAINTENANCE):
                    echo "<div>";
                    echo Erro("<span class='al_center'><b class='icon-warning'>IMPORTANTE:</b> O modo de manutenção está ativo. Somente usuários administradores podem ver o site assim!</span>", E_USER_ERROR);
                    echo "</div>";
                endif;

              
                ?>
                <div class="dashboard_sidebar">
                    <span class="mobile_menu btn btn_blue icon-menu icon-notext"></span>
                    <div class="fl_right">
                        <span class="dashboard_sidebar_welcome m_right">Bem-vindo(a) ao <?= ADMIN_NAME; ?>, Hoje <?= date('d/m/y H\hi'); ?></span>
                        <a class="icon-exit btn btn_red" title="Desconectar do <?= ADMIN_NAME; ?>!" href="dashboard.php?wc=home&logoff=true">Sair!</a>
                    </div>
                </div>

                <?php
                //QUERY STRING
                if (!empty($getView)):
                    $includepatch = __DIR__ . '/_sis/' . strip_tags(trim($getView)) . '.php';
                else:
                    $includepatch = __DIR__ . '/_sis/' . 'dashboard.php';
                endif;

                if (file_exists(__DIR__ . "/_siswc/" . strip_tags(trim($getView)) . '.php')):
                    require_once __DIR__ . "/_siswc/" . strip_tags(trim($getView)) . '.php';
                elseif (file_exists($includepatch)):
                    require_once($includepatch);
                else:
                    $_SESSION['trigger_controll'] = "<b>OPPSSS:</b> <span class='fontred'>_sis/{$getView}.php</span> ainda está em contrução!";
                    header('Location: dashboard.php?wc=home');
                    exit;
                endif;
                ?>
            </div>
        </div>
    </body>
</html>
<?php
ob_end_flush();
