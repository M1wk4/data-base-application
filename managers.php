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
  <h1 class="mb-4">Подчиненные менеджеры</h1>
  <div class="row">
    <div class="col-8">
    <table class="table table-striped">
        <thead>
          <tr>
          <th><?php echo sort_link_th('Подчиненный', 'man_name_asc', 'man_name_desc'); ?></th>
			    <th><?php echo sort_link_th('Процент', 'percent_asc', 'percent_desc'); ?></th>
			    <th><?php echo sort_link_th('Дата найма', 'hire_day_asc', 'hire_day_desc'); ?></th>
			    <th><?php echo sort_link_th('Дилер', 'deal_name_asc', 'deal_name_desc'); ?></th>
          </tr>
        </thead>
        <tbody>
        <?php
        $sort_list = array(
          'man_name_asc'   => '`man_name`',
          'man_name_desc'  => '`man_name` DESC',
          'percent_asc'  => '`percent`',
          'percent_desc' => '`percent` DESC',
          'hire_day_asc'   => '`hire_day`',
          'hire_day_desc'  => '`hire_day` DESC',
          'deal_name_asc'   => '`deal_name`',
          'deal_name_desc'  => '`deal_name` DESC',
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
          $sql = "SELECT man_with_login.Man_Id as id, man_with_login.name as man_name, man_with_login.percent, man_with_login.hire_day, dealers.name as deal_name, dealers.D_id as deal_id, man_with_login.comments
                      from `man_with_login`, `dealers` 
                      where man_with_login.parent_id = {$mid} and man_with_login.D_id = dealers.D_id
                      ORDER BY {$sort_sql}";
          $res = $mysqli->query($sql);
          $data = $res->fetch_all();
          foreach ($data as $row){
            echo "<tr>";
                echo "<td>" . $row[1].'<h7 class="text-muted"> #'.$row[0]. "</h7> </td>";
                echo "<td>" . ($row[2]*100). "</td>";
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[4] . "</td>";
                echo "<td>" . "<button type='button' class='btn btn-outline-primary'data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-nametitle='".$row[1]
                            ."' data-bs-imgtovara='".($row[2]*100)."' data-bs-pricetovar='".$row[4]."' data-bs-man_id='".$row[0]."' data-bs-d_id='".$row[5]."' data-bs-com='".$row[6]."'>Изменить</button>" ."</td>";
                echo "</tr>";
          }
        } 
         ?>
        </tbody>
      </table>
    </div>
    <div class="col">





    <form class="was-validated">
    <legend>Регистрация нового менеджера</legend>
      <div class="mb-3">
        <label for="name_new" class="form-label">Имя</label>
        <input type="text" class="form-control" id="name_new" required  pattern="^([А-Я]{1}[а-яё]{1,32} [А-Я]{1}[а-яё]{1,32})$">
        <div class="invalid-feedback">Введите имя. Допустимо: только русские буквы. Например: Иванов Иван</div>
        <div class="valid-feedback"></div>
      </div>



      <div class="mb-3">
        <label for="login_new" class="form-label">Логин</label>
        <input type="text" class="form-control" id="login_new" required  pattern="^(.[a-zA-Z0-9_.]{3,15})$">
        <div class="invalid-feedback">Введите логин. Допустимо: 4 - 15 латинских символа, цифры и символы из набора (_-.)</div>
        <div class="valid-feedback"></div>
      </div>


      
      <div class="mb-3">
        <label for="pass" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="pass" required  pattern="^(.[a-zA-Z0-9_.*%&]{6,15})$">
        <div class="invalid-feedback">Введите логин. Допустимо: 6 - 15 латинских символа, цифры и символы из набора (_-.*%&)</div>
        <div class="valid-feedback"></div>
      </div>
      <div class="mb-3">
        <label for="precent_new" class="form-label">Процент</label>
        
          <input type="text" class="form-control" id="precent_new" aria-describedby="precent_help" required  pattern="^([1-9]|1[0-9])$|(20)$"> 
          <div class="invalid-feedback">Число от 1 до 20</div>
          <div class="valid-feedback"></div>
      </div>
      <div class="mb-3">
          <label for="precent_new" class="form-label">Дилер</label>
          <select class="form-select" aria-label="" id="dealers_new" name="deal">

          <?php      
            include "scripts\bd_incl.php";
            if (isset($login)){
                $mysqli->query("SET @p0='".$mid."'");
                $res = $mysqli->query("CALL `free_dealer`(@p0)");  
                $data = $res->fetch_all();
                $mysqli->close();
                $i = 1;
               foreach ($data as $row){
                  echo "<option value='".$row[0]."'>" . $row[1] . "</option>";
                      $i++;
                }
              }    
            ?>
          
          </select>
      </div>
      <div class="mb-3">
        <label for="comments" class="form-label">Комментарий (не обязательно)</label>
        <textarea  type="text" class="form-control" id="comments" maxlength="150"> </textarea>
        <div class="valid-feedback">Не более 150 смиволов</div>
      </div>
        <input type="submit" id="newman" class="btn btn-primary"\>
    </form>




    </div>
    </div>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast1" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <strong class="me-auto">ОШИБКА</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
     </div>
    <div class="toast-body" id="errorMess1"> </div>
  </div>
