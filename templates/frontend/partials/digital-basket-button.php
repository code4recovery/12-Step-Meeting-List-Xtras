<?php
/**
 * Digital basket button template
 */

?>
<small class="tw-mr-2">
	<a id="<?php echo $data->service_key ?>-link" class="tw-normal-case <?php echo tsml_xtras_get_classes('button'); ?> <?php echo tsml_xtras_get_classes( 'button_secondary_outline' ); ?>" href="<?php echo $data->service_url . $data->username ?>" target="_blank">
		<?php if ( $data->service_key === "venmo" ) { ?>
			<svg xmlns="http://www.w3.org/2000/svg" class="tw-h-4 tw-w-4" viewBox="0 0 512 512">
				<title>Logo Venmo</title>
				<path d="M444.17 32H70.28C49.85 32 32 46.7 32 66.89V441.6c0 20.31 17.85 38.4 38.28 38.4h373.78c20.54 0 35.94-18.2 35.94-38.39V66.89C480.12 46.7 464.6 32 444.17 32zM278 387H174.32l-41.57-248.56 90.75-8.62 22 176.87c20.53-33.45 45.88-86 45.88-121.87 0-19.62-3.36-33-8.61-44l82.63-16.72c9.56 15.78 13.86 32 13.86 52.57-.01 65.5-55.92 150.59-101.26 210.33z" fill="currentColor"/>
			</svg>
		<?php } elseif ( $data->service_key === "paypal" ) { ?>
			<svg xmlns="http://www.w3.org/2000/svg" class="tw-h-4 tw-w-4" viewBox="0 0 512 512">
				<title>Logo Paypal</title>
				<path d="M424.81 148.79c-.43 2.76-.93 5.58-1.49 8.48-19.17 98-84.76 131.8-168.54 131.8h-42.65a20.67 20.67 0 00-20.47 17.46l-21.84 137.84-6.18 39.07a10.86 10.86 0 009.07 12.42 10.72 10.72 0 001.7.13h75.65a18.18 18.18 0 0018-15.27l.74-3.83 14.24-90 .91-4.94a18.16 18.16 0 0118-15.3h11.31c73.3 0 130.67-29.62 147.44-115.32 7-35.8 3.38-65.69-15.16-86.72a72.27 72.27 0 00-20.73-15.82z" fill="currentColor"/>
				<path d="M385.52 51.09C363.84 26.52 324.71 16 274.63 16H129.25a20.75 20.75 0 00-20.54 17.48l-60.55 382a12.43 12.43 0 0010.39 14.22 12.58 12.58 0 001.94.15h89.76l22.54-142.29-.7 4.46a20.67 20.67 0 0120.47-17.46h42.65c83.77 0 149.36-33.86 168.54-131.8.57-2.9 1.05-5.72 1.49-8.48 5.7-36.22-.05-60.87-19.72-83.19z" fill="currentColor"/>
			</svg>
		<?php } elseif ( $data->service_key === "square" ) { ?>
			<svg class="tw-h-4 tw-w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
			<path d="M473.3 96.2c-9.7-26.6-30.6-47.5-57.2-57.1-24.5-7.9-46.9-7.9-92.2-7.9H187.7c-45 0-67.7 0-91.8 7.5C69.2 48.4 48.3 69.4 38.7 96 31 120.4 31 142.9 31 187.9v136.3c0 45.2 0 67.5 7.5 91.9 9.7 26.6 30.6 47.5 57.2 57.1 24.4 7.7 46.9 7.7 91.9 7.7H324c45.2 0 67.7 0 91.9-7.5 26.7-9.7 47.7-30.7 57.3-57.3 7.7-24.4 7.7-46.9 7.7-91.9V188.3c.1-45.2.1-67.7-7.6-92.1zm-115.6 86.9-17.5 17.4c-3.5 3.2-8.9 3.3-12.5.1-16.9-14.2-38.3-22.1-60.4-22.1-18.2 0-36.4 6-36.4 22.7 0 16.8 19.5 22.5 42 30.9 39.4 13.2 72 29.7 72 68.3 0 42-32.6 70.9-85.8 74.1l-4.9 22.6c-.9 4.2-4.6 7.3-8.9 7.3h-33.6l-1.7-.1c-5-1.1-8.1-6.1-7.1-11.1l5.3-23.8c-20.2-5-38.8-15.2-54.1-29.4v-.2c-3.5-3.5-3.5-9.2 0-12.7l18.7-18.2c3.6-3.3 9.1-3.3 12.6 0 17.1 16.1 39.9 25.1 63.6 24.8 24.4 0 40.7-10.3 40.7-26.7s-16.5-20.6-47.6-32.2c-33-11.8-64.3-28.5-64.3-67.5 0-45.3 37.6-67.5 82.3-69.5l4.7-23.1c.9-4.2 4.7-7.3 9-7.2H307l1.9.2c4.8 1.1 8.1 5.8 7 10.7l-5 25.7c16.8 5.6 32.8 14.4 46.4 26l.4.4c3.5 3.6 3.5 9.2 0 12.6z" fill="currentColor"/>
		</svg>
		<?php } ?>
		<?php echo sprintf( __( '%s', '12-step-meeting-list' ), $data->service_name ) ?>
	</a>
</small>
