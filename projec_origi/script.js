/* ═══════════════════════════
     HAMBURGUER
  ═══════════════════════════ */
  function toggleMenu() {
    const menu = document.getElementById('mobile-menu');
    const btn  = document.getElementById('menu-btn');
    const open = menu.style.maxHeight !== '0px' && menu.style.maxHeight !== '';
    menu.style.maxHeight = open ? '0px' : menu.scrollHeight + 'px';
    btn.setAttribute('aria-expanded', String(!open));
    btn.classList.toggle('menu-open', !open);
  }
  document.addEventListener('click', e => {
    const menu = document.getElementById('mobile-menu');
    const btn  = document.getElementById('menu-btn');
    if (!btn.contains(e.target) && !menu.contains(e.target)) {
      menu.style.maxHeight = '0px';
      btn.setAttribute('aria-expanded','false');
      btn.classList.remove('menu-open');
    }
  });
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
      document.getElementById('mobile-menu').style.maxHeight = '0px';
      document.getElementById('menu-btn').classList.remove('menu-open');
    }
  });

  /* ═══════════════════════════
     THEME
  ═══════════════════════════ */
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

  /* ═══════════════════════════
     SCROLL REVEAL
  ═══════════════════════════ */
  const revealEls = document.querySelectorAll('.reveal');
  const revObs = new IntersectionObserver(entries => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) {
        e.target.style.transitionDelay = (i % 5) * 0.07 + 's';
        e.target.classList.add('visible');
        revObs.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });
  revealEls.forEach(el => revObs.observe(el));

  /* ═══════════════════════════
     POSTS DATA (coleta do DOM)
  ═══════════════════════════ */
  const allPosts = Array.from(document.querySelectorAll('#post-grid .post-card'));
  let activeCat = 'todos';
  let activeTag = null;

  function getVisibleCount() {
    return allPosts.filter(p => p.style.display !== 'none').length;
  }
  function updateCounter(label) {
    document.getElementById('results-label').textContent = label;
    document.getElementById('results-count').textContent = `(${getVisibleCount()})`;
  }
  function checkEmpty() {
    const empty = getVisibleCount() === 0;
    document.getElementById('no-results').classList.toggle('show', empty);
  }
  function applyFilters() {
    allPosts.forEach(post => {
      const cat  = post.dataset.cat;
      const tags = post.dataset.tags || '';
      const catOk = activeCat === 'todos' || cat === activeCat;
      const tagOk = !activeTag || tags.split(',').includes(activeTag);
      post.style.display = (catOk && tagOk) ? '' : 'none';
    });
    checkEmpty();
  }

  /* ═══════════════════════════
     FILTER — TOP BAR + SIDEBAR
  ═══════════════════════════ */
  function filterCat(btn) {
    activeCat = btn.dataset.cat;
    activeTag = null;

    // sync top bar
    document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // sync sidebar
    document.querySelectorAll('.cat-list-item').forEach(item => {
      item.classList.toggle('active-cat', item.getAttribute('onclick').includes(`'${activeCat}'`));
    });

    // sync tags
    document.querySelectorAll('.tag-pill').forEach(t => t.classList.remove('active-tag'));

    const labels = { todos:'Todos os artigos', tecnologia:'Tecnologia', python:'Python',
      'front-end':'Front-end', css:'CSS & Design', javascript:'JavaScript', django:'Django' };
    applyFilters();
    updateCounter(labels[activeCat] || activeCat);
  }

  function sidebarCat(e, cat) {
    e.preventDefault();
    // sync top bar
    const topBtn = document.querySelector(`.cat-btn[data-cat="${cat}"]`);
    if (topBtn) filterCat(topBtn);
    else { activeCat = cat; applyFilters(); }

    document.querySelectorAll('.cat-list-item').forEach(item => {
      item.classList.toggle('active-cat', item.getAttribute('onclick').includes(`'${cat}'`));
    });
  }

  function filterTag(e, tag) {
    e.preventDefault();
    const pills = document.querySelectorAll('.tag-pill');
    if (activeTag === tag) {
      activeTag = null;
      pills.forEach(p => p.classList.remove('active-tag'));
    } else {
      activeTag = tag;
      pills.forEach(p => {
        const t = p.getAttribute('onclick').match(/'([^']+)'/)?.[1];
        p.classList.toggle('active-tag', t === tag);
      });
    }
    applyFilters();
    updateCounter(activeTag ? `#${activeTag}` : 'Todos os artigos');
  }

  /* ═══════════════════════════
     SEARCH
  ═══════════════════════════ */
  const searchData = allPosts.map(p => ({
    title: p.dataset.title,
    cat:   p.dataset.cat,
    el:    p
  }));

  function handleSearch(q) {
    const resultsEl = document.getElementById('search-results');
    q = q.trim().toLowerCase();
    if (!q) { resultsEl.classList.remove('show'); resultsEl.innerHTML = ''; return; }

    const matches = searchData.filter(p => p.title.toLowerCase().includes(q)).slice(0, 5);
    if (!matches.length) {
      resultsEl.innerHTML = '<div class="search-result-item" style="color:var(--muted);">Nenhum resultado encontrado.</div>';
    } else {
      resultsEl.innerHTML = matches.map(p => `
        <div class="search-result-item" onclick="jumpToPost(this, '${p.el.dataset.cat}')">
          ${highlight(p.title, q)}
          <span>${p.cat}</span>
        </div>`).join('');
    }
    resultsEl.classList.add('show');
  }

  function highlight(text, q) {
    const idx = text.toLowerCase().indexOf(q);
    if (idx < 0) return text;
    return text.slice(0, idx) +
      `<mark style="background:rgba(200,57,43,.18);color:#c8392b;border-radius:2px;">${text.slice(idx, idx + q.length)}</mark>` +
      text.slice(idx + q.length);
  }

  function jumpToPost(item, cat) {
    document.getElementById('search-results').classList.remove('show');
    document.getElementById('search-input').value = '';
    const btn = document.querySelector(`.cat-btn[data-cat="${cat}"]`);
    if (btn) filterCat(btn);
    document.getElementById('post-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  // Fechar busca ao clicar fora
  document.addEventListener('click', e => {
    const sr = document.getElementById('search-results');
    if (!sr.contains(e.target) && e.target.id !== 'search-input') {
      sr.classList.remove('show');
    }
  });

  // Inicializa contador
  updateCounter('Todos os artigos');