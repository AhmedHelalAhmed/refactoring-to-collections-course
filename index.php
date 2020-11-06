<?php

require_once 'vendor/autoload.php';

function load_json($path)
{
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}

$products = collect(load_json('data/products.json')['products']);

// echo json_encode($products);

// old way
/*
foreach ($products as $product) {
    if ($product['product_type']=='Lamp' || $product['product_type']=='Wallet') {
        foreach ($product['variants'] as $variant) {
            $totalCost+=$variant['price'];
        }
    }
}
*/


$lampsAndWallets=$products->filter(function ($product) {
    return collect(['Lamp','Wallet'])->contains($product['product_type']);
});


$prices=[];

foreach ($lampsAndWallets as $product) {
    foreach ($product['variants'] as $variant) {
        $prices[]=$variant['price'];
    }
}
$totalCost=0;

foreach ($prices as $price) {
    $totalCost+=$price;
}





var_dump($totalCost);// 985.52
