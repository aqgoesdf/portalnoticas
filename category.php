<?php
/**
 * O template para exibir o arquivo de posts por Categoria
 *
 * @package aqgoes
 */

get_header(); ?>

<main class="flex-grow pt-28 pb-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- CABEÇALHO DA CATEGORIA -->
    <header class="mb-12 border-b border-subtle pb-8">
      <!-- Badge indicativo -->
      <span class="px-3 py-1.5 rounded-md text-xs font-bold bg-brand/10 text-brand border border-brand/20 uppercase tracking-wider font-mono inline-block mb-3">
        Categoria
      </span>

      <!-- Título Dinâmico da Categoria -->
      <h1 class="font-title text-3xl sm:text-5xl font-extrabold tracking-tight text-primary leading-tight mb-3">
        <?php single_cat_title(); ?>
      </h1>

      <!-- Descrição da Categoria (se houver cadastrada no painel) -->
      <?php 
      $category_description = category_description();
      if ( ! empty( $category_description ) ) : 
      ?>
        <div class="text-muted text-base sm:text-lg max-w-3xl leading-relaxed">
          <?php echo $category_description; ?>
        </div>
      <?php else : ?>
        <p class="text-muted text-base sm:text-lg">
          Explore todos os artigos, tutoriais e dicas publicados na categoria <strong class="text-primary"><?php single_cat_title(); ?></strong>.
        </p>
      <?php endif; ?>
    </header>

    <!-- LISTAGEM DE CATEGORIAS (PILLS PARA NAVEGAÇÃO RÁPIDA) -->
    <div class="flex flex-wrap gap-2 mb-10">
      <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url('/') ); ?>" 
         class="px-4 py-2 rounded-xl text-xs font-semibold bg-secondary border border-subtle hover:border-brand transition-all text-primary">
        Todos
      </a>

      <?php
      $categories = get_categories( array(
          'orderby'    => 'name',
          'order'      => 'ASC',
          'hide_empty' => true,
      ) );

      $current_cat_id = get_queried_object_id();

      foreach ( $categories as $category ) :
          $is_active = ( $category->term_id === $current_cat_id );
          $class     = $is_active 
              ? 'bg-brand text-white' 
              : 'bg-secondary border border-subtle hover:border-brand text-primary';
      ?>
        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
           class="px-4 py-2 rounded-xl text-xs font-semibold transition-all <?php echo $class; ?>">
          <?php echo esc_html( $category->name ); ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- GRID DE ARTIGOS DA CATEGORIA -->
    <?php if ( have_posts() ) : ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <?php 
        while ( have_posts() ) : the_post(); 

          // Categorias do post
          $post_cats = get_the_category();
          $cat_name  = ! empty( $post_cats ) ? $post_cats[0]->name : 'Geral';

          // Tempo de leitura estimado
          $word_count   = str_word_count( wp_strip_all_tags( get_the_content() ) );
          $reading_time = ceil( $word_count / 200 );
        ?>
          <!-- Card do Artigo -->
          <article class="rounded-2xl border border-subtle bg-secondary overflow-hidden flex flex-col group transition-all duration-300 hover:-translate-y-1 hover:border-brand/50 hover:shadow-lg">
            
            <!-- Imagem Destacada -->
            <div class="aspect-video w-full overflow-hidden bg-subtle">
              <a href="<?php the_permalink(); ?>" class="block w-full h-full">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105' ) ); ?>
                <?php else : ?>
                  <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                <?php endif; ?>
              </a>
            </div>

            <!-- Conteúdo do Card -->
            <div class="p-6 flex-grow flex flex-col justify-between">
              <div>
                <span class="px-2.5 py-1 rounded-md text-xs font-semibold bg-brand/10 text-brand border border-brand/20 uppercase tracking-wider font-mono inline-block mb-3">
                  <?php echo esc_html( $cat_name ); ?>
                </span>

                <h2 class="font-title text-xl font-bold group-hover:text-brand transition-colors leading-snug">
                  <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                  </a>
                </h2>

                <p class="text-muted text-sm mt-2 line-clamp-2">
                  <?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
                </p>
              </div>

              <!-- Rodapé do Card -->
              <div class="mt-6 pt-4 border-t border-subtle flex items-center justify-between text-xs text-muted">
                <span><?php echo get_the_date( 'd \d\e F, Y' ); ?></span>
                <span><?php echo $reading_time; ?> min</span>
              </div>
            </div>

          </article>
        <?php endwhile; ?>

      </div>

      <!-- PAGINAÇÃO DINÂMICA NATIVA -->
      <div class="mt-12 flex justify-center items-center gap-2">
        <?php
        echo paginate_links( array(
            'prev_text' => __( 'Anterior', 'aqgoes' ),
            'next_text' => __( 'Próxima', 'aqgoes' ),
            'type'      => 'plain',
        ) );
        ?>
      </div>

    <?php else : ?>
      <!-- Mensagem quando não houver artigos na categoria -->
      <div class="text-center py-16 bg-secondary rounded-3xl border border-subtle">
        <p class="text-muted text-base mb-4">Nenhum artigo encontrado para esta categoria no momento.</p>
        <a href="<?php echo esc_url( home_url('/') ); ?>" class="px-5 py-2.5 rounded-xl bg-brand text-white text-xs font-semibold hover:bg-brand-hover transition-all inline-block">
          Voltar para a Home
        </a>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php 
get_footer();