<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
header("Location:login.php");
exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
$tdata=array();
$tdata['FromDate']=date('Ymd', strtotime($_POST['fromDate']));
$tdata['ToDate']=date('Ymd', strtotime($_POST['toDate']));
$tdata['DocEntry']=trim(addslashes(strip_tags($_POST['DocEntry'])));

$getAllData=$obj->getSimpleCollection($RETESTQCSAMPCOLLADD_API,$tdata);

$count=count($getAllData);

$adjacents = 1;

$records_per_page =20;
$page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

// =========================================================================================
if($page=='1'){
$r_start='0';   // 0
$r_end=$records_per_page;    // 20
}else{
$r_start=($page*$records_per_page)-($records_per_page);   // 20
$r_end=($records_per_page*$page);   // 40
}
// =========================================================================================

$page = ($page == 0 ? 1 : $page);
$start = ($page-1) * $records_per_page;
$i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.

$next = $page + 1;    
$prev = $page - 1;
$last_page = ceil($count/$records_per_page);
$second_last = $last_page - 1; 
$pagination = "";

if($last_page > 1)
{
$pagination .= "<div class='pagination' style='float: right;'>";

if($page > 1)
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($prev).");'>&laquo; Previous&nbsp;&nbsp;</a>";
else
$pagination.= "<spn class='disabled'>&laquo; Previous&nbsp;&nbsp;</spn>";   

if($last_page < 7 + ($adjacents * 2))
{   
for ($counter = 1; $counter <= $last_page; $counter++)
{
if ($counter == $page)
$pagination.= "<spn class='current'>$counter</spn>";
else
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
}
}
elseif($last_page > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2))
{
for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if($counter == $page)
$pagination.= "<spn class='current'>$counter</spn>";
else
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
}
$pagination.= "...";
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($second_last).");'> $second_last</a>";
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");'>$last_page</a>";   

}
elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
$pagination.= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
$pagination.= "...";
for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if($counter == $page)
$pagination.= "<spn class='current'>$counter</spn>";
else
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
}

$pagination.= "..";
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($second_last).");'>$second_last</a>";
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");'>$last_page</a>";   
}
else
{
$pagination.= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
$pagination.= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
$pagination.= "..";

for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
{
if($counter == $page)
$pagination.= "<spn class='current'>$counter</spn>";
else
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
}
}

}

if($page < $counter - 1)
$pagination.= "<a href='javascript:void(0);' onClick='change_page(".($next).");'>Next &raquo;</a>";
else

$pagination.= "<spn class='disabled'>Next &raquo;</spn>";
$pagination.= "</div>";       
}

$option.= '<table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
<thead class="fixedHeader1">
<tr>
<th>Sr.No </th>  
<th>Item View</th>
<th>DocEntry</th>
<th>GRPO No</th>
<th>GRPO DocEntry</th>
<th>Supplier Code</th>
<th>Supplier Name</th>
<th>Bp Ref No</th>
<th>LineNum</th>
<th>Item Code</th> 
<th>Item Name</th>
<th>Unit</th>
<th>GRN Qty</th>
<th>Batch No</th>
<th>Batch Qty</th>
<th>Mfg Date</th>
<th>Expiry Date</th>
<th>Sample Intimation</th>
<th>Branch Name</th>
</tr>
</thead>
<tbody>';

if(count($getAllData)!='0'){
for ($i=$r_start; $i <$r_end ; $i++) { 
if(!empty($getAllData[$i]->DocEntry)){   //  this condition save to extra blank loop
$SrNo=$i+1;
// --------------- Convert String code Start Here ---------------------------
if(empty($getAllData[$i]->MfgDate)){
$MfgDate='';
}else{
$U_MfgDate = str_replace('/', '-', $getAllData[$i]->MfgDate); 
// All (/) replace to (-)
$MfgDate=date("d-m-Y", strtotime($U_MfgDate));
}

if(empty($getAllData[$i]->ExpDate)){
$ExpiryDate='';
}else{
$U_ExpDate = str_replace('/', '-', $getAllData[$i]->ExpDate); 
// All (/) replace to (-)
$ExpiryDate=date("d-m-Y", strtotime($U_ExpDate));
}
// --------------- Convert String code End Here-- ---------------------------

$option.='
<tr>
<td class="desabled">'.$SrNo.'</td>

<td style="text-align: center;">
<input type="radio" id="list'.$getAllData[$i]->DocEntry.'" name="listRado" value="'.$getAllData[$i]->DocEntry.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord('.$getAllData[$i]->DocEntry.')"  style="width: 17px;height: 17px;">
</td>

<td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
<td class="desabled">'.$getAllData[$i]->GRNNo.'</td>
<td class="desabled">'.$getAllData[$i]->GRNEntry.'</td>
<td class="desabled">'.$getAllData[$i]->SupplierCode.'</td>
<td class="desabled">'.$getAllData[$i]->SupplierName.'</td>
<td class="desabled">'.$getAllData[$i]->BPRefNo.'</td>
<td class="desabled">'.$getAllData[$i]->GRNLineNo.'</td>
<td class="desabled">'.$getAllData[$i]->ItemCode.'</td>

<td class="desabled">'.$getAllData[$i]->ItemName.'</td>
<td class="desabled">'.$getAllData[$i]->SampleQtyUnit.'</td>
<td class="desabled">'.$getAllData[$i]->GRNQty.'</td>
<td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
<td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
<td class="desabled">'.$MfgDate.'</td>
<td class="desabled">'.$ExpiryDate.'</td>
<td class="desabled">'.$getAllData[$i]->TRNo.'</td>
<td class="desabled">'.$getAllData[$i]->Branch.'</td>
</tr>';
}
}
}else{
$option.='<tr><td colspan="18" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
}
$option.='</tbody> 
</table>'; 

$option.=$pagination;        
echo $option;
exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/retest_qc/sample_collection_retest_qc_modal.php' ?>
<?php include 'models/qc_post_transfer_modal.php' ?>
<?php include 'models/post_extra_issue.php' ?>


<style type="text/css">
body[data-layout=horizontal] .page-content {
padding: 20px 0 0 0;
padding: 40px 0 60px 0;
}
</style>

<!-- ---------- loader start here---------------------- -->
<div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
<div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
<img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
</div>
</div>
<!-- ---------- loader end here---------------------- -->

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Sample Collection</h4>

<div class="page-title-right">
<ol class="breadcrumb m-0">
<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
<li class="breadcrumb-item active">Sample Collection</li>
</ol>
</div>

</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-header justify-content-between d-flex align-items-center">
<h4 class="card-title mb-0">Sample Collection-Retest QC</h4> 
</div><!-- end card header -->

<div class="card-body">

<div class="top_filter">
<div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="form-group row mb-2">
            <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">From Date</label>
            <div class="col-lg-8">
                <input class="form-control" type="date" id="FromDate" name="FromDate">
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="form-group row mb-2">
            <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">To Date</label>
            <div class="col-lg-8">
                <input class="form-control" type="date" id="ToDate" name="ToDate">
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="form-group row mb-2">
            <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">Intimation No</label>
            <div class="col-lg-8">
                <div class="form-group mb-3">
                   <input type="text" class="form-control" id="DocEntry" name="DocEntry">
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="form-group row">
            <div class="col-lg-4" style="">
                <div class="">
                    <button type="button" style="top: 0px;" id="SearchBlock" class="btn btn-primary waves-effect" onclick="SearchData()">Search <i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<div class="table-responsive" id="list-append"></div>         
</div>
</div>
</div>
</div>
<br>

<form role="form" class="form-horizontal" id="SampleCollectionRetestQCUpdateForm" method="post">
<div class="row" id="footerProcess">
<div class="col-lg-12">
<div class="card">
<div class="card-body">

