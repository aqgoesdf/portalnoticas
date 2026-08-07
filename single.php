<?php
/**
 * single.php — post individual.
 */
get_header();

while ( have_posts() ) : the_post();
	$post_id  = get_the_ID();
	$cat_slug = aqgoes_post_cat_slug( $post_id );
	$cstyle   = aqgoes_category_style( $cat_slug );
	$author_id = get_the_author_meta( 'ID' );
	?>

	<article <?php post_class( 'single-post' ); ?>>

		<!-- Hero do post -->
		<section class="blog-hero py-10">
			<div class="max-w-4xl mx-auto px-4 sm:px-6 hero-content">
				<div class="breadcrumb mb-4 fade-up d1">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
					<span class="sep">›</span>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--muted);text-decoration:none;">Blog</a>
					<span class="sep">›</span>
					<span><?php echo esc_html( get_the_category_list( ', ', '', $post_id ) ); ?></span>
				</div>

				<span class="featured-badge fade-up d1" style="background:<?php echo esc_attr( $cstyle['bg'] ); ?>;color:<?php echo esc_attr( $cstyle['color'] ); ?>;"><?php echo esc_html( $cstyle['emoji'] . ' ' . get_the_category_list( ', ', '', $post_id ) ); ?></span>

				<h1 class="font-display text-3xl md:text-5xl font-black text-white mt-3 leading-tight fade-up d2">
					<?php the_title(); ?>
				</h1>

				<div class="flex items-center gap-3 mt-5 fade-up d3">
					<?php echo get_avatar( $author_id, 40 ); ?>
					<div>
						<div style="color:#fff;font-size:.85rem;font-weight:600;"><?php the_author(); ?></div>
						<div style="font-family:'JetBrains Mono',monospace;font-size:.7rem;color:rgba(255,255,255,.55);">
							<?php echo esc_html( get_the_date( 'd M Y' ) ); ?> · <?php echo (int) aqgoes_reading_time( $post_id ); ?> min de leitura
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
			<div class="blog-layout">

				<div>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="single-thumb reveal visible mb-8">
							<?php the_post_thumbnail( 'aqgoes-featured', array( 'alt' => get_the_title() ) ); ?>
						</div>
					<?php endif; ?>

					<div class="post-content reveal visible">
						<?php the_content(); ?>
					</div>

					<?php
					$post_tags = get_the_tags( $post_id );
					if ( $post_tags && ! is_wp_error( $post_tags ) ) :
						?>
						<div class="tags-wrap mt-8 pt-6" style="border-top:1px solid var(--border);">
							<?php foreach ( $post_tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-pill"><?php echo esc_html( $tag->name ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- Caixa do autor -->
					<div class="author-box reveal visible mt-8">
						<?php echo get_avatar( $author_id, 64 ); ?>
						<div>
							<div class="author-box-name"><?php the_author(); ?></div>
							<?php $author_bio = get_the_author_meta( 'description', $author_id ); ?>
							<p class="author-box-bio"><?php echo esc_html( $author_bio ? $author_bio : 'Autor(a) no blog ' . get_bloginfo( 'name' ) . '.' ); ?></p>
						</div>
					</div>

					<!-- Navegação anterior/próximo -->
					<nav class="post-nav reveal visible mt-8" aria-label="Navegação entre posts">
						<?php
						$prev = get_previous_post();
						$next = get_next_post();
						?>
						<div class="post-nav-item">
							<?php if ( $prev ) : ?>
								<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
									<span class="post-nav-label">← Anterior</span>
									<span class="post-nav-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
								</a>
							<?php endif; ?>
						</div>
						<div class="post-nav-item post-nav-item-next">
							<?php if ( $next ) : ?>
								<a href="<?php echo esc_url( get_permalink( $next ) ); ?>">
									<span class="post-nav-label">Próximo →</span>
									<span class="post-nav-title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</nav>

					<?php
					$related = aqgoes_related_posts( $post_id, 3 );
					if ( $related->have_posts() ) :
						?>
						<div class="mt-12">
							<h2 class="font-display text-xl font-bold mb-5 reveal visible" style="color:var(--text);">Artigos relacionados</h2>
							<div class="post-grid">
								<?php while ( $related->have_posts() ) : $related->the_post();
									$rcat  = aqgoes_post_cat_slug();
									$rstyle = aqgoes_category_style( $rcat );
									?>
									<article class="post-card reveal visible">
										<a href="<?php the_permalink(); ?>" class="post-card-img">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'aqgoes-card', array( 'alt' => get_the_title() ) ); ?>
											<?php else : ?>
												<img src="<?php echo esc_url( AQGOES_URI . '/assets/img/placeholder-card.jpg' ); ?>" alt="<?php the_title_attribute(); ?>"/>
											<?php endif; ?>
										</a>
										<div class="post-card-body">
											<span class="post-card-cat" style="background:<?php echo esc_attr( $rstyle['bg'] ); ?>;color:<?php echo esc_attr( $rstyle['color'] ); ?>;"><?php echo esc_html( $rstyle['emoji'] . ' ' . get_the_category_list( ', ' ) ); ?></span>
											<h3 class="post-card-title"><a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;"><?php the_title(); ?></a></h3>
											<div class="post-card-footer">
												<span class="post-card-read"><?php echo (int) aqgoes_reading_time(); ?> min</span>
											</div>
										</div>
									</article>
								<?php endwhile; wp_reset_postdata(); ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( comments_open() || get_comments_number() ) : ?>
						<div class="mt-12 reveal visible">
							<?php comments_template(); ?>
						</div>
					<?php endif; ?>

				</div>

				<?php get_sidebar(); ?>
			</div>
		</div>
	</article>

<?php endwhile; ?>

<?php get_footer(); ?>
