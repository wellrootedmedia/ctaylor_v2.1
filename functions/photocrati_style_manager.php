<?php
define('PHOTOCRATI_ACTIVE_PRESET', '__active__');
define('PHOTOCRATI_PRESET_PREFIX', 'photocrati_preset_');

class Photocrati_Style_Manager extends ArrayObject
{
    static  $_cache     = array();
    var     $_settings  = array();
    var     $_aliases = array(
        'is_sidebar_enabled' => 'display_sidebar',
        'name'               => 'preset_name',
        'title'              => 'preset_title',
        'is_third_party'     => 'custom_setting'
    );

    /**
     * Constructs a new preset
     * @param array $settings
     */
    function __construct($settings=array())
    {
        if (!is_array($settings)) $settings = array();

        // Perform some translations
        $keys = array_keys($settings);

        // The default option for blog meta is enabled
        if (in_array('blog_meta', $keys)) {
            if ($settings['blog_meta'] === '') {
                $settings['blog_meta'] = TRUE;
            }
        }

        // An empty string for showing the photocrati link is equal to TRUE
        if (in_array('show_photocrati', $keys)) {
            if (is_string($settings['show_photocrati']) && $settings['show_photocrati'] == 'hide') {
                $settings['show_photocrati'] = FALSE;
            }
            else if(is_string($settings['show_photocrati']) && $settings['show_photocrati'] == '') {
                $settings['show_photocrati'] = TRUE;
            }
        }

        // Menu font case options need adjusted
        if (in_array('submenu_font_case', $keys)) {
            if ($settings['submenu_font_case'] == 'normal') $settings['submenu_font_case'] = 'none';
            if ($settings['submenu_font_case'] == '')       $settings['submenu_font_case'] = 'uppercase';
        }
        if (in_array('menu_font_case', $keys)) {
            if ($settings['menu_font_case'] == 'normal')    $settings['menu_font_case'] = 'none';
            if ($settings['menu_font_case'] == '')          $settings['menu_font_case'] = 'uppercase';
        }
        $this->_settings = $settings;

        // Set some default values
        $defaults = array(
            'name'           =>  'preset-unnamed',
            'title'          =>  'Unnamed Preset',
            'dynamic_style'         =>  TRUE,
            'one_column'            =>  FALSE,
            'one_column_color'      =>  'FFFFFF',
            'one_column_logo'       =>  FALSE,
            'one_column_margin'     =>  '30',
            'is_sidebar_enabled'    =>  TRUE,
            'content_width'         =>  '65',
            'sidebar_width'         =>  '35',
            'logo_menu_position'    =>  'left-right',
            'bg_color'              =>  'FFFFFF',
            'bg_image'              =>  '',
            'bg_repeat'             =>  'repeat',
            'header_bg_color'       =>  'FFFFFF',
            'header_bg_image'       =>  '',
            'header_bg_repeat'      =>  'repeat',
            'container_color'       =>  'transparent',
            'container_border'      =>  '0',
            'container_border_color'=>  'CCCCCC',
            'font_color'            =>  '666666',
            'font_size'             =>  '16',
            'font_style'            =>  'Open Sans',
            'font_italic'           =>  'normal',
            'font_weight'           =>  '',
            'font_decoration'       =>  'none',
            'font_case'             =>  'none',
            'p_line'                =>  '25',
            'p_space'               =>  '25',
            'h1_color'              =>  '7695B2',
            'h1_size'               =>  '30',
            'h1_font_style'         =>  'Open Sans',
            'h1_font_case'          =>  'none',
            'h1_font_weight'        =>  'bold',
            'h1_font_decoration'    =>  'none',
            'h1_font_italic'        =>  'normal',
            'h1_font_align'         =>  '',
            'h2_color'              =>  '333333',
            'h2_size'               =>  '26',
            'h2_font_style'         =>  'Open Sans',
            'h2_font_case'          =>  'none',
            'h2_font_weight'        =>  'bold',
            'h2_font_italic'        =>  'normal',
            'h2_font_decoration'    =>  'none',
            'h2_font_align'         =>  '',
            'h3_color'              =>  '333333',
            'h3_size'               =>  '24',
            'h3_font_style'         =>  'Open Sans',
            'h3_font_case'          =>  'none',
            'h3_font_weight'        =>  'bold',
            'h3_font_italic'        =>  '', #normal
            'h3_font_decoration'    =>  'none',
            'h3_font_align'         =>  '',
            'h4_color'              =>  '333333',
            'h4_size'               =>  '22',
            'h4_font_style'         =>  'Open Sans',
            'h4_font_case'          =>  'none',
            'h4_font_weight'        =>  'bold',
            'h4_font_italic'        =>  '', #normal
            'h4_font_decoration'    =>  'none',
            'h4_font_align'         =>  '',
            'h5_color'              =>  '333333',
            'h5_size'               =>  '20',
            'h5_font_style'         =>  'Open Sans',
            'h5_font_case'          =>  'none',
            'h5_font_weight'        =>  'bold',
            'h5_font_italic'        =>  '', # normal
            'h5_font_decoration'    =>  'none',
            'h5_font_align'         =>  '',
            'link_color'            =>  '2B5780',
            'link_hover_color'      =>  '266ead',
            'link_hover_style'      =>  'underline',
            'sidebar_font_color'    =>  '666666',
            'sidebar_font_size'     =>  '16',
            'sidebar_font_style'    =>  'Open Sans',
            'sidebar_font_weight'   =>  '', # normal
            'sidebar_font_italic'   =>  '', # normal
            'sidebar_font_decoration' => 'none',
            'sidebar_font_case'     =>  'none',
            'sidebar_bg_color'      =>  'transparent',
            'sidebar_link_color'    =>  '2B5780',
            'sidebar_link_hover_color' => '2B5780',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color'   =>  '333333',
            'sidebar_title_size'    =>  '14',
            'sidebar_title_style'   =>  'Open Sans',
            'sidebar_title_weight'  =>  'bold', # normal
            'sidebar_title_italic'  =>  '', # normal
            'sidebar_title_decoration' =>'none',
            'sidebar_title_case'    =>  'uppercase',
            'menu_style'            =>  'transparent',
            'menu_color'            =>  'FFFFFF',
            'menu_hover_color'      =>  'FFFFFF',
            'menu_font_size'        =>  '14',
            'menu_font_style'       =>  'Open Sans',
            'menu_font_color'       =>  'A8A8A8',
            'menu_font_weight'      =>  'bold',
            'menu_font_italic'      =>  '', # normal,
            'menu_font_decoration'  =>  'none',
            'menu_font_hover_color' => '2D73B6',
            'menu_font_case'        => 'uppercase',
            'submenu_color'         => 'E8E8E8',
            'submenu_hover_color'   => 'C8C9CB',
            'submenu_font_size'     => '12',
            'submenu_font_style'    => 'Open Sans',
            'submenu_font_color'    => '484848',
            'submenu_font_weight'   => '', # normal
            'submenu_font_italic'   => '', # normal
            'submenu_font_decoration' => 'none',
            'submenu_font_hover_color' => '2D73B6',
            'submenu_font_case'     => 'none',
            'nextgen_border'        => '5',
            'nextgen_border_color'  => 'CCCCCC',
            'custom_logo'           => 'title',
            'custom_logo_image'     => 'Logo_Steel.png',
            'footer_copy'           => '',
            'custom_sidebar'        => FALSE,
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html'   => '',
            'social_media'          => FALSE,
            'social_media_title'    => 'Follow Me',
            'social_media_set'      => 'small',
            'social_rss'            => '',
            'social_email'          => '',
            'social_twitter'        => '',
            'social_facebook'       => '',
            'social_flickr'         => '',
            'google_analytics'      => '',
            'custom_js'             => '',
            'custom_css'            => 'p {
margin-bottom:0.5em;
}

#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}',
            'header_height'         => '140',
            'header_logo_margin_above' => '25',
            'header_logo_margin_below' => '10',
            'title_size'            => '38',
            'title_color'           => '7695b2',
            'title_font_style'      => '',
            'title_font_weight'     => 'bold',
            'title_style'           => 'Open Sans',
            'title_italic'          => '', # normal
            'title_decoration'      => 'none',
            'title_font_case'       => 'none',
            'description_size'      => '16',
            'description_color'     => '999999',
            'description_style'     => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => 'normal',
            'description_font_italic'   => '',
            'description_font_decoration' => 'none',
            'bg_top_offset'         => '0',
            'container_padding'     => '10',
            'footer_font'           => '16',
            'footer_font_color'     => '333333',
            'is_third_party'        => FALSE,
            'footer_widget_placement' => '3',
            'footer_background'     => 'FFFFFF',
            'footer_font_style'     => 'Open Sans',
            'footer_font_weight'    => '', # normal
            'footer_font_italic'    => '', # normal
            'footer_font_case'      => 'none', # normal
            'footer_font_decoration'=> 'none',
            'footer_widget_title'   => '14',
            'footer_widget_color'   => '7695b2',
            'footer_widget_style'   => 'Open Sans',
            'footer_widget_weight'  => 'bold', # normal
            'footer_widget_italic'  => '', # normal
            'footer_widget_decoration' => 'none',
            'footer_widget_case'    => 'none',
            'footer_link_color'     => '7695b2',
            'footer_link_hover_color' => '7695b2',
            'footer_link_hover_style' => 'none',
            'footer_height'         => '430',
            'show_photocrati'       => TRUE,
            'page_comments'         => FALSE,
            'blog_meta'             => TRUE,
        );
        $this->_clean_up_keys();

