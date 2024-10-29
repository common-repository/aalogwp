<?php
/*
Plugin Name: aaLog
Plugin URI: http://notoriouswebmaster.com/
Description: Allows logging data to a logfile.
Version: 1.0.2
Author: A. Alfred Ayache
Copyright: 2014, The Last Byte, inc.

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

class aalogwp_loader {

	var $msgs;

	function __construct() {

		$this->msgs = array(
			  'err' => array()
			, 'upd' => array()
		);

		add_action('plugins_loaded', array(&$this, 'init'));
		add_action('init', array(&$this, 'aalog_init'), 1);
		add_action('admin_menu', array(&$this, 'admin_menu'));
		add_action('admin_notices', array(&$this, 'admin_notices'));
	}

	function init() {
		global $oLog;

		$logfileName = get_option('aalog_filename');
		if (!$logfileName) {
			$logfileName = 'aalog-' . wp_create_nonce('aalog' . date('Y-m-d H:i:s'));
			add_option('aalog_filename', $logfileName);
		}

		$aalog_cookie = get_option('aalog_cookie');
		if (!$aalog_cookie) {
			$aalog_cookie = 'aalog-' . wp_create_nonce('aalogcookie' . date('Y-m-d H:i:s'));
			add_option('aalog_cookie', $aalog_cookie);
			$this->msgs['upd'][] = 'A new cookie has been generated for aaLog, and logging must be set to On.';
		}

		include_once plugin_dir_path( __FILE__ ) . 'aalog.php';

		$aLogdir = wp_upload_dir();
		$logdir = $aLogdir['basedir'] . '/aalogwp/';
		if (!empty($aLogdir['error'])) {
			$this->msgs['err'][] = $aLogdir['error'];
		}

		// does the directory exist?
		if (!is_dir($logdir)) {
			// create directory
			$bDir = mkdir($logdir, 0757, true);
			if (!$bDir) {
				$this->msgs['err'][] = "Could not create directory {$logdir}. Please check permissions.";
			}
		}

		$oLog = new aaLog($logdir . $logfileName . '.log', $aalog_cookie);
		if (!$oLog->isReady) {
			$this->msgs['err'][] = "Plugin aaLogWP couldn't write to the log directory {$logdir}. Probably a permissions issue.";
		}

		// process options
		if ($_GET['page'] == 'aalogwp_settings') { 
			if (isset($_POST['submit'])) {
				if ($_POST['setcookie'] == 'set') {
					$oLog->setCookie();
				} else {
					$oLog->unsetCookie();
				}
				
				// sanitize logfile name input
				$logfileName = sanitize_text_field($_POST['logfilename']);
				// if empty, default to aalog
				if (empty($logfileName)) {
					$logfileName = 'aalog';
				}
				// remove .log if entered by user
				$logfileName = preg_replace('/\.log$/', '', $logfileName);
				update_option('aalog_filename', $logfileName);

				// return to aalogwp_settings page, so we can use the cookie and other settings
				header('location: options-general.php?' . $_SERVER['QUERY_STRING']);
				exit;
			}

			if (isset($_POST['regencookie'])) {
				// delete current cookie if it exists
				$oLog->unsetCookie();

				// delete option with cookie nonce
				delete_option('aalog_cookie');

				// return to page, which will generate a new cookie nonce
				header('location: options-general.php?' . $_SERVER['QUERY_STRING']);
				exit;
			}

			if (isset($_POST['regenfilename'])) {
				$logfileName = 'aalog-' . wp_create_nonce('aalog' . date('Y-m-d H:i:s'));
				update_option('aalog_filename', $logfileName);

				// return to page, which will generate a new cookie nonce
				header('location: options-general.php?' . $_SERVER['QUERY_STRING']);
				exit;
			}
		}
	}

	function aalog_init() {

		do_action('aalog_init');		
	}

	function admin_menu() {

		add_options_page(
			  'aaLog Settings' 				// page_title
			, 'aaLog Options'				// menu_title
			, 'manage_options'				// capability
			, 'aalogwp_settings'			// menu_slug
			, array(&$this, 'menu_page')	// function
		);
	}

	function admin_notices() {

		if (!empty($this->msgs['err'])) {
			echo "<div class=\"error\">\n";
			foreach ($this->msgs['err'] as $msg) {
				echo "<p>{$msg}</p>\n";
			}
			echo "</div>\n";
		}

		if (!empty($this->msgs['upd'])) {
			echo "<div class=\"updated\">\n";
			foreach ($this->msgs['upd'] as $msg) {
				echo "<p>{$msg}</p>\n";
			}
			echo "</div>\n";
		}
	}

	function menu_page() {

		include plugin_dir_path( __FILE__ ) . 'aalogwp_options_page.php';
	}
}

$aalogwp_loader = new aalogwp_loader();



