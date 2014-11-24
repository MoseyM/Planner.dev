<?php
Class todoClass extends Filestore {
	public function __construct($filename){
		parent::__construct(strtolower($filename));
	}

	public $todoList;
}
?>
