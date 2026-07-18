<?php


function clean($data){

return htmlspecialchars(
trim($data)
);

}



function redirect($page){

header(
"location:$page"
);

exit();

}



?>