<?
if(!$_SESSION){session_start ();}  
include __DIR__.'/settings.php';
if(!$_SESSION[$name_session])
{
		$echo     = 'Для того, чтобы выйти – надо сперва войти!';
		$refresh  = 'dw_index.php';
		$content  =2;
}
else
{
    // echo '<pre>'.print_r(file($my_session) , true).'</pre>';
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
		if($_SESSION[$name_session]){$ses++;}

		if(!$ses) {$echo = 'Вы вышли';}

		$refresh  = 'dw_index.php';
		$content  =2;
		@SetCookie( $id_bad ,'',time()+(365*24*60*60), "/", $_SERVER["LOCAL_HOST"], 0);
		@SetCookie( $name_session  ,'',time()+(365*24*60*60), "/", $_SERVER["LOCAL_HOST"], 0);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Выход</title>
		<?='<meta http-equiv="Refresh" content="'.$content.'; URL='.$path.$refresh.'">'; ?>
	<style type="text/css">
body::before {
    content: "";
    position: fixed;
    left: -50px;
    right: -50px;
    top: -10px;
    bottom: 0px;
    z-index: -1;
    background: url(back.png)center/cover no-repeat;
    filter: blur(10px);
    height: 110%;
    opacity: 0.5;
}		.transparent {
    position: absolute;
    width: 500px;
    padding: 60px 50px;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    background: #ffffff7a;
    text-align: center;
    font-size: 19px;
    font-family: monospace;
}
	</style>
</head>
<body>
	<div class="transparent">
	<?=$echo?>
	</div>
</body>
</html>
