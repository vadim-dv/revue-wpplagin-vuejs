<?php
/**
 * medicinadigruppospallanzani functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package medicinadigruppospallanzani
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'medicinadigruppospallanzani_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function medicinadigruppospallanzani_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on medicinadigruppospallanzani, use a find and replace
		 * to change 'medicinadigruppospallanzani' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'medicinadigruppospallanzani', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'medicinadigruppospallanzani' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'medicinadigruppospallanzani_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 77,
				'width'       => 219,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'medicinadigruppospallanzani_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function medicinadigruppospallanzani_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'medicinadigruppospallanzani_content_width', 640 );
}
add_action( 'after_setup_theme', 'medicinadigruppospallanzani_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function medicinadigruppospallanzani_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'medicinadigruppospallanzani' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'medicinadigruppospallanzani' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'medicinadigruppospallanzani_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function medicinadigruppospallanzani_scripts() {
	wp_enqueue_style( 'medicinadigruppospallanzani-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'medicinadigruppospallanzani-style', 'rtl', 'replace' );

	wp_enqueue_script( 'medicinadigruppospallanzani-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'medicinadigruppospallanzani-review', get_template_directory_uri() . '/js/add_review.js', array( 'jquery' ), _S_VERSION, true );

	global $post;
	if( has_shortcode( $post->post_content, 'post-slider') ) {
		wp_enqueue_script( 'medicinadigruppospallanzani-clider', get_template_directory_uri() . '/js/custom-slider.js', array(), _S_VERSION, true );
	}	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'medicinadigruppospallanzani_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/*==============================*/

/**
 * Возможность загружать изображения для терминов (элементов таксономий: категории, метки).
 *
 * Пример получения ID и URL картинки термина:
 *     $image_id = get_term_meta( $term_id, '_thumbnail_id', 1 );
 *     $image_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
 *
 * @author: Kama http://wp-kama.ru
 *
 * @version 3.0
 */
