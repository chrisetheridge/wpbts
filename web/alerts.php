<?php
$_TITLE = "WPBTS - User Management";
require_once("header.php");
require_once('php/DBConn_Dave.php');
include_once("users_functions.php");
session_start();

//Setup authenticatoin.
if ($_SESSION['AUTH_USER_ID'] == null) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Not logged in..";
    $_SESSION['alert']['message'] = " Please authenticate to regain access";
    header('Location: login.php');
    exit();
}


?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active">Alert Management</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Alert Management</h1>
        </div>
    </div><!--/.row-->

    <?php
    if (isset($_SESSION['alert'])) {
        ?>
        <div class="alert <?php echo $_SESSION['alert']['message_type']; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong><?php echo $_SESSION['alert']["message_title"] ?></strong></div>
        <?php
        $_SESSION['alert'] = null;
    }
    ?>

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>All Alerts</h4>
            <a href="users_createuser.php" class="btn btn-default btn-md">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Alert
            </a>
        </div>
    </div>
    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <?php
                //LETS GET ALL ALERTS FROM THE DB THAT HAVE BEEN SENT.
            ?>
            <table data-toggle="table" data-search="true" data-pagination="true">
                <thead>
                <tr>
                    <th class="text-center">User ID</th>
                    <th class="text-center" data-sortable="true">Name</th>
                    <th class="text-center" data-sortable="true">Surname</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center" data-sortable="true">DOB</th>
                    <th class="text-center">Blood Type</th>
                    <th class="text-center">Options</th>
                </tr>
                </thead>


            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>


</div>    <!--/.main-->

<?php require_once('footer.php'); ?>
<!--<script>-->
<!--    $('#calendar').datepicker({});-->
<!---->
<!--    !function ($) {-->
<!--        $(document).on("click", "ul.nav li.parent > a > span.icon", function () {-->
<!--            $(this).find('em:first').toggleClass("glyphicon-minus");-->
<!--        });-->
<!--        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");-->
<!--    }(window.jQuery);-->
<!---->
<!--    $(window).on('resize', function () {-->
<!--        if ($(window).width() > 768)-->
<!--            $('#sidebar-collapse').collapse('show')-->
<!--    })-->
<!--    $(window).on('resize', function () {-->
<!--        if ($(window).width() <= 767)-->
<!--            $('#sidebar-collapse').collapse('hide')-->
<!--    })-->
<!--</script>-->

<script>
    function filterSName() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");

        var tdField = 2;

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[tdField];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<script>
    function filterDOB() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput2");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        var tdField = 5;
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[tdField];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<script>
    function filterBT() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput3");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        var tdField = 6;
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[tdField];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>


<script>
    $('#calendar').datepicker({});

    !function ($) {
        $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768)
            $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767)
            $('#sidebar-collapse').collapse('hide')
    })

    var jsonClinics = <?php echo json_encode(getAllClinics($mysqli)); ?>;

    //view event modal
    jQuery(function ($) {
        $('a.viewclinic').click(function (ev) {
            ev.preventDefault();
            window.console && console.log('button clicked');
            var uid = $(this).data('id');

            //get json object

            var objClinic;
            $.each(jsonClinics, function (i, item) {
                if (typeof item == 'object') {
                    if (item.clinic_id === uid.toString()) {
                        objClinic = item;
                    }
                }
            });

            $('#modal-view-clinic .modal-header .modal-title').html("Viewing: " + objClinic.clinic_id);

            $('#modal-view-clinic .modal-body #moClinicID').html(objClinic.clinic_id);
            $('#modal-view-clinic .modal-body #moClinicDescription').html(objClinic.description);
            $('#modal-view-clinic .modal-body #moClinicContact1').html(objClinic.contact_1);
            $('#modal-view-clinic .modal-body #moClinicContact2').html(objClinic.contact_2);
            $('#modal-view-clinic .modal-body #moClinicDescription').html(objClinic.description);
            $('#modal-view-clinic .modal-body #moClinicStreetNo').html(objClinic.street_no);
            $('#modal-view-clinic .modal-body #moClinicStreet').html(objClinic.street);
            $('#modal-view-clinic .modal-body #moClinicArea').html(objClinic.area);
            $('#modal-view-clinic .modal-body #moClinicCity').html(objClinic.city);
            $('#modal-view-clinic .modal-body #moClinicAreaCode').html(objClinic.area_code);

            $('#modal-view-clinic').modal('show', {backdrop: 'static'});

        });
    });

    //cancel event confirmation dialog
    jQuery(function ($) {
        $('a.removeclinic').click(function (ev) {
            ev.preventDefault();
            var uid = $(this).data('id');

            //get json object

            var objClinic;
            $.each(jsonClinics, function (i, item) {
                if (typeof item == 'object') {
                    if (item.clinic_id === uid.toString()) {
                        objClinic = item;
                    }
                }
            });

            $('#modal-remove-clinic .modal-body #moClinicID').html(objClinic.clinic_id);
            $('#modal-remove-clinic .modal-body #moClinicDescription').html(objClinic.description);
            $('#modal-remove-clinic .modal-footer #confirmationBtns').html("<a class='btn btn-md btn-primary' href='php/delete-clinic.php?clinic=" + objClinic.clinic_id + "'>Delete Clinic</a>");


            $('#modal-remove-clinic').modal('show', {backdrop: 'static'});

        });
    });


</script>

</body>

</html>
