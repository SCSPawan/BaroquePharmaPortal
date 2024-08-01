 <style type="text/css">
.mt-6{margin-top: -6px !important;}
 </style>

<!-- --------inventory transfer------------ -->
<div class="modal fade inventory_transfer_retails_issue" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer retails issue </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form role="form" class="form-horizontal" id="inventory_transfer_form_issue_retails_inventory" method="post">
                    <input type="text" name="it_InventoryTransfer_BPLId" id="it_InventoryTransfer_BPLId" class="form-control ">
                    <input type="text" name="it_InventoryTransfer_DocEntry" id="it_InventoryTransfer_DocEntry" class="form-control ">

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-4">
                                    <input class="form-select" readonly type="number" id="iT_InventoryTransfer_DocNo" name="iT_InventoryTransfer_DocNo">
                                </div>
                                <div class="col-lg-4">
                                    <select class="form-control desabled" readonly type="text" id="iT_InventoryTransfer_DocName" name="iT_InventoryTransfer_DocName"></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="iT_InventoryTransfer_branch" name="iT_InventoryTransfer_branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="iT_InventoryTransfer_BaseDocType" name="iT_InventoryTransfer_BaseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="iT_InventoryTransfer_PostingDate" name="iT_InventoryTransfer_PostingDate">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="iT_InventoryTransfer_DocumentDate" name="iT_InventoryTransfer_DocumentDate">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="iT_InventoryTransfer_BaseDocNum" name="iT_InventoryTransfer_BaseDocNum" readonly>
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
                                <tbody id="InventoryTransferItemAppend_retails"></tbody> 
                            </table>
                        </div>
                    <!-- table end -->

                    <!-- table start -->
                        <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
                        <div class="table-responsive mt-2" id="list">
                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
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
                                <tbody id="ContainerSelectionItemAppend_retails"></tbody> 
                            </table>
                        </div>
                    <!-- table end -->

                    <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer_retails_issue()">Add</button>
                    <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </form>    
            </div>
        </div>
    </div>
</div>
<!-- --------inventory transfer end------------ -->

<!--start sample collection Finished Goods model-->
<div class="modal fade goods_issue_sample_issue" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Goods Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal" id="inventory_transfer_form_issue_sample_gI" method="post">
                    <input type="hidden" name="sample_issue_BPLId" id="sample_issue_BPLId">
                    <input type="hidden" name="sample_issue_DocEntry" id="sample_issue_DocEntry">

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="sample_issue_branch" name="sample_issue_branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="sample_issue_BaseDocType" name="sample_issue_BaseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base Doc Num</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="sample_issue_BaseDocNum" name="sample_issue_BaseDocNum" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-4">
                                    <select class="form-select" id="sample_issue_DocNo" name="sample_issue_DocNo" onchange="selectedSeries();" readonly></select>
                                </div>
                                <div class="col-lg-4">
                                    <input class="form-control desabled" readonly type="text" id="sample_issue_DocNum" name="sample_issue_DocNum"></input>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="sample_issue_PostingDate" name="sample_issue_PostingDate" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="sample_issue_DocumentDate" name="sample_issue_DocumentDate" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>
                    </div><!--row end-->

                    <!-- table start -->
                        <div class="table-responsive" id="list">
                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
                                <thead class="fixedHeader1">
                                    <tr>
                                        <th>Sr. No </th>  
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Quality</th>
                                        <th>Warehouse</th>
                                        <th id="GI_ToWhsTh">ToWhs</th>
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
                        <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
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

                    <button type="button" data-bs-dismiss="modal" aria-label="Close"  class="btn active btn-danger" data-bs-toggle="button" autocomplete="off">Cancel</button>
                </form>
            </div><!--body end-->
        </div>
    </div>
