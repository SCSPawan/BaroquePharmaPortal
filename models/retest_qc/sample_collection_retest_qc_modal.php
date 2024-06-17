<!-- start sample collection model-->
<div class="modal fade open-sample-collection" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Sample Collection-Retest QC </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form role="form" class="form-horizontal" id="OTSCRTQC_P_Form" method="post">
                        <div class="row">
                            <input type="hidden" id="SCRTP_DocNo" name="SCRTP_DocNo">
                            <input type="hidden" id="SCRTP_GRNLineNo" name="SCRTP_GRNLineNo">
                            <input type="hidden" id="SCRTP_BPLId" name="SCRTP_BPLId">
                            <input type="hidden" id="SCRTP_LocCode" name="SCRTP_LocCode">
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingediant Type</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="SCRTP_IngrediantType" name="SCRTP_IngrediantType"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRN No</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SCRTP_GRNNo" name="SCRTP_GRNNo" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="SCRTP_GRNDocEntry" name="SCRTP_GRNDocEntry" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_Location" name="SCRTP_Location" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                    <div class="col-lg-6">
                                        <select class="form-select" id="SCRTP_DocNoName" name="SCRTP_DocNoName" onchange="selectedSeries()"></select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="tetx" id="SCRTP_NextNumber" name="SCRTP_NextNumber" readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_IntimatedBy" name="SCRTP_IntimatedBy" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_IntimatedDate" name="SCRTP_IntimatedDate" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="SCRTP_SampleQty" name="SCRTP_SampleQty" readonly>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="SCRTP_UoM" name="SCRTP_UoM" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_ARNo" name="SCRTP_ARNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                    <div class="col-lg-7">
                                        <select class="form-select" id="SCRTP_SampleCollectBy" name="SCRTP_SampleCollectBy"></select>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-xl-3 col-md-6">
                              <div class="form-group row mb-2">
                                 <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Recieved Sepretly</label>
                                 <div class="col-lg-6">
                                    <select class="form-select" id="SCRTP_SampleReciviedSeperetly" name="SCRTP_SampleReciviedSeperetly">
                                       <option value="Yes">Yes</option>
                                       <option value="No" selected>No</option>
                                    </select>
                                 </div>
                              </div>
                            </div> -->

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="SCRTP_DocDate" name="SCRTP_DocDate" value="<?php echo date("Y-m-d"); ?>" onchange="getSeriesDropdown()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_TRNo" name="SCRTP_TRNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_Branch" name="SCRTP_Branch" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_SupplierCode" name="SCRTP_SupplierCode" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_SupplierName" name="SCRTP_SupplierName" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_ItemCode" name="SCRTP_ItemCode" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_ItemName" name="SCRTP_ItemName" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_BatchNo" name="SCRTP_BatchNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="SCRTP_NoOfCont" name="SCRTP_NoOfCont">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_BatchQty" name="SCRTP_BatchQty" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_MaterialType" name="SCRTP_MaterialType" readonly>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="SCRTP_MakeBy" name="SCRTP_MakeBy" readonly>
                                    </div>
                                </div>
                            </div>

                        </div><!--row closed-->
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
                                                        <div class="col-lg-7">
                                                        <input type="text" name="" class="form-control desabled" readonly>
                                                        </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6" style="display: none;">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Date of Reversal</label>
                                                            <div class="col-lg-8 container_input">
                                                                <input type="text" name="" class="form-control desabled" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6" style="display: none;">
                                                        <div class="form-group row mb-2">
                                                            <div class="col-md-7">
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" disabled>Reverse Sample Issue</button>
                                                            </div>
                                                            <div class="col-lg-5 container_input">
                                                                <input type="text" name="" class="form-control desabled" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-xl-3 col-md-6" style="display: none;">
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

                                                    <div class="col-xl-3 col-md-6" style="display: none;">
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" id="OTSCRTQC_P_Btn" name="OTSCRTQC_P_Btn" onclick="OTSCRTQC_P_Submit();">Add</button>
                                
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger active">Cancel</button>
                            </div>
                        </div>

                    </form>
                </div>
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
                <h5 class="modal-title" id="myLargeModalLabel">Inventory Transfer123 </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- form start -->
                <!-- <form> -->
                     <form role="form" class="form-horizontal" id="inventory_transfer_form" method="post">
                       <div class="row">
                        <input type="text" id="SCRTQC_it_NextNumber" name="SCRTQC_it_NextNumber">
                        <input type="text" id="SCRTQC_it_SCRTQCB_DocEntry" name="SCRTQC_it_SCRTQCB_DocEntry">
                        <input type="text" id="_SCRTQCB_BPLId" name="_SCRTQCB_BPLId">

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SCRTQC_it_supplierCode" name="SCRTQC_it_supplierCode" readonly>
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SCRTQC_it_supplierName" name="SCRTQC_it_supplierName" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                                <div class="col-lg-6">
                                    <select class="form-select" id="SCRTQC_it_DocNoName" name="SCRTQC_it_DocNoName" onchange="selectedSeries()"></select>
                                </div>
                                <div class="col-lg-2">
                                    <input class="form-control desabled" type="text" id="SCRTQC_it_DocNo" name="SCRTQC_it_DocNo" readonly>
                                </div>
                            </div>
                        </div>

                         <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SCRTQC_it_Branch" name="SCRTQC_it_Branch" readonly>
                                </div>
                            </div>
                        </div>

                         <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SCRTQC_it_BaseDocType" name="SCRTQC_it_BaseDocType" readonly>
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
                                    <input class="form-control" type="date" id="it_PostingDate" name="it_PostingDate" value="<?php echo $currentDate; ?>">
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
                                    <input class="form-control" type="date" id="it_DocDate" name="it_DocDate" value="<?php echo $currentDate; ?>"> 
                                </div>
                            </div>
                        </div>

                         <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="SCRTQC_it_BaseDocNum" name="SCRTQC_it_BaseDocNum" readonly>
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
                                    <td class="desabled" id="SCRTQC_it_IL_ItemCode"></td>
                                    <td class="desabled" id="SCRTQC_it_IL_ItemName"></td>
                                    <td class="desabled" id="SCRTQC_it_IL_Quantity"></td>
                                    <td class="desabled" id="SCRTQC_it_IL_FromWhs"></td>
                                    <td class="desabled" id="SCRTQC_it_IL_ToWhs"></td>
                                    <td class="desabled" id="SCRTQC_it_IL_Location"></td>
                                    <td class="desabled" id="SCRTQC_it_IL_UOM"></td>
                                </tr>
                            </tbody> 
                        </table>
                    </div>
                    
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

                            <tbody id="ContainerSelectionItemAppend"></tbody> 
                        </table>
                    </div>

                   <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer()">Add</button>
                   <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </form>
                <!-- form end -->
            </div>
        </div>
    </div>
