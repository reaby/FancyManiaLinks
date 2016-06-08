<?php

namespace FML\ManiaCode;

/**
 * ManiaCode Element for joining a server
 *
 * @author    steeffeen <mail@steeffeen.com>
 * @copyright FancyManiaLinks Copyright © 2014 Steffen Schröder
 * @license   http://www.gnu.org/licenses/ GNU General Public License, Version 3
 */
class JoinServer extends Element {

	/*
	 * Protected properties
	 */
	protected $login = null;
	protected $serverIp = null;
	protected $serverPort = null;

	/**
	 * Create a new JoinServer Element
	 *
	 * @api
	 * @param string $login (optional) Server login
	 * @return static
	 */
	public static function create($login = null) {
		return new static($login);
	}

	/**
	 * Construct a new JoinServer Element
	 *
	 * @api
	 * @param string $login (optional) Server login
	 */
	public function __construct($login = null) {
		if ($login !== null) {
			$this->setLogin($login);
		}
	}

	/**
	 * Set the server login
	 *
	 * @api
	 * @param string $login Server login
	 * @return static
	 */
	public function setLogin($login) {
		$this->login      = (string)$login;
		$this->serverIp   = null;
		$this->serverPort = null;
		return $this;
	}

	/**
	 * Set the server ip and port
	 *
	 * @api
	 * @param string $serverIp   Server ip
	 * @param int    $serverPort Server port
	 * @return static
	 */
	public function setIp($serverIp, $serverPort) {
		$this->serverIp   = (string)$serverIp;
		$this->serverPort = (int)$serverPort;
		$this->login      = null;
		return $this;
	}

	/**
	 * @see Element::render()
	 */
	public function render(\DOMDocument $domDocument) {
		$domElement = $domDocument->createElement("join_server");
		
		if ($this->serverIp === null) {
			$loginElement = $domDocument->createElement("login", $this->login);
			$domElement->appendChild($loginElement);
		} else {
			$ipElement = $domDocument->createElement("ip", $this->serverIp . ":" . $this->serverPort);
			$domElement->appendChild($ipElement);
		}
		
		return $domElement;
	}
	
}
