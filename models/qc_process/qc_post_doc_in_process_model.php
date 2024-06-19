 <style type="text/css">
.mt-6{margin-top: -6px !important;}
.FreightInput {width: 100px;border: transparent;}
.FreightInput:focus {border: transparent;outline: none;}
 </style>
   <!--start qc check model-->

        <div class="modal fade qc_post_doc_in_process" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">QC Post Document  (QC Check) - In Process </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal" id="qcPostDocumentForm" method="post">
                        <div class="page-content">
                            <div class="container-fluid">
                              <div class="card">
                                <div class="card-body">
                                 <div class="row">

                                    <input type="hidden" id="QC_CK_D_BPLId" name="QC_CK_D_BPLId">
                                    <input type="hidden" id="QC_CK_D_BatchQty" name="QC_CK_D_BatchQty">
                                    <input type="hidden" id="QC_CK_D_LineNum" name="QC_CK_D_LineNum">
                                    <input type="hidden" id="QC_CK_D_LocCode" name="QC_CK_D_LocCode">
                                    <input type="hidden" id="QC_CK_D_MfgDate" name="QC_CK_D_MfgDate">
                                    <input type="hidden" id="QC_CK_D_ExpiryDate" name="QC_CK_D_ExpiryDate">
                                    <input type="hidden" id="QC_CK_D_SampleIntimationNo" name="QC_CK_D_SampleIntimationNo">
                                    <input type="hidden" id="QC_CK_D_SampleCollectionNo" name="QC_CK_D_SampleCollectionNo">
                                    <input type="hidden" id="QC_CK_D_SampleQty" name="QC_CK_D_SampleQty">
                                    <input type="hidden" id="QC_CK_D_GateENo" name="QC_CK_D_GateENo">
                                    <input type="hidden" id="QC_CK_D_series" name="QC_CK_D_series">
                                    <input type="hidden" id="" name="QC_CK_D_SpecfNo">

                                    <!-- <input class="form-control desabled" type="hidden" id="QC_CK_D_RetestDate" name="QC_CK_D_RetestDate"> -->
                                    <!-- <input class="form-control desabled" type="hidden" id="QC_CK_D_Loc" name="QC_CK_D_Loc"> -->

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_ReceiptNo" name="QC_CK_D_ReceiptNo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_ReceiptDocEntry" name="QC_CK_D_ReceiptDocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_WoNo" name="QC_CK_D_WoNo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_WODocEntry" name="QC_CK_D_WODocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_ItemCode" name="QC_CK_D_ItemCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_ItemName" name="QC_CK_D_ItemName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_GenericName" name="QC_CK_D_GenericName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_LabelCliam" name="QC_CK_D_LabelCliam" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Recieved Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_RecievedQty" name="QC_CK_D_RecievedQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_MfgBy" name="QC_CK_D_MfgBy" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="QC_CK_D_RefNo" name="QC_CK_D_RefNo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_BatchNo" name="QC_CK_D_BatchNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_BatchSize" name="QC_CK_D_BatchSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_PackSize" name="QC_CK_D_PackSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" id="QC_CK_D_SampleType" name="QC_CK_D_SampleType">
                                                        <!-- <option>Regular</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_MaterialType" name="QC_CK_D_MaterialType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_Branch" name="QC_CK_D_Branch" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No.</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_ARNo" name="QC_CK_D_ARNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control " type="text" id="QC_CK_D_DocName" name="QC_CK_D_DocName" onchange="selectedSeries();"></select> 
                                                </div>

                                                <div class="col-lg-4">
                                                    <input class="form-control " type="text" id="QC_CK_D_DocNo" name="QC_CK_D_DocNo" readonly>
                                                </div>
                                            </div>
                                        </div>







                                        


                                        <div class="col-xl-3 col-md-6">
    <div class="form-group row mb-2">
        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
        <div class="col-lg-8">
            <input class="form-control" type="date" id="QC_CK_D_PostingDate" name="QC_CK_D_PostingDate" value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>
