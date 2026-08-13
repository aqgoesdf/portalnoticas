<?php get_header(); ?>


<main class="flex-grow pt-28">



  <!-- HERO SECTION / DESTAQUES (1 Maior + 3 Menores) -->
  <section id="hero" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
      <h2 class="font-title text-2xl sm:text-3xl font-extrabold tracking-tight">Em Destaque</h2>
    </div>

    <?php
    // Query para buscar os 4 posts mais recentes
    $featured_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 5,
        'ignore_sticky_posts' => 1,
    );
    $featured_query = new WP_Query( $featured_args );

    if ( $featured_query->have_posts() ) :
    ?>
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <?php 
        while ( $featured_query->have_posts() ) : $featured_query->the_post(); 
          
          // Pega a primeira categoria do post
          $categories = get_the_category();
          $primary_category = ! empty( $categories ) ? esc_html( $categories[0]->name ) : 'Geral';

          // Iniciais do autor para o avatar
          $author_name  = get_the_author();
          $author_words = explode( ' ', $author_name );
          $initials     = '';
          foreach ( $author_words as $word ) {
              $initials .= strtoupper( substr( $word, 0, 1 ) );
          }
          $initials = substr( $initials, 0, 2 ); // Limita a 2 letras

          // --- 1. POST PRINCIPAL (DESTAQUE GRANDE - ÍNDICE 0) ---
          if ( $featured_query->current_post === 0 ) :
        ?>
            <article class="lg:col-span-7 group rounded-2xl border border-subtle bg-secondary overflow-hidden flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
              <a href="<?php the_permalink(); ?>" class="block aspect-video w-full overflow-hidden bg-subtle">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105' ) ); ?>
                <?php else : ?>
                  <img src="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?auto=format&fit=crop&w=1200&q=80" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                <?php endif; ?>
              </a>

              <div class="p-6 sm:p-8 flex-grow flex flex-col justify-between">
                <div>
                  <div class="flex items-center gap-3 text-xs font-semibold text-brand mb-3">
                    <span class="uppercase tracking-wider"><?php echo $primary_category; ?></span>
                    <span>•</span>
                    <span class="text-muted"><?php echo esc_html( ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) ); ?> min de leitura</span>
                  </div>

                  <h3 class="font-title text-2xl sm:text-3xl font-bold mb-4 group-hover:text-brand transition-colors">
                    <a href="<?php the_permalink(); ?>">
                      <?php the_title(); ?>
                    </a>
                  </h3>

                  <p class="text-muted text-sm sm:text-base mb-6 line-clamp-3">
                    <?php echo wp_trim_words( get_the_excerpt(), 25, '...' ); ?>
                  </p>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-subtle">
                  <div class="w-9 h-9 rounded-full bg-brand/20 text-brand font-bold flex items-center justify-center text-sm">
                    <?php echo esc_html( $initials ); ?>
                  </div>
                  <div>
                    <p class="text-xs font-semibold"><?php the_author(); ?></p>
                    <p class="text-xs text-muted"><?php echo get_the_date( 'j \d\e F, Y' ); ?></p>
                  </div>
                </div>
              </div>
            </article>

            <!-- Abertura da coluna dos 3 posts secundários -->
            <div class="lg:col-span-5 flex flex-col gap-4">

          <?php 
          // --- 2. POSTS SECUNDÁRIOS (POSTS 1, 2 E 3) ---
          else : 
          ?>
            <article class="group rounded-2xl border border-subtle bg-secondary p-5 flex gap-4 items-center transition-all duration-300 hover:border-brand/50 hover:shadow-md">
              <a href="<?php the_permalink(); ?>" class="w-24 h-24 sm:w-28 sm:h-28 rounded-xl overflow-hidden flex-shrink-0 bg-subtle block">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105' ) ); ?>
                <?php else : ?>
                  <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=400&q=80" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                <?php endif; ?>
              </a>

              <div class="flex-grow">
                <span class="text-xs font-semibold text-brand uppercase tracking-wider"><?php echo $primary_category; ?></span>
                <h4 class="font-title text-base sm:text-lg font-bold mt-1 group-hover:text-brand transition-colors line-clamp-2">
                  <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                  </a>
                </h4>
                <p class="text-xs text-muted mt-2"><?php echo get_the_date( 'j \d\e F, Y' ); ?></p>
              </div>
            </article>
          <?php 
          endif; 

        endwhile; 
        ?>

        <!-- Fechamento da coluna secundária se houver mais de 1 post -->
        <?php if ( $featured_query->post_count > 1 ) : ?>
          </div>
        <?php endif; ?>

      </div>
    <?php 
      wp_reset_postdata(); // Restaura a consulta global original do WordPress
    else : 
    ?>
      <p class="text-muted">Nenhum artigo publicado até o momento.</p>
    <?php endif; ?>
  </section>






 <!-- SEÇÃO CATEGORIAS E GRID DE ARTIGOS -->
