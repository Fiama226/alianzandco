<?php
/**
 * Template Name: Homepage
 *
 * @package AllianzAndCo
 */
get_header();

$hero_title = al_opt( 'al_hero_title', 'Engineering excellence for the African continent' );
$hero_text  = al_opt( 'al_hero_text',  'We deliver complex projects with high technical, economic and social impact to power Africa\'s development.' );
$hero_eye   = al_opt( 'al_hero_eyebrow', 'Building Africa\'s Future' );
$hero_btn   = al_opt( 'al_hero_btn_label', 'Discover our services' );
$hero_url   = al_opt( 'al_hero_btn_url', home_url( '/services' ) );
$hero_bg_id = al_opt( 'al_hero_bg' );
$hero_bg    = $hero_bg_id ? wp_get_attachment_image_url( $hero_bg_id, 'full' ) : AL_THEME_URI . '/assets/images/hero-1.jpg';
?>

<!-- HERO -->
<section class="al-hero">
    <div class="al-hero__bg">
        <img src="<?php echo esc_url( $hero_bg ); ?>" alt="" loading="eager" fetchpriority="high">
    </div>
    <div class="al-container al-hero__inner al-hero__content">
        <span class="al-hero__eyebrow"><?php echo esc_html( $hero_eye ); ?></span>
        <h1 class="al-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
        <p class="al-hero__text"><?php echo esc_html( $hero_text ); ?></p>
        <div class="al-hero__actions">
            <a class="al-btn al-btn--lg" href="<?php echo esc_url( $hero_url ); ?>">
                <?php echo esc_html( $hero_btn ); ?>
                <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
            </a>
            <a class="al-btn al-btn--ghost al-btn--lg" href="<?php echo esc_url( home_url( '/about-us' ) ); ?>"><?php esc_html_e( 'About us', 'allianzandco' ); ?></a>
        </div>

        <div class="al-hero__stat-bar">
            <?php for ( $i = 1; $i <= 4; $i++ ) :
                $num   = al_opt( "al_stat_{$i}_num" );
                $label = al_opt( "al_stat_{$i}_label" );
                if ( ! $num && ! $label ) continue;
                $numeric = (int) preg_replace( '/[^0-9]/', '', $num );
                ?>
                <div class="al-hero__stat">
                    <div class="al-hero__stat-num" <?php echo $numeric ? 'data-count="' . esc_attr( $numeric ) . '"' : ''; ?>>
                        <?php echo esc_html( $num ); ?>
                    </div>
                    <div class="al-hero__stat-label"><?php echo esc_html( $label ); ?></div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <a class="al-scroll-cue" href="#services"><?php esc_html_e( 'Scroll', 'allianzandco' ); ?></a>
</section>

<!-- SERVICES PREVIEW -->
<section id="services" class="al-section">
    <div class="al-container">
        <div class="al-section-head al-section-head--center al-reveal">
            <span class="al-eyebrow al-eyebrow--center"><?php esc_html_e( 'What we do', 'allianzandco' ); ?></span>
            <h2><?php esc_html_e( 'End-to-end engineering, energy & construction', 'allianzandco' ); ?></h2>
            <p><?php esc_html_e( 'From feasibility to commissioning, we deliver complex projects that power Africa\'s growth — combining deep technical expertise with on-the-ground execution.', 'allianzandco' ); ?></p>
        </div>

        <div class="al-grid al-grid--3">
            <?php
            $services_q = new WP_Query( array( 'post_type' => 'al_service', 'posts_per_page' => 6, 'orderby' => 'menu_order' ) );
            $fallback_services = array(
                array( 't' => 'Engineering & Construction', 'd' => 'Turnkey EPC delivery of complex industrial, commercial and infrastructure projects.' ),
                array( 't' => 'Energy & Power Grids',        'd' => 'High-voltage substations, transmission lines and distribution networks.' ),
                array( 't' => 'Renewable Energy',            'd' => 'Utility-scale solar PV, wind farms and hybrid energy systems.' ),
            );
            $i = 0;
            if ( $services_q->have_posts() ) :
                while ( $services_q->have_posts() ) : $services_q->the_post();
                    $icons = array( 'helmet', 'bolt', 'leaf', 'building', 'gear', 'shield' );
                    $ic = $icons[ $i % count( $icons ) ];
                    ?>
                    <a href="<?php echo esc_url( home_url( '/services' ) ); ?>" class="al-service al-reveal">
                        <div class="al-service__icon"><?php echo al_icon( $ic, 32 ); ?></div>
                        <h3 class="al-service__title"><?php the_title(); ?></h3>
                        <p class="al-service__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '…' ) ); ?></p>
                        <span class="al-service__link"><?php esc_html_e( 'Learn more', 'allianzandco' ); ?> <?php echo al_icon( 'arrow', 14 ); ?></span>
                    </a>
                    <?php $i++; endwhile; wp_reset_postdata();
            else :
                foreach ( $fallback_services as $j => $s ) :
                    $icons = array( 'helmet', 'bolt', 'leaf' ); ?>
                    <a href="<?php echo esc_url( home_url( '/services' ) ); ?>" class="al-service al-reveal">
                        <div class="al-service__icon"><?php echo al_icon( $icons[ $j ], 32 ); ?></div>
                        <h3 class="al-service__title"><?php echo esc_html( $s['t'] ); ?></h3>
                        <p class="al-service__text"><?php echo esc_html( $s['d'] ); ?></p>
                        <span class="al-service__link"><?php esc_html_e( 'Learn more', 'allianzandco' ); ?> <?php echo al_icon( 'arrow', 14 ); ?></span>
                    </a>
                <?php endforeach;
            endif; ?>
        </div>

        <div class="al-text-center" style="margin-top: 3rem;">
            <a class="al-link" href="<?php echo esc_url( home_url( '/services' ) ); ?>">
                <?php esc_html_e( 'View all services', 'allianzandco' ); ?>
                <span class="al-link__arrow"><?php echo al_icon( 'arrow', 16 ); ?></span>
            </a>
        </div>
    </div>
