<?php require('./connect.php') ?>
<?php
$data = mysqli_query($connect, "SELECT * FROM `product` WHERE `id_product` = $_GET[id]");
$sizes = mysqli_query($connect, "SELECT * FROM `size` JOIN `size_to_product` ON `size`.`size` = `size_to_product`.`id_size` where `id_product` = $_GET[id];");
$countSize = mysqli_query($connect, "SELECT COUNT(*) FROM `size` JOIN `size_to_product` ON `size`.`size` = `size_to_product`.`id_size` where `id_product` = $_GET[id];");
?>
<div class="block-content">
    <?php while ($row = mysqli_fetch_assoc($data)) : ?>
        <div style="background-image:url(<?= $row['img'] ?>)" class="div_img"></div>
        <h3 class="my-3"><?= $row['title'] ?></h3>
        <div class="block-d d-flex flex-column my-3">
            <strong class="fs-3"><?= $row['price'] ?> руб</strong>
            <p>Цвет: <?= $row['color'] ?></p>
        </div>
        <?php $fetchCountSize = mysqli_fetch_array($countSize); ?>
        <?php $countSizeByThisProduct = $fetchCountSize[0]?>
        <?php if($countSizeByThisProduct > 0): ?>
        <div class="sizes d-flex flex-row gap-2 mb-5">
                <?php while ($rowZ = mysqli_fetch_assoc($sizes)) : ?>
                    
                    <div class="size d-flex flex-row gap-1">
                        <input id="<?= $rowZ['id_size'] ?>" type="radio" name="selected_size">
                        <label for="<?= $rowZ['id_size'] ?>"><?= $rowZ['id_size'] ?>EU</label>
                    </div>
                <?php endwhile; ?>
        </div>
            <button class="btn_buy">В корзину</button>
        <?php else: ?>
            <button disabled class="btn_buy">Нет в наличии</button>
        <?php endif; ?>
    <?php endwhile; ?>
</div>