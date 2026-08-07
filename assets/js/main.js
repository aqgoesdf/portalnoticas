(function () {
	'use strict';

	/* ═══════════════════════════
	   TEMA (dark/light) — localStorage: aqgoes-theme
	═══════════════════════════ */
	var themeBtn = document.getElementById('theme-toggle');
	if (themeBtn) {
		themeBtn.addEventListener('click', function () {
			var html = document.documentElement;
			var isDark = html.classList.contains('dark');
			html.classList.remove(isDark ? 'dark' : 'light');
			html.classList.add(isDark ? 'light' : 'dark');
			try { localStorage.setItem('aqgoes-theme', isDark ? 'light' : 'dark'); } catch (e) {}
		});
	}

	/* ═══════════════════════════
	   MENU MOBILE (hamburguer)
	═══════════════════════════ */
	var menuBtn  = document.getElementById('menu-btn');
	var mobileMenu = document.getElementById('mobile-menu');

	function toggleMenu() {
		var open = mobileMenu.classList.toggle('open');
		menuBtn.classList.toggle('menu-open', open);
		menuBtn.setAttribute('aria-expanded', String(open));
	}
	function closeMenu() {
		mobileMenu.classList.remove('open');
		menuBtn.classList.remove('menu-open');
		menuBtn.setAttribute('aria-expanded', 'false');
	}
	if (menuBtn && mobileMenu) {
		menuBtn.addEventListener('click', toggleMenu);
		document.addEventListener('click', function (e) {
			if (!menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) closeMenu();
		});
		window.addEventListener('resize', function () {
			if (window.innerWidth >= 768) closeMenu();
		});
	}

	/* ═══════════════════════════
	   SCROLL REVEAL
	═══════════════════════════ */
	var revealEls = document.querySelectorAll('.reveal');
	if (revealEls.length && 'IntersectionObserver' in window) {
		var revObs = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry, i) {
				if (entry.isIntersecting) {
					entry.target.style.transitionDelay = (i % 5) * 0.07 + 's';
					entry.target.classList.add('visible');
					revObs.unobserve(entry.target);
				}
			});
		}, { threshold: 0.1 });
		revealEls.forEach(function (el) { revObs.observe(el); });
	} else {
		revealEls.forEach(function (el) { el.classList.add('visible'); });
	}

	/* ═══════════════════════════
	   BUSCA (sidebar) — roda em QUALQUER página que tenha o widget,
	   independente de existir #post-grid ou não. Antes esse bloco
	   ficava depois de um "if (!postGrid) return;" lá embaixo e
	   nunca chegava a ser ligado em páginas sem grid de posts.
	═══════════════════════════ */
	var searchInput   = document.getElementById('search-input');
	var searchResults = document.getElementById('search-results');

	function highlight(text, q) {
		var idx = text.toLowerCase().indexOf(q);
		if (idx < 0) return text;
		return text.slice(0, idx) +
			'<mark style="background:rgba(200,57,43,.18);color:#c8392b;border-radius:2px;">' +
			text.slice(idx, idx + q.length) + '</mark>' +
			text.slice(idx + q.length);
	}

	if (searchInput && searchResults) {
		searchInput.addEventListener('input', function () {
			var q = searchInput.value.trim().toLowerCase();
			if (!q) { searchResults.classList.remove('show'); searchResults.innerHTML = ''; return; }

			var pool = Array.prototype.slice.call(document.querySelectorAll('#post-grid .post-card'));
			var matches = pool.filter(function (p) {
				return (p.dataset.title || '').toLowerCase().indexOf(q) !== -1;
			}).slice(0, 5);

			if (!matches.length) {
				var fullSearchUrl = window.location.origin + '/?s=' + encodeURIComponent(searchInput.value.trim());
				searchResults.innerHTML =
					'<div class="search-result-item" style="color:var(--muted);">Nenhum resultado nesta página.</div>' +
					'<div class="search-result-item"><a href="' + fullSearchUrl + '" style="color:#c8392b;text-decoration:none;font-weight:700;">Buscar em todo o site →</a></div>';
			} else {
				searchResults.innerHTML = matches.map(function (p) {
					return '<div class="search-result-item" data-cat="' + p.dataset.cat + '">' +
						highlight(p.dataset.title, q) +
						'<span>' + p.dataset.cat + '</span></div>';
				}).join('');
			}
			searchResults.classList.add('show');
		});

		searchResults.addEventListener('click', function (e) {
			var item = e.target.closest('.search-result-item');
			if (!item || !item.dataset.cat) return;
			searchResults.classList.remove('show');
			searchInput.value = '';
			if (typeof window.aqgoesSetActiveCat === 'function') window.aqgoesSetActiveCat(item.dataset.cat);
			var grid = document.getElementById('post-grid');
			if (grid) grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
		});

		document.addEventListener('click', function (e) {
			if (!searchResults.contains(e.target) && e.target !== searchInput) {
				searchResults.classList.remove('show');
			}
		});
	}

	/* ═══════════════════════════
	   POSTS: filtro por categoria/tag
	   (só roda em páginas que têm o grid, ex: home.php)
	═══════════════════════════ */
	var postGrid = document.getElementById('post-grid');
	if (!postGrid) return;

	var allPosts = Array.prototype.slice.call(postGrid.querySelectorAll('.post-card'));
	var activeCat = 'todos';
	var activeTag = null;

	var labels = {};
	document.querySelectorAll('.cat-btn').forEach(function (btn) {
		labels[btn.dataset.cat] = btn.textContent.trim();
	});
	labels.todos = 'Todos os artigos';

	function getVisibleCount() {
		return allPosts.filter(function (p) { return p.style.display !== 'none'; }).length;
	}
	function updateCounter(label) {
		var labelEl = document.getElementById('results-label');
		var countEl = document.getElementById('results-count');
		if (labelEl) labelEl.textContent = label;
		if (countEl) countEl.textContent = '(' + getVisibleCount() + ')';
	}
	function checkEmpty() {
		var noResults = document.getElementById('no-results');
		if (noResults) noResults.classList.toggle('show', getVisibleCount() === 0);
	}
	function applyFilters() {
		allPosts.forEach(function (post) {
			var cat  = post.dataset.cat;
			var tags = post.dataset.tags || '';
			var catOk = activeCat === 'todos' || cat === activeCat;
			var tagOk = !activeTag || tags.split(',').indexOf(activeTag) !== -1;
			post.style.display = (catOk && tagOk) ? '' : 'none';
		});
		checkEmpty();
	}

	function setActiveCat(cat) {
		activeCat = cat;
		activeTag = null;

		document.querySelectorAll('.cat-btn').forEach(function (b) {
			b.classList.toggle('active', b.dataset.cat === cat);
		});
		document.querySelectorAll('.cat-list-item').forEach(function (item) {
			item.classList.toggle('active-cat', item.dataset.cat === cat);
		});
		document.querySelectorAll('.tag-pill').forEach(function (t) { t.classList.remove('active-tag'); });

		applyFilters();
		updateCounter(labels[cat] || cat);
	}
	window.aqgoesSetActiveCat = setActiveCat;

	document.querySelectorAll('.cat-btn').forEach(function (btn) {
		btn.addEventListener('click', function () { setActiveCat(btn.dataset.cat); });
	});
	document.querySelectorAll('.cat-list-item').forEach(function (item) {
		item.addEventListener('click', function (e) {
			e.preventDefault();
			setActiveCat(item.dataset.cat);
		});
	});

	document.querySelectorAll('.tag-pill').forEach(function (pill) {
		pill.addEventListener('click', function (e) {
			e.preventDefault();
			var tag = pill.dataset.tag;
			if (activeTag === tag) {
				activeTag = null;
				document.querySelectorAll('.tag-pill').forEach(function (p) { p.classList.remove('active-tag'); });
				updateCounter(labels[activeCat] || 'Todos os artigos');
			} else {
				activeTag = tag;
				document.querySelectorAll('.tag-pill').forEach(function (p) {
					p.classList.toggle('active-tag', p.dataset.tag === tag);
				});
				updateCounter('#' + tag);
			}
			applyFilters();
		});
	});

	updateCounter('Todos os artigos');
})();
