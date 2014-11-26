<!-- parent class for person and address -->

<?php
abstract class AddressBookClass
{
	protected function __construct($dbc, $id) {
		$this->dbc = $dbc;
		$this->id = $id;
	}

	public function checkId() {
		// checking if we are working with an existing id or row
		if (isset($id)) {
			update();
		} else {
			insert();
		}
	}


	// for current information
	protected abstract function update();
	// protected abstract function insert();
	//for new entries or complete deltion of entries
	protected abstract function delete();
	// protected abstract function add();
}
?>