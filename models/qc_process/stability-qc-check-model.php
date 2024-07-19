<style type="text/css">
    .mt-6{margin-top: -6px !important;}
    .FreightInput {width: 100px;border: transparent;}
    .FreightInput:focus {border: transparent;outline: none;}
    .no{border: 1px solid red !important;}
</style>
  <!--start qc check model-->


<div class="modal fade stability-qc-check" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">QC Post Document  (QC Check) - Stability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal" id="qcPostDocumentStabilityForm_update" method="post">
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="card">
                            <div class="card-body">
                                <!-- update_qc_post_document_stability -->
                                <div class="row">
                                    
                                  
                                        <!-- qcPostDocumentStabilityForm_update -->
                                    <input class="form-control desabled" type="hidden" id="StabilityPlanDocEntry" name="StabilityPlanDocEntry">
                                    <input class="form-control desabled" type="hidden" id="Stability_BPLId" name="Stability_BPLId">
                                    <input class="form-control desabled" type="hidden" id="Stability_ItemCode" name="Stability_ItemCode">
                                    <input class="form-control desabled" type="hidden" id="Stability_FromWhs" name="Stability_FromWhs">
                                    <input class="form-control desabled" type="hidden" id="Stability_QCDays" name="Stability_QCDays">
                                    <input class="form-control desabled" type="hidden" id="Stability_QCbaseno" name="Stability_QCbaseno">
                                    <input class="form-control desabled" type="hidden" id="Stability_QCbaseEntry" name="Stability_QCbaseEntry">
                                    <input class="form-control desabled" type="hidden" id="Stability_QCPlanno" name="Stability_QCPlanno">
                                    <input class="form-control desabled" type="hidden" id="Stability_QCPlanEntry" name="Stability_QCPlanEntry">
                                    <input class="form-control desabled" type="hidden" id="Stability_QCLDate" name="Stability_QCLDate">
                                    <input class="form-control desabled" type="hidden" id="Stability_QC_UOM" name="Stability_QC_UOM">
                                    <!-- <input class="form-control desabled" type="hidden" id="Stability_QCPlanEntry" name="Stability_QCPlanEntry"> -->
                                    <input class="form-control desabled" type="hidden" id="Stability_RouteStageRecoReceiptEntry" name="Stability_RouteStageRecoReceiptEntry">




                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="ReceiptNo" name="ReceiptNo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="ReceiptEntry" name="ReceiptEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="WoNo" name="WoNo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="WoEntry" name="WoEntry" readonly>
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
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="GenericName" name="GenericName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="LabelCliam" name="LabelCliam" readonly>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Label Cliam UOM</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control desabled" type="text" id="LabelCliamUOM" name="LabelCliamUOM" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="MfgBy" name="MfgBy" readonly>
                                                </div>
                                            </div>
                                        </div>

<div class="col-xl-3 col-md-6">
    <div class="form-group row mb-2">
        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Release Date</label>
        <div class="col-lg-8">
            <input class="form-control" type="date" id="ReleaseDate" name="ReleaseDate" value="<?php echo date('Y-m-d');?>">
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="form-group row mb-2">
        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retest Date</label>
        <div class="col-lg-8">
            <input class="form-control" type="date" id="RetestDate" name="RetestDate" value="<?php echo date('Y-m-d');?>">
        </div>
    </div>
</div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="ARNo" name="ARNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-5 col-form-label mt-6" for="val-skill">Specification No</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control desabled" type="text" id="SpecificationNo" name="SpecificationNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                <div class="col-lg-8">
                                                   <input class="form-control desabled" type="text" id="SampleType" name="SampleType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="MaterialType" name="MaterialType" readonly>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="Ref No" name="Ref No">
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
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="BatchSize" name="BatchSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
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
                                               <label class="col-lg-7 col-form-label mt-6" for="val-skill">Sample Intimation Stability</label>
                                                <div class="col-lg-5">
                                                    <input class="form-control desabled" type="text" id="SampleIntimationStability" name="SampleIntimationStability" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-7 col-form-label mt-6" for="val-skill">Sample Collection Stability</label>
                                                <div class="col-lg-5">
                                                    <input class="form-control desabled" type="text" id="SampleCollStability" name="SampleCollStability" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Whs Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="WhsCode" name="WhsCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-8 col-form-label mt-6" for="val-skill">Sample Transfer No From WO</label>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="SampleTransferNoFromWO" name="SampleTransferNoFromWO" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-8 col-form-label mt-6" for="val-skill">Sample Collection Entry From WO</label>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="SampleCollEntryFromWO" name="SampleCollEntryFromWO" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Plan DocNum</label>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="StabilityPlanDocNum" name="StabilityPlanDocNum" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Plan DocEntry</label>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="StabilityPlanDocEntry" name="StabilityPlanDocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Plan Quantity</label>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="StabilityPlanQuantity" name="StabilityPlanQuantity" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Loading Date</label>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="StabilityLoadingDate" name="StabilityLoadingDate" readonly>
                                                </div>
                                            </div>
                                        </div>


