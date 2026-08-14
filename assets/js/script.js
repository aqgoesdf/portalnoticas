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


/*lateral do post */
document.addEventListener('DOMContentLoaded', function() {
  const postContent = document.getElementById('post-content');
  const tocNav = document.getElementById('table-of-contents');
  const tocContainer = document.getElementById('toc-container');

  if (postContent && tocNav) {
    // Seleciona todos os subtítulos h2 e h3 do artigo
    const headings = postContent.querySelectorAll('h2, h3');

    // Se o artigo tiver pelo menos 1 título
    if (headings.length > 0) {
      tocNav.innerHTML = ''; // Limpa a mensagem "Carregando tópicos..."

      headings.forEach((heading, index) => {
        // 1. Gera um ID único e amigável para cada título caso não tenha
        if (!heading.id) {
          const slug = heading.innerText
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '') // Remove acentos
            .replace(/[^a-z0-9 -]/g, '')     // Remove caracteres especiais
            .replace(/\s+/g, '-')            // Substitui espaços por hífens
            .replace(/-+/g, '-');            // Evita hífens duplos

          heading.id = slug || 'topico-' + index;
        }

        // 2. Adiciona suporte a offset para o header fixo não cobrir o título
        heading.classList.add('scroll-mt-28'); 

        // 3. Cria o botão/link dinâmico no índice
        const link = document.createElement('a');
        link.href = '#' + heading.id;
        link.className = 'hover:text-brand transition-colors text-xs font-semibold py-1.5 flex items-center gap-2 border-b border-subtle/40 sm:border-0';
        
        // Indentação sutil se for um h3
        if (heading.tagName.toLowerCase() === 'h3') {
          link.classList.add('pl-4', 'opacity-80');
        }

        link.innerHTML = `<span class="text-brand text-[10px]">►</span> ${heading.innerText}`;

        // 4. Efeito de Rolagem Suave (Smooth Scroll) ao Clicar
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const targetId = this.getAttribute('href').substring(1);
          const targetElement = document.getElementById(targetId);

          if (targetElement) {
            targetElement.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });

            // Atualiza a URL no navegador sem dar reload na página
            history.pushState(null, null, '#' + targetId);
          }
        });

        tocNav.appendChild(link);
      });
    } else {
      // Se o post não possuir nenhum h2 ou h3, esconde a caixa de tópicos automaticamente
      if (tocContainer) {
        tocContainer.style.display = 'none';
      }
    }
  }
});





document.addEventListener('DOMContentLoaded', function() {
  const postContent = document.getElementById('post-content');
  const tocNav = document.getElementById('table-of-contents');
  const tocContainer = document.getElementById('toc-container');

  if (postContent && tocNav) {
    const headings = postContent.querySelectorAll('h2, h3');

    if (headings.length > 0) {
      tocNav.innerHTML = ''; // Limpa o carregando

      headings.forEach((heading, index) => {
        // Cria ID amigável
        if (!heading.id) {
          const slug = heading.innerText
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

          heading.id = slug || 'topico-' + index;
        }

        // Espaçamento para não cobrir com o header fixo
        heading.classList.add('scroll-mt-28');

        // Cria o link da sidebar
        const link = document.createElement('a');
        link.href = '#' + heading.id;
        link.className = 'hover:text-brand transition-colors text-xs font-semibold py-1 flex items-center gap-2 border-b border-subtle/30 last:border-0';
        
        if (heading.tagName.toLowerCase() === 'h3') {
          link.classList.add('pl-4', 'opacity-80');
        }

        // Ícone limpo usando caractere unicode (►)
        link.innerHTML = `<span class="text-brand text-[10px] flex-shrink-0">►</span> <span>${heading.innerText}</span>`;

        // Scroll Suave
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const targetId = this.getAttribute('href').substring(1);
          const targetElement = document.getElementById(targetId);

          if (targetElement) {
            targetElement.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });

            history.pushState(null, null, '#' + targetId);
          }
        });

        tocNav.appendChild(link);
      });
    } else {
      // Se não houver subtítulos no post, oculta o container da sidebar
      if (tocContainer) {
        tocContainer.style.display = 'none';
      }
    }
  }
});