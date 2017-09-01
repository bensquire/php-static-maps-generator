<?php
namespace GoogleStaticMap;

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

    protected $aPoints = [];
    protected $aAcceptableColors = [
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
    protected $iWeight = null;
    protected $sColor = null;
    protected $sFillColor = null;

    public function __construct($aParams = [])
    {
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
     * @param $iWeight
     * @return $this
     * @throws \Exception
     */
    public function setWeight($iWeight)
    {
        if (!preg_match('/^([0-9])+$/', $iWeight)) {
            throw new \Exception('Only integers allowed');
        }

        $this->iWeight = (int) $iWeight;
        return $this;
    }

    /**
     * Sets the color of the map path line, 24 or 32bit hex, or part of the listed color array.
     *
     * @param $sColor
     * @return $this
     * @throws \Exception
     */
    public function setColor($sColor)
    {
        $sColor = strtolower($sColor);

        if (!preg_match('/^0x[0-9A-F]{6,8}/', $sColor) && !in_array($sColor, $this->aAcceptableColors)) {
            throw new \Exception('Invalid Color, 24/32bit (0x00000000) or string: ' . $sColor);
        }

        $this->sColor = $sColor;
        return $this;
    }

    /**
     * Set the fill color of the map path (requires more than 2 points for it to become visible).
     *
     * @param $sFillColor
     * @return $this
     * @throws \Exception
     */
    public function setFillColor($sFillColor)
    {
        //fillcolor (24bit or 32bit color value) indicates its a closed loop path

        if (!preg_match('/^0x[0-9A-Fa-f]{6,8}/', $sFillColor)) {
            throw new \Exception('Invalid Fill Color, 24/32bit (0x00000000) or string');
        }

        $this->sFillColor = $sFillColor;
        return $this;
    }

    /**
     * Return the path line weight
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->iWeight;
    }

    /**
     * Return the polyfill color
     *
     * @return string
     */
    public function getFillColor(): string
    {
        return $this->sFillColor;
    }

    /**
     * Return the path line color
     *
     * @return string
     */
    public function getColor(): string
    {
        return $this->sColor;
    }

    /**
     * Creates the points in the Map Path, either pass a PathPoint
     * object, an array of PathPoint objects or an array of
     * PathPoint constructor values
     *
     * @param mixed $mPoints Array or PathPoint object
     * @return \GoogleStaticMap\Path
     * @throws \Exception
     */
    public function setPoint($mPoints)
    {
        if (is_array($mPoints) && count($mPoints) > 0) {
            foreach ($mPoints as $mPoint) {
                if ($mPoints instanceof PathPoint) {
                    $this->aPoints[] = $mPoint;
                } elseif (is_array($mPoint)) {
                    $this->aPoints[] = new PathPoint($mPoint);
                }
            }
        } elseif ($mPoints instanceof PathPoint) {
            $this->aPoints[] = $mPoints;
        } else {
            throw new \Exception('Invalid Map Path Point');
        }

        return $this;
    }

    /**
     * Build the map path part of the url string.
     *
     * @return string
     */
    public function build(): string
    {
        $sPath = '';

        if (count($this->aPoints) > 0) {
            $aUrl = [];

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
            foreach ($this->aPoints as $aPoint) {
                $aUrl[] = $aPoint->build();
            }

            $sPath .= implode($this::SEPARATOR, $aUrl);
        }

        return ((strlen($sPath) > 0) ? 'path=' . $sPath : '');
    }
}
