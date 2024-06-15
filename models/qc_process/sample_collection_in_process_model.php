<style type="text/css">
    .mt-6{margin-top: -6px !important;}
</style>

<!--start sample collection in process model-->
<div class="modal fade sample-collection-in-process" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Sample Collection5666 - In Process </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form role="form" class="form-horizontal" id="OTSCP_Form" method="post">
                    <div class="row">
                        <input type="text" id="IP_SC_LineNum" name="IP_SC_LineNum">
                        <input type="text" id="IP_SC_BPLId" name="IP_SC_BPLId">
                        <input type="text" id="IP_SC_BatchQty" name="IP_SC_BatchQty">
                        <input type="text" id="IP_SC_LocCode" name="IP_SC_LocCode">
                        <input type="text" id="IP_SC_RetainQtyUOM" name="IP_SC_RetainQtyUOM">
                        <input type="text" id="IP_Series" name="IP_Series">

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingediant Type</label>
                                <div class="col-lg-8">
                                    <select class="form-select" name="IP_SC_IngediantType" id="IP_SC_IngediantType">
                                        <!-- <option>None</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="IP_SC_RFPNo" name="IP_SC_RFPNo" readonly>
                                </div>
                                    <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="IP_SC_RFPEntry" name="IP_SC_RFPEntry" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="IP_SC_WONo" name="IP_SC_WONo" readonly>
                                </div>
                                    <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="IP_SC_WOEntry" name="IP_SC_WOEntry" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                <div class="col-lg-4">
                                    <select class="form-select" id="IP_SC_DocName" name="IP_SC_DocName" onchange="selectedSeries()"></select>
                                </div>
                                <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="IP_SC_DocNo" name="IP_SC_DocNo" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IP_SC_Location" name="IP_SC_Location" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IP_SC_IntimatedBy" name="IP_SC_IntimatedBy" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="IP_SC_IntimatedDate" name="IP_SC_IntimatedDate">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                                <div class="col-lg-6">
                                    <input class="form-control desabled" type="text" id="IP_SC_SampleQty" name="IP_SC_SampleQty" readonly>
                                </div>
                                <div class="col-lg-2">
                                    <input class="form-control desabled" type="text" id="IP_SC_SampleQtyUOM" name="IP_SC_SampleQtyUOM" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                <div class="col-lg-7">
                                    <select class="form-select" id="IP_SC_smpleCollectBy" name="IP_SC_mpleCollectBy"></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IP_SC_ARNo" name="IP_SC_ARNo" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Recieved Sepretly</label>
                                <div class="col-lg-6">
                                    <select class="form-select">
                                        <option>Select</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="IP_SC_DocDate" name="IP_SC_DocDate" value="<?php echo date('Y-m-d');?>" onchange="getSeriesDropdown();">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IP_SC_TRNo" name="IP_SC_TRNo" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IP_SC_Branch" name="IP_SC_Branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IP_SC_ItemCode" name="IP_SC_ItemCode" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IP_SC_ItemName" name="IP_SC_ItemName" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IP_SC_BatchNo" name="IP_SC_BatchNo" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" id="IP_SC_NoOfContainer" name="IP_SC_NoOfContainer">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">MakeBy</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="IP_SC_MakeBy" name="IP_SC_MakeBy" readonly>
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
                                            <form>
                                                <div class="row">

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-6 col-form-label mt-6" for="val-skill">UnderTest Transfer No</label>
                                                            <div class="col-lg-6">
                                                                <input type="text" name="IP_SC_UnderTestTransferNo" id="IP_SC_UnderTestTransferNo" class="form-control desabled" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Date of Reversal</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" name="IP_SC_DateofReversal" id="IP_SC_DateofReversal" class="form-control desabled" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                          <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <div class="col-md-5">
                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample Issue</button>
                                                                </div>
                                                                <div class="col-lg-7 container_input">
                                                                    <input type="text" name="IP_SC_SampleIssue" id="IP_SC_SampleIssue" class="form-control desabled" readonly>
                                                                 </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <div class="col-md-7">
                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Reverse Sample Issue</button>
                                                                </div>
                                                                <div class="col-lg-5 container_input">
                                                                    <input type="text" name="IP_SC_ReverseSampleIssue"  id="IP_SC_ReverseSampleIssue" class="form-control desabled" readonly>
                                                                 </div>
                                                            </div>
                                                        </div>

                                                     </div>

                                                     <div class="row">

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                                <div class="col-lg-6">
                                                                    <input type="text" name="IP_SC_RetainQty" id="IP_SC_RetainQty" class="form-control desabled" readonly>
                                                                </div>
                                                                <!-- <div class="col-lg-3">
                                                                    <input type="text" name="" class="form-control desabled" readonly>
                                                                </div> -->
                                                            </div>
                                                        </div>

                                                         <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <div class="col-md-4">
                                                                    <button type="button" class="pad_btn btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled style="padding: 7px 5px 7px 5px;">Retain Issue</button>
                                                                </div>
                                                                <div class="col-lg-8 container_input">
                                                                    <input type="text" name="IP_SC_RetainIssue" id="IP_SC_RetainIssue" class="form-control desabled" readonly>
                                                                 </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container No</label>
                                                                <div class="col-lg-8 container_input" style="display: inline-flex;">
                                                                    <input type="text" name="IP_SC_CntNo1" id="IP_SC_CntNo1" class="form-control desabled" readonly>
                                                                    <input type="text" name="IP_SC_CntNo2" id="IP_SC_CntNo2" class="form-control desabled" readonly>
                                                                    <input type="text" name="IP_SC_CntNo3" id="IP_SC_CntNo3" class="form-control desabled" readonly>
                                                                 </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Qty For Label</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" name="IP_SC_QtyForLabel" id="IP_SC_QtyForLabel" class="form-control desabled" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                     </div>

                                                     
                                                </form>        
                                               
                                                <div class="d-flex flex-wrap gap-2">
                                               
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample for Analysis Label</button>

                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample Label</button>

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
                            <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" id="SampleCollectionInProcess_Btn" name="SampleCollectionInProcess_Btn" onclick="SampleCollectionInProcess_Submit();">Add</button>

                            <button type="button" data-bs-dismiss="modal" aria-label="Close"  class="btn btn-danger active" data-bs-toggle="button" autocomplete="off">Cancel</button>
                        </div>
                    </form>
                 
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->

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
                 <form role="form" class="form-horizontal" id="inventory_transfer_form_issue_Retails" method="post">
                    <input class="form-control desabled" type="hidden" id="it_InventoryTransfer_BPLId" name="it_InventoryTransfer_BPLId">
                     <input class="form-control desabled" type="hidden" id="it_InventoryTransfer_DocEntry" name="it_InventoryTransfer_DocEntry">
                                    <div class="row">

                                       <!--  <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="iT_goods_issue_supplier_code" name="iT_goods_issue_supplier_code" readonly>
                                                </div>
                                            </div>
                                        </div> -->

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                                 <div class="col-lg-4">
                                                    <select class="form-control desabled" type="text" id="iT_InventoryTransfer_series" name="iT_InventoryTransfer_series"></select>
                                                 </div>
                                                 <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="inveTra_docNo" name="inveTra_docNo">
                                                 </div>

                                              
                                            </div>
                                        </div>

                                       <!--  <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="iT_InventoryTransfer_supplier_name" name="iT_InventoryTransfer_supplier_name" readonly>
                                                </div>
                                            </div>
                                        </div> -->

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
                                                     <tbody id="ContainerSelectionItemAppend_retails"></tbody> 
                                                </table>
                                            </div>
                                               <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button> -->
                                               <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer_Retials_issue()">Add</button>


                                               <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                            </form>
                                
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
                <form role="form" class="form-horizontal" id="inventory_transfer_form_issue_sample" method="post">

                    <input type="tex" id="it_BPLId" name="it_BPLId">
                    <input type="tex" id="it_DocEntry" name="it_DocEntry">
                    <input type="tex" id="numner_Series" name="numner_Series">

                    <div class="row">

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="gd_branch" name="gd_branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="gd_BaseDocType" name="gd_BaseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base Doc Num</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="gd_BaseDocNum" name="gd_BaseDocNum" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-4">
                                    <select class="form-control " type="text" id="gd_SeriesName" name="gd_SeriesName" onchange="selectedSeries_gd()"></select>
                                </div>
                                 <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="gd_docNo" name="gd_docNo" readonly>
                                </div>
                            </div>
                        </div>

                        <?php
                            // Get the current date in YYYY-MM-DD format
                            $currentDate = date('Y-m-d');
                            ?>

                        

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="gd_PostingDate" name="gd_PostingDate"  value="<?php echo $currentDate; ?>" onchange="getSeriesDropdown_gd();">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="gd_DocumentDate" name="gd_DocumentDate" value="<?php echo $currentDate; ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive" id="list">
                        <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                            <thead class="fixedHeader1">
                                <tr>
                                    <th>Sr. No </th>  
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Quality</th>
                                    <th>Warehouse</th>
                                    <th>ToWhset</th>
                                    <th>Location</th>
                                    <th>UOM</th>
                                </tr>
                            </thead>
                            <tbody id="InventoryTransferItemAppend"> </tbody> 
                        </table>
                    </div>

                    <br>

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
            </div>
        </div>
    </div>
