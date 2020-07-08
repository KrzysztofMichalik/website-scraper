<?php
require_once('../assets/simple_html_dom.php');
require_once('../assets/functions.php');

if(empty($_POST['source']) )
{
    die;
} 

// Get connected to choosen product card
$url = 'http://estoremedia.space/DataIT/'. $_POST['source'];
$html = new \simple_html_dom();
$response = connection($url);
$html->load($response);

// Variables to present data
$starsCounter;
$score;
$productPrice = $html->find('span.price');   
if(!empty($productPrice)){
    print 'Product Price: ' . $productPrice[0] . '</br>';
}

$productPricePromo = $html->find('span.price-promo');   
if(!empty($productPricePromo)){
    print 'Promo Price:' . $productPricePromo[0] . '</br>';
}

$productPriceOld = $html->find('del.price-old');   
if(!empty($productPriceOld)){
    print 'Old Price: ' . $productPriceOld[0] . '</br>';
}

$productImage = $html->find('.card-img-top');
if(!empty($productImage)){
    print 'Product img src:' . $productImage[0]->src . '</br>';
}

$productTitle = $html->find('.title');
if(!empty($productTitle)){
    print 'Product title: ' . $productTitle[0] . '</br>';
}

$productScore = $html->find('div.card-footer small');  

foreach ($productScore as  $value) 
{
    $clearTags = (strip_tags($value ));
    $array = explode(';', $clearTags);
    $starsCounter = 0;
    $last_index = count($array) -1;
    for ($i=0; $i <= $last_index ; $i++) 
    {         
        if($array[$i] == "&#9733") 
        {
            $starsCounter ++;
        } elseif($i == $last_index) 
        {
            $score = preg_replace("/[^0-9]/", "", $array[$i] );       
        }
    }    
}

print 'Product score: ' . $score . '<br>';
print 'Product stars: ' . $starsCounter;


