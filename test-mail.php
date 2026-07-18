<?php

include "config/mail.php";

$link = "https://google.com";

if(
sendResetMail(
"geerthigakbk@gmail.com",
"LMS User",
$link
))
{
    echo "Mail Sent";
}
else
{
    echo "Mail Failed";
}