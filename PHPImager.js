
   
   /**
    * Set the final dimentions for the image
    */
   var finished_width = 100;
   var finished_height = 100;
 
   var ratio = finished_width/finished_height;
   var w_height = $(window).height(); 


   function PHPImager(){
             
     
        $('head').append('<link rel="stylesheet" href="PHPImager.css" type="text/css"/>');
            
            $('body').prepend(
                '<div id="PHPImager_wrapper">'+
                    '<div id="PHPImager_workbox">'+
                        '<form action="PHPImager_server.php" method="POST" id="PHPImager_form" enctype="multipart/form-data">'+
                           '<input type="hidden" id="PHPImager_width" name="PHPImager_width" value="'+finished_width+'">'+
                           '<input type="hidden" id="PHPImager_height" name="PHPImager_height" value="'+finished_height+'">'+
                           '<div id="PHPImager_image_container">'+
                           '</div>'+
                            '<div id="PHPImager_controls" class="icon">'+
                                '<button onclick="PHPImager_revert(event);" data-text="revert" title="reset to original">'+
                                    '<img src="revert.jpg" alt="revert" title="reset to original"/>'+
                                '</button><!--'+ 
                             '--><button onclick="PHPImager_rotate(event);" data-text="rotate" title="rotate">'+
                                    '&#xe13e;'+
                                '</button><!--'+
                             '--><button onclick="PHPImager_flip(event);" data-text="flip" title="flip">'+
                                    '&#xe13f;'+           
                                '</button><!--'+
                             '--><button onclick="PHPImager_watermark(event);" data-text="watermark" title="watermark">'+
                                    '&#xe2e8;'+           
                                '</button><!--'+
                             '--><button onclick="PHPImager_grayscale(event);" data-text="grayscale" title="grayscale">'+
                                    '<img src="grayscale.jpg" alt="grayscale" title="grayscale"/>'+
                                '</button><!--'+
                             '--><button onclick="PHPImager_emboss(event);" data-text="emboss" title="emboss">'+
                                    '<img src="emboss.jpg" alt="emboss" title="emboss"/>'+       
                                '</button><!--'+
                             '--><button onclick="PHPImager_warm(event);" data-text="warm" title="warm">'+
                                    '<img src="hot.jpg" alt="warm" title="warm"/>'+       
                                '</button><!--'+
                             '--><button onclick="PHPImager_nature(event);" data-text="nature" title="nature">'+
                                    '<img src="cool.jpg" alt="nature" title="nature"/>'+       
                                '</button><!--'+
                             '--><button onclick="PHPImager_cool(event);" data-text="cool" title="cool">'+
                                    '<img src="cold.jpg" alt="cool" title="cool"/>'+       
                                '</button><!--'+
                             '--><button onclick="PHPImager_gaussian_blur(event);" data-text="gaussian blur" title="gaussian blur">'+
                                    '<img src="gaussian_blur.jpg" alt="gaussian blur" title="gaussian blur"/>'+       
                                '</button><!--'+
                             '--><button onclick="PHPImager_sketch(event);" data-text="sketch" title="sketch">'+
                                    '<img src="sketch.jpg" alt="sketch" title="sketch"/>'+       
                                '</button><!--'+
                             '--><button onclick="PHPImager_bright(event);" data-text="bright" title="bright">'+
                                    '<img src="bright.jpg" alt="bright" title="bright"/>'+       
                                '</button><!--'+
                             '--><button onclick="PHPImager_smooth(event);" data-text="smooth" title="smooth">'+
                                    '<img src="smooth.jpg" alt="smooth" title="smooth"/>'+       
                                '</button><!--'+    
                             '--><button onclick="PHPImager_sharp(event);" data-text="find edges" title="find edges">'+
                                    '<img src="sharp.jpg" alt="find edges" title="find edges"/>'+       
                                '</button><!--'+
                             '--><button onclick="PHPImager_negative(event);" data-text="negative" title="negative">'+
                                    '<img src="negative.jpg" alt="negative" title="negative"/>'+       
                                '</button><!--'+        
                             '--><button onclick="PHPImager_delete(event);" data-text="delete" title="delete">'+
                                    '&#xe253;'+
                                '</button>'+ 
                            '</div>'+
                            '<div id="PHPImager_save_cancel_box">'+
                                    '<input type="file" id="PHPIMAGER_UPLOAD_FILE" name="PHPIMAGER_UPLOAD_FILE" onchange="PHPImager_load();">'+
                                '</span>'+
                                '<button onclick="PHPImager_save(event);">'+
                                    'save'+
                                '</button>'+
                                '<button onclick="PHPImager_cancel(event);">'+
                                    'cancel'+
                                '</button>'+
                            '</div>'+
                        '</form>'+
                    '<div id="PHPImager_file_upload" onclick="document.getElementById(\'PHPIMAGER_UPLOAD_FILE\').click();">'+
                        '<span class="icon">'+
                            '&#xe253;'+
                        '</span>'+
                        '&nbsp;upload image'+
                    '</div>'+    
                    '<div id="PHPImager_spinner">'+
                    '<img src="PHPImager_spinner.gif" alt="please wait"/>'+
                    '</div>'+    
                    '</div>'+
                '</div>');        
                        
        
            var x = 0;
           $('.PHPImager').each(function(){
         
           var url = "null";
           var div = this;
           
           var name = $(div).children('input[type="file"]').first().prop('name');
           
           $(div).data("token", x);
           
           if($(div).find('img').length > 0){
               url = $(div).children("img").first().prop('src');
               $(div).html('<img src="'+url+'"/><input type="hidden" id="PHPImager_input_'+x+'" name="'+name+'">');
           }
           else{
               $(div).html('<img src="image_upload.svg"/><input type="hidden" id="PHPImager_input_'+x+'" name="'+name+'" value="'+url+'">');
           }
       
          $(div).children('img').first().css({width:"100%", height:"100%"}); 
          
          $('body').append("<div class='imager_cover' data-div='"+x+"' data-original='"+url+"' onclick='open_editor(this)'>upload/edit</div>"); 
        
        x++;
        });
    }
 
   function resize_cover(){
        $('.PHPImager').each(function(){
            var n_height = $(this).height();
            var n_width = $(this).width();
            var n_offset = $(this).offset();
            var token = $(this).data('token'); 
                       
            $('.imager_cover[data-div="'+token+'"]').css({
                width:n_width,
                height:n_height,
                top:n_offset.top,
                left:n_offset.left
                });
        });
    }
 
   function resize_image(){
     
        w_height = $(window).height();
        
        if(finished_height > finished_width){
            $('#PHPImager_image_container').css({ height: w_height*.7});
            $('#PHPImager_image_container').css({width: $('#PHPImager_image_container').height()*ratio });     
        }
        else{
            
            if(ratio < 1.8){
              
                var hi = $('#PHPImager_image_container').height()*ratio;
                var wide = $('#PHPImager_workbox').innerWidth()*.55;
              
              if(hi > wide){
                $('#PHPImager_image_container').css({ width: $('#PHPImager_workbox').innerWidth()*.55});
                $('#PHPImager_image_container').css({height: $('#PHPImager_image_container').width()/ratio });     
              }
              else{
                $('#PHPImager_image_container').css({ height: w_height*.55});
                $('#PHPImager_image_container').css({width: $('#PHPImager_image_container').height()*ratio });     
              }
            }
            else{
                $('#PHPImager_image_container').css({ width: $('#PHPImager_workbox').innerWidth()*.55});
                $('#PHPImager_image_container').css({height: $('#PHPImager_image_container').width()/ratio });     
                       
            }
            
        }
    }
   
   function position_upload_button(){
       var w = $('#PHPImager_file_upload').outerWidth()*.5;
       var h = $('#PHPImager_file_upload').outerHeight()*.5;
       var cw = $('#PHPImager_image_container').width()*.5;
       var ch = $('#PHPImager_image_container').height()*.5;
       var c_offset = $('#PHPImager_image_container').offset();
       
       $('#PHPImager_file_upload').css({
           top: c_offset.top +(ch - h),
           left: c_offset.left +(cw - w)
       });
   }
   
   function position_spinner(){
       var w = $('#PHPImager_spinner').outerWidth()*.5;
       var h = $('#PHPImager_spinner').outerHeight()*.5;
       var cw = $('#PHPImager_image_container').width()*.5;
       var ch = $('#PHPImager_image_container').height()*.5;
       var c_offset = $('#PHPImager_image_container').offset();
       
       $('#PHPImager_spinner').css({
           top: c_offset.top +(ch - h),
           left: c_offset.left +(cw - w)
       });
   }
   
   function resize_buttons(){
        $('#PHPImager_controls').children('button').each(function(){
            $(this).css('height', $(this).outerWidth());
         });
    }   
   
   function image_replace(image){
        if(image.indexOf("?") >= 0 && image.indexOf("=") >= 0 ){
            $('#PHPImager_image_container').html('<img src="'+image+'"/>');
        }
        else{
            $('#PHPImager_image_container').html('<img src="'+image+'?no_cache='+jQuery.now()+'"/>');
        }
    }
   
   function open_editor(value){
         
        if($(value).data('original') != null){
            image_replace($(value).data('original'));
           $('#PHPImager_image_container').data('image', $(value).data('original'));
           $('#PHPImager_file_upload').hide(); 
       
        }
        else{
          $('#PHPImager_file_upload').fadeIn(); 
        }
        $('#PHPImager_wrapper').fadeIn();
        $('#PHPImager_wrapper').data('target', $(value).data('div'));
        resize_buttons();
        position_upload_button();
        position_spinner();
    }   
   
   function PHPImager_ajax(action){
        var image = $('#PHPImager_image_container').data('image');
        var count = $('#PHPImager_wrapper').data('target');       
        var width = $("#PHPImager_width").val();
        var height = $("#PHPImager_height").val();
        var post_data = "url="+image+"&action="+action+"&PHPImager_width="+width+"&PHPImager_height="+height;
        $.ajax({
            url:"PHPImager_server.php",
            type:"POST",
            data: post_data,
            dataType: "json"
        })
        .done(function(response){
            if(response.status == "success"){
                $("#PHPImager_image_container").children('img').attr('src',response.url+'?'+jQuery.now());
                $('#PHPImager_image_container').data('image',response.url);
           
            }
            else if(response.status == "saved"){
               var div = $('.PHPImager').eq($('#PHPImager_wrapper').data('target')); 
               $(div).children('img').attr('src', response.url+"?"+jQuery.now());
               $(div).children('input').val(response.url);
               $('#PHPImager_image_container').html(" ");
               $('#PHPImager_wrapper').fadeOut();
               $('.imager_cover').each(function(){
                   if($(this).data('div') == $('#PHPImager_wrapper').data('target')){
                       $(this).data('original', response.url);
                   }
               });
           }
           else if(response.status == "cancelled"){
               $('#PHPImager_image_container').html(" ");
               $('#PHPImager_wrapper').fadeOut();
           }
           else if(response.status == "bad_file_type"){
               alert('Invalid image type. Please select a Jpeg, PNG or GIF file.');
           }
           else if(response.status == "error"){
               alert('An error occurred.');
           }
        })
        .fail(function(){
            alert('An error occurred.');
        });
        return false;     
   }
   
   function PHPImager_load(){
            
           var formData = new FormData($("#PHPImager_form")[0]);
           $.ajax({
           url: "PHPImager_server.php",
           type: 'POST',
           data: formData,
           processData:false,
           contentType:false,
           async: false,
           dataType:'json'
           })
           .done(function(result){
                if(result.status == "uploaded"){
                    $('#PHPImager_image_container').data('image', result.url);
                    $('#PHPImager_image_container').html('<img src="'+result.url+'"/>');
                }
           })
           .fail(function(){
           });
           
           $('#PHPImager_file_upload').fadeOut();
           $('#PHPImager_form').get(0).reset();         
   }
   
   function PHPImager_delete(event){
    event.preventDefault();
    confirm("Are you sure you want to delete this image? This cannot be undone.");
    PHPImager_ajax("delete");
    var div = $('.PHPImager').eq($('#PHPImager_wrapper').data('target')); 
    $(div).children('img').attr('src', "image_upload.svg");
    $(div).children('input').val("delete");
    $('#PHPImager_file_upload').fadeIn(); 
    $('#PHPImager_image_container').html(" ");
    $('#PHPImager_image_container').data('image', "");
   }
   
   function PHPImager_cancel(event){
       event.preventDefault();
       PHPImager_ajax("cancel");
       $('#PHPImager_image_container').html(" ");
       $('#PHPImager_wrapper').fadeOut();
       $('#PHPImager_image_container').data('image', "");
      
       
   }
   
   function PHPImager_rotate(event){
     event.preventDefault();
     PHPImager_ajax("rotate");    
   }
   
   function PHPImager_flip(event){
     event.preventDefault();
     PHPImager_ajax("flip");    
   }
   
   function PHPImager_watermark(event){
     event.preventDefault();
     PHPImager_ajax("watermark");    
   }
   
   function PHPImager_revert(event){
     event.preventDefault();
     PHPImager_ajax("revert");    
   }
   
   function PHPImager_grayscale(event){
     event.preventDefault();
     PHPImager_ajax("grayscale");    
   }
   
   function PHPImager_emboss(event){
     event.preventDefault();
     PHPImager_ajax("emboss");    
   }
   
   function PHPImager_warm(event){
     event.preventDefault();
     PHPImager_ajax("hot");    
   }
   
   function PHPImager_nature(event){
     event.preventDefault();
     PHPImager_ajax("cool");    
   }
   
   function PHPImager_cool(event){
     event.preventDefault();
     PHPImager_ajax("cold");    
   }
   
   function PHPImager_gaussian_blur(event){
     event.preventDefault();
     PHPImager_ajax("gaussian_blur");    
   }
   
   function PHPImager_sketch(event){
     event.preventDefault();
     PHPImager_ajax("sketch");    
   }
   
   function PHPImager_bright(event){
     event.preventDefault();
     PHPImager_ajax("bright");    
   }
   
   function PHPImager_smooth(event){
     event.preventDefault();
     PHPImager_ajax("smooth");    
   }
   
   function PHPImager_sharp(event){
     event.preventDefault();
     PHPImager_ajax("sharp");    
   }
   
   function PHPImager_negative(event){
     event.preventDefault();
     PHPImager_ajax("negative");    
   }
  
   function PHPImager_save(event){
       event.preventDefault();
       $('#PHPImager_image_container').html(" ");
       $('#PHPImager_wrapper').fadeOut();
       PHPImager_ajax("save");
       $('#PHPImager_image_container').data('image', "");
       
   }
   
  $(document).ajaxSend(function(){$("#PHPImager_spinner").show();});
  $(document).ajaxComplete(function(){$("#PHPImager_spinner").hide();});
         
  
  $(document).ready(function(){
     PHPImager();
  $(window).load(function(){
     resize_image();
     resize_cover(); 
  }); 
     
  });
               
  $(window).resize(function(){
        resize_buttons();
        resize_image();
        resize_cover();
        position_upload_button();
        position_spinner();
    
    });    
  
