<?php

class Inclusive_Pdf extends Zend_Pdf
{

	protected $_defaultFontSize = 12;
	
	protected $_font = null;
	
	protected function _getDefaultFont()
	{
	
		if (!($this->_font instanceof Zend_Pdf_Font))
		{
		
			$this->_font = Zend_Pdf_Font::fontWithName(
				Zend_Pdf_Font::FONT_HELVETICA
				);
		
		}
	
		return $this->_font;
	
	}
	
	protected function _getDefaultFontSize()
	{
	
		return $this->_defaultFontSize;
	
	}
	
	protected function _setDefaultFontSize($size)
	{
	
		$this->_defaultFontSize = $size;
		
		return $this;
	
	}
	
	/**
	* Returns the total width in points of the string using the specified font and
	* size.
	*
	* This is not the most efficient way to perform this calculation. I'm
	* concentrating optimization efforts on the upcoming layout manager class.
	* Similar calculations exist inside the layout manager class, but widths are
	* generally calculated only after determining line fragments.
	* 
	* @link http://devzone.zend.com/article/2525-Zend_Pdf-tutorial#comments-2535 
	* @param string $string
	* @param Zend_Pdf_Resource_Font $font
	* @param float $fontSize Font size in points
	* @return float
	*/
	static function _widthForStringUsingFontSize($string, $font, $fontSize) {
	
	     $drawingString = iconv('UTF-8', 'UTF-16BE//IGNORE', $string);
	     $characters = array();
	     for ($i = 0; $i < strlen($drawingString); $i++) {
	         $characters[] = (ord($drawingString[$i++]) << 8 ) | ord($drawingString[$i]);
	     }
	     $glyphs = $font->glyphNumbersForCharacters($characters);
	     $widths = $font->widthsForGlyphs($glyphs);
	     $stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) * $fontSize;
	     return $stringWidth;
	     
	}
	
}