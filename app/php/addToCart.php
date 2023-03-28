<?php 
session_start();

$cart = new stdClass();
if (isset($_GET['id'])) {
    $cart->id = floatval($_GET['id']);

}
if (isset($_GET['color'])) {
    $cart->color = $_GET['color'];
}
if (isset($_GET['image'])) {
    $cart->image = $_GET['image'];
}
if (isset($_GET['name'])) {
    $cart->name = $_GET['name'];
}
if (isset($_GET['price'])) {
    $cart->price = floatval($_GET['price']);
}
if (isset($_GET['count'])) {
    $cart->count = floatval($_GET['count']);
}

$cartItem = [];

if (isset($_SESSION['cartItem'])) {

    $cartItem = json_decode($_SESSION['cartItem'],true);
    $flag =  false;

    foreach($cartItem as $index => $item) {

        if ($item['id'] == $cart->id) {
            print_r($item['id']);
            $flag = true;
            $cartItem[$index]['count'] += $cart->count;
            if ($cartItem[$index]['count'] == 0) {
                unset($cartItem[$index]);
            }
            break;
        }
    }

    if (!$flag) {
        array_push($cartItem,(array)$cart);
    }

    print_r($cartItem);
    
    $_SESSION['cartItem'] = json_encode($cartItem);

} else {
    array_push($cartItem,(array)$cart);
    print_r($cartItem);
    $_SESSION['cartItem'] = json_encode($cartItem);
}


?>