<!-- Footer -->
<footer id="footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-col footer-about">
				<h3>Sobre Nós</h3>
				<p>A Estética Renova é uma clínica especializada em tratamentos estéticos faciais e corporais, com foco em resultados naturais e duradouros.</p>
			</div>
			<div class="footer-col footer-links">
				<h3>Links Rápidos</h3>
				<ul>
					<?php 
						$baseURL = ($URL[0] != 'index') ? BASE . '/' : ""; 
					?>
					<li><a href="<?= $baseURL; ?>#home"><i class="fas fa-chevron-right"></i> Home</a></li>
					<li><a href="<?= $baseURL; ?>#quem-somos"><i class="fas fa-chevron-right"></i> Quem Somos</a></li>
					<li><a href="<?= $baseURL; ?>#servicos"><i class="fas fa-chevron-right"></i> Serviços</a></li>
					<li><a href="<?= $baseURL; ?>#especialidades"><i class="fas fa-chevron-right"></i> Especialidades</a></li>
					<li><a href="<?= $baseURL; ?>#precos"><i class="fas fa-chevron-right"></i> Preços</a></li>
					<li><a href="<?= $baseURL; ?>#contato"><i class="fas fa-chevron-right"></i> Contato</a></li>
				</ul>
			</div>
			<div class="footer-col footer-links">
				<h3>Serviços</h3>
				<ul>
					<li><a href="<?= BASE ?>/harmonizacao-facial"><i class="fas fa-chevron-right"></i> Harmonização Facial</a></li>
					<li><a href="<?= BASE ?>/tratamentos-corporais"><i class="fas fa-chevron-right"></i> Tratamentos Corporais</a></li>
					<li><a href="<?= BASE ?>/tratamentos-capilares"><i class="fas fa-chevron-right"></i> Tratamentos Capilares</a></li>
					<li><a href="<?= BASE ?>/nutricao-estetica"><i class="fas fa-chevron-right"></i> Nutrição Estética</a></li>
					<li><a href="<?= BASE ?>/preenchimentos"><i class="fas fa-chevron-right"></i> Preenchimentos</a></li>
				</ul>
			</div>
			<div class="footer-col footer-newsletter">
				<h3>Newsletter</h3>
				<p>Inscreva-se para receber novidades, promoções exclusivas e dicas de beleza.</p>
				<form class="newsletter-form">
					<input type="email" class="newsletter-input" placeholder="Seu e-mail" required>
					<button type="submit" class="newsletter-btn"><i class="fas fa-paper-plane"></i></button>
				</form>
			</div>
		</div>
		<div class="footer-bottom">
			<p>&copy; <?= date("Y"); ?> Estética Renova. Todos os direitos reservados. Desenvolvido por <a href="https://weprimeweb.com/" target="_blank">WePrime Web</a></p>
		</div>
	</div>
</footer>