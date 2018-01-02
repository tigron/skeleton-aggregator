<?php
/**
 * Database migration class
 *
 * @author David Vandemaele <david@tigron.be>
 */
namespace Skeleton\Aggregator;

class Migration_20180102_163727_Init extends \Skeleton\Database\Migration {

	/**
	 * Migrate up
	 *
	 * @access public
	 */
	public function up() {
		$db = Database::get();
		$db->query("
			CREATE TABLE `aggregator` (
				`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
				`identifier` varchar(128) NOT NULL,
				`classname` varchar(64) NULL,
				`object_id` int NULL,
				`data` text NOT NULL,
				`created` datetime NOT NULL,
				`updated` datetime NULL
			);
		", []);
	}

	/**
	 * Migrate down
	 *
	 * @access public
	 */
	public function down() {

	}
}
