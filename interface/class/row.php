<?php


class Col{

	var $f=array();
	
	
	function __construct($field){
		$this->f = get_object_vars($field);
	}
	
	public function getLabel(){
		
		$label = $this->f['name'];
		
		if($this->f['table'] != "")
			$label = $this->f['table'].".".$label;

		
		if($this->f['primary_key']==1)
			return 	"<b>".$label."</b>";
			
		else
			return $label;
	}
}

?>