<!-- form start -->

    <div class="row">

        <input type="text" id="SCRTQCB_LocCode" name="SCRTQCB_LocCode">
        <input type="text" id="SCRTQCB_Series" name="SCRTQCB_Series">
        <input type="text" id="SCRTQCB_SupplierCode" name="SCRTQCB_SupplierCode">
        <input type="text" id="SCRTQCB_SupplierName" name="SCRTQCB_SupplierName">
        <input type="text" id="SCRTQCB_GRNLineNo" name="SCRTQCB_GRNLineNo">
        <input type="text" id="SCRTQCB_BPLId" name="SCRTQCB_BPLId">
        <input type="text" id="SCRTQCB_SampleType" name="SCRTQCB_SampleType">
        <input type="text" id="SCRTQCB_SampleQtyUnit" name="SCRTQCB_SampleQtyUnit">

        <input type="text" id="SCRTQCB_RISSFromWhs" name="SCRTQCB_RISSFromWhs">
        <input type="text" id="SCRTQCB_RISSToWhs" name="SCRTQCB_RISSToWhs">
        <input type="text" id="SCRTQCB_RetainQtyUom" name="SCRTQCB_RetainQtyUom">
        <input type="hidden" id="SCRTQCB_it_DocEntry" name="SCRTQCB_it_DocEntry">
        


        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingediant Type</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" type="text" id="SCRTQCB_IngrediantType" name="SCRTQCB_IngrediantType" readonly>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRN No</label>
                <div class="col-lg-4">
                    <input class="form-control desabled" type="text" id="SCRTQCB_GRNNo" name="SCRTQCB_GRNNo" readonly>
                </div>
                 <div class="col-lg-4">
                    <input class="form-control desabled" type="text" id="SCRTQCB_GRNDocEntry" name="SCRTQCB_GRNDocEntry" readonly>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                <div class="col-lg-4">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_DocNoName" name="SCRTQCB_DocNoName">
                </div>
                 <div class="col-lg-2">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_DocNum" name="SCRTQCB_DocNum">
                </div>
                <div class="col-lg-2">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_DocEntry" name="SCRTQCB_DocEntry">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_Location" name="SCRTQCB_Location">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_IntimatedBy" name="SCRTQCB_IntimatedBy">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_IntimationDate" name="SCRTQCB_IntimationDate">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_SampleQty" name="SCRTQCB_SampleQty">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                <div class="col-lg-7">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_SampleCollBy" name="SCRTQCB_SampleCollBy">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_ARNo" name="SCRTQCB_ARNo">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
               <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Recieved Sepretly</label>
                <div class="col-lg-6">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_SampleReSep" name="SCRTQCB_SampleReSep">
                </div>
            </div>
        </div>

         <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
               <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_DocDate" name="SCRTQCB_DocDate">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_TRNo" name="SCRTQCB_TRNo">
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_Branch" name="SCRTQCB_Branch">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_ItemCode" name="SCRTQCB_ItemCode">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_ItemName" name="SCRTQCB_ItemName">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_BatchNo" name="SCRTQCB_BatchNo">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
               <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_NoOfContainer" name="SCRTQCB_NoOfContainer">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="form-group row mb-2">
               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                <div class="col-lg-8">
                    <input class="form-control desabled" readonly type="text" id="SCRTQCB_BatchQty" name="SCRTQCB_BatchQty">
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
                            <a class="nav-link active" data-bs-toggle="tab" href="#samp_details" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Sample Collection Details</span>    
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#home" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">External Issue</span>    
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Extra Issue</span>    
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="samp_details" role="tabpanel">
                        
                            <div class="row">

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group row mb-2">
                                        <label class="col-lg-6 col-form-label mt-6" for="val-skill">UnderTest Transfer No</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="SCRTQCB_SCD_UTTNo" name="SCRTQCB_SCD_UTTNo" class="form-control desabled" readonly >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group row mb-2">
                                        <div class="col-md-5">
                                            <button type="button" id="SCRTQCB_SCD_SampleIssue_Btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".goods_issue" onclick="OpenInventoryTransferModel_sampleIssue()">Sample Issue</button>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="text" id="SCRTQCB_SCD_SampleIssue" name="SCRTQCB_SCD_SampleIssue" class="form-control  desabled" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group row mb-2">
                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Date of Reversal</label>
                                        <div class="col-lg-8 container_input">
                                            <input type="date" id="SCRTQCB_SCD_DateOfRever" name="SCRTQCB_SCD_DateOfRever" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group row mb-2">
                                        <div class="col-md-7">
                                            <button type="button" id="SCRTQCB_SCD_RevSampleIssue_Btn" class="btn btn-primary" data-bs-toggle="button" name="SCRTQCB_SCD_RevSampleIssue_Btn" onclick="OnclickReverseSampleIssue();">Reverse Sample Issue</button>
                                        </div>
                                        <div class="col-lg-5 container_input">
                                            <input type="text" id="SCRTQCB_SCD_RevSampleIssue" name="SCRTQCB_SCD_RevSampleIssue" class="form-control desabled">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group row mb-2">
                                        <label class="col-lg-6 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                        <div class="col-lg-3">
                                            <input type="text" id="SCRTQCB_SCD_RetQty" name="SCRTQCB_SCD_RetQty" class="form-control desabled" readonly>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="text" id="SCRTQCB_SCD_RetUoM" name="SCRTQCB_SCD_RetUoM" class="form-control desabled" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group row mb-2">
                                        <div class="col-md-4">
                                            <button type="button" id="SCRTQCB_SCD_RetainIssue_Btn" class="pad_btn btn btn-primary"data-bs-toggle="modal" data-bs-target=".inventory_transfer" onclick="OpenInventoryTransferModel()" style="padding: 7px 5px 7px 5px;">Retain Issue</button>
                                        </div>
                                        <div class="col-lg-8 container_input">
                                            <input type="text" id="SCRTQCB_SCD_RetainIssue" name="SCRTQCB_SCD_RetainIssue" class="form-control desabled" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group row mb-2">
                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container No</label>
                                        <div class="col-lg-8 container_input" style="display: inline-flex;">
                                            <input type="text" id="SCRTQCB_SCD_Cont1" name="SCRTQCB_SCD_Cont1" class="form-control" >
                                            <input type="text" id="SCRTQCB_SCD_Cont2" name="SCRTQCB_SCD_Cont2" class="form-control">
                                            <input type="text" id="SCRTQCB_SCD_Cont3" name="SCRTQCB_SCD_Cont3" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group row mb-2">
                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Qty For Label</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="SCRTQCB_SCD_QtyForLabel" name="SCRTQCB_SCD_QtyForLabel" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Sample for Analysis Label</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Sample Label</button>
                            </div>
                        </div>

                        <div class="tab-pane" id="home" role="tabpanel">
                            <div class="table-responsive" id="list">
                                <table id="tblSCRTQC_ExternalIssue" class="table sample-table-responsive table-bordered" style="">
                                    <thead class="fixedHeader1">
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Supplier Code</th>
                                            <th>Supplier Name</th>
                                            <th>UOM </th>  
                                            <th>Sample Date</th>
                                            <th>Warehouse</th>
                                            <th>Sample Quantity</th>
                                            <th>Inventory Transfer</th> 
                                            <th>UserText 1</th>
                                            <th>UserText 2</th>
                                            <th>UserText 3</th>
                                            <th>Attachment</th>
                                        </tr>
                                    </thead>
                                    <tbody id="External-issue-list-append">
                                        <!-- <tr>
                                            <td></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control desabled" readonly></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control desabled" readonly></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control desabled" readonly></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control desabled" readonly></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control desabled" readonly></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control desabled" readonly></td>
                                        </tr> -->
                                    </tbody> 
                                </table>
                            </div> 

                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".transfer_popup" onclick="return transferExternalExtra();">Transfer</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Sleep</button>
                            </div>
                        </div>

                        <div class="tab-pane" id="profile" role="tabpanel">
                            <div class="table-responsive" id="list">
                                <table id="tblSCRTQC_ExtraIssue" class="table sample-table-responsive table-bordered" style="">
                                    <thead class="fixedHeader1">
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Sample Quantity</th>
                                            <th>UOM</th>
                                            <th>Warehouse</th>
                                            <th>Sample By</th>  
                                            <th>Issue Date</th>
                                            <th>Post Extra Issue</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Extra-issue-list-append">
                                       <!--  <tr>
                                            <td></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control desabled" readonly></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control desabled" readonly></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                            <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control desabled" readonly></td>
                                        </tr> -->
                                    </tbody> 
                                </table>
                            </div> 
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".post_extra_issue" onclick="return postExtraIssue();">Post Extra Issue</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Issue Slip</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                       

<br>

<div class="d-flex flex-wrap gap-2">

    <button type="button" class="btn btn-primary active" id="SampleCollectionRetestQCUpdateForm_Btn" name="SampleCollectionRetestQCUpdateForm_Btn" onclick="SampleCollectionRetestQCUpdateForm()">Update</button>

</div>
</div>
</div>
</div>
</div>   
<!-- ----------- -->
</form>
</div>
</div>
<br>

<?php include 'include/footer.php' ?>

<style type="text/css">
body[data-layout=horizontal] .page-content {
padding: 20px 0 0 0;
padding: 40px 0 60px 0;
}
</style>
<script type="text/javascript">
// <!-- -------------- Direct called function diclear Start Here --------------------------------
$(".loader123").hide(); // loader default hide script
$("#footerProcess").hide(); // Afer Doc Selection Process default hide script
// <!-- -------------- Direct called function diclear End Here ----------------------------------

