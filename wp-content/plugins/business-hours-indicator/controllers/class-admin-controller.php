<?php

namespace MABEL_BHI_LITE\Controllers
{

	use MABEL_BHI_LITE\Core\Admin;
	use DateTimeZone;
	use MABEL_BHI_LITE\Core\Config_Manager;
	use MABEL_BHI_LITE\Core\Models\Option_Dependency;
	use MABEL_BHI_LITE\Core\Options_Manager;
	use MABEL_BHI_LITE\Core\Settings_Manager;

	if(!defined('ABSPATH')){die;}

	class Admin_Controller extends Admin
	{
		private $slug;
		public function __construct()
		{
			parent::__construct(new Options_Manager());
			$this->slug = Config_Manager::$slug;

			$this->add_script_dependencies(array('underscore'));

			$this->add_script_variable('clamp', 3);

			$this->init_admin_page();

			$this->add_ajax_function('mb-bhi-update-indicator',$this,'update_indicator',false,true);
			$this->add_ajax_function('mb-bhi-update-list',$this,'update_list',false, true);
		}

		public function update_list()
		{
			echo do_shortcode('[mbhi_hours]');
			wp_die();
		}

		public function update_indicator()
		{
			echo do_shortcode('[mbhi]');
			wp_die();
		}

		private function init_admin_page()
		{
			$this->options_manager->add_section('general', __('General',$this->slug), 'admin-tools', true);
			$this->options_manager->add_section('hours', __('Hours',$this->slug), 'clock');
			$this->options_manager->add_section('indicator', __('Indicator',$this->slug), 'arrow-down-alt');
			$this->options_manager->add_section('table', __('Table',$this->slug), 'editor-table');
			$this->options_manager->add_section('codes', __('Codes',$this->slug),'editor-code');

			$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
			$locations = Settings_Manager::get_setting('locations');

			$this->options_manager->add_dropdown_option(
				'general',
				'timezone',
				__('Time zone',$this->slug),
				array_combine($timezones,$timezones),
				Settings_Manager::get_setting('timezone')
			);

			$this->options_manager->add_dropdown_option(
				'general',
				'format',
				__('Time format',$this->slug),
				array(12 => __('12-hour format',$this->slug), 24 => __('24-hour format',$this->slug)),
				Settings_Manager::get_setting('format')
			);

			$this->options_manager->add_custom_option(
				'hours',
				__('Locations',$this->slug),
				'admin/views/locations.php',
				array('locations' => json_decode($locations))
			);

			$this->options_manager->add_text_option(
				'indicator',
				'openline',
				__('Now open message',$this->slug),
				Settings_Manager::get_translated_setting('openline'),
				null,
				__('HTML is allowed.',$this->slug)
			);

			$this->options_manager->add_text_option(
				'indicator',
				'closedline',
				__('Now closed message', $this->slug),
				Settings_Manager::get_translated_setting('closedline'),
				null,
				__('HTML is allowed.',$this->slug)
			);

			$this->options_manager->add_checkbox_option(
				'indicator',
				'includetime',
				__('Include time', $this->slug),
				__('Include the current time in the output.', $this->slug),
				Settings_Manager::get_setting('includetime')
			);

			$this->options_manager->add_checkbox_option(
				'indicator',
				'includeday',
				__('Include day', $this->slug),
				__('Include the current day in the output.'),
				Settings_Manager::get_setting('includeday')
			);

			$this->options_manager->add_checkbox_option(
				'indicator',
				'approximation',
				__('Opening/closing soon warning', $this->slug),
				__('When it\'s near opening or closing time, show a different message.', $this->slug),
				Settings_Manager::get_setting('approximation')
			);

			$this->options_manager->add_text_option(
				'indicator',
				'opensoonline',
				__('Opening soon message',$this->slug),
				Settings_Manager::get_translated_setting('opensoonline'),
				null,
				__('HTML is allowed. Use {x} to denote minutes.',$this->slug),
				new Option_Dependency('approximation','true')
			);

			$this->options_manager->add_text_option(
				'indicator',
				'closedsoonline',
				__('Closing soon message', $this->slug),
				Settings_Manager::get_translated_setting('closedsoonline'),
				null,
				__('HTML is allowed. Use {x} to denote minutes.',$this->slug),
				new Option_Dependency('approximation','true')
			);

			$this->options_manager->add_dropdown_option(
				'indicator',
				'warning',
				__('Opening soon warning', $this->slug),
				array(15 => 15, 30 => 30, 45 => 45),
				Settings_Manager::get_setting('warning'),
				null,
				new Option_Dependency('approximation', 'true'),
				__("Show 'opening soon' warning ", $this->slug),
				__('minutes in advance.', $this->slug)
			);

			$this->options_manager->add_dropdown_option(
				'indicator',
				'warningclosing',
				__('Closing soon warning', $this->slug),
				array(15 => 15, 30 => 30, 45 => 45),
				Settings_Manager::get_setting('warningclosing'),
				null,
				new Option_Dependency('approximation', 'true'),
				__("Show 'closing soon' warning ", $this->slug),
				__('minutes in advance.', $this->slug)
			);

			$this->options_manager->add_dropdown_option(
				'table',
				'tabledisplaymode',
				__('Display mode', $this->slug),
				array( 0 => __('Normal', $this->slug) , 1 => __('Consolidated', $this->slug) ),
				Settings_Manager::get_setting('tabledisplaymode')
			);

			$this->options_manager->add_dropdown_option(
				'table',
				'output',
				__('Output', $this->slug),
				array( 1 => __('Table',$this->slug) , 2 => __('Inline',$this->slug) ),
				Settings_Manager::get_setting('output')
			);

			$this->options_manager->add_checkbox_option(
				'table',
				'includespecialdates',
				__('Include holidays', $this->slug),
				__('Add holidays to the hours table.', $this->slug),
				Settings_Manager::get_setting('includespecialdates')
			);

			$this->options_manager->add_checkbox_option(
				'table',
				'includevacations',
				__('Include vacations', $this->slug),
				__('Add vacations to the hours table.', $this->slug),
				Settings_Manager::get_setting('includevacations')
			);

			$this->loader->add_action(Config_Manager::$slug . '-add-section-content-codes',$this,'codes_content');

			$this->loader->add_action(Config_Manager::$slug . '-add-content', $this , 'underscore_templates');

			$this->loader->add_action(Config_Manager::$slug . '-render-sidebar', $this,'render_main_sidebar');

			$this->loader->add_action(Config_Manager::$slug . '-render-sidebar-indicator', $this,'render_indicator_sidebar');

			$this->loader->add_action(Config_Manager::$slug . '-render-sidebar-table', $this,'render_list_sidebar');

		}

		public function render_list_sidebar()
		{
			include Config_Manager::$dir . 'admin/views/sidebar-list.php';
		}

		public function render_indicator_sidebar()
		{
			include Config_Manager::$dir . 'admin/views/sidebar-indicator.php';
		}

		public function render_main_sidebar()
		{
			include Config_Manager::$dir . 'admin/views/sidebar-main.php';
		}

		public function indicator_section()
		{
			include Config_Manager::$dir . 'admin/views/indicator-section.php';
		}

		public function underscore_templates()
		{
			include Config_Manager::$dir . 'admin/views/underscore-templates.php';
		}

		public function codes_content()
		{
			include Config_Manager::$dir . 'admin/views/codes.php';
		}

	}
}