<?php
/**
 * The footer.
 *
 * @package AllianzAndCo
 */
?>
</main><!-- .al-site-main -->

<footer class="al-footer">
    <div class="al-container">
        <div class="al-footer__grid">
            <div class="al-footer__col al-footer__about">
                <a class="al-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img class="al-logo__img" src="<?php echo esc_url( AL_THEME_URI . '/assets/images/logo-white.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" height="38">
                    <?php endif; ?>
                </a>
                <p><?php echo esc_html( al_opt( 'al_footer_about', 'ALLIANCE & CO delivers complex engineering and construction projects across the African continent with high technical, economic and social impact.' ) ); ?></p>
            </div>

            <div class="al-footer__col">
                <h5><?php esc_html_e( 'Explore', 'allianzandco' ); ?></h5>
                <?php
                if ( has_nav_menu( 'footer' ) ) {
                    wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1 ) );
                } else { ?>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>"><?php esc_html_e( 'About', 'allianzandco' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/services' ) ); ?>"><?php esc_html_e( 'Services', 'allianzandco' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-team' ) ); ?>"><?php esc_html_e( 'Team', 'allianzandco' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/blog-list' ) ); ?>"><?php esc_html_e( 'Blog', 'allianzandco' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/faqs' ) ); ?>"><?php esc_html_e( 'FAQs', 'allianzandco' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contacts' ) ); ?>"><?php esc_html_e( 'Contact', 'allianzandco' ); ?></a></li>
                    </ul>
                <?php } ?>
            </div>

            <div class="al-footer__col">
                <h5><?php esc_html_e( 'Services', 'allianzandco' ); ?></h5>
                <ul>
                    <?php
                    $services_q = new WP_Query( array( 'post_type' => 'al_service', 'posts_per_page' => 6, 'orderby' => 'menu_order' ) );
                    if ( $services_q->have_posts() ) :
                        while ( $services_q->have_posts() ) : $services_q->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata();
                    else : ?>
                        <li><a href="<?php echo esc_url( home_url( '/services' ) ); ?>"><?php esc_html_e( 'Engineering & Construction', 'allianzandco' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/services' ) ); ?>"><?php esc_html_e( 'Energy & Power Grids', 'allianzandco' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/services' ) ); ?>"><?php esc_html_e( 'Renewable Energy', 'allianzandco' ); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="al-footer__col">
                <h5><?php esc_html_e( 'Contact', 'allianzandco' ); ?></h5>
                <ul>
                    <?php if ( al_opt( 'al_contact_address' ) ) : ?>
                        <li><?php echo esc_html( al_opt( 'al_contact_address' ) ); ?></li>
                    <?php endif; ?>
                    <?php if ( al_opt( 'al_contact_phone' ) ) : ?>
                        <li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', al_opt( 'al_contact_phone' ) ) ); ?>"><?php echo esc_html( al_opt( 'al_contact_phone' ) ); ?></a></li>
                    <?php endif; ?>
                    <?php if ( al_opt( 'al_contact_email' ) ) : ?>
                        <li><a href="mailto:<?php echo esc_attr( al_opt( 'al_contact_email' ) ); ?>"><?php echo esc_html( al_opt( 'al_contact_email' ) ); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="al-footer__bottom">
            <div>
                <?php printf( esc_html__( '© %1$s %2$s. All rights reserved.', 'allianzandco' ), date( 'Y' ), get_bloginfo( 'name' ) ); ?>
            </div>
            <div class="al-footer__social">
                <?php foreach ( array( 'linkedin' => 'LinkedIn', 'twitter' => 'X / Twitter', 'facebook' => 'Facebook', 'instagram' => 'Instagram' ) as $k => $label ) :
                    $url = al_opt( "al_social_{$k}" ); if ( ! $url ) continue; ?>
                    <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $label ); ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM8.34 18.34H5.67V9.99h2.67v8.35zM7 8.82a1.55 1.55 0 1 1 0-3.1 1.55 1.55 0 0 1 0 3.1zm11.34 9.52h-2.67V14.2c0-.99-.02-2.27-1.39-2.27-1.39 0-1.6 1.08-1.6 2.2v4.21h-2.67V9.99h2.56v1.14h.04c.36-.68 1.23-1.39 2.54-1.39 2.71 0 3.21 1.78 3.21 4.1v4.5z"/></svg>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
