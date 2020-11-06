<?php

require_once 'vendor/autoload.php';


// "100110101"

// 309

// 3*100 + 0*10 + 9*1


// 3*10^2+ 0*10^1 + 9*10^0

// "100110101"

// 1*2^8 + 0*2^7 + 0*2^6 + 1*2^5 + 1*2^4 + 0*2^3 + 1*2^2 + 0*2^1 + 1*2^0

// 309

// way one
function binaryToDecimal($binary)
{
    $total=0;
    $exponent= strlen($binary)-1;
    
    for ($i=0; $i<strlen($binary); $i++) {
        $decimal = $binary[$i]*(2**$exponent);

        $total+=$decimal;
        $exponent--;
    }

    return $total;
}





dd(binaryToDecimal("100110101"));
