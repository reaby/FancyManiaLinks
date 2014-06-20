<?php

namespace FML\Controls\Quads;

use FML\Controls\Quad;

/**
 * Quad class for '321Go' styles
 *
 * @author    steeffeen
 * @copyright FancyManiaLinks Copyright © 2014 Steffen Schröder
 * @license   http://www.gnu.org/licenses/ GNU General Public License, Version 3
 */
class Quad_321Go extends Quad {
	/*
	 * Constants
	 */
	const STYLE       = '321Go';
	const SUBSTYLE_3  = '3';
	const SUBSTYLE_2  = '2';
	const SUBSTYLE_1  = '1';
	const SUBSTYLE_Go = 'Go!';

	/**
	 * Construct a new Quad_321Go Control
	 *
	 * @param string $id (optional) Quad id
	 */
	public function __construct($id = null) {
		// TODO: validate if the $style could simply be overwritten
		parent::__construct($id);
		$this->setStyle(self::STYLE);
	}
}
