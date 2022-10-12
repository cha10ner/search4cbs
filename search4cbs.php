<?php    //работающий вариант
$query = $_POST['query'];
$link = mysqli_connect("localhost", "username", "password", "dbname"); //серьёзно, вы думали тут будет пароль?
$sql = "SELECT id, name, description FROM informationsystem_items WHERE name LIKE '%$query%' OR description LIKE '%$query%' OR text LIKE '%$query%'";
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
		$sqlink0 = "SELECT path, name FROM structures WHERE id = (SELECT structure_id FROM informationsystems WHERE id = (SELECT informationsystem_id FROM informationsystem_items WHERE id LIKE '$row[0]'))";
		$qlink0 = mysqli_query($link, $sqlink0);
		$row0 = mysqli_fetch_row($qlink0);
       	  print("<srch>"."<a href=../$row0[0]/$row[0] target='_blank'>"."<u>".$row[1]."</u>"."</a>"."&nbsp;&nbsp;&nbsp;&nbsp;".$row0[1].$row[2]."<br />"."</srch>"); //выводим строки через print
				}
        }
    }
    else
    {
        print("<srch>".'Задан пустой поисковый запрос'."</srch>");
    }
?>
