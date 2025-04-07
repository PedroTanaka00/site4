<?php
$AdminLevel = LEVEL_WC_USERS;
if (!APP_PARTNERS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

//AUTO DELETE USER TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_PARTNERS, "WHERE partner_name IS NULL");
endif;

$Read = new Read;
$Search = filter_input_array(INPUT_POST);
if ($Search && $Search['s']):
    $S = urlencode($Search['s']);
    header("Location: dashboard.php?wc=partners/search&s={$S}");
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-user-tie">Parceiros</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Parceiros
        </p>
    </div>

    <div class="dashboard_header_search">
        <form name="searchPartners" action="" method="post" enctype="multipart/form-data" class="ajax_off">
            <input type="search" name="s" placeholder="Pesquisar Parceiro:" required/>
            <button class="btn btn_green icon icon-search icon-notext"></button>
        </form>
    </div>
</header>
<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Pager = new Pager("dashboard.php?wc=partners/home&page=", "<<", ">>", 5);
    $Pager->ExePager($Page, 12);
    $Read->ExeRead(DB_PARTNERS, "ORDER BY partner_name ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
    if (!$Read->getResult()):
        $Pager->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem parceiros cadastrados {$Admin['user_name']}. Comece agora mesmo cadastrando um novo parceiro. Ou aguarde novos parceiros!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Partners):
            extract($Partners);
            $partner_name = ($partner_name ? $partner_name : 'Novo');
            $partner_lastname = ($partner_lastname ? $partner_lastname : 'Parceiro');
            $PartnerThumb = "./uploads/{$partner_thumb}";
            $partner_thumb = (file_exists($PartnerThumb) && !is_dir($PartnerThumb) ? "{$partner_thumb}" : 'admin/_img/no_avatar.jpg');
            echo "<article class='single_user box box25 al_center'>
                    <div class='box_content'>
                        <img alt='Este é {$partner_name} {$partner_lastname}' title='Este é {$partner_name} {$partner_lastname}' src='./tim.php?src={$partner_thumb}&w=400&h=400'/>
                        <h1>{$partner_name} {$partner_lastname}</h1>
                        <p class='nivel icon-equalizer'>Parceiro</p>
                        <p class='info icon-calendar'>Desde " . date('d/m/Y \a\s H\h\si', strtotime($partner_registration)) . "</p>
                        <a class='btn btn_green icon-user' href='dashboard.php?wc=partners/create&id={$partner_id}' title='Gerenciar Parceiro!'>Gerenciar Parceiro!</a>
                    </div>
                </article>";
        endforeach;
        $Pager->ExePaginator(DB_PARTNERS);
        echo $Pager->getPaginator();
    endif;
    ?>
</div>