<?php
require_once 'dbangelconnect.php';
$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {
$update_field='';
if(isset($input['qty'])) {
$update_field.= "qty='".$input['qty']."'";
}
if($update_field && $input['id']) {
$sql_query = "UPDATE keranjangrinci SET $update_field WHERE idbarang ='" . $input['idbarang'] . "'";
mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
}
}
?>