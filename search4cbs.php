<?php    //работающий вариант, лишние ссылки, добавить в $link id и по нему смотреть в 1 цикле
$query = $_POST['query'];
$link = mysqli_connect("localhost", "s90297u0_cbs", "xar0h.KJIbIK", "s90297u0_cbs"); //серьёзно, вы думали тут будет пароль?
$sql = "SELECT id, name, description, path FROM informationsystem_items WHERE name LIKE '%$query%' OR description LIKE '%$query%' OR text LIKE '%$query%'";
$query = trim($query);
$query = mysqli_real_escape_string($link,$query);
$query = htmlspecialchars($query);
if ($link == false){
    print("<srch>"."Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error()."</srch>"); //всё пропало, шеф (если серьезно mysqli_connect_error() скажет где конкретно мы накосячили)
}
else {
    $result = mysqli_query($link, $sql); //про параметры не забываем
    }
    if ($result == false) {
        print("<srch>"."Произошла ошибка при выполнении запроса"."</srch>"); //ну, мало ли...
    }
    else
    if (!empty($query))
    {
        if (strlen($query) < 3)
        {
            print("<srch>".'Слишком короткий поисковый запрос'."</srch>");
        }
        else if (strlen($query) > 60)
        {
            print("<srch>".'Слишком длинный поисковый запрос'."</srch>");
        }
        else if (mysqli_affected_rows($link) == 0)
        {
            print("<srch>".'По вашему запросу ничего не найдено'."</srch>");
        }
        else
        {
            while ($row = mysqli_fetch_row($result)){
			$sqlink0 = "SELECT path, parent_id, name FROM structures WHERE id = (SELECT structure_id FROM informationsystems WHERE id = (SELECT informationsystem_id FROM informationsystem_items WHERE id LIKE '$row[0]'))";
			$qlink0 = mysqli_query($link, $sqlink0);
			$row0 = mysqli_fetch_row($qlink0);
			if ($row0[1] == 0)
			{
			if ($row[1] == '')
			{
			print("<srch>"."<a href=../$row0[0]/$row[3] target='_blank'>"."<u>"."Читать"."</u>"."</a>"."<br />".$row0[2].$row[2]."<br />"."</srch>"); //выводим строки через print
			}
			else
			{
			print("<srch>"."<a href=../$row0[0]/$row[3] target='_blank'>"."<u>".$row[1]."</u>"."</a>"."<br />".$row0[2].$row[2]."<br />"."</srch>"); //выводим строки через print
			}
			}
			else
			{
			if ($row[1] == '')
			{
			print("<srch>"."<a href=../$row0[1]/$row0[0]/$row[3] target='_blank'>"."<u>"."Читать"."</u>"."</a>"."<br />".$row0[2].$row[2]."<br />"."</srch>"); //выводим строки через print
			}
			else
			{
            print("<srch>"."<a href=../$row0[1]/$row0[0]/$row[3] target='_blank'>"."<u>".$row[1]."</u>"."</a>"."<br />".$row0[2].$row[2]."<br />"."</srch>"); //выводим строки через print
			}
			}
			}
        }
    }
    else
    {
        print("<srch>".'Задан пустой поисковый запрос'."</srch>");
    }
?>
