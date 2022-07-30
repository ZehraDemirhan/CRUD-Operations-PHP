<?php
   // No Validation in this example.

   // CONNECT to mysql server
   require "db.php" ;


   // DELETE a Game
   if ( isset($_GET["delete"])) {
       $id = $_GET["delete"] ;
       $game = getGame($id) ;
       try {
          $stmt = $db->prepare("DELETE FROM games where id = ?") ;
          $stmt->execute([$id]) ;
          $msg = "{$game["title"]} deleted" ;
       } catch(PDOException $ex) {
            gotoErrorPage();
       } 
   }

   // INSERT a Game
   if ( !empty($_POST)) {
       extract($_POST) ;
       try {
        $stmt = $db->prepare("INSERT INTO games (title, price, launch) VALUES (?,?,?)" ) ;
        $stmt->execute([$title, $price, $launch]) ;
        $msg = "$title (" . $db->lastInsertId() . ") added" ; 
       } catch(PDOException $ex) {
         gotoErrorPage();
       }
   }

   // READ all Games
   try {
       $rs = $db->query("select * from games") ;
       $games = $rs->fetchAll(PDO::FETCH_ASSOC) ;
   } catch( PDOException $ex) {
        gotoErrorPage();
   }

   // Edit Message
   if ( isset($_GET["edit"])) {
       $game = getGame($_GET["edit"]) ;
       $msg = "{$game["title"]} updated." ;
   }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game List App</title>
    <link rel="stylesheet" href="app.css">
    
</head>
<body>
    <h1>List of Games</h1>
    <form action="?" method="post">
        <table>
            <tr>
                <td colspan="2"><input type="text" name="title" placeholder="TITLE"></td>
                <td><input type="text" name="price" placeholder="PRICE"></td>
                <td><input type="date" name="launch" placeholder="LAUNCH"></td>
                <td>
                  <button type="submit" class="btn" title="Add">
                  <i class="fa-solid fa-plus"></i>
                  </button>
                </td>
            </tr>
            <tr>
                <th>ID</th>
                <th>TITLE</th>
                <th>PRICE</th>
                <th>LAUNCH</th>
                <th>Ops</th>
            </tr>
            <?php foreach( $games as $game) : ?>
            <tr>
                <td><?= $game["id"] ?></td>
                <td><?= $game["title"] ?></td>
                <td>$<?= $game["price"] ?> </td>
                <td><?= $game["launch"] ?></td>
                <td>
                    <a class="btn" href="?delete=<?= $game["id"] ?>" title="Delete"><i class="fa-solid fa-trash-can"></i></a>
                    <a class="btn" href="edit.php?id=<?= $game["id"] ?>" title="Edit"><i class="fa-solid fa-pen"></i></i></a>
                </td>
            </tr>
            <?php endforeach ?>    
            <tr>
                <td colspan="5">Rows: <?= $rs->rowCount() ?></td>
            </tr>
            
        </table>
    </form>
    <?php
       if ( isset($msg)) {
           echo "<p class='msg'>" , $msg, "</p>" ;
       }
    ?>
    
</body>
</html>