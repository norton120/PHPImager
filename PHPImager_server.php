<?php


//MAKE SURE to set the upload_max_filesize in PHP.ini to 10M - the default 2M file limit will kick out any cell phone pics.
ini_set('memory_limit', '256M');

    //set this to your watermark file.
        $local_path_to_watermark = "PHPImager_back.png";

require("class.PHPImagerLite.1.1.0.php");

    define('WATERMARK', $local_path_to_watermark);


   //check for temp dir, make or die
    if(!is_writable("PHPImager_temp/")){
       if(!mkdir("PHPImager_temp/",0777)){
           trigger_error("PHPImager_temp directory is not writable.");
           exit;
       } 
    }
    
    define('TEMP_DIR', "PHPImager_temp");    
  
   //set image dimensions 
    if(!empty($_POST['PHPImager_width']) && !empty($_POST['PHPImager_height'])){
        define('F_WIDTH', $_POST['PHPImager_width']);
        define('F_HEIGHT', $_POST['PHPImager_height']);
    }
    else{
            header("Content-Type: application/json");
            echo '{"status":"no_dims"}';
            exit;
    }
   
   //if uploaded image, set base working image 
    if(!empty($_FILES["PHPIMAGER_UPLOAD_FILE"])){
            
        if($_FILES["PHPIMAGER_UPLOAD_FILE"]['error'] > 0){
            header("Content-Type: application/json");
            echo '{"status":"upload_error"}';
            exit;
        }        

        define('IMAGE',$_FILES["PHPIMAGER_UPLOAD_FILE"]['tmp_name']);    
   
         $imager = new PHPImager(IMAGE);
         $imager->width = F_WIDTH;
         $imager->height = F_HEIGHT;
         $imager->resize();
         
         $result = $imager->return_image(TRUE,TEMP_DIR);
         
         if(!$result){
            if(strpos($imager->return_errors(), "Invalid image format.")!== FALSE){
                header("Content-Type: application/json");
                echo '{"status":"bad_file_type"}';
                unlink($_FILES["PHPIMAGER_UPLOAD_FILE"]['tmp_name']);
                exit;
            }
            else{
                header("Content-Type: application/json");
                echo '{"status":"error"}';
                unlink($_FILES["PHPIMAGER_UPLOAD_FILE"]['tmp_name']);
                exit;
            }
         }      $return_parts = pathinfo($result);
                $temp_path = $return_parts['dirname']."/".$return_parts['filename']."_WORKING.".$return_parts['extension'];
                copy($result,$temp_path);
                header("Content-Type: application/json");
                echo '{"status":"uploaded", "url":"'.$result.'"}';
                unlink($_FILES["PHPIMAGER_UPLOAD_FILE"]['tmp_name']);
                exit;
    }
  
   //use existing image  
    else if(!empty($_POST['url'])){
        if(strpos($_POST['url'], "_WORKING")!== FALSE){
           define('IMAGE',$_POST['url']);
           $bare_file = pathinfo($_POST['url'],PATHINFO_FILENAME); 
        }
        else{
            $return_parts = pathinfo($_POST['url']);
            $temp_path = TEMP_DIR."/".$return_parts['filename']."_WORKING";
            $bare_file = $return_parts['filename']."_WORKING"; 
            if(!file_exists($temp_path.".".$return_parts['extension'])){
                copy($_POST['url'],$temp_path.".".$return_parts['extension']);
            }
            define('IMAGE',$temp_path.".".$return_parts['extension']);
         
         //set working original 
            
            if($return_parts['dirname']!= TEMP_DIR){
                copy(IMAGE,TEMP_DIR."/".$return_parts['filename'].".".$return_parts['extension']);
            }
           
        }    
    }

    else{
            header("Content-Type: application/json");
            echo '{"status":"no_image"}';
            exit;
    }   

    
  //actions to perform on working image
    
    $actions = array('rotate','flip','watermark','delete','revert','grayscale','hot','cool','cold','emboss','save','cancel','gaussian_blur','sketch','bright','smooth','sharp','negative');
    
    if(in_array($_POST['action'], $actions)){
        define("ACTION",$_POST['action']);
    }
    $imager = new PHPImager(IMAGE);
    
    if(ACTION == "rotate"){
        $imager->rotate(90);
        $imager->width = F_WIDTH;
        $imager->height = F_HEIGHT;
        $imager->resize();
        $updated = $imager->return_image(TRUE,TEMP_DIR,$bare_file);
        if(!$updated){
            header("Content-Type: application/json");
            echo '{"status":"rotate_failed"}';
            exit;    
        }        
            header("Content-Type: application/json");
            echo '{"status":"success", "url":"'.$updated.'"}';
            exit;
        
    }
    
    if(ACTION == "flip"){
        $imager->rotate(180);
        $imager->width = F_WIDTH;
        $imager->height = F_HEIGHT;
        $imager->resize();
        $updated = $imager->return_image(TRUE,TEMP_DIR,$bare_file);
        if(!$updated){
            header("Content-Type: application/json");
            echo '{"status":"flip_failed"}';
            exit;    
        }        
            header("Content-Type: application/json");
            echo '{"status":"success", "url":"'.$updated.'"}';
            exit;
        
    }
    
    if(ACTION == "watermark"){
        $imager->width = F_WIDTH;
        $imager->height = F_HEIGHT;
        $imager->watermark(WATERMARK,40,20);
        $updated = $imager->return_image(TRUE,TEMP_DIR,$bare_file);
        if(!$updated){
            header("Content-Type: application/json");
            echo '{"status":"watermark_failed"}';
            exit;    
        }        
            header("Content-Type: application/json");
            echo '{"status":"success", "url":"'.$updated.'"}';
            exit;
        
    }

    if(ACTION == "revert"){
        $original = str_replace("_WORKING", "", IMAGE);
       
        if($original == IMAGE){
            header("Content-Type: application/json");
            echo '{"status":"success", "url":"'.IMAGE.'"}';
            exit;
        }    
        unlink(IMAGE);
        copy($original,IMAGE);
        header("Content-Type: application/json");
        echo '{"status":"success", "url":"'.IMAGE.'"}';
        exit;
    }
    
    if(ACTION == "cancel"){
        if(strpos(IMAGE,"_WORKING")!== FALSE){
            unlink(IMAGE);
            header("Content-Type: application/json");
            echo '{"status":"cancelled"}';
            exit;
        }
    }
    
    if(ACTION == "delete"){
        if(strpos(IMAGE,"_WORKING")!== FALSE){
            unlink(IMAGE);
        }
        $del_parts = pathinfo(IMAGE);
        if($del_parts['dirname'] == TEMP_DIR){
            if(is_file($del_parts['dirname']."/".str_replace("_WORKING", "", $del_parts['filename']).".".$del_parts['extension'])){
                unlink($del_parts['dirname']."/".str_replace("_WORKING", "", $del_parts['filename']).".".$del_parts['extension']);
            }    
        }
            header("Content-Type: application/json");
            echo '{"status":"deleted"}';
            exit;
    }
    
    
    
    $filters = array("grayscale","emboss","hot","cool","cold","gaussian_blur","sketch","bright","smooth","sharp","negative");
    
    if(in_array(ACTION,$filters)){
        $imager->width = F_WIDTH;
        $imager->height = F_HEIGHT;
        $imager->filter(ACTION);
        $updated = $imager->return_image(TRUE,TEMP_DIR,$bare_file);
        if(!$updated){
            header("Content-Type: application/json");
            echo '{"status":"filter_failed"}';
            exit;    
        }        
            header("Content-Type: application/json");
            echo '{"status":"success", "url":"'.$updated.'"}';
            exit;
        
    }
    
    if(ACTION == "save"){
        $parts = pathinfo(IMAGE);
        $file = str_replace("_WORKING","",$parts['filename']);
        $final = $parts['dirname']."/".$file.".".$parts['extension'];    
        copy(IMAGE,$final);
        unlink(IMAGE);      
            header("Content-Type: application/json");
            echo '{"status":"saved", "url":"'.$final.'"}';
            exit;
    }    
    
    
        
?>   
    