<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #main{border-collapse:collapse;
            margin:0 auto;


        }
       #main  tr:first-of-type{
            background-color:yellow;
        }
        #main td{
            border:1px solid black;
        }
        img{width:80px;}
        #big{
            width:400px;
        }
        #buy{
            border-collapse:collapse;
            margin:0 auto;
        }
        #buy tr{
            height:60px;
            border-bottom:1px solid grey !important;

        }
        #buy p{
            border-bottom:1px solid grey;
        }
        
        #buy img {margin:0 15px;}
        #buy tr:last-of-type{
            text-align:center;
        }
       
        #msg{
            background-color:rgba(10,10,10,0.2);
            border-radius:5px;
            width:200px;

            
        }

    </style>
</head>
<?php 

require "db.php";
try{
    $res=$db->query("select * from motorbikes");
    $bikes=$res->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($bikes);

}catch(PDOException $ex)
{
    die("select error");
}
if(isset($_GET['selectedbike']))
{
   
    $stmtPhoto=$db->prepare("select * from motorbike_photo where bike_id=?");
    $stmtPhoto->execute([$_GET['selectedbike']]);
    $photos=$stmtPhoto->fetchAll(PDO::FETCH_ASSOC);
   // var_dump($photos);

    $stmtInfo=$db->prepare("select * from motorbikes where id=?");
    $stmtInfo->execute([$_GET['selectedbike']]);
    $info=$stmtInfo->fetch(PDO::FETCH_ASSOC);
    //var_dump($info);

    //$stmt=$db->query("select * from motorbike_photo")
    if (!isset($_GET['img']))
    {
        $_GET['img']=$photos[0]['path'];
    }
    extract($_GET);



    //var_dump($photos);
    echo "<table id='buy'>";
    echo "<tr><td colspan=2><h2>",$info['title'],"</h2></td></tr>";
    echo "<tr>";
    echo "<td> <img  id='big' src='images/{$img}'</td>";
    echo "<td>",$info['price'] ." TL <br>";
  
    $keys=array_keys($info);
    foreach($keys as $key)
    {
     
        echo "<p>",$key." :".$info[$key],"</p>";
     
    }
    
   
    echo "<tr>";
    echo "<td colspan=2>";
    foreach($photos as $photo)
    {
        echo "<a href='?selectedbike={$_GET['selectedbike']}&img={$photo['path']}'> <img src='images/{$photo['path']}'></a>";
    }
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan=2>";

    echo "<a href=main.php> BACK </a>";
    echo "<a href=?selectedbike={$_GET['selectedbike']}&buy={$_GET['selectedbike']}> ADD TO CART </a>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

   // var_dump($_GET);
    if(isset($_GET['buy']))
    {
        try{
            
            $stmt=$db->prepare("INSERT INTO cart(Brand,Model,Price) VALUES (?,?,?)");
            $stmt->execute([$info['brand'],$info['model'],$info['price']]);
            $msg= "<p id='msg' > {$info['brand']} has added to the cart </p>";
            echo $msg;

            
        }catch(PDOExcepiton $ex)
        {
            die("insert error");
        }


    }


    exit;
}
?>
<body>
    <table id="main">
        <tr>
            <td></td>
            <td>Brand</td>
            <td>Model</td>
            <td>Title</td>
            <td>Price</td>
            <td>Discount</td>
            <td>Status</td>
        </tr>
        <?php foreach($bikes as $bike) :?>
           <tr>
            <td><a href="?selectedbike=<?=$bike['id']?>"><img src='images/<?=$bike['profile']?>'alt=""></a></td>
            <td><?=$bike['brand']?></td>
            <td><?=$bike['model']?></td>
            <td><?=$bike['title']?></td>
            <td><?=$bike['price']?></td>
            <td>YES</td>
            <td><?=$bike['status']?'SOLD':'On Sale'?></td>
           </tr>
           <?php endforeach ?>




    </table>
    
</body>
</html>