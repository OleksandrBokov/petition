<?php
$baseUrl =  Yii::app()->getBaseUrl(true);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title> =?utf-8?Q?=F0=9F=93=A7?= <?=$data['title']?></title>
</head>
<body style="background: #fff;">
<table  align="center" border="0" cellpadding="0" cellspacing="0" style="
    width:650px;
    min-height: 600px;
    text-align: center;
    background:url(<?=$baseUrl?>/images/site/boll-img5.png) -50px 0 no-repeat,
               url(<?=$baseUrl?>/images/site/boll-img2.png) 50px 450px no-repeat,
               url(<?=$baseUrl?>/images/site/boll-img7.png) 30% 350px no-repeat,
               url(<?=$baseUrl?>/images/site/boll-img3.png) 70% 100px no-repeat;">
    <tbody>
        <?=$data['message']?>
    </tbody>
</table>

</body>
</html>