</div>
<!-- --------------inventory transfer-------------- -->

<!----------Goods Issue-------------->

<div class="modal fade goods_issue" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="myLargeModalLabel">Goods Issue</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                  <!-- form start -->
                <form role="form" class="form-horizontal" id="inventory_transfer_form_issue_sample" method="post">
    
            <div class="modal-body">
                <input type="text" id="GI_series" name="GI_series">
                <input type="text" id="SCRTQC_GI_SCRTQCB_DocEntry" name="SCRTQC_GI_SCRTQCB_DocEntry">
                <input type="text" id="SCRTQCB_BPLId_samIss" name="SCRTQCB_BPLId_samIss">
                <input type="text" id="GI_supplierCode" name="GI_supplierCode">

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="GI_branch" name="GI_branch" readonly>
                                </div>
                            </div>
                        </div>

                         <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="GI_baseDocType" name="GI_baseDocType" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base Doc Num</label>
                                 <div class="col-lg-8">
                                    <input class="form-control desabled" type="text" id="GI_BaseDocNum" name="GI_BaseDocNum" readonly>
                                </div>
                            </div>
                        </div>

                         <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Series</label>
                               <div class="col-lg-6">
                                    <select class="form-select" id="GI_DocNoName" name="GI_DocNoName" onchange="selectedSeries()"></select>
                                </div>
                                <div class="col-lg-2">
                                    <input class="form-control desabled" type="text" id="GI_NextNumber" name="GI_NextNumber" readonly>
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
                                   <input class="form-control" type="date" id="GI_postingDate" name="GI_postingDate" value="<?php echo $currentDate ?>">
                                </div>
                            </div>
                        </div>

                         <div class="col-xl-3 col-md-6">
                            <div class="form-group row mb-2">
                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                 <div class="col-lg-8">
                                    <input class="form-control" type="date" id="GI_DocumentDate" name="GI_DocumentDate" value="<?php echo $currentDate ?>">
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
                                    <input class="border_hide" type="text" id="GI_item_code" name="GI_item_code" class="form-control">
                                </td>
                                <td>
                                    <input class="border_hide" type="text" id="GI_item_name" name="GI_item_name" class="form-control">
                                </td>
                                <td>
                                    <input class="border_hide" type="text" id="GI_quatility" name="GI_quatility" class="form-control">
                                </td>
                                <td>
                                    <input class="border_hide" type="text" id="GI_from_whs" name="GI_from_whs" class="form-control">
                                </td>
                                <td>
                                    <input class="border_hide" type="text" id="GI_to_whs" name="GI_to_whs" class="form-control">
                                </td>
                                <td class="desabled">
                                    <input class="border_hide" type="text" id="GI_Location" name="GI_Location" class="form-control">
                                </td>
                                <td class="desabled">
                                    <input class="border_hide" type="text" id="GI_uom" name="GI_uom" class="form-control">
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
                        <tbody id="ContainerSelectionItemAppendSampleIssue"> 
                        </tbody> 
                    </table>
                </div>

                <button type="button" class="btn btn-primary" data-bs-toggle="button" onclick="SubmitInventoryTransfer_sample_issue()">Add</button>
                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn active btn-primary" data-bs-toggle="button" autocomplete="off">Cancel</button>
            </div><!--body end-->

             </form>
        </div>
    </div>
</div>
<!-- --------------Goods Issue-------------- -->

<!-- --------sample collection restest qc RPT model------------------- -->
<div class="modal fade SampleCollectionRPT_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
<!-- --------------sample collection restest qc RPT model-------------- -->


<!-- --------------------------------------Transfer------------------------------------------- -->


