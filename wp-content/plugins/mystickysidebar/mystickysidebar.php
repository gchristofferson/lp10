<?php     
	/*
	Plugin Name: WP Sticky Sidebar 
	Plugin URI: http://wordpress.transformnews.com/plugins/mystickysidebar-sticky-sidebar-for-wordpress-1083
	Description: Simple sticky sidebar implementation. After install go to Settings / WP Sticky Sidebar and change Sticky Class to .your_sidebar_class.
	Version: 1.2.6
	Author: m.r.d.a
	Author URI: http://wordpress.transformnews.com/
	Text Domain: mystickysidebar
	Domain Path: /languages
	License: GPLv2 or later
	*/

defined('ABSPATH') or die("Cannot access pages directly.");

class MyStickysidebarBackend
{

    private $options;

	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'mystickyside_load_transl') );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action( 'admin_init', array( $this, 'mystickyside_default_options' ) );
    }
		
	public function mystickyside_load_transl()
	{
		load_plugin_textdomain('mystickysidebar', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
	}
	
	public function add_plugin_page()
	{
		add_options_page(
			'Settings Admin', 
			'WP Sticky Sidebar', 
			'manage_options', 
			'my-stickysidebar-settings', 
			array( $this, 'create_admin_page' )
		);
	}

	public function create_admin_page()
	{
		$this->options = get_option( 'mystickyside_option_name');
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e('WP Sticky Sidebar Settings', 'mystickysidebar'); ?></h2>       
			<form method="post" action="options.php">
			<?php
				settings_fields( 'mystickyside_option_group' );   
				do_settings_sections( 'my-stickysidebar-settings' );
				submit_button(); 
			?>
			</form>
			</div>
		<?php
	}
	
	public function page_init()
	{   
		global $id, $title, $callback, $page;     
		register_setting(
			'mystickyside_option_group',
			'mystickyside_option_name',
			array( $this, 'sanitize' )
		);
		
		add_settings_field( $id, $title, $callback, $page, $section = 'default', $args = array() );

		add_settings_section(
			'setting_section_id',
			__("WP Sticky Sidebar Options", 'mystickysidebar'),
			array( $this, 'print_section_info' ),
			'my-stickysidebar-settings'
		);
		add_settings_field(
			'mystickyside_class_selector',
			__("Sticky Class", 'mystickysidebar'),
			array( $this, 'mystickyside_class_selector_callback' ),
			'my-stickysidebar-settings',
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_class_content_selector',
			__("Container Class", 'mystickysidebar'),
			array( $this, 'mystickyside_class_content_selector_callback' ),
			'my-stickysidebar-settings',
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_margin_top', 
			__("Additional top margin", 'mystickysidebar'),
			array( $this, 'mystickyside_margin_top_callback' ), 
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_margin_bot', 
			__("Additional bottom margin", 'mystickysidebar'),
			array( $this, 'mystickyside_margin_bot_callback' ), 
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_min_width', 
			__("Disable if screen width is smaller than", 'mystickysidebar'),
			array( $this, 'mystickyside_min_width_callback' ), 
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_update_sidebar_height', 
			__("Update sidebar height", 'mystickysidebar'),
			array( $this, 'mystickyside_update_sidebar_height_callback' ), 
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_disable_at_front_home', 
			__("Disable at", 'mystickysidebar'),
			array( $this, 'mystickyside_enable_callback' ), 
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_disable_at_blog', 
			__("Disable at", 'mystickysidebar'),
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_disable_at_page', 
			__("Disable at", 'mystickysidebar'),
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_disable_at_tag', 
			__("Disable at", 'mystickysidebar'),
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_disable_at_category', 
			__("Disable at", 'mystickysidebar'),
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_disable_at_single', 
			__("Disable at", 'mystickysidebar'),
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_disable_at_archive', 
			__("Disable at", 'mystickysidebar'),
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_enable_at_pages', 
			__("", 'mystickysidebar'),
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_enable_at_posts', 
			__("", 'mystickysidebar'),
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		add_settings_field(
			'mystickyside_disable_at_search', 
			__("Disable at", 'mystickysidebar'),
			'my-stickysidebar-settings', 
			'setting_section_id'
		);
		
	}
/**
* Sanitize each setting field as needed
*
* @param array $input Contains all settings fields as array keys
*/
	public function sanitize( $input )
	{
		$new_input = array();
		if( isset( $input['mystickyside_class_selector'] ) )
			$new_input['mystickyside_class_selector'] = sanitize_text_field( $input['mystickyside_class_selector'] );
			
		if( isset( $input['mystickyside_class_content_selector'] ) )
			$new_input['mystickyside_class_content_selector'] = sanitize_text_field( $input['mystickyside_class_content_selector'] );

		if( isset( $input['mystickyside_margin_top'] ) )
			$new_input['mystickyside_margin_top'] = absint( $input['mystickyside_margin_top'] );
			
		if( isset( $input['mystickyside_margin_bot'] ) )
			$new_input['mystickyside_margin_bot'] = absint( $input['mystickyside_margin_bot'] );
		
		if( isset( $input['mystickyside_update_sidebar_height'] ) )
			$new_input['mystickyside_update_sidebar_height'] = sanitize_text_field( $input['mystickyside_update_sidebar_height'] );
			
		if( isset( $input['mystickyside_min_width'] ) )
			$new_input['mystickyside_min_width'] = absint( $input['mystickyside_min_width'] );
			
		if( isset( $input['mystickyside_disable_at_front_home'] ) )
			$new_input['mystickyside_disable_at_front_home'] = sanitize_text_field( $input['mystickyside_disable_at_front_home'] );
			
		if( isset( $input['mystickyside_disable_at_blog'] ) )
			$new_input['mystickyside_disable_at_blog'] = sanitize_text_field( $input['mystickyside_disable_at_blog'] );
			
		if( isset( $input['mystickyside_disable_at_page'] ) )
			$new_input['mystickyside_disable_at_page'] = sanitize_text_field( $input['mystickyside_disable_at_page'] );
		
		if( isset( $input['mystickyside_disable_at_tag'] ) )
			$new_input['mystickyside_disable_at_tag'] = sanitize_text_field( $input['mystickyside_disable_at_tag'] );
			
		if( isset( $input['mystickyside_disable_at_category'] ) )
			$new_input['mystickyside_disable_at_category'] = sanitize_text_field( $input['mystickyside_disable_at_category'] );
			
		if( isset( $input['mystickyside_disable_at_single'] ) )
			$new_input['mystickyside_disable_at_single'] = sanitize_text_field( $input['mystickyside_disable_at_single'] );			
			
		if( isset( $input['mystickyside_disable_at_archive'] ) )
			$new_input['mystickyside_disable_at_archive'] = sanitize_text_field( $input['mystickyside_disable_at_archive'] );
			
		if( isset( $input['mystickyside_enable_at_pages'] ) )
			$new_input['mystickyside_enable_at_pages'] = sanitize_text_field( $input['mystickyside_enable_at_pages'] );
				
		if( isset( $input['mystickyside_enable_at_posts'] ) )
			$new_input['mystickyside_enable_at_posts'] = sanitize_text_field( $input['mystickyside_enable_at_posts'] );
				
		if( isset( $input['mystickyside_disable_at_search'] ) )
			$new_input['mystickyside_disable_at_search'] = sanitize_text_field( $input['mystickyside_disable_at_search'] );		
									

		return $new_input;
	}

	public function mystickyside_default_options() {

		global $options;
		$default = array(

				'mystickyside_class_selector' => '#secondary',
				'mystickyside_class_content_selector' => '',
				'mystickyside_margin_top' => '90',
				'mystickyside_margin_bot' => '0',
				'mystickyside_min_width' => '0',
				'mystickyside_update_sidebar_height' => '',
				'mystickyside_enable_at_pages' => false,
				'mystickyside_enable_at_posts' => false
				
			);

		if ( get_option('mystickyside_option_name') == false ) {
			update_option( 'mystickyside_option_name', $default );
		}
	}
	


	public function print_section_info()
	{
		echo __("Add floating sticky sidebar to any WordPress theme.", 'mystickysidebar');
    }

	public function mystickyside_class_selector_callback()
	{
		printf(
			'<input type="text" size="26" id="mystickyside_class_selector" name="mystickyside_option_name[mystickyside_class_selector]" value="%s" /> ',  
			isset( $this->options['mystickyside_class_selector'] ) ? esc_attr( $this->options['mystickyside_class_selector']) : '' 
		);
		 echo '<span class="description">';
		 echo __("Sidebar element CSS class or id", 'mystickysidebar');
		 echo '</span>';
	}
	
	
	public function mystickyside_class_content_selector_callback()
	{
		printf(
			'<input type="text" size="26" id="mystickyside_class_content_selector" name="mystickyside_option_name[mystickyside_class_content_selector]" value="%s" /> ',  
			isset( $this->options['mystickyside_class_content_selector'] ) ? esc_attr( $this->options['mystickyside_class_content_selector']) : '' 
		); 
		 echo '<span class="description">';
		 _e("Container element class or id. It must be element that contains both sidebar and content. If left blank script will try to guess. Usually it's #main or #main-content", 'mystickysidebar');
		 echo '</span>';
	}

	
	public function mystickyside_margin_top_callback()
	{
		printf(
		'<p class="description">'
		);
		printf(
		' <input type="number" class="small-text" min="0" step="1" id="mystickyside_margin_top" name="mystickyside_option_name[mystickyside_margin_top]" value="%s" />',
			isset( $this->options['mystickyside_margin_top'] ) ? esc_attr( $this->options['mystickyside_margin_top']) : '90'
		);
		echo __("px.", 'mystickysidebar');
		echo '</p>';
	}
	
	public function mystickyside_margin_bot_callback()
	{
		printf(
		'<p class="description">'
		);
		printf(
		' <input type="number" class="small-text" min="0" step="1" id="mystickyside_margin_bot" name="mystickyside_option_name[mystickyside_margin_bot]" value="%s" />',
			isset( $this->options['mystickyside_margin_bot'] ) ? esc_attr( $this->options['mystickyside_margin_bot']) : '0'
		);
		echo __("px.", 'mystickysidebar');
		echo '</p>';
	}
	
	public function mystickyside_min_width_callback()
	{
		printf(
		'<p class="description">'
		);
		printf(
		' <input type="number" class="small-text" min="0" step="1" id="mystickyside_min_width" name="mystickyside_option_name[mystickyside_min_width]" value="%s" />',
			isset( $this->options['mystickyside_min_width'] ) ? esc_attr( $this->options['mystickyside_min_width']) : '753'
		);
		_e("px.", 'mystickysidebar');
		echo '</p>';
	}

	public function mystickyside_update_sidebar_height_callback()
	{
		printf(
		'<select id="mystickyside_update_sidebar_height" name="mystickyside_option_name[mystickyside_update_sidebar_height]" selected="%s">',
			isset( $this->options['mystickyside_update_sidebar_height'] ) ? esc_attr( $this->options['mystickyside_update_sidebar_height']) : '' 
		);
		if ($this->options['mystickyside_update_sidebar_height'] == 'true') {
		printf(
		'<option name="true" value="true" selected>true</option>
		<option name="false" value="">false</option>
		</select>'
		);	
		}
		if ($this->options['mystickyside_update_sidebar_height'] == 'false') {
		printf(
		'<option name="true" value="true">true</option>
		<option name="false" value="" selected >false</option>
		</select>'
		);	
		}
		if ($this->options['mystickyside_update_sidebar_height'] == '') {
		printf(
		'<option name="true" value="true">true</option>
		<option name="false" value="" selected >false</option>
		</select>'
		);	
		}	
		echo '<span class="description">';
		_e("Troubleshooting option, try this if your sidebar loses its background color...", 'mystickysidebar');
		echo '</span>';	
	} 
	
	public function mystickyside_enable_callback()
	{
		
		_e('<span>front page </span>', 'mystickysidebar');
		printf(
			'<input id="%1$s" name="mystickyside_option_name[mystickyside_disable_at_front_home]" type="checkbox" %2$s /> ',
			'mystickyside_disable_at_front_home',
			checked( isset( $this->options['mystickyside_disable_at_front_home'] ), true, false ) 
		) ;
		_e('<span>blog page </span>', 'mystickysidebar');
		printf(
			'<input id="%1$s" name="mystickyside_option_name[mystickyside_disable_at_blog]" type="checkbox" %2$s /> ',
			'mystickyside_disable_at_blog',
			checked( isset( $this->options['mystickyside_disable_at_blog'] ), true, false ) 
		);
		_e('<span>pages </span>', 'mystickysidebar');
		printf(
			'<input id="%1$s" name="mystickyside_option_name[mystickyside_disable_at_page]" type="checkbox" %2$s /> ',
			'mystickyside_disable_at_page',
			checked( isset( $this->options['mystickyside_disable_at_page'] ), true, false ) 
		);
		_e('<span>tags </span>', 'mystickysidebar');
		printf(
			'<input id="%1$s" name="mystickyside_option_name[mystickyside_disable_at_tag]" type="checkbox" %2$s /> ',
			'mystickyside_disable_at_tag',
			checked( isset( $this->options['mystickyside_disable_at_tag'] ), true, false ) 
		);
		_e('<span>categories </span>', 'mystickysidebar');
		printf(
			'<input id="%1$s" name="mystickyside_option_name[mystickyside_disable_at_category]" type="checkbox" %2$s /> ',
			'mystickyside_disable_at_category',
			checked( isset( $this->options['mystickyside_disable_at_category'] ), true, false ) 
		);
		_e('<span>posts </span>', 'mystickysidebar');
		printf(
			'<input id="%1$s" name="mystickyside_option_name[mystickyside_disable_at_single]" type="checkbox" %2$s /> ',
			'mystickyside_disable_at_single',
			checked( isset( $this->options['mystickyside_disable_at_single'] ), true, false ) 
		);
		_e('<span>archives </span>', 'mystickysidebar');
		printf(
			'<input id="%1$s" name="mystickyside_option_name[mystickyside_disable_at_archive]" type="checkbox" %2$s /> ',
			'mystickyside_disable_at_archive',
			checked( isset( $this->options['mystickyside_disable_at_archive'] ), true, false ) 
		);
		
		_e('<span>search </span>', 'mystickysidebar');
		printf(
			'<input id="%1$s" name="mystickyside_option_name[mystickyside_disable_at_search]" type="checkbox" %2$s /> ',
			'mystickyside_disable_at_search',
			checked( isset( $this->options['mystickyside_disable_at_search'] ), true, false ) 
		);
	
		if  (isset ( $this->options['mystickyside_disable_at_page'] ) == true )  {
			
			echo '<p> </p> <hr />';
			_e('<span class="">Except for this pages: </span>', 'mystickysidebar');
	
			printf(
				'<input type="text" size="26" id="mystickyside_enable_at_pages" name="mystickyside_option_name[mystickyside_enable_at_pages]" value="%s" /> ',  
				isset( $this->options['mystickyside_enable_at_pages'] ) ? esc_attr( $this->options['mystickyside_enable_at_pages']) : '' 
			); 
			
		 	_e('<span class="description">Comma separated list of pages to enable. It should be page name, id or slug. Example: about-us, 1134, Contact Us. Leave blank if you realy want to disable sticky sidebar for all pages.</span>', 'mystickysidebar');
			
		}
	
		if  (isset ( $this->options['mystickyside_disable_at_single'] ) == true )  {
			
			echo '<p> </p> <hr />';
			_e('<span class="">Except for this posts: </span>', 'mystickysidebar');
	
			printf(
				'<input type="text" size="26" id="mystickyside_enable_at_posts" name="mystickyside_option_name[mystickyside_enable_at_posts]" value="%s" /> ',  
				isset( $this->options['mystickyside_enable_at_posts'] ) ? esc_attr( $this->options['mystickyside_enable_at_posts']) : '' 
			); 
			
		 	_e('<span class="description">Comma separated list of posts to enable. It should be post name, id or slug. Example: about-us, 1134, Contact Us. Leave blank if you realy want to disable sticky sidebar for all posts.</span>', 'mystickysidebar');
			
		}
	
	}
	
}

//FRONTEND

class MyStickysidebarFrontend
{


	public function __construct()
	{
		
	add_action( 'wp_enqueue_scripts', array( $this, 'mystickysidebar_disable_at' ), 99 );
	
	//add_action( 'wp_enqueue_scripts', array( $this, 'mystickysidebar_disable_at' ), 99, 1 );

	//add_action( 'wp_enqueue_scripts', 'mystickysidebar_disable_at', 99 );
	}
	
	
	public function mystickysidebar_script() {
		
		$mystickyside_options = get_option( 'mystickyside_option_name' );
		
		if ( is_admin_bar_showing() ) {
			$aditionalmargintop = $mystickyside_options['mystickyside_margin_top'] + 32;
			} else {					
			$aditionalmargintop = $mystickyside_options['mystickyside_margin_top'];
			}
			
		wp_register_script('mystickysidebar', plugins_url( 'js/theia-sticky-sidebar.js', __FILE__ ), array('jquery'), '1.2.3', true);
		wp_enqueue_script( 'mystickysidebar' );
		
		$mystickyside_translation_array = array( 
			'mystickyside_string' => $mystickyside_options['mystickyside_class_selector'] ,
			'mystickyside_content_string' => $mystickyside_options['mystickyside_class_content_selector'] ,
			//'mystickyside_margin_top_string' => $mystickyside_options['mystickyside_margin_top'],
			'mystickyside_margin_top_string' => $aditionalmargintop,
			'mystickyside_margin_bot_string' => $mystickyside_options['mystickyside_margin_bot'],
			'mystickyside_update_sidebar_height_string' => $mystickyside_options['mystickyside_update_sidebar_height'],
			'mystickyside_min_width_string' => $mystickyside_options['mystickyside_min_width']
			
		);
		wp_localize_script( 'mystickysidebar', 'mystickyside_name', $mystickyside_translation_array );
		
	}
	
	//add_action( 'wp_enqueue_scripts', 'mystickysidebar_disable_at', 99 );
	
	public function mystickysidebar_disable_at() {
		
		$mystickyside_options = get_option( 'mystickyside_option_name' );	
		$mystickyside_disable_at_front_home = isset($mystickyside_options['mystickyside_disable_at_front_home']);
		$mystickyside_disable_at_blog = isset($mystickyside_options['mystickyside_disable_at_blog']);
		$mystickyside_disable_at_page = isset($mystickyside_options['mystickyside_disable_at_page']);
		$mystickyside_disable_at_tag = isset($mystickyside_options['mystickyside_disable_at_tag']);
		$mystickyside_disable_at_category = isset($mystickyside_options['mystickyside_disable_at_category']);
		$mystickyside_disable_at_single = isset($mystickyside_options['mystickyside_disable_at_single']);
		$mystickyside_disable_at_archive = isset($mystickyside_options['mystickyside_disable_at_archive']);
		$mystickyside_disable_at_search = isset($mystickyside_options['mystickyside_disable_at_search']);
		$mystickyside_enable_at_pages = isset($mystickyside_options['mystickyside_enable_at_pages']) ? $mystickyside_options['mystickyside_enable_at_pages'] : '';
		$mystickyside_enable_at_posts = isset($mystickyside_options['mystickyside_enable_at_posts']) ? $mystickyside_options['mystickyside_enable_at_posts'] : '';
		//$mystickyside_enable_at_pages_exp = explode( ',', $mystickyside_enable_at_pages ); 
		// Trim input to ignore empty spaces
		$mystickyside_enable_at_pages_exp = array_map('trim', explode(',', $mystickyside_enable_at_pages));
		$mystickyside_enable_at_posts_exp = array_map('trim', explode(',', $mystickyside_enable_at_posts));
	
	
		if ( is_front_page() && is_home() ) {
		
		// Default homepage
			if ( $mystickyside_disable_at_front_home == false ) { 
				$this->mystickysidebar_script();
			};
	
	
		} elseif ( is_front_page()){
		
		//Static homepage
			if ( $mystickyside_disable_at_front_home == false ) { 
				$this->mystickysidebar_script();
			};
	

		} elseif ( is_home()){
		
		//Blog page
			if ( $mystickyside_disable_at_blog == false ) { 
				$this->mystickysidebar_script();
			};
	
	
		} elseif ( is_page() ){
		
		//Single page
			if ( $mystickyside_disable_at_page == false ) { 
				$this->mystickysidebar_script();
			};
		
			if ( is_page( $mystickyside_enable_at_pages_exp  )  ){ 
			$this->mystickysidebar_script();
			}
	
			
		} elseif ( is_tag()){
		
		//Tag page
			if ( $mystickyside_disable_at_tag == false ) { 
				$this->mystickysidebar_script();
			};
	
		} elseif ( is_category()){
		
		//Category page
			if ( $mystickyside_disable_at_category == false ) { 
				$this->mystickysidebar_script();
			};
	
	
		} elseif ( is_single()){
		
		//Single post
			if ( $mystickyside_disable_at_single == false ) { 
				$this->mystickysidebar_script();
			};
		
			if ( is_single( $mystickyside_enable_at_posts_exp  )  ){ 
				$this->mystickysidebar_script();
			}
	
		} elseif ( is_archive()){
		
		//Archive
			if ( $mystickyside_disable_at_archive == false ) { 
				$this->mystickysidebar_script();
			};

		} elseif ( is_search()){
		
		//Search
			if ( $mystickyside_disable_at_search == false ) { 
				$this->mystickysidebar_script();
			};
		}
		
		
		
		
		/* else {
		
		//Everything else

		}*/
	
	}	
	
	
}

if( is_admin() ) {
	
	new MyStickysidebarBackend();

} else {
	
	new MyStickysidebarFrontend();
}
	
?>