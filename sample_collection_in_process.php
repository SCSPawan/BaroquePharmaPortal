
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
    $getAllData=$obj->getSimpleIntimation($INPROCESSSAMPCOLLADD,$tdata);

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
                    <th>RFP Entry</th>
                    <th>Material Type</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>WO Qty</th> 
                    <th>Batch No</th>
                    <th>Batch Qty</th>
                    <th>MFG Date</th>
                    <th>Expiry Date</th>
                    <th>Branch Name</th>
                </tr>
                </thead>
                <tbody>';
 
                if(count($getAllData)!='0'){
                    for ($i=$r_start; $i <$r_end ; $i++) { 
                        if(!empty($getAllData[$i]->RFPNo)){   //  this condition save to extra blank loop
                            $SrNo=$i+1;
                            // --------------- Convert String code Start Here ---------------------------
                                if(empty($getAllData[$i]->MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $MfgDate = str_replace('/', '-', $getAllData[$i]->MfgDate); 
                                    // All (/) replace to (-)
                                    $MfgDate=date("d-m-Y", strtotime($MfgDate));
                                }

                                if(empty($getAllData[$i]->ExpDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate = str_replace('/', '-', $getAllData[$i]->ExpDate); 
                                    // All (/) replace to (-)
                                    $ExpiryDate=date("d-m-Y", strtotime($ExpiryDate));
                                }
                            // --------------- Convert String code End Here-- ---------------------------

                        $option.='
                            <tr>
                                <td class="desabled">'.$SrNo.'</td>
                                <td style="text-align: center;">
                                    <input type="radio" id="list'.$getAllData[$i]->DocEntry.'" name="listRado" value="'.$getAllData[$i]->DocEntry.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord('.$getAllData[$i]->DocEntry.')">
                                </td>
                                <td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->WoNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->RFPEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->MaterialType.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->RetainQtyUom.'</td>
                                <td class="desabled">'.$getAllData[$i]->WOQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpiryDate.'</td>
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
<?php include 'models/qc_process/sample_collection_in_process_model.php' ?>
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
         
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Sample Collection - In Process</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Sample Collection - In Process</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                      <form role="form" class="form-horizontal" id="SampleCollectionProcessInUpdateForm" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header justify-content-between d-flex align-items-center">
                                        <h4 class="card-title mb-0">Sample Collectiona - In Process</h4> 
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
                                                                <input type="text" class="form-control" name="DocEntry" id="DocEntry">
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
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <br>
                        <div class="row"  id="footerProcess">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- <input class="form-control desabled" type="text" id="LocCode" name="LocCode"> -->
                                        <input type="hidden" id="BPLId" name="BPLId">
                                        <input type="hidden" id="it__DocEntry" name="it__DocEntry">
                                        <input type="hidden" id="si_Series" name="si_Series">
                                        <input type="hidden" id="gd_docNo" name="gd_docNo">
                                        
                                         <!-- <input type="hidden" id="numner_Series" name="numner_Series"> -->

                                        <input type="hidden" id="SCRTQCB_SupplierCode" name="SCRTQCB_SupplierCode">

                                        <input type="hidden" id="itP_FromWhs" name="itP_FromWhs">


                                        
                                        <!-- <input type="hidden" id="it_BatchNo" name="it_BatchNo"> -->
                                        

                             
                                    <div class="row">

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingediant Type</label>
                                                <!-- <div class="col-lg-8">
                                                    <select class="form-select" id="ingediantType" name="ingediantType">
                                                        <option>Select</option>
                                                    </select>
                                                </div> -->
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="ingediantType" name="ingediantType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="ReceiptNo" name="ReceiptNo" readonly>
                                                </div>
                                                 <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="ReceiptNo1" name="ReceiptNo1" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="woNo" name="woNo" readonly>
                                                </div>
                                                 <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="WoEntry" name="WoEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                <div class="col-lg-4">
                                                    <!-- <select class="form-control" id="DocNoName" name="DocNoName">
                                                        <option></option>
                                                    </select> -->

                                                    <input class="form-control desabled" type="text" id="DocNoName" name="DocNoName" readonly>
                                                </div>
                                                 <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="DocNo" name="DocNo" readonly>
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
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="IntimatedBy" name="IntimatedBy" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="date" id="IntimatedDate" name="IntimatedDate" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="SampleQty" name="SampleQty" readonly>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input class="form-control desabled" type="text" id="SampleQtyUnit" name="SampleQtyUnit" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control desabled" type="text" id="SampleCollectBy" name="SampleCollectBy" readonly>
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
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="DocDate" name="DocDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="TRNo" name="TRNo" readonly>
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
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="ItemCode" name="ItemCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="makeby" name="makeby" readonly>
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
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="BatchQty" name="BatchQty" readonly>
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
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="NoofCont" name="NoofCont" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill"> Container UOM</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="UOM" name="UOM" readonly>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!--row closed-->

                                             <!-- ====== -->
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
                                                    <!-- form start -->
                                                    <form>
                                                         <div class="row">

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">UnderTest Transfer No</label>
                                                                    <div class="col-lg-6">
                                                                        <input type="text" name="UnderTestTransferNo" id="UnderTestTransferNo" class="form-control desabled" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                     <div class="col-md-5">

                                                                        <button type="button" id="process_in_SCD_SampleIssue_Btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".goods_issue" onclick="OpenInventoryTransferModel_sampleIssue()">Sample Issue</button>

                                                                    </div>
                                                                    <div class="col-lg-7">
                                                                        <input type="text" name="SampleIssue" id="SampleIssue" class="form-control  desabled" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                              <div class="col-xl-3 col-md-6" style="display: none;">
                                                                <div class="form-group row mb-2">
                                                                     <label class="col-lg-4 col-form-label mt-6" for="val-skill">Date of Reversal</label>
                                                                    <div class="col-lg-8 container_input">
                                                                        <input type="text" name="DateofReversal" id="DateofReversal" class="form-control">
                                                                     </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6"  style="display: none;">
                                                                <div class="form-group row mb-2">
                                                                    <div class="col-md-7">

                                                                        <button type="button" id="Process_In_RevSampleIssue_Btn" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" onclick="processInReverseSampleIssue()">Reverse Sample Issue</button>
                                                                        
                                                                    </div>
                                                                    <div class="col-lg-5 container_input">
                                                                        <input type="text" name="ReverseSampleIssue" id="ReverseSampleIssue" class="form-control desabled" >
                                                                     </div>
                                                                </div>
                                                            </div>

                                                         </div>

                                                         <div class="row">

                                                            <div class="col-xl-3 col-md-6" style="display: none;">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="RetainQty" id="RetainQty" class="form-control desabled" readonly>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="RetainQtyUom" id="RetainQtyUom" class="form-control desabled" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                             <div class="col-xl-3 col-md-6"  style="display: none;">
                                                                <div class="form-group row mb-2">
                                                                    <div class="col-md-4">

                                                                         <button type="button" id="process_in_SCD_Retain_Issue_Btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" onclick="OpenInventoryTransferModel_RetailsIssue()">Retain Issue</button>
                                                                    </div>
                                                                    <div class="col-lg-8 container_input">
                                                                        <input type="text" name="RetainIssue" id="RetainIssue" class="form-control desabled" readonly>
                                                                     </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container No</label>
                                                                    <div class="col-lg-8 container_input" style="display: inline-flex;">
                                                                        <input type="text" name="ContainerNo1" id="ContainerNo1" class="form-control " >
                                                                        <input type="text" name="ContainerNo2" id="ContainerNo2" class="form-control ">
                                                                        <input type="text" name="ContainerNo3" id="ContainerNo3" class="form-control ">
                                                                     </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Qty For Label</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="QtyForLabel" id="QtyForLabel" class="form-control ">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                         </div>

                                                         
                                                    </form>        
                                                    <!-- form end -->
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <!-- Toggle States Button -->
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Sample for Analysis Label</button>

                                                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Sample Label</button>

                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="home" role="tabpanel">
                                                    <div class="table-responsive" id="list">
                                                          <input type="hidden" id="RowLevelSelectedExternalIssue" name="RowLevelSelectedExternalIssue">
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
                                                          <tbody id="External-issue-list-append"></tbody>
                                                        </table>
                                                    </div> 
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <button type="button" class="btn btn-primary" id="SC_ExternalIssue_PEI_Btn" data-bs-toggle="modal" data-bs-target=".inventory_external_transfer" onclick="OpenInventoryExternalTransferModel()" disabled="">Transfer</button>

                                                         <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Sleep</button>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="profile" role="tabpanel">
                                                    <div class="table-responsive" id="list">
                                                         <input type="hidden" id="RowLevelSelectedExtraIssue" name="RowLevelSelectedExtraIssue">
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
                                                            
                                                            <tbody id="Extra-issue-list-append"></tbody>
                                                        </table>
                                                    </div> 
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <!-- Toggle States Button -->
                                                        <button type="button" class="btn btn-primary" id="SC_ExtraIssue_PEI_Btn" data-bs-toggle="modal" data-bs-target=".goods_extra_issue" onclick="OpenInventoryTransferModel_extraIssue()" disabled="">Post Extra Issue</button>
<!-- OpenInventoryTransferModel_sampleIssue -->
                                                         <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Issue Slip</button>

                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="d-flex flex-wrap gap-2">

                                                    <button type="button" class="btn btn-primary active" id="SampleCollectionProcessInUpdateForm_Btn" name="SampleCollectionProcessInUpdateForm_Btn" onclick="SampleCollectionRetestQCUpdateForm()">Update</button>
                                                </div>
                                            </div>
                                       <!-- end card body -->
                                    </div>
                                  <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                    <!-- ====== -->
                 </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</form>
<br>   
</div>
<!-- End Page-content -->
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

    function selectedRecord(DocEntry){

        var totalRowCount = 0;
        var rowCount = 0;
        var table = document.getElementById("External-issue-list-append");
        var rows = table.getElementsByTagName("tr");
        for (var i = 0; i < rows.length; i++) {
        totalRowCount++;
         
            if (rows[i].getElementsByTagName("td").length > 0) {
                rowCount++;
            }
        }
        totalRowCount=rows.length;
        // console.log('rowCount=>', rowCount);
        // ---------------------------------------------------------------------------------------------------------------

        var totalRowCount_N = 0;
        var rowCount_N = 0;
        var table_N = document.getElementById("Extra-issue-list-append");

        var rows_N = table_N.getElementsByTagName("tr")
        for (var i = 0; i < rows_N.length; i++) {
            totalRowCount_N++;
            if (rows_N[i].getElementsByTagName("td").length > 0) {
                rowCount_N++;
            }
        }
      
        totalRowCount_N=rows_N.length;
        // console.log('totalRowCount_N=>', totalRowCount_N);
        // ---------------------------------------------------------------------------------------------------------------

        var dataString ='DocEntry='+DocEntry+'&rowCount_N='+rowCount_N+'&rowCount='+rowCount+'&action=sample_collecton_in_process_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {  
                $("#footerProcess").show();
                var JSONObjectAll = JSON.parse(result);

                        //console.log(JSONObjectAll['SampleCollDetails']);

                var JSONObject=JSONObjectAll['SampleCollDetails'];
                
                $(`#Extra-issue-list-append`).html(JSONObjectAll['ExtraIssue']); // Extra Issue Table Tr tag append here
                $(`#External-issue-list-append`).html(JSONObjectAll['ExternalIssue']); // External Issue Table Tr tag append here

                $(`#ReceiptNo`).val(JSONObject[0].RFPNo);
                $(`#ReceiptNo1`).val(JSONObject[0].RFPEntry);
                $(`#WoEntry`).val(JSONObject[0].WoEntry);
                $(`#woNo`).val(JSONObject[0].WoNo);
                $(`#Location`).val(JSONObject[0].Loction);
                $(`#IntimatedBy`).val(JSONObject[0].IntimatedBy);
                $(`#SampleQty`).val(JSONObject[0].SampleQty);
                $(`#SampleQtyUnit`).val(JSONObject[0].SampleQtyUnit);
                $(`#SampleCollectBy`).val(JSONObject[0].SampleCollectBy);
                $(`#ARNo`).val(JSONObject[0].ARNo);
                $(`#TRNo`).val(JSONObject[0].TRNo);
                $(`#Branch`).val(JSONObject[0].Branch);
                $(`#ItemCode`).val(JSONObject[0].ItemCode);
                $(`#ItemName`).val(JSONObject[0].ItemName);
                $(`#BatchNo`).val(JSONObject[0].BatchNo);
                $(`#NoofCont`).val(JSONObject[0].NoofCont);
                $(`#makeby`).val(JSONObject[0].MakeBy);
                $(`#UOM`).val(JSONObject[0].UOM);
                $(`#BatchQty`).val(JSONObject[0].BatchQty);
                $(`#UnderTestTransferNo`).val(JSONObject[0].UnderTransferNo);
                $(`#SampleIssue`).val(JSONObject[0].SampleIssue);
                $(`#DateofReversal`).val(JSONObject[0].DateofReversal);
                $(`#ReverseSampleIssue`).val(JSONObject[0].RevSamIssue);
                $(`#RetainQty`).val(JSONObject[0].RetainQty);
                $(`#RetainQtyUom`).val(JSONObject[0].RetainQtyUom);
                $(`#RetainIssue`).val(JSONObject[0].RetainIssue);
                $(`#ContainerNo1`).val(JSONObject[0].Cont1);
                $(`#ContainerNo2`).val(JSONObject[0].Cont2);
                $(`#ContainerNo3`).val(JSONObject[0].Cont3);
                $(`#QtyForLabel`).val(JSONObject[0].QtyforLabel);

                $('#ingediantType').val(JSONObject[0].IngredientType);
                $('#DocNoName').val(JSONObject[0].Series);
                $('#DocNo').val(JSONObject[0].DocNum);
                
                $(`#it__DocEntry`).val(JSONObject[0].DocEntry);
                $(`#BPLId`).val(JSONObject[0].BPLId);
                $(`#si_Series`).val(JSONObject[0].SeriesCode);
                // $(`#gd_docNo`).val(JSONObject[0].Series);

                
                $(`#SCRTQCB_SupplierCode`).val('');
                $(`#itP_FromWhs`).val(JSONObject[0].RISSFromWhs);

                getSeriesDropdown_gd();
                
                // <!-- ------------ IntimationDate Start Here --------------------- -->
                    var IntimationDateOG = JSONObject[0]['IntimationDate'];
                    if(IntimationDateOG!=''){
                        let [day, month, year] = IntimationDateOG.split(" ")[0].split("-");
                        let IntimationDate = `${year}-${month}-${day}`;
                        $(`#IntimatedDate`).val(IntimationDate);
                    }
                // <!-- ------------ IntimationDate End Here ----------------------- -->

                
                // <!-- ------------ DocDate Start Here --------------------- -->
                    var DocDateOG = JSONObject[0]['DocDate'];
                    if(DocDateOG!=''){
                        let [day, month, year] = DocDateOG.split(" ")[0].split("-");
                        let DocDate = `${year}-${month}-${day}`;
                        $(`#DocDate`).val(DocDate);
                    }
                // <!-- ------------ IntimationDate End Here ----------------------- -->
            },
            complete:function(data){
                // IngrediantTypeDropdown();
                getSupplierDropdown();
            }
        });
    }











    // function IngrediantTypeDropdown()
    // {
    //     $.ajax({ 
    //         type: "POST",
    //         url: 'ajax/kri_production_common_ajax.php',
    //         data:{'action':"IngrediantTypeDropdown_SampleCollection_ajax"},

    //         beforeSend: function(){
    //         },
    //         success: function(result)
    //         {
    //             // $('#ingediantType').html(result);
    //         },
    //         complete:function(data){
    //             getSeriesDropdown(); // DocName By using API to get dropdown 
    //         }
    //     }); 
//     // }

//     function getSeriesDropdown()
//     {
//         var dataString ='ObjectCode=SCS_SCINPROC&action=getSeriesDropdown_ajax';
//         $.ajax({
//             type: "POST",
//             url: 'ajax/kri_production_common_ajax.php',
//             data: dataString,
//             cache: false,
//             beforeSend: function(){
//             },
//             success: function(result){
//                 var SeriesDropdown = JSON.parse(result);
//                 $('#DocNoName').html(SeriesDropdown);
//             },
//             complete:function(data){
//                 selectedSeries(); // call Selected Series Single data function
//             }
//         }); 
//     }

//     function selectedSeries(){
//         var TrDate=$('#gd_PostingDate').val();
//         var Series=document.getElementById('DocNoName').value;
//         var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=&action=getSeriesSingleData_ajax';
//         $.ajax({
//             type: "POST",
//             url: 'ajax/kri_production_common_ajax.php',
//             data: dataString,
//             cache: false,

//             beforeSend: function(){
//             },
//             success: function(result)
//             {
//                 var JSONObject = JSON.parse(result);
// alert("hii")
//                 console.log('JSONObject=>',JSONObject);
//                 var NextNumber=JSONObject[0]['NextNumber'];
//                 var Series=JSONObject[0]['Series'];
//                 $('#DocNo').val(Series);
//                 $('#gd_docNo').val(Series);
//                 $('#inveTra_docNo').val(Series);
//                 $('#external_docNo').val(Series);
//                 $('#extra_docNo').val(Series);
                 
//                 $('#numner_Series').val(Series);                
//                 $('#NextNumber').val(NextNumber);
//             },
//             complete:function(data){
//                 getSupplierDropdown();
//             }
//         }); 
//     }





    function getSupplierDropdown(){

        var table = document.getElementById("tblSCRTQC_ExternalIssue");
        var tbodyRowCount = table.tBodies[0].rows.length; 

        var dataString ='action=SupplierDropdown_ajax';

        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',   
            data: dataString,  
            beforeSend: function(){
                // $(".loader123").show();
            },


            success: function(result)
            {  
               var JSONObject = JSON.parse(result);
               //console.log('JSONObject=>',JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=tbodyRowCount; 
                   $('#SC_ExternalI_SupplierCode'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->

                $('.ExternalIssueSelectedBPWithData').select2();// with data supplier dropdown
                $('.ExternalIssueDefault').select2();// default supplier dropdown
            },
            complete:function(data){
                getWareHouseDropdown();
            }
        });
    }

    function getWareHouseDropdown(){
        var table = document.getElementById("tblSCRTQC_ExternalIssue");
        var tbodyRowCount = table.tBodies[0].rows.length; 

        var dataString ='action=WareHouseDropdown_ajax';

        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,  
            beforeSend: function(){
            },
            success: function(result)
            {  
                var JSONObject = JSON.parse(result);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=tbodyRowCount; 
                    $('#SC_ExternalI_Warehouse'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->

                $('.ExternalIssueWareHouseDefault').select2();// with data supplier dropdown
                $('.ExternalIssueWareHouseWithData').select2();// default supplier dropdown
            },
            complete:function(data){
                getWareHouseExtraIssueDropdown();
            }
        });
    }

    function getWareHouseExtraIssueDropdown() {
        var table = document.getElementById("tblSCRTQC_ExtraIssue");
        var tbodyRowCount = table.tBodies[0].rows.length; 

        var dataString ='action=WareHouseDropdown_ajax';

        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',  
            data: dataString,  
            beforeSend: function(){
            },
            success: function(result)
            {  
                var JSONObject = JSON.parse(result);
                // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id=tbodyRowCount; 
                    $('#SC_FEI_Warehouse'+un_id).html(JSONObject);
                // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->

                $('.SC_FEI_WarehouseDefault').select2();// with data supplier dropdown
                $('.SC_FEI_WarehouseWithData').select2();// default supplier dropdown
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    // function ExternalIssueSelectedBP(un_id){

    //     var SupplierCode=document.getElementById('SCRTQCB_SupplierCode').value;
    //     var dataString ='SupplierCode='+SupplierCode+'&action=SupplierSingleData_ajax';

    //     $.ajax({  
    //         type: "POST",  
    //         url: 'ajax/kri_production_common_ajax.php',  
    //         data: dataString,  
    //         beforeSend: function(){
    //         // Show image container
    //            $(".loader123").show();
    //         },
    //         success: function(result)
    //         {  
    //             var JSONObject = JSON.parse(result);
    //             $('#SC_FEXI_SupplierName'+un_id).val(JSONObject);
    //         },
    //         complete:function(data){
    //            // Hide image container
    //            $(".loader123").hide();
    //         }
    //     });
    // }


function ExternalIssueSelectedBP(un_id){
        
    var CardCode=document.getElementById('SC_ExternalI_SupplierCode'+un_id).value;
    var Loc = $('#Location').val();
    var Branch= $('#Branch').val();
    var ItemCode = $('#ItemCode').val();
    var MakeBy = $('#makeby').val();    

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
                $('#SC_FEXI_UOM'+un_id).val($('#UOM').val());
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

    var Loc = $('#Location').val();
    var Branch= $('#Branch').val();
    var ItemCode = $('#ItemCode').val();
    var MakeBy = $('#makeby').val();  
    var UOM = $('#UOM').val();

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
    })
}















    function SearchData()
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
    }

    function OpenInventoryTransferModel_sampleIssue()
    {
        var Branch=document.getElementById('Branch').value;
        var Series=document.getElementById('si_Series').value;
        var DocEntry=document.getElementById('it__DocEntry').value;
        var BPLId=document.getElementById('BPLId').value;
        var gd_docNo=document.getElementById('gd_docNo').value;

        
        var dataString ='DocEntry='+DocEntry+'&action=OpenInventoryTransferSamplessue_In_ajax';

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
                var JSONObject = JSON.parse(result);

                //console.log('JSONObject=>',JSONObject);

                $('#gd_BaseDocType').val('SCS_SCINPROC');
                $('#gd_BaseDocNum').val(DocEntry);
                $('#gd_branch').val(Branch);
                $('#gd_Series').val(Series);
                $('#gd_docNo').val(gd_docNo);
                
                $('#it_BPLId').val(BPLId);
                $('#it_DocEntry').val(DocEntry);
                $('#InventoryTransferItemAppend').html(JSONObject);

                getSeriesDropdown_gd() // DocName By using API to get dropdown 
                ContainerSelection(''); // get Container Selection Table List
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }



    function OpenInventoryTransferModel_RetailsIssue()
    {
        var Branch=document.getElementById('Branch').value;
        var Series=document.getElementById('si_Series').value;
        var DocEntry=document.getElementById('it__DocEntry').value;
        var BPLId=document.getElementById('BPLId').value;
        
        var dataString ='DocEntry='+DocEntry+'&action=OpenInventoryTransferSamplessue_In_ajax';
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
                var JSONObject = JSON.parse(result);

                $('#iT_InventoryTransfer_BaseDocType').val('SCS_SCINPROC');
                $('#iT_InventoryTransfer_BaseDocNum').val(DocEntry);
                $('#iT_InventoryTransfer_branch').val(Branch);
                $('#it_InventoryTransfer_BPLId').val(BPLId);
                $('#it_InventoryTransfer_DocEntry').val(DocEntry);
                $('#iT_InventoryTransfer_PostingDate').val();
                $('#iT_InventoryTransfer_DocumentDate').val();

                $('#InventoryTransferItemAppend_retails').html(JSONObject);

                // getSeriesDropdown_retails();
                ContainerSelection_retails(); // get Container Selection Table List
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function getSeriesDropdown_gd()
    {  
        var TrDate=$('#gd_PostingDate_extra').val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=67&action=getSeriesDropdown_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                var SeriesDropdown = JSON.parse(result);
               

                //console.log('SeriesDropdown',SeriesDropdown);
                
                $('#iT_InventoryTransfer_external_series').html(SeriesDropdown);

            },
            complete:function(data){
                selectedSeries_gd();
            }
        }); 
    }

    

