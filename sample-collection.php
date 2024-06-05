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

    $getAllData=$obj->getSimpleCollection($SAMPLECOLL_API,$tdata);

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
                                if(empty($getAllData[$i]->U_MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $U_MfgDate = str_replace('/', '-', $getAllData[$i]->U_MfgDate); 
                                    // All (/) replace to (-)
                                    $MfgDate=date("d-m-Y", strtotime($U_MfgDate));
                                }

                                if(empty($getAllData[$i]->U_ExpDate)){
                                    $ExpiryDate='';
                                }else{
                                    $U_ExpDate = str_replace('/', '-', $getAllData[$i]->U_ExpDate); 
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
                                <td class="desabled">'.$getAllData[$i]->GRPONo.'</td>
                                <td class="desabled">'.$getAllData[$i]->GRPODEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->SupplierCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->SupplierName.'</td>
                                <td class="desabled">'.$getAllData[$i]->BPRefNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BaseLine.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->SampleUnit.'</td>
                                <td class="desabled">'.$getAllData[$i]->GRNQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpiryDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->IntimationNo.'</td>
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
<?php include 'models/sample-collection-model.php' ?>

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

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header justify-content-between d-flex align-items-center">
                                        <h4 class="card-title mb-0">Sample Collection</h4> 
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

                                        <div class="table-responsive" id="list-append">
                                            <!-- // page record appned here -->
                                        </div> 
 
                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

<form role="form" class="form-horizontal" id="SampleCollectionUpdateForm" method="post">
                        <div class="row" id="footerProcess">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <form>
                                            <!-- Hidden input start here ------------------------------------------------  -->
                                                <input type="hidden" id="SCF_SupplierCode" name="SCF_SupplierCode">
                                                <input type="hidden" id="SCF_SupplierName" name="SCF_SupplierName">
                                                <input type="hidden" id="SCF_CollDocEntry" name="SCF_CollDocEntry">
                                                <input type="hidden" id="SCF_BPLId" name="SCF_BPLId">
                                                <input type="hidden" id="SCF_GRPO_DocEntry" name="SCF_GRPO_DocEntry">
                                                <input type="hidden" id="SCF_GRPO_LocCode" name="SCF_GRPO_LocCode">
                                                <input type="hidden" id="SCF_GRPO_BatchQty" name="SCF_GRPO_BatchQty">
                                                <input type="hidden" id="SCF_GRPO_BaseLine" name="SCF_GRPO_BaseLine">
                                                <input type="hidden" id="SCF_SampleUnit" name="SCF_SampleUnit">
                                                <input type="hidden" id="SCF_UserCode" name="SCF_UserCode">
                                            <!-- Hidden input end here ------------------------------------------------  -->
                                            <div class="row">

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingrediant Type</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_IngrediantType" name="SCF_IngrediantType">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRN No</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_GRNNo" name="SCF_GRNNo">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_Location" name="SCF_Location">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_IntimatedBy" name="SCF_IntimatedBy">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_IntimatedDate" name="SCF_IntimatedDate">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_SampleQty" name="SCF_SampleQty">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                                        <div class="col-lg-7">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_SampleCollectBy" name="SCF_SampleCollectBy">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_ARNo" name="SCF_ARNo">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Recieved Sepretly</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_SampleReSep" name="SCF_SampleReSep">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_DocDate" name="SCF_DocDate">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_TRNo" name="SCF_TRNo">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_Branch" name="SCF_Branch">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_ItemCode" name="SCF_ItemCode">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_ItemName" name="SCF_ItemName">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_BatchNo" name="SCF_BatchNo">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-5 col-form-label mt-6" for="val-skill">No. Of Container</label>
                                                        <div class="col-lg-7">
                                                            <input class="form-control desabled" readonly type="text" id="SCF_NoOfContainer" name="SCF_NoOfContainer">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" type="text" id="SCF_MaterialType" name="SCF_MaterialType" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" type="text" id="SCF_MakeBy" name="SCF_MakeBy" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                            </div>

                        <br><br>    
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
        
                                        <!-- Tab panes -->

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="samp_details" role="tabpanel">
                                                <!-- form start -->
                                                <form>
                                                     <div class="row">

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">UnderTest Transfer No</label>
                                                                <div class="col-lg-6">
                                                                    <input type="text" id="SC_SCD_UTTransNo" name="SC_SCD_UTTransNo" class="form-control desabled" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                 <div class="col-md-5">
                                                                    <button type="button" id="SC_SCD_SampleIssue_Btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".goods_issue" onclick="SC_SCD_GI_SampleIssuePoP();">Sample Issue</button>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                    <input type="text" id="SC_SCD_SampleIssue" name="SC_SCD_SampleIssue" class="form-control  desabled" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                 <label class="col-lg-4 col-form-label mt-6" for="val-skill">Date of Reversal</label>
                                                                <div class="col-lg-8 container_input">
                                                                    <input type="date" id="SC_SCD_DateOfReversal" name="SC_SCD_DateOfReversal" class="form-control">
                                                                 </div>
                                                            </div>
                                                        </div> -->

                                                        <!-- <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <div class="col-md-7">
                                                                    <button type="button" id="SC_SCD_RevSampleIssue_Btn" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" onclick="OnclickReverseSampleIssue()">Reverse Sample Issue</button>
                                                                </div>
                                                                <div class="col-lg-5 container_input">
                                                                    <input type="text" id="SC_SCD_RevSampleIssue" name="SC_SCD_RevSampleIssue" class="form-control desabled" >
                                                                 </div>
                                                            </div>
                                                        </div> -->

                                                    </div>

                                                    <div class="row">

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-6 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                                <div class="col-lg-3">
                                                                    <input type="text" id="SC_SCD_RQty" name="SC_SCD_RQty" class="form-control desabled" readonly>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <input type="text" id="SC_SCD_RQtyUOM" name="SC_SCD_RQtyUOM" class="form-control desabled" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
<div class="col-md-5">
    

    <button type="button" id="SC_SCD_RetainIssue_Btn" class="pad_btn btn btn-primary"data-bs-toggle="modal" data-bs-target=".inventory_transfer" style="padding: 7px 5px 7px 5px;" onclick="OpenGoodsIssueRetainsIssue();">Retain Issue</button>

    <!-- <button type="button" id="SC_SCD_RetainIssue_Btn" class="pad_btn btn btn-primary"data-bs-toggle="modal" data-bs-target=".goods_issue" style="padding: 7px 5px 7px 5px;" onclick="OpenGoodsIssueRetainsIssue();">Retain Issue</button> -->
</div>
                                                                <div class="col-lg-7 container_input">
                                                                    <input type="text" id="SC_SCD_RetainIssue" name="SC_SCD_RetainIssue" class="form-control desabled" readonly>
                                                                 </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container No</label>
                                                                <div class="col-lg-8 container_input" style="display: inline-flex;">
                                                                    <input type="text" id="SC_SCD_ContainerNo1" name="SC_SCD_ContainerNo1" class="form-control " >
                                                                    <input type="text" id="SC_SCD_ContainerNo2" name="SC_SCD_ContainerNo2" class="form-control ">
                                                                    <input type="text" id="SC_SCD_ContainerNo3" name="SC_SCD_ContainerNo3" class="form-control ">
                                                                 </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Qty For Label</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" id="SC_SCD_QtyForLabel" name="SC_SCD_QtyForLabel" class="form-control ">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                     
                                                </form>        
                                                <!-- form end -->
                                                <div class="d-flex flex-wrap gap-2">

                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_quarantine" autocomplete="off" onclick="ViewSampleForAnalysisLabel_RPT();">Sample for Analysis Label</button>

                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_quarantine" autocomplete="off" onclick="ViewSampleLabel_RPT();">Sample Label</button>
                                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Sample for Analysis Label</button> 

                                                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Sample Label</button>
                                                        -->

                                                </div>
                                            </div>

                                            <div class="tab-pane" id="home" role="tabpanel">
                                                <div class="table-responsive" id="list">

                                                    <input type="hidden" id="RowLevelSelectedExternalIssue" name="RowLevelSelectedExternalIssue">

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
                                                    <button type="button" id="SC_ExternalIssue_PEI_Btn" class="pad_btn active btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" style="padding: 7px 5px 7px 5px;" onclick="SampleCollectionITransPop();" disabled>Transfer </button>

                                                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Slip1</button> -->

                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_quarantine" autocomplete="off" onclick="ViewExternalIssueSlip_RPT();">Issue Slip</button>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="profile" role="tabpanel">
                                                <div class="table-responsive" id="list">

                                                    <input type="hidden" id="RowLevelSelectedExtraIssue" name="RowLevelSelectedExtraIssue">
                                                    
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
                                                    <button type="button" id="SC_ExtraIssue_PEI_Btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".goods_issue" onclick="ExtraIssueTabGoodIuusePoP();" disabled>Post Extra Issue</button>

                                                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Issue Slip2</button> -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_quarantine" autocomplete="off" onclick="ViewExtraIssueSlip_RPT();">Issue Slip</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                    </form>
                    <br>
                    <div class="d-flex flex-wrap gap-2" style="margin-top: 10px;">
                        <button type="button" class="btn btn-primary" id="SampleCollectionUpdateForm_Btn" name="SampleCollectionUpdateForm_Btn" onclick="SampleCollectionUpdateForm()">Update</button>
                    </div>

                                <!-- form end -->
                
                                    </div>  
                                </div>  
                            </div>  
                        </div>  
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <br>
</form>
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

        $(`#Extra-issue-list-append`).html(''); // Extra Issue Table Tr tag append here
        $(`#External-issue-list-append`).html(''); // External Issue Table Tr tag append here

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

            // console.log('totalRowCount=>', totalRowCount);
            // console.log('rowCount=>', rowCount);
        // ==============================Table tr count inside tbody End here ====================

        // ==============================Table tr count inside tbody start here ===================
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

            // console.log('totalRowCount_N=>', totalRowCount_N);
            // console.log('rowCount_N=>', rowCount_N);
        // ==============================Table tr count inside tbody End here ====================

        var dataString ='DocEntry='+DocEntry+'&rowCount='+rowCount+'&rowCount_N='+rowCount_N+'&action=sample_collection_ajax';

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
                var JSONObjectAll = JSON.parse(result);
                // console.log(JSONObjectAll);

                var JSONObject=JSONObjectAll['SampleCollDetails'];
                // console.log('JSONObjectAll -> ExternalIssue =>', JSONObjectAll['ExternalIssue']);

                $(`#Extra-issue-list-append`).html(JSONObjectAll['ExtraIssue']); // Extra Issue Table Tr tag append here
                $(`#External-issue-list-append`).html(JSONObjectAll['ExternalIssue']); // External Issue Table Tr tag append here

            // <!-- ----------------- Bottom Hidden Field start here ----------------------- -->
                $(`#SCF_SupplierCode`).val(JSONObject[0]['SupplierCode']);
                $(`#SCF_SupplierName`).val(JSONObject[0]['SupplierName']);
                $(`#SCF_CollDocEntry`).val(JSONObject[0]['DocEntry']);
                $(`#SCF_BPLId`).val(JSONObject[0]['BPLId']);
                $(`#SCF_GRPO_DocEntry`).val(JSONObject[0]['GRPODEntry']);
                $(`#SCF_GRPO_LocCode`).val(JSONObject[0]['LocCode']);
                $(`#SCF_GRPO_BatchQty`).val(JSONObject[0]['BatchQty']);
                $(`#SCF_GRPO_BaseLine`).val(JSONObject[0]['BaseLine']);
                $(`#SCF_SampleUnit`).val(JSONObject[0]['SampleUnit']);

            // <!-- ----------------- Bottom Hidden Field end here ------------------------- -->

            // <!-- --------------- Tab Layout Sample Collection Details Mapping Start Here ------------------ -->
                $(`#SC_SCD_ContainerNo1`).val(JSONObject[0]['ContainerNo1']);
                $(`#SC_SCD_ContainerNo2`).val(JSONObject[0]['ContainerNo2']);
                $(`#SC_SCD_ContainerNo3`).val(JSONObject[0]['ContainerNo3']);
                $(`#SC_SCD_QtyForLabel`).val(JSONObject[0]['QtyForLabel']);
                $(`#SC_SCD_RQty`).val(JSONObject[0]['RQty']);
                $(`#SC_SCD_RQtyUOM`).val(JSONObject[0]['RQtyUOM']);
                $(`#SC_SCD_UTTransNo`).val(JSONObject[0]['UnderTestTransferNo']);
                $(`#SC_SCD_SampleIssue`).val(JSONObject[0]['SampleIssue']);
                // $(`#SC_SCD_RevSampleIssue`).val(JSONObject[0]['ReverseSampleIssue']);
                $(`#SC_SCD_RetainIssue`).val(JSONObject[0]['RetainIssue']);
            // <!-- --------------- Tab Layout Sample Collection Details Mapping End Here -------------------- -->
                
                $(`#SCF_IngrediantType`).val(JSONObject[0]['IngediantType']);
                $(`#SCF_GRNNo`).val(JSONObject[0]['GRPONo']);
                $(`#SCF_Location`).val(JSONObject[0]['Location']);
                $(`#SCF_IntimatedBy`).val(JSONObject[0]['IntimatedBy']);
                $(`#SCF_SampleQty`).val(JSONObject[0]['SampleQty']);
                $(`#SCF_SampleCollectBy`).val(JSONObject[0]['SampleCollectBy']);
                $(`#SCF_ARNo`).val(JSONObject[0]['ARNo']);
                $(`#SCF_SampleReSep`).val(JSONObject[0]['SampleRcvSepretly']);
                $(`#SCF_TRNo`).val(JSONObject[0]['TrNo']);
                $(`#SCF_Branch`).val(JSONObject[0]['Branch']);
                $(`#SCF_ItemCode`).val(JSONObject[0]['ItemCode']);
                $(`#SCF_ItemName`).val(JSONObject[0]['ItemName']);
                $(`#SCF_BatchNo`).val(JSONObject[0]['BatchNo']);
                $(`#SCF_NoOfContainer`).val(JSONObject[0]['NoOfContainer']);
                
                $(`#SCF_MaterialType`).val(JSONObject[0]['TypeOfMaterial']);
                $(`#SCF_MakeBy`).val(JSONObject[0]['MakeBy']);



                // <!-- ----------- Intimation Date Start Here ----------------------------------- -->
                    var intimationDateOG = JSONObject[0]['IntimationDate'];
                    if(intimationDateOG!=''){
                        intimationDate = intimationDateOG.split(' ')[0];
                        $(`#SCF_IntimatedDate`).val(intimationDate); 
                    }
                // <!-- ----------- Intimation Date End Here ------------------------------------- -->

                // <!-- ----------- Challan Date Start Here ----------------------------------- -->
                    var docDateOG = JSONObject[0]['DocDate'];
                    if(docDateOG!=''){
                        docDate = docDateOG.split(' ')[0];
                        $(`#SCF_DocDate`).val(docDate); 
                    }
                // <!-- ----------- Challan Date End Here ------------------------------------- -->

                tablayoutvalidation();
                getSupplierDropdown(totalRowCount);
                GetUserCodeUsingEmpId();
                // getWareHouseDropdown(totalRowCount);

                // getWareHouseExtraIssueDropdown(totalRowCount_N);

                $('.ExternalIssueSelectedBPWithData').select2();// with data supplier dropdown
                $('.ExternalIssueDefault').select2();// default supplier dropdown

                // $('.ExternalIssueWareHouseDefault').select2();// with data supplier dropdown
                // $('.ExternalIssueWareHouseWithData').select2();// default supplier dropdown

                // $('.SC_FEI_WarehouseDefault').select2();// with data supplier dropdown
                // $('.SC_FEI_WarehouseWithData').select2();// default supplier dropdown
                
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    // function getWareHouseDropdown(totalRowCount){

    //     var table = document.getElementById("TblExternalIssue");
    //     var tbodyRowCount = table.tBodies[0].rows.length;

    //     var dataString ='action=WareHouseDropdown_ajax';

    //     $.ajax({  
    //         type: "POST",  
    //         url: 'ajax/common-ajax.php',  
    //         data: dataString,  
    //         beforeSend: function(){
    //             $(".loader123").show();
    //         },
    //         success: function(result)
    //         {  
    //             var JSONObject = JSON.parse(result);
    //             // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
    //                 let un_id=tbodyRowCount; 
    //                 $('#SC_ExternalI_Warehouse'+un_id).html(JSONObject);
    //             // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
    //         },
    //         complete:function(data){
    //             $(".loader123").hide();
    //         }
    //     });
    // }

    // function getWareHouseExtraIssueDropdown(totalRowCount_N) {

    //     var table = document.getElementById("Tbl_SC_ExtraIssue");
    //     var tbodyRowCount = table.tBodies[0].rows.length;

    //     var dataString ='action=WareHouseDropdown_ajax';

    //     $.ajax({  
    //         type: "POST",  
    //         url: 'ajax/common-ajax.php',  
    //         data: dataString,  
    //         beforeSend: function(){
    //             $(".loader123").show();
    //         },
    //         success: function(result)
    //         {  
    //             var JSONObject = JSON.parse(result);
    //             // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
    //                 let un_id=tbodyRowCount;
    //                 $('#SC_FEI_Warehouse'+un_id).html(JSONObject);
    //             // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
    //         },
    //         complete:function(data){
    //             $(".loader123").hide();
    //         }
    //     });
    // }

    
    function GetUserCodeUsingEmpId(){
        var dataString ='action=GetUserCodeUsingEmpId_Ajax';

        $.ajax({  
            type: "POST",  
            url: 'ajax/common-ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                var JSONObject = JSON.parse(result);

                $('#SCF_UserCode').val(JSONObject[0]['UserId']);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function getSupplierDropdown(totalRowCount){

        var table = document.getElementById("TblExternalIssue");
        var tbodyRowCount = table.tBodies[0].rows.length;

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
                var JSONObject = JSON.parse(result);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=tbodyRowCount; 
                    $('#SC_ExternalI_SupplierCode'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

function ExternalIssueSelectedBP(un_id){
    var CardCode=document.getElementById('SC_ExternalI_SupplierCode'+un_id).value;
    var Loc = $('#SCF_Location').val();
    var Branch= $('#SCF_Branch').val();
    var ItemCode = $('#SCF_ItemCode').val();
    var MakeBy = $('#SCF_MakeBy').val();

    var dataString ='CardCode='+CardCode+'&Loc='+Loc+'&Branch='+Branch+'&ItemCode='+ItemCode+'&MakeBy='+MakeBy+'&action=GetCardNameAndWhs_Ajax';

    $.ajax({
        type: "POST",
        url: 'ajax/common-ajax.php',
        data: dataString,  
        beforeSend: function(){
            $(".loader123").show();
        },
        success: function(result){
            var JSONObject = JSON.parse(result);
            // console.log(JSONObject);

            if(CardCode!=''){
                $('#SC_FEXI_SupplierName'+un_id).val(JSONObject['CardName']);
                $('#SC_ExternalI_Warehouse'+un_id).val(JSONObject['Whse']);
                $('#SC_FEXI_SampleDate'+un_id).val(JSONObject['SampleDate']);
                $('#SC_FEXI_UOM'+un_id).val($('#SCF_SampleUnit').val());
            }else{
                $('#SC_FEXI_SupplierName'+un_id).val('');
                $('#SC_ExternalI_Warehouse'+un_id).val('');
                $('#SC_FEXI_SampleDate'+un_id).val('');
                $('#SC_FEXI_UOM'+un_id).val('');  
            }
        },
        complete:function(data){
            $(".loader123").hide();
        }
    });
}

function GetExtraIuuseWhs(un_id){

    var SampleQuantity = $('#SC_FEI_SampleQuantity'+un_id).val();

    var Loc = $('#SCF_Location').val();
    var Branch= $('#SCF_Branch').val();
    var ItemCode = $('#SCF_ItemCode').val();
    var MakeBy = $('#SCF_MakeBy').val();
    var UOM = $('#SCF_SampleUnit').val();

    var dataString ='UOM='+UOM+'&Loc='+Loc+'&Branch='+Branch+'&ItemCode='+ItemCode+'&MakeBy='+MakeBy+'&action=GetExtraIuuseWhs_Ajax';

    $.ajax({
        type: "POST",
        url: 'ajax/common-ajax.php',
        data: dataString,  
        beforeSend: function(){
            // $(".loader123").show();
        },
        success: function(result){
            // console.log(result);
            var JSONObject = JSON.parse(result);
            // console.log(JSONObject);
            // console.log(JSONObject['SampleBy']);


            if(SampleQuantity!=''){
                $('#SC_FEI_UOM'+un_id).val(JSONObject['UOM']);
                $('#SC_FEI_Warehouse'+un_id).val(JSONObject['Whse']);
                $('#SC_FEI_SampleBy'+un_id).val(JSONObject['SampleBy']);
                $('#SC_FEI_IssueDate'+un_id).val(JSONObject['IssueDate']);
            }else{
                $('#SC_FEI_UOM'+un_id).val('');
                $('#SC_FEI_Warehouse'+un_id).val('');
                $('#SC_FEI_SampleBy'+un_id).val('');
                $('#SC_FEI_IssueDate'+un_id).val('');
            }
        },
        complete:function(data){
            // $(".loader123").hide();
        }
    });
}

    function tablayoutvalidation(){
        var sampleIssue=document.getElementById('SC_SCD_SampleIssue').value;
        // var RevSampleIssue=document.getElementById('SC_SCD_RevSampleIssue').value;
        var RetainIssue=document.getElementById('SC_SCD_RetainIssue').value;
        
        // <!-- -------- sample issue validation Start Here -------------------- -->
            if(sampleIssue==''){
                document.getElementById("SC_SCD_SampleIssue_Btn").disabled = false;
            }else{
                document.getElementById("SC_SCD_SampleIssue_Btn").disabled = true;
            }
        // <!-- -------- sample issue validation End Here ---------------------- -->

        // <!-- -------- Reverse sample issue validation Start Here ------------ -->
            // if(RevSampleIssue==''){
            //     document.getElementById("SC_SCD_RevSampleIssue_Btn").disabled = false;
            // }else{
            //     document.getElementById("SC_SCD_RevSampleIssue_Btn").disabled = true;
            // }
        // <!-- -------- Reverse sample issue validation End Here -------------- -->

        // <!-- -------- Retain Issue validation Start Here -------------------- -->
            // if(sampleIssue==''){
            //     document.getElementById("SC_SCD_RevSampleIssue_Btn").disabled = true; // disabled
                
            // }else{

            //     if(RetainIssue==''){
            //         document.getElementById("SC_SCD_RevSampleIssue_Btn").disabled = false; // enable
            //     }else{
            //         document.getElementById("SC_SCD_RevSampleIssue_Btn").disabled = true; // disabled
            //     }
            // }
        // <!-- -------- Retain Issue validation End Here ---------------------- -->
    }

    function TransToUnder()
    {
        var SupplierCode=document.getElementById('SCF_SupplierCode').value;
        var SupplierName=document.getElementById('SCF_SupplierName').value;
        var BranchName=document.getElementById('SCF_Branch').value;
        var DocEntry=document.getElementById('SCF_CollDocEntry').value;

        var SampleQuantity=document.getElementById('SCF_SampleQty').value;

        var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

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
                $("#hideToWhs").hide();
                $('#it_SupplierCode').val(SupplierCode);
                $('#it_SupplierName').val(SupplierName);
                $('#it_BranchName').val(BranchName);
                $('#it_DocEntry').val(DocEntry);

                $('#it_BaseDocType').val('SCS_SCOL');

                var JSONObject = JSON.parse(result);
                $('#InventoryTransferItemAppend').html(JSONObject);

                //Item Quantity Recalculate according sample quantity start here -------------------
                    var itP_BQty=document.getElementById('itP_BQty').value;
                    var calculated_itP_BQty=parseFloat(itP_BQty-SampleQuantity).toFixed(6);
                    $('#itP_BQty').val(calculated_itP_BQty);
                //Item Quantity Recalculate according sample quantity end here --------------------- 

                getSeriesDropdown() // DocName By using API to get dropdown 
                ContainerSelection() // get Container Selection Table List
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function SampleCollectionITransPop()
    {   
        // SC_FEXI_Warehouse

        var un_id=document.getElementById('RowLevelSelectedExternalIssue').value;  // selected row un_id

        var SupplierCode=document.getElementById('SC_FEXI_SupplierCode'+un_id).value;
        var SupplierName=document.getElementById('SC_FEXI_SupplierName'+un_id).value;
        var ToWare=document.getElementById('SC_FEXI_Warehouse'+un_id).value;
        var SampleQuantity=document.getElementById('SC_FEXI_SampleQuantity'+un_id).value;
        var sampleDate=document.getElementById('SC_FEXI_SampleDate'+un_id).value;

        var BranchName=document.getElementById('SCF_Branch').value;
        var DocEntry=document.getElementById('SCF_CollDocEntry').value;

        var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

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
                
                // $("#hideToWhs").hide();
                $('#it_SupplierCode').val(SupplierCode);
                $('#it_SupplierName').val(SupplierName);
                $('#it_BranchName').val(BranchName);
                $('#it_DocEntry').val(DocEntry);

                $('#it_BaseDocType').val('SCS_SCOL');

                var JSONObject = JSON.parse(result);
                $('#InventoryTransferItemAppend').html(JSONObject);

                $('#itP_ToWhs').val(ToWare);
                //Item Quantity Recalculate according sample quantity start here -------------------
                    $('#itP_BQty').val(SampleQuantity);
                //Item Quantity Recalculate according sample quantity end here --------------------- 

                getSeriesDropdown() // DocName By using API to get dropdown 
                ContainerSelection() // get Container Selection Table List
                changedateformate(sampleDate);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function changedateformate(date){

        const myArray = date.split("-");

        var day=myArray[0];
        var months=myArray[1];
        var year=myArray[2]; 

        var Final_date=year+'-'+months+'-'+day;

        document.getElementById("it_PostingDate").value = Final_date; // posting date value set here
        document.getElementById("it_DocDate").value = Final_date; // Document date value set here
    }

    function SC_SCD_GI_SampleIssuePoP()
    {
        var SupplierCode=document.getElementById('SCF_SupplierCode').value;
        var SupplierName=document.getElementById('SCF_SupplierName').value;
        var BranchName=document.getElementById('SCF_Branch').value;
        var DocEntry=document.getElementById('SCF_CollDocEntry').value;
        var BPL_Id=document.getElementById('SCF_BPLId').value;

        var SampleQuantity=document.getElementById('SCF_SampleQty').value; // sample Qty Value get Here

        var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

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
                $('#DocumentType').val('SampleIssueGoodsIssue');
                $('#gi_SupplierCode').val(SupplierCode);
                $('#gi_SupplierName').val(SupplierName);
                $('#gi_BranchName').val(BranchName);
                $('#gi_DocEntry').val(DocEntry);
                $('#gi_BPL_Id').val(BPL_Id);

                $('#gi_BaseDocType').val('SCS_SCOL');
                // console.log(result);

                var JSONObject = JSON.parse(result);
                $('#GoodsIssueItemAppend').html(JSONObject);

                 $('#hideToWhsTd').hide(); // Item Table ToWhs Hide
                //Item Quantity Recalculate according sample quantity start here -------------------
                    $('#itP_BQty').val(SampleQuantity);
                //Item Quantity Recalculate according sample quantity end here --------------------- 

                getSeriesDropdownForGoodsIssue() // DocName By using API to get dropdown 
                goodsIssueContainerSelection() // get Container Selection Table List
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    
    function ExtraIssueTabGoodIuusePoP()
    {
        var SupplierCode=document.getElementById('SCF_SupplierCode').value;
        var SupplierName=document.getElementById('SCF_SupplierName').value;
        var BranchName=document.getElementById('SCF_Branch').value;
        var DocEntry=document.getElementById('SCF_CollDocEntry').value;
        var BPL_Id=document.getElementById('SCF_BPLId').value;

        var SampleQuantity=document.getElementById('SC_FEI_SampleQuantity1').value; // sample Qty Value get Here


        var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

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
                $('#DocumentType').val('ExtraIssueTabGoodsIssue');
                $('#gi_SupplierCode').val(SupplierCode);
                $('#gi_SupplierName').val(SupplierName);
                $('#gi_BranchName').val(BranchName);
                $('#gi_DocEntry').val(DocEntry);
                $('#gi_BPL_Id').val(BPL_Id);

                $('#gi_BaseDocType').val('SCS_SCOL');
                // console.log(result);

                var JSONObject = JSON.parse(result);
                $('#GoodsIssueItemAppend').html(JSONObject);

                $('#hideToWhsTd').hide(); // Item Table ToWhs Hide
                // $('#itP_ToWhs').val($('#SC_FEI_Warehouse1').val());

                //Item Quantity Recalculate according sample quantity start here -------------------
                    $('#itP_BQty').val(SampleQuantity);
                //Item Quantity Recalculate according sample quantity end here --------------------- 

                getSeriesDropdownForGoodsIssue() // DocName By using API to get dropdown 
                goodsIssueContainerSelection() // get Container Selection Table List
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function getSeriesDropdownForGoodsIssue()
    {   
        var TrDate=$('#gi_PostingDate').val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=60&action=getSeriesDropdown_ajax';

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
                var SeriesDropdown = JSON.parse(result);
                $('#gi_DocNoName').html(SeriesDropdown);
                selectedSeriesForGoodsIssue(); // call Selected Series Single data function
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeriesForGoodsIssue(){

        var TrDate=$('#gi_PostingDate').val();
        var Series=document.getElementById('gi_DocNoName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=60&action=getSeriesSingleData_ajax';

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
                var JSONObject = JSON.parse(result);

                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];

                $('#gi_DocNo').val(Series);
                $('#gi_NextNumber').val(NextNumber);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function getSeriesDropdown()
    {   
        var TrDate= $('#SCF_DocDate').val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=67&action=getSeriesDropdown_ajax';

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
                var SeriesDropdown = JSON.parse(result);
                $('#it_DocNoName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeries(){

        var TrDate= $('#SCF_DocDate').val();
        var Series=document.getElementById('it_DocNoName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=67&action=getSeriesSingleData_ajax';

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
                var JSONObject = JSON.parse(result);

                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];

                $('#it_DocNo').val(Series);
                $('#it_NextNumber').val(NextNumber);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function goodsIssueContainerSelection(){

        var GRPODEnt=document.getElementById('U_GRPODEnt').value;
        var BNo=document.getElementById('U_BNo').value;
        var ItemCode=document.getElementById('itP_ItemCode').value;
        var FromWhs=document.getElementById('itP_FromWhs').value;

        var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=SC_OpenInventoryTransferGI_ajax';

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
                var JSONObject = JSON.parse(result);
                $('#GoodsIssueContainerSelectionItemAppend').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }
   
    function ContainerSelection(){

        var GRPODEnt=document.getElementById('U_GRPODEnt').value;
        var BNo=document.getElementById('U_BNo').value;
        var ItemCode=document.getElementById('itP_ItemCode').value;
        var FromWhs=document.getElementById('itP_FromWhs').value;

        var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=SC_OpenInventoryTransferCS_ajax';

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
                var JSONObject = JSON.parse(result);
                $('#ContainerSelectionItemAppend').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function getSelectedContenerGI_Manual(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionTableGI");
 
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
            document.getElementById("csgi_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
    }

    function getSelectedContenerGI(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionTableGI");
 
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
            document.getElementById("csgi_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

        // <!-- --------------------- when user select checkbox update flag start here -------------- -->
            var usercheckListVal=document.getElementById('gi_usercheckList'+un_id).value;

            if(usercheckListVal=='0'){
                $(`#gi_usercheckList`+un_id).val('1');
            }else{
                $(`#gi_usercheckList`+un_id).val('0');
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
                console.log('usercheckListVal=>', usercheckListVal);

            if(usercheckListVal=='0'){
                // console.log('If', `#usercheckList`+un_id);
                $(`#usercheckList`+un_id).val('1');
                // console.log('11111111');
            }else{
                // console.log('else', `#usercheckList`+un_id);
                $(`#usercheckList`+un_id).val('0');
                // console.log('22222222');
            }
        // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
    }

    function EnterQtyValidation_GI(un_id) {
        var BatchQty=document.getElementById('gip_BatchQty'+un_id).value;
        var SelectedQty=document.getElementById('gip_SelectedQty'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){
                $('#gip_SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#gip_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

                getSelectedContenerGI_Manual(un_id); // if user change selected Qty value after selection 
            }else{
                $('#gip_SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#gip_SelectedQty'+un_id).val(BatchQty); // if user enter blank val
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error");
        }
    }

    function EnterQtyValidation(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){
                $('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

                // getSelectedContener(un_id); // if user change selected Qty value after selection  (14 May 2024)
            }else{
                $('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error");
        }
    }

    function SubmitInventoryTransfer(){

        var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
        var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
        var PostingDate=document.getElementById('it_PostingDate').value;
        var DocDate=document.getElementById('it_DocDate').value;
        var ToWhs=document.getElementById('itP_ToWhs').value;

        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(ToWhs!=''){ // Item level To Warehouse validation

                if(PostingDate!=''){ // Posting Date validation

                    if(DocDate!=''){ // Document Date validation

                    // <!-- ---------------- form submit process start here ----------------- -->
                        var formData = new FormData($('#inventory_transfer_form')[0]); // form Id
                        formData.append("SC_SubIT_Btn",'SubIT_Btn'); // submit btn Id
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

    function SubmitSCGI(){

        var selectedQtySum=document.getElementById('csgi_selectedQtySum').value; // final Qty sum
        var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
        var PostingDate=document.getElementById('gi_PostingDate').value;
        var DocDate=document.getElementById('gi_DocDate').value;
        var ToWhs=document.getElementById('itP_ToWhs').value;

        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(ToWhs!=''){ // Item level To Warehouse validation

                if(PostingDate!=''){ // Posting Date validation

                    if(DocDate!=''){ // Document Date validation

                    // <!-- ---------------- form submit process start here ----------------- -->
                        var formData = new FormData($('#SCGI_popup_form')[0]); // form Id
                        formData.append("SubGI_Btn",'SubGI_Btn'); // submit btn Id
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
                                },complete:function(data){
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

    function OnclickReverseSampleIssue(){

        var DocEntry=document.getElementById('SC_SCD_SampleIssue').value;

        var dataString ='DocEntry='+DocEntry+'&action=SCReverseSampleIsuue_ajax';

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

    function SampleCollectionUpdateForm()
    {
        var formData = new FormData($('#SampleCollectionUpdateForm')[0]); // form Id
        formData.append("SampleCollectionUpdateForm_Btn",'SampleCollectionUpdateForm_Btn'); // submit btn Id
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
            },complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function selectedExternalIssue(un_id){
        $('#RowLevelSelectedExternalIssue').val(un_id);
        document.getElementById("SC_ExternalIssue_PEI_Btn").disabled = false;
    }

    function selectedExtraIssue(un_id){
        $('#RowLevelSelectedExtraIssue').val(un_id);
        document.getElementById("SC_ExtraIssue_PEI_Btn").disabled = false;
    }

// --------------------------
    function OpenGoodsIssueRetainsIssue()
    {
        $('#it_DocFlagForWeb').val('SCD_RetainIuuse_IT');
        var SupplierCode=document.getElementById('SCF_SupplierCode').value;
        var SupplierName=document.getElementById('SCF_SupplierName').value;
        var BranchName=document.getElementById('SCF_Branch').value;
        var DocEntry=document.getElementById('SCF_CollDocEntry').value;

        var SampleQuantity=document.getElementById('SCF_SampleQty').value;

        var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

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
                // console.log(JSON.parse(result));

                var JSONObject = JSON.parse(result);
                $('#InventoryTransferItemAppend').html(JSONObject);

                $("#hideToWhs").hide();
                $('#hideToWhsTd').hide(); // Item Table ToWhs Hide
                
                $('#it_SupplierCode').val(SupplierCode);
                $('#it_SupplierName').val(SupplierName);
                $('#it_BranchName').val(BranchName);
                $('#it_DocEntry').val(DocEntry);
                $('#it_BaseDocType').val('SCS_SCOL');


                    // var RetainQty=parseFloat(document.getElementById('SC_SCD_RQty').value).toFixed(6);
                    $('#itP_BQty').val(parseFloat(document.getElementById('SC_SCD_RQty').value).toFixed(6));

                getSeriesDropdownForSCD_RI_GI() // DocName By using API to get dropdown 
                SCD_RI_GI_ContainerSelection() // get Container Selection Table List
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    // function OpenGoodsIssueRetainsIssue()
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
    //             $(".loader123").show();
    //         },
    //         success: function(result)
    //         {   

    //             $('#DocumentType').val('RetainIssueGoodsIssue');
    //             $('#gi_SupplierCode').val(SupplierCode);
    //             $('#gi_SupplierName').val(SupplierName);
    //             $('#gi_BranchName').val(BranchName);
    //             $('#gi_DocEntry').val(DocEntry);
    //             $('#gi_BPL_Id').val(BPL_Id);

    //             $('#gi_BaseDocType').val('SCS_SCOL');
    //             // console.log(result);

    //             var JSONObject = JSON.parse(result);
    //             $('#GoodsIssueItemAppend').html(JSONObject);

    //             $('#itP_BQty').val(parseFloat(document.getElementById('SC_SCD_RQty').value).toFixed(6));

    //             getSeriesDropdownForGoodsIssue() // DocName By using API to get dropdown 
    //             goodsIssueContainerSelection() // get Container Selection Table List
    //         },
    //         complete:function(data){
    //             $(".loader123").hide();
    //         }
    //     }); 
    // }

    function getSeriesDropdownForSCD_RI_GI()
    {   
        var TrDate= $('#SCF_DocDate').val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=67&action=getSeriesDropdown_ajax';

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
                var SeriesDropdown = JSON.parse(result);
                $('#it_DocNoName').html(SeriesDropdown);
                selectedSeriesForSCD_RI_GI(); // call Selected Series Single data function
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeriesForSCD_RI_GI(){

        var TrDate= $('#SCF_DocDate').val();
        var Series=document.getElementById('scd_ri_DocNoName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=67&action=getSeriesSingleData_ajax';

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
                var JSONObject = JSON.parse(result);

                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];

                $('#it_DocNo').val(Series);
                $('#it_NextNumber').val(NextNumber);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }


    function SCD_RI_GI_ContainerSelection(){

        var GRPODEnt=document.getElementById('U_GRPODEnt').value;
        var BNo=document.getElementById('U_BNo').value;
        var ItemCode=document.getElementById('itP_ItemCode').value;
        var FromWhs=document.getElementById('itP_FromWhs').value;

        var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=SC_OpenInventoryTransferCS_ajax';

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
                var JSONObject = JSON.parse(result);
                $('#ContainerSelectionItemAppend').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    // function getSelectedContener(un_id){
    //     //Create an Array.
    //     var selected = new Array();
 
    //     //Reference the Table.
    //     var tblFruits = document.getElementById("ContainerSelectionTableGIRI");
 
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

    // function SubmitSCGIRI(){
    //     // alert('SubmitSCGIRI');

    //     var selectedQtySum=document.getElementById('csgi_selectedQtySum').value; // final Qty sum
    //     var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
    //     var PostingDate=document.getElementById('scd_ri_PostingDate').value;
    //     var DocDate=document.getElementById('scd_ri_DocDate').value;
    //     var ToWhs=document.getElementById('itP_ToWhs').value;

    //     if(selectedQtySum==item_BQty){ // Container selection Qty validation

    //         if(ToWhs!=''){ // Item level To Warehouse validation

    //             if(PostingDate!=''){ // Posting Date validation

    //                 if(DocDate!=''){ // Document Date validation

    //                 // <!-- ---------------- form submit process start here ----------------- -->
    //                     var formData = new FormData($('#SCGIRI_popup_form')[0]); // form Id
    //                     formData.append("SubGIRI_Btn",'SubGIRI_Btn'); // submit btn Id
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
    //                                 // $(".loader123").show();
    //                             },
    //                             success: function(result)
    //                             {
    //                                 console.log(result);
    //                                 // var JSONObject = JSON.parse(result);

    //                                 // var status = JSONObject['status'];
    //                                 // var message = JSONObject['message'];
    //                                 // var DocEntry = JSONObject['DocEntry'];
    //                                 // if(status=='True'){
    //                                 //     swal({
    //                                 //       title: `${DocEntry}`,
    //                                 //       text: `${message}`,
    //                                 //       icon: "success",
    //                                 //       buttons: true,
    //                                 //       dangerMode: false,
    //                                 //     })
    //                                 //     .then((willDelete) => {
    //                                 //         if (willDelete) {
    //                                 //             location.replace(window.location.href); //ok btn... cuurent URL called
    //                                 //         }else{
    //                                 //             location.replace(window.location.href); // cancel btn... cuurent URL called
    //                                 //         }
    //                                 //     });
    //                                 // }else{
    //                                 //     swal("Oops!", `${message}`, "error");
    //                                 // }
    //                             },complete:function(data){
    //                                 // $(".loader123").hide();
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

function ViewExtraIssueSlip_RPT(){
    var UserCode=$('#SCF_UserCode').val();
    var DocEntry=$('#SCF_CollDocEntry').val();
    if(DocEntry!=''){
        var PrintOutURL=`http://192.168.1.30:8082/API/SAP/INWARDSAMPCOLEXTRAISPRINTLAYOUT?DocEntry=${DocEntry}&UserCode=${UserCode}`;
        document.getElementById("PrintQuarantine_Link").src = PrintOutURL;
    }

    document.getElementById('RPT_title').innerHTML= 'Extra Issue Slip';
}

function ViewExternalIssueSlip_RPT(){
    var UserCode=$('#SCF_UserCode').val();
    var DocEntry=$('#SCF_CollDocEntry').val();
    if(DocEntry!=''){
        var PrintOutURL=`http://192.168.1.30:8082/API/SAP/INWARDSAMPCOLEXTERNALISPRINTLAYOUT?DocEntry=${DocEntry}&UserCode=${UserCode}`;
        document.getElementById("PrintQuarantine_Link").src = PrintOutURL;
    }

    document.getElementById('RPT_title').innerHTML= 'External Issue Slip';
}


    function ViewSampleForAnalysisLabel_RPT(){
        var DocEntry=$('#SCF_CollDocEntry').val();
        if(DocEntry!=''){
            var PrintOutURL=`http://192.168.1.30:8082/API/SAP/INWARDSAMPLECOLLSAMPFORANAL?DocEntry=${DocEntry}`;
            document.getElementById("PrintQuarantine_Link").src = PrintOutURL;
        }

        document.getElementById('RPT_title').innerHTML= 'Sample For Analysis Label';
    }

    function ViewSampleLabel_RPT(){
        var DocEntry=$('#SCF_CollDocEntry').val();
        if(DocEntry!=''){
            var PrintOutURL=`http://192.168.1.30:8082/API/SAP/INWARDSAMPLECOLLSAMPLABEL?DocEntry=${DocEntry}`;
            document.getElementById("PrintQuarantine_Link").src = PrintOutURL;
        }

        document.getElementById('RPT_title').innerHTML= 'Sample Label';
    }

    function ViewPrintQuarantine_RPT_Close(){
        document.getElementById('RPT_title').innerHTML= '';
        document.getElementById("PrintQuarantine_Link").src = '';
    }

    function SeriesSelectionByDocumentWise(){
        var DocumentType=$('#DocumentType').val();

        if(DocumentType=='SampleIssueGoodsIssue'){
            // alert('Goods Issue');
            selectedSeriesForGoodsIssue(); // Geting Goods Issue Series 
        }else if(DocumentType=='ExtraIssueTabGoodsIssue'){
            // alert('Goods Issue-2222222222222222222');
            selectedSeriesForGoodsIssue(); // Geting Goods Issue Series 
        }else{
            // alert('Inventory Transfer');
            selectedSeries(); // Geting Inventory Transfer Series 
        }
    }

    function ChangeSeriesDropdownByDocumentWise(){
        var DocumentType=$('#DocumentType').val();

        if(DocumentType=='SampleIssueGoodsIssue'){
            // alert('Goods Issue');
            getSeriesDropdownForGoodsIssue(); // Geting Goods Issue Series 
        }else if(DocumentType=='ExtraIssueTabGoodsIssue'){
            // alert('Goods Issue-2222222222222222222');
            getSeriesDropdownForGoodsIssue(); // Geting Goods Issue Series 
        }else{
            // alert('Inventory Transfer');
            getSeriesDropdown(); // Geting Inventory Transfer Series 
        }
    }
</script>