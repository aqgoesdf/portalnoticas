  /* ── Hamburger Menu ── */
  function toggleMenu() {
    const menu = document.getElementById('mobile-menu');
    const btn  = document.getElementById('menu-btn');
    const isOpen = menu.style.maxHeight !== '0px' && menu.style.maxHeight !== '';
    if (isOpen) {
      menu.style.maxHeight = '0px';
      btn.setAttribute('aria-expanded','false');
      btn.classList.remove('menu-open');
    } else {
      menu.style.maxHeight = menu.scrollHeight + 'px';
      btn.setAttribute('aria-expanded','true');
      btn.classList.add('menu-open');
    }
  }
  // Fechar menu ao clicar fora
  document.addEventListener('click', e => {
    const menu = document.getElementById('mobile-menu');
    const btn  = document.getElementById('menu-btn');
    if (!btn.contains(e.target) && !menu.contains(e.target)) {
      menu.style.maxHeight = '0px';
      btn.setAttribute('aria-expanded','false');
      btn.classList.remove('menu-open');
    }
  });
  // Fechar ao redimensionar para desktop
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
      const menu = document.getElementById('mobile-menu');
      const btn  = document.getElementById('menu-btn');
      menu.style.maxHeight = '0px';
      btn.classList.remove('menu-open');
    }
  });

  /* ── Theme Toggle ── */
  function toggleTheme() {
    const html = document.documentElement;
    html.classList.toggle('dark');
    html.classList.toggle('light');
    localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
  }
  (function() {
    const saved = localStorage.getItem('theme') || 'light';
    document.documentElement.classList.remove('light','dark');
    document.documentElement.classList.add(saved);
  })();

  /* ── Carousel ── */
  const track     = document.getElementById('track');
  const dotsEl    = document.getElementById('dots');
  const counter   = document.getElementById('slide-counter');
  const progressEl= document.getElementById('progress-bar');
  const total     = track.children.length;
  let   current   = 0;
  let   autoTimer = null;
  let   progTimer = null;

  // Build dots
  for (let i = 0; i < total; i++) {
    const d = document.createElement('button');
    d.className = 'dot' + (i === 0 ? ' active' : '');
    d.setAttribute('aria-label', 'Slide ' + (i+1));
    d.onclick = () => goTo(i);
    dotsEl.appendChild(d);
  }

  function goTo(n) {
    current = (n + total) % total;
    track.style.transform = `translateX(-${current * 100}%)`;
    document.querySelectorAll('.dot').forEach((d,i) => d.classList.toggle('active', i === current));
    counter.textContent = `${current + 1} / ${total}`;
    resetProgress();
    clearTimeout(autoTimer);
    autoTimer = setTimeout(() => goTo(current + 1), 4200);
  }

  function resetProgress() {
    clearTimeout(progTimer);
    progressEl.style.transition = 'none';
    progressEl.style.width = '0%';
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        progressEl.style.transition = 'width 4s linear';
        progressEl.style.width = '100%';
      });
    });
  }

  window.changeSlide = (dir) => goTo(current + dir);

  // Start
  goTo(0);

  /* ── Keyboard nav ── */
  document.addEventListener('keydown', e => {
    if (e.key === 'ArrowLeft')  goTo(current - 1);
    if (e.key === 'ArrowRight') goTo(current + 1);
  });

  /* ── Touch / swipe ── */
  let touchStart = 0;
  track.addEventListener('touchstart', e => touchStart = e.touches[0].clientX, {passive:true});
  track.addEventListener('touchend',   e => {
    const delta = e.changedTouches[0].clientX - touchStart;
    if (Math.abs(delta) > 40) goTo(current + (delta < 0 ? 1 : -1));
  });