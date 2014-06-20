<?php

namespace FML\Controls;

use FML\Types\Styleable;

/**
 * Gauge Control
 * (CMlGauge)
 *
 * @author    steeffeen <mail@steeffeen.com>
 * @copyright FancyManiaLinks Copyright © 2014 Steffen Schröder
 * @license   http://www.gnu.org/licenses/ GNU General Public License, Version 3
 */
class Gauge extends Control implements Styleable {
	/*
	 * Constants
	 */
	const STYLE_BgCard           = 'BgCard';
	const STYLE_EnergyBar        = 'EnergyBar';
	const STYLE_ProgressBar      = 'ProgressBar';
	const STYLE_ProgressBarSmall = 'ProgressBarSmall';

	/*
	 * Protected properties
	 */
	protected $ratio = 0.;
	protected $grading = 1.;
	protected $color = null;
	protected $rotation = 0.;
	protected $centered = 0;
	protected $clan = 0;
	protected $drawBg = 1;
	protected $drawBlockBg = 1;
	protected $style = null;

	/**
	 * Construct a new Gauge Control
	 *
	 * @param string $id (optional) Gauge id
	 */
	public function __construct($id = null) {
		parent::__construct($id);
		$this->tagName = 'gauge';
	}

	/**
	 * Create a new Gauge Control
	 *
	 * @param string $id (optional) Gauge id
	 * @return \FML\Controls\Gauge|static
	 */
	public static function create($id = null) {
		return new static($id);
	}

	/**
	 * @see \FML\Controls\Control::getManiaScriptClass()
	 */
	public function getManiaScriptClass() {
		return 'CMlGauge';
	}

	/**
	 * Set ratio
	 *
	 * @param float $ratio Ratio value
	 * @return \FML\Controls\Gauge|static
	 */
	public function setRatio($ratio) {
		$this->ratio = (float)$ratio;
		return $this;
	}

	/**
	 * Set grading
	 *
	 * @param float $grading Grading value
	 * @return \FML\Controls\Gauge|static
	 */
	public function setGrading($grading) {
		$this->grading = (float)$grading;
		return $this;
	}

	/**
	 * Set color
	 *
	 * @param string $color Gauge color
	 * @return \FML\Controls\Gauge|static
	 */
	public function setColor($color) {
		$this->color = (string)$color;
		return $this;
	}

	/**
	 * Set rotation
	 *
	 * @param float $rotation Gauge rotation
	 * @return \FML\Controls\Gauge|static
	 */
	public function setRotation($rotation) {
		$this->rotation = (float)$rotation;
		return $this;
	}

	/**
	 * Set centered
	 *
	 * @param bool $centered Whether the Gauge is centered
	 * @return \FML\Controls\Gauge|static
	 */
	public function setCentered($centered) {
		$this->centered = ($centered ? 1 : 0);
		return $this;
	}

	/**
	 * Set clan
	 *
	 * @param int $clan Clan number
	 * @return \FML\Controls\Gauge|static
	 */
	public function setClan($clan) {
		$this->clan = (int)$clan;
		return $this;
	}

	/**
	 * Set draw background
	 *
	 * @param bool $drawBg Whether the Gauges background should be drawn
	 * @return \FML\Controls\Gauge|static
	 */
	public function setDrawBg($drawBg) {
		$this->drawBg = ($drawBg ? 1 : 0);
		return $this;
	}

	/**
	 * Set draw block background
	 *
	 * @param bool $drawBlockBg Whether the Gauges block background should be drawn
	 * @return \FML\Controls\Gauge|static
	 */
	public function setDrawBlockBg($drawBlockBg) {
		$this->drawBlockBg = ($drawBlockBg ? 1 : 0);
		return $this;
	}

	/**
	 * @see \FML\Types\Styleable::setStyle()
	 */
	public function setStyle($style) {
		$this->style = (string)$style;
		return $this;
	}

	/**
	 * @see \FML\Control::render()
	 */
	public function render(\DOMDocument $domDocument) {
		$xmlElement = parent::render($domDocument);
		if ($this->ratio) {
			$xmlElement->setAttribute('ratio', $this->ratio);
		}
		if ($this->grading != 1.) {
			$xmlElement->setAttribute('grading', $this->grading);
		}
		if ($this->color) {
			$xmlElement->setAttribute('color', $this->color);
		}
		if ($this->rotation) {
			$xmlElement->setAttribute('rotation', $this->rotation);
		}
		if ($this->centered) {
			$xmlElement->setAttribute('centered', $this->centered);
		}
		if ($this->clan) {
			$xmlElement->setAttribute('clan', $this->clan);
		}
		if (!$this->drawBg) {
			$xmlElement->setAttribute('drawbg', $this->drawBg);
		}
		if (!$this->drawBlockBg) {
			$xmlElement->setAttribute('drawblockbg', $this->drawBlockBg);
		}
		if ($this->style) {
			$xmlElement->setAttribute('style', $this->style);
		}
		return $xmlElement;
	}
}
