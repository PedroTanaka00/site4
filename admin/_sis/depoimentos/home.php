<?php
$AdminLevel = LEVEL_WC_TESTIMONIALS;
if (!APP_TESTIMONIALS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

//AUTO DELETE POST TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_TESTIMONIALS, "WHERE test_title IS NULL AND test_content IS NULL and test_status = :st", "st=0");
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-blog">Depoimentos</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="Todos os Depoimentos" href="dashboard.php?wc=depoimentos/home">Depoimentos</a>
        </p>
    </div>
</header>

<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Paginator = new Pager("dashboard.php?wc=depoimentos/home&pg=", '<<', '>>', 5);
    $Paginator->ExePager($Page, 12);

    $Read->FullRead("SELECT * FROM " . DB_TESTIMONIALS . " WHERE 1=1 "
            . "ORDER BY test_status ASC, test_date DESC "
            . "LIMIT :limit OFFSET :offset", "limit={$Paginator->getLimit()}&offset={$Paginator->getOffset()}"
    );
            
    if (!$Read->getResult()):
        $Paginator->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem depoimentos cadastrados {$Admin['user_name']}. Comece agora mesmo criando seu primeiro post!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Testimonials):
            extract($Testimonials);

            $TestCover = ($test_cover && file_exists("./uploads/{$test_cover}") && !is_dir("./uploads/{$test_cover}") ? "{$test_cover}" : 'admin/_img/no_image.jpg');
            $TestStatus = ($test_status == 1 && strtotime($test_date) >= strtotime(date('Y-m-d H:i:s')) ? '<span class="btn btn_blue icon-clock icon-notext wc_tooltip"><span class="wc_tooltip_baloon">Agendado</span></span>' : ($test_status == 1 ? '<span class="btn btn_green icon-checkmark icon-notext wc_tooltip"><span class="wc_tooltip_baloon">Publicado</span></span>' : '<span class="btn btn_yellow icon-warning icon-notext wc_tooltip"><span class="wc_tooltip_baloon">Pendente</span></span>'));
            $test_title = (!empty($test_title) ? $test_title : 'Edite esse rascunho para poder exibir como depoimento em seu site!');

            echo "<article class='box box25 post_single' id='{$test_id}'>           
                <div class='post_single_cover'>
                	<img alt='{$test_title}' title='{$test_title}' src='./tim.php?src={$TestCover}&w=" . IMAGE_W / 2 . "&h=" . IMAGE_H / 2 . "'/>
                    <div class='post_single_status'>
                        {$TestStatus}
                    </div>
                </div>
                <div class='post_single_content wc_normalize_height'>
                    <h1 class='title'>{$test_title}</h1>
                </div>
                <div class='post_single_actions'>
                    <a title='Editar Depoimento' href='dashboard.php?wc=depoimentos/create&id={$test_id}' class='post_single_center icon-pencil btn btn_blue'>Editar</a>
                    <span rel='post_single' class='j_delete_action icon-cancel-circle btn btn_red' id='{$test_id}'>Deletar</span>
                    <span rel='post_single' callback='Testimonials' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='{$test_id}'>Deletar Depoimento?</span>
                </div>
            </article>";
        endforeach;

        $Paginator->ExePaginator(DB_TESTIMONIALS, "WHERE 1=1");
        echo $Paginator->getPaginator();
    endif;
    ?>
</div>