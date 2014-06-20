<?php

namespace FML;

/**
 * Unique ID Model Class
 *
 * @author    steeffeen
 * @copyright FancyManiaLinks Copyright © 2014 Steffen Schröder
 * @license   http://www.gnu.org/licenses/ GNU General Public License, Version 3
 */
class UniqueID {
	/*
	 * Static properties
	 */
	protected static $currentIndex = 0;

	/**
	 * Protected properties
	 */
	protected $index = null;

	/**
	 * Create a new Unique ID object
	 *
	 * @return \FML\UniqueID|static
	 */
	public static function create() {
		return new static();
	}

	/**
	 * Get a new unique index
	 *
	 * @return int
	 */
	protected static function newIndex() {
		self::$currentIndex++;
		return self::$currentIndex;
	}

	/**
	 * Construct a Unique ID object
	 */
	public function __construct() {
		$this->index = static::newIndex();
	}

	/**
	 * Get the Unique ID value
	 *
	 * @return string
	 */
	public function getValue() {
		return (string)$this;
	}

	/**
	 * Get the string representation
	 *
	 * @return string
	 */
	public function __toString() {
		return 'FML_ID_' . $this->index;
	}
}