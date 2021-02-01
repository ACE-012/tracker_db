<?php
$path ='accounts.file';
$path1 ='ip.file';
     $fi = fopen($path1,"a+");
       $name   = urldecode($_POST['name']);
       $password   = urldecode($_POST['password']);
       $ip   = urldecode($_POST['ip']);
       $city   = urldecode($_POST['city']);
       $country   = urldecode($_POST['country']);
       $country_code   = urldecode($_POST['country_name']);
       $cipher = "aes-128-gcm";
       $fh = fopen($path,"a+");
       $fr=fopen($path,"r");
       $key="test";
       $iv = 12;
       $exist=false;
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
            fwrite($fi,"---------------------------\n".
            $name.
            "\nTime:".$d.
            "\nDate:".gmdate("d/m/Y").
            "\nIP:".$ip.
            "\nCity:".$city.
            "\nRegion:".$country.
            "\nCountry Name:".$country_code.
            "\nAccount Created\n");
            print "account created";
          }
     }
     else{
          print "account already exists";
          fwrite($fi,"---------------------------\n".
          $name.
          "\nTime:".$d.
          "\nDate:".gmdate("d/m/Y").
          "\nIP:".$ip.
          "\nCity:".$city.
          "\nRegion:".$country.
          "\nCountry Name:".$country_code.
          "\nAccount Not Created\n");
     }
     fclose($fh);
     fclose($fi);
