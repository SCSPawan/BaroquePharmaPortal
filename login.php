<?php 
require_once './classes/function.php';
$obj= new web();

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Baroque Pharmaceuticals Pvt Ltd</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Sweet alert start -->
        <script src="assets/dist/sweetalert.js"></script>
        <link rel="stylesheet" href="assets/dist/sweetalert.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- Sweet alert end -->

        <!-- select custom script -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    </head>

    <body data-layout="horizontal" data-topbar="dark">

<!-- ---------- loader start here---------------------- -->
    <div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
        <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
            <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
        </div>
    </div>
<!-- ---------- loader end here---------------------- -->

    <div class="authentication-bg min-vh-100" style="background: url(assets/images/auth-bg.jpg) bottom;">
        <div class="bg-light"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                       <div class="text-center mb-4">
                            <a href="index.html">
                                <img src="assets/images/barque.png" alt="" height="44"> 
                            </a>
                       </div>

                        <div class="card login-back">
                            <div class="card-body p-4"> 
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to Baroque .</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="home.php">
        
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                                        </div>
                
                                        <div class="mb-3">
                                            <!-- <div class="float-end">
                                                <a href="forgot-password.php" class="text-muted">Forgot password?</a>
                                            </div> -->
                                            <label class="form-label" for="userpassword">Password</label>
                                            <input type="password" class="form-control" id="userpassword" name="userpassword" placeholder="Enter password">
                                        </div>
                
                                                                            
                                        <div class="mt-3 text-end">
                                            <button type="button" id="login_btn" name="login_btn" class="btn btn-primary w-sm waves-effect waves-light" onclick="sendlogindetails();" type="submit">Log In</button>
                                        </div>

                                    </form>
                                </div>
            
                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center text-muted p-4">
                            <p class="text-black-10"><b>Baroque Pharmaceuticals Pvt. Ltd. © <?php echo date("Y");?> 
                            <!-- Design & Develop by <a href="https://softcoresolutions.com/" target="_blank">SoftCore Solutions Pvt. Ltd.</a> -->
                            </b></p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>
    <!-- end authentication section -->

    <script type="text/javascript">
        // <!-- -------------- Direct called function diclear Start Here --------------------------------
            $(".loader123").hide(); // loader default hide script
        // <!-- -------------- Direct called function diclear End Here ----------------------------------

        function sendlogindetails(){

            var username=document.getElementById('username').value;
            var userpassword=document.getElementById('userpassword').value;

            var dataString ='username='+username+'&userpassword='+userpassword+'&action=loginform_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function(){
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result)
                {
                    // console.log(result);
                    var JSONObject = JSON.parse(result);

                    var status = JSONObject['status'];
                    var message = JSONObject['message'];
                    var DocEntry = JSONObject['DocEntry'];
                    if(status=='True'){
                        swal({
                          // title: `${DocEntry}`,
                          text: `${message}`,
                          icon: "success",
                          buttons: true,
                          dangerMode: false,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                location.replace('open_transaction_for_sample_intimation.php'); //ok btn... cuurent URL called
                            }else{
                                location.replace('open_transaction_for_sample_intimation.php'); // cancel btn... cuurent URL called
                            }
                        });
                    }else{
                        swal("Oops!", `${message}`, "error");
                    }
                },
                complete:function(data){
                    // Hide image container
                    $(".loader123").hide();
                }
            }); 
        }
    </script>
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <!-- JAVASCRIPT -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenujs/metismenujs.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/js/pages/dashboard.init.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
</html>