<section id="categorias" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
      <h2 class="font-title text-2xl sm:text-3xl font-extrabold tracking-tight">Explore por Categoria</h2>
      <p class="text-muted text-sm mt-1">Filtre os conteúdos de acordo com o seu interesse técnico.</p>
    </div>
    
    <!-- Lista / Pills de Categorias Dinâmicas -->
    <div class="flex flex-wrap gap-2">
      <!-- Botão para Todos os Artigos -->
      <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url('/') ); ?>" 
         class="px-4 py-2 rounded-xl text-xs font-semibold bg-brand text-white transition-all hover:bg-brand-hover">
        Todos
      </a>

      <?php
      // Busca todas as categorias que possuem pelo menos 1 post publicado
      $categories = get_categories( array(
          'orderby'    => 'name',
          'order'      => 'ASC',
          'hide_empty' => true,
      ) );

      foreach ( $categories as $category ) :
          $category_link = get_category_link( $category->term_id );
      ?>
        <a href="<?php echo esc_url( $category_link ); ?>" 
           class="px-4 py-2 rounded-xl text-xs font-semibold bg-secondary border border-subtle hover:border-brand transition-all text-primary">
          <?php echo esc_html( $category->name ); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <?php
  // Configuração e Lógica da Paginação
  $paged          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
  $posts_per_page = 6; // Quantidade de cards por página no grid
  
  // Offset para desconsiderar os 4 posts principais exibidos na Hero Section
  $offset = ( $paged === 1 ) ? 4 : 4 + ( ( $paged - 1 ) * $posts_per_page );

  // Query customizada do Grid
  $grid_args = array(
      'post_type'      => 'post',
      'posts_per_page' => $posts_per_page,
      'paged'          => $paged,
      'offset'         => $offset,
  );

  $grid_query = new WP_Query( $grid_args );

  if ( $grid_query->have_posts() ) :
  ?>
    <!-- Grid de 3 Colunas com Artigos -->
    <div id="artigos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      
      <?php 
      while ( $grid_query->have_posts() ) : $grid_query->the_post(); 

        // Categoria Principal
        $post_cats = get_the_category();
        $cat_name  = ! empty( $post_cats ) ? $post_cats[0]->name : 'Geral';

        // Tempo Estimado de Leitura
        $word_count   = str_word_count( wp_strip_all_tags( get_the_content() ) );
        $reading_time = ceil( $word_count / 200 ); // Média de 200 palavras por minuto
      ?>
        <!-- Card do Artigo -->
        <article class="rounded-2xl border border-subtle bg-secondary overflow-hidden flex flex-col group transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
          <a href="<?php the_permalink(); ?>" class="aspect-video w-full overflow-hidden bg-subtle block">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105' ) ); ?>
            <?php else : ?>
              <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
            <?php endif; ?>
          </a>

          <div class="p-6 flex-grow flex flex-col justify-between">
            <div>
              <span class="text-xs font-semibold text-brand uppercase tracking-wider"><?php echo esc_html( $cat_name ); ?></span>
              
              <h3 class="font-title text-xl font-bold mt-2 mb-3 group-hover:text-brand transition-colors line-clamp-2">
                <a href="<?php the_permalink(); ?>">
                  <?php the_title(); ?>
                </a>
              </h3>

              <p class="text-muted text-sm line-clamp-2">
                <?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
              </p>
            </div>

            <div class="mt-6 pt-4 border-t border-subtle flex items-center justify-between text-xs text-muted">
              <span><?php echo get_the_date( 'd \d\e F, Y' ); ?></span>
              <span><?php echo $reading_time; ?> min</span>
            </div>
          </div>
        </article>
      <?php endwhile; ?>

    </div>

    <?php
    // Cálculo do total real de páginas considerando o offset
    $total_posts   = max( 0, $grid_query->found_posts - 4 );
    $max_num_pages = ceil( $total_posts / $posts_per_page );

    if ( $max_num_pages > 1 ) :
    ?>
      <!-- Paginação Estilizada -->
      <div class="mt-12 flex justify-center items-center gap-2">
        
        <!-- Botão Anterior -->
        <?php if ( $paged > 1 ) : ?>
          <a href="<?php echo esc_url( get_pagenum_link( $paged - 1 ) ); ?>" 
             class="p-2.5 rounded-xl border border-subtle bg-secondary hover:border-brand text-xs font-semibold transition-all">
            Anterior
          </a>
        <?php else : ?>
          <button disabled class="p-2.5 rounded-xl border border-subtle bg-secondary text-xs font-semibold opacity-50 cursor-not-allowed">
            Anterior
          </button>
        <?php endif; ?>

        <!-- Contador de Páginas -->
        <span class="px-4 py-2 text-xs font-semibold">
          Página <?php echo $paged; ?> de <?php echo $max_num_pages; ?>
        </span>

        <!-- Botão Próxima -->
        <?php if ( $paged < $max_num_pages ) : ?>
          <a href="<?php echo esc_url( get_pagenum_link( $paged + 1 ) ); ?>" 
             class="p-2.5 rounded-xl border border-subtle bg-secondary hover:border-brand text-xs font-semibold transition-all">
            Próxima
          </a>
        <?php else : ?>
          <button disabled class="p-2.5 rounded-xl border border-subtle bg-secondary text-xs font-semibold opacity-50 cursor-not-allowed">
            Próxima
          </button>
        <?php endif; ?>

      </div>
    <?php endif; ?>

  <?php 
    wp_reset_postdata();
  else : 
  ?>
    <p class="text-muted text-center py-8">Nenhum artigo encontrado.</p>
  <?php endif; ?>
