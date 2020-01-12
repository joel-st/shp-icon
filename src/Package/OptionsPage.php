<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Options Page
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 * @since 1.0.0
 */
class OptionsPage
{

	public $parent_slug = '';
	public $menu_slug = '';
	public $prefix = '';
	public $setting_tabs = [];
	public $current_tab = '';
	public $default_tab = '';
	public $display_settings = [];
	public $settings_group = '';

	public function __construct()
	{
		$this->parent_slug    = 'themes.php';
		$this->menu_slug    = shp_icon()->prefix;
		$this->options_prefix = shp_icon()->prefix . '-options';
		$this->default_tab = 'manage';
		$this->setting_tabs = [
			$this->default_tab => _x('Icon Collection', 'Options page tab title', 'shp-icon'),
			'settings' => _x('Settings', 'Options page tab title', 'shp-icon'),
			'help' => _x('Information & Help', 'Options page tab title', 'shp-icon'),
		];
		$this->current_tab = ( isset($_GET['tab']) ) ? $_GET['tab'] : $this->default_tab;
		$this->settings_group = shp_icon()->prefix . '-settings-group';

		$this->display_settings = [
			shp_icon()->prefix . '-display-inline-top-shift' => [
				'legend' => _x('em (default top-shift of inline icons)', 'Options page setting label', 'shp-icon'),
				'label' => _x('Inline Top Shift', 'Options page setting label', 'shp-icon'),
				'type' => 'number',
				'default' => .15
			],
			shp_icon()->prefix . '-display-inline-scale-factor' => [
				'legend' => _x('Default scale factor for inline icons related to font-size of parent element', 'Options page setting label', 'shp-icon'),
				'label' => _x('Scale Factor', 'Options page setting label', 'shp-icon'),
				'type' => 'number',
				'default' => 1
			],
		];
	}

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 1.0.0
	 */
	public function run()
	{
		add_action('admin_menu', [$this, 'registerSubmenuOptionsPage']);
		add_action('admin_init', [$this, 'registerSettings']);
	}

	/**
	 * Registers the options page to manage the plugin settings and icon collection
	 *
	 * @since 1.0.0
	 */
	public static function registerSubmenuOptionsPage()
	{
		add_submenu_page(
			$this->parent_slug,
			_x('SVG Icons', 'Plugins option page title', 'shp-icon'),
			_x('SVG Icons', 'Plugins option menu title', 'shp-icon'),
			'manage_options',
			$this->menu_slug,
			[$this, 'renderOptionsPage']
		);
	}

	/**
	 * Registers the settings and set sanitation callback by type
	 *
	 * @since 1.0.0
	 */
	public function registerSettings()
	{
		foreach ($this->display_settings as $name => $data) {
			add_option($name, $data['default']);

			$args = [
				'type' => $data['type'],
				'default' => $data['default'],
			];

			if ('boolean' == $data['type']) {
				$args['sanitize_callback'] = [$this, 'sanitizeCheckbox'];
			}

			if ('number' == $data['type']) {
				$args['sanitize_callback'] = [$this, 'sanitizeNumber'];
			}

			register_setting($this->settings_group, $name, $args);
		}
	}

	/**
	 * Main function to render the options page and tabs
	 *
	 * @since 1.0.0
	 */
	public static function renderOptionsPage()
	{
		echo '<div class="wrap wrap-shp-icon">';
		$this->renderOptionsPageHead();
		$this->renderOptionsPageTabs();

		if ('manage' == $this->current_tab) {
			$this->renderManagePage();
		} elseif ('settings' == $this->current_tab) {
			$this->renderSettingsPage();
		} elseif ('help' == $this->current_tab) {
			$this->renderHelpPage();
		}

		echo '</div>';
	}

