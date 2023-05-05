<?php
/**
 * Creates form fields output.
 *
 * This class is used in the class-admin.php to output form fields for the
 * configuration page for the plugin.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Utility\Forms
 */

namespace TSMLXtras\Utility;

use TSMLXtras\TSMLXtras;

if ( ! class_exists( 'Forms' ) ) {
	class TSMLX_Forms {
		
		/**
		 * Instance of main plugin object.
		 *
		 * @acces protected
		 * @var \TSMLXtras\TSMLXtras $plugin
		 */
		protected TSMLXtras $TSMLXtras;
		
		/**
		 * Plugin name, version, etc from plugin file header.
		 *
		 * @acces protected
		 * @var array $plugin_info
		 */
		protected mixed $plugin_info;
		
		/**
		 * Plugin slug with underscores in place of spaces
		 *
		 * @acces protected
		 * @var string $plugin_slug_underscores
		 */
		protected string $plugin_slug_underscores;
		
		/**
		 * Settings for this plugin.
		 *
		 * @acces protected
		 * @var array $plugin_options
		 */
		protected mixed $plugin_options;
		
		/**
		 * Template loader class.
		 *
		 * @acces protected
		 * @var \TSMLXtras\Utility\TSMLX_Admin_Template_Loader $template_loader
		 */
		protected TSMLX_Admin_Template_Loader $template_loader;
		
		/**
		 * Constructor.
		 *
		 * Instantiates the plugin by setting up the data structures that will
		 * be used to maintain the actions and the filters.
		 *
		 * @param \TSMLXtras\TSMLXtras $TSMLXtras
		 */
		public function __construct( TSMLXtras $TSMLXtras ) {
			$this->TSMLXtras               = $TSMLXtras;
			$this->plugin_slug_underscores = $this->TSMLXtras->get_slug( 'underscores' );
			$this->plugin_options          = $this->TSMLXtras->get_setting();
			$this->plugin_info             = $this->TSMLXtras->get_info();
			$this->template_loader         = new TSMLX_Admin_Template_Loader( $this->TSMLXtras );
		}
		
		/**
		 * Generic checkbox callback.
		 *
		 * @param array $args
		 *
		 * @return void
		 */
		public function draggable_list( array $args ): void {
			$data['slug']                 = $this->plugin_slug_underscores;
			$data                         = array_merge( $data, $args );
			$this->template_loader->set_template_data( $data );
			$this->template_loader->get_template_part( 'draggable_list' );
		}

		/**
		 * Generic checkbox callback.
		 *
		 * @param array $args
		 *
		 * @return void
		 */
		public function checkbox( array $args ): void {
			$data['id']      = $args['id'];
			$data['checked'] = array_key_exists( $args['id'], $this->plugin_options ) ? ' checked="checked"' : ' ';
			$data['slug']    = $this->plugin_slug_underscores;
			$data            = array_merge( $data, $args );
			$this->template_loader->set_template_data( $data );
			$this->template_loader->get_template_part( 'checkbox' );
		}

		/**
		 * Generic checkbox callback.
		 *
		 * @param array $args
		 *
		 * @return void
		 */
		public function color( array $args ): void {
			$data['color'] = array_key_exists( $args['id'], $this->plugin_options ) ? $this->plugin_options[ $args['id'] ] : ' ';
			$data['slug']  = $this->plugin_slug_underscores;
			$data          = array_merge( $data, $args );
			$this->template_loader->set_template_data( $data );
			$this->template_loader->get_template_part( 'color' );
		}

		/**
		 * Generic textbox callback.
		 *
		 * @param array $args
		 *
		 * @return void
		 */
		public function text( array $args ): void {
			$data['text'] = array_key_exists( $args['id'], $this->plugin_options ) ? $this->plugin_options[ $args['id'] ] : ' ';
			$data['slug']  = $this->plugin_slug_underscores;
			$data          = array_merge( $data, $args );
			$this->template_loader->set_template_data( $data );
			$this->template_loader->get_template_part( 'text' );
		}

		/**
		 * Generic image field callback.
		 *
		 * @param array $args
		 *
		 * @return void
		 */
		public function image( array $args ): void {
			$data['plugin_url'] = $this->TSMLXtras->get_path('plugin_url');
			$data['slug']       = $this->plugin_slug_underscores;
			$data['image_id']   = esc_attr( $this->plugin_options[ $args['id'] ] );
			$data               = array_merge( $data, $args );
			$this->template_loader->set_template_data( $data );
			$this->template_loader->get_template_part( 'image' );
		}
		
		/**
		 * Generic textarea field callback.
		 *
		 * @param array $args
		 *
		 * @return void
		 */
		public function textarea( array $args ): void {
			$data['content'] = $this->plugin_options[ $args['id'] ];
			$data['slug']    = $this->plugin_slug_underscores;
			$data            = array_merge( $data, $args );
			$this->template_loader->set_template_data( $data );
			$this->template_loader->get_template_part( 'textarea' );
		}
		
		/**
		 * Prints section info for Schema Settings.
		 *
		 * @param array $args
		 *
		 * @return void
		 */
		public function print_section_info( array $args ): void {
			print "<small>" . $args['description'] . "</small>";
		}
	}
}