        $keys = array_keys($this->_settings);
        foreach ($defaults as $key => $value) {
            if (!in_array($key, $keys)) $this->$key = $value;
        }
    }

    /**
     * Determines if a particular option has been set
     * @param $option
     * @return bool
     */
    function __isset($option)
    {
        return isset($this->_settings[$option]);
    }


    /**
     * Gets the value of an option
     * @param $option
     * @return null
     */
    function __get($option)
    {
        $keys = array_keys($this->_settings);
        $retval = in_array($option, $keys) ? $this->_settings[$option] : NULL;

        // If an option was unfound by name, perhaps it goes by an alias
        if (is_null($retval) && isset($this->_aliases[$option])) {
            $retval = $this->__get($this->_aliases[$option]);
        }

        // Ensure that proper boolean values are returned
        if ($retval == 'YES')       $retval = TRUE;
        elseif ($retval == 'NO')    $retval = FALSE;
        elseif ($retval == 'ON')     $retval = TRUE;
        elseif ($retval == 'OFF')   $retval = FALSE;

        return $retval;
    }


    /**
     * Sets an option to a particular value
     * @param $option
     * @param $value
     * @return mixed
     */
    function __set($option, $value)
    {
        // Ensure that proper boolean values are set
        if ($value == 'YES')    $value = TRUE;
        elseif ($value == 'NO') $value = FALSE;
        elseif ($value == 'ON') $value = TRUE;
        elseif ($value == 'OFF')$value = FALSE;

        // Remove the old option name
        if (isset($this->_aliases[$option])) {
            $old_option_name = $this->_aliases[$option];
            unset($this->_settings[$old_option_name]);
        }

        // Set the new option instead of the old option
        if (($key = array_search($option, $this->_aliases)) !== FALSE) $option = $key;

        return ($this->_settings[$option] = $value);
    }

    /**
     * Determines if a particular option has been set or not
     * @param $option_name
     * @return bool
     */
    function has_option($option_name)
    {
        return isset($this->$option_name);
    }

    /**
     * Gets the title of the preset
     * @return null
     */
    function get_title()
    {
        return $this->title;
    }

    /**
     * Gets the name of the preset
     * @return null
     */
    function get_name()
    {
        return $this->name;
    }


    /**
     * Determines if the preset was created by a third-party (such as the user)
     * @return bool
     */
    function is_third_party()
    {
        return $this->is_third_party;
    }

    /**
     * Sets the preset as the active preset for the theme
     */
    function set_as_active()
    {
        $this->_cache[PHOTOCRATI_ACTIVE_PRESET] = $this->_settings;
        $this->save(PHOTOCRATI_ACTIVE_PRESET);
    }

    /**
     * Returns TRUE if this is a new preset with no settings
     * @return bool
     */
    function is_new()
    {
        return empty($this->_settings) || $this->get_name() == 'preset-unnamed';
    }

    /**
     * Saves any changes made to the preset
     * @return bool
     */
    function save($save_as=FALSE)
    {
        $this->_clean_up_keys();
        if (!$save_as) $save_as = $this->get_name();
        update_option(PHOTOCRATI_PRESET_PREFIX.$save_as, $this->_settings);
        self::_generate_index($this->get_name(), $this->is_third_party());
    }

    function delete($key)
    {
        unset($this->_settings[$key]);
    }

    function _clean_up_keys()
    {
        // Clean up redundant keys
        $keys = array_keys($this->_settings);
        foreach ($this->_aliases as $good_key => $bad_key) {

            // We only want the aliased key (good key)
            if (in_array($bad_key, $keys)) {
                if (in_array($good_key, $keys)) {
                    unset($this->_settings[$bad_key]);
                }
                else {
                    $this->$good_key = $this->$bad_key;
                    unset($this->_settings[$bad_key]);
                }
            }
        }
    }

    static function are_dynamic_styles_enabled()
    {
        return self::get_active_preset()->dynamics_styles;
    }

    static function enable_dynamic_stylesheet()
    {
        $preset = self::get_active_preset();
        $preset->dynamic_style = TRUE;
        $preset->save(PHOTOCRATI_PRESET_PREFIX);
    }

    static function disable_dynamic_stylesheet()
    {
        $preset = self::get_active_preset();
        $preset->dynamic_style = FALSE;
        $preset->save(PHOTOCRATI_PRESET_PREFIX);
    }

	static function generate_static_stylesheet()
	{
		$retval         = FALSE;

		// Fetch the dynamic stylesheet
		$file = get_template_directory_uri() . '/styles/dynamic-style.php';
		if (!($response = wp_remote_get($file)) instanceof WP_Error) {
			$contents = wp_remote_retrieve_body($response);

			// Write the dynamic stylesheet to a static file
			if ($contents) {
				$newfile = implode(DIRECTORY_SEPARATOR, array(
					get_stylesheet_directory(),
					'styles',
					'style.css'
				));

				if (is_writable($newfile)) {
					$wrote = @file_put_contents($newfile, $contents);
					if ($wrote > 0) $retval = TRUE;
				}

			}
		}

		return $retval;
	}

    /**
     * Sets the specified as the active preset for the theme
     * @param $preset_name
     */
    static function set_active_preset($preset_name)
    {
        $preset = self::get_preset($preset_name);
        if (!$preset->is_new()) $preset->set_as_active();
    }

    /**
     * Generates an index of presets in the database
     * @param bool $new_name
     * @param bool $third_party
     * @return array
     */
    static function _generate_index($new_name=FALSE, $third_party=FALSE)
    {
        $presets = get_option('photocrati_presets', array());
        if (!$presets && self::legacy_table_exists()) {
            global $wpdb;
            $rows = $wpdb->get_results("SELECT preset_name, custom_setting FROM {$wpdb->prefix}photocrati_presets", ARRAY_A);
            foreach ($rows as $row) {
                $name           = $row['preset_name'];
                $is_third_party = $row['custom_setting'];
                $presets[$name] = $is_third_party;
            }
        }
        if ($new_name) {
            $presets[$new_name] = $third_party;
        }

        update_option('photocrati_presets', $presets);

        return $presets;
    }

    static function import_preset($filename, $third_party=TRUE)
    {
        $retval = FALSE;
        $contents = @file_get_contents($filename);
        if ($contents) {
            $settings = (array) json_decode($contents);
            if ($settings) {
                $preset = new Photocrati_Style_Manager($settings);
                $preset->is_third_party = $third_party;
                $preset->save();
                $retval = TRUE;
            }
        }

        return $retval;
    }

    static function legacy_table_exists()
    {
        global $wpdb;
        return is_object($wpdb->get_row("SHOW TABLES LIKE '{$wpdb->prefix}photocrati_presets'"));
    }


    /**
     * Returns the inner array
     * @return array
     */
    function to_array()
    {
        $retval = array();
        foreach ($this->_settings as $key => $value) {
            if ($value == 'YES')    $value = TRUE;
            elseif ($value == 'NO') $value = FALSE;
            elseif ($value == 'ON') $value = TRUE;
            elseif ($value == 'OFF')$value = FALSE;
            $retval[$key] = $value;
        }
        return $retval;
    }

    static function get_all_presets($return_third_party=TRUE)
    {
        $retval = array();
        foreach (self::_generate_index() as $preset_name => $third_party) {
            if (($return_third_party == FALSE && $third_party == FALSE) OR $return_third_party == TRUE) {
                $retval[] = self::get_preset($preset_name);
            }
        }

        return $retval;

    }

    /**
     * Returns only third party presets
     * @return array
     */
    static function get_all_third_party_presets()
    {
        $retval = array();
        foreach (self::_generate_index() as $preset_name => $third_party) {
            if ($third_party) {
                $retval[] = self::get_preset($preset_name);
            }
        }

        return $retval;
    }


    /**
     * Gets a named group of style settings
     * @param $preset_name
     */
    static function get_preset($preset_name)
    {
        global $wpdb;

        $retval = array();

        // Clean the name
        if ($preset_name != PHOTOCRATI_ACTIVE_PRESET) {
            $preset_name = preg_replace("/\s+/", '_', $preset_name);
            while (TRUE) {
                if (preg_match("/[^\w-_]+/", $preset_name, $match)) {
                    $preset_name = str_replace($match[0], '', $preset_name);
                }
                else break;
            }
        }

        // Have we already retrieved the preset? If so,
        // return it from the cache
        if (isset(self::$_cache[$preset_name])) {
            $retval = self::$_cache[$preset_name];
        }

        // We need to find the preset and it's settings
        else {
            // First try to locate the preset as a WP Option
            if (($settings = get_option(PHOTOCRATI_PRESET_PREFIX.$preset_name))) {
                $retval = $settings;
            }

            // We're still using the old Photocrati tables method. The active preset
            // is in the photocrati_styles table, whereas all others are in
            // photocrati_presets table

            // Are we asking for the active preset?
            elseif (self::legacy_table_exists()) {

                if ($preset_name == PHOTOCRATI_ACTIVE_PRESET) {
                    $retval = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}photocrati_styles LIMIT 1", ARRAY_A);
                }

                // Are we asking for an inactive preset?
                else {
                    $retval = $wpdb->get_row($wpdb->prepare(
                        "SELECT * FROM {$wpdb->prefix}photocrati_presets WHERE preset_name = %s",
                        $preset_name
                    ), ARRAY_A);
                }
            }

            // Cache the preset
            self::$_cache[$preset_name] = $retval;
        }

        // Wrap the array as an object
        $klass = get_class();
        $retval = new $klass($retval);

        return $retval;
    }

    /**
     * Returns the settings for the active preset
     * @return Photocrati_Style_Manager
     */
    static function get_active_preset()
    {
        return self::get_preset(PHOTOCRATI_ACTIVE_PRESET);
    }

    static function clone_active_as($title, $third_party=FALSE)
    {
        $name   = sanitize_title_with_dashes($title);
        $new_preset     = self::get_preset($name);
        $active_preset  = self::get_active_preset();

        foreach ($active_preset->to_array() as $key => $val) {
            $new_preset->$key = $val;
        }
        $new_preset->title = $title;
        $new_preset->name  = $name;
        $new_preset->is_third_party = $third_party;
        $new_preset->save();
    }

    /**
     * Determines whether the sidebar has been enabled for the active preset
     * @return mixed
     */
    static function is_sidebar_enabled()
    {
        return self::get_active_preset()->is_sidebar_enabled;
    }

    static function delete_preset($name)
    {
        delete_option(PHOTOCRATI_PRESET_PREFIX.$name);
        $presets = self::_generate_index();
        unset($presets[$name]);
        update_option('photocrati_presets', $presets);
    }

    static function init()
    {
        // Get any presets stored from legacy tables
        self::_generate_index();

        // Add default presets
        $preset = new Photocrati_Style_Manager(array(
            'preset_name'   =>  'preset-fstop',
            'preset_title'  =>  'Photocrati F-Stop',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'bottom-top',
            'bg_color' => '000000',
            'bg_image' => '',
            'bg_repeat' => 'repeat',
            'header_bg_color' => '000000',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => 'FFFFFF',
            'font_color' => 'FFFFFF',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => 'FFFFFF',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => 'FFFFFF',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => 'FFFFFF',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => 'FFFFFF',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => 'FFFFFF',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => 'eb941a',
            'link_hover_color' => 'ff6600',
            'link_hover_style' => 'none',
            'sidebar_font_color' => 'ababab',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => 'eb941a',
            'sidebar_link_hover_color' => 'ff6600',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color' => 'b0854a',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'color',
            'menu_color' => '000000',
            'menu_hover_color' => 'eb941a',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'FFFFFF',
            'menu_font_hover_color' => '704100',
            'menu_font_case' => 'uppercase',
            'submenu_color' => '474747',
            'submenu_hover_color' => 'eb941a',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => 'FFFFFF',
            'submenu_font_hover_color' => '704100',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => 'E1E1E1',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Orange2.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '60',
            'header_logo_margin_below' => '20',
            'title_color' => 'c78425',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => 'b5b5b5',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '10',
            'footer_font' => '16',
            'footer_font_color' => 'FFFFFF',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => '000000',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'c78425',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => 'c78425',
            'footer_link_hover_color' => 'c78425',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => '',
        ));
        $preset->save();

        $preset = new Photocrati_Style_Manager(array(
            'preset_name'   =>  'preset-emulsion',
            'preset_title'  =>  'Photocrati Emulsion',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'bottom-top',
            'bg_color' => 'FFFFFF',
            'bg_image' => '',
            'bg_repeat' => 'repeat',
            'header_bg_color' => 'FFFFFF',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => '666666',
            'font_color' => '333333',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => '333333',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => '333333',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => '333333',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => '333333',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => '333333',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => '5da85b',
            'link_hover_color' => '2ecc29',
            'link_hover_style' => 'none',
            'sidebar_font_color' => '545454',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => '5da85b',
            'sidebar_link_hover_color' => '2ecc29',
            'sidebar_link_hover_style' => 'none',
            'sidebar_title_color' => 'a6a6a6',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'color',
            'menu_color' => 'FFFFFF',
            'menu_hover_color' => 'E8E8EA',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => '666666',
            'menu_font_hover_color' => '5da85b',
            'menu_font_case' => 'uppercase',
            'submenu_color' => 'E8E8EA',
            'submenu_hover_color' => 'b2d3b1',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => '5da85b',
            'submenu_font_hover_color' => '595959',
            'submenu_font_case' => 'none',
            'nextgen_border' => '1',
            'nextgen_border_color' => 'CCCCCC',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Tall_Green.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}

h1 {
border-bottom:0 solid #E1E1E1;
text-align:center;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '60',
            'header_logo_margin_below' => '20',
            'title_color' => 'b2d3b1',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => '999999',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '10',
            'footer_font' => '16',
            'footer_font_color' => '333333',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => 'FFFFFF',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'b2d3b1',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => '5da85b',
            'footer_link_hover_color' => 'b2d3b1',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => '',
        ));
        $preset->save();

        // Photocrati Signature
        $preset = new Photocrati_Style_Manager(array(
            'preset_title'  =>  'Photocrati Signature',
            'preset_name'   =>  'preset-signature',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'bottom-top',
            'bg_color' => '42413F',
            'bg_image' => '',
            'bg_repeat' => 'repeat',
            'header_bg_color' => '42413F',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => 'CCCCCC',
            'font_color' => 'F1F1F1',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => 'F0F0EE',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => 'FFFFFF',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => 'FFFFFF',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => 'FFFFFF',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => 'FFFFFF',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => '6197CA',
            'link_hover_color' => '1c84e6',
            'link_hover_style' => 'none',
            'sidebar_font_color' => 'a8a8a8',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => '6197CA',
            'sidebar_link_hover_color' => '3597f2',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color' => 'bcd4eb',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'color',
            'menu_color' => '42413F',
            'menu_hover_color' => '666666',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'ffffff',
            'menu_font_hover_color' => 'bcd4eb',
            'menu_font_case' => 'uppercase',
            'submenu_color' => 'C2C2C2',
            'submenu_hover_color' => 'A0A6AA',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => '1B1B1B',
            'submenu_font_hover_color' => 'F0F0EE',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => 'E1E1E1',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Script_Blue.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '#footer {
border-top:0;
text-align:center;
}

h1 {
border-bottom:0px;
}

p {
margin-bottom:0.5em;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '60',
            'header_logo_margin_below' => '20',
            'title_color' => 'bcd4eb',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => 'CCCCCC',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '10',
            'footer_font' => '16',
            'footer_font_color' => 'FFFFFF',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => '42413F',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'bcd4eb',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => '6197CA',
            'footer_link_hover_color' => 'bcd4eb',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => '',
        ));
        $preset->save();

        // Photocrati Vignette
        $preset = new Photocrati_Style_Manager(array(
            'name'   =>  'preset-vignette',
            'title'  =>  'Photocrati Vignette',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'right-left',
            'bg_color' => '067506',
            'bg_image' => 'Green_BG.jpg',
            'bg_repeat' => 'no-repeat',
            'header_bg_color' => '000000',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat',
            'container_color' => 'e1e8d0',
            'container_border' => '0',
            'container_border_color' => 'd9f5a2',
            'font_color' => '000000',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => '4a640b',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => '4a640b',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => '4a640b',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => '4a640b',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => '4a640b',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => '6ea34b',
            'link_hover_color' => '8bc714',
            'link_hover_style' => 'underline',
            'sidebar_font_color' => '5c5c5c',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => '417e4a',
            'sidebar_link_hover_color' => '417e4a',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color' => '417e4a',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'color',
            'menu_color' => '000000',
            'menu_hover_color' => '067506',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'ffffff',
            'menu_font_hover_color' => 'fefeb9',
            'menu_font_case' => 'uppercase',
            'submenu_color' => '000000',
            'submenu_hover_color' => '067506',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => 'FFFFFF',
            'submenu_font_hover_color' => 'fefeb9',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => '007401',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Shiny_Green.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '.menu ul {
line-height:4;
}

.menu ul li:hover ul, .menu ul li ul {
line-height: 2;
}

.menu a:link, .menu a:visited {
padding:93px 17px 47px;
}

h1 {
border-bottom:0px;
}

div.sidebar {
padding: 20px;
}

div.slideshow {
margin-bottom:20px;
}

p {
margin-bottom:0.5em;
line-height:1.9em;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '15',
            'header_logo_margin_below' => '10',
            'title_color' => 'e6e6a1',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => 'b5b5b5',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '30',
            'footer_font' => '16',
            'footer_font_color' => 'FFFFFF',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => '000000',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'e6e6a1',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => 'e6e6a1',
            'footer_link_hover_color' => 'e6e6a1',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => '',
        ));
        $preset->save();

        // Photocrati Canvas
        $preset = new Photocrati_Style_Manager(array(
            'preset_name'   =>  'preset-canvas',
            'preset_title'  =>  'Photocrati Canvas',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'bottom-top',
            'bg_color' => 'FFFFFF',
            'bg_image' => 'Muslin_BG.jpg',
            'bg_repeat' => 'repeat',
            'header_bg_color' => 'FFFFFF',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat',
            'container_color' => 'FFFFFF',
            'container_border' => '0',
            'container_border_color' => '666666',
            'font_color' => '333333',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => '944C7D',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => '944C7D',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => '944C7D',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => '944C7D',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => '944C7D',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => 'e65370',
            'link_hover_color' => 'c2adbd',
            'link_hover_style' => 'none',
            'sidebar_font_color' => '333333',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => 'e65370',
            'sidebar_link_hover_color' => 'c2adbd',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color' => '333333',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'color',
            'menu_color' => 'FFFFFF',
            'menu_hover_color' => 'e3d6c6',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => '995083',
            'menu_font_hover_color' => 'e55070',
            'menu_font_case' => 'uppercase',
            'submenu_color' => 'f5efe7',
            'submenu_hover_color' => 'e3d6c6',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => '73604a',
            'submenu_font_hover_color' => 'e55070',
            'submenu_font_case' => 'none',
            'nextgen_border' => '0',
            'nextgen_border_color' => 'ffffff',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Fade_Pink.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '.widget-title, .widgettitle {
       margin-top:5px;
}

.widget-title, .widgettitle {
color:#944C7D;
font-size:17px;
font-weight:bold;
margin-bottom:21px;
}

p {
margin-bottom:2.5em;
}

.widget-title, .widgettitle {
padding:4px 0;
}

div.slideshow {
margin-bottom: 23px;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '60',
            'header_logo_margin_below' => '20',
            'title_color' => 'c2adbd',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => '999999',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '30',
            'footer_font' => '16',
            'footer_font_color' => '333333',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => 'FFFFFF',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'c2adbd',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => 'e65370',
            'footer_link_hover_color' => 'c2adbd',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => '',
        ));
        $preset->save();

        // Photocrati Lightbox
        $preset = new Photocrati_Style_Manager(array(
            'preset_name'   =>  'preset-lightbox',
            'preset_title'  =>  'Photocrati Lightbox',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'left-right',
            'bg_color' => 'FFFFFF',
            'bg_image' => '',
            'bg_repeat' => 'repeat',
            'header_bg_color' => 'FFFFFF',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => 'CCCCCC',
            'font_color' => '666666',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => '7695B2',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => '333333',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => '333333',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => '333333',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => '333333',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => '2B5780',
            'link_hover_color' => '266ead',
            'link_hover_style' => 'underline',
            'sidebar_font_color' => '666666',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => '2B5780',
            'sidebar_link_hover_color' => '2B5780',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color' => '333333',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'transparent',
            'menu_color' => 'FFFFFF',
            'menu_hover_color' => 'FFFFFF',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'A8A8A8',
            'menu_font_hover_color' => '2D73B6',
            'menu_font_case' => 'uppercase',
            'submenu_color' => 'E8E8E8',
            'submenu_hover_color' => 'C8C9CB',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => '484848',
            'submenu_font_hover_color' => '2D73B6',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => 'CCCCCC',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Steel.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => 'p {
margin-bottom:0.5em;
}

#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '25',
            'header_logo_margin_below' => '10',
            'title_color' => '7695b2',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => '999999',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '10',
            'footer_font' => '16',
            'footer_font_color' => '333333',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => 'FFFFFF',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => '7695b2',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => '7695b2',
            'footer_link_hover_color' => '7695b2',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => '',
        ));
        $preset->save();

        // Photocrati Darkroom
        $preset = new Photocrati_Style_Manager(array(
            'preset_title'  =>  'Photocrati Darkroom',
            'preset_name'   =>  'preset-darkroom',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'left-right',
            'bg_color' => '000000',
            'bg_image' => '',
            'bg_repeat' => 'repeat',
            'header_bg_color' => '000000',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => 'CCCCCC',
            'font_color' => 'F1F1F1',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => 'F0F0EE',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => 'FFFFFF',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => 'FFFFFF',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => 'FFFFFF',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => 'FFFFFF',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => '7c943b',
            'link_hover_color' => 'a9e600',
            'link_hover_style' => 'underline',
            'sidebar_font_color' => 'F1F1F1',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => '6197CA',
            'sidebar_link_hover_color' => '6197CA',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color' => 'FFFFFF',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'transparent',
            'menu_color' => '000000',
            'menu_hover_color' => '000000',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'c2c2c2',
            'menu_font_hover_color' => '9ac22b',
            'menu_font_case' => 'uppercase',
            'submenu_color' => 'bdbdbd',
            'submenu_hover_color' => '1F1F1F',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => '35382d',
            'submenu_font_hover_color' => '9ac22b',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => 'E1E1E1',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Stretch_Green.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => 'p {
margin-bottom:0.5em;
}

h1 {
border-bottom:0px;
}

#footer {
border-top:0px;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '15',
            'header_logo_margin_below' => '10',
            'title_color' => '8ca644',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => 'b5b5b5',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '10',
            'footer_font' => '16',
            'footer_font_color' => 'F1F1F1',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => '000000',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => '8ca644',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => '8ca644',
            'footer_link_hover_color' => '8ca644',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => '',
        ));
        $preset->save();

        // Photocrati Exposure
        $preset = new Photocrati_Style_Manager(array(
            'preset_name'   =>  'preset-exposure',
            'preset_title'  =>  'Photocrati Exposure',
				'dynamic_style' => 'YES',
				'one_column' => 'OFF',
				'one_column_color' => 'FFFFFF',
				'one_column_logo' => 'OFF',
				'one_column_margin' => '30',
				'is_sidebar_enabled' => 'YES',
				'content_width' => '65',
				'sidebar_width' => '35',
				'logo_menu_position' => 'left-right',
				'bg_color' => '24221f',
				'bg_image' => '',
				'bg_repeat' => 'repeat',
				'header_bg_color' => '24221f',
				'header_bg_image' => '',
				'header_bg_repeat' => 'repeat',
				'container_color' => 'transparent',
				'container_border' => '0',
				'container_border_color' => 'CCCCCC',
				'font_color' => 'F1F1F1',
				'font_size' => '16',
				'font_style' => 'Open Sans',
				'p_line' => '25',
				'p_space' => '25',
				'h1_color' => 'F0F0EE',
				'h1_size' => '30',
				'h1_font_style' => 'Open Sans',
				'h1_font_case' => 'none',
				'h1_font_weight' => 'bold',
				'h1_font_align' => '',
				'h2_color' => 'FFFFFF',
				'h2_size' => '26',
				'h2_font_style' => 'Open Sans',
				'h2_font_case' => 'none',
				'h2_font_weight' => 'bold',
				'h3_color' => 'FFFFFF',
				'h3_size' => '24',
				'h3_font_style' => 'Open Sans',
				'h3_font_case' => 'none',
				'h3_font_weight' => 'bold',
				'h4_color' => 'FFFFFF',
				'h4_size' => '22',
				'h4_font_style' => 'Open Sans',
				'h4_font_case' => 'none',
				'h4_font_weight' => 'bold',
				'h5_color' => 'FFFFFF',
				'h5_size' => '20',
				'h5_font_style' => 'Open Sans',
				'h5_font_case' => 'none',
				'h5_font_weight' => 'bold',
				'link_color' => '6197CA',
				'link_hover_color' => '2993f5',
				'link_hover_style' => 'underline',
				'sidebar_font_color' => 'c2c2c2',
				'sidebar_font_size' => '16',
				'sidebar_font_style' => 'Open Sans',
				'sidebar_bg_color' => 'transparent',
				'sidebar_link_color' => '6197CA',
				'sidebar_link_hover_color' => '2c92f2',
				'sidebar_link_hover_style' => 'underline',
				'sidebar_title_color' => 'FFFFFF',
				'sidebar_title_size' => '14',
				'sidebar_title_style' => 'Open Sans',
				'menu_style' => 'transparent',
				'menu_color' => '42413F',
				'menu_hover_color' => '42413F',
				'menu_font_size' => '14',
				'menu_font_style' => 'Open Sans',
				'menu_font_color' => '8C8C8C',
				'menu_font_hover_color' => '2f90eb',
				'menu_font_case' => 'uppercase',
				'submenu_color' => '999999',
				'submenu_hover_color' => '2f90eb',
				'submenu_font_size' => '12',
				'submenu_font_style' => 'Open Sans',
				'submenu_font_color' => '1B1B1B',
				'submenu_font_hover_color' => 'F0F0EE',
				'submenu_font_case' => 'none',
				'nextgen_border' => '5',
				'nextgen_border_color' => 'E1E1E1',
				'custom_logo' => 'title',
				'custom_logo_image' => 'Logo_Bright_Blue.png',
				'footer_copy' => '',
				'custom_sidebar' => 'OFF',
				'custom_sidebar_position' => 'ABOVE',
				'custom_sidebar_html' => '',
				'social_media' => 'OFF',
				'social_media_title' => 'Follow Me',
				'social_media_set' => 'small',
				'social_rss' => '',
				'social_email' => '',
				'social_twitter' => '',
				'social_facebook' => '',
				'social_flickr' => '',
				'google_analytics' => '',
				'custom_css' => '#footer {
border-top:0 solid #E8E7E7;
text-align:center;
}

h1 {
border-bottom:0 solid #E1E1E1;
}',
				'header_height' => '140',
				'header_logo_margin_above' => '15',
				'header_logo_margin_below' => '10',
				'title_color' => '637a8f',
				'title_font_style' => '',
				'title_font_weight' => 'bold',
				'title_style' => 'Open Sans',
				'description_size' => '16',
				'description_color' => 'b5b5b5',
				'description_style' => 'Open Sans',
                'description_font_weight'   => '',
                'description_font_style'    => '',
				'bg_top_offset' => '0',
				'container_padding' => '10',
				'footer_font' => '16',
				'footer_font_color' => 'F1F1F1',
                'is_third_party' => FALSE,
				'footer_widget_placement' => '3',
				'footer_background' => '24221f',
				'footer_font_style' => 'Open Sans',
				'footer_widget_title' => '14',
				'footer_widget_color' => '637a8f',
				'footer_widget_style' => 'Open Sans',
				'footer_link_color' => '637a8f',
				'footer_link_hover_color' => '637a8f',
				'footer_link_hover_style' => 'none',
				'footer_height' => '430',
				'show_photocrati' => '',
				'page_comments' => 'OFF',
				'blog_meta' => TRUE,
        ));
        $preset->save();

        // Photocrati Rangefinder
        $preset = new Photocrati_Style_Manager(array(
            'preset_title'   => 'Photocrati Rangefinder',
            'preset_name'    => 'preset-rangefinder',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'top-bottom',
            'bg_color' => '2f1c0b',
            'bg_image' => 'Wood_BG.jpg',
            'bg_repeat' => 'repeat-x',
            'header_bg_color' => 'ebe8dd',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => 'CCCCCC',
            'font_color' => 'ebe8dd',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => 'ffffff',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => 'd4c6a3',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => 'ded7ca',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => 'c5b383',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => 'c5b383',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => 'be3501',
            'link_hover_color' => 'eb551e',
            'link_hover_style' => 'none',
            'sidebar_font_color' => 'c5b383',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => 'be3501',
            'sidebar_link_hover_color' => 'eb551e',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color' => 'FFFFFF',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'transparent',
            'menu_color' => 'FFFFFF',
            'menu_hover_color' => 'FFFFFF',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => '280b03',
            'menu_font_hover_color' => 'be3501',
            'menu_font_case' => 'uppercase',
            'submenu_color' => 'f5f3eb',
            'submenu_hover_color' => 'ccc4a7',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => '280b03',
            'submenu_font_hover_color' => 'be3501',
            'submenu_font_case' => 'none',
            'nextgen_border' => '1',
            'nextgen_border_color' => 'f5f3ed',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Brown.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => 'h1 {
     border-bottom: 0px;
     padding-top: 24px;

}

h2 {
     padding-top: 41px;
}

#menu_wrapper {
     margin-top: -7px;
}

