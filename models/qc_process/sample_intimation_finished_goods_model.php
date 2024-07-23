 <style type="text/css">
    .mt-6{margin-top: -6px !important;}
 </style>

<!--sample intimation model-->
<div class="modal fade sample-intimation-finished-goods" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Sample Intimation - Finished Goods</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- form start -->
                    <form role="form" class="form-horizontal" id="SampleIntimationFinishedGoods_Form" method="post">
                        <input type="hidden" id="finished_good_LineNum" name="finished_good_LineNum">
                        <input type="hidden" id="finished_good_FromCont" name="finished_good_FromCont">
                        <input type="hidden" id="finished_good_RetestDate" name="finished_good_RetestDate">
                        <input type="hidden" id="finished_good_Series" name="finished_good_Series">
                        <input type="hidden" id="finished_good_Unit" name="finished_good_Unit">
                        <!-- <input type="text" id="finished_good_Location" name="finished_good_Location"> -->
                        <!-- <input type="text" id="finished_good_BatchQty" name="finished_good_BatchQty"> -->

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="finished_good_RFPNo" name="finished_good_RFPNo" readonly>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="finished_good_RFPODocEntry" name="finished_good_RFPODocEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                    <div class="col-lg-6">
                                        <select class="form-select" id="finished_good_DocName" name="finished_good_DocName" onchange="selectedSeries()"></select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="finished_good_DocNo" name="finished_good_DocNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="finished_good_WONo" name="finished_good_WONo" readonly>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="finished_good_WOEntry" name="finished_good_WOEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">BP Ref. No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_BPRefNo" name="finished_good_BPRefNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="finished_good_SampleType" name="finished_good_SampleType"></select>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="finished_good_TRBy" name="finished_good_TRBy"></select>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_ItemCode" name="finished_good_ItemCode" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_ItemName" name="finished_good_ItemName" readonly>
                                    </div>
                                </div>
                            </div>   

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_GRPOQty" name="finished_good_GRPOQty" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_SampleQty" name="finished_good_SampleQty" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_RetainQty" name="finished_good_RetainQty" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6" style="display: none;">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG By</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_MFGBy" name="finished_good_MFGBy" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Total No of container</label>
                                    <div class="col-lg-7">
                                        <input class="form-control" type="number" id="finished_good_TotalNoofcontainer" name="finished_good_TotalNoofcontainer">
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="finished_good_FromContainer" name="">
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="finished_good_ToContainer" name="finished_good_ToContainer">
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_BatchNo" name="finished_good_BatchNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_BatchQty" name="finished_good_BatchQty" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_MFGDate" name="finished_good_MFGDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_ExpiryDate" name="finished_good_ExpiryDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="finished_good_Status" name="finished_good_Status" readonly>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">Cancelled</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="finished_good_TRDate" name="finished_good_TRDate" value="<?php echo date('Y-m-d');?>" onchange="getSeriesDropdown()">
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_Branch" name="finished_good_Branch" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6" style="display: none;">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_ChallanNo" name="finished_good_ChallanNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6" style="display: none;">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_ChallanDate" name="finished_good_ChallanDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6" style="display: none;">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_GateEntryNo" name="finished_good_GateEntryNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6" style="display: none;">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_GateEntryDate" name="finished_good_GateEntryDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_Location" name="finished_good_Location" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">MakeBy</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_MakeBy" name="finished_good_MakeBy" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container UOM</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="finished_good_Container" name="finished_good_Container" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-2 col-form-label mt-6" for="val-skill">Container Nos</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control desabled" id="finished_good_ContainersNo" name="finished_good_ContainersNo" rows="4" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Toggle States Button -->
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary" id="SampleIntimationfinishedGoodBtn" name="SampleIntimationfinishedGoodBtn" onclick="SendSampleIntimationRetestQC_Data()">Add</button>

                                    <button type="button" class="btn btn-danger active" data-bs-toggle="button" data-bs-dismiss="modal" aria-label="Close"  autocomplete="off" aria-pressed="true">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- form end -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!--end sample intimation model-->

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
                    <form role="form" class="form-horizontal" id="inventory_transfer_finished_good_form" method="post">
                        <input type="hidden" id="TransferToUndertest_DocEntry" name="TransferToUndertest_DocEntry">
                        <input type="hidden" id="TransferToUndertest_BPL_Id" name="TransferToUndertest_BPL_Id">
                        <input type="hidden" id="TransferToUndertest_Series" name="TransferToUndertest_Series">
        

                        <div class="row">
                            <div class="col-xl-3 col-md-6" style="display: none;">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="TransferToUndertest_SupplierCode" name="TransferToUndertest_SupplierCode" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                    <div class="col-lg-6">
                                        <select class="form-select" id="TransferToUndertest_DocName" name="TransferToUndertest_DocName" onchange="selectedSeries()"></select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="TransferToUndertest_DocNo" name="TransferToUndertest_DocNo" readonly="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6" style="display: none;">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="TransferToUndertest_SupplierName" name="TransferToUndertest_SupplierName" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="TransferToUndertest_Branch" name="TransferToUndertest_Branch" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="TransferToUndertest_BaseDocType" name="TransferToUndertest_BaseDocType" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="TransferToUndertest_PostingDate" name="TransferToUndertest_PostingDate" value="<?php echo date('Y-m-d');?>" onchange="getSeriesDropdown()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="TransferToUndertest_DocumentDate" name="TransferToUndertest_DocumentDate" value="<?php echo date('Y-m-d');?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="TransferToUndertest_BaseDocNum" name="TransferToUndertest_BaseDocNum" readonly>
                                    </div>
                                </div>
                            </div>
                        </div><!--row end-->

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
                                    <tbody id="SampleIntimationInventoryTransferItemAppend"></tbody> 
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
                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button> -->
                        <button type="button" id="SubITFG_Btn" name="SubITFG_Btn" class="btn active btn-primary" onclick="SubmitInventoryTransfer();" autocomplete="off">Add</button>
                        <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </form>
                <!-- form end -->
            </div>
        </div>
    </div>
