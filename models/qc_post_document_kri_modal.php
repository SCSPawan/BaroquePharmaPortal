<!-- --------inventory transfer------------ -->
<div class="modal fade qc_post_inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Qc Post Document -> Inventory Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form role="form" class="form-horizontal" id="inventory_transfer_form-qc-post-doc" method="post">
                    <input type="hidden" id="BatchNo_value" name="BatchNo_value">
                    <input type="hidden" id="BranchId" name="BranchId">
                    <input type="hidden" id="_DocEntry" name="_DocEntry" >
                    <input type="hidden" id="it_Series" name="it_Series">
                    <input type="hidden" id="QC_Status_LineId" name="QC_Status_LineId">

                    <input type="hidden" id="QC_IT_AssayPotency" name="QC_IT_AssayPotency">
                    <input type="hidden" id="QC_IT_LoD_Water" name="QC_IT_LoD_Water">
                    <input type="hidden" id="QC_IT_potency" name="QC_IT_potency">
                    <input type="hidden" id="QC_IT_assay_append" name="QC_IT_assay_append">
                    <input type="hidden" id="QC_IT_factor" name="QC_IT_factor">
                    <input type="hidden" id="QC_IT_ARNo" name="QC_IT_ARNo">
                    <input type="hidden" id="QC_IT_RetestDate" name="QC_IT_RetestDate">

                    <div class="row">
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
                                  <select class="form-select" id="DocNo" name="DocNo" onchange="selectedSeries()"></select>
                               </div>

                               <div class="col-lg-2">
                                  <input class="form-control desabled" type="text" id="NextNumber" name="NextNumber" readonly="">
                               </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="it_BaseDocEntry" name="it_BaseDocEntry" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="it_postingDate" name="it_postingDate" value="<?php echo date("Y-m-d");?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="it_documentDate" name="it_documentDate" value="<?php echo date("Y-m-d");?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="it_BAseDocNum" name="it_BAseDocNum" readonly>
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
                                        <!-- <th>UOM</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="desabled">1</td>

                                        <td class="desabled"><input class="border_hide form-control desabled" type="text" id="tb_itme_code" name="tb_itme_code" class="form-control" readonly></td>

                                        <td class="desabled"><input class="border_hide form-control desabled" type="text" id="tb_item_name" name="tb_item_name" class="form-control" readonly></td>

                                        <td class="desabled"><input class="border_hide form-control desabled" type="text" id="tb_quality" name="tb_quality" class="form-control" readonly></td>

                                        <td class="desabled"><input class="border_hide form-control desabled" type="text" id="from_whs" name="from_whs" class="form-control" readonly></td>

                                        <td class="desabled"><input class="border_hide form-control desabled" type="text" id="to_whs" name="to_whs" class="form-control" readonly></td>

                                        <td class="desabled" readonly><input class="border_hide form-control desabled" type="text" id="tb_location" name="tb_location" class="form-control"></td>

                                       <!--  <td class="desabled" readonly>
                                            <input class="border_hide form-control desabled" type="text" id="tb_UOM" name="tb_UOM" class="form-control" readonly>
                                        </td> -->
                                    </tr>
                                </tbody> 
                            </table>
                        </div>
                    <!-- table end -->

                    <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
                    <div class="table-responsive mt-2" id="list">
                        <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
                            <thead class="fixedHeader1">
                                <tr>
                                    <!-- <th>Select</th> -->
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
                            <tbody id="ContainerSelectionItemAppend"></tbody> 
                        </table>
                    </div>

                    <button type="button" id="SubIT_Btn" name="SubIT_Btn" class="btn active btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer()">Add</button>

                    <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </form>
            </div><!--body end-->
        </div>
    </div>
</div>
<!-- --------inventory transfer------------ -->

<!-- --------sample intimation print Quarantine model------------------- -->
   <div class="modal fade QC_PostDocPrintLayout" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="RPT_title"></h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="ViewRPT_Print_Close()"></button>
            </div>
            
            <div class="modal-body">
               <iframe id="PrintQuarantine_Link" src="" style="width: 100%;height: 88vh;"></iframe>
            </div><!--body end-->
         </div>
      </div>
   </div>
<!-- --------------sample intimation print Quarantine model-------------- -->