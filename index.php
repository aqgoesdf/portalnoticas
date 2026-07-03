<?php get_header(); ?>

<main>
    <!-- ═══════════════════════════════════════
     SEÇÃO 1 — CARROSSEL (DINÂMICO)
═══════════════════════════════════════ -->
<section id="carousel-section" class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

  <div class="flex items-center justify-between mb-4">
    <div>
      <span class="section-label">Em Destaque</span>
      <h2 class="section-heading text-2xl font-bold mt-0.5" style="color:var(--text)">Principais Notícias</h2>
    </div>
    <!-- O total de slides (/ 4) será calculado pelo JS lendo os filhos do container 'track' -->
    <span class="text-xs" style="color:var(--muted)" id="slide-counter">1 / 4</span>
  </div>

  <div class="relative rounded-2xl overflow-hidden" style="height: clamp(280px, 52vw, 520px);">
    <div class="carousel-track h-full" id="track">

      <?php
      // Criamos uma consulta customizada para buscar os 4 posts mais recentes
      $carousel_query = new WP_Query(array(
          'posts_per_page' => 4,
          'post_status'    => 'publish'
      ));

      // Iniciamos o contador para manter as classes de animação (fade-up) exclusivas do slide inicial se desejar
      $slide_index = 0;

      if ($carousel_query->have_posts()) :
          while ($carousel_query->have_posts()) : $carousel_query->the_post();
              
              // Coleta a URL da imagem destacada do post, se não houver, usa uma padrão do Unsplash
              if (has_post_thumbnail()) {
                  $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
              } else {
                  $image_url = 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1200&q=80';
              }

              // Coleta a primeira categoria vinculada ao post para atuar como TAG
              $categories = get_the_category();
              $category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Geral';
              ?>

              <!-- slide individual -->
              <div class="carousel-slide h-full" style="background: linear-gradient(135deg,#1a0a06,#3d1206);">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover opacity-60"/>
                <div class="slide-overlay"></div>
                <div class="absolute bottom-0 left-0 p-6 md:p-10 max-w-2xl">
                  
                  <span class="tag mb-3 <?php echo ($slide_index === 0) ? 'fade-up' : ''; ?>">
                    <?php echo $category_name; ?>
                  </span>
                  
                  <h3 class="font-display text-white text-2xl md:text-4xl font-bold leading-tight <?php echo ($slide_index === 0) ? 'fade-up delay-1' : ''; ?>">
                    <a href="<?php the_permalink(); ?>" class="hover:underline">
                        <?php the_title(); ?>
                    </a>
                  </h3>
                  
                  <p class="text-white/75 text-sm mt-2 hidden sm:block <?php echo ($slide_index === 0) ? 'fade-up delay-2' : ''; ?>">
                    <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
                  </p>
                  
                  <div class="flex items-center gap-3 mt-4 <?php echo ($slide_index === 0) ? 'fade-up delay-3' : ''; ?>">
                    <!-- Avatar dinâmico do Autor do post -->
                    <?php echo get_avatar(get_the_author_meta('ID'), 28, '', '', array('class' => 'rounded-full w-7 h-7')); ?>
                    <span class="text-white/70 text-xs">
                        <?php the_author(); ?> · <?php echo get_the_date('d M Y'); ?>
                    </span>
                  </div>

                </div>
              </div>

              <?php
              $slide_index++;
          endwhile;
          // Reseta os dados globais de post do WordPress após finalizar o loop customizado
          wp_reset_postdata();
      else :
          // Fallback caso você ainda não tenha nenhum post cadastrado no painel local
          ?>
          <div class="carousel-slide h-full flex items-center justify-center bg-zinc-800">
              <p class="text-white">Nenhum post encontrado para o carrossel. Crie posts no painel administrativo!</p>
          </div>
      <?php endif; ?>

    </div><!-- /track -->

    <!-- Progress bar -->
    <div style="position:absolute;bottom:0;left:0;right:0;height:3px;background:rgba(255,255,255,.15);">
      <div id="progress-bar" style="width:0%;"></div>
    </div>

    <!-- Prev / Next -->
    <button class="carousel-btn" style="left:16px;" onclick="changeSlide(-1)" aria-label="Anterior">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M11 4L6 9l5 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </button>
    <button class="carousel-btn" style="right:16px;" onclick="changeSlide(1)" aria-label="Próximo">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M7 4l5 5-5 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </button>

    <!-- Dots (Gerados e injetados dinamicamente via JS na quantidade ideal) -->
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2" id="dots"></div>
  </div>
</section>


<!-- ═══════════════════════════════════════
     SEÇÃO 2 — 4 CARDS DE NOTÍCIAS (DINÂMICO)
