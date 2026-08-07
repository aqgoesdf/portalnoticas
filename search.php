<?php
/**
 * search.php — resultados de busca (?s=).
 */
get_header();
?>

<section class="blog-hero py-14">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 hero-content">
		<div class="breadcrumb mb-4 fade-up d1">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
			<span class="sep">›</span>
			<span>Busca</span>
		</div>
		<span class="section-label fade-up d1" style="color:rgba(200,57,43,.8);">Resultado da busca</span>
		<h1 class="font-display text-3xl md:text-4xl font-black text-white mt-2 leading-tight fade-up d2">
			<?php
			printf(
				/* translators: %s = termo pesquisado */
				esc_html__( 'Você pesquisou por: "%s"', 'aqgoes' ),
				esc_html( get_search_query() )
			);
			?>
		</h1>
		<p class="text-white/60 mt-2 text-sm max-w-lg fade-up d3">
			<?php
			global $wp_query;
			printf(
				esc_html( _n( '%d artigo encontrado.', '%d artigos encontrados.', $wp_query->found_posts, 'aqgoes' ) ),
				(int) $wp_query->found_posts
			);
			?>
		</p>
	</div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
	<div class="blog-layout">
		<div>

			<?php if ( have_posts() ) : ?>
				<div class="post-grid" id="post-grid">
					<?php while ( have_posts() ) : the_post();
						$cat_slug = aqgoes_post_cat_slug();
						$cstyle   = aqgoes_category_style( $cat_slug );
						?>
						<article class="post-card reveal visible" data-cat="<?php echo esc_attr( $cat_slug ); ?>" data-tags="<?php echo esc_attr( aqgoes_post_tags_data() ); ?>" data-title="<?php echo esc_attr( get_the_title() ); ?>">
							<a href="<?php the_permalink(); ?>" class="post-card-img">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'aqgoes-card', array( 'alt' => get_the_title() ) ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( AQGOES_URI . '/assets/img/placeholder-card.jpg' ); ?>" alt="<?php the_title_attribute(); ?>"/>
								<?php endif; ?>
							</a>
							<div class="post-card-body">
								<span class="post-card-cat" style="background:<?php echo esc_attr( $cstyle['bg'] ); ?>;color:<?php echo esc_attr( $cstyle['color'] ); ?>;"><?php echo esc_html( $cstyle['emoji'] . ' ' . get_the_category_list( ', ' ) ); ?></span>
								<h3 class="post-card-title">
									<a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;"><?php the_title(); ?></a>
								</h3>
								<p class="post-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
								<div class="post-card-footer">
									<div class="post-card-author">
										<?php echo get_avatar( get_the_author_meta( 'ID' ), 28 ); ?>
										<span class="post-card-author-name"><?php the_author(); ?></span>
									</div>
									<span class="post-card-read"><?php echo (int) aqgoes_reading_time(); ?> min</span>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<div class="flex justify-center mt-10 reveal visible">
					<div class="pagination">
						<?php the_posts_pagination( array( 'prev_text' => '←', 'next_text' => '→' ) ); ?>
					</div>
				</div>

			<?php else : ?>
				<div class="no-results show">
					<div style="font-size:3rem;margin-bottom:.75rem;">🔍</div>
					<h3 class="font-display text-xl font-bold mb-2" style="color:var(--text);">Nenhum resultado encontrado</h3>
					<p style="color:var(--muted);font-size:.875rem;margin-bottom:1.25rem;">Tente outros termos ou explore as categorias na lateral.</p>
					<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="max-width:360px;margin:0 auto;">
						<div class="search-wrap">
							<input type="text" class="search-input" name="s" placeholder="Pesquisar artigos…" value="<?php echo esc_attr( get_search_query() ); ?>"/>
							<svg class="search-icon" width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="6" cy="6" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M9.5 9.5l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
						</div>
					</form>
				</div>
			<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
