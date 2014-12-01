<?php

//connect to host
    define("DB_HOST", '127.0.0.1');
    define("DB_NAME", "addressBook");
    define("DB_USER", "queen");
    define("DB_PASS", 'password');

    require '../inc/db_connect.php';
    require_once '../inc/addressclass.php';

    $UseInfo = new AddressClass($dbc);
    
//find total number of rows and build pagination from that count
    $pageLimit = 10;
    $count = $dbc->query("SELECT COUNT(*) FROM addresses");
    $pageCount = $count->fetchColumn();
    $pages = ceil($pageCount / $pageLimit);
    $lastPage = $pages;    
//define page number
    (isset($_GET['page']) && $_GET['page'] >= 1) ? $current_page = $_GET['page'] : $current_page = 1;
    //query "addresses" database    
    $addressInfo = $UseInfo->getAddressData($current_page, $pageLimit);
//delete item
    if(!empty($_GET))
    {
        if(!empty($_GET['id']))
            {
                $id = $_GET['id'];
                $stmt = $dbc->query("DELETE FROM person WHERE id=$id");
                header($UseInfo->location);
            }
        if(!empty($_GET['address']))
        {
            $query = "UPDATE addresses 
                    SET email = NULL, phone = NULL, address = NULL, city = NULL, state = NULL, zip = NULL
                    WHERE person_id = :person_id";
            
            $stmt = $dbc->prepare($query);
            
            $stmt->bindValue(':person_id',  $_GET['address'],  PDO::PARAM_STR);
            
            $stmt->execute();
            $contactId = $dbc->lastInsertId();
        }  
    }
