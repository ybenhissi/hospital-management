<?php
    $pat_id = $_SESSION['pat_id'];
    $ret="SELECT * FROM  his_patients WHERE pat_id = ?";
    $stmt= $mysqli->prepare($ret) ;
    $stmt->bind_param('i',$pat_id);
    $stmt->execute() ;//ok
    $res=$stmt->get_result();
    //$cnt=1;
    while($row=$res->fetch_object())
    {
?>
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="pro-user-name ml-1">
                        <?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?> <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Bienvenue !</h6>
                    </div>


                    <a href="his_doc_modifier-compte.php" class="dropdown-item notify-item">
                        <i class="fas fa-user-tag"></i>
                        <span>Modifier compte</span>
                    </a>


                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="his_doc_logout_partial.php" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Se déconnecter</span>
                    </a>

                </div>
            </li>

           

        </ul>
    </div>
<?php }?>