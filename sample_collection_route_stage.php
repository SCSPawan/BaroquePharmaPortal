<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list'){
    $tdata=array();
    $tdata['FromDate']=date('Ymd', strtotime($_POST['fromDate']));
    $tdata['ToDate']=date('Ymd', strtotime($_POST['toDate']));
    $tdata['DocEntry']=trim(addslashes(strip_tags($_POST['DocEntry'])));

    $getAllData=$obj->getSimpleCollection($RSSAMPCOLLADD_API,$tdata);

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
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
                        <th>Sapmle Intimation No</th>
                        <th>Location</th>
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
                                    $MfgDate=date("d-m-Y", strtotime($getAllData[$i]->MfgDate));
                                }

                                if(empty($getAllData[$i]->ExpDate)){
                                    $ExpDate='';
                                }else{
                                    $ExpDate=date("d-m-Y", strtotime($getAllData[$i]->ExpDate));
                                }

                                if(empty($getAllData[$i]->WoDate)){
                                    $WoDate='';
                                }else{
                                    $WoDate=date("d-m-Y", strtotime($getAllData[$i]->WoDate));
                                }
                            // --------------- Convert String code End Here-- ---------------------------

                        $option.='<tr>
                                <td class="desabled">'.$SrNo.'</td>

                                <td style="text-align: center;">
                                    <input type="radio" id="list'.$getAllData[$i]->DocEntry.'" name="listRado" value="'.$getAllData[$i]->DocEntry.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord('.$getAllData[$i]->DocEntry.')"  style="width: 17px;height: 17px;">
                                </td>
                                <td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->WoNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->WoEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->StageName.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                <td class="desabled">'.$getAllData[$i]->WareHouse.'</td>
                                <td class="desabled">'.$WoDate.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->Loction.'</td>
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
<?php include 'models/qc_process/sample_collection_route_stage_model.php' ?>
    <style type="text/css">
        body[data-layout=horizontal] .page-content {padding: 20px 0 0 0;padding: 40px 0 60px 0;}
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
                                <h4 class="mb-0">Sample Collection - Route/Stage</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Sample Collection - Route/Stage</li>
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
                                <h4 class="card-title mb-0">Sample Collection - Route/Stage</h4> 
                            </div>

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

                <!-- START -->
                    <form role="form" class="form-horizontal" id="SampleCollectionRouteStageUpdateForm" method="post">
                        <br>
                        <div class="row" id="footerFirst">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="SCRS_DocType" name="SCRS_DocType">
                                            <input type="hidden" id="SCRS_Series" name="SCRS_Series">
                                            <input type="hidden" id="SCRS_LineNo" name="SCRS_LineNo">
                                            <input type="hidden" id="SCRS_BPLId" name="SCRS_BPLId">
                                            <input type="hidden" id="SCRS_LocCode" name="SCRS_LocCode">
                                            <input type="hidden" id="SCRS_WareHouse" name="SCRS_WareHouse">

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingrediant Type</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_IngrediantType" name="SCRS_IngrediantType" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="SCRS_WONo" name="SCRS_WONo" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="SCRS_WOEntry" name="SCRS_WOEntry" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="SCRS_DocNoName" name="SCRS_DocNoName" readonly>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input class="form-control desabled" type="text" id="SCRS_DocNo" name="SCRS_DocNo" readonly>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input class="form-control desabled" type="text" id="SCRS_DocEntry" name="SCRS_DocEntry" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Route/Stage</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_StageName" name="SCRS_StageName" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                                                                    
                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_IntimatedBy" name="SCRS_IntimatedBy" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_IntimatedDate" name="SCRS_IntimatedDate" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                                                    <div class="col-lg-5">
                                                        <input class="form-control desabled" type="text" id="SCRS_SampleQty" name="SCRS_SampleQty" readonly>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <input class="form-control desabled" type="text" id="SCRS_SampleQtyUOM" name="SCRS_SampleQtyUOM" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                                    <div class="col-lg-7">
                                                        <input class="form-control desabled" type="text" id="SCRS_SampleCollectBy" name="SCRS_SampleCollectBy" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_ARNo" name="SCRS_ARNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_DocDate" name="SCRS_DocDate" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_TRNo" name="SCRS_TRNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_Branch" name="SCRS_Branch" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_Location" name="SCRS_Location" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_ItemCode" name="SCRS_ItemCode" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_ItemName" name="SCRS_ItemName" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_BatchNo" name="SCRS_BatchNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_BatchQty" name="SCRS_BatchQty" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="SCRS_TotalNoContainer" name="SCRS_TotalNoContainer" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>  
                            </div>  
                        </div>  

                        <br>   
                        <div class="row" id="footerSecond">
                            <div class="col-xl-12">
                                <div class="card">                                
                                    <div class="card-body">
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

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="samp_details" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-6 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                            <div class="col-lg-3">
                                                                <input type="text" id="SCRS_SCD_RetainQty" name="SCRS_SCD_RetainQty" class="form-control desabled" readonly>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <input type="text" id="SCRS_SCD_RetainQtyUom" name="SCRS_SCD_RetainQtyUom" class="form-control desabled" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container No</label>
                                                            <div class="col-lg-8 container_input" style="display: inline-flex;">
                                                                <input type="text" id="SCRS_SCD_Cont1" name="SCRS_SCD_Cont1" class="form-control desabled" readonly>
                                                                <input type="text" id="SCRS_SCD_Cont2" name="SCRS_SCD_Cont2" class="form-control ">
                                                                <input type="text" id="SCRS_SCD_Cont3" name="SCRS_SCD_Cont3" class="form-control">
                                                             </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Qty For Label</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" id="SCTS_SCD_QtyforLabel" name="SCTS_SCD_QtyforLabel" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-wrap gap-2">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Sample Label</button>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="home" role="tabpanel">
                                                <div class="table-responsive" id="list">
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
                                                                <th>Inventory Transfer</th> 
                                                                <th>UserText 1</th>
                                                                <th>UserText 2</th>
                                                                <th>UserText 3</th>
                                                                <th>Attachment</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="External-issue-list-append">
                                                            <!-- // Bottom tab layout External issue record appned here -->
                                                        </tbody>
                                                    </table>
                                                </div> 
                                                <div class="d-flex flex-wrap gap-2">
                                                     <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Sleep</button>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="profile" role="tabpanel">
                                                <div class="table-responsive" id="list">
                                                    <table id="Tbl_SC_ExtraIssue" class="table sample-table-responsive table-bordered" style="">
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
                                                            <!-- // Bottom tab layout extra issue record appned here -->
                                                        </tbody>
                                                   </table>
                                                </div> 
                                                <div class="d-flex flex-wrap gap-2">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Issue Slip</button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="button" class="btn btn-primary" id="SampleCollectionRouteStageUpdateForm_Btn" name="SampleCollectionRouteStageUpdateForm_Btn" onclick="SampleCollectionRouteStageUpdateForm()">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <!-- END -->
                    </div>
                </div>

            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <br>
    <?php include 'include/footer.php' ?>
             

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

