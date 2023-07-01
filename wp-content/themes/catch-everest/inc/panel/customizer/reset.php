<?php
/**
 * Reset Theme Options, Footer Options, Section Sorter Options, Font Family Options
 *
 * @package Vogue
 */

if ( ! class_exists( 'Catcheverest_Customizer_Reset' ) ) {
	/**
	 * Adds Reset button to customizer
	 */
	final class Catcheverest_Customizer_Reset {
		/**
		 * @var Catcheverest_Customizer_Reset
		 */
		private static $instance = null;

		/**
		 * @var WP_Customize_Manager
		 */
		private $wp_customize;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		private function __construct() {
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_controls_print_scripts' ) );
			add_action( 'wp_ajax_customizer_reset', array( $this, 'ajax_customizer_reset' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ) );
		}

		public function customize_controls_print_scripts() {

			wp_enqueue_script( 'catch-everest-customizer-reset', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/customizer-reset.min.js', array( 'jquery' ), '20190207' );
			
			wp_localize_script( 'catch-everest-customizer-reset', 'catchEverestCustomizerReset', array(
				'reset'          => esc_html__( 'Reset', 'catch-everest' ),
				'confirm'        => esc_html__( "Caution: Reset all settings to default. Process is irreversible.", 'catch-everest' ),
				'nonce'          => array(
					'reset' => wp_create_nonce( 'catch-everest-customizer-reset' ),
				),
				'resetSection'   => esc_html__( 'Reset section', 'catch-everest' ),
				'confirmSection' => esc_html__( "Caution: Reset section settings to default. Process is irreversible.", 'catch-everest' ),
			) );
		}

		/**
		 * Store a reference to `WP_Customize_Manager` instance
		 *
		 * @param $wp_customize
		 */
		public function customize_register( $wp_customize ) {
			$this->wp_customize = $wp_customize;
		}

		public function ajax_customizer_reset() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'catch-everest-customizer-reset', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			if ( 'all' === $_POST['section'] ) {
				$this->reset_customizer();
			}

			update_option( 'catcheverest_options', $options );

			wp_send_json_success();
		}

		public function reset_customizer() {
			
			delete_option( 'catcheverest_options' );
			remove_theme_mods();
		}
	}
}

Catcheverest_Customizer_Reset::get_instance();
