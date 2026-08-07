<?php
/**
 * Template de Exibição de Categoria Individual (category.php)
 *
 * @package aqgoes-theme
 */

get_header(); 

// 1. Obtém a Categoria Atual com segurança
$current_cat  = get_queried_object();
$cat_id       = isset( $current_cat->term_id ) ? $current_cat->term_id : 0;
$cat_slug     = isset( $current_cat->slug ) ? strtolower( $current_cat->slug ) : '';
$cat_name     = isset( $current_cat->name ) ? $current_cat->name : '';
$cat_count    = isset( $current_cat->count ) ? $current_cat->count : 0;
$cat_desc     = category_description();

// Mapeamento visual das categorias (Emoji + Estilos)
$cat_styles_map = array(
    'python'     => array( 'emoji' => '🐍 ', 'bg' => 'rgba(55,118,171,.15)', 'text' => '#3776ab' ),
    'css'        => array( 'emoji' => '✨ ', 'bg' => 'rgba(56,189,248,.15)', 'text' => '#0891b2' ),
    'front-end'  => array( 'emoji' => '🎨 ', 'bg' => 'rgba(200,57,43,.12)',  'text' => '#c8392b' ),
    'django'     => array( 'emoji' => '🦄 ', 'bg' => 'rgba(68,183,139,.15)', 'text' => '#0c4b33' ),
    'javascript' => array( 'emoji' => '⚡ ', 'bg' => 'rgba(240,219,79,.2)',  'text' => '#6b5900' ),
    'tecnologia' => array( 'emoji' => '🖥️ ', 'bg' => 'rgba(124,58,237,.12)', 'text' => '#7c3aed' ),
);

$cat_emoji = isset( $cat_styles_map[ $cat_slug ] ) ? $cat_styles_map[ $cat_slug ]['emoji'] : '📁 ';
?>

<main>

