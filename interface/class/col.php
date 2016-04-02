<?php


class Col{

	var $f=array();
	var $fromIS = false;
	
	function __construct($field, $b=false){ //$b => From information_schema
		if(!$b) $this->f = get_object_vars($field);
		else $this->f = $field;
		$this->fromIS = $b;
	}
	public function getLabel(){
	
		if($this->fromIS)
			return $this->getLabelIS();
			
		$label = $this->f['name'];
		
		if($this->f['table'] != "")
			$label = $this->f['table'].".".$label;

		
		if($this->f['primary_key']==1)
			return 	"<b>".$label."</b>";
			
		else
			return $label;
	}
	
	public function getLabelIS(){
			
		$label = $this->f['COLUMN_NAME'];
		
		if($this->f['COLUMN_KEY']=="PRI")
			return 	"<b>".$label."</b>";
			
		else
			return $label;
	}
	public function getFieldName(){
		$label="";
		
		if($this->fromIS)
			$label=$this->f['COLUMN_NAME'];
		else
			$label=$this->f['name'];
		
		return $label;
	}
	public function getDefaultValue(){
	
		if($this->fromIS){
			if(isset($this->f["COLUMN_DEFAULT"])){
				return $this->f["COLUMN_DEFAULT"];
			}
			else if($this->f["IS_NULLABLE"] == "YES")
				return "NULL";
			else
				return "";
		}
		else
			return "";
			
	}
	
	
	public function getFormatInfo(){
	//	print_r($this->f);
		if($this->fromIS){
			if($this->f['DATA_TYPE'] == "date")
				return "YYYY-MM-DD";
			if(strpos($this->f['DATA_TYPE'],"int") !== FALSE)
				return "integer";
		}
	
	}
	public function getType(){
		if($this->fromIS)
			return $this->f["DATA_TYPE"];
		else
			return "-";
	}
}

?>
