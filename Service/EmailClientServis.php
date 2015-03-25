<?php

namespace AsistentPlusPlus\Service;
require_once __DIR__.'\..\vendor\autoload.php';
use Mail;

class EmailClientServis {

    public static  function sendMail($mail){

        $header= EmailClientServis::getMailHeader();
        $driver='';
        $mail = new Mail();
        $mail->factory(driver);
        mail($mail.getTo(),$mail,getSubject(),$mail.getMessage(),$header);
    }

    private static  function getMailHeader(){


        return "something";
    }
} 