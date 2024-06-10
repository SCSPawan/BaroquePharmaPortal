 <style type="text/css">
.mt-6{margin-top: -6px !important;}
.FreightInput {width: 100px;border: transparent;}
.FreightInput:focus {border: transparent;outline: none;}
 </style>
 <!--start qc check model-->


        <div class="modal fade retest-qc-check" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">QC Post Document-Retest QC (QC Check) </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal" id="qcPostDocumentRetestForm" method="post">
                        <div class="page-content">
                            <div class="container-fluid">
                            
                              <div class="card">

                                <div class="card-body">
                                    <div class="row">
                                        
                                        <input type="text" id="LineNum" name="LineNum">
                                        <input type="text" id="U_PC_BPLId" name="U_PC_BPLId">
                                        <input type="text" id="U_PC_LocCode" name="U_PC_LocCode">
                                        <input type="text" id="U_PC_Loc" name="U_PC_Loc">
                                        <!-- <input type="text" id="U_PC_GDEntry" name="U_PC_GDEntry"> -->
                                        <!-- <input type="text" id="U_PC_GRQty" name="U_PC_GRQty"> -->
                                        <input type="text" id="U_PC_RelDt" name="U_PC_RelDt">
                                        <input type="text" id="U_PC_RetstDt" name="U_PC_RetstDt">
                                        <input type="text" id="U_PC_RMQC" name="U_PC_RMQC" value="No">
                                        <input type="text" id="U_PC_RecQty" name="U_PC_RecQty">
                                        <input type="text" id="U_PC_SType" name="U_PC_SType">
                                        <input type="text" id="QCPD" name="QCPD" value="">
                                         <!-- <input type="hidden" id="Unit" name="Unit"> -->
                                         <!-- <input type="hidden" id="TNCont" name="TNCont"> -->
                                         <!-- <input type="hidden" id="TCont" name="TCont"> -->
                                         <input type="hidden" id="Series_value" name="Series_value">
                                         <input type="hidden" id="NextNumber" name="NextNumber">

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="GRPONo" name="GRPONo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="GRPODocEntry" name="GRPODocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SupplierCode" name="SupplierCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SupplierName" name="SupplierName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="ItemCode" name="ItemCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="ItemName" name="ItemName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="GenericName" name="GenericName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="LabelClaim" name="LabelClaim" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Claim UOM</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="LabelClaimUOM" name="LabelClaimUOM" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Recieved Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="RQty" name="RQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="MfgBy" name="MfgBy" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="BpRefNo" name="BpRefNo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="BatchNo" name="BatchNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="BatchQty" name="BatchQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="MfgDate" name="MfgDate" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Exp. Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="ExpiryDate" name="ExpiryDate" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Int. No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SampleIntimationNo" name="SampleIntimationNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Coll. No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SampleCollectionNo" name="SampleCollectionNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="number" id="SampleQty" name="SampleQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="PackSize" name="PackSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" id="SampleType" name="SampleType">
                                                        <!-- <option>Regular</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="MaterialType" name="MaterialType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Specification No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SpecfNo" name="SpecfNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc. No</label>
                                                <div class="col-lg-4">
                                                    <select class="form-select" id="DocNo" name="DocNo">
                                                        <!-- <option>Primary</option> -->
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input class="form-control desabled" type="text" id="DocNo1" name="DocNo1" readonly>
                                                </div>
                                                 <!-- <div class="col-lg-2">
                                                    <input class="form-control desabled" type="text" id="DocNo2" name="DocNo2" readonly>
                                                </div> -->
                                            </div>
                                        </div>
                                        <?php
                        // Get the current date in YYYY-MM-DD format
                        $currentDate = date('Y-m-d');

                        // echo  $currentDate;
                        ?>
                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="PostingDate" name="PostingDate" value="<?php echo $currentDate; ?>">
                                                </div>
                                            </div>
                                        </div>


                                        <?php
                        // Get the current date in YYYY-MM-DD format
                        $currentDate = date('Y-m-d');

                        // echo  $currentDate;
                        ?>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="AnalysisDate" name="AnalysisDate" value="<?php echo $currentDate; ?>" >
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">No. Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="Container" name="Container" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">QC Test Type</label>
                                                <div class="col-lg-8">
                                                     <select class="form-select" id="QCTestType" name="QCTestType">
                                                        <!-- <option>Regular</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stage</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="Stage" name="Stage">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="BranchName" name="BranchName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="ValidUpTo" name="ValidUpTo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No.</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="ARNo" name="ARNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="GateENo" name="GateENo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            <!-- Toggle States Button -->
                                            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Container Selection</button> -->
                                        </div>
                                    </div><!--row end-->
                                </div>
                                </div>
                              <br><br>


                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">                                
                                    <div class="card-body">

                                         <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">

                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#general_data" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">General Data</span>    
                                                </a>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#qc_status" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">QC Status</span>    
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#attatchment" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Attatchment</span>    
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="general_data" role="tabpanel">
                                        
                                                <div class="table-responsive qc_list_table table_item_padding" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                       <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Sr. No</th>
                                                                <th>Parameter Code</th>
                                                                <th>Parameter Name </th>  
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
                                                                <th>QC Status Result</th>
                                                                <th>UOM</th> 
                                                                <th>Retest</th> 
                                                                <th>Stability</th> 
                                                                <th>External Sample</th>
                                                                <th>Applicable For As</th>
                                                                <th>Applicable For LOD</th> 
                                                                <th>Analysis By</th>
                                                                <th>Analyst Remark</th>
                                                                <th>Instrument Code</th> 
                                                                <th>Instrument Name</th>
                                                                <th>Star Date</th>
                                                                <th>Start Time</th>
                                                                <th>End Date</th>
                                                                <th>End Time</th> 
                                                            </tr>
                                                        </thead>
                                                    <tbody id="retest-general-data-list-append">
                                                 

                                                       </tbody>  

                                                   </table>
                                               </div> 
                                            <!--end table-->

                                         </div> <!-- tab_pane samp details end -->

                                           

                                        <div class="tab-pane" id="qc_status" role="tabpanel">

                                            <div class="table-responsive" id="list">
                                                <input type="hidden" id="tr-count" value="1">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                          <thead class="fixedHeader1">
                                                                <tr>
                                                                    <th>Sr. No</th>
                                                                    <th>Status</th>
                                                                    <th>Quantity</th>
                                                                    <th>IT No</th>
                                                                    <th>Done By</th>  
                                                                    <th>Remarks</th>
                                                                </tr>
                                                            </thead>
                                                         <tbody id="retest-status-list-append">
                                                           
                                                           </tbody> 

                                                       </table>
                                               </div><!--table responsive end-->
                                                <div class="row">

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">GRPO Remaining Qty</label>
                                                                <div class="col-lg-7">
                                                                    <input class="form-control" type="text" id="" name="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <hr>        
                                                

                                            </div> <!-- tab_pane qc status end -->




                                            <div class="tab-pane" id="attatchment" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-10">
                                                     <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table table-bordered" style="">
                                                          <thead class="fixedHeader1">
                                                                <tr>
                                                                    <th>Select</th>
                                                                    <th>Status</th>
                                                                    <th>Quantity</th>
                                                                    <th>IT No</th>
                                                                    <th>Done By</th>  
                                                                    <th>Remarks</th>
                                                                </tr>
                                                            </thead>
                                                         <tbody id="retest-attach-list-append">
                                                          
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
                                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Assay Potency %</label>
                                                                <div class="col-lg-7">
                                                                    <input class="form-control" type="text" id="AssayPotency" name="AssayPotency" value="0.000000" onfocusout="CalculatePotency();">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Lod/Water%</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="LoD_Water" name="LoD_Water" value="0.000000" onfocusout="CalculatePotency();">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-7 col-form-label mt-6" for="val-skill">Assay Calculation Based On</label>
                                                                <div class="col-lg-5">
                                                                    <select class="form-select" id="assay-append" name="assay_append">
                                                                        <!-- <option>On As is Basis</option> -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Potency</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="potency" name="potency" value="0.000000" readonly="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Factor</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" id="factor" name="factor">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="qc_post_compiled_by" name="qc_post_compiled_by">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                                <div class="col-lg-4">
                                                                    <input class="form-control" type="number" id="noOfCont1" name="noOfCont1">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <input class="form-control" type="number" id="noOfCont2" name="noOfCont2">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="checked_by" name="checked_by">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="analysis_by" name="analysis_by">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                <div class="col-lg-8">
                                                                    <textarea class="form-control" rows="1" id="qc_remarks" class="qc_remarks"></textarea>
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
                                                             <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button> -->

                                                              <button type="button" class="btn btn-primary" id="addQcPostDocumentRetestBtn" name="addQcPostDocumentRetestBtn" onclick="return add_qc_post_document_retest_qc();">Add</button>

                                                             <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                                                             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" data-bs-toggle="button" autocomplete="off" onclick="TransToUnder();" disabled>Inventory Transfer</button>

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
                                                    <!--row end-->
                                            <!-- ------footer button end---- -->
                                            <!-- tfoot end -->
                                        </div> <!-- tab content end -->
               
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
    
                          </div><!-- end row-->
                    
                        </div><!--container-fluid-->
                    </div><!--page-content-->
                </form>
                </div><!--modal body end-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>

     <!--end qc check model-->


     <!-- --------inventory transfer------------ -->

