// --- LÓGICA DO MENU HAMBÚRGUER ---
const menuBtn = document.getElementById('menu-btn');
const menu = document.getElementById('menu');
const iconOpen = document.getElementById('icon-open');
const iconClose = document.getElementById('icon-close');
const navLinks = document.querySelectorAll('.nav-link');

function toggleMenu() {
    const isExpanded = menuBtn.getAttribute('aria-expanded') === 'true';
    
    menu.classList.toggle('hidden');
    menu.classList.toggle('flex');
    
    iconOpen.classList.toggle('hidden');
    iconClose.classList.toggle('hidden');
    
    menuBtn.setAttribute('aria-expanded', !isExpanded);
}

if (menuBtn) {
    menuBtn.addEventListener('click', toggleMenu);
}

navLinks.forEach(link => {
    link.addEventListener('click', () => {
        if (!menu.classList.contains('hidden') && window.innerWidth < 768) {
            toggleMenu();
        }
    });
});
