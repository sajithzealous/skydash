<?php
session_start(); // Start the session
?>




<div class="container-scroller">

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <img width="48" height="48" src="https://img.icons8.com/fluency/48/imac-exit-1.png" alt="imac-exit-1"/>
        <a class="navbar-brand brand-logo mr-5" href="#"><img src="images/logo.svg" class="mr-2" alt="logo"/></a>
        <h3 style="color:black"><?php echo  $_SESSION['username'];?></h3>

        <a class="navbar-brand brand-logo-mini" href="#"> <img src="images/logo-mini.svg" alt="logo"/></a>
      </div>
 
          </li>
<!-- 
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="images/faces/face28.jpg" alt="profile"/>
            </a>

            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
              <a class="dropdown-item">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
          <li class="nav-item nav-settings d-none d-lg-flex">
            <a class="nav-link" href="#">
              <i class="icon-ellipsis"></i>
            </a>
          </li> -->
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>