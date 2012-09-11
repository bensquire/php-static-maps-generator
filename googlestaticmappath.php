<?php

/**
 * @author Ben Squire <b.squire@gmail.com>
 * @license Apache 2.0
 *
 * @package GoogleStaticMap
 *
 * @abstract This class abstracts the path that can be placed onto the
 * Google Static Maps. Controlling the points object and the path styling.
 *
 * @see https://github.com/bensquire/php-static-maps-generator
 * @todo https://developers.google.com/maps/documentation/staticmaps/#EncodedPolylines
 * @todo https://developers.google.com/maps/documentation/staticmaps/#Viewports
 */
class GoogleStaticMapPath {

	const SEPERATOR = '|';

	protected $aPoints = array();
	protected $aAcceptableColors = array(
		'black',
		'brown',
		'green',
		'purple',
		'yellow',
		'blue',
		'gray',
		'orange',
		'red',
		'white'
	);
	protected $iWeight = null;
	protected $sColor = null;
	protected $sFillColor = null;

	public function __construct($aParams = array()) {
		if (isset($aParams['weight'])) {
			$this->setWeight($aParams['weight']);
		}

		if (isset($aParams['color'])) {
			$this->setColor($aParams['color']);
		}

		if (isset($aParams['fill_color'])) {
			$this->setFillColor($aParams['fill_color']);
		}

		if (isset($aParams['point'])) {
			$this->setPoint($aParams['point']);
		}
	}

	/**
	 * Set the weight of the map path line in px
	 *
	 * @param int $iWeight The width of the map path line
	 * @return \GoogleStaticMapPathStyling
	 * @throws Exception
	 */
	public function setWeight($iWeight) {
		if (!preg_match('/^([0-9])+$/', $iWeight)) {
			throw new Exception('Only integers allowed');
		}

		$this->iWeight = (int) $iWeight;
		return $this;
	}

	/**
	 * Sets the color of the map path line, 24 or 32bit hex, or part of the
	 * listed color array.
	 *
	 * @param string $sColor
	 * @return \GoogleStaticMapPathStyling
	 * @throws Exception
	 */
	public function setColor($sColor) {
		$sColor = strtolower($sColor);

		if (!preg_match('/^0x[0-9A-F]{6,8}/', $sColor) && !in_array($sColor, $this->aAcceptableColors)) {
			throw new Exception('Invalid Color, 24/32bit (0x00000000) or string: ' . $sColor);
		}

		$this->sColor = $sColor;
		return $this;
	}

	/**
	 * Set the fill color of the map path (requires more than 2 points for it to
	 * become visible).
	 *
	 * @param string $sFillColor
	 * @return \GoogleStaticMapPathStyling
	 * @throws Exception
	 */
	public function setFillColor($sFillColor) {
		//fillcolor (24bit or 32bit color value) indicates its a closed loop path

		if (!preg_match('/^0x[0-9A-Fa-f]{6,8}/', $sFillColor)) {
			throw new Exception('Invalid Fill Color, 24/32bit (0x00000000) or string');
		}

		$this->sFillColor = $sFillColor;
		return $this;
	}

	/**
	 * Return the path line weight
	 *
	 * @return int
	 */
	public function getWeight() {
		return $this->iWeight;
	}

	/**
	 * Return the polyfill color
	 *
	 * @return string
	 */
	public function getFillColor() {
		return $this->sFillColor;
	}

	/**
	 * Return the path line color
	 *
	 * @return string
	 */
	public function getColor() {
		return $this->sColor;
	}

	/**
	 * Creates the points in the Map Path, either pass a GoogleStaticMapPathPoint
	 * object, an array of GoogleStaticMapPathPoint objects or an array of
	 * GoogleStaticMapPathPoint constructor values
	 * 
	 * @param mixed $mPoints Array or GoogleStaticMapPathPoint object
	 * @return \GoogleStaticMapPath
	 * @throws Exception
	 */
	public function setPoint($mPoints) {
		if (is_array($mPoints) && count($mPoints) > 0) {
			foreach ($mPoints AS $mPoint) {
				if ($mPoints instanceof GoogleStaticMapPathPoint) {
					$this->aPoints[] = $mPoint;
				} elseif (is_array($mPoint)) {
					$this->aPoints[] = new GoogleStaticMapPathPoint($mPoint);
				}
			}
		} elseif ($mPoints instanceof GoogleStaticMapPathPoint) {
			$this->aPoints[] = $mPoints;
		} else {
			throw new Exception('Invalid Map Path Point');
		}

		return $this;
	}

	/**
	 * Build the map path part of the url string.
	 *
	 * @return string
	 */
	public function build() {
		$sPath = '';

		if (count($this->aPoints) > 0) {
			$aUrl = array();

			//Styling First
			if (strlen($this->iWeight) > 0) {
				$aUrl[] = 'weight:' . $this->iWeight;
			}

			if (strlen($this->sColor) > 0) {
				$aUrl[] = 'color:' . $this->sColor;
			}

			if (strlen($this->sFillColor) > 0) {
				$aUrl[] = 'fillcolor:' . $this->sFillColor;
			}

			//Then the points
			foreach ($this->aPoints AS $aPoint) {
				$aUrl[] = $aPoint->build();
			}

			$sPath .= implode($this::SEPERATOR, $aUrl);
		}

		return ((strlen($sPath) > 0) ? 'path=' . $sPath : '');
	}

}

?>