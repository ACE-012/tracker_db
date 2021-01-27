<?php
$path ='accounts.file';
$fh = fopen($path,"r");
for($i=0;$i<5;$i++)
    {
    print fgets($fh)."<br />";
}
fclose($fh);
?>