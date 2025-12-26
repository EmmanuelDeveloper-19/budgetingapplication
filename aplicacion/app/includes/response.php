<?php

$response = [];
$form = [];

if (isset($_SESSION['response'])) {
    $response = $_SESSION['response'];

    if (array_key_exists("data_form", $response)) {
        $form = $response['data_form'];
    }
    unset($_SESSION['response']);
}
if (!empty($data['update_data'])) {
    $form = $data['update_data'][0];
}

?>