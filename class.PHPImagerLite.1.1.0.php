<?php
/**
 * PHPImagerLite 
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
 * @example{
 * 
 *  $image = new PHPImager();
 * 
 *  $image->debug = TRUE; //echo errors
 *  $image->width = 500; //width of the output image, in pixels
 *  $image->height = 300;
 *  $image->output_type("jpg"); //the type of image to output
 *  
 *      $color = array(255,255,255,45); //array RGB or RGBA color values
 *  $image->rotate(44,$color); // sets the clockwise rotation (degrees) and background color for exposed parts.
 *  $image->filter('hot'); //applies the hot filter to the image.
 *  $image->resize(); //sizes and crops the image. Do any rotation before you do this.
 *  $image->watermark('watermark.png', 20, 5, "right" ); //places a watermark of watermark.png 5px from the bottom and 5px from the right corner, with 20% opacity.
 *  $image->return_image(TRUE,"../temp/"); //outputs the image to a file in the temp folder, returns the file pathname string.
 * }
 * 
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
  protected $original;
 
 /**
  * The original image type.
  * 
  * @var constant IMAGETYPE_PNG|IMAGETYPE_JPEG|IMAGETYPE_JPEG2000|IMAGETYPE_GIF
  */
  protected $original_type;  
 
 /**
  * The width of the original image, in pixels.
  * 
  * @var int
  */
  protected $original_width;
  
 /**
  * The height of the original image, in pixels.
  * 
  * @var int
  */
  protected $original_height;
 
 /**
  * The image type to output. 
  * Default type matches input.
  * 
  * @var constant one of the predefined image constants{
  *     @type IMAGETYPE_GIF
  *     @type IMAGETYPE_JPEG
  *     @TYPE IMAGETYPE_PNG
  *     @TYPE IMAGETYPE_JPEG2000
  * }
  */ 
  protected $output_type;
 
 /**
  * The resource while modifying the image.
  * 
  * @var resource
  */
  protected $image;
  
 /**
  * The background color object for the modified image.
  * 
  * @var resource
  */ 
  protected $bgd_color;

 //public resources
 
 /**
  * The finalized image width, in pixels
  * 
  * @var int
  */
  public $width;
  
 /**
  * The finalized image height, in pixels
  * 
  * @var int
  */   
  public $height;
 
 /**
 * If TRUE, echo errors on failure.
 * Default FALSE,
 * 
 * @var boolean
 */
 public $debug;
   
   
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
      $this->original = $image;
      if($this->GD_installed()){
          $this->original_information();
          
      }
      
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
       
       $this->error .=date('m/d/Y g:i:s a')." GD library is not present.\n";
       if($this->debug){
        echo $this->error;
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
    
    $size = getimagesize($this->original);
    $this->original_width = $size[0];
    $this->original_height = $size[1];
    
    $valid_types = array(1,2,3,9);
    
    if(in_array($size[2], $valid_types)){
        if($size[2] == 1){
            $this->original_type = IMAGETYPE_GIF;
        }
        else if($size[2] == 2){
            $this->original_type = IMAGETYPE_JPEG;
        }
        else if($size[2] == 3){
            $this->original_type = IMAGETYPE_PNG;
        }
        else if($size[2] == 9){
            $this->original_type = IMAGETYPE_JPEG2000; 
        }
    }
    else{
        $this->error .= date('n/d/Y g:i:s')." Invalid image format. Must be PNG, JPEG, GIF.\n";
        if($this->debug){
            echo $this->error;
        }
        return false;     
    }
    $this->output_type = $this->original_type;
    
    //build new image 
    
    if($this->original_type == IMAGETYPE_GIF){
        $this->image = imagecreatefromgif($this->original);
        
        $this->bgd_color = imagecolorallocatealpha($this->image, 0, 0, 0, 127);
        imagealphablending($this->image, TRUE);
        imagesavealpha($this->image, TRUE);     
    
    }
    else if($this->original_type == IMAGETYPE_JPEG || $this->original_type == IMAGETYPE_JPEG2000){
        $this->image = imagecreatefromjpeg($this->original);
        
        $this->bgd_color = imagecolorallocate($this->image, 255, 255, 255);
    }
    else if($this->original_type == IMAGETYPE_PNG){
        $this->image = imagecreatefrompng($this->original);
        imagecolortransparent($this->image,imagecolorallocate($this->image,0,0,0));
        imagealphablending($this->image, FALSE); imagesavealpha($this->image, TRUE);
    }
    
    
    
    //check orientation, correct if needed. 
    
    if($this->original_type == IMAGETYPE_JPEG || $this->original_type == IMAGETYPE_JPEG2000){
    $meta = exif_read_data($this->original);
    
    if(!empty($meta['Orientation'])){
           
        if($meta['Orientation'] == 2 && PHP_VERSION_ID > 50500){
            imageflip($this->image, IMG_FLIP_HORIZONTAL);        
        }
        else if($meta['Orientation'] == 3){
            imagerotate($this->image, 180, $this->bgd_color);        
        }
        else if($meta['Orientation'] == 4 && PHP_VERSION_ID > 50500){
            imageflip($this->image, IMG_FLIP_BOTH);
        }
        else if($meta['Orientation'] == 5 && PHP_VERSION_ID > 50500){
            imageflip($this->image, IMG_FLIP_HORIZONTAL);
            imagerotate($this->image, 90, $this->bgd_color);
        }
        else if($meta['Orientation'] == 6){
            imagerotate($this->image,-90, $this->bgd_color);
        }
        else if($meta['Orientation'] == 7 && PHP_VERSION_ID > 50500){
            imagerotate($this->image, -90, $this->bgd_color);
            imageflip($this->image, IMG_FLIP_VERTICAL);
        }
        else if($meta['Orientation'] == 8){
            imagerotate($this->image, 90, $this->bgd_color);
        }
    }
    
    }
    
    
    
       
   }  
 
  /**
   * Rotate the image
   * 
   * @param int $deg 0-360 rotate clockwise
   * @param array $bgd_color the background color for blank fill, in an RGB/RGBA array
   * @return void
   */  
  public function rotate($deg, $bgd_color=NULL){
       
       if(!empty($bgd_color) && is_array($bgd_color)){
           if(isset($bgd_color[3]) && ($this->output_type == IMAGETYPE_PNG || $this->output_type == IMAGETYPE_GIF) ){
               $this->bgd_color = imagecolorallocatealpha($this->image, $bgd_color[0], $bgd_color[1], $bgd_color[2], $bgd_color[3]);
           }
       
           else{
            $this->bgd_color = imagecolorallocate($this->image, $bgd_color[0], $bgd_color[1], $bgd_color[2]);
           }
       }
       
       $deg = $deg*(-1);
     
    if(!$rotated = imagerotate($this->image, $deg, $this->bgd_color)){
           $this->error .=date('m/d/Y g:i:s a')." failed to rotate image.\n";
           if($this->debug){
                echo $this->error;
                return FALSE;
           }
    }   
//dump and grab the new image 
     ob_start();
    
    if($this->output_type == IMAGETYPE_JPEG ||$this->output_type == IMAGETYPE_JPEG2000){
            imagejpeg($rotated);
         }
         
        else if($this->output_type == IMAGETYPE_GIF){
           imagegif($rotated);
        }
         
        else if($this->output_type == IMAGETYPE_PNG){
           imagepng($rotated);
        }
   $data = ob_get_clean();
   
   $this->image = imagecreatefromstring($data);
   
   if ($this->original_type == IMAGETYPE_PNG || $this->original_type == IMAGETYPE_GIF ){
        imagecolortransparent($this->image,imagecolorallocate($this->image,0,0,0));
        imagealphablending($this->image, FALSE); imagesavealpha($this->image, TRUE);
    }
 //set the new dimentions for the original  
   $this->original_height = imagesy($this->image);
   $this->original_width = imagesx($this->image);
   
   imagedestroy($rotated);
 
                   
   } 
 
  /**
   * Resizes and crops the image.
   * 
   * @param void
   * @return void
   * 
   */  
  public function resize(){
    
//determine the ratio 
    
    $input_aspect_ratio = $this->original_width / $this->original_height;
    $output_aspect_ratio = $this->width / $this->height; 
   
   if($input_aspect_ratio > $output_aspect_ratio){
    $new_height = $this->height;
       
    $new_width = intval($this->height * $input_aspect_ratio);
   }
   
   else{
    $new_height = intval($this->width / $input_aspect_ratio);
    $new_width = $this->width;
        
   }  
    
//resize first

    $temp_image = imagecreatetruecolor($new_width, $new_height);   
    if ($this->original_type == IMAGETYPE_PNG || $this->original_type == IMAGETYPE_GIF ){
        imagecolortransparent($temp_image,imagecolorallocate($temp_image,0,0,0));
        imagealphablending($temp_image, FALSE); imagesavealpha($temp_image, TRUE);
    }
    imagecopyresampled($temp_image, $this->image, 0, 0, 0, 0, $new_width, $new_height, $this->original_width, $this->original_height);
    
    
//calculate the offset to crop              

    $start_x = 0;
    $start_y = 0;           
               
   
        $start_y = ($new_height - $this->height)/2;
    
        $start_x = ($new_width - $this->width)/2;
    
    $modified_image = imagecreatetruecolor($this->width,$this->height);    
    if ($this->original_type == IMAGETYPE_PNG || $this->original_type == IMAGETYPE_GIF ){
        imagecolortransparent($modified_image,imagecolorallocate($modified_image,0,0,0));
        imagealphablending($modified_image, FALSE); imagesavealpha($modified_image, TRUE);
    }
    
    
    
        if(!imagecopy($modified_image, $temp_image,0,0,$start_x,$start_y, $new_width, $new_height)){
            $this->error .= date('n/d/Y g:i:s')." Failed to resize and crop image.\n";
            if($this->debug){
                echo $this->error;
            }
            return false;  
               
        }
       
//dump and grab    
    ob_start();
    
    if($this->output_type == IMAGETYPE_JPEG ||$this->output_type == IMAGETYPE_JPEG2000){
            imagejpeg($modified_image);
         }
         
        else if($this->output_type == IMAGETYPE_GIF){
           imagegif($modified_image);
        }
         
        else if($this->output_type == IMAGETYPE_PNG){
           imagepng($modified_image);
        }
   $data = ob_get_clean();
   
   $this->image = imagecreatefromstring($data);
   
   if ($this->original_type == IMAGETYPE_PNG || $this->original_type == IMAGETYPE_GIF ){
        imagecolortransparent($this->image,imagecolorallocate($this->image,0,0,0));
        imagealphablending($this->image, FALSE); imagesavealpha($this->image, TRUE);
    }
   
   imagedestroy($modified_image);
   imagedestroy($temp_image);
   
    
}
  
  /**
   * insert a watermark onto the image
   * @param string $watermark path to the watermark file.
   * @param int $opacity from 0 (opaque) to 100 (transparent).
   * @param int $offset the number of pixels to offset from the bottom left corner. Default is 5.
   * @param string $side the side of the watermark. options "left"|"right"
   * 
   */ 
  public function watermark($watermark, $opacity=40,  $offset=5, $side ="left"){
            
   //set options 
    
  //create the watermark image
      
      $watermark_data = getimagesize($watermark);
      $watermark_height = $watermark_data[1];
      $watermark_width = $watermark_data[0];
      $watermark_type = $watermark_data[2];
    
      if($watermark_type == IMAGETYPE_GIF || $watermark_type === 1){
          $mark = imagecreatefromgif($watermark);
      }
      else if($watermark_type == IMAGETYPE_JPEG || $watermark_type == IMAGETYPE_JPEG2000 || $watermark_type === 2 || $watermark_type === 9){
          $mark = imagecreatefromjpeg($watermark);
      }
      else if($watermark_type == IMAGETYPE_PNG || $watermark_type === 3){
          $mark = imagecreatefrompng($watermark);
          imagecolortransparent($mark,imagecolorallocatealpha($mark,255,255,255,127));
          
      }
      else{
          $this->debug .=date('m/d/Y g:i:s a')." Failed to insert watermark.\n";
          if($this->debug){
            echo $this->error;
          }            
          return FALSE;
      }
      
  //set the offsets
  
    if($side == "left"){
    
    $start_x = $offset;
        
    }
    else{
        
    $start_x = $this->width -($watermark_width + $offset);
    
    } 
 
    $start_y = $this->height - $watermark_height - $offset;
       
  //apply it to the image    
    
    if(!imagecopymerge($this->image, $mark, $start_x, $start_y, 0,0, $watermark_width, $watermark_height, $opacity)){
        $this->error .=date('m/d/Y g:i:s a')." Failed to insert watermark.\n";
            if($this->debug){
            echo $this->error;
        }            
       return FALSE;
    }    
      
  }
    
  /**
   * Returns an object with the meme header and the modified image, or a file location.
   * 
   * @param bool $file if TRUE outputs image as a file in the temp location. If FALSE outputs the image directly. Default FALSE.
   * @param string $temp_location the folder to store the image in.
   * @param string $name the new file name. defaults to timestamp.
   * 
   */
  public function return_image($file=FALSE, $temp_location = "temp",$name= NULL){
       
       if($file){
               
          if(empty($name)){
              $name = time();
          } 
           
         if($this->output_type == IMAGETYPE_JPEG ||$this->output_type == IMAGETYPE_JPEG2000){
            $location = $temp_location."/".$name.".jpg";    
            imagejpeg($this->image,$location);
         }
         
         else if($this->output_type == IMAGETYPE_GIF){
           $location = $temp_location."/".$name.".gif";    
           imagegif($this->image,$location);
         }
         
         else if($this->output_type == IMAGETYPE_PNG){
           $location = $temp_location."/".$name.".png";    
           imagepng($this->image,$location);
         }
     
         return $location;
       }
       
       else{
          
        if($this->output_type == IMAGETYPE_JPEG ||$this->output_type == IMAGETYPE_JPEG2000){
            header('Content-Type: image/jpeg');    
            imagejpeg($this->image);
         }
         
        else if($this->output_type == IMAGETYPE_GIF){
           header('Content-Type: image/gif');    
           imagegif($this->image);
        }
         
        else if($this->output_type == IMAGETYPE_PNG){
           header('Content-Type: image/png');    
           imagepng($this->image);
        }
             
       }
       
               
   }
 
  /**
   * Sets the output type for the image.
   * @param string $type options: 'jpg'|'gif'|'png'
   * @return void;
   */ 
   public function output_type($type){
        $type == strtolower($type);
    
       if($type == "jpg" || $type == "jpeg"){
           $this->output_type = IMAGETYPE_JPEG;
       }
       else if($type == "gif"){
           $this->output_type = IMAGETYPE_GIF;
       }
       else if($type == "png"){
           $this->output_type = IMAGETYPE_PNG;
       }
       else{
          $this->error .=date('m/d/Y g:i:s a')." Incorrect output type.\n";
            if($this->debug){
                echo $this->error;
            }            
            return FALSE;
       }
      
   } 
 
  /**
   * Applies a GD library filter to the image
   * @param $string filter options: 'negative'|'grayscale'|'sharp'|'emboss'|'gaussian_blur'|'blur'|'sketch'|'bright'|'contrast'|'hot'|'cold'|'cool'|'smooth'|'pixelate'
   *     
   */
   public function filter($filter){
      
      $filter = strtolower($filter);
       
       if($filter == "negative"){
            imagefilter($this->image,IMG_FILTER_NEGATE);
       }
       else if($filter == "grayscale"){
            imagefilter($this->image,IMG_FILTER_GRAYSCALE);
       }
       else if($filter == "sharp"){
            imagefilter($this->image,IMG_FILTER_EDGEDETECT);
       }
       else if($filter == "emboss"){
            imagefilter($this->image,IMG_FILTER_EMBOSS);
       }
       else if($filter == "gaussian_blur"){
            imagefilter($this->image,IMG_FILTER_GAUSSIAN_BLUR);
       } 
       else if($filter == "blur"){
            imagefilter($this->image,IMG_FILTER_SELECTIVE_BLUR);
       }    
       else if($filter == "sketch"){
            imagefilter($this->image,IMG_FILTER_MEAN_REMOVAL);
       }
       else if($filter == "bright"){
            imagefilter($this->image,IMG_FILTER_BRIGHTNESS,50);
       }
       else if($filter == "contrast"){
            imagefilter($this->image,IMG_FILTER_CONTRAST,50);
       }
       else if($filter == "hot"){
            imagefilter($this->image,IMG_FILTER_COLORIZE,30,20,20);
       }
       else if($filter == "cool"){
            imagefilter($this->image,IMG_FILTER_COLORIZE,10,26,15);
       }
       else if($filter == "cold"){
            imagefilter($this->image,IMG_FILTER_COLORIZE,15,25,35);
       }
       else if($filter == "smooth"){
            imagefilter($this->image,IMG_FILTER_SMOOTH,100);
       }
       else if($filter == "pixelate"){
            imagefilter($this->image,IMG_FILTER_PIXELATE,90,TRUE);
       }
       
       else{
             $this->error .=date('m/d/Y g:i:s a')." Incorrect filter type.\n";
                if($this->debug){
                    echo $this->error;
                }            
                return FALSE;
       }
     
                   
   }    
  

       
 }
