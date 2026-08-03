<?php
/**
 * Sidebar Reutilizável do Tema
 *
 * @package aqgoes-theme
 */

$total_posts = wp_count_posts()->publish;
?>

<aside class="sidebar">

  <!-- Widget: Busca Nativas WP -->
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
        <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="cat-list-item <?php echo ( is_home() ) ? 'active-cat' : ''; ?>">
          <span style="display:flex;align-items:center;"><span class="cat-dot" style="background:#c8392b;"></span>Todos os posts</span>
          <span class="cat-count"><?php echo esc_html( $total_posts ); ?></span>
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

</aside>