</div>

   <!-- ------------------------------------------------------------------------------------------------------------------------ -->

    <div class="modal fade sample-collection-finished-goods" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" aria-modal="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Sample Collection - Finished goods </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="OTSCP_Form" method="post">
                        <!-- --------- hidden field start ------------------------------------------------------ -->
                            <input type="hidden" name="SC_finished_good_LineNo" id="SC_finished_good_LineNo">
                            <input type="hidden" name="SC_finished_good_BPLId" id="SC_finished_good_BPLId">
                            <input type="hidden" name="SC_finished_good_LocCode" id="SC_finished_good_LocCode">
                            <input type="hidden" name="SC_finished_good_Unit" id="SC_finished_good_Unit">
                            <input type="hidden" name="SC_finished_good_UnderTransferNo" id="SC_finished_good_UnderTransferNo">
                            <input type="hidden" name="SC_finished_good_Dateofreversal" id="SC_finished_good_Dateofreversal">
                            <input type="hidden" name="SC_finished_good_RetainQty" id="SC_finished_good_RetainQty">
                            <input type="hidden" name="SC_finished_good_RetainQtyUOM" id="SC_finished_good_RetainQtyUOM">
                            <input type="hidden" name="SC_finished_good_Cont1" id="SC_finished_good_Cont1">
                            <input type="hidden" name="SC_finished_good_Cont2" id="SC_finished_good_Cont2">
                            <input type="hidden" name="SC_finished_good_Cont3" id="SC_finished_good_Cont3">
                            <input type="hidden" name="SC_finished_good_QtyforLabel" id="SC_finished_good_QtyforLabel">
                        <!-- --------- hidden field start ------------------------------------------------------ -->

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingediant Type</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="SC_IngredientsType" name="SC_IngredientsType"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="number" id="SC_finished_good_RFPNo" name="SC_finished_good_RFPNo" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="number" id="SC_finished_good_RFPODocEntry" name="SC_finished_good_RFPODocEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="number" id="SC_finished_good_WONo" name="SC_finished_good_WONo" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_WOEntry" name="SC_finished_good_WOEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                    <div class="col-lg-4">
                                        <select class="form-select" id="SC_finished_good_DocName" name="SC_finished_good_DocName" onchange="selectedSeries()"></select>
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="number" id="SC_finished_good_DocNo" name="SC_finished_good_DocNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_Location" name="SC_finished_good_Location" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_IntimatedBy" name="SC_finished_good_IntimatedBy" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="SC_finished_good_IntimatedDate" name="SC_finished_good_IntimatedDate" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="number" id="SC_finished_good_SampleQty" name="SC_finished_good_SampleQty" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_SampleQtyUOM" name="SC_finished_good_SampleQtyUOM" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                    <div class="col-lg-7">
                                        <select class="form-control"  id="SC_finished_good_SampleCollectBy" name="SC_finished_good_SampleCollectBy"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_ARNo" name="SC_finished_good_ARNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="SC_finished_good_DocDate" name="SC_finished_good_DocDate" value="<?php echo date('Y-m-d');?>" onchange="getSeriesDropdown()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_TRNo" name="SC_finished_good_TRNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_Branch" name="SC_finished_good_Branch" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_ItemCode" name="SC_finished_good_ItemCode" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_ItemName" name="SC_finished_good_ItemName" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_BatchNo" name="SC_finished_good_BatchNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SC_finished_good_BatchQty" name="SC_finished_good_BatchQty" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="SC_finished_good_NoOfContainer" name="SC_finished_good_NoOfContainer">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">MakeBy</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="SC_finished_good_MakeBy" name="SC_finished_good_MakeBy" readonly>
                                    </div>
                                </div>
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
                                                <a class="nav-link active" data-bs-toggle="tab" href="#samp_detailss" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">Sample Collection Details</span>    
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#homes" role="tab" disabled>
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">External Issue</span>    
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#profilety" role="tab" disabled>
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
                                                                <div class="col-lg-7">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Date of Reversal</label>
                                                                <div class="col-lg-8 container_input">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                 </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <div class="col-md-7">
                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Reverse Sample Issue</button>
                                                                </div>
                                                                <div class="col-lg-5 container_input">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                                <div class="col-lg-3">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <div class="col-md-4">
                                                                    <button type="button" class="pad_btn btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled style="padding: 7px 5px 7px 5px;">Retain Issue</button>
                                                                </div>
                                                                <div class="col-lg-8 container_input">
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
                                                    <!-- Toggle States Button -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample for Analysis Label</button>

                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample Label</button>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="homes" role="tabpanel">
                                                <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Sr. No</th>
                                                                <th>Supplier Code</th>
                                                                <th>Supplier Name</th>
                                                                <th>UOM </th>  
                                                                <th>Sample Date</th>
                                                                <th>Warehouse</th>
                                                                <th>Sample Quantity</th>
                                                                <th>Inventory Transfer</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control"></td>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control"></td>
                                                            </tr>

                                                            <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control"></td>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control"></td>
                                                            </tr>

                                                            <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control"></td>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control"></td>
                                                            </tr>
                                                        </tbody> 
                                                    </table>
                                                </div> 
                                                <div class="d-flex flex-wrap gap-2">
                                                    <!-- Toggle States Button -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Transfer</button>

                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Sleep</button>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="profilety" role="tabpanel">
                                                <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Sr. No</th>
                                                                <th>Sample Quantity</th>
                                                                <th>UOM</th>
                                                                <th>Warehouse</th>
                                                                <th>Sample By</th>  
                                                                <th>Issue Date</th>
                                                                <th>Post Extra Issue</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control"></td>
                                                            </tr>

                                                            <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control"></td>
                                                            </tr>

                                                            <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div> 
                                                <div class="d-flex flex-wrap gap-2">
                                                    <!-- Toggle States Button -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Post Extra Issue</button>

                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Slip</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="d-flex flex-wrap gap-2 mt-2">
                                <!-- Toggle States Button -->
                                <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" id="samplecollectFinishedGood_Btn" name="samplecollectFinishedGood_Btn" onclick="OTSCP_Submit();">Add</button>

                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger active">Cancel</button>
                            </div>
                        </div><!--row-->   
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
    <!--end sample collection model-->

