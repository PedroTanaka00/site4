// Elementos DOM
const themeToggle = document.getElementById('theme-toggle');
const htmlElement = document.documentElement;
const mobileToggle = document.getElementById('mobile-toggle');
const nav = document.getElementById('nav');
const header = document.getElementById('header');

// Função para alternar o tema
function toggleTheme() {
    // Adiciona classe de transição para suavizar a mudança
    document.body.classList.add('theme-transitioning');
    
    // Alterna entre os temas
    if (htmlElement.classList.contains('dark-theme')) {
        htmlElement.classList.remove('dark-theme');
        localStorage.setItem('theme', 'light');
        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
    } else {
        htmlElement.classList.add('dark-theme');
        localStorage.setItem('theme', 'dark');
        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
    }
    
    // Remove a classe de transição após a conclusão
    setTimeout(() => {
        document.body.classList.remove('theme-transitioning');
    }, 500);
}

// Evento de clique no botão de alternância de tema
themeToggle.addEventListener('click', toggleTheme);

// Carrega o tema preferido do usuário
document.addEventListener('DOMContentLoaded', () => {
    // Verifica se há uma preferência salva
    const savedTheme = localStorage.getItem('theme');
    
    // Verifica a preferência do sistema
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    // Aplica o tema salvo ou a preferência do sistema
    if (savedTheme === 'dark' || (!savedTheme && prefersDarkScheme)) {
        htmlElement.classList.add('dark-theme');
        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
    } else {
        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
    }
});

// Mobile Menu Toggle
mobileToggle.addEventListener('click', () => {
    nav.classList.toggle('active');
    mobileToggle.classList.toggle('active');
    
    // Alterna o ícone do menu
    if (mobileToggle.classList.contains('active')) {
        mobileToggle.innerHTML = '<i class="fas fa-times"></i>';
    } else {
        mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
    }
});

// Header Scroll Effect
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Smooth Scroll para links de navegação
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
            
            // Fecha o menu mobile se estiver aberto
            if (nav.classList.contains('active')) {
                nav.classList.remove('active');
                mobileToggle.classList.remove('active');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
        }
    });
});

// Especialidades Tabs
const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tabId = btn.getAttribute('data-tab');
        
        // Remove a classe ativa de todos os botões e conteúdos
        tabBtns.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Adiciona a classe ativa ao botão clicado e ao conteúdo correspondente
        btn.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});

// Pricing Toggle
const pricingToggle = document.getElementById('pricing-toggle');
const pricingCards = document.querySelectorAll('.pricing-card');

if (pricingToggle) {
    pricingToggle.addEventListener('change', () => {
        if (pricingToggle.checked) {
            // Mostra preços de pacote
            pricingCards[0].querySelector('.pricing-price').innerHTML = 'R$1200<span>/pacote</span>';
            pricingCards[1].querySelector('.pricing-price').innerHTML = 'R$5500<span>/pacote</span>';
            pricingCards[2].querySelector('.pricing-price').innerHTML = 'R$1800<span>/pacote</span>';
        } else {
            // Mostra preços de sessão única
            pricingCards[0].querySelector('.pricing-price').innerHTML = 'R$250<span>/sessão</span>';
            pricingCards[1].querySelector('.pricing-price').innerHTML = 'R$1200<span>/sessão</span>';
            pricingCards[2].querySelector('.pricing-price').innerHTML = 'R$350<span>/sessão</span>';
        }
    });
}

// Testimonial Carousel
const testimonialTrack = document.getElementById('testimonial-track');
const testimonialSlides = document.querySelectorAll('.testimonial-slide');
const prevBtn = document.getElementById('prev-testimonial');
const nextBtn = document.getElementById('next-testimonial');

if (testimonialTrack && testimonialSlides.length > 0) {
    let currentSlide = 0;
    
    function updateCarousel() {
        testimonialTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide > 0) ? currentSlide - 1 : testimonialSlides.length - 1;
            updateCarousel();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide < testimonialSlides.length - 1) ? currentSlide + 1 : 0;
            updateCarousel();
        });
    }
    
    // Auto slide testimonials
    setInterval(() => {
        currentSlide = (currentSlide < testimonialSlides.length - 1) ? currentSlide + 1 : 0;
        updateCarousel();
    }, 5000);
}

// Form Submission
const contactForm = document.getElementById('contact-form');

if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Obtém valores do formulário
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const service = document.getElementById('service').value;
        const message = document.getElementById('message').value;
        
        // Aqui você normalmente enviaria os dados para um servidor
        // Para fins de demonstração, apenas mostramos um alerta
        alert(`Obrigado ${name}! Sua mensagem foi enviada com sucesso. Entraremos em contato em breve.`);
        
        // Reseta o formulário
        contactForm.reset();
    });
}

// Anima elementos ao rolar a página
function animateOnScroll() {
    const elements = document.querySelectorAll('.service-card, .team-member, .especialidade-card, .step, .pricing-card, .client-card');
    
    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;
        
        if (elementPosition < screenPosition) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
}

// Define estilos iniciais para animação
document.querySelectorAll('.service-card, .team-member, .especialidade-card, .step, .pricing-card, .client-card').forEach(element => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(20px)';
    element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
});

// Executa animação ao rolar
window.addEventListener('scroll', animateOnScroll);

// Executa animação ao carregar a página
window.addEventListener('load', () => {
    animateOnScroll();
});







// Efeito de digitação com palavras alternadas
document.addEventListener('DOMContentLoaded', function() {
    const words = ["autoestima", "confiança", "bem-estar", "beleza"];
    const typingElement = document.getElementById('typing-text');
    let wordIndex = 0;
    
    function typeAndErase() {
        // Digita a palavra atual
        const currentWord = words[wordIndex];
        let charIndex = 0;
        
        // Limpa qualquer animação anterior
        typingElement.style.animation = 'none';
        typingElement.offsetHeight; // Força um reflow
        
        // Define o texto como vazio
        typingElement.textContent = '';
        
        // Configura a nova animação
        typingElement.style.width = '0';
        typingElement.style.animation = 'typing 3s steps(30, end) forwards, blink 0.75s step-end infinite';
        
        // Função para digitar caractere por caractere
        function typeChar() {
            if (charIndex < currentWord.length) {
                typingElement.textContent += currentWord.charAt(charIndex);
                charIndex++;
                setTimeout(typeChar, 100);
            } else {
                // Após digitar, espera um pouco e então apaga
                setTimeout(eraseWord, 2000);
            }
        }
        
        // Função para apagar a palavra
        function eraseWord() {
            if (typingElement.textContent.length > 0) {
                typingElement.textContent = typingElement.textContent.slice(0, -1);
                setTimeout(eraseWord, 50);
            } else {
                // Após apagar, passa para a próxima palavra
                wordIndex = (wordIndex + 1) % words.length;
                setTimeout(typeAndErase, 500);
            }
        }
        
        // Inicia a digitação
        typeChar();
    }
    
    // Inicia o ciclo de digitação/apagamento
    setTimeout(typeAndErase, 1000);
});