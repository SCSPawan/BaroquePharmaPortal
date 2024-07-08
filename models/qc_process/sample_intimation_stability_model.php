<style type="text/css">
.mt-6{margin-top: -6px !important;}
.textbox_bg {
    background-color: #efefef !important;
    pointer-events: none;
}
</style>

<!-- ----------------------- Sample Intimation Model Start --------------------------------- -->
    <div class="modal fade stability-qc-check" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Sample Intimation (Transfer Request) - Stability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form role="form" class="form-horizontal" id="OT_SampleIntimationForm" method="post">
                        <div class="row">
                            <input type="hidden" id="SIS_P_StatusChekBoxValue" name="SIS_P_StatusChekBoxValue">
                            <input type="hidden" id="SIS_P_BPLId" name="SIS_P_BPLId">
                            <input type="hidden" id="SIS_P_LocCode" name="SIS_P_LocCode">
                            <input type="hidden" id="SIS_P_WhsTotal" name="SIS_P_WhsTotal">
                            <input type="hidden" id="SIS_P_BaseType" name="SIS_P_BaseType">
                            <input type="hidden" id="SIS_P_BaseEntry" name="SIS_P_BaseEntry">
                            <input type="hidden" id="SIS_P_BaseNum" name="SIS_P_BaseNum">
                            <input type="hidden" id="SIS_P_DocDate" name="SIS_P_DocDate">
                            <input type="hidden" id="SIS_P_Quantity" name="SIS_P_Quantity">
                            <input type="hidden" id="SIS_P_AdditionalYear" name="SIS_P_AdditionalYear">
                            <input type="hidden" id="SIS_P_EndDate" name="SIS_P_EndDate">
                            <input type="hidden" id="SIS_P_PeriodType" name="SIS_P_PeriodType">
                            <input type="hidden" id="SIS_P_PeriodInMonths" name="SIS_P_PeriodInMonths">
                            <input type="hidden" id="SIS_P_PlannedQty" name="SIS_P_PlannedQty">

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                     <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="SIS_P_ReceiptNo" name="SIS_P_ReceiptNo" readonly>
                                    </div>
                                     <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="SIS_P_ReceiptEntry" name="SIS_P_ReceiptEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                    <div class="col-lg-5">
                                        <select class="form-select" id="SIS_P_DocNoName" name="SIS_P_DocNoName" onchange="selectedSeries()"></select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input class="form-control desabled" type="text" id="SIS_P_DocNo" name="SIS_P_DocNo" readonly>
                                    </div>
                                    <!-- <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="SIS_P_" name="SIS_P_" readonly style="border: 1px solid red;">
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="SIS_P_WONo" name="SIS_P_WONo" readonly>
                                    </div>
                                     <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="SIS_P_WODocEntry" name="SIS_P_WODocEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_SampleType" name="SIS_P_SampleType" readonly>
                                    </div>
                                </div>
                            </div>  
                                        
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="SIS_P_TrBy" name="SIS_P_TrBy"></select>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_ItemCode" name="SIS_P_ItemCode" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_ItemName" name="SIS_P_ItemName" readonly>
                                    </div>
                                </div>
                            </div>   

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="number" id="SIS_P_ReciptNo" name="SIS_P_ReciptNo" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stability Plan Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="number" id="SIS_P_StabilityPlanQuantity" name="SIS_P_StabilityPlanQuantity" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Whs Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_WhsCode" name="SIS_P_WhsCode" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Plan DocNum</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="SIS_P_StabilityPlanDocNum" name="SIS_P_StabilityPlanDocNum" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Plan DocEntry</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="SIS_P_StabilityPlanDocEntry" name="SIS_P_StabilityPlanDocEntry" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Unit</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_Unit" name="SIS_P_Unit" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-5 col-form-label mt-6" for="val-skill">Total No of container</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text" id="SIS_P_QtyPerContainer" name="SIS_P_QtyPerContainer" >
                                        
                                    </div>
                                    <div class="col-lg-3">
                                        <input class="form-control" type="text" id="SIS_P_TotalNoofContainer" name="SIS_P_TotalNoofContainer">
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="SIS_P_FromContainer" name="SIS_P_FromContainer">
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="SIS_P_ToContainer" name="SIS_P_ToContainer">
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_BatchNo" name="SIS_P_BatchNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_BatchQty" name="SIS_P_BatchQty" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_MfgDate" name="SIS_P_MfgDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_ExpiryDate" name="SIS_P_ExpiryDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retest Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_RetestDate" name="SIS_P_RetestDate" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-7 col-form-label mt-6" for="val-skill">Stability Trasnfer No From WO</label>
                                    <div class="col-lg-5">
                                        <input class="form-control desabled" type="text" id="SIS_P_StabilityTransferNoFromWo" name="SIS_P_StabilityTransferNoFromWo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Loading date</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="SIS_P_StabilityLoadingDate" name="SIS_P_StabilityLoadingDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-7 col-form-label mt-6" for="val-skill">Stability Trasnfer Entry From WO</label>
                                    <div class="col-lg-5">
                                        <input class="form-control desabled" type="text" id="SIS_P_StabilityTransferEntryFromWo" name="SIS_P_StabilityTransferEntryFromWo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SIS_P_Status" name="SIS_P_Status" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="SIS_P_StatusChekBox" name="SIS_P_StatusChekBox" style="pointer-events: none;">
                                            <label class="form-check-label" for="flexCheckDefault">Cancelled</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="SIS_P_TrDate" name="SIS_P_TrDate" value="<?php echo date("Y-m-d");?>" onchange="getSeriesDropdown()">
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_Branch" name="SIS_P_Branch" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_Location" name="SIS_P_Location" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-5 col-form-label mt-6" for="val-skill">Stability Type</label>
                                    <div class="col-lg-7">
                                        <input class="form-control desabled" type="text" id="SIS_P_StabilityType" name="SIS_P_StabilityType" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Condition</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="SIS_P_StabilityCondition" name="SIS_P_StabilityCondition" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Time Period</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="SIS_P_StabilityTimePeriod" name="SIS_P_StabilityTimePeriod" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Type</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIS_P_AnalysisType" name="SIS_P_AnalysisType" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="SIS_P_Container" name="SIS_P_Container">
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">MakeBy</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="SIS_P_MakeBy" name="SIS_P_MakeBy" readonly>
                                    </div>
                                </div>
                            </div> 
                                        
                            <div class="col-xl-6 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-2 col-form-label mt-6" for="val-skill">Container Nos</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" rows="3" id="SIS_P_ContainerNos" name="SIS_P_ContainerNos"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary" id="OP_SampleIntimationBtn" name="OP_SampleIntimationBtn" onclick="SendOT_SampleIntimationData()">Add</button>
                                    
                                    <button type="button" class="btn btn-danger active" data-bs-toggle="button" autocomplete="off" data-bs-dismiss="modal" aria-label="Close"  aria-pressed="true">Cancel</button>
                                 </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ----------------------- Sample Intimation Model End ----------------------------------- -->

