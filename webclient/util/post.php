<!DOCTYPE html>
<html>
<head>
    
</head>
<body>
    

<?php
if (isset($_POST["search"])) {
    echo $_POST['search'];
    
    
}
unset($_REQUEST);
?>
<form method="post">
    Name:  <input type="text" name="search" /><br />
    <!--<input type="submit" value="submit me!" />-->
</form>
 
</body>
</html>