if( is_admin() && ! class_exists('Term_Meta_Image') ){

	// init
	//add_action('current_screen', 'Term_Meta_Image_init');
	add_action( 'admin_init', 'Term_Meta_Image_init' );
	function Term_Meta_Image_init(){
		$GLOBALS['Term_Meta_Image'] = new Term_Meta_Image();
	}

	class Term_Meta_Image {

		// для каких таксономий включить код. По умолчанию для всех публичных
		static $taxes = []; // пример: array('category', 'post_tag');

		// название мета ключа
		static $meta_key = '_thumbnail_id';
		static $attach_term_meta_key = 'img_term';

		// URL пустой картинки
		static $add_img_url = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkAQMAAABKLAcXAAAABlBMVEUAAAC7u7s37rVJAAAAAXRSTlMAQObYZgAAACJJREFUOMtjGAV0BvL/G0YMr/4/CDwY0rzBFJ704o0CWgMAvyaRh+c6m54AAAAASUVORK5CYII=';

		public function __construct(){
			// once
			if( isset($GLOBALS['Term_Meta_Image']) )
				return $GLOBALS['Term_Meta_Image'];

			$taxes = self::$taxes ? self::$taxes : get_taxonomies( [ 'public' =>true ], 'names' );

			foreach( $taxes as $taxname ){
				add_action( "{$taxname}_add_form_fields",   [ $this, 'add_term_image' ],     10, 2 );
				add_action( "{$taxname}_edit_form_fields",  [ $this, 'update_term_image' ],  10, 2 );
				add_action( "created_{$taxname}",           [ $this, 'save_term_image' ],    10, 2 );
				add_action( "edited_{$taxname}",            [ $this, 'updated_term_image' ], 10, 2 );

				add_filter( "manage_edit-{$taxname}_columns",  [ $this, 'add_image_column' ] );
				add_filter( "manage_{$taxname}_custom_column", [ $this, 'fill_image_column' ], 10, 3 );
			}
		}

		## поля при создании термина
		public function add_term_image( $taxonomy ){
			wp_enqueue_media(); // подключим стили медиа, если их нет

			add_action('admin_print_footer_scripts', [ $this, 'add_script' ], 99 );
			$this->css();
			?>
			<div class="form-field term-group">
				<label><?php _e('Image', 'default'); ?></label>
				<div class="term__image__wrapper">
					<a class="termeta_img_button" href="#">
						<img src="<?php echo self::$add_img_url ?>" alt="">
					</a>
					<input type="button" class="button button-secondary termeta_img_remove" value="<?php _e( 'Remove', 'default' ); ?>" />
				</div>

				<input type="hidden" id="term_imgid" name="term_imgid" value="">
			</div>
			<?php
		}

		## поля при редактировании термина
		public function update_term_image( $term, $taxonomy ){
			wp_enqueue_media(); // подключим стили медиа, если их нет

			add_action('admin_print_footer_scripts', [ $this, 'add_script' ], 99 );

			$image_id = get_term_meta( $term->term_id, self::$meta_key, true );
			$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : self::$add_img_url;
			$this->css();
			?>
			<tr class="form-field term-group-wrap">
				<th scope="row"><?php _e( 'Image', 'default' ); ?></th>
				<td>
					<div class="term__image__wrapper">
						<a class="termeta_img_button" href="#">
							<?php echo '<img src="'. $image_url .'" alt="">'; ?>
						</a>
						<input type="button" class="button button-secondary termeta_img_remove" value="<?php _e( 'Remove', 'default' ); ?>" />
					</div>

					<input type="hidden" id="term_imgid" name="term_imgid" value="<?php echo $image_id; ?>">
				</td>
			</tr>
			<?php
		}

		public function css(){
			?>
			<style>
				.termeta_img_button{ display:inline-block; margin-right:1em; }
				.termeta_img_button img{ display:block; float:left; margin:0; padding:0; min-width:100px; max-width:150px; height:auto; background:rgba(0,0,0,.07); }
				.termeta_img_button:hover img{ opacity:.8; }
				.termeta_img_button:after{ content:''; display:table; clear:both; }
			</style>
			<?php
		}

		## Add script
		public function add_script(){
			// выходим если не на нужной странице таксономии
			//$cs = get_current_screen();
			//if( ! in_array($cs->base, array('edit-tags','term')) || ! in_array($cs->taxonomy, (array) $this->for_taxes) )
			//  return;

			$title = __('Featured Image', 'default');
			$button_txt = __('Set featured image', 'default');
			?>
			<script>
				jQuery(document).ready(function($){
					var frame,
						$imgwrap = $('.term__image__wrapper'),
						$imgid   = $('#term_imgid');

					// добавление
					$('.termeta_img_button').click( function(ev){
						ev.preventDefault();

						if( frame ){ frame.open(); return; }

						// задаем media frame
						frame = wp.media.frames.questImgAdd = wp.media({
							states: [
								new wp.media.controller.Library({
									title:    '<?php echo $title ?>',
									library:   wp.media.query({ type: 'image' }),
									multiple: false,
									//date:   false
								})
							],
							button: {
								text: '<?php echo $button_txt ?>', // Set the text of the button.
							}
						});

						// выбор
						frame.on('select', function(){
							var selected = frame.state().get('selection').first().toJSON();
							if( selected ){
								$imgid.val( selected.id );
								$imgwrap.find('img').attr('src', selected.sizes.thumbnail.url );
							}
						} );

						// открываем
						frame.on('open', function(){
							if( $imgid.val() ) frame.state().get('selection').add( wp.media.attachment( $imgid.val() ) );
						});

						frame.open();
					});

					// удаление
					$('.termeta_img_remove').click(function(){
						$imgid.val('');
						$imgwrap.find('img').attr('src','<?php echo self::$add_img_url ?>');
					});
				});
			</script>

			<?php
		}

		## Добавляет колонку картинки в таблицу терминов
		public function add_image_column( $columns ){
			// fix column width
			add_action( 'admin_notices', function(){
				echo '<style>.column-image{ width:50px; text-align:center; }</style>';
			});

			// column without name
			return array_slice( $columns, 0, 1 ) + [ 'image' =>'' ] + $columns;
		}

		public function fill_image_column( $string, $column_name, $term_id ){

			if( 'image' === $column_name && $image_id = get_term_meta( $term_id, self::$meta_key, 1 ) ){
				$string = '<img src="'. wp_get_attachment_image_url( $image_id, 'thumbnail' ) .'" width="50" height="50" alt="" style="border-radius:4px;" />';
			}

			return $string;
		}

		## Save the form field
		public function save_term_image( $term_id, $tt_id ){
			if( isset($_POST['term_imgid']) && $attach_id = (int) $_POST['term_imgid'] ){
				update_term_meta( $term_id,   self::$meta_key,             $attach_id );
				update_post_meta( $attach_id, self::$attach_term_meta_key, $term_id );
			}
		}

		## Update the form field value
		public function updated_term_image( $term_id, $tt_id ){
			if( ! isset($_POST['term_imgid']) )
				return;

			$cur_term_attach_id = (int) get_term_meta( $term_id, self::$meta_key, 1 );

			if( $attach_id = (int) $_POST['term_imgid'] ){
				update_term_meta( $term_id,   self::$meta_key,             $attach_id );
				update_post_meta( $attach_id, self::$attach_term_meta_key, $term_id );

				if( $cur_term_attach_id != $attach_id )
					wp_delete_attachment( $cur_term_attach_id );
			}
			else {
				if( $cur_term_attach_id )
					wp_delete_attachment( $cur_term_attach_id );

				delete_term_meta( $term_id, self::$meta_key );
			}
		}

	}

}







