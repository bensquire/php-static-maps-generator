<?php

/**
 * @author Ben Squire <b.squire@gmail.com>
 * @license Apache 2.0
 *
 * @package GoogleStaticMap
 *
 * @abstract This class abstracts the markers that can be placed onto the
 * Google Static Maps.
 *
 * @see https://github.com/bensquire/php-static-maps-generator
 */
class GoogleStaticMapMarker {

	const SEPERATOR = '|';

	protected $aMarkerSizes = array('tiny', 'mid', 'small');
	protected $fLongitude = '';
	protected $fLatitude = '';
	protected $sLabel = '';
	protected $sColor = '';
	protected $sSize = '';
	protected $sCustomIcon = ''; //TODO implement

	public function __construct($aParams = array()) {
		if (isset($aParams['color'])) {
			$this->setColor($aParams['color']);
		}

		if (isset($aParams['longitude'])) {
			$this->setLongitude($aParams['longitude']);
		}

		if (isset($aParams['latitude'])) {
			$this->setLatitude($aParams['latitude']);
		}

		if (isset($aParams['label'])) {
			$this->setLabel($aParams['label']);
		}

		if (isset($aParams['size'])) {
			$this->setSize($aParams['size']);
		}
	}

	/**
	 * Output the marker url string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->buildMarker();
	}

	/**
	 * Set the markers Longitude
	 *
	 * @param float $fLongitude
	 * @return GoogleStaticMapMarker
	 */
	public function setLongitude($fLongitude) {
		$this->fLongitude = $fLongitude;
		return $this;
	}

	/**
	 * Set the markers Latitude
	 *
	 * @param float $fLatitude
	 * @return GoogleStaticMapMarker
	 */
	public function setLatitude($fLatitude) {
		$this->fLatitude = $fLatitude;
		return $this;
	}

	/**
	 * Set the label for this marker
	 *
	 * @param string $sLabel
	 * @return GoogleStaticMapMarker
	 */
	public function setLabel($sLabel) {
		$this->sLabel = $sLabel;
		return $this;
	}

	/**
	 * Set the color for this marker
	 *
	 * @param string $sColor
	 * @return GoogleStaticMapMarker
	 */
	public function setColor($sColor) {
		$this->sColor = $sColor;
		return $this;
	}

	/**
	 * Set the size of the marker
	 *
	 * @param string $iSize
	 * @return GoogleStaticMapMarker
	 */
	public function setSize($iSize) {
		if ((in_array($iSize, $this->aMarkerSizes))) {
			$this->sSize = $iSize;
		}

		return $this;
	}

	/**
	 * Return the marker longitude
	 *
	 * @return string
	 */
	public function getLongitude() {
		return $this->fLongitude;
	}

	/**
	 * Return the marker latitude
	 *
	 * @return string
	 */
	public function getLatitude() {
		return $this->fLatitude;
	}

	/**
	 * Return the marker label
	 *
	 * @return string
	 */
	public function getLabel() {
		return $this->sLabel;
	}

	/**
	 * Return the marker color
	 *
	 * @return string
	 */
	public function getColor() {
		return $this->sColor;
	}

	/**
	 * Return the marker size
	 *
	 * @return string
	 */
	public function getSize() {
		return $this->sSize;
	}

	/**
	 * Return the marker url string
	 *
	 * @return string
	 */
	public function build() {
		return 'markers=' .
				((!empty($this->sColor)) ? 'color:' . urlencode($this->sColor . $this::SEPERATOR) : '') .
				((!empty($this->sLabel)) ? 'label:' . urlencode($this->sLabel . $this::SEPERATOR) : '') .
				((!empty($this->sSize)) ? 'size:' . urlencode($this->sSize . $this::SEPERATOR) : '') .
				$this->fLatitude . ',' . $this->fLongitude;
	}

}

?>