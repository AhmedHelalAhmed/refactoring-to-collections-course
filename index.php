<?php


function load_json($path)
{
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}

$products = load_json('data/products.json')['products'];

echo json_encode($products);
