<?php
$path ='accounts.file';
       $name   = urldecode($_POST['name']);
       $password   = urldecode($_POST['password']);
       $cipher = "aes-128-gcm";
       $fh = fopen($path,"a+");
       $fr=fopen($path,"r");
       $key="test";
       $iv = 12;
       $exist=false;
       while(!feof($fr))
       {
          $checktext = fgets($fr);
          if(strpos($checktext,"Name:")!== false)
          {
               $checktext=trim(str_replace("Name:","",$checktext));
               if(hash_equals($checktext,$name))
               {
                    $exist=true;
                    break;
               }
          }
     }
     if($exist==false)
     {
          if (in_array($cipher, openssl_get_cipher_methods()))
          {
          $ivlen = openssl_cipher_iv_length($cipher);
            $cipherpassword = openssl_encrypt($password, $cipher, $key, $options=0, $iv, $tagpass);
            $totalaccount="-----------------------".
                         "\nName:".$name.
                         "\nPassword:".$cipherpassword.
                         "\nPassword Tag:".$tagpass."\n";
            fwrite($fh,$totalaccount);
            print $totalaccount;
          }
     }
     else{
          print "account already exists";
     }
     fclose($fh);
?>