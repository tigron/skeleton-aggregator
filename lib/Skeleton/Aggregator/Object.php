<?php
/**
 * Object class
 *
 * @author David Vandemaele <david@tigron.be>
 */
namespace Skeleton\Aggregator;

use \Skeleton\Database\Database;

class Object {
	use \Skeleton\Object\Get;
	use \Skeleton\Object\Model;
	use \Skeleton\Object\Save;

	/**
	 * Class configuration
	 * @var array $class_configuration
	 */
	protected static $class_configuration = [
		'database_table' => 'aggregator'
	]

	/**
	 * Encode and set data
	 *
	 * @access public
	 * @param array $data
	 */
	public function set_data($data) {
		$this->data = json_encode($data);
	}

	/**
	 * Get decoded data
	 *
	 * @access public
	 * @return array $data
	 */
	public function get_data() {
		return json_decode($this->data, true);
	}

	/**
	 * Create new entry
	 *
	 * @access public
	 * @param string $identifier [description]
	 * @param array $data
	 * @param mixed $object
	 * @return Object $aggregator_object
	 */
	public static function create($identifier, $data = [], $object = NULL) {
		$aggregator_object = new self();
		$aggregator_object->identifier = $identifier;
		$aggregator_object->set_data($data);

		if (isset($object)) {
			$aggregator_object->classname = get_class($object);
			$aggregator_object->object_id = $object->id;
		}

		$aggregator_object->save();

		return $aggregator_object;
	}

	/**
	 * Get by identifier
	 *
	 * @access public
	 * @param string $identifier
	 * @return array Object $objects
	 */
	public static function get_by_identifier($identifier) {
		$table = self::trait_get_database_table();

		$db = Database::get();
		$ids = $db->get_column('SELECT id FROM ' . $table . ' WHERE identifier = ?', [ $identifier ]);

		$objects = [];
		foreach ($ids as $id) {
			$objects[] = self::get_by_id($id);
		}

		return $objects;
	}

	/**
	 * Get by identifier and classname
	 *
	 * @access public
	 * @param string $identifier
	 * @param string $classname
	 * @return array Object $objects
	 */
	public static function get_by_identifier_classname($identifier, $classname) {
		$table = self::trait_get_database_table();

		$db = Database::get();
		$ids = $db->get_column('SELECT id FROM ' . $table . ' WHERE identifier = ? AND classname = ?', [ $identifier, $classname ]);

		$objects = [];
		foreach ($ids as $id) {
			$objects[] = self::get_by_id($id);
		}

		return $objects;
	}

}
