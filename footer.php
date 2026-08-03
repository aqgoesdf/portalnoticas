<!-- ═══════════════════════════ FOOTER ═══════════════════════════ -->
<footer>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
      <div>
        <div class="font-display font-black text-xl mb-3" style="color:#c8392b;"><?php bloginfo( 'name' ); ?></div>
        <p class="text-xs leading-relaxed" style="color:var(--muted);"><?php bloginfo( 'description' ); ?></p>
      </div>
      <div>
        <h5 class="font-semibold text-sm mb-3" style="color:var(--text);">Editorias</h5>
        <ul class="space-y-1.5 text-xs" style="color:var(--muted);">
          <li><a href="#" style="color:inherit;text-decoration:none;">HTML|CSS</a></li>
          <li><a href="#" style="color:inherit;text-decoration:none;">JS</a></li>
          <li><a href="#" style="color:inherit;text-decoration:none;">Python</a></li>
          <li><a href="#" style="color:inherit;text-decoration:none;">Frameworks</a></li>
        </ul>
      </div>
      <div>
        <h5 class="font-semibold text-sm mb-3" style="color:var(--text);">Empresa</h5>
        <ul class="space-y-1.5 text-xs" style="color:var(--muted);">
          <li><a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>" style="color:inherit;text-decoration:none;">Sobre nós</a></li>
          <li><a href="#" style="color:inherit;text-decoration:none;">Redação</a></li>
          <li><a href="#" style="color:inherit;text-decoration:none;">Anuncie</a></li>
          <li><a href="<?php echo esc_url( home_url( '/contato' ) ); ?>" style="color:inherit;text-decoration:none;">Contato</a></li>
        </ul>
      </div>
      <div>
        <h5 class="font-semibold text-sm mb-3" style="color:var(--text);">Newsletter</h5>
        <p class="text-xs mb-3" style="color:var(--muted);">Receba as melhores notícias no seu e-mail.</p>
        <div class="flex gap-2">
          <input type="email" placeholder="seu@email.com" class="flex-1 text-xs px-3 py-2 rounded-md outline-none" style="background:var(--bg);border:1px solid var(--border);color:var(--text);"/>
          <button class="px-3 py-2 rounded-md text-xs font-bold text-white" style="background:#c8392b;">OK</button>
        </div>
      </div>
    </div>
    <div class="border-t pt-6 flex flex-col sm:flex-row items-center justify-between gap-2" style="border-color:var(--border);">
      <p class="text-xs" style="color:var(--muted);">© <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. Todos os direitos reservados.</p>
      <div class="flex gap-4 text-xs" style="color:var(--muted);">
        <a href="#" style="color:inherit;text-decoration:none;">Privacidade</a>
        <a href="#" style="color:inherit;text-decoration:none;">Termos</a>
        <a href="#" style="color:inherit;text-decoration:none;">Cookies</a>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>