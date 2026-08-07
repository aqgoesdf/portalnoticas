<?php
/**
 * index.php — template de fallback obrigatório do WordPress.
 * Usado sempre que não existir um template mais específico
 * (search.php, category.php, tag.php, date.php, author.php etc.).
 * home.php continua sendo o template principal da listagem do blog.
 */
get_header();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

	<div class="mb-8 reveal visible">
		<span class="section-label" style="color:#c8392b;">
			<?php
			if ( is_search() ) {
				esc_html_e( 'Resultado da busca', 'aqgoes' );
			} elseif ( is_category() ) {
				esc_html_e( 'Categoria', 'aqgoes' );
			} elseif ( is_tag() ) {
				esc_html_e( 'Tag', 'aqgoes' );
			} elseif ( is_author() ) {
				esc_html_e( 'Autor', 'aqgoes' );
			} elseif ( is_date() ) {
				esc_html_e( 'Arquivo', 'aqgoes' );
			} else {
				esc_html_e( 'Blog', 'aqgoes' );
			}
			?>
		</span>
		<h1 class="font-display text-3xl md:text-4xl font-black mt-2" style="color:var(--text);">
			<?php
			if ( is_search() ) {
				printf( esc_html__( 'Resultados para: "%s"', 'aqgoes' ), esc_html( get_search_query() ) );
			} else {
				the_archive_title();
			}
			?>
		</h1>
	</div>

	<div class="blog-layout">
		<div>
			<div class="post-grid" id="post-grid">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post();
						$cat_slug  = aqgoes_post_cat_slug();
						$cstyle    = aqgoes_category_style( $cat_slug );
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
				<?php else : ?>
					<div class="no-results show" style="grid-column:1/-1;">
						<div style="font-size:3rem;margin-bottom:.75rem;">🔍</div>
						<h3 class="font-display text-xl font-bold mb-2" style="color:var(--text);">Nenhum resultado encontrado</h3>
						<p style="color:var(--muted);font-size:.875rem;">Tente outra busca ou volte para o <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:#c8392b;">blog</a>.</p>
					</div>
				<?php endif; ?>
			</div>

			<div class="flex justify-center mt-10 reveal visible">
				<div class="pagination">
					<?php the_posts_pagination( array( 'prev_text' => '←', 'next_text' => '→' ) ); ?>
				</div>
			</div>
		</div>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
