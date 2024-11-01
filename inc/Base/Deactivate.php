<?php

/**
 * @package  WPGreeksCPT
 */

namespace Wpgreekscpt\Base;

class Deactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
	}
}