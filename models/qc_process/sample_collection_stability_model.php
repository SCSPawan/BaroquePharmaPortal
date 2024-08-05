 <style type="text/css">
.mt-6{margin-top: -6px !important;}
 </style>

<!-- Open Transaction for sample collection stability popup Start model --------------------------------------- -->
<div class="modal fade sample-collectoin-stability" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Sample Collection - Stability </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

                <form role="form" class="form-horizontal" id="OTSCSP_Form" method="post">
                    <div class="modal-body">
         
                        <div class="row">

                            <input type="hidden" id="OTSCP_BPLId" name="OTSCP_BPLId">
                            <input type="hidden" id="OTSCP_LocCode" name="OTSCP_LocCode">
                            <input type="hidden" id="OTSCP_UnderTestTransferNo" name="OTSCP_UnderTestTransferNo">
                            <input type="hidden" id="OTSCP_SampleIssue" name="OTSCP_SampleIssue">
                            <input type="hidden" id="OTSCP_QtyForLabel" name="OTSCP_QtyForLabel">
                            <input type="hidden" id="OTSCP_FromContainer" name="OTSCP_FromContainer">
                            <input type="hidden" id="OTSCP_ToContainer" name="OTSCP_ToContainer">
                            <input type="hidden" id="OTSCP_QtyPerContainer" name="OTSCP_QtyPerContainer">
                            <input type="hidden" id="OTSCP_WhsTotal" name="OTSCP_WhsTotal">
                            <input type="hidden" id="OTSCP_BaseType" name="OTSCP_BaseType">
                            <input type="hidden" id="OTSCP_BaseEntry" name="OTSCP_BaseEntry">
                            <input type="hidden" id="OTSCP_BaseNum" name="OTSCP_BaseNum">
                            <input type="hidden" id="OTSCP_Quantity" name="OTSCP_Quantity">
                            <input type="hidden" id="OTSCP_AdditionalYear" name="OTSCP_AdditionalYear">
                            <input type="hidden" id="OTSCP_EndDate" name="OTSCP_EndDate">
                            <input type="hidden" id="OTSCP_PeriodType" name="OTSCP_PeriodType">
                            <input type="hidden" id="OTSCP_RouteStageRecoProdReceiptQty" name="OTSCP_RouteStageRecoProdReceiptQty">
                            <input type="hidden" id="OTSCP_PlannedQty" name="OTSCP_PlannedQty">
                            <input type="hidden" id="OTSCP_PeriodinMonth" name="OTSCP_PeriodinMonth">

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingediant Type</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="OTSCP_IngredientsType" name="OTSCP_IngredientsType"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="OTSCP_ReceiptNo" name="OTSCP_ReceiptNo" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="OTSCP_ReceiptEntry" name="OTSCP_ReceiptEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="OTSCP_WONo" name="OTSCP_WONo" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="OTSCP_WODocEntry" name="OTSCP_WODocEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Doc No</label>
                                    <div class="col-lg-4">
                                        <select class="form-select" id="OTSCP_DocNoName" name="OTSCP_DocNoName" onchange="selectedSeries()"></select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input class="form-control desabled" type="text" id="OTSCP_DocNo" name="OTSCP_DocNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_IntimatedBy" name="OTSCP_IntimatedBy" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_IntimatedDate" name="OTSCP_IntimatedDate" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Unit</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_Unit" name="OTSCP_Unit" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                    <div class="col-lg-7">
                                        <select class="form-select" id="OTSCP_SampleCollectBy" name="OTSCP_SampleCollectBy"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_ARNo" name="OTSCP_ARNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_BatchNo" name="OTSCP_BatchNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_BatchQty" name="OTSCP_BatchQty" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-7 col-form-label mt-6" for="val-skill">Stability Transfer No From WO</label>
                                    <div class="col-lg-5">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityTransferNoFromWo" name="OTSCP_StabilityTransferNoFromWo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-7 col-form-label mt-6" for="val-skill">Stability Transfer Entry From WO</label>
                                    <div class="col-lg-5">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityTransferEntryFromWo" name="OTSCP_StabilityTransferEntryFromWo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Plan DocNum</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityPlanDocNum" name="OTSCP_StabilityPlanDocNum" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Satbility Plan DocEntry</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityPlanDocEntry" name="OTSCP_StabilityPlanDocEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Plan Loading Date</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityLoadingDate" name="OTSCP_StabilityLoadingDate" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Plan Quantity</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityPlanQuantity" name="OTSCP_StabilityPlanQuantity" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Intimation No</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityIntimationNo" name="OTSCP_StabilityIntimationNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="number" id="OTSCP_TotalNoofContainer" name="OTSCP_TotalNoofContainer">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Whs Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_WhsCode" name="OTSCP_WhsCode" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mnf Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_MfgDate" name="OTSCP_MfgDate" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_ExpiryDate" name="OTSCP_ExpiryDate" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control " type="date" id="OTSCP_DocDate" name="OTSCP_DocDate" value="<?php echo date("Y-m-d");?>" onchange="getSeriesDropdown()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_Branch" name="OTSCP_Branch" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_Location" name="OTSCP_Location" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_ItemCode" name="OTSCP_ItemCode" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_ItemName" name="OTSCP_ItemName" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stability Type</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityType" name="OTSCP_StabilityType" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Stability Condition</label>
                                    <div class="col-lg-7">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityCondition" name="OTSCP_StabilityCondition" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Time Period</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="OTSCP_StabilityTimePeriod" name="OTSCP_StabilityTimePeriod" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Type</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_AnalysisType" name="OTSCP_AnalysisType" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">MakeBy</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCP_MakeBy" name="OTSCP_MakeBy" readonly>
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
                                                <a class="nav-link active" data-bs-toggle="tab" href="#samp_details" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">Sample Collection Details</span>    
                                                </a>
                                            <li class="nav-item" disabled>
                                                <a class="nav-link" data-bs-toggle="tab" href="#home" role="tab" disabled>
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">External</span>    
                                                </a>
                                            </li>
                                            <li class="nav-item" disabled>
                                                <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab" disabled>
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Extra Issue</span>    
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->

                                        <div class="tab-content p-3 text-muted">
                                          <div class="tab-pane active" id="samp_detailss" role="tabpanel">
                                                <!-- form start -->
                                               <form>
                                                    <div class="row">

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">UnderTest Transfer No</label>
                                                                <div class="col-lg-6">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                       <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <div class="col-md-5">
                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample Issue</button>
                                                                </div>
                                                                <div class="col-lg-7 container_input">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                 </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container No</label>
                                                                <div class="col-lg-8 container_input" style="display: inline-flex;">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                 </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Qty For Label</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                       

                                                     </div>
                                                     
                                                </form>        
                                                <!-- form end -->
                                                <div class="d-flex flex-wrap gap-2">
                                                    
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample Print</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <!-- Toggle States Button -->
                            <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" id="OTSCSP_Btn" name="OTSCSP_Btn" onclick="OTSCSP_Submit();">Add</button>

                            <button type="button" data-bs-dismiss="modal" aria-label="Close"  class="btn btn-danger active" data-bs-toggle="button" autocomplete="off">Cancel</button>
                        </div>
                         
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- Open Transaction for sample collection stability popup end model --------------------------------------- -->


