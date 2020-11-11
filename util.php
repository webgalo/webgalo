<?php

define("NEWLINE", "<br>");

function mergeImages($img_src1, $img_src2, $id){
    
    //$img1_path = 'images_1.png';
    //$img2_path = 'images_2.png';
    
    list($img1_width, $img1_height) = getimagesize($img_src1);
    list($img2_width, $img2_height) = getimagesize($img_src2);
    
    $merged_width  = $img1_width + $img2_width;
    //get highest
    $merged_height = $img1_height > $img2_height ? $img1_height : $img2_height;
    
    $merged_image = imagecreatetruecolor($merged_width, $merged_height);
    
    imagealphablending($merged_image, false);
    imagesavealpha($merged_image, true);
    
    $img1 = imagecreatefromjpeg($img_src1);
    $img2 = imagecreatefromjpeg($img_src2);
    
    imagecopy($merged_image, $img1, 0, 0, 0, 0, $img1_width, $img1_height);
    //place at right side of $img1
    imagecopy($merged_image, $img2, $img1_width, 0, 0, 0, $img2_width, $img2_height);
    
    //save file or output to broswer
    $SAVE_AS_FILE = TRUE;
    if( $SAVE_AS_FILE ){
        $save_path = "numista/".$id.".jpg";
        imagejpeg($merged_image,$save_path, 100);
    }else{
        header('Content-Type: image/png');
        imagepng($merged_image);
    }
    
    //release memory
    imagedestroy($merged_image);
    
}

?>