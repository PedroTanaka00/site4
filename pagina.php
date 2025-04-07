<?php
$Read->ExeRead(DB_PAGES, "WHERE page_name = :nm", "nm={$URL[0]}");
if (!$Read->getResult()):
    require '404.php';
    return;
else:
    extract($Read->getResult()[0]);

	$imageCover = false;
	if( !empty($page_cover) && file_exists("admin/uploads/" . $page_cover) )
		$imageCover = BASE . "/admin/uploads/" . $page_cover;
endif;
?>

<section id="pagina" class="pagina section-padding">
    <div class="container">
		<div class="pagina-title">
			<h2 class="title-default"><?= $page_title; ?></h2>
		</div>

		<?php if($imageCover): ?>
        <div class="pagina-image">
        	<img src="<?= $imageCover ?>" alt="<?= $page_title; ?>" loading="lazy">
        </div>
		<?php endif; ?>

		<div class="pagina-content">
			<?= $page_content; ?>
		</div>
    </div>
</section>