<div class="col-xl-3 col-md-6">
<div class="form-group row mb-2">
<label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
 <div class="col-lg-4">
    <select class="form-select" type="text" id="StabilityQC_CK_D_DocName" name="StabilityQC_CK_D_DocName"></select> 
</div>

<div class="col-lg-4">
    <input class="form-control desabled" type="text" id="StabilityQC_CK_D_DocNo" name="StabilityQC_CK_D_DocNo" readonly>
</div>

<!-- <div class="col-lg-2">
 <input class="form-control desabled no" type="text" id="" name="" readonly>
</div>

<div class="col-lg-2">
 <input class="form-control desabled no" type="text" id="" name="" readonly>
</div> -->
</div>
</div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="PostingDate" name="PostingDate" value="<?php echo date('Y-m-d');?>">
                                                </div>
                                            </div>
                                        </div>

<div class="col-xl-3 col-md-6">
    <div class="form-group row mb-2">
        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
        <div class="col-lg-8">
            <input class="form-control" type="date" id="AnalysisDate" name="AnalysisDate" value="<?php echo date('Y-m-d');?>">
        </div>
    </div>
</div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">No. of Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="NoOfContainer" name="NoOfContainer" readonly>
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
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="Location" name="Location" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="ValidUpTo" name="ValidUpTo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="PackSize" name="PackSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stability Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="StabilityType" name="StabilityType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="AnalysisType" name="AnalysisType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Condition</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="StabilityCondition" name="StabilityCondition" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Time Period</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="StabilityTimePeriod" name="StabilityTimePeriod" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-8   col-form-label mt-6" for="val-skill">Release Material without QC</label>
                                                <div class="col-lg-4">
                                                    <select class="form-select">
                                                        <option>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">MakeBy</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="StabilityMakeBy" name="StabilityMakeBy" readonly>
                                                </div>
                                            </div>
                                        </div>



                                   </div>
                                </div>
                                </div>
                              <br>


                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">                                
                                    <div class="card-body">
                                         <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#general_data" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">General Data</span>    
                                                </a>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#qc_status" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">QC Status</span>    
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#attatchment" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Attatchment</span>    
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="general_data" role="tabpanel">
                                                <div class="table-responsive qc_list_table table_item_padding" id="list2">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                            <th>Sr.No</th>
                                                                    <th>Parameter Code</th>
                                                                    <th>Parameter Name</th>
                                                                    <th>Specification</th>
                                                                    <th>Result OutPut</th>
                                                                    <th>Comparison Result</th>
                                                                    <th>Result Output By QC Dept.</th>
                                                                    <th>Parameter Data Type</th>
                                                                    <th>Logical</th>
                                                                    <th>Lower Min</th>
                                                                    <th>Upper Max</th>
                                                                    <th>Mean</th>
                                                                    <th>QC Status by Analyst</th>
                                                                    <th>Test Method</th>
                                                                    <th>Material Type</th>
                                                                    <th>Pharmacopoeial Standard</th>
                                                                    <th>UOM</th>
                                                                    <th>Retest</th>
                                                                    <th>External Sample</th>
                                                                    <th>Analysis By</th>
                                                                    <th>Analyst Remarks</th>
                                                                    <th>Lower Max</th>
                                                                    <th>Release</th>
                                                                    <th>Descriptive Details</th>
                                                                    <th>Upper Min</th>
                                                                    <th>Lower Min - Result</th>
                                                                    <th>Upper Min - Result</th>
                                                                    <th>Upper Max - Result</th>
                                                                    <th>Mean - Result</th>
                                                                    <th>User Text-1</th>
                                                                    <th>User Text-2</th>
                                                                    <th>User Text-3</th>
                                                                    <th>User Text-4</th>
                                                                    <th>User Text-5</th>
                                                                    <th>QC Setup Remark</th>
                                                                    <th>Stability</th>
                                                                    <th>Applicable for Assay</th>
                                                                    <th>Applicable for LOD</th>
                                                                    <th>Instrument Code</th>
                                                                    <th>Instrument Name</th>
                                                                    <th>Start Date</th>
                                                                    <th>Start Time</th>
                                                                    <th>End Date</th>
                                                                    <th>End Time</th>
                                                              
                                                            
                                                               
                                                            </tr>
                                                        </thead>
                                                     <tbody id="qc-post-general-data-list-append"></tbody> 
                                                   </table>
                                               </div> 
                                            <!--end table-->
                                         </div> <!-- tab_pane samp details end -->

                                           

                                        <div class="tab-pane" id="qc_status" role="tabpanel">

                                            <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                          <thead class="fixedHeader1">
                                                                <tr>
                                                                <th>Sr. No</th>
                                                                    <th style="width:150px;display: block;">Status</th>
                                                                    <th>Quantity</th>
                                                                    <th>Release Date</th>
                                                                    <th>Release Time</th>
                                                                    <th>IT No</th>
                                                                    <th style="width:150px;display: block;">Done By</th>
                                                                    <th>Attachment 1</th>
                                                                    <th>Attachment 2</th>
                                                                    <th>Attachment 3</th>
                                                                    <th>Deviation Date</th>
                                                                    <th>Deviation No</th>
                                                                    <th>Deviation Reason</th>
                                                                    <th>Remarks</th>
                                                                </tr>
                                                            </thead>
                                                             <tbody id="qc-status-list-append"></tbody> 
                                                       </table>
                                               </div><!--table responsive end-->     

                                            </div> <!-- tab_pane qc status end -->




                                            <div class="tab-pane" id="attatchment" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-10">
                                                     <div class="table-responsive" id="list">
                                                     <table id="tblItemRecord" class="table table-bordered" style="">
                                                          <thead class="fixedHeader1">
                                                                <tr>
                                                                    <th>Sr. No</th>
                                                                    <th>Target Path</th>
                                                                    <th>File Name</th>
                                                                    <th>Attatchment Date</th>
                                                                    <th>Free Text</th>
                                                                </tr>
                                                            </thead>
                                                         <tbody id="qc-attach-list-append"></tbody> 

                                                       </table>
                                               </div><!--table responsive end-->
                                               </div><!--col closed-->

                                                <div class="col-md-2">

                                                <div class="gap-2">
                                                 <!-- Toggle States Button -->
                                                 <label class="btn btn-primary active  mb-2">
                                                    Browse <input type="file" hidden>
                                                </label>
                                                 <br>
                                                 <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Display</button>
                                                 <br>
                                                 <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Delete</button>
                                                         
                                                </div>
                                                
                                                </div><!--col closed-->
                                            </div><!--row closed-->
                                                
                                            </div> <!-- tab_pane attatchment end -->

                                            <!-- tfoot start -->

                                            <div class="general_data_footer">
                                                <div class="row">

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Assay Potency %</label>
                                                                <div class="col-lg-7">
                                                                    <input class="form-control" type="text" id="QC_CK_D_AssayPotency" name="QC_CK_D_AssayPotency" onfocusout="CalculatePotency();" value="0.000000">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">LOD/Water %</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="QC_CK_D_LODWater" name="QC_CK_D_LODWater" onfocusout="CalculatePotency();" value="0.000000">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-7 col-form-label mt-6" for="val-skill">Assay Calculation Based On</label>
                                                                <div class="col-lg-5">
                                                                    <select class="form-select assayapp" id="QC_CK_D_Assay" name="QC_CK_D_Assay"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Potency</label>
                                                                <div class="col-lg-8">
                                                                     <input class="form-control" type="text" id="QC_CK_D_Potency" name="QC_CK_D_Potency">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Factor</label>
                                                                <div class="col-lg-8">
                                                                     <input class="form-control" type="number" id="StabilityQC_CK_D_Factor" name="StabilityQC_CK_D_Factor">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control" id="StabilityQC_CK_D_CompiledBy" name="StabilityQC_CK_D_CompiledBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                <div class="col-lg-8">
                                                                     <select class="form-control" type="text" id="StabilityQC_CK_D_CheckedBy" name="StabilityQC_CK_D_CheckedBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control" type="text" id="StabilityQC_CK_D_AnalysisBy" name="StabilityQC_CK_D_AnalysisBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                         <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="StabilityQC_CK_D_NoOfContainer" name="StabilityQC_CK_D_NoOfContainer">
                                                                </div>
                                                                <!-- <div class="col-lg-4">
                                                                    <input class="form-control" type="text" id="" name="">
                                                                </div> -->

                                                            </div>
                                                        </div>


                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                <div class="col-lg-8">
                                                                    <textarea class="form-control" rows="1" id="StabilityQC_CK_D_Remarks" name="StabilityQC_CK_D_Remarks"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                </div>    
                                            </div>  <!--general data footer end-->
                                            
                                            <!-- -------footer button---- -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="d-flex flex-wrap gap-2">
                                                             <!-- Toggle States Button -->
                                                             <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button> -->

                                                             <button type="button" class="btn btn-primary" id="updateQcPostDocumentStabilityBtn" name="updateQcPostDocumentStabilityBtn" onclick="return update_qc_post_document_stability();">Add</button>

                                                             <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                                                             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" data-bs-toggle="button" autocomplete="off" onclick="inventoryTransferStability();">Inventory Transfer</button>

                                                              <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Update Result</button> -->
                                                        </div>
                                                    </div>
                                                        <div class="col-md-6">
                                                               <div class="btn-group">
                                                               <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Work Sheet Print</button>
                                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"><i class="fa fa-angle-down"></i>
                                                              <span class="visually-hidden"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                                              <li><a class="dropdown-item" href="#">Approval Label Print</a></li>
                                                              <li><a class="dropdown-item" href="#">Rejected Label Print</a></li>
                                                              <li><a class="dropdown-item" href="#">On-Hold Label Print</a></li>
                                                              <li><a class="dropdown-item" href="#">Print Certificate</a></li>
                                                            </ul>
                                                               

                                                         
                                                         </div>
                                                     </div>

                                                </div>
                                                    <!--row end-->

                                            <!-- ------footer button end---- -->



                                            <!-- tfoot end -->

                                        
                                                        </div> <!-- tab content end -->
                                                    </div>
                                                </div><!-- end card-body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->
                                   </div><!--row closed-->
                                </div><!--container-fluid-->
                            </div><!--page-content-->
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>

     <!--end qc check model-->

      <!-- --------inventory transfer------------ -->

