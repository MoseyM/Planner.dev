<?php
	

class AddressBook 
{
	function __construct($dbc) 
	{
		$this->dbc = $dbc;
	}

	function deleteEntryPerson($id)
	{
		//delete item from persons
        $this->dbc->query("DELETE FROM person WHERE id=$id");
    }

   	function deleteEntryAddress($id) 
   	{
            // $removeAddress = $_GET['address'];
            $this->dbc->query("DELETE FROM addresses WHERE person_id=$id");  
	}

	function addEntryPerson()
	{
		$query = "INSERT INTO person (firstname, lastname) 
                       VALUES (:firstname, :lastname)";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindValue(':firstname',  $_POST['firstname'],  PDO::PARAM_STR);
        $stmt->bindValue(':lastname',  $_POST['lastname'],  PDO::PARAM_STR);
        $stmt->execute();
        $contactId = $this->dbc->lastInsertId();
        return $contactId;
	}
	
	function addEntryAddress($contactId) {
		$this->verifyAddress();
        // logic for addresses table
        $stmt = $this->dbc->prepare("INSERT INTO addresses (person_id, email, phone, address, city, state, zip) 
                    VALUES (:person_id, :email, :phone, :address, :city, :state, :zip)");
        $stmt->bindValue(':person_id',  $contactId, PDO::PARAM_STR);
        $stmt->bindValue(':email',  $_POST['email'], PDO::PARAM_STR);
        $stmt->bindValue(':phone',  $_POST['phone'], PDO::PARAM_STR);
        $stmt->bindValue(':address',  $_POST['address'], PDO::PARAM_STR);
        $stmt->bindValue(':city',  $_POST['city'], PDO::PARAM_STR);
        $stmt->bindValue(':state',  $_POST['state'], PDO::PARAM_STR);
        $stmt->bindValue(':zip',  $_POST['zip'], PDO::PARAM_INT);
        $stmt->execute();
	}

	function editEntryAddress() {
		$stmt = $this->dbc->prepare("UPDATE person SET firstname = :firstname, lastname = :lastname WHERE id = :id");  
        $stmt->bindValue(':firstname',  $_POST['edit_firstname'],  PDO::PARAM_STR);
        $stmt->bindValue(':lastname',  $_POST['edit_lastname'],  PDO::PARAM_STR);
        $stmt->bindValue(':id',  $_POST['hidden_id'],  PDO::PARAM_STR);
        $stmt->execute();
	}

	function editEntryPerson() {
		$stmt = $this->dbc->prepare("UPDATE addresses SET email = :email, phone = :phone, address = :address, city = :city, state = :state, zip = :zip WHERE person_id = :person_id");     
		$stmt->bindValue(':person_id',  $_POST['hidden_id'],  PDO::PARAM_STR);
        $stmt->bindValue(':email',  $_POST['edit_email'],  PDO::PARAM_STR);
        $stmt->bindValue(':phone',  $_POST['edit_phone'],  PDO::PARAM_STR);
        $stmt->bindValue(':address',  $_POST['edit_address'],  PDO::PARAM_STR);
        $stmt->bindValue(':city',  $_POST['edit_city'],  PDO::PARAM_STR);
        $stmt->bindValue(':state',  $_POST['edit_state'],  PDO::PARAM_STR);
        $stmt->bindValue(':zip',  $_POST['edit_zip'],  PDO::PARAM_INT);
        $stmt->execute();
        $contactId = $this->dbc->lastInsertId();
	}

	function verifyAddress() {
		!empty($_POST['email']) ? $_POST['email'] : null;
        !empty($_POST['phone']) ? $_POST['phone'] : null;
        !empty($_POST['address']) ? $_POST['address'] : null;
        !empty($_POST['city']) ? $_POST['city'] : null;
        !empty($_POST['state']) ? $_POST['state'] : null;
        !empty($_POST['zip']) ? $_POST['zip'] : null;
	}
// Not sure where this is used but method created.
	function definePageNumber() {
		//find total number of rows and build pagination from that count
	    // $count = $this->dbc->query("SELECT COUNT(*) FROM addresses");
	    // $pageCount = $count->fetchColumn();
	    // $pages = ceil($pageCount / 10);
	    // $lastPage = $pages;
	    //define page number
		(isset($_GET['page']) && $_GET['page'] >= 1) ? $current_page = $_GET['page'] : $current_page = 1;
	    $offsetQuery = ($current_page - 1) *10;
	    $query = "SELECT person.id, firstname, lastname, email, phone, address, city, state, zip, addresses.id AS add_id, person_id
	        FROM person LEFT JOIN addresses ON addresses.person_id = person.id  LIMIT 10 OFFSET :offset";
	    $stmt = $this->dbc->prepare($query);
	    $stmt->bindValue(':offset',  $offsetQuery,  PDO::PARAM_INT);
	    $stmt->execute();
	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

