<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}
// $ARNo[] = [
//     'Series' => 234
// ];
// echo '<pre>';
// print_r(json_encode($ARNo));
// die();

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $tdata=array();
    $tdata['FromDate']=date('Ymd', strtotime($_POST['fromDate']));
    $tdata['ToDate']=date('Ymd', strtotime($_POST['toDate']));
    $tdata['DocEntry']=trim(addslashes(strip_tags($_POST['DocEntry'])));

    $getAllData=$obj->getSimpleIntimation($SAMPLEINTMUNDERTEST_API,$tdata);
    // echo '<pre>';
    // print_r($getAllData);
    // die();
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
                                    <input type="radio" id="list'.$getAllData[$i]->DocEntry.'" name="listRado" value="'.$getAllData[$i]->DocEntry.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord('.$getAllData[$i]->DocEntry.')">
                                </td>

                                <td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_GRPONo.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_GRPODEnt.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_UTTrans.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_VCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_VName.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_BPRefNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->GRPOLineNum.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_ICode.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_IName.'</td>
                                <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_BNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_BQty.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpiryDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->U_Branch.'</td>
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
<?php include 'models/sample-collection-model.php' ?>
        <!-- gridjs css -->
        <link rel="stylesheet" href="assets/libs/gridjs/theme/mermaid.min.css">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    
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
                                        <h4 class="card-title mb-0">Sample Intimation</h4> 
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
                                        <div class="row">
                                            <!-- ------- Hidden Filed Prepare Start Here ------------------------------- -->
                                                <input type="hidden" id="si_LineNum" name="si_LineNum">
                                                <input type="hidden" id="si_DocEntry" name="si_DocEntry">
                                            <!-- ------- Hidden Filed Prepare End Here --------------------------------- -->

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO No</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control desabled" type="text" id="si_GRPONo" name="si_GRPONo" readonly>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input class="form-control desabled" type="text" id="si_GRPODocEntry" name="si_GRPODocEntry" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>

                                                    <div class="col-lg-6">
                                                        <input class="form-control desabled" type="text" id="si_DocNoName" name="si_DocNoName" readonly>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <input class="form-control desabled" type="text" id="si_DocNo" name="si_DocNo" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Vendor Code</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_SupplierCode" name="si_SupplierCode" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Vendor Name</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_SupplierName" name="si_SupplierName" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">BP Ref. No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_BpRefNo" name="si_BpRefNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_SampleType" name="si_SampleType" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_TrType" name="si_TrType" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_ItemCode" name="si_ItemCode" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_ItemName" name="si_ItemName" readonly>
                                                    </div>
                                                </div>
                                            </div>   

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_GRPO_Qty" name="si_GRPO_Qty" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                    <div class="col-lg-4">
                                                            <input class="form-control desabled" type="number" id="si_SQty" name="si_SQty" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="si_Unit" name="si_Unit" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="number" id="si_RQty" name="si_RQty" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG By</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_MfgBy" name="si_MfgBy">
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Total No of container</label>
                                                    <div class="col-lg-7">
                                                        <input class="form-control desabled" type="number" id="si_NoOfcontainer" name="si_NoOfcontainer" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_FromContainer" name="si_FromContainer" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_ToContainer" name="si_ToContainer" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="si_statusDrop" name="si_statusDrop" readonly>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="si_StatusChekBox" name="si_StatusChekBox" style="pointer-events: none;">
                                                            <label class="form-check-label" for="flexCheckDefault">Cancelled</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_TrDate" name="si_TrDate" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_BranchName" name="si_BranchName" readonly>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_ChNo" name="si_ChNo" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_ChDate" name="si_ChDate" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_GateEntryNo" name="si_GateEntryNo">
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_PostingDate" name="si_PostingDate" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_MfgDate" name="si_MfgDate" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container UOM</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="text" id="si_Container" name="si_Container" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_BatchNo" name="si_BatchNo" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_BatchQty" name="si_BatchQty" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container Nos</label>
                                                    <div class="col-lg-8">
                                                       <textarea class="form-control desabled" style="position: absolute;width: 92%;" id="si_ContainerNOS" name="si_ContainerNOS" readonly ></textarea>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_ExpiryDate" name="si_ExpiryDate" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_Location" name="si_Location" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Qty Per Container</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_QtyPerContainer" name="si_QtyPerContainer" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="si_MakeBy" name="si_MakeBy" readonly="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Type of Material</label>
                                                    <div class="col-lg-7">
                                                        <input class="form-control desabled" type="text" id="si_TypeofMaterial" name="si_TypeofMaterial" readonly="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-2 col-form-label mt-6" for="val-skill">Container Nos</label>
                                                    <div class="col-lg-10">
                                                        <textarea class="form-control desabled" id="si_ContainerNOS" name="si_ContainerNOS" rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Toggle States Button -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="button" id="befor" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" autocomplete="off" onclick="TransToUnder();">Transfer To Undertest</button>

                                                    <button type="button" id="after" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".after_inventory_transfer" autocomplete="off" onclick="TransToUnderAfter();">Transfer To Undertest</button>

                                                    <input type="text" id="U_UTTrans" name="U_UTTrans" readonly class="desabled">
                                                </div>

                                                <div class="col-md-6 text-right">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_quarantine" autocomplete="off" onclick="ViewPrintUndertestLabel_RPT();">Print Undertest Label</button>

                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_quarantine" autocomplete="off" onclick="ViewPrintQuarantine_RPT();">Print Quarantine</button>

                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sample_inti_print_quarantine" autocomplete="off" onclick="ViewPrintSampleIntimation_RPT();">Print Sample Intimation</button>
                                                </div>
                                            </div>
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
                </div>
                <!-- End Page-content -->
                <br>
           <?php include 'include/footer.php' ?>

    <script type="text/javascript">

        // <!-- -------------- Direct called function diclear Start Here --------------------------------
            $(".loader123").hide(); // loader default hide script
            $("#footerProcess").hide(); // Afer Doc Selection Process default hide script
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
                    $('#list-append').html(result);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            });
        }

        function selectedRecord(DocEntry){
            var dataString ='DocEntry='+DocEntry+'&action=sample_intimation_ajax';

            $.ajax({
                type: "POST",  
                url: 'ajax/common-ajax.php',  
                data: dataString,  
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){  
                    $("#footerProcess").show();
                    var JSONObject = JSON.parse(result);

                    $(`#si_MakeBy`).val(JSONObject[0]['MakeBy']);
                    $(`#si_TypeofMaterial`).val(JSONObject[0]['TypeofMaterial']);

                    // ------------ row one start ------------------------------------------------------------
                        $(`#si_GRPONo`).val(JSONObject[0]['U_GRPONo']);
                        $(`#si_GRPODocEntry`).val(JSONObject[0]['U_GRPODEnt']);
                        $(`#si_BpRefNo`).val(JSONObject[0]['U_BPRefNo']);
                        $(`#si_ItemName`).val(JSONObject[0]['U_IName']);
                        $(`#si_MfgBy`).val(JSONObject[0]['U_MfgBy']);
                        $(`#si_statusDrop`).val(JSONObject[0]['Status']);
                        //  <!-- --------------- Cancelled Checkbox Set Value Start Here ---------------- -->
                            var Canceled=JSONObject[0]['Canceled'];

                            if(Canceled=='N'){
                                document.getElementById("si_StatusChekBox").checked = false; // Uncheck
                            }else{
                                document.getElementById("si_StatusChekBox").checked = true; // Check
                            }
                        //  <!-- --------------- Cancelled Checkbox Set Value end Here ---------------- -->
                            
                        // <!-- ----------- Challan Date Start Here ----------------------------------- -->
                            var chDateOG = JSONObject[0]['U_ChDate'];
                            if(chDateOG!=''){
                                ChDate = chDateOG.split(' ')[0];
                                $(`#si_ChDate`).val(ChDate); 
                            }
                        // <!-- ----------- Challan Date End Here ------------------------------------- -->
                        $(`#si_Container`).val(JSONObject[0]['U_Cont']);

                        // <!-- ----------- MfgDate Start Here ----------------------- -->
                            var mfgDateOG = JSONObject[0]['U_MfgDate'];
                            if (mfgDateOG!=''){
                                MfgDate = mfgDateOG.split(' ')[0];
                                $(`#si_MfgDate`).val(MfgDate);
                            }
                        // <!-- ----------- MfgDate End Here ------------------------- -->
                    // ------------ row one end here ---------------------------------------------------------

                    // ------------ row two start here -------------------------------------------------------
                        $(`#si_DocNoName`).val(JSONObject[0]['SeriesName']);
                        $(`#si_DocNo`).val(JSONObject[0]['DocNum']);
                        $(`#si_SampleType`).val(JSONObject[0]['U_SType']);
                        $(`#si_GRPO_Qty`).val(JSONObject[0]['U_GRPOQty']);
                        $(`#si_NoOfcontainer`).val(JSONObject[0]['U_TNCont']);

                        // <!-- ----------- TR Date Start Here ----------------------- -->
                            var tRDateOG = JSONObject[0]['U_TRDate'];
                            if(tRDateOG !=''){
                                TRDateOG = tRDateOG.split(' ')[0];
                                $(`#si_TrDate`).val(TRDateOG);
                            }
                        // <!-- ----------- TR Date End Here ------------------------- -->

                        $(`#si_GateEntryNo`).val(JSONObject[0]['U_GEntNo']);
                        $(`#si_BatchNo`).val(JSONObject[0]['U_BNo']);
                        $(`#si_Location`).val(JSONObject[0]['Location']);
                    // ------------ row two end here ---------------------------------------------------------

                    // ------------ row three start here -----------------------------------------------------
                        $(`#si_SupplierCode`).val(JSONObject[0]['U_VCode']);
                        $(`#si_TrType`).val(JSONObject[0]['U_TRBy']);
                        $(`#si_SQty`).val(JSONObject[0]['U_SQty']);
                        $(`#si_Unit`).val(JSONObject[0]['Unit']);
                        $(`#si_FromContainer`).val(JSONObject[0]['U_FCont']);
                        $(`#si_BranchName`).val(JSONObject[0]['U_Branch']);

                        // <!-- ----------- Gate Entry Date Start Here ----------------------- -->
                            var gEntDateOG = JSONObject[0]['U_GEntDate'];

                            if(gEntDateOG!=''){
                                gEntDateOG = gEntDateOG.split(' ')[0];
                                $(`#si_PostingDate`).val(gEntDateOG);
                            }
                        // <!-- ----------- Gate Entry Date End Here ------------------------- -->

                        $(`#si_BatchQty`).val(JSONObject[0]['U_BQty']);
                        $(`#si_QtyPerContainer`).val(JSONObject[0]['U_TNCont1']);
                    // ------------ row three end here -------------------------------------------------------

                    // ------------ row Four start here ------------------------------------------------------
                        $(`#si_SupplierName`).val(JSONObject[0]['U_VName']);
                        $(`#si_ItemCode`).val(JSONObject[0]['U_ICode']);
                        $(`#si_RQty`).val(JSONObject[0]['U_RQty']);
                        $(`#si_ToContainer`).val(JSONObject[0]['U_TCont']);
                        $(`#si_ChNo`).val(JSONObject[0]['U_ChNo']);
                        $(`#si_ContainerNOS`).val(JSONObject[0]['U_CNos']);
                        // <!-- ----------- Gate Entry Date Start Here ----------------------- -->
                            var expDateOG = JSONObject[0]['U_ExpDate'];

                            if(expDateOG!=''){
                                expDateOG = expDateOG.split(' ')[0];
                                $(`#si_ExpiryDate`).val(expDateOG);
                            }
                        // <!-- ----------- Gate Entry Date End Here ------------------------- -->
                    // ------------ row Four end here --------------------------------------------------------

                    $(`#si_LineNum`).val(JSONObject[0]['GRPOLineNum']); // hidden field
                    $(`#si_DocEntry`).val(JSONObject[0]['DocEntry']); // hidden field

                    $(`#U_UTTrans`).val(JSONObject[0]['U_UTTrans']); //
                    // --------------- bottom popup button hide & show script start here-----------------------
                        if(JSONObject[0]['U_UTTrans']==''){
                            $("#befor").show(); // Add Process Popup
                            $("#after").hide(); // View Process Popup
                        }else{
                            $("#befor").hide(); // Add Process Popup
                            $("#after").show(); // View Process Popup
                        }
                    // --------------- bottom popup button hide & show script end here-----------------------
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            });
        }

        function TransToUnder(){
            var SupplierCode=document.getElementById('si_SupplierCode').value;
            var SupplierName=document.getElementById('si_SupplierName').value;
            var BranchName=document.getElementById('si_BranchName').value;
            var DocEntry=document.getElementById('si_DocEntry').value;

            var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=OpenInventoryTransfer_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    $('#it_SupplierCode').val(SupplierCode);
                    $('#it_SupplierName').val(SupplierName);
                    $('#it_BranchName').val(BranchName);
                    $('#it_DocEntry').val(DocEntry);

                    var JSONObject = JSON.parse(result);
                    $('#InventoryTransferItemAppend').html(JSONObject);

                    getSeriesDropdown() // DocName By using API to get dropdown 
                    ContainerSelection() // get Container Selection Table List
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            }); 
        }

        function TransToUnderAfter(){
            var DocEntry=document.getElementById('U_UTTrans').value;
            var dataString ='DocEntry='+DocEntry+'&action=AfterInventoryTransfer_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){   
                    var JSONObject= JSON.parse(result);
                    // console.log(JSONObject);

                    $('#it_af_SupplierCode').val(JSONObject[0]['CardCode']);
                    $('#it_af_SupplierName').val(JSONObject[0]['CardName']);
                    $('#it_af_DocNoName').val(JSONObject[0]['Series']);
                    $('#it_af_DocNo').val(JSONObject[0]['DocNum']);
                    $('#it_af_Branch').val(JSONObject[0]['BranchName']);
                    $('#it_af_DocType').val(JSONObject[0]['BaseDocType']);
                    $('#it_af_BaseDocNum').val(JSONObject[0]['BaseDocNum']);

                    // <!-- ----------- Posting Date Start Here ----------------------- -->
                        var docDateOG = JSONObject[0]['DocDate'];
                        if(docDateOG!=''){
                            docDateOG = docDateOG.split(' ')[0];
                            $(`#it_af_postingDate`).val(docDateOG);
                        }
                    // <!-- ----------- Posting Date End Here ------------------------- -->

                    // <!-- ----------- Document Date Start Here ----------------------- -->
                        var taxDate = JSONObject[0]['TaxDate'];
                        if(taxDate!=''){
                            taxDate = taxDate.split(' ')[0];
                            $(`#it_af_DocDate`).val(taxDate);
                        }
                    // <!-- ----------- Document Date End Here ------------------------- -->

                    $('#it_af_ItemCode').val(JSONObject[0]['ItemCode']);
                    $('#it_af_ItemName').val(JSONObject[0]['ItemName']);
                    $('#it_af_Quantity').val(JSONObject[0]['Quantity']);
                    $('#it_af_FromWhs').val(JSONObject[0]['FromWhs']);
                    $('#it_af_ToWhse').val(JSONObject[0]['ToWhse']);
                    $('#it_af_Location').val(JSONObject[0]['Location']);
                    // $('#it_af_Location').val(JSONObject[0]['Location']);
                    $('#it_af_UOM').val(JSONObject[0]['UOM']);

                    AfterContainerSelection(JSONObject[0]['LineNum']); // get Container Selection Table View Mode List
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            });
        }

        function AfterContainerSelection(LineNum){
            var DocEntry=document.getElementById('U_UTTrans').value;
            var ItemCode=document.getElementById('it_af_ItemCode').value;
            var WareHouse=document.getElementById('it_af_ToWhse').value;

            var dataString ='DocEntry='+DocEntry+'&ItemCode='+ItemCode+'&LineNum='+LineNum+'&WareHouse='+WareHouse+'&action=AfterOpenInventoryTransferCS_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var JSONObject = JSON.parse(result);
                    $('#AfterContainerSelectionItemAppend').html(JSONObject);
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

            var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=OpenInventoryTransferCS_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var JSONObject = JSON.parse(result);
                    $('#ContainerSelectionItemAppend').html(JSONObject);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            });
        }

        function getSeriesDropdown(){
            var TrDate=$('#si_TrDate').val();
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
                    $('#it_DocNoName').html(SeriesDropdown);
                    selectedSeries(); // call Selected Series Single data function
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            }); 
        }

        function selectedSeries(){
            var TrDate=$('#si_TrDate').val();
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
                success: function(result){
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

        function EnterQtyValidation(un_id) {

            // Select the checkbox using its ID
            var checkbox = document.getElementById('itp_CS'+un_id);

            var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
            var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

            if(SelectedQty!=''){
                if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){
                    $('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                    $('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

                    // <!-- ----- checkbox selection start ---------------- -->
                        // Check the checkbox
                        checkbox.checked = true;
                    // <!-- ----- checkbox selection start ---------------- -->

                }else{
                    $('#itp_CS'+un_id).val(BatchQty);
                    $('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val

                    // <!-- ----- checkbox selection start ---------------- -->
                        // Check the checkbox
                        checkbox.checked = false;
                    // <!-- ----- checkbox selection start ---------------- -->

                    swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
                }
            }else{
                $('#itp_CS'+un_id).val(BatchQty);
                $('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val

                // <!-- ----- checkbox selection start ---------------- -->
                    // Check the checkbox
                    checkbox.checked = false;
                // <!-- ----- checkbox selection start ---------------- -->
                swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
            }

            getSelectedContener(un_id); // if user change selected Qty value after selection 
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

            // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
                const array = selected;
                let sum = 0;

                for (let i = 0; i < array.length; i++) {
                    sum += parseFloat(array[i]);
                }
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

        function SubmitInventoryTransfer(){
            var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
            var item_BQty=parseFloat(document.getElementById('itP_BQty').value).toFixed(6);  // item available Qty
            var PostingDate=document.getElementById('it_PostingDate').value;
            var DocDate=document.getElementById('it_DocDate').value;

            if(selectedQtySum==item_BQty){ // Container selection Qty validation
                if(PostingDate!=''){ // Posting Date validation
                    if(DocDate!=''){ // Document Date validation
                        // <!-- ---------------- form submit process start here ----------------- -->
                            var formData = new FormData($('#inventory_transfer_form')[0]); // form Id
                            formData.append("SubIT_Btn",'SubIT_Btn'); // submit btn Id
                            var error = true;

                            if(error){
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
                                        console.log(result);
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
                                    },
                                    complete:function(data){
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

        function ViewPrintQuarantine_RPT(){
            var DocEntry=$('#si_DocEntry').val();
            var PrintOutURL=`http://192.168.1.30:8082/API/SAP/SAMPLEINTIQUARLABEL?DocEntry=${DocEntry}`;

            document.getElementById('RPT_title').innerHTML= 'Print Quarantine';
            document.getElementById("PrintQuarantine_Link").src = PrintOutURL;
        }

            function ViewPrintUndertestLabel_RPT(){
                // var DocEntry=$('#U_UTTrans').val();
                var DocEntry=$('#si_DocEntry').val();
                if(DocEntry!=''){
                    var PrintOutURL=`http://192.168.1.30:8082/API/SAP/SAMPLEINTIUNDERTEST?DocEntry=${DocEntry}`;
                    document.getElementById("PrintQuarantine_Link").src = PrintOutURL;
                }

                document.getElementById('RPT_title').innerHTML= 'Print Undertest Label';
            }

            function ViewPrintSampleIntimation_RPT(){
                var DocEntry=$('#si_DocEntry').val();
                var PrintOutURL=`http://192.168.1.30:8082/API/SAP/INWARDSAMPLEINTIMATION?DocEntry=${DocEntry}`;

                document.getElementById('RPT_title').innerHTML= 'Print Sample Intimation';
                document.getElementById("PrintQuarantine_Link").src = PrintOutURL;
            }

        function ViewPrintQuarantine_RPT_Close(){
            document.getElementById('RPT_title').innerHTML= '';
            document.getElementById("PrintQuarantine_Link").src = '';
        }
    </script>