	/**
	 * Render the options page head
	 *
	 * @since 1.0.0
	 */
	public function renderOptionsPageHead()
	{
		echo '<h1 class="wp-heading-inline">' . _x('Icons', 'Options page heading', 'shp-icon') . '</h1>';
		if ('manage' == $this->current_tab) {
			echo '<input type="button" class="page-title-action aria-button-if-js" role="button" value="'._x('Add Icons', 'Options page title action', 'shp-icon').'" onclick="document.getElementById(`'.shp_icon()->Package->Upload->upload_input_id.'`).click()" />';
			shp_icon()->Package->Upload->renderUpload();
		}
		echo '<hr class="wp-header-end">';
	}

	/**
	 * Render the options page tabs and select the current tab
	 *
	 * @since 1.0.0
	 */
	public function renderOptionsPageTabs()
	{
		echo '<nav class="nav-tab-wrapper wp-clearfix" aria-label="' . _x('Second menu', 'Options page tab-nav aria-label', 'shp-icon') . '">';
		foreach ($this->setting_tabs as $tab => $name) {
			$class = ( $tab == $this->current_tab ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=$this->menu_slug&tab=$tab'>$name</a>";
		}
		echo '</nav>';
	}

	/**
	 * Render the manage page (icon collection)
	 *
	 * @since 1.0.0
	 */
	public function renderManagePage()
	{
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
	public static function renderIconsToolbar()
	{
		echo '<div class="media-toolbar wp-filter">';

		echo '<div class="media-toolbar-secondary">';
		echo '<h2 class="media-attachments-filter-heading">' . _x('Icon Collection', 'Options page media-toolbar title', 'shp-icon') . '</h2>';
		echo '</div>';

		echo '<div class="media-toolbar-primary search-form">';
		echo '<label for="media-search-input" class="media-search-input-label">' . _x('Search by name', 'Options page media-toolbar action input label', 'shp-icon') . '</label>';
		echo '<input type="search" id="media-search-input" class="search">';
		echo '</div>';

		echo '</div>';
	}

	/**
	 * Initialise admin icon list to render icons
	 *
	 * @since 1.0.0
	 */
	public function renderIcons()
	{
		$baseClass = shp_icon()->prefix . '-list';
		$icons = shp_icon()->icons;

		echo '<ul class="'.$baseClass.'">';

		echo '<li class="'.$baseClass.'__item '.$baseClass.'__item--no-results" style="display:none;">';
		echo '<div class="'.$baseClass.'__icon">';
		echo ':(';
		echo '</div>';
		echo '<div class="'.$baseClass.'__meta">';
		echo '<b class="'.$baseClass.'__name">'._x('No results', 'Options page no results', 'shp-icon').'</b>';
		echo '</div>';
		echo '</li>';

		if (!empty($icons)) {
			foreach ($icons as $icon) {
				$this->renderIcon($icon, $baseClass);
			}
		}

		echo '</ul>';
	}

	/**
	 * Render an icon as list element of admin icon list with icon options
	 *
	 * @since 1.0.0
	 */
	public function renderIcon($icon, $baseClass)
	{

		$shortcode = '[' . shp_icon()->prefix . ' icon="' . str_replace('.svg', '', $icon) . '"]';
		$style = 'background-color:rgba('.implode(',', shp_icon()->Package->Helpers->hexToRgb(shp_icon()->Package->Helpers->getAdminColors()[2], .1)).');color:'.shp_icon()->Package->Helpers->getAdminColors()[2].';';

		echo '<li class="'.$baseClass.'__item">';

		echo '<div class="'.$baseClass.'__actions">';
		echo '<div class="'.$baseClass.'__actions-toggle"><span></span><span></span><span></span></div>';
		echo '<ul class="'.$baseClass.'__action-list">';
		//echo '<li class="'.$baseClass.'__action"><a class="'.$baseClass.'__action-rename button-link">'._x('Rename', 'Options page icon action', 'shp-icon').'</a></li>';
		echo '<li class="'.$baseClass.'__action"><a class="'.$baseClass.'__action-remove button-link button-link-delete">'._x('Delete', 'Options page icon action', 'shp-icon').'</a></li>';
		echo '</ul>';
		echo '</div>';

		echo '<div class="'.$baseClass.'__icon">';
		echo do_shortcode('['.shp_icon()->prefix.' icon="'.str_replace('.svg', '', $icon).'" block]');
		echo '</div>';
		echo '<div class="'.$baseClass.'__meta">';
		echo '<b class="'.$baseClass.'__name">'.shp_icon()->Package->Helpers->getIconNameFromFileName($icon).'</b>';
		echo '<div class="'.$baseClass.'__shortcode">';
		echo "<input onClick='this.setSelectionRange(0, this.value.length)' value='".$shortcode."' style='".$style."' />";
		echo '</div>';
		echo '</div>';
		echo '</li>';
	}

	/**
	 * Render the settings page
	 *
	 * @since 1.0.0
	 */
	public function renderSettingsPage()
	{
		echo '<form method="post" action="options.php" class="'.$this->settings_group.'">';
		settings_fields($this->settings_group);

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
		echo '<h2 id="' . shp_icon()->prefix . '-display-options" style="margin: 0;">' . _x('Display Options for Icons using the Shortcode', 'Options page settings title', 'shp-icon').'</h2>';
		echo '</th>';
		echo '<td>';
		echo '<p class="description">'._x('This options only adapts to Icons generated by the shotcode without the <code>block</code> attribute. Example <code>[shp-icon icon="heart"]</code>.<br/> This options takes no effect for Icons insertet with the Gutenberg Block.', 'Options page settings description', 'shp-icon').'</p>';
		echo '</td></tr>';

		foreach ($this->display_settings as $name => $data) {
			$this->renderSetting($name, $data);
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
	public function renderSetting($name, $data)
	{
		switch ($data['type']) {
			case 'boolean':
				echo '<tr valign="top">';
				echo '<th scope="row">';
				echo $data['label'];
				echo '</th>';
				echo '<td>';
				echo '<fieldset>';
				echo '<legend class="screen-reader-text">';
				echo '<span>'.$data['label'].'</span>';
				echo '</legend>';
				echo '<label for="'.$name.'">';
				echo '<input name="'.$name.'" type="checkbox" id="'.$name.'" '.checked(1, get_option($name), false).'> ' . $data['legend'];
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
				echo '<span>'.$data['label'].'</span>';
				echo '</legend>';
				echo '<label for="'.$name.'">';
				echo '<input name="'.$name.'" type="number" step="0.01" id="'.$name.'" value="'.get_option($name).'"> ' . $data['legend'];
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
	public function sanitizeCheckbox($value)
	{
		if ('on' == $value) {
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
	public function sanitizeNumber($value)
	{
		$value = floatval($value);
		return $value;
	}

	/**
	 * Render the help page
	 *
	 * @since 1.0.0
	 */
	public function renderHelpPage()
	{
		echo '<div class="'.shp_icon()->prefix.'-help '.shp_icon()->prefix.'-help--left">';
		echo '<h2>'.sprintf(_x('Thank you for using %1$s', 'Options page help title. %1$s = plugin name.', 'shp-icon'), shp_icon()->plugin_header['Name']).'</h2>';

		echo '<div class="accordion">';
		echo '<div class="accordion__item">';

		echo '<label for="tm">jhasljfldsajflsdajf</label>';
		echo '<input type="checkbox" id="tm" />';

		echo '<div class="accordion__content">';
		echo '<p>adsfasdfsadfasdfasdfsadfsadfasd</p>';
		echo '</div>';

		echo '</div>';
		echo '</div>';
		echo '</div>';


		echo '<div class="'.shp_icon()->prefix.'-help '.shp_icon()->prefix.'-help--right">';
		echo '<h2>'._x('Say Thank You!', 'Options page help title', 'shp-icon').'</h2>';
		echo '</div>';
	}
}
