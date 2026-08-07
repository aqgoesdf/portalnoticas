<?php
/**
 * sidebar.php — widgets da lateral do blog.
 */
?>
<aside class="sidebar">

	<!-- Busca (filtra os posts já carregados nesta página, client-side) -->
	<div class="sidebar-widget widget-search reveal">
		<div class="widget-header">
			<svg width="15" height="15" viewBox="0 0 15 15" fill="none"><circle cx="6.5" cy="6.5" r="4.5" stroke="#c8392b" stroke-width="1.5"/><path d="M10 10l3 3" stroke="#c8392b" stroke-width="1.5" stroke-linecap="round"/></svg>
			<span class="widget-title">Buscar</span>
		</div>
		<div class="widget-body">
			<div class="search-wrap">
				<input type="text" class="search-input" id="search-input" placeholder="Pesquisar artigos…" autocomplete="off"/>
				<svg class="search-icon" width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="6" cy="6" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M9.5 9.5l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
				<div class="search-results" id="search-results"></div>
			</div>
			<p style="font-size:.68rem;color:var(--muted);margin-top:.6rem;">
				Busca detalhada? <a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" style="color:#c8392b;">use a busca completa do site</a>.
			</p>
		</div>
	</div>

	<!-- Categorias -->
	<div class="sidebar-widget reveal">
		<div class="widget-header">
			<svg width="15" height="15" viewBox="0 0 15 15" fill="none"><rect x="1" y="1" width="5" height="5" rx="1.5" fill="#c8392b"/><rect x="9" y="1" width="5" height="5" rx="1.5" fill="#c8392b" opacity=".5"/><rect x="1" y="9" width="5" height="5" rx="1.5" fill="#c8392b" opacity=".5"/><rect x="9" y="9" width="5" height="5" rx="1.5" fill="#c8392b"/></svg>
			<span class="widget-title">Categorias</span>
		</div>
		<div class="widget-body" style="padding-top:.6rem;padding-bottom:.6rem;">
			<div class="cat-list">
				<a href="#" class="cat-list-item active-cat" data-cat="todos">
					<span style="display:flex;align-items:center;"><span class="cat-dot" style="background:#c8392b;"></span>Todos os posts</span>
					<span class="cat-count"><?php echo (int) wp_count_posts()->publish; ?></span>
				</a>
				<?php
				$sidebar_cats = get_categories( array( 'hide_empty' => true ) );
				foreach ( $sidebar_cats as $cat ) :
					$dot = aqgoes_category_dot_color( $cat->slug );
					?>
					<a href="#" class="cat-list-item" data-cat="<?php echo esc_attr( $cat->slug ); ?>">
						<span style="display:flex;align-items:center;"><span class="cat-dot" style="background:<?php echo esc_attr( $dot ); ?>;"></span><?php echo esc_html( $cat->name ); ?></span>
						<span class="cat-count"><?php echo (int) $cat->count; ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- Tags -->
	<div class="sidebar-widget reveal">
		<div class="widget-header">
			<svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M1 7.5L7.5 1H14v6.5l-6.5 6.5L1 7.5z" stroke="#c8392b" stroke-width="1.3" stroke-linejoin="round"/><circle cx="11" cy="4" r="1.2" fill="#c8392b"/></svg>
			<span class="widget-title">Tags</span>
		</div>
		<div class="widget-body">
			<div class="tags-wrap" id="tags-wrap">
				<?php
				$sidebar_tags = get_tags( array( 'number' => 14, 'hide_empty' => true ) );
				foreach ( $sidebar_tags as $tag ) :
					?>
					<a href="#" class="tag-pill" data-tag="<?php echo esc_attr( $tag->slug ); ?>"><?php echo esc_html( $tag->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- Posts Recentes -->
	<div class="sidebar-widget reveal">
		<div class="widget-header">
			<svg width="15" height="15" viewBox="0 0 15 15" fill="none"><rect x="1" y="1" width="13" height="13" rx="2" stroke="#c8392b" stroke-width="1.3"/><path d="M4 5h7M4 8h5M4 11h4" stroke="#c8392b" stroke-width="1.3" stroke-linecap="round"/></svg>
			<span class="widget-title">Posts Recentes</span>
		</div>
		<div class="widget-body" style="padding-top:.5rem;padding-bottom:.5rem;">
			<?php
			$recent_q = new WP_Query( array( 'posts_per_page' => 4, 'post_status' => 'publish' ) );
			while ( $recent_q->have_posts() ) : $recent_q->the_post();
				?>
				<div class="recent-item">
					<div class="recent-thumb">
						<a href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'aqgoes-thumb', array( 'alt' => get_the_title() ) ); ?>
							<?php else : ?>
								<img src="<?php echo esc_url( AQGOES_URI . '/assets/img/placeholder-thumb.jpg' ); ?>" alt="<?php the_title_attribute(); ?>"/>
							<?php endif; ?>
						</a>
					</div>
					<div>
						<a href="<?php the_permalink(); ?>" class="recent-title"><?php the_title(); ?></a>
						<div class="recent-date"><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></div>
					</div>
				</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>

	<!-- Newsletter -->
	<div class="sidebar-widget reveal" style="background:#c8392b;border-color:#c8392b;">
		<div style="padding:1.4rem 1.3rem;">
			<div style="font-size:1.4rem;margin-bottom:.5rem;">📬</div>
			<h3 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#fff;margin-bottom:.4rem;">Receba novos artigos</h3>
			<p style="font-size:.78rem;color:rgba(255,255,255,.75);margin-bottom:1rem;line-height:1.5;">Sem spam. Apenas conteúdo técnico de qualidade toda semana.</p>
			<form method="post" action="">
				<input type="email" name="aqgoes_newsletter_email_sidebar" placeholder="seu@email.com" style="width:100%;padding:.6rem .85rem;border-radius:6px;border:none;font-size:.82rem;outline:none;margin-bottom:.6rem;font-family:'DM Sans',sans-serif;" required/>
				<button type="submit" style="width:100%;padding:.6rem;border-radius:6px;background:#fff;color:#c8392b;font-size:.82rem;font-weight:700;border:none;cursor:pointer;">
					Assinar newsletter
				</button>
			</form>
		</div>
	</div>

</aside>