</div>
<!-- --------------Goods Issue-------------- -->



   <!-- --------inventory transfer external------------ -->

<div class="modal fade inventory_external_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer External</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <!-- form start -->
                 <form role="form" class="form-horizontal" id="inventory_transfer_form_external" method="post">
                   
                     <input class="form-control desabled" type="hidden" id="it_InventoryTransfer_external_BPLId" name="it_InventoryTransfer_BPLId">
                     <input class="form-control desabled" type="hidden" id="it_InventoryTransfer_external_DocEntry" name="it_InventoryTransfer_DocEntry">
                                    <div class="row">

                                       <!--  <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="iT_goods_issue_supplier_code" name="iT_goods_issue_supplier_code" readonly>
                                                </div>
                                            </div>
                                        </div> -->

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                                 <div class="col-lg-4">
                                                    <select class="form-control desabled" type="text" id="iT_InventoryTransfer_external_series" name="iT_InventoryTransfer_external_series"></select>
                                                </div>

                                                 <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="external_docNo" name="external_docNo">
                                                 </div>
                                            </div>
                                        </div>

                                       <!--<div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="iT_InventoryTransfer_supplier_name" name="iT_InventoryTransfer_supplier_name" readonly>
                                                </div>
                                            </div>
                                        </div> -->

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="iT_InventoryTransfer_external_branch" name="iT_InventoryTransfer_external_branch" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="iT_InventoryTransfer_external_BaseDocType" name="iT_InventoryTransfer_external_BaseDocType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="iT_InventoryTransfer_external_PostingDate" name="iT_InventoryTransfer_external_PostingDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="iT_InventoryTransfer_external_DocumentDate" name="iT_InventoryTransfer_external_DocumentDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="iT_InventoryTransfer_external_BaseDocNum" name="iT_InventoryTransfer_external_BaseDocNum" readonly>
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
                                                     <tbody id="ContainerSelectionItemAppend_external"></tbody> 
                                                </table>
                                            </div>
                                               <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button> SubmitInventoryTransfer_Retials_issue-->
                                               <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer_external()">Add</button>

                                               <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                </form>
                                
      </div><!--body end-->
    </div>
  </div>
