<?php
/**
 * Plugin Name:   WP Camp Webring
 * Description:   We do a webring of pages that are attending to the WP Camp in Germany like it's 1997
 * Version:       0.2
  */

if ( ! class_exists( 'wp_camp_webring' ) ) {
	add_action( 'plugins_loaded', array( 'wp_camp_webring', 'get_object' ) );
	
	class wp_camp_webring {

		/**
		 * The class object
		 *
		 * @static
		 * @since  0.1
		 * @var    string
		 */		
		static private $classobj = NULL;

		/**
		 * The array of the blogs participating in the webring
		 *
		 * @since  0.2
		 * @var    array
		 */		
		public $blogs = array();

		/**
		 * The home_url of the blog
		 *
		 * @since  0.2
		 * @var    string
		 */				
		public $home_url = NULL;
		
		/**
		 * Constructor, init on defined hooks of WP and include second class
		 * 
		 * @access  public
		 * @since   0.1
		 * @uses    add_filter, home_url, shuffle
		 * @return  void
		 */
		public function __construct() {
			
			$this->home_url = home_url();
			
			// set the blogs array and suffle it
			$this->blogs = array(
				'http://kau-boys.de',
				'http://dunkelangst.org',
				'http://blog.drivingralle.de',
				'http://stefankremer.de',
				'http://hofmannsven.com',
			);

			shuffle( $this->blogs );
			
			// show the webring in footer
			add_filter( 'wp_footer', array( $this, 'display_webring' ) );

			add_filter( 'wp_enqueue_scripts', array( $this, 'load_style' ) );
		}
		
		/**
		 * Handler for the action 'init'. Instantiates this class.
		 * 
		 * @access  public
		 * @since   0.1
		 * @return  object $classobj
		 */
		public function get_object() {
			
			if ( NULL === self::$classobj ) {
				self::$classobj = new self;
			}
			
			return self::$classobj;
		}

		/**
		 * display the webring and choose two random blogs
		 *
		 * @access  public
		 * @since   0.1
		 * @uses    get_blog_url
		 * @return  void
		 */
		public function display_webring() {

			?><div class="wp-camp-webring"><a href="<?php echo $this->get_blog_url(); ?>" class="wp-camp-webring-prev">&#9668;</a> <a href="http://wpcamp.de/teilnehmerliste" class="wp-camp-webring-list">WP Camp Webring</a> <a href="<?php echo $this->get_blog_url(); ?>" class="wp-camp-webring-next">&#9658;</a></div><?php
		}
		
		/**
		 * Load frontend CSS
		 * 
		 * @access  public
		 * @since   0.1
		 * @uses    get_blog_url
		 * @return  void
		 */
		public function load_style() {

			wp_enqueue_style( 'wp-camp-webring', plugins_url( 'wp-camp-webring.css', __FILE__ ) );
		}
		
		/**
		 * Get a blog URL from the blogs array excluding the blog matching the home_url
		 * 
		 * @access  public
		 * @since   0.2
		 * @uses    array_shift
		 * @return  string $blog_url
		 */
		public function get_blog_url() {
			
			$blog_url = array_shift( $this->blogs );
			
			if ( parse_url( $blog_url, PHP_URL_HOST ) == parse_url( $this->home_url, PHP_URL_HOST ) )
				$blog_url = array_shift( $this->blogs );
			
			return $blog_url;
		}
	} // end class
} // end if class exists