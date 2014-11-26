<?php

//connect to host
    define("DB_HOST", '127.0.0.1');
    define("DB_NAME", "addressBook");
    define("DB_USER", "queen");
    define("DB_PASS", 'password');

    require '../inc/db_connect.php';
    
//find total number of rows and build pagination from that count
    $pageLimit = 4;
    $count = $dbc->query("SELECT COUNT(*) FROM addresses");
    $pageCount = $count->fetchColumn();
    $pages = ceil($pageCount / $pageLimit);
    $lastPage = $pages;
    
    $addresses = [];
    
//define page number
    (isset($_GET['page']) && $_GET['page'] >= 1) ? $current_page = $_GET['page'] : $current_page = 1;
    
//delete item
    if(!empty($_GET))
    {
        if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $stmt = $dbc->query("DELETE FROM person WHERE id=$id");
                header("Location: http://planner.dev/address_book/templates/index.php");
            }
        if(isset($_GET['address']))
        {
            $removeAddress = $_GET['address'];
            $stmt = $dbc->query("DELETE FROM addresses WHERE person_id=$removeAddress");
            header("Location: http://planner.dev/address_book/templates/index.php");
        }
        
    }
//query database
    $offsetQuery = ($current_page -1) *4;
    $query = "SELECT * FROM person LIMIT :pageLimit OFFSET :offset";
    $stmt = $dbc->prepare($query);

    $stmt->bindValue(':pageLimit',  $pageLimit,  PDO::PARAM_INT);
    $stmt->bindValue(':offset',  $offsetQuery,  PDO::PARAM_INT);

    $stmt->execute();
    
    $personInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $query = "SELECT * FROM addresses LIMIT :pageLimit OFFSET :offset";
    $stmt = $dbc->prepare($query);

    $stmt->bindValue(':pageLimit',  $pageLimit,  PDO::PARAM_INT);
    $stmt->bindValue(':offset',  $offsetQuery,  PDO::PARAM_INT);

    $stmt->execute();
    
    $addressInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($_POST);
    if(!empty($_POST))
    {
        
    //validating name
        if((isset($_POST['firstname'])) && (isset($_POST['lastname'])))
        {
            
        // logic for person table
            $stmt = $dbc->prepare("INSERT INTO person (firstname, lastname) 
                       VALUES (:firstname, :lastname)");
            
            $stmt->bindValue(':firstname',  $_POST['firstname'],  PDO::PARAM_STR);
            $stmt->bindValue(':lastname',  $_POST['lastname'],  PDO::PARAM_STR);
            
            $stmt->execute();
            $contactId = $dbc->lastInsertId();
            
        }
            !empty($_POST['email']) ? $_POST['email'] : null;
            !empty($_POST['phone']) ? $_POST['phone'] : null;
            !empty($_POST['address']) ? $_POST['address'] : null;
            !empty($_POST['city']) ? $_POST['city'] : null;
            !empty($_POST['state']) ? $_POST['state'] : null;
            !empty($_POST['zip']) ? $_POST['zip'] : null;
            
        // logic for addresses table
            $query = "INSERT INTO addresses (person_id, email, phone, address, city, state, zip) 
                        VALUES (:person_id, :email, :phone, :address, :city, :state, :zip)  ";
                        
            $stmt = $dbc->prepare($query);

            $stmt->bindValue(':person_id',  $contactId,  PDO::PARAM_STR);
            $stmt->bindValue(':email',  $_POST['email'],  PDO::PARAM_STR);
            $stmt->bindValue(':phone',  $_POST['phone'],  PDO::PARAM_STR);
            $stmt->bindValue(':address',  $_POST['address'],  PDO::PARAM_STR);
            $stmt->bindValue(':city',  $_POST['city'],  PDO::PARAM_STR);
            $stmt->bindValue(':state',  $_POST['state'],  PDO::PARAM_STR);
            $stmt->bindValue(':zip',  $_POST['zip'],  PDO::PARAM_INT);
            
            $stmt->execute();
            header("Location: http://planner.dev/address_book/templates/addressdb.php");
            
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
                <h4><a data-toggle="modal" href="" data-target="#add-edit-modal" id="add-name-header">Add Entry</a></h4>
            </div>
        </div>
    </div>

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
        <tr>
            <?php foreach ($personInfo as $person) :?>
            <td>
                <a href="?id=<?= $person['id']; ?>" data-target="#deleteRow" class="remove-button">
                    DELETE
                </a>
            </td>
            <td><?= htmlspecialchars(strip_tags($person['firstname'])); ?></td>
            <td><?= htmlspecialchars(strip_tags($person['lastname'])); ?></td>
            <td>
                <a data-toggle="modal" href="?id=<?= $person['id']; ?>" data-target="#add-edit-modal" class="add-button">
                    EDIT |
                </a>
                <?php endforeach ?>             
            </td>
            <?php foreach ($addressInfo as $address) :?>
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
          <?php endforeach ?> 
        </tr> 
              
    
        </table>            
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
        <div class="modal fade" id="add-edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
    </script>
    <footer></footer>
</html>