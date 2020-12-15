<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
<div id="box">

</div>
</body>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    const spanRed = (str) => {
        return `<span class="color-red">${str}</span>`;
    };

    const zoomToString = (str) => {
        return `<span class="size-20">${str}</span>`;
    }
    const hoverTitle = () => {
        $("h3").hover(
            function () {
                $(this).append($("<span> đã hover</span>"));
            }, function () {
                $(this).find("span").last().remove();
            }
        );
    };
    const loadData = () => {
        $.get("post.php", (data) => {
            const datas = JSON.parse(data);
            if (datas.data.length) {
                let html = '';
                datas.data.map((items) => {
                    let title = items.title;
                    title = title.replace("Ronaldo", spanRed('Ronaldo'));
                    title = title.replace("Messi", spanRed('Messi'));
                    html += '<div class="items" style="margin-bottom: 20px; background-color: aquamarine; display: flex">';
                    html += '<img src="' + items.image + '">';
                    html += '<div style="margin-left: 20px ">';
                    html += '<h3>';
                    html += title;
                    html += '</h3>';
                    html += '<p class="color-red">';
                    html += items.description.replace("Champions", zoomToString('Champions'));
                    html += '</p>';
                    html += '<a href="' + items.link + '">Xem thêm</a>';
                    html += '</div>';
                    html += '</div>';
                });
                $('#box').html(html);
                hoverTitle();
            }
        });
    };

    $(() => {
        loadData();
        setInterval(() => {
            loadData();
        }, 30000)

    });
</script>
</html>