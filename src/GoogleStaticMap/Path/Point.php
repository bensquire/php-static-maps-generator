<?php
namespace GoogleStaticMap\Path;

/**
 * @author Ben Squire <b.squire@gmail.com>
 * @license Apache 2.0
 *
 * @package GoogleStaticMap
 *
 * @abstract This class abstracts the path points that can be placed onto the
 * Google Static Maps. Either via coordinates or as a string location.
 *
 * @see https://github.com/bensquire/php-static-maps-generator
 */
class Point
{
    protected $longitude = null;
    protected $latitude = null;
    protected $location = null;

    /**
     * Set the longitude of the map point.
     *
     * @param $longitude
     * @return $this
     * @throws \Exception
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Set the Latitude of the map point.
     *
     * @param $latitude
     * @return $this
     * @throws \Exception
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = (float) $latitude;
        return $this;
    }

    /**
     * Set a string location of the map point.
     *
     * @param string $location
     * @return \GoogleStaticMap\Path\Point
     * @throws \Exception
     */
    public function setLocation(string $location)
    {
        if (strlen($location) === 0) {
            throw new \Exception('No string location provided...');
        }

        $this->location = $location;
        return $this;
    }

    /**
     * Return the float longitude
     *
     * @return float
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Return the float of the latitude
     *
     * @return float
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Return the location string
     *
     * @return string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * Recombines the coordinates of the map point
     *
     * @return string
     */
    protected function combineCoordinates(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }

    /**
     * Build the Map Path Point Part of the URL
     *
     * @return string
     */
    public function build(): string
    {
        if (strlen($this->longitude) > 0 && strlen($this->latitude) > 0) {
            return $this->combineCoordinates();
        }

        if (strlen($this->location) > 0) {
            return urlencode($this->location);
        }

        return '';
    }
}
