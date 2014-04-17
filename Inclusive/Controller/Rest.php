<?php

abstract class Inclusive_Controller_Rest extends Inclusive_Controller_Action 
{
	
	protected $_allowedMethods = array(
		'DELETE',
		'GET',
		'HEAD',
		'INDEX',
		'OPTIONS',
		'PATCH',
		'POST',
		'PUT'
		);
	
	public function __call($name,$arguments)
	{
	
		if (preg_match('#Action$#',$name))
		{
		
			$action = preg_replace('#Action$#','',$name);
			
			switch ($action) 
			{
				
				case 'delete':
				case 'get':
				case 'head':
				case 'options':
				case 'patch':
				case 'put':
					
					$model = $this->getService()
						->fetchOne($this->getRequest()->getParams());
					
					break;
				
				case 'index':
					
					$set = $this->getService()
						->fetchAll($this->getRequest()->getParams());
					
					break;
				
				case 'post':
					
					$model = $this->getService()->fetchNew();
					
					break;
					
				default:
					
					return parent::__call($name,$arguments);
					
					break;
				
			}
			
			$this->_helper->viewRenderer->setNoRender();
			
			switch ($action) 
			{
				
				case 'delete':
					
					$result = $this->getService()->delete($model);
					
					break;
				
				case 'index':
					
					$set = $this->getService()
						->fetchAll($this->getRequest()->getParams());
					
					break;
					
				case 'patch':
				case 'put':
				case 'post':
					
					$model
						->setFromArray($this->getRequest()->getParams())
						->save();
					
					break;
				
			}
			
			switch ($action)
			{
				
				case 'head':
				case 'options':
					
					$this->getResponse()->setHeader('Allow',implode(',',$this->_allowedMethods),true);
					
					$this->getResponse()->setBody(null);
					
					break;
				
				case 'get':
				case 'patch':
				case 'put':
				case 'post':
					
					$this->getResponse()->setBody(Zend_Json::encode($model));
					
					break;
					
				case 'index':
					
					$this->getResponse()->setBody(Zend_Json::encode($set));
					
					break;
			
			}
			
			return;
			
		}
		
		return parent::__call($name,$arguments);
	
	}
	
}