<?php
require_once './classes/function.php';
$obj = new web();

if (empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'list') {
    $tdata = array();
    $tdata['FromDate'] = date('Ymd', strtotime($_POST['fromDate']));
    $tdata['ToDate'] = date('Ymd', strtotime($_POST['toDate']));
    $tdata['DocEntry'] = trim(addslashes(strip_tags($_POST['DocEntry'])));

    $getAllData = $obj->getSimpleIntimation($STABQCPOSTDOCUMENTDETAILS, $tdata);

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
                        <th>Doc Entry</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Whs Code</th>
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
                        <th>Stability Intimation No</th>
                        <th>Stability Collection No</th>
                        <th>Route Stage Reco WO No</th>
                        <th>Route Stage Reco WO Entry</th>
                        <th>Route Stage Reco Prod Receipt No</th>
                        <th>Route Stage Reco Prod Receipt Entry</th>
                        <th>Route Stage Reco Prod Receipt Qty</th>
                        <th>Stability Type</th>
                        <th>Stability Condition</th>
                        <th>Stability Time Period</th>
                        <th>Type of Analysis</th>
                    </tr>
                </thead>
                <tbody>';

    if (count($getAllData) != '0') {
        for ($i = $r_start; $i < $r_end; $i++) {
            if (!empty($getAllData[$i]->DocEntry)) {   //  this condition save to extra blank loop
                $SrNo = $i + 1;
                // --------------- Convert String code Start Here ---------------------------
                    if (empty($getAllData[$i]->MfgDate)) {
                        $MfgDate = '';
                    } else {
                        $U_MfgDate = str_replace('/', '-', $getAllData[$i]->MfgDate);
                        $MfgDate = date("d-m-Y", strtotime($U_MfgDate));
                    }

                    if (empty($getAllData[$i]->ExpiryDate)) {
                        $ExpiryDate = '';
                    } else {
                        $U_ExpDate = str_replace('/', '-', $getAllData[$i]->ExpiryDate);
                        $ExpiryDate = date("d-m-Y", strtotime($U_ExpDate));
                    }

                    if (empty($getAllData[$i]->StabilityLoadingDate)) {
                        $StabilityLoadingDate = '';
                    } else {
                        $StabilityLoadingDate = date("d-m-Y", strtotime($getAllData[$i]->StabilityLoadingDate));
                    }
                // --------------- Convert String code End Here-- ---------------------------

                $option .= '<tr>
                    <td class="desabled">' . $SrNo . '</td>

                    <td style="text-align: center;">
                        <input type="radio" id="list' . $getAllData[$i]->DocEntry . '" name="listRado" value="' . $getAllData[$i]->DocEntry . '" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord(' . $getAllData[$i]->DocEntry . ')">
                    </td>

                    <td class="desabled">' . $getAllData[$i]->DocEntry . '</td>
                    <td class="desabled">' . $getAllData[$i]->ItemCode . '</td>
                    <td class="desabled">' . $getAllData[$i]->ItemName . '</td>
                    <td class="desabled">' . $getAllData[$i]->WhsCode . '</td>
                    <td class="desabled">' . $getAllData[$i]->BatchQty . '</td>
                    <td class="desabled">' . $getAllData[$i]->BatchNo . '</td>
                    <td class="desabled">' . $ExpiryDate . '</td>
                    <td class="desabled">' . $MfgDate . '</td>
                    <td class="desabled">' . $getAllData[$i]->Branch . '</td>
                    <td class="desabled">' . $getAllData[$i]->Loc . '</td>
                    <td class="desabled">' . $getAllData[$i]->StabilityPlanDocNum . '</td>
                    <td class="desabled">' . $getAllData[$i]->StabilityPlanDocEntry . '</td>
                    <td class="desabled">' . $StabilityLoadingDate . '</td>
                    <td class="desabled">' . $getAllData[$i]->StabilityPlanQty . '</td>
                    <td class="desabled">' . $getAllData[$i]->SampleIntimationNoStability . '</td>
                    <td class="desabled">' . $getAllData[$i]->SampleCollectionNoStability . '</td>
                    <td class="desabled">' . $getAllData[$i]->WoNo . '</td>
                    <td class="desabled">' . $getAllData[$i]->WoEntry . '</td>
                    <td class="desabled">' . $getAllData[$i]->ReceiptNo . '</td>
                    <td class="desabled">' . $getAllData[$i]->ReceiptEntry . '</td>
                    <td class="desabled">' . $getAllData[$i]->RecQty . '</td>
                    <td class="desabled">' . $getAllData[$i]->StabilityType . '</td>
                    <td class="desabled">' . $getAllData[$i]->StabilityCondition . '</td>
                    <td class="desabled">' . $getAllData[$i]->StabilityTimePeriod . '</td>
                    <td class="desabled">' . $getAllData[$i]->AnalysisType . '</td>
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
<?php include 'models/qc_process/stability-qc-check-model.php' ?>
<?php include 'models/qc_process/qc_post_qc_check_stability_modal.php' ?>

    <!-- ---------- loader start here---------------------- -->
        <div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
            <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
                <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
            </div>
        </div>
    <!-- ---------- loader end here---------------------- -->

    <!-- ---------instrument modal------------- -->
        <div class="modal fade instrument_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Instrument List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive table_item_padding" id="append_instrument_table"></div>
                    </div>
                </div>
            </div>
        </div>
    <!-- ---------instrument modal end------------- -->

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">QC Post Document(QC Check) - Stability</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active"> QC Post Document(QC Check) - Stability</li>
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
                                <h4 class="card-title mb-0">QC Post Document(QC Check) - Stability</h4>
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
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->

                <br>

                <form role="form" class="form-horizontal" id="QcDpcumentFormStability" method="post">
                    <div id="footerProcess">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="stability_DocEntry" name="stability_DocEntry">
                                            <input type="hidden" class="form-control" id="stability_BPLId" name="stability_BPLId">
                                            <input type="hidden" class="form-control" id="stability_Canceled" name="stability_Canceled">
                                            <input type="hidden" class="form-control" id="stability_LineNum" name="stability_LineNum">
                                            <input type="hidden" class="form-control" id="stability_LocCode" name="stability_LocCode">
                                            <input type="hidden" class="form-control" id="stability_Status" name="stability_Status">
                                            <input type="hidden" class="form-control" id="stability_SupplierCode" name="stability_SupplierCode">
                                            <input type="hidden" class="form-control" id="stability_SupplierName" name="stability_SupplierName">
                                            <input type="hidden" class="form-control" id="stability_ToWhse" name="stability_ToWhse">
                                            <input type="hidden" class="form-control" id="stability_Unit" name="stability_Unit">

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_ReceiptNo" name="stability_ReceiptNo" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_ReceiptEntry" name="stability_ReceiptEntry" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_WONo" name="stability_WONo" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_WOEntry" name="stability_WOEntry" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_ItemCode" name="stability_ItemCode" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_ItemName" name="stability_ItemName" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_GenericName" name="stability_GenericName" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_LabelClaim" name="stability_LabelClaim" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam UOM</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_LabelClaimUOM" name="stability_LabelClaimUOM" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_MfgBy" name="stability_MfgBy" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Release Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="Text" id="stability_RelDate" name="stability_RelDate">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retest Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="Text" id="stability_ReTestDate" name="stability_ReTestDate">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="Text" id="stability_ARNo" name="stability_ARNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Specification No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_SpecNo" name="stability_SpecNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-select desabled" id="stability_SamType" name="stability_SamType">
                                                            <option>Regular</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_MatType" name="stability_MatType" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_RefNo" name="stability_RefNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_BatchNo" name="stability_BatchNo" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_BatchQty" name="stability_BatchQty" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_MfgDate" name="stability_MfgDate" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_ExpiryDate" name="stability_ExpiryDate" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Intimation Stability</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control desabled" type="text" id="stability_SampleIntimationNoStability" name="stability_SampleIntimationNoStability" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Collection Stability</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control desabled" type="text" id="stability_SampleCollectionNoStability" name="stability_SampleCollectionNoStability" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Whs Code</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_WhsCode" name="stability_WhsCode" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-8 col-form-label mt-6" for="val-skill">Sample Transfer No From WO</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_StabilityTransferNofromWO" name="stability_StabilityTransferNofromWO" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-8 col-form-label mt-6" for="val-skill">Sample Collection Entry From WO</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_StabilityTransferEntryfromWO" name="stability_StabilityTransferEntryfromWO" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Plan DocNum</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_StabilityPlanDocNum" name="stability_StabilityPlanDocNum" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Plan DocEntry</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_StabilityPlanDocEntry" name="stability_StabilityPlanDocEntry" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Plan Quantity</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_StabilityPlanQty" name="stability_StabilityPlanQty" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-8 col-form-label mt-6" for="val-skill">Stability Loading Date</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="Text" id="stability_StabilityLoadingDate" name="stability_StabilityLoadingDate">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_SeriesName" name="stability_SeriesName" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="stability_Series" name="stability_Series" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="stability_PostingDate" name="stability_PostingDate" value="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="stability_ADate" name="stability_ADate" value="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">No. Container</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_NoCont" name="stability_NoCont" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_Branch" name="stability_Branch" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_Loc" name="stability_Loc" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="date" id="stability_ValidUpto" name="stability_ValidUpto">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_PackSize" name="stability_PackSize" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stability Type</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_StabilityType" name="stability_StabilityType" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Type</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="stability_AnalysisType" name="stability_AnalysisType" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Condition</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control desabled" type="text" id="stability_StabilityCondition" name="stability_StabilityCondition" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-6 col-form-label mt-6" for="val-skill">Stability Time Period</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control desabled" type="text" id="stability_StabilityTimePeriod" name="stability_StabilityTimePeriod" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-8 col-form-label mt-6" for="val-skill">Release Material without QC</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-select" id="stability_ReleaseMaterialwithoutQC" name="stability_ReleaseMaterialwithoutQC">
                                                            <option>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#general_data8" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">General Data</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#qc_status8" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">QC Status</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#attatchment8" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Attatchment</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="general_data8" role="tabpanel">
                                                <div class="table-responsive qc_list_table table_item_padding" id="list2">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Sr.No</th>
                                                                <th>Parameter Code</th>
                                                                <th>Parameter Name</th>
                                                                <th>Specification</th>
                                                                <th>Result OutPut</th>
                                                                <th>Comparison Result</th>
                                                                <th>Result Output By QC Dept.</th>
                                                                <th>Parameter Data Type</th>
                                                                <th>Logical</th>
                                                                <th>Lower Min</th>
                                                                <th>Upper Max</th>
                                                                <th>Mean</th>
                                                                <th>QC Status by Analyst</th>
                                                                <th>Test Method</th>
                                                                <th>Material Type</th>
                                                                <th>Pharmacopoeial Standard</th>
                                                                <th>UOM</th>
                                                                <th>Retest</th>
                                                                <th>External Sample</th>
                                                                <th>Analysis By</th>
                                                                <th>Analyst Remarks</th>
                                                                <th>Lower Max</th>
                                                                <th>Release</th>
                                                                <th>Descriptive Details</th>
                                                                <th>Upper Min</th>
                                                                <th>Lower Min - Result</th>
                                                                <th>Upper Min - Result</th>
                                                                <th>Upper Max - Result</th>
                                                                <th>Mean - Result</th>
                                                                <th>User Text-1</th>
                                                                <th>User Text-2</th>
                                                                <th>User Text-3</th>
                                                                <th>User Text-4</th>
                                                                <th>User Text-5</th>
                                                                <th>QC Setup Remark</th>
                                                                <th>Stability</th>
                                                                <th>Applicable for Assay</th>
                                                                <th>Applicable for LOD</th>
                                                                <th>Instrument Code</th>
                                                                <th>Instrument Name</th>
                                                                <th>Start Date</th>
                                                                <th>Start Time</th>
                                                                <th>End Date</th>
                                                                <th>End Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="qc-post-general-data-list-append_"></tbody>
                                                    </table>
                                                </div><!--end table-->
                                            </div> <!-- tab_pane samp details end -->

                                            <div class="tab-pane" id="qc_status8" role="tabpanel">
                                                <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Sr. No</th>
                                                                <th style="width:150px;display: block;">Status</th>
                                                                <th>Quantity</th>
                                                                <th>Release Date</th>
                                                                <th>Release Time</th>
                                                                <th>IT No</th>
                                                                <th style="width:150px;display: block;">Done By</th>
                                                                <th>Attachment 1</th>
                                                                <th>Attachment 2</th>
                                                                <th>Attachment 3</th>
                                                                <th>Deviation Date</th>
                                                                <th>Deviation No</th>
                                                                <th>Deviation Reason</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="qc-status-list-append_"></tbody>
                                                    </table>
                                                </div><!--table responsive end-->
                                            </div> <!-- tab_pane qc status end -->

                                            <div class="tab-pane" id="attatchment8" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="table-responsive" id="list">
                                                            <table id="tblItemRecord" class="table table-bordered" style="">
                                                                <thead class="fixedHeader1">
                                                                    <tr>
                                                                        <th>Sr. No</th>
                                                                        <th>Target Path</th>
                                                                        <th>File Name</th>
                                                                        <th>Attatchment Date</th>
                                                                        <th>Free Text</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="qc-attach-list-append_"></tbody>
                                                            </table>
                                                        </div><!--table responsive end-->
                                                    </div><!--col closed-->

                                                    <div class="col-md-2">
                                                        <div class="gap-2">
                                                            <!-- Toggle States Button -->
                                                            <label class="btn btn-primary active  mb-2">
                                                                Browse <input type="file" hidden>
                                                            </label>
                                                            <br>
                                                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Display</button>
                                                            <br>
                                                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Delete</button>
                                                        </div>
                                                    </div><!--col closed-->
                                                </div><!--row closed-->
                                            </div> <!-- tab_pane attatchment end -->
                                            <!-- tfoot start -->

                                            <div class="general_data_footer">
                                                <div class="row">
                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-5 col-form-label mt-6" for="val-skill">Assay Potency %</label>
                                                            <div class="col-lg-7">
                                                                <input class="form-control" type="text" id="stability_APot" name="stability_APot" onfocusout="CalculatePotency();" value="0.000000">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">LOD/Water %</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" id="stability_LODWater" name="stability_LODWater" onfocusout="CalculatePotency();" value="0.000000">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-7 col-form-label mt-6" for="val-skill">Assay Calculation Based On</label>
                                                            <div class="col-lg-5">
                                                                <select class="form-select" id="stability_AsyCal" name="stability_AsyCal">
                                                                    <!-- <option>On As is Basis</option> -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Potency</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" id="stability_Potency" name="stability_Potency">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Factor</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" id="stability_Factor" name="stability_Factor">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" id="stability_CompBy" name="stability_CompBy">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" id="stability_CheckBy" name="stability_CheckBy">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" id="stability_AnylBy" name="stability_AnylBy">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                            <div class="col-lg-4">
                                                                <input class="form-control" type="text" id="stability_NoCont1" name="stability_NoCont1">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input class="form-control" type="text" id="stability_NoCont2" name="stability_NoCont2">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="form-group row mb-2">
                                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Remarks</label>
                                                            <div class="col-lg-8">
                                                                <textarea class="form-control" rows="1" id="stability_Remarks" name="stability_Remarks"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!--general data footer end-->

                                            <!-- -------footer button---- -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <!-- Toggle States Button -->
                                                        <button type="button" class="btn btn-primary" id="addQcPostDocumentSubmitQCCheckBtnStability" name="addQcPostDocumentSubmitQCCheckBtnStability" onclick="return add_qc_post_document();">Update</button>

                                                        <button type="button" class="btn btn-danger active" data-bs-toggle="button" autocomplete="off" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                                                        <button type="button" class="btn btn-primary in-tranf" data-bs-toggle="modal" data-bs-target=".inventory_transfer_qc_ckeck_stability" autocomplete="off" onclick="TransToUnder();" disabled>Inventory Transfer</button>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Work Sheet Print</button>
                                                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"><i class="fa fa-angle-down"></i>
                                                            <span class="visually-hidden"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                                            <li><a class="dropdown-item" href="#">Approval Label Print</a></li>
                                                            <li><a class="dropdown-item" href="#">Rejected Label Print</a></li>
                                                            <li><a class="dropdown-item" href="#">On-Hold Label Print</a></li>
                                                            <li><a class="dropdown-item" href="#">Print Certificate</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--row end-->
                                            <!-- ------footer button end---- -->
                                        </div> <!-- tab content end -->
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div>
                </form>
            </div><!--row closed-->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <br>

    <?php include 'include/footer.php' ?>

    <style type="text/css">
        body[data-layout=horizontal] .page-content {padding: 20px 0 0 0;padding: 40px 0 60px 0;}
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
        $.ajax({
            type: "POST",
            url: window.location.href,
            data: dataString,
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(result) {
                $('#list-append').html(result);
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    });

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
                $(".loader123").show();
            },
            success: function(result) {
                $("#footerProcess").hide(); // bottom section hide
                $('#list-append').html(result);
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function selectedRecord(DocEntry) {
        var dataString = 'DocEntry=' + DocEntry + '&action=QCPostdocumentQCPost_Stability_row';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(result) {
                $("#footerProcess").show();
                var JSONObjectAll = JSON.parse(result);
                var JSONObject = JSONObjectAll['SampleCollDetails'];

                $(`#qc-post-general-data-list-append_`).html(JSONObjectAll['general_data']); // Extra Issue Table Tr tag append here
                $(`#qc-status-list-append_`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                $(`#qc-attach-list-append_`).html(JSONObjectAll['qcAttach']);

                // hidden-----------------------------------------------------------------------
                    $(`#stability_DocEntry`).val(JSONObject[0]['DocEntry']);
                    $(`#stability_BPLId`).val(JSONObject[0]['BPLId']);
                    $(`#stability_Canceled`).val(JSONObject[0]['Canceled']);
                    $(`#stability_LineNum`).val(JSONObject[0]['LineNum']);
                    $(`#stability_LocCode`).val(JSONObject[0]['LocCode']);
                    $(`#stability_Status`).val(JSONObject[0]['Status']);
                    $(`#stability_SupplierCode`).val(JSONObject[0]['SupplierCode']);
                    $(`#stability_SupplierName`).val(JSONObject[0]['SupplierName']);
                    $(`#stability_ToWhse`).val(JSONObject[0]['ToWhse']);
                    $(`#stability_ReceiptNo`).val(JSONObject[0]['ReceiptNo']);
                    $(`#stability_ReceiptEntry`).val(JSONObject[0]['ReceiptEntry']);

                // 1st row-----------------------------------------------------------------------
                    $(`#stability_WONo`).val(JSONObject[0]['WONo']);
                    $(`#stability_WOEntry`).val(JSONObject[0]['WOEntry']);
                    $(`#stability_ItemCode`).val(JSONObject[0]['ItemCode']);
                    $(`#stability_ItemName`).val(JSONObject[0]['ItemName']);
                    $(`#stability_GenericName`).val(JSONObject[0]['GenericName']);
                    $(`#stability_LabelClaim`).val(JSONObject[0]['LabelClaim']);
                    $(`#stability_LabelClaimUOM`).val(JSONObject[0]['LabelClaimUOM']);

                // 2nd row------------------------------------------------------------------------
                    $(`#stability_MfgBy`).val(JSONObject[0]['MfgBy']);
                    $(`#stability_NoCont1`).val(JSONObject[0]['NoCont1']);
                    $(`#stability_NoCont2`).val(JSONObject[0]['NoCont2']);
                    $(`#stability_RelDate`).val(DateFormatingDMY(JSONObject[0].RelDate));
                    $(`#stability_ReTestDate`).val(DateFormatingDMY(JSONObject[0].ReTestDate));
                    $(`#stability_ARNo`).val(JSONObject[0]['ARNo']);

                // 3nd row------------------------------------------------------------------------
                    $(`#stability_SpecNo`).val(JSONObject[0]['SpecNo']);
                    $(`#stability_SamType`).val(JSONObject[0]['SamType']);
                    $(`#stability_MatType`).val(JSONObject[0]['MatType']);
                    $(`#stability_RefNo`).val(JSONObject[0]['RefNo']);

                // 4th row------------------------------------------------------------------------
                    $(`#stability_BatchNo`).val(JSONObject[0]['BatchNo']);
                    $(`#stability_BatchQty`).val(JSONObject[0]['BatchQty']);

                    // <!-- ----------- MFG Date Start Here ----------------------------------- -->
                        // console.log('MfgDate=>',JSONObject[0].MfgDate);
                        $(`#stability_MfgDate`).val(DateFormatingDMY(JSONObject[0].MfgDate));
                    // <!-- ----------- MFG Date End Here ------------------------------------- -->

                    // console.log('all data=>',JSONObject[0]);

                    // <!-- ----------- Exp Date Start Here ----------------------------------- -->
                        // console.log('ExpDate=>',JSONObject[0].ExpiryDate);
                        console.log('ExpiryDate->', JSONObject[0].ExpiryDate);
                        $(`#stability_ExpiryDate`).val(DateFormatingDMY(JSONObject[0].ExpiryDate));
                    // <!-- ----------- Exp Date End Here ------------------------------------- -->

                //  5th row------------------------------------------------------------------------
                    $(`#stability_SampleIntimationNoStability`).val(JSONObject[0]['SampleIntimationNoStability']);
                    $(`#stability_SampleCollectionNoStability`).val(JSONObject[0]['SampleCollectionNoStability']);
                    $(`#stability_WhsCode`).val(JSONObject[0]['WhsCode']);
                    $(`#stability_StabilityTransferNofromWO`).val(JSONObject[0]['StabilityTransferNofromWO']);
                    $(`#stability_StabilityTransferEntryfromWO`).val(JSONObject[0]['StabilityTransferEntryfromWO']);
                    $(`#stability_StabilityPlanDocNum`).val(JSONObject[0]['StabilityPlanDocNum']);
                    $(`#stability_StabilityPlanDocEntry`).val(JSONObject[0]['StabilityPlanDocEntry']);
                    $(`#stability_StabilityPlanQty`).val(JSONObject[0]['StabilityPlanQty']);
                    $(`#stability_StabilityLoadingDate`).val(DateFormatingDMY(JSONObject[0].StabilityLoadingDate));
                    $(`#stability_SeriesName`).val(JSONObject[0]['SeriesName']);
                    $(`#stability_Series`).val(JSONObject[0]['Series']);
                    $(`#stability_Unit`).val(JSONObject[0]['Series']);
                    $(`#stability_NoCont`).val(JSONObject[0]['NoCont']);
                    $(`#stability_Branch`).val(JSONObject[0]['Branch']);
                    $(`#stability_Loc`).val(JSONObject[0]['Loc']);
                    $(`#stability_ValidUpto`).val(JSONObject[0]['ValidUpto']);
                    $(`#stability_PackSize`).val(JSONObject[0]['PackSize']);
                    $(`#stability_StabilityType`).val(JSONObject[0]['StabilityType']);
                    $(`#stability_AnalysisType`).val(JSONObject[0]['AnalysisType']);
                    $(`#stability_StabilityCondition`).val(JSONObject[0]['StabilityCondition']);
                    $(`#stability_StabilityTimePeriod`).val(JSONObject[0]['StabilityTimePeriod']);

                $('.in-tranf').removeAttr('disabled');

                QC_StatusByAnalystDropdown(JSONObjectAll.count);
                getResultOutputDropdown(JSONObjectAll.count);
                getQcStatusDropodwn(1);
                getDoneByDroopdown(1);
                assayapp();
                getResultOutputDropdownWithSelectedOption(JSONObjectAll.count);
                QC_StatusByAnalystDropdownWithSelectedOption(JSONObjectAll.count);
                GetRowLevelAnalysisByDropdown(JSONObjectAll.count);
                GetRowLevelAnalysisByDropdownWithSelectedOption(JSONObjectAll.count)
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function DateFormatingDMY(DateOG){
        if(DateOG!=''){
            let [day, month, year] = DateOG.split(" ")[0].split("-");
            let Date = `${day}-${month}-${year}`;
            // let Date = `${year}-${month}-${day}`;
            return Date;
        }
    }

    function CalculateResultOut(un_id) {
        var lowMin = document.getElementById('LowMin' + un_id).value;
        var uppMax = document.getElementById('UppMax' + un_id).value;
        var UOM = document.getElementById('UOM' + un_id).value;

        var ComparisonResultOG = document.getElementById('ComparisonResult' + un_id).value; // this value enter by user

        if (ComparisonResultOG != '') {
            $('#ResultOut' + un_id).val(ComparisonResultOG + ' ' + UOM);

            if (parseFloat(uppMax) === 0) {
                if (parseFloat(ComparisonResultOG) >= parseFloat(lowMin)) {
                    $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #c7f3c7');
                    $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');

                    setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "PASS");
                } else {
                    $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #f8a4a4');
                    $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

                    setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "FAIL");
                }
            } else {
                if (parseFloat(ComparisonResultOG) >= parseFloat(lowMin) && parseFloat(ComparisonResultOG) <= parseFloat(uppMax)) {
                    $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #c7f3c7');
                    $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');

                    setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "PASS");
                } else {
                    $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #f8a4a4');
                    $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

                    setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "FAIL");
                }
            }
        } else {
            $('#ResultOut' + un_id).val('');
            $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #FFFFFF');
            $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #FFFFFF;border:1px solid #FFFFFF !important;');

            setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "-");
        }
    }

    function setSelectedIndex(s, valsearch) {
        for (i = 0; i < s.options.length; i++) {
            if (s.options[i].value == valsearch) {
                // Item is found. Set its property and exit
                s.options[i].selected = true;
                break;
            }
        }
        return;
    }

    function ManualSelectedTResultOut(un_id) {
        var ResultOut = document.getElementById('ResultOut' + un_id).value;

        if (ResultOut == '-') {
            // BLANK
            $('#ResultOutTd' + un_id).attr('style', 'background-color: #ffffff');
            $('#ResultOut' + un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');

        } else if (ResultOut == 'FAIL') {
            // FAIL
            $('#ResultOutTd' + un_id).attr('style', 'background-color: #f8a4a4');
            $('#ResultOut' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

        } else {

            $('#ResultOutTd' + un_id).attr('style', 'background-color: #c7f3c7');
            $('#ResultOut' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        }
    }

    function SelectedQCStatus(un_id) {
        var QC_StatusByAnalyst = document.getElementById('QC_StatusByAnalyst' + un_id).value;

        if (QC_StatusByAnalyst == 'Complies') {
            $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #c7f3c7');
            $('#QC_StatusByAnalyst' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        } else if (QC_StatusByAnalyst == 'Non Complies') {
            $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #f8a4a4');
            $('#QC_StatusByAnalyst' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
        } else {
            $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #ffffff');
            $('#QC_StatusByAnalyst' + un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');
        }
    }

    function getQcStatusDropodwn(n) {
        var dataString = 'action=qc_api_OQCSTATUS_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_common-ajax.php',
            data: dataString,
            success: function(result) {
                $('.qc_status_selecte' + n).html(result);
            }
        });
    }

    function getDoneByDroopdown(n) {
        var dataString = 'action=qc_get_SAMINTTRBY_ajax';
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: 'ajax/kri_common-ajax.php',
            data: dataString,
            success: function(result) {

                var html = "";
                result.forEach(function(value, index) {
                    if (value.TRBy != "") {
                        html += '<option value="' + value.TRBy + '">' + value.TRBy + '</option>';
                    }
                });

                $('.done-by-mo' + n).html(html);
            }
        })
    }

    function QC_StatusByAnalystDropdown(trcount) {
        var dataString = 'TableId=@SCS_QCSTAB1&Alias=QCSts&action=dropdownMaster_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(result) {
                var JSONObject = JSON.parse(result);
                for (let i = 0; i < trcount; i++) {
                    $('.qc_statusbyab' + i).html(JSONObject); // dropdown set using Class                            
                }
            },
            complete: function(data) {}
        })
    }

    function getResultOutputDropdown(trcount) {
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: {
                'action': "ResultOutputDropdown_ajax"
            },
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(result) {
                for (let i = 0; i < trcount; i++) {
                    $('.dropdownResutl' + i).html(result); // dropdown set using Id                            
                }
            },
            complete: function(data) {}
        })
    }

    function assayapp() {
        var dataString = 'action=qc_assay_Calculation_Based_stability_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            success: function(result) {
                $('#stability_AsyCal').html(result);
            }
        })
    }

    function CalculatePotency() {
        // <!-- -----------  LoD / Water Value Preparing Start Here ------------------------------- -->
            var lod_waterOG = document.getElementById('stability_LODWater').value;

            if ((parseFloat(lod_waterOG).toFixed(6)) <= '0.000000' || lod_waterOG == '' || lod_waterOG == null) {
                var lod_water = '0.000000';
                $('#stability_LODWater').val(lod_water);
            } else {
                var lod_water = parseFloat(lod_waterOG).toFixed(6);
                $('#stability_LODWater').val(lod_water);
            }
        // <!-- -----------  LoD / Water Value Preparing End Here --------------------------------- -->

        // <!-- -----------  AssayPotency Value Preparing Start Here ------------------------------- -->
            var assayPotencyOG = document.getElementById('stability_APot').value;

            if ((parseFloat(assayPotencyOG).toFixed(6)) <= '0.000000' || assayPotencyOG == '' || assayPotencyOG == null) {
                var assayPotency = '0.000000';
                $('#stability_APot').val(assayPotency);
            } else {
                var assayPotency = parseFloat(assayPotencyOG).toFixed(6);
                $('#stability_APot').val(assayPotency);
            }
        // <!-- -----------  AssayPotency Value Preparing End Here --------------------------------- -->

        var Potency = ((100 - parseFloat(lod_water)) / 100) * parseFloat(assayPotency); // Calculation
        $('#stability_Potency').val(parseFloat(Potency).toFixed(6)); // Set Potency calculated val
    }

    function add_qc_post_document() {
        var formData = new FormData($('#QcDpcumentFormStability')[0]); // Form Id
        formData.append("addQcPostDocumentSubmitQCCheckBtnStability", 'addQcPostDocumentSubmitQCCheckBtnStability'); // Button Id
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
                        title: `${message}`,
                        text: `${DocEntry}`,
                        icon: "success",
                        buttons: true,
                        dangerMode: false,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            location.replace(window.location.href); //ok btn
                        } else {
                            location.replace(window.location.href); // cancel btn
                        }
                    });
                } else {
                    swal("Oops!", `${message}`, "error");
                }
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function TransToUnder() {
        var stability_DocEntry = document.getElementById('stability_DocEntry').value;
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: {
                'DocEntry': stability_DocEntry,
                'action': "qc_post_document_stability_pupup_ajax"
            },
            cache: false,
            dataType: 'JSON',
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(result) {
                $('#s_IT_stability_series').val(result.response[0].Series);
                $('#s_IT_stability_SupplierName').val(result.response[0].SupplierName);
                $('#s_IT_stability_Suppliercode').val(result.response[0].SupplierCode);
                $('#s_IT_stability_branch').val(result.response[0].Branch);
                $('#s_IT_stability_PostingDate').val(result.response[0].PostingDate);
                $('#s_IT_stability_DocumentDate').val('');
                $('#s_IT_stability_BaseDocType').val('SCS_QCINPROC');
                $('#s_IT_stability_BaseDocNum').val(result.response[0].DocNum);

                var JSONObject = result.option;
                $('#InventoryTransferItemAppend_stability').html(JSONObject);
                ContainerSelection_stability() // get Container Selection Table List
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function ContainerSelection_stability() {
        var DocEntry = document.getElementById('stability_DocEntry').value;
        var BatchNo = document.getElementById('stability_BatchNo').value;
        var ItemCode = document.getElementById('stability_ItemCode').value;
        var itP_FromWhs = document.getElementById('Stability_FromWhs').value;

        var dataString = 'ItemCode=' + ItemCode + '&WareHouse=' + itP_FromWhs + '&DocEntry=' + DocEntry + '&BatchNo=' + BatchNo + '&action=OpenInventoryTransfer_stability_qcchecked_ajax';
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
                $('#ContainerSelectionItemAppend_stabilitys').html(JSONObject);
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function getSelectedContener_retails(un_id) {
        //Create an Array.
        var selected = new Array();

        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_stabilitys");

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
            document.getElementById("cs_selectedQtySum_stability").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

        // <!-- --------------------- when user select checkbox update flag start here -------------- -->
            var usercheckListVal = document.getElementById('usercheckList_retails' + un_id).value;
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
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_stabilitys");

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
            document.getElementById("cs_selectedQtySum_stability").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
    }

    function SubmitInventoryTransferQC_stability() {
        var selectedQtySum = document.getElementById('cs_selectedQtySum_stability').value; // final Qty sum
        var PostingDate = document.getElementById('s_IT_stability_PostingDate').value;
        var DocDate = document.getElementById('s_IT_stability_DocumentDate').value;
        var ItemCode = document.getElementById('itP_ItemCode').value;
        var ItemName = document.getElementById('itP_ItemName').value;
        var item_BQty = parseFloat(document.getElementById('qc_check_Quality').value).toFixed(6); // item available Qty
        var fromWhs = document.getElementById('itP_FromWhs').value;
        var ToWhs = document.getElementById('itP_ToWhs').value;
        var Location = document.getElementById('itP_Loction').value;

        if (selectedQtySum == item_BQty) { // Container selection Qty validation
            if (ToWhs != '') { // Item level To Warehouse validation
                if (PostingDate != '') { // Posting Date validation
                    if (DocDate != '') { // Document Date validation
                        // <!-- ---------------- form submit process start here ----------------- -->
                            var formData = new FormData($('#inventoryFormSubmit_stability')[0]);
                            formData.append("SubIT_Btn_stabilitys", 'SubIT_Btn_stabilitys');

                            var error = true;
                            if (error) {
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
                                })
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

    $(document).ready(function() {
        var dataString = 'action=qc_get_SAMINTTRBY_ajax';
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: 'ajax/kri_common-ajax.php',
            data: dataString,
            success: function(result) {
                $('#stability_CompBy').val(result[0]['TRBy']);
                $('#stability_CheckBy').val(result[0]['TRBy']);
                $('#stability_AnylBy').val(result[0]['TRBy']);

                var html = "";
                result.forEach(function(value, index) {
                    html += '<option value="' + value.TRBy + '">' + value.TRBy + '</option>';
                });

                $('#doneBy_1').html(html);
            }
        })
    });

    // ---------------------------------Apoorv Changes -->
    let favorite = [];
    let total_uid = 0;
    function GetSelectedInstumentdata(un_id) {
        const ids_new_radio = [];

        $("input[name='InstrumentId[]']:checked").each(function() {
            const uid = parseInt($(this).val()); // Parse the value to integer
            favorite.push(uid);
            total_uid += uid;
            ids_new_radio.push(uid);
        });

        const InstrumentCode = $('#Html_InstrumentCode' + ids_new_radio[0]).text(); // Assuming you want the first element's text
        const InstrumentName = $('#Html_InstrumentName' + ids_new_radio[0]).text(); // Assuming you want the first element's text

        $('#InstrumentCode' + un_id).val(InstrumentCode);
        $('#InstrumentName' + un_id).val(InstrumentName);
    }

    function OpenInstrmentModal(un_id) {
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: {
                'un_id': un_id,
                'action': "OpenInstrmentModal_Ajax"
            },
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(result) {
                var Table = JSON.parse(result);
                $('#append_instrument_table').html(Table);
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }       

    function getResultOutputDropdownWithSelectedOption(trcount) {
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: {'action': "getResultOutputDropdownWithSelectedOption_Ajax"},
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(opt) {
                var JSONObject = JSON.parse(opt);
                let count = JSONObject.length;

                for (let i = 0; i < trcount; i++) {
                    const dropdown = document.getElementById('ResultOutputByQCDept' + i);

                    let selectedValue = $('#ResultOutputByQCDept_Old' + i).val();

                    let options = '';
                    for (let j = 0; j < count; j++) {
                        let selected = (selectedValue == JSONObject[j].Code) ? 'selected' : '';
                        options += `<option value="${JSONObject[j].Code}" ${selected}>${JSONObject[j].Name}</option>`;
                    }

                    dropdown.innerHTML = options;
                    OnChangeResultOutputByQCDept(i);
                }
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function OnChangeResultOutputByQCDept(un_id) {
        var ResultOutputByQCDept = $('#ResultOutputByQCDept' + un_id).val();

        if (ResultOutputByQCDept == 'FAIL') {
            $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #f8a4a4');
            $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
        } else if (ResultOutputByQCDept == 'PASS') {
            $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #c7f3c7');
            $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        } else {
            $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #FFFFFF');
            $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #FFFFFF;border:1px solid #FFFFFF !important;');
        }
    }

    function QC_StatusByAnalystDropdownWithSelectedOption(trcount) {
        var dataString = 'TableId=@SCS_QCPD1&Alias=QCStatus&action=QC_StatusByAnalystDropdownWithSelectedOption_Ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(opt) {
                var JSONObject = JSON.parse(opt);
                let count = JSONObject.length;

                for (let i = 0; i < trcount; i++) {
                    const dropdown = document.getElementById('qC_status_by_analyst' + i);

                    let selectedValue = $('#qC_status_by_analyst_Old' + i).val();

                    let options = '';
                    for (let j = 0; j < count; j++) {
                        let selected = (selectedValue == JSONObject[j].FldValue) ? 'selected' : '';
                        options += `<option value="${JSONObject[j].FldValue}" ${selected}>${JSONObject[j].Description}</option>`;
                    }

                    dropdown.innerHTML = options;
                    SelectedQCStatus(i);
                }
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function SelectedQCStatus(un_id) {
        var QC_StatusByAnalyst = document.getElementById('qC_status_by_analyst' + un_id).value;

        if (QC_StatusByAnalyst == 'Complies') {
            $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #c7f3c7');
            $('#qC_status_by_analyst' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        } else if (QC_StatusByAnalyst == 'Non Complies') {
            $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #f8a4a4');
            $('#qC_status_by_analyst' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
        } else {
            $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #ffffff');
            $('#qC_status_by_analyst' + un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');
        }
    }

    function GetRowLevelAnalysisByDropdownWithSelectedOption(trcount) {
        $.ajax({
            type: "POST",
            url: 'ajax/kri_common-ajax.php',
            data: {'action': "GetRowLevelAnalysisByDropdownWithSelectedOption_Ajax"},
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(opt) {
                var JSONObject = JSON.parse(opt);
                let count = JSONObject.length;

                for (let i = 0; i < trcount; i++) {
                    const dropdown = document.getElementById('AnalysisBy' + i);
                    let selectedValue = $('#AnalysisBy_Old' + i).val();
                    let options = `<option value="" >Select</option>`;
                    for (let j = 0; j < count; j++) {
                        let selected = (selectedValue == JSONObject[j].UserName) ? 'selected' : '';
                        options += `<option value="${JSONObject[j].UserCode}" ${selected}>${JSONObject[j].UserName}</option>`;
                    }

                    dropdown.innerHTML = options;
                }
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function GetRowLevelAnalysisByDropdown(trcount) {
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: {'action': "GetRowLevelAnalysisByDropdown_Ajax"},
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(result) {
                var dropdown = JSON.parse(result);

                for (let i = 0; i < trcount; i++) {
                    $('#AnalysisBy' + i).html(dropdown); // dropdown set using Id
                }

                $('#routStage_CheckedBy').html(dropdown); // Bottom dropdown set using Id
                $('#routStage_AnalysisBy').html(dropdown); // Bottom dropdown set using Id
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function SelectionOfQC_Status(un_id) {
        var tr_count = parseInt($('#tr-count').val());
        
        var now = new Date();
        var year = now.getFullYear();
        var month = (now.getMonth() + 1).toString().padStart(2, '0');
        var day = now.getDate().toString().padStart(2, '0');
        var formattedDate = `${day}-${month}-${year}`;
        var hours = now.getHours().toString().padStart(2, '0');
        var minutes = now.getMinutes().toString().padStart(2, '0');
        var formattedTime = `${hours}:${minutes}`;

        $('#qCReleaseDate_' + un_id).val(formattedDate);
        $('#qCReleaseTime_' + un_id).val(formattedTime);

        if (tr_count !== 1) {
            var rows = $('#qc-status-list-append tr');
            var Selected_QC_Status = $('#qc_Status_' + un_id).val();
            var valid = true;
            var message = "";

            rows.each(function(index) {
                if (index < rows.length - 1) {
                    var qcStatusDropdown = $('#qc_Status_' + (index + 1)).val();
                    if (qcStatusDropdown === Selected_QC_Status) {
                        valid = false;
                        message += `Row ${index + 1} has '${Selected_QC_Status}' selected.\n`;
                    }
                }
            });

            if (valid) {
                if (!$('#qCStsQty_' + un_id).val()) {
                    $('#qCStsQty_' + un_id).val(AutocalculateQC_Qty());
                }
            } else {
                $('#qCStsQty_' + un_id).val('');
                $('#qc_Status_' + un_id).val('');
                swal("Oops!", "Repeated QC Status failed:\n" + message, "error");
            }
        } else {
            $('#qCStsQty_' + un_id).val($('#stability_BatchQty').val());
        }
    }

    function AutocalculateQC_Qty() {
        // <!-- calculate Quantity for QC status tab start ------------------------------ -->
            var rows = document.querySelectorAll('#qc-status-list-append tr');

            // Get the count of tr elements
            var rowCount = rows.length;

            // Initialize sum
            var sum = 0;

            // Loop through each row and sum the values of the inputs named 'qCStsQty[]'
            rows.forEach(function(row) {
                var input = row.querySelector('input[name="qCStsQty[]"]');
                if (input) {
                    sum += parseFloat(input.value) || 0;
                }
            });

            var BatchQty = $('#stability_BatchQty').val();
            var QCS_Qty = parseFloat(parseFloat(BatchQty) - parseFloat(sum)).toFixed(3);
            return QCS_Qty;
        // <!-- calculate Quantity for QC status tab end -------------------------------- -->
    }

    function addMore(num) {
        // Formate manula enter Quantity
        var QC_Quantity = $('#qCStsQty_' + num).val();
        $('#qCStsQty_' + num).val(parseFloat(QC_Quantity).toFixed(3));

        var tr_count = $('#tr-count').val();
        var QCS_Qty = AutocalculateQC_Qty();

        // Proceed with AJAX request only if QCS_Qty is not equal to 0.00
        if (parseFloat(QCS_Qty) !== 0.00) {
            var tr_count = $('#tr-count').val();
            $.ajax({
                type: "POST",
                url: 'ajax/kri_common-ajax.php',
                data: ({index: tr_count,action: 'add_qc_status_input_more'}),
                success: function(result) {
                    $('#add-more_' + tr_count).after(result);
                    tr_count++;
                    $('#tr-count').val(tr_count);
                    $('#qCStsQty_' + tr_count).val(QCS_Qty);

                    getQcStatusDropodwn(tr_count);
                    getDoneByDroopdown(tr_count);
                }
            })
        }
    }
</script>