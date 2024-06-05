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

    $getAllData=$obj->getSimpleIntimation($RETESTQCSAMPLEINTIMATIONAFTERADD_API,$tdata);

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
                        <th>GRPO No</th>
                        <th>GRPO DocEntry</th>
                        <th>Under Test Trans. No</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Bp Ref No</th>
                        <th>LineNum</th>
                        <th>Item Code</th> 
                        <th>Item Name</th>
                        <th>Unit</th>
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
                        if(!empty($getAllData[$i]->DocEntry)){   //  this condition save to extra blank loop
                            $SrNo=$i+1;
                            // --------------- Convert String code Start Here ---------------------------
                                if(empty($getAllData[$i]->MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $MfgDate_OG = str_replace('/', '-', $getAllData[$i]->MfgDate); 
                                    // All (/) replace to (-)
                                    $MfgDate=date("d-m-Y", strtotime($MfgDate_OG));
                                }

                                if(empty($getAllData[$i]->ExpiryDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate_OG = str_replace('/', '-', $getAllData[$i]->ExpiryDate); 
                                    // All (/) replace to (-)
                                    $ExpiryDate=date("d-m-Y", strtotime($ExpiryDate_OG));
                                }
                            // --------------- Convert String code End Here-- ---------------------------

                        $option.='
                            <tr>
                                <td class="desabled">'.$SrNo.'</td>
                                <td style="text-align: center;">
                                    <input type="radio" id="list'.$getAllData[$i]->DocEntry.'" name="listRado" value="'.$getAllData[$i]->DocEntry.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord('.$getAllData[$i]->DocEntry.')">
                                </td>

                                <td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->GRNNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->GRNEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->TransferUnderTest.'</td>
                                <td class="desabled">'.$getAllData[$i]->SupplierCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->SupplierName.'</td>
                                <td class="desabled">'.$getAllData[$i]->BpRefNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->LineNum.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpiryDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->BranchName.'</td>
                            </tr>';
                        }
                    }
                }else{
                     $option.='<tr><td colspan="21" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
                }
        $option.='</tbody> 
    </table>'; 

    $option.=$pagination;        
    echo $option;
    exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/retest_qc/sample_intimation_retest_qc_modal.php' ?>

<style type="text/css">
    body[data-layout=horizontal] .page-content {
        padding: 20px 0 0 0;
        padding: 40px 0 60px 0;
    }

    textarea.form-control {
        min-height: calc(3.6em + 0.94rem + 2px);
    }
</style>

<!-- ---------- loader start here--------------------------------------------------------------------- -->
    <div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
        <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
            <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
        </div>
    </div>
