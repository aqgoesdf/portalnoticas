<?php
/**
 * Template para exibição do arquivo de Todos os Posts, Categorias, Tags e Autores
 *
 * @package aqgoes-theme
 */

get_header(); 

// Contagem total de artigos do blog
$total_published_posts = wp_count_posts()->publish;
?>

<main class="py-10">

  <!-- ═══════════════════════════ CABEÇALHO DA PÁGINA DE POSTS ═══════════════════════════ -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 mb-8">
    
    <!-- Breadcrumb -->
    <div class="breadcrumb mb-4 text-xs flex items-center gap-2" style="color:var(--muted);">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:underline">Início</a>
      <span class="sep">›</span>
      <span style="color:var(--text);">Todos os Posts</span>
    </div>

    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 pb-6 border-b" style="border-color:var(--border);">
      <div>
        <span class="section-label text-xs font-bold uppercase tracking-wider" style="color:#c8392b;">Acervo do Blog</span>
        <h1 class="font-display text-3xl md:text-4xl font-black mt-1" style="color:var(--text);">
          <?php 
          if ( is_category() ) {
              single_cat_title( 'Categoria: ' );
          } elseif ( is_tag() ) {
              single_tag_title( 'Tag: ' );
          } elseif ( is_author() ) {
              echo 'Artigos de: ' . get_the_author();
          } elseif ( is_day() || is_month() || is_year() ) {
              echo 'Arquivo: ' . get_the_date();
          } else {
              echo 'Todos os Artigos';
          }
          ?>
        </h1>
        <p class="text-sm mt-1" style="color:var(--muted);">
          Explore nossa lista completa de publicações e tutoriais.
        </p>
      </div>

      <!-- Contador de Artigos -->
      <div class="flex items-center gap-2" style="background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:.6rem 1rem;">
        <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;box-shadow:0 0 6px #4ade80;"></span>
        <span style="font-family:'JetBrains Mono',monospace;font-size:.72rem;color:var(--text);">
          <?php echo esc_html( $wp_query->found_posts ); ?> artigos encontrados
        </span>
      </div>
    </div>

    <!-- Barra de Categorias Rápida -->
    <div class="cat-bar mt-6 flex items-center gap-2 flex-wrap overflow-x-auto pb-2" id="cat-bar">
      <a href="<?php echo esc_url( get_permalink( get_option('page_for_posts') ) ? get_permalink( get_option('page_for_posts') ) : home_url('/blog') ); ?>" 
         class="cat-btn <?php echo ( ! is_category() && ! is_tag() ) ? 'active' : ''; ?>">
         Todos
      </a>
      <?php
      $categories = get_categories( array( 'hide_empty' => true ) );
      foreach ( $categories as $category ) {
          $is_active = is_category( $category->term_id ) ? 'active' : '';
          echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="cat-btn ' . $is_active . '">' . esc_html( $category->name ) . '</a>';
      }
      ?>
    </div>
  </section>

  <!-- ═══════════════════════════ LISTAGEM DOS POSTS ═══════════════════════════ -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="blog-layout">

      <!-- ══ COLUNA PRINCIPAL DE POSTS ══ -->
      <div>

        <div class="post-grid" id="post-grid">
          <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
              <?php 
              $cats = get_the_category();
              $primary_cat = ! empty( $cats ) ? $cats[0] : null;
              ?>

              <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card reveal' ); ?>>
                
                <div class="post-card-img">
                  <a href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                      <?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
                    <?php else : ?>
                      <div class="w-full h-full flex items-center justify-center font-display font-bold" style="background:var(--bg);color:var(--muted);min-height:160px;">
                        AqGoEs
                      </div>
                    <?php endif; ?>
                  </a>
                </div>

                <div class="post-card-body">
                  <?php if ( $primary_cat ) : ?>
                    <span class="post-card-cat" style="background:rgba(200,57,43,.15);color:#c8392b;">
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

            <div class="no-results" style="display:block; grid-column: 1 / -1; text-center py-12">
              <div style="font-size:3rem;margin-bottom:.75rem;">🔍</div>
              <h3 class="font-display text-xl font-bold mb-2" style="color:var(--text);">Nenhum post encontrado</h3>
              <p style="color:var(--muted);font-size:.875rem;">Não há artigos cadastrados nesta seção no momento.</p>
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

      <!-- ══ SIDEBAR ══ -->
      <aside class="sidebar">

        <!-- Widget: Busca -->
        <div class="sidebar-widget reveal">
          <div class="widget-header">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><circle cx="6.5" cy="6.5" r="4.5" stroke="#c8392b" stroke-width="1.5"/><path d="M10 10l3 3" stroke="#c8392b" stroke-width="1.5" stroke-linecap="round"/></svg>
            <span class="widget-title">Buscar</span>
          </div>
          <div class="widget-body">
            <form role="search" method="get" class="search-wrap" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <input type="text" class="search-input" name="s" value="<?php echo get_search_query(); ?>" placeholder="Pesquisar artigos…" autocomplete="off"/>
              <button type="submit" style="background:none;border:none;cursor:pointer;">
                <svg class="search-icon" width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="6" cy="6" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M9.5 9.5l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
              </button>
            </form>
          </div>
        </div>

        <!-- Widget: Categorias -->
        <div class="sidebar-widget reveal">
          <div class="widget-header">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><rect x="1" y="1" width="5" height="5" rx="1.5" fill="#c8392b"/><rect x="9" y="1" width="5" height="5" rx="1.5" fill="#c8392b" opacity=".5"/><rect x="1" y="9" width="5" height="5" rx="1.5" fill="#c8392b" opacity=".5"/><rect x="9" y="9" width="5" height="5" rx="1.5" fill="#c8392b"/></svg>
            <span class="widget-title">Categorias</span>
          </div>
          <div class="widget-body" style="padding-top:.6rem;padding-bottom:.6rem;">
            <div class="cat-list">
              <?php
              $sidebar_cats = get_categories( array( 'hide_empty' => true ) );
              foreach ( $sidebar_cats as $s_cat ) :
                  $is_active = is_category( $s_cat->term_id ) ? 'active-cat' : '';
              ?>
                <a href="<?php echo esc_url( get_category_link( $s_cat->term_id ) ); ?>" class="cat-list-item <?php echo $is_active; ?>">
                  <span style="display:flex;align-items:center;">
                    <span class="cat-dot" style="background:#c8392b;"></span>
                    <?php echo esc_html( $s_cat->name ); ?>
                  </span>
                  <span class="cat-count"><?php echo esc_html( $s_cat->count ); ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Widget: Tags -->
        <div class="sidebar-widget reveal">
          <div class="widget-header">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M1 7.5L7.5 1H14v6.5l-6.5 6.5L1 7.5z" stroke="#c8392b" stroke-width="1.3" stroke-linejoin="round"/><circle cx="11" cy="4" r="1.2" fill="#c8392b"/></svg>
            <span class="widget-title">Tags</span>
          </div>
          <div class="widget-body">
            <div class="tags-wrap">
              <?php
              $tags = get_tags( array( 'hide_empty' => true ) );
              if ( $tags ) {
                  foreach ( $tags as $tag ) {
                      echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="tag-pill">#' . esc_html( $tag->name ) . '</a>';
                  }
              }
              ?>
            </div>
          </div>
        </div>

      </aside>

    </div>
  </div>

</main>

<?php 
get_footer();