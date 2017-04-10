<?php


namespace MABEL_BHI_LITE\Services
{

	use MABEL_BHI_LITE\Models\Location;
	use MABEL_BHI_LITE\Models\Opening_Hours;
	use MABEL_BHI_LITE\Models\Opening_Hours_Set;
	use MABEL_BHI_LITE\Models\Special_Date;
	use MABEL_BHI_LITE\Models\Vacation;

	if(!defined('ABSPATH')){die;}

	class Conversion_Service
	{

		private static function raw_hour_to_opening_hours($hour, $dayname)
		{
			$start_time = DateTime_Service::getInstance()->convertToDateInWeek($hour->From.' '.$hour->FromIndication,$dayname);
			$end_time = DateTime_Service::getInstance()->convertToDateInWeek($hour->To .' '.$hour->ToIndication,$dayname);
			$after_midnight = false;

			if($end_time < $start_time){
				$end_time = DateTime_Service::getInstance()->addDays($end_time,1);
				$after_midnight = true;
			}

		    $hours = new Opening_Hours($start_time,$end_time);
			$hours->after_midnight = $after_midnight;

			return $hours;
		}

		public static function convert_to_location($raw,$location_name = null)
		{
			$raw_json = json_decode($raw);

			if($raw_json == null) return null;

			if($location_name === null && sizeof($raw_json) > 0){
				return self::create_location($raw_json[0]);
			}

			foreach($raw_json as $raw_location){
				if($raw_location->Name != $location_name) continue;

				return self::create_location($raw_location);
			}

			return null;
		}

		private static function create_location($raw_location)
		{
			$location = new Location($raw_location->Name);

			foreach($raw_location->Days as $day){

				$dayname = $day->Day;
				$short = DateTime_Service::getInstance()->getShortDOWFromDay($dayname);

				$week_day_int = DateTime_Service::getInstance()->getDayOfWeekAsInt($dayname);

				$set = new Opening_Hours_Set($week_day_int,$dayname, $short);

				$set->is_today =DateTime_Service::getInstance()->getToday() === $week_day_int;

				foreach($day->Hours as $hour){
					if($hour->From == 0 || $hour->To == 0) continue;

					array_push($set->opening_hours, Conversion_Service::raw_hour_to_opening_hours($hour, $dayname));
				}
				array_push($location->opening_hours,$set);
			}

			foreach($raw_location->Holidays as $raw_holiday){

				$date = DateTime_Service::getInstance()->dayMonthToDate($raw_holiday->Day, $raw_holiday->Month);
				$holiday = new Special_Date($date);
				$holiday->is_today = DateTime_Service::getInstance()->getNow()->diff($date)->days === 0;
				foreach($raw_holiday->Hours as $hour) {
					if($hour->From == 0 || $hour->To == 0) continue;

					array_push( $holiday->opening_hours, new Opening_Hours(
						DateTime_Service::getInstance()->toDateTime( $raw_holiday->Day, $raw_holiday->Month, $hour->From, $hour->FromIndication ),
						DateTime_Service::getInstance()->toDateTime( $raw_holiday->Day, $raw_holiday->Month, $hour->To, $hour->ToIndication )
					) );

				}

				array_push($location->specials,$holiday);

			}

			foreach($raw_location->Vacations as $raw_vacation){

				$from_date = DateTime_Service::getInstance()->dayMonthToDate($raw_vacation->FromDay, $raw_vacation->From);
				$to_date = DateTime_Service::getInstance()->dayMonthToDate($raw_vacation->ToDay, $raw_vacation->To);
				$vacation = new Vacation($from_date,$to_date);
				$vacation->spans_today = DateTime_Service::getInstance()->now_between_dates($from_date,$to_date);
				array_push($location->vacations, $vacation);
			}

			return $location;
		}

		public static function convert_to_locations($raw)
		{
			$locations = array();

			$raw_json = json_decode($raw);
			foreach($raw_json as $raw_location)
			{
				array_push($locations, self::create_location($raw_location));
			}

			return $locations;
		}

	}

}