<script type="text/javascript">
    // <!-- -------------- Direct called function diclear Start Here --------------------------------
        $(".loader123").hide(); // loader default hide script
        $("#footerFirst").hide(); // hide footer 1st section script
        $("#footerSecond").hide(); // hide footer 2st section script
    // <!-- -------------- Direct called function diclear End Here ----------------------------------

    $(document).ready(function(){
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
            success: function(result){   
                $('#list-append').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    });

    function change_page(page_id){ 
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
            success: function(result){
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
            success: function(result){  
                $("#footerFirst").hide(); //bottom section hide
                $("#footerSecond").hide(); //bottom section hide

                $('#list-append').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function selectedRecord(DocEntry){
        // ----------------------------- Table tr count inside tbody start here -------------------
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
        // ----------------------------- Table tr count inside tbody end here ---------------------
          
        // ----------------------------- Table tr count inside tbody start here -------------------
            var totalRowCount_N = 0;
            var rowCount_N = 0;
            var table_N = document.getElementById("Tbl_SC_ExtraIssue");
            var rows_N = table_N.getElementsByTagName("tr")
            for (var i = 0; i < rows_N.length; i++) {
                totalRowCount_N++;
                if (rows_N[i].getElementsByTagName("td").length > 0) {
                    rowCount_N++;
                }
            }
        // ----------------------------- Table tr count inside tbody end here ---------------------

        var dataString ='DocEntry='+DocEntry+'&rowCount='+rowCount+'&rowCount_N='+rowCount_N+'&action=sample_collection_route_stage_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/common-ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                
                // console.log(result);
                $("#footerFirst").show();
                $("#footerSecond").show();

                var JSONObjectAll = JSON.parse(result);
                var JSONObject=JSONObjectAll['SampleCollDetails'];

                $(`#Extra-issue-list-append`).html(JSONObjectAll['ExtraIssue']); // Extra Issue Table Tr tag append here
                $(`#External-issue-list-append`).html(JSONObjectAll['ExternalIssue']); // External Issue Table Tr tag append here

                // <!-- ----------------- Bottom Hidden Field start here ------------------------------------- -->
                    $(`#SCRS_DocType`).val(JSONObject[0]['DocType']);
                    $(`#SCRS_Series`).val(JSONObject[0]['Series']);
                    $(`#SCRS_LineNo`).val(JSONObject[0]['LineNo']);
                    $(`#SCRS_BPLId`).val(JSONObject[0]['BPLId']);
                    $(`#SCRS_LocCode`).val(JSONObject[0]['LocCode']);
                    $(`#SCRS_WareHouse`).val(JSONObject[0]['WareHouse']);
                // <!-- ----------------- Bottom Hidden Field end here --------------------------------------- -->

                // <!-- ----------------- first section data mapping start hide------------------------------- -->
                    // 1st line
                    $(`#SCRS_IngrediantType`).val(JSONObject[0]['IngredientType']);
                    $(`#SCRS_WONo`).val(JSONObject[0]['WoNo']);
                    $(`#SCRS_WOEntry`).val(JSONObject[0]['WoEntry']);
                    $(`#SCRS_DocNoName`).val(JSONObject[0]['SeriesName']);
                    $(`#SCRS_DocNo`).val(JSONObject[0]['DocNum']);
                    $(`#SCRS_DocEntry`).val(JSONObject[0]['DocEntry']);
                    $(`#SCRS_StageName`).val(JSONObject[0]['StageName']);

                    // 2nd line
                    $(`#SCRS_IntimatedBy`).val(JSONObject[0]['IntimatedBy']);
                    $(`#SCRS_SampleQty`).val(JSONObject[0]['SampleQty']);
                    $(`#SCRS_SampleQtyUOM`).val(JSONObject[0]['SampleQtyUnit']);
                    $(`#SCRS_SampleCollectBy`).val(JSONObject[0]['SampleCollectBy']);

                    //3rd line
                    $(`#SCRS_ARNo`).val(JSONObject[0]['ARNo']);
                    $(`#SCRS_TRNo`).val(JSONObject[0]['TRNo']);
                    $(`#SCRS_Branch`).val(JSONObject[0]['Branch']);

                    // 4th line
                    $(`#SCRS_Location`).val(JSONObject[0]['Loction']);
                    $(`#SCRS_ItemCode`).val(JSONObject[0]['ItemCode']);
                    $(`#SCRS_ItemName`).val(JSONObject[0]['ItemName']);
                    $(`#SCRS_BatchNo`).val(JSONObject[0]['BatchNo']);

                    // 5th line
                    $(`#SCRS_BatchQty`).val(JSONObject[0]['BatchQty']);
                    $(`#SCRS_TotalNoContainer`).val(JSONObject[0]['NoofCont']);
                // <!-- ----------------- first section data mapping end hide--------------------------------- -->

                // <!-- ----------- Intimation Date Start Here ----------------------------------------------- -->
                    var intimationDateOG = JSONObject[0]['IntimationDate'];
                    if(intimationDateOG!=''){
                        intimationDate = intimationDateOG.split(' ')[0];
                        $(`#SCRS_IntimatedDate`).val(intimationDate); 
                    }
                // <!-- ----------- Intimation Date End Here ------------------------------------------------- -->

                // <!-- ----------- Challan Date Start Here ------------------------------------------------- -->
                    var docDateOG = JSONObject[0]['DocDate'];
                    if(docDateOG!=''){
                        docDate = docDateOG.split(' ')[0];
                        $(`#SCRS_DocDate`).val(docDate); 
                    }
                // <!-- ----------- Challan Date End Here --------------------------------------------------- -->

                // <!-- -------------- Sample Collection Details Tab Start Here ----------------------------- -->
                    $(`#SCRS_SCD_RetainQty`).val(JSONObject[0]['RetainQty']);
                    $(`#SCRS_SCD_RetainQtyUom`).val(JSONObject[0]['RetainQtyUom']);
                    $(`#SCRS_SCD_Cont1`).val(JSONObject[0]['Cont1']);
                    $(`#SCRS_SCD_Cont2`).val(JSONObject[0]['Cont2']);
                    $(`#SCRS_SCD_Cont3`).val(JSONObject[0]['Cont3']);
                    $(`#SCTS_SCD_QtyforLabel`).val(JSONObject[0]['QtyforLabel']);
                // <!-- -------------- Sample Collection Details Tab End Here ------------------------------- -->

                $('.ExternalIssueSelectedBPWithData').select2();// with data supplier dropdown
                $('.ExternalIssueDefault').select2();// default supplier dropdown

                $('.ExternalIssueWareHouseDefault').select2();// with data supplier dropdown
                $('.ExternalIssueWareHouseWithData').select2();// default supplier dropdown

                $('.SC_FEI_WarehouseDefault').select2();// with data supplier dropdown
                $('.SC_FEI_WarehouseWithData').select2();// default supplier dropdown
            },
            complete:function(data){
                getSupplierDropdown(totalRowCount);
                getWareHouseDropdown(totalRowCount);

                getWareHouseExtraIssueDropdown(totalRowCount_N);
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
            },
            success: function(result){  
                var JSONObject = JSON.parse(result);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=totalRowCount; 
                    $('#SC_ExternalI_SupplierCode'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
            },
            complete:function(data){
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
            },
            success: function(result){  
                var JSONObject = JSON.parse(result);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=totalRowCount; 
                    $('#SC_ExternalI_Warehouse'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
            },
            complete:function(data){
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
            },
            success: function(result){  
                var JSONObject = JSON.parse(result);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=totalRowCount_N;
                    $('#SC_FEI_Warehouse'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function ExternalIssueSelectedBP(un_id){
        var SupplierCode=document.getElementById('SC_ExternalI_SupplierCode'+un_id).value;
        var dataString ='SupplierCode='+SupplierCode+'&action=SupplierSingleData_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/common-ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){  
                var JSONObject = JSON.parse(result);
                $('#SC_FEXI_SupplierName'+un_id).val(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function SampleCollectionRouteStageUpdateForm(){
        // alert('1');
        var formData = new FormData($('#SampleCollectionRouteStageUpdateForm')[0]); // form Id
        // alert('2');
        formData.append("SampleCollectionRouteStageUpdateForm_Btn",'SampleCollectionRouteStageUpdateForm_Btn'); // submit btn Id
        // alert('3');
        var error = true;
        // alert('4');

        $.ajax({
            url: 'ajax/common-ajax.php',
            type: "POST",
            data:formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
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
</script>