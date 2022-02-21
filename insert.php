
<?php

//insert.php

include('database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));
$data = array(
    ':usd_rate'  => $form_data->usd_rate,
    ':usd_total'  => $form_data->usd_total,
    ':inr_total'  => $form_data->usd_rate * $form_data->usd_total
);

$query = "
 INSERT INTO tbl_sample 
 (usd_rate, usd_total,inr_total) VALUES 
 (:usd_rate, :usd_total,:inr_total)
";

$statement = $connect->prepare($query);

if ($statement->execute($data)) {
    $message = 'Data Inserted';
}

$output = array(
    'message' => $message
);

echo json_encode($output);

?>
