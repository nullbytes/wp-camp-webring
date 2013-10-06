<?php
/**
 * Plugin Name:   WP Camp Webring
 * Description:   We do a webring of pages that are attending to the wpcamp in germany like it's 1997
 * Version:       0.1
  */

if ( ! class_exists( 'wp_camp_webring' ) ) {
	add_action( 'plugins_loaded', array( 'wp_camp_webring', 'get_object' ) );
	
	class wp_camp_webring {
		
		static private $classobj = NULL;
		
		/**
		 * Constructor, init on defined hooks of WP and include second class
		 * 
		 * @access  public
		 * @since   0.0.1
		 * @uses    add_filter, add_action
		 * @return  void
		 */
		public function __construct() {
			
			// show the webring in footer
			add_filter( 'wp_footer', array( $this, 'display_webring' ) );

			add_filter( 'wp_enqueue_scripts', array( $this, 'load_style' ) );
		}
		
		/**
		 * Handler for the action 'init'. Instantiates this class.
		 * 
		 * @access  public
		 * @since   0.0.1
		 * @return  object $classobj
		 */
		public function get_object() {
			
			if ( NULL === self :: $classobj ) {
				self :: $classobj = new self;
			}
			
			return self :: $classobj;
		}

		/**
		 * display the webring and choose two random blogs
		 *
		 * @since	0.1
		 * @access	public
		 * @uses	get_header
		 * @return	void
		 */
		public function display_webring() {

			$blogs = array(
				'http://glueckpress.com',
				'http://kau-boys.de',
				'http://blogprofis.de',
				'http://webstreifen.de',
			);
			shuffle( $blogs );

			?><a href="<?php echo $blogs[ 0 ];?>">&larr;</a> <a href="http://wpcamp.de/teilnehmerliste">WP Camp Webring</a> <a href="<?php echo $blogs[ 1 ];?>">&rarr;</a><?php
		}

		public function load_style() {

			wp_enqueue_style( 'wp-camp-webring', plugins_url( 'wp-camp-webring.css', __FILE__ ) );
		}
	} // end class
} // end if class exists