</div>
<!-- --------------inventory transfer-------------- -->


    <!-- --------After inventory transfer------------ -->

<div class="modal fade after_inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">After Inventory Transfer </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <!-- form start -->
                <form role="form" class="form-horizontal" id="after_inventory_transfer_finished_good_form" method="post">

                <input class="form-control desabled" type="hidden" id="after_TransferToUndertest_DocEntry" name="after_TransferToUndertest_DocEntry">
                <input class="form-control desabled" type="hidden" id="after_TransferToUndertest_BPL_Id" name="after_TransferToUndertest_BPL_Id">

                                    <div class="row">

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                                <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="after_TransferToUndertest_SupplierCode" name="after_TransferToUndertest_SupplierCode" readonly>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                                <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="after_TransferToUndertest_Series" name="after_TransferToUndertest_Series" readonly>
                                            </div>

                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="after_TransferToUndertest_SeriesName" name="after_TransferToUndertest_SeriesName" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                                <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="after_TransferToUndertest_SupplierName" name="after_TransferToUndertest_SupplierName" readonly>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="after_TransferToUndertest_Branch" name="after_TransferToUndertest_Branch" readonly>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                                <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="after_TransferToUndertest_BaseDocType" name="after_TransferToUndertest_BaseDocType" readonly>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                <div class="col-lg-8">
                                                <input class="form-control desabled" type="date" id="after_TransferToUndertest_PostingDate" name="after_TransferToUndertest_PostingDate">
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                                <div class="col-lg-8">
                                                <input class="form-control desabled" type="date" id="after_TransferToUndertest_DocumentDate" name="after_TransferToUndertest_DocumentDate">
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                                <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="after_TransferToUndertest_BaseDocNum" name="after_TransferToUndertest_BaseDocNum" readonly>
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
                                                    <tbody id="SampleIntimationInventoryTransferItemAppend_after">
                                                    <!-- tr>
                                                        <td class="desabled">1</td>
                                                        <td class="desabled">FG_DR_97</td>
                                                        <td class="desabled">FG_DR_97</td>
                                                        <td class="desabled">FG_DR_97</td>
                                                        <td class="desabled">FG_DR_97</td>
                                                        <td class="desabled">FG_DR_97</td>
                                                        <td class="desabled">FG_DR_97</td>
                                                        <td class="desabled">FG_DR_97</td>
                                                        <td class="desabled">FG_DR_97</td>
                                                        <td class="desabled">FG_DR_97</td>
                                                        </tr> -->

                                                        
                                                        
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
                                                            <!-- <th>Select</th> -->
                                                            <th>Item Code</th>
                                                            <th>Item Name</th>
                                                            <th>Container No</th>
                                                            <th>Batch</th>
                                                            <th>Batch Qty</th>
                                                            <th>Select Qty</th>
                                                            <th>Mfg Date</th> 
                                                            <th>Expiry Date</th>
                                                            <!-- <th>Item Code</th>
                                                            <th>Item Name</th>
                                                            <th>Container No</th>
                                                            <th>Batch</th>
                                                            <th>Batch Qty</th>
                                                            <th>Mfg Date</th> 
                                                            <th>Expiry Date</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ContainerSelectionItemAppend_after">
                                                    <!--  <tr>
                                                        
                                                        <td class="desabled">R00010</td>
                                                        <td class="desabled">CITARIO ITEM</td>
                                                        <td class="desabled">CENTRAL/1/20068778</td>
                                                        <td class="desabled">879999</td>
                                                        <td class="desabled">25</td>
                                                        
                                                        <td class="desabled"></td>
                                                        <td class="desabled"></td>
                                                        </tr>

                                                        <tr>
                                                        
                                                        <td class="desabled">R00010</td>
                                                        <td class="desabled">CITARIO ITEM</td>
                                                        <td class="desabled">CENTRAL/1/20068778</td>
                                                        <td class="desabled">879999</td>
                                                        <td class="desabled">25</td>
                                                        <td class="desabled"></td>
                                                        <td class="desabled"></td>
                                                        </tr>

                                                        <tr>
                                                        
                                                        <td class="desabled">R00010</td>
                                                        <td class="desabled">CITARIO ITEM</td>
                                                        <td class="desabled">CENTRAL/1/20068778</td>
                                                        <td class="desabled">879999</td>
                                                        <td class="desabled">25</td>
                                                        <td class="desabled"></td>
                                                        <td class="desabled"></td>
                                                        </tr>
                                        
                                                        -->
                                                    </tbody> 
                                                </table>
                                            </div>
                                            <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            

            </form>

            </div><!--body end-->
        </div>
    </div>
</div>


    <!-- --------------After inventory transfer-------------- -->

<!-- --------Sample Intimation - In Process RPT View Modal Start ------------------- -->
<div class="modal fade Sample_Inti_FG_RPT" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
<!-- --------Sample Intimation - In Process RPT View Modal Start ------------------- -->


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
