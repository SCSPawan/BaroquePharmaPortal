<?php
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj = new web();
$objKri = new webKri();

if (empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'list') {

    $tdata = array();
    $tdata['FromDate'] = date('Ymd', strtotime($_POST['fromDate']));
    $tdata['ToDate'] = date('Ymd', strtotime($_POST['toDate']));
    $tdata['DocEntry'] = trim(addslashes(strip_tags($_POST['DocEntry'])));
    $getAllData = $obj->getSimpleIntimation($FGSAMPCOLLADD, $tdata);
    //  echo $INPROCESSSAMPLEINTIMATIONADD;
    //  echo "<pre>";
    //  print_r($getAllData);
    //  echo "</pre>";
    // exit;
    $count = count($getAllData);

    $adjacents = 1;

    $records_per_page = 20;
    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    // =========================================================================================
    if ($page == '1') {
        $r_start = '0';   // 0
        $r_end = $records_per_page;    // 20
    } else {
        $r_start = ($page * $records_per_page) - ($records_per_page);   // 20
        $r_end = ($records_per_page * $page);   // 40
    }
    // =========================================================================================

    $page = ($page == 0 ? 1 : $page);
    $start = ($page - 1) * $records_per_page;
    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.

    $next = $page + 1;
    $prev = $page - 1;
    $last_page = ceil($count / $records_per_page);
    $second_last = $last_page - 1;
    $pagination = "";

    if ($last_page > 1) {
        $pagination .= "<div class='pagination' style='float: right;'>";

        if ($page > 1)
            $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($prev) . ");'>&laquo; Previous&nbsp;&nbsp;</a>";
        else
            $pagination .= "<spn class='disabled'>&laquo; Previous&nbsp;&nbsp;</spn>";

        if ($last_page < 7 + ($adjacents * 2)) {
            for ($counter = 1; $counter <= $last_page; $counter++) {
                if ($counter == $page)
                    $pagination .= "<spn class='current'>$counter</spn>";
                else
                    $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
            }
        } elseif ($last_page > 5 + ($adjacents * 2)) {
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination .= "<spn class='current'>$counter</spn>";
                    else
                        $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
                }
                $pagination .= "...";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($second_last) . ");'> $second_last</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($last_page) . ");'>$last_page</a>";
            } elseif ($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
                $pagination .= "...";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<spn class='current'>$counter</spn>";
                    else
                        $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
                }

                $pagination .= "..";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($second_last) . ");'>$second_last</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($last_page) . ");'>$last_page</a>";
            } else {
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
                $pagination .= "..";

                for ($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<spn class='current'>$counter</spn>";
                    else
                        $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
                }
            }
        }

        if ($page < $counter - 1)
            $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($next) . ");'>Next &raquo;</a>";
        else

            $pagination .= "<spn class='disabled'>Next &raquo;</spn>";
        $pagination .= "</div>";
    }

    $option .= '<table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
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

    if (count($getAllData) != '0') {
        for ($i = $r_start; $i < $r_end; $i++) {
            if (!empty($getAllData[$i]->RFPNo)) {   //  this condition save to extra blank loop
                $SrNo = $i + 1;
                // --------------- Convert String code Start Here ---------------------------
                if (empty($getAllData[$i]->MfgDate)) {
                    $MfgDate = '';
                } else {
                    $MfgDate = str_replace('/', '-', $getAllData[$i]->MfgDate);
                    // All (/) replace to (-)
                    $MfgDate = date("d-m-Y", strtotime($MfgDate));
                }

                if (empty($getAllData[$i]->ExpiryDate)) {
                    $ExpiryDate = '';
                } else {
                    $ExpiryDate = str_replace('/', '-', $getAllData[$i]->ExpiryDate);
                    // All (/) replace to (-)
                    $ExpiryDate = date("d-m-Y", strtotime($ExpiryDate));
                }
                // --------------- Convert String code End Here-- ---------------------------

                $option .= '
                            <tr>
                                <td class="desabled">' . $SrNo . '</td>
                                <td style="text-align: center;">
                                    <input type="radio" id="list' . $getAllData[$i]->DocEntry . '" name="listRado" value="' . $getAllData[$i]->DocEntry . '" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord(' . $getAllData[$i]->DocEntry . ')">
                                </td>
                                <td class="desabled">' . $getAllData[$i]->DocEntry . '</td>
                                <td class="desabled">' . $getAllData[$i]->WoNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->RFPEntry . '</td>
                                <td class="desabled">' . $getAllData[$i]->MatType . '</td>
                                <td class="desabled">' . $getAllData[$i]->ItemCode . '</td>
                                <td class="desabled">' . $getAllData[$i]->ItemName . '</td>
                                <td class="desabled">' . $getAllData[$i]->Unit . '</td>
                                <td class="desabled">' . $getAllData[$i]->WOQty . '</td>
                                <td class="desabled">' . $getAllData[$i]->BatchNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->BatchQty . '</td>
                                <td class="desabled">' . $MfgDate . '</td>
                                <td class="desabled">' . $ExpiryDate . '</td>
                                <td class="desabled">' . $getAllData[$i]->Branch . '</td>
                            </tr>';
            }
        }
    } else {
        $option .= '<tr><td colspan="16" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
    }
    $option .= '</tbody> 
    </table>';

    $option .= $pagination;
    echo $option;
    exit(0);
}
?>


