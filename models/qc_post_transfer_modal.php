<div class="modal fade transfer_popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer900</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- form start -->
                <!-- <form> -->
                <form role="form" class="form-horizontal" id="inventory_transfer_form_transfer" method="post">
                    <div class="row">
                        <input type="text" id="transfer_it_DocNo" name="transfer_it_DocNo">
                        <input type="text" id="transfer_it_SCRTQCB_DocEntry" name="transfer_it_SCRTQCB_DocEntry">
                        <input type="text" id="_transfer_BPLId" name="_transfer_BPLId">

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="transfer_it_supplierCode" name="transfer_it_supplierCode" readonly>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="transfer_it_supplierName" name="transfer_it_supplierName" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-5">
                                    <select class="form-select" id="transfer_it_DocNoName" name="transfer_it_DocNoName" onchange="selectedSeries_transfer()"></select>
                                </div>
                                <div class="col-lg-3">
                                    <input class="form-control desabled" type="text" id="transfer_it_NextNumber" name="transfer_it_NextNumber" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="transfer_it_Branch" name="transfer_it_Branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="transfer_it_BaseDocType" name="transfer_it_BaseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <?php
                        // Get the current date in YYYY-MM-DD format
                        $currentDate = date('Y-m-d');
                        ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="it_PostingDate_tras">Posting Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="it_PostingDate_tras" name="it_PostingDate_tras" value="<?php echo $currentDate; ?>" onchange="getSeriesDropdown_transfer()">
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="it_DocDate_trans">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="it_DocDate_trans" name="it_DocDate_trans" value="<?php echo $currentDate; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="transfer_it_BaseDocNum" name="transfer_it_BaseDocNum" readonly>
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
                                    <td class="desabled" id="transfer_it_IL_ItemCode"></td>
                                    <td class="desabled" id="transfer_it_IL_ItemName"></td>
                                    <td class="desabled" id="transfer_it_IL_Quantity"></td>
                                    <td class="desabled" id="transfer_it_IL_FromWhs"></td>
                                    <td class="desabled" id="transfer_it_IL_ToWhs"></td>
                                    <td class="desabled" id="transfer_it_IL_Location"></td>
                                    <td class="desabled" id="transfer_it_IL_UOM"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
                    <div class="table-responsive mt-2" id="list">
                        <table id="ContainerSelectionTable_transfer" class="table sample-table-responsive table-bordered" style="">
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

                            <tbody id="ContainerSelectionItemAppend_transfer"></tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer_trnasfer()">Add</button>
                    <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </form>
                <!-- form end -->
            </div>
        </div>
    </div>
</div>