<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <script src="./app.js"></script>
    <title>Chat app</title>
  </head>
  <body>

<?php
$file = fopen('file.csv', 'r');
$productsArray = [];
while (($line = fgetcsv($file)) !== FALSE) {
  $productsArray[] = $line;
}
fclose($file);


print "<table style='width:100%;'>";
for($i = 0; $i < count($productsArray); $i++){
    if($i == 0) {
        print "<tr>";
        foreach ($productsArray[$i] as $key => $value) {
            print "<th>". $value . "<th>";
        }
        print "</tr>";        
      } else {
        print "<tr>";
        foreach ($productsArray[$i] as $key => $value) {
          if($key == 0 || $key == 1) {
            print "<th><button data-toggle='modal' data-target='#exampleModal' class='triger' data-link='". $productsArray[$i][1]. "'>". $value . "</button><th>";
          } else {

            print "<td>". $value . "<td>";
          }
        }
        print "</tr>";        
    }
}
?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  </body>
</html>