<?php
$_TITLE = "WPBTS - Edit Event";
if(!isset($_GET['eventid']))
{
    header("Location: events.php");
}
require_once("header.php");
require_once('php/DBConn.php');
require_once('api/events/functions.php');

session_start();

//get selected event info
$eventid = filter_var($_GET['eventid'], FILTER_SANITIZE_STRING);
$event = getEvents($mysqli, $eventid)[0]; //first and only slot - 0


?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main"><!--.main-->
    
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="events.php">Event Management</a></li>
            <li class="active">Edit Event</li>
        </ol>
    </div><!--/.row-->
    <br/>
    <?php
        if(isset($_SESSION['alert']))
        {
            ?>
            <div class="alert <?php echo $_SESSION['alert']['message_type']; ?> alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><?php echo $_SESSION['alert']["message_title"] ?></strong> <?php echo $_SESSION['alert']["message"] ?>
            </div>
            <?php
            $_SESSION['alert'] = null;
        }
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Event</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">            
                <form role="form" action="php/form-handler-event-edit-create.php" method="POST" class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-6">
                        <label>Event ID</label>
                        <input required readonly type="text" class="form-control" name="eventid" value="<?php echo $event['event_id']; ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">Creator ID</label>
                        <input required readonly type="text" class="form-control" name="creatorid" value="<?php echo $event['creator_id']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Title</label>
                        <input required type="text" class="form-control" name="title" value="<?php echo $event['title']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Description</label>
                        <textarea required class="form-control" rows="6" name="description"><?php echo $event['description']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Date</label>
                                <input required type="text" class="form-control daterange" id="eventdate" name="date" value="<?php echo $event['event_date']; ?>">    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Type</label>
                                <select required type="text" class="form-control" name="typeid">
                                    <?php
                                    {
                                        $sql = "SELECT * FROM TBL_EVENT_TYPE;";
                                        $QueryResult = $mysqli->query($sql);
                                        if ($QueryResult == TRUE)
                                        {
                                            ?>
                                                <option value='-1' disabled>Select one--</option>
                                            <?php
                                            while (($Row = $QueryResult->fetch_assoc()) !== NULL)
                                            {
                                                ?>
                                                    <option <?php if($event['type_id'] === $Row['TYPE_ID']){ echo "selected"; } ?> value='<?php echo $Row['TYPE_ID']; ?>'><?php echo $Row['URGENCY'] . " - " . $Row['DESCRIPTION']; ?></option>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <option selected disabled>Could not load list</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Event Admin</label>
                                <select required type="text" class="form-control" name="eventadminid">
                                    <?php
                                    {
                                        $sql = "SELECT * FROM TBL_ADMIN;";
                                        $QueryResult = $mysqli->query($sql);
                                        if ($QueryResult == TRUE)
                                        {
                                            ?>
                                                <option value='-1' disabled>Select one--</option>
                                            <?php
                                            while (($Row = $QueryResult->fetch_assoc()) !== NULL)
                                            {
                                                ?>
                                                    <option <?php if($event['event_admin'] === $Row['ADMIN_ID']){ echo "selected"; } ?> value='<?php echo $Row['ADMIN_ID']; ?>'><?php echo $Row['FIRST_NAME'] . " " . $Row['LAST_NAME']; ?></option>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <option selected disabled>Could not load list</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">Address</label>
                        <input type="hidden" name="address_id" value="<?php echo $event['address_id']; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street Number</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="streetno" value="<?php echo $event['street_no']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="street" value="<?php echo $event['street']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Suburb</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="suburb" value="<?php echo $event['area']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="city" value="<?php echo $event['city']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Zip Code</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="zip" value="<?php echo $event['area_code']; ?>"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-6 text-right">
                        <br/>
                        <button type="submit" class="btn btn-info">Save Event</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    

</div>	<!--/.main-->

<?php require_once('footer.php'); ?>

<script>
    
    $("#eventdate").datepicker({dateFormat: "dd-mm-yy"}); //sets date picker format
    
</script>	
</body>

</html>