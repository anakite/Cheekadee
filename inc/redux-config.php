<?php
    /**
     * ReduxFramework bswp Config File
     * For full documentation, please visit: https://docs.reduxframework.com
     * */

    if ( ! class_exists( 'Redux_Framework_bswp_config' ) ) {

        class Redux_Framework_bswp_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
                //print_r($options); //Option values
                //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

                /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'bswp' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'bswp' ),
                    'icon'   => 'el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                //Stylesheets 
                $styles = array(
                    'bootstrap.min.css' => 'Bootstrap',                      
                    'cosmo.min.css'     => 'Cosmo', 
                    'darkly.min.css'    => 'Darkly',
                    'flatly.min.css'    => 'Flatly', 
                    'journal.min.css'   => 'Journal', 
                    'readable.min.css'  => 'Readable',
                    'sandstone.min.css' => 'Sandstone', 
                    'simplex.min.css'   => 'Simplex', 
                    'slate.min.css'     => 'Slate',  
                    'superhero.min.css' => 'Superhero',                   
                    'yeti.min.css'      => 'Yeti'
                );

                // Bootstrap Button Colors
                $btn_color = array(
                    "default"   => "Default",
                    "primary"   => "Primary",
                    "info"      => "Info",
                    "success"   => "Success",
                    "warning"   => "Warning",
                    "danger"    => "Danger",
                    "link"      => "Link"
                );

                // Bootstrap Button Size
                $btn_size = array(
                    "xs"        => "Extra Small",
                    "sm"        => "Small",
                    "default"   => "Medium",
                    "lg"        => "Large"
                );

                // Array of social options
                $social_options = array(
                    'twitter'       => 'Twitter',
                    'facebook'      => 'Facebook',
                    'vk'            => 'Vk',
                    'google-plus'   => 'Google Plus',
                    'instagram'     => 'instagram',
                    'linkedin'      => 'LinkedIn',
                    'tumblr'        => 'Tumblr',
                    'pinterest'     => 'Pinterest',
                    'github-alt'    => 'Github',
                    'dribbble'      => 'Dribbble',
                    'flickr'        => 'Flickr',
                    'skype'         => 'Skype',
                    'youtube'       => 'Youtube',
                    'vimeo-square'  => 'Vimeo',
                    'reddit'        => 'Reddit',
                    'stumbleupon'   => 'Stumbleupon',
                    'github'        => 'Github',
                    'vine'          => 'Vine',
                    'rss'           => 'RSS',
                );
                /**
                 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
                 * */
                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'bswp' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'bswp' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'bswp' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'bswp' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'bswp' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'bswp' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'bswp' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'bswp' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';
                if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
                    Redux_Functions::initWpFilesystem();

                    global $wp_filesystem;

                    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
                }

                // DECLARATION OF SECTIONS

                //General            
                $this->sections[] = array(
                    'icon'      => 'el-icon-cog',
                    'title'     => __('General', 'bswp'),
                    'fields'    => array(
                         array(   
                        'type'      => 'select',
                        'id'        => 'css_style',
                        'title'     => __('Theme Stylesheet', 'bswp'), 
                        'subtitle'  => __('Select your themes alternative color scheme.', 'bswp'),
                        'default'   => 'bootstrap.min.css',
                        'options'   => $styles,
                        ),

                        array( 
                            'title'     => __( 'Favicon', 'bswp' ),
                            'subtitle'  => __( 'Use this field to upload your custom favicon.', 'bswp' ),
                            'id'        => 'custom_favicon',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                        ),
                    )
                ); 

                // Header
                $this->sections[] = array(
                    'icon'      => 'el-icon-website',
                    'title'     => __('Header', 'bswp'),
                    'fields'    => array(
                        array(
                    'title'     => __( 'Fixed Navbar', 'bswp' ),
                    'subtitle'  => __( 'Select to enable/disable a fixed navbar.', 'bswp' ),
                    'id'        => 'disable_fixed_navbar',
                    'default'   => false,
                    'on'        => __( 'Enable', 'bswp' ),
                    'off'       => __( 'Disable', 'bswp' ),
                    'type'      => 'switch',
                            ),

                    array(
                    'title'     => __( 'Inverse Navbar', 'bswp' ),
                    'subtitle'  => __( 'Select to enable/disable an inverse navbar color.', 'bswp' ),
                    'id'        => "disable_inverse_navbar",
                    'default'   => false,
                    'on'        => __( 'Enable', 'bswp' ),
                    'off'       => __( 'Disable', 'bswp' ),
                    'type'      => 'switch',
                                        ),

                    array(
                    'title'     => __( 'Logo', 'bswp' ),
                    'subtitle'  => __( 'Use this field to upload your custom logo for use in the theme header. (Recommended 200px x 40px)', 'bswp' ),
                    'id'        => 'custom_logo',
                    'default'   => '',
                    'type'      => 'media',
                    'url'       => true,                       
                       ),
                    )
                 );

                //Homepage                  
                $this->sections[] = array(
                    'icon'      => 'el-icon-home',
                    'title'     => __('Homepage', 'bswp'),
                    //'subsection' => true,
                    'fields'    => array(
                        array(
                            'id'        => 'homepage-layout',
                            'type'      => 'sorter',
                            'title'     => __('Homepage Layout Manager', 'bswp'),
                            'desc'      => __('Organize how you want the layout to appear on the homepage', 'bswp'),
                            'options'   => array(
                                'enabled'   => array(
                                    'herocontent'   => 'Hero Content',
                                    'widgets'       => 'Widgets',
                                ),
                                'disabled'  => array(
                                    'homecontent'   => 'Home Content',
                                    'heropost'      => 'Hero Post',
                                    
                                ),
                                
                            ),
                        ),

                        array(  
                            'title'     => __('Featured Heading', 'bootstrap'),
                            'subtitle'  => __('This is the heading of the featured content.', 'bootstrap'),
                            'id'        => 'featured_heading',
                            'default'   => 'Responsive!',
                            'type'      => 'text',
                        ),

                        array(  
                            'title'     => __('Featured Content', 'bootstrap'),
                            'subtitle'  => __('This is the content of the Hero Content module.', 'bootstrap'),
                            'id'        => 'featured_content',
                            'default'   => 'A responsive WordPress theme with all the Bootstrap goodies. Check out the page layouts, features, and shortcodes this theme has to offer. Feel free to look around.',
                            'type'      => 'textarea',
                        ),

                        array( 
                            'title'     => __( 'Featured Button', 'bswp' ),
                            'subtitle'  => __( 'Enable/Disable featured button.', 'bswp' ),
                            'id'        => 'featured_btn',
                            'default'   => true,
                            'on'        => __( 'Enable', 'bswp' ),
                            'off'       => __( 'Disable', 'bswp' ),
                            'type'      => 'switch',
                        ),

                        array(  
                            'title'     => __( 'Featured Button Text', 'bswp' ),
                            'subtitle'  => __( 'This is the text that will replace Learn More.', 'bswp' ),
                            'id'        => 'featured_btn_text',
                            'default'   => 'Learn More',
                            'type'      => 'text',
                            'required'  => array('featured_btn','equals','1'),
                        ),

                        array(  
                            'title'     => __( 'Featured Button URL', 'bswp' ),
                            'subtitle'  => __( 'This is the URL for the button.', 'bswp' ),
                            'id'        => 'featured_btn_url',
                            'default'   => 'http://',
                            'type'      => 'text',
                            'required'  => array('featured_btn','equals','1'),
                        ),

                        array( 
                            'title'     => __( 'Make the Featured button Full Width - Block', 'bswp' ),
                            'subtitle'  => __( 'Enable/Disable full width button.', 'bswp' ),
                            'id'        => 'featured_btn_block',
                            'default'   => true,
                            'on'        => __( 'Enable', 'bswp' ),
                            'off'       => __( 'Disable', 'bswp' ),
                            'type'      => 'switch',
                            'required'  => array('featured_btn','equals','1'),
                        ),

                        array( 
                            'title'     => __( 'Featured Button Size', 'bswp' ),
                            'subtitle'  => __( 'Select the Bootstrap button size you want.', 'bswp' ),
                            'id'        => 'featured_btn_size',
                            'default'   => 'default',
                            'type'      => 'select',
                            'options'   => $btn_size,
                            'required'  => array('featured_btn','equals','1'),
                        ),

                        array( 
                            'title'     => __( 'Featured Button Color', 'bswp' ),
                            'subtitle'  => __( 'Select the Bootstrap button color you want.', 'bswp' ),
                            'id'        => 'featured_btn_color',
                            'default'   => 'default',
                            'type'      => 'select',
                            'options'   => $btn_color,
                            'required'  => array('featured_btn','equals','1'),
                        ),

                        array( 
                            'title'     => __( 'Right Featured Content', 'bswp' ),
                            'subtitle'  => __( 'Add your image or text/html for right Featured content region.', 'bswp' ),
                            'id'        => 'right_featured',
                            'default'   => '',
                            'type'      => 'editor',
                        ),

                    )
                );
                    //Blog
                    $this->sections[] = array(
                        'icon'      => 'el-icon-wordpress',
                        'title'     => __('Blog', 'bswp'),
                        'fields'    => array(
                            array(
                                'title'     => __( 'Display Meta Data', 'bswp' ),
                                'subtitle'  => __( 'Select to enable/disable the date and author.', 'bswp' ),
                                'id'        => 'disable_meta',
                                'default'   => true,
                                'on'        => __( 'Enable', 'bswp' ),
                                'off'       => __( 'Disable', 'bswp' ),
                                'type'      => 'switch',
                            ),

                            array(
                                'title'     => __( 'Read More Button Text', 'bswp' ),
                                'subtitle'  => __( 'This is the text that will replace Read More.', 'bswp' ),
                                'id'        => 'read_more_text',
                                'default'   => 'Read More',
                                'type'      => 'text',
                            ),

                            array(
                                'title'     => __( 'Make the Read More button Full Width - Block', 'bswp' ),
                                'subtitle'  => __( 'Enable/Disable full width button.', 'bswp' ),
                                'id'        => 'read_more_block',
                                'default'   => true,
                                'on'        => __( 'Enable', 'bswp' ),
                                'off'       => __( 'Disable', 'bswp' ),
                                'type'      => 'switch',
                            ),

                            array(
                                'title'     => __( 'Read More Button Size', 'bswp' ),
                                'subtitle'  => __( 'Select the Bootstrap button size you want.', 'bswp' ),
                                'id'        => 'read_more_size',
                                'default'   => 'default',
                                'type'      => 'select',
                                'options'   => $btn_size,
                            ),

                            array(
                                'title'     => __( 'Read More Button Color', 'bswp' ),
                                'subtitle'  => __( 'Select the Bootstrap button color you want.', 'bswp' ),
                                'id'        => 'read_more_color',
                                'default'   => 'default',
                                'type'      => 'select',
                                'options'   => $btn_color,
                            ),

                            array(
                                'title'     => __( 'Display Tags', 'bswp' ),
                                'subtitle'  => __( 'Select to enable/disable the post tags.', 'bswp' ),
                                'id'        => 'enable_disable_tags',
                                'default'   => true,
                                'on'        => __( 'Enable', 'bswp' ),
                                'off'       => __( 'Disable', 'bswp' ),
                                'type'      => 'switch',
                            ),
                        )
                    );

                    //Portfolio            
                    $this->sections[] = array(
                        'icon'      => 'el-icon-camera',
                        'title'     => __('Portfolio', 'bswp'),
                        'fields'    => array(
                             array( 
                            'title'     => __( 'Portfolio Columns', 'bswp' ),
                            'subtitle'  => __( 'Select the number of columns you would like to use for the portfolio.', 'bswp' ),
                            'id'        => 'portfolio_column',
                            'type'      => 'image_select',
                            'options'   => array(
                                '6' => array('alt' => '2 Column',  'img' => ReduxFramework::$_url . 'assets/img/2-col-portfolio.png'),
                                '4' => array('alt' => '3 Column',  'img' => ReduxFramework::$_url . 'assets/img/3-col-portfolio.png'),
                                '3' => array('alt' => '4 Column',  'img' => ReduxFramework::$_url . 'assets/img/4-col-portfolio.png'),
                                ),
                            'default'   => '4'
                            ),

                            array( 
                            'title'     => __( 'Display Filter', 'bswp' ),
                            'subtitle'  => __( 'Select to enable/disable the portfolio filter.', 'bswp' ),
                            'id'        => 'filter_switch',
                            'default'   => true,
                            'on'        => __( 'Enable', 'bswp' ),
                            'off'       => __( 'Disable', 'bswp' ),
                            'type'      => 'switch',
                            ),

                            array( 
                            'title'     => __( 'Filter Button Size', 'bswp' ),
                            'subtitle'  => __( 'Select the Bootstrap button size you want for the Filter.', 'bswp' ),
                            'id'        => 'filter_size',
                            'default'   => 'default',
                            'type'      => 'select',
                            'options'   => $btn_size,
                            'required'  => array('filter_switch','equals','1')    
                            ),

                            array( 
                            'title'     => __( 'Filter Button Color', 'bswp' ),
                            'subtitle'  => __( 'Select the Bootstrap button color you want for the filter.', 'bswp' ),
                            'id'        => 'filter_color',
                            'default'   => 'default',
                            'type'      => 'select',
                            'options'   => $btn_color,
                            'required'  => array('filter_switch','equals','1')
                            ),
                        )
                    );

                    //CSS
                    $this->sections[] = array(
                        'icon'      => 'el-icon-css',
                        'title'     => __('CSS', 'bswp'),
                        'fields'    => array(
                             array(
                                'title'     => __( 'Custom CSS', 'bswp' ),
                                'subtitle'  => __( 'Insert any custom CSS.', 'bswp' ),
                                'id'        => 'custom_css',
                                'type'      => 'ace_editor',
                                'mode'      => 'css',
                                'theme'     => 'monokai',
                            ),
                        )
                    );
                    //Footer             
                    $this->sections[] = array(
                        'icon'      => 'el-icon-photo',
                        'title'     => __('Footer', 'bswp'),
                        'fields'    => array(
                            array( 
                                'title'     => __( 'Custom Copyright', 'bswp' ),
                                'subtitle'  => __( 'Add your own custom text/html for copyright region.', 'bswp' ),
                                'id'        => 'custom_copyright',
                                'default'   => '&copy; Copyright 2016 - <a href="http://bswp.anakitemedia.com">bswp.anakitemedia.com</a>',
                                'type'      => 'editor',
                            ),

                            array( 
                                'title'     => __( 'Custom Powered By Text', 'bswp' ),
                                'subtitle'  => __( 'Add your own custom text/html for powered by region.', 'bswp' ),
                                'id'        => 'custom_power',
                                'default'   => 'Powered by <a href="http://bswp.com">bswp</a>',
                                'type'      => 'editor',
                            ),
                        )
                    );

                    //Social             
                    $this->sections[] = array(
                        'icon'      => 'el-icon-torso',
                        'title'     => __('Social', 'bswp'),
                        'fields'    => array(
                             array( 
                                'title'     => __( 'Social Icons', 'bswp' ),
                                'subtitle'  => __( 'Arrange your social icons. Add complete URLs to your social profiles.', 'bswp' ),
                                'id'        => 'social_icons',
                                'type'      => 'sortable',
                                'options'   => $social_options,
                            ),
                        )
                    );

                  // // New Section here get section icon from shoestrap
                  // $this->sections[] = array(
                  //     'icon'      => 'el-icon-wordpress',
                  //     'title'     => __('Blog', 'bswp'),
                  //     'fields'    => array(
                  //         array(
                  //               'title'     => __( 'Display Tags', 'bswp' ),
                  //               'subtitle'  => __( 'Select to enable/disable the post tags.', 'bswp' ),
                  //               'id'        => 'enable_disable_tags',
                  //               'default'   => true,
                  //               'on'        => __( 'Enable', 'bswp' ),
                  //               'off'       => __( 'Disable', 'bswp' ),
                  //               'type'      => 'switch',
                  //           ),
                  //       )
                  //   );

                if ( file_exists( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) ) {
                    $tabs['docs'] = array(
                        'icon'    => 'el-icon-book',
                        'title'   => __( 'Documentation', 'bswp' ),
                        'content' => nl2br( file_get_contents( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) )
                    );
                }
            }


            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'bswp' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'bswp' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'bswp' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'bswp' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'bswp' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'bswp_options',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Theme Options', 'bswp' ),
                    'page_title'           => __( 'Theme Options', 'bswp' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
                // $this->args['admin_bar_links'][] = array(
                //     'id'    => 'redux-docs',
                //     'href'   => 'http://docs.reduxframework.com/',
                //     'title' => __( 'Documentation', 'bswp' ),
                // );
                //
                // $this->args['admin_bar_links'][] = array(
                //     //'id'    => 'redux-support',
                //     'href'   => 'https://github.com/ReduxFramework/redux-framework/issues',
                //     'title' => __( 'Support', 'bswp' ),
                // );
                //
                // $this->args['admin_bar_links'][] = array(
                //     'id'    => 'redux-extensions',
                //     'href'   => 'reduxframework.com/extensions',
                //     'title' => __( 'Extensions', 'bswp' ),
                // );

                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                // $this->args['share_icons'][] = array(
                //     'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                //     'title' => 'Visit us on GitHub',
                //     'icon'  => 'el-icon-github'
                //     //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                // );
                // $this->args['share_icons'][] = array(
                //     'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                //     'title' => 'Like us on Facebook',
                //     'icon'  => 'el-icon-facebook'
                // );
                // $this->args['share_icons'][] = array(
                //     'url'   => 'http://twitter.com/reduxframework',
                //     'title' => 'Follow us on Twitter',
                //     'icon'  => 'el-icon-twitter'
                // );
                // $this->args['share_icons'][] = array(
                //     'url'   => 'http://www.linkedin.com/company/redux-framework',
                //     'title' => 'Find us on LinkedIn',
                //     'icon'  => 'el-icon-linkedin'
                // );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( __( '<p></p>', 'bswp' ), $v );
                } else {
                    $this->args['intro_text'] = __( '<p></p>', 'bswp' );
                }

                // Add content after the form.
                $this->args['footer_text'] = __( '<p></p>', 'bswp' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;

              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_bswp_config();
    } else {
        echo "The class named Redux_Framework_bswp_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;

          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;
