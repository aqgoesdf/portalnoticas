<?php
/**
 * page.php — template genérico para Páginas do WordPress
 * (usado quando não existe page-{slug}.php específico).
 */
get_header();

while ( have_posts() ) : the_post();
	?>
	<section class="blog-hero py-10">
		<div class="max-w-4xl mx-auto px-4 sm:px-6 hero-content">
			<div class="breadcrumb mb-4 fade-up d1">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
				<span class="sep">›</span>
				<span><?php the_title(); ?></span>
			</div>
			<h1 class="font-display text-3xl md:text-4xl font-black text-white mt-2 leading-tight fade-up d2">
				<?php the_title(); ?>
			</h1>
		</div>
	</section>

	<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="single-thumb reveal visible mb-8">
				<?php the_post_thumbnail( 'aqgoes-featured', array( 'alt' => get_the_title() ) ); ?>
			</div>
		<?php endif; ?>

		<div class="post-content reveal visible">
			<?php the_content(); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
