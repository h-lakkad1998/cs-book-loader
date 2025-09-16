<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://https://profiles.wordpress.org/hlakkad1998/
 * @since      1.0.0
 *
 * @package    Cs_Book_Loader
 * @subpackage Cs_Book_Loader/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="books-filter-wrap">
    <div class="books-filters">
        <label>
            <?php esc_html_e('Author Name:', 'cs-book-loader'); ?>
            <select id="filter-author">
                <option value="" disabled selected ><?php esc_html_e('---Select Letter---','cs-book-loader'); ?></option>
                <?php foreach ( range( 'A', 'Z' ) as $letter ) : ?>
                    <option value="<?php echo esc_attr( $letter ); ?>" >
                        <?php echo esc_html( $letter ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            <?php esc_html_e('Price Range:', 'cs-book-loader'); ?>
            <select id="filter-price">
                <option value="" disabled selected ><?php esc_html_e('---Select Price Range---','cs-book-loader'); ?></option>
                <?php foreach ( array( '50-100', '100-150', '150-200' ) as $range ) : ?>
                    <option value="<?php echo esc_attr( $range ); ?>" >
                        <?php echo esc_html( $range ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            <?php esc_html_e('Publish Date:', 'cs-book-loader'); ?>
            <select id="filter-order">
                <option value="NEWEST" <?php selected( $order, 'NEWEST' ); ?>><?php esc_html_e('Newest', 'cs-book-loader'); ?></option>
                <option value="OLDEST" <?php selected( $order, 'OLDEST' ); ?>><?php esc_html_e('Oldest', 'cs-book-loader'); ?></option>
            </select>
        </label>
    </div>

    <div class="books-list">
        <?php if ( ! empty( $books ) ) : ?>
            <?php foreach ( $books as $book ) : ?>
                <div class="book-item">
                    <h3><?php echo esc_html( $book['title'] ); ?></h3>
                    <p><strong><?php esc_html_e('Author:', 'cs-book-loader'); ?></strong> <?php echo esc_html( $book['author_name'] ); ?></p>
                    <p><strong><?php esc_html_e('Price:', 'cs-book-loader'); ?></strong> $<?php echo esc_html( $book['price'] ); ?></p>
                    <p><strong><?php esc_html_e('Published:', 'cs-book-loader'); ?></strong> <?php echo esc_html( $book['publish_date'] ); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p><?php esc_html_e('No books found.', 'cs-book-loader'); ?></p>
        <?php endif; ?>
    </div>

    <div class="books-load-more">
        <button id="cs-load-more-btn" type="button"  <?php echo $book_query->max_num_pages >= 2 ? '' : ' style="display:none;"'; ?>><?php esc_html_e('Load More', 'cs-book-loader'); ?></button>
    </div>
</div>
