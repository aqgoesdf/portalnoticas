<?php get_header(); ?>

<!-- ═══════════════════════════════════════
     PÁGINA DE ARTIGOS (FEED DO BLOG)
═══════════════════════════════════════ -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
  <div class="mb-10 text-center md:text-left">
    <span class="section-label">Feed</span>
    <h1 class="text-3xl md:text-5xl font-black mt-2" style="color:var(--text)">Todos os Artigos</h1>
    <p class="text-sm mt-2" style="color:var(--muted)">Fique por dentro das últimas atualizações do blog.</p>
  </div>

  <!-- Mantendo a sua classe original de grid para os cards de notícias -->
  <div class="cards-grid">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            $blog_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=600&q=75';
            $blog_categories = get_the_category();
            $blog_cat_name = !empty($blog_categories) ? esc_html($blog_categories[0]->name) : 'Geral';
            ?>
            <article class="news-card">
              <div class="relative overflow-hidden" style="height:180px;">
                <img src="<?php echo esc_url($blog_image); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"/>
                <span class="tag absolute top-3 left-3"><?php echo $blog_cat_name; ?></span>
              </div>
              <div class="p-4">
                <h4 class="font-display font-bold text-base leading-snug mb-2" style="color:var(--text)">
                  <a href="<?php the_permalink(); ?>" class="hover:underline">
                    <?php the_title(); ?>
                  </a>
                </h4>
                <p class="text-xs leading-relaxed mb-3" style="color:var(--muted)">
                  <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                </p>
                <div class="flex items-center justify-between">
                  <span class="text-xs" style="color:var(--muted)"><?php echo get_the_date('d M Y'); ?></span>
                  <a href="<?php the_permalink(); ?>" class="read-more">Leia mais →</a>
                </div>
              </div>
            </article>
            <?php
        endwhile;

        // PAGINAÇÃO NATIVA DO WP COM SUAS CLASSES
        echo '<div class="col-span-full flex justify-center gap-4 mt-8">';
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => __('← Anterior', 'aqgoes'),
            'next_text' => __('Próximo →', 'aqgoes'),
        ));
        echo '</div>';

    else :
        ?>
        <p class="text-sm col-span-full text-center" style="color:var(--muted)">Nenhum artigo publicado ainda.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>