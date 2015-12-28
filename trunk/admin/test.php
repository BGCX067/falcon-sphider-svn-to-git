<p>
<?php
      $fhandle=fopen("../settings/conf.php","r+b");
      $oldContents=fread($fhandle,filesize("../settings/conf.php")); 
      $preg=preg_match_all("#admin=\"(.*)\".*admin_pw=\"(.*)\";#iUs",$oldContents,$arr,PREG_SET_ORDER);
      
      if(!$arr){
      $arr=array(array('defult','falcon','qq516974090'));
      }
        var_dump($arr);
        $auth=<<<AUTH
/*********************** 
User name and password settings 
***********************/
\$admin="{$arr[0][1]}";
\$admin_pw="{$arr[0][2]}";

AUTH;
     // fwrite($fhandle,$auth);
?>
</p>