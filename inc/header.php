<!-- Header -->
<header id="header">
	<div class="container header-container">
		<a href="<?= BASE; ?>" class="logo" title="<?= SITE_NAME; ?>">
			<img src="assets/img/weprime2.png" alt="<?= SITE_NAME; ?>" class="logo-image">
		</a>
		<div class="header-right">
			<div class="theme-toggle" id="theme-toggle">
				<i class="fas fa-moon"></i>
			</div>
			<div class="mobile-toggle" id="mobile-toggle">
				<i class="fas fa-bars"></i>
			</div>
		</div>
		<nav id="nav">
			<ul>
				<?php 
					$baseURL = ($URL[0] != 'index') ? BASE . '/' : ""; 
				?>
				<li><a href="<?= $baseURL; ?>#home">Home</a></li>
				<li><a href="<?= $baseURL; ?>#quem-somos">Quem Somos</a></li>
				<li><a href="<?= $baseURL; ?>#nossa-equipe">Equipe</a></li>
				<li><a href="<?= $baseURL; ?>#servicos">Serviços</a></li>
				<li><a href="<?= $baseURL; ?>#precos">Preços</a></li>
				<li><a href="<?= $baseURL; ?>#contato">Contato</a></li>
			</ul>
			<div class="nav-btn">
				<a href="<?= $baseURL; ?>#agendamento" class="btn btn-glow">Agendar</a>
			</div>
		</nav>
	</div>
</header>