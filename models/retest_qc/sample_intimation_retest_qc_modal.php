<style type="text/css">
.mt-6{margin-top: -6px !important;}
 </style>

<!--sample intimation model-->
   <div class="modal fade sample-intimation" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-xl">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="myLargeModalLabel">Sample Intimation- Retest QC</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
               
               <form role="form" class="form-horizontal" id="SampleIntimationRetestQCForm" method="post">
                  <div class="row">

                     <!-- hidden filed --------------------------------------------------------- -->
                        <input type="hidden" id="SIRT_NextNumber" name="SIRT_NextNumber">
                        <input type="hidden" id="SIRT_LineNum" name="SIRT_LineNum">
                        <input type="hidden" id="SIRT_LocID" name="SIRT_LocID">
                        <input type="hidden" id="SIRT_BranchID" name="SIRT_BranchID">
                        <input type="hidden" id="SIRT_WhsCode" name="SIRT_WhsCode">
                        <!-- <input type="text" id="SIRT_QtyPerContainer" name="SIRT_QtyPerContainer"> -->
                     <!-- ---------------------------------------------------------------------- -->

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO No</label>
                           <div class="col-lg-6">
                              <input class="form-control desabled" type="text" id="SIRT_GRPONo" name="SIRT_GRPONo" readonly>
                           </div>
                           <div class="col-lg-2">
                              <input class="form-control desabled" type="text" id="SIRT_GRPODocEntry" name="SIRT_GRPODocEntry" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                           <div class="col-lg-6">
                              <select class="form-select" id="SIRT_DocNoName" name="SIRT_DocNoName" onchange="selectedSeries();"></select>
                           </div>
                           <div class="col-lg-2">
                              <input class="form-control desabled" type="text" id="SIRT_DocNo" name="SIRT_DocNo" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Vendor Code</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_VenderCode" name="SIRT_VenderCode" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Vendor Name</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_VenderName" name="SIRT_VenderName" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">BP Ref. No</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_BpRefNo" name="SIRT_BpRefNo" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_SampleType" name="SIRT_SampleType" readonly>
                           </div>
                        </div>
                     </div>  

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                           <div class="col-lg-8">
                              <select class="form-select" id="SIRT_TrType" name="SIRT_TrType"></select>
                           </div>
                        </div>
                     </div>  

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_ItemCode" name="SIRT_ItemCode" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_ItemName" name="SIRT_ItemName" readonly>
                           </div>
                        </div>
                     </div>   

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO Qty</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="number" id="SIRT_GRPO_Qty" name="SIRT_GRPO_Qty" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-5 col-form-label mt-6" for="val-skill">Retest Sample Qty</label>
                           <div class="col-lg-4">
                              <input class="form-control desabled" type="number" id="SIRT_SQty" name="SIRT_SQty" readonly>
                           </div>
                           <div class="col-lg-3">
                              <input class="form-control desabled" type="text" id="SIRT_UOM" name="SIRT_UOM" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="number" id="SIRT_RQty" name="SIRT_RQty" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG By</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_MfgBy" name="SIRT_MfgBy" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-5 col-form-label mt-6" for="val-skill">Total No of container</label>
                           <div class="col-lg-7">
                              <input class="form-control" type="number" id="SIRT_NoOfcontainer" name="SIRT_NoOfcontainer">
                           </div>
                        </div>
                     </div>  

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                           <div class="col-lg-8">
                              <input class="form-control" type="number" id="SIRT_FromContainer" name="SIRT_FromContainer">
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                           <div class="col-lg-8">
                              <input class="form-control" type="number" id="SIRT_ToContainer" name="SIRT_ToContainer">
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                           <div class="col-lg-4">
                              <input class="form-control desabled" type="text" id="SIRT_Status" name="SIRT_Status" readonly>
                           </div>

                           <div class="col-lg-4">
                              <div class="form-check">
                                 <input class="form-check-input" type="checkbox" value="" id="SIRT_StatusChekBox" name="SIRT_StatusChekBox" style="pointer-events: none;">
                                 <label class="form-check-label" for="flexCheckDefault">Cancelled</label>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR Date</label>
                           <div class="col-lg-8">
                              <input class="form-control" type="date" id="SIRT_TrDate" name="SIRT_TrDate" value="<?php echo  date("Y-m-d");?>" onchange="getSeriesDropdown();">
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_BranchName" name="SIRT_BranchName" readonly>
                           </div>
                        </div>
                     </div>  

                     <div class="col-xl-3 col-md-6" style="display: none;">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan No</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="number" id="SIRT_ChallanNo" name="SIRT_ChallanNo" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6" style="display: none;">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan Date</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_ChallanDate" name="SIRT_ChallanDate" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6" style="display: none;">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_GateEntryNo" name="SIRT_GateEntryNo" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6" style="display: none;">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_GateEntryDate" name="SIRT_GateEntryDate" readonly>
                           </div>
                        </div>
                     </div> 

                     

                     <div class="col-xl-3 col-md-6" style="display: none;">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container</label>
                           <div class="col-lg-8">
                              <input class="form-control" type="text" id="SIRT_Container" name="SIRT_Container">
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_BatchNo" name="SIRT_BatchNo" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="number" id="SIRT_BatchQty" name="SIRT_BatchQty" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_MfgDate" name="SIRT_MfgDate" readonly>
                           </div>
                        </div>
                     </div> 

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_ExpiryDate" name="SIRT_ExpiryDate" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_Location" name="SIRT_Location" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retest Date</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_RetestDate" name="SIRT_RetestDate" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_MakeBy" name="SIRT_MakeBy" readonly>
                           </div>
                        </div>
                     </div>

                     <!-- 
                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Type of Material</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="SIRT_TypeofMaterial" name="SIRT_TypeofMaterial" readonly>
                           </div>
                        </div>
                     </div> -->


                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-5 col-form-label mt-6" for="val-skill">Qty Per Container</label>
                           <div class="col-lg-7">
                              <input class="form-control desabled" type="text" id="SIRT_QtyPerContainer" name="SIRT_QtyPerContainer" readonly>
                           </div>
                        </div>
                     </div>


                     <div class="col-xl-6 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-2 col-form-label mt-6" for="val-skill">Container Nos</label>
                           <div class="col-lg-10">
                              <textarea class="form-control desabled" id="SIRT_ContainerNos" name="SIRT_ContainerNos" rows="4"></textarea>
                           </div>
                        </div>
                     </div>
                     

                  </div>
                  <!--row closed-->
                    
                  <!-- Toggle States Button -->
                  <div class="row">
                     <div class="col-md-6">

                        <button type="button" class="btn btn-primary" id="SampleIntimationRetestQCBtn" name="SampleIntimationRetestQCBtn" onclick="SendSampleIntimationRetestQC_Data()">Add</button>

                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger active" data-bs-toggle="button" autocomplete="off" aria-pressed="true">Cancel</button>

                     </div>
                  </div>
                  <!--row closed-->
               </form>
               <!-- form end -->
            </div>
         </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
