<html>
    <head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!--[if !lte IE 9]> --><meta name="viewport" content="width=device-width, initial-scale=1"><!-- <![endif]-->
   
<style>
    body,html{
        width:100%;
        height:100%;        
    }
    
    .PHPImager{
        width:30%;
        height:10rem;
    }
</style>   
   
</head>
<body>   
    <form action="test_submit.php" method="POST" enctype="multipart/form-data">
    
        <div class="PHPImager">
            <img src="../../root/content/all_set.png" alt="logo image">
            <input type="file" name="image1">
        </div>
        <div class="PHPImager">
            <input type="file" name="image2">
        </div>
        <div class="PHPImager">
            <img src="http://www.knoxmodernmedia.com/content/logo.png" alt="logo image">
            <input type="file" name="image3">
        </div>
        <div class="PHPImager">
            <input type="file" name="image4">
        </div>
    
    </form>





<script type="text/javascript" src="PHPImager.js"></script>
</body>
</html>

