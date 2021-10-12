<? unset($_SESSION['11f6b3285bf71a87811c3dadccb7b166']);
$path         = '//'.$_SERVER['HTTP_HOST']. str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__).'/';

$id_bad      = md5(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__));

if(substr_count(__DIR__, 'comments_1_5')) {$no_input_redirection=1;}

$my_session   = __DIR__ .'/my_session.php'; //файл с изменяемыми сессиями




//-------------- не менять
$admin_login  = 'cb359db0a1158ab6c927b442add77741'; // id5
$admin_pass   = '3efa71bc5cee5e6e133dff04ff4998b9'; // id6
//-------------- не менять


//-------------- можно поменять
$open_name     = 'admin_example'; // можно изменить  // id4
$salt 	       = '89fe766db2985e1ecc1972c25577ddbf'; // можно изменить // id7
$name_session  = 'dw_admin_2_1'; // можно изменить //id8
$value_session =  $admin_login; // можно изменить //id9
//-------------- можно поменять


if(basename($_SERVER['DOCUMENT_ROOT']) == current(explode('.', $_SERVER["HTTP_HOST"])))// проверка поддомена
{
  $real_dir      = implode('/', array_slice( explode('/', $_SERVER['DOCUMENT_ROOT']), 0, -1));// Путь на поддомене
  $dw_main_domen = $_SERVER["HTTP_X_FORWARDED_PROTO"].'://'.implode('.',array_slice(explode('.',$_SERVER['HTTP_HOST']), 1));
}
else
{
	$real_dir      = $_SERVER['DOCUMENT_ROOT'];  // Путь на домене
  $dw_main_domen = $_SERVER["HTTP_X_FORWARDED_PROTO"].'://'.$_SERVER["HTTP_HOST"];
}

//------------------------------------  chooses
$chooses        = unserialize(file_get_contents( __DIR__ .'/chooses.dat')) ;
if($chooses[name_file])        { $lp_dat = $chooses[name_file].'.dat'; }
if($chooses[folder]=='into')   { $DIR    = __DIR__; }
if($chooses[folder]=='up')     { $DIR    = implode('/', array_slice( explode('/', $real_dir), 0, -1)); ; }
//------------------------------------  chooses


if(file_exists($DIR.'/'.$lp_dat))
{
	$array      = unserialize(file_get_contents($DIR.'/'.$lp_dat)) ;
  $show_array = str_replace(array("\r\n", "\r", "\n"), '<br>', print_r($array, true));

	if($array[open_name])   { $open_name   = $array[open_name];    }//массив_со_значениями
	if($array[admin_login])  { $admin_login = $array[admin_login];   }// md5
	if($array[admin_pass])  { $admin_pass  = $array[admin_pass];   }// md5
	if($array[redirection]) { $redirection = $array[redirection];  }
	if($array[form])    { $form    = $array[form];     }
	if($array[dw_email])    { $dw_email    = $array[dw_email];     }

	if((basename(strip_tags($_SERVER['REQUEST_URI']))) != 'dw_index.php'){$broken=1;}

	if($_GET[form]==open)
	{
		$array[form]   = 'ok';
		$write             = @file_put_contents($DIR.'/'.$lp_dat, serialize($array) );

		if($write)
		{
		$echo              = '<div class="transparent">Форма открыта</div>';
		$main_refresh      = 'dw_index.php';
    $content=2;
		}
	}
	elseif($_GET[redirect]==no)
	{
		$array[redirection] = '';
		$write              = @file_put_contents($DIR.'/'.$lp_dat, serialize($array) );

		if($write)
		{
		$echo               = '<div class="transparent">Переадресация отключена</div>';
		$main_refresh       = 'dw_index.php';
    $content=2;
		}
	}
	else
	{
		if($redirection and $_SESSION[$name_session] and !$broken)
		{
			exit('<meta http-equiv="Refresh" content="0; URL='.$redirection.'">');
		}
		if($form==no and !$_SESSION[$name_session] and !$_COOKIE[$name_session])
		{
      $main_refresh = $dw_main_domen;
      $content      =2;
      $path         = '';
			$echo         = '<div class="transparent">Форма скрыта</div>';
		}
	}
}

$big_id = md5($name_session.$admin_pass);  //id_big
if($_COOKIE[$name_session]==$big_id and !$_SESSION[$name_session])
{
  $_SESSION[$name_session] = $value_session;//go_session
  include $my_session;
  header("Refresh: 0");
  exit;
} //автоматический запуск сессии по кукам

if (!function_exists('dw_strtolower')) {
 function dw_strtolower($strr) { $big_lang = array('А' => 'а','Б' => 'б','В' => 'в','Г' => 'г','Д' => 'д','Е' => 'е','Ё' => 'ё','Ж' => 'ж','З' => 'з','И' => 'и','Й' => 'й','К' => 'к','Л' => 'л','М' => 'м','Н' => 'н','О' => 'о','П' => 'п','Р' => 'р','С' => 'с','Т' => 'т','У' => 'у','Ф' => 'ф','Х' => 'х','Ц' => 'ц','Ч' => 'ч','Ш' => 'ш','Щ' => 'щ','Ъ' => 'ъ','Ы' => 'ы','Ь' => 'ь','Э' => 'э','Ю' => 'ю','Я' => 'я','A' => 'a','B' => 'b','C' => 'c','D' => 'd','E' => 'e','F' => 'f','G' => 'g','H' => 'h','I' => 'i','J' => 'j','K' => 'k','L' => 'l','M' => 'm','N' => 'n','O' => 'o','P' => 'p','Q' => 'q','R' => 'r','S' => 's','T' => 't','U' => 'u','V' => 'v','W' => 'w','X' => 'x','Y' => 'y','Z' => 'z','É' => 'é','Â' => 'â','Ê' => 'ê','Î' => 'î','Ô' => 'ô','Û' => 'û','À' => 'à','È' => 'è','Ù' => 'ù','Ë' => 'ë','Ï' => 'ï','Ü' => 'ü','Ÿ' => 'ÿ','Ç' => 'ç','Ą' => 'ą','Ć' => 'ć','Ę' => 'ę','Ł' => 'ł','Ń' => ''); return strtr( $strr , $big_lang ); }

}