</div>
<!--end sample intimation model-->



<!-- --------inventory transfer------------ -->
<div class="modal fade inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <!-- form start -->
         <form role="form" class="form-horizontal" id="SIRT_inventory_transfer_form" method="post">

            <div class="modal-body">
                   
               <div class="row">

                  <input type="hidden" id="SIRTIT_DocNo" name="SIRTIT_DocNo"> <!-- hidden -->
                  <input type="hidden" id="SIRTIT_BPL_Id" name="SIRTIT_BPL_Id"> <!-- hidden -->

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="SIRTIT_SupplierCode" name="SIRTIT_SupplierCode" readonly>
                        </div>
                     </div>
                  </div>

                  

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="SIRTIT_SupplierName" name="SIRTIT_SupplierName" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="SIRTIT_BranchName" name="SIRTIT_BranchName" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                        <div class="col-lg-5">
                           <select class="form-select" id="SIRTIT_DocNoName" name="SIRTIT_DocNoName" onchange="selectedSeries()">
                              <option>Select</option>
                           </select>
                        </div>

                        <div class="col-lg-3">
                           <input class="form-control desabled" type="text" id="SIRTIT_NextNumber" name="SIRTIT_NextNumber" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="SIRTIT_BaseDocType" name="SIRTIT_BaseDocType" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                        <div class="col-lg-8">
                           <input class="form-control" type="date" id="SIRTIT_PostingDate" name="SIRTIT_PostingDate" value="<?php echo date("Y-m-d");?>" onchange="getSeriesDropdown()">
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                        <div class="col-lg-8">
                           <input class="form-control" type="date" id="SIRTIT_DocDate" name="SIRTIT_DocDate" value="<?php echo date("Y-m-d");?>">
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="SIRTIT_DocEntry" name="SIRTIT_DocEntry" readonly>
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
                        <tbody id="SampleIntimationInventoryTransferItemAppend"></tbody> <!-- Item List Append here -->
                     </table>
                  </div>
               <!-- table end -->

               <!-- table start -->
               <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
               <div class="table-responsive mt-2" id="list">
                  <table id="ContainerSelectionTable" class="table sample-table-responsive table-bordered" style="">
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
                     <tbody id="ContainerSelectionItemAppend"></tbody> <!-- Container Selection List Append here -->
                  </table>
               </div>

               <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" id="SIRTIT_SubBtn" name="SIRTIT_SubBtn" onclick="SubmitSampleIntimationRetestQCInventoryTransfer()">Add</button>

               <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>                 
            </div><!--body end-->
         </form>
         <!-- form End -->
      </div>
   </div>
</div>
<!-- --------------inventory transfer-------------- -->


<!-- --------After inventory transfer------------ -->
<div class="modal fade after_inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body" id="SampleIntimationRetestQCInventoryTransferAfterHTMLAppend">
           
         </div>
      </div>
   </div>
</div>
<!-- --------------After inventory transfer-------------- -->

<!-- --------sample intimation print model------------------- -->
   <div class="modal fade sample_inti_print_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="RPT_title"></h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="RPTPrint_Close()"></button>
            </div>
            
            <div class="modal-body">
               <iframe id="RPTPrint_Link" src="" style="width: 100%;height: 88vh;"></iframe>
            </div><!--body end-->
         </div>
      </div>
   </div>
<!-- --------------sample intimation print model-------------- -->