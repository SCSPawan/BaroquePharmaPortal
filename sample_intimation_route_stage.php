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

    $getAllData=$obj->getSimpleIntimation($ROUTESTAGESAMPLEINTIMATIONADD_API,$tdata);

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
                        <th>Sr. No </th>  
                        <th>Item View</th>
                        <th>DocEntry</th>
                        <th>WO No</th>
                        <th>WOEntry</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Stage Name</th>
                        <th>Batch No</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Warehouse</th>
                        <th>WO Date</th>
                        <th>MFG Date</th>
                        <th>Expiry Date</th>
                        <th>Location</th>
                        <th>Branch Name</th
                    </tr>
                </thead>
                <tbody>';
 
                if(count($getAllData)!='0'){
                    for ($i=$r_start; $i <$r_end ; $i++) { 
                        if(!empty($getAllData[$i]->DocEntry)){   //  this condition save to extra blank loop
                            $SrNo=$i+1;
                            // --------------- Convert String code Start Here ---------------------------
                                if(empty($getAllData[$i]->WODate)){
                                    $WODate='';
                                }else{
                                    $WODate=date("d-m-Y", strtotime($getAllData[$i]->WODate));
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
                            // --------------- Convert String code End Here-- ---------------------------

                        $option.='
                            <tr>
                                <td class="desabled">'.$SrNo.'</td>
                                <td style="text-align: center;">
                                    <input type="radio" id="list'.$getAllData[$i]->DocEntry.'" name="listRado" value="'.$getAllData[$i]->DocEntry.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord('.$getAllData[$i]->DocEntry.')">
                                </td>

                                <td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                <td class="desabled">'.$getAllData[$i]->WoEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->RouteStage.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->unit.'</td>
                                <td class="desabled">'.$getAllData[$i]->WareHouse.'</td>
                                <td class="desabled">'.$WODate.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->Location.'</td>
                                <td class="desabled">'.$getAllData[$i]->Branch.'</td>
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
<?php include 'models/qc_process/sample_intimation_route_stage_model.php' ?>

    <style type="text/css">
        body[data-layout=horizontal] .page-content {
            padding: 20px 0 0 0;
            padding: 40px 0 60px 0;
        }
        .border_hide{
            background: #efefef !important;
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
                                <h4 class="mb-0">Sample Intimation - Route Stage</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Sample Intimation - Route Stage</li>
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
                                    <h4 class="card-title mb-0">Sample Intimation - Route Stage</h4> 
                                </div><!-- end card header -->

                                <div class="card-body">

                                    <div class="top_filter">
                                        <div class="row">

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">From Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="FromDate" name="FromDate" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d').'-3 days'))?>" >
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
                                                    <div class="col-lg-4" style="">
                                                        <div class="">
                                                            <button type="button" style="top: 0px;" id="SearchBlock" class="btn btn-primary waves-effect" onclick="SearchData()">Search <i class="bx bx-search-alt align-middle"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive" id="list-append">
                                        <!-- Table data list append Here -->
                                    </div> 
            
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                        
                    <div class="row" id="footerProcess">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form role="form" class="form-horizontal" id="SampleIntimationRouteStageUpdateForm" method="post">
                                        <div class="row">

                                            <input type="hidden" id="SIRSU_SeriesId" name="SIRSU_SeriesId">
                                            <input type="hidden" id="SIRSU_StatusChekBox_val" name="SIRSU_StatusChekBox_val">
                                            <input type="hidden" id="SIRSU_LineNum" name="SIRSU_LineNum">
                                            <input type="hidden" id="SIRSU_LocId" name="SIRSU_LocId">
                                            <input type="hidden" id="SIRSU_QtyPerCont" name="SIRSU_QtyPerCont">
                                            <input type="hidden" id="SIRSU_BPLId" name="SIRSU_BPLId">
                                            <input type="hidden" id="SIRSU_WareHouse" name="SIRSU_WareHouse">

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                     <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="SIRSU_ReceiptNo" name="SIRS_ReceiptNo" readonly>
                                                    </div>
                                                     <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="SIRSU_ReceiptEntry" name="SIRS_ReceiptEntry" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="SIRSU_DocNoName" name="SIRSU_DocNoName" readonly>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input class="form-control desabled" type="text" id="SIRSU_DocNo" name="SIRSU_DocNo" readonly>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input class="form-control desabled" type="text" id="SIRSU_DocEntry" name="SIRSU_DocEntry" value="" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="SIRSU_WONo" name="SIRSU_WONo" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="SIRSU_WOEntry" name="SIRSU_WOEntry" value="" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Route/Stage</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_RouteStage" name="SIRSU_RouteStage" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_SampleType" name="SIRSU_SampleType" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                                                    <div class="col-lg-8">
                                                         <input class="form-control desabled" type="text" id="SIRSU_TrBy" name="SIRSU_TrBy" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_ItemCode" name="SIRSU_ItemCode" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_ItemName" name="SIRSU_ItemName" readonly>
                                                    </div>
                                                </div>
                                            </div>   

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_WoQty" name="SIRSU_WoQty" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="number" id="SIRSU_SampleQty" name="SIRSU_SampleQty">
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="number" id="SIRSU_RetainQty" name="SIRSU_RetainQty">
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Unit</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_Unit" name="SIRSU_Unit" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_BatchNo" name="SIRSU_BatchNo" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_BatchQty" name="SIRSU_BatchQty" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_MfgDate" name="SIRSU_MfgDate" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_ExpiryDate" name="SIRSU_ExpiryDate" readonly>
                                                    </div>
                                                </div>
                                            </div>      

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_WoDate" name="SIRSU_WoDate" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Total No Of Container</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control desabled" type="text" id="SIRSU_TotNoCont" name="SIRSU_TotNoCont" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_FromCont" name="SIRSU_FromCont" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_ToCont" name="SIRSU_ToCont" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="SIRSU_Status" name="SIRSU_Status" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="SIRSU_StatusChekBox" name="SIRSU_StatusChekBox" style="pointer-events: none;">
                                                            <label class="form-check-label" for="flexCheckDefault">Cancelled</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_TrDate" name="SIRSU_TrDate" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_Branch" name="SIRSU_Branch" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_Location" name="SIRSU_Location" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_Container" name="SIRSU_Container" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container Nos</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_ContainerNos" name="SIRSU_ContainerNos" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_ChallanNo" name="SIRSU_ChallanNo" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_ChallanDate" name="SIRSU_ChallanDate" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_GateEntryNo" name="SIRSU_GateEntryNo" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SIRSU_GateEntryDate" name="SIRSU_GateEntryDate" readonly>
                                                    </div>
                                                </div>
                                            </div> 
              
                                            <!-- <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Print Undertest Label</button>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Print Quarantine</button>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Print Sample Intimation</button>
                                                </div>
                                            </div> -->
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-primary " id="SampleIntimationRouteStageUpdateBtn" name="SampleIntimationRouteStageUpdateBtn" data-bs-toggle="button" autocomplete="off" onclick="SendSampleIntimationRouteStageDataUpdate()">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
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
                $('#list-append').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
       });
    }

    function selectedRecord(DocEntry)
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'DocEntry':DocEntry,'action':"sample_intimation_RS_Selected_row"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                $("#footerProcess").show(); // Afer Doc Selection Process show script

                var JSONObject = JSON.parse(result);

                $(`#SIRSU_ReceiptNo`).val(JSONObject[0]['ReceiptNo']);
                $(`#SIRSU_ReceiptEntry`).val(JSONObject[0]['ReceiptEntry']);
                $('#SIRSU_DocNo').val(JSONObject[0]['DocNum']);
                $(`#SIRSU_WONo`).val(JSONObject[0]['WONo']);
                $(`#SIRSU_WOEntry`).val(JSONObject[0]['WoEntry']);
                $(`#SIRSU_DocEntry`).val(JSONObject[0]['DocEntry']);
                $(`#SIRSU_RouteStage`).val(JSONObject[0]['RouteStage']);
                $(`#SIRSU_SampleType`).val(JSONObject[0]['SampleType']);
                $(`#SIRSU_TrBy`).val(JSONObject[0]['TRBy']);
                $(`#SIRSU_ItemCode`).val(JSONObject[0]['ItemCode']);
                $(`#SIRSU_ItemName`).val(JSONObject[0]['ItemName']);
                $(`#SIRSU_WoQty`).val(JSONObject[0]['WOQty']);
                $(`#SIRSU_SampleQty`).val(JSONObject[0]['SampleQty']);
                $(`#SIRSU_RetainQty`).val(JSONObject[0]['RetainQty']);
                $(`#SIRSU_Unit`).val(JSONObject[0]['unit']);
                $(`#SIRSU_BatchNo`).val(JSONObject[0]['BatchNo']);
                $(`#SIRSU_BatchQty`).val(JSONObject[0]['BatchQty']);
                $(`#SIRS_WoQty`).val(JSONObject[0]['TotNoCont']);
                $(`#SIRSU_TotNoCont`).val(JSONObject[0]['WOQty']);
                $(`#SIRSU_FromCont`).val(JSONObject[0]['FCont']);
                $(`#SIRSU_ToCont`).val(JSONObject[0]['TCont']);
                $(`#SIRSU_Status`).val(JSONObject[0]['Status']);
                $(`#SIRSU_Branch`).val(JSONObject[0]['Branch']);
                $(`#SIRSU_Location`).val(JSONObject[0]['Location']);
                $(`#SIRSU_Container`).val(JSONObject[0]['Container']);
                $(`#SIRSU_ContainerNos`).val(JSONObject[0]['ContainerNos']);
                $(`#SIRSU_ChallanNo`).val(JSONObject[0]['challanNo']);
                $(`#SIRSU_GateEntryNo`).val(JSONObject[0]['GateEntryNo']);

                // <!-- ----------- MfgDate Start Here ----------------------- -->
                    var mfgDateOG = JSONObject[0]['MfgDate'];
                    if(mfgDateOG!=''){
                        MfgDate = mfgDateOG.split(' ')[0];
                        $(`#SIRSU_MfgDate`).val(MfgDate);
                    }
                // <!-- ----------- MfgDate End Here ------------------------- -->

                // <!-- ----------- Expiry Date Start Here ----------------------- -->
                    var expiryDateOG = JSONObject[0]['ExpDate'];
                    if(mfgDateOG!=''){
                        ExpiryDate = expiryDateOG.split(' ')[0];
                        $(`#SIRSU_ExpiryDate`).val(ExpiryDate);
                    }
                // <!-- ----------- Expiry Date End Here --------------------------- -->

                // <!-- ----------- WO Date Start Here ----------------------- -->
                    var woDateOG = JSONObject[0]['WODate'];
                    if(woDateOG!=null){
                        woDate = woDateOG.split(' ')[0];
                        $(`#SIRSU_WoDate`).val(woDate);
                    }
                // <!-- ----------- WO Date End Here --------------------------- -->

                // <!-- ----------- TR Date Start Here ----------------------- -->
                    var tRDateOG = JSONObject[0]['TRDate'];
                    if(tRDateOG !=''){
                        TRDateOG = tRDateOG.split(' ')[0];
                        $(`#SIRSU_TrDate`).val(TRDateOG);
                    }
                // <!-- ----------- TR Date End Here ------------------------- -->

                // <!-- ----------- Challan Date Start Here ----------------------- -->
                    var challanDateOG = JSONObject[0]['ChallanDate'];
                    if(challanDateOG !=''){
                        ChallanDateOG = challanDateOG.split(' ')[0];
                        $(`#SIRSU_ChallanDate`).val(ChallanDateOG);
                    }
                // <!-- ----------- Challan Date End Here ------------------------- -->

                // <!-- ----------- GateEnrty Date Start Here ----------------------- -->
                    var gateEntryDateOG = JSONObject[0]['GateEntryDate'];
                    if(gateEntryDateOG !=''){
                        GateEntryDateOG = gateEntryDateOG.split(' ')[0];
                        $(`#SIRSU_GateEntryDate`).val(GateEntryDateOG);
                    }
                // <!-- ----------- GateEnrty Date End Here ------------------------- -->

                //  <!-- --------------- Cancelled Checkbox Set Value Start Here ---------------- -->
                    var Canceled=JSONObject[0]['Canceled'];

                    if(Canceled=='N'){
                        document.getElementById("SIRSU_StatusChekBox").checked = false; // Uncheck
                        $(`#SIRSU_StatusChekBox_val`).val(Canceled);
                    }else{
                        document.getElementById("SIRSU_StatusChekBox").checked = true; // Check
                        $(`#SIRSU_StatusChekBox_val`).val(Canceled);
                    }
                //  <!-- --------------- Cancelled Checkbox Set Value end Here ---------------- -->

                // <!-- --------------------- Hidden Field Start Here ------------------------- -->
                    $(`#SIRSU_LineNum`).val(JSONObject[0]['LineNum']);
                    $(`#SIRSU_LocId`).val(JSONObject[0]['LocId']);
                    $(`#SIRSU_QtyPerCont`).val(JSONObject[0]['QtyPerCont']);
                    $(`#SIRSU_BPLId`).val(JSONObject[0]['BPLId']);
                    $(`#SIRSU_WareHouse`).val(JSONObject[0]['WareHouse']);
                // <!-- --------------------- Hidden Field End Here --------------------------- -->

                getSeriesData(JSONObject[0]['Series']) // DocName By using API to get dropdown 
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function getSeriesData(Series){
        var TrDate = $('#SIRSU_TrDate').val();
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_SIRSTAGE&action=getSeriesSingleData_ajax';

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
                console.log(result);
                var JSONObject = JSON.parse(result);

                var Series=JSONObject[0]['Series'];
                var SeriesName=JSONObject[0]['SeriesName'];

                $('#SIRSU_DocNoName').val(SeriesName);
                $('#SIRSU_SeriesId').val(Series);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function SendSampleIntimationRouteStageDataUpdate(){

        var formData = new FormData($('#SampleIntimationRouteStageUpdateForm')[0]);  // Form Id
        formData.append("SampleIntimationRouteStageUpdateBtn",'SampleIntimationRouteStageUpdateBtn');  // Button Id
        var error = true;

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
</script>