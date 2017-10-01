<?php

namespace GoogleStaticMap;

/**
 * @author Ben Squire <b.squire@gmail.com>
 * @license Apache 2.0
 *
 * @package GoogleStaticMap
 *
 * @abstract This class generates an img src which can be used to load a
 *            'Google Static Map', it currently supports free features,
 *            with plans to integrate the premium features at a later date.
 *
 *            Editable Features include:
 *                -    Map zoom, language, img format, scale etc
 *                -    Markers
 *                -    Feature Styling
 *
 *            Please note Google restricts you to 25,000 unique map generations
 *            each day.
 *
 * @see https://github.com/bensquire/php-static-maps-generator
 *
 * @example examples/example1.php
 * @example examples/example2.php
 * @example examples/example3.php
 * @example examples/example4.php
 * @example examples/example5.php
 * @example examples/example6.php
 */
class Map
{
    public const MAX_URL_LENGTH = 2048;

    protected $googleUrl = 'maps.google.com/maps/api/staticmap';
    protected $validLanguages = ['eu', 'bg', 'bn', 'ca', 'cs', 'da', 'de', 'el', 'en', 'en-AU', 'en-GB', 'es', 'eu', 'fa', 'fi', 'fil', 'fr', 'gl', 'gu', 'hi', 'hr', 'hu', 'id', 'it', 'iw', 'ja', 'kn', 'ko', 'lt', 'lv', 'ml', 'mr', 'nl', 'nn', 'no', 'or', 'pl', 'pt', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl', 'sr', 'sv', 'tl', 'ta', 'te', 'th', 'tr', 'uk', 'vi', 'zh-CN', 'zh-TW'];
    protected $validFormats = ['png', 'png8', 'png32', 'gif', 'jpg', 'jpg-baseline'];
    protected $validMapTypes = ['roadmap', 'satellite', 'hybrid', 'terrain'];
    protected $validScales = [1, 2, 4]; //4 is business only
    protected $isHttps = false;
    protected $apiKey = null;  //TODO Finishing Adding
    protected $centre = null;  //{latitude,longitude} or ('city hall, new york, ny')
    protected $zoomLevel = 10;
    protected $height = 200;
    protected $width = 200;
    protected $scale = 1;
    protected $format = 'png';
    protected $mapType = 'roadmap'; //See $map_types;
    protected $languageCode = 'en-GB';
    protected $region = '';   //TODO Add
    protected $markers = [];
    protected $path = null;
    protected $visible = [];  //TODO Add
    protected $feature = [];
    protected $isSensor = false;

    /**
     * Magic Method to output final image source.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->buildSource();
    }

    /**
     * Sets a single map marker instance, using either an array of parameters, or by passing in  _Marker object
     * e.g:    $map->setMarker(array('color'=>'blue','size'=>'mid','longitude'=>-0.12437000,'latitude'=>51.59413528));
     *
     * @param $aParams
     * @return $this
     * @throws \Exception
     */
    public function addMarker(Marker $aParams)
    {
        $this->markers[] = $aParams;
        return $this;
    }

    /**
     * Sets the whether we should use https to retrieve the map
     *
     * @param bool $isHttps
     * @return $this
     */
    public function setHttps(bool $isHttps)
    {
        $this->isHttps = $isHttps;
        return $this;
    }

    /**
     * Set the API Key used to retrieve this map (server or client)
     *
     * @param $sKey
     * @return $this
     * @throws \Exception
     */
    public function setAPIKey(string $sKey)
    {
        if (preg_match('/^[^a-zA-Z0-9]+$/i', $sKey)) {
            throw new \Exception('Invalid API key');
        }

        $this->apiKey = $sKey;
        return $this;
    }

    /**
     * * Sets the center location of the map, actual location worked out by google so input varies greatly:
     * e.g:    $map->setCenter('London,UK');
     * e.g:    $map->setCenter('-0.12437000,51.59413528');
     *
     * @param string $center
     * @return $this
     */
    public function setCenter(string $center)
    {
        $this->centre = $center;
        return $this;
    }

    /**
     * Sets the maps resolution (1 == Normal, 2 == Double, 4 == Quad)
     *
     * @param $scale
     * @return $this
     * @throws \Exception
     */
    public function setScale(int $scale)
    {
        if (!in_array($scale, $this->validScales)) {
            throw new \Exception('Invalid map scale value: ' . $scale);
        }

        $this->scale = $scale;
        return $this;
    }

    /**
     * Sets the zoom level of the map, valid values 0 to 22.
     *
     * @param $zoomLevel
     * @return $this
     * @throws \Exception
     */
    public function setZoom(int $zoomLevel)
    {
        if ($zoomLevel < 0 || $zoomLevel > 22) {
            throw new \Exception('Invalid Zoom amount requested, 0 to 22, acceptable.');
        }

        $this->zoomLevel = $zoomLevel;
        return $this;
    }

    /**
     * Sets the map type, options are: 'roadmap', 'satellite', 'hybrid', 'terrain'
     *
     * @param $mapType
     * @return $this
     * @throws \Exception
     */
    public function setMapType(string $mapType)
    {
        if (!in_array($mapType, $this->validMapTypes)) {
            throw new \Exception('Unknown map type requested.');
        }

        $this->mapType = $mapType;
        return $this;
    }

    /**
     * Sets the output format of the map. Expected formats are: 'png', 'png8', 'png32', 'gif', 'jpg', 'jpg-baseline'
     *
     * @param $format
     * @return $this
     * @throws \Exception
     */
    public function setFormat(string $format)
    {
        if (!in_array($format, $this->validFormats)) {
            throw new \Exception('Unknown image format requested.');
        }

        $this->format = $format;
        return $this;
    }

    /**
     * Sets the height (in pixels) of the map. Maximum of 640px.
     *
     * @param $height
     * @return $this
     * @throws \Exception
     */
    public function setHeight(int $height)
    {
        if ($height > 640) {
            throw new \Exception('Height cannot be above 640.');
        }

        $this->height = $height;
        return $this;
    }

    /**
     * Sets the width (in pixels) of the map. Maximum of 640px.
     *
     * @param $width
     * @return $this
     * @throws \Exception
     */
    public function setWidth(int $width)
    {
        if ($width > 640) {
            throw new \Exception('Width cannot be above 640.');
        }

        $this->width = $width;
        return $this;
    }

    /**
     * Set the language of the map, acceptable values are: 'eu', 'bg', 'bn', 'ca', 'cs', 'da', 'de', 'el', 'en', 'en-AU', 'en-GB', 'es', 'eu', 'fa', 'fi', 'fil', 'fr', 'gl', 'gu', 'hi', 'hr', 'hu', 'id', 'it', 'iw', 'ja', 'kn', 'ko', 'lt', 'lv', 'ml', 'mr', 'nl', 'nn', 'no', 'or', 'pl', 'pt', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl', 'sr', 'sv', 'tl', 'ta', 'te', 'th', 'tr', 'uk', 'vi', 'zh-CN', 'zh-TW'
     *
     * @param $language
     * @return $this
     * @throws \Exception
     */
    public function setLanguage(string $language)
    {
        if (!in_array($language, $this->validLanguages)) {
            throw new \Exception('Unknown language requested.');
        }

        $this->languageCode = $language;
        return $this;
    }

    /**
     * Create (or adds) the styling of single the map feature, pass in either an object of _Feature or an array of parameters
     * e.g:    $map->setFeatureStyling(array('feature'=>'all', 'element'=>'all', 'style'=>array('hue'=>'6095C6', 'saturation'=>-23, 'gamma'=>3.88, 'lightness'=>16)));
     *
     * @param $feature
     * @return $this
     * @throws \Exception
     */
    public function addFeature(Feature $feature)
    {
        $this->feature[] = $feature;
        return $this;
    }

    /**
     * Creates the GoogleMapPath object used to draw points on the map. Either pass an array of values through, or an Path object.
     *
     * @param $mPath
     * @return $this
     */
    public function setMapPath(Path $mPath)
    {
        $this->path = $mPath;
        return $this;
    }

    /**
     * Returns an array of set Marker objects;
     *
     * e.g:    $markers = $map->getMarkers();
     *
     * @return array
     */
    public function getMarkers(): array
    {
        return $this->markers;
    }

    /**
     * Returns the parameter passed to set the map
     *
     * e.g:    $center = $map->getCenter();
     *
     * @return string
     */
    public function getCenter(): ?string
    {
        return $this->centre;
    }

    /**
     * @return int|null
     */
    public function getScale(): ?int
    {
        return $this->scale;
    }

    /**
     * Returns the zoom level set.
     *
     * e.g:    $zoom = $map->getZoom();
     *
     * @return int
     */
    public function getZoom(): int
    {
        return $this->zoomLevel;
    }

    /**
     * Returns the set map type.
     *
     * e.g:    $type = $map->getType();
     *
     * @return string
     */
    public function getMapType(): string
    {
        return $this->mapType;
    }

    /**
     * Returns the set format of the map
     *
     * e.g:    $format = $map->getFormat();
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Returns the set height of the map
     *
     * e.g:    $height = $map->getHeight();
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Returns the set width of the map
     *
     * e.g:    $width = $map->getWidth();
     *
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * Returns the set language of the map;
     *
     * e.g:    $language = $map->getLanguage();
     *
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->languageCode;
    }

    /**
     * Returns the an array of map feature stylings.
     *
     * e.g:    $styling = $map->getFeatureStyling();
     *
     * @return array
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * @return Path|null
     */
    public function getMapPath(): ?Path
    {
        return $this->path;
    }

    /**
     * Checks whether the url is within the allowed length
     *
     * @param string $string
     * @return boolean
     */
    protected function validLength($string): bool
    {
        return (strlen($string) <= $this::MAX_URL_LENGTH);
    }

    /**
     * Creates the final url for the image tag
     *
     * @return string
     * @throws \Exception
     */
    public function buildSource(): string
    {
        $url = [];

        $url[] = 'center=' . urlencode($this->centre);
        $url[] = 'zoom=' . $this->zoomLevel;
        $url[] = 'language=' . $this->languageCode;
        $url[] = 'maptype=' . $this->mapType;
        $url[] = 'format=' . $this->format;
        $url[] = 'size=' . $this->width . 'x' . $this->height;
        $url[] = 'scale=' . $this->scale;


        if (strlen($this->apiKey) > 0) {
            $url[] = 'key=' . $this->apiKey;
        }

        if (!empty($this->markers)) {
            foreach ($this->markers as $oMarker) {
                $url[] = $oMarker->build();
            }
        }

        if (!empty($this->feature)) {
            foreach ($this->feature as $oFeature) {
                $url[] = $oFeature->build();
            }
        }


        if ($this->path instanceof Path) {
            $url[] = $this->path->build();
        }

        $url[] = 'sensor=' . (($this->isSensor) ? 'true' : 'false');

        $sSrcTag = 'http' . (($this->isHttps) ? 's' : '') . '://' . $this->googleUrl . '?' . implode('&', $url);

        if (!$this->validLength($sSrcTag)) {
            throw new \Exception('URL Exceeded maxiumum length of ' . $this::MAX_URL_LENGTH . ' characters.');
        }

        return $sSrcTag;
    }
}
