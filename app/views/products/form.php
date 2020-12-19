<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="/product" method="post" enctype='multipart/form-data'>
    <div>
        <label for="name">Tên sản phẩm:</label><br>
        <input type="text" name="name" id="name" /><br>
    </div>
    <div>
        <label for="lname">Giá sản phẩm:</label><br>
        <input type="text" name="price" id="price" />
    </div>
    <div>
        <label>Upload ảnh</label>
        <input type="file" name="image" id="image"/>
    </div>
    <input type="submit" value="Gửi">
</form>
</body>
</html>
