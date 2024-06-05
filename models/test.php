<html>
	<head>
	<title>Web Grid Using Arrow Key</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
<body>
		<h1>Web Grid Table</h1>
		<div id="abc" class="table_here" role="grid">
			<table class="table" border="1" style="width:50%; padding:15px;">
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Address</th>
				</tr>
				<tr role="row">
					<td role="gridcell" tabindex="0" aria-label="name" aria-describedby="f2_key">
						<input type="text" class="link" tabindex="-1" name="name" aria-label="name">
					</td>
					<td role="gridcell" tabindex="-1" aria-label="Email Id" aria-describedby="f2_key">
						<input type="text" class="link" tabindex="-1" name="email" aria-label="email">
					</td>
					<td role="gridcell" tabindex="-1" aria-label="Mobile Number" aria-describedby="f2_key">
						<input type="text" class="link" tabindex="-1" name="mob" aria-label="mobile">
					</td>
					<td role="gridcell" tabindex="-1" aria-label="Address" aria-describedby="f2_key">
						<input type="text" class="link" tabindex="-1" name="add" aria-label="address">
					</td>
					<p id="f2_key" style="display:none;" aria-hidden="true">Press F2 Key To Edit cell</p>
				</tr>
				<tr role="row">
					<td role="gridcell" tabindex="-1" aria-label="name" aria-describedby="f2_key">
						<input type="text" tabindex="-1" class="link" name="name">
					</td>
					<td role="gridcell" tabindex="-1" aria-label="Email Id" aria-describedby="f2_key">
						<input type="text" tabindex="-1" class="link" name="email">
					</td>
					<td role="gridcell" tabindex="-1" aria-label="Mobile Number" aria-describedby="f2_key">
						<input type="text" tabindex="-1" class="link" name="mob">
					</td>
					<td role="gridcell" tabindex="-1" aria-label="Address" aria-describedby="f2_key">
						<input type="text" tabindex="-1" class="link" name="add">
					</td>
				</tr>
								<tr role="row">
					<td role="gridcell" tabindex="-1" aria-label="name" aria-describedby="f2_key">
						<input type="text" tabindex="-1" class="link" name="name">
					</td>
					<td role="gridcell" tabindex="-1" aria-label="Email Id" aria-describedby="f2_key">
						<input type="text" tabindex="-1" class="link" name="email">
					</td>
					<td role="gridcell" tabindex="-1" aria-label="Mobile Number" aria-describedby="f2_key">
						<input type="text" tabindex="-1" class="link" name="mob">
					</td>
					<td role="gridcell" tabindex="-1" aria-label="Address" aria-describedby="f2_key">
						<input type="text" tabindex="-1" class="link" name="add">
					</td>
				</tr>
      </table>
    </div>
   </body>
</html>


<script type="text/javascript">
var currCell = $('td').first();
var editing = false;

// User clicks on a cell
$('td').click(function() {
    currCell = $(this);
    edit();
});

// Show edit box
function edit() {
    editing = true;
    currCell.toggleClass("editing");
    $('#edit').show();
    $('#edit #text').val(currCell.html());
    $('#edit #text').select();
}

// User saves edits
$('#edit form').submit(function(e) {
    editing = false;
    e.preventDefault();
    // Ajax to update value in database
    $.get('#', '', function() {
        $('#edit').hide();
        currCell.toggleClass("editing");
        currCell.html($('#edit #text').val());
        currCell.focus();
    });
});

// User navigates table using keyboard
$('table').keydown(function (e) {
    var c = "";
    if (e.which == 39) {
        // Right Arrow
        c = currCell.next();
    } else if (e.which == 37) { 
        // Left Arrow
        c = currCell.prev();
    } else if (e.which == 38) { 
        // Up Arrow
        c = currCell.closest('tr').prev().find('td:eq(' + 
          currCell.index() + ')');
    } else if (e.which == 40) { 
        // Down Arrow
        c = currCell.closest('tr').next().find('td:eq(' + 
          currCell.index() + ')');
    } else if (!editing && (e.which == 13 || e.which == 32)) { 
        // Enter or Spacebar - edit cell
        e.preventDefault();
        edit();
    } else if (!editing && (e.which == 9 && !e.shiftKey)) { 
        // Tab
        e.preventDefault();
        c = currCell.next();
    } else if (!editing && (e.which == 9 && e.shiftKey)) { 
        // Shift + Tab
        e.preventDefault();
        c = currCell.prev();
    } 

    // If we didn't hit a boundary, update the current cell
    if (c.length > 0) {
        currCell = c;
        currCell.focus();
    }
});

// User can cancel edit by pressing escape
$('#edit').keydown(function (e) {
    if (editing && e.which == 27) { 
        editing = false;
        $('#edit').hide();
        currCell.toggleClass("editing");
        currCell.focus();
    }
});
</script>


<style type="text/css">
* {
    font-size: 12px;
    font-family: 'Helvetica', Arial, Sans-Serif;
    box-sizing: border-box;
}

table, th, td {
    border-collapse:collapse;
    border: solid 1px #ccc;
    padding: 10px 20px;
    text-align: center;
}

th {
    background: #0f4871;
    color: #fff;
}

tr:nth-child(2n) {
    background: #f1f1f1;
}
td:hover {
    color: #fff;
    background: #CA293E;
}
td:focus {
    background: #f44;
}

.editing {
    border: 2px dotted #c9c9c9;
}

#edit { 
    display: none;
}
</style>