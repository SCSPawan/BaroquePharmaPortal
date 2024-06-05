 <style type="text/css">
.mt-6{margin-top: -6px !important;}
 </style>

    <!--start sample collection in process model-->

    <div class="modal fade sample-collection-route-stage" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Sample Collection - Route/Stage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form role="form" class="form-horizontal" id="OTSCRSP_Form" method="post">
                    <div class="modal-body">
         
                        <div class="row">

                            <input type="hidden" id="OTSCRSP_NextNumber" name="OTSCRSP_NextNumber">
                            <input type="hidden" id="OTSCRSP_BPLId" name="OTSCRSP_BPLId">
                            <input type="hidden" id="OTSCRSP_LineNo" name="OTSCRSP_LineNo">
                            <input type="hidden" id="OTSCRSP_LocCode" name="OTSCRSP_LocCode">
                            <input type="hidden" id="OTSCRSP_SampleIntimationNo" name="OTSCRSP_SampleIntimationNo">
                            <input type="hidden" id="OTSCRSP_WareHouse" name="OTSCRSP_WareHouse">

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingediant Type</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="OTSCRSP_IngredientsType" name="OTSCRSP_IngredientsType"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_WONo" name="OTSCRSP_WONo" readonly>
                                    </div>
                                     <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_WOEntry" name="OTSCRSP_WOEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                    <div class="col-lg-4">
                                        <select class="form-select" id="OTSCRSP_DocNoName" name="OTSCRSP_DocNoName" onclick="selectedSeries()"></select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_DocNo" name="OTSCRSP_DocNo" readonly>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_DocNum" name="OTSCRSP_DocNum" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Route/Stage</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_StageName" name="OTSCRSP_StageName" readonly>
                                    </div>
                                </div>
                            </div>
                                                
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_IntimatedBy" name="OTSCRSP_IntimatedBy" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_IntimatedDate" name="OTSCRSP_IntimatedDate" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                                    <div class="col-lg-6">
                                        <input class="form-control" type="text" id="OTSCRSP_SampleQty" name="OTSCRSP_SampleQty">
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_SampleQtyUOM" name="OTSCRSP_SampleQtyUOM" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                    <div class="col-lg-7">
                                        <select class="form-select" id="OTSCRSP_SampleCollectBy" name="OTSCRSP_SampleCollectBy"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_ARNo" name="OTSCRSP_ARNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="OTSCRSP_DocDate" name="OTSCRSP_DocDate" value="<?php echo date('Y-m-d'); ?>" onclick="selectedSeries()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_TRNo" name="OTSCRSP_TRNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_Branch" name="OTSCRSP_Branch" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_Loaction" name="OTSCRSP_Loaction" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_ItemCode" name="OTSCRSP_ItemCode" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_ItemName" name="OTSCRSP_ItemName" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_BatchNum" name="OTSCRSP_BatchNum" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="OTSCRSP_BatchQty" name="OTSCRSP_BatchQty" readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="OTSCRSP_TotalNoContainer" name="OTSCRSP_TotalNoContainer" >
                                    </div>

                                </div>
                            </div>
                        </div>

                        <br>    
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">                                
                                    <div class="card-body">
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

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="samp_detailss" role="tabpanel">
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

                                                <div class="d-flex flex-wrap gap-2">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample Print</button>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="homes" role="tabpanel">
                                                <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
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
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Transfer</button>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Sleep</button>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="profilety" role="tabpanel">
                                                <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
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
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Post Extra Issue</button>
                                                     <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Slip</button>
                                                </div>
                                            </div>
                                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" id="OTSCRSP_Btn" name="OTSCRSP_Btn" onclick="OTSCRSP_Submit();">Add</button>

                            <button type="button" data-bs-dismiss="modal" aria-label="Close"  class="btn btn-danger active" data-bs-toggle="button" autocomplete="off">Cancel</button>
                        </div>
                         
                    </div>
                </form>
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
                                               <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                
      </div><!--body end-->
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
                 <form>
                                     <div class="row">

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
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base Doc Num</label>
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
                                                                <th>Warehouse</th>
                                                                <th>Item Cost</th>
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
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                         </tr>
                                           
                                                         
                                                     </tbody> 
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
                                               <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn active btn-primary" data-bs-toggle="button" autocomplete="off">Cancel</button>
                                



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
