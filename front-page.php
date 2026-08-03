<?php
/**
 * Template Principal do Blog
 *
 * @package aqgoes-theme
 */

get_header(); 

// 1. Contagem total de artigos publicados
$total_published_posts = wp_count_posts()->publish;
?>

<main>

<!-- ═══════════════════════════ HERO BLOG ═══════════════════════════ -->
<section class="blog-hero py-14">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 hero-content">
    <div class="breadcrumb mb-4 fade-up d1">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
      <span class="sep">›</span>
      <span>Blog</span>
    </div>
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
      <div>
        <span class="section-label fade-up d1" style="color:rgba(200,57,43,.8);">Dev Blog</span>
        <h1 class="font-display text-4xl md:text-5xl font-black text-white mt-2 leading-tight fade-up d2">
          <?php 
          if ( is_search() ) {
              printf( __( 'Resultados para: "%s"', 'aqgoes-theme' ), get_search_query() );
          } elseif ( is_category() ) {
              single_cat_title( 'Categoria: ' );
          } elseif ( is_tag() ) {
              single_tag_title( 'Tag: ' );
          } else {
              echo 'Artigos & Tutoriais';
          }
          ?>
        </h1>
        <p class="text-white/60 mt-2 text-sm max-w-lg fade-up d3">
          Conteúdo técnico sobre desenvolvimento web, Python, CSS moderno e as ferramentas que uso no dia a dia.
        </p>
      </div>

      <!-- Live counter -->
      <div class="fade-up d4 flex items-center gap-2" style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:.6rem 1rem;">
        <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;box-shadow:0 0 6px #4ade80;"></span>
        <span style="font-family:'JetBrains Mono',monospace;font-size:.72rem;color:rgba(255,255,255,.65);">
          <?php echo esc_html( $total_published_posts ); ?> artigos publicados
        </span>
      </div>
    </div>

    <!-- ── CATEGORY FILTER BAR ── -->
    <div class="cat-bar mt-8 fade-up d4" id="cat-bar">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cat-btn <?php echo ( ! is_category() ) ? 'active' : ''; ?>">Todos</a>
      <?php
      $categories = get_categories( array( 'hide_empty' => true ) );
      foreach ( $categories as $category ) {
          $is_active = is_category( $category->term_id ) ? 'active' : '';
          echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="cat-btn ' . $is_active . '">' . esc_html( $category->name ) . '</a>';
      }
      ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════ CONTEÚDO PRINCIPAL ═══════════════════════════ -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
  <div class="blog-layout">

    <!-- ══ COLUNA POSTS ══ -->
    <div>

      <!-- ── FEATURED POST (Exibido apenas na primeira página e fora de buscas) ── -->
      <?php if ( is_home() && ! is_paged() && ! is_search() ) : ?>
        <?php
        $featured_query = new WP_Query( array(
            'posts_per_page' => 1,
            'meta_key'       => '_is_featured', // Opcional: Filtra post em destaque
            'meta_value'     => '1',
            'ignore_sticky_posts' => 1
        ) );

        // Fallback: se não houver meta tag de destaque, pega o post mais recente
        if ( ! $featured_query->have_posts() ) {
            $featured_query = new WP_Query( array( 'posts_per_page' => 1 ) );
        }

        if ( $featured_query->have_posts() ) :
            while ( $featured_query->have_posts() ) : $featured_query->the_post();
                $featured_id = get_the_ID(); // Guarda o ID para evitar duplicar na listagem abaixo
                $cats = get_the_category();
                $primary_cat = ! empty( $cats ) ? $cats[0] : null;
        ?>
          <div class="featured-card reveal mb-8" id="featured-wrap">
            <div class="featured-img-wrap">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
              <?php else : ?>
                <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&q=80" alt="featured"/>
              <?php endif; ?>
              
              <div style="position:absolute;top:1rem;left:1rem;z-index:2;">
                <span class="featured-badge">✦ Destaque</span>
              </div>
            </div>

            <div class="featured-body">
              <div class="featured-meta">
                <?php if ( $primary_cat ) : ?>
                  <span class="featured-badge" style="background:#f0db4f;color:#6b5900;"><?php echo esc_html( $primary_cat->name ); ?></span>
                <?php endif; ?>
                <span class="featured-time"><?php echo get_the_date( 'd M Y' ); ?></span>
              </div>

              <h2 class="featured-title">
                <a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;">
                  <?php the_title(); ?>
                </a>
              </h2>

              <p class="featured-excerpt">
                <?php echo get_the_excerpt(); ?>
              </p>

              <div class="flex items-center justify-between flex-wrap gap-3 mt-auto">
                <div class="featured-author">
                  <?php echo get_avatar( get_the_author_meta( 'ID' ), 40, '', 'autor', array( 'class' => 'rounded-full' ) ); ?>
                  <div>
                    <div class="featured-author-name"><?php the_author(); ?></div>
                    <div class="featured-author-role">Autor</div>
                  </div>
                </div>

                <a href="<?php the_permalink(); ?>" class="read-btn">
                  Ler artigo
                  <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M7 3l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
              </div>
            </div>
          </div>
        <?php 
            endwhile;
            wp_reset_postdata();
        endif; 
        ?>
      <?php endif; ?>

      <!-- ── RESULTS HEADER ── -->
      <div class="flex items-center justify-between mb-5">
        <h2 class="font-display text-xl font-bold" style="color:var(--text);">
          <span id="results-label">
            <?php 
            if ( is_search() ) {
                echo 'Resultados encontrados';
            } else {
                echo 'Todos os artigos';
            }
            ?>
          </span>
          <span id="results-count" class="ml-2 text-sm font-normal" style="color:var(--muted);font-family:'JetBrains Mono',monospace;">
            (<?php echo $wp_query->found_posts; ?>)
          </span>
        </h2>
        <div style="font-size:.75rem;color:var(--muted);">
          Ordenar por: <span style="color:#c8392b;font-weight:600;cursor:pointer;">Recentes ↓</span>
        </div>
      </div>

      <!-- ── POST GRID ── -->
      <div class="post-grid" id="post-grid">

        <?php if ( have_posts() ) : ?>
          <?php while ( have_posts() ) : the_post(); ?>
            <?php 
            // Ignora o post em destaque no grid para não repetir
            if ( isset( $featured_id ) && get_the_ID() === $featured_id ) {
                continue;
            }

            $cats = get_the_category();
            $primary_cat = ! empty( $cats ) ? $cats[0] : null;
            $tags_list = wp_get_post_tags( get_the_ID(), array( 'fields' => 'names' ) );
            ?>

            <article class="post-card reveal" 
                     data-cat="<?php echo $primary_cat ? esc_attr( strtolower($primary_cat->slug) ) : ''; ?>" 
                     data-tags="<?php echo esc_attr( implode(',', $tags_list) ); ?>" 
                     data-title="<?php echo esc_attr( get_the_title() ); ?>">
              
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
                  <span class="post-card-cat" style="background:rgba(55,118,171,.15);color:#3776ab;">
                    <?php echo esc_html( $primary_cat->name ); ?>
                  </span>
                <?php endif; ?>

                <h3 class="post-card-title">
                  <a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;">
                    <?php the_title(); ?>
                  </a>
                </h3>

                <p class="post-card-excerpt">
                  <?php echo get_the_excerpt(); ?>
                </p>

                <div class="post-card-footer">
                  <div class="post-card-author">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 28, '', 'autor', array( 'class' => 'rounded-full' ) ); ?>
                    <span class="post-card-author-name"><?php the_author(); ?></span>
                  </div>
                  <span class="post-card-read"><?php echo get_the_date('d M'); ?></span>
                </div>
              </div>

            </article>

          <?php endwhile; ?>
        <?php else : ?>

          <!-- No results -->
          <div class="no-results" id="no-results" style="display:block;">
            <div style="font-size:3rem;margin-bottom:.75rem;">🔍</div>
            <h3 class="font-display text-xl font-bold mb-2" style="color:var(--text);">Nenhum resultado encontrado</h3>
            <p style="color:var(--muted);font-size:.875rem;">Tente pesquisar por outros termos ou categorias.</p>
          </div>

        <?php endif; ?>

      </div><!-- /post-grid -->

      <!-- ── PAGINATION ── -->
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

    </div><!-- /posts col -->

    <!-- ══ SIDEBAR ══ -->
    <aside class="sidebar">

      <!-- Widget: Busca Nativas WP -->
      <div class="sidebar-widget reveal">
        <div class="widget-header">
          <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><circle cx="6.5" cy="6.5" r="4.5" stroke="#c8392b" stroke-width="1.5"/><path d="M10 10l3 3" stroke="#c8392b" stroke-width="1.5" stroke-linecap="round"/></svg>
          <span class="widget-title">Buscar</span>
        </div>
        <div class="widget-body">
          <form role="search" method="get" class="search-wrap" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="text" class="search-input" name="s" id="search-input" value="<?php echo get_search_query(); ?>" placeholder="Pesquisar artigos…" autocomplete="off"/>
            <button type="submit" style="background:none;border:none;cursor:pointer;">
              <svg class="search-icon" width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="6" cy="6" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M9.5 9.5l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </button>
          </form>
        </div>
      </div>

      <!-- Widget: Categorias Dinâmicas -->
      <div class="sidebar-widget reveal">
        <div class="widget-header">
          <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><rect x="1" y="1" width="5" height="5" rx="1.5" fill="#c8392b"/><rect x="9" y="1" width="5" height="5" rx="1.5" fill="#c8392b" opacity=".5"/><rect x="1" y="9" width="5" height="5" rx="1.5" fill="#c8392b" opacity=".5"/><rect x="9" y="9" width="5" height="5" rx="1.5" fill="#c8392b"/></svg>
          <span class="widget-title">Categorias</span>
        </div>
        <div class="widget-body" style="padding-top:.6rem;padding-bottom:.6rem;">
          <div class="cat-list">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cat-list-item <?php echo ( ! is_category() ) ? 'active-cat' : ''; ?>">
              <span style="display:flex;align-items:center;"><span class="cat-dot" style="background:#c8392b;"></span>Todos os posts</span>
              <span class="cat-count"><?php echo esc_html( $total_published_posts ); ?></span>
            </a>

            <?php
            $sidebar_cats = get_categories( array( 'hide_empty' => true ) );
            foreach ( $sidebar_cats as $s_cat ) :
                $is_active = is_category( $s_cat->term_id ) ? 'active-cat' : '';
            ?>
              <a href="<?php echo esc_url( get_category_link( $s_cat->term_id ) ); ?>" class="cat-list-item <?php echo $is_active; ?>">
                <span style="display:flex;align-items:center;">
                  <span class="cat-dot" style="background:#3776ab;"></span>
                  <?php echo esc_html( $s_cat->name ); ?>
                </span>
                <span class="cat-count"><?php echo esc_html( $s_cat->count ); ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Widget: Tags Dinâmicas -->
      <div class="sidebar-widget reveal">
        <div class="widget-header">
          <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M1 7.5L7.5 1H14v6.5l-6.5 6.5L1 7.5z" stroke="#c8392b" stroke-width="1.3" stroke-linejoin="round"/><circle cx="11" cy="4" r="1.2" fill="#c8392b"/></svg>
          <span class="widget-title">Tags</span>
        </div>
        <div class="widget-body">
          <div class="tags-wrap" id="tags-wrap">
            <?php
            $tags = get_tags( array( 'hide_empty' => true ) );
            if ( $tags ) {
                foreach ( $tags as $tag ) {
                    echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="tag-pill">' . esc_html( $tag->name ) . '</a>';
                }
            } else {
                echo '<span style="font-size:0.8rem;color:var(--muted);">Nenhuma tag encontrada</span>';
            }
            ?>
          </div>
        </div>
      </div>

      <!-- Widget: Posts Recentes -->
      <div class="sidebar-widget reveal">
        <div class="widget-header">
          <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><rect x="1" y="1" width="13" height="13" rx="2" stroke="#c8392b" stroke-width="1.3"/><path d="M4 5h7M4 8h5M4 11h4" stroke="#c8392b" stroke-width="1.3" stroke-linecap="round"/></svg>
          <span class="widget-title">Posts Recentes</span>
        </div>
        <div class="widget-body" style="padding-top:.5rem;padding-bottom:.5rem;">

          <?php
          $recent_posts = new WP_Query( array(
              'posts_per_page'      => 4,
              'post_status'         => 'publish',
              'ignore_sticky_posts' => true
          ) );

          if ( $recent_posts->have_posts() ) :
              while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
          ?>
            <div class="recent-item">
              <div class="recent-thumb">
                <a href="<?php the_permalink(); ?>">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'thumbnail', array( 'alt' => get_the_title() ) ); ?>
                  <?php else : ?>
                    <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=120&q=60" alt="thumb"/>
                  <?php endif; ?>
                </a>
              </div>
              <div>
                <a href="<?php the_permalink(); ?>" class="recent-title"><?php the_title(); ?></a>
                <div class="recent-date"><?php echo get_the_date( 'd M Y' ); ?></div>
              </div>
            </div>
          <?php 
              endwhile;
              wp_reset_postdata();
          endif; 
          ?>

        </div>
      </div>

      <!-- Widget: Newsletter -->
      <div class="sidebar-widget reveal" style="background:#c8392b;border-color:#c8392b;">
        <div style="padding:1.4rem 1.3rem;">
          <div style="font-size:1.4rem;margin-bottom:.5rem;">📬</div>
          <h3 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#fff;margin-bottom:.4rem;">Receba novos artigos</h3>
          <p style="font-size:.78rem;color:rgba(255,255,255,.75);margin-bottom:1rem;line-height:1.5;">Sem spam. Apenas conteúdo técnico de qualidade toda semana.</p>
          <input type="email" placeholder="seu@email.com" style="width:100%;padding:.6rem .85rem;border-radius:6px;border:none;font-size:.82rem;outline:none;margin-bottom:.6rem;font-family:'DM Sans',sans-serif;"/>
          <button style="width:100%;padding:.6rem;border-radius:6px;background:#fff;color:#c8392b;font-size:.82rem;font-weight:700;border:none;cursor:pointer;transition:opacity .2s;" onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
            Assinar newsletter
          </button>
        </div>
      </div>

    </aside><!-- /sidebar -->

  </div><!-- /blog-layout -->
</div>

</main>

<?php 
get_footer();