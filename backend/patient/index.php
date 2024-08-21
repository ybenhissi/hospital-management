<?php
    session_start();
    include('assets/inc/config.php');//get configuration file
    if(isset($_POST['pat_login']))
    {
        $pat_email = $_POST['pat_email'];
        //$doc_email = $_POST['doc_ea']
        $pat_pwd = sha1(md5($_POST['pat_pwd']));//double encrypt to increase security
        $stmt=$mysqli->prepare("SELECT pat_number, pat_pwd, pat_id FROM his_patients WHERE  pat_email=? AND pat_pwd=? ");//sql to log in user
        $stmt->bind_param('ss', $pat_email, $pat_pwd);//bind fetched parameters
        $stmt->execute();//execute bind
        $stmt -> bind_result($pat_number, $pat_pwd ,$pat_id);//bind result
        $rs=$stmt->fetch();
        $_SESSION['pat_id'] = $pat_id;
        $_SESSION['pat_number'] = $pat_number;//Assign session to doc_number id
        //$uip=$_SERVER['REMOTE_ADDR'];
        //$ldate=date('d/m/Y h:i:s', time());
        if($rs)
            {//if its sucessfull
                header("location:his_doc_afficher_un_patient.php");
            }

        else
            {
            #echo "<script>alert('Access Denied Please Check Your Credentials');</script>";
                $err = "Accès refusé Veuillez vérifier vos informations d'identification";
            }
    }
?>
<!--End Login-->
<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8" />
        <title>Système de gestion hospitalière - Un système d'information super réactif</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="MartDevelopers" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/diagnostic.png">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!--Load Sweet Alert Javascript-->
        
        <script src="assets/js/swal.js"></script>
        <!--Inject SWAL-->
        <?php if(isset($success)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Success","<?php echo $success;?>","success");
                            },
                                100);
                </script>

        <?php } ?>

        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Failed","<?php echo $err;?>","error");
                            },
                                100);
                </script>

        <?php } ?>



    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <p class="text-muted mb-4 mt-3">Entrez votre adresse e-mail et votre mot de passe pour accéder au panneau Patient.</p>
                                </div>

                                <form method='post' >

                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Email du patient</label>
                                        <input class="form-control" name="pat_email" type="text" id="emailaddress" required="" placeholder="Enter your doctor number">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Mot de passe</label>
                                        <input class="form-control" name="pat_pwd" type="password" required="" id="password" placeholder="Enter your password">
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" name="pat_login" type="submit"> Se Connecter </button>
                                    </div>

                                </form>

                                <!--
                                For Now Lets Disable This 
                                This feature will be implemented on later versions
                                <div class="text-center">
                                    <h5 class="mt-3 text-muted">Sign in with</h5>
                                    <ul class="social-list list-inline mt-3 mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github-circle"></i></a>
                                        </li>
                                    </ul>
                                </div> 
                                -->

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Revenir au <a href="index.php" class="text-white ml-1"><b>Log In</b></a> OU <a href="../../index.php" class="text-white ml-1"><b>Page d'accueil</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->



        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>