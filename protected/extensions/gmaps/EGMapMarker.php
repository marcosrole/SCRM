<?php

/**
 * 
 * EGMapMarker
 * A GoogleMap Marker
 * 
 * @author Antonio Ramirez
 * 
 * @since 2010-12-22 modified by Antonio Ramirez 
 * 
 * change log:
 * @since 2011-01-21 by Antonio Ramirez
 * - Included support for different types of Markers
 * - Implemented new and specially for EGMap modified version of CJavaScript::encode
 * - Fixed logic bug on setOption function
 * - Removed the need of optionsToJs function
 * - Included option for global info window
 * - included different types of Marker Object support
 * - EGMap::encode deprecates the use of optionsToJs
 * 
 * @TODO: modify $events to CTypeMap('EGMapEvent')
 * 
 * 
 * @copyright 
 * info as this library is a modified version of Fabrice Bernhard 
 * 
 * Copyright (c) 2008 Fabrice Bernhard
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software 
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
 * subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial 
 * portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT
 * LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
 * NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE 
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */
class EGMapMarker
{
	
  	protected static $_counter = 0;
    /**
    * javascript name of the marker
    *
    * @var string
    */
  	protected $js_name        = null;
  
  	protected $options = array(
    //  Map  Map on which to display Marker.  
    'map' => null,
    // LatLng  Marker position. Required.  
    'position' => null,
    // string  Rollover text  
    'title' => null,
    // Icon  for the foreground  
    'icon' => null,
    // Shadow  image  
    'shadow' => null,
    // Object  Image map region for drag/click. Array of x/y values that define the perimeter of the icon.  
    'shape' => null,
    // string  Mouse cursor to show on hover  
    'cursor' => null,
    // boolean  If true, the marker can be clicked  
    'clickable' => null,
    // boolean  If true, the marker can be dragged.  
    'draggable' => null,
    // boolean  If true, the marker is visible  
    'visible' => null,
    // boolean  If true, the marker shadow will not be displayed.  
    'flat' => null,
    // number  All Markers are displayed on the map in order of their zIndex, with higher values displaying in front of Markers with lower values. By default, Markers are displayed according to their latitude, with Markers of lower latitudes appearing in front of Markers at higher latitudes.  
    'zIndex' => null,
  	);
  	protected $info_window 			= null;
  	protected $info_window_shared 	= false;
  	protected $events         		= array();
  	protected $custom_properties 	= array();
  	/**
   	* 
   	* Included support for different types of Markers
   	* @var string marker object type (defaults to Marker)
   	*/
  	protected $marker_object		= 'google.maps.Marker';
  	/**
  	 * 
  	 * Private reference to the coords (position)
  	 * @var EGMapCoord
  	 */
  	private $_coord;
  
  /**
   * @param string $js_name Javascript name of the marker
   * @param float $lat Latitude
   * @param float $lng Longitude
   * @param EGMapIcon $icon
   * @param EGmapEvent[] array of GoogleMap Events linked to the marker
   * @author Fabrice Bernhard
   * @since 2010-12-22 modified by Antonio Ramirez
   */
  public function __construct( $lat, $lng, $options = array(), $js_name='marker', $events=array() )
  {
    $this->js_name = ($js_name ==='marker'?$js_name.(self::$_counter++):$js_name);
    
    if(isset($options['title'])) $options['title'] = CJavaScript::encode($options['title']);
    
    $this->setOptions($options);
    $this->setGMapCoord(new EGMapCoord($lat,$lng));
    $this->events  = $events;    
  }
  
  /**
   * Construct from a EGMapGeocodedAddress object
   *
   * @param string $js_name
   * @param EGMapGeocodedAddress $gmap_geocoded_address
   * @return EGMapMarker
   */
  public static function constructFromGMapGeocodedAddress($gmap_geocoded_address,$js_name='marker')
  {
    if (!$gmap_geocoded_address instanceof EGMapGeocodedAddress)
    {
      throw new CException(Yii::t('EGMap', 'object passed to constructFromGMapGeocodedAddress is not a EGMapGeocodedAddress'));
    }
    
    return new EGMapMarker($js_name,$gmap_geocoded_address->getLat(),$gmap_geocoded_address->getLng());
  }
  
