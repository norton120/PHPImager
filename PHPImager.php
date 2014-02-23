<?php
/**
 * PHPImager 
 * A simple class to modify images in browser.
 * 
 * @author Knox Modern Media
 * 
 * 
 * @Copyright (c) <2014> <Knox Modern Media>
 *   
 *   Permission is hereby granted, free of charge, to any person obtaining a copy
 *   of this software and associated documentation files (the "Software"), to deal
 *   in the Software without restriction, including without limitation the rights
 *   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *   copies of the Software, and to permit persons to whom the Software is
 *   furnished to do so, subject to the following conditions:
 *   
 *   The above copyright notice and this permission notice shall be included in
 *   all copies or substantial portions of the Software.
 *   
 *   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *   THE SOFTWARE.
 * 
 * @license http://opensource.org/licenses/MIT
 * @version 1.1.0
 * 
 */
 
 class PHPImager{
 /**
  * The class error log.
  * 
  * @var string
  */
  protected $error;
  
 /**
  * The original image filename
  * 
  * @var string
  */  
  public $original;
 
 /**
  * The height of the original image.
  * 
  * @var float;
  */
  protected $original_height;
 
 /**
  * The width of the original image.
  * 
  * @var float;
  */
  protected $original_width;
 
 /**
  * The image that is being manipulated.
  * 
  * @var resource 
  */
  protected $image;
     
 /**
  * The original image type, 
  * accepted are {
  *     @type IMAGETYPE_GIF
  *     @type IMAGETYPE_JPEG
  *     @type IMAGETYPE_PNG
  *     @type IMAGETYPE_BMP
  * }
  */
  protected $original_type; 
  
 /**
  * The orientation of the original image (if given).
  * Expressed in degrees from upright or the orientation change, ie {
  *     @type 0 = no rotation (upright).
  *     @type FH = flipped horizontally. 
  *     @type 180 = 180 rotation (upside down).
  *     @type FV = flipped vertically.
  *     @type 90FH = 90 rotation, flipped horizontally.
  *     @type 270 = 270 rotation.
  *     @type 90FV = 90 flipped vertically.
  *     @type 90 = 90 rotation.
  *     }
  */
  protected $original_orientation;
 
 /**
  * The GPS latitude of the original image, in decimal form.
  * 
  * @var float
  */
  protected $original_latitude;
 
 /**
  * The GPS longitude of the original image, in decimal form.
  * 
  * @var float
  */
  protected $original_longitude;
 
 /**
  * The date the original image was created.
  * 
  * @var string
  */ 
  protected $original_created_date;
 
 /**
  * The time the original image was created.
  * 
  * @var string
  */ 
  protected $original_created_time;
  
 /**
  * The keywords associated with the the original image, in CSV string.
  * 
  * @var string
  */
  protected $original_keywords;
   
 /**
  * The copywright of the original image.
  * 
  * @var string
  */                        
  protected $original_copywright;      
     
 /**
  * The headline of the original image.
  * 
  * @var string
  */                        
  protected $original_headline;      
     
 /**
  * The special instructions of the original image.
  * 
  * @var string
  */                        
  protected $original_special_instructions;      
    
 /**
  * The subject of the original image.
  * 
  * @var string
  */                        
  protected $original_subject;      
   
 /**
  * The caption of the original image.
  * 
  * @var string
  */                        
  protected $original_caption;
        
 /**
  * The category of the original image.
  * 
  * @var string
  */                        
  protected $original_category;      
 
 /**
  * The contact information of the original image author.
  * 
  * @var string
  */                        
  protected $original_contact;      
    
 /**
  * The source of the original image.
  * 
  * @var string
  */                        
  protected $original_source;      
  
 /**
  * The credit of the original image.
  * 
  * @var string
  */                        
  protected $original_credit;      
 
 /**
  * The city location of the original image.
  * 
  * @var string
  */                        
  protected $original_city;      
 
 /**
  * The local location of the original image.
  * 
  * @var string
  */                        
  protected $original_sublocation;      
 
 /**
  * The state/province of the original image.
  * 
  * @var string
  */                        
  protected $original_state;      
                          
 /**
  * The image type to output. 
  * Default type matches input.
  * 
  * @var constant one of the predefined image constants{
  *     @type IMAGETYPE_GIF
  *     @type IMAGETYPE_JPEG
  *     @type IMAGETYPE_PNG
  *     @type IMAGETYPE_BMP
  * }
  */ 
  protected $type;

 /**
  * The color to fill the background with when an area is exposed. 
  * Default is white, transparent for PNG and GIF.
  */  
 protected $background_color;
  
 
 //public resources
 
 /**
  * If TRUE, echo errors on failure.
  * Default FALSE,
  * 
  * @var boolean
  */
  public $debug;

 /**
  * The finished image width
  * 
  * @var int
  */
  public $width;
  
 /**
  * The finished image height
  * 
  * @var int
  */
  public $height;
 
 /**
  * If TRUE, will attempt to use metadata to correct image orientation.
  * Default TRUE. 
  * 
  * @var boolean
  */ 
  public $auto_orientation;
  
 /**
  * File location for a semi-transparent watermark PNG. File transparency should already be set. 
  * 
  * @var string
  */ 
  public $watermark;
  
 /**
  * The public temporary file folder for the modified file
  * 
  * @var string
  */ 
  public $temp;
 //methods
  
  /**
   * Set the original image to be modified.
   * 
   * @param string $image the filename/location of the image to be modified.
   * @return void.
   *
   */
  function __construct($image){
      $this->debug = FALSE;
      $this->original =$image;
      $this->original_orientation ="";
      $this->original_latitude ="";
      $this->original_longitude ="";
      $this->original_created_date="";
      $this->original_created_time="";
      $this->original_keywords="";
      $this->original_headline="";
      $this->original_copywright="";
      $this->original_special_instructions="";
      $this->original_subject="";
      $this->original_caption="";
      $this->original_category="";
      $this->original_contact="";
      $this->original_source="";
      $this->original_credit="";
      $this->original_city="";
      $this->original_sublocation="";
      $this->original_state="";
      $this->auto_orientation = TRUE;
  }
  
  /**
   * Returns error log.
   * 
   * @param void;
   * @return string;
   */
   public function return_errors(){
       return $this->error;
   }
   
  /**
   * Checks for the GD library.
   * 
   * @param void
   * @return boolean 
   */
   protected function GD_installed(){
       if(extension_loaded("gd") && function_exists("gd_info")){
           return TRUE;
       }
       return FALSE;
   }
   
  /**
   * Sets the baselines of the original image
   * 
   * @param void
   * @return void sets type to $this->type;
   */
   protected function original_information(){
    
    $size = getimagesize($this->original,$info);
    $this->$original_width = $size[0];
    $this->$original_height = $size[1];
    
    $valid_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_JPEG2000, IMAGETYPE_PNG, IMAGETYPE_BMP);
    
    if(in_array($size[2], $valid_types)){
        $this->original_type = $size[2];
        $this->type = $size[2];
    }
    else{
        $this->error .= date('n/d/Y g:i:s')." Invalid image format. Must be PNG, JPEG, GIF or WBMP.\n";
        if($this->debug){
            echo $this->error;
        }
        return false;     
    }
    
        
    if($this->original_type == IMAGETYPE_JPEG || $this->original_type == IMAGETYPE_JPEG2000 ){
            
        if(isset($info['APP13'])){
      //get IPTC data        
            $data = array('created_date'=>'2#055',
                          'created_time'=>'2#060',
                          'keywords'=>'2#025',
                          'copywright'=>'2#116',
                          'headline'=>'2#105',
                          'special_instructions'=>'2#040',
                          'subject'=>'2#012',
                          'category'=>'2#015',
                          'caption'=>'2#120',
                          'contact'=>'2#118',
                          'source'=>'2#115',
                          'credit'=>'2#110',
                          'city'=>'2#90',
                          'sublocation'=>'2#92',
                          'state'=>'2#095');
            
            $IPTC = iptcparse($info['APP13']);
                    
            foreach($data as $key => $code){
                if(!empty($IPTC[$code])){
                    if(is_array($IPTC[$code])){
                        foreach($IPTC[$code] as $value){
                            $this->original_.$key = $this->original_.$key.",".$IPTC[$code][$value];
                        }
                    }
                    else{
                        $this->original_.$key = $IPTC[$code][0];
                    }
                        
                }
            }
        }
        
      
        $exif = exif_read_data($this->original);
        
            //orientation 
            if(!empty($exif['Orientation'])){
                if($exif['Orientation'] == 1){
                    $this->original_orientation == "0";
                }
                else if ($exif['Orientation'] == "2"){
                    $this->original_orientation == "FH";
                }
                
                else if ($exif['Orientation'] == "3"){
                    $this->original_orientation == "180";
                }
                
                else if ($exif['Orientation'] == "4"){
                    $this->original_orientation == "FV";
                }
                
                else if ($exif['Orientation'] == "5"){
                    $this->original_orientation == "90FH";
                }
                
                else if ($exif['Orientation'] == "6"){
                    $this->original_orientation == "270";
                }
                
                else if ($exif['Orientation'] == "7"){
                    $this->original_orientation == "90FV";
                }
                
                else if ($exif['Orientation'] == "8"){
                    $this->original_orientation == "90";
                }
            }  
            
            //Geolocation
            if(!empty($exif['GPSLatitudeRef']) && !empty($exif['GPSLongitudeRef'])){
                    
                if($exif['GPSLatitudeRef'] == "S"){
                    $latitude = "-";
                }
                  
                $latitude = (float) strstr($exif['GPSLatitude'][0], "/",TRUE); 
                
                $latitude = $latitude + (((strstr($exif['GPSLatitude'][1], "/",TRUE)*60) + strstr($exif['GPSLatitude'][2], "/",TRUE))/3600);  
                
                    
                $this->original_latitude = $latitude;
            
                if($exif['GPSLongitudeRef'] == "W"){
                    $longitude = "-";
                }
                  
                $longitude = (float) strstr($exif['GPSLongitude'][0], "/",TRUE); 
                
                $longitude = $longitude + (((strstr($exif['GPSLongitude'][1], "/",TRUE)*60) + strstr($exif['GPSLongitude'][2], "/",TRUE))/3600);  
                    
                $this->original_longitude = $longitude;
             
            }
    }
    
    
    
       
   }  
 
  /**
   * Create the image to be manipulated.
   * Sets background image color default based on image type.
   * @param void.
   * @return resource.
   * 
   */
   protected function create_image(){
       if($this->original_type = IMAGETYPE_JPEG || $this->original_type = IMAGETYPE_JPEG2000 ){
           if(!$this->image = imagecreatefromjpeg($this->original)){
                $this->error .= date('n/d/Y g:i:s')." Failed to create image from Jpeg.\n";
                if($this->debug){
                    echo $this->error;
                }
            return false;
           }
           $this->background_color = imagecolorallocate($this->image, 255, 255, 255);
       }
 
       else if($this->original_type = IMAGETYPE_PNG){
             if(!$this->image = imagecreatefrompng($this->original)){
                $this->error .= date('n/d/Y g:i:s')." Failed to create image from PNG.\n";
                if($this->debug){
                    echo $this->error;
                }
            return false;
           }
          
           $this->background_color = imagecolortransparent($this->image, imagecolorallocatealpha($this->image, 255, 255, 255, 127));
           imagesavealpha($this->image, TRUE);
             
       }
 
       else if($this->original_type = IMAGETYPE_GIF){
             if(!$this->image = imagecreatefromgif($this->original)){
                $this->error .= date('n/d/Y g:i:s')." Failed to create image from GIF.\n";
                if($this->debug){
                    echo $this->error;
                }
            return false;
           }
           $this->background_color = imagecolortransparent($this->image, imagecolorallocatealpha($this->image, 255, 255, 255, 127));
           imagesavealpha($this->image, TRUE);
           imagealphablending($this->image, FALSE);
       }
 
       else if($this->original_type = IMAGETYPE_BMP){
             if(!$this->image = imagecreatefromjpeg($this->original)){
                $this->error .= date('n/d/Y g:i:s')." Failed to create image from BMP.\n";
                if($this->debug){
                    echo $this->error;
                }
            return false;
           }
           $this->background_color = imagecolorallocate($this->image, 255, 255, 255);  
       }
       else{
            $this->error .= date('n/d/Y g:i:s')." Invalid image format. Must be PNG, JPEG, GIF or WBMP.\n";
                if($this->debug){
                    echo $this->error;
                }
            return false;     
       }
       
   }
 
  /**
   * Fixes image orientation if orientation info is given.
   * 
   * @param void;
   * @return void;
   */
   protected function correct_orientation(){
       if(!empty($this->original_orientation)){
            if($this->original_orientation == "FH"){
                imageflip($this->image, IMG_FLIP_HORIZONTAL);
            }
            
            else if($this->original_orientation == "FV"){
                imageflip($this->image, IMG_FLIP_VERTICAL);
            }
            
            else if($this->original_orientation == "180"){
                imagerotate($this->image, 180, $this->background_color);
            }
            
            else if($this->original_orientation == "90FH"){
                imageflip($this->image, IMG_FLIP_HORIZONTAL);
                imagerotate($this->image, 90, $this->background_color);
            }
            
            else if($this->original_orientation == "90FV"){
                imageflip($this->image, IMG_FLIP_VERTICAL);
                imagerotate($this->image, 90, $this->background_color);
            }
            
            else if($this->original_orientation == "270"){
                 imagerotate($this->image, 270, $this->background_color);
            }
            
            else if($this->original_orientation == "90"){
                 imagerotate($this->image, 90, $this->background_color);
            }    
       }
   }
 
  /**
   * Set the background image color.
   * @param int $red the red channel value
   * @param int $green the green channel value
   * @param int $blue the blue channel value
   * @param int $alpha the alpha channel value (0 is opaque, 127 is fully transparent. PNG and GIF only) 
   * 
   * @return void. 
   */ 
   public function set_background_color($red, $green, $blue, $alpha=NULL){
       
        if($alpha != NULL && ($this->type == IMAGETYPE_GIF || $this->type == IMAGETYPE_GIF)){
            if(!$this->background_color = imagecolortransparent($this->image, imagecolorallocatealpha($this->image, $red, $green, $blue, $alpha))
               && imagesavealpha($this->image, TRUE)){
                $this->error .= date('n/d/Y g:i:s')." Failed to set background color.\n";
                if($this->debug){
                    echo $this->error;
                }
                return false;
           }
        }

        else{
            if(!$this->background_color = imagecolorallocate($this->image, $red,$green,$blue)){
                $this->error .= date('n/d/Y g:i:s')." Failed to set background color.\n";
                if($this->debug){
                    echo $this->error;
                }
                return false;
            }
        }
       
   } 
       
  /**
   * Resizes and crops the image.
   * 
   * @param void.
   * @return void.
   *   
   */
   public function resize(){
        
    //determine the scale     
     if($this->width > $this->height){
         $ratio = $this->width/$this->original_width;
     }    
     else{
         $ratio = $this->height/$this->original_height;
     }  
     
     
       
     //get scaled dim of original
       $new_height = $this->original_height * $ratio;
       $new_width = $this->original_width * $ratio;
     
     //create the new canvas  
       $modified_image = imagecreatetruecolor($this->width, $this->height);
     
     //determine cropping needed  
        $start_x = 0;
        $start_y = 0;
        
       if($new_height != $this->height){
           $start_y = round(abs($new_height-$this->height)/2);
       }
       
       if($new_width != $this->width){
           $start_y = round(abs($new_height-$this->height)/2);
       }
       
       if(!imagecopyresampled($this->image, $modified_image, 0, 0, $start_x, $start_y, $this->width, $this->height, $this->original_width, $this->original_height)){
            $this->error .= date('n/d/Y g:i:s').' failed to scale image.'."\n";
            if($this->debug){
                echo $this->error;
            }
            
            return false;
       }
       
       $this->image = $modified_image;
       
       imagedestroy($modified_image);
   }   
  
  /**
   * Rotates the image.
   * 
   * @param int $deg the number of degrees to rotate the image.
   * @param string $direction 'clockwise'||'counterclockwise' the direction to rotate. Default is clockwise.
   * @return void
   */
   public function rotate($deg, $direction='clockwise'){
       
       if($direction == "clockwise"){
           $deg = $deg* -1; 
       }
       
       if(!$modified_image = imagerotate($this->image, $deg, $this->background_color)){
            $this->error .= date('n/d/Y g:i:s').' failed to rotate image.'."\n";
            if($this->debug){
                echo $this->error;
            }
            
            return false;
       }
       
       $this->image = $modified_image;
       
   }
   
  /**
   * Watermark the image. 
   *  
   * @param none
   * @return void
   */ 
   public function set_watermark($offset_x, $offset_y){
       
    if(empty($this->watermark)){
        $this->error .= date('n/d/Y g:i:s').' No watermark file set.'."\n";
        if($this->debug){
            echo $this->error;
        }
      
        return false;
       
      }
        
     if(strtolower(substr($this->watermark, -3)) != "png" ){
       $this->error .= date('n/d/Y g:i:s').' watermark file must be a png file.'."\n";
        if($this->debug){
            echo $this->error;
        }
      
        return false;
       
      }  
      
      $watermark = imagecreatefrompng($this->watermark);
        
      $start_x = $this->width - imagesx($watermark) - $offset_x; 
      
      $start_y = $this->height - imagesy($watermark) - $offset_y;  
   
      imagealphablending($this->image, TRUE); 
   
      if(!imagecopy($this->image, $watermark, $start_x,$start_y, 0, 0, imagesx($watermark), $imagesy($watermark))){
            $this->error .= date('n/d/Y g:i:s').' failed to create watermark.'."\n";
            if($this->debug){
                echo $this->error;
            }
            
            return false;
      }    
        
      imagedestroy($watermark);     
   }    
   
  /**
   * Apply filters to the image. These are the basic filters from GD, nothing fancy.
   * 
   * @param string $filter the filter to apply. options include 'negate'|'grayscale'|'brighten'|'contrast'|'emboss'|'blur'|'sketchy'|'smooth'|'pixelate'
   *     
   * @return void
   */    
   public function apply_filter($filter){
       $filters = array('negate','grayscale','brighten','contrast','emboss','blur','sketchy','smooth','pixelate');
       
       if(!in_array($filter,$filters)){
                 $this->error .= date('n/d/Y g:i:s').' invalid filter.'."\n";
            if($this->debug){
                echo $this->error;
            }
            
            return false;
       }
       
       $arg1 = NULL;
       $arg2 = NULL;
       
       
       if($filter == "negate"){
           $filter = IMG_FILTER_NEGATE;
       }
       else if( $filter == "grayscale"){
           $filter = IMG_FILTER_GRAYSCALE;
       }       
       else if( $filter == "brighten"){
           $filter = IMG_FILTER_BRIGHTNESS;
           $arg1 = 20;
       }
       else if( $filter == "contrast"){
           $filter = IMG_FILTER_CONTRAST;
           $arg1 = 20;
       }
       else if( $filter == "emboss"){
           $filter = IMG_FILTER_EMBOSS;
       }
       else if( $filter == "blur"){
           $filter = IMG_FILTER_GAUSSIAN_BLUR;
       }
       else if( $filter == "sketchy"){
           $filter = IMG_FILTER_MEAN_REMOVAL;
       }
       else if( $filter == "smooth"){
           $filter = IMG_FILTER_SMOOTH;
           $arg1 = 20;
       }
       else if( $filter == "pixelate"){
           $filter = IMG_FILTER_PIXELATE;
           $arg1 = 5;
           $arg2 = TRUE;
       }
       
       if(!imagefilter($this->image, $filter, $arg1, $arg2)){
            $this->error .= date('n/d/Y g:i:s').' Failed to apply filter.'."\n";
            if($this->debug){
                echo $this->error;
            }
            
            return false;
       }
       
       
   }
 

 /**
  * Outputs the modified image to a file, or returns it 
  * 
  * @param bool $file if TRUE returns the file location of the image. Default TRUE;
  * @return string|array if $file is TRUE, returns that file location, else returns an array{
  *     'header' = > the header image type for the image
  *     'image' => the image itself
  * }
  */
  public function output_image($file=TRUE){
 
        
    if($this->type == IMAGETYPE_PNG){
        if($file){
            
            $location = $this->temp.time().".png";   
            imagepng($this->image,$location);
        }
        else{
            $return_header = 'Content-Type: image/png';
            $return = imagepng($this->image);
        }
    }            
     
    if($this->type == IMAGETYPE_JPEG){
        if($file){
            
            
            $location = $this->temp.time().".jpg";   
            imagejpeg($this->image,$location);
        }
        else{
            $return_header = 'Content-Type: image/jpeg';
            $return = imagejpeg($this->image);
        }
    }
    if($this->type == IMAGETYPE_WBMP){
        if($file){
            
            
            $location = $this->temp.time().".bmp";   
            imagewbmp($this->image,$location);
        }
        else{
            $return_header = 'Content-Type: image/bmp';
            $return = imagewbmp($this->image);
        }
    }
    
    if($this->type == IMAGETYPE_GIF){
        if($file){
            
            $location = $this->temp.time().".gif";   
            imagegif($this->image,$location);
        }
        else{
            $return_header = 'Content-Type: image/gif';
            $return = imagegif($this->image);
        }
    }      
  
    image_destroy($this->image);
  
  
  if(!empty($return)){
      
     return array('header'=>$return_header, 'image'=>$return);
     
  }
  
  return $location;
  
  }
 
}
