<?php

 
class Images{
   
   var $image;
   var $image_type;
   var $path;
 
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }

      return $this;
   }

   function to($path){
      $this->path= $path."/";
      return $this;
   }
   function save($filename, $width=null, $height=null, $compression=60, $permissions=null) {
      $wd=is_null($width)?$this->getWidth():$width;
      $ht=is_null($height)?$this->getHeight():$height;
      $this->resize($wd, $ht);
   $image_type=$this->image_type;
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$this->path.$filename.'.jpg',$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$this->path.$filename.'.gif');         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$this->path.$filename.'.png');
      }else{
	  print "Unknown Formate";
	  }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }      
}
?>