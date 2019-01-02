<?php
namespace App\Helpers;

class Image
{
    public static $uploadPath = '/public/uploads/guestbook_entries/';
    public static $uploadUrl = 'public/uploads/guestbook_entries';

    /**
     * @param $image
     * @return array|string
     */
    public static function upload($image)
    {
        if(!empty($image)){
            $errors   = array();
            $fileSize = $image['size'];
            $fileTmp  = $image['tmp_name'];
            $fileNameArray = explode('.', $image['name']);
            $fileName = $fileNameArray[0];
            $fileExt  = end($fileNameArray);
            $fileExt  = strtolower($fileExt);

            $expensions = array("jpeg","jpg","png");

            $tempName = tempnam($_SERVER['DOCUMENT_ROOT'] . static::$uploadPath , $fileName);
            rename($tempName, $tempName .= '.' . $fileExt);

            if(in_array($fileExt, $expensions) === false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }

            if($fileSize > 2097152){
                $errors[]='File size must be less than 2 MB';
            }

            if(empty($errors) == true){
                $result = move_uploaded_file($fileTmp, $tempName);
                $tempNameArray = explode('/', $tempName);
                $url = static::$uploadPath . end($tempNameArray);
                return $url;
            } else{
                return $errors;
            }
        }
    }

    public static function remove($imageUrl)
    {
        $physicalPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $imageUrl;
        if (file_exists($physicalPath))
        {
            unlink($physicalPath);
        }
        return false;
    }

    /**
     * @param $imageUrl
     * @return string
     */
    public static function getImageUrl($imageUrl)
    {
        return url($imageUrl);
    }
}