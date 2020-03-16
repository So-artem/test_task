<html>
<head>
  <title>Form</title>
  <meta charset="utf-8">
  <link rel='stylesheet' href='style.css'>
</head>
<body>
  <!-- форма вводу даних -->
  <form enctype="multipart/form-data" method="POST" action="save.php" class="contact_form">
    <input name="name" placeholder="Ім'я"><br>
    <input name="surname" placeholder="Прізвище"><br>
    <input name="email" placeholder="Email"><br>
    <input name="telephone" placeholder="Телефон"><br>


    <!-- <img id="blah" alt="your image" width="100" height="100" /> -->
    <input type="file" name="file" accept="image/jpeg,image/gif,image/x-png"><br><br>

    <button class="submit" type="submit" name= "review" >Додати</button>
  </form>


<form >
<table class="table_sort">
  <thead>
<?php
    // відображення
    $xml_info = new SplFileInfo('peopleDB.xml');
    //readfile("uploades/12.jpg");
    if((int)$xml_info->getSize() > 0)
    {
    
    $sxml = simplexml_load_file("peopleDB.xml");
    echo "<tr>
            <th>Ім'я</th>
            <th>Прізвище</th>
            <th>Email</th>
            <th>Номер<br>телефону</th>
            <th>Фото</th>
            <form><th>Видалити</th></form>
          </tr>
          </thead>
          <tbody>";
    foreach($sxml->info as $value)
      {
        echo "<tr>
            <td> $value->name </td>
            <td> $value->surname </td>
            <td> $value->email </td>
            <td> $value->telephone </td>
            <td> <img src='uploades/$value->id.jpg' width='100' height='100'> </td>
            <td> 
             <form action = 'delete.php' method = 'POST'>
               <input type = 'hidden' name = 'deleteHidden' value = '$value->id'>
              <br>
               <button class='submit' type='submit'>Delete</button>
             </form>
             </td>
          </tr>";
      }
    }
?>
</tbody>
</table>

<script>
  document.addEventListener('DOMContentLoaded', () => {

    const getSort = ({ target }) => {
        const order = (target.dataset.order = -(target.dataset.order || -1));
        const index = [...target.parentNode.cells].indexOf(target);
        const collator = new Intl.Collator(['en', 'ru'], { numeric: true });
        const comparator = (index, order) => (a, b) => order * collator.compare(
            a.children[index].innerHTML,
            b.children[index].innerHTML
        );
        
        for(const tBody of target.closest('table').tBodies)
            tBody.append(...[...tBody.rows].sort(comparator(index, order)));

        for(const cell of target.parentNode.cells)
            cell.classList.toggle('sorted', cell === target);
    };
    
    document.querySelectorAll('.table_sort thead').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));
    
});
</script>

</form>
</body>
</html>