<?php
$AdminLevel = 6;
if (!APP_PARTNERS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

$Read = new Read;

$Search = filter_input_array(INPUT_POST);
if ($Search && $Search['s']):
    $S = urlencode($Search['s']);
    header("Location: dashboard.php?wc=partners/search&s={$S}");
endif;

$GetSearch = filter_input(INPUT_GET, 's', FILTER_DEFAULT);
$ThisSearch = urldecode($GetSearch);
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-search">Pesquisar Parceiros</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=partners/home">Parceiros</a>
            <span class="crumb">/</span>
            Pesquisar Parceiros
        </p>
    </div>

    <div class="dashboard_header_search">
        <form name="searchPartnres" action="" method="post" enctype="multipart/form-data" class="ajax_off">
            <input type="search" value="<?= htmlspecialchars($ThisSearch); ?>" name="s" placeholder="Pesquisar Parceiros:" required/>
            <button class="btn btn_green icon icon-search icon-notext"></button>
        </form>
    </div>
</header>
<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Pager = new Pager("dashboard.php?wc=partners/search&s={$GetSearch}&page=", "<<", ">>", 5);
    $Pager->ExePager($Page, 12);
    $Read->ExeRead(DB_PARTNERS, "WHERE partner_name LIKE '%' :s '%' OR partner_lastname LIKE '%' :s '%' OR concat(partner_name, ' ', partner_lastname) LIKE '%' :s '%' OR partner_id LIKE '%' :s '%' ORDER BY partner_name ASC LIMIT :limit OFFSET :offset", "s={$ThisSearch}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
    if (!$Read->getResult()):
        $Pager->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Olá {$Admin['user_name']}. Não foram encontrados parceiros com nome ou ID ligados a <b>{$ThisSearch}</b>, favor tente outros termos!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Partners):
            extract($Partners);
            $PartnerThumb = "./uploads/{$partner_thumb}";
            $partner_thumb = (file_exists($PartnerThumb) && !is_dir($PartnerThumb) ? "uploads/{$partner_thumb}" : 'admin/_img/no_avatar.jpg');
            echo "<article class='single_user box box25 al_center'>
                    <div class='box_content'>
                        <img alt='Este é {$partner_name} {$partner_lastname}' title='Este é {$partner_name} {$partner_lastname}' src='./tim.php?src={$partner_thumb}&w=600&h=600'/>
                        <h1>{$partner_name} {$partner_lastname}</h1>
                        <p class='nivel icon-equalizer'>Parceiro</p>
                        <p class='info icon-calendar'>Desde " . date('d/m/Y \a\s H\h\si', strtotime($partner_registration)) . "</p>
                        <a class='btn btn_green icon-user' href='dashboard.php?wc=partners/create&id={$partner_id}' title='Gerenciar Parceiro!'>Gerenciar Parceiro!</a>
                    </div>
                </article>";
        endforeach;

        $Pager->ExePaginator(DB_PARTNERS, "WHERE partner_name LIKE '%' :s '%'", "s={$GetSearch}");
        echo $Pager->getPaginator();
    endif;
    ?>
</div>