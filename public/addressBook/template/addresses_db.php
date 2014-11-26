<?php

define("DB_HOST", '127.0.0.1');
define("DB_NAME", 'addressBook');
define("DB_USER", 'queen');
define("DB_PASS", 'password');

require "../inc/db_connect.php";

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

    <div class="container-name add-name">
        <div class="row row-border">
            <div class="col-md-3">
                <h4><a data-toggle="modal" href="" data-target="#update-modal" id="add-name-header">Add Entry</a></h4>
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
        <!-- Modal -->
       <div class="modal fade in" id="deleteRow">
                  <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body">
                        Are you sure you want to delete this entire row?
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                        <button type="button" class="btn btn-danger">delete</button>
                      </div>
                    </div>
                  </div>
                </div>
        <tr>
            <td>
                <a data-toggle="modal" href="" data-target="#deleteRow" class="remove-button">
                    DELETE
                </a>
                
            </td>
            <td>Patrick</td>
            <td>Rodo</td>
            <td>
                <a data-toggle="modal" href="" id="edit-modal" data-target="#update-modal" class="edit-button">
                    EDIT | </a>    
                <a data-toggle="modal" href="" data-target="#deleteAddress" class="remove-button">
                    DELETE
                </a>
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
                <div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h3 class="modal-title">Contact Information</h3>
                            <div class="modal-body">
                                <form method="POST">
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="first-name" name="firstname" class="edit" placeholder="First Name">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="last-name" name = "lastname" class="edit" placeholder="Last Name">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="address" name="address" class="edit" placeholder="Address">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="city" name="city" class="edit" placeholder="City">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="state" name="state" class="edit" placeholder="State">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="zipcode" name="zip" placeholder="Zipcode">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="phone-number" name="phone" placeholder="Phone Number">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="modal-form-control text-center" id="email" name="email" class="edit" placeholder="Email">
                                  </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button> <button type="submit" class="btn btn-success" value="add"><a href="?id=add">add</a></button> <button type="submit" class="btn btn-success" value="edit"><a href="?id=edit">Update Entry</a></button>
            </td>
            <td>24907 Crescent Trce</td>
            <td>San Antonio</td>
            <td>TX</td>
            <td>78258</td>
            <td>(210) 928-7710</td>
            <td>patrickrodo@yahoo.com</td>
        </tr> 
        <tr>
            <td>
                <a data-toggle="modal" href="" data-target="#deleteRow" class="remove-button">
                    DELETE
                </a>
                <!-- Modal -->
                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body">
                        Are you sure you want to delete this entire row?
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                            <button type="button" class="btn btn-danger">delete</button>
                        </div>
                    </div>
                  </div>
                </div>
            </td>
            <td>Patrick</td>
            <td>Rodo</td>
            <td>
                <a data-toggle="modal" href="" data-target="#edit-modal" class="edit-button">
                    EDIT |
                </a>        
                <a data-toggle="modal" href="" data-target="#deleteAddress" class="remove-button">
                    DELETE
                </a>
            </td>
            
        </tr> 
        
    </table>        
    <? var_dump($_POST); ?>
</body>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var toggle = function() {
            var mydiv = document.getElementById('collapse');
            if (mydiv.style.display === 'inline' || mydiv.style.display === '')
                mydiv.style.display = 'none';
            else
                mydiv.style.display = 'inline'
        }

        function centerModal() {
            $(this).css('display', 'block');
            var $dialog = $(this).find(".modal-dialog");
            var offset = ($(window).height() - $dialog.height()) / 2;
            // Center modal vertically in window
            $dialog.css("margin-top", offset);
        }

        $('.modal').on('show.bs.modal', centerModal);
        $(window).on("resize", function () {
            $('.modal:visible').each(centerModal);
        });
        // $('#edit-modal').click(function() {
        //             $('.edit-modal').each(function() {
        //                 $(this).val()
        //             });
        //         });
    </script>
    <footer></footer>
</html>