<?
if(!$_SESSION){session_start ();}
include __DIR__.'/settings.php';

$send_name           = md5(trim(strip_tags($_POST['admin_login'])).$salt);  //echo '<br>'.$send_name .'<br>';
$send_pas            = md5(trim(strip_tags($_POST['admin_pass'])).$salt); // if($_POST['admin_pass']){ exit( $send_pas );}

if($main_refresh)
{
    $refresh = $main_refresh;
}
else
{
    if($_SESSION[$name_session])
    {
      if($DIR)
      {
          $H3                = "Изменить настройки" ;
          $refresh           = '';
          $var_name          = 'change';
          $input_open_name   = '<input type="text"     name="open_name"    placeholder="Имя(как к вам обращаться)"> ';
          $input_redirection = '<input type="text"     name="redirection" placeholder="адрес передресации" autocomplete="new-password">';
          $input_pas_2       = '<input type="password" name="pas_2"    id="pas2" placeholder="Пароль 2 раз"'.$required.'autocomplete="new-password">';
          $show_pass         = '<div style="text-align:right;"><a id="show_pass">Показать пароль</a></div>';

          if($form==ok or !$form)
          {
             $text    = 'Скрыть форму(<red>форма доступна<red>)';
          }
          else
          {
             $text    = 'Показать форму(<green>форма закрыта<green>)';
          }
          $input_checkbox= '<input type="checkbox" name="checkbox" class="checkbox"><span id="hide">'.$text .'</span>';

          if($_POST['admin_pass'] != $_POST['pas_2']){$_POST['change']='';$bad='Пароли не равны';}

          if($_POST['change'])
          {
              if($_POST['open_name'] )  { $array[open_name]  = strip_tags($_POST['open_name'] ); $refresh='test.php';$content=0;}
              if($_POST['admin_login']) { $array[admin_login] = md5(trim(strip_tags($_POST['admin_login'])).$salt); $reboot=1; }
              if($_POST['admin_pass'])  { $array[admin_pass] = md5(trim(strip_tags($_POST['admin_pass'])).$salt); $reboot=1; }

              if($_POST['checkbox'] and $form==no)
              {
                  $array[form] = 'ok';
                  $hide_form       =' + Форма открыта';
                  $echo            = '<div class="transparent">Форма открыта</div>';
                  $refresh         = 'test.php';
                  $content         =2;
              }
              elseif(($_POST['checkbox'] and $form==ok ) or ($_POST['checkbox'] and !$form))
              {
                  $array[form] = 'no';
                  $hide_form       =' + Форма скрыта';
                  $echo            = '<div class="transparent">Форма скрыта</div>';
                  $refresh         = 'test.php';
                  $content         =2;
              }
              if($_POST['redirection'])
              {
                  $array[redirection] = strip_tags($_POST['redirection']);
                  $refresh = $array[redirection];
                  $content =2;
                  $path    ='';
                  $echo    = '<div class="transparent">Вас переместят'.$hide_form.'</div>';
              }

              if($reboot){ if($send_name == $admin_login) { $bad = 'Введите новое имя';    $no_write =1;}}
              if($reboot){ if($send_pas  == $admin_pass) { $bad = 'Введите новый пароль';  $no_write =1;}}//echo '<br>'.$no_write.'<br>' ;
              if(!$no_write)
              {
                 $write = @file_put_contents($DIR.'/'.$lp_dat, serialize($array) );
                 if($write)
                 {
                    if($reboot)
                    {
                       SetCookie($name_session ,'',time()+(365*24*60*60), "/", $_SERVER["HTTP_HOST"], 0);

                       $ses_array = @file($my_session);
                   		if($ses_array)
                   		{
                   			for ($i=0; $i < count($ses_array); $i++) {
                   				if(substr_count($ses_array[$i], '_SESSION'))
                   				{
                   					unset($_SESSION[current(explode(']', end(explode('[', $ses_array[$i])))) ] );
                   					if($_SESSION[current(explode(']', end(explode('[', $ses_array[$i])))) ] ){$ses++;}
                   				}
                   			}
                   		}
                   		 unset($_SESSION[$name_session]);
                       $refresh = 'test.php';
                       $content =2;
                       $echo    ='<div class="transparent" style="text-align:center;">Вам нужно ввести новый пароль и логин</div>';
                    }
                 }
              }
          }
          $required = ' ';
      }
      else
      {
        $H3 = 'Изменить путь и имя';
        if($_POST['change_dir'])
        {
          if($_POST['radio']=='1')
          {
              $chooses[folder]='into';
          }
          elseif($_POST['radio']=='2')
          {
              $chooses[folder]='up';
          }
          else
          {
              $H3 = 'Папка не выбрана.';
          }

          if($_POST['file_lp'])
          {
             $chooses[name_file] = $_POST['file_lp'];
             @file_put_contents(__DIR__.'/chooses.dat', serialize($chooses) );
             $chooses        = unserialize(file_get_contents( __DIR__ .'/chooses.dat')) ;
             if($chooses[name_file])        { $echo .= 'Имя';      }
             if($chooses[folder]=='into')   { $echo .= ' и место'; }
             if($chooses[folder]=='up')     { $echo .= ' и место'; }
             if($echo)                      { $echo .= ' файла записано!'; }
          }

          if( $echo )
          {
            $refresh   = 'test.php';
            $echo      = '<div class="transparent" style="text-align:center;">'.$echo.'</div>';
            $content=5;
          }
        }
      }
    }
    else
    {
        if($_POST['send'])
        {
            if(($send_name == $admin_login) && ($send_pas == $admin_pass))
            {
                $_SESSION[$name_session] = $value_session; //vars_name_and_value
                include $my_session;
                $echo                    = '<div class="transparent">Все верно</div>';
                $refresh                 = 'index.html'; $content=0;
                @SetCookie($name_session,$big_id, time()+(365*24*60*60),"/",$_SERVER["HTTP_HOST"],0);
                @setcookie( $id_bad , '' ,time()+(365*24*60*60));
            }
            else
            {
                $echo = 'Что-то не верно';
                if(!$_SESSION[ $id_bad ])        { $_SESSION[ $id_bad ] = '0'; $bad .= ' 3 попытки осталось';}
                elseif( $_SESSION[ $id_bad ] == '0') { $_SESSION[ $id_bad ] = '1'; $bad .= ' 2 попытка осталась';}
                elseif( $_SESSION[ $id_bad ] == '1') { $_SESSION[ $id_bad ] = '2'; $bad .= ' 1 попытка осталось';}
                elseif( $_SESSION[ $id_bad ] == '2') { $_SESSION['bad'] = 'is'; $bad  = 'Заблокировано';}
            }
        }

        $var_name = 'send';
        $required =required;
    }
}


