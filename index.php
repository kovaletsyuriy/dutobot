<?PHP 
require '/phpQuery/phpQuery-onefile.php';
$login_url = 'http://e-rozklad.dut.edu.ua/timeTable/group';
$agent = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';
$reffer = 'http://e-rozklad.dut.edu.ua/timeTable/searchStudent';
$postLoginFields = array();
$postLoginFields['TimeTableForm[faculty]'] = '2';
$postLoginFields['TimeTableForm[course]'] = '2';
$postLoginFields['TimeTableForm[group]'] = '634';
/*$postLoginFields['TimeTableForm[student]'] = '3';*/
//$postLoginFields['St[st2]'] = 'ковалець';


$postLoginFields['yt0'] = 'true';


$ch = curl_init();

	curl_setopt($ch, CURLOPT_REFERER, $reffer);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postLoginFields));
	curl_setopt($ch, CURLOPT_URL,$login_url);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//выполняем запрос
$page = curl_exec($ch);
curl_close($ch);
	$encode = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="ru" />';
    echo $encode . '<br>';
 $document = phpQuery::newDocument($page);
 $page2 = $document->find('table.timeTable')->prepend('<br>')->prepend($encode);
$fp = fopen('counter.txt', 'w+');
$test = fwrite($fp, $page); // Запись в файл
if ($test) {
	echo 'Данные в файл counter.txt успешно занесены.';
}else {
	echo 'Ошибка при записи в файл counter.txt.';
}
fclose($fp); //Закрытие файла

$fp2 = fopen('counter2.txt', 'w+');
$test2 = fwrite($fp2, $page2); // Запись в файл
if ($test2) {
	echo 'Данные в файл counter2.txt успешно занесены.';
}else {
	echo 'Ошибка при записи в файл counter2.txt.';
}
fclose($fp2); //Закрытие файла

//echo($page2);

//поиск по даттте:
$query = $_POST['dateQuery'];
$queryRes = $page2->find("td > div:contains('$query') ");
$queryResText = $queryRes->text();
$queryResHtml = $queryRes;


if ($queryResText==$query) { 
	$parentsTd = $page2->find("td:contains('$queryResText')");
	$queryText = $parentsTd->html();
}

$fp3 = fopen('counter3.txt', 'w+');
$test3 = fwrite($fp3, $queryText); // Запись в файл
if ($test3) {
	echo 'Данные в файл counter3.txt успешно занесены. <br>';
	echo $queryText;
}else {
	echo 'Ошибка при записи в файл counter3.txt.';
}
fclose($fp3); //Закрытие файла

?>