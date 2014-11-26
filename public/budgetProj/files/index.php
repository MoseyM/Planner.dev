<? require_once 'header.php';
require_once 'sidebar.php'; 
require_once 'footer.php'; ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <form class=" " method = "POST" action="index.php">
                        <label for="hours"> Hours Worked: </label>
                            <input type="text" id="hours" name="hours" placeholder="Enter Hrs Worked Here">
                         <label for="comm"> Total Commission: </label>
                            <input type="text" id="comm" name="commission" placeholder="Enter Total Commission Here">
                         <label for="pay"> Hourly Pay: </label>
                            <input type="text" id="pay" name="pay" placeholder="Enter Hourly Pay Here">


                            
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
</div>
    <!-- /#wrapper -->
    </div>

	