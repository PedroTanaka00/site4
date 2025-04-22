<?php
ob_start();
session_start();

require 'admin/_app/Config.inc.php';

//READ CLASS AUTO INSTANCE
if (empty($Read)):
    $Read = new Read;
endif;

$Sesssion = new Session(SIS_CACHE_TIME);

//USER SESSION VALIDATION
if (!empty($_SESSION['userLogin']) && !empty($_SESSION['userLogin']['user_id'])):
    if (empty($Read)):
        $Read = new Read;
    endif;
    $Read->ExeRead(DB_USERS, "WHERE user_id = :user_id", "user_id={$_SESSION['userLogin']['user_id']}");
    if ($Read->getResult()):
        $_SESSION['userLogin'] = $Read->getResult()[0];
    else:
        unset($_SESSION['userLogin']);
    endif;
endif;

//GET PARAMETER URL
$getURL = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT)));
$setURL = (empty($getURL) ? 'index' : $getURL);
$URL = explode('/', $setURL);
$SEO = new Seo($setURL);

//CHECK IF THIS POST ABLE TO AMP
if (APP_POSTS_AMP && (!empty($URL[0]) && $URL[0] == 'artigo') && file_exists('./amp.php')):
    $Read->ExeRead(DB_POSTS, "WHERE post_name = :name", "name={$URL[1]}");
    $PostAmp = ($Read->getResult()[0]['post_amp'] == 1 ? true : false);
endif;

//INSTANCE AMP (valid single article only)
if (APP_POSTS_AMP && (!empty($URL[0]) && $URL[0] == 'artigo') && file_exists('./amp.php') && (!empty($URL[2]) && $URL[2] == 'amp') && (!empty($PostAmp) && $PostAmp == true)):
    require './amp.php';
else:
?>
<!DOCTYPE html>
<html lang="pt-BR" class="light-theme" itemscope itemtype="https://schema.org/<?= $SEO->getSchema(); ?>">
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $SEO->getTitle(); ?></title>

        <meta name="description" content="<?= $SEO->getDescription(); ?>"/>
        <meta name="author" content="WePrimeWeb Developers">

        <meta name="robots" content="index, follow"/>

        <meta itemprop="name" content="<?= $SEO->getTitle(); ?>"/>
        <meta itemprop="description" content="<?= $SEO->getDescription(); ?>"/>
        <meta itemprop="image" content="<?= BASE; ?>/assets/img/social-share.jpg"/>
        <meta itemprop="url" content="<?= BASE; ?>/<?= $getURL; ?>"/>
        
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?= $SEO->getTitle(); ?>" />
        <meta property="og:description" content="<?= $SEO->getDescription(); ?>" />
        <meta property="og:image" content="<?= BASE; ?>/assets/img/social-share.jpg" />
        <meta property="og:url" content="<?= BASE; ?>/<?= $getURL; ?>" />
        <meta property="og:site_name" content="<?= SITE_NAME; ?>" />
        <meta property="og:locale" content="pt_BR" />

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?= $SEO->getTitle(); ?>">
        <meta name="twitter:description" content="<?= $SEO->getDescription(); ?>">
        <meta name="twitter:image" content="<?= BASE; ?>/assets/img/social-share.jpg">

        <link rel="shortcut icon" href="<?= BASE; ?>/favicon.ico" type="image/x-icon" />
        <link rel="base" href="<?= BASE; ?>"/>
        <link rel="canonical" href="<?= BASE; ?>">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="<?= BASE; ?>/assets/css/style.css">
        <link rel="stylesheet" href="<?= BASE; ?>/assets/css/page.css">

        <script>
            const baseUrl = "<?= BASE; ?>";
        </script>
	</head>

	<body>
        <!-- Popup que sera renderizado ao enviar o formulario de contato -->
        <div id="popup" class="popup">
            <div id="progressBar" class="progress-bar"></div>
            <p></p>
        </div>
        

        <?php		
        /**
         * ----------------------------------------------------------------
         * HEADER - Carrega o cabeçalho do site
         * ----------------------------------------------------------------
         */
        if (file_exists("./inc/header.php")):
            require "./inc/header.php";
        else:
            trigger_error('Crie um arquivo /inc/header.php na pasta do tema!');
        endif;
			
			
			 
        /**
         * ----------------------------------------------------------------
         * CONTENT - Carrega o conteúdo do site
         * ----------------------------------------------------------------
         */
        $URL[1] = (empty($URL[1]) ? null : $URL[1]);

        $Pages = array();
        $Read->FullRead("SELECT page_name FROM " . DB_PAGES);
        if ($Read->getResult()):
            foreach ($Read->getResult() as $SinglePage):
                $Pages[] = $SinglePage['page_name'];
            endforeach;
        endif;
        
        // Checa se a URL está vazia ou é 'home' para carregar 'home.php'
        if ($URL[0] == 'index') :
            if (file_exists('home.php')) :
                require 'home.php';
            else:
                trigger_error("Não foi possível encontrar o arquivo <b>home.php</b>");
            endif;
        else:
            if (in_array($URL[0], $Pages) && file_exists('pagina.php')):
                if (file_exists("/page-{$URL[0]}.php")):
                    require "page-{$URL[0]}.php";
                else:
                    require  'pagina.php';
                endif;

            elseif (file_exists($URL[0] . '.php')):
                if ($URL[0] == 'artigos' && file_exists("cat-{$URL[1]}.php")):
                    require "cat-{$URL[1]}.php";
                else:
                    require $URL[0] . '.php';
                endif;
            elseif (file_exists($URL[0] . '/' . $URL[1] . '.php')):
                require $URL[0] . '/' . $URL[1] . '.php';
            else:
                if (file_exists("404.php")):
                    require '404.php';
                else:
                    trigger_error("Não foi possível incluir o arquivo <b>(404.php)</b>");
                endif;
            endif;
        endif;
			
			
			
        /**
         * ----------------------------------------------------------------
         * FOOTER - Carrega o rodapé do site
         * ----------------------------------------------------------------
         */
        if (file_exists("./inc/footer.php")):
            require "./inc/footer.php";
        else:
            trigger_error('Crie um arquivo /inc/footer.php na pasta do tema!');
        endif;
        ?>
		
		
		
        <script src="<?= BASE; ?>/assets/js/script.js"></script>
	</body>
</html>
<?php
endif;
ob_end_flush();
