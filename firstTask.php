<?php
include('simple_html_dom.php');

if (file_exists('file.csv')) {
    unlink('file.csv');
    echo "The file has been successfully deleted \n";
}

$data = array(
    'ProductsTitle' =>[],
    'UrlCard'       =>[],
    'ImageSrc'      =>[],
    'Price'         =>[],
    'Score'         =>[],
    'Stars'         =>[]
);

$content = '';

$html = new \simple_html_dom();


$files = glob('html/*.{html}', GLOB_BRACE);


if (empty($files)) {
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
    $numberOfPages = $html->find('li.page-item a');


    foreach ($numberOfPages as $key => $value) {
        if($key < count($numberOfPages) - 1) {
            $pageNo = strip_tags($value);       
            $link = 'http://estoremedia.space/DataIT/' . 'index.php?page=' . $pageNo .'#';         
            $response = connection($link);
            $content.= $response;
        }
    }
    
} else {

    $files = glob('html/*.{html}', GLOB_BRACE);
    
    foreach ($files as $file) {
        $content .= file_get_contents($file);
    }
}
/*
* get content of all pages.
*/


$html->load($content);
$productsTitles     = $html->find('.title');
$productsImages     = $html->find('.card-img-top');
$productsPrices     = $html->find('div.card-body h5');   
$productsScore      = $html->find('div.card-footer small');   

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
// Stars & score
foreach ($productsScore as  $value) {
    $clearTags = (strip_tags($value ));
    $array = explode(';', $clearTags);
    $starsCounter = 0;
    $last_index = count($array) -1;
    for ($i=0; $i <= $last_index ; $i++) {         
        if($array[$i] == "&#9733") {
            $starsCounter ++;
        } elseif($i == $last_index) {
            $score = preg_replace("/[^0-9]/", "", $array[$i] );
            array_push($data['Score'], $score);
            
        }
    }
    array_push($data['Stars'], $starsCounter);
    
}

$outputArray = array();


for($i=0; $i < count($data['ProductsTitle']); $i++) {
    $array = [];
    $array[] = $data['ProductsTitle'][$i];
    $array[] = $data['UrlCard'][$i];
    $array[] = $data['ImageSrc'][$i];
    $array[] = $data['Price'][$i];
    $array[] = $data['Score'][$i];
    $array[] = $data['Stars'][$i];

    array_push($outputArray, $array);


}


$output = fopen("file.csv","w");
fputcsv($output, array('Title','Card Url','Image Url', 'Price', 'Score', 'Stars'));

foreach ($outputArray as $key =>$row) {
    fputcsv($output, $row);
  }
  
fclose($output);

print 'The script has generated a file';