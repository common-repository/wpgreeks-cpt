<?php 
/**
 * @package  WPGreeksCPT
 */

namespace Wpgreekscpt\Api\CallBacks;

use Wpgreekscpt\Base\BaseController;

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		return require_once( "$this->wpgreeks_plugin_path/templates/admin.php" );
	}

	public function adminCpt()
	{
		return require_once( "$this->wpgreeks_plugin_path/templates/cpt.php" );
	}

	public function adminTaxonomy()
	{
		return require_once( "$this->wpgreeks_plugin_path/templates/taxonomy.php" );
	}
}