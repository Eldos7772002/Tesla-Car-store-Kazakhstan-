<?
if(!$_SESSION){session_start ();}
include __DIR__.'/settings.php';

$count=4;
if($array[redirection]){$count++;$plus.='<red>'.$count.')</red>. <a href="'.$path.'\Index.html?redirect=no">Отключить переадресацию</a> - redirect=no<br>';}
if($array[form]==no)    {$count++;  $plus .='<red>'.$count.')</red>. <a href="'.$path.'dw_index.php?form=open" title="Данная ссылка откроет форму для других пользователей">Показать форму</a> - form=open<br>';}

$about_dw_admin = 'Имя будет использоваться в качестве  приветсвия, никак в регистрации и авторизации учавствовать не будет.
Если где-то вам хочется, чтобы ваше имя выходило в в качестве привествия, то см. <a href="https://dwweb.ru/project/dw_admin_2_1.html#level_var_open_name" target="_blank">здесь</a>';

if($show_array){$show_array = '<details><summary><red>Показать массив</red></summary> <div class="border padding_20 margin_20_0">'.$show_array.'</div></details>';}

$show_ses = '<details><summary><red>Показать сессии</red></summary> <div class="border padding_20 margin_20_0"><pre>'.print_r($_SESSION, true).'</pre></div></details>';

if($_SESSION[$name_session])
{
    if($DIR)
    {
        $echo  = '<n>Здравствуйте  '.$open_name.'</n><h2>DW - ADMIN 2.1</h2>
        <div style="text-align:left;">
            "test.php"(тестовая страница), админки <a href="https://dwweb.ru/project/dw_admin_2_1.html" target="_blank" title="Описание">DW-ADMIN 2.1.</a><br>
            Теперь вы можете изменить:<br>
            <red>1)</red>. Имя админа(<u id="ada"><span>'.$open_name.'<span><div class="ada">'.$about_dw_admin.'</div> <a href=https://dwweb.ru/project/dw_admin_2_1.html#level_var_open_name   target=_blank>""$open_name"</a></u>).<br>
            <red>2)</red>. Пароль.<br>
            <red>3)</red>. <a href=https://dwweb.ru/project/dw_admin_2_1.html#paragraph_redirect target=_blank>Переадресацию.</a> <br>
            <red>4)</red>. <a href=https://dwweb.ru/project/dw_admin_2_1.html#paragraph_hide_form target=_blank>Показать/скрыть форму входа</a>.<br>
            '.$show_array.'
            '.$plus.'
            '.$show_ses.'
            <a href="'.$path.'logout.php">Выйти</a> - logout.php<br>
            <button class="but" onclick="javascript:document.location.href=\''.$path.'dw_index.php\'">Изменить настройки</button>
        </div>';
    }
    else
    {
        $echo  = '<n>Здравствуйте  '.$open_name.'</n><h2>Путь до файла не выбран!</h2>
        Его нужно выбрать.
        <button class="but" onclick="javascript:document.location.href=\''.$path.'dw_index.php\'">Изменить настройки</button> ';
    }
}
else
{
	$echo    = 'У вас недостаточно прав для просмотра данной информации! ';
	$refresh = '<meta http-equiv="Refresh" content="2; URL='.$path.'dw_index.php">';
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>тестовая страница</title><? echo $refresh; ?><style type="text/css"> red{color: red;} h2 { font-family: 'Roboto', sans-serif; font-weight: 100; border-bottom: 2px solid #1762ee; padding-bottom: 15px;}body::before { content: ""; position: fixed; left: -50px; right: -50px; top: -10px; bottom: 0px; z-index: -1; background: url(back.png)center/cover no-repeat; filter: blur(10px); height: 110%; opacity: 0.5;}.transparent { position: absolute; width: 500px; padding: 60px 50px; top: 50%; left: 50%; transform: translate(-50%,-50%); background: #ffffff7a; text-align: center; font-size: 16px; color: #919191; font-family: monospace;}input#submitlink { width: 100%; padding: 10px; margin: 20px 0;}#ada:hover .ada { opacity:1; transition: 2s; display:block;}.ada { display:none; position: absolute; background: #f7f7f7; padding: 40px; border: 1px solid #c4c4c4; width: 500px; left: 10px; opacity:0; transition: 2s; }#ada span{cursor: pointer;}a { color: #b2b2b2; text-decoration: none; border-bottom: 1px solid;}a:hover { border: 1px solid #ff000000;}n { position: absolute; top: 20px; right: 20px;}.but{width:100%;padding:10px 0;margin-top:20px;background:#1762EE;color:white; border-radius:20px;border-width:0;outline:none;height:40px;cursor:pointer; transition: .3s ease-out;}button.but:hover{background:#ffffffab;color: #01215d;border:1px solid #9f9f9f94; transition: .3s ease-out;}details:focus,summary:focus { outline: 0; outline: none;}summary { cursor: pointer;}.border { border: 1px solid #e8e8e8;}</style></head><body><div class="transparent"><? echo $echo; ?></div></body>
</html>
