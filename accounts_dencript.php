<?php
$path ='accounts.file';
$path1 ='ip.file';
    $name   = urldecode($_POST['name']);
    $name=trim($name);
    $password   = urldecode($_POST['password']);
    $ip   = urldecode($_POST['ip']);
    $city   = urldecode($_POST['city']);
    $country   = urldecode($_POST['country']);
    $country_code   = urldecode($_POST['country_name']);
    $cipher = "aes-128-gcm";
    $fh = fopen($path,"r");
    $fi = fopen($path1,"a+");
    $key="test";
    $iv = 12;
    $found=false;
    $dH=number_format(gmdate("H"));
    $delayH=5;
    $dM=number_format(gmdate("i"));
    $dS=number_format(gmdate("s"));
    $delayM=30;
    $H=$dH+$delayH;
    $M=$dM+$delayM;
    if($M>=60)
    {
        $M-=60;
        $H+=1;
    }
    $d="".$H.":".$M.":".$dS;
    while(!feof($fh))
    {
       if (in_array($cipher, openssl_get_cipher_methods()))
            {
            $ivlen = openssl_cipher_iv_length($cipher);
            $ciphertext = fgets($fh);
            if(strpos($ciphertext,"Name:")!== false)
            {
                $ciphertext=trim(str_replace("Name:","",$ciphertext));
                if(hash_equals($ciphertext,$name))
                {
                    $found=true;
                    $cipherpass = fgets($fh);
                    $cipherpass=str_replace("Password:","",$cipherpass);
                    $tagpass=fgets($fh);
                    $tagpass=str_replace("Password Tag:","",$tagpass);
                    $tagpass=trim($tagpass);
                    $original_plainpass = openssl_decrypt($cipherpass, $cipher, $key, $options=0, $iv, $tagpass);
                    $original_plainpass=trim($original_plainpass);
                    if(hash_equals($original_plainpass,$password))
                    {
                        fwrite($fi,"---------------------------\n".
                                    $name.
                                    "\nTime:".$d.
                                    "\nDate:".gmdate("d/m/Y").
                                    "\nIP:".$ip.
                                    "\nCity:".$city.
                                    "\nRegion:".$country.
                                    "\nCountry Name:".$country_code.
                                    "\nLogin Success\n");
                        print "login success";
                    }
                    else
                    {
                        fwrite($fi,"---------------------------\n".
                                    $name.
                                    "\nTime:".$d.
                                    "\nDate:".gmdate("d/m/Y").
                                    "\nIP:".$ip.
                                    "\nCity:".$city.
                                    "\nRegion:".$country.
                                    "\nCountry Name:".$country_code.
                                    "\nLogin Falied\n");
                        print "wrong pass";
                    }
                    break;
                }
            }
        }
    }
    if($found==false)
    {
        if(trim($name)=="")
        {                        
            fwrite($fi,"---------------------------\n".
            "\nTime:".$d.
            "\nDate:".gmdate("d/m/Y").
            "\nIP:".$ip.
            "\nCity:".$city.
            "\nRegion:".$country.
            "\nCountry Name:".$country_code.
            "\nLogin Attempt\n");
        }
        else
        {                        
            fwrite($fi,"---------------------------\n".
            $name.
            "\nTime:".$d.
            "\nDate:".gmdate("d/m/Y").
            "\nIP:".$ip.
            "\nCity:".$city.
            "\nRegion:".$country.
            "\nCountry:".$country_code.
            "\nLogin Attempt\n");
        }
        print "no account found";
    }
    fclose($fh);
    fclose($fi);
?>