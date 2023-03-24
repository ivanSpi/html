<?php
session_start();
if (!isset($_SESSION['map']))
{
    $_SESSION['map'] = [];
}
const players = ["X","0"];
?>

<!DOCTYPE html>
<html>
<head>
<title>crestics</title>
<meta charset="utf-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<style>
    body{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        width: 1400;
    }
    body *
    {
        margin: 0 auto;
        text-align: center;
    }
    h2
    {
        padding: 20px;
    }
    .map
    {
        align-self: center;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        width: 60%;
    }
    .map *
    {
        font-size: 48px;
        flex: 33.33%;
        height: 200px;
    }
</style>
</head>
<body>
<h2>Crestics and nulics</h2>
<?php
$gameArr = $_SESSION['map'];
if(isset($_GET['starter'])){
    $_SESSION['game'] = true;
    $_SESSION['player'] = players[1];
    for ($ROW = 0; $ROW < 9; $ROW++)
    {
        $gameArr[$ROW]= "";
    }
}
if ($_SESSION['game']) Render($gameArr);
$_SESSION['map'] = $gameArr;

?>
<form method="get">
    <input class="btn btn-primary style="background-color:grey; font-size:48px;" type="submit" value="Start game" name="starter">
</form>
</body>
</html>

<?php
function Render(& $game)
{
    echo "<form class=\"map\" method=\"get\">";
    for ($ROW = 0; $ROW < 9; $ROW++)
    {
        if (isset($_GET["$ROW"]) && $game[$ROW] == "")
        {
            if ($_SESSION['player'] == players[0])
            {
                 $game[$ROW] = players[1];
            }
            else 
            {
                $game[$ROW] = players[0];
            }
            $_SESSION['player'] = $game[$ROW];
        }
    }
    $check = CheckOut($game);
    if ($check != null)
    {
        echo "<h2 style=\"position: absolute; margin-left: 1200px; font-size: 36px;\">Player " . $_SESSION['player']. " won!</h2>";
        $_SESSION['game'] = false;
         for ($ROW = 0; $ROW < 9; $ROW++)
         {
            $value = $game[$ROW];
             if (in_array($ROW,$check))
            {
                echo <<< MAP
                <input class="btn btn-light" style="background-color:yellow" name="$ROW" type="submit" disabled="true"  value=$value>
                MAP; 
            }
            else
            {
                echo <<< MAP
                <input class="btn btn-light" name="$ROW" type="submit" disabled="true"  value=$value>
                MAP; 
            }
         }
    }
    else
    { 
        for ($ROW = 0; $ROW < 9; $ROW++)
        {
             $value = $game[$ROW];
             echo <<< MAP
             <input class="btn btn-light" name="$ROW" type="submit" value=$value>
             MAP;
        }
    }  
        
}

function CheckOut(& $game)
{
    for ($i = 0 ; $i < 3; $i++)
    {
        if ($game[$i*3] == players[0] && $game[$i*3+1] == players[0] && $game[$i*3+2] == players[0])
        {
            return array($i*3,$i*3+1,$i*3+2);
        }
        else if ($game[$i*3] == players[1] && $game[$i*3+1] == players[1] && $game[$i*3+2] == players[1])
        {
            return array($i*3,$i*3+1,$i*3+2);
        }
        else if ($game[$i] == players[0] && $game[$i+3] == players[0] && $game[$i+6] == players[0] )
        {
            return array($i,$i+3,$i+6);
        }
        else if ($game[$i] == players[1] && $game[$i+3] == players[1] && $game[$i+6] == players[1] )
        {
            return array($i,$i+3,$i+6);
        }
    }
    if ($game[0] ==  players[0] && $game[4] == players[0] && $game[8] == players[0])
    {
        return array(0,4,8);
    }
    else if ($game[0] ==  players[1] && $game[4] == players[1] && $game[8] == players[1])
    {
        return array(0,4,8);
    }
    else if ($game[2] ==  players[0] && $game[4] == players[0] && $game[6] == players[0])
    {
        return array(2,4,6);
    }
    else if ($game[2] ==  players[1] && $game[4] == players[1] && $game[6] == players[1])
    {
        return array(2,4,6);
    }
    return null;
}

?>