<?php
/**
 * O template para exibir o artigo individual (Single Post)
 *
 * @package aqgoes
 */

get_header(); ?>

<main class="flex-grow pt-28 pb-16">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <?php
    // Dados dinâmicos do post
    $categories       = get_the_category();
    $primary_category = ! empty( $categories ) ? esc_html( $categories[0]->name ) : 'TUTORIAIS';
    $primary_cat_link = ! empty( $categories ) ? get_category_link( $categories[0]->term_id ) : '#';

    // Datas: Publicação e Atualização
    $published_date   = get_the_date( 'd/m/Y' );
    $modified_date    = get_the_modified_date( 'd/m/Y' );
    $has_been_updated = ( get_the_modified_date( 'U' ) > get_the_date( 'U' ) );

    // Tempo de leitura estimado
    $word_count   = str_word_count( wp_strip_all_tags( get_the_content() ) );
    $reading_time = ceil( $word_count / 200 );

    // URL Atual para compartilhamento
    $current_url   = urlencode( get_permalink() );
    $current_title = urlencode( get_the_title() );
    ?>

    <article class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- HERO DO POST (2 COLUNAS) -->
      <header class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center mb-10">
        
        <!-- Coluna Esquerda: Meta, Título, Autor -->
        <div class="lg:col-span-7 space-y-6">
          <a href="<?php echo esc_url( $primary_cat_link ); ?>" class="px-3 py-1.5 rounded-md text-xs font-bold bg-brand text-white uppercase tracking-wider inline-block">
            <?php echo $primary_category; ?>
          </a>

          <h1 class="font-title text-3xl sm:text-5xl font-extrabold tracking-tight text-primary leading-tight">
            <?php the_title(); ?>
          </h1>

          <div class="text-xs text-muted font-mono flex flex-wrap items-center gap-2">
            <span><?php echo $published_date; ?></span>
            <?php if ( $has_been_updated ) : ?>
              <span>•</span>
              <span>Atualizado em <?php echo $modified_date; ?></span>
            <?php endif; ?>
            <span>•</span>
            <span><?php echo $reading_time; ?>min de leitura</span>
          </div>

          <div class="flex items-center gap-3 pt-2">
            <div class="w-12 h-12 rounded-xl overflow-hidden border border-amber-500/50 bg-subtle flex-shrink-0">
              <?php echo get_avatar( get_the_author_meta( 'ID' ), 96, '', get_the_author(), array( 'class' => 'w-full h-full object-cover' ) ); ?>
            </div>
            <div>
              <span class="text-xs text-muted block">Conteúdo por:</span>
              <span class="font-title font-bold text-sm text-primary"><?php the_author(); ?></span>
            </div>
          </div>
        </div>

        <!-- Coluna Direita: Imagem Destacada -->
        <div class="lg:col-span-5 aspect-video sm:aspect-[4/3] rounded-3xl overflow-hidden bg-subtle border border-subtle shadow-2xl">
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full object-cover' ) ); ?>
          <?php else : ?>
            <img src="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?auto=format&fit=crop&w=800&q=80" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover" />
          <?php endif; ?>
        </div>

      </header>

      <!-- BARRA DE AÇÕES (COMPARTILHAMENTO E IA) -->
      <div class="border-y border-subtle py-4 mb-12 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-muted">
        <div class="flex items-center gap-3">
          <span class="font-bold text-primary">Compartilhe:</span>
          <div class="flex items-center gap-3">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $current_url; ?>" target="_blank" rel="noopener" class="hover:text-brand transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
            <a href="https://api.whatsapp.com/send?text=<?php echo $current_title . '%20' . $current_url; ?>" target="_blank" rel="noopener" class="hover:text-brand transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.964 9.964 0 001.333 4.993L2 22l5.233-1.237a9.994 9.994 0 004.779 1.217h.004c5.505 0 9.988-4.478 9.989-9.985 0-2.669-1.038-5.176-2.925-7.062A9.925 9.925 0 0012.012 2z"/></svg></a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $current_url; ?>&title=<?php echo $current_title; ?>" target="_blank" rel="noopener" class="hover:text-brand transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 2a2 2 0 110 4 2 2 0 010-4z"/></svg></a>
            <a href="https://twitter.com/intent/tweet?text=<?php echo $current_title; ?>&url=<?php echo $current_url; ?>" target="_blank" rel="noopener" class="hover:text-brand transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link copiado!');" class="hover:text-brand transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg></button>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <span>Resumir este post com:</span>
          <a href="https://chatgpt.com/?q=Resuma+o+seguinte+artigo:+<?php echo $current_url; ?>" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-full border border-subtle bg-secondary hover:border-brand transition-all flex items-center gap-1.5 font-semibold text-primary">💬 ChatGPT</a>
          <a href="https://www.perplexity.ai/?q=Resuma+o+seguinte+artigo:+<?php echo $current_url; ?>" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-full border border-subtle bg-secondary hover:border-brand transition-all flex items-center gap-1.5 font-semibold text-primary">🔍 Perplexity</a>
        </div>
      </div>

      <!-- CORPO DO POST COM SIDEBAR (2 COLUNAS) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <!-- ESQUERDA: CONTEÚDO PRINCIPAL (8 COLUNAS) -->
        <div class="lg:col-span-8 space-y-8">
          <?php if ( has_excerpt() ) : ?>
            <div class="p-6 rounded-2xl bg-secondary border-l-4 border-brand italic text-lg text-primary/90 leading-relaxed">
              <?php echo get_the_excerpt(); ?>
            </div>
          <?php endif; ?>

          <div id="post-content" class="prose prose-lg dark:prose-invert max-w-none text-primary leading-relaxed space-y-6">
            <?php the_content(); ?>
          </div>
        </div>

        <!-- DIREITA: SIDEBAR "NAVEGUE POR TÓPICOS" (4 COLUNAS - FIXO) -->
        <aside class="lg:col-span-4">
          <div id="toc-container" class="sticky top-28 p-6 rounded-3xl border border-subtle bg-secondary shadow-xl space-y-4">
            <h3 class="font-title font-bold text-lg text-primary border-b border-subtle pb-3">
              Navegue por tópicos
            </h3>
            
            <nav id="table-of-contents" class="space-y-2 text-sm text-muted">
              <p class="text-xs opacity-75">Carregando tópicos...</p>
            </nav>
          </div>
        </aside>

      </div>

    </article>

  <?php endwhile; endif; ?>
</main>

<?php 
get_footer();