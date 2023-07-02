<?php
require('./connect.php');
mysqli_query($connect,"DELETE `p`,`pa` FROM `product` `p` JOIN `size_to_product` `pa` ON `p`.`id_product` = `pa`.`id_product` AND `p`.`id_product` = '$_GET[id]'");