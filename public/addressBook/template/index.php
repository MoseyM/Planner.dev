<?php
    //connect to host
    define("DB_HOST", '127.0.0.1');
    define("DB_NAME", "addressBook");
    define("DB_USER", "queen");
    define("DB_PASS", 'password');

    require '../inc/db_connect.php';
    require_once '../inc/addressClass.php';

    $address = new AddressBook($dbc);

    if(!empty($_GET))
        { 
            $address->deleteEntryPerson();
            $address->deleteEntryAddress(); 
            header("Location: http://planner.dev/addressBook/template/index.php");
        }

    $addressInfo = $address->definePageNumber();
    //checking $_POST for submission
    if(!empty($_POST))
    {
        //validating name is set
        if((isset($_POST['firstname'])) && (isset($_POST['lastname'])))
        {
            $contactId = $address->addEntryPerson();
        }
            $address->addEntryAddress($contactId);
                header("Location: http://planner.dev/addressBook/template/index.php");
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
            <td><?= htmlspecialchars(strip_tags($address['firstname'])); ?></td>
            <td><?= htmlspecialchars(strip_tags($address['lastname'])); ?></td>
            <td>
                <a data-toggle="modal" href="" data-target="#add-modal" class="add-button">
                    EDIT |
                </a>
            
                <a  href="?address=<?= $address['person_id']; ?>" data-target="#deleteAddress" class="remove-button">
                    DELETE
                </a>
            </td>
            <td><?= htmlspecialchars(strip_tags($address['address'])); ?></td>
            <td><?= htmlspecialchars(strip_tags($address['city'])); ?></td>
            <td><?= htmlspecialchars(strip_tags($address['state'])); ?></td>
            <td><?= htmlspecialchars(strip_tags($address['zip'])); ?></td>
            <td><?= htmlspecialchars(strip_tags($address['phone'])); ?></td>
            <td><?= htmlspecialchars(strip_tags($address['email'])); ?></td>
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
<!-- edit Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content modal-content-edit">
                <div class="modal-header">
                    <h3 class="modal-title">Contact Information</h3>
                        <div class="modal-body">
                            <form role="form" method="POST">
                              <div class="form-group">
                                <div class="form-group">
                                <input type="text" class="modal-form-control text-center" id="first-name" placeholder="First Name" name="firstname">
                                </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="last-name" placeholder="Last Name" name="lastname">
                                  </div>
                                    <input type="text" class="modal-form-control text-center" id="address" placeholder="Address" name="address">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="city" placeholder="City" name="city">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="state" placeholder="State" name="state">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="zipcode" placeholder="Zipcode" name="zip">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="phone-number" placeholder="Phone Number" name="phone">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="email" placeholder="Email" name="email">
                                  </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                                        <button type="submit" class="btn btn-success" href="?id=<?= $person['id']; ?>">edit</button>
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
        var toggle = function() {
            var mydiv = document.getElementById('collapse');
            if (mydiv.style.display === 'inline' || mydiv.style.display === '')
                mydiv.style.display = 'none';
            else
                mydiv.style.display = 'inline';
        }

        // add code to autofill

    </script>
    <footer></footer>
</html>