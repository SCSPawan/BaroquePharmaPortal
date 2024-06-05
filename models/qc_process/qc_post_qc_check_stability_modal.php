<style type="text/css">
    .mt-6{margin-top: -6px !important;}
    .FreightInput {width: 100px;border: transparent;}
    .FreightInput:focus {border: transparent;outline: none;}
    .no{border: 1px solid red !important;}
</style>


 <!-- --------inventory transfer------------ -->
<div class="modal fade inventory_transfer_qc_ckeck_stability" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer Stability </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <!-- form start -->
                 <form role="form" class="form-horizontal" id="inventoryFormSubmit_stability" method="post">
                            <input class="form-control desabled" type="hidden" id="s_InventoryTransfer_BPLId" name="s_InventoryTransfer_BPLId">
                            <input class="form-control desabled" type="hidden" id="s_InventoryTransfer_DocEntry" name="s_InventoryTransfer_DocEntry">

                                     <div class="row">

                                        <!-- <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div> -->

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="s_IT_stability_series" name="s_IT_stability_series" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="s_IT_stability_SupplierName" name="s_IT_stability_SupplierName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier code</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="s_IT_stability_Suppliercode" name="s_IT_stability_Suppliercode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="s_IT_stability_branch" name="s_IT_stability_branch" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="s_IT_stability_BaseDocType" name="s_IT_stability_BaseDocType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="s_IT_stability_PostingDate" name="s_IT_stability_PostingDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="s_IT_stability_DocumentDate" name="s_IT_stability_DocumentDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="s_IT_stability_BaseDocNum" name="s_IT_stability_BaseDocNum" readonly>
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
                                                     <tbody id="InventoryTransferItemAppend_stability">

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
                                 <tbody id="ContainerSelectionItemAppend_stabilitys"></tbody> 
                               </table>
                           </div>
                           <button type="button" id="SubIT_Btn" name="SubIT_Btn" class="btn active btn-primary" data-bs-toggle="button" autocomplete="off" onclick="SubmitInventoryTransferQC_stability()">Add</button>
                           <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                    </form>
                                
      </div><!--body end-->
    </div>
  </div>
</div>



    <!-- --------------inventory transfer-------------- -->