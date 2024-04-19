<?php
function museum_reviews_component() {
    ob_start();

    $query = new WP_Query([
        'post_type' => 'museum_reviews',
        'posts_per_page' => -1,
        'meta_key' => 'visit_date', // De key van het custom field gebruiken
        'orderby' => 'meta_value', // Sorteren op de waarde van het custom field
        'order' => 'DESC' // Of 'DESC' voor aflopend, afhankelijk van hoe je wilt sorteren
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $image_ids = explode(',', get_post_meta($post_id, 'museum_review_images', true));
            $background_color = esc_attr(get_post_meta($post_id, 'museum_background_color', true));
            $text_color = esc_attr(get_post_meta($post_id, 'museum_text_color', true)); // Tekstkleur ophalen
            ?>
            <div class='post-container' style='background-color: <?php echo $background_color; ?>; color: <?php echo $text_color; ?>;'> <!-- Kleur toegepast -->
                <div class='oxy-post' style="transform: rotate(<?php echo rand(-4, 4); ?>deg);">
                    <h2 class='oxy-post-title'><?php the_title(); ?></h2>
                    <div style='color: <?php echo $text_color; ?>;'>Bezoekdatum: <?php echo get_post_meta($post_id, 'visit_date', true); ?></div>

                    <a href='<?php echo esc_url(get_post_meta($post_id, 'museum_url', true)); ?>' class='oxy-post-museum-url' style='color: <?php echo $text_color; ?>; border-color: <?php echo $text_color; ?>;' target="_blank">Bezoek site van <?php the_title(); ?></a><br>
                    <a href='<?php echo esc_url(get_post_meta($post_id, 'museum_maps', true)); ?>' class='oxy-post-museum-maps' style='color: <?php echo $text_color; ?>; border-color: <?php echo $text_color; ?>;' target="_blank">Bekijk op Google Maps</a>
                    <div class='oxy-post-content'>
                        <?php the_content(); ?>
                    </div>
                    <div class='oxy-post-images-lint-wrapper' id='post-images-<?php echo $post_id; ?>'>
                    <div class="scroll-arrow left-arrow" style="position: absolute; left: 0; z-index: 10;">&lt;</div>
                    <div class='oxy-post-images-lint' style="position: relative;">
                    <?php foreach ($image_ids as $id) { echo wp_get_attachment_image($id, 'full', false, ["loading" => "lazy"]); } ?>
                    </div>
                    <div class="scroll-arrow right-arrow" style="position: absolute; right: 0; z-index: 10;">&gt;</div>
</div>
                    <div class='oxy-post-image-count'>
                        Aantal foto's: <?php echo count($image_ids); ?>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>Geen museum reviews gevonden.</p>';
    }

    wp_reset_postdata();


    echo '<style>
    .post-container {
        height: auto; /* Veranderd naar auto zodat de container kan groeien */
        display: flex;
        flex-direction: column; /* Richting veranderd om items verticaal te stapelen */
        align-items: center;
        justify-content: flex-start; /* Aanpassing om content vanaf de top te starten */
        padding-bottom: 100px;
        padding-top: 100px;
    }
    
    .oxy-post {
        width: 80%;
        margin: 0 auto;
    }
    
    
    .oxy-post-title,
    .oxy-post-museum-url,
    .oxy-post-museum-maps,
    .oxy-post-content {
        margin: 20px 0;
    }
    
    .oxy-post-images-lint-wrapper {
        display: flex;
        align-items: center;
        margin: 20px 0;
        position: relative; /* Nodig voor absolute positionering van pijlen */
    }
    
    .oxy-post-images-lint {
        display: flex;
        overflow-x: hidden;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        flex-grow: 1;
        max-height: 150px; /* Maximale hoogte voor de afbeeldingenstrip */
    }
    
    .oxy-post-images-lint img {
        scroll-snap-align: start;
        max-width: 100%;
        max-height: 150px;
        height: auto;
        object-fit: cover;
        margin: 0 5px;
    }
    
    .scroll-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        width: 60px;
        height: 60px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        cursor: pointer;
        position: absolute; /* Maakt pijlen absoluut gepositioneerd */
        top: 50%;
        transform: translateY(-50%);
        color:orange;
    }
    
    .left-arrow {
        left: 0;
    }
    
    .right-arrow {
        right: 0;
    }
    
    .oxy-post-image-count {
        margin-left: auto;
    }
        
    </style>
    
    <script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".oxy-post-images-lint-wrapper").forEach(wrapper => {
        const scrollContainer = wrapper.querySelector(".oxy-post-images-lint");
        const leftArrow = wrapper.querySelector(".left-arrow");
        const rightArrow = wrapper.querySelector(".right-arrow");

        leftArrow.addEventListener("click", () => {
            scrollContainer.scrollBy({ left: -200, behavior: "smooth" });
        });

        rightArrow.addEventListener("click", () => {
            scrollContainer.scrollBy({ left: 200, behavior: "smooth" });
        });
    });
});
</script>
';



    return ob_get_clean();
}

add_shortcode('museum_reviews', 'museum_reviews_component');
?>
