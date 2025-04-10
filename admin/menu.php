<nav class="dashboard_nav">
    <div class="dashboard_nav_admin">
        <!--<img class="dashboard_nav_admin_thumb rounded" alt="" title="" src="./tim.php?src=<?= $Admin['user_thumb']; ?>&w=76&h=76"/>-->
        <img class="" alt="" title="" src="../admin/_img/work_logo_v.png"/>
    </div>


    <ul class="dashboard_nav_menu">
        <li class="dashboard_nav_menu_li <?= $getViewInput == 'home' ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-home" title="Home" href="dashboard.php?wc=home">Home</a></li>

        <?php
        if (APP_POSTS && $_SESSION['userLogin']['user_level'] >= LEVEL_WC_POSTS):
            $wc_posts_alerts = null;
            $Read->FullRead("SELECT count(post_id) as total FROM " . DB_POSTS . " WHERE post_status != 1");
            if ($Read->getResult() && $Read->getResult()[0]['total'] >= 1):
                $wc_posts_alerts .= "<span class='wc_alert bar_yellow'>{$Read->getResult()[0]['total']}</span>";
            endif;
            ?>
            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'posts/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-blog" title="Posts" href="dashboard.php?wc=posts/home">Posts <?= $wc_posts_alerts; ?></a>
                <ul class="dashboard_nav_menu_sub">
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'posts/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Posts" href="dashboard.php?wc=posts/home">&raquo; Ver Posts <?= $wc_posts_alerts; ?></a></li>
                    <li class="dashboard_nav_menu_sub_li <?= strstr($getViewInput, 'posts/categor') ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Categorias" href="dashboard.php?wc=posts/categories">&raquo; Categorias</a></li>
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'posts/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Novo Post" href="dashboard.php?wc=posts/create">&raquo; Novo Post</a></li>
                </ul>
            </li>
            <?php
        endif;


        if (APP_LEADS):
            ?>
            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'leads/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-user-tie" title="Leads" href="dashboard.php?wc=leads/home">Leads</a></li>
            <?php
        endif;

        if (APP_TESTIMONIALS):
            ?>
            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'depoimentos/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-file-text2" title="Depoimentos" href="dashboard.php?wc=depoimentos/home">Depoimentos</a>
                <ul class="dashboard_nav_menu_sub">
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'depoimentos/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Depoimentos" href="dashboard.php?wc=depoimentos/home">&raquo; Ver Depoimentos</a></li>
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'depoimentos/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Novo Depoimento" href="dashboard.php?wc=depoimentos/create">&raquo; Novo Depoimento</a></li>
                </ul>
            </li>
            <?php
        endif;

        if (APP_PARTNERS):
            ?>
            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'partners/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-user-tie" title="Parceiros" href="dashboard.php?wc=partners/home">Parceiros</a>
                <ul class="dashboard_nav_menu_sub">
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'partners/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Parceiros" href="dashboard.php?wc=partners/home">&raquo; Ver Parceiros</a></li>
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'partners/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Novo Parceiros" href="dashboard.php?wc=partners/create">&raquo; Novo Parceiros</a></li>
                </ul>
            </li>
            <?php
        endif;
        
        if (APP_VIDEO):
            $wc_video_alerts = null;
            $Read->FullRead("SELECT count(video_id) as total FROM " . DB_VIDEO . " WHERE video_status != 1");
            if ($Read->getResult() && $Read->getResult()[0]['total'] >= 1):
                $wc_video_alerts .= "<span class='wc_alert btn_yellow'>{$Read->getResult()[0]['total']}</span>";
            endif;
            ?>
            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'video/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-video-camera" title="Vídeos" href="dashboard.php?wc=video/home">Vídeos<?= $wc_video_alerts; ?></a>
                <ul class="dashboard_nav_menu_sub">
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'video/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Vídeos" href="dashboard.php?wc=video/home">&raquo; Vídeos <?= $wc_video_alerts; ?></a></li>
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'video/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Criar Vídeos" href="dashboard.php?wc=video/create">&raquo; Criar Vídeos</a></li>
                </ul>
            </li>
            <?php
        endif;
        ?>

        <?php if (APP_GALLERY):
            $wc_gallery_alerts = null;
            $Read->FullRead("SELECT count(gallery_id) as total FROM " . DB_GALLERY . " WHERE gallery_status != 1");
            if ($Read->getResult() && $Read->getResult()[0]['total'] >= 1):
                $wc_gallery_alerts .= "<span class='wc_alert btn_yellow'>{$Read->getResult()[0]['total']}</span>";
            endif;
            ?>
            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'gallery/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-file-picture" title="Galerias" href="dashboard.php?wc=gallery/home">Galerias<?= $wc_gallery_alerts; ?></a>
                <ul class="dashboard_nav_menu_sub">
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'gallery/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Galerias" href="dashboard.php?wc=gallery/home">&raquo; Galerias <?= $wc_gallery_alerts; ?></a></li>
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'gallery/categories' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Categorias" href="dashboard.php?wc=gallery/categories">&raquo; Categorias</a></li>
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'gallery/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Criar Galeria" href="dashboard.php?wc=gallery/create">&raquo; Criar Galeria</a></li>
                </ul>
            </li>
            <?php
        endif;
        

        if (APP_PAGES && $_SESSION['userLogin']['user_level'] >= LEVEL_WC_PAGES):
            $wc_pages_alerts = null;
            $Read->FullRead("SELECT count(page_id) as total FROM " . DB_PAGES . " WHERE page_status != 1");
            if ($Read->getResult() && $Read->getResult()[0]['total'] >= 1):
                $wc_pages_alerts .= "<span class='wc_alert bar_yellow'>{$Read->getResult()[0]['total']}</span>";
            endif;
            ?>
            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'pages/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-pagebreak" title="Páginas" href="dashboard.php?wc=pages/home">Páginas<?= $wc_pages_alerts; ?></a></li>
            <?php
        endif;

        if (APP_USERS && $_SESSION['userLogin']['user_level'] >= LEVEL_WC_USERS):
            ?>
            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'team/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-user-minus" title="Equipe" href="dashboard.php?wc=team/home">Equipe</a>
                <ul class="dashboard_nav_menu_sub">
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'team/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Profissionais" href="dashboard.php?wc=team/home">&raquo; Ver Profissionais</a></li>
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'team/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Novo Profissional" href="dashboard.php?wc=team/create">&raquo; Novo Profissional</a></li>
                </ul>
            </li>

            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'users/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-users" title="Usuários" href="dashboard.php?wc=users/home">Usuários</a>
                <ul class="dashboard_nav_menu_sub">
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'users/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Usuários" href="dashboard.php?wc=users/home">&raquo; Ver Usuários</a></li>
                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'users/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Novo Usuário" href="dashboard.php?wc=users/create">&raquo; Novo Usuário</a></li>
                </ul>
            </li>
            <?php
        endif;
        ?>

        <li class="dashboard_nav_menu_li"><a target="_blank" class="icon-forward" title="Ver Site" href="<?= BASE; ?>">Ver Site</a></li>
    </ul>

    <div class="dashboard_nav_normalize"></div>        
</nav>