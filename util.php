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

//    $save_path = "numista/".$id.".jpg";
//    imagejpeg($merged_image,$save_path, 100);
    /*
     * 1200px X 675px
     The ideal image size and aspect ratio are 1200px X 675px and 16:9, respectively. The maximum file size is 5MB for photos and animated GIFs. You can go up to 15MB if you're posting via their website. You can tweet up to four images per post
     */

    $width_proportion = ceil($merged_width/16);
    $height_proportion = ceil($merged_height/9);

    if($width_proportion > $height_proportion){
      $adjusted_height = $width_proportion*9;
      $adjusted_width = $width_proportion*16;
    }else{
      $adjusted_height = $height_proportion*9;
      $adjusted_width = $height_proportion*16;
    }

    $adjusted_image = imagecreatetruecolor($adjusted_width, $adjusted_height);

    imagealphablending($adjusted_image, false);
    imagesavealpha($adjusted_image, true);

    $white = imagecolorallocate($adjusted_image, 255, 255, 255);
    imagefill($adjusted_image, 0, 0, $white);

    imagecopy($adjusted_image, $merged_image, ($adjusted_width - $merged_width)/2, ($adjusted_height - $merged_height)/2, 0, 0, $merged_width, $merged_height);

    $scaled_image = imagescale($adjusted_image, 1200, 675);

    $save_path = "numista/".$id.".jpg";
    imagejpeg($scaled_image,$save_path, 100);

    //release memory
    imagedestroy($merged_image);
    imagedestroy($adjusted_image);
    imagedestroy($scaled_image);

}

?>
