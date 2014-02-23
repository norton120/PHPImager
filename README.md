PHPImager && PHPImagerLite
======

A *responsive* image manipulation suite using PHP (with the GD library) and jQuery.
----------------------------------------------------------------------------------
* PHPImager and PHPImagerLite are mini-suite solutions for adding image manipulation and uploading to a responsive project.
* They each consist of an image processing PHP class, a front end script (jQuery dependant) and a server-side script to process ajax
* between the two. The front end script uses the included css stylesheet, so modifying the script to fit your project can be done 
* by updating the css.
* PHPImager features metadata manipulation, text/watermark insertion, multiple filters and more - this is still very much 
* a work in progress. 
* PHPImagerLite has some basic filters, watermarking, cropping etc. 

###DEPENDANCIES###
* jQuery 1.8.1 = < 
* PHP5.3 = <  
* GD library

###USE###
1. Load the whole PHPImager folder somewhere in your filesystem. 
2. Add the js script to your project, right before the ```</body>``` tag.
				<script type="text/javascript" src="path_to_folder/PHPImager.js"></script>
3.In the PHPImager.js file at the very beginning you will find 2 variables: 
				var finished_width = 100;
				var finished_height = 100;
set these to the image size you want PHPImager to output. (I did it this way because typically you want to control 
the image size and aspect ratio to fit you project. PHPImager will have an option to make this controllable). 
4.At the very top of PHPImager_server.php you will find a varaible:
				$local_path_to_watermark = "PHPImager_back.png";
set this to the image you want to use as a watermark for your project. 
5.In your project for each element you want to use PHPImager, mark up as follows:
				<div class="PHPImager">
            			<img src="current_image.jpg">
            			<input type="file" name="your_image_name">
				</div>	
**note** you don't need to have an existing image, PHPImager will insert a placeholder if there is no image in 
the div. This layout will still function if javascript is disabled as a simple file uploader, so make sure your backend script is prepared to handle
either a file or url. 
**tip** the replacement PHPImager divs will keep the size styling you set, so style the .PHPImager divs to fit your layout.  
6.PHPImager will load, edit and save the image, and on submit will pass the local uri of the image as a string under the name for the file input it replaced.
Why not pass the new file? Yeah I know. But after considering both options it just made more sense to pass a reference to a file already on the server than to
keep passing the file back/forth - this is simple and effective, and doesn't burn bandwidth.


That is all, I am open to suggestions, improvements, feel free to grab a fork and start improving. Thanks!


 
