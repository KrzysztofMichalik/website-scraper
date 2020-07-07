<?php

// headers 
// $headers = array('Product name', 'Card url', 'Image url', 'Price', 'Number of score', 'Number of stars');
// array of data
$data = array(
    'ProductsTitle' =>[],
    'UrlCard'      =>[],
    'ImageSrc'      =>[],
    'Price'         =>[],
    'Score'         =>[],
    'Stars'         =>[]
);
// $fh = fopen("file.csv", "w");
// fputcsv($fh, $headers);

$content = '';

ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);
include('simple_html_dom.php');

$html = new \simple_html_dom();

function connection(string $url) : string
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    try {        
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    } catch (Exception $e){
        return $e->getMessage();
    }
}

$response = connection("http://estoremedia.space/DataIT/");
$html->load($response);


/*
* get content of all pages.
*/
$numberOfPages = $html->find('li.page-item a');


foreach ($numberOfPages as $key => $value) {
    if($key < count($numberOfPages) - 1) {
        $pageNo = strip_tags($value);       
        $link = 'http://estoremedia.space/DataIT/' . 'index.php?page=' . $pageNo .'#';         
        $response = connection($link);
        $content.= $response;
    }
}

$html->load($content);
$productsTitles     = $html->find('.title');
$productsImages     = $html->find('.card-img-top');
$imagesSrc          = [];
$productsPrices     = $html->find('div.card-body h5');   
$prices             = [];
$productsScore      = $html->find('div.card-footer small');   
$numberOfStars      = [];
$numberOfScore      = [];

// Products Title & url

foreach ($productsTitles as $value) {
   
    $url = $value->href;
    $title = $value->{'data-name'};
    array_push($data['ProductsTitle'],  $title);
    array_push($data['UrlCard'], $url);
}
// Images
foreach ($productsImages as $value) {
    $src = $value->src;
    array_push($data['ImageSrc'], $src);    
}
// Price
foreach ($productsPrices as $value) {   
    $price = $value->innertext;
    array_push($data['Price'], $price);    
}

foreach ($productsScore as  $value) {
    $clearTags = (strip_tags($value ));
    $array = explode(';', $clearTags);
    $starsCounter = 0;
    $last_index = count($array) -1;
    for ($i=0; $i <= $last_index ; $i++) {         
        if($array[$i] == "&#9733") {
            $starsCounter ++;
        } elseif($i == $last_index) {
            $res = preg_replace("/[^0-9]/", "", $array[$i] );
            $numberOfScore[] = $res;
        }
    }
    
    $numberOfStars[] = $starsCounter;

}



// header('Content-Type: text/csv');
// header('Content-Disposition: attachment; filename="sample.csv"');

// $user_CSV[0] = array('Product name', 'Card url', 'Image url', 'Price', 'Number of score', 'Number of stars');

// // very simple to increment with i++ if looping through a database result 

// $user_CSV[1] = array('Quentin', 'Del Viento', 34);
// $user_CSV[2] = array('Antoine', 'Del Torro', 55);
// $user_CSV[3] = array('Arthur', 'Vincente', 15);

// $fp = fopen('php://output', 'wb');
// foreach ($user_CSV as $line) {
//     // though CSV stands for "comma separated value"
//     // in many countries (including France) separator is ";"
//     fputcsv($fp, $line, ',');
// }
// fclose($fp);
// var_dump($numberOfScore);

$html->clear();
unset($html);


var_dump($data);
?>


<!-- 
<div class="card h-100">                              
    <a href="product.php?id=2006622791">
        <img class="card-img-top" src="https://images-na.ssl-images-amazon.com/images/I/61s4XzZa00L._SL1010_.jpg" alt="">
    </a>                              
    <div class="card-body">                                  
        <h4 class="card-title">                                      
           <a href="product.php?id=2006622791" class="title" data-name="LG 49LH604V TV#:49 Zoll">LG 49LH604V TV#:49 Zoll</a>                                  
        </h4>
        <h5>$391,99</h5>
        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>                              
    </div>
    <div class="card-footer">
        <small class="text-muted">★★★☆☆ (2)</small>                              
    </div> 
</div> -->