</div>



    <!-- --------------inventory transfer external-------------- -->



    <!-- --------Goods Issue------------ -->
<div class="modal fade goods_extra_issue" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Goods Issue extra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form role="form" class="form-horizontal" id="inventory_transfer_form_extra" method="post">

                    <input type="hidden" id="it_BPLId_extra" name="it_BPLId_extra">
                    <input type="hidden" id="it_DocEntry_extra" name="it_DocEntry_extra">

                    <div class="row">

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="gd_branch_extra" name="gd_branch_extra" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="gd_BaseDocType_extra" name="gd_BaseDocType_extra" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base Doc Num</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="gd_BaseDocNum_extra" name="gd_BaseDocNum_extra" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-4">
                                    <select class="form-control desabled" type="text" id="gd_Series_extra" name="gd_Series_extra"></select>
                                </div>
                                 <div class="col-lg-4">
                                 <input class="form-control desabled" type="text" id="extra_docNo" name="extra_docNo">
                             </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="gd_PostingDate_extra" name="gd_PostingDate_extra">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="gd_DocumentDate_extra" name="gd_DocumentDate_extra">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive" id="list">
                        <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                            <thead class="fixedHeader1">
                                <tr>
                                    <th>Sr. No </th>  
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Quality</th>
                                    <th>Warehouse</th>
                                    <th>ToWhset</th>
                                    <th>Location</th>
                                    <th>UOM</th>
                                </tr>
                            </thead>
                            <tbody id="InventoryTransferItemAppend_extra"> </tbody> 
                        </table>
                    </div>

                    <br>

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
                            <tbody id="ContainerSelectionItemAppend_extra"></tbody> 
                        </table>
                    </div>
<!-- SubmitInventoryTransfer_sample_issue -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer_extra()">Add</button>

                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn active btn-danger" data-bs-toggle="button" autocomplete="off">Cancel</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- --------------Goods Issue-------------- -->