<!-- ----------------------- Inventory Transfer Model Start --------------------------------- -->
<div class="modal fade inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form role="form" class="form-horizontal" id="SIS_IT_form" method="post">
                <div class="modal-body">

                    <input type="hidden" id="SIS_IT_BPLId" name="SIS_IT_BPLId">
                    <div class="row">

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SIS_IT_SupplierCode" name="SIS_IT_SupplierCode" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SIS_IT_SupplierName" name="SIS_IT_SupplierName" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SIS_IT_BranchName" name="SIS_IT_BranchName" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                <div class="col-lg-6">
                                    <select class="form-select" id="SIS_IT_SeriesName" name="SIS_IT_SeriesName" onchange="selectedSeries()"></select>
                                </div>

                                <div class="col-lg-2">
                                    <input class="form-control desabled" type="text" id="SIS_IT_SeriesNo" name="SIS_IT_SeriesNo" readonly="">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SIS_IT_BaseDocType" name="SIS_IT_BaseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="SIS_IT_PostingDate" name="SIS_IT_PostingDate" value="<?php echo date('Y-m-d');?>" onchange="getSeriesDropdown()">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="SIS_IT_DocumentDate" name="SIS_IT_DocumentDate" value="<?php echo date('Y-m-d');?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SIS_IT_DocEntry" name="SIS_IT_DocEntry" readonly>
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
                            <tbody>
                                <tr>
                                    <td class="desabled">1</td>
                                    <td class="desabled"><input class="border_hide textbox_bg" type="text" id="SIS_ITI_ItemCode" name="SIS_ITI_ItemCode" class="form-control"></td>
                                    <td class="desabled"><input class="border_hide textbox_bg" type="text" id="SIS_ITI_ItemName" name="SIS_ITI_ItemName" class="form-control"></td>
                                    <td class="desabled"><input class="border_hide textbox_bg" type="text" id="SIS_ITI_Quality" name="SIS_ITI_Quality" class="form-control"></td>
                                    <td class="desabled"><input class="border_hide textbox_bg" type="text" id="SIS_ITI_FromWhs" name="SIS_ITI_FromWhs" class="form-control"></td>
                                    <td class="desabled"><input class="border_hide textbox_bg" type="text" id="SIS_ITI_ToWhs" name="SIS_ITI_ToWhs" class="form-control"></td>
                                    <td class="desabled"><input class="border_hide textbox_bg" type="text" id="SIS_ITI_Location" name="SIS_ITI_Location" class="form-control"></td>
                                    <td class="desabled"><input class="border_hide textbox_bg" type="text" id="SIS_ITI_UOM" name="SIS_ITI_UOM" class="form-control"></td>
                                </tr>
                            </tbody> 
                        </table>
                    </div>
                    <!-- table end -->

                    <!-- Container table start -->
                    <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
                    <div class="table-responsive mt-2" id="list">
                        <table id="ContainerSelectionTable_IT" class="table sample-table-responsive table-bordered" style="">
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
                    <!-- Container table end -->

                   <button type="button" id="SubSIS_IT_Btn" name="SubSIS_IT_Btn" class="btn active btn-primary" data-bs-toggle="button" autocomplete="off" onclick="SubmitInventoryTransfer()">Add</button>

                   <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ----------------------- Inventory Transfer Model End ----------------------------------- -->

<!-- --------After inventory transfer--------------------- -->
<div class="modal fade after_inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="SIS_IT_View"></div>

        </div>
    </div>
</div>
<!-- --------------After inventory transfer-------------- -->

<!-- --------Sample Intimation - Stability RPT View Modal Start ------------------- -->
<div class="modal fade Sample_Inti_Stability_RPT" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="RPT_title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="View_RPT_Close()"></button>
         </div>
         
         <div class="modal-body">
            <iframe id="RPT_Link" src="" style="width: 100%;height: 88vh;"></iframe>
         </div><!--body end-->
      </div>
   </div>
</div>
<!-- --------Sample Intimation - Stability RPT View Modal Start ------------------- -->