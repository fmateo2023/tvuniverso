/**
 * TV Universo - JavaScript Principal
 * Interacciones del frontend público
 */

document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initAnimations();
});

/** Navbar: toggle mobile + scroll effect */
function initNavbar() {
    const toggle = document.querySelector('.navbar__toggle');
    const menu = document.querySelector('.navbar__menu');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('active');
            toggle.textContent = menu.classList.contains('active') ? '✕' : '☰';
        });

        // Cerrar menú al hacer click en un enlace
        menu.querySelectorAll('.navbar__link').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('active');
                toggle.textContent = '☰';
            });
        });
    }

    // Efecto scroll en navbar
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        if (!navbar) return;
        const currentScroll = window.scrollY;
        if (currentScroll > 50) {
            navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
        } else {
            navbar.style.boxShadow = 'none';
        }
        lastScroll = currentScroll;
    });
}

/** Animaciones de entrada al hacer scroll */
function initAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.card, .about-card, .stat-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(el);
    });
}

// Clase para animación de entrada
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .animate-in {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    </style>
`);

/** Validación de formulario de contacto */
function validateContactForm(form) {
    const name = form.querySelector('[name="name"]');
    const email = form.querySelector('[name="email"]');
    const message = form.querySelector('[name="message"]');
    let valid = true;

    // Limpiar errores previos
    form.querySelectorAll('.form-error').forEach(el => el.remove());

    if (!name.value.trim()) {
        showFieldError(name, 'El nombre es obligatorio');
        valid = false;
    }

    if (!email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        showFieldError(email, 'Ingresa un email válido');
        valid = false;
    }

    if (!message.value.trim() || message.value.trim().length < 10) {
        showFieldError(message, 'El mensaje debe tener al menos 10 caracteres');
        valid = false;
    }

    return valid;
}

function showFieldError(field, msg) {
    const error = document.createElement('span');
    error.className = 'form-error';
    error.style.cssText = 'color:#e74c3c;font-size:0.8rem;display:block;margin-top:4px;';
    error.textContent = msg;
    field.parentNode.appendChild(error);
    field.style.borderColor = '#e74c3c';
    field.addEventListener('input', () => {
        field.style.borderColor = '';
        if (error.parentNode) error.remove();
    }, { once: true });
}