//checking $_POST for submission
    if(!empty($_POST))
    {
        $UseInfo->addresses = $_POST;
    //validating name is set
        if((isset($UseInfo->addresses['firstname'])) && (isset($UseInfo->addresses['lastname'])))
        {       
        	$UseInfo->insertPerson();
            header($UseInfo->location);
        } else if(isset($UseInfo->addresses['hidden_id'])) {
        // editing address table
            $UseInfo->editAddress();
            $UseInfo->editPerson();
            header($UseInfo->location); 
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Address Book</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <link href='http://fonts.googleapis.com/css?family=Nunito:300,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href= "../css/style.css">

</head>

<body>

    <div class='container'>
        <div class="row text-center">
            <h1 id="address-header">Address Book</h1>
        </div>
    </div>
    
<!-- add new person -->
    <div class="container-name add-name">
        <div class="row row-border">
            <div class="col-md-3">
                <h4><a data-toggle="modal" href="" data-target="#add-modal" id="add-name-header">Add Entry</a></h4>
            </div>
        </div>
    </div>
    <div>
    <table class="table table-striped">
        <tr>
            <th><hr id="first-hr"></th>
            <th>First Name</th>
            <th>Last Name</th>
            <th><hr id="second-hr"></th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zipcode</th>
            <th>Phone Number</th>
            <th>Email</th>
        </tr>
            <?php foreach ($addressInfo as $address) :?>
        <tr>
            <td>
                <a href="?id=<?= $address['id']; ?>" data-target="#deleteRow" class="remove-button">
                    DELETE
                </a>
            </td>
            <td id="person-firstName-<?= $address['id'] ?>"><?= htmlspecialchars(strip_tags($address['firstname'])); ?></td>
            <td id="person-lastName-<?= $address['id'] ?>"><?= htmlspecialchars(strip_tags($address['lastname'])); ?></td>
            <td>
                <a data-edit-person="<?= $address['id']; ?>" data-toggle="modal" href="" data-target="#edit-modal" class="edit-button">
                    EDIT |
                </a>
            
                <a  href="?address=<?= $address['person_id']; ?>" data-target="#deleteAddress" class="remove-button">
                    DELETE
                </a>
            </td>
            <td id="person-address-<?= $address['id'] ?>"><?= htmlspecialchars(strip_tags($address['address'])); ?></td>
            <td id="person-city-<?= $address['id'] ?>"><?= htmlspecialchars(strip_tags($address['city'])); ?></td>
            <td id="person-state-<?= $address['id'] ?>"><?= htmlspecialchars(strip_tags($address['state'])); ?></td>
            <td id="person-zip-<?= $address['id'] ?>"><?= htmlspecialchars(strip_tags($address['zip'])); ?></td>
            <td id="person-phone-<?= $address['id'] ?>"><?= htmlspecialchars(strip_tags($address['phone'])); ?></td>
            <td id="person-email-<?= $address['id'] ?>"><?= htmlspecialchars(strip_tags($address['email'])); ?></td>
        </tr> 
    
            <?php endforeach ?>     
        </table>   
        </div>         
    <!-- Modal -->
        <div class="modal fade in" id="deleteRow">
          <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to delete this entire row?
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                <a href="?id=<?= $person['id']; ?>"><button type="button" class="btn btn-danger">delete</button></a>
              </div>
            </div>
          </div>
        </div>
    <!-- Remove Address Modal -->
        <div class="modal fade" id="deleteAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to delete this person's address?
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                <button type="button" class="btn btn-danger">delete</button>
              </div>
            </div>
          </div>
        </div>
    <!-- Add Address Modal -->
        <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Contact Information</h3>
                        <div class="modal-body">
                            <form role="form" method="POST">
                              <div class="form-group">
                                <div class="form-group">
                                <input type="text" class="modal-form-control text-center" id="first-name" placeholder="First Name" name="firstname">
                                </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="last-name" placeholder="Last Name" name="lastname">
                                  </div>
                                    <input type="text" class="modal-form-control text-center" id="first-name" placeholder="Address" name="address">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="last-name" placeholder="City" name="city">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="last-name" placeholder="State" name="state">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="last-name" placeholder="Zipcode" name="zip">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="last-name" placeholder="Phone Number" name="phone">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="last-name" placeholder="Email" name="email">
                                  </div>
                                 
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                                        <button type="submit" class="btn btn-success">add</button>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     <!-- Edit Address Modal -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content modal-content-edit">
                <div class="modal-header">
                    <h3 class="modal-title">Contact Information</h3>
                        <div class="modal-body">
                            <form role="form" method="POST">
                              <div class="form-group">
                                <div class="form-group">
                                <input type="text" class="modal-form-control text-center" id="editFirstName" placeholder="First Name" name="edit_firstname">
                                </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="editLastName" placeholder="Last Name" name="edit_lastname">
                                  </div>
                                    <input type="text" class="modal-form-control text-center" id="editAddress" placeholder="Address" name="edit_address">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="editCity" placeholder="City" name="edit_city">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="editState" placeholder="State" name="edit_state">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="editZip" placeholder="Zipcode" name="edit_zip">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="editPhone" placeholder="Phone Number" name="edit_phone">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="editEmail" placeholder="Email" name="edit_email">
                                  </div>
                                   <div class="form-group">
                                    <input type="hidden" class="modal-form-control text-center" id="hidden_id" name="hidden_id" value="">
                                  </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                                        <button data-edit-person="<?= $address['id']; ?>"class="edit-confirm-button " type="submit" class="btn btn-success" href="?id=<?= $address['id']; ?>">edit</button>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    
    //auto-populating database info into edit modal
        $('.edit-button').click(function()
        {
            var personId = $(this).data('edit-person');
            var addressId = $(this).data('edit-address');
            var personFirstName = $("#person-firstName-" + personId).text();
            var personLastName = $("#person-lastName-" + personId).text();
            var phone = $("#person-phone-" + personId).text();
            var address = $("#person-address-" + personId).text();
            var city = $("#person-city-" + personId).text();
            var state = $("#person-state-" + personId).text();
            var zip = $("#person-zip-" + personId).text();
            var email = $("#person-email-" + personId).text();
            
            $("#editFirstName").val(personFirstName);
            $("#editLastName").val(personLastName);
            $("#editPhone").val(phone);
            $("#editAddress").val(address);
            $("#editCity").val(city);
            $("#editState").val(state);
            $("#editZip").val(zip);
            $("#hidden_id").val(personId);
            $("#editEmail").val(email);
            $("#remove-person").val([personId, addressId]);
            $("#editContactModal").modal();
        });



    </script>
    <footer></footer>
</html>