<?php
/**
 * Template Oficial para a Listagem de Todos os Posts (Blog)
 *
 * @package aqgoes-theme
 */

get_header(); 

$total_published_posts = wp_count_posts()->publish;
?>

<main>

<!-- ═══════════════════════════ HEADER BLOG ═══════════════════════════ -->
<section class="blog-hero py-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 hero-content">
    <div class="breadcrumb mb-3 fade-up d1">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
      <span class="sep">›</span>
      <span>Blog</span>
    </div>
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
      <div>
        <span class="section-label fade-up d1" style="color:rgba(200,57,43,.8);">Acervo de Conteúdo</span>
        <h1 class="font-display text-3xl md:text-4xl font-black text-white mt-1 leading-tight fade-up d2">
          Todos os Artigos
        </h1>
        <p class="text-white/60 mt-1 text-sm max-w-lg fade-up d3">
          Explore todos os tutoriais, guias e publicações em ordem cronológica.
        </p>
      </div>

      <div class="fade-up d4 flex items-center gap-2" style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:.5rem .9rem;">
        <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;box-shadow:0 0 6px #4ade80;"></span>
        <span style="font-family:'JetBrains Mono',monospace;font-size:.72rem;color:rgba(255,255,255,.65);">
          <?php echo esc_html( $total_published_posts ); ?> artigos no total
        </span>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════ LISTAGEM COMPLETA ═══════════════════════════ -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
  <div class="blog-layout">

    <!-- COLUNA PRINCIPAL DE POSTS -->
    <div>
      <div class="post-grid" id="post-grid">
        <?php if ( have_posts() ) : ?>
          <?php while ( have_posts() ) : the_post(); ?>
            <?php 
            $cats = get_the_category();
            $primary_cat = ! empty( $cats ) ? $cats[0] : null;
            ?>

            <article class="post-card reveal">
              <div class="post-card-img">
                <a href="<?php the_permalink(); ?>">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
                  <?php else : ?>
                    <img src="https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=600&q=75" alt="post"/>
                  <?php endif; ?>
                </a>
              </div>

              <div class="post-card-body">
                <?php if ( $primary_cat ) : ?>
                  <span class="post-card-cat" style="background:rgba(200,57,43,.12);color:#c8392b;">
                    <?php echo esc_html( $primary_cat->name ); ?>
                  </span>
                <?php endif; ?>

                <h2 class="post-card-title">
                  <a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;">
                    <?php the_title(); ?>
                  </a>
                </h2>

                <p class="post-card-excerpt">
                  <?php echo get_the_excerpt(); ?>
                </p>

                <div class="post-card-footer">
                  <div class="post-card-author">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 28, '', 'autor', array( 'class' => 'rounded-full' ) ); ?>
                    <span class="post-card-author-name"><?php the_author(); ?></span>
                  </div>
                  <span class="post-card-read"><?php echo get_the_date('d M Y'); ?></span>
                </div>
              </div>
            </article>

          <?php endwhile; ?>
        <?php else : ?>
          <div class="no-results" style="display:block; grid-column:1/-1;">
            <div style="font-size:3rem;margin-bottom:.75rem;">🔍</div>
            <h3 class="font-display text-xl font-bold mb-2" style="color:var(--text);">Nenhum artigo publicado</h3>
            <p style="color:var(--muted);font-size:.875rem;">Volte em breve para acompanhar novos conteúdos.</p>
          </div>
        <?php endif; ?>
      </div>

      <!-- Paginação -->
      <div class="flex justify-center mt-10 reveal">
        <div class="pagination">
          <?php
          echo paginate_links( array(
              'prev_text' => '←',
              'next_text' => '→',
              'type'      => 'plain',
          ) );
          ?>
        </div>
      </div>
    </div>

    <!-- SIDEBAR -->
    <?php get_sidebar(); ?>

  </div>
</div>

</main>

<?php get_footer(); ?>