<?php

/**
 * @author Ben Squire <b.squire@gmail.com>
 * @license Apache 2.0
 *
 * @package GoogleStaticMap
 *
 * @abstract This class abstracts the map feature styling part of the Google
 * Static map API. i.e: Determine the styling of the map features (Think map color,
 * opacity, build colors etc)
 *
 * @see https://github.com/bensquire/php-static-maps-generator
 */
class GoogleStaticMapFeatureStyling {

	const SEPERATOR = '|';

	protected $fGamma = null;
	protected $fLightness = null;
	protected $fSaturation = null;
	protected $fHue = null;
	protected $bVisible = true;
	protected $bInvertLightness = false;

	public function __construct($aParams = array()) {
		if (isset($aParams['gamma'])) {
			$this->setGamma($aParams['gamma']);
		}

		if (isset($aParams['lightness'])) {
			$this->setLightness($aParams['lightness']);
		}

		if (isset($aParams['saturation'])) {
			$this->setSaturation($aParams['saturation']);
		}

		if (isset($aParams['hue'])) {
			$this->setHue($aParams['hue']);
		}

		if (isset($aParams['invert_lightness'])) {
			$this->setInvertLightness($aParams['invert_lightness']);
		}

		if (isset($aParams['visibility'])) {
			$this->setVisibility($aParams['visibility']);
		}
	}

	/**
	 * Sets the gamma value of the elements styling
	 *
	 * @param float $fGamma
	 * @return GoogleStaticMapFeatureStyling
	 */
	public function setGamma($fGamma) {
		if (!is_float($fGamma) || $fGamma < 0.01 || $fGamma > 10.0) {
			throw new Exception('Invalid Gamma Styling Paramater Passed ' . $fGamma);
		}

		$this->fGamma = $fGamma;
		return $this;
	}

	/**
	 * Sets the lightness value of the elements styling
	 *
	 * @param int $iLightness
	 * @return GoogleStaticMapFeatureStyling
	 */
	public function setLightness($iLightness) {
		if (!is_int($iLightness) || $iLightness > 100 || $iLightness < -100) {
			throw new Exception('Invalid Lightness Styling Paramater Passed ' . $iLightness);
		}

		$this->fLightness = $iLightness;
		return $this;
	}

	/**
	 * Sets the saturation of the elements styling
	 *
	 * @param int $iSaturation
	 * @return GoogleStaticMapFeatureStyling
	 */
	public function setSaturation($iSaturation) {
		if (!is_int($iSaturation) || $iSaturation > 100 || $iSaturation < -100) {
			throw new Exception('Invalid Saturation Styling Paramater Passed ' . $iSaturation);
		}

		$this->fSaturation = $iSaturation;
		return $this;
	}

	/**
	 * Sets the RGB colour of the elements styling. Note: it is used for colour
	 * only, not lightness or saturation.
	 *
	 * @param type $sHue
	 * @return GoogleStaticMapFeatureStyling
	 */
	public function setHue($sHue) {
		$sHue = ltrim($sHue, '#');

		if (!preg_match('/^[0-9A-Fa-f]{3,6}/', $sHue)) {
			throw new Exception('Invalid Hue (RGB) format: ' . $sHue);
		}

		$this->fHue = $sHue;
		return $this;
	}

	/**
	 * Invert the lightness of the elements styling.
	 *
	 * @param bool $bInvertLightness
	 * @return GoogleStaticMapFeatureStyling
	 */
	public function setInvertLightness($bInvertLightness) {
		$this->bInvertLightness = ($bInvertLightness == true);
		return $this;
	}

	/**
	 * Determines if an element should be visible, or simplified (complexity
	 * decided by google).
	 *
	 * @param string $mVisibility
	 * @return GoogleStaticMapFeatureStyling
	 */
	public function setVisibility($mVisibility) {

		if ($mVisibility == true || $mVisibility == 'on') {
			$this->bVisible = 'on';
		} elseif ($mVisibility == false || $mVisibility == 'off') {
			$this->bVisible = 'off';
		} else {
			$this->bVisible = 'simplified';
		}

		return $this;
	}

	/**
	 * Returns the elements gamma value
	 *
	 * @return float
	 */
	public function getGamma() {
		return $this->fGamma;
	}

	/**
	 * Returns the elements lightness value
	 *
	 * @return float
	 */
	public function getLightness() {
		return $this->fLightness;
	}

	/**
	 * Returns the elements saturation value
	 *
	 * @return float
	 */
	public function getSaturation() {
		return $this->fSaturation;
	}

	/**
	 * Returns the elements hue value
	 *
	 * @return float
	 */
	public function getHue() {
		return $this->fHue;
	}

	/**
	 * Returns whether the lightness is inverted
	 *
	 * @return boolean
	 */
	public function getInvertLightness() {
		return $this->bInvertLightness;
	}

	/**
	 * Returns the visibility status of the element
	 *
	 * @return string
	 */
	public function getVisibility() {
		return $this->bVisible;
	}

	/**
	 * Builds the string for this specific elements styling
	 *
	 * @return string
	 */
	public function build() {
		$aUrl = array();

		if (!empty($this->fGamma)) {
			$aUrl[] = 'gamma:' . $this->fGamma;
		}

		if (!empty($this->fLightness)) {
			$aUrl[] = 'lightness:' . $this->fLightness;
		}

		if (!empty($this->fSaturation)) {
			$aUrl[] = 'saturation:' . $this->fSaturation;
		}

		if (!empty($this->fHue)) {
			$aUrl[] = 'hue:0x' . $this->fHue;
		}

		if ($this->bVisible !== true) {
			$aUrl[] = 'visibility:false';
		}

		if ($this->bInvertLightness !== false) {
			$aUrl[] = 'inverse_lightness:true';
		}

		return implode($this::SEPERATOR, $aUrl);
	}

}

?>