<?php
/**
 * Template Name: Philosophy
 *
 * @package AllianzAndCo
 */
get_header();

$al_title    = get_the_title();
$al_subtitle = 'We believe infrastructure is more than concrete and steel — it is the foundation of opportunity.';
$al_image    = get_the_post_thumbnail_url( null, 'full' ) ?: AL_THEME_URI . '/assets/images/about-1.jpg';
include locate_template( 'template-parts/page-header.php' );
?>

<section class="al-section">
    <div class="al-container" style="max-width: 880px;">
        <div class="al-reveal" style="font-size: 1.1rem; line-height: 1.9; color: var(--al-color-text);">
            <span class="al-eyebrow"><?php esc_html_e( 'Our philosophy', 'allianzandco' ); ?></span>
            <h1 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 2rem;"><?php esc_html_e( 'Built on trust, designed to last', 'allianzandco' ); ?></h1>
            <p style="font-family: var(--al-font-accent); font-style: italic; color: var(--al-color-text); font-size: 1.4rem; border-left: 4px solid var(--al-color-accent); padding-left: 1.5rem; margin-bottom: 2rem;">
                <?php esc_html_e( '"Africa does not need more pilots. It needs more projects that get built, perform and last."', 'allianzandco' ); ?>
            </p>
            <p><?php esc_html_e( 'Alliance & Co exists to deliver infrastructure that lasts — physically, economically and socially. Every decision we make is weighed against three questions:', 'allianzandco' ); ?></p>
            <ul class="al-feature-row__list" style="margin: 2rem 0;">
                <li><span class="check"><?php echo al_icon( 'check', 14 ); ?></span> <strong><?php esc_html_e( 'Will it be safe?', 'allianzandco' ); ?></strong> <?php esc_html_e( 'For our people, our partners and the communities we work in.', 'allianzandco' ); ?></li>
                <li><span class="check"><?php echo al_icon( 'check', 14 ); ?></span> <strong><?php esc_html_e( 'Will it perform?', 'allianzandco' ); ?></strong> <?php esc_html_e( 'For the full design life — not just at handover.', 'allianzandco' ); ?></li>
                <li><span class="check"><?php echo al_icon( 'check', 14 ); ?></span> <strong><?php esc_html_e( 'Will it leave a positive mark?', 'allianzandco' ); ?></strong> <?php esc_html_e( 'On the local economy, on skills, on the environment.', 'allianzandco' ); ?></li>
            </ul>
            <h2><?php esc_html_e( 'Engineering with context', 'allianzandco' ); ?></h2>
            <p><?php esc_html_e( 'The most successful projects we have delivered all share one thing: they were designed and built with deep respect for the local context — the climate, the soil, the regulatory environment, the supply chain, the workforce. We do not transplant solutions; we adapt them.', 'allianzandco' ); ?></p>
            <h2><?php esc_html_e( 'A long-term view', 'allianzandco' ); ?></h2>
            <p><?php esc_html_e( 'We measure our success in decades, not in quarters. We invest in our people, our partners and our systems — knowing that the best outcomes come from long-term commitment. That is why so much of our work comes from repeat clients.', 'allianzandco' ); ?></p>
            <h2><?php esc_html_e( 'Sustainability is not a department', 'allianzandco' ); ?></h2>
            <p><?php esc_html_e( 'It is the way we plan, design, build and operate. Every project is evaluated for its environmental and social impact, and we are constantly investing in lower-carbon construction methods, renewable energy and circular material use.', 'allianzandco' ); ?></p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="al-cta">
    <div class="al-container al-cta__inner">
        <h2 class="al-cta__title"><?php esc_html_e( 'See how we put this into practice', 'allianzandco' ); ?></h2>
        <a class="al-btn al-btn--white al-btn--lg" href="<?php echo esc_url( home_url( '/services' ) ); ?>">
            <?php esc_html_e( 'Our services', 'allianzandco' ); ?>
            <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
        </a>
    </div>
</section>

<?php get_footer();
