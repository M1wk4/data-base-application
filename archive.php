<?php
    include_once "scripts\bd_incl.php";
    include_once 'header.php';
    
?>
<?php
  function sort_link_th($title, $a, $b) {
    $sort = @$_GET['sort'];
    if ($sort == $a) {
      return '<a class="active" href="?sort=' . $b . '">' . $title . ' <i>▲</i></a>';
    } elseif ($sort == $b) {
      return '<a class="active" href="?sort=' . $a . '">' . $title . ' <i>▼</i></a>';  
    } else {
      return '<a href="?sort=' . $a . '">' . $title . '</a>';  
    }
  }
?>
<div class="container">
  <h1 class="mb-4">Архив контрактов</h1>
  <div class="row">
    <div class="col">
    <table class="table table-striped">
        <thead>
          <tr>
          <th><?php echo sort_link_th('Id бывшего сотрудника', 'man_id_asc', 'man_id_desc'); ?></th>
			    <th><?php echo sort_link_th('Id контрагента', 'contr_id_asc', 'contr_id_desc'); ?></th>
			    <th><?php echo sort_link_th('Дата начала', 'dayfrom_asc', 'dayfrom_desc'); ?></th>
			    <th><?php echo sort_link_th('Дата конца', 'dayto_asc', 'dayto_desc'); ?></th>

          </tr>
        </thead>
        <tbody>
        <?php
        $sort_list = array(
          'man_id_asc'   => '`man_id`',
          'man_id_desc'  => 'man_id` DESC',
          'contr_id_asc'  => '`contr_id`',
          'contr_id_desc' => '`contr_id` DESC',
          'dayfrom_asc'   => '`dayfrom`',
          'dayfrom_desc'  => '`dayfrom` DESC',
          'dayto_asc'   => '`dayto`',
          'dayto_desc'  => '`dayto` DESC',
        );
        $login = $_SESSION['login'];
        $mid = $_SESSION['mid'];
        if (isset($login)){
          $sort = @$_GET['sort'];
          if (array_key_exists($sort, $sort_list)) {
            $sort_sql = $sort_list[$sort];
          } else {
            $sort_sql = reset($sort_list);
          } 
          $sql = "SELECT man_id,	contr_id,	dayfrom,	dayto
                      from `delete_cont`
                      ORDER BY {$sort_sql}";
          $res = $mysqli->query($sql);
          $data = $res->fetch_all();
          foreach ($data as $row){
                $contrid = $row[1];
                echo "<tr>";
                echo "<td>" . $row[0]. " </td>";
                echo "<td>" . $row[1]. "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";
                
                echo  "<td>" . "<button type='button' class='btn btn-outline-primary'data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-contr='".$row[1]."'  data-bs-end='".$row[3]."'>Обновить</button>" ."</td>";
                echo "</td>";
                echo "</tr>";
          }
        } 
         ?>
        </tbody>
      </table>
    </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Выбирите нового менеджера</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3 needs-validation" novalidate>
              
              <div class="form-group">
              <select class="form-select" aria-label="Пример выбора по умолчанию" id="mann">
               <?php 
               
                include "scripts\bd_incl.php";
                if (isset($login)){
                    $mysqli->query("SET @p0='".$contrid."'");
                    $mysqli->query("SET @p1='".$mid."'");
                    $res1 = $mysqli->query("CALL `free_man`(@p0, @p1)");  
                    $data1 = $res1->fetch_all();
                    $mysqli->close();
                    $i = 1;
                   foreach ($data1 as $row1){
                      echo "<option value='".$row1[0]."'>" . $row1[1] . "</option>";
                          $i++;
                    }
                  }
                ?>
                </select>

            <h5 id='end'> </h5>
            <h5 id='contrid'> </h5>
            <div class="modal-footer">
              <button type="button" id="upd_man" class="btn btn-primary">Обновить</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
            </div>
            </form>
        </div>
    </div>       
</div>
</div>
</div>
<script src='js/upd_ins.js'> </script>
<script> 
const exampleModal = document.getElementById('exampleModal')
exampleModal.addEventListener('show.bs.modal', event => {
  // Кнопка, которая активировала модальное окно
  const button = event.relatedTarget
  // Извлекает информацию из атрибутов data-bs-*
  const contr_id = button.getAttribute('data-bs-contr') 
  const end = button.getAttribute('data-bs-end')

  // При необходимости вы можете инициировать запрос AJAX здесь,
  // а затем выполнить обновление в обратном вызове.
  //
  // Обновляет содержимое модального окна.
  const modalBodyInput = exampleModal.querySelector('#end')
  const modalBodyInput1 = exampleModal.querySelector('#contrid')



  modalBodyInput.value = end
  modalBodyInput1.value = contr_id

})
</script>