/**
 * TV Universo - JavaScript Principal
 * Animaciones y interacciones estilo VOGA
 */

document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initScrollAnimations();
});

function initNavbar() {
    const toggle = document.querySelector('.navbar__toggle');
    const menu = document.querySelector('.navbar__menu');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('active');
            toggle.textContent = menu.classList.contains('active') ? '✕' : '☰';
        });

        menu.querySelectorAll('.navbar__link').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('active');
                toggle.textContent = '☰';
            });
        });
    }

    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        const scrollBtn = document.getElementById('scrollTopBtn');
        if (!navbar) return;
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(253,246,236,0.95)';
            navbar.style.boxShadow = '0 4px 30px rgba(107,66,38,0.08)';
        } else {
            navbar.style.background = 'rgba(253,246,236,0.8)';
            navbar.style.boxShadow = 'none';
        }
        if (scrollBtn) {
            scrollBtn.classList.toggle('visible', window.scrollY > 400);
        }
    });
}

function initScrollAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                entry.target.style.transitionDelay = (i * 0.08) + 's';
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08 });

    document.querySelectorAll('.card, .about-card, .stat-card, .contact-info__item, .section__title').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(24px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

document.head.insertAdjacentHTML('beforeend', '<style>.animate-in{opacity:1!important;transform:translateY(0)!important}</style>');

function validateContactForm(form) {
    const name = form.querySelector('[name="name"]');
    const email = form.querySelector('[name="email"]');
    const message = form.querySelector('[name="message"]');
    let valid = true;

    form.querySelectorAll('.form-error').forEach(el => el.remove());

    if (!name.value.trim()) { showFieldError(name, 'El nombre es obligatorio'); valid = false; }
    if (!email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) { showFieldError(email, 'Ingresa un email válido'); valid = false; }
    if (!message.value.trim() || message.value.trim().length < 10) { showFieldError(message, 'El mensaje debe tener al menos 10 caracteres'); valid = false; }

    return valid;
}

function showFieldError(field, msg) {
    const error = document.createElement('span');
    error.className = 'form-error';
    error.style.cssText = 'color:var(--rosa);font-size:0.8rem;display:block;margin-top:4px;';
    error.textContent = msg;
    field.parentNode.appendChild(error);
    field.style.borderColor = 'var(--rosa)';
    field.addEventListener('input', () => {
        field.style.borderColor = '';
        if (error.parentNode) error.remove();
    }, { once: true });
}