<!-- ═══════════════════════════ HERO DA CATEGORIA ═══════════════════════════ -->
<section class="blog-hero py-14">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 hero-content">
    <div class="breadcrumb mb-4 fade-up d1">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
      <span class="sep">›</span>
      <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Blog</a>
      <span class="sep">›</span>
      <span>Categoria</span>
    </div>
    
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
      <div>
        <span class="section-label fade-up d1" style="color:rgba(200,57,43,.8);">Categoria Selecionada</span>
        <h1 class="font-display text-4xl md:text-5xl font-black text-white mt-2 leading-tight fade-up d2">
          <?php echo esc_html( $cat_emoji . $cat_name ); ?>
        </h1>
        <p class="text-white/60 mt-2 text-sm max-w-lg fade-up d3">
          <?php echo $cat_desc ? wp_strip_all_tags( $cat_desc ) : 'Exibindo todos os artigos e tutoriais publicados em ' . esc_html( $cat_name ) . '.'; ?>
        </p>
      </div>
      
      <!-- Contador da Categoria -->
      <div class="fade-up d4 flex items-center gap-2" style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:.6rem 1rem;">
        <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;box-shadow:0 0 6px #4ade80;"></span>
        <span style="font-family:'JetBrains Mono',monospace;font-size:.72rem;color:rgba(255,255,255,.65);">
          <?php echo $cat_count; ?> <?php echo ( $cat_count === 1 ) ? 'artigo publicado' : 'artigos publicados'; ?>
        </span>
      </div>
    </div>

    <!-- ── BARRA SUPERIOR DE FILTRO (.cat-bar) ── -->
    <div class="cat-bar mt-8 fade-up d4" id="cat-bar">
      <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="cat-btn">
        Todos
      </a>

      <?php
      $all_categories = get_categories( array( 'hide_empty' => true ) );

      foreach ( $all_categories as $cat_item ) :
          if ( $cat_item->slug === 'uncategorized' ) continue;
          
          $item_slug  = strtolower( $cat_item->slug );
          $item_emoji = isset( $cat_styles_map[ $item_slug ] ) ? $cat_styles_map[ $item_slug ]['emoji'] : '📁 ';
          $is_active  = ( $cat_id === $cat_item->term_id ) ? 'active' : '';
      ?>
        <a href="<?php echo esc_url( get_category_link( $cat_item->term_id ) ); ?>" class="cat-btn <?php echo $is_active; ?>">
          <?php echo esc_html( $item_emoji . $cat_item->name ); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════ POSTS DA CATEGORIA ═══════════════════════════ -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
  <div class="blog-layout grid grid-cols-1 lg:grid-cols-12 gap-10">

    <!-- COLUNA PRINCIPAL -->
    <div class="lg:col-span-8">

      <div class="flex items-center justify-between mb-5">
        <h2 class="font-display text-xl font-bold" style="color:var(--text);">
          <span>Artigos em <?php echo esc_html( $cat_name ); ?></span>
          <span class="ml-2 text-sm font-normal" style="color:var(--muted);font-family:'JetBrains Mono',monospace;">
            (<?php echo $cat_count; ?>)
          </span>
        </h2>
      </div>

      <!-- QUERY DEDICADA PARA BUSCAR POSTS DA CATEGORIA -->
      <?php 
      $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
      
      $cat_args = array(
          'post_type'      => 'post',
          'post_status'    => 'publish',
          'cat'            => $cat_id, // Busca estrita pelo ID da categoria
          'paged'          => $paged,
          'posts_per_page' => 10,
      );
      
      $cat_query = new WP_Query( $cat_args );
      ?>

      <div class="post-grid grid grid-cols-1 sm:grid-cols-2 gap-6" id="post-grid">

        <?php if ( $cat_query->have_posts() ) : ?>
          <?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); ?>
            <?php 
            $author_avatar = get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 28 ) );
            $word_count    = str_word_count( strip_tags( get_the_content() ) );
            $reading_time  = ceil( $word_count / 200 );

            $bg_color  = isset( $cat_styles_map[ $cat_slug ] ) ? $cat_styles_map[ $cat_slug ]['bg'] : 'rgba(200,57,43,.12)';
            $txt_color = isset( $cat_styles_map[ $cat_slug ] ) ? $cat_styles_map[ $cat_slug ]['text'] : '#c8392b';
            ?>

            <article class="post-card p-5 rounded-xl flex flex-col justify-between transition-transform duration-300 hover:-translate-y-1" style="background:var(--surface);border:1px solid var(--border);">
              <div>
                <div class="rounded-lg overflow-hidden h-44 mb-4">
                  <a href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                      <?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                    <?php else : ?>
                      <img src="https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=600&q=75" class="w-full h-full object-cover" alt="<?php the_title(); ?>"/>
                    <?php endif; ?>
                  </a>
                </div>

                <span class="inline-block text-xs font-bold px-2.5 py-1 rounded mb-2" style="background:<?php echo esc_attr( $bg_color ); ?>;color:<?php echo esc_attr( $txt_color ); ?>;">
                  <?php echo esc_html( $cat_emoji . $cat_name ); ?>
                </span>

                <h3 class="font-display text-lg font-bold mb-2 line-clamp-2">
                  <a href="<?php the_permalink(); ?>" style="color:var(--text);text-decoration:none;" class="hover:text-[#c8392b] transition-colors">
                    <?php the_title(); ?>
                  </a>
                </h3>

                <p class="text-xs leading-relaxed mb-4 line-clamp-3" style="color:var(--muted);">
                  <?php echo get_the_excerpt(); ?>
                </p>
              </div>

              <div class="flex items-center justify-between pt-3 border-t mt-2" style="border-color:var(--border);">
                <div class="flex items-center gap-2">
                  <img src="<?php echo esc_url( $author_avatar ); ?>" class="w-6 h-6 rounded-full" alt="autor"/>
                  <span class="text-xs font-semibold" style="color:var(--text);"><?php the_author(); ?></span>
                </div>
                <span class="text-xs" style="color:var(--muted);"><?php echo $reading_time; ?> min</span>
              </div>
            </article>

          <?php endwhile; ?>
        <?php else : ?>

          <div class="no-results text-center py-10 col-span-full">
            <div style="font-size:3rem;margin-bottom:.75rem;">🔍</div>
            <h3 class="font-display text-xl font-bold mb-2" style="color:var(--text);">Nenhum artigo encontrado</h3>
            <p style="color:var(--muted);font-size:.875rem;">Não encontramos nenhum post vinculado à categoria "<strong><?php echo esc_html( $cat_name ); ?></strong>".</p>
          </div>

        <?php endif; ?>

      </div>

      <!-- PAGINAÇÃO CONDICIONAL (SÓ EXIBE SE HOUVER MAIS DE 5 POSTS) -->
      <?php if ( $cat_count > 5 ) : ?>
        <div class="mt-10 flex justify-center">
          <?php 
          echo paginate_links( array(
              'total'     => $cat_query->max_num_pages,
              'current'   => $paged,
              'prev_text' => '←',
              'next_text' => '→',
          ) );
          ?>
        </div>
      <?php endif; ?>

      <?php wp_reset_postdata(); ?>

    </div>

    <!-- SIDEBAR -->
    <div class="lg:col-span-4">
      <?php get_sidebar(); ?>
    </div>

  </div>
</div>

</main>

<?php get_footer(); ?>