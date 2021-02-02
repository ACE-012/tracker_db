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
    $name   = urldecode($_POST['name']);
    $email   = urldecode($_POST['email']);
    $password   = md5($email.urldecode($_POST['password']));
    $ip   = urldecode($_POST['ip']);
    $city   = urldecode($_POST['city']);
    $country   = urldecode($_POST['country']);
    $country_code   = urldecode($_POST['country_name']);
    $cipher = "aes-128-gcm";
    $fi = fopen($path1,"a+");
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
    $get="SELECT email , pass  FROM test6";
    $results=mysqli_query($conn,$get);
    if ($results->num_rows > 0) {
        while($row = $results->fetch_assoc()) {
            if (in_array($cipher, openssl_get_cipher_methods()))
            {
                if(hash_equals($row['email'],$email))
                {
                    $found=true;
                    if(hash_equals($password,$row['pass']))
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
            "\nEmail:".$email.
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
    fclose($fi);