<div class="modal fade inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <!-- form start -->
                    <form role="form" class="form-horizontal" id="inventory_transfer_form" method="post">
                                     <div class="row">
                                      
                                        
                                        <input class="form-control desabled" type="text" id="BranchId" name="BranchId">
                                        <input class="form-control desabled" type="text" id="_DocEntry" name="_DocEntry" >
                                        

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="it_SupplierCode" name="it_SupplierCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="it_Series" name="it_Series" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="it_SupplierName" name="it_SupplierName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="it_BranchName" name="it_BranchName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="it_BaseDocEntry" name="it_BaseDocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="it_postingDate" name="it_postingDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="it_documentDate" name="it_documentDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="it_BAseDocNum" name="it_BAseDocNum" readonly>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!--row end-->
                    
                                     <!-- form end -->


                                    <!-- table start -->

                                    <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <!-- <th>select</th> -->
                                                                <th>Sr. No </th>  
                                                                <th>Item Code</th>
                                                                <th>Item Name</th>
                                                                <th>Quality</th>
                                                                <th>From Whs</th>
                                                                <th>To Whs</th>
                                                                <!-- <th>From Bin</th> -->
                                                                <!-- <th>To Bin</th>  -->
                                                                <th>Location</th>
                                                                <th>UOM</th>
                                                            </tr>
                                                        </thead>
                                                     <tbody>
                                                        <tr>
                                                            <!--  <td style="text-align: center;">

                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td> -->
                                                            <td>1</td>
                                                            <td><input class="border_hide" type="text" id="tb_itme_code" name="tb_itme_code" class="form-control" readonly></td>
                                                            <td><input class="border_hide" type="text" id="tb_item_name" name="tb_item_name" class="form-control" readonly></td>
                                                            <td><input class="border_hide" type="text" id="tb_quality" name="tb_quality" class="form-control" readonly></td>
                                                            <td><input class="border_hide" type="text" id="from_whs" name="from_whs" class="form-control" readonly></td>
                                                            <!-- <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td> -->
                                                            <!-- <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td> -->
                                                            <td><input class="border_hide" type="text" id="to_whs" name="to_whs" class="form-control" readonly></td>
                                                            <td class="desabled"><input class="border_hide" type="text" id="tb_location" name="tb_location" class="form-control" readonly></td>
                                                            <td class="desabled"><input class="border_hide" type="text" id="tb_UOM" name="tb_UOM" class="form-control" readonly=""></td>
                                                         </tr>

                                                          

                                                         
                                                     </tbody> 
                                                   </table>
                                               </div>
                                <!-- table end -->
                                 <!-- table start -->
                   <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
                    <div class="table-responsive mt-2" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Select</th>
                                                                <th>Item Code</th>
                                                                <th>Item Name</th>
                                                                <th>Container No</th>
                                                                <th>Batch</th>
                                                                <th>Batch Qty</th>
                                                                <th>Select Qty</th>
                                                                <th>Mfg Date</th> 
                                                                <th>Expiry Date</th>
                                                            </tr>
                                                        </thead>
                                                     <tbody id="ContainerSelectionItemAppend">
                                                       

                                                     </tbody> 
                                                   </table>
                                               </div>
                                               <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button> -->

                                               <button type="button" id="SubIT_Btn" name="SubIT_Btn" class="btn active btn-primary" data-bs-toggle="button" autocomplete="off" onclick="SubmitInventoryTransfer()">Add</button>
                                               <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                 </form>
                                
      </div><!--body end-->
    </div>
  </div>
