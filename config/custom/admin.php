<?php

namespace iem\custom;

use iem\api\settings;
use iem\api\callback\settingsCallback;

/**
 * Admin
 * use it to write your admin related methods by extending the settings api class.
 */

class admin extends settings
{
	/**
	 * Callback class
	 * @var class instance
	 */
	public $callback;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->callback = new settingsCallback();

		$this->enqueue();

		$this->admin_pages();

		$this->admin_subpages();

		$this->settings();

		$this->sections();

		$this->fields();

		parent::__construct();
	}

	private function enqueue()
	{
		// Scripts multidimensional array with styles and scripts
		$scripts = array(
			'script' => array( 
				'jquery', 
				'media_uplaoder',
				get_template_directory_uri() . '/assets/js/admin.min.js'
			),
			'style' => array( 
				get_template_directory_uri() . '/assets/css/admin.min.css',
				'wp-color-picker'
			)
		);

		// Pages array to where enqueue scripts
		$pages = array( 'toplevel_page_iem' );

		// Enqueue files in Admin area
		settings::admin_enqueue( $scripts, $pages );
	}

	private function admin_pages()
	{
		$admin_pages = array(
			array(
				'page_title' => 'iem Admin Page',
				'menu_title' => 'iem',
				'capability' => 'manage_options',
				'menu_slug' => 'iem',
				'callback' => array( $this->callback, 'admin_index' ),
				'icon_url' => get_template_directory_uri() . '/assets/images/iem-logo.png',
				'position' => 110,
			)
		);

		// Create multiple Admin menu pages and subpages
		settings::add_admin_pages( $admin_pages );
	}

	private function admin_subpages()
	{
		$admin_subpages = array(
			array(
				'parent_slug' => 'iem',
				'page_title' => 'iem Settings Page',
				'menu_title' => 'Settings',
				'capability' => 'manage_options',
				'menu_slug' => 'iem',
				'callback' => array( $this->callback, 'admin_index' )
			),
			array(
				'parent_slug' => 'iem',
				'page_title' => 'iem FAQ',
				'menu_title' => 'FAQ',
				'capability' => 'manage_options',
				'menu_slug' => 'iem_faq',
				'callback' => array( $this->callback, 'admin_faq' )
			)
		);

		// Create multiple Admin menu subpages
		settings::add_admin_subpages( $admin_subpages );
	}

	private function settings()
	{
		// Register settings
		$args = array(
			array(
				'option_group' => 'iem_options_group',
				'option_name' => 'first_name',
				'callback' => array( $this->callback, 'iem_options_group' )
			),
			array(
				'option_group' => 'iem_options_group',
				'option_name' => 'iem_test2'
			)
		);

		settings::add_settings( $args );
	}

	private function sections()
	{
		// Register sections
		$args = array(
			array(
				'id' => 'iem_admin_index',
				'title' => 'Settings',
				'callback' => array( $this->callback, 'iem_admin_index' ),
				'page' => 'iem'
			)
		);

		settings::add_sections( $args );
	}

	private function fields()
	{
		// Register fields
		$args = array(
			array(
				'id' => 'first_name',
				'title' => 'First Name',
				'callback' => array( $this->callback, 'first_name' ),
				'page' => 'iem',
				'section' => 'iem_admin_index',
				'args' => array(
					'label_for' => 'first_name',
					'class' => ''
				)
			)
		);

		settings::add_fields( $args );
	}
}