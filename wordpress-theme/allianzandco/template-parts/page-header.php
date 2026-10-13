<?php
/**
 * Reusable page header / banner.
 *
 * Available variables (set before include):
 *  - $al_title
 *  - $al_subtitle
 *  - $al_image (URL)
 *  - $al_breadcrumbs (bool, default true)
 *
 * @package AllianzAndCo
 */

$al_title       = $al_title       ?? get_the_title();
$al_subtitle    = $al_subtitle    ?? '';
$al_image       = $al_image       ?? get_the_post_thumbnail_url( null, 'full' );
$al_breadcrumbs = $al_breadcrumbs ?? true;
?>
<section class="al-page-header">
    <?php if ( $al_image ) : ?>
        <div class="al-page-header__bg"><?php /* img element below so we can set a fallback */ ?>
            <img src="<?php echo esc_url( $al_image ); ?>" alt="" loading="eager" decoding="async">
        </div>
    <?php endif; ?>
    <div class="al-container al-page-header__inner">
        <?php if ( $al_breadcrumbs ) : ?>
            <nav class="al-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'allianzandco' ); ?>">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'allianzandco' ); ?></a>
                <?php if ( is_singular( 'post' ) ) : ?>
                    <span class="sep">/</span>
                    <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Blog', 'allianzandco' ); ?></a>
                <?php endif; ?>
                <span class="sep">/</span>
                <span><?php echo esc_html( $al_title ); ?></span>
            </nav>
        <?php endif; ?>
        <h1 class="al-page-header__title"><?php echo esc_html( $al_title ); ?></h1>
        <?php if ( $al_subtitle ) : ?>
            <p class="al-page-header__text"><?php echo esc_html( $al_subtitle ); ?></p>
        <?php endif; ?>
    </div>
</section>
