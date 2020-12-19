<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .list li {
            background: url("https://bradfrost.github.com/this-is-responsive/patterns/images/icon_arrow_right.png") no-repeat 97% 50%;
            border-bottom: 1px solid #ccc;
            display: table;
            border-collapse: collapse;
            width: 100%;
        }

        .inner {
            display: table-row;
            overflow: hidden;
        }

        .li-img {
            display: table-cell;
            vertical-align: middle;
            width: 30%;
            padding-right: 1em;
        }

        .li-img img {
            display: block;
            width: 100%;
            height: auto;
        }

        .li-text {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }

        .li-head {
            margin: 0;
        }

        .li-sub {
            margin: 0;
        }

        @media all and (min-width: 45em) {
            .list li {
                float: left;
                width: 50%;
            }
        }

        @media all and (min-width: 75em) {
            .list li {
                width: 33.33333%;
            }
        }
    </style>
</head>
<body>
<!--Pattern HTML-->
<div id="pattern" class="pattern">
    <ul class="list img-list">
        <?php
        if (isset($product) && count($product)) {
            foreach ($product as $item) {
                ?>
                <li>
                    <a href="/product?id=<?= $item['id'] ?>" class="inner">
                        <div class="li-img">
                            <img src="uploads/<?= $item['image'] ?>"
                                 alt="Image Alt Text"/>
                        </div>
                        <div class="li-text">
                            <h4 class="li-head"><?= $item['name'] ?></h4>
                            <p class="li-sub">Giá tiền: <?= number_format($item['price'],0,",","."); ?> VNĐ</p>
                        </div>
                    </a>
                </li>
                <?php
            }
        }
        ?>
    </ul>
</div>
</body>
</html>