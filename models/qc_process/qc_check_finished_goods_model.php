<style type="text/css">
    .mt-6{margin-top: -6px !important;}
    .FreightInput {width: 100px;border: transparent;}
    .FreightInput:focus {border: transparent;outline: none;}
</style>
<!--start qc check model-->

<div class="modal fade qc-check-finished-goods" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">QC Post Document  (QC Check) - Finished Goods11</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal" id="OTFQCCFG_FORM" method="post">
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-6">
                                            <input type="hidden" id="OTFQCCFG_BPLId" name="OTFQCCFG_BPLId">
                                            <input type="hidden" id="OTFQCCFG_BpRefNo" name="OTFQCCFG_BpRefNo">
                                            <input type="hidden" id="OTFQCCFG_FrgnName" name="OTFQCCFG_FrgnName">
                                            <input type="hidden" id="OTFQCCFG_GEDate" name="OTFQCCFG_GEDate">
                                            <input type="hidden" id="OTFQCCFG_GateENo" name="OTFQCCFG_GateENo">
                                            <input type="hidden" id="OTFQCCFG_LabelClaimUOM" name="OTFQCCFG_LabelClaimUOM">
                                            <input type="hidden" id="OTFQCCFG_LineNum" name="OTFQCCFG_LineNum">
                                            <input type="hidden" id="OTFQCCFG_LocCode" name="OTFQCCFG_LocCode">
                                            <input type="hidden" id="OTFQCCFG_Qty" name="OTFQCCFG_Qty">
                                            <input type="hidden" id="OTFQCCFG_RetestDate" name="OTFQCCFG_RetestDate">
                                            <input type="hidden" id="OTFQCCFG_SpecfNo" name="OTFQCCFG_SpecfNo">
                                            <input type="hidden" id="OTFQCCFG_SrNo" name="OTFQCCFG_SrNo">
                                            <input type="hidden" id="OTFQCCFG_SupplierCode" name="OTFQCCFG_SupplierCode">
                                            <input type="hidden" id="OTFQCCFG_SupplierName" name="OTFQCCFG_SupplierName">
                                            <input type="hidden" id="OTFQCCFG_Unit" name="OTFQCCFG_Unit">
                                            <input type="hidden" id="OTFQCCFG_WOQty" name="OTFQCCFG_WOQty">
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_RFPNo" name="OTFQCCFG_RFPNo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_RFPDocEntry" name="OTFQCCFG_RFPDocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_WONo" name="OTFQCCFG_WONo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_WODocEntry" name="OTFQCCFG_WODocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_ItemCode" name="OTFQCCFG_ItemCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_ItemName" name="OTFQCCFG_ItemName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_GenericName" name="OTFQCCFG_GenericName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_LabelClaim" name="OTFQCCFG_LabelClaim" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Recieved Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_RecievedQty" name="OTFQCCFG_RecievedQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_MfgBy" name="OTFQCCFG_MfgBy" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="OTFQCCFG_RefNo" name="OTFQCCFG_RefNo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_BatchNo" name="OTFQCCFG_BatchNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_BatchSize" name="OTFQCCFG_BatchSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_PackSize" name="OTFQCCFG_PackSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="OTFQCCFG_MfgDate" name="OTFQCCFG_MfgDate">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="OTFQCCFG_ExpiryDate" name="OTFQCCFG_ExpiryDate">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" id="OTFQCCFG_SampleType" name="OTFQCCFG_SampleType"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Intimation No</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_SampleIntimationNo" name="OTFQCCFG_SampleIntimationNo" readonly="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Collection No</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_SampleCollectionNo" name="OTFQCCFG_SampleCollectionNo" readonly="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_SampleQty" name="OTFQCCFG_SampleQty" readonly="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_MaterialType" name="OTFQCCFG_MaterialType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_BranchName" name="OTFQCCFG_BranchName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No.</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_ARNo" name="OTFQCCFG_ARNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                <div class="col-lg-5">
                                                    <select class="form-select" id="OTFQCCFG_DocName" name="OTFQCCFG_DocName" onchange="selectedSeries()"></select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_DocNo" name="OTFQCCFG_DocNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="OTFQCCFG_PostingDate" name="OTFQCCFG_PostingDate" value="<?php echo date("Y-m-d"); ?>" onchange="getSeriesDropdown();">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="OTFQCCFG_AnalysisDate" name="OTFQCCFG_AnalysisDate" value="<?php echo date("Y-m-d"); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">QC Test type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" type="text" id="OTFQCCFG_QcTestType" name="OTFQCCFG_QcTestType"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stage</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" type="text" id="OTFQCCFG_Stage" name="OTFQCCFG_Stage"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_Location" name="OTFQCCFG_Location" readonly="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_MakeBy" name="OTFQCCFG_MakeBy" readonly="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-7 col-form-label mt-6" for="val-skill">Release Material Without QC</label>
                                                <div class="col-lg-5">
                                                    <select class="form-select" id="OTFQCCFG_RelMaterialWithoutQC" name="OTFQCCFG_RelMaterialWithoutQC">
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Release Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="OTFQCCFG_ReleaseDate" name="OTFQCCFG_ReleaseDate" value="<?php echo date('Y-m-d');?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="OTFQCCFG_ValidUpTo" name="OTFQCCFG_ValidUpTo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_NoOfContainer" name="OTFQCCFG_NoOfContainer" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">                                
                                        <div class="card-body">
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

                                            <div class="tab-content p-3 text-muted">
                                                <div class="tab-pane active" id="general_data" role="tabpanel">
                                                    <div class="table-responsive qc_list_table table_item_padding" id="list2">
                                                        <table id="tblQCCFG_GD" class="table sample-table-responsive table-bordered">
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
                                                            <tbody id="Qc_Post_FG_GD_list_append"></tbody> 
                                                        </table>
                                                    </div> 
                                                </div>

                                                <div class="tab-pane" id="qc_status" role="tabpanel">
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
                                                            <tbody id="qc-status-list-append"></tbody>
                                                        </table>
                                                    </div>
                                                    <hr>       
                                                </div>

                                                <div class="tab-pane" id="attatchment" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="table-responsive" id="list">
                                                                <table id="tblItemRecord" class="table table-bordered">
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
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="gap-2">
                                                                <label class="btn btn-primary active mb-2">Browse <input type="file" hidden></label>
                                                                <br>
                                                                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Display</button>
                                                                <br>
                                                                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="general_data_footer">
                                                    <div class="row">
                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Assay Potency %</label>
                                                                <div class="col-lg-7">
                                                                    <input class="form-control" type="number" id="AssayPotency" name="AssayPotency" value="0.000000" onfocusout="CalculatePotency()">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">LOD/Water %</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" id="LoD_Water" name="LoD_Water" value="0.000000" onfocusout="CalculatePotency()">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-7 col-form-label mt-6" for="val-skill">Assay Calculation Based On</label>
                                                                <div class="col-lg-5">
                                                                    <select class="form-select" id="assay_CalBasedOn" name="assay_CalBasedOn"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Potency</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control desabled" type="text" id="Potency" name="Potency" value="0.000000" readonly="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Factor</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="OTFQCCFG_Factor" name="OTFQCCFG_Factor">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-select" type="text" id="OTFQCCFG_ComplitedBy" name="OTFQCCFG_ComplitedBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-select" type="text" id="OTFQCCFG_CheckedBy" name="OTFQCCFG_CheckedBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-select" type="text" id="OTFQCCFG_AnalysisBy" name="OTFQCCFG_AnalysisBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">No. of Container</label>
                                                                <div class="col-lg-4">
                                                                    <input class="form-control" type="text" id="OTFQCCFG_FCont" name="OTFQCCFG_FCont">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <input class="form-control desabled" type="text" id="OTFQCCFG_TCont" name="OTFQCCFG_TCont" readonly="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-2 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                <div class="col-lg-10">
                                                                    <textarea class="form-control" rows="1" id="OTFQCCFG_Remark" name="OTFQCCFG_Remark"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <button type="button" class="btn btn-primary" id="OTFQCCFG_Btn" name="OTFQCCFG_Btn" onclick="return AddOTFQCCFG_Fun();">Add</button>

                                                            <button type="button" class="btn btn-danger active" data-bs-dismiss="modal" aria-label="Close"  data-bs-toggle="button" autocomplete="off">Cancel</button>

                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" data-bs-toggle="button" autocomplete="off" disabled>Inventory Transfer</button>
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
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</div>
<!--end qc check model-->

