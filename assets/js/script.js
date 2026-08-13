document.addEventListener('DOMContentLoaded', () => {
  const themeToggleBtn = document.getElementById('theme-toggle');
  const darkIcon = document.getElementById('theme-toggle-dark-icon');
  const lightIcon = document.getElementById('theme-toggle-light-icon');
  const menuToggleBtn = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');

  // --- 1. GERENCIAMENTO DE TEMA (DARK / LIGHT MODE) ---
  
  // Verifica preferência salva ou do sistema
  const isDarkMode = localStorage.getItem('theme') === 'dark' ||
    (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);

  function applyTheme(isDark) {
    if (isDark) {
      document.documentElement.classList.add('dark');
      darkIcon.classList.add('hidden');
      lightIcon.classList.remove('hidden');
    } else {
      document.documentElement.classList.remove('dark');
      lightIcon.classList.add('hidden');
      darkIcon.classList.remove('hidden');
    }
  }

  // Inicializa tema
  applyTheme(isDarkMode);

  // Evento de Alternância do Botão Sol/Lua
  themeToggleBtn.addEventListener('click', () => {
    const currentlyDark = document.documentElement.classList.contains('dark');
    const newThemeIsDark = !currentlyDark;

    applyTheme(newThemeIsDark);
    localStorage.setItem('theme', newThemeIsDark ? 'dark' : 'light');
  });

  // --- 2. MENU MOBILE HAMBÚRGUER ---
  
  menuToggleBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });

  // Fecha menu mobile ao clicar em um link
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      mobileMenu.classList.add('hidden');
    });
  });
});


/*Páginas Artigos  */
// --- 3. RECURSO DE COPIAR CÓDIGO DA IDE ---
document.querySelectorAll('.copy-code-btn').forEach(button => {
  button.addEventListener('click', () => {
    const codeBlock = button.closest('.group').querySelector('code');
    if (!codeBlock) return;

    const codeText = codeBlock.innerText;

    navigator.clipboard.writeText(codeText).then(() => {
      const span = button.querySelector('span');
      const originalText = span.textContent;

      span.textContent = 'Copiado!';
      button.classList.add('bg-emerald-600', 'text-white');

      setTimeout(() => {
        span.textContent = originalText;
        button.classList.remove('bg-emerald-600', 'text-white');
      }, 2000);
    }).catch(err => {
      console.error('Erro ao copiar código: ', err);
    });
  });
});


/*Carrossel*/
document.addEventListener('DOMContentLoaded', () => {
  // --- CARROSSEL HERO SECTION ---
  const track = document.getElementById('carousel-track');
  const prevBtn = document.getElementById('carousel-prev');
  const nextBtn = document.getElementById('carousel-next');
  const dots = document.querySelectorAll('#carousel-dots span');

  if (track && prevBtn && nextBtn) {
    let currentIndex = 0;
    const totalSlides = 3;

    const updateCarousel = (index) => {
      currentIndex = index;
      track.style.transform = `translateX(-${currentIndex * 100}%)`;

      // Atualiza indicadores visuais
      dots.forEach((dot, idx) => {
        if (idx === currentIndex) {
          dot.classList.add('bg-brand');
          dot.classList.remove('bg-subtle');
        } else {
          dot.classList.remove('bg-brand');
          dot.classList.add('bg-subtle');
        }
      });
    };

    nextBtn.addEventListener('click', () => {
      const nextIndex = (currentIndex + 1) % totalSlides;
      updateCarousel(nextIndex);
    });

    prevBtn.addEventListener('click', () => {
      const prevIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      updateCarousel(prevIndex);
    });

    dots.forEach((dot, idx) => {
      dot.addEventListener('click', () => updateCarousel(idx));
    });
  }
});