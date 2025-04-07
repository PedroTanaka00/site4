<!-- Home Section -->
<section id="home">
    <div class="container">
        <div class="home-content">
            <div class="home-text">
                <h1>Transforme sua beleza e aumente sua <span id="typing-text">autoestima</span></h1>
                <p>Na Estética Renova, combinamos tecnologia avançada e profissionais especializados para oferecer tratamentos estéticos personalizados que realçam sua beleza natural.</p>
                <div class="home-btns">
                    <a href="#servicos" class="btn">Nossos Serviços</a>
                    <a href="#contato" class="btn btn-outline">Fale Conosco</a>
                </div>
            </div>
        </div>
        
        <div class="home-icons">
            <div class="icon-item" data-delay="0">
                <div class="icon-circle">
                    <i class="fas fa-spa"></i>
                </div>
                <div class="icon-line"></div>
            </div>
            <div class="icon-item" data-delay="0.2">
                <div class="icon-circle">
                    <i class="fas fa-syringe"></i>
                </div>
                <div class="icon-line"></div>
            </div>
            <div class="icon-item" data-delay="0.4">
                <div class="icon-circle">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="icon-line"></div>
            </div>
            <div class="icon-item" data-delay="0.6">
                <div class="icon-circle">
                    <i class="fas fa-magic"></i>
                </div>
                <div class="icon-line"></div>
            </div>
            <div class="icon-item" data-delay="0.8">
                <div class="icon-circle">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="icon-line"></div>
            </div>
            <div class="icon-item" data-delay="1.0">
                <div class="icon-circle">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="icon-line"></div>
            </div>
            <div class="icon-item" data-delay="1.2">
                <div class="icon-circle">
                    <i class="fas fa-hand-sparkles"></i>
                </div>
                <div class="icon-line"></div>
            </div>
            <div class="icon-item" data-delay="1.4">
                <div class="icon-circle">
                    <i class="fas fa-mortar-pestle"></i>
                </div>
                <div class="icon-line"></div>
            </div>
            <div class="icon-item" data-delay="1.6">
                <div class="icon-circle">
                    <i class="fas fa-pump-soap"></i>
                </div>
                <div class="icon-line"></div>
            </div>
        </div>
    </div>
</section>


<!-- Quem Somos -->
<?php 
$Read->FullRead("SELECT page_subtitle, page_content, page_cover FROM ws_pages WHERE page_name = 'quem-somos' AND page_status = 1");
if($Read->getResult()):
    extract($Read->getResult()[0]);