</div>
  </div>
  
</div>




<script src="js/new_man.js"></script>  
 
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3 needs-validation" novalidate>
              <div class="form-group">
                
                <label for="exampleFormControlInput1" style='margin-top: 6px' class="fw-bold">Имя</label>
                <h10 id='man_id'> </h10>
                <input type="text" class="form-control" id="name" name="name" style='margin-top: 6px'>
                <div class="invalid-feedback">
                  Ввидите имя
                </div>
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput2" style='margin-top: 6px' class="fw-bold">Процент</label>
                <input type="text" class="form-control" id="procent" name="procent" style='margin-top: 6px'>
                <div class="invalid-feedback">
                  Укажите доступный процент (между 0 и 20)
                </div>
              </div>
              <div class="form-group">
                <label for="dealers" style='margin-top: 6px' class="fw-bold">Дилер</label>
                <select class="form-select" aria-label="" id="dealers" name="deal">
                <option selected id='d_id'> </option>
                <?php
                  
                  include "scripts\bd_incl.php";
                  if (isset($login)){
                    $mysqli->query("SET @p0='".$mid."'");
                    $res = $mysqli->query("CALL `free_dealer`(@p0)");  
                    $data = $res->fetch_all();
                    $mysqli->close();
                    $i = 1;
                    foreach ($data as $row){
                      echo "<option value='".$row[0]."'>" . $row[1] . "</option>";
                      $i++;
                    }
                  }
                  
                ?>
                </select>
                <div class="form-group">
                  <label for="upcomments" style='margin-top: 6px' class="fw-bold">Комментарий</label>
                  <textarea  type="text" class="form-control" id="upcomments"> </textarea>
                  <div id="textarea_help1" class="form-text">Не более 150 сиволов</div>
                </div>
              </div>
            
            <div class="modal-footer">
              <button type="button" id="upd_man" class="btn btn-primary">Обновить</button>
              <button type="button" id="del_man" class="btn btn-primary">Удалить</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
            </div>
            
            <div class="position-fixed top-50 start-50 translate-middle-y" style="z-index: 11">
              <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="me-auto">ОШИБКА</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
                </div>
                <div class="toast-body" id="errorMess">
                </div>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>

<script src="js/del_man.js"></script>  
<script src="js/upd_man.js"></script>    
               
<script> 
const exampleModal = document.getElementById('exampleModal')

exampleModal.addEventListener('show.bs.modal', event => {
  // Кнопка, которая активировала модальное окно
  const button = event.relatedTarget
  // Извлекает информацию из атрибутов data-bs-*
  const man_id = button.getAttribute('data-bs-man_id') 
  const d_id = button.getAttribute('data-bs-d_id') 
  const recipient = button.getAttribute('data-bs-nametitle')
  const procent = button.getAttribute('data-bs-imgtovara')
  const diler = button.getAttribute('data-bs-pricetovar')
  const com = button.getAttribute('data-bs-com');
  // При необходимости вы можете инициировать запрос AJAX здесь,
  // а затем выполнить обновление в обратном вызове.
  //
  // Обновляет содержимое модального окна.
  const modalTitle = exampleModal.querySelector('.modal-title ')
  const modalBodyInput = exampleModal.querySelector('.modal-body input[id=name]')
  const modalBodyInput1 = exampleModal.querySelector('.modal-body input[id=procent]')
  const modalBodyInput2 = exampleModal.querySelector('#d_id')
  const h_man_id = exampleModal.querySelector('#man_id')
  const area = exampleModal.querySelector('#upcomments')


  modalTitle.textContent = `Изменения менеджера: ${recipient}`
  modalBodyInput.value = recipient
  modalBodyInput1.value = procent
  modalBodyInput2.innerHTML = diler
  modalBodyInput2.value = d_id;
  h_man_id.value = man_id
  area.innerHTML = com
  area.value = com
})
</script>
<?php
include_once 'footer.php';
?>