</div>


                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="QC_CK_D_AnalysisDate" name="QC_CK_D_AnalysisDate" value="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">QC Test type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control" type="text" id="QC_CK_D_QCTesttype" name="QC_CK_D_QCTesttype"></select>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="col-xl-3 col-md-6">
                                             <div class="form-group row mb-2">
                                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stage</label>
                                                 <div class="col-lg-8">


                                                     <select class="form-select" id="QC_CK_D_Stage" name="QC_CK_D_Stage">
                                                         <!-- <option>Regular</option> -->
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="QC_CK_D_Loc" name="QC_CK_D_Loc" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="QC_CK_D_MakeBy" name="QC_CK_D_MakeBy" readonly>
                                    </div>
                                </div>
                            </div>

                             <!-- <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="QC_CK_D_MaterialType" name="QC_CK_D_MaterialType" readonly>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-xl-3 col-md-6">
                                             <div class="form-group row mb-2">
                                                 <label class="col-lg-7 col-form-label mt-6" for="val-skill">Release Material Without QC</label>
                                                 <div class="col-lg-5">
                                                     <select class="form-select" id="QC_CK_D_RelMaterialWithoutQC" name="QC_CK_D_RelMaterialWithoutQC">
                                                         <option value="Yes">Yes</option>
                                                         <option value="No" Selected>No</option>
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>

                                         
                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Release Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="QC_CK_D_ReleaseDate" name="QC_CK_D_ReleaseDate" value="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="QC_CK_D_ValidUpTo" name="QC_CK_D_ValidUpTo"  value="<?php echo date('Y-m-d'); ?>" >
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="QC_CK_D_NoOfContainer" name="QC_CK_D_NoOfContainer" readonly>
                                                </div>
                                            </div>
                                        </div>

                                   </div>
                                </div>
                                </div>
                              <br>


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
                                        
                                                <div class="table-responsive qc_list_table table_item_padding" id="list2">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                        <tr>
                                                                        <th>Sr.No</th>
                                                                        <th>Parameter Code</th>
                                                                        <th>Parameter Name</th>
                                                                        <th>Specification</th>
                                                                        <th>Result OutPut</th>
                                                                        <th>Comparison Result</th>
                                                                        <th>Result Output By QC Dept.</th>
                                                                        <th>Parameter Data Type</th>
                                                                        <th>Logical</th>
                                                                        <th>Lower Min</th>
                                                                        <th>Upper Max</th>
                                                                        <th>Mean</th>
                                                                        <th>QC Status by Analyst</th>
                                                                        <th>Test Method</th>
                                                                        <th>Material Type</th>
                                                                        <th>Pharmacopoeial Standard</th>
                                                                        <th>UOM</th>
                                                                        <th>Retest</th>
                                                                        <th>External Sample</th>
                                                                        <th>Analysis By</th>
                                                                        <th>Analyst Remarks</th>
                                                                        <th>Lower Max</th>
                                                                        <th>Release</th>
                                                                        <th>Descriptive Details</th>
                                                                        <th>Upper Min</th>
                                                                        <th>Lower Min - Result</th>
                                                                        <th>Upper Min - Result</th>
                                                                        <th>Upper Max - Result</th>
                                                                        <th>Mean - Result</th>
                                                                        <th>User Text-1</th>
                                                                        <th>User Text-2</th>
                                                                        <th>User Text-3</th>
                                                                        <th>User Text-4</th>
                                                                        <th>User Text-5</th>
                                                                        <th>QC Setup Remark</th>
                                                                        <th>Stability</th>
                                                                        <th>Applicable for Assay</th>
                                                                        <th>Applicable for LOD</th>
                                                                        <th>Instrument Code</th>
                                                                        <th>Instrument Name</th>
                                                                        <th>Start Date</th>
                                                                        <th>Start Time</th>
                                                                        <th>End Date</th>
                                                                        <th>End Time</th>
                                                        </tr>
                                                        </thead>
                                                     <tbody id="qc-post-general-data-list-append"></tbody> 

                                                   </table>
                                               </div> 
                                            <!--end table-->

                                         </div> <!-- tab_pane samp details end -->

                                           

                                        <div class="tab-pane" id="qc_status" role="tabpanel">