?>
<section id="quem-somos" class="section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Quem Somos</h2>
            <p>Conheça nossa história e compromisso com a excelência em estética médica</p>
        </div>
        <div class="quem-somos-grid">
            <?php if( !empty($page_cover) && file_exists("admin/uploads/" . $page_cover) ): ?>
            <div class="quem-somos-image shimmer">
                <img src="<?= BASE ?>/admin/uploads/<?= $page_cover; ?>" alt="Nossa clínica">
            </div>
            <?php endif; ?>

            <div class="quem-somos-content">
                <h2><?= $page_subtitle; ?></h2>
                <?= $page_content; ?>
                <div class="quem-somos-stats">
                    <div class="stat-item animate-pulse">
                        <i class="fas fa-user-md"></i>
                        <h3>15+</h3>
                        <p>Especialistas</p>
                    </div>
                    <div class="stat-item animate-pulse">
                        <i class="fas fa-smile"></i>
                        <h3>5000+</h3>
                        <p>Clientes Satisfeitos</p>
                    </div>
                    <div class="stat-item animate-pulse">
                        <i class="fas fa-award"></i>
                        <h3>12+</h3>
                        <p>Anos de Experiência</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


    <!-- Nossa Equipe -->
    <section id="nossa-equipe" class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Nossa Equipe</h2>
                <p>Conheça os profissionais dedicados a cuidar da sua beleza e bem-estar</p>
            </div>
            <div class="team-grid">
                <div class="team-member">
                    <div class="team-image">
                        <img src="/placeholder.svg?height=300&width=300" alt="Dra. Mariana Silva">
                    </div>
                    <div class="team-info">
                        <h3>Dra. Mariana Silva</h3>
                        <p>Diretora Clínica</p>
                        <div class="team-bio">
                            Especialista em Dermatologia Estética com mais de 15 anos de experiência. Formada pela USP com especializações internacionais.
                        </div>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-member">
                    <div class="team-image">
                        <img src="/placeholder.svg?height=300&width=300" alt="Dr. Rafael Mendes">
                    </div>
                    <div class="team-info">
                        <h3>Dr. Rafael Mendes</h3>
                        <p>Cirurgião Plástico</p>
                        <div class="team-bio">
                            Especialista em procedimentos minimamente invasivos. Membro da Sociedade Brasileira de Cirurgia Plástica.
                        </div>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-member">
                    <div class="team-image">
                        <img src="/placeholder.svg?height=300&width=300" alt="Dra. Camila Rocha">
                    </div>
                    <div class="team-info">
                        <h3>Dra. Camila Rocha</h3>
                        <p>Dermatologista</p>
                        <div class="team-bio">
                            Especialista em tratamentos faciais e corporais. Pós-graduada em Dermatologia Avançada.
                        </div>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Serviços -->
    <section id="servicos" class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Nossos Serviços</h2>
                <p>Oferecemos uma ampla gama de tratamentos estéticos para rosto e corpo</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <h3 class="service-title">Tratamentos Faciais</h3>
                    <p class="service-desc">Rejuvenescimento, limpeza de pele profunda, microagulhamento, peelings e muito mais para uma pele radiante.</p>
                    <a href="<?= BASE ?>/tratamentos-faciais" class="service-link">Saiba mais <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-venus"></i>
                    </div>
                    <h3 class="service-title">Tratamentos Corporais</h3>
                    <p class="service-desc">Redução de medidas, combate à celulite, flacidez e gordura localizada com tecnologia avançada.</p>
                    <a href="<?= BASE ?>/tratamentos-corporais" class="service-link">Saiba mais <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-syringe"></i>
                    </div>
                    <h3 class="service-title">Preenchimentos</h3>
                    <p class="service-desc">Preenchimento labial, de olheiras, bigode chinês e outras áreas para um visual mais jovem e harmonioso.</p>
                    <a href="<?= BASE ?>/preenchimentos" class="service-link">Saiba mais <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="service-title">Toxina Botulínica</h3>
                    <p class="service-desc">Aplicação precisa para suavizar rugas e linhas de expressão, proporcionando um aspecto natural.</p>
                    <a href="<?= BASE ?>/toxina-botulinica" class="service-link">Saiba mais <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-tint"></i>
                    </div>
                    <h3 class="service-title">Bioestimuladores</h3>
                    <p class="service-desc">Estimulação da produção de colágeno para combater a flacidez e melhorar a qualidade da pele.</p>
                    <a href="<?= BASE ?>/bioestimuladores" class="service-link">Saiba mais <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-magic"></i>
                    </div>
                    <h3 class="service-title">Harmonização Facial</h3>
                    <p class="service-desc">Procedimentos combinados para equilibrar e valorizar os traços do rosto de forma personalizada.</p>
                    <a href="<?= BASE ?>/harmonizacao-facial" class="service-link">Saiba mais <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Especialidades -->
    <section id="especialidades" class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Nossas Especialidades</h2>
                <p>Conheça as áreas em que somos referência no mercado de estética médica</p>
            </div>
            <div class="especialidades-tabs">
                <button class="tab-btn active" data-tab="tab1">Facial</button>
                <button class="tab-btn" data-tab="tab2">Corporal</button>
                <button class="tab-btn" data-tab="tab3">Capilar</button>
                <button class="tab-btn" data-tab="tab4">Nutrição</button>
            </div>
            <div class="tab-content active" id="tab1">
                <div class="especialidade-grid">
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Rejuvenescimento Facial">
                        </div>
                        <div class="especialidade-info">
                            <h3>Rejuvenescimento Facial</h3>
                            <p>Combinação de técnicas para reduzir sinais de envelhecimento e devolver a jovialidade à pele.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Laser Fracionado</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Radiofrequência</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Bioestimuladores</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Harmonização Facial">
                        </div>
                        <div class="especialidade-info">
                            <h3>Harmonização Facial</h3>
                            <p>Procedimentos que valorizam os traços naturais do rosto, criando proporções harmônicas.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Preenchimentos</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Toxina Botulínica</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Fios de PDO</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Tratamento de Acne">
                        </div>
                        <div class="especialidade-info">
                            <h3>Tratamento de Acne</h3>
                            <p>Protocolos específicos para controlar a acne ativa e reduzir cicatrizes.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Peeling Químico</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>LED Terapia</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Microagulhamento</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="tab2">
                <div class="especialidade-grid">
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Redução de Medidas">
                        </div>
                        <div class="especialidade-info">
                            <h3>Redução de Medidas</h3>
                            <p>Tratamentos eficazes para eliminar gordura localizada e reduzir o contorno corporal.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Criolipólise</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Ultrassom Focalizado</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Radiofrequência</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Combate à Celulite">
                        </div>
                        <div class="especialidade-info">
                            <h3>Combate à Celulite</h3>
                            <p>Protocolos avançados para reduzir a aparência da celulite e melhorar a textura da pele.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Carboxiterapia</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Intradermoterapia</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Ondas de Choque</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Flacidez Corporal">
                        </div>
                        <div class="especialidade-info">
                            <h3>Flacidez Corporal</h3>
                            <p>Tratamentos que estimulam o colágeno e melhoram a firmeza da pele em diversas áreas do corpo.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Radiofrequência</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>HIFU Corporal</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Bioestimuladores</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="tab3">
                <div class="especialidade-grid">
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Queda Capilar">
                        </div>
                        <div class="especialidade-info">
                            <h3>Tratamento para Queda</h3>
                            <p>Protocolos personalizados para combater a queda de cabelo e estimular o crescimento capilar.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Laser de Baixa Potência</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Intradermoterapia Capilar</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Plasma Rico em Plaquetas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Microimplante Capilar">
                        </div>
                        <div class="especialidade-info">
                            <h3>Microimplante Capilar</h3>
                            <p>Técnica avançada para restauração capilar com resultados naturais e duradouros.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Técnica FUE</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Implante Folicular</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Recuperação Rápida</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Tratamentos Capilares">
                        </div>
                        <div class="especialidade-info">
                            <h3>Tratamentos Capilares</h3>
                            <p>Cuidados específicos para diferentes tipos de cabelo e couro cabeludo.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Hidratação Profunda</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Tratamento para Caspa</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Reconstrução Capilar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="tab4">
                <div class="especialidade-grid">
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Nutrição Estética">
                        </div>
                        <div class="especialidade-info">
                            <h3>Nutrição Estética</h3>
                            <p>Planos alimentares personalizados que complementam os tratamentos estéticos e potencializam resultados.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Avaliação Nutricional</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Plano Alimentar Personalizado</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Suplementação Específica</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Emagrecimento">
                        </div>
                        <div class="especialidade-info">
                            <h3>Emagrecimento Saudável</h3>
                            <p>Programas completos para perda de peso com acompanhamento nutricional e estético.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Reeducação Alimentar</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Bioimpedância</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Acompanhamento Contínuo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="especialidade-card">
                        <div class="especialidade-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Nutrição Funcional">
                        </div>
                        <div class="especialidade-info">
                            <h3>Nutrição Funcional</h3>
                            <p>Abordagem que trata o organismo como um todo, melhorando a saúde e refletindo na beleza.</p>
                            <div class="especialidade-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Alimentos Funcionais</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Detox Nutricional</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Nutrição Anti-aging</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Processo de Agendamento -->
    <section id="agendamento" class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Processo de Agendamento</h2>
                <p>Conheça o passo a passo para iniciar seu tratamento na Estética Renova</p>
            </div>
            <div class="process-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Contato Inicial</h3>
                    <p class="step-desc">Entre em contato por telefone, WhatsApp ou formulário online para agendar sua avaliação.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Avaliação</h3>
                    <p class="step-desc">Consulta detalhada para entender suas necessidades e definir o melhor tratamento.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Plano Personalizado</h3>
                    <p class="step-desc">Desenvolvimento de um protocolo exclusivo para atingir seus objetivos estéticos.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3 class="step-title">Início do Tratamento</h3>
                    <p class="step-desc">Realização das sessões conforme o cronograma estabelecido na avaliação.</p>
                </div>
            </div>
            <div class="agendamento-cta">
                <div class="cta-card">
                    <div class="cta-glow"></div>
                    <div class="cta-content">
                        <div class="cta-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3>Transforme sua aparência hoje!</h3>
                        <p>Agende agora mesmo sua avaliação gratuita e dê o primeiro passo para realçar sua beleza natural com tratamentos personalizados.</p>
                        <div class="cta-countdown">
                            <div class="countdown-item">
                                <span id="countdown-days">0</span>
                                <span>Dias</span>
                            </div>
                            <div class="countdown-item">
                                <span id="countdown-hours">0</span>
                                <span>Horas</span>
                            </div>
                            <div class="countdown-item">
                                <span id="countdown-minutes">0</span>
                                <span>Minutos</span>
                            </div>
                            <div class="countdown-item">
                                <span id="countdown-seconds">0</span>
                                <span>Segundos</span>
                            </div>
                        </div>
                        <p class="cta-limited">Promoção por tempo limitado!</p>
                        <a href="#contato" class="btn btn-cta">Agendar Avaliação Gratuita</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Preços -->
    <section id="precos" class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Nossos Preços</h2>
                <p>Investimento em tratamentos de qualidade para sua beleza e autoestima</p>
            </div>
            <div class="pricing-toggle">
                <span class="toggle-label toggle-monthly">Sessão Única</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="pricing-toggle">
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Pacote</span>
            </div>
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3 class="pricing-title">Tratamentos Faciais</h3>
                        <div class="pricing-price">R$250<span>/sessão</span></div>
                        <p class="pricing-description">Tratamentos básicos para cuidados faciais</p>
                    </div>
                    <div class="pricing-features">
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Limpeza de Pele Profunda</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Hidratação Facial</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Peeling Superficial</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Máscara LED</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-times"></i>
                            <span>Radiofrequência Facial</span>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="#contato" class="btn btn-outline">Agendar Agora</a>
                    </div>
                </div>
                <div class="pricing-card featured">
                    <div class="pricing-header">
                        <h3 class="pricing-title">Harmonização Facial</h3>
                        <div class="pricing-price">R$1200<span>/sessão</span></div>
                        <p class="pricing-description">Procedimentos avançados para rejuvenescimento</p>
                    </div>
                    <div class="pricing-features">
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Toxina Botulínica</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Preenchimento com Ácido Hialurônico</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Bioestimuladores de Colágeno</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Fios de PDO</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Avaliação e Acompanhamento</span>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="#contato" class="btn">Agendar Agora</a>
                    </div>
                </div>
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3 class="pricing-title">Tratamentos Corporais</h3>
                        <div class="pricing-price">R$350<span>/sessão</span></div>
                        <p class="pricing-description">Procedimentos para modelagem corporal</p>
                    </div>
                    <div class="pricing-features">
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Drenagem Linfática</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Massagem Modeladora</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Radiofrequência Corporal</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-check"></i>
                            <span>Ultrassom</span>
                        </div>
                        <div class="pricing-feature">
                            <i class="fas fa-times"></i>
                            <span>Criolipólise</span>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="#contato" class="btn btn-outline">Agendar Agora</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Para Quem Atendemos -->
    <section id="para-quem" class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Para Quem Atendemos</h2>
                <p>Nossos tratamentos são personalizados para atender diferentes perfis e necessidades</p>
            </div>
            <div class="clients-grid">
                <div class="client-card">
                    <div class="client-icon">
                        <i class="fas fa-female"></i>
                    </div>
                    <h3 class="client-title">Mulheres</h3>
                    <p class="client-desc">Tratamentos faciais e corporais específicos para as necessidades femininas, desde o rejuvenescimento até o combate à celulite.</p>
                </div>
                <div class="client-card">
                    <div class="client-icon">
                        <i class="fas fa-male"></i>
                    </div>
                    <h3 class="client-title">Homens</h3>
                    <p class="client-desc">Protocolos adaptados para a pele masculina, incluindo tratamentos para calvície, rugas e definição corporal.</p>
                </div>
                <div class="client-card">
                    <div class="client-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="client-title">Jovens Adultos</h3>
                    <p class="client-desc">Tratamentos preventivos e corretivos para acne, manchas e primeiros sinais de envelhecimento.</p>
                </div>
                <div class="client-card">
                    <div class="client-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="client-title">Executivos</h3>
                    <p class="client-desc">Procedimentos rápidos e eficazes que se encaixam na agenda ocupada de profissionais que buscam aparência rejuvenescida.</p>
                </div>
                <div class="client-card">
                    <div class="client-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3 class="client-title">Casais</h3>
                    <p class="client-desc">Pacotes especiais para casais que desejam cuidar da aparência juntos, com descontos exclusivos.</p>
                </div>
                <div class="client-card">
                    <div class="client-icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <h3 class="client-title">Terceira Idade</h3>
                    <p class="client-desc">Tratamentos suaves e eficazes para peles maduras, com foco no conforto e resultados naturais.</p>
                </div>
            </div>


            <?php 
            $Read->FullRead("SELECT test_title, test_author, test_content, test_cover FROM ws_testimonial WHERE test_status = 1 ORDER BY test_id DESC");
            if($Read->getResult()):
            ?>
            <div class="testimonials">
                <div class="section-title">
                    <h2>Depoimentos</h2>
                    <p>O que nossos clientes dizem sobre nós</p>
                </div>
                <div class="testimonial-carousel">
                    <div class="testimonial-track" id="testimonial-track">
                        <?php 
                        foreach($Read->getResult() as $depoimento): 
                            $fisrtLetter = strtoupper(substr($depoimento['test_title'], 0, 1));
                        ?>
                        <div class="testimonial-slide">
                            <div class="testimonial-card">
                                <p class="testimonial-text"><?= $depoimento['test_content'] ?></p>
                                <div class="testimonial-author">
                                    <div class="testimonial-avatar">
                                        <span><?= $fisrtLetter; ?></span>
                                    </div>
                                    <div class="testimonial-info">
                                        <h4><?= $depoimento['test_title'] ?></h4>
                                        <p><?= $depoimento['test_author'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="testimonial-controls">
                        <button class="testimonial-btn" id="prev-testimonial">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="testimonial-btn" id="next-testimonial">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- Contato -->
    <section id="contato" class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Entre em Contato</h2>
                <p>Estamos prontos para atender você e esclarecer todas as suas dúvidas</p>
            </div>
            <div class="contato-grid">
                <div class="contato-info">
                    <h2>Vamos conversar sobre sua transformação</h2>
                    <p>Entre em contato conosco para agendar sua avaliação gratuita ou esclarecer dúvidas sobre nossos tratamentos. Nossa equipe está pronta para atendê-lo com toda atenção que você merece.</p>
                    <div class="contato-item">
                        <div class="contato-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contato-text">
                            <h4>Endereço</h4>
                            <p><?= SITE_ADDR_ADDR; ?></p>
                        </div>
                    </div>
                    <div class="contato-item">
                        <div class="contato-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contato-text">
                            <h4>Telefone</h4>
                            <p><?= SITE_ADDR_PHONE_A; ?> / <?= SITE_ADDR_PHONE_B; ?></p>
                        </div>
                    </div>
                    <div class="contato-item">
                        <div class="contato-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contato-text">
                            <h4>E-mail</h4>
                            <p><?= SITE_ADDR_EMAIL; ?></p>
                        </div>
                    </div>
                    <div class="contato-item">
                        <div class="contato-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contato-text">
                            <h4>Horário de Funcionamento</h4>
                            <p><?= SITE_HOURS_SERVICE; ?></p>
                        </div>
                    </div>
                    <div class="contato-social">
                        <a href="<?= SITE_SOCIAL_INSTAGRAM; ?>"><i class="fab fa-instagram"></i></a>
                        <a href="<?= SITE_SOCIAL_FB_PAGE; ?>"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://wa.me/55<?= SITE_WHATSAPP_NUMBER; ?>"><i class="fab fa-whatsapp"></i></a>
                        <a href="<?= SITE_SOCIAL_YOUTUBE; ?>"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="contato-form">
                    <form id="contact-form">
                        <div class="form-group">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" id="name" class="form-control" placeholder="Seu nome completo" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" id="email" class="form-control" placeholder="Seu melhor e-mail" required>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="tel" id="phone" class="form-control" placeholder="(00) 00000-0000" required>
                        </div>
                        <div class="form-group">
                            <label for="service" class="form-label">Serviço de Interesse</label>
                            <select id="service" class="form-control" required>
                                <option value="">Selecione um serviço</option>
                                <option value="facial">Tratamentos Faciais</option>
                                <option value="corporal">Tratamentos Corporais</option>
                                <option value="harmonizacao">Harmonização Facial</option>
                                <option value="capilar">Tratamentos Capilares</option>
                                <option value="nutricao">Nutrição Estética</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message" class="form-label">Mensagem</label>
                            <textarea id="message" class="form-control" placeholder="Descreva o que você procura ou suas dúvidas" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary">Enviar Mensagem</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    

