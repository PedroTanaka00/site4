<?php
$AdminLevel = LEVEL_WC_LEADS;
if (!APP_LEADS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT CREATE
if (empty($Create)):
    $Create = new Create;
endif;

$S = filter_input(INPUT_GET, "s", FILTER_DEFAULT);

$WhereString = (!empty($S) ? " AND lead_nome LIKE '%{$S}%' OR lead_email LIKE '%{$S}%' OR lead_telefone LIKE '%{$S}%' OR lead_id LIKE '%{$S}%' " : "");

$Search = filter_input_array(INPUT_POST);
if ($Search && $Search['s']):
    $S = urlencode($Search['s']);
    header("Location: dashboard.php?wc=leads/home&s={$S}");
    exit;
endif;

$Params = ($WhereString ? "&s={$S}" : null);
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-user-tie">Leads</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=leads/home">Leads</a>
            <span class="crumb">/</span>
            Leads
        </p>
    </div>
    
    <div class="dashboard_header_search w100">
        <form name="searchUsers" action="" method="post" enctype="multipart/form-data" class="ajax_off">
            <input type="search" value="<?= $S; ?>" name="s" placeholder="Pesquisar:" style="width: 10%; margin-right: 3px;" />
            <button class="btn btn_green icon icon-search icon-notext"></button>
            <a href="dashboard.php?wc=leads/home" class="btn btn_yellow icon icon-spinner9 icon-notext"></a>
            <a href="<?= BASE; ?>/admin/_siswc/leads/rel.php?formato=xls<?= $Params; ?>" target="_blank" class="btn btn_blue icon-file-text">Exportar Excel</a>
        </form>
    </div>
</header>

<div class="dashboard_content">

    <div class="box box100">
    	<div class="panel_header default">
            <h2 class="icon-users">Leads</h2>
        </div>
        <div class="panel">            
        	<article class='single_order "box box100 header_blue'>
        		<p class='coll color_white' style="width: 20%;">Nome</p>
        		<p class='coll color_white' style="width: 20%;">Telefone</p>
        		<p class='coll color_white' style="width: 20%;">E-mail</p>
        		<p class='coll color_white' style="width: 20%;">Página</p>
        		<p class='coll color_white' style="width: 20%;">Data</p>
        	</article>
            <?php
            $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
	    	$Page = ($getPage ? $getPage : 1);

			if (!$WhereString) :
				$Pager = new Pager("dashboard.php?wc=leads/home&page=", "<<", ">>", 5);
			else :
				$Pager = new Pager("dashboard.php?wc=leads/home&s={$S}&page=", "<<", ">>", 5);
			endif;
			
			$Pager->ExePager($Page, 30);
		
            $Read->ExeRead(DB_LEADS_SITE, " WHERE 1 = 1 $WhereString ORDER BY lead_dataCadastro DESC, lead_nome ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
            if (!$Read->getResult()):
                $Pager->ReturnPage();
                echo Erro("<span class='al_center icon-notification'>Ainda não existem leads cadastrados {$Admin['user_name']}.</span>", E_USER_NOTICE);
            else:
				foreach ($Read->getResult() as $Leads):
            		extract($Leads);
                    echo "<article class='single_order post_single' id='{$lead_id}' style='float: none;'>
                        <p class='coll' style='width: 20%;'>" . $lead_nome . "</p>
                        <p class='coll' style='width: 20%;'>" . $lead_telefone . "</p>  
                        <p class='coll' style='width: 20%;'>" . $lead_email . "</p>
                        <p class='coll' style='width: 20%;'>" . $lead_pagina . "</p>
                        <p class='coll' style='width: 20%;'>" . date('d/m/Y H:i:s', strtotime($lead_dataCadastro)) . "</p>
                </article>";
                endforeach;
            endif;
			
            $Pager->ExePaginator(DB_LEADS_SITE, " WHERE 1 = 1 $WhereString");
            echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>