<!-- --------inventory transfer------------ -->
<div class="modal fade inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form role="form" class="form-horizontal" id="inventory_transfer_form_fg_external" method="post">
                <input type="hidden" id="BPLId" name="BPLId">
                <input type="hidden" id="fg_ITRFPEntry" name="fg_ITRFPEntry">
                <input type="hidden" id="it_Linenum" name="it_Linenum">
                <input type="hidden" id="it_InventoryTransfer_external_DocEntry" name="it_InventoryTransfer_external_DocEntry">

                <div class="modal-body">
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
                                <div class="col-lg-4">
                                    <select class="form-select" type="text" id="iT_InventoryTransfer_series" name="iT_InventoryTransfer_series" onchange="selectedSeries_gd();"></select>
                                </div>

                                <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="inveTra_docNo" name="inveTra_docNo" readonly>
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
                                    <input class="form-control desabled" type="text" id="inveTra_branch" name="inveTra_branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="inveTra_doctyp" name="inveTra_doctyp" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="posting-date" name="posting-date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="docdate" name="docdate" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="inveTra_basedocnum" name="inveTra_basedocnum" readonly>
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
                                <tbody id="InventoryTransferItemAppend_external"></tbody> 
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
                                <tbody id="ContainerSelectionItemAppend_external"></tbody> 
                            </table>
                        </div>
                    <!-- table end -->

                    <button type="button" id="SubIT_Btn_fg_transfer" name="SubIT_Btn_fg_transfer" class="btn active btn-primary" onclick="SubmitInventoryTransfer_external();" autocomplete="off">Add</button>

                    <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </form>
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
                <form  role="form" class="form-horizontal" id="SubIT_Btn_post_extra_issue_fg" method="post">
                    <input type="hidden" id="fg_it_LineId" name="fg_it_LineId">
                    <input type="hidden" id="fg_it_RcDocEntry" name="fg_it_RcDocEntry">
                    <input type="hidden" id="fg_it_DocEntry" name="fg_it_DocEntry">
                    <input type="hidden" id="fg_it_BPLID" name="fg_it_BPLID">

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="invtr_Extra_branch" name="invtr_Extra_branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="invtr_Extra_doctyp" name="invtr_Extra_doctyp" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base Doc Num</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="invtr_Extra_docnum" name="invtr_Extra_docnum" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-4">
                                    <select class="form-select" type="text" id="iT_extra_series" name="iT_extra_series" onchange="selectedSeries_gd_extra();"></select>
                                </div>
                                <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="iT_extra_docNo" name="iT_extra_docNo" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill" >Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="iT_extra_posting" name="iT_extra_posting" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="iT_extra_docdate" name="iT_extra_docdate" value="<?php echo date('Y-m-d'); ?>">
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
                                <tbody id="InventoryTransferItemAppend_extra"></tbody> 
                            </table>
                        </div>
                    <!-- table end -->

                    <br>

                    <!-- table start -->
                        <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
                        <div class="table-responsive mt-2" id="list">
                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
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
                                <tbody id="ContainerSelectionItemAppend_extra"></tbody> 
                            </table>
                        </div>
                    <!-- table end -->

                    <button type="button" class="btn btn-primary" data-bs-toggle="button" id="SubIT_Btn_post_extra_issue_fg" autocomplete="off"  onclick="SubmitInventoryTransfer_extra()">Add</button>

                    <button type="button" data-bs-dismiss="modal" aria-label="Close"  class="btn active btn-danger" data-bs-toggle="button" autocomplete="off">Cancel</button>
                </form>
            </div>
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