<?php
namespace PowerpackElements\Modules\Posts;

use PowerpackElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'pp-posts';
	}

	public function get_widgets() {
		return [
			'Card_Slider',
			'Content_Ticker',
			'Magazine_Slider',
			'Tiled_Posts',
			'Posts',
			'Timeline',
		];
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		/**
		 * Pagination Break.
		 *
		 * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
		 */
		/*add_action( 'pre_get_posts', [ $this, 'fix_query_offset' ], 1 );
		add_filter( 'found_posts', [ $this, 'fix_query_found_posts' ], 1, 2 );*/

		add_action( 'wp_ajax_pp_get_post', array( $this, 'get_post_data' ) );
		add_action( 'wp_ajax_nopriv_pp_get_post', array( $this, 'get_post_data' ) );
	}
	
	public function get_post_data() {
		
		$post_id   = $_POST['page_id'];
		$widget_id = $_POST['widget_id'];
		$filter  = $_POST['category'];
		$filter   = str_replace( '.', '', $filter );
		$taxonomy_filter  = $_POST['taxonomy'];
		$taxonomy_filter   = str_replace( '.', '', $taxonomy_filter );

		$elementor = \Elementor\Plugin::$instance;
		$meta      = $elementor->documents->get( $post_id )->get_elements_data();

		$widget_data = $this->find_element_recursive( $meta, $widget_id );
		
		$data = array(
			'message'    => __( 'Saved', 'powerpack' ),
			'ID'         => '',
			'skin_id'    => '',
			'html'       => '',
			'pagination' => '',
		);
		
		if ( null != $widget_data ) {
			
			// Restore default values.
			$widget = $elementor->elements_manager->create_element_instance( $widget_data );
			$skin = $widget->get_current_skin();
			$skin_body = $skin->render_ajax_post_body( $filter, $taxonomy_filter );
			$pagination = $skin->render_ajax_pagination();
		
			$data['ID']         = $widget->get_id();
			$data['skin_id']    = $widget->get_current_skin_id();
			$data['html']		= $skin_body;
			$data['pagination'] = $pagination;
		}
		wp_send_json_success( $data );
	}

	/**
	 * Get Widget Setting data.
	 *
	 * @since 1.7.0
	 * @access public
	 * @param array  $elements Element array.
	 * @param string $form_id Element ID.
	 * @return Boolean True/False.
	 */
	public function find_element_recursive( $elements, $form_id ) {

		foreach ( $elements as $element ) {
			if ( $form_id === $element['id'] ) {
				return $element;
			}

			if ( ! empty( $element['elements'] ) ) {
				$element = $this->find_element_recursive( $element['elements'], $form_id );

				if ( $element ) {
					return $element;
				}
			}
		}

		return false;
	}

	/**
	 * Get Post Parts
	 *
	 * @since  1.4.11.0
	 * @return array
	 */
	public static function get_post_parts() {
		$post_parts = [
			'thumbnail',
			'terms',
			'title',
			'meta',
			'excerpt',
			'button',
		];

		return $post_parts;
	}

	/**
	 * Get Meta Items
	 *
	 * @since  1.4.11.0
	 * @return array
	 */
	public static function get_meta_items() {
		$meta_items = [
			'author',
			'date',
			'comments',
		];

		return $meta_items;
	}
}
