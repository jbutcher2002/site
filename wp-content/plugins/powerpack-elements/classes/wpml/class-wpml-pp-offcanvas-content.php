<?php

class WPML_PP_Offcanvas_Content extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'custom_content';
	}

	public function get_fields() {
<<<<<<< HEAD
		return array( 'title', 'description' );
=======
		return array( 
			'title',
			'description',
		);
>>>>>>> master
	}

	protected function get_title( $field ) {
		switch( $field ) {
			case 'title':
<<<<<<< HEAD
				return esc_html__( 'Offcanvas Content - Title', 'power-pack' );

			case 'description':
				return esc_html__( 'Offcanvas Content - Description', 'power-pack' );

=======
				return esc_html__( 'Offcanvas Content - Box Title', 'powerpack' );
			case 'description':
				return esc_html__( 'Offcanvas Content - Box Description', 'powerpack' );
>>>>>>> master
			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch( $field ) {
			case 'title':
				return 'LINE';
<<<<<<< HEAD

			case 'description':
				return 'VISUAL';

=======
			case 'description':
				return 'LINE';
>>>>>>> master
			default:
				return '';
		}
	}

}
