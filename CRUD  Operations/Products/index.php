<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<?php 
require "db.php";
if(!isset($_GET['pageNo']))
{
    $_GET['pageNo']=0;
}
try{
    extract($_GET);
    $startIndex=($pageNo)*3;
    $res=$db->query("select * from products limit $startIndex ,3");
    $products=$res->fetchAll(PDO::FETCH_ASSOC);
   // var_dump($products);

}catch(PDOException $ex)
{
    die("selection error");

}
if(isset($_GET['added']))
{
    $stmt=$db->prepare("INSERT INTO cart1(title,price,img,rate)VALUES (?,?,?,?)") ;
    $product=getProduct($_GET['added']);
   // var_dump($product);
    $stmt->execute([$product['title'],$product['price'],$product['image'],$product['rate']]);

}

$RightArrow=$pageNo+1;
$LeftArrow=$pageNo-1;




?>

<body>
<table>
            <tr>
                <td><a  href='?pageNo=<?=$LeftArrow?>'><img src='icon/prev.png'></a></td>
                <td class='product'>
                    <img src='img/<?=$products[0]['image']?>'><br><br>
                    <span class='title'><?=$products[0]['title']?></span><br>
                    <?php for($i=0;$i<$products[0]['rate'];$i++)
                    {
                        echo  "<img src='icon/full.jpg'>";
                    }
                    for($i=0;$i<5-$products[0]['rate'];$i++)
                    {
                        echo  "<img src='icon/empty.jpg'>";
                    }
                    ?>
                    <div class='price'>196.00 TL</div>
                    <div><a class='btn' href='?pageNo=<?=$pageNo?>&added=<?=$products[0]['id']?>'>Add</a></div>
                </td>
                
                <td class='product'>
                    <img src='img/<?=$products[1]['image']?>'><br><br>
                    <span class='title'><?=$products[1]['title']?></span><br>
                    <?php for($i=0;$i<$products[1]['rate'];$i++)
                    {
                        echo  "<img src='icon/full.jpg'>";
                    }
                    for($i=0;$i<5-$products[1]['rate'];$i++)
                    {
                        echo  "<img src='icon/empty.jpg'>";
                    }
                    ?>
                    <div class='price'>196.00 TL</div>
                    <div><a class='btn'href='?pageNo=<?=$pageNo?>&added=<?=$products[1]['id']?>'>Add</a></div>
                </td>
                
                <td class='product'>
                    <img src='img/<?=$products[2]['image']?>'><br><br>
                    <span class='title'><?=$products[2]['title']?></span><br>
                    <?php for($i=0;$i<$products[2]['rate'];$i++)
                    {
                        echo  "<img src='icon/full.jpg'>";
                    }
                    for($i=0;$i<5-$products[2]['rate'];$i++)
                    {
                        echo  "<img src='icon/empty.jpg'>";
                    }
                    ?>
                    <div class='price'>196.00 TL</div>
                    <div><a class='btn' href='?pageNo=<?=$pageNo?>&added=<?=$products[2]['id']?>'>Add</a></div>
                </td>
                <td><a href='?pageNo=<?=$RightArrow?>'><img src='icon/next.png'></a></td>
            </tr>
        </table>
        <div class='pages'>
            <a class='pageNo <?=$pageNo==0?'active':''?>'  href='?pageNo=0'>1</a>
            <a class='pageNo <?=$pageNo==1?'active':''?>' href='?pageNo=1'>2</a>
            <a class='pageNo <?=$pageNo==2?'active':''?> ' href='?pageNo=2'>3</a>
            <a class='pageNo <?=$pageNo==3?'active':''?> ' href='?pageNo=3'>4</a>
            <a class='pageNo <?=$pageNo==4?'active':''?>  'href='?pageNo=4'>5</a>
            <a class='pageNo<?=$pageNo==5?'active':''?>' href='?pageNo=5'>6</a>        
        </div>
        <div >
            <a class='btn' href="cart.php">Go to Cart</a>
        </div>
</body>
</html>