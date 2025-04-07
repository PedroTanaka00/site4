<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

/*
 * BANCO DE DADOS
 */
define('SIS_DB_HOST', 'localhost:3306'); //Link do banco de dados
define('SIS_DB_USER', 'root'); //Usuário do banco de dados
define('SIS_DB_PASS', ''); //Senha  do banco de dados
define('SIS_DB_DBSA', 'weprime_painel'); //Nome  do banco de dados

/*
 * CACHE E CONFIG
 */
define('SIS_CACHE_TIME', 10); //Tempo em minutos de sessão
define('SIS_CONFIG_WC', 0); //Registrar configurações no banco para gerenciar pelo painel!
/*
 * AUTO MANAGER
 */
define('DB_AUTO_TRASH', 0); //Remove todos os itens não gerenciados do banco!
define('DB_AUTO_PING', 0); //Tenta enviar 1x por dia o sitemap e o RSS para o Google/Bing
/*
 * TABELAS
 */
define('DB_CONF', 'ws_config'); //Tabela de Configurações
define('DB_USERS', 'ws_users'); //Tabela de usuários
define('DB_USERS_ADDR', 'ws_users_address'); //Tabela de endereço de usuários
define('DB_USERS_NOTES', 'ws_users_notes'); //Tabela de notas do usuário
define('DB_POSTS', 'ws_posts'); //Tabela de posts
define('DB_POSTS_IMAGE', 'ws_posts_images'); //Tabela de imagens de post
define('DB_CATEGORIES', 'ws_categories'); //Tabela de categorias de posts
define('DB_SEARCH', 'ws_search'); //Tabela de pesquisas
define('DB_PAGES', 'ws_pages'); //Tabela de páginas
define('DB_PAGES_IMAGE', 'ws_pages_images'); //Tabela de imagens da página
define('DB_PAGES_CATEGORIES', 'ws_pages_categories'); //Tabela de categorias de páginas
define('DB_COMMENTS', 'ws_comments'); //Tabela de Comentários
define('DB_COMMENTS_LIKES', 'ws_comments_likes'); //Tabela GOSTEI dos Comentários
define('DB_STATES', 'states'); //Tabela de estados
define('DB_CITIES', 'cities'); //Tabela de cidades
define('DB_DISTRICTS', 'districts'); //Tabela de bairros
define('DB_SLIDES', 'ws_slides'); //Tabela de conteúdo em destaque
define('DB_VIEWS_VIEWS', 'ws_siteviews_views'); //Controle de acesso ao site
define('DB_VIEWS_ONLINE', 'ws_siteviews_online'); //Controle de usuários online
define('DB_WC_API', 'workcontrol_api'); //Controle de api do WC
define('DB_WC_CODE', 'workcontrol_code'); //Controle de code de WC
define('DB_BANNERS', 'ws_banners'); //Tabela de banners
define('DB_TEMPLATE_COLORS', 'ws_template_colors'); //Tabela de cores de template
define('DB_GALLERY', 'ws_gallery'); //Tabela de galerias
define('DB_GALLERY_CATEGORY', 'ws_gallery_category'); //Tabela de categoria da galeria
define('DB_GALLERY_IMAGE', 'ws_gallery_images'); //Tabela de imagens da galeria
define('DB_VIDEO', 'ws_video'); //Tabela de vídeos
define('DB_PARTNERS', 'ws_partners'); //Tabela de Parceiros
define('DB_TESTIMONIALS', 'ws_testimonial'); //Tabela de Depoimentos
define('DB_LEADS_SITE', 'site_crm_leads'); //Tabela de Leads Site CRM



/*
  AUTO LOAD DE CLASSES
 */

function MyAutoLoad($Class) {
    $cDir = ['Conn', 'Helpers', 'Models', 'WorkControl'];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . '/' . $dirName . '/' . $Class . '.class.php') && !is_dir(__DIR__ . '/' . $dirName . '/' . $Class . '.class.php')):
            include_once(__DIR__ . '/' . $dirName . '/' . $Class . '.class.php');
            $iDir = true;
        endif;
    endforeach;
}

spl_autoload_register("MyAutoLoad");

/*
 * Define todas as constantes do banco dando sua devida preferência!
 */
$WorkControlDefineConf = null;
if (SIS_CONFIG_WC):
    $Read = new Read;
    $Read->FullRead("SELECT conf_key, conf_value FROM " . DB_CONF);
    if ($Read->getResult()):
        foreach ($Read->getResult() as $WorkControlDefineConf):
            if ($WorkControlDefineConf['conf_key'] != 'THEME' || empty($_SESSION['WC_THEME'])):
                define("{$WorkControlDefineConf['conf_key']}", "{$WorkControlDefineConf['conf_value']}");
            endif;
        endforeach;
        $WorkControlDefineConf = true;
    endif;
endif;


require 'Config/Config.inc.php';
require 'Config/Agency.inc.php';
require 'Config/Client.inc.php';




/*
 * Exibe erros lançados
 */

function Erro($ErrMsg, $ErrNo = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? 'trigger_info' : ($ErrNo == E_USER_WARNING ? 'trigger_alert' : ($ErrNo == E_USER_ERROR ? 'trigger_error' : 'trigger_success')));
    echo "<div class='trigger {$CssClass}'>{$ErrMsg}<span class='ajax_close'></span></div>";
}

/*
 * Exibe erros lançados por ajax
 */

function AjaxErro($ErrMsg, $ErrNo = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? 'trigger_info' : ($ErrNo == E_USER_WARNING ? 'trigger_alert' : ($ErrNo == E_USER_ERROR ? 'trigger_error' : 'trigger_success')));
    return "<div class='trigger trigger_ajax {$CssClass}'>{$ErrMsg}<span class='ajax_close'></span></div>";
}

/*
 * personaliza o gatilho do PHP
 */

function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    echo "<div class='trigger trigger_error'>";
    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class='ajax_close'></span></div>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');


/*
 * Descreve nivel de usuário
 */

function getWcLevel($Level = null) {
    $UserLevel = [
        1 => 'Cliente (user)',
        2 => 'Assinante (user)',
        6 => 'Colaborador (adm)',
        7 => 'Suporte Geral (adm)',
        8 => 'Gerente Geral (adm)',
        9 => 'Administrador (adm)',
        10 => 'Super Admin (adm)'
    ];

    if (!empty($Level)):
        return $UserLevel[$Level];
    else:
        return $UserLevel;
    endif;
}
