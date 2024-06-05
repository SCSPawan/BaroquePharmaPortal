 <style type="text/css">
.mt-6{margin-top: -6px !important;}
 </style>
<!--sample intimation model-->
   <div class="modal fade sample-intimation" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
   aria-hidden="true">
      <div class="modal-dialog modal-xl">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="myLargeModalLabel">Sample Intimation </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            <!-- form start -->
            <form role="form" class="form-horizontal" id="SampleIntimationForm" method="post">
               <div class="row">
                  <!-- ---------- Hidden Filed Prepare Start Here ----------------------------------- -->
                  <!-- <input type="hidden" id="Unit" name="Unit"> -->
                  <input type="hidden" id="LineNum" name="LineNum">
                  <input type="hidden" id="NextNumber" name="NextNumber">
                  <input type="hidden" id="BPLId" name="BPLId">
                  <input type="hidden" id="LocCode" name="LocCode">
                  <!-- ---------- Hidden Filed Prepare End Here ----------------------------------- -->

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO No</label>
                        <div class="col-lg-6">
                           <input class="form-control desabled" type="text" id="GRPONo" name="GRPONo" readonly>
                        </div>
                        <div class="col-lg-2">
                           <input class="form-control desabled" type="text" id="GRPODocEntry" name="GRPODocEntry" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                        <div class="col-lg-5">
                           <select class="form-select" id="DocNoName" name="DocNoName" onchange="selectedSeries()">
                              <option>Select</option>
                           </select>
                        </div>

                        <div class="col-lg-3">
                           <input class="form-control desabled" type="text" id="DocNo" name="DocNo" readonly>
                        </div>
                     </div>
                  </div>  

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Vendor Code</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="SupplierCode" name="SupplierCode" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Vendor Name</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="SupplierName" name="SupplierName" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">BP Ref. No</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="BpRefNo" name="BpRefNo">
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                        <div class="col-lg-8">
                           <select class="form-select" id="SampleType" name="SampleType">
                              <option>Select</option>
                           </select>
                        </div>
                     </div>
                  </div>  

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                        <div class="col-lg-8">
                           <select class="form-select" id="TrType" name="TrType">
                              <option>Select</option>
                           </select>
                        </div>
                     </div>
                  </div>  

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="ItemCode" name="ItemCode" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="ItemName" name="ItemName" readonly>
                        </div>
                     </div>
                  </div>   

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO Qty</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="GRPO_Qty" name="GRPO_Qty" readonly>
                        </div>
                     </div>
                  </div>  

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                        <div class="col-lg-4">
                           <input class="form-control desabled" type="number" id="SQty" name="SQty" readonly>
                        </div>
                        <div class="col-lg-4">
                           <input class="form-control desabled" type="text" id="Unit" name="Unit" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="number" id="RQty" name="RQty" readonly>
                        </div>
                     </div>
                  </div>  

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG By</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="MfgBy" name="MfgBy">
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-5 col-form-label mt-6" for="val-skill">Total No of container</label>
                        <div class="col-lg-7">
                           <input class="form-control desabled" type="number" id="NoOfcontainer" name="NoOfcontainer" readonly>
                        </div>
                     </div>
                  </div>  

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="number" id="FromContainer" name="FromContainer" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="number" id="ToContainer" name="ToContainer" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                        <div class="col-lg-4">
                           <input class="form-control desabled" type="text" id="statusDrop" name="statusDrop" readonly>
                        </div>

                        <div class="col-lg-4">
                           <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="StatusChekBox" name="StatusChekBox" style="pointer-events: none;">
                              <label class="form-check-label" for="flexCheckDefault">Cancelled</label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR Date</label>
                           <div class="col-lg-8">
                           <input class="form-control" type="date" id="TrDate" name="TrDate" onchange="getSeriesDropdown();">
                           </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="BranchName" name="BranchName" readonly>
                        </div>
                     </div>
                  </div>  

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan No</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="ChNo" name="ChNo" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan Date</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="ChDate" name="ChDate" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="GateEntryNo" name="GateEntryNo">
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="PostingDate" name="PostingDate" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container UOM</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="Container" name="Container" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="BatchNo" name="BatchNo" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="BatchQty" name="BatchQty" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="MfgDate" name="MfgDate" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="ExpiryDate" name="ExpiryDate" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="Location" name="Location" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="MakeBy" name="MakeBy" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-5 col-form-label mt-6" for="val-skill">Qty Per Container</label>
                        <div class="col-lg-7">
                           <input class="form-control desabled" type="text" id="QtyPerContainer" name="QtyPerContainer" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-5 col-form-label mt-6" for="val-skill">Type of Material</label>
                        <div class="col-lg-7">
                           <input class="form-control desabled" type="text" id="TypeofMaterial" name="TypeofMaterial" readonly>
                        </div>
                     </div>
                  </div>

                  

                  <div class="col-xl-6 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-2 col-form-label mt-6" for="val-skill">Container Nos</label>
                        <div class="col-lg-10">
                           <textarea class="form-control desabled" id="ContainerNOS" name="ContainerNOS" rows="4"></textarea>
                        </div>
                     </div>
                  </div>

               <!-- Toggle States Button -->
                  <div class="row">
                     <div class="col-md-6">

                        <button type="button" class="btn btn-primary" id="SampleIntimationBtn" name="SampleIntimationBtn" onclick="SendSampleIntimationData()">Add</button>

                        <button type="button" class="btn btn-danger active" data-bs-dismiss="modal">Cancel</button>

                       <!--  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" autocomplete="off">Transfer To Undertest</button>

                        <input type="text" name="" class="desabled"> -->
                     </div>

                    <!--  <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Print Undertest Label</button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Print Quarantine</button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Print Sample Intimation</button>
                     </div> -->
                  </div>
               </div>
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
               <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- form start -->
            <form role="form" class="form-horizontal" id="inventory_transfer_form" method="post">
           
               <div class="modal-body">
                  
                  <div class="row">
                     <!-- ---------- Hidden Filed Prepare start Here ----------------------------------- -->
                        <input type="hidden" id="it_NextNumber" name="it_NextNumber">
                        <input type="hidden" id="it_DocFlagForWeb" name="it_DocFlagForWeb">
                     <!-- ---------- Hidden Filed Prepare End Here ----------------------------------- -->

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="it_SupplierCode" name="it_SupplierCode" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                           <div class="col-lg-6">
                              <select class="form-select" id="it_DocNoName" name="it_DocNoName" onchange="selectedSeries()">
                                 <option>Select</option>
                              </select>
                           </div>

                           <div class="col-lg-2">
                              <input class="form-control desabled" type="text" id="it_DocNo" name="it_DocNo" readonly>
                           </div>
                        </div>
                     </div> 

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
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="it_BaseDocType" name="it_BaseDocType" value="SCS_SINTIMATION" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                           <div class="col-lg-8">
                              <input class="form-control" type="date" id="it_PostingDate" name="it_PostingDate" value="<?php echo date("Y-m-d");?>">
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                           <div class="col-lg-8">
                              <input class="form-control" type="date" id="it_DocDate" name="it_DocDate" value="<?php echo date("Y-m-d");?>">
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-md-6">
                        <div class="form-group row mb-2">
                           <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                           <div class="col-lg-8">
                              <input class="form-control desabled" type="text" id="it_DocEntry" name="it_DocEntry" readonly>
                           </div>
                        </div>
                     </div>

                  </div><!--row end-->

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
                              <th id="hideToWhs">To Whs</th> 
                              <th>Location</th>
                              <th>UOM</th>
                           </tr>
                        </thead>

                        <tbody id="InventoryTransferItemAppend">
                           <!-- -- Item Invetory Transfer Append Here -->
                        </tbody> 
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

                        <tbody id="ContainerSelectionItemAppend">
                           <!-- -- Container Selection Item Append Here -->
                        </tbody> 
                     </table>
                  </div>

                  <button type="button" id="SubIT_Btn" name="SubIT_Btn" class="btn active btn-primary" data-bs-toggle="button" autocomplete="off" onclick="SubmitInventoryTransfer()">Add</button>

                 <!--  <button type="button" class="btn btn-primary w-md"  name="New_Create_APCRMMST" id="New_Create_APCRMMST" onclick="sendformData();">Submit</button> -->

                  <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

               </div><!--body end-->
            </form>
            <!-- form end -->
         </div>
      </div>
   </div>
