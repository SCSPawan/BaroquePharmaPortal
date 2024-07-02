<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Baroque Pharmaceuticals Pvt Ltd</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Sweet alert start -->
            <script src="assets/dist/sweetalert.js"></script>
            <link rel="stylesheet" href="assets/dist/sweetalert.css">
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- Sweet alert end -->

        <!-- select custom script -->

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    </head>

    <style type="text/css">
        div.pagination {padding: 3px;margin: 3px;text-align:center;font-family:tahoma;font-size:12px;}

        div.pagination a {padding: 2px 5px 2px 5px;margin: 2px;border: 1px solid #00afef;text-decoration: none;color: #00afef;clear: left;}

        div.pagination a:hover, div.digg a:active {border: 1px solid #00afef;color: #000;}

        div.pagination spn.current {padding: 2px 5px 2px 5px;margin: 2px;border: 1px solid #000000;font-weight: bold;background-color: #e1f4fb;color: #000000;}

        div.pagination spn.disabled {padding: 2px 5px 2px 5px;margin: 2px;border: 1px solid #EEE;color: #DDD;}

        .custom_scroll{height: 560px;overflow-y: scroll;}
        .custom_scroll::-webkit-scrollbar { background: #fff;}

        .done{color: #1dec1d !important;}
        .working{color: darkorange !important;}
        .hold{color: red !important;}
        .pending{color: #00ffef !important;}
        /*.check{color: #ec1ddf !important;}*/
    </style>

    <body data-layout="horizontal" data-topbar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
            
            <header id="page-topbar" class="ishorizontal-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="home.php" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/barque.png" alt="" height="33">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/barque.png" alt="" height="33"> 
                                </span>
                            </a>

                            <a href="home.php" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/barque.png" alt="" height="33">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/barque.png" alt="" height="33"> 
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <div class="topnav">
                            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                                
                                <div class="collapse navbar-collapse" id="topnav-menu-content">
                                    <ul class="navbar-nav">

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                                <i class='bx bx-grid-alt'></i>
                                                <span data-key="t-apps">Inward QC</span> <div class="arrow-down"></div>
                                            </a>


                                            <!-- custom_scroll (horizontal scroll class 👇) -->
                                            <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                                
                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button">
                                                        <span data-key="t-charts">Inward QC</span> <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                        <a href="open_transaction_for_sample_intimation.php" class="dropdown-item" data-key="t-calendar">Open Transaction for Sample Intimation</a>
                                                        <a href="sample-intimation.php" class="dropdown-item" data-key="t-calendar">Sample Intimation</a>

                                                        <a href="open-sample-collection.php" class="dropdown-item" data-key="t-calendar">Open Transaction for Sample Collection</a>
                                                        <a href="sample-collection.php" class="dropdown-item" data-key="t-chat">Sample Collection</a>

                                                        <a href="open-transaction-for-qc-post-doc.php" class="dropdown-item" data-key="t-calendar">Open Transaction for QC Post Document</a>

                                                        <a href="qc-post-document.php" class="dropdown-item" data-key="t-calendar">QC Post Document</a>
                                                    </div>
                                                </div>






                                                <!-- <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button">
                                                        <span data-key="t-charts">Sample Intimation</span> <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                        <a href="open_transaction_for_sample_intimation.php" class="dropdown-item" data-key="t-calendar">Open Transaction for Sample Intimation</a>
                                                        <a href="sample-intimation.php" class="dropdown-item" data-key="t-calendar">Sample Intimation</a>
                                                    </div>
                                                </div>

                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button">
                                                        <span data-key="t-charts">Sample Collection</span> <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                        <a href="open-sample-collection.php" class="dropdown-item" data-key="t-calendar">Open Transaction for Sample Collection</a>
                                                        <a href="sample-collection.php" class="dropdown-item" data-key="t-chat">Sample Collection</a>
                                                    </div>
                                                </div>

                                                <a href="open-transaction-for-qc-post-doc.php" class="dropdown-item" data-key="t-calendar">Open Transaction for QC Post Document</a>

                                                <a href="qc-post-document.php" class="dropdown-item" data-key="t-calendar">QC Post Document</a> -->

                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button">
                                                        <span data-key="t-charts">Retest QC</span> <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                        <a href="open_trasaction_for_sample_intimation_retest_qc.php" class="dropdown-item" data-key="t-calendar">Open Transaction for Sample Intimation-Retest QC</a>

                                                        <a href="sample_intimation_retest_qc.php" class="dropdown-item" data-key="t-calendar">Sample Intimation-Retest QC</a>

                                                        <a href="open_trasaction_for_sample_collection_retest_qc.php" class="dropdown-item" data-key="t-calendar">Open Transaction for Sample Collection-Retest QC</a>

                                                        <a href="sample_collection_retest_qc.php" class="dropdown-item" data-key="t-chat">Sample Collection-Retest QC</a>

                                                        <a href="open_trasaction_for_qc_for_doc_retest_qc.php" class="dropdown-item" data-key="t-calendar">Open Transaction for QC Post Document-Retest QC</a>

                                                        <a href="qc_post_document_retest_qc.php" class="dropdown-item" data-key="t-calendar">QC Post Document-Retest QC</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </li>
        
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                                <i class='bx bx-grid-alt'></i>
                                                <span data-key="t-apps">Production QC</span> <div class="arrow-down"></div>
                                            </a>
                                            <!-- custom_scroll (horizontal scroll class 👇) -->
                                            <div class="dropdown-menu " aria-labelledby="topnav-pages">

                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button">
                                                        <span data-key="t-charts">Route/Stage</span> <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                        <a href="open_trasaction_for_sample_intimation_route_stage.php" class="dropdown-item check" data-key="t-chat">Open Transactions for Sample Intimation - Route/Stage</a>

                                                        <a href="sample_intimation_route_stage.php" class="dropdown-item check" data-key="t-chat">Sample Intimation - Route/Stage</a>

                                                        <a href="open_trasaction_for_sample_collection_route_stage.php" class="dropdown-item check" data-key="t-chat">Open Transactions for Sample Collection - Route/Stage</a>

                                                        <a href="sample_collection_route_stage.php" class="dropdown-item check" data-key="t-chat">Sample Collection - Route/Stage</a>

                                                        <a href="open_transaction_for_qc_post_doc_route_stage.php" class="dropdown-item" data-key="t-chat">Open Transaction For QC Post Document - Route Stage</a>

                                                        <a href="qc_post_doc_route_stage.php" class="dropdown-item" data-key="t-chat">QC Post document (QC Check) - Route Stage</a>
                                                    </div>
                                                </div>
                                                
                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button">
                                                        <span data-key="t-charts">In Process</span> <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                        <a href="open_transaction_for_sample_intimation_in_process.php" class="dropdown-item check" data-key="t-calendar">Open Transactions for Sample Intimation - In Process</a>

                                                        <a href="sample_intimation_in_process.php" class="dropdown-item check" data-key="t-calendar" >Sample Intimation - In Process</a>

                                                        <a href="open_transaction_for_sample_collection_in_process.php" class="dropdown-item check" data-key="t-calendar">Open Transaction for Sample Collection - In Process</a>

                                                        <a href="sample_collection_in_process.php" class="dropdown-item check" data-key="t-calendar">Sample Collection - In Process</a>

                                                        <a href="open_trasaction_for_qc_post_doc_in_process.php" class="dropdown-item check" data-key="t-calendar">Open Transaction for QC Post Document - In Process</a>

                                                        <a href="qc_post_doc_in_process.php" class="dropdown-item check" data-key="t-calendar">QC Post document (QC Check) - In Process</a>
                                                    </div>
                                                </div>

                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button">
                                                        <span data-key="t-charts">Finished Goods</span> <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                        <a href="open_transaction_for_sample_intimation_finished_goods.php" class="dropdown-item check" data-key="t-chat">Open Transaction for Sample Intimation - Finished Goods</a>

                                                        <a href="sample_intimation_finished_goods.php" class="dropdown-item check" data-key="t-chat">Sample Intimation - Finished Goods</a>

                                                        <a href="open_trasaction_for_sample_collection_finished_goods.php" class="dropdown-item check" data-key="t-chat">Open Transaction for Sample Collection - Finished Goods</a>

                                                        <a href="sample_collection_in_finished_goods.php" class="dropdown-item check" data-key="t-chat">Sample Collection - Finished Goods</a>

                                                        <a href="open_trasaction_for_qc_check_finished_goods.php" class="dropdown-item" data-key="t-chat">Open Transaction For QC Check - Finished Goods</a>

                                                        <a href="qc_check_finished_goods.php" class="dropdown-item" data-key="t-chat">QC Check - Finished Goods</a>
                                                    </div>
                                                </div>

                                                <!-- <a href="open_items_for_retest_qc_post_doc.php" class="dropdown-item hold" data-key="t-chat">Open Items for Retest QC post document - QC Check</a>

                                                <a href="qc_check_retest_doc.php" class="dropdown-item hold" data-key="t-chat">QC Check - Retest document</a> -->

                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button">
                                                        <span data-key="t-charts">Stability</span> <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                        <a href="stability-plan.php" class="dropdown-item check" data-key="t-chat">Stability Plan</a>

                                                        <a href="open_transaction_for_sample_intimation_stability.php" class="dropdown-item check" data-key="t-chat">Open Items For Sample Intimation - Stability</a>

                                                        <a href="sample_intimation_stability.php" class="dropdown-item check" data-key="t-chat">Sample Intimation (Transfer Request) - Stability</a>

                                                        <a href="open_trasaction_for_sample_collection_stability.php" class="dropdown-item check" data-key="t-chat">Open Transaction for Sample Collection - Stability</a>

                                                        <a href="sample_collection_stability.php" class="dropdown-item check" data-key="t-chat">Sample Collection - Stability</a>

                                                        <a href="open_trasaction_for_qc_post_doc_stability.php" class="dropdown-item working" data-key="t-chat">Open Transaction for QC Post Document - Stability</a>

                                                        <a href="qc_post_doc_stability.php" class="dropdown-item hold" data-key="t-chat">QC Post Document (QC Check) - Stability</a>
                                                    </div>
                                                </div>

                                            
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <div class="d-flex"></div>

                        <div class="dropdown top_header_profile d-inline-flex">

                            <h2>Welcome 
                                <span>
                                    <?php echo ucfirst($_SESSION['Baroque_FirstName'])?>
                                    <?php echo ucfirst($_SESSION['Baroque_LastName'])?>
                                </span>
                            </h2>

                            <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/user-icon.png"
                                alt="Header Avatar">
                            </button>

                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <a class="dropdown-item" href="logout.php">
                                    <i class='bx bx-log-out text-muted font-size-18 align-middle me-1'></i>
                                    <span class="align-middle">Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <style type="text/css">
                .top_header_profile h2{vertical-align: middle;font-size: 14px;padding-top: 22px;}
            </style>
    