</section>

<!-- ABOUT SPLIT -->
<section class="al-section al-section--alt">
    <div class="al-container">
        <div class="al-feature-row">
            <div class="al-feature-row__media al-reveal">
                <img src="<?php echo esc_url( AL_THEME_URI . '/assets/images/about-1.jpg' ); ?>" alt="<?php esc_attr_e( 'Alliance & Co engineering team', 'allianzandco' ); ?>" loading="lazy">
            </div>
            <div class="al-reveal">
                <span class="al-eyebrow"><?php esc_html_e( 'Who we are', 'allianzandco' ); ?></span>
                <h2><?php esc_html_e( '20+ years of engineering Africa\'s most ambitious projects', 'allianzandco' ); ?></h2>
                <p><?php esc_html_e( 'Alliance & Co is a multi-disciplinary engineering and construction company headquartered in France, with operations across West, East and North Africa. We exist to deliver complex projects that drive the continent\'s development — safely, sustainably, and to the highest international standards.', 'allianzandco' ); ?></p>
                <ul class="al-feature-row__list">
                    <li><span class="check"><?php echo al_icon( 'check', 14 ); ?></span> ISO 9001 / 14001 / 45001 certified</li>
                    <li><span class="check"><?php echo al_icon( 'check', 14 ); ?></span> Active in 18 countries across Africa</li>
                    <li><span class="check"><?php echo al_icon( 'check', 14 ); ?></span> EPC, EPCM and O&M delivery models</li>
                    <li><span class="check"><?php echo al_icon( 'check', 14 ); ?></span> Strong local content and partner network</li>
                </ul>
                <a class="al-btn" href="<?php echo esc_url( home_url( '/about-us' ) ); ?>" style="margin-top: 1rem;">
                    <?php esc_html_e( 'More about us', 'allianzandco' ); ?>
                    <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- PROJECTS -->
<section class="al-section">
    <div class="al-container">
        <div class="al-section-head al-flex al-flex--between al-reveal" style="flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="al-eyebrow"><?php esc_html_e( 'Selected projects', 'allianzandco' ); ?></span>
                <h2><?php esc_html_e( 'Built across the continent', 'allianzandco' ); ?></h2>
            </div>
            <a class="al-link" href="<?php echo esc_url( home_url( '/services' ) ); ?>">
                <?php esc_html_e( 'Explore our work', 'allianzandco' ); ?>
                <span class="al-link__arrow"><?php echo al_icon( 'arrow', 16 ); ?></span>
            </a>
        </div>

        <div class="al-grid al-grid--3">
            <?php
            $proj_q = new WP_Query( array( 'post_type' => 'al_project', 'posts_per_page' => 6, 'orderby' => 'menu_order' ) );
            $fallback = array(
                array( 't' => 'Côte d\'Ivoire HV Substation', 'img' => 'project-1.jpg', 'cat' => 'Energy' ),
                array( 't' => 'Touba Solar PV Plant',          'img' => 'project-2.jpg', 'cat' => 'Renewable' ),
                array( 't' => 'Lake Turkana Wind Farm',        'img' => 'project-3.jpg', 'cat' => 'Renewable' ),
            );
            if ( $proj_q->have_posts() ) :
                while ( $proj_q->have_posts() ) : $proj_q->the_post();
                    $img = get_the_post_thumbnail_url( null, 'al-project' ) ?: AL_THEME_URI . '/assets/images/project-1.jpg';
                    $terms = get_the_terms( get_the_ID(), 'al_project_cat' );
                    $cat   = $terms && ! is_wp_error( $terms ) ? $terms[0]->name : '';
                    ?>
                    <a href="#" class="al-project al-reveal">
                        <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        <span class="al-project__arrow"><?php echo al_icon( 'arrow', 18 ); ?></span>
                        <div class="al-project__overlay">
                            <?php if ( $cat ) : ?><span class="al-project__cat"><?php echo esc_html( $cat ); ?></span><?php endif; ?>
                            <h3 class="al-project__title"><?php the_title(); ?></h3>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata();
            else :
                foreach ( $fallback as $p ) : ?>
                    <a href="#" class="al-project al-reveal">
                        <img src="<?php echo esc_url( AL_THEME_URI . '/assets/images/' . $p['img'] ); ?>" alt="<?php echo esc_attr( $p['t'] ); ?>" loading="lazy">
                        <span class="al-project__arrow"><?php echo al_icon( 'arrow', 18 ); ?></span>
                        <div class="al-project__overlay">
                            <span class="al-project__cat"><?php echo esc_html( $p['cat'] ); ?></span>
                            <h3 class="al-project__title"><?php echo esc_html( $p['t'] ); ?></h3>
                        </div>
                    </a>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<!-- STATS / DARK -->
