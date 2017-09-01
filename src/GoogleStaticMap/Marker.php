<?php

namespace GoogleStaticMap;

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
class Marker
{
    public const SEPARATOR = '|';

    protected $validMarkerSizes = ['tiny', 'mid', 'small'];
    protected $longitude = '';
    protected $latitude = '';
    protected $label = '';
    protected $colour = '';
    protected $size = '';
    protected $customIcon = ''; //TODO implement

    public function __construct($params = [])
    {
        if (isset($params['color'])) {
            $this->setColor($params['color']);
        }

        if (isset($params['longitude'])) {
            $this->setLongitude($params['longitude']);
        }

        if (isset($params['latitude'])) {
            $this->setLatitude($params['latitude']);
        }

        if (isset($params['label'])) {
            $this->setLabel($params['label']);
        }

        if (isset($params['size'])) {
            $this->setSize($params['size']);
        }
    }

    /**
     * Output the marker url string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->buildMarker();
    }

    /**
     * Set the markers Longitude
     *
     * @param float $longitude
     * @return Marker
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Set the markers Latitude
     *
     * @param float latitude
     * @return Marker
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Set the label for this marker
     *
     * @param string $string
     * @return Marker
     */
    public function setLabel(string $string)
    {
        $this->label = $string;
        return $this;
    }

    /**
     * Set the color for this marker
     *
     * @param string $colour
     * @return Marker
     */
    public function setColor(string $colour)
    {
        $this->colour = $colour;
        return $this;
    }

    /**
     * Set the size of the marker
     *
     * @param string $size
     * @return Marker
     */
    public function setSize(string $size)
    {
        if ((in_array($size, $this->validMarkerSizes))) {
            $this->size = $size;
        }

        return $this;
    }

    /**
     * Return the marker longitude
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * Return the marker latitude
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Return the marker label
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Return the marker color
     *
     * @return string
     */
    public function getColor(): string
    {
        return $this->colour;
    }

    /**
     * Return the marker size
     *
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * Return the marker url string
     *
     * @return string
     */
    public function build(): string
    {
        return 'markers=' .
            ((!empty($this->colour)) ? 'color:' . urlencode($this->colour . $this::SEPARATOR) : '') .
            ((!empty($this->label)) ? 'label:' . urlencode($this->label . $this::SEPARATOR) : '') .
            ((!empty($this->size)) ? 'size:' . urlencode($this->size . $this::SEPARATOR) : '') .
            $this->latitude . ',' . $this->longitude;
    }
}
