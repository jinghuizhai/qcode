<?php
    include 'phpqrcode.php';  
    /*生成二维码函数
    *@param $url 二维码指向的地址
    *@param $name 生成图片的名称
    *@param $dir 生成图片的路径
    *@param $logo logo的绝对路径（包含图片名）
    *@param $level 生成图片的大小（缩放倍数）
    */
    function createQcode($url,$name,$logo,$dir,$size){
        $errorCorrectionLevel = 'L';//容错级别 
        //生成二维码图片
        $imgname = $dir.'/'.$name.'.png';
        $logoname = $name.'logo.png';
        QRcode::png($url,$imgname,$errorCorrectionLevel, $size, 2); 
        // $logo = $name.'logo.png';//准备好的logo图片
        $QR = $imgname;//已经生成的原始二维码图 
          
        if ($logo !== FALSE){
            $QR = imagecreatefromstring(file_get_contents($QR)); 
            $logo = imagecreatefromstring(file_get_contents($logo)); 
            $QR_width = imagesx($QR);//二维码图片宽度 
            $QR_height = imagesy($QR);//二维码图片高度 
            $logo_width = imagesx($logo);//logo图片宽度 
            $logo_height = imagesy($logo);//logo图片高度 
            $logo_qr_width = $QR_width / 5; 
            $scale = $logo_width/$logo_qr_width; 
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2; 
            //重新组合图片并调整大小 
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,  
            $logo_qr_height, $logo_width, $logo_height); 
        } 
        //输出图片 
        return imagepng($QR,$dir.'/'.$logoname);
        // echo '<img src="'.$logoname.'"/>';
    }
    echo createQcode('http://www.baidu.com','qrcode','dog.png',"D://wamp/www/qcode",7);
?>