function toggleTheme() {
  const htmlEl = document.documentElement;
  if (htmlEl.classList.contains('dark')) {
    htmlEl.classList.remove('dark');
    htmlEl.classList.add('light');
    localStorage.setItem('theme', 'light');
  } else {
    htmlEl.classList.remove('light');
    htmlEl.classList.add('dark');
    localStorage.setItem('theme', 'dark');
  }
}