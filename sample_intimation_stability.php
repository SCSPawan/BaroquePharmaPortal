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

    $getAllData=$obj->getSimpleIntimation($STABSAMPINTIAFTERADD_API,$tdata);
    // echo '<pre>';
    // print_r($getAllData[0]);
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
                        <th>Period in Months</th>
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
                                if(empty($getAllData[$i]->MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $U_MfgDate = str_replace('/', '-', $getAllData[$i]->MfgDate); 
                                    $MfgDate=date("d-m-Y", strtotime($U_MfgDate));
                                }

                                if(empty($getAllData[$i]->ExpDate)){
                                    $ExpiryDate='';
                                }else{
                                    $U_ExpDate = str_replace('/', '-', $getAllData[$i]->ExpDate); 
                                    $ExpiryDate=date("d-m-Y", strtotime($U_ExpDate));
                                }

                                if(empty($getAllData[$i]->StabilityLoadingDate)){
                                    $StabilityLoadingDate='';
                                }else{
                                    $StabilityLoadingDate=date("d-m-Y", strtotime($getAllData[$i]->StabilityLoadingDate));
                                }
                            // --------------- Convert String code End Here-- ---------------------------

                        $option.='
                            <tr>
                                <td class="desabled">'.$SrNo.'</td>

                                <td style="text-align: center;">
                                    <input type="radio" id="list'.$getAllData[$i]->DocEntry.'" name="listRado" value="'.$getAllData[$i]->DocEntry.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord('.$getAllData[$i]->DocEntry.')">
                                </td>

                                <td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->WhsCode.'</td>
                                <td class="desabled" style="color:red;">****</td>
                                <td class="desabled" style="color:red;">****</td>
                                <td class="desabled" style="color:red;">****</td>
                                <td class="desabled" style="color:red;">****</td>
                                <td class="desabled" style="color:red;">****</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$ExpiryDate.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->Branch.'</td>
                                <td class="desabled">'.$getAllData[$i]->Location.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityPlanDocNum.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityPlanDocEntry.'</td>
                                <td class="desabled">'.$StabilityLoadingDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityPlanQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->WoNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->WoEntry.'</td>
                                <td class="desabled" style="color:red;">****</td>
                                <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                <td class="desabled">'.$getAllData[$i]->ReceiptNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->ReceiptEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->ReceiptQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityType.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityCondition.'</td>
                                <td class="desabled">'.$getAllData[$i]->StabilityTimePeriod.'</td>
                                <td class="desabled">'.$getAllData[$i]->AnalysisType.'</td>
                                <td class="desabled" style="color:red;">****</td>
                                <td class="desabled" style="color:red;">****</td>
                                <td class="desabled" style="color:red;">****</td>
                                <td class="desabled" style="color:red;">****</td>
                            </tr>';
                        }
                    }
                }else{
                     $option.='<tr><td colspan="16" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
                }
        $option.='</tbody> 
    </table>'; 

    $option.=$pagination;        
    echo $option;
    exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/qc_process/sample_intimation_stability_model.php' ?>
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

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Sample Intimation (Transfer Request) - Stability</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Sample Intimation (Transfer Request) - Stability</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header justify-content-between d-flex align-items-center">
                                <h4 class="card-title mb-0">Sample Intimation (Transfer Request) - Stability</h4> 
                            </div><!-- end card header -->
                            <div class="card-body">

                                <div class="top_filter">
                                    <div class="row">

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">From Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="FromDate" name="FromDate" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d').'-3 days'))?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">To Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="ToDate" name="ToDate" value="<?php echo date("Y-m-d") ?>">
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
                                                <div class="col-lg-4">
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

                <div class="row" id="footerProcess">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <input type="hidden" id="SIS_Series" name="SIS_Series">
                                    <input type="hidden" id="SIS_Canceled" name="SIS_Canceled">
                                    <input type="hidden" id="SIS_BPLId" name="SIS_BPLId">
                                    <input type="hidden" id="SIS_DocEntry" name="SIS_DocEntry">
                                    <input type="hidden" id="SIS_DocType" name="SIS_DocType">
                                    <input type="hidden" id="SIS_FromWhse" name="SIS_FromWhse">
                                    <input type="hidden" id="SIS_LineNum" name="SIS_LineNum">
                                    <input type="hidden" id="SIS_LocCode" name="SIS_LocCode">
                                    <input type="hidden" id="SIS_QtyPerContainer" name="SIS_QtyPerContainer">
                                    <input type="hidden" id="SIS_ToWhse" name="SIS_ToWhse">
                                    <input type="hidden" id="SIS_SupplierCode" name="SIS_SupplierCode">
                                    <input type="hidden" id="SIS_SupplierName" name="SIS_SupplierName">

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                            <div class="col-lg-6">
                                                <input class="form-control desabled" type="text" id="SIS_ReceiptNo" name="SIS_ReceiptNo" readonly>
                                            </div>
                                            <div class="col-lg-2">
                                                <input class="form-control desabled" type="text" id="SIS_ReceiptEntry" name="SIS_ReceiptEntry" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                            <div class="col-lg-4">
                                               <input class="form-control desabled" type="text" id="SIS_SeriesName" name="SIS_SeriesName" readonly>
                                            </div>
                                            <div class="col-lg-2">
                                                <input class="form-control desabled" type="text" id="SIS_DocNum" name="SIS_DocNum" readonly>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="SIS_WoNo" name="SIS_WoNo" readonly>
                                            </div>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="SIS_WoEntry" name="SIS_WoEntry" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_SampleType" name="SIS_SampleType" readonly>
                                            </div>
                                        </div>
                                    </div>  
                                                
                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_TRBy" name="SIS_TRBy" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_ItemCode" name="SIS_ItemCode" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_ItemName" name="SIS_ItemName" readonly>
                                            </div>
                                        </div>
                                    </div>   

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_ReceiptQty" name="SIS_ReceiptQty" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-5 col-form-label mt-6" for="val-skill">Stability Plan Qty</label>
                                            <div class="col-lg-7">
                                                <input class="form-control desabled" type="number" id="SIS_StabilityPlanQty" name="SIS_StabilityPlanQty" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Whs Code</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_WhsCode" name="SIS_WhsCode" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Plan DocNum</label>
                                            <div class="col-lg-6">
                                                <input class="form-control desabled" type="text" id="SIS_StabilityPlanDocNum" name="SIS_StabilityPlanDocNum" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Plan DocEntry</label>
                                            <div class="col-lg-6">
                                                <input class="form-control desabled" type="text" id="SIS_StabilityPlanDocEntry" name="SIS_StabilityPlanDocEntry" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Unit</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_Unit" name="SIS_Unit" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-6 col-form-label mt-6" for="val-skill">Total No of container</label>
                                            <div class="col-lg-6">
                                                 <input class="form-control desabled" type="text" id="SIS_TotalNoOfContainer" name="SIS_TotalNoOfContainer" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                            <div class="col-lg-8">
                                                 <input class="form-control desabled" type="text" id="SIS_FromContainer" name="SIS_FromContainer" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                            <div class="col-lg-8">
                                                 <input class="form-control desabled" type="text" id="SIS_ToContainer" name="SIS_ToContainer" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_BatchNo" name="SIS_BatchNo" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_BatchQty" name="SIS_BatchQty" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_MfgDate" name="SIS_MfgDate" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_ExpDate" name="SIS_ExpDate" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retest Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_RetestDate" name="SIS_RetestDate" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-7 col-form-label mt-6" for="val-skill">Stability Trasnfer No From WO</label>
                                            <div class="col-lg-5">
                                                <input class="form-control desabled" type="text" id="SIS_StabilityTransferNofromWo" name="SIS_StabilityTransferNofromWo" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Loading date</label>
                                            <div class="col-lg-6">
                                                <input class="form-control desabled" type="text" id="SIS_StabilityLoadingDate" name="SIS_StabilityLoadingDate" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Trasnfer Entry From WO</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="SIS_StabilityTransferEntryfromWo" name="SIS_StabilityTransferEntryfromWo" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="SIS_Status" name="SIS_Status" readonly>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="SIS_StatusChekBox" name="SIS_StatusChekBox" style="pointer-events: none;">
                                                    <label class="form-check-label" for="flexCheckDefault">Cancelled</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_TrDate" name="SIS_TrDate" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_Branch" name="SIS_Branch" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_Location" name="SIS_Location" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-5 col-form-label mt-6" for="val-skill">Stability Type</label>
                                            <div class="col-lg-7">
                                                <input class="form-control desabled" type="text" id="SIS_StabilityType" name="SIS_StabilityType" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-5 col-form-label mt-6" for="val-skill">Stability Condition</label>
                                            <div class="col-lg-7">
                                                <input class="form-control desabled" type="text" id="SIS_StabilityCondition" name="SIS_StabilityCondition" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Time Period</label>
                                            <div class="col-lg-6">
                                                <input class="form-control desabled" type="text" id="SIS_StabilityTimePeriod" name="SIS_StabilityTimePeriod" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Type</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SIS_AnalysisType" name="SIS_AnalysisType" readonly>
                                            </div>
                                        </div>
                                    </div>  
                                                                            
                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container Nos</label>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" rows="1" id="SIS_ContainerNos" name="SIS_ContainerNos" readonly></textarea>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container</label>
                                            <div class="col-lg-8">
                                                 <input class="form-control desabled" type="text" id="SIS_Container" name="SIS_Container" readonly>
                                            </div>
                                        </div>
                                    </div> 
                
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" data-bs-toggle="button" autocomplete="off" id="befor" onclick="TransToUnder();">Transfer To Undertest</button>
                                            
                                            <button type="button" id="after" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".after_inventory_transfer" autocomplete="off" onclick="TransToUnderAfter();" style="">Transfer To Undertest</button>
                                            
                                            <input type="text" id="SIS_UnderTestTransferNo" name="SIS_UnderTestTransferNo" class="desabled" readonly>
                                        </div>

                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Print Undertest Label</button>

                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Print Quarantine</button>

                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Print Sample Intimation</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                      
                        </div>
                    </div>

                </div>
            </div>
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
                $("#footerProcess").hide(); // bottom section hide
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
                $("#footerProcess").hide(); // bottom section hide
                $('#list-append').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
       });
    }

    function selectedRecord(DocEntry){

        var dataString ='DocEntry='+DocEntry+'&action=sample_intimation_stability_ajax';

        $.ajax({  
            type: "POST",  
            url: 'ajax/common-ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {  
                $("#footerProcess").show();
                var JSONObject = JSON.parse(result);

                // hidden-----------------------------------------------------------------------
                    $(`#SIS_Series`).val(JSONObject[0]['Series']);
                    $(`#SIS_Canceled`).val(JSONObject[0]['Canceled']);

                    $(`#SIS_BPLId`).val(JSONObject[0]['BPLId']);
                    $(`#SIS_DocEntry`).val(JSONObject[0]['DocEntry']);
                    $(`#SIS_DocType`).val(JSONObject[0]['DocType']);
                    $(`#SIS_FromWhse`).val(JSONObject[0]['FromWhse']);
                    $(`#SIS_LineNum`).val(JSONObject[0]['LineNum']);
                    $(`#SIS_LocCode`).val(JSONObject[0]['LocCode']);
                    $(`#SIS_QtyPerContainer`).val(JSONObject[0]['QtyPerContainer']);
                    $(`#SIS_ToWhse`).val(JSONObject[0]['ToWhse']);

                    $(`#SIS_SupplierCode`).val(''); //this field is not in SAP -> Indu
                    $(`#SIS_SupplierName`).val(''); //this field is not in SAP -> Indu

                // 1st row-----------------------------------------------------------------------
                        $(`#SIS_ReceiptNo`).val(JSONObject[0]['ReceiptNo']);
                        $(`#SIS_ReceiptEntry`).val(JSONObject[0]['ReceiptEntry']);
                        $(`#SIS_SeriesName`).val(JSONObject[0]['SeriesName']);
                        $(`#SIS_WoNo`).val(JSONObject[0]['WoNo']);
                        $(`#SIS_WoEntry`).val(JSONObject[0]['WoEntry']);
                        $(`#SIS_SampleType`).val(JSONObject[0]['SampleType']);
                        $(`#SIS_DocNum`).val(JSONObject[0]['DocNum']);

                // 2nd row------------------------------------------------------------------------
                        $(`#SIS_TRBy`).val(JSONObject[0]['TRBy']);
                        $(`#SIS_ItemCode`).val(JSONObject[0]['ItemCode']);
                        $(`#SIS_ItemName`).val(JSONObject[0]['ItemName']);
                        $(`#SIS_ReceiptQty`).val(JSONObject[0]['ReceiptQty']);

                // 3nd row------------------------------------------------------------------------
                        $(`#SIS_StabilityPlanQty`).val(JSONObject[0]['StabilityPlanQty']);
                        $(`#SIS_WhsCode`).val(JSONObject[0]['WhsCode']);
                        $(`#SIS_StabilityPlanDocNum`).val(JSONObject[0]['StabilityPlanDocNum']);
                        $(`#SIS_StabilityPlanDocEntry`).val(JSONObject[0]['StabilityPlanDocEntry']);

                // 4th row------------------------------------------------------------------------
                        $(`#SIS_Unit`).val(JSONObject[0]['Unit']);
                        $(`#SIS_TotalNoOfContainer`).val(JSONObject[0]['TotalNoOfContainer']);
                        $(`#SIS_FromContainer`).val(JSONObject[0]['FromContainer']);
                        $(`#SIS_ToContainer`).val(JSONObject[0]['ToContainer']);

                // 5th row------------------------------------------------------------------------
                        $(`#SIS_BatchNo`).val(JSONObject[0]['BatchNo']);
                        $(`#SIS_BatchQty`).val(JSONObject[0]['BatchQty']);

                        // <!-- ----------- MFG Date Start Here ----------------------------------- -->
                            var mfgDateOG = JSONObject[0]['MfgDate'];
                            if(mfgDateOG!=''){
                                MfgDate = mfgDateOG.split(' ')[0];
                                $(`#SIS_MfgDate`).val(MfgDate); 
                            }
                        // <!-- ----------- MFG Date End Here ------------------------------------- -->

                        // <!-- ----------- Exp Date Start Here ----------------------------------- -->
                            var expDateOG = JSONObject[0]['ExpDate'];
                            if(expDateOG!=''){
                                ExpDate = expDateOG.split(' ')[0];
                                $(`#SIS_ExpDate`).val(ExpDate); 
                            }
                        // <!-- ----------- Exp Date End Here ------------------------------------- -->

                // 6th row------------------------------------------------------------------------
                        $(`#SIS_StabilityTransferNofromWo`).val(JSONObject[0]['StabilityTransferNofromWo']);
                        $(`#SIS_StabilityTransferEntryfromWo`).val(JSONObject[0]['StabilityTransferEntryfromWo']);

                        // <!-- ----------- Retest Date Start Here ----------------------------------- -->
                            var retestDateOG = JSONObject[0]['RetestDate'];
                            if(retestDateOG!=''){
                                RetestDate = retestDateOG.split(' ')[0];
                                $(`#SIS_RetestDate`).val(RetestDate); 
                            }
                        // <!-- ----------- Retest Date End Here ------------------------------------- -->

                        // <!-- ----------- Stability Loading Date Start Here ----------------------------------- -->
                            var sldDateOG = JSONObject[0]['StabilityLoadingDate'];
                            if(sldDateOG!=''){
                                SldDate = sldDateOG.split(' ')[0];
                                $(`#SIS_StabilityLoadingDate`).val(SldDate); 
                            }
                        // <!-- ----------- Stability Loading Date End Here ------------------------------------- -->

                // 7th row------------------------------------------------------------------------
                        $(`#SIS_Status`).val(JSONObject[0]['Status']);
                        $(`#SIS_Branch`).val(JSONObject[0]['Branch']);
                        $(`#SIS_Location`).val(JSONObject[0]['Location']);

                        //  <!-- --------------- Cancelled Checkbox Set Value Start Here ---------------- -->
                            var Canceled=JSONObject[0]['Canceled'];

                            if(Canceled=='N'){
                                document.getElementById("SIS_StatusChekBox").checked = false; // Uncheck
                            }else{
                                document.getElementById("SIS_StatusChekBox").checked = true; // Check
                            }
                        //  <!-- --------------- Cancelled Checkbox Set Value end Here ---------------- -->

                        // <!-- ----------- TR Loading Date Start Here ----------------------------------- -->
                            var trDateOG = JSONObject[0]['TRDate'];
                            if(trDateOG!=''){
                                TRDate = trDateOG.split(' ')[0];
                                $(`#SIS_TrDate`).val(TRDate); 
                            }
                        // <!-- ----------- TR Loading Date End Here ------------------------------------- -->

                // 8th row------------------------------------------------------------------------
                        $(`#SIS_StabilityType`).val(JSONObject[0]['StabilityType']);
                        $(`#SIS_StabilityCondition`).val(JSONObject[0]['StabilityCondition']);
                        $(`#SIS_StabilityTimePeriod`).val(JSONObject[0]['StabilityTimePeriod']);
                        $(`#SIS_AnalysisType`).val(JSONObject[0]['AnalysisType']);

                // 9th row------------------------------------------------------------------------
                        $(`#SIS_ContainerNos`).val(JSONObject[0]['ContainerNos']);
                        $(`#SIS_Container`).val(JSONObject[0]['Container']);

                // 10th row-----------------------------------------------------------------------
                        $(`#SIS_UnderTestTransferNo`).val(JSONObject[0]['UnderTestTransferNo']);

                // // --------------- bottom popup button hide & show script start here-----------------------
                    if(JSONObject[0]['UnderTestTransferNo']==''){
                        $("#befor").show(); // Add Process Popup
                        $("#after").hide(); // View Process Popup
                    }else{
                        $("#befor").hide(); // Add Process Popup
                        $("#after").show(); // View Process Popup
                    }
                // // --------------- bottom popup button hide & show script end here-----------------------
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function TransToUnder()
    {
        var SupplierCode=document.getElementById('SIS_SupplierCode').value;
        var SupplierName=document.getElementById('SIS_SupplierName').value;
        var BranchName=document.getElementById('SIS_Branch').value;
        var DocEntry=document.getElementById('SIS_DocEntry').value;
        var DocType=document.getElementById('SIS_DocType').value;
        var ItemCode=document.getElementById('SIS_ItemCode').value;
        var ItemName=document.getElementById('SIS_ItemName').value;
        var FromWhse=document.getElementById('SIS_WhsCode').value;
        var ToWhse=document.getElementById('SIS_ToWhse').value;
        var BatchQty=document.getElementById('SIS_BatchQty').value;
        var Location=document.getElementById('SIS_Location').value;
        var UOM=document.getElementById('SIS_Unit').value;

        $(".loader123").show(); // loader show script

        $('#SIS_IT_SupplierCode').val(SupplierCode);
        $('#SIS_IT_SupplierName').val(SupplierName);
        $('#SIS_IT_BranchName').val(BranchName);
        $('#SIS_IT_DocEntry').val(DocEntry);
        $('#SIS_IT_BaseDocType').val(DocType);
        $('#SIS_IT_PostingDate').val('');
        $('#SIS_IT_DocumentDate').val('');
        $('#SIS_ITI_ItemCode').val(ItemCode);
        $('#SIS_ITI_ItemName').val(ItemName);
        $('#SIS_ITI_Quality').val(BatchQty);
        $('#SIS_ITI_FromWhs').val(FromWhse);
        $('#SIS_ITI_ToWhs').val(ToWhse);
        $('#SIS_ITI_Location').val(Location);
        $('#SIS_ITI_UOM').val(UOM);

        getSeriesDropdown() // DocName By using API to get dropdown 
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
            },
            success: function(result)
            {
                var SeriesDropdown = JSON.parse(result);
                $('#SIS_IT_SeriesName').html(SeriesDropdown);
            },
            complete:function(data){
                selectedSeries(); // call Selected Series Single data function
            }
        }); 
    }

    function selectedSeries(){

        var Series=document.getElementById('SIS_IT_SeriesName').value;
        var dataString ='Series='+Series+'&ObjectCode=67&action=getSeriesSingleData_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                var NextNumber=JSONObject[0]['NextNumber'];
                $('#SIS_IT_SeriesNo').val(NextNumber);
            },
            complete:function(data){
                ContainerSelection() // get Container Selection Table List
            }
        }); 
    }

    function ContainerSelection(){

        var ItemCode=document.getElementById('SIS_ItemCode').value;
        var WareHouse=document.getElementById('SIS_WhsCode').value;
        var BatchNo=document.getElementById('SIS_BatchNo').value;
        var DocEntry=document.getElementById('SIS_StabilityTransferEntryfromWo').value;

        var BPLId=document.getElementById('SIS_BPLId').value;

        var dataString ='ItemCode='+ItemCode+'&WareHouse='+WareHouse+'&BatchNo='+BatchNo+'&DocEntry='+DocEntry+'&action=OpenInventoryTransferSIS_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
            },
            success: function(result)
            {
                $('#SIS_IT_BPLId').val(BPLId);
                var JSONObject = JSON.parse(result);
                $('#ContainerSelectionItemAppend').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 

    }

    function getSelectedContener(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionTable_IT");
 
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

    function EnterQtyValidation(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){

                $('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

                getSelectedContener(un_id); // if user change selected Qty value after selection 
            }else{
                $('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
        }
    }

    function SubmitInventoryTransfer(){

        var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
        var item_BQty=parseFloat(document.getElementById('SIS_ITI_Quality').value).toFixed(6);  // item available Qty
        var PostingDate=document.getElementById('SIS_IT_PostingDate').value;
        var DocDate=document.getElementById('SIS_IT_DocumentDate').value;

        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(PostingDate!=''){ // Posting Date validation

                if(DocDate!=''){ // Document Date validation

                // <!-- ---------------- form submit process start here ----------------- -->
                    var formData = new FormData($('#SIS_IT_form')[0]); // form Id
                    formData.append("SubSIS_IT_Btn",'SubSIS_IT_Btn'); // submit btn Id

                    var error = true;
                    
                    if(error)
                    {
                        $.ajax({
                            url: 'ajax/common-ajax.php',
                            type: "POST",
                            data:formData,
                            processData: false,
                            contentType: false,
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
                                            location.replace(window.location.href); //ok btn
                                        }else{
                                            location.replace(window.location.href); // cancel btn
                                        }
                                    });
                                }else{
                                    swal("Oops!", `${message}`, "error");
                                }
                            },complete:function(data){
                                $(".loader123").hide();
                            }
                        });
                    }
                // <!-- ---------------- form submit process end here ------------------- -->
                }else{
                    swal("Oops!", "Please Select a Document Date.", "error");
                }

            }else{
                swal("Oops!", "Please Select a Posting Date.", "error");
            }

        }else{
            swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
        }
    }

    function TransToUnderAfter(){

        var DocEntry=document.getElementById('SIS_UnderTestTransferNo').value;
        var Location=document.getElementById('SIS_Location').value;

        var dataString ='DocEntry='+DocEntry+'&action=SIRTIT_View_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {  
                var JSONObject= JSON.parse(result);
                $('#SIS_IT_View').html(JSONObject);

                document.getElementById("SIRTIT_View_Locatio").innerHTML = Location; // set Item Table Location value
            },
            complete:function(data){
                var Series=document.getElementById('SIRTIT_View_Series').value; // get Series Id 
                getSeriesDataViewMood(Series); // get Series Name Using Series Code
            }
        }); 
    }

    function getSeriesDataViewMood(Series){

        var dataString ='Series='+Series+'&ObjectCode=67&action=getSeriesSingleData_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                var Series_Name=JSONObject[0]['SeriesName'];
        
                $('#SIRTIT_View_Series_Name').val(Series_Name);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }
</script>