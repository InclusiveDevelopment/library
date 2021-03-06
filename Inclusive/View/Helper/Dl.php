<?php

class Inclusive_View_Helper_Dl extends Zend_View_Helper_Abstract {
	
	public function dl(array $row,array $options=null) {
		
		$string = '<dl'.((isset($options['class'])) ? ' class="'.$options['class'].'"' : '').'>';
		
		foreach ($row as $key => $value) {
			
			$class = strtolower($key);
			
			$string .= $this->renderTerm($key,$class);
			
			$string .= $this->renderDefinition($value,$class);
			
		}
		
		return $string .= "</dl>\n";
		
	}
	
	public function renderTerm($term,$class=null) {
		
		return '<dt '.(($class) ? $class : '').'>'.$term.'</dt>';
		
	}
	
	public function renderDefinition($definition,$class=null) {
		
        return '<dd '.(($class) ? $class : '').'>'.$definition.'</dd>';
        
	}
	
}