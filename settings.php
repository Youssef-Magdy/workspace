<?php
session_start();
include 'connect.php';
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
<!--        --><?php
//        $stmt = $con->prepare('SELECT * from settings ');
//        $stmt->execute();
//        $rows = $stmt->fetchAll();
//        ?>
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
                    <li>Settings</li>
                    <li>Drinks</li>
                </ol>

            </div>

            <div id="content">

                <div class="row" style="width: 100%;">
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-2">
                        <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-glass"></i> Drinks </h1>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-2">
                        <a href="settings.php?do=add" class="btn btn-primary" style="padding: 10px; margin:5px 0;width:80px"><i class="fa-fw fa fa-plus"></i>Add</a>
                    </div>
                </div>

                <?php
                $total = $con->query('
           SELECT
            COUNT(*)
            FROM
            settings
            ')->fetchColumn();
                // How many items to list per page
                if (empty($total)) {
                    $stmt = $con->prepare('SELECT * from settings ');
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
                    $stmt = $con->prepare('SELECT * FROM  settings LIMIT :limit OFFSET :offset');

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
                    $stmt = $con->prepare("SELECT * FROM  settings WHERE name LIKE '%$searchq%' ");
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

                        echo "<script type='text/javascript'>  setTimeout(function() {window.location.href = 'settings.php?do=manage'}, 2000)</script>";


                    }
                }

                ?>


                <form action="settings.php?do=manage" method="get" class="smart-form" >


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
                            <td>Price</td>
                            <td>Control</td>
                        </tr>
                        <?php
                        foreach ($rows as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['price'] ?></td>
                                <td>
                                    <a href="settings.php?do=edit&id=<?php echo $row['id']; ?>"
                                       class="btn btn-success">Edit</a>
                                    <a href="settings.php?do=delete&id=<?php echo $row['id']; ?>"
                                       class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php // The "back" link
                    if (!empty($total)) {

                        $prevlink = ($page > 1) ? '<a style="color:red;" href="settings.php?do=manage&page=1" title="First page">&laquo;</a> <a style="color:red;" href="settings.php?do=manage&page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

                        // The "forward" link
                        $nextlink = ($page < $pages) ? '<a style="color:red;" href="settings.php?do=manage&page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a style="color:red;" href="settings.php?do=manage&page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

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
            $price = $_POST['price'];

            $stmt = $con->prepare("INSERT INTO settings(name , price)
        VALUES(:zname,:zprice )");
            $stmt->execute(array(
                ':zname' => $name,
                ':zprice' => $price
                ));

            echo "<script type='text/javascript'>  setTimeout(function() {window.location.href = 'settings.php?do=manage' , 0})</script>";

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
                    <li>Settings</li>
                    <li>Drinks</li>
                    <li>Add</li>

                </ol>

            </div>
            <!-- END RIBBON -->
            <!--------------start contect------------------->
            <div id="content">

                <div class="row" >
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                        <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-plus"></i> Add Drink </h1>
                    </div>
                </div>
                <div class="row">
                    <div>

                        <!--Start Validation Form -->

                        <form action="settings.php?do=add" method="post" style="padding: 20px;"
                              name="form" id="checkout-form" class="smart-form " enctype="multipart/form-data">
                            <fieldset>
                                <div class="row">
                                    <section class="col col-6">
                                        <label class="input"> <i class="icon-prepend fa fa-glass"></i>
                                            <input type="text" name="name" placeholder="Name"
                                                   required autocomplete="off">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="input"> <i class="icon-prepend fa  fa-money"></i>
                                            <input type="text" name="price" placeholder="Please Entry Your Price"
                                                   autocomplete="off" >
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
    }elseif ( $do == 'edit'){

        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $stmt = $con->prepare("SELECT * FROM settings WHERE id = ?");
        $stmt->execute(array($id));
        $row = $stmt->fetch();
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
                    <li>Settings</li>
                    <li>Drinks</li>
                    <li>Edit</li>

                </ol>

            </div>
            <!-- END RIBBON -->
            <!--------------start contect------------------->
            <div id="content">

                <div class="row" >
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                        <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-edit"></i> Edit </h1>
                    </div>
                </div>
                <div class="row">
                    <div>

                        <!--Start Validation Form -->

                        <form action="settings.php?do=update" method="post" style="padding: 20px;"
                              name="form" id="checkout-form" class="smart-form " enctype="multipart/form-data">
                            <fieldset>
                                <input type="hidden" name="id" value="<?php echo $row['id']?>">
                                <div class="row">
                                    <section class="col col-6">
                                        <label class="input"> <i class="icon-prepend fa fa-glass"></i>
                                            <input type="text" name="name" placeholder="Name"
                                                   required autocomplete="off" value="<?php echo $row['name']?>">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="input"> <i class="icon-prepend fa  fa-money"></i>
                                            <input type="text" name="price" placeholder="Please Entry Your Price"
                                                   autocomplete="off" value="<?php echo $row['price']?>">
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


        <?php
    }elseif ( $do == 'update'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Get The Variables From The Form
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];

            $stmt = $con->prepare("UPDATE settings SET  name=? , price = ?  WHERE id= ? ");
            $stmt->execute(array( $name , $price , $id));

        }
        echo "<script type='text/javascript'>  setTimeout(function() {window.location.href = 'settings.php?do=manage'} , 0) </script>";


    }elseif ($do == 'delete') {

        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $stmt = $con->prepare('DELETE FROM settings WHERE id = :zuser ');
        $stmt->bindParam(":zuser", $id);
        $stmt->execute();
        echo "<script type='text/javascript'>  setTimeout(function() {window.location.href = 'settings.php?do=manage' , 0})</script>";


    }
    include 'inculde/footer.inc';


} else {

    header('location:index.php');
    exit();
}
?>

<!-- END MAIN PANEL -->

