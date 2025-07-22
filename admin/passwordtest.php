<?php

$hash= password_hash(password:"Ad12",algo:PASSWORD_BCRYPT);
echo $hash;
echo "<br>hash length ".strlen($hash);

?>
