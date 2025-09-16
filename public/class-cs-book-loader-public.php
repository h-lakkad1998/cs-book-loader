<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://profiles.wordpress.org/hlakkad1998/
 * @since      1.0.0
 *
 * @package    Cs_Book_Loader
 * @subpackage Cs_Book_Loader/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cs_Book_Loader
 * @subpackage Cs_Book_Loader/public
 * @author     Hardik Patel <hardiklakkad2@gmail.com>
 */
class Cs_Book_Loader_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cs_Book_Loader_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cs_Book_Loader_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cs-book-loader-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cs-book-loader-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name, 'csBookLoader', 
			array( 
				'rest_url' => esc_url_raw( site_url('wp-json/books/v1/list') ),
				'nonce'    => wp_create_nonce( 'wp_rest' ),
			)
		);

	}



	function register_book_post_type() {
		$labels = array(
			'name'                  => _x( 'Books', 'Post Type General Name', 'cs-book-loader' ),
			'singular_name'         => _x( 'Book', 'Post Type Singular Name', 'cs-book-loader' ),
			'menu_name'             => __( 'Books', 'cs-book-loader' ),
			'name_admin_bar'        => __( 'Books', 'cs-book-loader' ),
			'archives'              => __( 'Book Archives', 'cs-book-loader' ),
			'attributes'            => __( 'Book Attributes', 'cs-book-loader' ),
			'parent_item_colon'     => __( 'Parent Book:', 'cs-book-loader' ),
			'all_items'             => __( 'All Book', 'cs-book-loader' ),
			'add_new_item'          => __( 'Add New Book', 'cs-book-loader' ),
			'add_new'               => __( 'Add New', 'cs-book-loader' ),
			'new_item'              => __( 'New Book', 'cs-book-loader' ),
			'edit_item'             => __( 'Edit Book', 'cs-book-loader' ),
			'update_item'           => __( 'Update Book', 'cs-book-loader' ),
			'view_item'             => __( 'View Book', 'cs-book-loader' ),
			'view_items'            => __( 'View Book', 'cs-book-loader' ),
			'search_items'          => __( 'Search Book', 'cs-book-loader' ),
			'not_found'             => __( 'Not found', 'cs-book-loader' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'cs-book-loader' ),
			'featured_image'        => __( 'Featured Image', 'cs-book-loader' ),
			'set_featured_image'    => __( 'Set featured image', 'cs-book-loader' ),
			'remove_featured_image' => __( 'Remove featured image', 'cs-book-loader' ),
			'use_featured_image'    => __( 'Use as featured image', 'cs-book-loader' ),
			'insert_into_item'      => __( 'Insert into Book', 'cs-book-loader' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Book', 'cs-book-loader' ),
			'items_list'            => __( 'Books list', 'cs-book-loader' ),
			'items_list_navigation' => __( 'Books list navigation', 'cs-book-loader' ),
			'filter_items_list'     => __( 'Filter Books list', 'cs-book-loader' ),
		);
		$args = array(
			'label'                 => __( 'Book', 'cs-book-loader' ),
			'description'           => __( 'Advanced Book Listing with Custom Filters & AJAX Pagination', 'cs-book-loader' ),
			'labels'                => $labels,
			'supports'              => array( 'title' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_icon'				=> 'dashicons-book',
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'books', $args );
	}

	function cs_books_register_submenu() {
		add_submenu_page(
			'edit.php?post_type=books',
			__( 'Cache Settings', 'cs-book-loader' ),
			__( 'Cache Settings', 'cs-book-loader' ),
			'manage_options',
			'cs-books-cache',
			array( $this, 'cs_books_cache_page')
		);
	}

	function cs_books_cache_page() {
		if ( isset( $_POST['cs_clear_cache'] ) && check_admin_referer( 'cs_clear_cache_action', 'cs_clear_cache_nonce' ) ) {
			global $wpdb;
			$like1 = $wpdb->esc_like( '_transient_cs_books_' ) . '%';
			$like2 = $wpdb->esc_like( '_transient_timeout_cs_books_' ) . '%';

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$count = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", $like1, $like2 ) );

			$count = ( $count >= 2 ) ? $count / 2 : 0; 
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", $like1, $like2 ) );

			echo '<div class="updated"><p>' . esc_html( $count ) .' '. esc_html__( 'Book cache cleared successfully.', 'cs-book-loader' ) . '</p></div>';
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Books Cache Settings', 'cs-book-loader' ); ?></h1>
			<form method="post">
				<?php wp_nonce_field( 'cs_clear_cache_action', 'cs_clear_cache_nonce' ); ?>
				<p><?php esc_html_e( 'Click the button below to clear all cached book queries.', 'cs-book-loader' ); ?></p>
				<p><input type="submit" name="cs_clear_cache" class="button button-primary" value="<?php esc_attr_e( 'Clear Cache', 'cs-book-loader' ); ?>"></p>
			</form>
		</div>
		<?php
	}

	function register_books_meta_boxes(){
		add_meta_box(
			'cs_books_meta_box',         
			'Book Details',           
			array($this, 'books_display_meta_box'), 
			'books',                  
			'normal',                 
			'default'                 
		);
	}

	function books_display_meta_box( $post ) {
		$author_name  = get_post_meta($post->ID, 'cs_author_name', true);
		$price        = get_post_meta($post->ID, 'cs_price', true);
		$publish_date = get_post_meta($post->ID, 'cs_publish_date', true);

		wp_nonce_field('cs_books_nonce', 'cs_books_meta_box_nonce');
		?>
		
		<p>
			<label for="cs_author_name"><strong><?php esc_html_e('Author Name:', 'cs-book-loader'); ?></strong></label><br>
			<input placeholder="<?php esc_attr_e('Enter Author Name','cs-book-loader'); ?>" type="text" name="cs_author_name" id="cs_author_name" value="<?php echo esc_attr($author_name); ?>" required >
		</p>

		<p>
			<label for="cs_price"><strong><?php esc_html_e('Price:', 'cs-book-loader'); ?></strong></label><br>
			<input placeholder="<?php esc_attr_e('Enter Price Between $20 and $200','cs-book-loader'); ?>" type="number" name="cs_price" id="cs_price" value="<?php echo esc_attr($price); ?>" step="1" min="20" max="200" required >
		</p>

		<p>
			<label for="cs_publish_date"><strong><?php esc_html_e('Published Date:', 'cs-book-loader'); ?></strong></label><br>
			<input type="date" name="cs_publish_date" id="cs_publish_date" value="<?php echo esc_attr($publish_date); ?>" required >
		</p>

		<?php
		
	}

	function  books_save_meta_box( $post_id ){
		$secure_nonce = isset($_POST['cs_books_meta_box_nonce']) ?  sanitize_text_field($_POST['cs_books_meta_box_nonce']) : '';
		if ( !wp_verify_nonce($secure_nonce, 'cs_books_nonce')) {
			return $post_id;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		if ('books' === get_post_type( $post_id ) ) {
			if (!current_user_can('edit_post', $post_id)) {
				return $post_id;
			}
		}

		if (isset($_POST['cs_author_name'])) {
			update_post_meta($post_id, 'cs_author_name', sanitize_text_field($_POST['cs_author_name']));
		}

		if (isset($_POST['cs_price'])) {
			update_post_meta($post_id, 'cs_price', floatval($_POST['cs_price']));
		}

		if (isset($_POST['cs_publish_date'])) {
			update_post_meta($post_id, 'cs_publish_date', sanitize_text_field($_POST['cs_publish_date']));
		}
	}

	function register_cs_filter_route(){
		 register_rest_route(
			'books/v1',
			'/list',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'get_books_list'),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);
	}

	public function check_permissions( WP_REST_Request $request ) {
        $nonce = $request->get_header( 'X-WP-Nonce' );
        if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
            return new WP_Error(
                'rest_forbidden',
                __( 'Invalid nonce.', 'cs-book-loader' ),
                array( 'status' => 403 )
            );
        }
        return true;
    }

	function get_books_list( WP_REST_Request $request ) {
		$paged = max( 1, (int) $request->get_param( 'page' ) );

		$author_letter = strtoupper( sanitize_text_field( $request->get_param( 'author_letter' ) ) );
		if ( ! preg_match( '/^[A-Z]$/', $author_letter ) ) {
			$author_letter = false;
		}

		$allowed_prices = array( '50-100', '100-150', '150-200' );
		$price_filter   = sanitize_text_field( $request->get_param( 'price_filter' ) );
		if ( ! in_array( $price_filter, $allowed_prices, true ) ) {
			$price_filter = false;
		}

		$order = strtoupper( $request->get_param( 'order' ) ) === 'NEWEST' ? 'DESC' : 'ASC';

		$prep_array = array(
            'paged'         => $paged,
            'order'         => $order,
        );

		if( false !== $price_filter ){
			$prep_array['price_filter']  =  $price_filter;
		}
		
		if( false !== $author_letter ){
			$prep_array['author_letter'] = $author_letter;
		}

        $cache_key = 'cs_books_' . md5( wp_json_encode( $prep_array ) );

        $cached = get_transient( $cache_key );
        if ( $cached ) {
			$books = $cached['books'];
			$pagination = $cached['pagination'];
        }else{
			if( $author_letter && $price_filter ){
				$meta_query = array( 'relation' => 'AND' );
			}

			if ( $author_letter ) {
				$meta_query[] = array(
					'key'     => 'cs_author_name',
					'value'   =>   '^' . $author_letter,
					// phpcs:ignore WordPressVIPMinimum.Performance.RegexpCompare.compare_compare
					'compare' => 'REGEXP',
				);
			}

			if ( $price_filter ) {
				$range = explode( '-', $price_filter );
				if ( count( $range ) === 2 ) {
					$meta_query[] = array(
						'key'     => 'cs_price',
						'value'   => array( (int) $range[0], (int) $range[1] ),
						'compare' => 'BETWEEN',
						'type'    => 'NUMERIC',
					);
				}
			}

			$args = array(
				'post_type'      => 'books',
				'post_status'    => 'publish',
				'posts_per_page' => get_option( 'posts_per_page', 10 ),
				'paged'          => $paged,
				'meta_query'     => $meta_query, //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				'orderby'        => 'meta_value',
				'meta_key'       => 'cs_publish_date', //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'order'          => $order,
				'fields'         => 'ids',
			);

			$query = new WP_Query( $args );

			$books = array();
			if ( $query->have_posts() ) {
				foreach ( $query->posts as $post_id ) {
					$books[] = array(
						'title'        => get_the_title( $post_id ),
						'author_name'  => get_post_meta( $post_id, 'cs_author_name', true ),
						'price'        => get_post_meta( $post_id, 'cs_price', true ),
						'publish_date' => get_post_meta( $post_id, 'cs_publish_date', true ),
					);
				}
			}

			$pagination = array(
				'current_page' => $paged,
				'total_pages'  => (int) $query->max_num_pages,
			);

			set_transient( $cache_key, array(
				'books'      => $books,
				'pagination' => $pagination,
			), HOUR_IN_SECONDS );
		}
		ob_start();
			if ( ! empty( $books ) ) {
				foreach ( $books as $book ) {
					?>
					<div class="book-item">
						<h3><?php echo esc_html( $book['title'] ); ?></h3>
							<p><strong><?php esc_html_e('Author:', 'cs-book-loader'); ?></strong> <?php echo esc_html( $book['author_name'] ); ?></p>
							<p><strong><?php esc_html_e('Price:', 'cs-book-loader'); ?></strong> $<?php echo esc_html( $book['price'] ); ?></p>
							<p><strong><?php esc_html_e('Published:', 'cs-book-loader'); ?></strong> <?php echo esc_html( $book['publish_date'] ); ?></p>
					</div>
					<?php
				}
			} else {
				echo '<p>No books found.</p>';
			}
		$html = ob_get_clean();

		return array(
			'html'       => $html,
			'pagination' => $pagination,
		);
	}

	function book_shortcode_callback( $atts ){
		$atts = shortcode_atts(
			array(
				'page'          => 1,
				'author_letter' => 'A',
				'price_filter'  => '50-100',
				'order'         => 'NEWEST',
			),
			$atts,
			'advanced_books'
		);

		$per_page  = get_option( 'posts_per_page' );
		$order    = $atts['order'];
		$book_query = new WP_Query( array(
			'post_type'      => 'books',
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
			'paged'          => 1,
			'orderby'        => 'meta_value', 
			'meta_key'       => 'cs_publish_date', //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'order'          => ( 'OLDEST' === $order ) ? 'ASC' : 'DESC',
		) );

		$books = array();
		foreach ( $book_query->posts as $post ) {
			$books[] = array(
				'title'        => get_the_title( $post->ID ),
				'author_name'  => get_post_meta( $post->ID, 'cs_author_name', true ),
				'price'        => get_post_meta( $post->ID, 'cs_price', true ),
				'publish_date' => get_post_meta( $post->ID, 'cs_publish_date', true ),
			);
		}

		ob_start();
		include plugin_dir_path( __FILE__ ) . 'partials/cs-book-loader-public-display.php';
		return ob_get_clean();
	}
}
