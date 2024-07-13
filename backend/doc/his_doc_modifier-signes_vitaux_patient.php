<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['add_patient_vitals']))
		{
			$vit_number = $_POST['vit_number'];
			$vit_pat_number = $_POST['vit_pat_number'];
            $vit_bodytemp  = $_POST['vit_bodytemp'];
            $vit_heartpulse = $_POST['vit_heartpulse'];
            $vit_resprate  = $_POST['vit_resprate'];
            $vit_bloodpress = $_POST['vit_bloodpress'];
            //$pres_ins = $_POST['pres_ins'];
            //$pres_pat_ailment = $_POST['pres_pat_ailment'];
            //sql to insert captured values
			$query="INSERT INTO  his_vitals  (vit_number, vit_pat_number, vit_bodytemp, vit_heartpulse, vit_resprate, vit_bloodpress) VALUES(?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ssssss', $vit_number, $vit_pat_number, $vit_bodytemp, $vit_heartpulse, $vit_resprate, $vit_bloodpress);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Données vitales du patient ajoutées";
			}
			else {
				$err = "Veuillez réessayer ou réessayer plus tard";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
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
            <?php
                $pat_number = $_GET['pat_number'];
                $ret="SELECT  * FROM his_patients WHERE pat_number=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$pat_number);
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
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laboratoire</a></li>
                                                <li class="breadcrumb-item active">Capturer les signes vitaux</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Capture des signes vitaux de <?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 
                            <!-- Form row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">Ajouter tous les champs</h4>
                                            <!--Add Patient Form-->
                                            <form method="post">
                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Nom du patient</label>
                                                        <input type="text" required="required" readonly name="" value="<?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?>" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Maladie du patient</label>
                                                        <input required="required" type="text" readonly name="" value="<?php echo $row->pat_ailment;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                    </div>

                                                </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4" class="col-form-label">Identifiant du patient</label>
                                                        <input type="text" required="required" readonly name="vit_pat_number" value="<?php echo $row->pat_number;?>" class="form-control" id="inputEmail4" placeholder="DD/MM/YYYY">
                                                    </div>


                                                </div>

                                                
                                                <hr>
                                                <div class="form-row">
                                                    
                                            
                                                    <div class="form-group col-md-2" style="display:none">
                                                        <?php 
                                                            $length = 5;    
                                                            $vit_no =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                        ?>
                                                        <label for="inputZip" class="col-form-label">Vital Number</label>
                                                        <input type="text" name="vit_number" value="<?php echo $vit_no;?>" class="form-control" id="inputZip">
                                                    </div>
                                                </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-3">
                                                        <label for="inputEmail4" class="col-form-label">Température corporelle du patient °C</label>
                                                        <input type="text" required="required"  name="vit_bodytemp"class="form-control" id="inputEmail4" placeholder="°C">
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="inputPassword4" class="col-form-label">BPM du pouls/battement cardiaque du patient</label>
                                                        <input required="required" type="text"  name="vit_heartpulse"  class="form-control"  id="inputPassword4" placeholder="HeartBeats Per Minute ">
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="inputPassword4" class="col-form-label">Fréquence respiratoire du patient bpm</label>
                                                        <input required="required" type="text"  name="vit_resprate"  class="form-control"  id="inputPassword4" placeholder="Breathes Per Minute">
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="inputPassword4" class="col-form-label">Tension artérielle du patient mmHg</label>
                                                        <input required="required" type="text"  name="vit_bloodpress"  class="form-control"  id="inputPassword4" placeholder="mmHg">
                                                    </div>

                                                </div>

                                                <button type="submit" name="add_patient_vitals" class="ladda-button btn btn-success" data-style="expand-right">modifier les signes viatux</button>

                                            </form>
                                            <!--End Patient Form-->
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card-->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

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
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        CKEDITOR.replace('editor')
        </script>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>