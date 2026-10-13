<?php
/**
 * The header.
 *
 * @package AllianzAndCo
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#al-main"><?php esc_html_e( 'Skip to content', 'allianzandco' ); ?></a>

<header class="al-header <?php echo is_front_page() ? 'al-header--transparent' : ''; ?>">
    <div class="al-container al-header__inner">
        <a class="al-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <?php if ( has_custom_logo() ) :
                // On the homepage (transparent/dark header) prefer the white logo if uploaded
                $logo_id = get_theme_mod( 'custom_logo' );
                $alt_id  = ( is_front_page() ) ? get_theme_mod( 'al_header_logo_white' ) : 0;
                if ( $alt_id ) {
                    echo wp_get_attachment_image( $alt_id, 'full', false, array( 'class' => 'al-logo__img' ) );
                } else {
                    the_custom_logo();
                }
            else :
                $logo_dark  = AL_THEME_URI . '/assets/images/logo-dark.png';
                $logo_white = AL_THEME_URI . '/assets/images/logo-white.png';
                $src = ( is_front_page() && file_exists( AL_THEME_DIR . '/assets/images/logo-white.png' ) ) ? $logo_white : $logo_dark;
            ?>
                <img class="al-logo__img" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" height="38">
            <?php endif; ?>
        </a>

        <nav class="al-nav" aria-label="<?php esc_attr_e( 'Primary', 'allianzandco' ); ?>">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'al-nav__list',
                    'depth'          => 2,
                ) );
            } else { ?>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'allianzandco' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>"><?php esc_html_e( 'About', 'allianzandco' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/services' ) ); ?>"><?php esc_html_e( 'Services', 'allianzandco' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/our-team' ) ); ?>"><?php esc_html_e( 'Team', 'allianzandco' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/blog-list' ) ); ?>"><?php esc_html_e( 'Blog', 'allianzandco' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contacts' ) ); ?>"><?php esc_html_e( 'Contact', 'allianzandco' ); ?></a></li>
                </ul>
            <?php } ?>
        </nav>

        <div class="al-header__actions">
            <?php
            // Language switcher (TranslatePress). Renders only if the plugin is active.
            if ( shortcode_exists( 'language-switcher' ) || function_exists( 'trp_language_switcher' ) ) {
                echo '<div class="al-lang-switcher">';
                if ( function_exists( 'trp_language_switcher' ) ) {
                    $args = array(
                        'dropdown'               => false,
                        'show_flags'             => true,
                        'show_current'           => true,
                        'previous_language_other_lang' => false,
                    );
                    trp_language_switcher( $args );
                } else {
                    echo do_shortcode( '[language-switcher]' );
                }
                echo '</div>';
            }
            ?>
            <a class="al-btn al-btn--outline" href="<?php echo esc_url( home_url( '/contacts' ) ); ?>">
                <?php esc_html_e( 'Get in touch', 'allianzandco' ); ?>
            </a>
            <button class="al-burger" aria-expanded="false" aria-controls="al-mobile-menu" aria-label="<?php esc_attr_e( 'Toggle menu', 'allianzandco' ); ?>">
                <span></span>
            </button>
        </div>
    </div>

    <div id="al-mobile-menu" class="al-mobile-menu" aria-hidden="true">
        <?php
        // Mobile language switcher
        if ( function_exists( 'trp_language_switcher' ) ) {
            echo '<div class="al-lang-switcher al-lang-switcher--mobile">';
            trp_language_switcher( array( 'dropdown' => false, 'show_flags' => true, 'show_current' => true ) );
            echo '</div>';
        }
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'depth'          => 2,
            ) );
        } else { ?>
            <ul>
                <?php
                $fallback = array(
                    '/'              => 'Home',
                    '/about-us'      => 'About',
                    '/services'      => 'Services',
                    '/our-team'      => 'Team',
                    '/philosophy'    => 'Philosophy',
                    '/history'       => 'History',
                    '/faqs'          => 'FAQs',
                    '/blog-list'     => 'Blog',
                    '/contacts'      => 'Contact',
                );
                foreach ( $fallback as $url => $label ) {
                    printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $url ) ), esc_html( $label ) );
                }
                ?>
            </ul>
        <?php } ?>
    </div>
</header>

<main id="al-main" class="al-site-main">