<!-- --------------inventory transfer-------------- -->

<!-- --------sample intimation print Quarantine model------------------- -->
   <div class="modal fade sample_inti_print_quarantine" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="RPT_title"></h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="ViewPrintQuarantine_RPT_Close()"></button>
            </div>
            
            <div class="modal-body">
               <iframe id="PrintQuarantine_Link" src="" style="width: 100%;height: 88vh;"></iframe>
            </div><!--body end-->
         </div>
      </div>
   </div>
<!-- --------------sample intimation print Quarantine model-------------- -->

<!-- --------After inventory transfer------------ -->
   <div class="modal fade after_inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
               <div class="row">

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="it_af_SupplierCode" name="it_af_SupplierCode" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                        <div class="col-lg-5">
                           <input class="form-control desabled" type="text" id="it_af_DocNoName" name="it_af_DocNoName" readonly>
                        </div>
                        <div class="col-lg-3">
                           <input class="form-control desabled" type="text" id="it_af_DocNo" name="it_af_DocNo" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="it_af_SupplierName" name="it_af_SupplierName" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="it_af_Branch" name="it_af_Branch" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="it_af_DocType" name="it_af_DocType" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="it_af_postingDate" name="it_af_postingDate" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="it_af_DocDate" name="it_af_DocDate" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="it_af_BaseDocNum" name="it_af_BaseDocNum" readonly>
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

                     <tbody>
                        <tr>
                           <td class="desabled">1</td>
                           <td class="desabled">
                              <input class="border_hide textbox_bg" type="text" id="it_af_ItemCode" name="it_af_ItemCode" class="form-control" readonly>
                           </td>

                           <td class="desabled">
                              <input class="border_hide textbox_bg" type="text" id="it_af_ItemName" name="it_af_ItemName" class="form-control" readonly>
                           </td>

                           <td class="desabled">
                              <input class="border_hide textbox_bg" type="text" id="it_af_Quantity" name="it_af_Quantity" class="form-control" readonly>
                           </td>

                           <td class="desabled">
                              <input class="border_hide textbox_bg" type="text" id="it_af_FromWhs" name="it_af_FromWhs" class="form-control" readonly>
                           </td>

                           <td class="desabled">
                              <input class="border_hide textbox_bg" type="text" id="it_af_ToWhse" name="it_af_ToWhse" class="form-control" readonly>
                           </td>

                           <td class="desabled">
                              <input class="border_hide textbox_bg" type="text" id="it_af_Location" name="it_af_Location" class="form-control" readonly>
                           </td>

                           <td class="desabled">
                              <input class="border_hide textbox_bg" type="text" id="it_af_UOM" name="it_af_UOM" class="form-control" readonly>
                           </td>
                        </tr>
                     </tbody> 
                  </table>
               </div>

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
                     <tbody id="AfterContainerSelectionItemAppend">
                        <!-- -- Container Selection Item Append Here -->
                     </tbody> 
                  </table>
               </div>

               <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

            </div>
         </div>
      </div>
   </div>
