<?php
$AdminLevel = 6;
if (empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
$Read = new Read;
endif;
?>
<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-home">Dashboard</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
        </p>
    </div>
</header>

<div class="dashboard_content">


    <?php if (APP_POSTS): ?>
    <div class="box box50 dashboard_mostviews">
        <div class="panel_header dark">
            <h2 class="icon-eye-plus">ÚLTIMOS POSTS:</h2>
        </div>
        <div class="panel">
            <?php
            $Read->ExeRead(DB_POSTS, "WHERE post_status = 1 ORDER BY post_date DESC LIMIT 5");
            if (!$Read->getResult()):
            echo Erro("<span class='icon-info al_center'>Ainda não existem posts cadastrados!</span>", E_USER_NOTICE);
            else:
            foreach ($Read->getResult() as $Post):
                $imagePost = BASE ."/admin/uploads/".$Post['post_cover'];
            echo "
                        <article>
                            <img src='".$imagePost."' title='{$Post['post_title']}' alt='{$Post['post_title']}'/>
                            <div class='info'>
                                <span>{$Post['post_views']} visitas</span>
                                <h1><a href='dashboard.php?wc=posts/create&id={$Post['post_id']}' title='Ver Post'>{$Post['post_title']}</a></h1>
                            </div>
                         </article>
                    ";
            endforeach;
            endif;
            ?>
            <div class="clear"></div>
        </div>
    </div>
    <?php
    endif;
    if (APP_POSTS):
    ?>
    <div class="box box50 dashboard_mostviews">
        <div class="panel_header dark">
            <h2 class="icon-eye-plus">POSTS MAIS VISTOS:</h2>
        </div>
        <div class="panel">
            <?php
            $Read->ExeRead(DB_POSTS, "WHERE post_status = 1 ORDER BY post_views DESC, post_date DESC LIMIT 5");
            if (!$Read->getResult()):
            echo Erro("<span class='icon-info al_center'>Ainda não existem posts cadastrados!</span>", E_USER_NOTICE);
            else:
            foreach ($Read->getResult() as $Post):
                $imagePost = BASE ."/admin/uploads/".$Post['post_cover'];
            echo "
                        <article>
                            <img src='".$imagePost."' title='{$Post['post_title']}' alt='{$Post['post_title']}'/>
                            <div class='info'>
                                <span>{$Post['post_views']} visitas</span>
                                <h1><a href='dashboard.php?wc=posts/create&id={$Post['post_id']}' title='Ver Post'>{$Post['post_title']}</a></h1>
                            </div>
                         </article>
                    ";
            endforeach;
            endif;
            ?>
            <div class="clear"></div>
        </div>
    </div>
    <?php
    endif;
    ?>
</div>



<script>
    //ICON REFRESH IN DASHBOARD
    $('#loopDashboard').click(function () {
        Dashboard();
    });

    //DASHBOARD REALTIME
    setInterval(function () {
        Dashboard();
    }, 10000);
</script>
