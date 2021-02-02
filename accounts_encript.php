<?php
$path1 ='ip.file';
$servername = "localhost";
$username = "root";
$database="mytest";
$conn=mysqli_connect($servername,$username,"",$database);
if(!$conn)
{
     echo "unable to connect to database please try again later<br>";
     die(mysqli_connect_error());
}
     $fi = fopen($path1,"a+");
       $name   = urldecode($_POST['name']);
       $email   = urldecode($_POST['email']);
       $password   = md5($email.urldecode($_POST['password']));
       $ip   = urldecode($_POST['ip']);
       $city   = urldecode($_POST['city']);
       $country   = urldecode($_POST['country']);
       $country_code   = urldecode($_POST['country_name']);
       $cipher = "aes-128-gcm";
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
     $create="INSERT INTO `test6` (`Name`, `email`, `pass`, `data`) VALUES ("."'".$name."'".", "."'".$email."'".", "."'".$password."'".", '{\"Ben\":37,\"Joe\":43}')";
     $result=mysqli_query($conn,$create);
     if($result)
     {
          if (in_array($cipher, openssl_get_cipher_methods()))
          {
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
     fclose($fi);