function custom_taxonomy_area() {
	$labels = array(
	'name'                       => _x( 'Medicine Areas', 'Taxonomies', 'Taxonomy General Name', 'text_domain' ),
	'singular_name'              => _x( 'Medicine Area', 'Taxonomy', 'Taxonomy Singular Name', 'text_domain' ),
	'menu_name'                  => __( 'Medicine Area', 'Taxonomy', 'text_domain' ),
	'all_items'                  => __( 'All Items', 'text_domain' ),
	'parent_item'                => __( 'Parent Item', 'text_domain' ),
	'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
	'new_item_name'              => __( 'New Item Name', 'text_domain' ),
	'add_new_item'               => __( 'Add New Item', 'text_domain' ),
	'edit_item'                  => __( 'Edit Item', 'text_domain' ),
	'update_item'                => __( 'Update Item', 'text_domain' ),
	'view_item'                  => __( 'View Item', 'text_domain' ),
	'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
	'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
	'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
	'popular_items'              => __( 'Popular Items', 'text_domain' ),
	'search_items'               => __( 'Search Items', 'text_domain' ),
	'not_found'                  => __( 'Not Found', 'text_domain' ),
	'no_terms'                   => __( 'No items', 'text_domain' ),
	'items_list'                 => __( 'Items list', 'text_domain' ),
	'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
	'labels'                     => $labels,
	'hierarchical'               => true,
	'public'                     => true,
	'show_ui'                    => true,
	'show_admin_column'          => true,
	'show_in_nav_menus'          => true,
	'show_tagcloud'              => true,
	);
	register_taxonomy( 'area', array( 'doctors' ), $args );
	}
	add_action( 'init', 'custom_taxonomy_area', 0 );




