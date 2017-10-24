<!DOCTYPE html>
<html lang='zh-CN'>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>迈德医学V</title>
    <style>

    </style>
</head>
<body>
    <img src="{{ asset('resources/views/home/wechat/boarding') }}" style="width:100%;">
    <div style="position:absolute;top:15%;left:5%;width:60%;color:#F6F6F6">
        <img src="{{ $user->headimgurl }}" class="img-circle pull-left" style="width:36%;">
        <div class="pull-left" style="padding-left:20px;">
            <p>{{ $user->nickname }}</p>
            <p>送你一张学习机票</p>
        </div>
    </div>
</div>
</body>
</html>