function getSeriesDropdown_gd_extra()
{
    // alert('hii');
    var TrDate=$('#gd_PostingDate_extra').val();
    var dataString ='TrDate='+TrDate+'&ObjectCode=60&action=getSeriesDropdown_ajax';
    $.ajax({
        type: "POST",
        url: 'ajax/common-ajax.php',
        data: dataString,
        cache: false,
        beforeSend: function(){
            $(".loader123").show();
        },
        success: function(result){
            var SeriesDropdown = JSON.parse(result);

            console.log('SeriesDropdown',SeriesDropdown);
            $('#gd_Series_extra').html(SeriesDropdown);
        },
        complete:function(data){
            selectedSeries_gd_extra()
        }
    })
}

    



    function selectedSeries_gd_extra()
    {

      
        var TrDate=$('#gd_PostingDate_extra').val();
        var Series=document.getElementById('gd_Series_extra').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=60&action=getSeriesSingleData_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);

                console.log('JSONObject111=>',JSONObject)

            var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];         
                $('#it_Docno').val(Series);                
                $('#extra_docNo').val(NextNumber);
            },
            complete:function(data){
                    $(".loader123").hide();
            }
        }); 
    }


function selectedSeries_gd(){
   
    var TrDate=$('#gd_PostingDate_extra').val();
    var Series=document.getElementById('iT_InventoryTransfer_external_series').value;
    var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=60&action=getSeriesSingleData_ajax';
    $.ajax({
        type: "POST",
        url: 'ajax/kri_production_common_ajax.php',
        data: dataString,
        cache: false,

        beforeSend: function(){
        },
        success: function(result)
        {
            var JSONObject = JSON.parse(result);            
            //console.log('JSONObject=>',JSONObject);
         var NextNumber=JSONObject[0]['NextNumber'];
            var Series=JSONObject[0]['Series'];         
            $('#it_numner_Series').val(Series);                
            $('#external_docNo').val(NextNumber);
        },
        complete:function(data){
                $(".loader123").hide();
        }
    }); 
}






    function ContainerSelection(){

        var DocEntry=document.getElementById('it__DocEntry').value;
        var BatchNo=document.getElementById('it_BatchNo').value;
        var ItemCode=document.getElementById('itP_ItemCode').value;
        var itP_FromWhs=document.getElementById('itP_FromWhs').value;

        var dataString ='ItemCode='+ItemCode+'&WareHouse='+itP_FromWhs+'&DocEntry='+DocEntry+'&BatchNo='+BatchNo+'&action=OpenInventoryTransfer_Simple_issue_process_in_ajax';

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
                var JSONObject = JSON.parse(result);
                 $('#ContainerSelectionItemAppend').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function ContainerSelection_retails(){

        var DocEntry=document.getElementById('it__DocEntry').value;
        var BatchNo=document.getElementById('it_BatchNo').value;
        var ItemCode=document.getElementById('itP_ItemCode').value;
        var itP_FromWhs=document.getElementById('itP_FromWhs').value;

        var dataString ='ItemCode='+ItemCode+'&WareHouse='+itP_FromWhs+'&DocEntry='+DocEntry+'&BatchNo='+BatchNo+'&action=OpenInventoryTransfer_Retails_issue_process_in_ajax';

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
                var JSONObject = JSON.parse(result);
                $('#ContainerSelectionItemAppend_retails').html(JSONObject); 
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


    function EnterQtyValidation(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){

                $('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

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
            document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
    }
    
    function getSelectedContener_retails(un_id)
    {
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_retails");
 
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
            document.getElementById("cs_selectedQtySum_retails").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
        // <!-- --------------------- when user select checkbox update flag start here -------------- -->
            var usercheckListVal=document.getElementById('usercheckList_retails'+un_id).value;
            if(usercheckListVal=='0'){
                $(`#usercheckList_retails`+un_id).val('1');
            }else{
                $(`#usercheckList_retails`+un_id).val('0');
            }
        // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
    }

    function EnterQtyValidation_retails(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty_retails'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty_retails'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){

                $('#SelectedQty_retails'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS_retails'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
            }else{
                $('#SelectedQty_retails'+un_id).val(BatchQty); // if user enter grater than val
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#SelectedQty_retails'+un_id).val(BatchQty); // if user enter blank val
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
        }
        getSelectedContener_num_retails(un_id);
    }


    function getSelectedContener_num_retails(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_retails");
 
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
            document.getElementById("cs_selectedQtySum_retails").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
    }

    function SubmitInventoryTransfer_sample_issue()
    {
        var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
        var PostingDate=document.getElementById('gd_PostingDate').value;
        var DocDate=document.getElementById('gd_DocumentDate').value;
        var ItemCode=document.getElementById('itP_ItemCode').value;
        var ItemName=document.getElementById('itP_ItemName').value;
        var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
        var fromWhs=document.getElementById('itP_FromWhs').value;
        var ToWhs=document.getElementById('itP_ToWhs').value;
        var Location=document.getElementById('itP_Loction').value;

        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(ToWhs!=''){ // Item level To Warehouse validation

                if(PostingDate!=''){ // Posting Date validation

                    if(DocDate!=''){ // Document Date validation

                        // <!-- ---------------- form submit process start here ----------------- -->
                            var formData = new FormData($('#inventory_transfer_form_issue_sample')[0]); 
                            formData.append("SubIT_Btn_S_sample_issue",'SubIT_Btn_sampleIssue'); 

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
                                        var JSONObject = JSON.parse(result);
                                        //console.log(JSONObject);

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

    // function getSeriesDropdown_retails()

    // {
    //     var TrDate = $(`#gd_PostingDate_extra`).val();
    //     var dataString ='TrDate='+TrDate+'$ObjectCode=67&action=getSeriesDropdown_ajax';
    //     $.ajax({
    //         type: "POST",
    //         url: 'ajax/common-ajax.php',
    //         data: dataString,
    //         cache: false,
    //         beforeSend: function(){
    //             $(".loader123").show();
    //         },
    //         success: function(result){
    //             var SeriesDropdown = JSON.parse(result);

    //             console.log('SeriesDropdown',SeriesDropdown);

    //             $('#iT_InventoryTransfer_series').html(SeriesDropdown);
    //             $('#iT_InventoryTransfer_external_series').html(SeriesDropdown);
    //         },
    //         complete:function(data){
    //             $(".loader123").hide();
    //         }
    //     }); 
    // }





    function SubmitInventoryTransfer_Retials_issue()
    {
        var selectedQtySum=document.getElementById('cs_selectedQtySum_retails').value; // final Qty sum
        var PostingDate=document.getElementById('iT_InventoryTransfer_PostingDate').value;
        var DocDate=document.getElementById('iT_InventoryTransfer_DocumentDate').value;
        var ItemCode=document.getElementById('itP_ItemCode').value;
        var ItemName=document.getElementById('itP_ItemName').value;
        var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
        var fromWhs=document.getElementById('itP_FromWhs').value;
        var ToWhs=document.getElementById('itP_ToWhs').value;
        var Location=document.getElementById('itP_Loction').value;

        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(ToWhs!=''){ // Item level To Warehouse validation

                if(PostingDate!=''){ // Posting Date validation

                    if(DocDate!=''){ // Document Date validation

                        // <!-- ---------------- form submit process start here ----------------- -->
                            var formData = new FormData($('#inventory_transfer_form_issue_Retails')[0]); 
                            formData.append("SubIT_Btn_Retails_issue",'SubIT_Btn_sampleIssue'); 

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
                                        $(".loader123").show();
                                    },
                                    success: function(result)
                                    {
                                        var JSONObject = JSON.parse(result);
                                        //console.log(JSONObject);

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
                        wal("Oops!", "Please Select A Document Date.", "error");
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



    function processInReverseSampleIssue(){

        var DocEntry=document.getElementById('SampleIssue').value;

        var dataString ='DocEntry='+DocEntry+'&action=PrpcessInReverseSampleIsuue_ajax';

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

    function SampleCollectionRetestQCUpdateForm()
    {
        var formData = new FormData($('#SampleCollectionProcessInUpdateForm')[0]); // form Id
        formData.append("SampleCollectionProcessInUpdateForm_Btn",'SampleCollectionProcessInUpdateForm_Btn'); // submit btn Id

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
                },complete:function(data){
                    $(".loader123").hide();
                }
            });
        }   
    }


function OpenInventoryExternalTransferModel(){
    var un_id=document.getElementById('RowLevelSelectedExternalIssue').value;  // selected row un_id

    var Branch=document.getElementById('Branch').value;
    var Series=document.getElementById('si_Series').value;
    var DocEntry=document.getElementById('it__DocEntry').value;
    var BPLId=document.getElementById('BPLId').value;

    var dataString ='DocEntry='+DocEntry+'&action=OpenInventoryTransferSamplessue_In_ajax';
    $.ajax({
        type: "POST",
        url: 'ajax/kri_production_common_ajax.php',
        data: dataString,
        cache: false,
        beforeSend: function(){
            $(".loader123").show();
        },
        success: function(result){
            var JSONObject = JSON.parse(result);
            $('#iT_InventoryTransfer_external_BaseDocType').val('SCS_SCINPROC');
            $('#iT_InventoryTransfer_external_BaseDocNum').val(DocEntry);
            $('#iT_InventoryTransfer_external_branch').val(Branch);
            $('#it_InventoryTransfer_external_BPLId').val(BPLId);
            $('#it_InventoryTransfer_external_DocEntry').val(DocEntry);
            $('#InventoryTransferItemAppend_external').html(JSONObject);

            ContainerSelection_extenal(); // get Container Selection Table List
        },
        complete:function(data){
            $(".loader123").hide();
        }
    })
}




function ContainerSelection_extenal(){
    var selectedRadio = document.querySelector('input[name="listRado"]:checked');

    // Check if a radio button is selected
    if (selectedRadio) {
        // Get the value of the selected radio button
        var selectedValue = selectedRadio.value;
        var SC_ExternalQty_Row = $('#SC_FEXI_SampleQuantity' + selectedValue).val()
        var SC_ExternalLineId_Row = $('#SC_FEXI_Linenum' + selectedValue).val();
    } else {
        var SC_ExternalQty_Row = 0.000;
        var SC_ExternalLineId_Row = '';
    }
    var DocEntry=document.getElementById('it__DocEntry').value;
    var BatchNo=document.getElementById('it_BatchNo').value;
    var ItemCode=document.getElementById('itP_ItemCode').value;
    var itP_FromWhs=document.getElementById('itP_FromWhs').value;

    var dataString ='ItemCode='+ItemCode+'&WareHouse='+itP_FromWhs+'&DocEntry='+DocEntry+'&BatchNo='+BatchNo+'&action=OpenInventoryTransfer_external_process_in_ajax';
    $.ajax({
        type: "POST",
        url: 'ajax/kri_production_common_ajax.php',
        data: dataString,
        cache: false,
        beforeSend: function(){
            $(".loader123").show();
        },
        success: function(result){
            var JSONObject = JSON.parse(result);

            $('#ContainerSelectionItemAppend_external').html(JSONObject);
            $('#itP_BQty').val(SC_ExternalQty_Row);
            $('#it_Linenum').val(SC_ExternalLineId_Row);           
        },
        complete:function(data){
            $(".loader123").hide();
        }
    })
}

    function getSelectedContener_extenal(un_id)
    {
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_external");
 
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
            document.getElementById("cs_selectedQtySum_external").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
        // <!-- --------------------- when user select checkbox update flag start here -------------- -->
            var usercheckListVal=document.getElementById('usercheckList_external'+un_id).value;
            if(usercheckListVal=='0'){
                $(`#usercheckList_external`+un_id).val('1');
            }else{
                $(`#usercheckList_external`+un_id).val('0');
            }
        // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
    }

    function EnterQtyValidation_external(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty_external'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty_external'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){

                $('#SelectedQty_external'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS_external'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
            }else{
                $('#SelectedQty_external'+un_id).val(BatchQty); // if user enter grater than val
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#SelectedQty_external'+un_id).val(BatchQty); // if user enter blank val
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
        }
        getSelectedContener_num_external(un_id);
    }

    function getSelectedContener_num_external(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_external");
 
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
            document.getElementById("cs_selectedQtySum_external").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
    }




    


function OpenInventoryTransferModel_extraIssue()
{
    var Branch=document.getElementById('Branch').value;
    var Series=document.getElementById('si_Series').value;
    var DocEntry=document.getElementById('it__DocEntry').value;
    var BPLId=document.getElementById('BPLId').value;
    
    var dataString ='DocEntry='+DocEntry+'&action=OpenInventoryTransferExtraIssue_In_ajax';

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
            var JSONObject = JSON.parse(result);

            $('#gd_BaseDocType_extra').val('SCS_SCINPROC');
            $('#gd_BaseDocNum_extra').val(DocEntry);
            $('#gd_branch_extra').val(Branch);
            $('#gd_Series_extra').val(Series);
            $('#it_BPLId_extra').val(BPLId);
            $('#it_DocEntry_extra').val(DocEntry);
            $('#InventoryTransferItemAppend_extra').html(JSONObject);

            getSeriesDropdown_gd_extra()
            // getSeriesDropdown_gd() // DocName By using API to get dropdown 
            ContainerSelection_extraIssue(); // get Container Selection Table List
        },
        complete:function(data){
            $(".loader123").hide();
        }
    }) 
}


function ContainerSelection_extraIssue(){
    var selectedRadio = document.querySelector('input[name="ExtraIslistRado[]"]:checked');
// Check if a radio button is selected


                    if (selectedRadio) {
                        // console.log('If');
                        // Get the value of the selected radio button
                        var selectedValue = selectedRadio.value;
                        var SC_ExteraQty_Row = $('#SC_FEI_SampleQuantity' + selectedValue).val();
                        var SC_ExteraLineId_Row = $('#SC_FEI_Linenum' + selectedValue).val();
                    } else {
                        // console.log('else');
                        var SC_ExteraQty_Row = 0.000;
                        var SC_ExteraLineId_Row = '';
                    }
 

            // console.log('SC_ExteraQty_Row=>', SC_ExteraQty_Row);
            // console.log('SC_ExteraLineId_Row->', SC_ExteraLineId_Row);

        var DocEntry=document.getElementById('it__DocEntry').value;
        var BatchNo=document.getElementById('BatchNo').value;
        // alert(BatchNo);
        var ItemCode=document.getElementById('ItemCode').value;
        var itP_FromWhs=document.getElementById('itP_FromWhs').value;



        var dataString ='ItemCode='+ItemCode+'&WareHouse='+itP_FromWhs+'&DocEntry='+DocEntry+'&BatchNo='+BatchNo+'&action=OpenInventoryTransfer_ExtraIssueProcess_in_ajax';

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
                var JSONObject = JSON.parse(result);
                $('#ContainerSelectionItemAppend_extra').html(JSONObject);
                $('#itP_BQty_extra').val(SC_ExteraQty_Row);
                $('#it_LineId').val(SC_ExteraLineId_Row);           
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }
// -----


    function getSelectedContener_extra(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_extra");
 
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
            document.getElementById("cs_selectedQtySum_extra").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

        // <!-- --------------------- when user select checkbox update flag start here -------------- -->
            var usercheckListVal=document.getElementById('usercheckList_extra'+un_id).value;

            if(usercheckListVal=='0'){
                $(`#usercheckList_extra`+un_id).val('1');
            }else{
                $(`#usercheckList_extra`+un_id).val('0');
            }
        // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
    }


    function EnterQtyValidation_extra(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty_extra'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty_extra'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){

                $('#SelectedQty_extra'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS_extra'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

            }else{
                $('#SelectedQty_extra'+un_id).val(BatchQty); // if user enter grater than val
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#SelectedQty_extra'+un_id).val(BatchQty); // if user enter blank val
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
        }

        getSelectedContenerGI_Manual_extra(un_id);
    }

    function getSelectedContenerGI_Manual_extra(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_extra");
 
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
            document.getElementById("cs_selectedQtySum_extra").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
    }






 function SubmitInventoryTransfer_external()
    {
        var selectedQtySum=document.getElementById('cs_selectedQtySum_external').value; // final Qty sum
        var PostingDate=document.getElementById('gd_PostingDate_extra').value;
        var DocDate=document.getElementById('iT_InventoryTransfer_external_DocumentDate').value;
        var ItemCode=document.getElementById('itP_ItemCode').value;
        var ItemName=document.getElementById('itP_ItemName').value;
        var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
        var fromWhs=document.getElementById('itP_FromWhs').value;
        var ToWhs=document.getElementById('itP_ToWhs').value;
        var Location=document.getElementById('itP_Loction').value;







        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(ToWhs!=''){ // Item level To Warehouse validation

                if(PostingDate!=''){ // Posting Date validation

                    if(DocDate!=''){ // Document Date validation

                        // <!-- ---------------- form submit process start here ----------------- -->
                            var formData = new FormData($('#inventory_transfer_form_external')[0]); 
                            formData.append("SubIT_Btn_transfer",'SubIT_Btn_transfer'); 
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
                                        $(".loader123").show();
                                    },
                                    success: function(result)
                                    {
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
                                    },complete:function(data){
                                        $(".loader123").hide();
                                    }
                                });
                            }
                        // <!-- ---------------- form submit process end here ------------------- -->
                    }else{
                        wal("Oops!", "Please Select A Document Date.", "error");
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




function SubmitInventoryTransfer_extra(){

     var selectedQtySum=document.getElementById('cs_selectedQtySum_extra').value; // final Qty sum
        var PostingDate=document.getElementById('gd_PostingDate_extra').value;
        var DocDate=document.getElementById('gd_DocumentDate_extra').value;
        var ItemCode=document.getElementById('itP_ItemCode_extra').value;
        var ItemName=document.getElementById('itP_ItemName_extra').value;
        var item_BQty=parseFloat(document.getElementById('itP_BQty_extra').value).toFixed(6);  // item available Qty
        var fromWhs=document.getElementById('itP_FromWhs_extra').value;
        var ToWhs=document.getElementById('itP_ToWhs_extra').value;
        var Location=document.getElementById('itP_Loction_extra').value;

        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(ToWhs!=''){ // Item level To Warehouse validation

                if(PostingDate!=''){ // Posting Date validation

                    if(DocDate!=''){ // Document Date validation

                        // <!-- ---------------- form submit process start here ----------------- -->
                            var formData = new FormData($('#inventory_transfer_form_extra')[0]); 
                            formData.append("SubIT_Btn_post_extra_issue",'SubIT_Btn_post_extra_issue'); 

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
                                        $(".loader123").show();
                                    },
                                    success: function(result)
                                    {
                                        var JSONObject = JSON.parse(result);
                                        //console.log(JSONObject);

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
                        wal("Oops!", "Please Select A Document Date.", "error");
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
        // alert('hiiii');
    }

    function selectedExtraIssue(un_id){
        $('#RowLevelSelectedExtraIssue').val(un_id);
        document.getElementById("SC_ExtraIssue_PEI_Btn").disabled= false;
    }

    function AllCheckCheckbox() {
        var mainCheckbox = document.querySelector('.itp_checkboxall');
        var checkboxes = document.querySelectorAll('#ContainerSelectionItemAppend_external .form-check-input');
        var hiddenFields = document.querySelectorAll('input[name="usercheckList_external[]"]');
        
        if (mainCheckbox.checked) {
            checkboxes.forEach((checkbox, index) => {
                checkbox.checked = true;
                hiddenFields[index].value = '1';
            });
        } else {
            checkboxes.forEach((checkbox, index) => {
                checkbox.checked = false;
                hiddenFields[index].value = '0';
            });
        }
        AllcalculateSum();
    }

    function AllcalculateSum() {
        var selectedQtyFields = document.querySelectorAll('input[name="SelectedQty_external[]"]');
        var hiddenFields = document.querySelectorAll('input[name="usercheckList_external[]"]');
        var total = 0;

        selectedQtyFields.forEach((field, index) => {
            if (hiddenFields[index].value === '1') {
                var value = parseFloat(field.value) || 0;
                total += value;
            }
        });

        document.getElementById('cs_selectedQtySum_external').value = total.toFixed(6);
    }
</script>
<!-- 2610 -->