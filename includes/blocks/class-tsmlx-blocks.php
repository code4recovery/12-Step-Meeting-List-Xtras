<?php
/**
 * Creates all Blocks.
 *
 * This class is instantiated and run() in the main TSMLXtras class to create
 * all blocks that are available within the plugin
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Blocks
 */

namespace TSMLXtras\Blocks;

if ( ! class_exists( 'TSMLX_Blocks' ) ) {
	class TSMLX_Blocks {
		
		/**
		 * Blocks to load.
		 *
		 * @var array $blocks
		 */
		private array $blocks = [
			'meetings-block',
		];
		
		/**
		 * Sets this class into motion.
		 *
		 * Executes the plugin by calling the run method of classes.
		 *
		 * @return void
		 */
		public function run(): void {
			$this->setup_actions();
		}
		
		/**
		 * Setting up action hooks.
		 *
		 * @return void
		 */
		protected function setup_actions(): void {
			add_action( 'init', [ $this, 'setup_blocks' ] );
		}
		
		/**
		 * Register the blocks.
		 *
		 * @return void
		 */
		public function setup_blocks(): void {
			foreach ( $this->blocks as $block ) {
				$path = __DIR__ . '/' . $block;
				register_block_type(
					$path,
					[ 'block_json' => $path . 'block.json' ]
				);
			}
		}
	}
}