<!-- ---------- loader end here--------------------------------------------------------------------- -->
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
                            <h4 class="mb-0">Sample Intimation</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Sample Intimation</li>
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
                                <h4 class="card-title mb-0">Sample Intimation-Retest QC</h4> 
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
                <!-- end row -->
                <br>

                <div class="row" id="footerProcess">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form>
                                    <div class="row">

                                        <!-- hidden field define start ----------------------------------------- -->
                                            <input type="hidden" id="SIRTAD_BranchID" name="SIRTAD_BranchID">
                                            <input type="hidden" id="SIRTAD_DocEntry" name="SIRTAD_DocEntry">
                                            <input type="hidden" id="SIRTAD_FrmWhse" name="SIRTAD_FrmWhse">
                                            <input type="hidden" id="SIRTAD_LineNum" name="SIRTAD_LineNum">
                                            <input type="hidden" id="SIRTAD_LocID" name="SIRTAD_LocID">
                                            <input type="hidden" id="SIRTAD_PostingDate" name="SIRTAD_PostingDate">
                                            <input type="hidden" id="SIRTAD_RetestDate" name="SIRTAD_RetestDate">
                                            <input type="hidden" id="SIRTAD_Series" name="SIRTAD_Series">
                                            <input type="hidden" id="SIRTAD_ToWhse" name="SIRTAD_ToWhse">
                                            <input type="hidden" id="SIRTAD_WhsCode" name="SIRTAD_WhsCode">
                                        <!-- hidden field define end ----------------------------------------- -->

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO No</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_GRNNo" name="SIRTAD_GRNNo" readonly>
                                                </div>
                                                 <div class="col-lg-2">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_GRPODocEntry" name="SIRTAD_GRPODocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_DocName" name="SIRTAD_DocName" readonly>
                                                </div>
                                                 <div class="col-lg-2">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_DocNo" name="SIRTAD_DocNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Vendor Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_SupplierCode" name="SIRTAD_SupplierCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Vendor Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_SupplierName" name="SIRTAD_SupplierName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">BP Ref. No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_BpRefNo" name="SIRTAD_BpRefNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control desabled" id="SIRTAD_SampleType" name="SIRTAD_SampleType" readonly>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_TrType" name="SIRTAD_TrType" readonly>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_ItemCode" name="SIRTAD_ItemCode" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_ItemName" name="SIRTAD_ItemName" readonly>
                                                </div>
                                            </div>
                                        </div>   

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="number" id="SIRTAD_GRPO_Qty" name="SIRTAD_GRPO_Qty" readonly>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_SQty" name="SIRTAD_SQty" readonly>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_Unit" name="SIRTAD_Unit" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="number" id="SIRTAD_RQty" name="SIRTAD_RQty" readonly>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_MfgBy" name="SIRTAD_MfgBy" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-5 col-form-label mt-6" for="val-skill">Total No of container</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control desabled" type="number" id="SIRTAD_NoOfcontainer" name="SIRTAD_NoOfcontainer" readonly>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_FromContainer" name="SIRTAD_FromContainer" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_ToContainer" name="SIRTAD_ToContainer" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_Status" name="SIRTAD_Status" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" value="" id="SIRTAD_StatusChekBox" name="SIRTAD_StatusChekBox" style="pointer-events: none;">
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
                                                    <input class="form-control desabled" type="tetx" id="SIRTAD_TrDate" name="SIRTAD_TrDate" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_BranchName" name="SIRTAD_BranchName" readonly>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_ChallanNo" name="SIRTAD_ChallanNo">
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_ChallanDate" name="SIRTAD_ChallanDate" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_GateEntryNo" name="SIRTAD_GateEntryNo">
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_GateEntryDate" name="SIRTAD_GateEntryDate" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Tr. No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="number" id="SIRTAD_TrNo" name="SIRTAD_TrNo" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_Container" name="SIRTAD_Container" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_BatchNo" name="SIRTAD_BatchNo" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="number" id="SIRTAD_BatchQty" name="SIRTAD_BatchQty" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container Nos</label>
                                                <div class="col-lg-8">
                                                   <textarea class="form-control desabled" id="SIRTAD_ContainerNOS" name="SIRTAD_ContainerNOS" style="position: absolute;width: 92%;" readonly ></textarea>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_MfgDate" name="SIRTAD_MfgDate" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_ExpiryDate" name="SIRTAD_ExpiryDate" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_Location" name="SIRTAD_Location" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6"></div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Qty Per Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_QtyPerContainer" name="SIRTAD_QtyPerContainer" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SIRTAD_MakeBy" name="SIRTAD_MakeBy" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                      
                                        <!-- Toggle States Button -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary" id="befor" data-bs-toggle="modal" data-bs-target=".inventory_transfer" autocomplete="off" onclick="TransferToUndertest();">Transfer To Undertest</button>

                                                <button type="button" class="btn btn-primary" id="after" data-bs-toggle="modal" data-bs-target=".after_inventory_transfer" autocomplete="off" onclick="TransferToUndertestAfter()">Transfer To Undertest</button>

                                                <input type="text" id="SIRTAD_UTTrans" name="SIRTAD_UTTrans" class="desabled" readonly>
                                            </div>

                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_modal" autocomplete="off" onclick="ViewPrint_RPT('RETESTSAMPLEINTIUNDERTEST','Print Undertest Label');">Print Undertest Label</button>

                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_modal" autocomplete="off" onclick="ViewPrint_RPT('RETESTSAMPLEINTIQUARLABEL','Print Quarantine');">Print Quarantine</button>

                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_modal" autocomplete="off" onclick="ViewPrint_RPT('RETESTSAMPLEINTIMATION','Print Sample Intimation');">Print Sample Intimation</button>
                                            </div>
                                        </div>
                                    </div>
                                </form><!-- form end -->
                            </div><!--row end-->
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
                $('#list-append').html(result);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
       });
    }

    function selectedRecord(DocEntry){

        var dataString ='DocEntry='+DocEntry+'&action=sample_intimation_Retest_QC_ajax';

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
                $("#footerProcess").show();
                var JSONObject = JSON.parse(result);
                // console.log(JSONObject);

                // ------------ row one start -------------------------------------------------------
                    $(`#SIRTAD_GRNNo`).val(JSONObject[0]['GRNNo']);
                    $(`#SIRTAD_GRPODocEntry`).val(JSONObject[0]['GRNEntry']);
                    $(`#SIRTAD_BpRefNo`).val(JSONObject[0]['BpRefNo']);
                    $(`#SIRTAD_ItemName`).val(JSONObject[0]['ItemName']);
                    $(`#SIRTAD_Status`).val(JSONObject[0]['Status']);
                    $(`SIRTAD_MfgBy`).val(JSONObject[0]['MfgBy']);
                    $(`#SIRTAD_Container`).val(JSONObject[0]['Container']);
                    $(`#SIRTAD_QtyPerContainer`).val(JSONObject[0]['QtyPerContainer']);
                    $(`#SIRTAD_MakeBy`).val(JSONObject[0]['MakeBy']);

                    //  <!-- --------------- Cancelled Checkbox Set Value Start Here ---------------- -->
                        var Canceled=JSONObject[0]['Canceled'];

                        if(Canceled=='N'){
                            document.getElementById("SIRTAD_StatusChekBox").checked = false; // Uncheck
                        }else{
                            document.getElementById("SIRTAD_StatusChekBox").checked = true; // Check
                        }
                    //  <!-- --------------- Cancelled Checkbox Set Value end Here ---------------- -->

                    // <!-- ----------- MfgDate Start Here ----------------------- -->
                        var mfgDateOG = JSONObject[0]['MfgDate'];
                        if (mfgDateOG!=''){
                            MfgDate = mfgDateOG.split(' ')[0];
                            $(`#SIRTAD_MfgDate`).val(MfgDate);
                        }
                    // <!-- ----------- MfgDate End Here ------------------------- -->

                    // <!-- ----------- Challan Date Start Here ----------------------- -->
                        var challanDateOG = JSONObject[0]['challanDate'];

                        if(challanDateOG !='' && challanDateOG!=null){
                            challanDate = challanDateOG.split(' ')[0];
                            $(`#SIRTAD_ChallanDate`).val(challanDate);
                        }
                    // <!-- ----------- Challan Date End Here ------------------------- -->

                // ------------ row one end here ---------------------------------------------------------

                // ------------ row two start here -------------------------------------------------------
                    $(`#SIRTAD_DocName`).val(JSONObject[0]['Series']);
                    $(`#SIRTAD_DocNo`).val(JSONObject[0]['DocNum']);
                    $(`#SIRTAD_SampleType`).val(JSONObject[0]['SampleType']);
                    $(`#SIRTAD_GRPO_Qty`).val(JSONObject[0]['GRPOQty']);
                    $(`#SIRTAD_NoOfcontainer`).val(JSONObject[0]['TotNoCont']);

                    // <!-- ----------- TR Date Start Here ----------------------- -->
                        var tRDateOG = JSONObject[0]['TRDate'];
                        if(tRDateOG !=''){
                            TRDateOG = tRDateOG.split(' ')[0];
                            $(`#SIRTAD_TrDate`).val(TRDateOG);
                        }
                    // <!-- ----------- TR Date End Here ------------------------- -->
                    // <!-- ----------- Expiry Date Start Here ----------------------- -->
                        var expiryDateOG = JSONObject[0]['ExpiryDate'];
                        if(expiryDateOG !=''){
                            expiryDate = expiryDateOG.split(' ')[0];
                            $(`#SIRTAD_ExpiryDate`).val(expiryDate);
                        }
                    // <!-- ----------- Expiry Date End Here ------------------------- -->
                    
                    $(`#SIRTAD_GateEntryNo`).val(JSONObject[0]['GateEntryNo']); // Missing
                    $(`#SIRTAD_BatchNo`).val(JSONObject[0]['BatchNo']);
                // ------------ row two end here ---------------------------------------------------------

                // ------------ row three start here -----------------------------------------------------
                    $(`#SIRTAD_SupplierCode`).val(JSONObject[0]['SupplierCode']);
                    $(`#SIRTAD_TrType`).val(JSONObject[0]['TRBy']);
                    $(`#SIRTAD_SQty`).val(JSONObject[0]['SQty']);
                    $(`#SIRTAD_Unit`).val(JSONObject[0]['Unit']);
                    $(`#SIRTAD_FromContainer`).val(JSONObject[0]['FromCont']);
                    $(`#SIRTAD_BranchName`).val(JSONObject[0]['BranchName']);

                    
                    // <!-- ----------- Gate Entry Date Start Here ----------------------- -->
                        var getEntryDateOG = JSONObject[0]['GateEntryDate'];

                        if(getEntryDateOG !='' && getEntryDateOG!=null){
                            getEntryDate = getEntryDateOG.split(' ')[0];
                            $(`#SIRTAD_GateEntryDate`).val(getEntryDate);
                        }
                    // <!-- ----------- Gate Entry Date End Here ------------------------- -->

                    $(`#SIRTAD_BatchQty`).val(JSONObject[0]['BatchQty']);
                    $(`#SIRTAD_Location`).val(JSONObject[0]['Location']);
                // ------------ row three end here -------------------------------------------------------

                // ------------ row Four start here -----------------------------------------------------
                    $(`#SIRTAD_SupplierName`).val(JSONObject[0]['SupplierName']);
                    $(`#SIRTAD_ItemCode`).val(JSONObject[0]['ItemCode']);
                    $(`#SIRTAD_RQty`).val(JSONObject[0]['RQty']);
                    $(`#SIRTAD_ToContainer`).val(JSONObject[0]['ToCont']);
                    $(`#SIRTAD_ContainerNOS`).val(JSONObject[0]['ContainerNos']);

                    $(`#SIRTAD_ChallanNo`).val();
                    $(`#SIRTAD_TrNo`).val(JSONObject[0]['TRNo']);
                // ------------ row Four end here -------------------------------------------------------

                    $(`#SIRTAD_UTTrans`).val(JSONObject[0]['TransferUnderTest']); // Transfer Under Test Value

                // --------------------- Hidden Field definr Start here
                    $(`#SIRTAD_BranchID`).val(JSONObject[0]['BranchID']);
                    $(`#SIRTAD_DocEntry`).val(JSONObject[0]['DocEntry']);
                    $(`#SIRTAD_FrmWhse`).val(JSONObject[0]['FrmWhse']);
                    $(`#SIRTAD_LineNum`).val(JSONObject[0]['LineNum']);
                    $(`#SIRTAD_LocID`).val(JSONObject[0]['LocID']);
                    $(`#SIRTAD_PostingDate`).val(JSONObject[0]['PostingDate']);
                    $(`#SIRTAD_RetestDate`).val(JSONObject[0]['RetestDate']);
                    // $(`#SIRTAD_Series`).val(JSONObject[0]['Series']);
                    $(`#SIRTAD_ToWhse`).val(JSONObject[0]['ToWhse']);
                    $(`#SIRTAD_WhsCode`).val(JSONObject[0]['WhsCode']);
                // --------------------- Hidden Field definr Start here

                // --------------- bottom popup button hide & show script start here-----------------------
                    if(JSONObject[0]['TransferUnderTest']==''){
                        $("#befor").show(); // Add Process Popup
                        $("#after").hide(); // View Process Popup
                    }else{
                        $("#befor").hide(); // Add Process Popup
                        $("#after").show(); // View Process Popup
                    }
                // --------------- bottom popup button hide & show script end here-----------------------
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        });
    }

    function TransferToUndertest()
    {
        var SupplierCode=document.getElementById('SIRTAD_SupplierCode').value;
        var SupplierName=document.getElementById('SIRTAD_SupplierName').value;
        var BranchName=document.getElementById('SIRTAD_BranchName').value;
        var DocEntry=document.getElementById('SIRTAD_DocEntry').value;
        var BPL_Id=document.getElementById('SIRTAD_BranchID').value;

        var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=OpenSampleIntimationRetestInventoryTransfer_ajax';

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
                $('#SIRTIT_SupplierCode').val(SupplierCode);
                $('#SIRTIT_SupplierName').val(SupplierName);
                $('#SIRTIT_BranchName').val(BranchName);
                $('#SIRTIT_DocEntry').val(DocEntry);
                $('#SIRTIT_BaseDocType').val('SCS_SIRETEST');
                $('#SIRTIT_BPL_Id').val(BPL_Id);

                var JSONObject = JSON.parse(result);
                $('#SampleIntimationInventoryTransferItemAppend').html(JSONObject);

                getSeriesDropdown() // DocName By using API to get dropdown 
                ContainerSelection() // get Container Selection Table List
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function getSeriesDropdown(){
        var TrDate = $(`#SIRTIT_PostingDate`).val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=67&action=getSeriesDropdown_ajax';

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
                $('#SIRTIT_DocNoName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeries(){
        var TrDate = $(`#SIRTIT_PostingDate`).val();
        var Series=document.getElementById('SIRTIT_DocNoName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=67&action=getSeriesSingleData_ajax';

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

                $('#SIRTIT_DocNo').val(Series);
                $('#SIRTIT_NextNumber').val(NextNumber);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function ContainerSelection(){

        var GRPODEnt=document.getElementById('SIRTIT_i_GRNEntry').value;
        var BNo=document.getElementById('SIRTIT_i_BatchNo').value;
        var ItemCode=document.getElementById('SIRTIT_i_ItemCode').value;
        var FromWhs=document.getElementById('SIRTIT_i_FromWhs').value;

        var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=sample_intimation_Retest_QC_ContainerList_ajax';

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
                $('#ContainerSelectionItemAppend').html(JSONObject);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function EnterQtyValidation(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){

                $('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(4));
                $('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(4)); // same value set on checkbox value

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
            document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(4); // Container Selection final sum
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

    function SubmitSampleIntimationRetestQCInventoryTransfer(){

        var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
        var item_BQty=parseFloat(document.getElementById('SIRTIT_i_BQty').value).toFixed(4);  // item available Qty
        var PostingDate=document.getElementById('SIRTIT_PostingDate').value;
        var DocDate=document.getElementById('SIRTIT_DocDate').value;

        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(PostingDate!=''){ // Posting Date validation

                if(DocDate!=''){ // Document Date validation

                // <!-- ---------------- form submit process start here ----------------- -->
                    var formData = new FormData($('#SIRT_inventory_transfer_form')[0]); // form Id
                    formData.append("SIRTIT_SubBtn",'SIRTIT_SubBtn'); // submit btn Id
                    // SIRTIT_SubBtn
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
                                // Show image container
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
            swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
        }
    }

    function TransferToUndertestAfter(){

        var DocEntry=document.getElementById('SIRTAD_UTTrans').value;
        var Location=document.getElementById('SIRTAD_Location').value;

        var dataString ='DocEntry='+DocEntry+'&action=SIRTIT_View_ajax';

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
                var JSONObject= JSON.parse(result);
                $('#SampleIntimationRetestQCInventoryTransferAfterHTMLAppend').html(JSONObject);

                var Series=document.getElementById('SIRTIT_View_Series').value; // get Series Id 
                getSeriesDataViewMood(Series); // get Series Name Using Series Code

                document.getElementById("SIRTIT_View_Locatio").innerHTML = Location; // set Item Table Location value
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
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
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                var Series_Name=JSONObject[0]['SeriesName'];
        
                $('#SIRTIT_View_Series_Name').val(Series_Name);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }
</script>

<script type="text/javascript">
    function ViewPrint_RPT(API_Name,FormTitle){
        var DocEntry=$('#SIRTAD_DocEntry').val();
        var PrintOutURL=`http://192.168.1.30:8082/API/SAP/${API_Name}?DocEntry=${DocEntry}`;

        document.getElementById('RPT_title').innerHTML= FormTitle;
        document.getElementById("RPTPrint_Link").src = PrintOutURL;
    }

    function RPTPrint_Close(){
        document.getElementById('RPT_title').innerHTML= '';
        document.getElementById("RPTPrint_Link").src = '';
    }
</script>