<input type="hidden" id="tr-count" value="1">
                                            <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
                                                          <thead class="fixedHeader1">
                                                          <tr>
                                                                     <th>Sr. No</th>
                    
                                                                     <th style="width:150px;display: block;">Status</th>
                                                                     <th>Quantity</th>
                                                                     <th>Release Date</th>
                                                                     <th>Release Time</th>
                                                                     <th>IT No</th>
                                                                     <th style="width:150px;display: block;">Done By</th>
                                                                     <th>Attachment 1</th>
                                                                     <th>Attachment 2</th>
                                                                     <th>Attachment 3</th>
                                                                     <th>Deviation Date</th>
                                                                     <th>Deviation No</th>
                                                                     <th>Deviation Reason</th>
                                                                     <th>Remarks</th>

                                                                 </tr>
                                                            </thead>
                                                         <tbody id="qc-status-list-append">
                                                            <!-- <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr> -->

                                                            
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
                                                                    <th>Sr. No</th>
                                                                    <th>Target Path</th>
                                                                    <th>File Name</th>
                                                                    <th>Attatchment Date</th>
                                                                    <th>Free Text</th>
                                                                </tr>
                                                            </thead>
                                                         <tbody id="qc-attach-list-append">
                                                            <!-- <tr>
                                                                <td class="desabled">
                                                                1
                                                                </td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr> -->

                                                            

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
                                                                    <input class="form-control" type="text" id="QC_CK_D_AssayPotency" name="QC_CK_D_AssayPotency" onfocusout="CalculatePotency();" value="0.000000">
                                                                    <!-- <input class="form-control" type="text" id="QC_CK_D_AssayPotency" name="QC_CK_D_AssayPotency"> -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">LOD/Water %</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="QC_CK_D_LODWater" name="QC_CK_D_LODWater" onfocusout="CalculatePotency();" value="0.000000">
                                                                    <!-- <input class="form-control" type="text" id="QC_CK_D_LODWater" name="QC_CK_D_LODWater"> -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-7 col-form-label mt-6" for="val-skill">Assay Calculation Based On</label>
                                                                <div class="col-lg-5">

                                                                     <select class="form-select assayapp" id="QC_CK_D_Assay" name="QC_CK_D_Assay"></select>
                                                                    <!-- <select class="form-select" id="QC_CK_D_Assay" name="QC_CK_D_Assay">
                                                                        <option>On As is Basis</option>
                                                                    </select> -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Potency</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="QC_CK_D_Potency" name="QC_CK_D_Potency">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Factor</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" id="QC_CK_D_Factor" name="QC_CK_D_Factor">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control" id="QC_CK_D_CompiledBy" name="QC_CK_D_CompiledBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control" type="text" id="QC_CK_D_CheckedBy" name="QC_CK_D_CheckedBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control" type="text" id="QC_CK_D_AnalysisBy" name="QC_CK_D_AnalysisBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">No. of Container</label>
                                                                <div class="col-lg-4">
                                                                    <input class="form-control" type="text" id="QC_CK_D_FromContainer" name="QC_CK_D_FromContainer">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <input class="form-control desabled" type="text" id="QC_CK_D_ToContainer" name="QC_CK_D_ToContainer" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">Qty Per Container</label>
                                                                <div class="col-lg-6">
                                                                    <input class="form-control" type="text" id="QC_CK_D_QtyPerContainer" name="QC_CK_D_QtyPerContainer">
                                                                </div>
                                                            </div>
                                                        </div> -->

        <!-- <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" type="text" id="QC_CK_D_ToContainer" name="QC_CK_D_ToContainer" readonly>
                </div>
            </div>
        </div> -->


                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                <div class="col-lg-8">
                                                                    <textarea class="form-control" rows="1" id="QC_CK_D_Remarks" name="QC_CK_D_Remarks"></textarea>
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

                                                              <button type="button" class="btn btn-primary" id="addQcPostDocumentQCCheckBtn" name="addQcPostDocumentQCCheckBtn" onclick="return add_qc_post_document();">Add</button>

                                                             <button type="button" class="btn btn-danger active" data-bs-toggle="button" autocomplete="off" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                                                             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" data-bs-toggle="button" autocomplete="off" disabled="">Inventory Transfer</button>

                                                              <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Update Result</button> -->
                                                        </div>
                                                    </div>
                                                        <!-- <div class="col-md-6">
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
                                                     </div> -->

                                                </div>
                                                    <!--row end-->

                                            <!-- ------footer button end---- -->

                                        

                                            <!-- tfoot end -->

                                        
                                        </div> <!-- tab content end -->
               
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div><!--row closed-->
                        </div><!--container-fluid-->
                        </form>
                    </div><!--page-content-->
                </div>
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
                    <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <!-- form start -->
                 <form method="post" action="#" id="inventrotyTransferQC_ckecked">
                                     <div class="row">

                                        <input class="form-control desabled" type="hidden" id="qc_check_branchID" name="qc_check_branchID" readonly>

                                        <input class="form-control desabled" type="hidden" id="qc_check_DocEntry" name="qc_check_DocEntry" readonly>

