<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php require  "db.php"; 
$res=$db->query("select * from cart1");
$cart=$res->fetchAll(PDO::FETCH_ASSOC);




?>

<body>
    <table>
        <?php foreach($cart as $product):?>
            <tr>
            <td><?=$product['title']?></td>
            <td><?=$product['price']?></td>
            <td><?=$product['img']?></td>
            <td><?=$product['rate']?></td>
        
        </tr>
       
        <?php endforeach?>
    </table>
    <a href="index.php">Go Back</a>
</body>
</html>