</div>



    <!-- --------------inventory transfer-------------- -->

     <style type="text/css">
    .modal-body{padding: 1 !important;}
     </style>


    
   <script type="text/javascript">
(function ($) {

  $.fn.enableCellNavigation = function () {

    var arrow = {
      left: 37,
      up: 38,
      right: 39,
      down: 40
    };

    // select all on focus
    // works for input elements, and will put focus into
    // adjacent input or textarea. once in a textarea,
    // however, it will not attempt to break out because
    // that just seems too messy imho.
    this.find('input').keydown(function (e) {

      // shortcut for key other than arrow keys
      if ($.inArray(e.which, [arrow.left, arrow.up, arrow.right, arrow.down]) < 0) {
        return;
      }

      var input = e.target;
      var td = $(e.target).closest('td');
      var moveTo = null;

      switch (e.which) {

        case arrow.left:
          {
            if (input.selectionStart == 0) {
              moveTo = td.prev('td:has(input,textarea)');
            }
            break;
          }
        case arrow.right:
          {
            if (input.selectionEnd == input.value.length) {
              moveTo = td.next('td:has(input,textarea)');
            }
            break;
          }

        case arrow.up:
        case arrow.down:
          {

            var tr = td.closest('tr');
            var pos = td[0].cellIndex;

            var moveToRow = null;
            if (e.which == arrow.down) {
              moveToRow = tr.next('tr');
            } else if (e.which == arrow.up) {
              moveToRow = tr.prev('tr');
            }

            if (moveToRow.length) {
              moveTo = $(moveToRow[0].cells[pos]);
            }

            break;
          }

      }

      if (moveTo && moveTo.length) {

        e.preventDefault();

        moveTo.find('input,textarea').each(function (i, input) {
          input.focus();
          input.select();
        });

      }

    });

  };

})(jQuery);


// use the plugin
$(function () {
  $('#list').enableCellNavigation();
});


</script>
