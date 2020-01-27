<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Options Page
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 * @since 1.0.0
 */
class OptionsPage {

	public $parent_slug      = '';
	public $menu_slug        = '';
	public $prefix           = '';
	public $setting_tabs     = array();
	public $current_tab      = '';
	public $default_tab      = '';
	public $display_settings = array();
	public $settings_group   = '';

	public function __construct() {
		$this->parent_slug    = 'themes.php';
		$this->menu_slug      = shp_icon()->prefix;
		$this->options_prefix = shp_icon()->prefix . '-options';
		$this->default_tab    = 'manage';
		$this->setting_tabs   = array(
			$this->default_tab => _x( 'Icon Collection', 'Options page tab title', 'shp-icon' ),
			'settings'         => _x( 'Settings', 'Options page tab title', 'shp-icon' ),
			'help'             => _x( 'Information & Help', 'Options page tab title', 'shp-icon' ),
		);
		$this->current_tab    = ( isset( $_GET['tab'] ) && sanitize_text_field( $_GET['tab'] ) ) ? $_GET['tab'] : $this->default_tab;
		$this->settings_group = shp_icon()->prefix . '-settings-group';

		$this->display_settings = array(
			shp_icon()->prefix . '-display-inline-top-shift' => array(
				'legend'  => _x( 'em (default top shift of inline icons).', 'Options page setting label', 'shp-icon' ),
				'label'   => _x( 'Top Shift', 'Options page setting label', 'shp-icon' ),
				'type'    => 'number',
				'default' => .15,
			),
			shp_icon()->prefix . '-display-inline-scale-factor' => array(
				'legend'  => _x( 'Default scale factor for inline icons related to font-size of parent element.', 'Options page setting label', 'shp-icon' ),
				'label'   => _x( 'Scale Factor', 'Options page setting label', 'shp-icon' ),
				'type'    => 'number',
				'default' => 1,
			),
		);
	}

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		add_action( 'admin_menu', array( $this, 'registerSubmenuOptionsPage' ) );
		add_action( 'admin_init', array( $this, 'registerSettings' ) );
	}

	/**
	 * Registers the options page to manage the plugin settings and icon collection
	 *
	 * @since 1.0.0
	 */
	public static function registerSubmenuOptionsPage() {
		add_submenu_page(
			$this->parent_slug,
			_x( 'SVG Icons', 'Plugins option page title', 'shp-icon' ),
			_x( 'SVG Icons', 'Plugins option menu title', 'shp-icon' ),
			'manage_options',
			$this->menu_slug,
			array( $this, 'renderOptionsPage' )
		);
	}

	/**
	 * Registers the settings and set sanitation callback by type
	 *
	 * @since 1.0.0
	 */
	public function registerSettings() {
		foreach ( $this->display_settings as $name => $data ) {
			add_option( $name, $data['default'] );

			$args = array(
				'type'    => $data['type'],
				'default' => $data['default'],
			);

			if ( 'boolean' === $data['type'] ) {
				$args['sanitize_callback'] = array( $this, 'sanitizeCheckbox' );
			}

			if ( 'number' === $data['type'] ) {
				$args['sanitize_callback'] = array( $this, 'sanitizeNumber' );
			}

			register_setting( $this->settings_group, $name, $args );
		}
	}

	/**
	 * Main function to render the options page and tabs
	 *
	 * @since 1.0.0
	 */
	public static function renderOptionsPage() {
		echo '<div class="wrap wrap-shp-icon">';
		$this->renderOptionsPageHead();
		$this->renderOptionsPageTabs();

		if ( 'manage' === $this->current_tab ) {
			$this->renderManagePage();
		} elseif ( 'settings' === $this->current_tab ) {
			$this->renderSettingsPage();
		} elseif ( 'help' === $this->current_tab ) {
			$this->renderHelpPage();
		}

		echo '</div>';
	}

	/**
	 * Render the options page head
	 *
	 * @since 1.0.0
	 */
	public function renderOptionsPageHead() {
		echo '<h1 class="wp-heading-inline">' . _x( 'Icons', 'Options page heading', 'shp-icon' ) . '</h1>';
		if ( 'manage' === $this->current_tab ) {
			echo '<input type="button" class="page-title-action aria-button-if-js" role="button" value="' . _x( 'Add Icons', 'Options page title action', 'shp-icon' ) . '" onclick="' . esc_js( 'document.getElementById(`' . shp_icon()->Package->Upload->upload_input_id . '`).click()' ) . '" />';
			shp_icon()->Package->Upload->renderUpload();
		}
		echo '<hr class="wp-header-end">';
	}

	/**
	 * Render the options page tabs and select the current tab
	 *
	 * @since 1.0.0
	 */
	public function renderOptionsPageTabs() {
		echo '<nav class="nav-tab-wrapper wp-clearfix" aria-label="' . _x( 'Second menu', 'Options page tab-nav aria-label', 'shp-icon' ) . '">';
		foreach ( $this->setting_tabs as $tab => $name ) {
			$class = ( $tab === $this->current_tab ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=$this->menu_slug&tab=$tab'>$name</a>";
		}
		echo '</nav>';
	}

	/**
	 * Render the manage page (icon collection)
	 *
	 * @since 1.0.0
	 */
	public function renderManagePage() {
		echo '<div class="media-frame wp-core-ui mode-grid mode-edit hide-menu">';
		$this->renderIconsToolbar();
		$this->renderIcons();
		echo '</div>';
	}

	/**
	 * Render the manage page toolbar to search icons
	 *
	 * @since 1.0.0
	 */
	public static function renderIconsToolbar() {
		echo '<div class="media-toolbar wp-filter">';

		echo '<div class="media-toolbar-secondary">';
		echo '<h2 class="media-attachments-filter-heading">' . _x( 'Icon Collection', 'Options page media-toolbar title', 'shp-icon' ) . '</h2>';
		echo '</div>';

		echo '<div class="media-toolbar-primary search-form">';
		echo '<label for="media-search-input" class="media-search-input-label">' . _x( 'Search by name', 'Options page media-toolbar action input label', 'shp-icon' ) . '</label>';
		echo '<input type="search" id="media-search-input" class="search">';
		echo '</div>';

		echo '</div>';
	}

	/**
	 * Initialise admin icon list to render icons
	 *
	 * @since 1.0.0
	 */
	public function renderIcons() {
		$base_class = shp_icon()->prefix . '-list';
		$icons      = shp_icon()->icons;

		echo '<ul class="' . $base_class . '">';

		echo '<li class="' . $base_class . '__item ' . $base_class . '__item--no-results" style="display:none;">';
		echo '<div class="' . $base_class . '__icon">';
		echo ':(';
		echo '</div>';
		echo '<div class="' . $base_class . '__meta">';
		echo '<b class="' . $base_class . '__name">' . _x( 'No results', 'Options page no results', 'shp-icon' ) . '</b>';
		echo '</div>';
		echo '</li>';

		if ( ! empty( $icons ) ) {
			foreach ( $icons as $icon ) {
				$this->renderIcon( $icon, $base_class );
			}
		}

		echo '</ul>';
	}

	/**
	 * Render an icon as list element of admin icon list with icon options
	 *
	 * @since 1.0.0
	 */
	public function renderIcon( $icon, $base_class ) {

		$shortcode = '[' . shp_icon()->prefix . ' icon="' . str_replace( '.svg', '', $icon ) . '"]';
		$style     = 'background-color:rgba(' . implode( ',', shp_icon()->Package->Helpers->hexToRgb( shp_icon()->Package->Helpers->getAdminColors()[2], .1 ) ) . ');color:' . shp_icon()->Package->Helpers->getAdminColors()[2] . ';';

		echo '<li class="' . $base_class . '__item">';

		echo '<div class="' . $base_class . '__actions">';
		echo '<div class="' . $base_class . '__actions-toggle"><span></span><span></span><span></span></div>';
		echo '<ul class="' . $base_class . '__action-list">';
		//echo '<li class="'.$base_class.'__action"><a class="'.$base_class.'__action-rename button-link">'._x('Rename', 'Options page icon action', 'shp-icon').'</a></li>';
		echo '<li class="' . $base_class . '__action"><a class="' . $base_class . '__action-remove button-link button-link-delete">' . _x( 'Delete', 'Options page icon action', 'shp-icon' ) . '</a></li>';
		echo '</ul>';
		echo '</div>';

		echo '<div class="' . $base_class . '__icon">';
		echo do_shortcode( '[' . shp_icon()->prefix . ' icon="' . str_replace( '.svg', '', $icon ) . '" block]' );
		echo '</div>';
		echo '<div class="' . $base_class . '__meta">';
		echo '<b class="' . $base_class . '__name">' . shp_icon()->Package->Helpers->getIconNameFromFileName( $icon ) . '</b>';
		echo '<div class="' . $base_class . '__shortcode">';
		echo "<input onClick='" . esc_js( 'this.setSelectionRange(0, this.value.length)' ) . "' value='" . $shortcode . "' style='" . $style . "' />";
		echo '</div>';
		echo '</div>';
		echo '</li>';
	}

	/**
	 * Render the settings page
	 *
	 * @since 1.0.0
	 */
	public function renderSettingsPage() {
		echo '<form method="post" action="options.php" class="' . $this->settings_group . '">';
		settings_fields( $this->settings_group );

		echo '<table class="form-table" role="presentation">';

		// echo '<tr valign="top"><th>';
		// echo '<h2 id="' . shp_icon()->prefix . '-upload-options" style="margin: 0;">'._x('Upload Options', 'Options page settings title', 'shp-icon').'</h2>';
		// echo '</th>';
		// echo '<td>';
		// echo '<p class="description">'._x('Choose what should be removed while uploading SVG-Icons.', 'Options page settings description', 'shp-icon').'</p>';
		// echo '</td></tr>';
		//
		// foreach ($this->upload_settings as $name => $data) {
		// 	$this->renderSetting($name, $data);
		// }

		echo '<tr valign="top"><th>';
		echo '<h2 id="' . shp_icon()->prefix . '-display-options" style="margin: 0;">' . _x( 'Display Options for inline icons', 'Options page settings title', 'shp-icon' ) . '</h2>';
		echo '</th>';
		echo '<td>';
		echo '<p class="description">' . _x( 'This options only adapts to inline icons without the <code>block</code> attribute. Example <code>[shp-icon icon="heart"]</code>.<br/> This options takes no effect for icons insertet with the Gutenberg block.', 'Options page settings description', 'shp-icon' ) . '</p>';
		echo '</td></tr>';

		foreach ( $this->display_settings as $name => $data ) {
			$this->renderSetting( $name, $data );
		}

		echo '</table>';

		submit_button();
		echo '</form>';
	}

	/**
	 * Render the input element for a setting
	 *
	 * @since 1.0.0
	 */
	public function renderSetting( $name, $data ) {
		switch ( $data['type'] ) {
			case 'boolean':
				echo '<tr valign="top">';
				echo '<th scope="row">';
				echo $data['label'];
				echo '</th>';
				echo '<td>';
				echo '<fieldset>';
				echo '<legend class="screen-reader-text">';
				echo '<span>' . $data['label'] . '</span>';
				echo '</legend>';
				echo '<label for="' . $name . '">';
				echo '<input name="' . $name . '" type="checkbox" id="' . $name . '" ' . checked( 1, get_option( $name ), false ) . '> ' . $data['legend'];
				echo '</label>';
				echo '</fieldset>';
				echo '</td>';
				echo '</tr>';
				break;
			case 'number':
				echo '<tr valign="top">';
				echo '<th scope="row">';
				echo $data['label'];
				echo '</th>';
				echo '<td>';
				echo '<legend class="screen-reader-text">';
				echo '<span>' . $data['label'] . '</span>';
				echo '</legend>';
				echo '<label for="' . $name . '">';
				echo '<input name="' . $name . '" type="number" step="0.01" id="' . $name . '" value="' . get_option( $name ) . '"> ' . $data['legend'];
				echo '</label>';
				echo '</td>';
				echo '</tr>';
				break;
		}
	}

	/**
	 * Sanitize checkbox value
	 *
	 * @param string $value the checkbox state (on/off)
	 * @return number returns 1 for 'on' and 0 for 'off'
	 * @since 1.0.0
	 */
	public function sanitizeCheckbox( $value ) {
		if ( 'on' === $value ) {
			$value = 1;
		} else {
			$value = 0;
		}

		return $value;
	}

	/**
	 * Sanitize number value
	 *
	 * @param string $value the value submitted by an input[type="number"]
	 * @return number returns a number
	 * @since 1.0.0
	 */
	public function sanitizeNumber( $value ) {
		$value = floatval( $value );
		return $value;
	}

	/**
	 * Render the help page
	 *
	 * @since 1.0.0
	 */
	public function renderHelpPage() {
		echo '<div class="' . shp_icon()->prefix . '-help ' . shp_icon()->prefix . '-help--left">';
		echo '<h2>' . sprintf( _x( 'Thank you for using %1$s', 'Options page help title. %1$s = plugin name.', 'shp-icon' ), shp_icon()->plugin_header['Name'] ) . '</h2>';

		// introduction
		echo '<p>';
		echo _x( 'Feel free to upload any SVG file to the plugin. To use SVG’s on websites is always a pain. But hey – good news – this plugin tries to support a proper use of SVG icons on your website. Any SVG uploaded to the plugin can be used with a shortcode or with a Gutenberg block.', 'Options page help introduction', 'shp-icon' );
		echo '</p>';
		echo '<br/>';
		echo '<hr/>';

		// how to use the icons
		echo '<h3 id="how-to-use-the-shortcode">';

		//  how to use the icons as shortcode
		echo _x( 'Use Icons as a Shortcode', 'Options page help how to use title', 'shp-icon' );
		echo '</h3>';
		echo '<p>';
		echo _x( 'It is best to use the shortcode in text elements. The icon will adapt to the font size to give an excellent combination.', 'Options page help use as shortcode', 'shp-icon' );
		echo '</p>';
		$style = 'background-color:rgba(' . implode( ',', shp_icon()->Package->Helpers->hexToRgb( shp_icon()->Package->Helpers->getAdminColors()[2], .1 ) ) . ');color:' . shp_icon()->Package->Helpers->getAdminColors()[2] . ';';
		echo '<code style="' . $style . '">[' . shp_icon()->prefix . ' icon="IconName"]</code>';
		echo '<br/>';

		// how to use the icons shortcode options
		echo '<h4>';
		echo _x( 'Shortcode Options', 'Options page help use as shortcode', 'shp-icon' );
		echo '</h4>';

		echo '<table class="form-table" role="presentation">';

		echo '<tr valign="top">';
		echo '<th scope="row">';
		echo '<code style="' . $style . '">icon=""</code>';
		echo '</th>';
		echo '<td>';
		echo sprintf( _x( '%1$s. Use the <i>icon</i> attribute to define which icon to display. You will find the icon name in your %2$s.', 'Options page help use as shortcode', 'shp-icon' ), '<b style="color:red;">' . _x( 'Required', 'Options page help use as shortcode', 'shp-icon' ) . '</b>', '<a href="' . admin_url( 'themes.php?page=' . shp_icon()->prefix . '&tab=manage' ) . '">' . _x( 'icon collection', 'Options page help use as shortcode' ) . '</a>' );
		echo '</td>';
		echo '</tr>';

		echo '<tr valign="top">';
		echo '<th scope="row">';
		echo '<code style="' . $style . '">block</code>';
		echo '</th>';
		echo '<td>';
		echo _x( 'Use the <i>block</i> attribute to let a shortcode icon act like a block icon.', 'Options page help use as shortcode', 'shp-icon' ) . '</p>';
		echo '</td>';
		echo '</tr>';

		echo '<tr valign="top">';
		echo '<th scope="row">';
		echo '<code style="' . $style . '">top-shift=""</code>';
		echo '</th>';
		echo '<td>';
		echo sprintf( _x( 'Use the <i>top-shift</i> attribute to fine tune the vertical align of an inline icon. This is useful if the visual align of an inline icon isn’t perfect. Set the attribute to a number, the number uses then the <i>em</i> unit. You can also set a default top shift for all inline icons under the %s.', 'Options page help use as shortcode', 'shp-icon' ), '<a href="' . admin_url( 'themes.php?page=' . shp_icon()->prefix . '&tab=settings' ) . '">' . _x( 'settings tab', 'Options page help use as shortcode' ) . '</a>' );
		echo '</td>';
		echo '</tr>';

		echo '<tr valign="top">';
		echo '<th scope="row">';
		echo '<code style="' . $style . '">scale-factor=""</code>';
		echo '</th>';
		echo '<td>';
		echo sprintf( _x( 'Use the <i>scale-factor</i> attribute to fine tune the rendered size of an inline icon. Set the attribute to a number, the number uses then the <i>em</i> unit. You can also set a default scale factor for all inline icons under the %s.', 'Options page help use as shortcode', 'shp-icon' ), '<a href="' . admin_url( 'themes.php?page=' . shp_icon()->prefix . '&tab=settings' ) . '">' . _x( 'settings tab', 'Options page help use as shortcode' ) . '</a>' );
		echo '</td>';
		echo '</tr>';

		echo '<tr valign="top">';
		echo '<th scope="row">';
		echo '<code style="' . $style . '">color=""</code>';
		echo '</th>';
		echo '<td>';
		echo sprintf( _x( 'Use the <i>color</i> attribute to colorize an icon. The coloration only works, if your SVG is using %s.', 'Options page help use as shortcode', 'shp-icon' ), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/color_value#currentColor" target="_blank">' . _x( 'fill="currentColor"', 'Options page help use as shortcode' ) . '</a>' );
		echo '</td>';
		echo '</tr>';

		echo '<tr valign="top">';
		echo '<th scope="row">';
		echo '<code style="' . $style . '">background-color=""</code>';
		echo '</th>';
		echo '<td>';
		echo _x( 'Use the <i>background-color</i> attribute to colorize the icons parent background. Should work everywhere.', 'Options page help use as shortcode', 'shp-icon' );
		echo '</td>';
		echo '</tr>';

		echo '</table>';
		echo '<br/>';
		echo '<br/>';
		echo '<hr/>';

		// how to use the icons as block
		echo '<h3 id="how-to-use-the-block">';
		echo _x( 'Use Icons as a Gutenberg Block', 'Options page help how to use title', 'shp-icon' );
		echo '</h3>';
		echo '<p>';
		echo _x( 'Icons inserted with the Gutenberg block will fill the available space. Find the block in the Gutenberg editor in the <b>common</b> section as <b>SVG Icon</b>.', 'Options page help use as Gutenberg block', 'shp-icon' );
		echo '</p>';
		echo '<br/>';
		echo '<hr/>';

		// faq
		echo '<h3 id="how-to-use-the-block">';
		echo _x( 'FAQ', 'Options page help FAQ', 'shp-icon' );
		echo '</h3>';

		echo '<div class="accordion">';

		echo '<div class="accordion__item">';
		echo '<h4><label class="accordion__item-head" for="optimize-svg"><b>' . _x( 'What can I do to optimize my SVG’s before uploading to the plugin?', 'Options page help FAQ', 'shp-icon' ) . '</b></label></h4>';
		echo '<input type="checkbox" class="accordion__item-checkbox" id="optimize-svg" />';
		echo '<span class="accordion__item-state-indicator"></span>';
		echo '<div class="accordion__content">';
		echo '<p><b>' . _x( 'SVGO is sick! Props to all the developers of SVGO!', 'Options page help FAQ answer', 'shp-icon' ) . '</b></p>';
		echo '<p>' . sprintf(
			_x( 'According to SVGO, SVG files, especially those exported from various editors, usually contain a lot of redundant and useless information. This can include editor metadata, comments, hidden elements, default or non-optimal values and other stuff that can be safely removed or converted without affecting the SVG rendering result. To do so you can use the %s which perfectly optimises your SVG’s. ', 'Options page help FAQ answer', 'shp-icon' ),
			'<a target="_blank" href="https://github.com/svg/svgo">' . _x( 'SVGO (SVG Optimizer)', 'Options page help FAQ answer', 'shp-icon' ) . '</a>'
		) . '</p>';
		echo '<ul>';
		echo '<li>';
		echo sprintf( _x( 'Use SVGO as a web app – %s', 'Options page help FAQ answer', 'shp-icon' ), '<a target="_blank" href="https://jakearchibald.github.io/svgomg/">' . _x( 'SVGOMG', 'Options page help FAQ answer', 'shp-icon' ) . '</a>' );
		echo '</li>';
		echo '<li>';
		echo sprintf( _x( 'Use SVGO as a Sketch plugin – %s', 'Options page help FAQ answer', 'shp-icon' ), '<a target="_blank" href="https://github.com/BohemianCoding/svgo-compressor">' . _x( 'svgo-compressor', 'Options page help FAQ answer', 'shp-icon' ) . '</a>' );
		echo '</li>';
		echo '<li>';
		echo sprintf( _x( 'Use SVGO as macOS app – %s', 'Options page help FAQ answer', 'shp-icon' ), '<a target="_blank" href="https://image-shrinker.com/">' . _x( 'Image Shrinker', 'Options page help FAQ answer', 'shp-icon' ) . '</a>' );
		echo '</li>';
		echo '<li>';
		echo sprintf( _x( 'Use SVGO as an OSX Folder Action – %s', 'Options page help FAQ answer', 'shp-icon' ), '<a target="_blank" href="https://github.com/svg/svgo-osx-folder-action">' . _x( 'svgo-osx-folder-action', 'Options page help FAQ answer', 'shp-icon' ) . '</a>' );
		echo '</li>';
		echo '</ul>';
		echo '<p><b>' . _x( 'Further you can read the following articles to optimize your SVG’s manually.', 'Options page help FAQ answer', 'shp-icon' ) . '</b></p>';
		echo '<ul>';
		echo '<li>';
		echo '<a target="_blank" href="https://vecta.io/blog/guide-to-getting-sharp-and-crisp-svg-images">' . _x( 'A Guide to Getting Sharp and Crisp SVG Images on Screen.', 'Options page help FAQ answer', 'shp-icon' ) . '</a>';
		echo '</li>';
		echo '<li>';
		echo '<a target="_blank" href="https://blog.ginetta.net/i-set-out-to-create-pixel-perfect-icons-heres-what-i-discovered-along-the-way-4e46378932df">' . _x( 'I set out to create pixel perfect icons. Here’s what I discovered along the way.', 'Options page help FAQ answer', 'shp-icon' ) . '</a>';
		echo '</li>';
		echo '</ul>';
		echo '</div>';
		echo '</div>'; // .accordion__item

		echo '<div class="accordion__item">';
		echo '<h4><label class="accordion__item-head" for="file-changes"><b>' . _x( 'Is there any change on my files trough the upload?', 'Options page help FAQ', 'shp-icon' ) . '</b></label></h4>';
		echo '<input type="checkbox" class="accordion__item-checkbox" id="file-changes" />';
		echo '<span class="accordion__item-state-indicator"></span>';
		echo '<div class="accordion__content">';
		echo '<p>' . sprintf(
			_x( 'While uploading an SVG, it will be sanitised by %s and renamed based on the filename. Other changes to the SVG won’t happen.', 'Options page help FAQ answer', 'shp-icon' ),
			'<a target="_blank" href="https://github.com/darylldoyle/svg-sanitizer">' . _x( 'a PHP SVG/XML Sanitizer', 'Options page help FAQ answer', 'shp-icon' ) . '</a>'
		) . '</p>';
		echo '</div>';
		echo '</div>'; // .accordion__item

		echo '<div class="accordion__item">';
		echo '<h4><label class="accordion__item-head" for="where-to-use-the-shortcode"><b>' . _x( 'Where can I use the shortcode?', 'Options page help FAQ', 'shp-icon' ) . '</b></label></h4>';
		echo '<input type="checkbox" class="accordion__item-checkbox" id="where-to-use-the-shortcode" />';
		echo '<span class="accordion__item-state-indicator"></span>';
		echo '<div class="accordion__content">';
		echo '<p>' . sprintf(
			_x( 'The shortcode works within the content section (editor). By default there is no additional shortcode support. You can add shortcode support via WordPress %1$s or do the shortcode directly in your template files with %2$s. Read the following article for further information.', 'Options page help FAQ answer', 'shp-icon' ),
			'<a target="_blank" href="https://developer.wordpress.org/reference/functions/add_filter/"><code>add_filter()</code></a>',
			'<a target="_blank" href="https://developer.wordpress.org/reference/functions/do_shortcode/"><code>do_shortcode()</code></a>'
		) . '</p>';
		echo '<ul>';
		echo '<li>';
		echo '<a target="_blank" href="http://stephanieleary.com/2010/02/using-shortcodes-everywhere/">' . _x( 'Using Shortcodes everywhere.', 'Options page help FAQ answer', 'shp-icon' ) . '</a>';
		echo '</li>';
		echo '</ul>';
		echo '</div>';
		echo '</div>'; // .accordion__item

		echo '<div class="accordion__item">';
		echo '<h4><label class="accordion__item-head" for="ie-support"><b>' . _x( 'SVG support for Internet Explorer?', 'Options page help FAQ', 'shp-icon' ) . '</b></label></h4>';
		echo '<input type="checkbox" class="accordion__item-checkbox" id="ie-support" />';
		echo '<span class="accordion__item-state-indicator"></span>';
		echo '<div class="accordion__content">';
		echo '<p>' . _x( 'Yes there is a small script watching out for Internet Explorer users to fix a few problems with IE11. If you discover any problems displaying your icons in other browsers too, submit the issue in the plugin repository!', 'Options page help FAQ answer', 'shp-icon' ) . '</p>';
		echo '</div>';
		echo '</div>'; // .accordion__item

		echo '<div class="accordion__item">';
		echo '<h4><label class="accordion__item-head" for="migrate"><b>' . _x( 'What do I have to consider when migrating the website?', 'Options page help FAQ', 'shp-icon' ) . '</b></label></h4>';
		echo '<input type="checkbox" class="accordion__item-checkbox" id="migrate" />';
		echo '<span class="accordion__item-state-indicator"></span>';
		echo '<div class="accordion__content">';
		echo '<p>' . sprintf( _x( 'The uploaded SVG’s are saved in <code>/wp-content/uploads/%s</code>. Migrate this folder too to keep the your icons working.', 'Options page help FAQ answer', 'shp-icon' ), shp_icon()->prefix ) . '</p>';
		echo '</div>';
		echo '</div>'; // .accordion__item

		echo '</div>'; // .accordion
		echo '</div>'; // .help--left

		echo '<div class="' . shp_icon()->prefix . '-help ' . shp_icon()->prefix . '-help--right">';
		echo '<h3>' . _x( 'That’s it, peace.', 'Options page help title', 'shp-icon' ) . '</h3>';
		echo '<p>' . sprintf( _x( 'Contribute or get help: %s', 'Options page help', 'shp-icon' ), '<a target="_blank" href="' . shp_icon()->plugin_header['PluginURI'] . '">' . _x( 'Plugin Repository', 'Options page help FAQ answer', 'shp-icon' ) . '</a>' ) . '</p>';
		echo '<p>' . sprintf( _x( 'Report issues: %s', 'Options page help', 'shp-icon' ), '<a target="_blank" href="' . shp_icon()->plugin_header['PluginURI'] . '/issues">' . _x( 'Plugin Repository', 'Options page help FAQ answer', 'shp-icon' ) . '</a>' ) . '</p>';
		echo '<h3>' . _x( 'Say Thank You With A Donation', 'Options page help title', 'shp-icon' ) . '</h3>';
		echo '<p><a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CM27FZ8UYJCGJ&source=url">Paypal</a></p>';
		echo '<p><a target="_blank" href="https://commerce.coinbase.com/checkout/99bafc19-737b-4b16-aaec-962f81a17a5d">Cryptos</a></p>';
		echo '</div>';
	}
}
