<?php
Class todoClass extends Filestore {
	public function __construct($filename){
		parent::__construct(strtolower($filename));
	}

	public function CheckForLength() {
		if ($_POST['actToAdd'] || empty($_POST['actToAdd'])) {
			throw new Exeption('Please limit your Todo Item to 256 characters.');			
		}
	}

	public $todoList;
}
?>
