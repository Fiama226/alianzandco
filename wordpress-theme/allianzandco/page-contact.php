<?php
/**
 * Template Name: Contact
 *
 * @package AllianzAndCo
 */
get_header();

// Handle contact form submission
$al_sent = false; $al_error = '';
if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['al_contact_nonce'] ) && wp_verify_nonce( $_POST['al_contact_nonce'], 'al_contact_submit' ) ) {
    $name    = sanitize_text_field( $_POST['name']    ?? '' );
    $email   = sanitize_email(      $_POST['email']   ?? '' );
    $phone   = sanitize_text_field( $_POST['phone']   ?? '' );
    $subject = sanitize_text_field( $_POST['subject'] ?? '' );
    $msg     = sanitize_textarea_field( $_POST['message'] ?? '' );
    if ( $name && is_email( $email ) && $msg ) {
        $to       = al_opt( 'al_contact_email', get_option( 'admin_email' ) );
        $subj     = $subject ?: sprintf( __( 'New contact from %s', 'allianzandco' ), $name );
        $body     = sprintf( "Name: %s\nEmail: %s\nPhone: %s\n\n%s", $name, $email, $phone, $msg );
        $headers  = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
        $sent     = wp_mail( $to, $subj, $body, $headers );
        $al_sent  = $sent;
        if ( ! $sent ) $al_error = __( 'There was a problem sending your message. Please try again or email us directly.', 'allianzandco' );
    } else {
        $al_error = __( 'Please fill in all required fields with valid information.', 'allianzandco' );
    }
}

$al_title    = get_the_title();
$al_subtitle = 'Tell us about your project — we will respond within two business days.';
$al_image    = get_the_post_thumbnail_url( null, 'full' ) ?: AL_THEME_URI . '/assets/images/about-1.jpg';
include locate_template( 'template-parts/page-header.php' );
?>

<section class="al-section">
    <div class="al-container">
        <div class="al-contact-grid">
            <div class="al-contact-info al-reveal">
                <span class="al-eyebrow"><?php esc_html_e( 'Get in touch', 'allianzandco' ); ?></span>
                <h2><?php esc_html_e( 'Alliance & Co', 'allianzandco' ); ?></h2>
                <p><?php esc_html_e( 'Reach out about an upcoming project, a partnership, a career opportunity or anything else. Our team will get back to you within two business days.', 'allianzandco' ); ?></p>

                <div style="margin-top: 2rem;">
                    <?php if ( al_opt( 'al_contact_address' ) ) : ?>
                        <div class="al-contact-item">
                            <span class="al-contact-item__icon"><?php echo al_icon( 'pin', 20 ); ?></span>
                            <div>
                                <h5><?php esc_html_e( 'Address', 'allianzandco' ); ?></h5>
                                <p><?php echo esc_html( al_opt( 'al_contact_address' ) ); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ( al_opt( 'al_contact_phone' ) ) : ?>
                        <div class="al-contact-item">
                            <span class="al-contact-item__icon"><?php echo al_icon( 'phone', 20 ); ?></span>
                            <div>
                                <h5><?php esc_html_e( 'Phone', 'allianzandco' ); ?></h5>
                                <p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', al_opt( 'al_contact_phone' ) ) ); ?>"><?php echo esc_html( al_opt( 'al_contact_phone' ) ); ?></a></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ( al_opt( 'al_contact_email' ) ) : ?>
                        <div class="al-contact-item">
                            <span class="al-contact-item__icon"><?php echo al_icon( 'mail', 20 ); ?></span>
                            <div>
                                <h5><?php esc_html_e( 'Email', 'allianzandco' ); ?></h5>
                                <p><a href="mailto:<?php echo esc_attr( al_opt( 'al_contact_email' ) ); ?>"><?php echo esc_html( al_opt( 'al_contact_email' ) ); ?></a></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ( al_opt( 'al_contact_hours' ) ) : ?>
                        <div class="al-contact-item">
                            <span class="al-contact-item__icon"><?php echo al_icon( 'clock', 20 ); ?></span>
                            <div>
                                <h5><?php esc_html_e( 'Opening hours', 'allianzandco' ); ?></h5>
                                <p><?php echo esc_html( al_opt( 'al_contact_hours' ) ); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="al-reveal" style="background: #fff; border: 1px solid var(--al-color-border); border-radius: var(--al-radius-lg); padding: 2.5rem;">
                <?php if ( $al_sent ) : ?>
                    <div style="padding: 1.5rem; background: #e6f4ea; border-radius: var(--al-radius); color: #1a8a3a; margin-bottom: 1.5rem;">
                        <strong><?php esc_html_e( 'Thank you!', 'allianzandco' ); ?></strong>
                        <?php esc_html_e( 'Your message has been sent. We will get back to you within two business days.', 'allianzandco' ); ?>
                    </div>
                <?php elseif ( $al_error ) : ?>
                    <div style="padding: 1.5rem; background: #fdecea; border-radius: var(--al-radius); color: #c0392b; margin-bottom: 1.5rem;">
                        <?php echo esc_html( $al_error ); ?>
                    </div>
                <?php endif; ?>

                <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;"><?php esc_html_e( 'Send us a message', 'allianzandco' ); ?></h3>
                <p style="color: var(--al-color-text-muted); margin-bottom: 1.5rem;"><?php esc_html_e( 'Fill in the form below and we will get back to you shortly.', 'allianzandco' ); ?></p>

                <form class="al-form" method="post">
                    <?php wp_nonce_field( 'al_contact_submit', 'al_contact_nonce' ); ?>
                    <div class="al-form__row">
                        <div class="al-field">
                            <label for="al-name"><?php esc_html_e( 'Name *', 'allianzandco' ); ?></label>
                            <input type="text" id="al-name" name="name" required value="<?php echo isset( $_POST['name'] ) ? esc_attr( $_POST['name'] ) : ''; ?>">
                        </div>
                        <div class="al-field">
                            <label for="al-email"><?php esc_html_e( 'Email *', 'allianzandco' ); ?></label>
                            <input type="email" id="al-email" name="email" required value="<?php echo isset( $_POST['email'] ) ? esc_attr( $_POST['email'] ) : ''; ?>">
                        </div>
                    </div>
                    <div class="al-form__row">
                        <div class="al-field">
                            <label for="al-phone"><?php esc_html_e( 'Phone', 'allianzandco' ); ?></label>
                            <input type="tel" id="al-phone" name="phone" value="<?php echo isset( $_POST['phone'] ) ? esc_attr( $_POST['phone'] ) : ''; ?>">
                        </div>
                        <div class="al-field">
                            <label for="al-subject"><?php esc_html_e( 'Subject', 'allianzandco' ); ?></label>
                            <input type="text" id="al-subject" name="subject" value="<?php echo isset( $_POST['subject'] ) ? esc_attr( $_POST['subject'] ) : ''; ?>">
                        </div>
                    </div>
                    <div class="al-field">
                        <label for="al-message"><?php esc_html_e( 'Message *', 'allianzandco' ); ?></label>
                        <textarea id="al-message" name="message" rows="6" required><?php echo isset( $_POST['message'] ) ? esc_textarea( $_POST['message'] ) : ''; ?></textarea>
                    </div>
                    <button type="submit" class="al-btn al-btn--lg" style="align-self: start;">
                        <?php esc_html_e( 'Send message', 'allianzandco' ); ?>
                        <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer();
