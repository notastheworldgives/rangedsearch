<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.freelancer.com/u/picaro3535.html
 * @since      1.0.0
 *
 * @package    Mes_um_rangesearch
 * @subpackage Mes_um_rangesearch/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mes_um_rangesearch
 * @subpackage Mes_um_rangesearch/admin
 * @author     picaro3535 <picaro3535@gmail.com>
 */
class Mes_um_rangesearch_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        add_action('admin_init', array($this, 'admin_init'));

	}
    function admin_init(){
        add_action( 'load-post.php', array(&$this, 'add_metabox'), 9 );
        add_action( 'load-post-new.php', array(&$this, 'add_metabox'), 9 );
    }
    function add_metabox(){
        global $current_screen;
        if( $current_screen->id == 'um_directory'){
            add_action( 'add_meta_boxes', array(&$this, 'add_metabox_directory'), 5);
            add_action( 'save_post', array(&$this, 'save_metabox_directory'), 10, 2 );
        }

    }
    function add_metabox_directory(){
        add_meta_box('um-admin-form-search-mes-rs', 'Range Search Options', array(&$this, 'load_metabox_directory'), 'um_directory', 'normal', 'default');
    }
    function load_metabox_directory( ) {
        global $ultimatemember;
        $custom_search = apply_filters('um_admin_custom_search_filters', array() );
        $searchable_fields = $ultimatemember->builtin->all_user_fields('date,time,url');
        $searchable_fields = $searchable_fields + $custom_search;

        foreach( $searchable_fields as $key => &$arr) {
            $field = $ultimatemember->builtin->get_a_field($key);
            if (is_array($field)){
                $arr['type'] = isset($field['type'])?$field['type']:'';
            }
        }
        $global_js_var = array();
        $global_js_var['srchFields'] = $searchable_fields;

        $post_id = get_the_ID();
        $rs_fields = get_post_meta( $post_id, '_um_' . MES_UM_RS_FIELDS, true);
        if (!empty($rs_fields)){
            if (is_array($rs_fields)) {
                for ($i = 0; $i < count($rs_fields);) {
                    if (empty($rs_fields[$i]))
                        array_splice($rs_fields, $i, 1);
                    else
                        $i++;
                }
                $global_js_var['rsFields'] = $rs_fields;
            }
        }
        $json = json_encode($global_js_var);
        if ($json != FALSE){
            echo "<script>var mes_um_rs_obj = $json;</script>";
        }
        $prefix_min = get_post_meta( $post_id, MES_UM_RS_META_KEY_PREFIX . MES_UM_RS_PREFIX_MIN, true);
        $prefix_max = get_post_meta( $post_id, MES_UM_RS_META_KEY_PREFIX . MES_UM_RS_PREFIX_MAX, true);
        include_once dirname(__FILE__) . '/templates/range-search-options.php';

    }
    function tooltip( $text, $e = false ){

        ?>

        <span class="um-admin-tip">
			<?php if ($e == 'e' ) { ?>
                <span class="um-admin-tipsy-e" title="<?php echo $text; ?>"><i class="dashicons dashicons-editor-help"></i></span>
            <?php } else { ?>
                <span class="um-admin-tipsy-w" title="<?php echo $text; ?>"><i class="dashicons dashicons-editor-help"></i></span>
            <?php } ?>
		</span>

    <?php

    }

    /***
     ***	@on/off UI
     ***/
    function ui_on_off( $id, $default=0, $is_conditional=false, $cond1='', $cond1_show='', $cond1_hide='', $yes='', $no='' ) {

        $meta = (string)get_post_meta( get_the_ID(), $id, true );
        if ( $meta === '0' && $default > 0 ) {
            $default = $meta;
        }

        $yes = ( !empty( $yes ) ) ? $yes : __('Yes');
        $no = ( !empty( $no ) ) ? $no : __('No');

        if (isset($this->postmeta[$id][0]) || $meta ) {
            $active = ( isset( $this->postmeta[$id][0] ) ) ? $this->postmeta[$id][0] : $meta;
        } else {
            $active = $default;
        }

        if ($is_conditional == true) {
            $is_conditional = ' class="um-adm-conditional" data-cond1="'.$cond1.'" data-cond1-show="'.$cond1_show.'" data-cond1-hide="'.$cond1_hide.'"';
        }

        ?>

        <span class="um-admin-yesno">
			<span class="btn pos-<?php echo $active; ?>"></span>
			<span class="yes" data-value="1"><?php echo $yes; ?></span>
			<span class="no" data-value="0"><?php echo $no; ?></span>
			<input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>" value="<?php echo $active; ?>" <?php echo $is_conditional; ?> />
		</span>

    <?php
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
		 * defined in Mes_um_rangesearch_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mes_um_rangesearch_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mes_um_rangesearch-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mes_um_rangesearch_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mes_um_rangesearch_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mes_um_rangesearch-admin.js', array( 'jquery', 'um_admin_scripts' ), $this->version, true );

	}

}