<?php include 'include/header.php' ?>
<?php include 'models/qc_process/sample_collection_finished_goods_model.php' ?>

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
                        <h4 class="mb-0">Sample Collection</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sample Collection - Finished Goods</li>
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
                            <h4 class="card-title mb-0">Sample Collection - Finished Goods</h4>
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
                                                    <input type="text" class="form-control" name="DocEntry" id="DocEntry" value="">
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

                            <!-- form start -->

                            <form role="form" class="form-horizontal" id="SampleCollectionFormFinishedGoods" method="post">

                                <!-- <input class="form-control desabled" type="text" id="LocCode" name="LocCode"> -->
                                <input type="hidden" id="BPLId" name="BPLId">
                                <input type="hidden" id="it__DocEntry" name="it__DocEntry">
                                <input type="hidden" id="si_Series" name="si_Series">
                                <input type="hidden" id="numner_Series" name="numner_Series">
                                <input type="hidden" id="LineNo" name="LineNo">
                                <input type="hidden" id="SCRTQCB_SupplierCode" name="SCRTQCB_SupplierCode">
                                <input type="hidden" id="LocCode" name="LocCode">
                                <!-- <input type="hidden" id="BatchQty" name="BatchQty"> -->



                                <div class="row">

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ingediant Type</label>
                                            <div class="col-lg-8">
                                                <select class="form-select" id="fg_IngediantType" name="fg_IngediantType">
                                                    <option>None</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" readonly type="number" id="fg_RFPNo" name="fg_RFPNo">
                                            </div>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" readonly type="number" id="fg_RFPEntry" name="fg_RFPEntry">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" readonly type="number" id="fg_WoNo" name="fg_WoNo">
                                            </div>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" readonly type="number" id="fg_WoEntry" name="fg_WoEntry">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" readonly type="number" id="fg_DocNo" name="fg_DocNo">
                                                <!--  <select class="form-select desabled" id="fg_DocNo" name="fg_DocNo">
                                                        <option></option>
                                                    </select> -->
                                            </div>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" readonly type="text" id="fg_DocName" name="fg_DocName">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_Loction" name="fg_Loction">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="BatchQty" name="BatchQty">

                                            </div>
                                        </div>
                                    </div>





                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated By</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_IntimatedBy" name="fg_IntimatedBy">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Intimated Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="date" id="fg_IntimationDate" name="fg_IntimationDate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty </label>
                                            <div class="col-lg-6">
                                                <input class="form-control desabled" readonly type="number" id="fg_SampleQty" name="fg_SampleQty">
                                            </div>
                                            <div class="col-lg-2">
                                                <input class="form-control desabled" readonly type="text" id="fg_SampleQtyUnit" name="fg_SampleQtyUnit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Collect By</label>
                                            <div class="col-lg-7">
                                                <input class="form-control desabled" readonly type="text" id="fg_SampleCollectBy" name="fg_SampleCollectBy">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_ARNo" name="fg_ARNo">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Recieved Sepretly</label>
                                                <div class="col-lg-6">
                                                    <select class="form-select desabled" id="fg_SampleRecievedSepretly" name="fg_Dofg_SampleRecievedSepretlycDate">
                                                        <option>Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">DocDate</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="date" id="fg_DocDate" name="fg_DocDate">
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">TR No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_TRNo" name="fg_TRNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_Branch" name="fg_Branch">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_ItemCode" name="fg_ItemCode">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_ItemName" name="fg_ItemName">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_BatchNo" name="fg_BatchNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">No.Of Container</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_NoofCont" name="fg_NoofCont">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make by</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_Makeby" name="fg_Makeby">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Uom</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="fg_Uom" name="fg_Uom">
                                            </div>
                                        </div>
                                    </div>
                                    <!--  <div class="d-flex flex-wrap gap-2">
                                          
                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Container Selection</button>
                                        </div> -->

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
                                                                            <input type="text" name="UnderTestTransferNo" id="UnderTestTransferNo" class="form-control desabled" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <div class="col-md-5">
                                                                            <button type="button" id="process_in_SCD_SampleIssue_Btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".goods_issue_sample_issue" onclick="OpenInventoryTransferModel_sampleIssue()">Sample Issue</button>

                                                                            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".goods_issue_sample_issue">Sample Issue</button> -->
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

                                                                <div class="col-xl-3 col-md-6" style="display: none;">
                                                                    <div class="form-group row mb-2">
                                                                        <div class="col-md-7">

                                                                            <button type="button" id="SC_SCD_RevSampleIssue_Btn" class="btn btn-primary" data-bs-toggle="button" autocomplete="off" onclick="OnclickReverseSampleIssue()">Reverse Sample Issue</button>
                                                                            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Reverse Sample Issue</button> -->
                                                                        </div>
                                                                        <div class="col-lg-5 container_input">
                                                                            <input type="text" name="ReverseSampleIssue" id="ReverseSampleIssue" class="form-control desabled">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <!-- <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                                    <div class="col-lg-3">
                                                                       <input type="text" name="RetainQty" id="RetainQty" class="form-control desabled" readonly>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="RetainQtyUom" id="RetainQtyUom" class="form-control desabled" readonly>
                                                                    </div>
                                                                </div>
                                                            </div> -->

                                                                <div class="col-xl-3 col-md-6" style="display: none;">
                                                                    <div class="form-group row mb-2">
                                                                        <div class="col-md-4">
                                                                            <!--  <button type="button" class="pad_btn btn btn-primary"data-bs-toggle="modal" data-bs-target=".inventory_transfer_retails_issue" style="padding: 7px 5px 7px 5px;">Retain Issue</button> -->

                                                                            <button type="button" id="SCD_Retain_Issue_Btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer_retails_issue" onclick="OpenInventoryTransferModel_RetailsIssue()">Retain Issue</button>
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
                                                                            <input type="text" name="ContainerNo1" id="ContainerNo1" class="form-control ">
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
                                                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
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
                                                                        <!-- <th>Sr. No</th>
                                                                        <th>Supplier Code</th>
                                                                        <th>Supplier Name</th>
                                                                        <th>UOM </th>  
                                                                        <th>Sample Date</th>
                                                                        <th>Warehouse</th>
                                                                        <th>Sample Quantity</th>
                                                                        <th>Inventory Transfer</th>  -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="External-issue-list-append"></tbody>

                                                            </table>
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <!-- Toggle States Button -->
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" onclick="OpenInventoryExternalTransferModel();">Transfer</button>

                                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Sleep</button>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane" id="profile" role="tabpanel">
                                                        <div class="table-responsive" id="list">
                                                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
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
                                                            <button type="button" class="btn btn-primary" id="SC_ExtraIssue_FG_Btn" data-bs-toggle="modal" data-bs-target=".goods_issue" disabled onclick="OpenInventoryTransferModel_extraIssue()">Post Extra Issue</button>

                                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Issue Slip</button>

                                                        </div>
                                                    </div>

                                                </div><!--tab content end-->
                                            </div><!-- end card-body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                </div><!--row closed-->


                                <!-- form end -->

                                <br>
                                <div class="d-flex flex-wrap gap-2">
                                    <!-- <button type="button" class="btn btn-primary" onclick="">Add</button> -->


                                    <button type="button" class="btn btn-primary" id="SampleCollectionFinishedGoodUpdateForm_Btn" name="SampleCollectionFinishedGoodUpdateForm_Btn" onclick="SampleCollectionUpdateForm()">Update</button>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Cancel</button>
                                </div>
                            </form>

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
        $(document).ready(function() {
            var fromDate = document.getElementById('FromDate').value;
            var toDate = document.getElementById('ToDate').value;
            var DocEntry = document.getElementById('DocEntry').value;

            var dataString = 'fromDate=' + fromDate + '&toDate=' + toDate + '&DocEntry=' + DocEntry + '&action=list';
            // console.log(dataString);
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: dataString,
                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    $('#list-append').html(result);
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        });



        function SampleCollectionUpdateForm() {
            SampleCollectionUpdateForm
            var formData = new FormData($('#SampleCollectionFormFinishedGoods')[0]); // form Id
            formData.append("SampleCollectionFinishedGoodUpdateForm_Btn", 'SampleCollectionFinishedGoodUpdateForm_Btn'); // submit btn Id
            var error = true;

            $.ajax({
                url: 'ajax/kri_production_common_ajax.php',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);

                    var status = JSONObject['status'];
                    var message = JSONObject['message'];
                    var DocEntry = JSONObject['DocEntry'];
                    if (status == 'True') {
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
                                } else {
                                    location.replace(window.location.href); // cancel btn... cuurent URL called
                                }
                            });
                    } else {
                        swal("Oops!", `${message}`, "error");
                    }
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }


        function SearchData() {
            var fromDate = document.getElementById('FromDate').value;
            var toDate = document.getElementById('ToDate').value;
            var DocEntry = document.getElementById('DocEntry').value;

            var dataString = 'fromDate=' + fromDate + '&toDate=' + toDate + '&DocEntry=' + DocEntry + '&action=list';

            $.ajax({
                type: "POST",
                url: window.location.href,
                data: dataString,
                beforeSend: function() {
                    $("#footerProcess").hide();
                    $(".loader123").show();
                },
                success: function(result) {
                    console.log(result);
                    $('#list-append').html(result);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }




        function selectedRecord(DocEntry) {

            var totalRowCount = 0;
            var rowCount = 0;
            // var table = document.getElementById("tblSCRTQC_ExternalIssue");
            var table = document.getElementById("External-issue-list-append");
            var rows = table.getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                totalRowCount++;
                // console.log(rows[i].getElementsByTagName("td").length);
                if (rows[i].getElementsByTagName("td").length > 0) {
                    rowCount++;

                }
            }

            totalRowCount = rows.length;
            // console.log('Extra Issue');
            // console.log('totalRowCount=>', totalRowCount);
            // console.log('rowCount=>', rowCount);
            // ==============================Table tr count inside tbody End here ====================
            // ==============================Table tr count inside tbody start here ===================
            var totalRowCount_N = 0;
            var rowCount_N = 0;
            // var table_N = document.getElementById("tblSCRTQC_ExtraIssue");
            var table_N = document.getElementById("Extra-issue-list-append");

            var rows_N = table_N.getElementsByTagName("tr")
            for (var i = 0; i < rows_N.length; i++) {
                totalRowCount_N++;
                if (rows_N[i].getElementsByTagName("td").length > 0) {
                    rowCount_N++;
                }
            }

            totalRowCount_N = rows_N.length;

            // console.log('totalRowCount_N=>', totalRowCount_N);

            var dataString = 'DocEntry=' + DocEntry +'&rowCount='+rowCount+'&rowCount_N='+rowCount_N+ '&action=Sample_Collection_Finished_Goods_In_Process';
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    $("#footerProcess").show();
                    var JSONObjectAll = JSON.parse(result);
                    // console.log(JSONObjectAll['SampleCollDetails']);
                    // var JSONObject=JSONObjectAll['SampleCollDetails']; // sample collection details var
                    // console.log('dd=>',JSONObject);
                    // $(`#qc-post-general-data-list-append`).html(JSONObjectAll['general_data']); // Extra Issue Table Tr tag append here
                    // $(`#qc-external-list-append`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                    // $(`#qc-extra-list-append`).html(JSONObjectAll['qcAttach']);

                    var JSONObject = JSONObjectAll['SampleCollDetails'];
                    $(`#Extra-issue-list-append`).html(JSONObjectAll['ExtraIssue']); // Extra Issue Table Tr tag append here
                    $(`#External-issue-list-append`).html(JSONObjectAll['ExternalIssue']); // External Issue Table Tr tag append here

                    $(`#fg_RFPNo`).val(JSONObject[0].RFPNo);
                    $(`#fg_RFPEntry`).val(JSONObject[0].RFPEntry);
                    $(`#fg_WoNo`).val(JSONObject[0].WoNo);
                    $(`#fg_WoEntry`).val(JSONObject[0].WoEntry);
                    $(`#fg_DocNo`).val(JSONObject[0].Series);
                    $(`#fg_DocName`).val(JSONObject[0].SeriesName);
                    $(`#fg_Loction`).val(JSONObject[0].Loction);
                    $(`#fg_IntimatedBy`).val(JSONObject[0].IntimatedBy);
                    $(`#fg_IntimationDate`).val(DateFormatingYMD(JSONObject[0].IntimationDate));
                    $(`#fg_SampleQty`).val(JSONObject[0].SampleQty);
                    $(`#fg_SampleQtyUnit`).val(JSONObject[0].SampleQtyUnit);
                    $(`#fg_SampleCollectBy`).val(JSONObject[0].SampleCollectBy);
                    $(`#fg_ARNo`).val(JSONObject[0].ARNo);

                    $(`#fg_DocDate`).val(DateFormatingYMD(JSONObject[0].DocDate));
                    $(`#fg_TRNo`).val(JSONObject[0].TRNo);
                    $(`#fg_Branch`).val(JSONObject[0].Branch);
                    $(`#fg_ItemCode`).val(JSONObject[0].ItemCode);
                    $(`#fg_ItemName`).val(JSONObject[0].ItemName);
                    $(`#fg_BatchNo`).val(JSONObject[0].BatchNo);
                    $(`#fg_NoofCont`).val(JSONObject[0].NoofCont);

                    $(`#UnderTestTransferNo`).val(JSONObject[0].UnderTransferNo);
                    $(`#SampleIssue`).val(JSONObject[0].SampleIssue);
                    $(`#DateofReversal`).val(JSONObject[0].DateofReversal);
                    $(`#ReverseSampleIssue`).val(JSONObject[0].RevSamIssue);
                    fg_DocDate
                    $(`#RetainQty`).val(JSONObject[0].RetainQty);
                    $(`#RetainQtyUom`).val(JSONObject[0].RetainQtyUom);
                    $(`#RetainIssue`).val(JSONObject[0].RetainIssue);
                    $(`#ContainerNo1`).val(JSONObject[0].Cont1);
                    $(`#ContainerNo2`).val(JSONObject[0].Cont2);
                    $(`#ContainerNo3`).val(JSONObject[0].Cont3);
                    $(`#QtyForLabel`).val(JSONObject[0].QtyforLabel);

                    $(`#it__DocEntry`).val(JSONObject[0].DocEntry);
                    $(`#BPLId`).val(JSONObject[0].BPLId);
                    $(`#si_Series`).val(JSONObject[0].Series);
                    $(`#SCRTQCB_SupplierCode`).val('');
                    $(`#LineNo`).val(JSONObject[0].LineNo);
                    $(`#LocCode`).val(JSONObject[0].LocCode);
                    $(`#BatchQty`).val(JSONObject[0].BatchQty);
                    $(`#fg_Makeby`).val(JSONObject[0].MakeBy);
                    $(`#fg_Uom`).val(JSONObject[0].UOM);


                    getSupplierDropdown(totalRowCount);
                    getWareHouseDropdown(totalRowCount);
                    getWareHouseExtraIssueDropdown(totalRowCount_N);
                    IngrediantTypeDropdown();
                    getSeriesDropdown_gd();
                    getSeriesDropdown_gd_extra();
                    getSeriesDropdown(); // DocName By using API to get dropdown 
                    // TR_ByDropdown(); //TR By API to Get Dropdown
                    // --------------- bottom popup button hide & show script end here-----------------------
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }


        function DateFormatingYMD(DateOG) {
            if (DateOG != '') {
                let [day, month, year] = DateOG.split(" ")[0].split("-");
                let Date = `${year}-${month}-${day}`;
                return Date;
            }
        }

        function getSeriesDropdown() {

            var TrDate = $(`#sample_issue_PostingDate`).val();

            var dataString = 'TrDate=' + TrDate + '&ObjectCode=60&action=getSeriesDropdown_ajax';
            // console.log('dataString',dataString);
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    var SeriesDropdown = JSON.parse(result);
                    //console.log('SeriesDropdown',SeriesDropdown);
                    $('#sample_issue_DocNo').html(SeriesDropdown);
                    // $('#sample_issue_DocNum').html(SeriesDropdown);

                    selectedSeries(); // call Selected Series Single data function
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }


        function selectedSeries() {
            var TrDate = $('#sample_issue_PostingDate').val();
            var Series = document.getElementById('sample_issue_DocNo').value;
            var dataString = 'TrDate=' + TrDate + '&Series=' + Series + '&ObjectCode=60&action=getSeriesSingleData_ajax';
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);

                    //console.log('JSONObject=>', JSONObject);
                    var NextNumber = JSONObject[0]['NextNumber'];
                    var Series = JSONObject[0]['Series'];
                    // $('#sample_issue_DocNum').val(Series);
                    // $('#sample_issue_DocNum').val(Series);
                    // alert(Series)

                    $('#sample_issue_DocNum').val(NextNumber);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

        //   function getSupplierDropdown(totalRowCount){
        // var dataString ='action=SupplierDropdown_ajax';

        // $.ajax({  
        //         type: "POST",  
        //         url: 'ajax/kri_production_common_ajax.php',   
        //         data: dataString,  
        //         beforeSend: function(){
        //         // Show image container
        //                   $(".loader123").show();
        //                 },
        //                 success: function(result)
        //                 {  
        //                 // console.log('supplier drop=>', result);
        //                    var JSONObject = JSON.parse(result);
        //                 // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
        //                 let un_id=totalRowCount; 
        //                 // console.log(un_id);
        //                    $('#SC_ExternalI_SupplierCode'+un_id).html(JSONObject);
        //                 // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
        //                 },
        //                 complete:function(data){
        //                 // Hide image container
        //                    $(".loader123").hide();
        //                 }
        //         });
        // }




        function getSupplierDropdown(totalRowCount) {
            // ==============================Table tr count inside tbody start here ===================
            var totalRowCount = 0;
            var rowCount = 0;
            var table = document.getElementById("External-issue-list-append");
            var rows = table.getElementsByTagName("tr")
            for (var i = 0; i < rows.length; i++) {
                totalRowCount++;
                if (rows[i].getElementsByTagName("td").length > 0) {
                    rowCount++;
                }
            }

            // ==============================Table tr count inside tbody End here ====================

            var dataString = 'action=SupplierDropdown_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    // console.log('supplier drop=>', result);
                    var JSONObject = JSON.parse(result);
                    // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id = rowCount;
                    $('#SC_ExternalI_SupplierCode' + un_id).html(JSONObject);
                    // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }



        function getWareHouseDropdown(totalRowCount) {
            var dataString = 'action=WareHouseDropdown_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);
                    // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id = totalRowCount;
                    $('#SC_ExternalI_Warehouse' + un_id).html(JSONObject);
                    // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }


        function getWareHouseExtraIssueDropdown(totalRowCount_N) {
            var dataString = 'action=WareHouseDropdown_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);
                    // <!-- ------- this loop mapped supplier list dropdown start here-------------- -->
                    let un_id = totalRowCount_N;
                    $('#SC_FEI_Warehouse' + un_id).html(JSONObject);
                    // <!-- ------- this loop mapped supplier list dropdown end here---------------- -->
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }



        function IngrediantTypeDropdown() {
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: {
                    'action': "IngrediantTypeDropdown_SampleCollection_ajax"
                },

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    $('#fg_IngediantType').html(result);
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }


        function OpenInventoryTransferModel_sampleIssue() {
            // alert('h');
            // var SupplierCode=document.getElementById('si_SupplierCode').value;
            // var SupplierName=document.getElementById('si_SupplierName').value;
            var Branch = document.getElementById('fg_Branch').value;
            var Series = document.getElementById('si_Series').value;
            var DocEntry = document.getElementById('it__DocEntry').value;
            var BPLId = document.getElementById('BPLId').value;
            // var afters=
            // alert(DocEntry);

            var dataString = 'DocEntry=' + DocEntry + '&action=OpenInventoryTransferSamplessue_finied_good_In_ajax';
            // alert(dataString);
            // +'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);
                    // console.log(JSONObject);
                    // console.log(result);
                    // $('#iT_goods_issue_supplier_code').val(SupplierCode);
                    // $('#iT_goods_issue_supplier_name').val(SupplierName);
                    $('#sample_issue_BaseDocType').val('SCS_SCINPROC');
                    $('#sample_issue_BaseDocNum').val(DocEntry);
                    $('#sample_issue_branch').val(Branch);
                    $('#sample_issue_Series').val(Series);
                    $('#sample_issue_BPLId').val(BPLId);
                    $('#sample_issue_DocEntry').val(DocEntry);
                    // $('#iT_goods_issue_PostingDate').val();
                    // $('#iT_goods_issue_DocumentDate').val();

                    $('#InventoryTransferItemAppend').html(JSONObject);
                    // alert(after);
                   // getSeriesDropdown_gd()
                    // DocName By using API to get dropdown 
                    ContainerSelection_sample_issue(); // get Container Selection Table List
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }



        function OpenInventoryTransferModel_RetailsIssue() {
            // var SupplierCode=document.getElementById('si_SupplierCode').value;
            // var SupplierName=document.getElementById('si_SupplierName').value;
            var Branch = document.getElementById('fg_Branch').value;
            var Series = document.getElementById('si_Series').value;
            var DocEntry = document.getElementById('it__DocEntry').value;
            var BPLId = document.getElementById('BPLId').value;
            // var afters=

            var dataString = 'DocEntry=' + DocEntry + '&action=OpenInventoryTransferRetails_issue_finied_good_In_ajax';
            // alert(dataString);
            // +'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);
                    // console.log(JSONObject);
                    // console.log(result);
                    // $('#iT_InventoryTransfer_supplier_code').val(SupplierCode);
                    // $('#iT_InventoryTransfer_supplier_name').val(SupplierName);
                    $('#iT_InventoryTransfer_BaseDocType').val('SCS_SCINPROC');
                    $('#iT_InventoryTransfer_BaseDocNum').val(DocEntry);
                    $('#iT_InventoryTransfer_branch').val(Branch);
                    $('#iT_InventoryTransfer_series').val(Series);
                    $('#it_InventoryTransfer_BPLId').val(BPLId);
                    $('#it_InventoryTransfer_DocEntry').val(DocEntry);
                    $('#iT_InventoryTransfer_PostingDate').val();
                    $('#iT_InventoryTransfer_DocumentDate').val();

                    $('#InventoryTransferItemAppend_retails').html(JSONObject);

                    // alert(after);
                    // getSeriesDropdown_retails();
                    // getSeriesDropdown() // DocName By using API to get dropdown 
                    ContainerSelection_retails(); // get Container Selection Table List
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }



        function ContainerSelection_retails() {

            var DocEntry = document.getElementById('it__DocEntry').value;
            var BatchNo = document.getElementById('it__BatchNo').value;
            var ItemCode = document.getElementById('itP_retails_ItemCode').value;
            var itP_FromWhs = document.getElementById('itP_retails_FromWhs').value;
            // ItemCode=SFG00001&WareHouse=RETN-WHS&BatchNo=C0121157

            var dataString = 'ItemCode=' + ItemCode + '&WareHouse=' + itP_FromWhs + '&DocEntry=' + DocEntry + '&BatchNo=' + BatchNo + '&action=OpenInventoryTransfer_Retails_issue_Finished_Goods_ajax';
            // alert('g');
            // console.log(dataString);

            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);

                    console.log(JSONObject);

                    $('#ContainerSelectionItemAppend_retails').html(JSONObject);
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });

        }


        function ContainerSelection_sample_issue() {



            var DocEntry = document.getElementById('it__DocEntry').value;
            var BatchNo = document.getElementById('it_BatchNo').value;
            var ItemCode = document.getElementById('itP_ItemCode').value;
            var itP_FromWhs = document.getElementById('itP_FromWhs').value;

            var dataString = 'ItemCode=' + ItemCode + '&WareHouse=' + itP_FromWhs + '&DocEntry=' + DocEntry + '&BatchNo=' + BatchNo + '&action=OpenInventoryTransfer_Simple_issue_finied_good_ajax';
            // console.log(dataString);
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    // console.log('hhhh=>',result);
                    var JSONObject = JSON.parse(result);
                    $('#ContainerSelectionItemAppend').html(JSONObject);
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });

        }



        function getSelectedContener(un_id) {
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
            var usercheckListVal = document.getElementById('usercheckList' + un_id).value;

            if (usercheckListVal == '0') {
                $(`#usercheckList` + un_id).val('1');
            } else {
                $(`#usercheckList` + un_id).val('0');
            }
            // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
        }


        function EnterQtyValidation(un_id) {
            var BatchQty = document.getElementById('itp_BatchQty' + un_id).value;
            var SelectedQty = document.getElementById('SelectedQty' + un_id).value;

            if (SelectedQty != '') {

                if (parseFloat(SelectedQty) <= parseFloat(BatchQty)) {

                    $('#SelectedQty' + un_id).val(parseFloat(SelectedQty).toFixed(6));
                    $('#itp_CS' + un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value

                    // getSelectedContener(un_id); // if user change selected Qty value after selection 
                } else {
                    $('#SelectedQty' + un_id).val(BatchQty); // if user enter grater than val
                    swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
                }

            } else {
                $('#SelectedQty' + un_id).val(BatchQty); // if user enter blank val
                swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
            }

            getSelectedContenerGI_Manual(un_id);
        }



        function getSelectedContenerGI_Manual(un_id) {
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



        function SubmitInventoryTransfer_sample_issue() {

            var selectedQtySum = document.getElementById('cs_selectedQtySum').value; // final Qty sum
            var PostingDate = document.getElementById('sample_issue_PostingDate').value;
            var DocDate = document.getElementById('sample_issue_DocumentDate').value;
            var ItemCode = document.getElementById('itP_ItemCode').value;
            var ItemName = document.getElementById('itP_ItemName').value;
            var item_BQty = parseFloat(document.getElementById('itP_BQty').value).toFixed(6); // item available Qty
            var fromWhs = document.getElementById('itP_FromWhs').value;
            var ToWhs = document.getElementById('itP_ToWhs').value;
            var Location = document.getElementById('itP_Loction').value;


            if (selectedQtySum == item_BQty) { // Container selection Qty validation

                if (ToWhs != '') { // Item level To Warehouse validation

                    if (PostingDate != '') { // Posting Date validation

                        if (DocDate != '') { // Document Date validation

                            // <!-- ---------------- form submit process start here ----------------- -->
                            var formData = new FormData($('#inventory_transfer_form_issue_sample_gI')[0]);
                            formData.append("SubIT_Btn_finied_goods_sample_issue", 'SubIT_Btn_sampleIssue');

                            var error = true;

                            if (error) {
                                $.ajax({
                                    url: 'ajax/kri_production_common_ajax.php',
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    beforeSend: function() {
                                        // Show image container
                                        $(".loader123").show();
                                    },
                                    success: function(result) {
                                        //console.log(result);
                                        var JSONObject = JSON.parse(result);
                                        // console.log(JSONObject);

                                        var status = JSONObject['status'];
                                        var message = JSONObject['message'];
                                        var DocEntry = JSONObject['DocEntry'];
                                        if (status == 'True') {
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
                                                    } else {
                                                        location.replace(window.location.href); // cancel btn... cuurent URL called
                                                    }
                                                });
                                        } else {
                                            swal("Oops!", `${message}`, "error");
                                        }
                                    },
                                    complete: function(data) {
                                        // Hide image container
                                        $(".loader123").hide();
                                    }
                                });

                            }
                            // <!-- ---------------- form submit process end here ------------------- -->
                        } else {
                            swal("Oops!", "Please Select A Document Date.", "error");
                        }

                    } else {
                        swal("Oops!", "Please Select A Posting Date.", "error");
                    }
                } else {
                    swal("Oops!", "To Warehouse Mandatory.", "error");
                }

            } else {
                swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
            }
        }





        function SubmitInventoryTransfer_retails_issue() {

            var selectedQtySum = document.getElementById('cs_selectedQtySum_retails').value; // final Qty sum
            var PostingDate = document.getElementById('iT_InventoryTransfer_PostingDate').value;
            var DocDate = document.getElementById('iT_InventoryTransfer_DocumentDate').value;
            var ItemCode = document.getElementById('itP_retails_ItemCode').value;
            var ItemName = document.getElementById('itP_retails_ItemName').value;
            var item_BQty = parseFloat(document.getElementById('itP_retails_BQty').value).toFixed(6); // item available Qty
            var fromWhs = document.getElementById('itP_retails_FromWhs').value;
            var ToWhs = document.getElementById('itP_retails_ToWhs').value;
            var Location = document.getElementById('itP_retails_Loction').value;


            if (selectedQtySum == item_BQty) { // Container selection Qty validation

                if (ToWhs != '') { // Item level To Warehouse validation

                    if (PostingDate != '') { // Posting Date validation

                        if (DocDate != '') { // Document Date validation

                            // <!-- ---------------- form submit process start here ----------------- -->
                            var formData = new FormData($('#inventory_transfer_form_issue_retails_inventory')[0]);
                            formData.append("SubIT_Btn_finied_goods_retails_issue", 'SubIT_Btn_sampleIssue');

                            var error = true;

                            if (error) {
                                $.ajax({
                                    url: 'ajax/kri_production_common_ajax.php',
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    beforeSend: function() {
                                        // Show image container
                                        $(".loader123").show();
                                    },
                                    success: function(result) {
                                        //console.log(result);
                                        var JSONObject = JSON.parse(result);
                                        // console.log(JSONObject);

                                        var status = JSONObject['status'];
                                        var message = JSONObject['message'];
                                        var DocEntry = JSONObject['DocEntry'];
                                        if (status == 'True') {
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
                                                    } else {
                                                        location.replace(window.location.href); // cancel btn... cuurent URL called
                                                    }
                                                });
                                        } else {
                                            swal("Oops!", `${message}`, "error");
                                        }
                                    },
                                    complete: function(data) {
                                        // Hide image container
                                        $(".loader123").hide();
                                    }
                                });

                            }
                            // <!-- ---------------- form submit process end here ------------------- -->
                        } else {
                            swal("Oops!", "Please Select A Document Date.", "error");
                        }

                    } else {
                        swal("Oops!", "Please Select A Posting Date.", "error");
                    }
                } else {
                    swal("Oops!", "To Warehouse Mandatory.", "error");
                }

            } else {
                swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
            }
        }



        function getSelectedContener_retails(un_id) {
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
            var usercheckListVal = document.getElementById('usercheckList_retails' + un_id).value;
            // alert('h');
            if (usercheckListVal == '0') {
                $(`#usercheckList_retails` + un_id).val('1');
            } else {
                $(`#usercheckList_retails` + un_id).val('0');
            }
            // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
        }


        function EnterQtyValidation_retails(un_id) {
            var BatchQty = document.getElementById('itp_BatchQty_retails' + un_id).value;
            var SelectedQty = document.getElementById('SelectedQty_retails' + un_id).value;

            if (SelectedQty != '') {

                if (parseFloat(SelectedQty) <= parseFloat(BatchQty)) {

                    $('#SelectedQty_retails' + un_id).val(parseFloat(SelectedQty).toFixed(6));
                    $('#itp_CS_retails' + un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
                    // getSelectedContener(un_id); // if user change selected Qty value after selection 
                } else {
                    $('#SelectedQty_retails' + un_id).val(BatchQty); // if user enter grater than val
                    swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
                }

            } else {
                $('#SelectedQty_retails' + un_id).val(BatchQty); // if user enter blank val
                swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
            }

            getSelectedContener_num_retails(un_id);
        }


        function getSelectedContener_num_retails(un_id) {
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


        function OnclickReverseSampleIssue() {

            var DocEntry = document.getElementById('it__DocEntry').value;
            var dataString = 'DocEntry=' + DocEntry + '&action=SCReverseSampleIsuue_ajax';


            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                cache: false,

                // beforeSend: function(){
                //     $(".loader123").show();
                // },
                success: function(result) {
                    console.log(result);
                    var JSONObject = JSON.parse(result);

                    var status = JSONObject['status'];
                    var message = JSONObject['message'];
                    var DocEntry = JSONObject['DocEntry'];
                    if (status == 'True') {
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
                                } else {
                                    location.replace(window.location.href); // cancel btn... cuurent URL called
                                }
                            });
                    } else {
                        swal("Oops!", `${message}`, "error");
                    }
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }





        $(document).ready(function() {
            for (var i = 8 - 1; i >= 0; i--) { // 2 count hard core there is called row count on page load
                $("#Property_code" + i).select2();
            }

        });

        function PropertyCode(i) {
            var username = $('#Property_code' + `${i}` + 'option:selected').text();
            var userid = $('#Property_code' + i).val();

            $('#result').html("id : " + userid + ", name : " + username);
        }



        function ExternalIssueSelectedBP(un_id) {
            var CardCode = document.getElementById('SC_ExternalI_SupplierCode' + un_id).value;
            var Loc = $('#fg_Loction').val();
            var Branch = $('#fg_Branch').val();
            var ItemCode = $('#fg_ItemCode').val();
            var MakeBy = $('#fg_Makeby').val();

            var dataString = 'CardCode=' + CardCode + '&Loc=' + Loc + '&Branch=' + Branch + '&ItemCode=' + ItemCode + '&MakeBy=' + MakeBy + '&action=SupplierSingleData_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);


                    if (CardCode != '') {
                        $('#SC_FEXI_SupplierName' + un_id).val(JSONObject['CardName']);
                        $('#SC_ExternalI_Warehouse' + un_id).val(JSONObject['Whse']);
                        $('#SC_FEXI_SampleDate' + un_id).val(JSONObject['SampleDate']);
                        $('#SC_FEXI_UOM' + un_id).val($('#fg_Uom').val());
                    } else {
                        $('#SC_FEXI_SupplierName' + un_id).val('');
                        $('#SC_ExternalI_Warehouse' + un_id).val('');
                        $('#SC_FEXI_SampleDate' + un_id).val('');
                        $('#SC_FEXI_UOM' + un_id).val('');
                    }
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }





        function GetExtraIuuseWhs(un_id) {

            var SampleQuantity = $('#SC_FEI_SampleQuantity' + un_id).val();
            var Loc = $('#fg_Loction').val();
            var Branch = $('#fg_Branch').val();
            var ItemCode = $('#fg_ItemCode').val();
            var MakeBy = $('#fg_Makeby').val();
            var UOM = $('#fg_Uom').val();

            var dataString = 'UOM=' + UOM + '&Loc=' + Loc + '&Branch=' + Branch + '&ItemCode=' + ItemCode + '&MakeBy=' + MakeBy + '&action=GetExtraIuuseWhs_Ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                beforeSend: function() {
                    // $(".loader123").show();
                },
                success: function(result) {
                    // console.log(result);
                    var JSONObject = JSON.parse(result);
                    //console.log('GetExtraIuuseWhs=>',JSONObject);

                    if (SampleQuantity != '') {
                        $('#SC_FEI_UOM' + un_id).val(JSONObject['UOM']);
                        $('#SC_FEI_Warehouse' + un_id).val(JSONObject['Whse']);
                        $('#SC_FEI_SampleBy' + un_id).val(JSONObject['SampleBy']);
                        $('#SC_FEI_IssueDate' + un_id).val(JSONObject['IssueDate']);
                    } else {
                        $('#SC_FEI_UOM' + un_id).val('');
                        $('#SC_FEI_Warehouse' + un_id).val('');
                        $('#SC_FEI_SampleBy' + un_id).val('');
                        $('#SC_FEI_IssueDate' + un_id).val('');
                    }
                },
                complete: function(data) {
                    // $(".loader123").hide();
                }
            });
        }


        function selectedExtraIssue(un_id) {
            // $('#RowLevelSelectedExtraIssue').val(un_id);
            document.getElementById("SC_ExtraIssue_FG_Btn").disabled = false;
        }


    function OpenInventoryExternalTransferModel() {
    var Branch = document.getElementById('fg_Branch').value;
    var Series = document.getElementById('fg_DocName').value;
    var DocEntry = document.getElementById('it__DocEntry').value;
    var BPLId = document.getElementById('LineNo').value;

    var dataString = 'DocEntry=' + DocEntry + '&action=SCFG_IT_ExternalIssue_ajax';
    $.ajax({
        type: "POST",
        url: 'ajax/kri_production_common_ajax.php',
        data: dataString,
        cache: false,
        beforeSend: function() {
            $(".loader123").show();
        },
        success: function(result) {
            var JSONObject = JSON.parse(result);

            var Response = JSONObject.res[0]; // Assume the response array contains only one object for this example

       
            // $('#iT_InventoryTransfer_external_BaseDocType').val(Response.DocType);
            // $('#iT_InventoryTransfer_external_BaseDocNum').val(Response.DocEntry);
            $('#inveTra_branch').val(Branch);
            $('#it_InventoryTransfer_external_BPLId').val(BPLId);
            $('#it_InventoryTransfer_external_DocEntry').val(DocEntry);
            $('#inveTra_basedocnum').val(Response.DocNum);
            $('#inveTra_doctyp').val(Response.DocType);

            $('#InventoryTransferItemAppend_external').html(JSONObject.html);

            // getSeriesDropdown_retails();
            ContainerSelection_extenal(); // get Container Selection Table List
        },
        complete: function(data) {
            $(".loader123").hide();
        }
    });
}


 function ContainerSelection_extenal(){

// alert('hii');

    var selectedRadio = document.querySelector('input[name="listRado[]"]:checked');

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

var dataString ='ItemCode='+ItemCode+'&WareHouse='+itP_FromWhs+'&DocEntry='+DocEntry+'&BatchNo='+BatchNo+'&action=OpenInventoryTransfer_fg_external_process_in_ajax';

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
        // console.log(result);
        var JSONObject = JSON.parse(result);
        
        // $('#ContainerSelectionItemAppend_retails').html(JSONObject); 
        $('#ContainerSelectionItemAppend_external').html(JSONObject);
        $('#itP_BQty').val(SC_ExternalQty_Row);
        $('#it_Linenum').val(SC_ExternalLineId_Row); 
        $('#fg_ITRFPEntry').val($('#fg_RFPEntry').val());          
    },
    complete:function(data){
        $(".loader123").hide();
    }
}); 
}

        function getSeriesDropdown_gd() {
         
            var TrDate = $('#posting-date').val();
            var dataString = 'TrDate=' + TrDate + '&ObjectCode=67&action=getSeriesDropdown_ajax';
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var SeriesDropdown = JSON.parse(result);


                    console.log('SeriesDropdown',SeriesDropdown);

                    $('#iT_InventoryTransfer_series').html(SeriesDropdown);
                    ///$('#iT_InventoryTransfer_series').html(SeriesDropdown);

                },
                complete: function(data) {
                    selectedSeries_gd();
                }
            });
        }

      
 function selectedSeries_gd(){
       
    var TrDate=$('#posting-date').val();
   
   var Series=document.getElementById('iT_InventoryTransfer_series').value;
 
   var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=67&action=getSeriesSingleData_ajax';

   
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
           $('#inveTra_docNo').val(NextNumber);
       },
       complete:function(data){
               $(".loader123").hide();
       }
   }); 
}
 





