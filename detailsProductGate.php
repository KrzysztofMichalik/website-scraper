<?php
if(empty($_POST['source']) )
{
    die;
} 

$url = $_POST['source'];
include('simple_html_dom.php');
$html = new \simple_html_dom();

$data = array(
    'ProductsTitle' =>[],
    'UrlCard'       =>[],
    'ImageSrc'      =>[],
    'Price'         =>[],
    'Score'         =>[],
    'Stars'         =>[]
);



$response = connection($url);
$html->load($response);
$productPrice          = $html->find('div.card-body h5.price');   
$productPricePromo     = $html->find('div.card-body h5.price-old');   
$productPriceOld       = $html->find('div.card-body h5.price');   
// $productImage     = $html->find('.card-img-top')->src;
$productTitle     = $html->find('.title');
$productVariant   = $html->find('.variants div.box');
$productScore      = $html->find('div.card-footer small');   

if (!empty($productPrice) ){
    print $productPrice; 
} 

echo $productPrice ;
echo $productPricePromo ;
echo $productPriceOld ;
echo $productImage   ;
echo $productTitle  ;
echo $productVariant;
echo $productScore ;

if(!empty($productPricePromo)){print $productPricePromo; } 
if(!empty($productPriceOld)){print $productPriceOld; } 
if(!empty($productImage  )){print $productImage  ; } 
if(!empty($productTitle )){print $productTitle ; } 
if(!empty($productVarian)){print $productVarian;}
if(!empty($productScore)){print $productScore; } 


// // Stars & score
// foreach ($productsScore as  $value) {
//     $clearTags = (strip_tags($value ));
//     $array = explode(';', $clearTags);
//     $starsCounter = 0;
//     $last_index = count($array) -1;
//     for ($i=0; $i <= $last_index ; $i++) {         
//         if($array[$i] == "&#9733") {
//             $starsCounter ++;
//         } elseif($i == $last_index) {
//             $score = preg_replace("/[^0-9]/", "", $array[$i] );
//             array_push($data['Score'], $score);
            
//         }
//     }
//     array_push($data['Stars'], $starsCounter);
    
// }

// $outputArray = array();


// for($i=0; $i < count($data['ProductsTitle']); $i++) {
//     $array = [];
//     $array[] = $data['ProductsTitle'][$i];
//     $array[] = $data['UrlCard'][$i];
//     $array[] = $data['ImageSrc'][$i];
//     $array[] = $data['Price'][$i];
//     $array[] = $data['Score'][$i];
//     $array[] = $data['Stars'][$i];

//     array_push($outputArray, $array);


// }


// $output = fopen("file.csv","w");
// fputcsv($output, array('Title','Card Url','Image Url', 'Price', 'Score', 'Stars'));

// foreach ($outputArray as $key =>$row) {
//     fputcsv($output, $row);
//   }
  
// fclose($output);

// print 'The script has generated a file';