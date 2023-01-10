<?php
session_start();
include 'connect.php';
date_default_timezone_set('Africa/Cairo');
if (isset($_SESSION['username'])) {
    include 'inculde/header.inc';
    include 'inculde/nav.inc';
    $do = '';
    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }
    if ($do == 'manage') {
        ?>
<Style>
    .main-table tr:first-child td{
        background-color:#686667;
        color: white;
    }
</Style>
<?php
$stmt = $con->prepare('SELECT * from member ');
$stmt->execute();
$rows = $stmt->fetchAll();
    ?>
        <!-- MAIN PANEL -->
        <div id="main" role="main">

        <!-- RIBBON -->
        <div id="ribbon">

				<span class="ribbon-button-alignment"> 
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"
                          rel="tooltip" data-placement="bottom"
                          data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings."
                          data-html="true">
						<i class="fa fa-refresh"></i>
					</span> 
				</span>

            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home</li>
                <li>Dashboard</li>

            </ol>

        </div>

            <div id="content">

            <div class="row" style="width: 100%;">
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-2">
                    <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Members </h1>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-2">
                <a href="member.php?do=add" class="btn btn-primary" style="padding: 10px; margin:5px 0;width:80px"><i class="fa-fw fa fa-plus"></i>Add</a>
                </div>
            </div>

            <?php
                $total = $con->query('
           SELECT
            COUNT(*)
            FROM
            member
            ')->fetchColumn();
                // How many items to list per page
                if (empty($total)) {
                    $stmt = $con->prepare('SELECT * from member ');
                    $stmt->execute();
                    $rows = $stmt->fetchAll();
                } else {
                    $limit = 10;

                    // How many pages will there be
                    $pages = ceil($total / $limit);

                    // What page are we currently on?
                    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                        'options' => array(
                            'default' => 1,
                            'min_range' => 1,
                        ),
                    )));

                    // Calculate the offset for the query
                    $offset = ($page - 1) * $limit;

                    // Some information to display to the user
                    $start = $offset + 1;
                    $end = min(($offset + $limit), $total);


                    // Prepare the paged query
                    $stmt = $con->prepare('SELECT * FROM  member LIMIT :limit OFFSET :offset');

                    // Bind the query params
                    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();

                    //    $stmt = $con->prepare('SELECT * from payroll_month ');
                    //    $stmt->execute();
                    $rows = $stmt->fetchAll();
                }


            if (isset($_GET['search'])){
                $searchq = $_GET['search'];
//                $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
                $stmt = $con->prepare("SELECT * FROM  member WHERE name LIKE '%$searchq%' ");
                $stmt->execute();
                $rows = $stmt->fetchAll();

                //If There's Such Id Show The Form
                if ($count = $stmt->rowCount() > 0) {
                    foreach ($rows as $row){
                        $name = $row['name'];
                    }
                }else{

                    echo "<div class='alert alert-danger' style='max-width: 350px ; text-align: center; margin: auto;font-size: 18px'>
               لا يوجد هذا الاسم فى الجدول
        </div>";

                    echo "<script type='text/javascript'>  setTimeout(function() {window.location.href = 'member.php?do=manage'}, 2000)</script>";


                }
            }

            ?>


                <form action="member.php?do=manage" method="get" class="smart-form" >


                    <div class="row" style="width: 100%;">
                        <section class="col col-4" style="float: right;">
                            <label class="input"> <i class="icon-prepend fa fa-search"></i>
                                <input type="text" name="search" placeholder="Search by Name" autocomplete="off"  >
                            </label>
                        </section>
                    </div>

                </form>


                  <div class="table-responsive">
                       <table class="table main-table table-bordered text-center">
                            <tr>

                                <td>#</td>
                                <td> Name </td>
                                <td>Phone</td>
                                <td>Check In</td>
                                <td>Register </td>
                                <td>Check Out </td>




                            </tr>
                            <?php
                            foreach ($rows as $row) {
                               ?>
                                <tr>
                                    <td><?php echo $row['id'] ?>
                                   <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['phone'] ?></td>
                                    <td><?php echo $row['start'] ?></td>
                                    <td><?php echo $row['register'] ?></td>


                                    <td>
                                        <a href="member.php?do=update&id=<?php echo $row['id']; ?>"
                                           class="btn btn-danger">CheckOut</a>
                                    </td>
                               </tr>
                                <?php
                            }
                            ?>
                       </table>
                        <?php // The "back" link
                        if (!empty($total)) {

                            $prevlink = ($page > 1) ? '<a style="color:red;" href="member.php?do=manage&page=1" title="First page">&laquo;</a> <a style="color:red;" href="member.php?do=manage&page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

                            // The "forward" link
                           $nextlink = ($page < $pages) ? '<a style="color:red;" href="member.php?do=manage&page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a style="color:red;" href="member.php?do=manage&page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

                           // Display the paging information
                            echo '<div style="float: right;"  id="paging"><p  style=" background-color: #3a3633;color: white; padding: 10px; ">', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';
                            ?>

                        <?php
                        } ?>


                    </div>
            </div>
        </div>
        <!--------------end contect------------------->
        <?php
    }else if( $do == 'add') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//        $date = date('h:i:s', time()) ;
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];


        $stmt = $con->prepare("INSERT INTO member(name , phone , email , birthday , register )
        VALUES(:zname,:zphone ,:zemail ,:zbirth ,:zreg)");
        $stmt->execute(array(
        ':zname' => $name,
        ':zphone' => $phone,
        ':zemail' => $email,
        ':zbirth' => $age,
//         ':zstart' => $date,
         ':zreg' => $_SESSION['username']));

            $stmt = $con->prepare("INSERT INTO old_member(name , phone , email , birthday )
        VALUES(:zname,:zphone ,:zemail ,:zbirth )");
            $stmt->execute(array(
                ':zname' => $name,
                ':zphone' => $phone,
                ':zemail' => $email,
                ':zbirth' => $age));


            echo "<script type='text/javascript'>  setTimeout(function() {window.location.href = 'member.php?do=manage' , 0})</script>";

        }
        ?>


<div id="main" role="main">
    <!-- RIBBON -->
        <div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"
                          rel="tooltip" data-placement="bottom"
                          data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings."
                          data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home</li>
                <li>Add</li>

            </ol>

        </div>
        <!-- END RIBBON -->
        <!--------------start contect------------------->
        <div id="content">

            <div class="row" >
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                    <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-plus"></i> Add Member </h1>
                </div>
            </div>
            <div class="row">
                <div>

                    <!--Start Validation Form -->

                    <form action="member.php?do=add" method="post" style="padding: 20px;"
                          name="form" id="checkout-form" class="smart-form " enctype="multipart/form-data">
                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                        <input type="text" name="name" placeholder="Name"
                                               required autocomplete="off">
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                        <input type="date" name="age" placeholder="Age"
                                                autocomplete="off" >
                                    </label>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa fa-envelope-o"></i>
                                        <input type="email" name="email" placeholder="email"
                                                autocomplete="off">
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                                        <input type="tel" name="phone" placeholder="Phone" data-mask="(999) 9999-9999"
                                               autocomplete="off">
                                    </label>
                                </section>

                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa  fa-clock-o"></i>
                                        <input type="text" name="time" disabled value="<?php echo $date = date('H:i:s', time()) ;?>">
                                    </label>
                                </section>
                            </div>
                        </fieldset>

                        <button type="submit" class="btn btn-primary" style="padding: 10px;float: right;margin-top: 15px;width:80px">Save
                        </button>

                    </form>
                    <!--End Validation Form-->
                </div>
                <!-- end widget content -->
            </div>

            </div>
        </div>
        <!--------------end contect------------------->
<?php
    }elseif ( $do == 'update'){

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    $date = date('H:i:s', time());
    $stmt = $con->prepare("UPDATE member SET  end = ?  WHERE id= ? ");
    $stmt->execute(array($date , $id));
    echo "<script type='text/javascript'>  setTimeout(function() {window.location.href = 'member.php?do=cal&id=$id' , 0})</script>";



    }elseif ( $do == 'cal') {

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    $stmt = $con->prepare('SELECT * from member WHERE id=? LIMIT 1');
    $stmt->execute(array($id));
    $row = $stmt->fetch();

    $start= strtotime($row['start']);
    $end = strtotime($row['end']);
    $loginTime = $start;
    $checkTime = $end;
    $diff = $checkTime - $loginTime;

    $drin = $con->prepare("SELECT * FROM settings");
    $drin->execute();
    $rows = $drin->fetchAll();

    ?>


    <div id="main" role="main">
        <!-- RIBBON -->
        <div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"
                          rel="tooltip" data-placement="bottom"
                          data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings."
                          data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home</li>
                <li>Calculate</li>

            </ol>

        </div>
        <!-- END RIBBON -->
        <!--------------start contect------------------->
        <div id="content">

            <div class="row">
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                    <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa  fa-check"></i> Calculate </h1>
                </div>
            </div>
            <div class="row">
                <div>

                    <!--Start Validation Form -->

                    <form action="member.php" method="get" style="padding: 20px;"
                          name="form" id="checkout-form" class="smart-form " enctype="multipart/form-data">
                        <fieldset>
                            <input type="hidden" name="do" value="cal">
                            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                            <input type="hidden" name="cal" value="1">
                            <div class="row">
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" disabled value="<?php echo abs($diff)/(60*60);?>"
                                               required autocomplete="off">
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa  fa-usd"></i>
                                        <input type="text" name="pay"
                                               required autocomplete="off" <?php if(isset($_GET['pay'])){echo 'value="'.$_GET['pay'].'"';}else{echo 'placeholder="Enter the price of hour"';}?>>
                                    </label>
                                </section>
                            </div>


                            <div class="row">
                                <legend> <h4 class="col-md-4 col-lg-4 control-label" style="margin: 0 0 10px 10px ;"><strong>Drinks :</strong></h4> </legend>
                            </div>

<?php
$no='1';
foreach ($rows as $row) {
    ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="yourBox<?php echo $no;?>" class="checkbox style-0"  name="<?php echo 'd'.$no; ?>" value="<?php echo $row['price']?>" <?php if(isset($_GET['n'.$no])){echo 'checked';}?>>
                                                <span> <?php echo $row['name']?><input required id="yourText<?php echo $no;?>" <?php if(!isset($_GET['n'.$no])){echo 'disabled';}?> type="number" name="<?php echo 'n'.$no; ?>" style="position: static;margin-left: 10px"<?php if(isset($_GET['d'.$no])){echo 'value="'.$_GET['n'.$no].'"';}else{echo 'placeholder="0"';}?>> </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
    <script>
        document.getElementById('yourBox<?php echo $no;?>').onchange = function() {
            document.getElementById('yourText<?php echo $no;?>').disabled = !this.checked;
        };</script>
<?php
    $no++;
}
?>

                            <button type="submit" class="btn btn-primary" style="padding: 10px; display:block; margin: 15px auto;width:12%;">Calculate
                            </button>
                            <?php
                            if (isset($_GET['cal']) && $_GET['cal']==1){
                                $no='1';$total_drinks=0;
                                foreach ($rows as $row ){
                                    if (isset($_GET[ 'd'.$no ])){
                                        $total_drinks=($_GET[ 'd'.$no ]*$_GET['n'.$no]+$total_drinks);
                                    }
                                    $no++;
                                }
                                $s=array( $total_drinks , (abs($diff)/(60*60)*$_GET['pay']));
                                echo '<section style="display: block;width: 22%; margin: 50px auto 20px ;">
                                    <label class="input"> <i style="color: white;" class="icon-prepend fa fa-money"></i>
                                
                                        <input style="background-color: #474544; color: white;" type="text" disabled value="'.number_format(array_sum($s) ,2 , '.','').' '.'EGP'.'">
                                    </label>';

                            }

                            ?>
                        </fieldset>
                    </form>
                    <a href="?do=delete&id=<?php echo $_GET['id']?>" class="btn btn-danger" style="padding: 10px;float: right;margin: 10px 30px ;width:80px">OK
                    </a>
                    <!--End Validation Form-->
                </div>
                <!-- end widget content -->
            </div>

            </div>
        </div>


        <?php


        }elseif ($do == 'delete') {

            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            $stmt = $con->prepare('DELETE FROM member WHERE id = :zuser ');
            $stmt->bindParam(":zuser", $id);
            $stmt->execute();
            echo "<script type='text/javascript'>  setTimeout(function() {window.location.href = 'member.php?do=manage'} , 0)</script>";


        }elseif($do == 'old'){ ?>
<Style>
    .main-table tr:first-child td{
                background-color:#686667;
        color: white;
    }
</Style>
<?php
$stmt = $con->prepare('SELECT * from old_member ');
$stmt->execute();
$rows = $stmt->fetchAll();
    ?>
            <!-- MAIN PANEL -->
            <div id="main" role="main">

                <!-- RIBBON -->
                <div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"
                          rel="tooltip" data-placement="bottom"
                          data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings."
                          data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

                    <!-- breadcrumb -->
                    <ol class="breadcrumb">
                        <li>Home</li>
                        <li>Old Members</li>

                    </ol>

                </div>

                <div id="content">

                    <div class="row" style="width: 100%;">
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Old Members </h1>
                        </div>
                    </div>

                    <?php
                    $total = $con->query('
           SELECT
            COUNT(*)
            FROM
            old_member
            ')->fetchColumn();
                    // How many items to list per page
                    if (empty($total)) {
                        $stmt = $con->prepare('SELECT * from old_member ');
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                    } else {
                        $limit = 10;

                        // How many pages will there be
                        $pages = ceil($total / $limit);

                        // What page are we currently on?
                        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                            'options' => array(
                                'default' => 1,
                                'min_range' => 1,
                            ),
                        )));

                        // Calculate the offset for the query
                        $offset = ($page - 1) * $limit;

                        // Some information to display to the user
                        $start = $offset + 1;
                        $end = min(($offset + $limit), $total);


                        // Prepare the paged query
                        $stmt = $con->prepare('SELECT * FROM  old_member LIMIT :limit OFFSET :offset');

                        // Bind the query params
                        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                        $stmt->execute();

                        //    $stmt = $con->prepare('SELECT * from payroll_month ');
                        //    $stmt->execute();
                        $rows = $stmt->fetchAll();
                    }

                    if (isset($_GET['search'])){
                        $searchq = $_GET['search'];
//                $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
                        $stmt = $con->prepare("SELECT * FROM  old_member WHERE name LIKE '%$searchq%' OR date LIKE '%$searchq%' ");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();

                        //If There's Such Id Show The Form
                        if ($count = $stmt->rowCount() > 0) {
                            foreach ($rows as $row){
                                $name = $row['name'];
                            }
                        }else{

                            echo "<div class='alert alert-danger' style='max-width: 350px ; text-align: center; margin: auto;font-size: 18px'>
               لا يوجد هذا الاسم فى الجدول
        </div>";

                            echo "<script type='text/javascript'>  setTimeout(function() {window.location.href = 'member.php?do=old'}, 2000)</script>";


                        }
                    }



                    ?>



                    <form action="member.php" method="get" class="smart-form" >


                        <div class="row" style="width: 100%;">
                            <section class="col col-4" style="float: right;">
                                <input type="hidden" name="do" value="old">

                                <label class="input"> <i class="icon-prepend fa fa-search"></i>
                                    <input type="text" name="search" placeholder="Search by Name" autocomplete="off"  >
                                </label>
                            </section>
                        </div>

                    </form>


                    <div class="table-responsive">
                        <table class="table main-table table-bordered text-center">
                            <tr>

                                <td>#</td>
                                <td> Name </td>
                                <td>Phone</td>
                                <td>Email</td>
                                <td>Birthday Date</td>
                                <td>Date</td>




                            </tr>
                            <?php
                            foreach ($rows as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id'] ?>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['phone'] ?></td>
                                    <td><?php echo $row['email'] ?></td>
                                    <td><?php echo $row['birthday'] ?></td>
                                    <td><?php echo $row['date'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php // The "back" link
                        if (!empty($total)) {

                            $prevlink = ($page > 1) ? '<a style="color:red;" href="?do=old&page=1" title="First page">&laquo;</a> <a style="color:red;" href="?do=old&page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

                            // The "forward" link
                            $nextlink = ($page < $pages) ? '<a style="color:red;" href="?do=old&page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a style="color:red;" href="?do=old&page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

                            // Display the paging information
                            echo '<div style="float: right;"  id="paging"><p  style=" background-color: #3a3633;color: white; padding: 10px; ">', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';
                            ?>

                            <?php
                        } ?>


                    </div>
                </div>
            </div>
            <!--------------end contect------------------->
            <?php

        }
        include 'inculde/footer.inc';


} else {

    echo "<script type='text/javascript'> window.location.href = 'index.php'</script>";
    exit();
 }
 ?>

    <!-- END MAIN PANEL -->

