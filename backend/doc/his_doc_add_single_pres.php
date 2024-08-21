<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['add_patient_presc']))
		{
			$pres_pat_name = $_POST['pres_pat_name'];
			$pres_pat_number = $_POST['pres_pat_number'];
            $pres_pat_addr = $_POST['pres_pat_addr'];
            $pres_pat_age = $_POST['pres_pat_age'];
            $pres_number = $_POST['pres_number'];
            $pres_ins = $_POST['pres_ins'];
            $pres_pat_ailment = $_POST['pres_pat_ailment'];
            //sql to insert captured values
			$query="INSERT INTO  his_prescriptions  (pres_pat_name, pres_pat_number, pres_pat_type, pres_pat_addr, pres_pat_age, pres_number, pres_pat_ailment, pres_ins) VALUES(?,?,?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ssssssss', $pres_pat_name, $pres_pat_number, $pres_pat_type, $pres_pat_addr, $pres_pat_age, $pres_number, $pres_pat_ailment, $pres_ins);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Prescription du patient ajoutée";
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
                                                <li class="breadcrumb-item"><a href="his_doc_tableau_de_bord.php">Tableau de bord</a></li>
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pharmacie</a></li>
                                                <li class="breadcrumb-item active">Ajouter une ordonnance</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Ajouter une prescription au patient</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title -->
                            <!-- Form row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">Remplissez tous les champs</h4>
                                            <!--Add Patient Form-->
                                            <form method="post">
                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Nom du patient</label>
                                                        <input type="text" required="required" readonly name="pres_pat_name" value="<?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?>" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Âge du patient</label>
                                                        <input required="required" type="text" readonly name="pres_pat_age" value="<?php echo $row->pat_age;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                    </div>

                                                </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Numéro de patient</label>
                                                        <input type="text" required="required" readonly name="pres_pat_number" value="<?php echo $row->pat_number;?>" class="form-control" id="inputEmail4" placeholder="DD/MM/YYYY">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Adresse du patient</label>
                                                        <input required="required" type="text" readonly name="pres_pat_addr" value="<?php echo $row->pat_addr;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Age">
                                                    </div>

                                                </div>

                                                <div class="form-group ">
                                                        <label for="inputCity" class="col-form-label">Maladie du patient</label>
                                                        <input required="required" type="text" value="<?php echo $row->pat_ailment;?>" name="pres_pat_ailment" class="form-control" id="inputCity">
                                                </div>
                                                <hr>
                                                <div class="form-row">


                                                    <div class="form-group col-md-2" style="display:none">
                                                        <?php
                                                            $length = 5;
                                                            $pres_no =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                        ?>
                                                        <label for="inputZip" class="col-form-label">Numéro d'ordonnance</label>
                                                        <input type="text" name="pres_number" value="<?php echo $pres_no;?>" class="form-control" id="inputZip">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Ordonnance</label>
                                                        <textarea required="required" rows = "10" class="form-control" id= "pres_ins" name="pres_ins"></textarea>
                                                        <!-- <textarea required="required"  type="text" class="form-control" name="pres_ins" id="editor"></textarea> -->
                                                </div>
                                                <div class="form-group">
                                                    <progress id="progressbar" min="0" max="1" value="0">
                                                </div>

                                                <button type="submit" class="ladda-button btn btn-primary" data-style="expand-right"><input type="file" id="input_image" name="input_image"/></button>
                                                <button type="submit" name="add_patient_presc" class="ladda-button btn btn-primary" data-style="expand-right">Ajouter une prescription au patient</button>

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

        <style>
            textarea {
                resize: none;
            }
        </style>
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        // CKEDITOR.replace('editor')
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src='https://cdn.rawgit.com/naptha/tesseract.js/1.0.10/dist/tesseract.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                var input_image = document.getElementById('input_image');
                input_image.addEventListener('change', handleInputChange);
            });

            function handleInputChange(event){
                var input = event.target;
                var file = input.files[0];
                console.log(file);
                Tesseract.recognize(file)
                    .progress(function(message){
                        document.getElementById('progressbar').value = message.progress;
                        console.log(message);
                    })
                    .then(function(result){
                        var contentArea = document.getElementById('pres_ins');
					    contentArea.innerHTML = result.text;
                        console.log(result);
                    })
                    .catch(function(err){
                        console.error(err);
                    });
            }
        </script>


    </body>

</html>