<input type="text" id="qc_check_SeriesId" name="qc_check_SeriesId" readonly>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_check_supplier_code" name="qc_check_supplier_code" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <!-- <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_check_series" name="qc_check_series" readonly>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" type="text" id="qcD_Series" name="qcD_Series"  onchange="selectedSeriesForIT();"></select>

                                                <!-- <select class="form-select desabled" disabled>
                                                        <option>Primary</option>
                                                    </select> -->
                                            </div>
                                            <div class="col-lg-2">
                                                <input class="form-control desabled" readonly type="text" id="qc_check_seriesDocNum" name="qc_check_seriesDocNum">
                                            </div>
                                        </div>
                                    </div>



                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_check_supplier_name" name="qc_check_supplier_name" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_check_branch" name="qc_check_branch" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_check_base_docType" name="qc_check_base_docType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="qc_check_posting_date" name="qc_check_posting_date" value="<?php echo date("Y-m-d"); ?>">
                                                </div>
                                            </div>
                                        </div>


                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                                  <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="qc_check_document_date" name="qc_check_document_date" value="<?php echo date("Y-m-d"); ?>">
                                                </div>
                                            </div>
                                        </div>


                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_check_baseDocNum" name="qc_check_baseDocNum" readonly>
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
                                                              <!--   <th>select</th> -->
                                                                <th>Sr. No </th>  
                                                                <th>Item Code</th>
                                                                <th>Item Name</th>
                                                                <th>Quality</th>
                                                                <th>From Whs</th>
                                                                <th>To Whs</th>
                                                                <th>Location</th>
                                                                <th>UOM</th>
                                                            </tr>
                                                        </thead>
                                                     <tbody>
                                                        <tr>
                                                           <!--   <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td> -->
                                                            <td>1</td>
                                                            <td><input class="border_hide" type="text" id="qc_check_itemCode" name="qc_check_itemCode" class="form-control"></td>

                                                            <td><input class="border_hide" type="text" id="qc_check_ItemName" name="qc_check_ItemName" class="form-control"></td>

                                                            <td><input class="border_hide" type="text" id="qc_check_Quality" name="qc_check_Quality" class="form-control"></td>

                                                            <td><input class="border_hide" type="text" id="qc_check_FromWhs" name="qc_check_FromWhs" class="form-control"></td>
                                                            
                                                            <td><input class="border_hide" type="text" id="qc_check_ToWhs" name="qc_check_ToWhs" class="form-control"></td>
                                                            
                                                            <td class="desabled">
                                                                <input class="border_hide" type="text" id="qc_check_Location" name="qc_check_Location" class="form-control">
                                                            </td>
                                                            <td class="desabled">
                                                                <input class="border_hide" type="text" id="qc_check_UOM" name="qc_check_UOM" class="form-control">
                                                            </td>
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
                                                     <tbody id="ContainerSelectionItemAppend"></tbody> 
                                                   </table>
                                               </div>
                                               <button type="button" class="btn btn-primary" data-bs-toggle="button"  onclick="SubmitInventoryTransferQC_ckeck();">Add</button>
                                               <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                          </form>       
      </div><!--body end-->
    </div>
  </div>
</div>



    <!-- --------------inventory transfer-------------- -->

    
<!-- --------RPT Pint View modal start ------------------- -->
<div class="modal fade QC_PostDocRSPrintLayout" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title text-danger" id="RPT_title"></h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="ViewRPT_Print_Close()"></button>
            </div>
            
            <div class="modal-body">
               <iframe id="PrintQuarantine_Link" src="" style="width: 100%;height: 88vh;"></iframe>
            </div><!--body end-->
         </div>
      </div>
   </div>
<!-- --------RPT Pint View modal end --------------------- -->
 <!-- ---------instrument modal------------- -->
 <div class="modal fade instrument_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Instrument List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive table_item_padding" id="append_instrument_table"></div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!-- ---------instrument modal end------------- -->  
                 <!-- ---------instrument modal------------- -->
        <div class="modal fade instrument_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Instrument List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive table_item_padding" id="append_instrument_table"></div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!-- ---------instrument modal end------------- -->  
                














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
