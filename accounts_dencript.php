<?php
$path ='accounts.file';
    $name   = urldecode($_POST['name']);
    $name=trim($name);
    $password   = urldecode($_POST['password']);
    $cipher = "aes-128-gcm";
    $fh = fopen($path,"r");
    $key="test";
    $iv = 12;
    $found=false;
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
                        print "login success";
                    }
                    else
                    {
                        print "wrong pass";
                    }
                    break;
                }
            }
        }
    }
    if($found==false)
    {
        print "no account found";
    }
    fclose($fh);
?>