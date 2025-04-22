<?php

if (!$WorkControlDefineConf):
    /*
     * URL DO SISTEMA
     */
    define('BASE', 'http://project-weprime-site-04.localhost'); //Url raiz do site no servidor
    define('THEME', ''); //template do site
endif;


//DINAMYC THEME
if (!empty($_SESSION['WC_THEME'])):
    define('THEME', $_SESSION['WC_THEME']); //template do site
endif;

/*
 * PATCH CONFIG
 */
define('INCLUDE_PATH', BASE . '/themes/' . THEME); //Geral de inclusão (Não alterar)
define('REQUIRE_PATH', 'themes/' . THEME); //Geral de inclusão (Não alterar)

if (!$WorkControlDefineConf):
    /*
     * ADMIN CONFIG
     */
    define('ADMIN_NAME', 'Painel');  //Nome do painel de controle (Work Control)
    define('ADMIN_DESC', 'WePrime'); //Descrição do painel de controle (Work Control)
    define('ADMIN_MODE', 1); //1 = website / 2 = e-commerce / 3 = Imobi / 4 = EAD
    define('ADMIN_WC_CUSTOM', 1); //Habilita menu e telas customizadas
    define('ADMIN_MAINTENANCE', 0); //Manutenção
    define('ADMIN_VERSION', '1.0');

    /*
     * E-MAIL SERVER
     * Consulte estes dados com o serviço de hospedagem
     */
    define('MAIL_HOST', 'smtp.hostinger.com'); //Servidor de e-mail
    define('MAIL_PORT', '465'); //Porta de envio
    define('MAIL_USER', 'contato@weprimeweb.com'); //E-mail de envio
    define('MAIL_SMTP', 'contato@weprimeweb.com'); //E-mail autenticador do envio (Geralmente igual ao MAIL_USER, exceto em serviços como AmazonSES, sendgrid...)
    define('MAIL_PASS', '4dSsvOZ&pK'); //Senha do e-mail de envio
    define('MAIL_SENDER', 'WePrimeWeb Developers'); //Nome do remetente de e-mail
    define('MAIL_MODE', 'ssl'); //Encriptação para envio de e-mail [0 não parametrizar / tls / ssl] (Padrão = tls)
    define('MAIL_TESTER', ''); //E-mail de testes (DEV)
    define('MAIL_ADDRESS', 'contato@weprimeweb.com'); //E-mail do Destinatario (que irá receber o formulário)

    /*
     * MEDIA CONFIG
     */
    define('IMAGE_W', 1600); //Tamanho da imagem (WIDTH)
    define('IMAGE_H', 800); //Tamanho da imagem (HEIGHT)
    define('THUMB_W', 800); //Tamanho da miniatura (WIDTH) PDTS
    define('THUMB_H', 1000); //Tamanho da minuatura (HEIGHT) PDTS
    define('AVATAR_W', 500); //Tamanho da miniatura (WIDTH) USERS
    define('AVATAR_H', 500); //Tamanho da minuatura (HEIGHT) USERS
    define('SLIDE_W', 1920); //Tamanho da miniatura (WIDTH) SLIDE
    define('SLIDE_H', 600); //Tamanho da minuatura (HEIGHT) SLIDE
    define('BANNER_W', 500); //Tamanho da miniatura (WIDTH) BANNER
    define('BANNER_H', 400); //Tamanho da minuatura (HEIGHT) BANNER

    /*
     * APP CONFIG
     * Habilitar ou desabilitar modos do sistema
     */
    define('APP_POSTS', 1); //Posts
    define('APP_POSTS_AMP', 1); //AMP para Posts
    define('APP_POSTS_INSTANT_ARTICLE', 1); //Instante Article FB
    define('APP_SEARCH', 1); //Relatório de Pesquisas
    define('APP_PAGES', 1); //Páginas
    define('APP_USERS', 1); //Usuários
    define('APP_TEMPLATE', 1); //Template
    define('APP_GALLERY', 1); //Galeria
    define('APP_VIDEO', 1); //Vídeo
    define('APP_PARTNERS', 1); //Parceiros
    define('APP_TESTIMONIALS', 1); //Depoimentos
    define('APP_LEADS', 1); //Leads

    /*
     * LEVEL CONFIG
     * Configura permissões do painel de controle!
     */
    define('LEVEL_WC_POSTS', 6);
    define('LEVEL_WC_PAGES', 6);
    define('LEVEL_WC_REPORTS', 6);
    define('LEVEL_WC_TEMPLATE', 6);
    define('LEVEL_WC_USERS', 6);
    define('LEVEL_WC_TESTIMONIALS', 6);
	define('LEVEL_WC_LEADS', 6);
	define('LEVEL_WC_CONFIG', 6);
    define('LEVEL_WC_CONFIG_MASTER', 10);
    define('LEVEL_WC_CONFIG_API', 10);
    define('LEVEL_WC_CONFIG_CODES', 10);

    /*
     * FB SEGMENT
     * Configura ultra segmentação de público no facebook
     * !!!! IMPORTANTE :: Para utilizar ultra segmentação de produtos e imóveis
     * é precisso antes configurar os catálogos de produtos respectivamente!
     */
    define('SEGMENT_FB_PIXEL_ID', 0); //Id do pixel de rastreamento
    define('SEGMENT_WC_USER', 0); //Enviar dados do login de usuário?
    define('SEGMENT_WC_BLOG', 0); //Ultra segmentar páginas do BLOG?
    define('SEGMENT_WC_ECOMMERCE', 0); //Ultra segmentar páginas do E-COMMERCE?
    define('SEGMENT_WC_IMOBI', 0); //Ultra segmentar páginas do imobi?
    define('SEGMENT_WC_EAD', 0); //Ultra segmentar páginas do EAD?
    define('SEGMENT_GL_ANALYTICS_UA', ''); //ID do Google Analytics (UA-00000000-0)
    define('SEGMENT_FB_PAGE_ID', ''); //ID do Facebook Pages (Obrigatório para POST - Instant Article)
    define('SEGMENT_GL_ADWORDS_ID', ''); //ID do pixel do Adwords (todo o site)
    define('SEGMENT_GL_ADWORDS_LABEL', ''); //Label do pixel do Adwords (todo o site)


    /*
     * APP LINKS
     * Habilitar ou desabilitar campos de links alternativos
     */
    define('APP_LINK_POSTS', 1); //Posts
    define('APP_LINK_PAGES', 1); //Páginas


    /*
     * ACCOUNT CONFIG
     */
    define('ACC_MANAGER', 1); //Conta de usuários (UI)
    define('ACC_TAG', 'Minha Conta!'); //null para OLÁ {NAME} ou texto (Minha Conta, Meu Cadastro, etc)

    /*
     * COMMENT CONFIG
     */
    define('COMMENT_MODERATE', 1); //Todos os NOVOS comentários ficam ocultos até serem aprovados
    define('COMMENT_ON_POSTS', 1); //Aplica comentários aos posts
    define('COMMENT_ON_PAGES', 1); //Aplica comentários as páginas
    define('COMMENT_ON_PRODUCTS', 1); //Aplica comentários aos produtos
    define('COMMENT_SEND_EMAIL', 1); //Envia e-mails transicionais para usuários sobre comentários
    define('COMMENT_ORDER', 'DESC'); //Ordem de exibição dos comentários (ASC ou DESC)
    define('COMMENT_RESPONSE_ORDER', 'ASC'); //Ordem de exibição das respostas (ASC ou DESC)

    /*
     * ACTIVECAMPAIGN CONFIG
     */
    define('ACTIVE_CAMPAIGN', 0); //Ativa cadastro em newsletter
    define('ACTIVE_CAMPAIGN_URL', 'https://charmefitness1125.api-us1.com'); //URL da conta ActiveCampaign
    define('ACTIVE_CAMPAIGN_KEY', 'edae4cc3d54eed89806d385db428521a4100f687f40ee142bdff68cc407507117aa4850a'); //KEY da conta ActiveCampaign
    define('ACTIVE_CAMPAIGN_LISTS', '1'); //ID das listas separados por vírgula ('1' OU '1,2')
    define('ACTIVE_CAMPAIGN_TAGS', 'Leads'); //Tags separadas por vírgula ('WC' OU 'WC,Mentor')

    /*
    * CONFIGURAÇÕES ACTIVE CAMPAIGN
    */
    define('ACTIVECAMPAIGN_HOST', ""); //Active Host
    define('ACTIVECAMPAIGN_APIKEY', ""); //Active Host
endif;