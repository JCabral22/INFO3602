<?php get_header(); ?>
<div class="page-body">
    <?php
    while (have_posts()) {
        the_post(); ?>
        <div class='page-title' style="background-image: url(<?php echo get_theme_file_uri('images/n95.jpg') ?> );filter: grayscale(90%);"><?php the_title() ?></div>
        <div class="page-content">
            <div class="page-hierarchy">

                <?php
                $theParent = wp_get_post_parent_ID(get_the_ID());
                if ($theParent) { ?>
                    <div class="metabox">
                        <p><a class="parent-link" href="<?php echo get_permalink($theParent); ?>">
                                <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a>
                        </p>
                    </div>
                <?php }

                ?>
                <?php

                $testArray = get_pages(array(
                    'child_of' => get_the_ID()
                ));
                if ($theParent or $testArray) { ?>
                    <div class="page-links">
                        <h2 class="page-links__title">
                            <a href="<?php echo get_permalink($theParent); ?>">
                                <?php echo get_the_title($theParent); ?>
                            </a>
                        </h2>
                        <ul class="min-list">
                            <?php
                            if ($theParent) {
                                $findChildrenOf = $theParent;
                            } else {
                                $findChildrenOf = get_the_ID();
                            }
                            wp_list_pages(array(
                                'title_li' => NULL,
                                'child_of' => $findChildrenOf,
                                'sort_column' => 'menu_order'
                            ));
                            ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <div class="page-text"><?php if (get_the_title() == "Frequently asked Questions") {
                                        the_content();
                                        $args = array(
                                            //TODO: write query to check for all posts that belong to FAQ
                                            'category_name' => 'faq',
                                            'post_type' => 'post',
                                            'posts_per_page' => -1,
                                        );
                                        $faq_query = new WP_Query($args);
                                        // check if query was successfull
                                        if ($faq_query->have_posts()) {
                                            while ($faq_query->have_posts()) {
                                                $faq_query->the_post();
                                                the_title('<div class="question"><h1>', '</h1>');
                                                the_excerpt();
                                            }
                                    ?>
                        <a class="page-button" href=<?php echo get_permalink() ?>>READ MORE</a>
                <?php
                                            wp_reset_postdata();
                                        } else {
                                            echo 'No questions as yet! feel free to ask in the comments';
                                        }
                                    } else {
                                        the_content();
                                    } ?>
            </div>

        </div>
</div>
<?php }


    get_footer(); ?>