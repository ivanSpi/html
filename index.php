<?php 
session_start();
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}
const limit = 10;
?>
<!DOCTYPE html>
<html>
<head>
<title>calculator</title>
<meta charset="utf-8">
</head>
<body>
<h2>Calculator</h2>
<?php
$history = $_SESSION['history'];
if (isset($_GET['result']) && !empty($_GET['function']))
{
    $function = $_GET['function'];
    if(preg_match("/[a-z]/i", $function))
    {
        echo "UNCORRECT INPUT";
    }
    else
    {
        $i = 1;
        while(isset($history[$i]))
        {
            $i++;
        }
        if ($i > limit)
        {
            for ($j = 1; $j <= 9; $j++)
            {
                $history[$j] = $history[$j+1];
            }
            $i--;
        }
        $history[$i] = $function . " = " . eval("return $function ;");
        $_SESSION['history'] = $history;
        eval("echo \"<h1>\" . $function . \"</h1>\";");
    }
}

echo "<table>";
foreach ($history as $key => $value)
{
    echo "<tr><td>";
    echo $key . "  )";
    echo "</td>";
    echo "<td>";
    echo $value;
    echo "</td></tr>";
}
echo "</table>";
if (isset($_GET['clear']))
{
    session_destroy();
}
?>
<form method="get">
<p>Your problem: <input type="text" name="function" /></p>
<input type="submit" value="Result" name="result">
<input type="submit" value="Clear history" name="clear">
</form>
</body>
</html>