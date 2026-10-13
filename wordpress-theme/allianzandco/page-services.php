<?php
/**
 * Template Name: Services
 *
 * @package AllianzAndCo
 */
get_header();

$al_title    = get_the_title();
$al_subtitle = 'Six core capabilities, delivered as one integrated EPC and O&M partner.';
$al_image    = get_the_post_thumbnail_url( null, 'full' ) ?: AL_THEME_URI . '/assets/images/service-1.jpg';
include locate_template( 'template-parts/page-header.php' );
?>

<section class="al-section">
    <div class="al-container">
        <div class="al-grid al-grid--3">
            <?php
            $icons = array( 'helmet', 'bolt', 'leaf', 'building', 'gear', 'shield' );
            $i = 0;
            $q = new WP_Query( array( 'post_type' => 'al_service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
            if ( $q->have_posts() ) :
                while ( $q->have_posts() ) : $q->the_post(); ?>
                    <div class="al-service al-reveal">
                        <div class="al-service__icon"><?php echo al_icon( $icons[ $i % count( $icons ) ], 32 ); ?></div>
                        <h3 class="al-service__title"><?php the_title(); ?></h3>
                        <p class="al-service__text"><?php echo esc_html( wp_trim_words( get_the_excerpt() ?: wp_strip_all_tags( get_the_content() ), 28, '…' ) ); ?></p>
                        <span class="al-service__link"><?php esc_html_e( 'Learn more', 'allianzandco' ); ?> <?php echo al_icon( 'arrow', 14 ); ?></span>
                    </div>
                <?php $i++; endwhile; wp_reset_postdata();
            else : ?>
                <?php
                $fallback = array(
                    array( 't' => 'Engineering & Construction', 'd' => 'Turnkey EPC delivery of complex industrial, commercial and infrastructure projects, from feasibility to commissioning.' ),
                    array( 't' => 'Energy & Power Grids',        'd' => 'High-voltage substations, transmission lines and distribution networks that connect cities and industries.' ),
                    array( 't' => 'Renewable Energy',            'd' => 'Utility-scale solar PV, wind farms and hybrid energy systems designed, financed and operated for long-term performance.' ),
                    array( 't' => 'Civil & Structural Works',    'd' => 'Bridges, ports, roads, water systems and structural concrete delivered to international standards.' ),
                    array( 't' => 'Project Management',          'd' => 'Owner\'s engineering, EPCM and program management for multi-stakeholder infrastructure programs.' ),
                    array( 't' => 'Operations & Maintenance',    'd' => 'Long-term O&M services for energy assets, industrial facilities and critical infrastructure.' ),
                );
                foreach ( $fallback as $j => $s ) : ?>
                    <div class="al-service al-reveal">
                        <div class="al-service__icon"><?php echo al_icon( $icons[ $j ], 32 ); ?></div>
                        <h3 class="al-service__title"><?php echo esc_html( $s['t'] ); ?></h3>
                        <p class="al-service__text"><?php echo esc_html( $s['d'] ); ?></p>
                        <span class="al-service__link"><?php esc_html_e( 'Learn more', 'allianzandco' ); ?> <?php echo al_icon( 'arrow', 14 ); ?></span>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<!-- PROCESS -->
<section class="al-section al-section--alt">
    <div class="al-container">
        <div class="al-section-head al-section-head--center al-reveal">
            <span class="al-eyebrow al-eyebrow--center"><?php esc_html_e( 'How we deliver', 'allianzandco' ); ?></span>
            <h2><?php esc_html_e( 'An integrated delivery model', 'allianzandco' ); ?></h2>
        </div>
        <div class="al-grid al-grid--4">
            <?php
            $steps = array(
                array( 'n' => '01', 't' => 'Feasibility',  'd' => 'We work with clients to scope, model and de-risk the project from day one.' ),
                array( 'n' => '02', 't' => 'Engineering',  'd' => 'Our multi-disciplinary engineering teams design to international codes and local context.' ),
                array( 'n' => '03', 't' => 'Construction', 'd' => 'We self-perform the critical path and orchestrate the rest with trusted local partners.' ),
                array( 'n' => '04', 't' => 'Operate',      'd' => 'We stay involved — operating, maintaining and optimising the asset for the long term.' ),
            );
            foreach ( $steps as $s ) : ?>
                <div class="al-reveal" style="padding: 1.5rem; background: #fff; border-radius: var(--al-radius-lg); border: 1px solid var(--al-color-border);">
                    <div style="font-family: var(--al-font-display); font-weight: 700; color: var(--al-color-accent); font-size: 1.5rem; margin-bottom: 1rem;"><?php echo esc_html( $s['n'] ); ?></div>
                    <h4><?php echo esc_html( $s['t'] ); ?></h4>
                    <p style="font-size: .95rem;"><?php echo esc_html( $s['d'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="al-cta">
    <div class="al-container al-cta__inner">
        <h2 class="al-cta__title"><?php esc_html_e( 'Tell us about your project', 'allianzandco' ); ?></h2>
        <a class="al-btn al-btn--white al-btn--lg" href="<?php echo esc_url( home_url( '/contacts' ) ); ?>">
            <?php esc_html_e( 'Get in touch', 'allianzandco' ); ?>
            <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
        </a>
    </div>
</section>

<?php get_footer();
