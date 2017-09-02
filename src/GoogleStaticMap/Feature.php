<?php
namespace GoogleStaticMap;

/**
 * @author Ben Squire <b.squire@gmail.com>
 * @license Apache 2.0
 *
 * @package GoogleStaticMap
 *
 * @abstract This class abstracts the map feature part of the Google
 * Static map API. i.e: Determine those map features that are visible
 * and how they are styled.
 *
 * @see https://github.com/bensquire/php-static-maps-generator
 */
class Feature
{
    public const SEPARATOR = '|';

    protected $validFeatures = [
        'administrative',
        'administrative.country',
        'administrative.land_parcel',
        'administrative.locality',
        'administrative.neighborhood',
        'administrative.province',
        'all',
        'landscape',
        'landscape.man_made',
        'landscape.natural',
        'poi',
        'poi.attraction',
        'poi.business',
        'poi.government',
        'poi.medical',
        'poi.park',
        'poi.place_of_worship',
        'poi.school',
        'poi.sports_complex',
        'road',
        'road.arterial',
        'road.highway',
        'road.highway.controlled_access',
        'road.local',
        'transit',
        'transit.line',
        'transit.station',
        'transit.station.airport',
        'transit.station.bus',
        'transit.station.rail',
        'water'
    ];
    protected $validElements = ['all', 'geometry', 'labels'];
    protected $feature = null;
    protected $element = null;
    protected $style = null;

    public function __construct(array $params = [])
    {
        if (isset($params['feature'])) {
            $this->setFeature($params['feature']);
        }

        if (isset($params['element'])) {
            $this->setElement($params['element']);
        }

        if (isset($params['style'])) {
            $this->setStyle($params['style']);
        }
    }

    /**
     * Sets the type of feature the object represents
     *
     * @param $feature
     * @return $this
     * @throws \Exception
     */
    public function setFeature(string $feature)
    {
        if (!in_array($feature, $this->validFeatures)) {
            throw new \Exception('Unknown Map Feature');
        }

        $this->feature = $feature;
        return $this;
    }

    /**
     * Creates the feature styling object either using an associative array of values or by passing in an instance of _FeatureStyling.
     *
     * @param $style
     * @return $this
     * @throws \Exception
     */
    public function setStyle($style)
    {
        if ($style instanceof \GoogleStaticMap\FeatureStyling) {
            $this->style = $style;
            return $this;
        }

        if (is_array($style)) {
            $this->style = new \GoogleStaticMap\FeatureStyling($style);
            return $this;
        }

        throw new \Exception('Invalid type passed to Map Feature Styling.');
    }

    /**
     * Sets the element of the feature you are styling, 'all', 'geometry', 'labels'.
     *
     * @param $element
     * @return $this
     * @throws \Exception
     */
    public function setElement(string $element)
    {
        if (!in_array($element, $this->validElements)) {
            throw new \Exception('Unknown Map Element');
        }

        $this->element = $element;
        return $this;
    }

    /**
     * Returns the feature being edited
     *
     * @return string
     */
    public function getFeature(): string
    {
        return $this->feature;
    }

    /**
     * Returns the features styling object.
     *
     * @return \GoogleStaticMap\FeatureStyling
     */
    public function getStyle(): ?\GoogleStaticMap\FeatureStyling
    {
        return $this->style;
    }

    /**
     * Returns the element of the feature that's being styled
     *
     * @return string
     */
    public function getElement(): string
    {
        return $this->element;
    }

    /**
     * Builds the url string of the feature styling
     *
     * @return string
     */
    public function build(): string
    {
        if ($this->style instanceof \GoogleStaticMap\FeatureStyling) {
            $styles = $this->style->build();
        }

        return 'style=feature:' . $this->feature . $this::SEPARATOR . 'element:' . $this->element . ((isset($styles) ? $this::SEPARATOR . $styles : ''));
    }
}