  /**
  * @return string $js_name Javascript name of the marker  
  */
  public function getName()
  {
    return $this->js_name;
  }
  
  /**    
  * @return  null | string js constructor $icon  
  * @since 2011-01-08 modified by Antonio Ramirez
  */
  public function getIcon()
  {
    return $this->options['icon'];
  }
  /**
   * 
   * Sets the icon URL or a EGMapMarkerImage
   * @param string js object constructor|EGMapMarkerImage $icon
   * @author Antonio Ramirez
   * @since 2011-01-08 by Antonio Ramirez
   */
  public function setIcon( $icon ){
  	
  	$this->options['icon'] = $icon instanceof EGMapMarkerImage? $icon->toJs(): $icon;
  }
  /**    
  * @return null|string js constructor $shadow 
  * @author Antonio Ramirez 
  */
  public function getShadow()
  {
    return $this->options['shadow'];
  }
  /**
   * 
   * Sets the icon URL or a EGMapMarkerImage
   * @param string js object constructor|EGMapMarkerImage $shadow
   * @author Antonio Ramirez
   */
  public function setShadow( $shadow ){
  	$this->options['shadow '] = $shadow instanceof EGMapMarkerImage? $shadow->toJs(): $shadow;
  }
  /**
   * @param array $options
   * @author fabriceb
   * @since 2009-08-21
   * @modified by Antonio Ramirez
   */
  public function setOptions($options)
  {
  	if(isset($options['title'])) $options['title'] = CJavaScript::encode($options['title']);
    $this->options = array_merge($this->options, $options);
  }
  /**
   * @return array $options
   * @author fabriceb
   * @since 2009-08-21
   */
  public function getOptions()
  {

    return $this->options;
  }
    /**
   * 
   * @param string $name
   * @return mixed
   * @author fabriceb
   * @since 2009-08-21
   */
  public function getOption($name)
  {
    if(isset($this->options[$name]))
    	return $this->options[$name];
    return false;
  }
  
  /**
   * 
   * @param string $name
   * @param mixed $value
   * @return void
   * @author fabriceb
   * @since 2009-08-21
   * @since 2011-01-22 by Antonio Ramirez
   * 		fixed logical bug
   */
  public function setOption($name, $value)
  {
  	switch (strtolower($name)){
  		case 'shadow':
  			$this->setShadow($name);
  			break;
  		case 'position':
  			$this->setGMapCoord($value);
  			break;
  		case 'icon':
  			$this->setIcon($name);
  			break;
  		case 'title':
  			$this->options[$name] = '"'.$value.'"';
  			break;
  		default:
  			$this->options[$name] = $value;
  	}
    
  }
  
  /**
   * returns the coordinates object of the marker
   * 
   * @return EGMapCoord
   * @author Antonio Ramirez
   */
  public function getGMapCoord()
  {
    return $this->_coord;
  }
  /**
   * sets the coordinates object of the marker
   * 
   * @param EGMapCoord
   * @author Antonio Ramirez
   */
  public function setGMapCoord($gmap_coord)
  {
  	if(!$gmap_coord instanceof EGMapCoord)
  		throw new CException(Yii::t('EGMap','Marker coordenates must be of type EGMapCoord'));
  	$this->_coord = $gmap_coord;
    $this->options['position'] = $this->_coord->toJs();
  }  
  /**
  * @return float $lat Javascript latitude  
  */
  public function getLat()
  {
    
    return $this->getGMapCoord()->getLatitude();
  }
  /**
  * @return float $lng Javascript longitude  
  */
  public function getLng()
  {
    
    return $this->getGMapCoord()->getLongitude();
  }
  
