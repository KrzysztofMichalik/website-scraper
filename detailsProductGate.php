<?php
if(empty($_POST['source']) )
{
    die;
} 


$url = $_POST['source'];
include('simple_html_dom.php');
$html = new \simple_html_dom();

$response = connection($url);

$html->load($response);
$starsCounter;
$score;
$productPrice           = $html->find('span.price');   
if(!empty($productPrice)){
    print 'Product Price: ' . $productPrice[0] . '</br>';
}


$productPricePromo      = $html->find('span.price-promo');   
if(!empty($productPricePromo)){
    print 'Promo Price:' . $productPricePromo[0] . '</br>';
}

$productPriceOld        = $html->find('del.price-old');   
if(!empty($productPriceOld)){
    print 'Old Price: ' . $productPriceOld[0] . '</br>';
}

$productImage           = $html->find('.card-img-top');
if(!empty($productImage)){
    print 'Product img src:' . $productImage[0]->src . '</br>';
}

$productTitle           = $html->find('.title');
if(!empty($productTitle)){
    print 'Product title: ' . $productTitle[0] . '</br>';
}

$productScore           = $html->find('div.card-footer small');  
$json                   = $html->find("script[type='application/json']");

// Stars & score
foreach ($productScore as  $value) {
    $clearTags = (strip_tags($value ));
    $array = explode(';', $clearTags);
    $starsCounter = 0;
    $last_index = count($array) -1;
    for ($i=0; $i <= $last_index ; $i++) {         
        if($array[$i] == "&#9733") {
            $starsCounter ++;
        } elseif($i == $last_index) {
            $score = preg_replace("/[^0-9]/", "", $array[$i] );       
        }
    }    
}

print 'Product score: ' . $score . '<br>';
print 'Product stars: ' . $starsCounter;

var_dump($json);
foreach ($json as $key => $value) {
    echo($value);
}
