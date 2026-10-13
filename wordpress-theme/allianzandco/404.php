<?php
/**
 * 404 template.
 *
 * @package AllianzAndCo
 */
get_header();
?>

<section class="al-404">
    <div class="al-container">
        <div class="al-reveal">
            <div class="al-404__num">404</div>
            <h1 class="al-404__title"><?php esc_html_e( 'Page not found', 'allianzandco' ); ?></h1>
            <p class="al-404__text"><?php esc_html_e( 'The page you are looking for might have been moved, deleted, or perhaps never existed. Try one of the links below.', 'allianzandco' ); ?></p>
            <div class="al-flex" style="justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a class="al-btn al-btn--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php esc_html_e( 'Back to home', 'allianzandco' ); ?>
                    <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
                </a>
                <a class="al-btn al-btn--outline al-btn--lg" href="<?php echo esc_url( home_url( '/contacts' ) ); ?>">
                    <?php esc_html_e( 'Contact us', 'allianzandco' ); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer();
