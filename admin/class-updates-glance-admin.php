<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://cnpagency.com/people/glenn
 * @since      1.0.0
 *
 * @package    Updates_Glance
 * @subpackage Updates_Glance/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Updates_Glance
 * @subpackage Updates_Glance/admin
 * @author     Glenn Welser <glenn@cnpagency.com>
 */
class Updates_Glance_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	private $default_checks = [ 'themes', 'plugins' ];

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Updates_Glance_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Updates_Glance_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/updates-glance-admin.css', array(), $this->version, 'all' );

	}

	public function dashboard_glance_items( $glance_items ) {

		$checks = apply_filters( 'update_glance_items', $this->default_checks );
		foreach ( $checks as $check ) {
			$glance_items[] = $this->check_for_updates( $check );
		}

		return $glance_items;
	}

	public function check_for_updates( $check ) {

		$update       = $this->get_update_transient( $check );
		$update_count = 0;
		if ( $update ) {
			$update_count = count( $update->response );
		}

		$installed_count = 0;
		switch ( $check ) {
			case 'plugins':
				$installed_count = count( get_plugins() );
				break;

			case 'themes':
				$installed_count = count( wp_get_themes() );
				break;
		}

		return $this->format_glance_item( $check, $installed_count, $update_count );
	}

	public function format_glance_item( $check, $checked, $response ) {

		$glance_text = sprintf( '%d %s', $checked, ucwords( $check ) );
		$glance_item = '<a class="' . $this->plugin_name . '-' . $check . '-count " href="' . $this->get_admin_url( $check . '.php' ) . '">' . $glance_text . '</a>';
		if ( $response ) {
			// translators: update
			$updates_text = sprintf( _n( '%d update', '%d updates', $response, 'updates-glance' ), $response );
			$glance_item  .= ' (<a class="' . $this->plugin_name . '-' . $check . '-updates " href="' . $this->get_admin_url( 'update-core.php' ) . '">' . $updates_text . '</a>)';
		}

		return $glance_item;
	}

	public function get_update_transient( $check ) {

		return get_site_transient( 'update_' . $check );
	}

	public function get_admin_url( $path ) {

		return is_multisite() ? network_admin_url( $path ) : admin_url( $path );
	}
}