function custom_post_type_doctors() {

$labels = array(
	'name'                  => 'Doctors',
	'singular_name'         => 'Doctor',
	'menu_name'             => 'Doctors',

	'add_new_item'          => 'Add new doctor',
	'add_new'               => 'Add new doctor',
	'new_item'              => 'new',
	'edit_item'             => 'dit',
	'update_item'           => 'update',
	'view_item'             => 'see all',
	'view_items'            => 'see',
	'search_items'          => 'search',
	'not_found'             => 'Not found',
	'not_found_in_trash'    => 'Not found in Trash',

);
$rewrite = array(
	'slug'                  => 'doctors',
	'with_front'            => true,
	'pages'                 => false,
	'feeds'                 => false,
);
$args = array(
	'label'                 => 'Doctors',
	'description'           => 'Doctors list',
	'labels'                => $labels,
	'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', ),
	'taxonomies'            => array( 'area' ),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 6,
	'menu_icon'             => 'dashicons-nametag',
	'show_in_admin_bar'     => true,
	'show_in_nav_menus'     => true,
	'can_export'            => true,
	'has_archive'           => true,
	'exclude_from_search'   => true,
	'query_var'             => 'foto',
	'publicly_queryable'    => true,
	'rewrite'               => $rewrite,
	
);
register_post_type( 'doctors', $args );    
}
add_action( 'init', 'custom_post_type_doctors', 0 );

/*
     * Chorcode for slider
 */

add_shortcode('post-slider', 'my_shortcode_function');
function my_shortcode_function() {
    $args = array(
        'posts_per_page' => 10,
        'post_type' => 'doctors'        
    );
	echo "<div class=\"slider-wrap\">";
    $my_query = new WP_Query( $args );
    if ( $my_query->have_posts() ) :
        // Start the loop.
        while ( $my_query->have_posts() ) : $my_query->the_post();

            get_template_part( 'template-parts/content-slider', get_post_format() );

            // End the loop.
        endwhile;
    // If no content, include the "No posts found" template.
    else :
        get_template_part( 'template-parts/content', 'none' );

    endif;
	echo "</div>";
    }


 /**
 * Custom post type for Reviews
**/
add_action( 'init', 'register_post_type_reviews' );
function register_post_type_reviews(){
    register_post_type('reviews', array(
        'label'  => null,
        'labels' => [
            'name'               => 'Review',
            'singular_name'      => 'Review',
            'add_new'            => 'Add Review',
            'add_new_item'       => 'Adding Review',
            'edit_item'          => 'Edit Review',
            'new_item'           => 'New Review',
            'view_item'          => 'View Review',
            'search_items'       => 'Search Review',
            'not_found'          => 'Not found',
            'not_found_in_trash' => 'Not found in trash',
            'menu_name'          => 'Reviews',
        ],
        'description'            => 'Reviews',
        'exclude_from_search'    => false,
        'public'                 => true,
        'capability_type'        => 'page',
        'hierarchical'           => false,
        'show_in_menu'           => null,
        'show_in_rest'           => true,
        'rest_base'              => null,
        'menu_position'          => null,
        'menu_icon'              => 'dashicons-format-status',
        'supports'               => [
            'title',
            'editor',
            // 'excerpt', 
            // 'trackbacks', 
            // 'custom-fields', 
            // 'comments', 
            // 'revisions', 
            // 'thumbnail', 
            // 'author', 
            // 'page-attributes', 
        ],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ) );
}

/**
 * Notification about new reviews in admin area
**/
add_action( 'admin_menu', 'add_user_menu_bubble' );
function add_user_menu_bubble() {
    global $menu;

    $count = wp_count_posts('reviews')->pending; # need approvement 
    if ($count) {
        foreach ($menu as $key => $value) {
            if ( $menu[$key][2] == 'edit.php?post_type=reviews' ) {
                $menu[$key][0] .= '<span class="awaiting-mod"><span class="pending-count">'.$count.'</span></span>';
                break;
            }
        }
    }
}

//Filter to to get acf field within acf field for relational field set
add_filter( 'acf/rest_api/reviews/get_fields', function( $data ) {
    if ( ! empty( $data ) ) {
        array_walk_recursive( $data, 'get_fields_recursive' );
    }

    return $data;
} );

