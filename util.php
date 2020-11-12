<?php

define("NEWLINE", "<br>");

function mergeImages($img_src1, $img_src2, $id){
    
    //$img1_path = 'images_1.png';
    //$img2_path = 'images_2.png';
    
    list($img1_width, $img1_height) = getimagesize($img_src1);
    list($img2_width, $img2_height) = getimagesize($img_src2);
    
    $merged_width  = $img1_width + $img2_width;
    //get highest
    if($img1_height > $img2_height){
        $merged_height = $img1_height;
        $img1_height_diff = 0;
        $img2_height_diff = ($img1_height - $img2_height)/2; //centraliza a imagem menor
    }else{
        $merged_height = $img2_height;
        $img1_height_diff = ($img2_height - $img1_height)/2; //centraliza a imagem menor
        $img2_height_diff = 0;
    }
    
    $merged_image = imagecreatetruecolor($merged_width, $merged_height);
    
    imagealphablending($merged_image, false);
    imagesavealpha($merged_image, true);
    
    $trans_colour = imagecolorallocate($merged_image, 255, 255, 255);
    imagefill($merged_image, 0, 0, $trans_colour);
    
    $img1 = imagecreatefromjpeg($img_src1);
    $img2 = imagecreatefromjpeg($img_src2);
    
    imagecopy($merged_image, $img1, 0, $img1_height_diff, 0, 0, $img1_width, $img1_height);
    //place at right side of $img1
    imagecopy($merged_image, $img2, $img1_width, $img2_height_diff, 0, 0, $img2_width, $img2_height);
    
    $save_path = "numista/".$id.".jpg";
    imagejpeg($merged_image,$save_path, 100);
    
    $ratio = $merged_height / $merged_width;
    
    if($ratio < 0.5625){
        $adjusted_height = $merged_width*9/16;
        $adjusted_width = $merged_width;
    }
    
    $adjusted_image = imagecreatetruecolor($adjusted_width, $adjusted_height);
    
    imagealphablending($adjusted_image, false);
    imagesavealpha($adjusted_image, true);
    
    $white = imagecolorallocate($adjusted_image, 255, 255, 255);
    imagefill($adjusted_image, 0, 0, $white);
    
    imagecopy($adjusted_image, $merged_image, 0, 0, 0, 0, $merged_width, $adjusted_width);
    
    $adjusted_image2 = imagescale($merged_image, 1200, -1);
    
    $save_path = "numista/".$id."_scaled.jpg";
    imagejpeg($adjusted_image,$save_path, 100);
    
    $save_path = "numista/".$id."_scaled2.jpg";
    imagejpeg($adjusted_image2,$save_path, 100);
    
    //release memory
    imagedestroy($merged_image);
    imagedestroy($adjusted_image);
    imagedestroy($adjusted_image2);
    
}

?>