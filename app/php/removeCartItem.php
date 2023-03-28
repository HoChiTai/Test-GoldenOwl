<?php 
session_start();

if (isset($_GET['id'])) {
    $id = floatval($_GET['id']);
    $cartItem = json_decode($_SESSION['cartItem'],true);

    foreach($cartItem as $index => $item) {

        if ($item['id'] == $id) {
            unset($cartItem[$index]);
            break;
        }
    }
    print_r($cartItem);
    $_SESSION['cartItem'] = json_encode($cartItem);
}

?>