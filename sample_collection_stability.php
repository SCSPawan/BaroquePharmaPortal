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

    $getAllData=$obj->getSimpleCollection($STABSAMPCOLAFTERADD_API,$tdata);

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
                        <th>Intimation No</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Whs Code</th>
                        <th>Whs Total</th>
                        <th>Base Type</th>
                        <th>Base Entry</th>
                        <th>Base Num</th>
                        <th>Doc Date</th>
                        <th>Quantity</th>
                        <th>Lot Number</th>
                        <th>Exp. Date</th>
                        <th>Mnf Date</th>
                        <th>BPL Name</th>
                        <th>Location</th>
                        <th>Stability Plan DocNum</th>
                        <th>Stability Plan DocEntry</th>
                        <th>Stability Loading Date</th>
                        <th>Stability Plan Quantity</th>
                        <th>Stability Intimation No</th>
                        <th>Route Stage Reco WO No</th>
                        <th>Route Stage Reco WO Entry</th>
                        <th>Planned Qty</th>
                        <th>Route Stage Reco UOM</th>
                        <th>Route Stage Reco Prod Receipt No</th>
                        <th>Route Stage Reco Prod Receipt Entry</th>
                        <th>Route Stage Reco Prod Receipt Qty</th>
                        <th>Stability Type</th>
                        <th>Stability Condition</th>
                        <th>Stability Time Period</th>
                        <th>Type of Analysis</th>
                        <th>Period in months</th>
                        <th>Period Type</th>
                        <th>Additional Year</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>';
 
                if(count($getAllData)!='0'){
                    for ($i=$r_start; $i <$r_end ; $i++) { 
                        if(!empty($getAllData[$i]->DocEntry)){   //  this condition save to extra blank loop
                            $SrNo=$i+1;
                            // --------------- Convert String code Start Here ---------------------------
                                if(empty($getAllData[$i]->DocDate)){
                                    $DocDate='';
                                }else{
                                    $DocDate=date("d-m-Y", strtotime($getAllData[$i]->DocDate));
                                }

                                if(empty($getAllData[$i]->MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $MfgDate=date("d-m-Y", strtotime($getAllData[$i]->MfgDate));
                                }

                                if(empty($getAllData[$i]->ExpDate)){
                                    $ExpDate='';
                                }else{
                                    $ExpDate=date("d-m-Y", strtotime($getAllData[$i]->ExpDate));
                                }

                                if(empty($getAllData[$i]->StabilityLoadingDate)){
                                    $StabilityLoadingDate='';
                                }else{
                                    $StabilityLoadingDate=date("d-m-Y", strtotime($getAllData[$i]->StabilityLoadingDate));
                                }

                                if(empty($getAllData[$i]->EndDate)){
                                    $EndDate='';
                                }else{
                                    $EndDate=date("d-m-Y", strtotime($getAllData[$i]->EndDate));
                                }

                            // --------------- Convert String code End Here-- ---------------------------

                        $option.='
                            <tr>
                                <td class="desabled">'.$SrNo.'</td>

                                <td style="text-align: center;">
                                    <input type="radio" id="list'.$getAllData[$i]->DocEntry.'" name="listRado" value="'.$getAllData[$i]->DocEntry.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord('.$getAllData[$i]->DocEntry.')"  style="width: 17px;height: 17px;">
                                </td>
                                 <td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>

                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->WhsCode.'</td>
                        <td class="desabled" style="color:red;">***</td>
                        <td class="desabled" style="color:red;">***</td>
                        <td class="desabled" style="color:red;">***</td>
                        <td class="desabled" style="color:red;">***</td>
                                <td class="desabled">'.$DocDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$ExpDate.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->BPLId.'</td>
                                <td class="desabled">'.$getAllData[$i]->Location.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityPlanDocNum.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityPlanDocEntry.'</td>
                                <td class="desabled">'.$StabilityLoadingDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityPlanQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->SampleIntimationNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->WoNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->WoEntry.'</td>
                        <td class="desabled" style="color:red;">***</td>
                                <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                <td class="desabled">'.$getAllData[$i]->ReceiptNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->ReceiptEntry.'</td>
                        <td class="desabled" style="color:red;">***</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityType.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityCondition.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityTimePeriod.'</td>
                                <td class="desabled">'.$getAllData[$i]->AnalysisType.'</td>
                        <td class="desabled" style="color:red;">***</td>
                        <td class="desabled" style="color:red;">***</td>
                        <td class="desabled" style="color:red;">***</td>
                        <td class="desabled" style="color:red;">***</td>
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
<?php include 'models/qc_process/sample_collection_stability_model.php' ?>
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

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Sample Collection - Stability</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Sample Collection - Stability</li>
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
                                <h4 class="card-title mb-0">Sample Collection - Stability</h4> 
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
                                                       <input type="number" class="form-control" id="DocEntry" name="DocEntry">
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
                <!-- form tah start -->
                <div class="divAction" id="footerProcess">
                <form role="form" class="form-horizontal" id="SampleCollectionStabilityUpdateForm" method="post" data-select2-id="SampleCollectionStabilityUpdateForm">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">

                                        <input type="text" id="B_Series" name="B_Series">
                                        <input type="text" id="B_BPLId" name="B_BPLId">
                                        <input type="text" id="B_Canceled" name="B_Canceled">
                                        <input type="text" id="B_DocEntry" name="B_DocEntry">
                                        <input type="text" id="B_DocType" name="B_DocType">
                                        <input type="text" id="B_FromContainer" name="B_FromContainer">
                                        <input type="text" id="B_FromWhse" name="B_FromWhse">
                                        <input type="text" id="B_LineNum" name="B_LineNum">
                                        <input type="text" id="B_LocCode" name="B_LocCode">
                                        <input type="text" id="B_QtyPerContainer" name="B_QtyPerContainer">
                                        <input type="text" id="B_Status" name="B_Status">
                                        <input type="text" id="B_ToContainer" name="B_ToContainer">
                                        <input type="text" id="B_ToWhse" name="B_ToWhse">


                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingediant Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_IngrediantType" name="B_IngrediantType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="B_ReceiptNo" name="B_ReceiptNo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="B_ReceiptEntry" name="B_ReceiptEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="B_WoNo" name="B_WoNo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="B_WoEntry" name="B_WoEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                <div class="col-lg-5">
                                                    <input class="form-control desabled" type="text" id="B_SeriesName" name="B_SeriesName" readonly>
                                                </div>
                                                 <div class="col-lg-3">
                                                    <input class="form-control desabled" type="text" id="B_DocNum" name="B_DocNum" readonly>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_IntimatedBy" name="B_IntimatedBy" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_IntimatedDate" name="B_IntimatedDate" readonly>
                                                </div>
                                            </div>
                                        </div>


                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Unit</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_Unit" name="B_Unit" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control desabled" type="text" id="B_SampleCollectBy" name="B_SampleCollectBy" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_ARNo" name="B_ARNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_BatchNo" name="B_BatchNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_BatchQty" name="B_BatchQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-7 col-form-label mt-6" for="val-skill">Stability Transfer No From WO</label>
                                                <div class="col-lg-5">
                                                    <input class="form-control desabled" type="text" id="B_StabilityTransferNofromWo" name="B_StabilityTransferNofromWo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Transfer Entry From WO</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="B_StabilityTransferEntryfromWo" name="B_StabilityTransferEntryfromWo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Plan DocNum</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="B_StabilityPlanDocNum" name="B_StabilityPlanDocNum" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-6 col-form-label mt-6" for="val-skill">Satbility Plan DocEntry</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="B_StabilityPlanDocEntry" name="B_StabilityPlanDocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-7 col-form-label mt-6" for="val-skill">Stability Plan Loading Date</label>
                                                <div class="col-lg-5">
                                                    <input class="form-control desabled" type="text" id="B_StabilityLoadingDate" name="B_StabilityLoadingDate" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Plan Quantity</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="B_StabilityPlanQty" name="B_StabilityPlanQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Intimation No</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="B_SampleIntimationNo" name="B_SampleIntimationNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_TotalNoOfContainer" name="B_TotalNoOfContainer" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Whs Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_WhsCode" name="B_WhsCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mnf Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_MfgDate" name="B_MfgDate" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_ExpDate" name="B_ExpDate" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_DocDate" name="B_DocDate" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_Branch" name="B_Branch" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_Location" name="B_Location" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_ItemCode" name="B_ItemCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_ItemName" name="B_ItemName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stability Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_StabilityType" name="B_StabilityType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Condition</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="B_StabilityCondition" name="B_StabilityCondition" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Time Period</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="B_StabilityTimePeriod" name="B_StabilityTimePeriod" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="B_AnalysisType" name="B_AnalysisType" readonly>
                                                </div>
                                            </div>
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
                                            <a class="nav-link active" data-bs-toggle="tab" href="#samp_details" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">Sample Collection Details</span>    
                                            </a>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#home" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">External</span>    
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                <span class="d-none d-sm-block">Extra Issue</span>    
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->

                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active" id="samp_details" role="tabpanel">
                                              
                                            <div class="row">

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-6 col-form-label mt-6" for="val-skill">UnderTest Transfer No</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control desabled" id="SCD_UnderTestTransferNo" name="SCD_UnderTestTransferNo" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <div class="col-md-5">
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".goods_issue" onclick="OpenInventoryTransferModel_sampleIssue()">Sample Issue</button>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <input type="text" id="SCD_SampleIssue" name="SCD_SampleIssue" class="form-control  desabled" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container No</label>
                                                        <div class="col-lg-8 container_input" style="display: inline-flex;">
                                                            <input type="text" id="" name="" class="form-control desabled" readonly >
                                                            <input type="text" id="" name="" class="form-control ">
                                                            <input type="text" id="" name="" class="form-control ">
                                                         </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Qty For Label</label>
                                                        <div class="col-lg-8">
                                                            <input type="number" id="SCD_QtyforLabel" name="SCD_QtyforLabel" class="form-control ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Sample Print</button>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="home" role="tabpanel">
                                            <div class="table-responsive" id="list">
                                                <input type="text" id="RowLevelSelectedExternalIssue" name="RowLevelSelectedExternalIssue">

                                                <table id="TblExternalIssue" class="table sample-table-responsive table-bordered" style="">
                                                    <thead class="fixedHeader1">
                                                        <tr>
                                                            <th>Sr. No</th>
                                                            <th>Supplier Code</th>
                                                            <th>Supplier Name</th>
                                                            <th>UOM </th>  
                                                            <th>Sample Date</th>
                                                            <th>Warehouse</th>
                                                            <th>Sample Quantity</th>
                                                            <th>User Text1</th>
                                                            <th>User Text2</th>
                                                            <th>User Text3</th>
                                                            <th>Inventory Transfer</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody id="External-issue-list-append"></tbody> 

                                                </table>
                                            </div> 
                                                
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" id="SC_ExternalIssue_PEI_Btn" class="pad_btn active btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" style="padding: 7px 5px 7px 5px;" onclick="SampleCollectionITransPop();" disabled="">Transfer </button>

                                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Sleep</button>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="profile" role="tabpanel">
                                            <div class="table-responsive" id="list">
                                            <input type="hidden" id="RowLevelSelectedExtraIssue" name="RowLevelSelectedExtraIssue">
                                                <table id="TblExtraIssue" class="table sample-table-responsive table-bordered" style="">
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
                                                    <tbody id="Extra-issue-list-append"></tbody> 
                                                </table>
                                            </div> 

                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" id="SC_ExtraIssue_PEI_Btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".goods_issue" onclick="SC_SCD_GI_SampleIssuePoP();" disabled>Post Extra Issue</button>

                                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Issue Slip</button>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="button" class="btn btn-primary" id="SampleCollectionStabilityUpdateForm_Btn" name="SampleCollectionStabilityUpdateForm_Btn" onclick="SampleCollectionStabilityUpdateForm()">Update</button>
                                        </div>
                                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </form>
            </div>
                <!-- form tag end -->
            </div>
            <br>
           <?php include 'include/footer.php' ?>

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
                $(".loader123").show();
            },
            success: function(result)
            {   
                $('#list-append').html(result);

                $(".ExternalIssueraManual1").select2();// dropdown with search option
            },
            complete:function(data){
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
                $(".loader123").show();
            },
            success: function(result)
            {
                $('#list-append').html(result);
            },
            complete:function(data){
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
                $(".loader123").show();
            },
            success: function(result)
            {  
                $("#footerProcess").hide();
                $('#list-append').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
       });
    }

    function selectedRecord(DocEntry){
        // ==============================Table tr count inside tbody start here ===================
            var totalRowCount = 0;
            var rowCount = 0;
            var table = document.getElementById("TblExternalIssue");
            var rows = table.getElementsByTagName("tr")
            for (var i = 0; i < rows.length; i++) {
                totalRowCount++;
                if (rows[i].getElementsByTagName("td").length > 0) {
                    rowCount++;
                }
            }

            console.log('totalRowCount=>', totalRowCount);
            console.log('rowCount=>', rowCount);
        // ==============================Table tr count inside tbody End here ====================
        // ==============================Table tr count inside tbody start here ===================
            var totalRowCount_N = 0;
            var rowCount_N = 0;
            var table_N = document.getElementById("TblExtraIssue");
            var rows_N = table_N.getElementsByTagName("tr")
            for (var i = 0; i < rows_N.length; i++) {
                totalRowCount_N++;
                if (rows_N[i].getElementsByTagName("td").length > 0) {
                    rowCount_N++;
                }
            }

            // console.log('totalRowCount_N=>', totalRowCount_N);
            // console.log('rowCount_N=>', rowCount_N);
        // ==============================Table tr count inside tbody End here ====================
// rowCount
        var dataString ='DocEntry='+DocEntry+'&rowCount='+rowCount+'&rowCount_N='+rowCount_N+'&action=sample_collection_stability_ajax';

        $.ajax({  
            type: "POST",  
            url: 'ajax/common-ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {  
                // console.log(result);
                $("#footerProcess").show();
                var JSONObjectAll = JSON.parse(result);

                // console.log(JSONObjectAll);

                var JSONObject=JSONObjectAll['SampleCollDetails'];

                $(`#Extra-issue-list-append`).html(JSONObjectAll['ExtraIssue']); // Extra Issue Table Tr tag append here
                $(`#External-issue-list-append`).html(JSONObjectAll['ExternalIssue']); // External Issue Table Tr tag append here

                // <!-- ---------- bottom section field mapping start here ------------------------------ -->
                    
                    // Hidden filed mapping----------------------------------------------------------------

                        $('#B_Series').val(JSONObject[0]['Series']);
                        $('#B_BPLId').val(JSONObject[0]['BPLId']);
                        $('#B_Canceled').val(JSONObject[0]['Canceled']);
                        $('#B_DocEntry').val(JSONObject[0]['DocEntry']);
                        $('#B_DocType').val(JSONObject[0]['DocType']);
                        $('#B_FromContainer').val(JSONObject[0]['FromContainer']);
                        $('#B_FromWhse').val(JSONObject[0]['FromWhse']);
                        $('#B_LineNum').val(JSONObject[0]['LineNum']);
                        $('#B_LocCode').val(JSONObject[0]['LocCode']);
                        $('#B_QtyPerContainer').val(JSONObject[0]['QtyPerContainer']);
                        $('#B_Status').val(JSONObject[0]['Status']);
                        $('#B_ToContainer').val(JSONObject[0]['ToContainer']);
                        $('#B_ToWhse').val(JSONObject[0]['ToWhse']);

                    // 1st line-------------------------------------------------------------------------------
                        $('#B_IngrediantType').val(JSONObject[0]['IngrediantType']);
                        $('#B_ReceiptNo').val(JSONObject[0]['ReceiptNo']);
                        $('#B_ReceiptEntry').val(JSONObject[0]['ReceiptEntry']);
                        $('#B_WoNo').val(JSONObject[0]['WoNo']);
                        $('#B_WoEntry').val(JSONObject[0]['WoEntry']);
                        $('#B_SeriesName').val(JSONObject[0]['SeriesName']);
                        $('#B_DocNum').val(JSONObject[0]['DocNum']);

                    // 2nd line-------------------------------------------------------------------------------
                        $('#B_IntimatedBy').val(JSONObject[0]['IntimatedBy']);
                        $('#B_IntimatedDate').val(JSONObject[0]['IntimatedDate']);
                        $('#B_Unit').val(JSONObject[0]['Unit']);
                        $('#B_SampleCollectBy').val(JSONObject[0]['SampleCollectBy']);

                    // 3rd line-------------------------------------------------------------------------------
                        $('#B_ARNo').val(JSONObject[0]['ARNo']);
                        $('#B_BatchNo').val(JSONObject[0]['BatchNo']);
                        $('#B_BatchQty').val(JSONObject[0]['BatchQty']);
                        $('#B_StabilityTransferNofromWo').val(JSONObject[0]['StabilityTransferNofromWo']);

                    // 4th line-------------------------------------------------------------------------------
                        $('#B_StabilityTransferEntryfromWo').val(JSONObject[0]['StabilityTransferEntryfromWo']);
                        $('#B_StabilityPlanDocNum').val(JSONObject[0]['StabilityPlanDocNum']);
                        $('#B_StabilityPlanDocEntry').val(JSONObject[0]['StabilityPlanDocEntry']);

                        // <!-- ----------- Stability Loading Date Start Here ----------------------------------- -->
                            var stabilityLoadingDateOG = JSONObject[0]['StabilityLoadingDate'];
                            if(stabilityLoadingDateOG!=''){
                                slDate = stabilityLoadingDateOG.split(' ')[0];
                                $(`#B_StabilityLoadingDate`).val(slDate); 
                            }
                        // <!-- ----------- Stability Loading Date End Here ------------------------------------- -->


                    // 5th line-------------------------------------------------------------------------------
                        $('#B_StabilityPlanQty').val(JSONObject[0]['StabilityPlanQty']);
                        $('#B_SampleIntimationNo').val(JSONObject[0]['SampleIntimationNo']);
                        $('#B_TotalNoOfContainer').val(JSONObject[0]['TotalNoOfContainer']);
                        $('#B_WhsCode').val(JSONObject[0]['WhsCode']);


                    // 6th line-------------------------------------------------------------------------------
                        // <!-- ----------- Mnf Date Start Here ----------------------------------- -->
                            var mnfDateOG = JSONObject[0]['MfgDate'];
                            if(mnfDateOG!=''){
                                mnfDate = mnfDateOG.split(' ')[0];
                                $(`#B_MfgDate`).val(mnfDate); 
                            }
                        // <!-- ----------- Mnf Date End Here ------------------------------------- -->

                        // <!-- ----------- Exp Date Start Here ----------------------------------- -->
                            var ExpDateOG = JSONObject[0]['ExpDate'];
                            if(ExpDateOG!=''){
                                ExpDate = ExpDateOG.split(' ')[0];
                                $(`#B_ExpDate`).val(ExpDate); 
                            }
                        // <!-- ----------- Exp Date End Here ------------------------------------- -->

                        // <!-- ----------- Doc Date Start Here ----------------------------------- -->
                            var docDateOG = JSONObject[0]['DocDate'];
                            if(docDateOG!=''){
                                DocDate = docDateOG.split(' ')[0];
                                $(`#B_DocDate`).val(DocDate); 
                            }
                        // <!-- ----------- Doc Date End Here ------------------------------------- -->

                        $('#B_Branch').val(JSONObject[0]['Branch']);


                    // 7th line-------------------------------------------------------------------------------
                        $('#B_Location').val(JSONObject[0]['Location']);
                        $('#B_ItemCode').val(JSONObject[0]['ItemCode']);
                        $('#B_ItemName').val(JSONObject[0]['ItemName']);
                        $('#B_StabilityType').val(JSONObject[0]['StabilityType']);

                    // 8th line-------------------------------------------------------------------------------
                        $('#B_StabilityCondition').val(JSONObject[0]['StabilityCondition']);
                        $('#B_StabilityTimePeriod').val(JSONObject[0]['StabilityTimePeriod']);
                        $('#B_AnalysisType').val(JSONObject[0]['AnalysisType']);
                // <!-- ---------- bottom section field mapping end here -------------------------------- -->

                // <!-- -----------Sample Collection Deatils Tab data mappin start  here --------------------- -->
                        
                        $('#SCD_UnderTestTransferNo').val(JSONObject[0]['UnderTestTransferNo']);
                        $('#SCD_QtyforLabel').val(JSONObject[0]['QtyforLabel']);
                        $('#SCD_SampleIssue').val(JSONObject[0]['SampleIssue']);
                // <!-- -----------Sample Collection Deatils Tab data mappin start  here --------------------- -->



                // tablayoutvalidation();
                getSupplierDropdown(totalRowCount);
                getWareHouseDropdown(totalRowCount);

                getWareHouseExtraIssueDropdown(totalRowCount_N);

                $('.ExternalIssueSelectedBPWithData').select2();// with data supplier dropdown
                $('.ExternalIssueDefault').select2();// default supplier dropdown

                $('.ExternalIssueWareHouseDefault').select2();// with data supplier dropdown
                $('.ExternalIssueWareHouseWithData').select2();// default supplier dropdown

                $('.SC_FEI_WarehouseDefault').select2();// with data supplier dropdown
                $('.SC_FEI_WarehouseWithData').select2();// default supplier dropdown
                
            },complete:function(data){
                // $(".loader123").hide();
            }
        });
    }

    function getSupplierDropdown(totalRowCount){

        
           var rowCount = document.getElementById('TblExternalIssue').rows.length;
            // alert(rowCount);
           var dataString ='action=SupplierDropdown_ajax';

        $.ajax({  
            type: "POST",  
            url: 'ajax/common-ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {  
                // console.log('=>'result);
                var JSONObject = JSON.parse(result);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=rowCount-1; 
                     // console.log('un_id=>', un_id);
                    $('#SC_ExternalI_SupplierCode'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function getWareHouseDropdown(totalRowCount){
         var rowCount = document.getElementById('TblExternalIssue').rows.length;
            // alert(rowCount);
        var dataString ='action=WareHouseDropdown_ajax';

        $.ajax({  
            type: "POST",  
            url: 'ajax/common-ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {  
                var JSONObject = JSON.parse(result);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=rowCount-1; 
                    $('#SC_ExternalI_Warehouse'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
            },
            complete:function(data){
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
                $(".loader123").show();
            },
            success: function(result)
            {  
                var JSONObject = JSON.parse(result);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=totalRowCount_N; 
// console.log('un_id=>', un_id);
                    $('#SC_FEI_Warehouse'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }
 
    function SampleCollectionStabilityUpdateForm()
    {
        var formData = new FormData($('#SampleCollectionStabilityUpdateForm')[0]); // form Id
        formData.append("SampleCollectionStabilityUpdateForm_Btn",'SampleCollectionStabilityUpdateForm_Btn'); // submit btn Id
        var error = true;
        
        $.ajax({
            url: 'ajax/kri_production_common_ajax.php',
            type: "POST",
            data:formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                // console.log(result);
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
            }
            ,complete:function(data){
                $(".loader123").hide();
            }
        });
    }



    function OpenInventoryTransferModel_sampleIssue()
    {
        // alert('h');
        // var SupplierCode=document.getElementById('si_SupplierCode').value;
        // var SupplierName=document.getElementById('si_SupplierName').value;
        // var Branch=document.getElementById('fg_Branch').value;
        // var Series=document.getElementById('si_Series').value;
        var DocEntry=document.getElementById('B_DocEntry').value;
        // var BPLId=document.getElementById('BPLId').value;
        // var afters=
        // alert(DocEntry);
        
        var dataString ='DocEntry='+DocEntry+'&action=OpenInventoryTransferSamplessue_stability_ajax';
        // alert(dataString);
        // +'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                // console.log(JSONObject);
                // var DataDetails =DataDetails[]
                // console.log(result);
                // $('#iT_goods_issue_supplier_code').val(SupplierCode);
                // $('#iT_goods_issue_supplier_name').val(SupplierName);
                $('#stability_BaseDocType').val(JSONObject['DataDetails'][0].DocType);
                $('#stability_BaseDocNum').val(JSONObject['DataDetails'][0].DocNum);
                $('#stability_Branch').val(JSONObject['DataDetails'][0].Branch);
                $('#stability_Series').val(JSONObject['DataDetails'][0].Series);
                $('#stability_BPLId').val(JSONObject['DataDetails'][0].BPLId);
                $('#stability_DocEntry').val(JSONObject['DataDetails'][0].DocEntry);
                // $('#iT_goods_issue_PostingDate').val();
                // $('#iT_goods_issue_DocumentDate').val();
                $('#InventoryTransferItemAppend').html(JSONObject['option']);
                $('#ContainerSelectionItemAppend').html(JSONObject['containerSelection']);
                // alert(after);
                // getSeriesDropdown_gd() // DocName By using API to get dropdown 
                 // ContainerSelection_sample_issue(); // get Container Selection Table List
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }


  function getSelectedContener(un_id){
        //Create an Array.
        var selected = new Array();
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend");
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


    function EnterQtyValidation_GI(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){

                $('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

                // getSelectedContener(un_id); // if user change selected Qty value after selection 
            }else{
                $('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
        }

        getSelectedContenerGI_Manual(un_id);
    }



    function getSelectedContenerGI_Manual(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend");
 
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

   // ==================Tranfer=========================
     
     function getSelectedContener_tranfer(un_id){
        //Create an Array.
        var selected = new Array();
        //Reference the Table.
        var tblFruits = document.getElementById("InventoryTransferItemAppend_containerSelector_transfer");
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


    function EnterQtyValidation_GI_tranfer(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){

                $('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

                // getSelectedContener(un_id); // if user change selected Qty value after selection 
            }else{
                $('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
        }

        getSelectedContenerGI_Manual_tranfer(un_id);
    }



    function getSelectedContenerGI_Manual_tranfer(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("InventoryTransferItemAppend_containerSelector_transfer");
 
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



   // ===================End Tranfer====================

function SubmitInventoryTransfer_sample_issue(){

var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
// var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
var PostingDate=document.getElementById('stability_PostingDate').value;
var DocDate=document.getElementById('stability_DocumentDate').value;
var ItemCode=document.getElementById('itP_ItemCode').value;
var ItemName=document.getElementById('itP_ItemName').value;
var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
var fromWhs=document.getElementById('itP_FromWhs').value;
var ToWhs=document.getElementById('itP_ToWhs').value;
var Location=document.getElementById('itP_Loction').value;

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
                var formData = new FormData($('#stabilityForm')[0]); 
                formData.append("SubIT_Btn_S_sample_issue_sampleCollection_stability",'SubIT_Btn_S_sample_issue_sampleCollection_stability'); 


                var error = true;

                if(error)
                {
                        $.ajax({
                                url: 'ajax/kri_production_common_ajax.php',
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


 function SampleCollectionITransPop()
    {   
        var un_id=document.getElementById('RowLevelSelectedExternalIssue').value;  // selected row un_id

        // alert(un_id);

        var SupplierCode=document.getElementById('SC_FEXI_SupplierCode'+un_id).value;
        var SupplierName=document.getElementById('SC_FEXI_SupplierName'+un_id).value;
        var ToWare=document.getElementById('SC_FEXI_Warehouse'+un_id).value;
        var SampleQuantity=document.getElementById('SC_FEXI_SampleQuantity'+un_id).value;
        var sampleDate=document.getElementById('SC_FEXI_SampleDate'+un_id).value;
        var BranchName=document.getElementById('B_Branch').value;
        var DocEntry=document.getElementById('B_DocEntry').value;
        var Series=document.getElementById('B_Series').value;
        

        var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_stabilitys_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {   
                
                $('#stabl_supplier_code').val(SupplierCode);
                $('#stabl_supplier_name').val(SupplierName);
                $('#stabl_Branch').val(BranchName);
                // $('#it_DocEntry').val(DocEntry);
                $('#stabl_BaseDocNum').val(DocEntry);
                $('#stabl_Series').val(Series);
                $('#stabl_BaseDocType').val('SCS_SCOLSTAB');
                var JSONObject = JSON.parse(result);
                $('#InventoryTransferItemAppend_stability_transfer').html(JSONObject['option']);
                $('#InventoryTransferItemAppend_containerSelector_transfer').html(JSONObject['containerSelection']);
                //Item Quantity Recalculate according sample quantity start here -------------------
                $('#itP_BQty').val(SampleQuantity);
                //Item Quantity Recalculate according sample quantity end here --------------------- 

                // getSeriesDropdown() // DocName By using API to get dropdown 
                // ContainerSelection() // get Container Selection Table List
                // changedateformate(sampleDate);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }



function SC_SCD_GI_SampleIssuePoP(){

     // alert('h');
        // var SupplierCode=document.getElementById('si_SupplierCode').value;
        // var SupplierName=document.getElementById('si_SupplierName').value;
        // var Branch=document.getElementById('fg_Branch').value;
        // var Series=document.getElementById('si_Series').value;
        var DocEntry=document.getElementById('B_DocEntry').value;
        // var BPLId=document.getElementById('BPLId').value;
        // var afters=
        // alert(DocEntry);
        
        var dataString ='DocEntry='+DocEntry+'&action=OpenInventoryTransferSamplessue_stability_ajax';
        // alert(dataString);
        // +'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                // console.log(JSONObject);
                // var DataDetails =DataDetails[]
                // console.log(result);
                // $('#iT_goods_issue_supplier_code').val(SupplierCode);
                // $('#iT_goods_issue_supplier_name').val(SupplierName);
                $('#stability_BaseDocType').val(JSONObject['DataDetails'][0].DocType);
                $('#stability_BaseDocNum').val(JSONObject['DataDetails'][0].DocNum);
                $('#stability_Branch').val(JSONObject['DataDetails'][0].Branch);
                $('#stability_Series').val(JSONObject['DataDetails'][0].Series);
                $('#stability_BPLId').val(JSONObject['DataDetails'][0].BPLId);
                $('#stability_DocEntry').val(JSONObject['DataDetails'][0].DocEntry);
                // $('#iT_goods_issue_PostingDate').val();
                // $('#iT_goods_issue_DocumentDate').val();
                $('#InventoryTransferItemAppend').html(JSONObject['option']);
                $('#ContainerSelectionItemAppend').html(JSONObject['containerSelection']);
                // alert(after);
                // getSeriesDropdown_gd() // DocName By using API to get dropdown 
                 // ContainerSelection_sample_issue(); // get Container Selection Table List
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
}


function inventoryTransferStability()
{

var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
// var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
var PostingDate=document.getElementById('stabl_PostingDate').value;
var DocDate=document.getElementById('stabl_DocumentDate').value;
var ItemCode=document.getElementById('itP_ItemCode').value;
// var ItemName=document.getElementById('itP_ItemName').value;
var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
var fromWhs=document.getElementById('itP_FromWhs').value;
var ToWhs=document.getElementById('itP_ToWhs').value;
var Location=document.getElementById('itP_location').value;

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
                  // SubIT_Btn_S_sample_issue_sampleCollection_stabilityss start
                  // <!-- ---------------- form submit proce here ----------------- -->
                     var formData = new FormData($('#inventoryTransferStabilityform')[0]); 
                         formData.append("SubIT_Btn_transfer_sampleCollection_stability",'SubIT_Btn_transfer_sampleCollection_stability'); 
                     var error = true;

                if(error)
                {
                        $.ajax({
                                url: 'ajax/kri_production_common_ajax.php',
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
                                    // console.log(JSONObject);
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



    function selectedExternalIssue(un_id){
        $('#RowLevelSelectedExternalIssue').val(un_id);
        document.getElementById("SC_ExternalIssue_PEI_Btn").disabled = false;
    }

    function selectedExtraIssue(un_id){
        $('#RowLevelSelectedExtraIssue').val(un_id);
        document.getElementById("SC_ExtraIssue_PEI_Btn").disabled= false;
    }
</script>           






































<script type="text/javascript">
        $(document).ready(function(){
            
            for (var i = 8 - 1; i >= 0; i--) { // 2 count hard core there is called row count on page load
                $("#Property_code"+i).select2();
            }
           
        });
         function PropertyCode(i){
            var username = $('#Property_code'+`${i}` +'option:selected').text();
            var userid = $('#Property_code'+i).val();

            $('#result').html("id : " + userid + ", name : " + username);
         }
</script>

<!-- 902 total Line static -->