</section>




<!-- CALL TO ACTION (CTA) BANNER -->
<section id="newsletter" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="rounded-3xl bg-brand text-white p-8 sm:p-12 relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8 shadow-2xl">
    
    <!-- Elemento Decorativo Background -->
    <div class="absolute -right-12 -bottom-12 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>

    <!-- Texto do CTA (Editável via Customizer ou Fixo) -->
    <div class="max-w-xl z-10 text-center lg:text-left">
      <h2 class="font-title text-2xl sm:text-4xl font-extrabold tracking-tight">
        <?php echo esc_html( get_theme_mod( 'aqgoes_cta_title', 'Receba artigos técnicos direto no seu e-mail.' ) ); ?>
      </h2>
      <p class="mt-3 text-white/80 text-sm sm:text-base">
        <?php echo esc_html( get_theme_mod( 'aqgoes_cta_description', 'Junte-se a mais de 5.000 desenvolvedores. Sem spam, apenas conteúdo prático sobre desenvolvimento Front-End e UI Design.' ) ); ?>
      </p>
    </div>

    <!-- Formulário de Inscrição -->
    <?php 
    // Se você utilizar algum plugin de Newsletter (ex: Mailchimp), pode definir um Shortcode via Customizer
    $newsletter_shortcode = get_theme_mod( 'aqgoes_cta_shortcode' ); 
    
    if ( ! empty( $newsletter_shortcode ) ) : 
        echo do_shortcode( $newsletter_shortcode );
    else :
    ?>
      <form class="w-full lg:w-auto flex flex-col sm:flex-row gap-3 z-10" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
        <!-- Nonce e Ação para segurança do formulário WordPress -->
        <?php wp_nonce_field( 'aqgoes_newsletter_action', 'aqgoes_newsletter_nonce' ); ?>
        <input type="hidden" name="action" value="aqgoes_newsletter_submit">

        <input 
          type="email" 
          name="subscriber_email"
          placeholder="Seu melhor e-mail" 
          required 
          class="px-5 py-3.5 rounded-xl text-slate-800 text-sm bg-white border-0 focus:outline-none focus:ring-2 focus:ring-white/50 w-full sm:w-80 shadow-inner" 
        />
        <button 
          type="submit" 
          class="px-6 py-3.5 rounded-xl bg-slate-900 text-white font-semibold text-sm hover:bg-slate-800 transition-all shadow-md flex-shrink-0">
          Inscrever-se
        </button>
      </form>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>