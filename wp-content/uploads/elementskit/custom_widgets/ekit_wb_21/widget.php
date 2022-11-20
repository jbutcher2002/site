<?php

namespace Elementor;

defined('ABSPATH') || exit;

class Ekit_Wb_21 extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_style( 'ekit-wb-21-style-handle', 'http://localhost/site/wp-content/uploads/elementskit/custom_widgets/ekit_wb_21/style.css');
		wp_register_script( 'ekit-wb-21-script-handle', 'http://localhost/site/wp-content/uploads/elementskit/custom_widgets/ekit_wb_21/script.js', [ 'elementor-frontend' ], '1.0.0', true );
	}


	public function get_style_depends() {
		return [ 'ekit-wb-21-style-handle' ];
	}


	public function get_script_depends() {
		return [ 'ekit-wb-21-script-handle' ];
	}

	public function get_name() {
		return 'ekit_wb_21';
	}


	public function get_title() {
		return esc_html__( 'Lottie Comment', 'elementskit-lite' );
	}


	public function get_categories() {
		return ['basic'];
	}


	public function get_icon() {
		return 'eicon-cog';
	}


	protected function register_controls() {
	}


	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
<div class="wrapper">

  
  <div 
       id="svg__00" 
       class="lottie"
  ></div>
  
  <h1>Render Inline Animation with JS</h1>
  <div 
       id="svg__01" 
       class="lottie"
  ></div>

  <h1>Render Remote Animation with Data Attributes</h1>
  <div 
       id="svg__02" 
       class="lottie" 
       data-animation-path="https://assets10.lottiefiles.com/packages/lf20_r2CgaB.json" 
       data-autoplay="true" 
       data-rederer="svg" 
       data-anim-loop="true" 
       data-name="Lottie Animation"
   ></div>
  
</div>

		<?php
	}


}
