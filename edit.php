<?php

//edit.php

include('database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$data = array(
    ':usd_rate'  => $form_data->usd_rate,
    ':usd_total'  => $form_data->usd_total,
    ':inr_total'  => $form_data->usd_rate * $form_data->usd_total,
    ':id'    => $form_data->id
);

$query = "
 UPDATE tbl_sample 
 SET usd_rate = :usd_rate, usd_total = :usd_total, inr_total = :inr_total  
 WHERE id = :id
";

$statement = $connect->prepare($query);
if ($statement->execute($data)) {
    $message = 'Data Edited';
}

$output = array(
    'message' => $message
);

echo json_encode($output);