if($_COOKIE[ $id_bad ]){ $_SESSION['bad']='is';}
if($_SESSION['bad'])
{
  setcookie( $id_bad , $id_bad ,time()+(365*24*60*60));
  $path    = '';
  $refresh = $dw_main_domen;
  $content =2;
  $echo    = '<div class="transparent">Заблокировано</div>';
}
if($bad){ $H3 = '<red>'.$bad.'</red>';}

if($refresh)
{
   $refresh     = '<meta http-equiv="Refresh" content="'.$content.'; URL='.$path.$refresh.'">';
}
else
{
    if(!$_SESSION[$name_session] or ($DIR and $_SESSION[$name_session]))
    {
        if(!$H3 )  { $H3 =   "Войти" ;}
        $echo =  '<form class="transparent" method="post">
           <div class="form-inner">
             <h3>'.$H3 .'</h3>
             '.$input_open_name.'
             <input type="text"     name="admin_login" placeholder="Логин" '.$required.'autocomplete="new-password">
             <input type="password" name="admin_pass" placeholder="Пароль"'.$required.'autocomplete="new-password" id="pas">
             '.$input_pas_2.'
             '.$show_pass.'
             '.$need_name_file_lp.'
             '.$input_redirection.'
             '.$input_checkbox.'
            <input type="submit"   name="'.$var_name.'" value="Отправить" class="submit">
           
          </div>
        </form>';
    }

    if(!$lp_dat  and $_SESSION[$name_session]){$need_name_file_lp = '<div style="text-indent: 22px; margin: 5px 0 0 0;">2). <a href="https://dwweb.ru/project/dw_admin_2_1.html#imya_fayla" target="_blank">Что такое имя файла?</a></div><input type="text" name="file_lp" placeholder="Введите имя файла" required title="название файла, например \'example\'">
     ';}

    if(!$DIR and $_SESSION[$name_session])
    {
        $echo =  '<form class="transparent" method="post">
           <div class="form-inner">
             <h3>'.$H3 .'</h3>
             <div><input type="radio"  name="radio" value="1" class="checkbox">1.1). В папке где <a href="https://dwweb.ru/project/dw_admin_2_1.html#papka_sohraneniya" target="_blank" title="О папке сохранения">расположен settings.php</a></div>
             <div><input type="radio"  name="radio"  value="2" class="checkbox">1.2). На <a href="https://dwweb.ru/project/dw_admin_2_1.html#rekomenduemyie_nastroyk" target="_blank">уровень выше</a></div>
             '.$need_name_file_lp .'
             <input type="submit" name="change_dir" value="Сохранить" class="submit">
          </div>
        </form>';
   }
}
?>
<!DOCTYPE html><html lang="ru"><head> <meta charset="UTF-8"> <title>Вход</title> <? echo $refresh; ?> <style> green{color: green;} red{color: red;}body::before { content: ""; position: fixed; left: -50px; right: -50px; top: -10px; bottom: 0px; z-index: -1; background: url(back.png)center/cover no-repeat; filter: blur(10px); height: 110%; opacity: 0.5;}input {outline:none;} * {box-sizing: border-box;}.transparent {text-align: center; position: absolute; width: 500px; padding: 60px 50px; top: 50%; left: 50%; transform: translate(-50%,-50%); background: #f4f5fc80; border: 2px solid #cacaca; box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 3px 6px rgba(0,0,0,0.22);}.form-inner {position: relative;}.form-inner h3 { position: relative; margin-top: 0; color: #5f5f5f; font-family: 'Roboto', sans-serif; font-weight: 300; font-size: 23px; text-transform: uppercase; text-align: center; margin-bottom: 25px; padding-bottom: 10px;}.form-inner h3:after { content: ""; position :absolute; left: 0; bottom: -6px; height: 2px; width: 100%; background: #1762EE;} .form-inner input { display: block; width: 100%; padding: 0 15px; margin: 10px 0 15px; border-width: 0; line-height: 40px; border-radius: 20px; background: rgba(255,255,255,.2); font-family: 'Roboto', sans-serif;}.form-inner input.submit {color: white;}.form-inner input[type="submit"] {background: #1762EE;}input#submitlink { background: transparent; border: 0; cursor:pointer; margin: 0; padding: 0; color: #034af3; text-decoration: underline;}input#submitlink:visited { color: #505abc;}input#submitlink:hover { color: #1d60ff; text-decoration: none;}input#submitlink:active { color: #12eb87;}.checkbox { width: 10px !important; height: 10px !important; display: inline-block !important; margin: 11px 12px 0 0 !important;}a { color: #939393; text-decoration: none; border: 1px solid #ff000000;}a:hover { border-bottom: 1px solid;}a#show_pass:hover { border: none;}span#hide { font-size: 13px; font-family: 'Roboto', sans-serif; color: #707070; padding: 0 0 14px;}a#show_pass { font-size: 13px; font-family: 'Roboto', sans-serif; color: #707070; padding: 0 0 14px; cursor: pointer;} a.dw-admin { position: absolute; right: 20px; bottom: 7px; color: #7e7e7e; font-size: 15px; font-family: monospace; text-decoration: none;}a.dw-admin:hover { border-bottom: 1px solid grey;}</style></head><body>
<? echo $echo ;?>
<script>
    if(document.getElementById('show_pass'))
    {
        show_pass.addEventListener("click", myFoo);
        function myFoo()
        {
            if (pas.type=='password')
            {
               pas.type  =  pas2.type = "text";
               document.getElementById('show_pass').innerHTML = 'Скрыть пароль';
            }
            else
            {
              pas.type  = pas2.type = "password";
              document.getElementById('show_pass').innerHTML = 'Показать пароль';
            }
        }
    }
</script>
   <a href="https://dwweb.ru/project/dw_admin_2_1.html" target="_blank" class="dw-admin" title="страница с настройками">© DW-admin 2.1</a>
</body>
</html>
