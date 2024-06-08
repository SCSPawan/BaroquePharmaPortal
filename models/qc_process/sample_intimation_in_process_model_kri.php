<style type="text/css">
.mt-6{margin-top: -6px !important;}
 </style>
<!--sample intimation model-->
    <div class="modal fade sample-intimation-in-process" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Sample Intimation - In Process</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                   <form role="form" class="form-horizontal" id="SampleIntimationFormInProcess" method="post">
                        <input type="hidden" id="NextNumber" name="NextNumber">
                        <input type="hidden" id="Remark" name="Remark">
                        <input type="hidden" id="LineNum" name="LineNum">
                        <input type="hidden" id="U_PC_Unit" name="U_PC_Unit">
                        <input type="hidden" id="Location" name="Location">
                        <input type="hidden" id="RetestDate" name="RetestDate">
                        <input type="hidden" id="QtyPerContainer" name="QtyPerContainer">
                        <input type="hidden" id="LocCode" name="LocCode">
                        <input type="hidden" id="BPLId" name="BPLId">

                        <div class="row">

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                     <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="ReceiptNo" name="ReceiptNo" readonly>
                                    </div>
                                     <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="ReceiptNo1" name="ReceiptNo1" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                    <div class="col-lg-6">
                                        <select class="form-select" id="DocNoName" name="DocNoName">
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="DocNo" name="DocNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                    <div class="col-lg-6">
                                        <input class="form-control desabled" type="text" id="woEntry" name="woEntry" readonly>
                                    </div>
                                     <div class="col-lg-2">
                                        <input class="form-control desabled" type="text" id="woNo" name="woNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">BP Ref. No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="BpRefNo" name="BpRefNo" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                    <div class="col-lg-8">
                                       <select class="form-select" id="sampleType" name="sampleType">
                                           <option>Select</option>
                                       </select>
                                    </div>
                                </div>
                            </div>  
                            
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="TrBy" name="TrBy">
                                       </select>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="itemCode" name="itemCode" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="itemName" name="itemName" readonly>
                                    </div>
                                </div>
                            </div>   

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="number" id="wOQty" name="wOQty" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="number" id="sampleQty" name="sampleQty" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="number" id="RetainQty" name="RetainQty" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG By</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="MfgBy" name="MfgBy" readonly> 
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-5 col-form-label mt-6" for="val-skill">Total No of container</label>
                                    <div class="col-lg-7">
                                        <input class="form-control" type="number" id="totalNoOfContainer" name="totalNoOfContainer" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="fromContainer" name="fromContainer" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="ToContainer" name="ToContainer" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="number" id="BatchNo" name="BatchNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="number" id="BatchQty" name="BatchQty" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="date" id="MFGDate" name="MFGDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="date" id="ExpiryDate" name="ExpiryDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                    <div class="col-lg-4">
                                        <input class="form-control desabled" type="text" id="statusVal" name="statusVal" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                          <label class="form-check-label" for="flexCheckDefault">
                                            Cancelled
                                          </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="date" id="TrDate" name="TrDate" >
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="Branch" name="Branch" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="number" id="ChallanNo" name="ChallanNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="date" id="ChallanDate" name="ChallanDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="GateEntryNo" name="GateEntryNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="date" id="GateEntryDate" name="GateEntryDate" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container Nos</label>
                                    <div class="col-lg-8">
                                        <input class="form-control desabled" type="text" id="ContainerNo" name="ContainerNo" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group row mb-2">
                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" id="Container" name="Container" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary" id="SampleIntimationInProcessBtn" name="SampleIntimationInProcessBtn" onclick="SendSampleIntimationData()">Add</button>

                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger active" data-bs-toggle="button" autocomplete="off" aria-pressed="true">Cancel</button>
                                </div>
                            </div>
                        </div>
                   </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!--end sample intimation model-->

