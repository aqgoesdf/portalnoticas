<?php
/**
 * Formulário de Busca Dinâmico - AqGoEs Blog
 *
 * @package aqgoes-theme
 */
?>

<form role="search" method="get" class="search-wrap relative" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <input 
    type="search" 
    class="search-input w-full text-xs px-3.5 py-2.5 rounded-md outline-none transition-colors" 
    placeholder="Pesquisar artigos…" 
    value="<?php echo get_search_query(); ?>" 
    name="s" 
    autocomplete="off"
    required 
  />
  <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 border-0 bg-transparent cursor-pointer text-muted hover:text-[#c8392b] transition-colors" aria-label="Executar busca">
    <svg class="search-icon" width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="6" cy="6" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M9.5 9.5l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
  </button>
</form>