<?php
/**
 * Template Name: Contato (AqGoEs)
 *
 * page-contato.php — aplicado automaticamente pelo WordPress na página
 * cujo slug seja "contato". Processa o formulário e envia por wp_mail()
 * para o e-mail de administração do site.
 */

$aqgoes_contact_sent  = false;
$aqgoes_contact_error = '';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['aqgoes_contact_nonce'] ) ) {
	if ( ! wp_verify_nonce( $_POST['aqgoes_contact_nonce'], 'aqgoes_contact_form' ) ) {
		$aqgoes_contact_error = 'Sessão expirada, tente novamente.';
	} elseif ( ! empty( $_POST['aqgoes_website'] ) ) {
		// honeypot preenchido = bot. Finge sucesso e não envia nada.
		$aqgoes_contact_sent = true;
	} else {
		$name    = isset( $_POST['aqgoes_name'] ) ? sanitize_text_field( wp_unslash( $_POST['aqgoes_name'] ) ) : '';
		$email   = isset( $_POST['aqgoes_email'] ) ? sanitize_email( wp_unslash( $_POST['aqgoes_email'] ) ) : '';
		$subject = isset( $_POST['aqgoes_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['aqgoes_subject'] ) ) : '';
		$message = isset( $_POST['aqgoes_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['aqgoes_message'] ) ) : '';

		if ( ! $name || ! is_email( $email ) || ! $message ) {
			$aqgoes_contact_error = 'Preencha nome, e-mail válido e mensagem.';
		} else {
			$to      = get_option( 'admin_email' );
			$subject_line = sprintf( '[%s] Contato: %s', get_bloginfo( 'name' ), $subject ? $subject : 'Sem assunto' );
			$body    = "Nome: {$name}\nE-mail: {$email}\n\nMensagem:\n{$message}";
			$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

			if ( wp_mail( $to, $subject_line, $body, $headers ) ) {
				$aqgoes_contact_sent = true;
			} else {
				$aqgoes_contact_error = 'Não foi possível enviar agora. Tente novamente em instantes.';
			}
		}
	}
}

get_header();

while ( have_posts() ) : the_post();
	?>

	<section class="page-hero py-14">
		<div class="max-w-4xl mx-auto px-4 sm:px-6 page-hero-content">
			<div class="breadcrumb mb-4 fade-up d1">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
				<span class="sep">›</span>
				<span>Contato</span>
			</div>
			<span class="section-label fade-up d1" style="color:rgba(200,57,43,.8);">Vamos conversar</span>
			<h1 class="font-display text-4xl md:text-5xl font-black text-white mt-2 leading-tight fade-up d2">
				<?php the_title(); ?>
			</h1>
			<p class="text-white/60 mt-2 text-sm max-w-lg fade-up d3">
				<?php echo esc_html( get_theme_mod( 'aqgoes_contato_subtitle', 'Dúvidas, projetos ou só bater um papo sobre dev — a caixa de entrada está aberta.' ) ); ?>
			</p>
		</div>
	</section>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
		<div class="contact-grid">

			<!-- Formulário -->
			<div class="reveal visible">
				<?php if ( $aqgoes_contact_sent ) : ?>
					<div class="form-success">✓ Mensagem enviada! Retorno o mais rápido possível.</div>
				<?php elseif ( $aqgoes_contact_error ) : ?>
					<div class="form-error"><?php echo esc_html( $aqgoes_contact_error ); ?></div>
				<?php endif; ?>

				<form method="post" action="">
					<?php wp_nonce_field( 'aqgoes_contact_form', 'aqgoes_contact_nonce' ); ?>
					<input type="text" name="aqgoes_website" value="" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;" aria-hidden="true"/>

					<div class="form-field">
						<label for="aqgoes_name">Nome</label>
						<input type="text" id="aqgoes_name" name="aqgoes_name" required value="<?php echo isset( $_POST['aqgoes_name'] ) ? esc_attr( wp_unslash( $_POST['aqgoes_name'] ) ) : ''; ?>"/>
					</div>

					<div class="form-field">
						<label for="aqgoes_email">E-mail</label>
						<input type="email" id="aqgoes_email" name="aqgoes_email" required value="<?php echo isset( $_POST['aqgoes_email'] ) ? esc_attr( wp_unslash( $_POST['aqgoes_email'] ) ) : ''; ?>"/>
					</div>

					<div class="form-field">
						<label for="aqgoes_subject">Assunto</label>
						<input type="text" id="aqgoes_subject" name="aqgoes_subject" value="<?php echo isset( $_POST['aqgoes_subject'] ) ? esc_attr( wp_unslash( $_POST['aqgoes_subject'] ) ) : ''; ?>"/>
					</div>

					<div class="form-field">
						<label for="aqgoes_message">Mensagem</label>
						<textarea id="aqgoes_message" name="aqgoes_message" rows="6" required><?php echo isset( $_POST['aqgoes_message'] ) ? esc_textarea( wp_unslash( $_POST['aqgoes_message'] ) ) : ''; ?></textarea>
					</div>

					<button type="submit" class="btn-primary">
						Enviar mensagem
						<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M7 3l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</form>
			</div>

			<!-- Info -->
			<div class="reveal visible">
				<div class="info-card">
					<div class="contact-info-item">
						<span class="contact-info-icon">
							<svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M2 4.5h14v9H2v-9z" stroke="currentColor" stroke-width="1.4"/><path d="M2.5 5l6.5 5 6.5-5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						</span>
						<div>
							<div class="contact-info-label">E-mail</div>
							<div class="contact-info-value"><?php echo esc_html( get_option( 'admin_email' ) ); ?></div>
						</div>
					</div>

					<div class="contact-info-item">
						<span class="contact-info-icon">
							<svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 17s6-5.2 6-9.5A6 6 0 003 7.5C3 11.8 9 17 9 17z" stroke="currentColor" stroke-width="1.4"/><circle cx="9" cy="7.5" r="2" stroke="currentColor" stroke-width="1.4"/></svg>
						</span>
						<div>
							<div class="contact-info-label">Localização</div>
							<div class="contact-info-value">Brasília, DF</div>
						</div>
					</div>

					<div class="contact-info-item">
						<span class="contact-info-icon">
							<svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M3 9c0-3.3 2.7-6 6-6s6 2.7 6 6-2.7 6-6 6" stroke="currentColor" stroke-width="1.4"/><path d="M9 15l-2.5-2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
						</span>
						<div>
							<div class="contact-info-label">Tempo de resposta</div>
							<div class="contact-info-value">Até 2 dias úteis</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<?php
endwhile;

get_footer();
