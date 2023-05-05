<?php
/**
 * Adds extra fields to groups
 *
 * This class is instantiated and run() in the main TSMLXtras class to add
 * all extra fields that are available within the plugin
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\TSMLX_Xtrafields
 */

namespace TSMLXtras\Xtrafields;

use TSMLXtras\TSMLXtras;
if ( ! class_exists( 'TSMLX_Xtrafields' ) ) {
	class TSMLX_Xtrafields {
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
		 * Is Group Unique ID field enabled
		 *
		 * @acces protected
		 * @var bool
		 */
		protected mixed $group_id_enabled;
		
		/**
		 * Constructor.
		 *
		 * @param \TSMLXtras\TSMLXtras $TSMLXtras
		 */
		public function __construct(TSMLXtras $TSMLXtras) {
			$this->TSMLXtras = $TSMLXtras;
			$this->plugin_info = $this->TSMLXtras->get_info();
			$this->group_id_enabled = array_key_exists('enable_group_id', $this->TSMLXtras->get_setting());
		}
		
		/**
		 * Sets this class into motion.
		 * Executes the plugin by calling the run method of classes.
		 * @return void
		 */
		public function run(): void {
			if ($this->group_id_enabled) {
				$this->setup_actions();
			}
		}
		
		private function setup_actions(): void {
			add_action('add_meta_boxes', [$this, 'add_meta_boxes'], 5, 2);
		}
		
		public function add_meta_boxes($post_type, $post): void {
			add_meta_box('tsmlx-group-extrafields', $this->plugin_info['Name'] . ' Custom Fields', [$this, 'xtrafields'], 'tsml_meeting', 'normal', 'low', ['type'=>'meeting'] );
		}
		
		/**
		 * Generates custom fields metabox custom fields for meetings admin page
		 */
		public function xtrafields ($post, $args): void {
			$group_id = get_post_meta($post->ID, 'group_id', true);
			$group_unique_id = get_post_meta($group_id, 'group_unique_id', true);
			?>
            <div id="contact-type" data-type="meeting">
                <div class="meta_form_row">
                    <label for="group_unique_id">
						<?php _e('Group Number', '12-step-meeting-list') ?>
                    </label>
                    <input type="text" name="group_unique_id" id="group_unique_id" value="<?php echo $group_unique_id ?>">
                </div>
                <div class="meta_form_separator">
                    <p style="margin-top:5px;">
                        Can be used to record the group number assigned by your World Service Office, GSO, or other entity.
                        <strong>NOTE: This will be associated with the group, not this specific meeting.</strong>
                    </p>
                </div>
            </div>
			<?php
		}
	}
}
