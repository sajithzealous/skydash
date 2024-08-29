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

 <div class="my-gradient-background">

 <div class="login" action=""style="width:400px;height:500px">
 <img src="include_file/ElevateLogo.png" class="imgdata"alt="logo">
  <input type="text" placeholder="Username" id="empid" style="margin-top:50px">
  <input type="password" placeholder="Password" id="password">
  <center>
 
<br>
<button class="a" id="button" style="margin-left: -266px;">
    Login
    <div class="liquid"></div>
</button>

 
<style >


body {
    margin: 0;
    height: 100vh;
    display: grid;
    place-items: center;
   background: linear-gradient(-45deg, rgba(11, 200, 191, 1), rgba(53, 51, 137, 1));
}

.a {
    font: 700 16px consolas; /* Font size */
    color: #ffff;
    text-decoration: none;
    text-transform: uppercase;
    padding: 10px 30px; /* Padding */
    position: relative;
    overflow: hidden;
    border-radius: 5px;
    border: none; /* Remove button border */
    cursor: pointer; /* Change cursor to pointer */
    transition: 0.2s;
    transform: scale(1); /* Scale */
    z-index: 0;
    background: transparent; /* Set background to transparent */
}

.a .liquid {
    position: absolute;
    top: -60px;
    left: 0;
    width: 100%;
    height: 200px;
    background: #7293ff;
    box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.7);
    z-index: -1;
    transition: 0.6s;
}

.a .liquid::after,
.a .liquid::before {
    position: absolute;
    content: "";
    width: 200%;
    height: 200%;
    top: 0;
    left: 0;
    transform: translate(-25%, -75%);
}

.a .liquid::after {
    border-radius: 45%;
    background: rgba(20, 20, 20, 1);
    box-shadow: 0 0 10px 5px #7293ff, inset 0 0 5px #7293ff;
    animation: animate 5s linear infinite;
    opacity: 0.8;
}

.a .liquid::before {
    border-radius: 40%;
    box-shadow: 0 0 10px rgba(26, 26, 26, 0.5),
        inset 0 0 5px rgba(26, 26, 26, 0.5);
    background: rgba(26, 26, 26, 0.5);
    animation: animate 7s linear infinite;
}

@keyframes animate {
    0% {
        transform: translate(-25%, -75%) rotate(0);
    }
    100% {
        transform: translate(-25%, -75%) rotate(360deg);
    }
}

.a:hover .liquid {
    top: -120px;
}

.a:hover {
    box-shadow: 0 0 5px #7293ff, inset 0 0 5px #7293ff;
    transition-delay: 0.2s;
}


</style>
</center>

</div>
</div>

  <style>

 



.imgdata{

  width:250px;
  height:100px;


}

.login {
  overflow: hidden;
  background-color: white;
  padding: 30px 30px 30px 30px;
  border-radius: 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  width: 400px;
  transform: translate(-50%, -50%);
  transition: transform 300ms, box-shadow 300ms;
  box-shadow: 5px 10px 10px rgba(2, 128, 144, 0.2);

}

.login::before, .login::after {
  content: '';
  position: absolute;
  width: 1200px;
  height: 1200px;
  border-top-left-radius: 40%;
  border-top-right-radius: 45%;
  border-bottom-left-radius: 35%;
  border-bottom-right-radius: 40%;
  z-index: -1;
}

.login::before {
  left: 40%;
  bottom: -130%;
  background-color: #0BC8BF;
  animation: wawes 6s infinite linear;
}

.login::after {
  left: 45%;
  bottom: -125%;
  background-color: #353389;
  animation: wawes 7s infinite;
}

.login input {
  font-family: 'Asap', sans-serif;
  display: block;
  border-radius: 5px;
  font-size: 16px;
  background: white;
  width: 100%;
  border-bottom: 1px solid;
  padding: 10px 10px;
  margin: 15px -10px;
}

button {
  display: flex;
  align-items: center;
  font-family: inherit;
  cursor: pointer;
  font-weight: 500;
  font-size: 17px;
  padding: 0.8em 1.3em 0.8em 0.9em;
  color: white;
  background: #ad5389;
  background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
  border: none;
  letter-spacing: 0.05em;
  border-radius: 16px;
}

button svg {
  margin-right: 3px;
  transform: rotate(30deg);
  transition: transform 0.5s cubic-bezier(0.76, 0, 0.24, 1);
}

button span {
  transition: transform 0.5s cubic-bezier(0.76, 0, 0.24, 1);
}

button:hover svg {
  transform: translateX(5px) rotate(90deg);
}

button:hover span {
  transform: translateX(7px);
}


@keyframes wawes {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

a {
  text-decoration: none;
  color: rgba(255, 255, 255, 0.6);
  position: absolute;
  right: 10px;
  bottom: 10px;
  font-size: 12px;
}

  </style> 

  
  <?php
  include 'include_file/pulg.php';
  ?>
  <!-- endinject -->
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php $rand =rand(0000,9999)?>
 <script src="login/js/login.js?<?php echo $rand ?>"></script> 

 


</html>