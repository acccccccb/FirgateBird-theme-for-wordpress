<?php
    if(empty($_POST['chatText'])) {
        echo 'oops!';
        return false;
    }
    else {
    require('var.php');
        //功能
        //$tempChat = mysql_real_escape_string($_POST['chatText']);
        $tempChat =$_POST['chatText'];
        $ip = $_SERVER["REMOTE_ADDR"];
        if($tempChat == ''){
            return false;
        }
        // 语句判断

        // 输入新闻 显示最近的几条新闻
        elseif( $tempChat == '新闻' ) {
            $url = "http://3g.163.com/touch/all?dataversion=A&version=v_standard";
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $contents = curl_exec($ch);
            preg_match_all ("/<h2>(.*?)<\/h2>/U", $contents, $pat_array);
            reset($pat_array[1]);
            $n =5;
            foreach ($pat_array[1] as $key=>$value ) {
              if( stristr($value,'title') == true && $n >  0 ) {
                  $re = $re . $value;
                  $n = $n - 1;
              }
            }
            curl_close($ch);
            $re = '以下是最近的新闻：<br/>'.$re;
        }
        // 显示IP地址
        else if( $tempChat == 'ip' ) {
            $re = '你的IP地址是：'.$_SERVER["REMOTE_ADDR"];
        }
        // 天气
        else if( $tempChat == '天气' ) {
           $url = 'https://free-api.heweather.com/v5/weather?city=113.99.3.0&key=a056da985a9144099e0b858f2460c1ff';
           //$url = 'https://free-api.heweather.com/v5/forecast?city=113.99.3.0&key=a056da985a9144099e0b858f2460c1ff';
           $ch = curl_init();
           $timeout = 5;
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
           curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
           $contents = curl_exec($ch);
           $contents = json_decode($contents,true);
//           echo('<pre>');
//           var_dump($contents);
//           echo('</pre>');

           $city = $contents['HeWeather5']['0']['basic']['city'];//城市
           $cnty = $contents['HeWeather5']['0']['basic']['cnty'];//国家

           $txt_d_0 = $contents['HeWeather5']['0']['daily_forecast']['0']["cond"]["txt_d"];//今日天气
           $date_0 = $contents['HeWeather5']['0']['daily_forecast']['0']["date"];//今日日期
           $dir_0 = $contents['HeWeather5']['0']['daily_forecast']['0']["wind"]["dir"];//风向
           $sc_0 = $contents['HeWeather5']['0']['daily_forecast']['0']["wind"]["sc"];//风力
           $aqi_0 = $contents['HeWeather5']['0']['aqi']['city']['aqi'];// 空气质量指数
           $pm25_0 = $contents['HeWeather5']['0']['aqi']['city']['pm25'];// PM2.5
           $qlty_0 = $contents['HeWeather5']['0']['aqi']['city']['qlty'];// 空气状况

           // hourly_forecast
           $txt_t_0 = $contents['HeWeather5']['0']['hourly_forecast']['0']["cond"]["txt"];//即时天气
           $date_t_0 = $contents['HeWeather5']['0']['hourly_forecast']['0']["date"];//时间
           $dir_t_0 = $contents['HeWeather5']['0']['hourly_forecast']['0']["wind"]["dir"];//风向
           $sc_t_0 = $contents['HeWeather5']['0']['hourly_forecast']['0']["wind"]["sc"];//风力

           $txt_t_1 = $contents['HeWeather5']['0']['hourly_forecast']['1']["cond"]["txt"];//即时天气
           $date_t_1 = $contents['HeWeather5']['0']['hourly_forecast']['1']["date"];//时间
           $dir_t_1 = $contents['HeWeather5']['0']['hourly_forecast']['1']["wind"]["dir"];//风向
           $sc_t_1 = $contents['HeWeather5']['0']['hourly_forecast']['1']["wind"]["sc"];//风力

            $hourly_forecast_0 = $txt_t_0.$date_t_0.$dir_t_0.$sc_t_0;
            $hourly_forecast_1 = $txt_t_1.$date_t_1.$dir_t_1.$sc_t_1;

            echo  ($hourly_forecast_0);
            echo  ($hourly_forecast_1);
           // now
           $txt_n_0 = $contents['HeWeather5']['0']['now']["cond"]["txt"];
           $dir_n_0 = $contents['HeWeather5']['0']['now']["wind"]["dir"];
           $sc_n_0 = $contents['HeWeather5']['0']['now']["wind"]["sc"];
           $sc_n_0 = $contents['HeWeather5']['0']['suggestion'];

            // suggestion 建议
            $txt_s_0 = $contents['HeWeather5']['0']['suggestion']['air']['txt'];
            $comf_s_0 = $contents['HeWeather5']['0']['suggestion']['comf']['txt'];
            $cw_s_0 = $contents['HeWeather5']['0']['suggestion']['cw']['txt'];
            $srsg_s_0 = $contents['HeWeather5']['0']['suggestion']['drsg']['txt'];
            $flu_s_0 = $contents['HeWeather5']['0']['suggestion']['flu']['txt'];
            $sport_s_0 = $contents['HeWeather5']['0']['suggestion']['sport']['txt'];
            $trav_s_0 = $contents['HeWeather5']['0']['suggestion']['trav']['txt'];
            $uv_s_0 = $contents['HeWeather5']['0']['suggestion']['uv']['txt'];

            $sug = $txt_s_0.$comf_s_0.$cw_s_0.$srsg_s_0.$srsg_s_0.$flu_s_0.$sport_s_0.$trav_s_0.$uv_s_0;


           $date_1 = $contents['HeWeather5']['0']['daily_forecast']['1']["date"];//明日日期
           $txt_d_1= $contents['HeWeather5']['0']['daily_forecast']['1']["cond"]["txt_d"];//明日天气
           $dir_1 = $contents['HeWeather5']['0']['daily_forecast']['1']["wind"]["dir"];//风向
           $sc_1 = $contents['HeWeather5']['0']['daily_forecast']['1']["wind"]["sc"];//风力

           $date_2 = $contents['HeWeather5']['0']['daily_forecast']['2']["date"];//后日日期
           $txt_d_2 = $contents['HeWeather5']['0']['daily_forecast']['2']["cond"]["txt_d"];//后日天气
           $dir_2 = $contents['HeWeather5']['0']['daily_forecast']['2']["wind"]["dir"];//风向
           $sc_2 = $contents['HeWeather5']['0']['daily_forecast']['2']["wind"]["sc"];//风力

           $tit = $cnty.' '.$city.' 空气指数：'.$aqi_0.' PM2.5：'.$pm25_0.' 空气状况：'.$qlty_0.'<br/>';
           $day_0 = $date_t_0.' '.$txt_d_0.' '.$dir_0.' '.$sc_0.'<br/>';
           $day_1 = $date_1.' '.$txt_d_1.' '.$dir_1.' '.$sc_1.'<br/>';
           $day_2 = $date_2.' '.$txt_d_2.' '.$dir_2.' '.$sc_2.'<br/>';

           $re = '天气：<br/>'.$tit.$day_0.$day_1.$day_2;

           curl_close($ch);
        }
        //
        else if( stristr($tempChat,'谁是这个世界最帅的人') == true ) {
            $re =  '是你，主人。';
        }
        // 未知命令
        else {
            $array=array(
                "对方不想跟你说话并向你扔了一条狗。",
                "对方不想跟你说话并向你抛出一段乱码",
                "对方不想跟你说话并向你抛出一个异常"
            );
            $rand_keys=array_rand($array,1);
            $re=$array[$rand_keys];
        }
        //echo $sendUser.$tempChat.'<br/>';
        //sleep(rand($minReTime,$maxReTime));
        echo '<span class="inputtit">'.$reUser.$separator.'</span>'.$re;
    }
?>