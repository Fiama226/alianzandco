<?php
/**
 * Template Name: About
 *
 * @package AllianzAndCo
 */
get_header();

$al_title    = get_the_title();
$al_subtitle = 'We exist to deliver complex engineering and construction projects that drive the development of the African continent.';
$al_image    = get_the_post_thumbnail_url( null, 'full' ) ?: AL_THEME_URI . '/assets/images/about-1.jpg';
include locate_template( 'template-parts/page-header.php' );
?>

<section class="al-section">
    <div class="al-container">
        <div class="al-feature-row">
            <div class="al-feature-row__media al-reveal">
                <img src="<?php echo esc_url( AL_THEME_URI . '/assets/images/about-2.jpg' ); ?>" alt="<?php esc_attr_e( 'Alliance & Co operations', 'allianzandco' ); ?>" loading="lazy">
            </div>
            <div class="al-reveal">
                <span class="al-eyebrow"><?php esc_html_e( 'About Alliance & Co', 'allianzandco' ); ?></span>
                <h2><?php esc_html_e( 'A multi-disciplinary engineering company with a continental footprint', 'allianzandco' ); ?></h2>
                <p><?php esc_html_e( 'ALLIANCE & CO delivers complex projects with high technical, economic and social stakes for the development of the African continent. We bring together engineering, construction, energy and operations capabilities under one roof — to give our clients a single, accountable partner from feasibility to long-term performance.', 'allianzandco' ); ?></p>
                <p><?php esc_html_e( 'Founded in 2005, we are headquartered in France and operate across West, East and North Africa. We work with public utilities, private developers, financiers and multilateral institutions — combining international best-practice with deep local context.', 'allianzandco' ); ?></p>
                <a class="al-btn" href="<?php echo esc_url( home_url( '/our-team' ) ); ?>" style="margin-top: 1rem;">
                    <?php esc_html_e( 'Meet the team', 'allianzandco' ); ?>
                    <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="al-section al-section--alt">
    <div class="al-container">
        <div class="al-section-head al-section-head--center al-reveal">
            <span class="al-eyebrow al-eyebrow--center"><?php esc_html_e( 'Our values', 'allianzandco' ); ?></span>
            <h2><?php esc_html_e( 'What guides every project we deliver', 'allianzandco' ); ?></h2>
        </div>
        <div class="al-grid al-grid--3">
            <?php
            $values = array(
                array( 'icon' => 'shield',   't' => 'Safety first',            'd' => 'No project is successful if our people or communities are not safe. QHSE is built into every plan, every site, every shift.' ),
                array( 'icon' => 'check',    't' => 'Engineering excellence',  'd' => 'We design and build to international standards, with discipline, rigour and a long-term view of performance.' ),
                array( 'icon' => 'leaf',     't' => 'Sustainability',          'd' => 'Every decision is weighed against its environmental and social footprint. We deliver infrastructure that lasts.' ),
                array( 'icon' => 'user',     't' => 'Local content',           'd' => 'We invest in local teams, suppliers and partners — creating lasting capability wherever we operate.' ),
                array( 'icon' => 'gear',     't' => 'Operational discipline',  'd' => 'We plan, track and adapt in real time. Our project controls are designed to give clients clarity and confidence.' ),
                array( 'icon' => 'star',     't' => 'Long-term partnership',    'd' => 'Most of our work comes from repeat clients. We earn trust by delivering — and we keep delivering long after handover.' ),
            );
            foreach ( $values as $v ) : ?>
                <div class="al-value al-reveal">
                    <div class="al-value__icon"><?php echo al_icon( $v['icon'], 36 ); ?></div>
                    <h4><?php echo esc_html( $v['t'] ); ?></h4>
                    <p><?php echo esc_html( $v['d'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CEO MESSAGE -->
<section class="al-section">
    <div class="al-container">
        <div class="al-feature-row al-feature-row--reverse">
            <div class="al-feature-row__media al-reveal">
                <img src="<?php echo esc_url( AL_THEME_URI . '/assets/images/team-lead.jpg' ); ?>" alt="<?php esc_attr_e( 'Ostin Harrison, CEO', 'allianzandco' ); ?>" loading="lazy">
            </div>
            <div class="al-reveal">
                <span class="al-eyebrow"><?php esc_html_e( 'A word from the CEO', 'allianzandco' ); ?></span>
                <h2><?php esc_html_e( 'Building Africa\'s future, one project at a time', 'allianzandco' ); ?></h2>
                <p style="font-family: var(--al-font-accent); font-style: italic; font-size: 1.25rem; color: var(--al-color-text);"><?php esc_html_e( '"When I founded Alliance & Co, the goal was simple — to give Africa the same quality of engineering and construction that I had seen delivered in the most demanding markets in the world. Twenty years later, that mission is unchanged."', 'allianzandco' ); ?></p>
                <p><?php esc_html_e( 'Today, Alliance & Co is a continent-wide team of engineers, builders and operators. We are proud of the projects we have delivered — and even more excited about the ones ahead.', 'allianzandco' ); ?></p>
                <p style="margin-top: 1.5rem;">
                    <strong style="font-family: var(--al-font-display); font-size: 1.1rem;">Ostin Harrison</strong><br>
                    <span style="color: var(--al-color-text-muted);"><?php esc_html_e( 'Founder & CEO', 'allianzandco' ); ?></span>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="al-cta">
    <div class="al-container al-cta__inner">
        <h2 class="al-cta__title"><?php esc_html_e( 'Want to work with us?', 'allianzandco' ); ?></h2>
        <a class="al-btn al-btn--white al-btn--lg" href="<?php echo esc_url( home_url( '/contacts' ) ); ?>">
            <?php esc_html_e( 'Get in touch', 'allianzandco' ); ?>
            <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
        </a>
    </div>
</section>

<?php get_footer();
