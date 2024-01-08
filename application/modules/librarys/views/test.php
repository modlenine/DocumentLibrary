<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php 


$string = "#php test #jquery #ประกาศ อีกอัน #ประกาศบริษัท";

$string = convertHashtoLink2($string );
echo $string."<br>";

if(isset($_GET['tag'])){
    $expression = "/#+([ก-เa-zA-Z0-9_]+)/";
    $tag = preg_replace($expression, '', $_GET['tag']);
    echo $tag;
}
?>
    
</body>
</html>