═══════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

  <div class="flex items-center justify-between mb-6">
    <div>
      <span class="section-label">Mais Lidas</span>
      <h2 class="section-heading text-2xl font-bold mt-0.5" style="color:var(--text)">Notícias Recentes</h2>
    </div>
    <!-- Link para a página de arquivo de posts nativa do WordPress -->
    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="read-more hidden sm:block">Ver todas →</a>
  </div>

  <div class="cards-grid">

    <?php
    // Criamos uma consulta para buscar as próximas 4 notícias pulando as 4 do carrossel
    $cards_query = new WP_Query(array(
        'posts_per_page' => 4,
        'offset'         => 4,
        'post_status'    => 'publish'
    ));

    if ($cards_query->have_posts()) :
        while ($cards_query->have_posts()) : $cards_query->the_post();

            // Resgata a imagem destacada ou define um link padrão caso não exista
            if (has_post_thumbnail()) {
                $card_image = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
            } else {
                $card_image = 'https://images.unsplash.com/photo-1465101162946-4377e57745c3?w=600&q=75';
            }

            // Pega a primeira categoria do post
            $categories = get_the_category();
            $category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Geral';
            ?>

            <!-- card individual -->
            <article class="news-card">
              <div class="relative overflow-hidden" style="height:180px;">
                <img src="<?php echo esc_url($card_image); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"/>
                <span class="tag absolute top-3 left-3"><?php echo $category_name; ?></span>
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
        // Restaura a query global padrão do WordPress
        wp_reset_postdata();
    else :
        // Caso seu WordPress local tenha menos de 5 posts criados, o offset pode retornar vazio. 
        // Como fallback temporário, listamos posts normais sem pular o carrossel.
        $fallback_query = new WP_Query(array('posts_per_page' => 4));
        if ($fallback_query->have_posts()) :
            while ($fallback_query->have_posts()) : $fallback_query->the_post();
                // (Mesma estrutura exata do card acima)
                if (has_post_thumbnail()) { $card_image = get_the_post_thumbnail_url(get_the_ID(), 'medium_large'); }
                else { $card_image = 'https://images.unsplash.com/photo-1465101162946-4377e57745c3?w=600&q=75'; }
                $categories = get_the_category(); $category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Geral';
                ?>
                <article class="news-card">
                  <div class="relative overflow-hidden" style="height:180px;">
                    <img src="<?php echo esc_url($card_image); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"/>
                    <span class="tag absolute top-3 left-3"><?php echo $category_name; ?></span>
                  </div>
                  <div class="p-4">
                    <h4 class="font-display font-bold text-base leading-snug mb-2" style="color:var(--text)">
                      <a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a>
                    </h4>
                    <p class="text-xs leading-relaxed mb-3" style="color:var(--muted)"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                    <div class="flex items-center justify-between">
                      <span class="text-xs" style="color:var(--muted)"><?php echo get_the_date('d M Y'); ?></span>
                      <a href="<?php the_permalink(); ?>" class="read-more">Leia mais →</a>
                    </div>
                  </div>
                </article>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
    endif; ?>

  </div>

  <div class="text-center mt-5 sm:hidden">
    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="read-more text-sm">Ver todas as notícias →</a>
  </div>
</section>


<!-- ═══════════════════════════════════════
     SEÇÃO 3 — CHAMADA PARA AÇÃO (DINÂMICO)
═══════════════════════════════════════ -->
<section class="cta-section my-8 py-16 px-4">
  <div class="max-w-3xl mx-auto text-center relative z-10">
    <span class="inline-block text-xs tracking-widest uppercase font-bold text-white/60 mb-3">
      Nosso Blog
    </span>
    
    <h2 class="font-display text-3xl md:text-5xl font-black text-white leading-tight mb-4">
      Análises profundas,<br class="hidden sm:block"/> sem pressa e sem ruído
    </h2>
    
    <p class="text-white/75 text-base md:text-lg mb-8 max-w-xl mx-auto">
      No blog AqGoEs, nossos editores e colunistas vão além das manchetes. Leituras que informam, provocam e inspiram.
    </p>
    
    <!-- Link dinâmico apontando para a listagem principal do blog -->
    <a href="<?php echo esc_url(get_post_type_archive_link('post') ? get_post_type_archive_link('post') : home_url('/')); ?>" class="cta-btn text-base">
      Explorar o Blog &rarr;
    </a>
    
    <p class="text-white/45 text-xs mt-5">Sem cadastro. Totalmente gratuito.</p>
  </div>
</section>


</main>

<?php get_footer(); ?>