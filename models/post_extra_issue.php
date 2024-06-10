<div class="modal fade post_extra_issue" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Post Extra Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- form start -->
            <form role="form" class="form-horizontal" id="inventory_transfer_form_extra_sample" method="post">

                <div class="modal-body">


                    <input type="hidden" id="extraIssue_NextNumber" name="extraIssue_NextNumber">
                    <input type="hidden" id="extraIssue_GI_SCRTQCB_DocEntry" name="extraIssue_GI_SCRTQCB_DocEntry">
                    <input type="hidden" id="extraIssue_BPLId_samIss" name="extraIssue_BPLId_samIss">
                    <input type="hidden" id="extraIssue_supplierCode" name="extraIssue_supplierCode">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="extraIssue_branch" name="extraIssue_branch" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="extraIssue_baseDocType" name="extraIssue_baseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base Doc Num</label>
                                <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="extraIssue_BaseDocNum" name="extraIssue_BaseDocNum" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-6">
                                    <select class="form-select" id="extraIssue_DocNoName" name="extraIssue_DocNoName" onchange="selectedSeriesForGoodsIssue()"></select>
                                </div>
                                <div class="col-lg-2">
                                    <input class="form-control desabled" type="text" id="extraIssue_series" name="extraIssue_series" readonly>
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
                                    <input class="form-control" type="date" id="extraIssue_postingDate" name="extraIssue_postingDate" value="<?php echo date('Y-m-d'); ?>" onchange="getSeriesDropdownForPostExtraIssue()">
                                </div>
                            </div>
                        </div>

                        <?php
                        // Get the current date in YYYY-MM-DD format
                        $currentDate = date('Y-m-d');
                        ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="date" id="extraIssue_DocumentDate" name="extraIssue_DocumentDate"  value="<?php echo date('Y-m-d'); ?>">
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
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <input class="border_hide" type="text" id="extraIssue_item_code" name="extraIssue_item_code" class="form-control">
                                    </td>
                                    <td>
                                        <input class="border_hide" type="text" id="extraIssue_item_name" name="extraIssue_item_name" class="form-control">
                                    </td>
                                    <td>
                                        <input class="border_hide" type="text" id="extraIssue_quatility" name="extraIssue_quatility" class="form-control">
                                    </td>
                                    <td>
                                        <input class="border_hide" type="text" id="extraIssue_from_whs" name="extraIssue_from_whs" class="form-control">
                                    </td>
                                    <td>
                                        <input class="border_hide" type="text" id="extraIssue_to_whs" name="extraIssue_to_whs" class="form-control">
                                    </td>
                                    <td class="desabled">
                                        <input class="border_hide" type="text" id="extraIssue_Location" name="extraIssue_Location" class="form-control">
                                    </td>
                                    <td class="desabled">
                                        <input class="border_hide" type="text" id="extraIssue_uom" name="extraIssue_uom" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table end -->
                    <!-- <br> -->

                    <!-- table start -->
                    <h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
                    <div class="table-responsive mt-2" id="list">
                        <table id="tblItemRecord_extraIssue" class="table sample-table-responsive table-bordered" style="">
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
                            <tbody id="ContainerSelectionItemAppendSampleIssue_extraissue">
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer_extra_issue()">Add</button>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn active btn-primary" data-bs-toggle="button" autocomplete="off" aria-label="Close" style="background-color: red;">Cancel</button>
                </div><!--body end-->

            </form>
        </div>
    </div>
</div>