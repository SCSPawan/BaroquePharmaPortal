<?php 
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

if(empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list'){
    $tdata=array();
    $tdata['FromDate']=date('Ymd', strtotime($_POST['fromDate']));
    $tdata['ToDate']=date('Ymd', strtotime($_POST['toDate']));
    $tdata['DocEntry']=trim(addslashes(strip_tags($_POST['DocEntry'])));
    $getAllData=$obj->getSimpleIntimation($FGSAMPLEINTIMATIONDETAILS,$tdata);

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
                                <td class="desabled">'.$getAllData[$i]->MatType.'</td>
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
<?php include 'models/qc_process/sample_intimation_finished_goods_model.php' ?>

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Samples Intimation - Finished Goods</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Samples Intimation - Finished Goods</li>
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
                                <h4 class="card-title mb-0">Samples Intimation - Finished Goods</h4> 
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
                                                <div class="col-lg-4">
                                                    <div class="">
                                                        <button type="button" style="top: 0px;" id="SearchBlock" class="btn btn-primary waves-effect" onclick="SearchData()">Search <i class="bx bx-search-alt align-middle"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive" id="list-append"></div> 
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
                                    <input type="hidden" id="SI_FG_DocNo" name="SI_FG_DocNo">
                                    <input type="hidden" id="SI_FG_BranchID" name="SI_FG_BranchID">
                                    <input type="hidden" id="SI_FG_Unit" name="SI_FG_Unit">
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                <div class="col-lg-6">
                                                <input class="form-control desabled" type="text" id="SI_FG_RFPNo" name="SI_FG_RFPNo" readonly>
                                            </div>
                                                <div class="col-lg-2">
                                                <input class="form-control desabled" type="text" id="SI_FG_RFPODocEntry" name="SI_FG_RFPODocEntry" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" readonly type="text" id="SI_FG_DocName" name="SI_FG_DocName">
                                            </div>

                                            <div class="col-lg-4">
                                                <input class="form-control desabled" readonly type="number" id="SI_FG_DocEntry" name="SI_FG_DocEntry">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                <div class="col-lg-6">
                                                <input class="form-control desabled" type="text" id="SI_FG_WoNo" name="SI_FG_WoNo" readonly>
                                            </div>
                                                <div class="col-lg-2">
                                                <input class="form-control desabled" type="text" id="SI_FG_WOEntry" name="SI_FG_WOEntry" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">BP Ref. No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_BPRefNo" name="SI_FG_BPRefNo" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_SampleType" name="SI_FG_SampleType" readonly>
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR By</label>
                                            <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="SI_FG_TRBy" name="SI_FG_TRBy" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_ItemCode" name="SI_FG_ItemCode" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_ItemName" name="SI_FG_ItemName" readonly>
                                            </div>
                                        </div>
                                    </div>   

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_GRPO_Qty" name="SI_FG_GRPO_Qty" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_SampleQty" name="SI_FG_SampleQty" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_RetainQty" name="SI_FG_RetainQty" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6" style="display: none;">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG By</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_MFGBy" name="SI_FG_MFGBy" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Total No of container</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="number" id="SI_FG_TotNoCont" name="SI_FG_TotNoCont" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_FromCont" name="SI_FG_FromCont" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_ToCont" name="SI_FG_ToCont" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_BatchNo" name="SI_FG_BatchNo" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_BatchQty" name="SI_FG_BatchQty" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">MFG Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_MfgDate" name="SI_FG_MfgDate" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_ExpiryDate" name="SI_FG_ExpiryDate" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="SI_FG_Status" name="SI_FG_Status" readonly>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="SI_FG_StatusChekBox" style="pointer-events: none;">
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
                                                <input class="form-control desabled" type="text" id="SI_FG_TRDate" name="SI_FG_TRDate" disabled>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_BranchName" name="SI_FG_BranchName" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6" style="display: none;">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_ChNo" name="SI_FG_ChNo" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6" style="display: none;">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Challan Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_ChDate" name="SI_FG_ChDate" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6" style="display: none;">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_GateEntryNo" name="SI_FG_GateEntryNo" readonly>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-xl-3 col-md-6" style="display: none;">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_GateEntryDate" name="SI_FG_GateEntryDate" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Container UOM</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_Container" name="SI_FG_Container" readonly>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">MakeBy</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="SI_FG_MakeBy" name="SI_FG_MakeBy" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                            
                                    <div class="col-xl-6 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-2 col-form-label mt-6" for="val-skill">Container Nos</label>
                                            <div class="col-lg-10">
                                                <textarea class="form-control desabled" id="SI_FG_ContainerNos" name="SI_FG_ContainerNos" rows="4" readonly=""></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-primary" id="befor" data-bs-toggle="modal" data-bs-target=".inventory_transfer" autocomplete="off" onclick="TransferToUndertest();">Transfer To Undertest</button>

                                            <button type="button" class="btn btn-primary" id="after" data-bs-toggle="modal" data-bs-target=".after_inventory_transfer" autocomplete="off" onclick="TransferToUndertestAfter()">Transfer To Undertest</button>

                                            <input type="text" id="U_UTTrans" name="U_UTTrans" readonly class="desabled">
                                        </div>

                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".Sample_Inti_FG_RPT" autocomplete="off" onclick="View_RPT_Open_PUT('FGSAMPLEINTIUNDERTESTPRINTLAYOUT','Print Undertest Label');">Print Undertest Label</button>

                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".Sample_Inti_FG_RPT" autocomplete="off" onclick="View_RPT_Open('FGSAMPLEINTIQUARANPRINTLAYOUT','Print Quarantine');">Print Quarantine</button>

                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".Sample_Inti_FG_RPT" autocomplete="off" onclick="View_RPT_Open('FGSAMPLEINTISAMPLINTIPRINTLAYOUT','Print Sample Intimation');">Print Sample Intimation</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <br>
        <?php include 'include/footer.php' ?>

        <style type="text/css">
            body[data-layout=horizontal] .page-content {padding: 20px 0 0 0;padding: 40px 0 60px 0;}
        </style>

<script type="text/javascript">
    $(".loader123").hide(); // loader default hide script
    $("#footerProcess").hide(); // Afer Doc Selection Process default hide script

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
        })
    });

    function selectedRecord(DocEntry){
        var dataString ='DocEntry='+DocEntry+'&action=sample_intimation_finished_good_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){  
                $("#footerProcess").show();
                var JSONObject = JSON.parse(result);

                $(`#SI_FG_DocEntry`).val(JSONObject[0].DocEntry);
                $(`#SI_FG_RFPNo`).val(JSONObject[0].RFPNo);
                $(`#SI_FG_RFPODocEntry`).val(JSONObject[0].RFPODocEntry);
                $(`#SI_FG_WoNo`).val(JSONObject[0].WONo);
                $(`#SI_FG_WOEntry`).val(JSONObject[0].WOEntry);
                $(`#SI_FG_DocNo`).val(JSONObject[0].Series);
                $(`#SI_FG_DocName`).val(JSONObject[0].SeriesName);
                $(`#SI_FG_BPRefNo`).val(JSONObject[0].BpRefNo);
                $(`#SI_FG_TRBy`).val(JSONObject[0].TRBy);
                $(`#SI_FG_ItemCode`).val(JSONObject[0].ItemCode);
                $(`#SI_FG_ItemName`).val(JSONObject[0].ItemName);
                $(`#SI_FG_GRPO_Qty`).val(JSONObject[0].WOQty);
                $(`#SI_FG_SampleQty`).val(JSONObject[0].SQty);
                $(`#SI_FG_SampleType`).val(JSONObject[0].SampleType);
                $(`#SI_FG_RetainQty`).val(JSONObject[0].RQty);
                $(`#SI_FG_MFGBy`).val(JSONObject[0].MfgBy);
                $(`#SI_FG_TotNoCont`).val(JSONObject[0].TotNoCont);
                $(`#SI_FG_FromCont`).val(JSONObject[0].FromCont);
                $(`#SI_FG_ToCont`).val(JSONObject[0].ToCont);
                $(`#SI_FG_BatchNo`).val(JSONObject[0].BatchNo);
                $(`#SI_FG_BatchQty`).val(JSONObject[0].BatchQty);
                $(`#SI_FG_Status`).val(JSONObject[0].Status);
                $(`#SI_FG_BranchName`).val(JSONObject[0].BranchName);
                $(`#SI_FG_ChNo`).val(JSONObject[0].ChNo);
                $(`#SI_FG_GateEntryNo`).val(JSONObject[0].GateEntryNo);
                $(`#SI_FG_ContainerNos`).val(JSONObject[0].ContainerNos);
                $(`#SI_FG_Container`).val(JSONObject[0].Container);
                $(`#SI_FG_BranchID`).val(JSONObject[0].BranchID);
                $(`#SI_FG_Unit`).val(JSONObject[0].Unit);
                $(`#SI_FG_MakeBy`).val(JSONObject[0].MakeBy);
                $(`#SI_FG_GateEntryDate`).val(DateFormatingDMY(JSONObject[0].GateEntryDate));
                $(`#SI_FG_ChDate`).val(DateFormatingDMY(JSONObject[0].ChDate));
                $(`#SI_FG_TRDate`).val(DateFormatingDMY(JSONObject[0].TRDate));
                $(`#SI_FG_MfgDate`).val(DateFormatingDMY(JSONObject[0].MfgDate));
                $(`#SI_FG_ExpiryDate`).val(DateFormatingDMY(JSONObject[0].ExpiryDate));

                var Canceled=JSONObject[0]['Canceled'];
                if(Canceled=='N'){
                    document.getElementById("SI_FG_StatusChekBox").checked = false; // Uncheck
                }else{
                    document.getElementById("SI_FG_StatusChekBox").checked = true; // Check
                }

                if (!JSONObject[0]['TransferToUnderTes']) {
                    $("#befor").show(); // Add Process Popup
                    $("#after").hide(); // View Process Popup
                } else {
                    $("#befor").hide(); // Add Process Popup
                    $("#after").show(); // View Process Popup
                }
            },
            complete:function(data){
                $(".loader123").hide();
            }
        })
    } 

    function DateFormatingDMY(DateOG){
        if(DateOG!=''){
            let [day, month, year] = DateOG.split(" ")[0].split("-");
            let Date = `${day}-${month}-${year}`;
            return Date;
        }
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
        })
    }

    function TransferToUndertest(){
        var BranchName=document.getElementById('SI_FG_BranchName').value;
        var Series=document.getElementById('SI_FG_DocNo').value;
        var DocEntry=document.getElementById('SI_FG_DocEntry').value;
        var BPL_Id=document.getElementById('SI_FG_BranchID').value;
        var dataString ='DocEntry='+DocEntry+'&action=OpenSampleIntimationFinishedGoodInventoryTransfer_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                $('#TransferToUndertest_Branch').val(BranchName);
                $('#TransferToUndertest_DocEntry').val(DocEntry);
                $('#TransferToUndertest_BaseDocType').val('SCS_SINTIFG');
                $('#TransferToUndertest_BPL_Id').val(BPL_Id);
                $('#TransferToUndertest_BaseDocNum').val(DocEntry);

                var JSONObject = JSON.parse(result);
                $('#SampleIntimationInventoryTransferItemAppend').html(JSONObject);
            },
            complete:function(data){
                ContainerSelection() // get Container Selection Table List
            }
        })
    }

    function ContainerSelection(){
        var DocEntry=document.getElementById('TransferToUndertest_i_GRNEntry').value;
        var BNo=document.getElementById('TransferToUndertest_i_BatchNo').value;
        var ItemCode=document.getElementById('TransferToUndertest_i_ItemCode').value;
        var FromWhs=document.getElementById('TransferToUndertest_i_FromWhs').value;

        var dataString ='DocEntry='+DocEntry+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=sample_intimation_Finished_Good_ContainerList_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
            },
            success: function(result){
                var JSONObject = JSON.parse(result);
                $('#ContainerSelectionItemAppend').html(JSONObject);
            },
            complete:function(data){
                getSeriesDropdown() // DocName By using API to get dropdown 
            }
        })
    }

    function getSeriesDropdown(){
        var TrDate= $('#TransferToUndertest_PostingDate').val();
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
                $('#TransferToUndertest_DocName').html(SeriesDropdown);
            },
            complete:function(data){
                selectedSeries(); // call Selected Series Single data function
            }
        })
    }

    function selectedSeries(){
        var TrDate= $('#TransferToUndertest_PostingDate').val();
        var Series=document.getElementById('TransferToUndertest_DocName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=67&action=getSeriesSingleData_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
            },
            success: function(result){
                var JSONObject = JSON.parse(result);

                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];

                $('#TransferToUndertest_DocNo').val(NextNumber);
                $('#TransferToUndertest_Series').val(Series);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        })
    }  

    function TransferToUndertestAfter(){
        var BranchName=document.getElementById('SI_FG_BranchName').value;
        var Series=document.getElementById('SI_FG_DocNo').value;
        var DocEntry=document.getElementById('SI_FG_DocEntry').value;
        var BPL_Id=document.getElementById('SI_FG_BranchID').value;
        var dataString ='DocEntry='+DocEntry+'&action=OpenSampleIntimationFinishedGoodInventoryTransferAfter_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                $('#after_TransferToUndertest_Branch').val(BranchName);
                $('#after_TransferToUndertest_Series').val(Series);
                $('#after_TransferToUndertest_DocEntry').val(DocEntry);
                $('#after_TransferToUndertest_BaseDocType').val('SCS_SINTIFG');
                $('#after_TransferToUndertest_BPL_Id').val(BPL_Id);
                $('#after_TransferToUndertest_BaseDocNum').val(DocEntry);

                var JSONObject = JSON.parse(result);
                $('#SampleIntimationInventoryTransferItemAppend_after').html(JSONObject);

                ContainerSelection_after() // get Container Selection Table List
            },
            complete:function(data){
                $(".loader123").hide();
            }
        })
    }

    function ContainerSelection_after(){
        var DocEntry=document.getElementById('after_TransferToUndertest_DocEntry').value;
        var BNo=document.getElementById('after_TransferToUndertest_i_BatchNo').value;
        var ItemCode=document.getElementById('after_TransferToUndertest_i_ItemCode').value;
        var FromWhs=document.getElementById('after_TransferToUndertest_i_ToWhs').value;

        var dataString ='DocEntry='+DocEntry+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=sample_intimation_Finished_Good_ContainerList_after_ajax';
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
                $('#ContainerSelectionItemAppend_after').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        })
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

    function EnterQtyValidation_GI(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

        if(SelectedQty!=''){
            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){
                $('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
            }else{
                $('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
                $('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); 
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }
        }else{
            $('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val
            $('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); 
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error");
        }

        getSelectedContenerGI_Manual(un_id); // if user change selected Qty value after selection       
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

        // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
            const array = selected;
            let sum = 0;

            for (let i = 0; i < array.length; i++) {
                sum += parseFloat(array[i]);
            }
            document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
    }

    function View_RPT_Open_PUT(API_Name,RPT_Title){
        var DocEntry=$('#U_UTTrans').val();
        var PrintOutURL=`http://192.168.1.30:8082/API/SAP/${API_Name}?DocEntry=${DocEntry}`;

        document.getElementById('RPT_title').innerHTML= RPT_Title; // Append Title dynamiclly
        document.getElementById("RPT_Link").src = PrintOutURL;
    }

    function View_RPT_Open(API_Name,RPT_Title){
        var DocEntry=$('#SI_FG_DocEntry').val();
        var PrintOutURL=`http://192.168.1.30:8082/API/SAP/${API_Name}?DocEntry=${DocEntry}`;

        document.getElementById('RPT_title').innerHTML= RPT_Title; // Append Title dynamiclly
        document.getElementById("RPT_Link").src = PrintOutURL;
    }

    function View_RPT_Close(){
        document.getElementById('RPT_title').innerHTML= '';
        document.getElementById("RPT_Link").src = '';
    }

    function SubmitInventoryTransfer(){
        var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
        var item_BQty=parseFloat(document.getElementById('TransferToUndertest_i_BQty').value).toFixed(6);  // item available Qty
        var PostingDate=document.getElementById('TransferToUndertest_PostingDate').value;
        var DocDate=document.getElementById('TransferToUndertest_DocumentDate').value;
        var FromWhs=document.getElementById('TransferToUndertest_i_FromWhs').value;

        if(selectedQtySum==item_BQty){ // Container selection Qty validation
            if(FromWhs!=''){ // Item level From Warehouse validation
                if(PostingDate!=''){ // Posting Date validation
                    if(DocDate!=''){ // Document Date validation
                        // <!-- ---------------- form submit process start here ----------------- -->
                            var formData = new FormData($('#inventory_transfer_finished_good_form')[0]); // form Id
                            formData.append("SubITFG_Btn",'SubITFG_Btn'); // submit btn Id

                            var error = true;
                            if(error){
                                $.ajax({
                                    url: 'ajax/kri_production_common_ajax.php',
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
                                })
                            }
                        // <!-- ---------------- form submit process end here ------------------- -->
                    }else{
                        swal("Oops!", "Please Select A Document Date.", "error");
                    }
                }else{
                    swal("Oops!", "Please Select A Posting Date.", "error");
                }
            }else{
                swal("Oops!", "From Warehouse Mandatory.", "error");
            }
        }else{
            swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
        }
    }
</script>