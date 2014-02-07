<?php

class Inclusive_Service_Adapter_Table extends Inclusive_Service_Adapter_Abstract 
{

	protected $_table = null;
	
	protected $_tableClass = 'Inclusive_Db_Table';
	
	public function arrayToSelect(array $array)
	{
	
		$select = $this->getTable()->select(true);
		
		foreach ($array as $key => $value)
		{
			
			$comparator = '= ?';
			
			if (is_array($value))
			{
			
				$comparator = 'IN(?)';
			
			}
			
			$select->where("`$key` $comparator",$value);
			
		}
		
		return $select;
	
	}
	
	public function arrayToWhere(array $array)
	{
	
		$where = array();
		
		foreach ($array as $key => $value)
		{
			
			$comparator = '= ?';
			
			if (is_array($value))
			{
			
				$comparator = 'IN(?)';
			
			}
			
			$where["`$key` $comparator"] = $value;
			
		}
		
		return $where;
	
	}
	
	public function createUniqueId($length=10) 
	{
	
		return $this->getTable()
			->createUniqueId($length);
	
	}
	
	public function getTable() 
	{
	
		$class = $this->_tableClass;
	
		if (!($this->_table instanceof $class))
		{
		
			$this->setTable(new $class());
		
		}
		
		return $this->_table;
	
	}
	
	public function getTableClass()
	{
	
		return $this->_tableClass;
		
	}
	
	public function setTable(Inclusive_Db_Table_Abstract $table) 
	{
	
		$this->_table = $table;
		
		return $this;
	
	}
	
}