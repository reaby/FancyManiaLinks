<?php

namespace FML\Controls;

use FML\Types\Playable;
use FML\Types\Scriptable;

/**
 * Audio Control
 * (CMlMediaPlayer)
 *
 * @author    steeffeen
 * @copyright FancyManiaLinks Copyright © 2014 Steffen Schröder
 * @license   http://www.gnu.org/licenses/ GNU General Public License, Version 3
 */
class Audio extends Control implements Playable, Scriptable {
	/*
	 * Protected properties
	 */
	protected $data = null;
	protected $dataId = null;
	protected $play = 0;
	protected $looping = 0;
	protected $music = 0;
	protected $volume = 1.;
	protected $scriptEvents = 0;

	/**
	 * Create a new Audio Control
	 *
	 * @param string $id (optional) Audio id
	 * @return \FML\Controls\Audio
	 */
	public static function create($id = null) {
		return new static($id);
	}

	/**
	 * Construct a new Audio Control
	 *
	 * @param string $id (optional) Audio id
	 */
	public function __construct($id = null) {
		// TODO: validate if $tagName could simply be overwritten
		parent::__construct($id);
		$this->tagName = 'audio';
	}

	/**
	 * @see \FML\Controls\Control::getManiaScriptClass()
	 */
	public function getManiaScriptClass() {
		return 'CMlMediaPlayer';
	}

	/**
	 * @see \FML\Types\Playable::setData()
	 */
	public function setData($data) {
		$this->data = (string)$data;
		return $this;
	}

	/**
	 * @see \FML\Types\Playable::setDataId()
	 */
	public function setDataId($dataId) {
		$this->dataId = (string)$dataId;
		return $this;
	}

	/**
	 * @see \FML\Types\Playable::setPlay()
	 */
	public function setPlay($play) {
		$this->play = ($play ? 1 : 0);
		return $this;
	}

	/**
	 * @see \FML\Types\Playable::setLooping()
	 */
	public function setLooping($looping) {
		$this->looping = ($looping ? 1 : 0);
		return $this;
	}

	/**
	 * @see \FML\Types\Playable::setMusic()
	 */
	public function setMusic($music) {
		$this->music = ($music ? 1 : 0);
		return $this;
	}

	/**
	 * @see \FML\Types\Playable::setVolume()
	 */
	public function setVolume($volume) {
		$this->volume = (float)$volume;
		return $this;
	}

	/**
	 * @see \FML\Types\Scriptable::setScriptEvents()
	 */
	public function setScriptEvents($scriptEvents) {
		$this->scriptEvents = ($scriptEvents ? 1 : 0);
		return $this;
	}

	/**
	 * @see \FML\Types\Renderable::render()
	 */
	public function render(\DOMDocument $domDocument) {
		$xmlElement = parent::render($domDocument);
		if ($this->data) {
			$xmlElement->setAttribute('data', $this->data);
		}
		if ($this->play) {
			$xmlElement->setAttribute('play', $this->play);
		}
		if (!$this->looping) {
			$xmlElement->setAttribute('looping', $this->looping);
		}
		if ($this->music) {
			$xmlElement->setAttribute('music', $this->music);
		}
		if ($this->volume != 1.) {
			$xmlElement->setAttribute('volume', $this->volume);
		}
		if ($this->scriptEvents) {
			$xmlElement->setAttribute('scriptevents', $this->scriptEvents);
		}
		return $xmlElement;
	}
}
