<style type="text/css">
.mt-6{margin-top: -6px !important;}
 </style>
<!--sample intimation model-->
  
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
               <form role="form" class="form-horizontal" id="inventoryFormSubmit_process_in" method="post">
                     
                  <input type="text" id="it_BPLId" name="it_BPLId">
                  <input type="text" id="it_DocEntry" name="it_DocEntry">
                  <input type="text" id="it_DocNo" name="it_DocNo">
                  

                  <div class="row">
                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="it_SupplierCode" name="it_SupplierCode" readonly>
                           </div>
                        </div>
                     </div>

                     <!-- <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="it_series" name="it_series" readonly>
                           </div>
                        </div>
                     </div> -->

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="it_SupplierName" name="it_SupplierName" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="it_BranchName" name="it_BranchName" readonly>
                           </div>
                        </div>
                     </div>
                     
                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                           <div class="col-lg-6">
                              <select class="form-select" id="it_DocNoName" name="it_DocNoName" onchange="selectedSeries()"></select>
                           </div>

                           <div class="col-lg-2">
                              <input class="form-control desabled" type="text" id="it_NextNumber" name="it_NextNumber" readonly="">
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="it_BaseDocType" name="it_BaseDocType" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                           <div class="col-lg-8">
                              <input class="form-control" type="date" id="it_PostingDate" name="it_PostingDate" value="<?php echo date('Y-m-d');?>">
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                           <div class="col-lg-8">
                              <input class="form-control" type="date" id="it_DocumentDate" name="it_DocumentDate" value="<?php echo date('Y-m-d');?>">
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="it_BaseDocNum" name="it_BaseDocNum" readonly>
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
                                  <th>From Whs</th>
                                  <th>To Whs</th>
                                  <th>Location</th>
                                  <th>UOM</th>
                              </tr>
                          </thead>
                       <tbody id="InventoryTransferItemAppend"></tbody> 
                     </table>
                  </div>

                  <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
                  <div class="table-responsive mt-2" id="ContainerSelectionItemAppend"></div>

                  <button type="button" id="SubIT_Btn" name="SubIT_Btn" class="btn active btn-primary" onclick="SubmitInventoryTransfer();" autocomplete="off">Add</button>

                  <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

               </form>
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
            <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">

            <input type="hidden" id="after_it_BPLId" name="after_it_BPLId">
            <input type="hidden" id="after_it_DocEntry" name="after_it_DocEntry">
      
            <div class="row">

               <div class="col-xl-3 col-md-6">
                  <div class="form-group row mb-2">
                     <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                     <div class="col-lg-8">
                        <input class="form-control desabled" type="text" id="after_it_SupplierCode" name="after_it_SupplierCode" readonly>
                     </div>
                  </div>
               </div>

               <div class="col-xl-3 col-md-6">
                  <div class="form-group row mb-2">
                     <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                     <div class="col-lg-8">
                        <input class="form-control desabled" type="text" id="after_it_series" name="after_it_series" readonly>
                     </div>
                  </div>
               </div>

               <div class="col-xl-3 col-md-6">
                  <div class="form-group row mb-2">
                     <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                     <div class="col-lg-8">
                        <input class="form-control desabled" type="text" id="after_it_SupplierName" name="after_it_SupplierName" readonly>
                     </div>
                  </div>
               </div>

               <div class="col-xl-3 col-md-6">
                  <div class="form-group row mb-2">
                     <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                     <div class="col-lg-8">
                        <input class="form-control desabled" type="text" id="after_it_BranchName" name="after_it_BranchName" readonly>
                     </div>
                  </div>
               </div>

               <div class="col-xl-3 col-md-6">
                  <div class="form-group row mb-2">
                     <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                     <div class="col-lg-8">
                        <input class="form-control desabled" type="text" id="after_it_BaseDocType" name="after_it_BaseDocType" readonly>
                     </div>
                  </div>
               </div>

               <div class="col-xl-3 col-md-6">
                  <div class="form-group row mb-2">
                     <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                     <div class="col-lg-8">
                        <input class="form-control desabled" type="date" id="after_it_PostingDate" name="after_it_PostingDate" readonly>
                     </div>
                  </div>
               </div>

               <div class="col-xl-3 col-md-6">
                  <div class="form-group row mb-2">
                     <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                     <div class="col-lg-8">
                        <input class="form-control desabled" type="date" id="after_it_DocumentDate" name="after_it_DocumentDate" readonly>
                     </div>
                  </div>
               </div>

               <div class="col-xl-3 col-md-6">
                  <div class="form-group row mb-2">
                     <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                     <div class="col-lg-8">
                        <input class="form-control desabled" type="text" id="after_it_BaseDocNum" name="after_it_BaseDocNum" readonly>
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
                        <th>From Whs</th>
                        <th>To Whs</th>
                        <th>Location</th>
                        <th>UOM</th>
                     </tr>
                  </thead>
                  <tbody id="InventoryTransferItemAppend_after"></tbody> 
               </table>
            </div>

            <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
            <div class="table-responsive mt-2"id="ContainerSelectionItemAppend_after"></div>

            <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
         </div><!--body end-->
      </div>
   </div>
</div>
<!-- --------------After inventory transfer-------------- -->
