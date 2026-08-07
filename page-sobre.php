<?php
/**
 * Template Name: Sobre (AqGoEs)
 *
 * page-sobre.php — aplicado automaticamente pelo WordPress na página
 * cujo slug seja "sobre". Também pode ser escolhido manualmente em
 * Atributos da Página → Modelo, em qualquer outra página.
 */
get_header();

while ( have_posts() ) : the_post();
	?>

	<section class="blog-hero py-14">
		<div class="max-w-4xl mx-auto px-4 sm:px-6 hero-content">
			<div class="breadcrumb mb-4 fade-up d1">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
				<span class="sep">›</span>
				<span>Sobre</span>
			</div>
			<span class="section-label fade-up d1" style="color:rgba(200,57,43,.8);">Quem escreve</span>
			<h1 class="font-display text-4xl md:text-5xl font-black text-white mt-2 leading-tight fade-up d2">
				<?php the_title(); ?>
			</h1>
			<p class="text-white/60 mt-2 text-sm max-w-lg fade-up d3">
				<?php echo esc_html( get_theme_mod( 'aqgoes_sobre_subtitle', 'Desenvolvimento web, do backend ao front-end — documentando o processo de aprender na prática.' ) ); ?>
			</p>
		</div>
	</section>

	<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="single-thumb reveal visible mb-8">
				<?php the_post_thumbnail( 'aqgoes-featured', array( 'alt' => get_the_title() ) ); ?>
			</div>
		<?php endif; ?>

		<div class="post-content reveal visible">
			<?php
			if ( trim( get_the_content() ) ) {
				the_content();
			} else {
				?>
				<p>Edite esta página no wp-admin para contar sua história aqui — trajetória, o que te trouxe para desenvolvimento web, e o que você quer construir com o AqGoEs-DeV.</p>
				<?php
			}
			?>
		</div>

		<!-- Stack -->
		<div class="mt-10 reveal visible">
			<h2 class="font-display text-xl font-bold mb-4" style="color:var(--text);">Stack & Ferramentas</h2>
			<div class="flex flex-wrap gap-2.5">
				<span class="skill-pill">🌐 HTML &amp; CSS</span>
				<span class="skill-pill">⚡ JavaScript</span>
				<span class="skill-pill">🐍 Python</span>
				<span class="skill-pill">🐘 PHP</span>
				<span class="skill-pill">📝 WordPress</span>
				<span class="skill-pill">🎨 Tailwind CSS</span>
				<span class="skill-pill">🔧 Infraestrutura & Redes</span>
			</div>
		</div>

		<!-- CTA -->
		<div class="mt-10 reveal visible" style="background:#c8392b;border-radius:16px;padding:2rem;">
			<h3 style="font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:800;color:#fff;margin-bottom:.5rem;">Bora trocar uma ideia?</h3>
			<p style="font-size:.875rem;color:rgba(255,255,255,.8);margin-bottom:1.25rem;">Projeto, dúvida técnica ou só quer dizer oi — me chama.</p>
			<a href="<?php echo esc_url( home_url( '/contato' ) ); ?>" class="inline-flex items-center px-5 py-2.5 rounded-md text-sm font-bold" style="background:#fff;color:#c8392b;text-decoration:none;">Falar comigo →</a>
		</div>

	</div>

	<?php
endwhile;

get_footer();
