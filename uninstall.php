<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}
delete_option( 'tsmlxtras_settings' );
