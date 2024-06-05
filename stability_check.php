<?php include 'include/header.php' ?>
<?php include 'models/qc_process/stability-qc-check-model.php' ?>
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
                                    <h4 class="mb-0">Stability Check</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active"> Stability Check</li>
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
                                        <h4 class="card-title mb-0">Stability Check</h4>  
                                       
                                    </div><!-- end card header -->
                                        <div class="card-body">

                                                <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table_inline table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Item View</th>
                                                                <th>Sr.No </th>
                                                                <th>Item Code</th> 
                                                                <th>Item Name</th>
                                                                <th>Batch No</th>
                                                                <th>Batch Qty</th>
                                                                <th>Unit</th>
                                                                <th>Warehouse</th>
                                                                <th>WO Qty</th>
                                                                <th>Stability Check Date</th>
                                                                <th>Mfg Date</th>
                                                                <th>Expiry Date</th>
                                                                <th>Branch Name</th>
                                                            </tr>
                                                        </thead>
                                                     <tbody>
                                                        <tr>                                             <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">SFG001</td>
                                                            <td class="desabled">ACILIOUR OILMENT</td>
                                                            <td class="desabled">20210709</td>
                                                            <td class="desabled">30,000</td>
                                                            <td class="desabled">Kgs</td>
                                                            <td class="desabled">FG Store</td>
                                                            <td class="desabled">30,000</td>
                                                            <td class="desabled">08-10-2021</td>
                                                            <td class="desabled">08-11-2021</td>
                                                            <td class="desabled">08-11-2021</td>
                                                            <td class="desabled">ABC Company Pvt. Ltd</td>
                                                         </tr>
                                                         <tr>
                                                            <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">SFG001</td>
                                                            <td class="desabled">ACILIOUR OILMENT</td>
                                                            <td class="desabled">20210709</td>
                                                            <td class="desabled">30,000</td>
                                                            <td class="desabled">Kgs</td>
                                                            <td class="desabled">FG Store</td>
                                                            <td class="desabled">30,000</td>
                                                            <td class="desabled">08-10-2021</td>
                                                            <td class="desabled">08-11-2021</td>
                                                            <td class="desabled">08-11-2021</td>
                                                            <td class="desabled">ABC Company Pvt. Ltd</td>
                                                         </tr>
                                                          <tr>
                                                            <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">SFG001</td>
                                                            <td class="desabled">ACILIOUR OILMENT</td>
                                                            <td class="desabled">20210709</td>
                                                            <td class="desabled">30,000</td>
                                                            <td class="desabled">Kgs</td>
                                                            <td class="desabled">FG Store</td>
                                                            <td class="desabled">30,000</td>
                                                            <td class="desabled">08-10-2021</td>
                                                            <td class="desabled">08-11-2021</td>
                                                            <td class="desabled">08-11-2021</td>
                                                            <td class="desabled">ABC Company Pvt. Ltd</td>
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

                        <br>


                        <div class="row">
                            <div class="col-md-12">

                                 <div class="card">
                                <div class="card-body">
                                 <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                                <div class="col-lg-8">
                                                   <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Claim</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Received Date
                                                </label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No.</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                       <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">QC Test Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                                <div class="col-lg-8">
                                                   <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Warehouse</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Purpose</label>
                                                <div class="col-lg-8">
                                                   <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                 </div>
                               </div>
                            </div>
                                
                            </div><!--col closed-->
                        </div><!--row closed-->

                        <br>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">                                
                                    <div class="card-body">

                                         <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">

                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#general_data5" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">General Data</span>    
                                                </a>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#qc_status5" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">QC Status</span>    
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#attatchment5" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Attatchment</span>    
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="general_data5" role="tabpanel">
                                        
                                                <div class="table-responsive qc_list_table table_item_padding" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Sr. No</th>
                                                                <th>Parametre Code</th>
                                                                <th>Parametre Name </th>  
                                                                <th>Standard</th>
                                                                <th>Release</th>
                                                                <th>Parameter Data Type</th> 
                                                                <th>Descriptive Details</th> 
                                                                <th>Logical</th>
                                                                <th>Lower Min</th> 
                                                                <th>Lower Max</th> 
                                                                <th>Upper Min</th> 
                                                                <th>Upper Max</th> 
                                                                <th>Mean</th>
                                                                <th>Lower Min - Result</th>
                                                                <th>Lower Max - Result</th>
                                                                <th>Upper Min - Result</th> 
                                                                <th>Upper Max - Result</th>
                                                                <th>Mean</th> 
                                                                <th>Result Output</th>
                                                                <th>Remarks</th>
                                                                <th>QC Status by Analyst</th>
                                                                <th>Test Method</th>
                                                                <th>Material Type</th>
                                                                <th>User Text-1</th>
                                                                <th>User Text-2</th>
                                                                <th>User Text-3</th>
                                                                <th>User Text-4</th>
                                                                <th>User Text-5</th>
                                                                <th>QC Setup Result</th>
                                                                <th>UOM</th>
                                                                <th>Retest</th>
                                                                <th>Stability</th>
                                                                <th>External Sample</th>
                                                                <th>Applicable for As</th>
                                                                <th>Applicable for LOD</th>
                                                                <th>Analysis By</th>
                                                                <th>Analysis Remarks</th>
                                                                <th>Instrument Code</th> 
                                                                <th>Instrument Name</th>
                                                                <th>Start Date</th>
                                                                <th>Start Time</th>
                                                                <th>End Date</th>
                                                                <th>End Time</th> 
                                                            </tr>
                                                        </thead>
                                                     <tbody>
                                                        <tr>
                                                            <td class="desabled">1</td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                             <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                         </tr>

                                                         <tr>
                                                            <td class="desabled">1</td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                             <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                         </tr>

                                                         <tr>
                                                            <td class="desabled">1</td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                             <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                         </tr>

                                                         <tr>
                                                            <td class="desabled">1</td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                             <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                         </tr>

                                                       </tbody> 

                                                   </table>
                                               </div> 
                                            <!--end table-->

                                         </div> <!-- tab_pane samp details end -->

                                           

                                        <div class="tab-pane" id="qc_status5" role="tabpanel">

                                            <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                          <thead class="fixedHeader1">
                                                                <tr>
                                                                    <th>Sr. No</th>
                                                                    <th>Status</th>
                                                                    <th>Goods Issue</th>
                                                                    <th>Done By</th>  
                                                                    <th>Remarks</th>
                                                                </tr>
                                                            </thead>
                                                         <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr>

                                                             <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr>

                                                             <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr>

                                                             <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr>
                                                           </tbody> 

                                                       </table>
                                               </div><!--table responsive end-->

                                            </div> <!-- tab_pane qc status end -->


                                            <div class="tab-pane" id="attatchment5" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-10">
                                                     <div class="table-responsive" id="list">
                                                   <table id="tblItemRecord" class="table table-bordered" style="">
                                                          <thead class="fixedHeader1">
                                                                <tr>
                                                                    <th>Sr. No</th>
                                                                    <th>Target Path</th>
                                                                    <th>File Name</th>
                                                                    <th>Attatchment Date</th>
                                                                    <th>Free Text</th>
                                                                </tr>
                                                            </thead>
                                                         <tbody>
                                                            <tr>
                                                                <td class="desabled">
                                                                1
                                                                </td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr>

                                                             <tr>
                                                                <td class="desabled">
                                                                1
                                                                </td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr>

                                                             <tr>
                                                                <td class="desabled">
                                                                1
                                                                </td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr>

                                                           </tbody> 

                                                       </table>
                                               </div><!--table responsive end-->
                                               </div><!--col closed-->

                                                <div class="col-md-2">

                                                <div class="gap-2">
                                                 <!-- Toggle States Button -->
                                                 <label class="btn btn-primary active  mb-2">
                                                    Browse <input type="file" hidden>
                                                </label>
                                                 <br>
                                                 <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Display</button>
                                                 <br>
                                                 <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Delete</button>
                                                         
                                                </div>
                                                
                                                </div><!--col closed-->
                                            </div><!--row closed-->
                                                
                                            </div> <!-- tab_pane attatchment end -->

                                            <!-- tfoot start -->

                                            <div class="general_data_footer">
                                                <div class="row">

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                                <div class="col-lg-7">
                                                                    <input class="form-control" type="text" id="" name="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="" name="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                         <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="" name="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                <div class="col-lg-8">
                                                                    <textarea class="form-control" rows="1"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                </div>    
                                            </div>  <!--general data footer end-->
                                            
                                            <!-- -------footer button---- -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="d-flex flex-wrap gap-2">
                                                             <!-- Toggle States Button -->
                                                             <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button>

                                                             <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off">Cancel</button>

                                                             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".goods_issue">Goods Issue</button>

                                                              <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Update Result</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">         
                                                               <div class="btn-group">
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Work Sheet Print</button>
                                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"><i class="fa fa-angle-down"></i>
                                                              <span class="visually-hidden"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                                              <li><a class="dropdown-item" href="#">Approval Label Print</a></li>
                                                              <li><a class="dropdown-item" href="#">Rejected Label Print</a></li>
                                                              <li><a class="dropdown-item" href="#">On-Hold Label Print</a></li>
                                                              <li><a class="dropdown-item" href="#">Print Certificate</a></li>
                                                            </ul>
                                                                </div>
                                                         
                                                         </div>
                                                     </div>

                                                </div>
                                                    <!--row end-->

                                            <!-- ------footer button end---- -->


                                            <!-- tfood end -->

                                        
                                        </div> <!-- tab content end -->
               
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                                                        
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <br>
                
           <?php include 'include/footer.php' ?>

           