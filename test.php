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

$response = array(
    "cart_total" => 400,
    "total_items" => 2,
    "c0351df09a396e2db897222fd4efd6d5" => array(
        "id" => 7,
        "qty" => 1,
        "price" => 200,
        "name" => "pname",
        "variant_id" => 13,
        "options" => array(
            "variant_id" => 13
        ),
        "rowid" => "c0351df09a396e2db897222fd4efd6d5",
        "subtotal" => 200
    ),
    "062667abbd21e2796eb5b604fabfa7ee" => array(
        "id" => 14,
        "qty" => 1,
        "price" => 200,
        "name" => "pname",
        "variant_id" => 27,
        "options" => array(
            "variant_id" => 27
        ),
        "rowid" => "062667abbd21e2796eb5b604fabfa7ee",
        "subtotal" => 200
    )
);

$new_payload = array();

foreach ($response as $key => $value) {
    $new_payload = array();
    if ($key !== "cart_total" && $key !== "total_items") {
        $filtered_item = array(
            "id" => $value["id"],
            "qty" => $value["qty"],
            "price" => $value["price"],
            "name" => $value["name"],
            "variant_id" => $value["variant_id"]
        );
        $new_payload = $filtered_item;
        echo '<pre>';
        print_r($new_payload);
        echo '----------------';
    }
}

// Print the new payload to check the result
// print_r($new_payload);


?>