.widget-title, .widgettitle {
     padding-top: 12px;
]

#footer {
     border-top: 0px;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '5',
            'header_logo_margin_below' => '20',
            'title_color' => 'ad9966',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => '666666',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '10',
            'footer_font' => '16',
            'footer_font_color' => '333333',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => 'ebe8dd',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'ad9966',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => 'be3501',
            'footer_link_hover_color' => 'ad9966',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => TRUE,
        ));
        $preset->save();

        // Photocrati Polarized
        $preset = new Photocrati_Style_Manager(array(
            'preset_title'   =>  'Photocrati Polarized',
            'preset_name'    =>  'preset-polarized',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'left-right',
            'bg_color' => '000000',
            'bg_image' => 'Grille_BG.jpg',
            'bg_repeat' => 'repeat-x',
            'header_bg_color' => 'ffffff',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat',
            'container_color' => 'e3e3e3',
            'container_border' => '9',
            'container_border_color' => 'fffcf7',
            'font_color' => '423f3d',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => '274a6b',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => '274a6b',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => '274a6b',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => '274a6b',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => '274a6b',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => '6197CA',
            'link_hover_color' => '61b3ff',
            'link_hover_style' => 'none',
            'sidebar_font_color' => '383738',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => '6197CA',
            'sidebar_link_hover_color' => '61b3ff',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color' => '274a6b',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'transparent',
            'menu_color' => '42413F',
            'menu_hover_color' => '42413F',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => '8C8C8C',
            'menu_font_hover_color' => '6197ca',
            'menu_font_case' => 'uppercase',
            'submenu_color' => '6f7378',
            'submenu_hover_color' => '6197ca',
            'submenu_font_size' => '11',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => '1B1B1B',
            'submenu_font_hover_color' => 'ffffff',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => 'E1E1E1',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Steel.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '.menu ul {
       line-height: 1.5em;
}

p {
margin-bottom:0.5em;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '15',
            'header_logo_margin_below' => '10',
            'title_color' => '57697a',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => '999999',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '20',
            'container_padding' => '20',
            'footer_font' => '16',
            'footer_font_color' => '333333',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => 'FFFFFF',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => '57697a',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => '57697a',
            'footer_link_hover_color' => '57697a',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => TRUE,
        ));
        $preset->save();

        // Photocrati Wide Angle
        $preset = new Photocrati_Style_Manager(array(
            'preset_name'   =>  'preset-wideangle',
            'preset_title'  =>  'Photocrati Wide Angle',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'left-right',
            'bg_color' => '000000',
            'bg_image' => '',
            'bg_repeat' => 'repeat',
            'header_bg_color' => 'ffffff',
            'header_bg_image' => 'header-bg.jpg',
            'header_bg_repeat' => 'repeat-x',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => 'CCCCCC',
            'font_color' => 'E1E1E1',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => 'f09f8f',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => 'FFFFFF',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => 'FFFFFF',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => 'FFFFFF',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => 'FFFFFF',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => '995c53',
            'link_hover_color' => 'd46b58',
            'link_hover_style' => 'none',
            'sidebar_font_color' => 'E1E1E1',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => 'f09f8f',
            'sidebar_link_hover_color' => 'd46b58',
            'sidebar_link_hover_style' => 'none',
            'sidebar_title_color' => 'a8a8a8',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'transparent',
            'menu_color' => 'FFFFFF',
            'menu_hover_color' => 'FFFFFF',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'd4d4d4',
            'menu_font_hover_color' => 'd46b58',
            'menu_font_case' => 'uppercase',
            'submenu_color' => 'E8E8E8',
            'submenu_hover_color' => 'd46b58',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => '995c53',
            'submenu_font_hover_color' => 'ffffff',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => 'E1E1E1',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Melon.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '#footer {
border-top:0;
text-align:center;
}

h1 {
border-bottom:0px;
}

p {
margin-bottom:0.5em;
line-height:1.7em;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '11',
            'header_logo_margin_below' => '10',
            'title_color' => 'd46b58',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => '999999',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '20',
            'footer_font' => '16',
            'footer_font_color' => '333333',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => 'FFFFFF',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'd46b58',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => 'd46b58',
            'footer_link_hover_color' => 'd46b58',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => TRUE,
        ));
        $preset->save();

        // Photocrati Silver Halide
        $preset = new Photocrati_Style_Manager(array(
            'preset_name'   =>  'preset-silverhalide',
            'preset_title'  =>  'Photocrati Silver Halide',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'left-right',
            'bg_color' => 'FFFFFF',
            'bg_image' => '',
            'bg_repeat' => 'repeat',
            'header_bg_color' => '000000',
            'header_bg_image' => 'header-bg-blk.jpg',
            'header_bg_repeat' => 'repeat-x',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => 'CCCCCC',
            'font_color' => '333333',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => '786644',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => '333333',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => '333333',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => '333333',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => '333333',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => 'cbb07b',
            'link_hover_color' => 'e3cc9e',
            'link_hover_style' => 'none',
            'sidebar_font_color' => '757375',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => 'b39968',
            'sidebar_link_hover_color' => 'f0d198',
            'sidebar_link_hover_style' => 'none',
            'sidebar_title_color' => '786644',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'transparent',
            'menu_color' => '000000',
            'menu_hover_color' => '000000',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'c9ac71',
            'menu_font_hover_color' => 'd4d0d4',
            'menu_font_case' => 'uppercase',
            'submenu_color' => '333333',
            'submenu_hover_color' => '666666',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => 'cbb07b',
            'submenu_font_hover_color' => 'e3cc9e',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => 'CCCCCC',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Gold.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '#footer {
border-top:0;
text-align:center;
}

h1 {
border-bottom:0px;
}

p {
margin-bottom:0.5em;
line-height:1.7em;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '11',
            'header_logo_margin_below' => '10',
            'title_color' => 'c9ac71',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => 'b5b5b5',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '20',
            'footer_font' => '16',
            'footer_font_color' => 'F1F1F1',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => '000000',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'c9ac71',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => 'c9ac71',
            'footer_link_hover_color' => 'c9ac71',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => TRUE,
        ));
        $preset->save();

        // Photocrati Filter
        $preset = new Photocrati_Style_Manager(array(
            'preset_title'  =>  'Photocrati Filter',
            'preset_name'   =>  'preset-filter',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'left-right',
            'bg_color' => 'a5a6a1',
            'bg_image' => '',
            'bg_repeat' => 'repeat',
            'header_bg_color' => '2E2E2E',
            'header_bg_image' => '',
            'header_bg_repeat' => 'repeat-x',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => 'CCCCCC',
            'font_color' => '000000',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => '565945',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => '737851',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => '000000',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => '000000',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => '000000',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => '91995e',
            'link_hover_color' => '94a683',
            'link_hover_style' => 'none',
            'sidebar_font_color' => '424242',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => '91995e',
            'sidebar_link_hover_color' => '94a683',
            'sidebar_link_hover_style' => 'none',
            'sidebar_title_color' => 'f1ffe3',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'transparent',
            'menu_color' => '2E2E2E',
            'menu_hover_color' => '2E2E2E',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'faffe3',
            'menu_font_hover_color' => 'd4f52e',
            'menu_font_case' => 'uppercase',
            'submenu_color' => '999999',
            'submenu_hover_color' => 'C8C9CB',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => 'FFFFFF',
            'submenu_font_hover_color' => '333333',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => 'E1E1E1',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Lime.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '#footer {
border-top:0;
text-align:right;
}

h1 {
border-bottom:0px;
}

p {
margin-bottom:0.5em;
line-height:1.7em;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '15',
            'header_logo_margin_below' => '10',
            'title_color' => '91995e',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => 'CCCCCC',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '20',
            'footer_font' => '16',
            'footer_font_color' => 'FFFFFF',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => '2E2E2E',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => '91995e',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => '91995e',
            'footer_link_hover_color' => '91995e',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => TRUE,
        ));
        $preset->save();

        // Photocrati Bokeh
        $preset = new Photocrati_Style_Manager(array(
            'preset_name'   =>  'preset-bokeh',
            'preset_title'  =>  'Photocrati Bokeh',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'left-right',
            'bg_color' => '000000',
            'bg_image' => 'background_bokeh.jpg',
            'bg_repeat' => 'repeat-x',
            'header_bg_color' => 'FFFFFF',
            'header_bg_image' => 'polnlig_header_bg.gif',
            'header_bg_repeat' => 'repeat-x',
            'container_color' => 'transparent',
            'container_border' => '0',
            'container_border_color' => 'CCCCCC',
            'font_color' => 'E1E1E1',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => 'f04a16',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => 'FFFFFF',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => 'FFFFFF',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => 'FFFFFF',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => 'FFFFFF',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => 'ebdfd9',
            'link_hover_color' => 'ff8661',
            'link_hover_style' => 'underline',
            'sidebar_font_color' => 'E1E1E1',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => 'd6874e',
            'sidebar_link_hover_color' => 'f04916',
            'sidebar_link_hover_style' => 'underline',
            'sidebar_title_color' => 'FFFFFF',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'color',
            'menu_color' => '',
            'menu_hover_color' => 'f04a16',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'd6874e',
            'menu_font_hover_color' => 'FFFFFF',
            'menu_font_case' => 'uppercase',
            'submenu_color' => 'E8E8E8',
            'submenu_hover_color' => 'f04a16',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => '333333',
            'submenu_font_hover_color' => 'FFFFFF',
            'submenu_font_case' => 'none',
            'nextgen_border' => '2',
            'nextgen_border_color' => 'faf7f7',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Bokeh.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => '.menu a:link, .menu a:visited {
padding:52px 17px 29px;
}

#footer {
border-top:0;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '10',
            'header_logo_margin_below' => '10',
            'title_color' => 'd6874e',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => '999999',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '20',
            'footer_font' => '16',
            'footer_font_color' => '333333',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => 'FFFFFF',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'd6874e',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => 'd6874e',
            'footer_link_hover_color' => 'd6874e',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => TRUE,
        ));
        $preset->save();

        // Photocrati Prime
        $preset = new Photocrati_Style_Manager(array(
            'preset_title'  =>  'Photocrati Prime',
            'preset_name'   =>  'preset-prime',
            'dynamic_style' => 'YES',
            'one_column' => 'OFF',
            'one_column_color' => 'FFFFFF',
            'one_column_logo' => 'OFF',
            'one_column_margin' => '30',
            'is_sidebar_enabled' => 'YES',
            'content_width' => '65',
            'sidebar_width' => '35',
            'logo_menu_position' => 'right-left',
            'bg_color' => 'f5dddb',
            'bg_image' => 'pink_stripes.gif',
            'bg_repeat' => 'repeat',
            'header_bg_color' => 'FFFFFF',
            'header_bg_image' => 'header_fadepink.gif',
            'header_bg_repeat' => 'repeat-x',
            'container_color' => 'ffffff',
            'container_border' => '0',
            'container_border_color' => 'CCCCCC',
            'font_color' => '000000',
            'font_size' => '16',
            'font_style' => 'Open Sans',
            'p_line' => '25',
            'p_space' => '25',
            'h1_color' => 'e3628b',
            'h1_size' => '30',
            'h1_font_style' => 'Open Sans',
            'h1_font_case' => 'none',
            'h1_font_weight' => 'bold',
            'h1_font_align' => '',
            'h2_color' => 'e3628b',
            'h2_size' => '26',
            'h2_font_style' => 'Open Sans',
            'h2_font_case' => 'none',
            'h2_font_weight' => 'bold',
            'h3_color' => 'e3628b',
            'h3_size' => '24',
            'h3_font_style' => 'Open Sans',
            'h3_font_case' => 'none',
            'h3_font_weight' => 'bold',
            'h4_color' => 'e3628b',
            'h4_size' => '22',
            'h4_font_style' => 'Open Sans',
            'h4_font_case' => 'none',
            'h4_font_weight' => 'bold',
            'h5_color' => 'e3628b',
            'h5_size' => '20',
            'h5_font_style' => 'Open Sans',
            'h5_font_case' => 'none',
            'h5_font_weight' => 'bold',
            'link_color' => 'd1a1ac',
            'link_hover_color' => 'ff548d',
            'link_hover_style' => 'none',
            'sidebar_font_color' => '858085',
            'sidebar_font_size' => '16',
            'sidebar_font_style' => 'Open Sans',
            'sidebar_bg_color' => 'transparent',
            'sidebar_link_color' => 'c6869a',
            'sidebar_link_hover_color' => 'e3628b',
            'sidebar_link_hover_style' => 'none',
            'sidebar_title_color' => 'c6869a',
            'sidebar_title_size' => '14',
            'sidebar_title_style' => 'Open Sans',
            'menu_style' => 'transparent',
            'menu_color' => 'FFFFFF',
            'menu_hover_color' => 'FFFFFF',
            'menu_font_size' => '14',
            'menu_font_style' => 'Open Sans',
            'menu_font_color' => 'd1a1ac',
            'menu_font_hover_color' => 'e3628b',
            'menu_font_case' => 'uppercase',
            'submenu_color' => 'eeeadf',
            'submenu_hover_color' => 'ffffff',
            'submenu_font_size' => '12',
            'submenu_font_style' => 'Open Sans',
            'submenu_font_color' => 'c6869a',
            'submenu_font_hover_color' => 'e3628b',
            'submenu_font_case' => 'none',
            'nextgen_border' => '5',
            'nextgen_border_color' => 'e8e7e7',
            'custom_logo' => 'title',
            'custom_logo_image' => 'Logo_Pink.png',
            'footer_copy' => '',
            'custom_sidebar' => 'OFF',
            'custom_sidebar_position' => 'ABOVE',
            'custom_sidebar_html' => '',
            'social_media' => 'OFF',
            'social_media_title' => 'Follow Me',
            'social_media_set' => 'small',
            'social_rss' => '',
            'social_email' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_flickr' => '',
            'google_analytics' => '',
            'custom_css' => 'div.slideshow {
margin-bottom: 20px;
}

#primary {
padding:25px 23px;
width:79%;
}',
            'header_height' => '140',
            'header_logo_margin_above' => '10',
            'header_logo_margin_below' => '10',
            'title_color' => 'd1a1ac',
            'title_font_style' => '',
            'title_font_weight' => 'bold',
            'title_style' => 'Open Sans',
            'description_size' => '16',
            'description_color' => '999999',
            'description_style' => 'Open Sans',
            'description_font_weight'   => '',
            'description_font_style'    => '',
            'bg_top_offset' => '0',
            'container_padding' => '30',
            'footer_font' => '16',
            'footer_font_color' => '333333',
            'is_third_party' => FALSE,
            'footer_widget_placement' => '3',
            'footer_background' => 'FFFFFF',
            'footer_font_style' => 'Open Sans',
            'footer_widget_title' => '14',
            'footer_widget_color' => 'd1a1ac',
            'footer_widget_style' => 'Open Sans',
            'footer_link_color' => 'd1a1ac',
            'footer_link_hover_color' => 'd1a1ac',
            'footer_link_hover_style' => 'none',
            'footer_height' => '430',
            'show_photocrati' => '',
            'page_comments' => 'OFF',
            'blog_meta' => TRUE,
        ));
        $preset->save();

        // Import any presets bundled with the theme
        $preset_dir = get_stylesheet_directory()."/admin/presets";
        $presets = glob("{$preset_dir}/*.json");
        $presets = array_merge($presets, glob("{$preset_dir}/*.crati"));
        foreach ($presets as $filename) Photocrati_Style_Manager::import_preset($filename, FALSE);

        // Set the default preset
        $active = Photocrati_Style_Manager::get_preset(PHOTOCRATI_ACTIVE_PRESET);
        if ($active->is_new()) Photocrati_Style_Manager::set_active_preset('preset-ten-stop');
    }
}
