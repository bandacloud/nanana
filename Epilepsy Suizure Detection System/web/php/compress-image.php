<?php
    function compressImage($source, $destination, $quality)
    {
        // Get Image Info
        $imgInfo=getimagesize($source);
        $mime=$imgInfo['mime'];

        // create a new image from file
        switch ($mime) {
        case 'image/jpeg':
            $image=imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image=imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image=imagecreatefromgif($source);
            break;
        case 'image/webp':
            $image=imagecreatefromwebp($source);
            break;
        default:
            $image=imagecreatefromjpeg($source);
    }

        //save image
        imagejpeg($image, $destination, $quality);

        //return compressed Image
        return $destination;
    }
?>