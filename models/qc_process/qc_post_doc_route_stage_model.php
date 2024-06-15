<style type="text/css">
    .mt-6{margin-top: -6px !important;}
    .FreightInput {width: 100px;border: transparent;}
    .FreightInput:focus {border: transparent;outline: none;}
</style>
   <!--start qc check model-->

    <div class="modal fade qc_post_doc_route_stage" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">QC Post Document  (QC Check) - Route Stage </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal" id="QcDpcumentFormRouteStage" method="post">
                        <div class="page-content">
                            <div class="container-fluid">
                                <div class="card">
                                    <div class="card-body">

                                        <input type="hidden" id="routStage_BPLId" name="routStage_BPLId">
                                        <input type="hidden" id="routStage_LocCode" name="routStage_LocCode">
                                        <input type="hidden" id="routStage_RMWQC" name="routStage_RMWQC">
                                        <input type="hidden" id="routStage_ShelfLife" name="routStage_ShelfLife">
                                        <input type="hidden" id="routStage_AssayPotencyReq" name="routStage_AssayPotencyReq">

                                        <div class="row">
                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="routStage_woto" name="routStage_woto" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="routStage_woEntry" name="routStage_woEntry" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_itemCode" name="routStage_itemCode" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_itemName" name="routStage_itemName" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_genericName" name="routStage_genericName" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_LanelCliam" name="routStage_LanelCliam" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam UOM</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_LabelCliamUOM" name="routStage_LabelCliamUOM" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Recieved Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_RecievedQty" name="routStage_RecievedQty" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_MfgBy" name="routStage_MfgBy" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="text" id="routStage_RefNo" name="routStage_RefNo">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Specification No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_SpecificationNo" name="routStage_SpecificationNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_BatchNo" name="routStage_BatchNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_BatchSize" name="routStage_BatchSize" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="routStage_MfgDate" name="routStage_MfgDate">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="routStage_ExpiryDate" name="routStage_ExpiryDate">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="routStage_WODate" name="routStage_WODate">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-8 col-form-label mt-6" for="val-skill">Sample Intimation Route Stage No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="routStage_SampleIntimationNo" name="routStage_SampleIntimationNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-8 col-form-label mt-6" for="val-skill">Sample Collection Route Stage No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="routStage_SampleCollectionNo" name="routStage_SampleCollectionNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_SampleQty" name="routStage_SampleQty" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6" style="display: none;">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_RetainQty" name="routStage_RetainQty" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-select" id="routStage_SampleType" name="routStage_SampleType"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_MaterialType" name="routStage_MaterialType" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_PackSize" name="routStage_PackSize" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">No. Container</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_NoContainer" name="routStage_NoContainer" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-select" id="routStage_DocName" name="routStage_DocName" onchange="selectedSeries()"></select>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="routStage_DocNo" name="routStage_DocNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="routStage_PostingDate" name="routStage_PostingDate" value="<?php echo date("Y-m-d") ?>" onchange="selectedSeries()">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="routStage_AnalysisDate" name="routStage_AnalysisDate" value="<?php echo date('Y-m-d')?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">QC Test type</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-select" id="routStage_QCTesttype" name="routStage_QCTesttype"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stage</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_Stage" name="routStage_Stage" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_Branch" name="routStage_Branch" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_Location" name="routStage_Location" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="routStage_ValidUpTo" name="routStage_ValidUpTo">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No.</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_ARNo" name="routStage_ARNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="routStage_GateEntryNo" name="routStage_GateEntryNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Release Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="routStage_ReleaseDate" name="routStage_ReleaseDate" value="<?php echo date("Y-m-d");?>" onchange="OnChangeReleaseDate()">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retest Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="routStage_RetestDate" name="routStage_RetestDate">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-7   col-form-label mt-6" for="val-skill">Release Material without QC</label>
                                                    <div class="col-lg-5">
                                                        <select class="form-select" id="routStage_Release" name="routStage_Release">
                                                            <option value="Yes">Yes</option>
                                                            <option value="No" Selected>No</option>
                                                        </select>
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
                                                    </li>
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
                                                        <div class="table-responsive" id="list">
                                                            <input type="hidden" id="tr-count" value="1">
                                                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
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


                                                                        <!-- <th>Sr. No</th> -->
                                                                        <!-- <th>Status</th> -->
                                                                        <!-- <th>Quantity</th> -->
                                                                        <!-- <th>IT No</th> -->
                                                                        <!-- <th>Release Date</th>
                                                                        <th>Release Time</th> -->
                                                                        <!-- <th>Done By</th> -->
                                                                        <!-- <th>Attatchment 1</th> 
                                                                        <th>Attatchment 2</th> 
                                                                        <th>Attatchment 3</th>  
                                                                        <th>Deviation Date</th>
                                                                        <th>Deviation No</th>
                                                                        <th>Deviation Reason</th> -->
                                                                        <!-- <th>Remarks</th> -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="qc-status-list-append"></tbody>
                                                            </table>
                                                        </div><!--table responsive end-->   
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
                                                                        <tbody id="qc-attach-list-append"></tbody> 
                                                                    </table>
                                                                </div><!--table responsive end-->
                                                            </div><!--col closed-->

                                                            <div class="col-md-2">
                                                                <div class="gap-2">
                                                                    <!-- Toggle States Button -->
                                                                    <label class="btn btn-primary active  mb-2">Browse <input type="file" hidden></label>
                                                                    <!-- <br>
                                                                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Display</button>
                                                                    <br>
                                                                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Delete</button> -->
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
                                                                            <input class="form-control" type="text" id="routStage_AssayPotency" name="routStage_AssayPotency" onfocusout="CalculatePotency();" value="0.000000">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">LOD/Water %</label>
                                                                        <div class="col-lg-8">
                                                                            <input class="form-control" type="text" id="routStage_LODWater" name="routStage_LODWater" onfocusout="CalculatePotency();" value="0.000000">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-7 col-form-label mt-6" for="val-skill">Assay Calculation Based On</label>
                                                                        <div class="col-lg-5">
                                                                            <select class="form-select" id="routStage_AssayCalc" name="routStage_AssayCalc"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Potency</label>
                                                                        <div class="col-lg-8">
                                                                            <input class="form-control" type="text" id="routStage_Potency" name="routStage_Potency" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Factor</label>
                                                                        <div class="col-lg-8">
                                                                            <input class="form-control" type="number" id="routStage_Factor" name="routStage_Factor">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                        <div class="col-lg-8">
                                                                            <select class="form-select" id="routStage_CheckedBy" name="routStage_CheckedBy"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                                        <div class="col-lg-4">
                                                                            <input class="form-control" type="text" id="routStage_U_PC_NoCont1" name="routStage_U_PC_NoCont1">
                                                                        </div>
                                                                         <div class="col-lg-4">
                                                                            <input class="form-control" type="text" id="routStage_U_PC_NoCont2" name="routStage_U_PC_NoCont2" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Approved By</label>
                                                                        <div class="col-lg-8">
                                                                            <select class="form-select" id="routStage_ApprovedBy" name="routStage_ApprovedBy"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                        <div class="col-lg-8">
                                                                            <select class="form-select" id="routStage_AnalysisBy" name="routStage_AnalysisBy"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-2 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                        <div class="col-lg-10">
                                                                            <textarea class="form-control" id="routStage_Remarks" name="routStage_Remarks" rows="1"></textarea>
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
                                                                        <button type="button" class="btn btn-primary" id="addQcPostDocumentSubmitQCCheckRouteStageBtn" name="addQcPostDocumentSubmitQCCheckRouteStageBtn" onclick="return add_qc_post_document();">Add</button>

                                                                        <button type="button" class="btn btn-danger active" data-bs-toggle="button" autocomplete="off" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
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
                                            </div><!-- end card-body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                </div><!--row closed-->
                            </div><!--container-fluid-->
                        </div><!--page-content-->
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

     <!--end qc check model-->

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
                 <form>
                                     <div class="row">

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
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
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!--row end-->
                    </form>
                    <!-- form end -->


                                    <!-- table start -->

                                    <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>select</th>
                                                                <th>Sr. No </th>  
                                                                <th>Item Code</th>
                                                                <th>Item Name</th>
                                                                <th>Quality</th>
                                                                <th>From Whs</th>
                                                                <th>To Whs</th>
                                                                <th>From Bin</th>
                                                                <th>To Bin</th> 
                                                                <th>Location</th>
                                                                <th>UOM</th>
                                                            </tr>
                                                        </thead>
                                                     <tbody>
                                                        <tr>
                                                             <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td>1</td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                          <tr>
                                                            <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td>1</td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                          <tr>
                                                           <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td>1</td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
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
                                                     <tbody>
                                                        <tr>
                                                            <td style="text-align: center;">
                                                                 <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td class="desabled">R00010</td>
                                                            <td class="desabled">CITARIO ITEM</td>
                                                            <td class="desabled">CENTRAL/1/20068778</td>
                                                            <td class="desabled">879999</td>
                                                            <td class="desabled">25</td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                         <tr>
                                                            <td style="text-align: center;">
                                                                 <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td class="desabled">R00010</td>
                                                            <td class="desabled">CITARIO ITEM</td>
                                                            <td class="desabled">CENTRAL/1/20068778</td>
                                                            <td class="desabled">879999</td>
                                                            <td class="desabled">25</td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                         <tr>
                                                            <td style="text-align: center;">
                                                                 <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td class="desabled">R00010</td>
                                                            <td class="desabled">CITARIO ITEM</td>
                                                            <td class="desabled">CENTRAL/1/20068778</td>
                                                            <td class="desabled">879999</td>
                                                            <td class="desabled">25</td>
                                                            <td><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                          <tr>
                                                            <td colspan="6"></td>
                                                            <td class="desabled">788</td>
                                                            <td colspan="2"></td>
                                                         </tr>
                                           
                                           
                                                         
                                                     </tbody> 
                                                   </table>
                                               </div>
                                               <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button>
                                               <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                
      </div><!--body end-->
    </div>
  </div>
</div>



    <!-- --------------inventory transfer-------------- -->



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
