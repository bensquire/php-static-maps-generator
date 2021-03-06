<?php
namespace GoogleStaticMap;

use GoogleStaticMap\Path\Point;

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
class Path
{
    public const SEPARATOR = '|';

    protected $points = [];
    protected $validColours = [
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
    ];
    protected $weight = null;
    protected $colour = null;
    protected $fillColour = null;

    /**
     * Set the weight of the map path line in px
     *
     * @param int $weight
     * @return $this
     * @throws \Exception
     */
    public function setWeight(int $weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Sets the color of the map path line, 24 or 32bit hex, or part of the listed color array.
     *
     * @param $colour
     * @return $this
     * @throws \Exception
     */
    public function setColor(string $colour)
    {
        $colour = strtolower($colour);

        if (!preg_match('/^0x[0-9A-F]{6,8}/', $colour) && !in_array($colour, $this->validColours)) {
            throw new \Exception('Invalid Color, 24/32bit (0x00000000) or string: ' . $colour);
        }

        $this->colour = $colour;
        return $this;
    }

    /**
     * Set the fill color of the map path (requires more than 2 points for it to become visible).
     *
     * @param $colour
     * @return $this
     * @throws \Exception
     */
    public function setFillColor(string $colour)
    {
        //fillcolor (24bit or 32bit color value) indicates its a closed loop path

        if (!preg_match('/^0x[0-9A-Fa-f]{6,8}/', $colour)) {
            throw new \Exception('Invalid Fill Color, 24/32bit (0x00000000) or string');
        }

        $this->fillColour = $colour;
        return $this;
    }

    /**
     * Return the path line weight
     *
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * Return the polyfill color
     *
     * @return string
     */
    public function getFillColor(): string
    {
        return $this->fillColour;
    }

    /**
     * Return the path line color
     *
     * @return string
     */
    public function getColor(): string
    {
        return $this->colour;
    }

    /**
     * @param Point $point
     * @return $this
     */
    public function addPoint(Point $point)
    {
        $this->points[] = $point;
        return $this;
    }

    /**
     * Build the map path part of the url string.
     *
     * @return string
     */
    public function build(): string
    {
        $path = '';

        if (count($this->points) > 0) {
            $url = [];

            //Styling First
            if (strlen($this->weight) > 0) {
                $url[] = 'weight:' . $this->weight;
            }

            if (strlen($this->colour) > 0) {
                $url[] = 'color:' . $this->colour;
            }

            if (strlen($this->fillColour) > 0) {
                $url[] = 'fillcolor:' . $this->fillColour;
            }

            //Then the points
            foreach ($this->points as $point) {
                $url[] = $point->build();
            }

            $path .= implode($this::SEPARATOR, $url);
        }

        return ((strlen($path) > 0) ? 'path=' . $path : '');
    }
}