<!-- --------------After inventory transfer-------------- -->





     <!--start sample collection model-->

      <div class="modal fade open-sample-collection" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Sample Collection </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                  
                  <div class="modal-body">
                     <form role="form" class="form-horizontal" id="OTSCP_Form" method="post">
                        <div class="row">

                           <!-- -------------- hidden input start here -------------------------- -->
                           <input type="hidden" id="OTSCP_LineNum" name="OTSCP_LineNum">
                           <input type="hidden" id="OTSCP_NextNumber" name="OTSCP_NextNumber">
                           <input type="hidden" id="OTSCP_RQtyUom" name="OTSCP_RQtyUom">
                           <input type="hidden" id="OTSCP_RetainQty" name="OTSCP_RetainQty">
                           <input type="hidden" id="OTSCP_ContNo1" name="OTSCP_ContNo1">
                           <input type="hidden" id="OTSCP_ContNo2" name="OTSCP_ContNo2">
                           <input type="hidden" id="OTSCP_ContNo3" name="OTSCP_ContNo3">
                           <input type="hidden" id="OTSCP_QtyLab" name="OTSCP_QtyLab">
                           <input type="hidden" id="OTSCP_DRev" name="OTSCP_DRev">
                           <input type="hidden" id="OTSCP_UTNo" name="OTSCP_UTNo">
                           <input type="hidden" id="OTSCP_BPLId" name="OTSCP_BPLId">
                           <input type="hidden" id="OTSCP_LocCode" name="OTSCP_LocCode">
                           <input type="hidden" id="OTSCP_SupplierCode" name="OTSCP_SupplierCode">
                           <input type="hidden" id="OTSCP_SupplierName" name="OTSCP_SupplierName">
                           <!-- -------------- hidden input end here ---------------------------- -->

                           <!-- <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingredients Type</label>
                                 <div class="col-lg-8">
                                    <select class="form-select" id="OTSCP_IngredientsType" name="OTSCP_IngredientsType">
                                    </select>
                                 </div>
                              </div>
                           </div> -->

                           <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingredients Type</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="OTSCP_IngredientsType" name="OTSCP_IngredientsType" readonly>
                                 </div>
                              </div>
                           </div>

                           <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRN No</label>
                                 <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="OTSCP_GRPONo" name="OTSCP_GRPONo" readonly>
                                 </div>
                                 <div class="col-lg-4">
                                    <input class="form-control desabled" type="text" id="OTSCP_GRPODocEntry" name="OTSCP_GRPODocEntry" readonly>
                                 </div>
                              </div>
                           </div>

                           <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                 <div class="col-lg-4">
                                    <select class="form-control" id="OTSCP_DocNoName" name="OTSCP_DocNoName" onchange="selectedSeries()"></select>
                                 </div>
                                 <div class="col-lg-4">
                                    <input class="form-control desabled" type="number" id="OTSCP_DocNo" name="OTSCP_DocNo" readonly>
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
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                                 <div class="col-lg-5">
                                    <input class="form-control desabled" type="text" id="OTSCP_SQty" name="OTSCP_SQty" readonly>
                                 </div>
                                 <div class="col-lg-3">
                                    <input class="form-control desabled" type="text" id="OTSCP_SQtyUOM" name="OTSCP_SQtyUOM" readonly>
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
                                 <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Recieved Sepretly</label>
                                 <div class="col-lg-6">
                                    <select class="form-select" id="OTSCP_SampleRecievedSepretly" name="OTSCP_SampleRecievedSepretly">
                                       <option value="Yes">Yes</option>
                                       <option value="No" selected>No</option>
                                    </select>
                                 </div>
                              </div>
                           </div>

                           <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                                 <div class="col-lg-8">
                                    <input class="form-control" type="date" id="OTSCP_DocDate" name="OTSCP_DocDate" value="<?php echo date('Y-m-d'); ?>" onchange="getSeriesDropdown()">
                                 </div>
                              </div>
                           </div>

                           <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="OTSCP_TRNo" name="OTSCP_TRNo" readonly>
                                 </div>
                              </div>
                           </div>

                           <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="OTSCP_BranchName" name="OTSCP_BranchName" readonly>
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
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="OTSCP_BatchNo" name="OTSCP_BatchNo" readonly>
                                 </div>
                              </div>
                           </div>

                           <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                 <div class="col-lg-8">
                                    <input class="form-control" type="text" id="OTSCP_NoOfCont" name="OTSCP_NoOfCont">
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
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="OTSCP_MaterialType" name="OTSCP_MaterialType" readonly>
                                 </div>
                              </div>
                           </div>

                           <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="OTSCP_MakeBy" name="OTSCP_MakeBy" readonly>
                                 </div>
                              </div>
                           </div>

                        </div>

                        <br><br> 

                        <div class="row">
                           <div class="col-xl-12">
                              <div class="card">                                
                                 <div class="card-body">
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

                                    <div class="tab-content p-3 text-muted">
                                       <div class="tab-pane active" id="samp_detailss" role="tabpanel">

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
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Date of Reversal</label>
                                                   <div class="col-lg-8">
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
                                                      <input type="text" name="" class="form-control desabled" readonly >
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

                                          <div class="d-flex flex-wrap gap-2">
                                             <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample for Analysis Label</button>

                                             <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Sample Label</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="d-flex flex-wrap gap-2 mt-2">
                              <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" id="OTSCP_Btn" name="OTSCP_Btn" onclick="OTSCP_Submit();">Add</button>

                              <button type="button" class="btn btn-danger active" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                           </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
