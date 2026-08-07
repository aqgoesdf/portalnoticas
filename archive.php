<?php
/**
 * Template de Arquivo Geral - Tags, Autores e Datas (archive.php)
 *
 * @package aqgoes-theme
 */

get_header(); 
?>

<main>

<section class="blog-hero py-14">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 hero-content">
    <div class="breadcrumb mb-4 fade-up d1">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
      <span class="sep">›</span>
      <span>Arquivo</span>
    </div>

    <span class="section-label fade-up d1" style="color:rgba(200,57,43,.8);">Listagem de Arquivos</span>
    <h1 class="font-display text-4xl md:text-5xl font-black text-white mt-2 leading-tight fade-up d2">
      <?php the_archive_title(); ?>
    </h1>
    <p class="text-white/60 mt-2 text-sm max-w-lg fade-up d3">
      <?php the_archive_description(); ?>
    </p>
  </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
  <div class="blog-layout grid grid-cols-1 lg:grid-cols-12 gap-10">
    <div class="lg:col-span-8">
      <div class="post-grid grid grid-cols-1 sm:grid-cols-2 gap-6">
        <?php if ( have_posts() ) : ?>
          <?php while ( have_posts() ) : the_post(); ?>
            <article class="post-card p-5 rounded-xl transition-transform duration-300 hover:-translate-y-1" style="background:var(--surface);border:1px solid var(--border);">
              <h3 class="font-display text-lg font-bold mb-2">
                <a href="<?php the_permalink(); ?>" style="color:var(--text);"><?php the_title(); ?></a>
              </h3>
              <p class="text-xs leading-relaxed mb-4 line-clamp-3" style="color:var(--muted);"><?php echo get_the_excerpt(); ?></p>
            </article>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
      
      <div class="mt-8">
        <?php the_posts_pagination(); ?>
      </div>
    </div>

    <div class="lg:col-span-4">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>

</main>

<?php get_footer(); ?>