<!-- ---------instrument modal------------- -->
    <div class="modal fade instrument_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-bs-backdrop="static">
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
                <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer  (QC Check) - Finished Goods</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="post" action="#" id="inventrotyTransferQC_ckecked">
                    <div class="row">
                        <input type="hidden" id="IT_QC_BranchId" name="IT_QC_BranchId">
                        <input type="hidden" id="QCPD_QCS_LineId" name="QCPD_QCS_LineId">

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IT_QC_supplierCode" name="IT_QC_supplierCode" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-4">
                                    <select class="form-select" type="text"id="IT_QC_Series" name="IT_QC_Series" onchange="selectedSeriesForIT()"></select>
                                </div>
                                <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="IT_QC_Series_DocNo" name="IT_QC_Series_DocNo" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IT_QC_SupplierName" name="IT_QC_SupplierName" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IT_QC_Branch" name="IT_QC_Branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IT_QC_BaseDocType" name="IT_QC_BaseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <?php
                            $currentDate = date('Y-m-d'); // Get the current date in YYYY-MM-DD format
                        ?>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="IT_QC_PostingDate" name="IT_QC_PostingDate" value="<?php echo $currentDate; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="IT_QC_DocumentDate" name="IT_QC_DocumentDate" value="<?php echo $currentDate; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IT_QC_BaseDocNum" name="IT_QC_BaseDocNum" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- table start -->
                        <div class="table-responsive" id="list">
                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
                                <thead class="fixedHeader1">
                                    <tr>
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
                                <tbody id="qc-post-data-list-append"></tbody> 
                            </table>
                        </div>
                    <!-- table end -->

                    <!-- table start -->
                        <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
                        <div class="table-responsive mt-2" id="list">
                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
                                <thead class="fixedHeader1">
                                    <tr>
                                        <th><input class="form-check-input itp_checkboxall" type="checkbox" onclick="AllCheckCheckbox()" style="width: 17px;height: 17px;"></th>
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
                    <!-- table end -->

                    <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransferQC_ckeck();">Add</button>

                    <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </form>      
            </div>
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
