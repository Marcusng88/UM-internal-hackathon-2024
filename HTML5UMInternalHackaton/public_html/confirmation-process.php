<?php
    $delivery = $_POST['delivery'];
    $cutlery = $_POST['cutlery_conf'];

    if(isset($_POST['delivery_confirmation'])){
        $spot = $_POST['delivery_confirmation'];
        $data = array(
            'delivery'  => $delivery,
            'spot'      => $spot,
            'cutlery'   => $cutlery
        );
    }else{
        $data = array(
            'delivery'  => $delivery,
            'cutlery'   => $cutlery
        );
    }

    header('Location: summary.php?'.http_build_query($data));
?>