<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/stability-qc-check-model.php' ?>

        <!-- gridjs css -->
        <link rel="stylesheet" href="assets/libs/gridjs/theme/mermaid.min.css">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    


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
                                    <h4 class="mb-0">Stability QC Check</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Stability QC Check</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                           <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header justify-content-between d-flex align-items-center">
                                        <h4 class="card-title mb-0">Open Stability QC Check</h4>  
                                       
                                    </div><!-- end card header -->
                                        <div class="card-body">

                                                <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table_inline table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Item View</th>
                                                                <th>Sr.No </th>  
                                                                <th>Document No</th>
                                                                <th>Item Code</th> 
                                                                <th>Item Name</th>
                                                                <th>Qty</th>
                                                                <th>Unit</th>
                                                                <th>Batch No</th>
                                                                <th>Manufacture Date</th>
                                                                <th>Expiry Date</th>
                                                            </tr>
                                                        </thead>
                                                     <tbody>
                                                        <tr>
                                                            <td style="width: 100px;vertical-align: middle; text-align: center;">
                                                                <a href="" class="" data-bs-toggle="modal" data-bs-target=".stability-qc-check">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">SFG001</td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled">500</td>
                                                            <td class="desabled">Kgs</td>
                                                            <td class="desabled">2021070</td>
                                                            <td class="desabled">08-10-2021</td>
                                                            <td class="desabled">08-11-2021</td>
                                                         </tr>
                                                         <tr >
                                                            <td style="width: 100px;vertical-align: middle; text-align: center;">
                                                                <a href="" class="" data-bs-toggle="modal" data-bs-target=".stability-qc-check">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">SFG001</td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled">500</td>
                                                            <td class="desabled">Kgs</td>
                                                            <td class="desabled">2021070</td>
                                                            <td class="desabled">08-10-2021</td>
                                                            <td class="desabled">08-11-2021</td>
                                                         </tr>
                                                         <tr >
                                                            <td style="width: 100px;vertical-align: middle; text-align: center;">
                                                                <a href="" class="" data-bs-toggle="modal" data-bs-target=".stability-qc-check">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">RM0001</td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled">500</td>
                                                            <td class="desabled">Kgs</td>
                                                            <td class="desabled">2021070</td>
                                                            <td class="desabled">08-10-2021</td>
                                                            <td class="desabled">08-11-2021</td>
                                                         </tr>

                                                     </tbody> 
                                                   </table>
                                               </div>                 
                                        </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
           <?php include 'include/footer.php' ?>