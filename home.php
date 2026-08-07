<?php
/**
 * home.php — página de listagem do blog (Posts Page).
 * Reproduz o blog.html estático com dados reais do WP.
 */
get_header();

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

/* ── Post em destaque: só na página 1 ── */
$featured_id = 0;
if ( 1 === $paged ) {
	$featured_q = new WP_Query( array(
		'posts_per_page' => 1,
		'post_status'    => 'publish',
		'ignore_sticky_posts' => false,
	) );
	if ( $featured_q->have_posts() ) {
		$featured_q->the_post();
		$featured_id = get_the_ID();
	}
	wp_reset_postdata();
}

/* ── Contagem total de posts publicados ── */
$total_posts = wp_count_posts()->publish;
?>

<section class="blog-hero py-14">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 hero-content">
		<div class="breadcrumb mb-4 fade-up d1">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
			<span class="sep">›</span>
			<span>Blog</span>
		</div>
		<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
			<div>
				<span class="section-label fade-up d1" style="color:rgba(200,57,43,.8);"><?php echo esc_html( get_theme_mod( 'aqgoes_blog_hero_label', 'Dev Blog' ) ); ?></span>
				<h1 class="font-display text-4xl md:text-5xl font-black text-white mt-2 leading-tight fade-up d2">
					<?php echo esc_html( get_theme_mod( 'aqgoes_blog_hero_title', 'Artigos & Tutoriais' ) ); ?>
				</h1>
				<p class="text-white/60 mt-2 text-sm max-w-lg fade-up d3">
					<?php echo esc_html( get_theme_mod( 'aqgoes_blog_hero_desc', 'Conteúdo técnico sobre desenvolvimento web, Python, CSS moderno e as ferramentas que uso no dia a dia.' ) ); ?>
				</p>
			</div>

			<div class="fade-up d4 flex items-center gap-2" style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:.6rem 1rem;">
				<span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;box-shadow:0 0 6px #4ade80;"></span>
				<span style="font-family:'JetBrains Mono',monospace;font-size:.72rem;color:rgba(255,255,255,.65);"><?php echo (int) $total_posts; ?> artigos publicados</span>
			</div>
		</div>

		<div class="cat-bar mt-8 fade-up d4" id="cat-bar">
			<button class="cat-btn active" data-cat="todos">Todos</button>
			<?php
			$cats = get_categories( array( 'hide_empty' => true ) );
			foreach ( $cats as $cat ) :
				$style = aqgoes_category_style( $cat->slug );
				?>
				<button class="cat-btn" data-cat="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $style['emoji'] . ' ' . $cat->name ); ?></button>
			<?php endforeach; ?>
		</div>
	</div>
</section>

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

		<?php get_sidebar(); ?>

	</div><!-- /blog-layout -->
</div>

<?php get_footer(); ?>
