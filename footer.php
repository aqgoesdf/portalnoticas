<!-- ═══════════════════════════════════════
     FOOTER (DINÂMICO)
═══════════════════════════════════════ -->
<footer>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
      
      <!-- Coluna 1: Sobre -->
      <div>
        <div class="font-display font-black text-xl mb-3" style="color:#c8392b;">AqGoEs</div>
        <p class="text-xs leading-relaxed" style="color:var(--muted)">Jornalismo independente que conecta você ao mundo que importa.</p>
      </div>
      
      <!-- Coluna 2: Editorias (Menu Dinâmico de Categorias) -->
      <div>
        <h5 class="font-semibold text-sm mb-3" style="color:var(--text);">Editorias</h5>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'footer-editorias',
            'container'      => 'ul',
            'container_class'=> 'space-y-1.5 text-xs',
            'items_wrap'     => '%3$s',
            'fallback_cb'    => false,
            'link_class'     => 'hover:underline text-inherit',
        ));
        ?>
      </div>
      
      <!-- Coluna 3: Empresa (Menu Dinâmico de Páginas) -->
      <div>
        <h5 class="font-semibold text-sm mb-3" style="color:var(--text);">Empresa</h5>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'footer-empresa',
            'container'      => 'ul',
            'container_class'=> 'space-y-1.5 text-xs',
            'items_wrap'     => '%3$s',
            'fallback_cb'    => false,
            'link_class'     => 'hover:underline text-inherit',
        ));
        ?>
      </div>
      
      <!-- Coluna 4: Newsletter -->
      <div>
        <h5 class="font-semibold text-sm mb-3" style="color:var(--text);">Newsletter</h5>
        <p class="text-xs mb-3" style="color:var(--muted);">Receba as melhores notícias no seu e-mail.</p>
        <div class="flex gap-2">
          <input type="email" placeholder="seu@email.com" class="flex-1 text-xs px-3 py-2 rounded-md outline-none" style="background:var(--bg);border:1px solid var(--border);color:var(--text);" />
          <button class="px-3 py-2 rounded-md text-xs font-bold text-white" style="background:#c8392b;">OK</button>
        </div>
      </div>
      
    </div>
    
    <!-- Direitos Autorais e Links Legais -->
    <div class="border-t pt-6 flex flex-col sm:flex-row items-center justify-between gap-2" style="border-color:var(--border);">
      <p class="text-xs" style="color:var(--muted);">© <?php echo date('Y'); ?> AqGoEs Desenvolvimento. Todos os direitos reservados.</p>
      <div class="flex gap-4 text-xs" style="color:var(--muted);">
        <a href="#" style="color:inherit;text-decoration:none;" class="hover:underline">Privacidade</a>
        <a href="#" style="color:inherit;text-decoration:none;" class="hover:underline">Termos</a>
        <a href="#" style="color:inherit;text-decoration:none;" class="hover:underline">Cookies</a>
      </div>
    </div>
  </div>
</footer>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/script.js"></script>
<?php wp_footer(); ?> <!-- Permite que scripts enfileirados e plugins injetem códigos antes do fechamento do body -->
</body>
</html>