<!--end sample collection model-->

<!-- --------Goods Issue------------ -->
<div class="modal fade goods_issue" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title ChangeModalNameJS" id="myLargeModalLabel">Goods Issue</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body">
            <!-- form start -->
            <form role="form" class="form-horizontal" id="SCGI_popup_form" method="post">
           
               <div class="row">

                  <!-- ---------- Hidden Filed Prepare start Here ----------------------------------- -->
                     <input type="hidden" id="DocumentType" name="DocumentType">
                     <input type="hidden" id="gi_NextNumber" name="gi_NextNumber">
                     <input type="hidden" id="gi_BPL_Id" name="gi_BPL_Id">
                  <!-- ---------- Hidden Filed Prepare End Here ----------------------------------- -->

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="gi_SupplierCode" name="gi_SupplierCode" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                        <div class="col-lg-6">
                           <select class="form-select" id="gi_DocNoName" name="gi_DocNoName" onchange="SeriesSelectionByDocumentWise()">
                              <option>Select</option>
                           </select>
                        </div>

                        <div class="col-lg-2">
                           <input class="form-control desabled" type="text" id="gi_DocNo" name="gi_DocNo" readonly>
                        </div>
                     </div>
                  </div> 

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="gi_SupplierName" name="gi_SupplierName" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="gi_BranchName" name="gi_BranchName" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="gi_BaseDocType" name="gi_BaseDocType" value="SCS_SINTIMATION" readonly>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                        <div class="col-lg-8">
                           <input class="form-control" type="date" id="gi_PostingDate" name="gi_PostingDate" value="<?php echo date('Y-m-d');?>" onchange="ChangeSeriesDropdownByDocumentWise()">
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                        <div class="col-lg-8">
                           <input class="form-control" type="date" id="gi_DocDate" name="gi_DocDate" value="<?php echo date('Y-m-d');?>">
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-3 col-md-6">
                     <div class="form-group row mb-2">
                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                        <div class="col-lg-8">
                           <input class="form-control desabled" type="text" id="gi_DocEntry" name="gi_DocEntry" readonly>
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
                           <!-- <th>To Whs</th> -->
                           <th>Location</th>
                           <th>UOM</th>
                        </tr>
                     </thead>
                     <tbody id="GoodsIssueItemAppend">
                        <!-- -- Goods Issue Transfer Append Here -->
                     </tbody> 
                  </table>
               </div>
               <!-- table end -->
               <br>

               <!-- table start -->
               <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
               <div class="table-responsive mt-2" id="list">
                  <table id="ContainerSelectionTableGI" class="table sample-table-responsive table-bordered" style="">
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
                     <tbody id="GoodsIssueContainerSelectionItemAppend">
                        <!-- -- Goods Issue Container selection List Append Here -->
                     </tbody> 
                  </table>
               </div>

               <button type="button" id="SubGI_Btn" name="SubGI_Btn" class="btn active btn-primary" data-bs-toggle="button" autocomplete="off" onclick="SubmitSCGI()">Add</button>
               <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
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