<div class="modal fade inventory_transfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                                    <input class="form-control desabled" type="text" id="s_InventoryTransfer_series" name="s_InventoryTransfer_series" readonly>
                                                </div>
                                            </div>
                                        </div>

                                       <!--  <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div>
                                            </div>
                                        </div> -->

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="s_InventoryTransfer_branch" name="s_InventoryTransfer_branch" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="s_InventoryTransfer_BaseDocType" name="s_InventoryTransfer_BaseDocType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="s_InventoryTransfer_PostingDate" name="s_InventoryTransfer_PostingDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="s_InventoryTransfer_DocumentDate" name="s_InventoryTransfer_DocumentDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
                                                 <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="s_InventoryTransfer_BaseDocNum" name="s_InventoryTransfer_BaseDocNum" readonly>
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
                                                     <tbody id="InventoryTransferItemAppend_retails">

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
                                 <tbody id="ContainerSelectionItemAppend_retails"></tbody> 
                               </table>
                           </div>
                           <button type="button" id="SubIT_Btn" name="SubIT_Btn" class="btn active btn-primary" data-bs-toggle="button" autocomplete="off" onclick="SubmitInventoryTransfer()">Add</button>
                           <button type="button" class="btn active btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                    </form>
                                
      </div><!--body end-->
    </div>
  </div>
</div>



    <!-- --------------inventory transfer-------------- -->