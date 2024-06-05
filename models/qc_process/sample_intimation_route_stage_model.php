<style type="text/css">
.mt-6{margin-top: -6px !important;}
 </style>

<!--sample intimation route stage model-->

    <div class="modal fade sample-intimation-route-stage" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Sample Intimation (Transfer Request) - Route Stage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- form start -->

                    <form role="form" class="form-horizontal" id="SampleIntimationRouteStageForm" method="post">
                        <div class="row">

                            <!-- ---------- Hidden Field start here ------------------ -->
                                <input type="hidden" id="SIRS_DocNo" name="SIRS_DocNo">
                                <input type="hidden" id="SIRS_BPLId" name="SIRS_BPLId">
                                <input type="hidden" id="SIRS_DocNum" name="SIRS_DocNum">
                                <input type="hidden" id="SIRS_LineNum" name="SIRS_LineNum">
                                <input type="hidden" id="SIRS_LocId" name="SIRS_LocId">
                                <input type="hidden" id="SIRS_Quantity" name="SIRS_Quantity">
                                <input type="hidden" id="SIRS_ReceiptQty" name="SIRS_ReceiptQty">
                                <input type="hidden" id="SIRS_WareHouse" name="SIRS_WareHouse">
                                <input type="hidden" id="SIRS_StatusChekBox_val" name="SIRS_StatusChekBox_val">
                            <!-- ---------- Hidden Field end here -------------------- -->

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SIRS_ReceiptNo" name="SIRS_ReceiptNo" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SIRS_1" name="SIRS_1" value="" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                    <div class="col-lg-4">
                                        <select class="form-select" id="SIRS_DocNoName" name="SIRS_DocNoName" onchange="selectedSeries()"></select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="SIRS_NextNumber" name="SIRS_NextNumber" readonly>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="SIRS_2" name="SIRS_2" value="" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SIRS_WONo" name="SIRS_WONo" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SIRS_WOEntry" name="SIRS_WOEntry" value="" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Route/Stage</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_RouteStage" name="SIRS_RouteStage" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="SIRS_SampleType" name="SIRS_SampleType"></select>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="SIRS_TrBy" name="SIRS_TrBy"></select>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_ItemCode" name="SIRS_ItemCode" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_ItemName" name="SIRS_ItemName" readonly>
                                    </div>
                                </div>
                            </div>   

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_WoQty" name="SIRS_WoQty" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="number" id="SIRS_SampleQty" name="SIRS_SampleQty">
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="number" id="SIRS_RetainQty" name="SIRS_RetainQty">
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Unit</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_Unit" name="SIRS_Unit" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_BatchNo" name="SIRS_BatchNo" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_BatchQty" name="SIRS_BatchQty" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_MfgDate" name="SIRS_MfgDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_ExpiryDate" name="SIRS_ExpiryDate" readonly>
                                    </div>
                                </div>
                            </div>    

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_WoDate" name="SIRS_WoDate" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Total No Of Container</label>
                                    <div class="col-lg-7">
                                        <input class="form-control desabled" type="text" id="SIRS_TotNoCont" name="SIRS_TotNoCont" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_FromCont" name="SIRS_FromCont" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_ToCont" name="SIRS_ToCont" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SIRS_Status" name="SIRS_Status" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="SIRS_StatusChekBox" name="SIRS_StatusChekBox" style="pointer-events: none;">
                                            <label class="form-check-label" for="flexCheckDefault">Cancelled</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="SIRS_TrDate" name="SIRS_TrDate" value="<?php echo date("Y-m-d");?>" onchange="selectedSeries()">
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_Branch" name="SIRS_Branch" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_Location" name="SIRS_Location" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_Container" name="SIRS_Container" readonly>
                                    </div>
                                </div>
                            </div> 



                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_ChallanNo" name="SIRS_ChallanNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_ChallanDate" name="SIRS_ChallanDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_GateEntryNo" name="SIRS_GateEntryNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_GateEntryDate" name="SIRS_GateEntryDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <!-- <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_GateEntryDate" name="SIRS_GateEntryDate" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SIRS_GateEntryDate" name="SIRS_GateEntryDate" readonly>
                                    </div>
                                </div>
                            </div>  -->

                            <div class="col-xl-6 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-2 col-form-label mt-6" for="val-skill">Container Nos</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control desabled" id="SIRS_ContainerNos" name="SIRS_ContainerNos" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>




                
                            <!-- Toggle States Button -->
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button> -->

                                    <button type="button" class="btn btn-primary" id="SampleIntimationRouteStageBtn" name="SampleIntimationRouteStageBtn" onclick="SendSampleIntimationRouteStageData()">Add</button>

                                    <button type="button" class="btn btn-danger active" data-bs-toggle="button" autocomplete="off" data-bs-dismiss="modal" aria-label="Close"  aria-pressed="true">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- form end -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!-- </div> -->

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
    <td class="desabled"><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
    <td class="desabled"><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
    <td class="desabled"><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
    <td class="desabled"><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
    <td class="desabled"><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
    <td class="desabled"><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
    <td class="desabled"><input class="border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97"></td>
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
    <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

    </div><!--body end-->
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
                                                    <input class="form-control desabled" type="date" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="date" id="" name="" readonly>
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
                                                                <th>From Bin</th>
                                                                <th>To Bin</th> 
                                                                <th>Location</th>
                                                                <th>UOM</th>
                                                            </tr>
                                                         </thead>
                                                      <tbody>
                                                        <tr>
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
                                                         </tr>

                                                           <tr>
                                                         <td class="desabled">1</td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                          <tr>
                                                         <td class="desabled">1</td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
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
                                                                <th>Item Code</th>
                                                                <th>Item Name</th>
                                                                <th>Container No</th>
                                                                <th>Batch</th>
                                                                <th>Batch Qty</th>
                                                                <th>Mfg Date</th> 
                                                                <th>Expiry Date</th>
                                                            </tr>
                                                        </thead>
                                                     <tbody>
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

                                                         <tr>
                                                           
                                                            <td class="desabled">R00010</td>
                                                            <td class="desabled">CITARIO ITEM</td>
                                                            <td class="desabled">CENTRAL/1/20068778</td>
                                                            <td class="desabled">879999</td>
                                                            <td class="desabled">25</td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                         </tr>
                                           
                                                         
                                                     </tbody> 
                                                   </table>
                                          </div>
                                               <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">View</button> -->
                                               <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                



                </div><!--body end-->
    </div>
  </div>
</div>


    <!-- --------------After inventory transfer-------------- -->





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
