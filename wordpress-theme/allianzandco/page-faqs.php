<?php
/**
 * Template Name: FAQs
 *
 * @package AllianzAndCo
 */
get_header();

$al_title    = get_the_title();
$al_subtitle = 'Answers to the questions we get most often from clients, partners and candidates.';
$al_image    = get_the_post_thumbnail_url( null, 'full' ) ?: AL_THEME_URI . '/assets/images/about-1.jpg';
include locate_template( 'template-parts/page-header.php' );
?>

<section class="al-section">
    <div class="al-container" style="max-width: 900px;">
        <div class="al-faq al-reveal">
            <?php
            $faq_q = new WP_Query( array( 'post_type' => 'al_faq', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
            $i = 0;
            if ( $faq_q->have_posts() ) :
                while ( $faq_q->have_posts() ) : $faq_q->the_post(); $i++; ?>
                    <div class="al-faq__item <?php echo $i === 1 ? 'is-open' : ''; ?>">
                        <button class="al-faq__q" aria-expanded="<?php echo $i === 1 ? 'true' : 'false'; ?>">
                            <span><?php the_title(); ?></span>
                            <span class="al-faq__icon"></span>
                        </button>
                        <div class="al-faq__a">
                            <div class="al-faq__a-inner"><?php the_content(); ?></div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata();
            else :
                $faqs = array(
                    array( 'q' => 'What types of projects does Alliance & Co deliver?', 'a' => 'We deliver complex engineering, construction, energy and infrastructure projects across the African continent — including high-voltage transmission, solar and wind farms, industrial facilities and turnkey commercial builds.' ),
                    array( 'q' => 'In which countries do you operate?',                  'a' => 'We are headquartered in France with active operations across West, East and North Africa, including Côte d\'Ivoire, Senegal, Nigeria, Ghana, Morocco, Kenya and Ethiopia.' ),
                    array( 'q' => 'How do you ensure quality and safety on your sites?', 'a' => 'Every project is governed by an integrated quality, health, safety and environment (QHSE) system, certified to ISO 9001, ISO 14001 and ISO 45001 standards.' ),
                    array( 'q' => 'Do you offer renewable energy solutions?',             'a' => 'Yes — solar PV plants, wind farms, hybrid energy systems and grid-stability solutions are core to our business. We design, finance and build.' ),
                    array( 'q' => 'Can you support a project from feasibility to commissioning?', 'a' => 'Absolutely. Our full EPC / EPCM model covers feasibility, design, procurement, construction, commissioning and long-term operations & maintenance.' ),
                    array( 'q' => 'How do I request a proposal?',                        'a' => 'Use the contact form on our website or email projects@alliance-co.net with your project brief, location and timeline. We will respond within two business days.' ),
                );
                foreach ( $faqs as $j => $f ) : ?>
                    <div class="al-faq__item <?php echo $j === 0 ? 'is-open' : ''; ?>">
                        <button class="al-faq__q" aria-expanded="<?php echo $j === 0 ? 'true' : 'false'; ?>">
                            <span><?php echo esc_html( $f['q'] ); ?></span>
                            <span class="al-faq__icon"></span>
                        </button>
                        <div class="al-faq__a">
                            <div class="al-faq__a-inner"><p><?php echo esc_html( $f['a'] ); ?></p></div>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="al-cta">
    <div class="al-container al-cta__inner">
        <h2 class="al-cta__title"><?php esc_html_e( 'Still have questions?', 'allianzandco' ); ?></h2>
        <a class="al-btn al-btn--white al-btn--lg" href="<?php echo esc_url( home_url( '/contacts' ) ); ?>">
            <?php esc_html_e( 'Contact us', 'allianzandco' ); ?>
            <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
        </a>
    </div>
</section>

<?php get_footer();
