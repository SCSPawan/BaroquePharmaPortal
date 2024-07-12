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
// User se mail body lete hain
$mail_body = "Yeh aapka email ka content hoga jo mail body me dikhayega.";

// URL encode karte hain mail body ko taaki ye mailto link me sahi se set ho sake
$encoded_body = urlencode($mail_body);

// Mailto link create karte hain
$mailto_link = "mailto:pawan.k@softcoresolutions.com?subject=Your Subject Here&body={$mail_body}";

// HTML button display karte hain jo mailto link pe le jayega
echo "<a href='{$mailto_link}'><button>Send Email via Outlook</button></a>";
?>
