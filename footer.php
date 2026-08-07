</main><!-- /main aberto em header.php -->

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
					<?php
					$editorias = get_categories( array( 'number' => 4, 'hide_empty' => false ) );
					foreach ( $editorias as $cat ) :
						?>
						<li><a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="color:inherit;text-decoration:none;"><?php echo esc_html( $cat->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div>
				<h5 class="font-semibold text-sm mb-3" style="color:var(--text);">Empresa</h5>
				<ul class="space-y-1.5 text-xs" style="color:var(--muted);">
					<?php
					if ( has_nav_menu( 'footer' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'footer',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'link_before'    => '',
							'walker'         => new Aqgoes_Walker_Nav_Menu( false ),
						) );
					} else {
						?>
						<li><a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>" style="color:inherit;text-decoration:none;">Sobre nós</a></li>
						<li><a href="#" style="color:inherit;text-decoration:none;">Redação</a></li>
						<li><a href="#" style="color:inherit;text-decoration:none;">Anuncie</a></li>
						<li><a href="<?php echo esc_url( home_url( '/contato' ) ); ?>" style="color:inherit;text-decoration:none;">Contato</a></li>
					<?php } ?>
				</ul>
			</div>

			<div>
				<h5 class="font-semibold text-sm mb-3" style="color:var(--text);">Newsletter</h5>
				<p class="text-xs mb-3" style="color:var(--muted);">Receba as melhores notícias no seu e-mail.</p>
				<form class="flex gap-2" method="post" action="">
					<input type="email" name="aqgoes_newsletter_email" placeholder="seu@email.com" class="flex-1 text-xs px-3 py-2 rounded-md outline-none" style="background:var(--bg);border:1px solid var(--border);color:var(--text);" required/>
					<button type="submit" class="px-3 py-2 rounded-md text-xs font-bold text-white" style="background:#c8392b;">OK</button>
				</form>
			</div>
		</div>

		<div class="border-t pt-6 flex flex-col sm:flex-row items-center justify-between gap-2" style="border-color:var(--border);">
			<p class="text-xs" style="color:var(--muted);">&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. Todos os direitos reservados.</p>
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
