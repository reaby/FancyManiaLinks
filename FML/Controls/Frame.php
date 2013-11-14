<?php

namespace FML\Controls;

use FML\Types\Container;
use FML\Types\Renderable;

/**
 * Class representing CMlFrame
 *
 * @author steeffeen
 */
class Frame extends Control implements Container {
	/**
	 * Private properties
	 */
	private $children = array();

	/**
	 * Construct a new frame control
	 *
	 * @param string $id        	
	 */
	public function __construct($id = null) {
		parent::__construct($id);
		$this->tagName = 'frame';
	}

	/**
	 *
	 * @see \FML\Types\Container::add()
	 * @return \FML\Controls\Frame
	 */
	public function add(Renderable $child) {
		array_push($this->children, $child);
		return $this;
	}

	/**
	 *
	 * @see \FML\Types\Container::removeChildren()
	 * @return \FML\Controls\Frame
	 */
	public function removeChildren() {
		$this->children = array();
		return $this;
	}

	/**
	 *
	 * @see \FML\Renderable::render()
	 */
	public function render(\DOMDocument $domDocument) {
		$xml = parent::render($domDocument);
		foreach ($this->children as $child) {
			$childXml = $child->render($domDocument);
			$xml->appendChild($childXml);
		}
		return $xml;
	}

	/**
	 * Return class name
	 * 
	 * @return string
	 */
	public static function getClass() {
		return __CLASS__;
	}
}

?>
