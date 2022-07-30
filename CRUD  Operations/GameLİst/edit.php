<?php
   require "db.php" ;

   if ( !empty($_POST)) {
       extract($_POST) ;
       try {
         $stmt = $db->prepare("UPDATE games SET title= :title , price = :price, launch = :launch  WHERE id = :id") ;
         $stmt->execute(["id" => $id, "title" => $title, "price" => $price, "launch" => $launch ]) ;
         header("Location: index.php?edit=$id") ;
         exit ;
       } catch(PDOException $ex) {
           gotoErrorPage() ;
       }
   }


   $id = $_GET["id"] ;
   try {
     $stmt = $db->prepare("SELECT * FROM games WHERE id = ?") ;
     $stmt->execute([$id]) ;
     $game = $stmt->fetch(PDO::FETCH_ASSOC) ;
   } catch( PDOException $ex) {
        gotoErrorPage() ;
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>
    <h1>Edit Game</h1>
    <form action="" method="post">
        <table>
            <tr>
                <td>ID</td>
                <td>
                   <?= $game["id"] ?>
                   <input type="hidden" name="id" value="<?= $game["id"] ?>">
                </td>
            </tr>
            <tr>
                <td>TITLE</td>
                <td>
                    <input type="text" name="title" value="<?= $game["title"] ?>">
                </td>
            </tr>
            <tr>
                <td>PRICE</td>
                <td>
                    <input type="text" name="price" value="<?= $game["price"] ?>">
                </td>
            </tr>
            <tr>
                <td>LAUNCH</td>
                <td>
                    <input type="date" name="launch" value="<?= $game["launch"] ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                   <button type="submit" class="btn">
                   <i class="fa-solid fa-rotate-right"></i>
                   </button>
                </td>
            </tr>
            
        </table>
    </form>
</body>
</html>