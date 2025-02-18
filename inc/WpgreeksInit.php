<?php

/**
 * @package  WPGreeksCPT
 */

namespace Wpgreekscpt;

final class WpgreeksInit
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function wpgreeks_get_services() 
	{
		return [
			Pages\Dashboard::class,
			Base\Enqueue::class,
			Base\SettingsLinks::class,
			Base\CustomPostTypeController::class,
			Base\ModernDesignController::class,
			Base\CustomTaxonomyController::class,
			Base\WidgetController::class
		];
	}

	/**
	 * Loop through the classes, initialize them, 
	 * and call the register() method if it exists
	 * @return
	 */
	public static function wpgreeks_register_services() 
	{
		foreach ( self::wpgreeks_get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @param  class $class    class from the services array
	 * @return class instance  new instance of the class
	 */
	private static function instantiate( $class )
	{
		$service = new $class();
		return $service;
	}
}