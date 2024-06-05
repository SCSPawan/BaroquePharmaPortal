<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}
?>
<?php include 'include/header.php' ?>


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
                                    <h4 class="mb-0">BMR BPR</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">BMR BPR</li>
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
                                        <h4 class="card-title mb-0">BMR BPR</h4> 
                                    </div>

      
                               <div class="card-body">
                                 <div class="row">
                                        <div class="col-xl-2 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select samp-selct">
                                                        <option>Select</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Status</label>
                                                <div class="col-lg-8">
                                                   <select class="form-select samp-selct">
                                                        <option>Select</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Product No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-4 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Product Description</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-2 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Planned Quantity</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Warehouse</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Priority
                                                </label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-4 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Roting Date Calculation</label>
                                                <div class="col-lg-8">
                                                     <select class="form-select samp-selct">
                                                        <option>Select</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            <!-- Toggle States Button -->
                                            <label class="col-form-label mt-6 font-size-20" for="val-skill">BMR</label>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Print</button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Re Print</button>
                                            <div class="col-lg-1"></div>
                                             <label class="col-form-label mt-6 font-size-20" for="val-skill">BPR</label>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Print</button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Re Print</button>
                                            <div class="col-lg-1"></div>
                                             <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off">Update Now</button>
                                        </div>

                                       </div>
                                    </div>
                                </div>
                                    <br><br>    
                             <div class="row">
                            <div class="col-xl-12">
                                <div class="card">                                
                                    <div class="card-body">
                                        
                                                <div class="table-responsive qc_list_table table_item_padding" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table_inline table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                                <th>No. </th>  
                                                                <th>Description</th>
                                                                <th>Base Qty</th>
                                                                <th>Base ratio</th> 
                                                                <th>Planned Qty</th> 
                                                                <th>Issued</th> 
                                                                <th>Available</th> 
                                                                <th>UOM Code</th> 
                                                                <th>UOM Name</th> 
                                                                <th>Warehouse</th> 
                                                                <th>Issued Method</th>  
                                                            </tr>
                                                        </thead>
                                                     <tbody>
                                                        <tr>
                                                            <td> 
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                             </td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                              <td class="desabled"></td>
                                                               <td class="desabled"></td>
                                                                <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td >
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                            </td>
                                                         </tr>

                                                          <tr>
                                                            <td> 
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                             </td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                              <td class="desabled"></td>
                                                               <td class="desabled"></td>
                                                                <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td >
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                            </td>
                                                         </tr>

                                                          <tr>
                                                            <td> 
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                             </td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                              <td class="desabled"></td>
                                                               <td class="desabled"></td>
                                                                <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td >
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                            </td>
                                                         </tr>

                                                          <tr>
                                                            <td> 
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                             </td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                              <td class="desabled"></td>
                                                               <td class="desabled"></td>
                                                                <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td >
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                            </td>
                                                         </tr>

                                                          <tr>
                                                            <td> 
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                             </td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                              <td class="desabled"></td>
                                                               <td class="desabled"></td>
                                                                <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td >
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                            </td>
                                                         </tr>

                                                          <tr>
                                                            <td> 
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                             </td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                            <td><input  type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                             <td class="desabled"></td>
                                                              <td class="desabled"></td>
                                                               <td class="desabled"></td>
                                                                <td class="desabled"></td>
                                                            <td ><input type="text" id="" name="" class="form-control"></td>
                                                            <td >
                                                                <select class="form-select samp-selct">
                                                                <option>Select</option>
                                                                 <option>...</option>
                                                                 </select>
                                                            </td>
                                                         </tr>

                                                        </tbody> 

                                                   </table>
                                               </div> 
                                          
                                            
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                                                        
                        </form>
                        </div><!--container-fluid-->
                    </div><!--page-content-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>

     <!--end qc check model-->

     <style type="text/css">
    .modal-body{padding: 0 !important;
     </style>
    }

   <script type="text/javascript">
(function ($) {

  $.fn.enableCellNavigation = function () {

    var arrow = {
      left: 37,
      up: 38,
      right: 39,
      down: 40
    };

    // select all on focus
    // works for input elements, and will put focus into
    // adjacent input or textarea. once in a textarea,
    // however, it will not attempt to break out because
    // that just seems too messy imho.
    this.find('input').keydown(function (e) {

      // shortcut for key other than arrow keys
      if ($.inArray(e.which, [arrow.left, arrow.up, arrow.right, arrow.down]) < 0) {
        return;
      }

      var input = e.target;
      var td = $(e.target).closest('td');
      var moveTo = null;

      switch (e.which) {

        case arrow.left:
          {
            if (input.selectionStart == 0) {
              moveTo = td.prev('td:has(input,textarea)');
            }
            break;
          }
        case arrow.right:
          {
            if (input.selectionEnd == input.value.length) {
              moveTo = td.next('td:has(input,textarea)');
            }
            break;
          }

        case arrow.up:
        case arrow.down:
          {

            var tr = td.closest('tr');
            var pos = td[0].cellIndex;

            var moveToRow = null;
            if (e.which == arrow.down) {
              moveToRow = tr.next('tr');
            } else if (e.which == arrow.up) {
              moveToRow = tr.prev('tr');
            }

            if (moveToRow.length) {
              moveTo = $(moveToRow[0].cells[pos]);
            }

            break;
          }

      }

      if (moveTo && moveTo.length) {

        e.preventDefault();

        moveTo.find('input,textarea').each(function (i, input) {
          input.focus();
          input.select();
        });

      }

    });

  };

})(jQuery);


// use the plugin
$(function () {
  $('#list').enableCellNavigation();
});


</script>



<?php include 'include/footer.php' ?>