$(document).ready(function()
{
var fromDate=document.getElementById('FromDate').value;
var toDate=document.getElementById('ToDate').value;
var DocEntry=document.getElementById('DocEntry').value;

var dataString ='fromDate='+fromDate+'&toDate='+toDate+'&DocEntry='+DocEntry+'&action=list';

$.ajax({  
type: "POST",  
url: window.location.href,  
data: dataString,  
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{   
$('#list-append').html(result);

$(".ExternalIssueraManual1").select2();// dropdown with search option
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
});

function change_page(page_id)
{ 
var fromDate=document.getElementById('FromDate').value;
var toDate=document.getElementById('ToDate').value;
var DocEntry=document.getElementById('DocEntry').value;

var dataString ='fromDate='+fromDate+'&toDate='+toDate+'&DocEntry='+DocEntry+'&page_id='+page_id+'&action=list';

$.ajax({
type: "POST",
url: window.location.href,  
data: dataString,
cache: false,
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
$('#list-append').html(result);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}

function SearchData(){
var fromDate=document.getElementById('FromDate').value;
var toDate=document.getElementById('ToDate').value;
var DocEntry=document.getElementById('DocEntry').value;

var dataString ='fromDate='+fromDate+'&toDate='+toDate+'&DocEntry='+DocEntry+'&action=list';

$.ajax({  
type: "POST",  
url: window.location.href,  
data: dataString,  
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{  
// $("#footerProcess").hide();
$('#list-append').html(result);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}

function selectedRecord(DocEntry){

// ==============================Table tr count inside tbody start here ===================
var totalRowCount = 0;
var rowCount = 0;
var table = document.getElementById("tblSCRTQC_ExternalIssue");
var rows = table.getElementsByTagName("tr")
for (var i = 0; i < rows.length; i++) {
totalRowCount++;
if (rows[i].getElementsByTagName("td").length > 0) {
rowCount++;
}
}

// console.log('Extra Issue');
// console.log('totalRowCount=>', totalRowCount);
// console.log('rowCount=>', rowCount);
// ==============================Table tr count inside tbody End here ====================

// ==============================Table tr count inside tbody start here ===================
var totalRowCount_N = 0;
var rowCount_N = 0;
var table_N = document.getElementById("tblSCRTQC_ExtraIssue");
var rows_N = table_N.getElementsByTagName("tr")
for (var i = 0; i < rows_N.length; i++) {
totalRowCount_N++;
if (rows_N[i].getElementsByTagName("td").length > 0) {
rowCount_N++;
}
}

// console.log('External Issue----2');
// console.log('totalRowCount_N=>', totalRowCount_N);
// console.log('rowCount_N=>', rowCount_N);
// ==============================Table tr count inside tbody End here ====================

var dataString ='DocEntry='+DocEntry+'&rowCount='+rowCount+'&rowCount_N='+rowCount_N+'&action=sample_collection_RTQC_ajax';

$.ajax({  
type: "POST",  
url: 'ajax/common-ajax.php',  
data: dataString,  
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{

$("#footerProcess").show();  // bottom section show script
var JSONObjectAll = JSON.parse(result);
console.log(JSONObjectAll);
var JSONObject=JSONObjectAll['SampleCollDetails'];

$(`#Extra-issue-list-append`).html(JSONObjectAll['ExtraIssue']); // Extra Issue Table Tr tag append here
$(`#External-issue-list-append`).html(JSONObjectAll['ExternalIssue']); // External Issue Table Tr tag append here

// <!-- --------------- Tab Layout Sample Collection Details Mapping Start Here ------------------ -->
$(`#SCRTQCB_SCD_UTTNo`).val(JSONObject[0]['UnderTransferNo']);
$(`#SCRTQCB_SCD_Cont1`).val(JSONObject[0]['Cont1']);
$(`#SCRTQCB_SCD_Cont2`).val(JSONObject[0]['Cont2']);
$(`#SCRTQCB_SCD_Cont3`).val(JSONObject[0]['Cont3']);

$(`#SCRTQCB_SCD_RetQty`).val(JSONObject[0]['RetainQty']);
$(`#SCRTQCB_SCD_RetUoM`).val(JSONObject[0]['RetainQtyUom']);
$(`#SCRTQCB_SCD_QtyForLabel`).val(JSONObject[0]['QtyforLabel']);

$(`#SCRTQCB_SCD_SampleIssue`).val(JSONObject[0]['SampleIssue']);
$(`#SCRTQCB_SCD_RetainIssue`).val(JSONObject[0]['RetainIssue']);
$(`#SCRTQCB_SCD_RevSampleIssue`).val(JSONObject[0]['RevSamIssue']);
// <!-- --------------- Tab Layout Sample Collection Details Mapping End Here -------------------- -->

$(`#SCRTQCB_IngrediantType`).val(JSONObject[0]['IngredientType']);
$(`#SCRTQCB_GRNNo`).val(JSONObject[0]['GRNNo']);
$(`#SCRTQCB_GRNDocEntry`).val(JSONObject[0]['GRNEntry']);
$(`#SCRTQCB_DocNoName`).val(JSONObject[0]['SeriesName']);
$(`#SCRTQCB_DocNum`).val(JSONObject[0]['DocNum']);
$(`#SCRTQCB_DocEntry`).val(JSONObject[0]['DocEntry']);
$(`#SCRTQCB_Location`).val(JSONObject[0]['Loction']);
// SCRTQCB_it_DocEntry

$(`#SCRTQCB_IntimatedBy`).val(JSONObject[0]['IntimatedBy']);
$(`#SCRTQCB_SampleQty`).val(JSONObject[0]['SampleQty']);
$(`#SCRTQCB_SampleCollBy`).val(JSONObject[0]['SampleCollectBy']);
// <!-- ----------- Intimation Date Start Here ----------------------------------- -->
var intimationDateOG = JSONObject[0]['IntimationDate'];
if(intimationDateOG!=''){
intimationDate = intimationDateOG.split(' ')[0];
$(`#SCRTQCB_IntimationDate`).val(intimationDate); 
}
// <!-- ----------- Intimation Date End Here --------------------------------------- -->


$(`#SCRTQCB_ARNo`).val(JSONObject[0]['ARNo']);
$(`#SCRTQCB_SampleReSep`).val(JSONObject[0]['SampleReceivedseperately']);
$(`#SCRTQCB_TRNo`).val(JSONObject[0]['TRNo']);
// <!-- ----------- Document Date Start Here ----------------------------------- -->
var docDateOG = JSONObject[0]['DocDate'];
if(docDateOG!=''){
docDate = docDateOG.split(' ')[0];
$(`#SCRTQCB_DocDate`).val(docDate); 
}
// <!-- ----------- Document Date End Here --------------------------------------- -->

$(`#SCRTQCB_Branch`).val(JSONObject[0]['Branch']);
$(`#SCRTQCB_ItemCode`).val(JSONObject[0]['ItemCode']);
$(`#SCRTQCB_ItemName`).val(JSONObject[0]['ItemName']);
$(`#SCRTQCB_BatchNo`).val(JSONObject[0]['BatchNo']);

$(`#SCRTQCB_NoOfContainer`).val(JSONObject[0]['NoofCont']);
$(`#SCRTQCB_BatchQty`).val(JSONObject[0]['BatchQty']);


// <!-- -------------- hidden field mapped here --------------------------- -->
$(`#SCRTQCB_GRNLineNo`).val(JSONObject[0]['GRNLineNo']);
$(`#SCRTQCB_BPLId`).val(JSONObject[0]['BPLId']);
$(`#SCRTQCB_LocCode`).val(JSONObject[0]['LocCode']);
$(`#SCRTQCB_Series`).val(JSONObject[0]['Series']);
$(`#SCRTQCB_SupplierCode`).val(JSONObject[0]['SupplierCode']);
$(`#SCRTQCB_SupplierName`).val(JSONObject[0]['SupplierName']);

$(`#SCRTQCB_SampleType`).val(JSONObject[0]['SampleType']);
$(`#SCRTQCB_SampleQtyUnit`).val(JSONObject[0]['SampleQtyUnit']);


$(`#SCRTQCB_RISSFromWhs`).val(JSONObject[0]['RISSFromWhs']);
$(`#SCRTQCB_RISSToWhs`).val(JSONObject[0]['RISSToWhs']);
$(`#SCRTQCB_RetainQtyUom`).val(JSONObject[0]['RetainQtyUom']);

// <!-- -------------- hidden field mapped here --------------------------- -->

tablayoutvalidation();
getSupplierDropdown(totalRowCount);
getWareHouseDropdown(totalRowCount);
getWareHouseExtraIssueDropdown(totalRowCount_N);

$('.ExternalIssueSelectedBPWithData').select2();// with data supplier dropdown
$('.ExternalIssueDefault').select2();// default supplier dropdown

$('.ExternalIssueWareHouseDefault').select2();// with data supplier dropdown
$('.ExternalIssueWareHouseWithData').select2();// default supplier dropdown

$('.SC_FEI_WarehouseDefault').select2();// with data supplier dropdown
$('.SC_FEI_WarehouseWithData').select2();// default supplier dropdown

},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}

function getWareHouseDropdown(totalRowCount){
var dataString ='action=WareHouseDropdown_ajax';

$.ajax({  
type: "POST",  
url: 'ajax/common-ajax.php',  
data: dataString,  
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{  
var JSONObject = JSON.parse(result);
// <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
let un_id=totalRowCount; 
$('#SC_ExternalI_Warehouse'+un_id).html(JSONObject);
// <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}

function getWareHouseExtraIssueDropdown(totalRowCount_N) {
var dataString ='action=WareHouseDropdown_ajax';

$.ajax({  
type: "POST",  
url: 'ajax/common-ajax.php',  
data: dataString,  
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{  
var JSONObject = JSON.parse(result);
// <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
let un_id=totalRowCount_N; 
$('#SC_FEI_Warehouse'+un_id).html(JSONObject);
// <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}

function getSupplierDropdown(totalRowCount){
var dataString ='action=SupplierDropdown_ajax';

$.ajax({  
type: "POST",  
url: 'ajax/common-ajax.php',  
data: dataString,  
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{  
// console.log('supplier drop=>', result);
var JSONObject = JSON.parse(result);
// <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
let un_id=totalRowCount; 
$('#SC_ExternalI_SupplierCode'+un_id).html(JSONObject);
// <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}

function ExternalIssueSelectedBP(un_id){

var SupplierCode=document.getElementById('SCRTQCB_SupplierCode').value;

var dataString ='SupplierCode='+SupplierCode+'&action=SupplierSingleData_ajax';

$.ajax({  
type: "POST",  
url: 'ajax/common-ajax.php',  
data: dataString,  
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{  
var JSONObject = JSON.parse(result);
$('#SC_FEXI_SupplierName'+un_id).val(JSONObject);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}

function tablayoutvalidation(){
var sampleIssue=document.getElementById('SCRTQCB_SCD_SampleIssue').value;
var RevSampleIssue=document.getElementById('SCRTQCB_SCD_RevSampleIssue').value;
var RetainIssue=document.getElementById('SCRTQCB_SCD_RetainIssue').value;

// <!-- -------- sample issue validation Start Here ------------ -->
if(sampleIssue==''){
document.getElementById("SCRTQCB_SCD_SampleIssue_Btn").disabled = false;
}else{
document.getElementById("SCRTQCB_SCD_SampleIssue_Btn").disabled = true;
}
// <!-- -------- sample issue validation End Here -------------- -->

// <!-- -------- Reverse sample issue validation Start Here ------------ -->
if(RevSampleIssue==''){
document.getElementById("SCRTQCB_SCD_RevSampleIssue_Btn").disabled = false;
}else{
document.getElementById("SCRTQCB_SCD_RevSampleIssue_Btn").disabled = true;
}
// <!-- -------- Reverse sample issue validation End Here -------------- -->

// <!-- -------- Retain Issue validation Start Here ------------ -->
if(sampleIssue==''){
document.getElementById("SCRTQCB_SCD_RevSampleIssue_Btn").disabled = true; // disabled

}else{

if(RetainIssue==''){
document.getElementById("SCRTQCB_SCD_RevSampleIssue_Btn").disabled = false; // enable
}else{
document.getElementById("SCRTQCB_SCD_RevSampleIssue_Btn").disabled = true; // disabled
}
}
// <!-- -------- Retain Issue validation End Here -------------- -->
}

function OpenInventoryTransferModel()
{
var SupplierCode=document.getElementById('SCRTQCB_SupplierCode').value;
var SupplierName=document.getElementById('SCRTQCB_SupplierName').value;
var BranchName=document.getElementById('SCRTQCB_Branch').value;
var DocEntry=document.getElementById('SCRTQCB_DocEntry').value;

// <!-- ---------- Item Level data get start here ------------- -->
var ItemCode=document.getElementById('SCRTQCB_ItemCode').value;
var ItemName=document.getElementById('SCRTQCB_ItemName').value;
var Location=document.getElementById('SCRTQCB_Location').value;
var RISSFromWhs=document.getElementById('SCRTQCB_RISSFromWhs').value;
var RISSToWhs=document.getElementById('SCRTQCB_RISSToWhs').value;
var RetainQtyUom=document.getElementById('SCRTQCB_RetainQtyUom').value;

var BatchQty=document.getElementById('SCRTQCB_BatchQty').value;
var SampleQty=document.getElementById('SCRTQCB_SampleQty').value;
var BatchQty_itemLevel=(parseFloat(BatchQty)-parseFloat(SampleQty)).toFixed(6);
// <!-- ---------- Item Level data get end here --------------- -->
var SCRTQCB_BPLId=document.getElementById('SCRTQCB_BPLId').value;




// var SampleQuantity=document.getElementById('SCF_SampleQty').value;

// var hideToware="1";

//var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

// $.ajax({
//     type: "POST",
//     url: 'ajax/common-ajax.php',
//     // data: dataString,
//     cache: false,

//     // beforeSend: function(){
//     //     // Show image container
//     //     $(".loader123").show();
//     // },
//     success: function(result)
//     {   
// $("#hideToWhs").hide();
$('#SCRTQC_it_supplierCode').val(SupplierCode);
$('#SCRTQC_it_supplierName').val(SupplierName);
$('#SCRTQC_it_Branch').val(BranchName);
$('#SCRTQC_it_BaseDocNum').val(DocEntry);
$('#SCRTQC_it_BaseDocType').val('SCS_SCRETEST');
$('#_SCRTQCB_BPLId').val(SCRTQCB_BPLId);
$('#SCRTQC_it_SCRTQCB_DocEntry').val(DocEntry);






// -------- item level set data start -------------------
$('#SCRTQC_it_IL_ItemCode').html(ItemCode);
$('#SCRTQC_it_IL_ItemName').html(ItemName);
$('#SCRTQC_it_IL_Quantity').html(BatchQty_itemLevel);
$('#SCRTQC_it_IL_FromWhs').html(RISSFromWhs);
$('#SCRTQC_it_IL_ToWhs').html(RISSToWhs);
$('#SCRTQC_it_IL_Location').html(Location);
$('#SCRTQC_it_IL_UOM').html(RetainQtyUom);
// -------- item level set data end ---------------------





// SCRTQC_it_supplierCode
// SCRTQC_it_supplierName
// SCRTQC_it_Branch

// $('#it_BaseDocType').val('SCS_SCOL');
// console.log('responce=>', result);
// var JSONObject = JSON.parse(result);
//                 $('#InventoryTransferItemAppend').html(JSONObject);

// //Item Quantity Recalculate according sample quantity start here -------------------
//     var itP_BQty=document.getElementById('itP_BQty').value;
//     var calculated_itP_BQty=parseFloat(itP_BQty-SampleQuantity).toFixed(6);
//     $('#itP_BQty').val(calculated_itP_BQty);
// //Item Quantity Recalculate according sample quantity end here --------------------- 

getSeriesDropdown() // DocName By using API to get dropdown 
ContainerSelection() // get Container Selection Table List
// }
// ,
// complete:function(data){
//     // Hide image container
//     $(".loader123").hide();
// }
// }); 
}



function OpenInventoryTransferModel_sampleIssue(){

var SupplierCode=document.getElementById('SCRTQCB_SupplierCode').value;
var SupplierName=document.getElementById('SCRTQCB_SupplierName').value;
var BranchName=document.getElementById('SCRTQCB_Branch').value;
var DocEntry=document.getElementById('SCRTQCB_DocEntry').value;

// <!-- ---------- Item Level data get start here ------------- -->
var ItemCode=document.getElementById('SCRTQCB_ItemCode').value;
var ItemName=document.getElementById('SCRTQCB_ItemName').value;
var Location=document.getElementById('SCRTQCB_Location').value;
var RISSFromWhs=document.getElementById('SCRTQCB_RISSFromWhs').value;
var RISSToWhs=document.getElementById('SCRTQCB_RISSToWhs').value;
var RetainQtyUom=document.getElementById('SCRTQCB_RetainQtyUom').value;

var BatchQty=document.getElementById('SCRTQCB_BatchQty').value;
var SampleQty=document.getElementById('SCRTQCB_SampleQty').value;
var BatchQty_itemLevel=(parseFloat(BatchQty)-parseFloat(SampleQty)).toFixed(6);
// <!-- ---------- Item Level data get end here --------------- -->
var SCRTQCB_BPLId=document.getElementById('SCRTQCB_BPLId').value;


// $("#hideToWhs").hide();
$('#GI_supplierCode').val(SupplierCode);
// $('#SCRTQC_it_supplierName').val(SupplierName);

$('#GI_branch').val(BranchName);
$('#GI_baseDocType').val('SCS_SCRETEST');
$('#GI_BaseDocNum').val(DocEntry);

$('#SCRTQCB_BPLId_samIss').val(SCRTQCB_BPLId);

$('#SCRTQC_GI_SCRTQCB_DocEntry').val(DocEntry);
// -------- item level set data start -------------------
$('#GI_item_code').val(ItemCode);
$('#GI_item_name').val(ItemName);
$('#GI_quatility').val(BatchQty_itemLevel);
$('#GI_from_whs').val(RISSFromWhs);
$('#GI_to_whs').val(RISSToWhs);
$('#GI_Location').val(Location);
$('#GI_uom').val(RetainQtyUom);
// -------- item level set data end ---------------------

getSeriesDropdownForGoodsIssue() // DocName By using API to get dropdown 
// ContainerSelection() // get Container Selection Table List
ContainerSelection_sample_issue();


}




// function SampleCollectionITransPop()
// {   
//     var un_id=document.getElementById('RowLevelSelectedExternalIssue').value;  // selected row un_id

//     var SupplierCode=document.getElementById('SC_FEXI_SupplierCode'+un_id).value;
//     var SupplierName=document.getElementById('SC_FEXI_SupplierName'+un_id).value;
//     var ToWare=document.getElementById('SC_FEXI_Warehouse'+un_id).value;
//     var SampleQuantity=document.getElementById('SC_FEXI_SampleQuantity'+un_id).value;
//     var sampleDate=document.getElementById('SC_FEXI_SampleDate'+un_id).value;

//     var BranchName=document.getElementById('SCF_Branch').value;
//     var DocEntry=document.getElementById('SCF_CollDocEntry').value;

//     var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

//     $.ajax({
//         type: "POST",
//         url: 'ajax/common-ajax.php',
//         data: dataString,
//         cache: false,

//         beforeSend: function(){
//             // Show image container
//             $(".loader123").show();
//         },
//         success: function(result)
//         {   
//             // console.log('TransToUnder=>', result);

//             $('#it_SupplierCode').val(SupplierCode);
//             $('#it_SupplierName').val(SupplierName);
//             $('#it_BranchName').val(BranchName);
//             $('#it_DocEntry').val(DocEntry);

//             $('#it_BaseDocType').val('SCS_SCOL');

//             var JSONObject = JSON.parse(result);
//             $('#InventoryTransferItemAppend').html(JSONObject);

//             //Item Quantity Recalculate according sample quantity start here -------------------
//                 $('#itP_BQty').val(SampleQuantity);
//             //Item Quantity Recalculate according sample quantity end here --------------------- 

//             getSeriesDropdown() // DocName By using API to get dropdown 
//             ContainerSelection() // get Container Selection Table List
//             changedateformate(sampleDate);
//         },
//         complete:function(data){
//             // Hide image container
//             $(".loader123").hide();
//         }
//     }); 
// }

// function changedateformate(date){

//     const myArray = date.split("-");

//     var day=myArray[0];
//     var months=myArray[1];
//     var year=myArray[2]; 

//     var Final_date=year+'-'+months+'-'+day;

//     document.getElementById("it_PostingDate").value = Final_date; // posting date value set here
//     document.getElementById("it_DocDate").value = Final_date; // Document date value set here
// }

// function SC_SCD_GI_SampleIssuePoP()
// {
//     var SupplierCode=document.getElementById('SCF_SupplierCode').value;
//     var SupplierName=document.getElementById('SCF_SupplierName').value;
//     var BranchName=document.getElementById('SCF_Branch').value;
//     var DocEntry=document.getElementById('SCF_CollDocEntry').value;
//     var BPL_Id=document.getElementById('SCF_BPLId').value;

//     var SampleQuantity=document.getElementById('SCF_SampleQty').value; // sample Qty Value get Here

//     var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

//     $.ajax({
//         type: "POST",
//         url: 'ajax/common-ajax.php',
//         data: dataString,
//         cache: false,

//         beforeSend: function(){
//             // Show image container
//             $(".loader123").show();
//         },
//         success: function(result)
//         {   
//             $('#gi_SupplierCode').val(SupplierCode);
//             $('#gi_SupplierName').val(SupplierName);
//             $('#gi_BranchName').val(BranchName);
//             $('#gi_DocEntry').val(DocEntry);
//             $('#gi_BPL_Id').val(BPL_Id);

//             $('#gi_BaseDocType').val('SCS_SCOL');
//             // console.log(result);

//             var JSONObject = JSON.parse(result);
//             $('#GoodsIssueItemAppend').html(JSONObject);

//             //Item Quantity Recalculate according sample quantity start here -------------------
//                 $('#itP_BQty').val(SampleQuantity);
//             //Item Quantity Recalculate according sample quantity end here --------------------- 

//             getSeriesDropdownForGoodsIssue() // DocName By using API to get dropdown 
//             goodsIssueContainerSelection() // get Container Selection Table List
//         },
//         complete:function(data){
//             // Hide image container
//             $(".loader123").hide();
//         }
//     }); 
// }

function getSeriesDropdownForGoodsIssue()
{
var dataString ='ObjectCode=60&action=getSeriesDropdown_ajax';

$.ajax({
type: "POST",
url: 'ajax/common-ajax.php',
data: dataString,
cache: false,

beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
var SeriesDropdown = JSON.parse(result);
$('#GI_DocNoName').html(SeriesDropdown);
selectedSeriesForGoodsIssue(); // call Selected Series Single data function
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}

function selectedSeriesForGoodsIssue(){

var Series=document.getElementById('GI_DocNoName').value;
var dataString ='Series='+Series+'&ObjectCode=60&action=getSeriesSingleData_ajax';

$.ajax({
type: "POST",
url: 'ajax/common-ajax.php',
data: dataString,
cache: false,

beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
var JSONObject = JSON.parse(result);

var NextNumber=JSONObject[0]['NextNumber'];
var Series=JSONObject[0]['Series'];

$('#GI_series').val(Series);
$('#GI_NextNumber').val(NextNumber);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}

function getSeriesDropdown()
{
var dataString ='ObjectCode=67&action=getSeriesDropdown_ajax';

$.ajax({
type: "POST",
url: 'ajax/common-ajax.php',
data: dataString,
cache: false,

beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
var SeriesDropdown = JSON.parse(result);
$('#SCRTQC_it_DocNoName').html(SeriesDropdown);
$('#GI_DocNoName').html(SeriesDropdown);

selectedSeries(); // call Selected Series Single data function
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}

function selectedSeries(){

var Series=document.getElementById('SCRTQC_it_DocNoName').value;
var dataString ='Series='+Series+'&ObjectCode=67&action=getSeriesSingleData_ajax';

$.ajax({
type: "POST",
url: 'ajax/common-ajax.php',
data: dataString,
cache: false,

beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
// console.log('selected Series=>', result);
var JSONObject = JSON.parse(result);

var NextNumber=JSONObject[0]['NextNumber'];
var Series=JSONObject[0]['Series'];

$('#SCRTQC_it_DocNo').val(Series);
$('#GI_series').val(Series);
$('#SCRTQC_it_NextNumber').val(NextNumber);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}



//  function goodsIssueContainerSelection(){
//     var GRPODEnt=document.getElementById('U_GRPODEnt').value;
//     var BNo=document.getElementById('U_BNo').value;
//     var ItemCode=document.getElementById('itP_ItemCode').value;
//     var FromWhs=document.getElementById('itP_FromWhs').value;

//     var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=SC_OpenInventoryTransferGI_ajax';

//     $.ajax({
//         type: "POST",
//         url: 'ajax/common-ajax.php',
//         data: dataString,
//         cache: false,

//         beforeSend: function(){
//             // Show image container
//             $(".loader123").show();
//         },
//         success: function(result)
//         {
//             // console.log(result);
//             var JSONObject = JSON.parse(result);
//             $('#GoodsIssueContainerSelectionItemAppend').html(JSONObject);
//         },
//         complete:function(data){
//             // Hide image container
//             $(".loader123").hide();
//         }
//     }); 
// }

function ContainerSelection(){
var GRPODEnt=document.getElementById('SCRTQC_it_BaseDocNum').value;
var BNo=document.getElementById('SCRTQCB_BatchNo').value;
var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerHTML;
var FromWhs=document.getElementById('SCRTQC_it_IL_FromWhs').innerHTML;

var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=SC_OpenInventoryTransferCS_ajax';

$.ajax({
type: "POST",
url: 'ajax/common-ajax.php',
data: dataString,
cache: false,
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
// console.log(result);
var JSONObject = JSON.parse(result);
$('#ContainerSelectionItemAppend').html(JSONObject);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}


function ContainerSelection_sample_issue(){

var GRPODEnt=document.getElementById('GI_BaseDocNum').value;
var BNo=document.getElementById('SCRTQCB_BatchNo').value;
var ItemCode=document.getElementById('GI_item_code').value;
var FromWhs=document.getElementById('GI_from_whs').value;

var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=kri_SC_OpenInventoryTransferCS_sample_issue_ajax';

$.ajax({
type: "POST",
url: 'ajax/kri_common-ajax.php',
data: dataString,
cache: false,
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result){
// console.log(result);
var JSONObject = JSON.parse(result);
$('#ContainerSelectionItemAppendSampleIssue').html(JSONObject);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}



// function getSelectedContenerGI_Manual(un_id){
//     //Create an Array.
//     var selected = new Array();

//     //Reference the Table.
//     var tblFruits = document.getElementById("ContainerSelectionTableGI");

//     //Reference all the CheckBoxes in Table.
//     var chks = tblFruits.getElementsByTagName("INPUT");

//     // Loop and push the checked CheckBox value in Array.
//     for (var i = 0; i < chks.length; i++) {
//         if (chks[i].checked) {
//             selected.push(chks[i].value);
//         }
//     }
//         // console.log('selected=>', selected);

//     // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
//         const array = selected;
//         let sum = 0;

//         for (let i = 0; i < array.length; i++) {
//             sum += parseFloat(array[i]);

//         }
//         // console.log('sum=>', sum);
//         document.getElementById("csgi_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
//     // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
// }

// function getSelectedContenerGI(un_id){
//     //Create an Array.
//     var selected = new Array();

//     //Reference the Table.
//     var tblFruits = document.getElementById("ContainerSelectionTableGI");

//     //Reference all the CheckBoxes in Table.
//     var chks = tblFruits.getElementsByTagName("INPUT");

//     // Loop and push the checked CheckBox value in Array.
//     for (var i = 0; i < chks.length; i++) {
//         if (chks[i].checked) {
//             selected.push(chks[i].value);
//         }
//     }
//         // console.log('selected=>', selected);

//     // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
//         const array = selected;
//         let sum = 0;

//         for (let i = 0; i < array.length; i++) {
//             sum += parseFloat(array[i]);

//         }
//         // console.log('sum=>', sum);
//         document.getElementById("csgi_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
//     // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

//     // <!-- --------------------- when user select checkbox update flag start here -------------- -->
//         var usercheckListVal=document.getElementById('gi_usercheckList'+un_id).value;

//         if(usercheckListVal=='0'){
//             $(`#gi_usercheckList`+un_id).val('1');
//         }else{
//             $(`#gi_usercheckList`+un_id).val('0');
//         }
//     // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
// }

function getSelectedContener_goodsIssue(un_id){
//Create an Array.
var selected = new Array();

//Reference the Table.
var tblFruits = document.getElementById("ContainerSelectionItemAppendSampleIssue");

//Reference all the CheckBoxes in Table.
var chks = tblFruits.getElementsByTagName("INPUT");

// Loop and push the checked CheckBox value in Array.
for (var i = 0; i < chks.length; i++) {
if (chks[i].checked) {
selected.push(chks[i].value);
}
}
// console.log('selected=>', selected);

// <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
const array = selected;
let sum = 0;

for (let i = 0; i < array.length; i++) {
sum += parseFloat(array[i]);

}
// console.log('sum=>', sum);
document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
// <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

// <!-- --------------------- when user select checkbox update flag start here -------------- -->
var usercheckListVal=document.getElementById('usercheckList'+un_id).value;

if(usercheckListVal=='0'){
$(`#usercheckList`+un_id).val('1');
}else{
$(`#usercheckList`+un_id).val('0');
}
// <!-- --------------------- when user select checkbox update flag End here ---------------- -->
}



function getSelectedContener(un_id){
//Create an Array.
var selected = new Array();

//Reference the Table.
var tblFruits = document.getElementById("ContainerSelectionTable");

//Reference all the CheckBoxes in Table.
var chks = tblFruits.getElementsByTagName("INPUT");

// Loop and push the checked CheckBox value in Array.
for (var i = 0; i < chks.length; i++) {
if (chks[i].checked) {
selected.push(chks[i].value);
}
}
// console.log('selected=>', selected);

// <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
const array = selected;
let sum = 0;

for (let i = 0; i < array.length; i++) {
sum += parseFloat(array[i]);

}
// console.log('sum=>', sum);
document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
// <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

// <!-- --------------------- when user select checkbox update flag start here -------------- -->
var usercheckListVal=document.getElementById('usercheckList'+un_id).value;

if(usercheckListVal=='0'){
$(`#usercheckList`+un_id).val('1');
}else{
$(`#usercheckList`+un_id).val('0');
}
// <!-- --------------------- when user select checkbox update flag End here ---------------- -->
}

// function EnterQtyValidation_GI(un_id) {
//     var BatchQty=document.getElementById('gip_BatchQty'+un_id).value;
//     var SelectedQty=document.getElementById('gip_SelectedQty'+un_id).value;

//     if(SelectedQty!=''){

//         if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){
//         // if(SelectedQty<=BatchQty){
//             $('#gip_SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
//             $('#gip_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

//             getSelectedContenerGI_Manual(un_id); // if user change selected Qty value after selection 
//         }else{
//             $('#gip_SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
//             swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
//         }

//     }else{
//         $('#gip_SelectedQty'+un_id).val(BatchQty); // if user enter blank val
//         swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error");
//     }
// }

function EnterQtyValidation(un_id) {
var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

if(SelectedQty!=''){

if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){
$('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
$('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
}else{
$('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
$('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); // same value set on checkbox value
swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
}

}else{
$('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val
$('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); // same value set on checkbox value
swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error");
}

getSelectedContener(un_id); // if user change selected Qty value after selection 
}

// function ContainerAllCalculation(){
//     //Create an Array.
//     var selected = new Array();

//     //Reference the Table.
//     var tblFruits = document.getElementById("ContainerSelectionTable");

//     //Reference all the CheckBoxes in Table.
//     var chks = tblFruits.getElementsByTagName("INPUT");

//     // Loop and push the checked CheckBox value in Array.
//     for (var i = 0; i < chks.length; i++) {
//         if (chks[i].checked) {
//             selected.push(chks[i].value);
//         }
//     }
//         // console.log('selected=>', selected);

//     // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
//         const array = selected;
//         let sum = 0;

//         for (let i = 0; i < array.length; i++) {
//             sum += parseFloat(array[i]);

//         }
//         // console.log('sum=>', sum);
//         document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
//     // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

//     // <!-- --------------------- when user select checkbox update flag start here -------------- -->
//         // var usercheckListVal=document.getElementById('usercheckList'+un_id).value;

//         // if(usercheckListVal=='0'){
//         //     $(`#usercheckList`+un_id).val('1');
//         // }else{
//         //     $(`#usercheckList`+un_id).val('0');
//         // }
//     // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
// }

function SubmitInventoryTransfer(){

var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
// var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
var PostingDate=document.getElementById('it_PostingDate').value;
var DocDate=document.getElementById('it_DocDate').value;
var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerText;
var ItemName=document.getElementById('SCRTQC_it_IL_ItemName').innerText;
var item_BQty=parseFloat(document.getElementById('SCRTQC_it_IL_Quantity').innerText).toFixed(6);  // item available Qty
var fromWhs=document.getElementById('SCRTQC_it_IL_FromWhs').innerText;
var ToWhs=document.getElementById('SCRTQC_it_IL_ToWhs').innerText;
var Location=document.getElementById('SCRTQC_it_IL_Location').innerText;

// var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerText;
// var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerText;
// console.log('selectedQtySum=>',selectedQtySum);
// console.log('item_BQty=>',item_BQty);
// console.log('PostingDate=>',PostingDate);
// console.log('DocDate=>',DocDate);
// console.log('ToWhs=>',ToWhs);
// console.log('fromWhs=>',fromWhs);

if(selectedQtySum==item_BQty){ // Container selection Qty validation

if(ToWhs!=''){ // Item level To Warehouse validation

if(PostingDate!=''){ // Posting Date validation

if(DocDate!=''){ // Document Date validation

// <!-- ---------------- form submit process start here ----------------- -->
var formData = new FormData($('#inventory_transfer_form')[0]); 
formData.append("SubIT_Btn_SCRT",'SubIT_Btn'); 

formData.append("cs_selectedQtySum",selectedQtySum);
formData.append("SCRTQC_it_IL_Quantity",item_BQty);
formData.append("it_PostingDate",PostingDate);

formData.append("it_DocDate",DocDate);
formData.append("SCRTQC_it_IL_ToWhs",ToWhs);
formData.append("SCRTQC_it_IL_FromWhs",fromWhs);

formData.append("SCRTQC_ItemCode",ItemCode);
formData.append("ItemName",ItemName);

// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);
// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);

var error = true;

if(error)
{
$.ajax({
url: 'ajax/kri_common-ajax.php',
type: "POST",
data:formData,
processData: false,
contentType: false,
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
// console.log(result);
var JSONObject = JSON.parse(result);
console.log(JSONObject);

var status = JSONObject['status'];
var message = JSONObject['message'];
var DocEntry = JSONObject['DocEntry'];
if(status=='True'){
    swal({
      title: `${DocEntry}`,
      text: `${message}`,
      icon: "success",
      buttons: true,
      dangerMode: false,
    })
    .then((willDelete) => {
        if (willDelete) {
            location.replace(window.location.href); //ok btn... cuurent URL called
        }else{
            location.replace(window.location.href); // cancel btn... cuurent URL called
        }
    });
}else{
    swal("Oops!", `${message}`, "error");
}
}
,complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}
// <!-- ---------------- form submit process end here ------------------- -->
}else{
swal("Oops!", "Please Select A Document Date.", "error");
}

}else{
swal("Oops!", "Please Select A Posting Date.", "error");
}
}else{
swal("Oops!", "To Warehouse Mandatory.", "error");
}

}else{
swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
}
}




function SubmitInventoryTransfer_sample_issue(){

var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
// var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
var PostingDate=document.getElementById('GI_postingDate').value;
var DocDate=document.getElementById('GI_DocumentDate').value;
var ItemCode=document.getElementById('GI_item_code').value;
var ItemName=document.getElementById('GI_item_name').value;
var item_BQty=parseFloat(document.getElementById('GI_quatility').value).toFixed(6);  // item available Qty
var fromWhs=document.getElementById('GI_from_whs').value;
var ToWhs=document.getElementById('GI_to_whs').value;
var Location=document.getElementById('GI_Location').value;

// var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerText;
// var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerText;
// console.log('selectedQtySum=>',selectedQtySum);
// console.log('item_BQty=>',item_BQty);
// console.log('PostingDate=>',PostingDate);
// console.log('DocDate=>',DocDate);
// console.log('ToWhs=>',ToWhs);
// console.log('fromWhs=>',fromWhs);

if(selectedQtySum==item_BQty){ // Container selection Qty validation

if(ToWhs!=''){ // Item level To Warehouse validation

if(PostingDate!=''){ // Posting Date validation

if(DocDate!=''){ // Document Date validation

// <!-- ---------------- form submit process start here ----------------- -->
var formData = new FormData($('#inventory_transfer_form_issue_sample')[0]); 
formData.append("SubIT_Btn_SCRT_sample_issue",'SubIT_Btn_sampleIssue'); 

// formData.append("cs_selectedQtySum",selectedQtySum);
// formData.append("SCRTQC_it_IL_Quantity",item_BQty);
// formData.append("it_PostingDate",PostingDate);

// formData.append("it_DocDate",DocDate);
// formData.append("SCRTQC_it_IL_ToWhs",ToWhs);
// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);

// formData.append("SCRTQC_ItemCode",ItemCode);
// formData.append("ItemName",ItemName);

// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);
// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);

var error = true;

if(error)
{
$.ajax({
url: 'ajax/kri_common-ajax.php',
type: "POST",
data:formData,
processData: false,
contentType: false,
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
console.log(result);
var JSONObject = JSON.parse(result);
console.log(JSONObject);

var status = JSONObject['status'];
var message = JSONObject['message'];
var DocEntry = JSONObject['DocEntry'];
if(status=='True'){
    swal({
      title: `${DocEntry}`,
      text: `${message}`,
      icon: "success",
      buttons: true,
      dangerMode: false,
    })
    .then((willDelete) => {
        if (willDelete) {
            location.replace(window.location.href); //ok btn... cuurent URL called
        }else{
            location.replace(window.location.href); // cancel btn... cuurent URL called
        }
    });
}else{
    swal("Oops!", `${message}`, "error");
}
}
,complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}
// <!-- ---------------- form submit process end here ------------------- -->
}else{
swal("Oops!", "Please Select A Document Date.", "error");
}

}else{
swal("Oops!", "Please Select A Posting Date.", "error");
}
}else{
swal("Oops!", "To Warehouse Mandatory.", "error");
}

}else{
swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
}
}



function SubmitInventoryTransfer_trnasfer(){

var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
// var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
var PostingDate=document.getElementById('it_PostingDate_tras').value;
var DocDate=document.getElementById('it_DocDate_trans').value;
var ItemCode=document.getElementById('transfer_it_IL_ItemCode').innerText;
var ItemName=document.getElementById('transfer_it_IL_ItemName').innerText;
var item_BQty=parseFloat(document.getElementById('transfer_it_IL_Quantity').innerText).toFixed(6);  // item available Qty
var fromWhs=document.getElementById('transfer_it_IL_FromWhs').innerText;
var ToWhs=document.getElementById('transfer_it_IL_ToWhs').innerText;
var Location=document.getElementById('transfer_it_IL_Location').innerText;

// var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerText;
// var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerText;
// console.log('selectedQtySum=>',selectedQtySum);
// console.log('item_BQty=>',item_BQty);
// console.log('PostingDate=>',PostingDate);
// console.log('DocDate=>',DocDate);
// console.log('ToWhs=>',ToWhs);
// console.log('fromWhs=>',fromWhs);

if(selectedQtySum==item_BQty){ // Container selection Qty validation

if(ToWhs!=''){ // Item level To Warehouse validation

if(PostingDate!=''){ // Posting Date validation

if(DocDate!=''){ // Document Date validation

// <!-- ---------------- form submit process start here ----------------- -->
var formData = new FormData($('#inventory_transfer_form_transfer')[0]); 
formData.append("SubIT_Btn_SCRT_transfer",'SubIT_Btn'); 

formData.append("cs_selectedQtySum",selectedQtySum);
formData.append("transfer_it_IL_Quantity",item_BQty);
formData.append("it_PostingDate",PostingDate);

formData.append("it_DocDate",DocDate);
formData.append("transfer_it_IL_ToWhs",ToWhs);
formData.append("transfer_it_IL_FromWhs",fromWhs);

formData.append("transfer_it_IL_ItemCode",ItemCode);
formData.append("ItemName",ItemName);

// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);
// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);

var error = true;

if(error)
{
$.ajax({
url: 'ajax/kri_common-ajax.php',
type: "POST",
data:formData,
processData: false,
contentType: false,
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
// console.log(result);
var JSONObject = JSON.parse(result);
console.log(JSONObject);

var status = JSONObject['status'];
var message = JSONObject['message'];
var DocEntry = JSONObject['DocEntry'];
if(status=='True'){
    swal({
      title: `${DocEntry}`,
      text: `${message}`,
      icon: "success",
      buttons: true,
      dangerMode: false,
    })
    .then((willDelete) => {
        if (willDelete) {
            location.replace(window.location.href); //ok btn... cuurent URL called
        }else{
            location.replace(window.location.href); // cancel btn... cuurent URL called
        }
    });
}else{
    swal("Oops!", `${message}`, "error");
}
}
,complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}
// <!-- ---------------- form submit process end here ------------------- -->
}else{
swal("Oops!", "Please Select A Document Date.", "error");
}

}else{
swal("Oops!", "Please Select A Posting Date.", "error");
}
}else{
swal("Oops!", "To Warehouse Mandatory.", "error");
}

}else{
swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
}
}





function EnterQtyValidation_transfer(un_id) {
var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

if(SelectedQty!=''){

if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){
$('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
$('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
// getSelectedContener(un_id);
}else{
$('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
$('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); // same value set on checkbox value
swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");

}

}else{
$('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val
$('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); // same value set on checkbox value
swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error");
}

getSelectedContenerCalulateManul(); // if user change selected Qty value after selection 
}









// function SubmitSCGI(){

//     var selectedQtySum=document.getElementById('csgi_selectedQtySum').value; // final Qty sum
//     var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
//     var PostingDate=document.getElementById('gi_PostingDate').value;
//     var DocDate=document.getElementById('gi_DocDate').value;
//     var ToWhs=document.getElementById('itP_ToWhs').value;

//     if(selectedQtySum==item_BQty){ // Container selection Qty validation

//         if(ToWhs!=''){ // Item level To Warehouse validation

//             if(PostingDate!=''){ // Posting Date validation

//                 if(DocDate!=''){ // Document Date validation

//                 // <!-- ---------------- form submit process start here ----------------- -->
//                     var formData = new FormData($('#SCGI_popup_form')[0]); // form Id
//                     formData.append("SubGI_Btn",'SubGI_Btn'); // submit btn Id
//                     var error = true;

//                     if(error)
//                     {
//                         $.ajax({
//                             url: 'ajax/common-ajax.php',
//                             type: "POST",
//                             data:formData,
//                             processData: false,
//                             contentType: false,
//                             beforeSend: function(){
//                                 // Show image container
//                                 $(".loader123").show();
//                             },
//                             success: function(result)
//                             {
//                                 // console.log(result);
//                                 var JSONObject = JSON.parse(result);
//                                 console.log(JSONObject);

//                                 var status = JSONObject['status'];
//                                 var message = JSONObject['message'];
//                                 var DocEntry = JSONObject['DocEntry'];
//                                 if(status=='True'){
//                                     swal({
//                                       title: `${DocEntry}`,
//                                       text: `${message}`,
//                                       icon: "success",
//                                       buttons: true,
//                                       dangerMode: false,
//                                     })
//                                     .then((willDelete) => {
//                                         if (willDelete) {
//                                             location.replace(window.location.href); //ok btn... cuurent URL called
//                                         }else{
//                                             location.replace(window.location.href); // cancel btn... cuurent URL called
//                                         }
//                                     });
//                                 }else{
//                                     swal("Oops!", `${message}`, "error");
//                                 }
//                             },complete:function(data){
//                                 // Hide image container
//                                 $(".loader123").hide();
//                             }
//                         });
//                     }
//                 // <!-- ---------------- form submit process end here ------------------- -->
//                 }else{
//                     swal("Oops!", "Please Select A Document Date.", "error");
//                 }

//             }else{
//                 swal("Oops!", "Please Select A Posting Date.", "error");
//             }
//         }else{
//             swal("Oops!", "To Warehouse Mandatory.", "error");
//         }

//     }else{
//         swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
//     }
// }

// function OnclickReverseSampleIssue(){

//     var DocEntry=document.getElementById('SC_SCD_SampleIssue').value;

//     var dataString ='DocEntry='+DocEntry+'&action=SCReverseSampleIsuue_ajax';

//     $.ajax({
//         type: "POST",
//         url: 'ajax/common-ajax.php',
//         data: dataString,
//         cache: false,

//         beforeSend: function(){
//             // Show image container
//             $(".loader123").show();
//         },
//         success: function(result)
//         {
//             console.log(result);
//             var JSONObject = JSON.parse(result);

//             var status = JSONObject['status'];
//             var message = JSONObject['message'];
//             var DocEntry = JSONObject['DocEntry'];
//             if(status=='True'){
//                 swal({
//                   title: `${DocEntry}`,
//                   text: `${message}`,
//                   icon: "success",
//                   buttons: true,
//                   dangerMode: false,
//                 })
//                 .then((willDelete) => {
//                     if (willDelete) {
//                         location.replace(window.location.href); //ok btn... cuurent URL called
//                     }else{
//                         location.replace(window.location.href); // cancel btn... cuurent URL called
//                     }
//                 });
//             }else{
//                 swal("Oops!", `${message}`, "error");
//             }
//         },
//         complete:function(data){
//             // Hide image container
//             $(".loader123").hide();
//         }
//     }); 
// }

    function SampleCollectionRetestQCUpdateForm()
    {
        var formData = new FormData($('#SampleCollectionRetestQCUpdateForm')[0]); // form Id
        formData.append("SampleCollectionRetestQCUpdateForm_Btn",'SampleCollectionRetestQCUpdateForm_Btn'); // submit btn Id

        var error = true;

        if(error)
        {
            $.ajax({
                url: 'ajax/kri_common-ajax.php',
                type: "POST",
                data:formData,
                processData: false,
                contentType: false,
                // beforeSend: function(){
                // // Show image container
                // $(".loader123").show();
                // },
                success: function(result)
                {
                    console.log(result);
                    // var JSONObject = JSON.parse(result);

                    // var status = JSONObject['status'];
                    // var message = JSONObject['message'];
                    // var DocEntry = JSONObject['DocEntry'];

                    // if(status=='True'){
                    //     swal({
                    //         title: `${DocEntry}`,
                    //         text: `${message}`,
                    //         icon: "success",
                    //         buttons: true,
                    //         dangerMode: false,
                    //     })
                    //     .then((willDelete) => {
                    //         if (willDelete) {
                    //             location.replace(window.location.href); //ok btn... cuurent URL called
                    //         }else{
                    //             location.replace(window.location.href); // cancel btn... cuurent URL called
                    //         }
                    //     });
                    // }else{
                    //     swal("Oops!", `${message}`, "error");
                    // }
                }
                // ,complete:function(data){
                // // Hide image container
                // $(".loader123").hide();
                // }
            });
        }   
    }



function OnclickReverseSampleIssue(){
// SCRTQCB_SCD_SampleIssue
var DocEntry=document.getElementById('SCRTQCB_SCD_SampleIssue').value;
var SCRTQCB_DocEntry=document.getElementById('SCRTQCB_DocEntry').value;
var dataString ='DocEntry='+DocEntry+'&SCRTQCB_DocEntry='+SCRTQCB_DocEntry+'&action=SCRetestQcReverseSampleIsuue_ajax';

$.ajax({
type: "POST",
url: 'ajax/kri_common-ajax.php',
data: dataString,
cache: false,

beforeSend: function(){
$(".loader123").show();
},
success: function(result)
{
var JSONObject = JSON.parse(result);
var status = JSONObject['status'];
var message = JSONObject['message'];
var DocEntry = JSONObject['DocEntry'];
if(status=='True'){
swal({
title: `${DocEntry}`,
text: `${message}`,
icon: "success",
buttons: true,
dangerMode: false,
})
.then((willDelete) => {
if (willDelete) {
location.replace(window.location.href); //ok btn... cuurent URL called
}else{
location.replace(window.location.href); // cancel btn... cuurent URL called
}
});
}else{
swal("Oops!", `${message}`, "error");
}
},
complete:function(data){
$(".loader123").hide();
}
}); 
}





// function reverseSampleIssue(){

//     var formData = new FormData($('#SampleCollectionRetestQCUpdateForm')[0]); // form Id
//     formData.append("SCRTQCB_SCD_RevSampleIssue_Btn",'SCRTQCB_SCD_RevSampleIssue_Btn'); // submit 
//     var error = true;
// // name="SampleCollectionRetestQCUpdateForm_Btn"
//     if(error)
//     {
//         $.ajax({
//             url: 'ajax/kri_common-ajax.php',
//             type: "POST",
//             data:formData,
//             processData: false,
//             contentType: false,
//             beforeSend: function(){
//                 $(".loader123").show();
//             },
//             success: function(result)
//             {
//             //     var JSONObject = JSON.parse(result);
//             //     var status = JSONObject['status'];
//             //     var message = JSONObject['message'];
//             //     var DocEntry = JSONObject['DocEntry'];
//             //     if(status=='True'){
//             //         swal({
//             //             title: `${DocEntry}`,
//             //             text: `${message}`,
//             //             icon: "success",
//             //             buttons: true,
//             //             dangerMode: false,
//             //         })
//             //         .then((willDelete) => {
//             //             if (willDelete) {
//             //                 location.replace(window.location.href); //ok btn... cuurent URL called
//             //             }else{
//             //                 location.replace(window.location.href); // cancel btn... cuurent URL called
//             //             }
//             //         });
//             //     }else{
//             //         swal("Oops!", `${message}`, "error");
//             //     }
//             // },complete:function(data){
//             //     // Hide image container
//             //     $(".loader123").hide();
//              }
//         });
//     } 


// }

// function selectedExternalIssue(un_id){
//     $('#RowLevelSelectedExternalIssue').val(un_id);
//     document.getElementById("SC_ExternalIssue_PEI_Btn").disabled = false;
// }

// function selectedExtraIssue(un_id){
//     $('#RowLevelSelectedExtraIssue').val(un_id);
//     document.getElementById("SC_ExtraIssue_PEI_Btn").disabled = false;
// }



function getSeriesDropdown_transfer()
{
var dataString ='ObjectCode=67&action=getSeriesDropdown_ajax';

$.ajax({
type: "POST",
url: 'ajax/common-ajax.php',
data: dataString,
cache: false,

beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
var SeriesDropdown = JSON.parse(result);
$('#transfer_it_DocNoName').html(SeriesDropdown);
$('#GI_DocNoName').html(SeriesDropdown);

selectedSeries_transfer(); // call Selected Series Single data function
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}

function selectedSeries_transfer(){

var Series=document.getElementById('transfer_it_DocNoName').value;
var dataString ='Series='+Series+'&ObjectCode=67&action=getSeriesSingleData_ajax';

$.ajax({
type: "POST",
url: 'ajax/common-ajax.php',
data: dataString,
cache: false,

beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
// console.log('selected Series=>', result);
var JSONObject = JSON.parse(result);

var NextNumber=JSONObject[0]['NextNumber'];
var Series=JSONObject[0]['Series'];

$('#transfer_it_DocNo').val(Series);
$('#GI_series').val(Series);
$('#transfer_it_NextNumber').val(NextNumber);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}




function transferExternalExtra()
{
var SupplierCode=document.getElementById('SCRTQCB_SupplierCode').value;
var SupplierName=document.getElementById('SCRTQCB_SupplierName').value;
var BranchName=document.getElementById('SCRTQCB_Branch').value;
var DocEntry=document.getElementById('SCRTQCB_DocEntry').value;

// <!-- ---------- Item Level data get start here ------------- -->
var ItemCode=document.getElementById('SCRTQCB_ItemCode').value;
var ItemName=document.getElementById('SCRTQCB_ItemName').value;
var Location=document.getElementById('SCRTQCB_Location').value;
var RISSFromWhs=document.getElementById('SCRTQCB_RISSFromWhs').value;
var RISSToWhs=document.getElementById('SCRTQCB_RISSToWhs').value;
var RetainQtyUom=document.getElementById('SCRTQCB_RetainQtyUom').value;

var BatchQty=document.getElementById('SCRTQCB_BatchQty').value;
var SampleQty=document.getElementById('SCRTQCB_SampleQty').value;
var BatchQty_itemLevel=(parseFloat(BatchQty)-parseFloat(SampleQty)).toFixed(6);
// <!-- ---------- Item Level data get end here --------------- -->
var SCRTQCB_BPLId=document.getElementById('SCRTQCB_BPLId').value;




// var SampleQuantity=document.getElementById('SCF_SampleQty').value;

// var hideToware="1";

//var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

// $.ajax({
//     type: "POST",
//     url: 'ajax/common-ajax.php',
//     // data: dataString,
//     cache: false,

//     // beforeSend: function(){
//     //     // Show image container
//     //     $(".loader123").show();
//     // },
//     success: function(result)
//     {   
// $("#hideToWhs").hide();
$('#transfer_it_supplierCode').val(SupplierCode);
$('#transfer_it_supplierName').val(SupplierName);
$('#transfer_it_Branch').val(BranchName);
$('#transfer_it_BaseDocNum').val(DocEntry);
$('#transfer_it_BaseDocType').val('SCS_SCRETEST');
$('#_transfer_BPLId').val(SCRTQCB_BPLId);
$('#transfer_it_SCRTQCB_DocEntry').val(DocEntry);


// -------- item level set data start -------------------
$('#transfer_it_IL_ItemCode').html(ItemCode);
$('#transfer_it_IL_ItemName').html(ItemName);
$('#transfer_it_IL_Quantity').html(BatchQty_itemLevel);
$('#transfer_it_IL_FromWhs').html(RISSFromWhs);
$('#transfer_it_IL_ToWhs').html(RISSToWhs);
$('#transfer_it_IL_Location').html(Location);
$('#transfer_it_IL_UOM').html(RetainQtyUom);
// -------- item level set data end ---------------------

getSeriesDropdown_transfer() // DocName By using API to get dropdown 
ContainerSelection_transfer() // get Container Selection Table List

}



function ContainerSelection_transfer(){
var GRPODEnt=document.getElementById('transfer_it_BaseDocNum').value;
var BNo=document.getElementById('SCRTQCB_BatchNo').value;
var ItemCode=document.getElementById('transfer_it_IL_ItemCode').innerHTML;
var FromWhs=document.getElementById('transfer_it_IL_FromWhs').innerHTML;

var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=SC_OpenInventoryTransferCS_ajax_trnsfer';

$.ajax({
type: "POST",
url: 'ajax/kri_common-ajax.php',
data: dataString,
cache: false,
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
// console.log(result);
var JSONObject = JSON.parse(result);
$('#ContainerSelectionItemAppend_transfer').html(JSONObject);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}

function getSelectedContenerCalulateManul(){
//Create an Array.
var selected = new Array();

//Reference the Table.
var tblFruits = document.getElementById("ContainerSelectionTable_transfer");

//Reference all the CheckBoxes in Table.
var chks = tblFruits.getElementsByTagName("INPUT");

// Loop and push the checked CheckBox value in Array.
for (var i = 0; i < chks.length; i++) {
if (chks[i].checked) {
selected.push(chks[i].value);
}
}
// console.log('selected=>', selected);

// <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
const array = selected;
let sum = 0;

for (let i = 0; i < array.length; i++) {
sum += parseFloat(array[i]);

}
// console.log('sum=>', sum);
document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
// <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
}


function getSelectedContener(un_id){
//Create an Array.
var selected = new Array();

//Reference the Table.
var tblFruits = document.getElementById("ContainerSelectionTable_transfer");

//Reference all the CheckBoxes in Table.
var chks = tblFruits.getElementsByTagName("INPUT");

// Loop and push the checked CheckBox value in Array.
for (var i = 0; i < chks.length; i++) {
if (chks[i].checked) {
selected.push(chks[i].value);
}
}
// console.log('selected=>', selected);

// <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
const array = selected;
let sum = 0;

for (let i = 0; i < array.length; i++) {
sum += parseFloat(array[i]);

}
// console.log('sum=>', sum);
document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
// <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

// <!-- --------------------- when user select checkbox update flag start here -------------- -->
var usercheckListVal=document.getElementById('usercheckList'+un_id).value;

if(usercheckListVal=='0'){
$(`#usercheckList`+un_id).val('1');
}else{
$(`#usercheckList`+un_id).val('0');
}

// <!-- --------------------- when user select checkbox update flag End here ---------------- -->
}



function postExtraIssue(){

var SupplierCode=document.getElementById('SCRTQCB_SupplierCode').value;
var SupplierName=document.getElementById('SCRTQCB_SupplierName').value;
var BranchName=document.getElementById('SCRTQCB_Branch').value;
var DocEntry=document.getElementById('SCRTQCB_DocEntry').value;
// <!-- ---------- Item Level data get start here ------------- -->
var ItemCode=document.getElementById('SCRTQCB_ItemCode').value;
var ItemName=document.getElementById('SCRTQCB_ItemName').value;
var Location=document.getElementById('SCRTQCB_Location').value;
var RISSFromWhs=document.getElementById('SCRTQCB_RISSFromWhs').value;
var RISSToWhs=document.getElementById('SCRTQCB_RISSToWhs').value;
var RetainQtyUom=document.getElementById('SCRTQCB_RetainQtyUom').value;

var BatchQty=document.getElementById('SCRTQCB_BatchQty').value;
var SampleQty=document.getElementById('SCRTQCB_SampleQty').value;
var BatchQty_itemLevel=(parseFloat(BatchQty)-parseFloat(SampleQty)).toFixed(6);
// <!-- ---------- Item Level data get end here --------------- -->
var SCRTQCB_BPLId=document.getElementById('SCRTQCB_BPLId').value;


// $("#hideToWhs").hide();
$('#extraIssue_supplierCode').val(SupplierCode);
// $('#SCRTQC_it_supplierName').val(SupplierName);
$('#extraIssue_branch').val(BranchName);
$('#extraIssue_baseDocType').val('SCS_QCRETEST');
$('#extraIssue_BaseDocNum').val(DocEntry);

$('#extraIssue_BPLId_samIss').val(SCRTQCB_BPLId);

$('#extraIssue_GI_SCRTQCB_DocEntry').val(DocEntry);
// -------- item level set data start -------------------
$('#extraIssue_item_code').val(ItemCode);
$('#extraIssue_item_name').val(ItemName);
$('#extraIssue_quatility').val(BatchQty_itemLevel);
$('#extraIssue_from_whs').val(RISSFromWhs);
$('#extraIssue_to_whs').val(RISSToWhs);
$('#extraIssue_Location').val(Location);
$('#extraIssue_uom').val(RetainQtyUom);
// -------- item level set data end ---------------------

getSeriesDropdownForPostExtraIssue() // DocName By using API to get dropdown 
// ContainerSelection() // get Container Selection Table List
ContainerSelection_extra_issue();


}



function SubmitInventoryTransfer_extra_issue(){

var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
// var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
var PostingDate=document.getElementById('extraIssue_postingDate').value;
var DocDate=document.getElementById('extraIssue_DocumentDate').value;
var ItemCode=document.getElementById('extraIssue_item_code').value;
var ItemName=document.getElementById('extraIssue_item_name').value;
var item_BQty=parseFloat(document.getElementById('extraIssue_quatility').value).toFixed(6);  // item available Qty
var fromWhs=document.getElementById('extraIssue_from_whs').value;
var ToWhs=document.getElementById('extraIssue_to_whs').value;
var Location=document.getElementById('extraIssue_Location').value;

// var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerText;
// var ItemCode=document.getElementById('SCRTQC_it_IL_ItemCode').innerText;
// console.log('selectedQtySum=>',selectedQtySum);
// console.log('item_BQty=>',item_BQty);
// console.log('PostingDate=>',PostingDate);
// console.log('DocDate=>',DocDate);
// console.log('ToWhs=>',ToWhs);
// console.log('fromWhs=>',fromWhs);

if(selectedQtySum==item_BQty){ // Container selection Qty validation

if(ToWhs!=''){ // Item level To Warehouse validation

if(PostingDate!=''){ // Posting Date validation

if(DocDate!=''){ // Document Date validation

// <!-- ---------------- form submit process start here ----------------- -->
var formData = new FormData($('#inventory_transfer_form_extra_sample')[0]); 
formData.append("SubIT_Btn_SCRT_extrA_issue",'SubIT_Btn_extraIssue'); 

// formData.append("cs_selectedQtySum",selectedQtySum);
// formData.append("SCRTQC_it_IL_Quantity",item_BQty);
// formData.append("it_PostingDate",PostingDate);

// formData.append("it_DocDate",DocDate);
// formData.append("SCRTQC_it_IL_ToWhs",ToWhs);
// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);

// formData.append("SCRTQC_ItemCode",ItemCode);
// formData.append("ItemName",ItemName);

// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);
// formData.append("SCRTQC_it_IL_FromWhs",fromWhs);

var error = true;

if(error)
{
$.ajax({
url: 'ajax/kri_common-ajax.php',
type: "POST",
data:formData,
processData: false,
contentType: false,
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
console.log(result);
var JSONObject = JSON.parse(result);
console.log(JSONObject);

var status = JSONObject['status'];
var message = JSONObject['message'];
var DocEntry = JSONObject['DocEntry'];
if(status=='True'){
    swal({
      title: `${DocEntry}`,
      text: `${message}`,
      icon: "success",
      buttons: true,
      dangerMode: false,
    })
    .then((willDelete) => {
        if (willDelete) {
            location.replace(window.location.href); //ok btn... cuurent URL called
        }else{
            location.replace(window.location.href); // cancel btn... cuurent URL called
        }
    });
}else{
    swal("Oops!", `${message}`, "error");
}
}
,complete:function(data){
// Hide image container
$(".loader123").hide();
}
});
}
// <!-- ---------------- form submit process end here ------------------- -->
}else{
swal("Oops!", "Please Select A Document Date.", "error");
}

}else{
swal("Oops!", "Please Select A Posting Date.", "error");
}
}else{
swal("Oops!", "To Warehouse Mandatory.", "error");
}

}else{
swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
}
}






function ContainerSelection_extra_issue(){

var GRPODEnt=document.getElementById('extraIssue_BaseDocNum').value;
var BNo=document.getElementById('SCRTQCB_BatchNo').value;
var ItemCode=document.getElementById('extraIssue_item_code').value;
var FromWhs=document.getElementById('extraIssue_from_whs').value;

var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=kri_SC_OpenInventoryTransferCS_extra_issue_ajax';

$.ajax({
type: "POST",
url: 'ajax/kri_common-ajax.php',
data: dataString,
cache: false,
beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result){
// console.log(result);
var JSONObject = JSON.parse(result);
$('#ContainerSelectionItemAppendSampleIssue_extraissue').html(JSONObject);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}




function getSeriesDropdownForPostExtraIssue()
{
var dataString ='ObjectCode=60&action=getSeriesDropdown_ajax';

$.ajax({
type: "POST",
url: 'ajax/common-ajax.php',
data: dataString,
cache: false,

beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
var SeriesDropdown = JSON.parse(result);
$('#extraIssue_DocNoName').html(SeriesDropdown);
selectedSeriesForGoodsIssue(); // call Selected Series Single data function
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}

function selectedSeriesForGoodsIssue(){

var Series=document.getElementById('extraIssue_DocNoName').value;
var dataString ='Series='+Series+'&ObjectCode=60&action=getSeriesSingleData_ajax';

$.ajax({
type: "POST",
url: 'ajax/common-ajax.php',
data: dataString,
cache: false,

beforeSend: function(){
// Show image container
$(".loader123").show();
},
success: function(result)
{
var JSONObject = JSON.parse(result);

var NextNumber=JSONObject[0]['NextNumber'];
var Series=JSONObject[0]['Series'];

$('#extraIssue_series').val(Series);
$('#extraIssue_NextNumber').val(NextNumber);
},
complete:function(data){
// Hide image container
$(".loader123").hide();
}
}); 
}

function EnterQtyValidation_extraIssue(un_id) {
var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

if(SelectedQty!=''){

if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){
$('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
$('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
}else{
$('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
$('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); // same value set on checkbox value
swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
}

}else{
$('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val
$('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); // same value set on checkbox value
swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error");
}

getSelectedContener_extraIssue_cal(un_id); // if user change selected Qty value after selection 
}



function getSelectedContener_extraIssue_cal(un_id){
//Create an Array.
var selected = new Array();

//Reference the Table.
var tblFruits = document.getElementById("ContainerSelectionItemAppendSampleIssue_extraissue");

//Reference all the CheckBoxes in Table.
var chks = tblFruits.getElementsByTagName("INPUT");

// Loop and push the checked CheckBox value in Array.
for (var i = 0; i < chks.length; i++) {
if (chks[i].checked) {
selected.push(chks[i].value);
}
}
// console.log('selected=>', selected);

// <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
const array = selected;
let sum = 0;

for (let i = 0; i < array.length; i++) {
sum += parseFloat(array[i]);

}
// console.log('sum=>', sum);
document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
// <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

// <!-- --------------------- when user select checkbox update flag start here -------------- -->
var usercheckListVal=document.getElementById('usercheckList'+un_id).value;


// <!-- --------------------- when user select checkbox update flag End here ---------------- -->
}




function getSelectedContener_extraIssue(un_id){
//Create an Array.
var selected = new Array();

//Reference the Table.
var tblFruits = document.getElementById("ContainerSelectionItemAppendSampleIssue_extraissue");

//Reference all the CheckBoxes in Table.
var chks = tblFruits.getElementsByTagName("INPUT");

// Loop and push the checked CheckBox value in Array.
for (var i = 0; i < chks.length; i++) {
if (chks[i].checked) {
selected.push(chks[i].value);
}
}
// console.log('selected=>', selected);

// <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
const array = selected;
let sum = 0;

for (let i = 0; i < array.length; i++) {
sum += parseFloat(array[i]);

}
// console.log('sum=>', sum);
document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
// <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

// <!-- --------------------- when user select checkbox update flag start here -------------- -->
var usercheckListVal=document.getElementById('usercheckList'+un_id).value;

if(usercheckListVal=='0'){
$(`#usercheckList`+un_id).val('1');
}else{
$(`#usercheckList`+un_id).val('0');
}
// <!-- --------------------- when user select checkbox update flag End here ---------------- -->
}






//  function getSelectedContener_extraIssue(un_id){
//     //Create an Array.
//     var selected = new Array();

//     //Reference the Table.
//     var tblFruits = document.getElementById("ContainerSelectionItemAppendSampleIssue");

//     //Reference all the CheckBoxes in Table.
//     var chks = tblFruits.getElementsByTagName("INPUT");

//     // Loop and push the checked CheckBox value in Array.
//     for (var i = 0; i < chks.length; i++) {
//         if (chks[i].checked) {
//             selected.push(chks[i].value);
//         }
//     }
//         // console.log('selected=>', selected);

//     // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
//         const array = selected;
//         let sum = 0;

//         for (let i = 0; i < array.length; i++) {
//             sum += parseFloat(array[i]);

//         }
//         // console.log('sum=>', sum);
//         document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
//     // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

//     // <!-- --------------------- when user select checkbox update flag start here -------------- -->
//         var usercheckListVal=document.getElementById('usercheckList'+un_id).value;

//         if(usercheckListVal=='0'){
//             $(`#usercheckList`+un_id).val('1');
//         }else{
//             $(`#usercheckList`+un_id).val('0');
//         }
//     // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
// }



//  function postExtraIssue()
// {
//     var SupplierCode=document.getElementById('SCRTQCB_SupplierCode').value;
//     var SupplierName=document.getElementById('SCRTQCB_SupplierName').value;
//     var BranchName=document.getElementById('SCRTQCB_Branch').value;
//     var DocEntry=document.getElementById('SCRTQCB_DocEntry').value;

//     // <!-- ---------- Item Level data get start here ------------- -->
//         var ItemCode=document.getElementById('SCRTQCB_ItemCode').value;
//         var ItemName=document.getElementById('SCRTQCB_ItemName').value;
//         var Location=document.getElementById('SCRTQCB_Location').value;
//         var RISSFromWhs=document.getElementById('SCRTQCB_RISSFromWhs').value;
//         var RISSToWhs=document.getElementById('SCRTQCB_RISSToWhs').value;
//         var RetainQtyUom=document.getElementById('SCRTQCB_RetainQtyUom').value;

//         var BatchQty=document.getElementById('SCRTQCB_BatchQty').value;
//         var SampleQty=document.getElementById('SCRTQCB_SampleQty').value;
//         var BatchQty_itemLevel=(parseFloat(BatchQty)-parseFloat(SampleQty)).toFixed(6);
//     // <!-- ---------- Item Level data get end here --------------- -->
//       var SCRTQCB_BPLId=document.getElementById('SCRTQCB_BPLId').value;




//     // var SampleQuantity=document.getElementById('SCF_SampleQty').value;

//     // var hideToware="1";

//     //var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

//     // $.ajax({
//     //     type: "POST",
//     //     url: 'ajax/common-ajax.php',
//     //     // data: dataString,
//     //     cache: false,

//     //     // beforeSend: function(){
//     //     //     // Show image container
//     //     //     $(".loader123").show();
//     //     // },
//     //     success: function(result)
//     //     {   
//             // $("#hideToWhs").hide();
//             $('#transfer_it_supplierCode').val(SupplierCode);
//             $('#transfer_it_supplierName').val(SupplierName);
//             $('#transfer_it_Branch').val(BranchName);
//             $('#transfer_it_BaseDocNum').val(DocEntry);
//             $('#transfer_it_BaseDocType').val('SCS_SCRETEST');
//             $('#_transfer_BPLId').val(SCRTQCB_BPLId);
//             $('#transfer_it_SCRTQCB_DocEntry').val(DocEntry);


//             // -------- item level set data start -------------------
//                 $('#transfer_it_IL_ItemCode').html(ItemCode);
//                 $('#transfer_it_IL_ItemName').html(ItemName);
//                 $('#transfer_it_IL_Quantity').html(BatchQty_itemLevel);
//                 $('#transfer_it_IL_FromWhs').html(RISSFromWhs);
//                 $('#transfer_it_IL_ToWhs').html(RISSToWhs);
//                 $('#transfer_it_IL_Location').html(Location);
//                 $('#transfer_it_IL_UOM').html(RetainQtyUom);
//             // -------- item level set data end ---------------------

//             getSeriesDropdown_transfer() // DocName By using API to get dropdown 
//             ContainerSelection_transfer() // get Container Selection Table List

// }



// function postExtraIssue(){

// alert('hiiii');


// }


</script>
<!-- 778 -->