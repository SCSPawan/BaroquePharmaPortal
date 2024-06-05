
<?php 
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

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
    $getAllData=$obj->getSimpleIntimation($INPROCESSSAMPLEINTIMATIONADD,$tdata);

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
                    <th>RFP Entry</th>
                    <th>Material Type</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>WO Qty</th> 
                    <th>Batch No</th>
                    <th>Batch Qty</th>
                    <th>Mfg Date</th>
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

                                if(empty($getAllData[$i]->ExpiryDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate = str_replace('/', '-', $getAllData[$i]->ExpiryDate); 
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
                                <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                <td class="desabled">'.$getAllData[$i]->RFPODocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->MaterialType.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                <td class="desabled">'.$getAllData[$i]->WOQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpiryDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->BranchName.'</td>
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
<?php include 'models/qc_process/sample_intimation_in_process_model.php' ?>
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
                                    <h4 class="mb-0">Sample Intimation - In Process</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Sample Intimation - In Process</li>
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
                                        <h4 class="card-title mb-0">Sample Intimation - In Process</h4> 
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
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <br>
                        <div class="row" id="footerProcess">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
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
                                            <input type="hidden" id="it__DocEntry" name="it_DocEntry">
                                            <input type="hidden" id="si_Series" name="si_Series">
                                    
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
                                                            <select class="form-control desabled" id="DocNoName" name="DocNoName" disabled readonly>
                                                            <option>Primary</option>
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
                                                            <input class="form-control desabled" type="text" id="wOQty" name="wOQty" readonly>
                                                        </div>
                                                    </div>
                                                </div>  

                                                 <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" type="text" id="sampleQty" name="sampleQty" readonly>
                                                        </div>
                                                    </div>
                                                </div> 

                                                 <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" type="text" id="RetainQty" name="RetainQty" readonly>
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
                                                            <input class="form-control desabled" type="number" id="totalNoOfContainer" name="totalNoOfContainer" readonly>
                                                        </div>
                                                        <!-- <div class="col-lg-3">
                                                            <input class="form-control desabled" type="number" id="totalNoOfContainer1" name="totalNoOfContainer1" readonly>
                                                        </div> -->
                                                    </div>
                                                </div>  

                                                  <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" type="text" id="fromContainer" name="fromContainer" readonly>
                                                        </div>
                                                    </div>
                                                </div> 

                                                 <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" type="text" id="ToContainer" name="ToContainer" readonly>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" type="text" id="BatchNo" name="BatchNo"readonly>
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
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="date" id="MFGDate" name="MFGDate">
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="date" id="ExpiryDate" name="ExpiryDate">
                                                        </div>
                                                    </div>
                                                </div> 

                                                 <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                                        <div class="col-lg-4">
                                                            <input class="form-control desabled" type="text" type="text" id="statusVal" name="statusVal" readonly>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-check">
                                                              <input class="form-check-input desabled" type="checkbox" id="flexCheckDefault" readonly>
                                                              <label class="form-check-label desabled" for="flexCheckDefault">
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
                                                            <input class="form-control" type="date" id="TrDate" name="TrDate">
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
                                                            <input class="form-control desabled" type="text" id="ChallanNo" name="ChallanNo" readonly>
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
                                                            <input class="form-control" type="date" id="GateEntryDate" name="GateEntryDate">
                                                        </div>
                                                    </div>
                                                </div> 

                                                 <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container Nos</label>
                                                        <div class="col-lg-8">
                                                            <textarea class="form-control desabled" rows="1" readonly id="ContainerNo" name="ContainerNo"></textarea>
                                                        </div>
                                                    </div>
                                                </div> 

                                                 <div class="col-xl-3 col-md-6">
                                                    <div class="form-group row mb-2">
                                                       <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control desabled" type="text" id="Container" name="Container" readonly>
                                                        </div>
                                                    </div>
                                                </div> 

                                              <!-- Toggle States Button -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        
                                                        <button type="button" id="UTT_aftre" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" onclick="TransfeToUndertestInventroryTransfer('')" data-bs-toggle="button" autocomplete="off" >Transfer To Undertest</button>
                                                         
                                                        <button type="button" id="UTT_befor" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".after_inventory_transfer" onclick="TransfeToUndertestInventroryTransfer('after')" autocomplete="off">Transfer To Undertest</button>

                                                         <input type="text" id="UnderTestTransferNo" name="UnderTestTransferNo" class="desabled">
                                                    </div>

                                                    <div class="col-md-6 text-right">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Print Undertest Label</button>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Print Quarantine</button>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" >Print Sample Intimation</button>
                                                    </div>
                                                </div>
                                            </div><!--row end-->

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-primary" id="SampleIntimationUpdateForm_Btn" name="SampleIntimationUpdateForm_Btn" onclick="SampleIntimationUpdateForm()">Update</button>
                                            </div>
                                        </div><!--row end-->
                                       </from>
                                        </div>

                                       
                                    <!-- end card body -->

                                </div>
                                <!-- end card -->
                                 

                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
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

    $(document).ready(function()
    {
        var fromDate=document.getElementById('FromDate').value;
        var toDate=document.getElementById('ToDate').value;
        var DocEntry=document.getElementById('DocEntry').value;

        var dataString ='fromDate='+fromDate+'&toDate='+toDate+'&DocEntry='+DocEntry+'&action=list';
// console.log(dataString);
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
            }
            ,
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
       });
    });

    function selectedRecord(DocEntry){

        var dataString ='DocEntry='+DocEntry+'&action=sample_intimation_in_process_ajax';
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
                var JSONObject = JSON.parse(result); // all responce holde and convert here

                $(`#ReceiptNo`).val(JSONObject[0].RFPNo);
                $(`#ReceiptNo1`).val(JSONObject[0].RFPODocEntry);
                $(`#woEntry`).val(JSONObject[0].WOEntry);
                $(`#woNo`).val(JSONObject[0].WONo);
                $(`#BpRefNo`).val(JSONObject[0].BpRefNo);

                $(`#itemCode`).val(JSONObject[0].ItemCode);
                $(`#itemName`).val(JSONObject[0].ItemName);
                $(`#wOQty`).val(JSONObject[0].WOQty);
                $(`#sampleQty`).val(JSONObject[0].SQty);
                $(`#RetainQty`).val(JSONObject[0].RQty);

                $(`#MfgBy`).val(JSONObject[0].MfgBy);
                $(`#totalNoOfContainer`).val(JSONObject[0].TotNoCont);
                $(`#fromContainer`).val(JSONObject[0].FromCont);
                $(`#ToContainer`).val(JSONObject[0].ToCont);

                $(`#BatchNo`).val(JSONObject[0].BatchNo);
                $(`#BatchQty`).val(JSONObject[0].BatchQty);

                $(`#MFGDate`).val(JSONObject[0].MfgDate);
                $(`#ExpiryDate`).val(JSONObject[0].ExpiryDate);
                $(`#statusVal`).val(JSONObject[0].Status);

                $(`#Branch`).val(JSONObject[0].BranchName);

                $(`#ChallanNo`).val(JSONObject[0].ChNo);
                $(`#ChallanDate`).val(JSONObject[0].ChDate);

                $(`#GateEntryNo`).val(JSONObject[0].GateEntryNo);
                $(`#GateEntryDate`).val(JSONObject[0].GateEntryDate);
                $(`#ContainerNo`).val(JSONObject[0].ContainerNos);
                $(`#Container`).val(JSONObject[0].Container);
                $(`#Location`).val(JSONObject[0].Location);
                $(`#RetestDate`).val(JSONObject[0].RetestDate);
                $(`#QtyPerContainer`).val(JSONObject[0].QtyPerContainer);
                $(`#LocCode`).val(JSONObject[0].LocCode);
                $(`#BPLId`).val(JSONObject[0].BranchID);
                $(`#it__DocEntry`).val(JSONObject[0].DocEntry);
                $(`#si_Series`).val(JSONObject[0].Series);


                var Canceled=JSONObject[0]['Canceled'];
                if(Canceled=='N'){
                    document.getElementById("flexCheckDefault").checked = false; // Uncheck
                }else{
                    document.getElementById("flexCheckDefault").checked = true; // Check
                }

                $(`#UnderTestTransferNo`).val(JSONObject[0]['UnderTestTransferNo']);

                if(JSONObject[0]['UnderTestTransferNo']==''){
                    $(`#UTT_befor`).hide();
                    $(`#UTT_aftre`).show();
                }else{
                    $(`#UTT_befor`).show();
                    $(`#UTT_aftre`).hide();
                }

                SampleTypeDropdown();
                getSeriesDropdown(); // DocName By using API to get dropdown 
                TR_ByDropdown(); //TR By API to Get Dropdown
                // --------------- bottom popup button hide & show script end here-----------------------
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        });
    }

    function getSeriesDropdown()
    {
        var dataString ='ObjectCode=SCS_SINPROCESS&action=getSeriesDropdown_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result){
                var SeriesDropdown = JSON.parse(result);
                // console.log(SeriesDropdown);
                $('#DocNoName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeries(){

        var Series=document.getElementById('DocNoName').value;
        var dataString ='Series='+Series+'&ObjectCode=SCS_SINPROCESS&action=getSeriesSingleData_ajax';
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
                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];
                $('#DocNo').val(Series);
                $('#NextNumber').val(NextNumber);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

  function SampleTypeDropdown(){

        var dataString ='TableId=@SCS_SINPROCESS&Alias=PC_SType&action=dropdownMaster_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result){
                var JSONObject = JSON.parse(result);
                // console.log(JSONObject);
                $('#sampleType').html(JSONObject);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        });
    }


  function TR_ByDropdown()
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'action':"TR_ByDropdown_ajax"},

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var SampleTypeDrop = JSON.parse(result);
                $('#TrBy').html(SampleTypeDrop);
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
                $('#list-append').html(result);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
       });
    }


 function TransfeToUndertestInventroryTransfer(after)
    {
        // var SupplierCode=document.getElementById('si_SupplierCode').value;
        // var SupplierName=document.getElementById('si_SupplierName').value;
        var Branch=document.getElementById('Branch').value;
        var Series=document.getElementById('si_Series').value;
        var DocEntry=document.getElementById('it__DocEntry').value;
        var BPLId=document.getElementById('BPLId').value;
        // var afters=
        
        var dataString ='DocEntry='+DocEntry+'&action=OpenInventoryTransfer_ajax';

        // alert(DocEntry);


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
                // console.log(result);
                // $('#it_SupplierCode').val(SupplierCode);
                // $('#it_SupplierName').val(SupplierName);

                if(after==''){
                    $('#it_BaseDocType').val('SCS_SINPROCESS');
                    $('#it_BaseDocNum').val(DocEntry);
                    $('#it_BranchName').val(Branch);
                    $('#it_series').val(Series);
                    $('#it_BPLId').val(BPLId);
                    $('#it_DocEntry').val(DocEntry);
                    $('#InventoryTransferItemAppend').html(JSONObject);

                }else{
                    $('#after_it_BaseDocType').val('SCS_SINPROCESS');
                    $('#after_it_BaseDocNum').val(DocEntry);
                    $('#after_it_BranchName').val(Branch);
                    $('#after_it_series').val(Series);
                    $('#after_it_BPLId').val(BPLId);
                    $('#after_it_DocEntry').val(DocEntry);
                    $('#InventoryTransferItemAppend_after').html(JSONObject);
                }
               
                // alert(after);

                

                // getSeriesDropdown() // DocName By using API to get dropdown 
                ContainerSelection(after) // get Container Selection Table List
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }




function ContainerSelection(after){

        var DocEntry=document.getElementById('it__DocEntry').value;
        var BatchNo=document.getElementById('it_BatchNo').value;
        var ItemCode=document.getElementById('itP_ItemCode').value;
        var itP_ToWhs=document.getElementById('itP_ToWhs').value;

        // ItemCode=P00003&WareHouse=RETN-WHS&DocEntry=297&BatchNo=BQ13

        var dataString ='DocEntry='+DocEntry+'&BNo='+BatchNo+'&ItemCode='+ItemCode+'&FromWhs='+itP_ToWhs+'&afterSet='+after+'&action=OpenInventoryTransfer_process_in_ajax';

        // console.log(dataString);

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
                if(after==""){
                 $('#ContainerSelectionItemAppend').html(JSONObject);
                }else{
                    $('#ContainerSelectionItemAppend_after').html(JSONObject);
                }
                
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

    function EnterQtyValidation(un_id) {
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




  function SubmitInventoryTransfer(){

        var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
        var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
        var PostingDate=document.getElementById('it_PostingDate').value;
        var DocDate=document.getElementById('it_DocumentDate').value;
        var ToWhs=document.getElementById('itP_ToWhs').value;

        // console.log(item_BQty);
        // console.log(selectedQtySum);
        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(ToWhs!=''){ // Item level To Warehouse validation

                if(PostingDate!=''){ // Posting Date validation

                    if(DocDate!=''){ // Document Date validation

                    // <!-- ---------------- form submit process start here ----------------- -->
                        var formData = new FormData($('#inventoryFormSubmit_process_in')[0]); // form Id
                        formData.append("SC_SubIT_Btn_post_doc",'SubIT_Btn'); // submit btn Id
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
                                success: function(result){
                                    // console.log(result);
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



 function SampleIntimationUpdateForm()
    {
        var formData = new FormData($('#SampleIntimationFormInProcess')[0]); // form Id
        formData.append("SampleIntimationUpdateForm_Btn",'SampleIntimationUpdateForm_Btn'); // submit btn Id
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

</script>