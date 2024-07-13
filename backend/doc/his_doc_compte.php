
<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $doc_id = $_SESSION['doc_id'];
  $doc_number = $_SESSION['doc_number'];
?>

<!DOCTYPE html>
    <html lang="en">

    <?php include('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
             <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <!--Get Details Of A Single User And Display Them Here-->
            <?php
                $doc_number=$_SESSION['doc_number'];
                $ret="SELECT  * FROM his_docs WHERE doc_number=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$doc_number);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
            {
            ?>
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                                            <li class="breadcrumb-item active">Afficher Mon Profile</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Profile de <?php echo $row->doc_fname;?> <?php echo $row->doc_lname;?></h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box text-center">
                                    <img src="../doc/assets/images/users/<?php echo $row->doc_dpic;?>" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">

                                    
                                    <div class="text-centre mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Nom complet :</strong> <span class="ml-2"><?php echo $row->doc_fname;?> <?php echo $row->doc_lname;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Identifiant :</strong> <span class="ml-2"><?php echo $row->doc_number;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2"><?php echo $row->doc_email;?></span></p>


                                    </div>

                                </div> <!-- end card-box -->

                            </div> <!-- end col-->
                            <!--Vitals-->
                            <div class="col-lg-6 col-xl-6">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Temperature du corps</th>
                                                <th>Fréquence cardiaque/pouls</th>
                                                <th>Fréquence respiratoire</th>
                                                <th>Pression artérielle</th>
                                                <th>Date d'enregistrement</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $vit_pat_number =$_SESSION['doc_number'];
                                            $ret="SELECT  * FROM his_vitals WHERE vit_pat_number =?";
                                            $stmt= $mysqli->prepare($ret) ;
                                            $stmt->bind_param('i',$vit_pat_number );
                                            $stmt->execute() ;//ok
                                            $res=$stmt->get_result();
                                            //$cnt=1;
                                            
                                            while($row=$res->fetch_object())
                                                {
                                            $mysqlDateTime = $row->vit_daterec; //trim timestamp to date

                                        ?>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $row->vit_bodytemp;?>°C</td>
                                                    <td><?php echo $row->vit_heartpulse;?>BPM</td>
                                                    <td><?php echo $row->vit_resprate;?>bpm</td>
                                                    <td><?php echo $row->vit_bloodpress;?>mmHg</td>
                                                    <td><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></td>
                                                </tr>
                                            </tbody>
                                        <?php }?>
                                    </table>
                                    </div>
                                </div> <!-- end col-->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->


            </div>
            <?php }?>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>


</html>