<section class="al-section al-section--dark">
    <div class="al-container">
        <div class="al-grid al-grid--4 al-reveal" style="text-align: left;">
            <?php
            $stat_defaults = array(
                array( 'n' => 120, 's' => '+', 'l' => 'Projects delivered across Africa' ),
                array( 'n' => 18,  's' => '',  'l' => 'Countries with active operations' ),
                array( 'n' => 350, 's' => '+', 'l' => 'Engineers, builders and operators' ),
                array( 'n' => 98,  's' => '%', 'l' => 'Client satisfaction rate' ),
            );
            foreach ( $stat_defaults as $s ) : ?>
                <div class="al-counter">
                    <div class="al-counter__num" data-count="<?php echo esc_attr( $s['n'] ); ?>" data-suffix="<?php echo esc_attr( $s['s'] ); ?>">0<?php echo esc_html( $s['s'] ); ?></div>
                    <div class="al-counter__label"><?php echo esc_html( $s['l'] ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TEAM PREVIEW -->
<section class="al-section">
    <div class="al-container">
        <div class="al-section-head al-flex al-flex--between al-reveal" style="flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="al-eyebrow"><?php esc_html_e( 'Our team', 'allianzandco' ); ?></span>
                <h2><?php esc_html_e( 'The people behind every project', 'allianzandco' ); ?></h2>
            </div>
            <a class="al-link" href="<?php echo esc_url( home_url( '/our-team' ) ); ?>">
                <?php esc_html_e( 'Meet the full team', 'allianzandco' ); ?>
                <span class="al-link__arrow"><?php echo al_icon( 'arrow', 16 ); ?></span>
            </a>
        </div>

        <div class="al-grid al-grid--3">
            <?php
            $team_q = new WP_Query( array( 'post_type' => 'al_team', 'posts_per_page' => 3, 'orderby' => 'menu_order' ) );
            if ( $team_q->have_posts() ) :
                while ( $team_q->have_posts() ) : $team_q->the_post();
                    $img = get_the_post_thumbnail_url( null, 'al-team' ) ?: AL_THEME_URI . '/assets/images/team-lead.jpg';
                    $role = get_post_meta( get_the_ID(), '_al_role', true );
                    ?>
                    <a href="<?php the_permalink(); ?>" class="al-member al-reveal">
                        <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        <div class="al-member__overlay">
                            <h3 class="al-member__name"><?php the_title(); ?></h3>
                            <span class="al-member__role"><?php echo esc_html( $role ); ?></span>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata();
            else : ?>
                <a href="<?php echo esc_url( home_url( '/our-team' ) ); ?>" class="al-member al-reveal">
                    <img src="<?php echo esc_url( AL_THEME_URI . '/assets/images/team-lead.jpg' ); ?>" alt="" loading="lazy">
                    <div class="al-member__overlay">
                        <h3 class="al-member__name">Ostin Harrison</h3>
                        <span class="al-member__role">Founder &amp; CEO</span>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- TESTIMONIAL / PHILOSOPHY -->
<section class="al-section al-section--alt">
    <div class="al-container">
        <div class="al-grid al-grid--2" style="align-items: center;">
            <div class="al-reveal">
                <span class="al-eyebrow"><?php esc_html_e( 'Our philosophy', 'allianzandco' ); ?></span>
                <h2><?php esc_html_e( 'Built on trust, designed to last', 'allianzandco' ); ?></h2>
                <p style="font-size: 1.1rem;"><?php esc_html_e( 'We believe infrastructure is more than concrete and steel — it is the foundation of opportunity. Every Alliance & Co project is designed to outlast its brief, its budget and its builders.', 'allianzandco' ); ?></p>
                <a class="al-btn" href="<?php echo esc_url( home_url( '/philosophy' ) ); ?>" style="margin-top: 1rem;">
                    <?php esc_html_e( 'Read our philosophy', 'allianzandco' ); ?>
                    <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
                </a>
            </div>
            <div class="al-reveal" style="padding: 2rem; background: #fff; border-radius: var(--al-radius-lg); border: 1px solid var(--al-color-border); position: relative;">
                <div style="color: var(--al-color-accent); margin-bottom: 1rem;"><?php echo al_icon( 'quote', 40 ); ?></div>
                <blockquote style="font-family: var(--al-font-accent); font-style: italic; font-size: 1.4rem; line-height: 1.5; color: var(--al-color-text); margin: 0 0 1.5rem;">
                    "Africa does not need more pilots. It needs more projects that get built, perform and last."
                </blockquote>
                <div style="font-family: var(--al-font-display); font-weight: 700;">Ostin Harrison</div>
                <div style="font-size: .9rem; color: var(--al-color-text-muted);"><?php esc_html_e( 'Founder & CEO, Alliance & Co', 'allianzandco' ); ?></div>
            </div>
        </div>
    </div>
</section>

<!-- PARTNERS / CLIENTS -->
<section class="al-section al-section--sm">
    <div class="al-container">
        <div class="al-section-head al-section-head--center al-reveal">
            <span class="al-eyebrow al-eyebrow--center"><?php esc_html_e( 'Trusted by', 'allianzandco' ); ?></span>
            <h2 style="font-size: 1.5rem;"><?php esc_html_e( 'Public utilities, private developers & financial partners', 'allianzandco' ); ?></h2>
        </div>
        <div class="al-clients al-reveal">
            <?php for ( $n = 1; $n <= 12; $n++ ) :
                $img = AL_THEME_DIR . "/assets/images/partner-{$n}.jpeg";
                if ( ! file_exists( $img ) ) continue; ?>
                <div class="al-clients__item">
                    <img src="<?php echo esc_url( AL_THEME_URI . "/assets/images/partner-{$n}.jpeg" ); ?>" alt="<?php printf( esc_attr__( 'Partner %d', 'allianzandco' ), $n ); ?>" loading="lazy">
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- BLOG -->
<section class="al-section al-section--alt">
    <div class="al-container">
        <div class="al-section-head al-flex al-flex--between al-reveal" style="flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="al-eyebrow"><?php esc_html_e( 'Insights', 'allianzandco' ); ?></span>
                <h2><?php esc_html_e( 'From the field', 'allianzandco' ); ?></h2>
            </div>
            <a class="al-link" href="<?php echo esc_url( home_url( '/blog-list' ) ); ?>">
                <?php esc_html_e( 'All articles', 'allianzandco' ); ?>
                <span class="al-link__arrow"><?php echo al_icon( 'arrow', 16 ); ?></span>
            </a>
        </div>

        <div class="al-grid al-grid--3">
            <?php
            $blog_q = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => 1 ) );
            if ( $blog_q->have_posts() ) :
                while ( $blog_q->have_posts() ) : $blog_q->the_post();
                    $img = get_the_post_thumbnail_url( null, 'al-blog' ) ?: AL_THEME_URI . '/assets/images/blog-1.jpeg';
                    ?>
                    <article class="al-post-card al-reveal">
                        <a class="al-post-card__media" href="<?php the_permalink(); ?>">
                            <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        </a>
                        <div class="al-post-card__body">
                            <div class="al-post-card__meta">
                                <span class="al-cat"><?php esc_html_e( 'Insight', 'allianzandco' ); ?></span>
                                <span>·</span>
                                <time datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
                            </div>
                            <h3 class="al-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="al-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '…' ) ); ?></p>
                            <a class="al-link" href="<?php the_permalink(); ?>">
                                <?php esc_html_e( 'Read article', 'allianzandco' ); ?>
                                <span class="al-link__arrow"><?php echo al_icon( 'arrow', 16 ); ?></span>
                            </a>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="al-cta">
    <div class="al-container al-cta__inner">
        <h2 class="al-cta__title"><?php esc_html_e( 'Ready to discuss your next project?', 'allianzandco' ); ?></h2>
        <a class="al-btn al-btn--white al-btn--lg" href="<?php echo esc_url( home_url( '/contacts' ) ); ?>">
            <?php esc_html_e( 'Get in touch', 'allianzandco' ); ?>
            <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
        </a>
    </div>
</section>

<?php get_footer();
