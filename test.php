<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<select class="selectpicker" multiple data-live-search="true">
    <?php //for ($i=0; $i <20000 ; $i++) { ?>
        <option>Test - <?php //echo $i;?></option>
    <?php //} ?>
</select> -->

<?php
// // User se mail body lete hain
// $mail_body = "Yeh aapka email ka content hoga jo mail body me dikhayega.";

// // URL encode karte hain mail body ko taaki ye mailto link me sahi se set ho sake
// $encoded_body = urlencode($mail_body);

// // Mailto link create karte hain
// $mailto_link = "mailto:pawan.k@softcoresolutions.com?subject=Your Subject Here&body={$mail_body}";

// // HTML button display karte hain jo mailto link pe le jayega
// echo "<a href='{$mailto_link}'><button>Send Email via Outlook</button></a>";
?>

<?php 
// $response = array(
//     "cart_total" => 400,
//     "total_items" => 2,
//     "c0351df09a396e2db897222fd4efd6d5" => array(
//         "id" => 7,
//         "qty" => 1,
//         "price" => 200,
//         "name" => "pname",
//         "variant_id" => 13,
//         "options" => array(
//             "variant_id" => 13
//         ),
//         "rowid" => "c0351df09a396e2db897222fd4efd6d5",
//         "subtotal" => 200
//     ),
//     "062667abbd21e2796eb5b604fabfa7ee" => array(
//         "id" => 14,
//         "qty" => 1,
//         "price" => 200,
//         "name" => "pname",
//         "variant_id" => 27,
//         "options" => array(
//             "variant_id" => 27
//         ),
//         "rowid" => "062667abbd21e2796eb5b604fabfa7ee",
//         "subtotal" => 200
//     )
// );

// foreach ($response as $key => $value) {
//     $new_variable = array();
//     if ($key !== "cart_total" && $key !== "total_items") {
//         // $new_variable['id']=$value;
//         $tdata[$key]=$value;
//         $new_variable[] = $tdata;

//         echo '<pre>';
//         print_r($value);
//         echo '-------------------------------';
//     }
// }

// // Print the new variable to check the result
// // print_r($new_variable);

// $response = array(
//     "cart_total" => 400,
//     "total_items" => 2,
//     "c0351df09a396e2db897222fd4efd6d5" => array(
//         "id" => 7,
//         "qty" => 1,
//         "price" => 200,
//         "name" => "pname",
//         "variant_id" => 13,
//         "options" => array(
//             "variant_id" => 13
//         ),
//         "rowid" => "c0351df09a396e2db897222fd4efd6d5",
//         "subtotal" => 200
//     ),
//     "062667abbd21e2796eb5b604fabfa7ee" => array(
//         "id" => 14,
//         "qty" => 1,
//         "price" => 200,
//         "name" => "pname",
//         "variant_id" => 27,
//         "options" => array(
//             "variant_id" => 27
//         ),
//         "rowid" => "062667abbd21e2796eb5b604fabfa7ee",
//         "subtotal" => 200
//     )
// );

// $new_payload = array();

// foreach ($response as $key => $value) {
//     $new_payload = array();
//     if ($key !== "cart_total" && $key !== "total_items") {
//         $filtered_item = array(
//             "id" => $value["id"],
//             "qty" => $value["qty"],
//             "price" => $value["price"],
//             "name" => $value["name"],
//             "variant_id" => $value["variant_id"]
//         );
//         $new_payload = $filtered_item;
//         echo '<pre>';
//         print_r($new_payload);
//         echo '----------------';
//     }
// }

// Print the new payload to check the result
// print_r($new_payload);



?>
<?php
// function dateDifference($date1, $date2) {
//     $datetime1 = new DateTime($date1);
//     $datetime2 = new DateTime($date2);
//     $interval = $datetime1->diff($datetime2);

//     $years = $interval->y;
//     $months = $interval->m;
//     $days = $interval->d;

//     if ($years > 0) {
//         return $years . ' year' . ($years > 1 ? 's' : '');
//     } elseif ($months > 0) {
//         return $months . ' month' . ($months > 1 ? 's' : '');
//     } else {
//         return $days . ' day' . ($days > 1 ? 's' : '');
//     }
// }

// $date1 = '2024-07-01';
// $date2 = date('Y-m-d'); // Current date

// echo dateDifference($date1, $date2);

$priceRangs = ['8','1366','2725','4083','5442','6800','7000'];
?>

<?php  if(count($priceRangs)>0){ ?>
   <a class="shop-filter-toogle" href="">
      Price
      <i class="fi-rs-angle-small-down angle-down"></i>
      <i class="fi-rs-angle-small-up angle-up"></i>
   </a>
   <div class="shop-product-fillter-header">
      <div class="list-group">
         <div class="list-group-item">
            <input class="form-check-input price-range price" type="checkbox" onchange="filterByPrice(0,<?php echo current($priceRangs)?>);">
            <label class="form-check-label">
            <span> Less than Rs <?php echo current($priceRangs)?></span>
            </label>                      
         </div>
      </div>
      
      <?php for ($i=0; $i < count($priceRangs)/2; $i++) { ?>
         <div class="list-group">
            <div class="list-group-item">
               <input class="form-check-input price-range price" type="checkbox" onchange="filterByPrice(<?php echo $priceRangs[$i]?>,<?php echo $priceRangs[$i+1]?>);">
               <label class="form-check-label">
               <span> <?php echo $priceRangs[$i]?> To <?php echo $priceRangs[$i+1]?></span>
               </label>                      
            </div>
         </div>
      <?php } ?>

      <div class="list-group">
         <div class="list-group-item">
            <input class="form-check-input price-range price" type="checkbox" onchange="filterByPrice(<?php echo end($priceRangs)?>,100000);">
            <label class="form-check-label">
            <span> Greater than Rs <?php echo end($priceRangs)?></span>
            </label>                      
         </div>
      </div>

   </div>
<?php } ?>
