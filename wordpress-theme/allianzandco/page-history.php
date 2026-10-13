<?php
/**
 * Template Name: History
 *
 * @package AllianzAndCo
 */
get_header();

$al_title    = get_the_title();
$al_subtitle = 'From a small engineering practice to a continent-wide EPC partner — twenty years of building Africa.';
$al_image    = get_the_post_thumbnail_url( null, 'full' ) ?: AL_THEME_URI . '/assets/images/about-2.jpg';
include locate_template( 'template-parts/page-header.php' );
?>

<section class="al-section">
    <div class="al-container">
        <div style="max-width: 880px; margin: 0 auto;">
            <div class="al-timeline al-reveal">
                <?php
                $milestones = array(
                    array( 'y' => '2005', 't' => 'Foundation in Paris',          'd' => 'Alliance & Co is founded by Ostin Harrison as a specialist engineering consultancy focused on power and infrastructure in West Africa.' ),
                    array( 'y' => '2008', 't' => 'First substation project',     'd' => 'Delivery of a 225 kV substation in Abidjan for CI-Energie — the project that defined our EPC model.' ),
                    array( 'y' => '2011', 't' => 'Expansion across West Africa', 'd' => 'New offices in Dakar, Accra and Lagos. Local teams established to deepen partnerships with national utilities.' ),
                    array( 'y' => '2014', 't' => 'First solar PV plant',         'd' => 'Commissioning of a 30 MWp solar PV plant in Senegal — our first major renewable energy project.' ),
                    array( 'y' => '2017', 't' => 'East Africa entry',           'd' => 'Award of a major wind farm package at Lake Turkana, Kenya — establishing our East African presence.' ),
                    array( 'y' => '2019', 't' => 'ISO 9001 / 14001 / 45001',     'd' => 'Group-wide certification of our integrated QHSE management system.' ),
                    array( 'y' => '2021', 't' => 'EPCM model launch',            'd' => 'Rollout of our full EPCM service line for multi-stakeholder infrastructure programs.' ),
                    array( 'y' => '2023', 't' => 'Operations & Maintenance',     'd' => 'Launch of long-term O&M services — keeping the assets we build performing for decades.' ),
                    array( 'y' => '2025', 't' => '100+ projects delivered',      'd' => 'A milestone year: 100+ projects delivered, 18 countries served, 350+ engineers and builders.' ),
                );
                foreach ( $milestones as $m ) : ?>
                    <div class="al-timeline__item">
                        <div class="al-timeline__year"><?php echo esc_html( $m['y'] ); ?></div>
                        <h3 class="al-timeline__title"><?php echo esc_html( $m['t'] ); ?></h3>
                        <p><?php echo esc_html( $m['d'] ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="al-cta">
    <div class="al-container al-cta__inner">
        <h2 class="al-cta__title"><?php esc_html_e( 'Be part of the next chapter', 'allianzandco' ); ?></h2>
        <a class="al-btn al-btn--white al-btn--lg" href="<?php echo esc_url( home_url( '/contacts' ) ); ?>">
            <?php esc_html_e( 'Get in touch', 'allianzandco' ); ?>
            <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
        </a>
    </div>
</section>

<?php get_footer();