function getSeriesDropdown_gd_extra()
{
    // alert('hii');
    var TrDate=$('#iT_extra_posting').val();
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

            //console.log('SeriesDropdown',SeriesDropdown);
            $('#iT_extra_series').html(SeriesDropdown);
        },
        complete:function(data){
            selectedSeries_gd_extra()
        }
    })
}


   function selectedSeries_gd_extra()
    {

      
        var TrDate=$('#iT_extra_posting').val();
        var Series=document.getElementById('iT_extra_series').value;
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

                // console.log('JSONObject111=>',JSONObject)

            var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];         
                $('#it_Docno').val(Series);                
                $('#iT_extra_docNo').val(NextNumber);
            },
            complete:function(data){
                    $(".loader123").hide();
            }
        }); 
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



    function SubmitInventoryTransfer_external()

    // alert("HIII");

    {
        var selectedQtySum=document.getElementById('cs_selectedQtySum_external').value; // final Qty sum
        var PostingDate=document.getElementById('posting-date').value;
        var DocDate=document.getElementById('docdate').value;
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
                            var formData = new FormData($('#inventory_transfer_form_fg_external')[0]); 
                            formData.append("SubIT_Btn_fg_transfer",'SubIT_Btn_fg_transfer'); 
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



    // Extera issue functionality code here...

    function OpenInventoryTransferModel_extraIssue()
{



    // var Branch=document.getElementById('Branch').value;
    // var Series=document.getElementById('si_Series').value;
    var DocEntry=document.getElementById('it__DocEntry').value;
    // var BPLId=document.getElementById('BPLId').value;
    
    var dataString ='DocEntry='+DocEntry+'&action=SCFG_IT_ExternalIssue_ajax';

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

            var Response = JSONObject.res[0];
            

            //  console.log('Response',Response);
            //  console.log('Response DocNum->',Response.DocNum);
            
            //  console.log('Response111',Response[0]['Branch']);
            $('#invtr_Extra_branch').val(Response.Branch);
            
            // $('#it_InventoryTransfer_external_BPLId').val(BPLId);
            // $('#it_InventoryTransfer_external_DocEntry').val(DocEntry);
            // $('#invtr_Extra_docnum').val(Response.DocNum);
             $('#invtr_Extra_doctyp').val(Response.DocType);
            $('#InventoryTransferItemAppend_extra').html(JSONObject.html);
           

            // getSeriesDropdown_gd_extra()
            // // getSeriesDropdown_gd() // DocName By using API to get dropdown 
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

        var DocEntry=$('#it__DocEntry').val();
        var BatchNo=$('#it_BatchNo').val();
        var ItemCode=$('#itP_ItemCode').val();
        var itP_FromWhs=$('#itP_FromWhs').val();

        var dataString ='ItemCode='+ItemCode+'&WareHouse='+itP_FromWhs+'&DocEntry='+DocEntry+'&BatchNo='+BatchNo+'&action=OpenInventoryTransfer_fg_ExtraIssueProcess_in_ajax';

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
                // console.log('ContainerSelection_extraIssue=>', JSONObject);
                $('#ContainerSelectionItemAppend_extra').html(JSONObject);
                $('#itP_BQty').val(SC_ExteraQty_Row);

                $('#fg_it_LineId').val(SC_ExteraLineId_Row);  
                $('#fg_it_DocEntry').val($('#it__DocEntry').val());
                $('#fg_it_RcDocEntry').val($('#fg_RFPEntry').val());
                $('#fg_it_BPLID').val($('#BPLId').val());
                //          
            },
            complete:function(data){
                $(".loader123").hide();
            }
        })
    }






    function getSelectedContener_extra(un_id){
        
        //Create an Array.

        var selected = new Array();
 
        //Reference the Table.

        var tblFruits = document.getElementById("ContainerSelectionItemAppend_extra");
        // console.log('tblFruits=>', tblFruits);

 
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
    



    function SubmitInventoryTransfer_extra(){

    var selectedQtySum=document.getElementById('cs_selectedQtySum_extra').value; // final Qty sum
    var PostingDate=document.getElementById('iT_extra_posting').value;
    var DocDate=document.getElementById('iT_extra_docdate').value;
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
                       var formData = new FormData($('#SubIT_Btn_post_extra_issue_fg')[0]); 
                       formData.append("SubIT_Btn_post_extra_issue_fg",'SubIT_Btn_post_extra_issue_fg'); 

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







</script>