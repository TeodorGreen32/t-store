<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src='./functions.js'></script>
</head>
<?php require('./connect.php') ?>
<body>

    <?php if (isset($_GET['admin'])) : ?>
        <div class="admin">
            <form action="./index.php" METHOD="POST">
                <input autocomplete="none" name="login" type="text" placeholder="login" required>
                <input autocomplete="none" name="password" type="password" placeholder="password" required>
                <input type="submit" value="login">
            </form>
        </div>
    <?php endif; ?>
    <?php if (isset($_POST['login']) && isset($_POST['password'])) : ?>
        <?php require('./config.php') ?>
        <?php if ($_POST['login'] == $login) : ?>
            <?php if ($_POST['password'] == $password) : ?>
                <?php $number = 0; ?>
                
                <div class="admin-open">
                    <form send-function="ajax-admin" action="./addProduct.php" method="post">
                        <input type="text" name='title' placeholder="title" required>
                        <input type="text" name='url-img' placeholder="url-img">
                        <input type="text" name='color' placeholder="color">
                        <input type="text" name='price' placeholder="price" required>
                        <select name="category" id="">
                            <?php $category = mysqli_query($connect, "SELECT * FROM `category`") ?>
                            <?php while ($catRow = mysqli_fetch_assoc($category)) : ?>
                                <option value="<?= $catRow['category_name'] ?>"><?= $catRow['category_name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="size">
                            <?php for ($i = 35; $i <= 45; $i++) : ?>
                                <div name="size-box" class="size-box">
                                    <input id="<?= $i ?>" name="size-<?= $i ?>" value="<?= $i ?>" type="checkbox">
                                    <label for="<?= $i ?>"><?= $i ?> EU</label>
                                </div>
                            <?php endfor; ?>
                        </div>
                        <input type="submit" value="Добавить товар">
                    </form>
                </div>
            <?php else : ?>
                <script>
                    alert("invalid password")
                    <?php $_POST = array(); ?>
                </script>
            <?php endif; ?>
        <?php else : ?>
            <script>
                alert("invalid user")
            </script>
            <?php $_POST = array(); ?>
        <?php endif; ?>
    <?php endif; ?>



    
    <header>
        <div class="container-sm">
            <div class="nav-bar d-flex justify-content-between align-items-center">
                <div class="logo">T-Store</div>
                <nav>
                    <ul class="d-none d-md-block">
                        <li>Огромные скидки</li>
                        <li>Новинки Весна-Лето 2023</li>
                        <li>О нас</li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="modal fade" id="exampleModalLive" tabindex="-1" aria-labelledby="exampleModalLiveLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">T-Store</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_GET['id_data'])) : ?>
                        <div style="background-image:url()" class="img_div">1</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <main>

        <div class="container-sm">
            <div class="row">
                <div class="col-3">
                    <div class="menu">
                        <div class="sort-menu">
                            <a href="/?sort_mode=price_asc&filter_mode=<?php if (isset($_GET['filter_mode'])) echo $_GET['filter_mode']; ?>"><button>Цена<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="Edit / Sort_Descending">
                                            <path id="Vector" d="M4 17H16M4 12H13M4 7H10M18 13V5M18 5L21 8M18 5L15 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg></button></a>
                            <a href="/?sort_mode=price_desc&filter_mode=<?php if (isset($_GET['filter_mode'])) echo $_GET['filter_mode']; ?>"><button>Цена<svg width="20px" height="20px" viewBox="0 0 24 24" fill="#7c88a7" xmlns="http://www.w3.org/2000/svg">
                                        <g id="Edit / Sort_Ascending">
                                            <path id="Vector" d="M4 17H10M4 12H13M18 11V19M18 19L21 16M18 19L15 16M4 7H16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg></button></a>
                        </div>

                        <div class="filter-menu">
                            <a class="item" data="all" href="/?filter_mode=all&sort_mode=<?php if (isset($_GET['sort_mode'])) echo $_GET['sort_mode']; ?>">Все</a>
                            <a class="item" data="ked" href="/?filter_mode=ked&sort_mode=<?php if (isset($_GET['sort_mode'])) echo $_GET['sort_mode']; ?>">Кеды</a>
                            <a class="item" data="kon" href="/?filter_mode=kon&sort_mode=<?php if (isset($_GET['sort_mode'])) echo $_GET['sort_mode']; ?>">Конверсы</a>
                            <a class="item" data="sli" href="/?filter_mode=sli&sort_mode=<?php if (isset($_GET['sort_mode'])) echo $_GET['sort_mode']; ?>">Слипоны</a>
                        </div>
                    </div>
                </div>

                <?php

                $sort_list = [
                    'price_asc'  => '`price`',
                    'price_desc' => '`price` DESC',
                ];
                $filter_list = [
                    'ked' => "Кеды",
                    'kon' => "Конверсы",
                    'sli' => "Слипоны"
                ];

                if (isset($_GET['sort_mode']) && $_GET['sort_mode'] != "") {
                    if (array_key_exists($_GET['sort_mode'], $sort_list)) {
                        $sort = $sort_list[$_GET['sort_mode']];
                        $data = mysqli_query($connect, "SELECT * FROM `product` ORDER BY $sort");
                    }
                } else {
                    $data = mysqli_query($connect, "SELECT * FROM `product`");
                }
                if (isset($_GET['filter_mode']) && $_GET['filter_mode'] != "all") {
                    if (array_key_exists($_GET['filter_mode'], $filter_list)) {
                        if (isset($_GET['sort_mode']) && $_GET['sort_mode'] != "") {
                            if (array_key_exists($_GET['sort_mode'], $sort_list)) {
                                $filter = $filter_list[$_GET['filter_mode']];
                                $data = mysqli_query($connect, "SELECT * FROM `product` WHERE `category` LIKE '$filter' ORDER BY $sort");
                            }
                        } else {
                            $filter = $filter_list[$_GET['filter_mode']];
                            $data = mysqli_query($connect, "SELECT * FROM `product` WHERE `category` LIKE '$filter'");
                        }
                    }
                }

                ?>

                <div class="col-9">
                    <div class="wrapper-product">
                        <?php while ($row = mysqli_fetch_assoc($data)) : ?>
                            <div class="item">
                                <div onclick="openModalProduct(<?= $row['id_product'] ?>)" style="background-image:url(<?= $row['img'] ?>)" class="img_div"></div>
                                <div onclick="openModalProduct(<?= $row['id_product'] ?>)" class="description">
                                    <div class="title"><?= $row['title'] ?></div>
                                    <div class="price"><strong> <?= $row['price'] ?> руб </strong></div>
                                </div>
                                <button onclick="openModalProduct(<?= $row['id_product'] ?>)">Подробнее</button>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <script>
                    document.querySelectorAll('.filter-menu a').forEach((el, index) => {
                        el.classList.remove('pressed')
                        el.classList.remove('pressed-last')
                        el.classList.remove('pressed-first')

                        if (el.getAttribute('data') == '<?= $_GET['filter_mode'] ?>') {
                            if (index + 1 == document.querySelectorAll('.filter-menu a').length || index == 0) {
                                if (index + 1 == document.querySelectorAll('.filter-menu a').length) {
                                    el.classList.add('pressed-last')
                                } else {
                                    el.classList.add('pressed-first')
                                }
                            } else {
                                el.classList.add('pressed')
                            }


                        }
                    })
                </script>

            </div>
        </div>

    </main>


    <!-- con lib -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./admin/style.css">
    <script src="./admin/script.js"></script>
    
    <script>
        sendAdminForm()
    </script>
</body>

</html>