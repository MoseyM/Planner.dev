<?php
	

class AddressClass 
{
	public $addresses = [];
	function __construct($dbc) 
	{
		$this->dbc = $dbc;
	}

	public $location = "Location: http://planner.dev/addressBook/template/index.php";

	public function insertPerson() {
		$query = "INSERT INTO person (firstname, lastname) 
                       VALUES (:firstname, :lastname)";
        $stmt = $this->dbc->prepare($query);        
        $stmt->bindValue(':firstname',  $this->addresses['firstname'],  PDO::PARAM_STR);
        $stmt->bindValue(':lastname',  $this->addresses['lastname'],  PDO::PARAM_STR);       
        $stmt->execute();
        $contactId = $this->dbc->lastInsertId();
        $this->cleanAddress();
        $this->insertAddress($contactId);
	}

	public function cleanAddress() {
		!empty($this->addresses['email']) ? $this->addresses['email'] : null;
        !empty($this->addresses['phone']) ? $this->addresses['phone'] : null;
        !empty($this->addresses['address']) ? $this->addresses['address'] : null;
        !empty($this->addresses['city']) ? $this->addresses['city'] : null;
        !empty($this->addresses['state']) ? $this->addresses['state'] : null;
        !empty($this->addresses['zip']) ? $this->addresses['zip'] : null;
	}

	private function insertAddress($id) {
		$query = "INSERT INTO addresses (person_id, email, phone, address, city, state, zip) 
            VALUES (:person_id, :email, :phone, :address, :city, :state, :zip)";            
        $stmt = $this->dbc->prepare($query);
        $stmt->bindValue(':person_id',  $id,  PDO::PARAM_STR);
        $stmt->bindValue(':email',  $this->addresses['email'],  PDO::PARAM_STR);
        $stmt->bindValue(':phone',  $this->addresses['phone'],  PDO::PARAM_STR);
        $stmt->bindValue(':address',  $this->addresses['address'],  PDO::PARAM_STR);
        $stmt->bindValue(':city',  $this->addresses['city'],  PDO::PARAM_STR);
        $stmt->bindValue(':state',  $this->addresses['state'],  PDO::PARAM_STR);
        $stmt->bindValue(':zip',  $this->addresses['zip'],  PDO::PARAM_STR);
        $stmt->execute();
	}

	public function getAddressData($current, $limit) {
		$offsetQuery = ($current -1) *10;
    	$query = "SELECT person.id, firstname, lastname, email, phone, address, city, state, zip, addresses.id AS add_id, person_id
        FROM person LEFT JOIN addresses ON addresses.person_id = person.id  LIMIT :pageLimit OFFSET :offset";
	    $stmt = $this->dbc->prepare($query);
	    $stmt->bindValue(':pageLimit',  $limit,  PDO::PARAM_INT);
	    $stmt->bindValue(':offset',  $offsetQuery,  PDO::PARAM_INT);

	    $stmt->execute();
    
	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function editAddress() {
		$query = "UPDATE person
                        SET firstname = :firstname, lastname = :lastname
                        WHERE id = :id";      
            $stmt = $this->dbc->prepare($query);        
            $stmt->bindValue(':firstname',  $this->addresses['edit_firstname'],  PDO::PARAM_STR);
            $stmt->bindValue(':lastname',  $this->addresses['edit_lastname'],  PDO::PARAM_STR);
            $stmt->bindValue(':id',  $this->addresses['hidden_id'],  PDO::PARAM_STR);
            $stmt->execute();
	}

	public function editPerson() {
		$query = "UPDATE addresses 
                        SET email = :email, phone = :phone, address = :address, city = :city, state = :state, zip = :zip
                        WHERE person_id = :person_id";
            $stmt = $this->dbc->prepare($query);
            $stmt->bindValue(':person_id',  $this->addresses['hidden_id'],  PDO::PARAM_STR);
            $stmt->bindValue(':email',  $this->addresses['edit_email'],  PDO::PARAM_STR);
            $stmt->bindValue(':phone',  $this->addresses['edit_phone'],  PDO::PARAM_STR);
            $stmt->bindValue(':address',  $this->addresses['edit_address'],  PDO::PARAM_STR);
            $stmt->bindValue(':city',  $this->addresses['edit_city'],  PDO::PARAM_STR);
            $stmt->bindValue(':state',  $this->addresses['edit_state'],  PDO::PARAM_STR);
            $stmt->bindValue(':zip',  $this->addresses['edit_zip'],  PDO::PARAM_STR);
            $stmt->execute();
            // $contactId = $this->dbc->lastInsertId();
	}
}

