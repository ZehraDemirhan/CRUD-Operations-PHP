<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php require "db.php";


if(!empty($_POST) )
{
    //ADD OPERATION
    //$now =new DateTime();
   // $time=$now->format('Y-m-d');
  
    //var_dump($time);
    extract($_POST);
    if($addOne!=='')
    {
        $stmt=$db->prepare("INSERT INTO todo(action) VALUES (?)");
        $stmt->execute([$addOne]);

    }

}
//DELETE
if(isset($_GET['del']))
{
    $stmt=$db->prepare("DELETE FROM todo where id=? ");
    $stmt->execute([$_GET['del']]);
}

?>
<body>
    <?php
     try{
        $res=$db->query("select * from todo");
        $options=$res->fetchAll(PDO::FETCH_ASSOC);
        
    
    }catch(PDOException $ex)
    {
        die("selection errror!");
    
    }
    $optionCount=count($options);
    $count=1;
     if(isset($_GET['button']) && $optionCount !=0)
    {
        $number=rand(0,$optionCount-1);
        //var_dump($number);
        //var_dump($options);


   
   
   echo  "<div class='overlay'>";
      echo   "<div class='modal'>";
       echo   "<h1 class='modal__title'>My Suggestion &#x1f609;</h1>";
         echo    "<p class='modal__body'>{$options[$number]['action']}";
   
    echo "<a class='button' href='index.php'>OK</a>";
     echo    "</div>";
      echo  "</div>";
    }
   
   
    //var_dump($options);
    function isinset($addOne)
    {
        global $options;
        foreach($options as $option)
        {
            if($option['action']==$addOne)
            return 1;
        }

    }
    
    
    ?>
<div>

            <div class="header">
                <div class="container">
                    <h1 class="header__title">CTIS256 - Midterm #2</h1>
                    <h2 class="header__subtitle">by Your Name Surname</h2>
                </div>
            </div>
            <div class="container">
                <div>
                    <a href="?button=clicked" class="big-button">What should I do?</a>
                </div>
                <div class="widget">
                    <div>
                        <div class="widget-header">
                            <h3 class="widget-header__title">Your Options</h3>
                            <h3 class="widget-header__title"><?=$optionCount?></h3>
                        </div>
                        <div>
                            <p class="widget__message"><?=$optionCount==0? 'List is empty' :'' ?></p>
                            <?php foreach($options as $option): 
                                ;?>
                            <div class="option">
                                <p class="option__text"> <?=$count?>. <?=$option['action']?></p>
                                <a href='?del=<?=$options[$count-1]['id']?> 'class="button button--link option__trash">&#x1f5d1;</a>
                            </div>
                            <?php  $count++; 
                            endforeach ?>
                        </div>
                    </div>
                    <div>
                        <p class="add-option-error"> <?=isset($addOne) && $addOne =='' ?'Type some value': ''?></p> 
                        <p class="add-option-error"> <?=isset($addOne) && isinset($addOne) ?'Already Exists ': ''?></p> 
                        
                        <form class="add-option" action ="" method="post">
                            <input class="add-option__input" autocomplete="Off" type="text" name="addOne">
                                <button class="button">Add One</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       
</body>
</html>