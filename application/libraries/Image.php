<?php

class image
{
    private $_cmInPoints = 0.026434;
    private $_twipsInCm  = 567;
    private $_imgFile;
    private $_width;
    private $_height;
    private $_defaultWidth;
    private $_defaultHeight;
    
    public function __construct($fileName, $width = 0, $height = 0)
    {
        $this->_imgFile = $fileName;
        $this->_width   = $width;
        $this->_height	= $height;
        $imgSize = getimagesize($fileName);
        $this->_defaultWidth  = $imgSize[0];
        $this->_defaultHeight = $imgSize[1];
    }
    
    private function _getWidth()
    {	
        if (!empty($this->_width)) {
            $width = $this->_width;
        } else if (!empty($this->_height)) {
            $width = ($this->_defaultWidth / $this->_defaultHeight) * $this->_height;
        } else {
            $width = $this->_defaultWidth * $this->_cmInPoints;
        }
        return round($width * $this->_twipsInCm);
    }
    
    private function _getHeight()
    {	
        if (!empty($this->_height)) {
            $height = $this->_height;
        } else if (!empty($this->_height)) {
            $height = ($this->_defaultHeight / $this->_defaultWidth) * $this->_width; 
        } else {
            $height = $this->_defaultHeight * $this->_cmInPoints;
        }
        return round($height * $this->_twipsInCm);
    }
    
    
    private	function _fileToHex() 
    {	  
        $f = fopen($this->_imgFile, "r");
        $string = fread($f, filesize($this->_imgFile));
        fclose($f);
    
        $str = '';
        for ($i = 0; $i < strlen($string); $i ++) {
            $hex = dechex( ord($string[$i]));
        
            if (strlen($hex) == 1) {			  
                $hex = '0'.$hex;
            }
        
            $str .= $hex;	
        }
        
        return $str;
    }
    
    public function getContent() 
    {	  
        $content = '{\pict\picscalex35\picscaley35\piccropl0\piccropr0\piccropt0\piccropb0\picw8729\pich8729';
        $content .= '\picwgoal'.$this->_getWidth();  		
        $content .= '\pichgoal'.$this->_getHeight();
        $content .= '\wmetafile8\bliptag-790847609\blipupi96{\*\blipuid d0dc9f87e9266da7ca48a80faafb1e4e}';  
        $content .= $this->_fileToHex();		
        $content .= '}'; 			
        return $content;
    }
}