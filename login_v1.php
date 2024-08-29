<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="./vendors/feather/feather.css">
  <link rel="stylesheet" href="./vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="./vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="./css/vertical-layout-light/style.css">
  <!-- endinject -->
     <link rel="shortcut icon" href="include_file/ELogo.png" > 
</head>

<body>
<!--   <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 presskey">
              <div class="text-center">
                <div class="brand-logo">
                  <img src="include_file/ElevateLogo.png" alt="logo" style="width: 50%;">
                </div>
              </div>


              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3 ">
                <div class="form-group ">
                  <input type="email" class="form-control form-control-lg" placeholder="Employee Id" id="empid">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg Password" placeholder="Password" id="password">
                </div>
                <div class="mt-3">
                  <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" id="button">SIGN IN</a>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">

                                                                    
                </div>
 
              </form>
            </div>
          </div>
        </div>
      </div>
      
    </div>
     
  </div> -->
  <div class="brand-logo">
                  <!-- <img src="include_file/ElevateLogo.png" alt="logo" style="width: 10%;"> -->
 </div>

 
    <div class="box" style="margin-bottom: 10%;border-radius:29px;">

        <div class="graphic1"></div>
        <div class="graphic2"></div>
        <div class="graphic3"></div>
        <div class="graphic4"></div>

    <div class="social">
        <img src="include_file/ElevateLogo.png" alt="logo" style=" width: 60%;
    margin-bottom: 405px;
    margin-left: -3px;">
    </div>  
        
        <form action="">

            <span>
                <ion-icon name="person-outline"></ion-icon>
            <input type="email" placeholder="UserId" id="empid">
        </span>
        <span>
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" placeholder="Password" id="password">
        </span>


    </form>
        
    <button id="button">
        LOG IN
        <ion-icon name="chevron-forward-outline"></ion-icon>

    </button>
 

    </div>
 



    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <style>
      

* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body {
    width: 100%;
    min-height: 100vh;
    background-image: url();
    background: linear-gradient(-45deg, #0BC8BF, #353389);
    display: grid;
    place-items: center;
    
}
.box{
    height: 600px;
    width: 550px;
    background: #0BC8BF;
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 0 10px 2px rgb(255,255,255,0.4);
}
.graphic1{
    height: 180px;
    width: 200px;
    background: #353389;
    position: absolute;
    top: -120px;
    right: 20px;
    transform: rotate(45deg);
    border-radius: 20px;
    box-shadow: 0 0 10px 2px rgb(255,255,255,0.4);
}
.graphic2{
    height: 600px;
    width: 180px;
    background: #353389;
    position: absolute;
    top: -100px;
    right: -15%;
    transform: rotate(45deg);
    border-radius: 30px;
    box-shadow: 0 0 10px 2px rgb(255,255,255,0.4);
}
.graphic3{
    height: 300px;
    width: 250px;
    background: #353389;
    position: absolute;
    right: -30px;
    bottom: -160px;
    transform: rotate(45deg);
    border-radius: 30px;
    box-shadow: 0 0 10px 2px rgb(255,255,255,0.4);
}
.graphic4{
    height: 600px;
    width: 500px;
    position: absolute;
    background: #fff;
    transform: rotate(135deg);
    position: absolute;
    left:-300px ;
    top: -100px;
    border-radius: 100px 0 0 0;
    box-shadow: 0 0 10px 2px rgb(255,255,255,0.4);

}
form{
    position: absolute;
    width: 220px;
    top: 150px;
    left: 30px;
}
form span{
 margin-bottom: 30px;
 display: block;
 width: 100%;
 border-bottom: 2px solid grey;
}
form span input{
    border: none;
    margin-left: 10px;
    height: 1.5rem;
    
}
form span input:focus{
    outline: none;
}
form span ion-icon{
    font-size: 18px;
    color: rgb(102, 16, 214);
}

.box .social{
    position: absolute;
    bottom: 60px;
    right: 30px;
    color: #fff;
    font-family: 'nunito',sans-serif;

}
.social ion-icon{
    margin-top: 15px;
    font-size: 18px;
    margin-right: 10px;
}

.box button{
    position: absolute;
    border: 2px solid grey;
    background: #fff;
    top: 60%;
    left: 10%;
    width: 230px;
    color: rgb(109,99,190);
    font-weight: bolder;
    font-size: 1.2rem;
    border-radius: 30px;
    padding: 6px;
    box-shadow: -2px 5px 10px 2px rgb(180 , 180 , 245);
}
button ion-icon{
    font-size: 1.5rem;
    float: right;
    margin-right:20px ;
    width: 20%;
}
a{
    color: #fff;
    text-decoration: none;
}

      
    </style>
 


  
  <?php
  include 'include_file/pulg.php';
  ?>
  <!-- endinject -->
</body>
<?php $rand =rand(0000,9999)?>
<script src="login/js/login.js?<?php $rand ?>"></script>
 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</html>