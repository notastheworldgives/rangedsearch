<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.freelancer.com/u/picaro3535.html
 * @since      1.0.0
 *
 * @package    Mes_um_rangesearch
 * @subpackage Mes_um_rangesearch/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mes_um_rangesearch
 * @subpackage Mes_um_rangesearch/includes
 * @author     picaro3535 <picaro3535@gmail.com>
 */
class Mes_um_rangesearch {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mes_um_rangesearch_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'mes_um_rangesearch';
		$this->version = '1.0.0';

		$this->load_dependencies();
		//$this->set_locale();
		if (is_admin())
			$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mes_um_rangesearch_Loader. Orchestrates the hooks of the plugin.
	 * - Mes_um_rangesearch_i18n. Defines internationalization functionality.
	 * - Mes_um_rangesearch_Admin. Defines all hooks for the admin area.
	 * - Mes_um_rangesearch_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mes_um_rangesearch-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mes_um_rangesearch-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
        if (is_admin())
		    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mes_um_rangesearch-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mes_um_rangesearch-public.php';

		$this->loader = new Mes_um_rangesearch_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mes_um_rangesearch_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mes_um_rangesearch_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Mes_um_rangesearch_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		//$plugin_public = new Mes_um_rangesearch_Public( $this->get_plugin_name(), $this->get_version() );

		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

        $this->loader->add_filter('um_frontend_member_search_filters',$this, 'um_frontend_member_search_filters');
        $this->loader->add_filter('um_query_args_filter', $this, 'um_query_args_filter');
        $this->loader->add_filter('um_shortcode_args_filter', $this, 'um_shortcode_args_filter');


	}

    private $rs_fields;
    private $prefix_min = '';
    private $prefix_max = '';
    function um_shortcode_args_filter($args){
        if (isset($args[MES_UM_RS_FIELDS]) && !empty($args[MES_UM_RS_FIELDS])) {
            $rs_fields = unserialize($args[MES_UM_RS_FIELDS]);
            if (is_array($rs_fields)) {
                for ($i = 0; $i < count($rs_fields);) {
                    if (empty($rs_fields[$i]))
                        array_splice($rs_fields, $i, 1);
                    else
                        $i++;
                }
                $this->rs_fields = $rs_fields;
            }
        }
        if (isset($args[MES_UM_RS_PREFIX_MIN]) && !empty($args[MES_UM_RS_PREFIX_MIN]))
            $this->prefix_min = $args[MES_UM_RS_PREFIX_MIN] . ' ';
        if (isset($args[MES_UM_RS_PREFIX_MAX]) && !empty($args[MES_UM_RS_PREFIX_MAX]))
            $this->prefix_max = $args[MES_UM_RS_PREFIX_MAX] . ' ';
        return $args;
    }

    function um_frontend_member_search_filters($filters){
        if (isset($this->rs_fields)){
            $new_filters = array();
            foreach ($filters as $filter) {
                $new_filters[] = $filter;
                if (in_array($filter, $this->rs_fields)) {
                    $new_filters[] = $filter . MES_UM_RS_FIELD_NAME_POSTFIX;
                }
            }
            $this->add_um_search_field_filters($this->rs_fields);
            return $new_filters;
        }
        return $filters;
    }
    function add_um_search_field_filters($filters){
        foreach($filters as $filter) {
            add_filter("um_search_field_$filter" . MES_UM_RS_FIELD_NAME_POSTFIX, function($attrs) use($filter){
                global $ultimatemember;
                $fields = $ultimatemember->builtin->all_user_fields;
                if (is_array($fields) && isset($fields[$filter])) {
                    $attrs = $fields[$filter];
                    $attrs['label'] = isset($attrs['label']) ? $this->prefix_max . $attrs['label'] : '';
                }
                else{
                    $attrs = array('type' => 'text', 'label' => '');
                }
                return $attrs;
            });
            add_filter("um_search_field_$filter", array($this, 'um_search_field'));

        }
    }

    function um_search_field($attrs){

        $attrs['label'] = isset( $attrs['label'] ) ? $this->prefix_min . $attrs['label'] : '';
        return $attrs;
    }

    function um_query_args_filter($query_args){
        if (isset( $_REQUEST['um_search'] ) && isset($this->rs_fields) ) {
            global $ultimatemember;
            $query = $ultimatemember->permalinks->get_query_array();

            if (isset($query_args['meta_query']) && is_array($query_args['meta_query'])) {
                $new_query_args = array();
                $indexes = array();
                foreach ($this->rs_fields as $field) {
                    $found = false;
                    foreach ($query_args['meta_query'] as $key => $arr) {
                        if (is_array($arr)) {
                            if (isset($arr['key']) &&
                                ($arr['key'] == $field || $arr['key'] == $field . MES_UM_RS_FIELD_NAME_POSTFIX)
                            ) {
                                $indexes[$key] = '';
                                $found = true;
                            } else if (isset($arr[0]) && is_array($arr[0]) && isset($arr[0]['key']) &&
                                ($arr[0]['key'] == $field || $arr[0]['key'] == $field . MES_UM_RS_FIELD_NAME_POSTFIX ||
                                    $arr[0]['key'] == MES_UM_RS_FORM_KEY)
                            ) {
                                $indexes[$key] = '';
                                $found = true;
                            }
                        }

                    }
                    if ($found) {
                        $value = isset($query[$field])? trim($query[$field]):'';
                        $value1 = isset($query[$field . MES_UM_RS_FIELD_NAME_POSTFIX])?
                            trim($query[$field . MES_UM_RS_FIELD_NAME_POSTFIX]):'';
                        if ($value && $value1) {
                            $new_query_args[] = array(
                                'key' => $field,
                                'value' => array($value, $value1),
                                'compare' => 'BETWEEN',
                                'type' => 'numeric'
                            );
                        }
                    }
                }
                $query_args['meta_query'] = array_diff_key($query_args['meta_query'], $indexes);
                $query_args['meta_query'] = array_merge($query_args['meta_query'], $new_query_args);
            }
        }
        return $query_args;
    }
           
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mes_um_rangesearch_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
