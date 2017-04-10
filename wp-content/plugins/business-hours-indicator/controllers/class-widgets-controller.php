<?php

namespace MABEL_BHI_LITE\Controllers {

	use MABEL_BHI_LITE\Core\Config_Manager;
	use MABEL_BHI_LITE\Core\Registry;
	use MABEL_BHI_LITE\Core\Settings_Manager;
	use MABEL_BHI_LITE\Core\Widget;
	use MABEL_BHI_LITE\Core\Widget_Options_Manager;

	if ( ! defined( 'ABSPATH' ) ) {
		die;
	}

	class Widgets_Controller
	{
		private $location_names;

		public function __construct()
		{
			$locations = json_decode(Settings_Manager::get_setting('locations'), true);

			if($locations == null) $locations = array();

			$this->location_names = array();

			if(is_array($locations)) {
				foreach ($locations as $location) {
					array_push($this->location_names, $location['Name']);
				}
			}

			Registry::get_loader()->add_action('widgets_init', $this, 'register_list_widget');
			Registry::get_loader()->add_action('widgets_init', $this, 'register_indicator_widget');
		}

		public function register_indicator_widget()
		{
			$option_manager = new Widget_Options_Manager();

			if(sizeof($this->location_names))
			{
				$option_manager->add_text_option(
					'title',
					__( 'Title', Config_Manager::$slug ),
					null
				);

				$option_manager->add_dropdown_option(
					'location',
					__( 'Location', Config_Manager::$slug ),
					array_combine( $this->location_names, $this->location_names )
				);
			}

			$widget = new Widget(
				'mbhi_indicator_widget',
				__('[BHI] opening hours indicator', Config_Manager::$slug),
				__('Show whether you are currently open or closed.', Config_Manager::$slug),
				'mbhi',
				$option_manager
			);

			if(sizeof($this->location_names) === 0)
				$widget->warning = __( "No location found. Go to Settings > Business Hours Indicator to set up locations.",
					Config_Manager::$slug );

			register_widget($widget);
		}

		public function register_list_widget()
		{

			$option_manager = new Widget_Options_Manager();

			if(sizeof($this->location_names))
			{
				$option_manager->add_text_option(
					'title',
					__( 'Title', Config_Manager::$slug ),
					null
				);

				$option_manager->add_dropdown_option(
					'location',
					__( 'Location', Config_Manager::$slug ),
					array_combine( $this->location_names, $this->location_names )
				);
			}

			$widget = new Widget(
				'mbhi_list_widget',
				__('[BHI] opening hours overview', Config_Manager::$slug),
				__('Show the list of opening times for a location.', Config_Manager::$slug),
				'mbhi_hours',
				$option_manager
			);

			if(sizeof($this->location_names) === 0)
				$widget->warning = __( "No location found. Go to Settings > Business Hours Indicator to set up locations.",
					Config_Manager::$slug );

			register_widget($widget);
		}
	}
}