<!-- --------inventory transfer------------ -->
<div class="modal fade inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" id="inventoryTransferStabilityform" method="POST">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="stabl_supplier_code" name="stabl_supplier_code"  readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="stabl_supplier_name" name="stabl_supplier_name"  readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="stabl_Series" name="stabl_Series"  readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="stabl_Branch" name="stabl_Branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="stabl_BaseDocType" name="stabl_BaseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base Doc Num</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="stabl_BaseDocNum" name="stabl_BaseDocNum" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="stabl_PostingDate" name="stabl_PostingDate">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="stabl_DocumentDate" name="stabl_DocumentDate">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- table start -->
                        <div class="table-responsive" id="list">
                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
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
                                <tbody id="InventoryTransferItemAppend_stability_transfer"></tbody> 
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
                                <tbody id="InventoryTransferItemAppend_containerSelector_transfer"></tbody> 
                            </table>
                        </div>
                    <!-- table start -->

                    <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="inventoryTransferStability()">Add</button>
                    <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </form> 
            </div>
        </div>
    </div>
</div>
<!-- --------------inventory transfer-------------- -->

<!-- --------Goods Issue------------ -->
<div class="modal fade goods_issue" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Goods Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- form start -->
                <form method="post" action="#" id="stabilityForm">
                    <div class="row">
                        <input type="hidden" id="stability_BPLId" name="stability_BPLId">
                        <input type="hidden" id="stability_DocEntry" name="stability_DocEntry">

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="stability_Branch" name="stability_Branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="stability_BaseDocType" name="stability_BaseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="stability_BaseDocNum" name="stability_BaseDocNum" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                <div class="col-lg-4">
                                    <select class="form-select" type="text" id="stability_SeriesName" name="stability_SeriesName" onchange="selectedSeriesForGoodsIssue()"></select>
                                </div>
                                <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="stability_docNo" name="stability_docNo" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="stability_PostingDate" name="stability_PostingDate" value="<?php echo date('Y-m-d');?>" onchange="getSeriesDropdownForGoodsIssue()">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="stability_DocumentDate" name="stability_DocumentDate" value="<?php echo date('Y-m-d');?>">
                                </div>
                            </div>
                        </div>
                    </div><!--row end-->

                    <div class="table-responsive" id="list">
                        <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                            <thead class="fixedHeader1">
                                <tr>
                                    <th>Sr. No </th>  
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Quality</th>
                                    <th id="SI_GI_Th">From Whs</th>
                                    <th>To Whs</th>
                                    <th>Location</th>
                                    <th>UOM</th>
                                </tr>
                            </thead>
                            <tbody id="InventoryTransferItemAppend"></tbody> 
                        </table>
                    </div>
                    <!-- table end -->
                    <br>

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
                    <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer_sample_issue()">Add</button>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn active btn-danger" data-bs-toggle="button" autocomplete="off">Cancel</button>
                </form>
            </div><!--body end-->
        </div>
    </div>
</div>
<!-- --------------Goods Issue-------------- -->

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