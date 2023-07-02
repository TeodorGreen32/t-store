<?php 
require('./connect.php');

$title = trim(strip_tags(htmlspecialchars($_POST['title'])));
$img = trim(strip_tags(htmlspecialchars($_POST['url-img'] ?: "https://banner2.cleanpng.com/20180423/eaq/kisspng-royalty-free-no-symbol-5add84ba4c1804.9946209815244668743117.jpg")));
$color = trim(strip_tags(htmlspecialchars($_POST['color'] ?: "Незивестный цвет")));
$price = trim(strip_tags(htmlspecialchars($_POST['price'])));
$category = trim(strip_tags(htmlspecialchars($_POST['category'])));
mysqli_query($connect,"INSERT INTO `product`(`title`, `img`, `price`, `color`, `category`) VALUES ('$title','$img','$price','$color','$category')");
$idData = mysqli_query($connect,"SELECT `id_product` from `product` where `title` like '$title'");
$id = mysqli_fetch_assoc($idData)['id_product'];
foreach($_POST as $i=>$key){
    if(preg_match('/size/',$i)){
        echo $key;
        mysqli_query($connect,"INSERT INTO `size_to_product`(`id_product`, `id_size`) VALUES ('$id','$key')");
        
    }
}



?>