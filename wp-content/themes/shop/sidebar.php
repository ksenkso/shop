<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}

$taxonomy     = 'product_cat';
$orderby      = 'name';
$show_count   = 0;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title        = '';
$empty        = 0;

$args = array(
    'taxonomy'     => $taxonomy,
    'orderby'      => $orderby,
    'show_count'   => $show_count,
    'pad_counts'   => $pad_counts,
    'hierarchical' => $hierarchical,
    'title_li'     => $title,
    'hide_empty'   => $empty
);
$all_categories = get_categories( $args );

?>

<div id="secondary" class="widget-area" role="complementary">
    <ul class="cat-list">
    <?php
    foreach ($all_categories as $cat) :
        if($cat->category_parent == 0) :
            $category_id = $cat->term_id;
            $args2 = array(
                'taxonomy'     => $taxonomy,
                'child_of'     => 0,
                'parent'       => $category_id,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
            );
            $sub_cats = get_categories( $args2 );

            ?>
            <li class="cat-item">
                <a href="<?= get_term_link($cat->slug, 'product_cat') ?>"><?= $cat->name ?>
                <?php
                if($sub_cats) : ?>
                    <div class="cat-toggle">+</div></a>
                    <ul class="subcat-list">
                    <?php foreach($sub_cats as $sub_category) : ?>
                        <li class="cat-item">
                            <a href="<?= get_term_link($sub_category->slug, 'product_cat') ?>"><?= $sub_category->name ?></a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                </a>
                <?php endif; ?>
            </li>
        <?php

        endif;
    endforeach;
    ?>
    </ul>
</div><!-- #secondary -->