  /**
  * @param string $map_js_name 
  * @return string Javascript code to create the marker
  * @author Fabrice Bernhard
  * @since 2009-08-21
  * @since 2010-12-22 modified by Antonio Ramirez
  * @since 2011-01-08 modified by Antonio Ramirez
  * 		Removed EGMapMarkerImage conversion
  * @since 2011-01-11 included option for global info window
  * @since 2011-01-22 included different types of Marker Object support
  * 				  EGMap::encode deprecates the use of optionsToJs
  * @since 2011-01-23 fixed logic bug
  * 				  
  */
  public function toJs($map_js_name = 'map')
  {
    $this->setOption('map', $map_js_name);
    
    $return = '';
    if($this->info_window instanceof EGMapInfoWindow)
    {
    	if($this->info_window_shared){
    		$info_window_name = $map_js_name.'_info_window';
    		$this->addEvent(new EGMapEvent('click','if ('.$info_window_name.') '.$info_window_name.'.close(); '.$info_window_name.' = '.$this->info_window->getName().'; '.$this->info_window->getName().".open(".$map_js_name.",".$this->getName().");"));
    	}
      	else 
      		$this->addEvent(new EGMapEvent('click',$this->info_window->getName().".open(".$map_js_name.",".$this->getName().");"));
      $return .= $this->info_window->toJs();
    }
    $return .=' 
    		var '. $this->getName().' = new '.$this->marker_object.'('.EGMap::encode($this->options).");\n";
    foreach ($this->custom_properties as $attribute=>$value)
    {
      $return .= $this->getName().".".$attribute." = '".$value."';";
    }
    foreach ($this->events as $event)
    {
      $return .= '    '.$event->getEventJs($this->getName())."\n";
    }   
    
    return $return;
  }
  
  /**
   * Adds an event listener to the marker
   *
   * @param GMapEvent $event
   */
  public function addEvent($event)
  {
    array_push($this->events,$event);
  }
  /**
   * Adds an onlick listener that open a html window with some text 
   *
   * @param EGMapInfoWindow $info_window
   * @param boolean $shared among other markers (unique info_window display)
   * 
   * @author Antonio Ramirez
   * @since 2011-01-23 Added shared functionality for infoWindows
   */
  public function addHtmlInfoWindow( EGMapInfoWindow $info_window, $shared = true )
  {
    $this->info_window = $info_window;
    $this->info_window_shared = $shared;
  }
  /**
   * 
   * @return boolean if info window is shared or not
   */
  public function htmlInfoWindowShared(){
  	return $this->info_window_shared;
  }
  
  /**
  * @return EGMapInfoWindow
  * @author Antonio Ramirez
  */
  public function getHtmlInfoWindow()
  {
  
    return $this->info_window;
  }
  
  /**
   * Returns the code for the static version of Google Maps
   * @TODO Add support for color and alpha-char
   * @author Laurent Bachelier
   * @return string
   */
  public function getMarkerStatic()
  {
    
    return $this->getLat().','.$this->getLng();
  }
  /**
   * 
   * Sets custom properties to the Marker
   * @param array $custom_properties
   */
  public function setCustomProperties($custom_properties)
  {
  	if(!is_array($custom_properties))
  		throw new CException(Yii::t('EGMap','EGMapMarker custom properties must of type array to be set'));
    $this->custom_properties=$custom_properties;
  }
  /**
   * 
   * @return array custom properties
   */
  public function getCustomProperties()
  {
    
    return $this->custom_properties;
  }
  /**
   * Sets a custom property to the generated javascript object
   *
   * @param string $name
   * @param string $value
   */
  public function setCustomProperty($name,$value)
  {
    $this->custom_properties[$name] = $value;
  }
  
  /**
  *
  * @param EGMapMarker[] $markers array of MArkers
  * @return EGMapCoord
  * @author fabriceb
  * @since 2009-05-02
  *
  **/
  public static function getMassCenterCoord($markers)
  {
    $coords = array();
    foreach($markers as $marker)
    {
      array_push($coords, $marker->getGMapCoord());
    }
   
    return EGMapCoord::getMassCenterCoord($coords);
  }
  
  /**
  *
  * @param EGMapMarker[] $markers array of MArkers
  * @return EGMapCoord
  * @author fabriceb
  * @since 2009-05-02
  *
  **/
  public static function getCenterCoord($markers)
  {
    $bounds = EGMapBounds::getBoundsContainingMarkers($markers);
  
    return $bounds->getCenterCoord();
  }
  
  /**
   * 
   * @param EGMapBounds $gmap_bounds
   * @return boolean $is_inside
   * @author fabriceb
   * @since Jun 2, 2009 fabriceb
   */
  public function isInsideBounds(EGMapBounds $gmap_bounds)
  {
  
    return $this->getGMapCoord()->isInsideBounds($gmap_bounds);
  }
  
}
