<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}
?>
<?php include 'include/header.php' ?>


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Welcome !</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Baroque</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card bg-primary">
                                    <div class="card-body">
                                        <div class="text-center py-3">
                                            <ul class="bg-bubbles ps-0">
                                                <li><i class="bx bx-grid-alt font-size-24"></i></li>
                                                <li><i class="bx bx-tachometer font-size-24"></i></li>
                                                <li><i class="bx bx-store font-size-24"></i></li>
                                                <li><i class="bx bx-cube font-size-24"></i></li>
                                                <li><i class="bx bx-cylinder font-size-24"></i></li>
                                                <li><i class="bx bx-command font-size-24"></i></li>
                                                <li><i class="bx bx-hourglass font-size-24"></i></li>
                                                <li><i class="bx bx-pie-chart-alt font-size-24"></i></li>
                                                <li><i class="bx bx-coffee font-size-24"></i></li>
                                                <li><i class="bx bx-polygon font-size-24"></i></li>
                                            </ul>
                                           <div class="main-wid position-relative">
                                                <h3 class="text-white">Welcome to</h3>

                                                <h3 class="text-white mb-0"> Baroque!</h3>

                                                <p class="text-white-50 px-4 mt-4">Baroque Pharmaceuticals Pvt. Ltd., is a fast growing pharmaceutical company with a strong focus on supply of excellent quality yet affordable medicines in India and across the world and is a trusted name amongst the healthcare professionals.</p>
                                                
                                               <!--  <div class="mt-4 pt-2 mb-2">
                                                    <a href="#" class="btn btn-success">View Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                </div> -->
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="avatar">
                                                    <span class="avatar-title bg-soft-primary rounded">
                                                        <i class="mdi mdi-shopping-outline text-primary font-size-24"></i>
                                                    </span>
                                                </div>
                                                <p class="text-muted mt-4 mb-0">Today Orders</p>
                                                <h4 class="mt-1 mb-0">3,89,658 <sup class="text-success fw-medium font-size-14"><i class="mdi mdi-arrow-down"></i> 10%</sup></h4>
                                                <div>
                                                    <div class="py-3 my-1">
                                                        <div id="mini-1" data-colors='["#3980c0"]'></div>
                                                    </div>
                                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Day</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Week</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Month</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Year</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="avatar">
                                                    <span class="avatar-title bg-soft-success rounded">
                                                        <i class="mdi mdi-eye-outline text-success font-size-24"></i>
                                                    </span>
                                                </div>
                                                <p class="text-muted mt-4 mb-0">Today Visitor</p>
                                                <h4 class="mt-1 mb-0">1,648,29 <sup class="text-danger fw-medium font-size-14"><i class="mdi mdi-arrow-down"></i> 19%</sup></h4>
                                                <div>
                                                    <div class="py-3 my-1">
                                                        <div id="mini-2" data-colors='["#33a186"]'></div>
                                                    </div>
                                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Day</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Week</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Month</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Year</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="avatar">
                                                    <span class="avatar-title bg-soft-primary rounded">
                                                        <i class="mdi mdi-rocket-outline text-primary font-size-24"></i>
                                                    </span>
                                                </div>
                                                <p class="text-muted mt-4 mb-0">Total Expense</p>
                                                <h4 class="mt-1 mb-0">6,48,249 <sup class="text-success fw-medium font-size-14"><i class="mdi mdi-arrow-down"></i> 22%</sup></h4>
                                                <div>
                                                    <div class="py-3 my-1">
                                                        <div id="mini-3" data-colors='["#3980c0"]'></div>
                                                    </div>
                                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Day</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Week</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Month</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Year</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="avatar">
                                                    <span class="avatar-title bg-soft-success rounded">
                                                        <i class="mdi mdi-account-multiple-outline text-success font-size-24"></i>
                                                    </span>
                                                </div>
                                                <p class="text-muted mt-4 mb-0">New Users</p>
                                                <h4 class="mt-1 mb-0">$5,265,3 <sup class="text-danger fw-medium font-size-14"><i class="mdi mdi-arrow-down"></i> 18%</sup></h4>
                                                <div>
                                                    <div class="py-3 my-1">
                                                        <div id="mini-4" data-colors='["#33a186"]'></div>
                                                    </div>
                                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Day</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Week</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Month</a></li>
                                                        <li class="list-inline-item"><a href="#" class="text-muted">Year</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center mb-3">
                                            <h5 class="card-title mb-0">Sales Statistics</h5>
                                            <div class="ms-auto">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted font-size-12">Sort By:</span> <span class="fw-medium">Weekly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                                        <a class="dropdown-item" href="#">Monthly</a>
                                                        <a class="dropdown-item" href="#">Yearly</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                       <div class="row align-items-center">
                                        <div class="col-xl-8">
                                            <div>
                                                 <div id="sales-statistics" data-colors='["#eff1f3","#eff1f3","#eff1f3","#eff1f3","#33a186","#3980c0","#eff1f3","#eff1f3","#eff1f3", "#eff1f3"]' class="apex-chart"></div>
                                            </div>
                                          </div>
                                           <div class="col-xl-4">
                                               <div class="">
                                                    <div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex">
                                                                <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                                <div class="flex-1 ms-2">
                                                                    <p class="mb-0">Product Order</p>
                                                                    <h5 class="mt-1 mb-0 font-size-16">43,541.58</h5>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <span class="badge badge-soft-primary">25.4%<i class="mdi mdi-arrow-down ms-2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 border-top pt-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex">
                                                                <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                                <div class="flex-1 ms-2">
                                                                    <p class="mb-0">Product Pending</p>
                                                                    <h5 class="mt-1 mb-0 font-size-16">17,351.12</h5>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <span class="badge badge-soft-primary">17.4%<i class="mdi mdi-arrow-down ms-2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 border-top pt-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex">
                                                                <i class="mdi mdi-circle font-size-10 mt-1 text-success"></i>
                                                                <div class="flex-1 ms-2">
                                                                    <p class="mb-0">Product Cancelled</p>
                                                                    <h5 class="mt-1 mb-0 font-size-16">32,569.74</h5>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <span class="badge badge-soft-success">16.3%<i class="mdi mdi-arrow-up ms-1"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 border-top pt-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex">
                                                                <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                                <div class="flex-1 ms-2">
                                                                    <p class="mb-0">Product Delivered</p>
                                                                    <h5 class="mt-1 mb-0 font-size-16">67,356.24</h5>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <span class="badge badge-soft-primary">65.7%<i class="mdi mdi-arrow-up ms-1"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                               </div>
                                           </div>
                                           
                                       </div>

                                    </div>
                                </div>
                            </div>

                           
                        
</div>
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <br>
                
            <?php include 'include/footer.php' ?>

               <style type="text/css">
            body[data-layout=horizontal] .page-content {
                padding: 20px 0 0 0;
                padding: 40px 0 60px 0;
            }
           </style>