<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_profile']))
		{
			$doc_fname=$_POST['doc_fname'];
			$doc_lname=$_POST['doc_lname'];
			$doc_id=$_SESSION['doc_id'];
            $doc_email=$_POST['doc_email'];
           // $doc_pwd=sha1(md5($_POST['doc_pwd']));
            $doc_dpic=$_FILES["doc_dpic"]["name"];
		    move_uploaded_file($_FILES["doc_dpic"]["tmp_name"],"assets/images/users/".$_FILES["doc_dpic"]["name"]);

            //sql to insert captured values
			$query="UPDATE his_docs SET doc_fname=?, doc_lname=?,  doc_email=?, doc_dpic=? WHERE doc_id = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ssssi', $doc_fname, $doc_lname, $doc_email, $doc_dpic, $doc_id);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Profile Updated";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
        }
        //Change Password
        if(isset($_POST['update_pwd']))
		{
            $doc_number=$_SESSION['pat_id'];
            $doc_pwd=sha1(md5($_POST['doc_pwd']));//double encrypt 
            
            //sql to insert captured values
			$query="UPDATE his_patients SET doc_pwd =? WHERE pat_id = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('si', $doc_pwd, $doc_number);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Password Updated";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!DOCTYPE html>
    <html lang="en">
        <?php include('assets/inc/head.php');?>
    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('assets/inc/nav.php');?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include('assets/inc/sidebar.php');?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <?php
                $doc_id=$_SESSION['pat_id'];
                $ret="SELECT * FROM  his_patients where pat_id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('i',$doc_id);
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
                                        <h4 class="page-title">Profile de <?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title -->

                            <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    
                                    <div class="text-centre mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Nom complet :</strong> <span class="ml-2"><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Identifiant :</strong> <span class="ml-2"><?php echo $row->pat_number;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2"><?php echo $row->pat_email;?></span></p>


                                    </div>

                                </div> <!-- end card-box -->

                            </div> <!-- end col-->

                                <div class="col-lg-8 col-xl-8">
                                    <div class="card-box">
                                        <ul class="nav nav-pills navtab-bg nav-justified">
                                            <li class="nav-item">
                                                <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                                    Mettre à jour votre Profile
                                                </a>
                                            </li>
                                            
                                            <li class="nav-item">
                                                <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                    Changer de Mot de passe
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="aboutme">

                                            <form method="post" enctype="multipart/form-data">
                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Informations Personnelles</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="firstname">Prénom</label>
                                                                <input type="text" name="doc_fname" required="required"  class="form-control" id="firstname" placeholder="<?php echo $row->pat_fname;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lastname">Nom</label>
                                                                <input type="text" name="doc_lname" required="required" class="form-control" id="lastname" placeholder="<?php echo $row->pat_lname;?>">
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="useremail">Addresse Email</label>
                                                                <input type="email" name="doc_email" required="required"  class="form-control" id="useremail" placeholder="<?php echo $row->pat_email;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="useremail">Photo de Profile</label>
                                                                <input type="file" name="doc_dpic" class="form-control btn btn-success" id="useremail" >
                                                            </div>
                                                        </div>
                                                        
                                                    </div> <!-- end row -->
                                                    
                                                    <div class="text-right">
                                                        <button type="submit" name="update_profile" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Sauvegarder</button>
                                                    </div>
                                                </form>


                                            </div> <!-- end tab-pane -->
                                            <!-- end about me section content -->

                                           

                                            <div class="tab-pane" id="settings">
                                                <form method="post">
                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Informations Personnelles</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="firstname">Ancien Mot de Passe</label>
                                                                <input type="password" class="form-control" id="firstname" placeholder="Saisir votre ancien mot de passe">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lastname">Nouveau Mot de Passe</label>
                                                                <input type="password" class="form-control" name="doc_pwd" id="lastname" placeholder="Saisir votre nouveau mot de passe">
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <div class="form-group">
                                                        <label for="useremail">Confirmer Mot de Passe</label>
                                                        <input type="password" class="form-control" id="useremail" placeholder="Confirmer votre nouveau mot de passe">
                                                    </div>

                                                    <div class="text-right">
                                                        <button type="submit" name="update_pwd" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Sauvegarder</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- end settings content-->

                                        </div> <!-- end tab-content -->
                                    </div> <!-- end card-box-->

                                </div> <!-- end col -->
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