<?php
session_start();
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Golden Sneaker</title>
    <link rel='icon' type='image/x-icon' href='./app/assets/favicon.ico'>
    <link rel='stylesheet' href='./app/css/styles.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js" defer></script>
    <script type="text/javascript" src="./app/js/main.js" defer></script>
</head>
<body>

    <?php
  
        // Read JSON data
        $jsonShoes = file_get_contents('./app/data/shoes.json');
        $shoesJsonData = json_decode($jsonShoes,true);
        $shoesData = $shoesJsonData['shoes'];


        // print_r($_SESSION['cartItem']);
        // session_destroy();
    ?>

    <main>
        <div class='card'>
            <div class='card__top'>
                <img src='./app/assets/nike.png' class='card__logo'/>
            </div>
            <div class='card__title'>Our Products</div>
            <div class='card__body'>
                <?php      
                    foreach($shoesData as $item) {

                        echo "
                            <div class='item'>
                                <div class='item__image' style='background-color: $item[color] '>
                                    <img src='$item[image]' />
                                </div>
                                <div class='iten__name'>
                                    $item[name]
                                </div>
                                <div class='item__description'>
                                    $item[description]
                                </div>
                                <div class='item__button'>
                                    <div class='price'>
                                        $$item[price]
                                    </div>
                                    ";
                            if (isset($_SESSION['cartItem'])) {
                                $cartItem = json_decode($_SESSION['cartItem'],true);
                                $flag = false;
                                foreach($cartItem as $index => $value) {
                                    if ($item['id'] == $value['id']) {
                                        $flag = true;
                                        break;
                                    }
                                }
                                
                                if ($flag) {
                                    echo "
                                    <button class='btn btn-add inactive'>
                                        <img src='./app/assets/check.png' class='check-icon'>
                                    </button>
                                     ";
                                } else {
                                    echo "
                                    <button class='btn btn-add' data-id=$item[id] data-color=$item[color] data-image=$item[image]
                                         data-name='$item[name]' data-price=$item[price]>
                                        ADD TO CART
                                    </button>
                                     ";
                                }
                            }  else {
                                echo "
                                    <button class='btn btn-add' data-id=$item[id] data-color=$item[color] data-image=$item[image]
                                        data-name='$item[name]' data-price=$item[price]>
                                        ADD TO CART
                                    </button>
                                    ";
                                }
                        echo "
                            </div>
                        </div>
                        ";
                    }
                ?>
                <!-- <div class='item'>
                    <div class='item__image' style='background-color: #e1e7ed'>
                        <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/1315882/air-zoom-pegasus-36-mens-running-shoe-wide-D24Mcz-removebg-preview.png' />
                    </div>
                    <div class='iten__name'>
                        Nike Air Zoom Pegasus 36
                    </div>
                    <div class='item__description'>
                        The iconic Nike Air Zoom Pegasus 36 offers more cooling and mesh that targets breathability across high-heat areas. A slimmer heel collar and tongue reduce bulk, while exposed cables give you a snug fit at higher speeds.
                    </div>
                    <div class='item__button'>
                        <div class='price'>
                            $108.97
                        </div>
                        <button class='btn btn_add'>
                            ADD TO CART
                        </button>
                    </div>
                </div> -->
            
            </div>
        </div>
        <div class='card'>
            <div class='card__top'>
                <img src='./app/assets/nike.png' class='card__logo'/>
            </div>

        <?php
            $sum = 0;
            if (isset($_SESSION['cartItem'])) {
                $cartItem = json_decode($_SESSION['cartItem'],true);
                foreach($cartItem as $index => $item) { 
                    $sum += $item['price'] * $item['count'];
                }
            }
           echo " <div class='card__title'>
                Your cart
                <span>$$sum</span>
            </div>";

        ?>
            <div class='card__body'>
                
                    <?php
                        if (isset($_SESSION['cartItem'])) {
                            $cartItem = json_decode($_SESSION['cartItem'],true);
                            foreach($cartItem as $index => $item) { 
                                echo "
                                <div class='cart-item'>
                                        <div class='cart-item__left'>
                                            <div class='cart-item__image' style='background-color: $item[color]'>
                                                <img src='$item[image]' />
                                            </div>
                                        </div>
                                        <div class='cart-item__right'>
                                            <div class='cart-item__name'>$item[name]</div>
                                            <div class='cart-item__price'>$$item[price]</div>
                                            <div class='cart-item__actions'>
                                                <div class='cart-item__count'>
                                                    <button class='btn cart-item-btn__decrease' data-id=$item[id] data-price=$item[price]>-</button>
                                                    <span class='count'>$item[count]</span>
                                                    <button class='btn cart-item-btn__increase' data-id=$item[id] data-price=$item[price]>+</button>
                                                </div>
                                                <button class='btn cart-item-btn__remove' data-id=$item[id] data-price=$item[price]>
                                                    <img src='./app/assets/trash.png'/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }
                        }
                    ?>

                <!-- <div class='cart-item'>
                    <div class='cart-item__left'>
                        <div class='cart-item__image' style='background-color: #e1e7ed'>
                            <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/1315882/air-zoom-pegasus-36-mens-running-shoe-wide-D24Mcz-removebg-preview.png' />
                        </div>
                    </div>
                    <div class='cart-item__right'>
                        <div class='cart-item__name'>Nike Air Zoom Pegasus 36</div>
                        <div class='cart-item__price'>$108.97</div>
                        <div class='cart-item__actions'>
                            <div class='cart-item__count'>
                                <button class='btn cari-item__decrease'>-</button>
                                <span>1</span>
                                <button class='btn cari-item__increase'>+</button>
                            </div>
                            <button class='btn cari-item__remove'>
                                <img src='./app/assets/trash.png'/>
                            </button>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
    </main>
</body>
</html>