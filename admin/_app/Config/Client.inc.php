<?php

if (!$WorkControlDefineConf):

    /**
     * TAG GTM E RECAPTCHA DO SITE
     */
    define("GTM_ID", "");
    define('RECAPTCHA_SITE', '6LcfhN8pAAAAAK6z0t8PFAL_YysOLuWfpvqBR1Zf');
    define('RECAPTCHA_SECRET', '6LcfhN8pAAAAAIEVJ1gWkmipitpQAcvhWi-Zxvrd');


    /*
     * SITE CONFIG
     */
    define('SITE_NAME', 'Estética Prime'); //Nome do site do cliente
    define('SITE_SUBNAME', 'Estética Prime'); //Nome do site do cliente
    define('SITE_DESC', 'Nossa clínica possui uma infraestrutura moderna e completa.'); //Descrição do site do cliente

    define('SITE_FONT_NAME', 'Open Sans'); //Tipografia do site (https://www.google.com/fonts)
    define('SITE_FONT_WHIGHT', '300,400,600,700,800'); //Tipografia do site (https://www.google.com/fonts)

    /*
     * SHIP CONFIG
     * DADOS DO SEU CLIENTE/DONO DO SITE
     */
    define('SITE_ADDR_NAME', 'Estética Prime'); //Nome de remetente
    define('SITE_ADDR_RS', 'Estética Prime'); //Razão Social
    define('SITE_ADDR_EMAIL', 'contato@esteticaprime.com.br'); //E-mail de contato
    define('SITE_ADDR_SITE', 'www.esteticaprime.com.br'); //URL descrita
    define('SITE_ADDR_CNPJ', ''); //CNPJ da empresa
    define('SITE_ADDR_IE', ''); //Inscrição estadual da empresa
    define('SITE_ADDR_PHONE_A', '(11) 3456-7890'); //Telefone 1
    define('SITE_ADDR_PHONE_B', '(11) 98765-4321'); //Telefone 2
    define('SITE_ADDR_ADDR', 'Av. Paulista, 1000 - Bela Vista, São Paulo - SP'); //ENDEREÇO: rua, número (complemento)
    define('SITE_ADDR_CITY', ''); //ENDEREÇO: cidade
    define('SITE_ADDR_DISTRICT', ''); //ENDEREÇO: bairro
    define('SITE_ADDR_UF', ''); //ENDEREÇO: UF do estado
    define('SITE_ADDR_ZIP', ''); //ENDEREÇO: CEP
    define('SITE_ADDR_COUNTRY', ''); //ENDEREÇO: País
    define('SITE_HOURS_SERVICE', 'Segunda a Sexta: 9h às 20h | Sábado: 9h às 14h'); //Descrição do horário de atendimento
    define('SITE_WHATSAPP_NUMBER', '19999998888'); //WhatsApp 
    define('SITE_WHATSAPP_DESC', "Olá *Estética Prime*!"); //WhatsApp 




    /**
     * Social Config
     */
    define('SITE_SOCIAL_NAME', 'WePrimeWeb Developers');
    /*
     * Google
     */
    define('SITE_SOCIAL_GOOGLE', 0);
    define('SITE_SOCIAL_GOOGLE_AUTHOR', ''); //https://plus.google.com/????? (**ID DO USUÁRIO)
    define('SITE_SOCIAL_GOOGLE_PAGE', ''); //https://plus.google.com/???? (**ID DA PÁGINA)
    /*
     * Facebook
     */
    define('SITE_SOCIAL_FB', 1);
    define('SITE_SOCIAL_FB_APP', 0); //Opcional APP do facebook
    define('SITE_SOCIAL_FB_AUTHOR', ''); //https://www.facebook.com/?????
    define('SITE_SOCIAL_FB_PAGE', 'https://www.facebook.com/'); //https://www.facebook.com/?????
    define('SITE_SOCIAL_TWITTER', ''); //https://www.twitter.com/?????
    define('SITE_SOCIAL_YOUTUBE', 'https://www.youtube.com/'); //https://www.youtube.com/user/?????
    define('SITE_SOCIAL_INSTAGRAM', 'https://www.instagram.com/'); //https://www.instagram.com/?????
    define('SITE_SOCIAL_TIKTOK', 'https://www.tiktok.com/pt-BR/'); //https://www.snapchat.com/add/?????
endif;
