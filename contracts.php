<?php
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

<link rel="stylesheet" href="css\bootstrap-datepicker3.min.css"> 
<ul class="nav nav-tabs" id="myTab">
  <li class="nav-item">
    <a class="nav-link active" data-bs-toggle="tab" href="#contr">Все контракты</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#open">Открытые</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#end">Закрытые</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#new">Заключить новый контракт</a>
  </li>
</ul>
<div class="tab-content">
  <div class="tab-pane active mt-2" id="contr">
    <div class="as-table" data-code="modcontr">
      <div class="container">
        <h1 class="mb-4">Контракты</h1>
          <div class="row">
            <div class="col">
              <table class="table table-striped">
              <thead>
                <tr>
                  <th><?php echo sort_link_th('Дилер', 'NAME_asc', 'NAME_desc'); ?></th>
                  <th><?php echo sort_link_th('Дата начала', 'dayfrom_asc', 'dayfrom_desc'); ?></th>
                  <th><?php echo sort_link_th('Дата конца', 'dayto_asc', 'dayto_desc'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "scripts\bd_incl.php";
                $sort_list = array(
                  'NAME_asc'   => '`NAME`',
                  'NAME_desc'  => '`NAME` DESC',
                  'dayfrom_asc'  => '`dayfrom`',
                  'dayfrom_desc' => '`dayfrom` DESC',
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
                  $sql = "SELECT contragents.NAME, dayfrom, dayto
                            from `contracts`, `contragents`
                            where contracts.man_id = {$mid}
                            and contragents.contr_id = contracts.contr_id
                            ORDER BY {$sort_sql}";
                  $res = $mysqli->query($sql);
                  $data = $res->fetch_all();
                  $mysqli->close(); 
                  foreach ($data as $row){
                    echo "<tr>";
                        echo "<td>" . $row[0] . "</td>";
                        echo "<td>" . $row[1]. "</td>";
                        echo "<td>" . $row[2] . "</td>";
                    echo "</tr>";
                  }
                } 
                ?>
              </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>              
  
  <div class="tab-pane mt-2 fade" id="open">
    <div class="as-table" data-code="modopen"> 
    <div class="container">
        <h1 class="mb-4">Открытые</h1>
          <div class="row">
            <div class="col">
              <table class="table table-striped">
              <thead>
                <tr>
                  <th><?php echo sort_link_th('Дилер', 'NAME_asc', 'NAME_desc'); ?></th>
                  <th><?php echo sort_link_th('Дата начала', 'dayfrom_asc', 'dayfrom_desc'); ?></th>
                  <th><?php echo sort_link_th('Дата конца', 'dayto_asc', 'dayto_desc'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "scripts\bd_incl.php";
                $sort_list = array(
                  'NAME_asc'   => '`NAME`',
                  'NAME_desc'  => '`NAME` DESC',
                  'dayfrom_asc'  => '`dayfrom`',
                  'dayfrom_desc' => '`dayfrom` DESC',
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
                  $sql = "SELECT contragents.NAME, dayfrom, dayto
                            from `contracts`, `contragents`
                            where contracts.man_id = {$mid}
                            and contragents.contr_id = contracts.contr_id
                            and contracts.dayto > sysdate()
                            ORDER BY {$sort_sql}";
                  $res = $mysqli->query($sql);
                  $data = $res->fetch_all();
                  $mysqli->close(); 
                  foreach ($data as $row){
                    echo "<tr>";
                        echo "<td>" . $row[0] . "</td>";
                        echo "<td>" . $row[1]. "</td>";
                        echo "<td>" . $row[2] . "</td>";
                    echo "</tr>";
                  }
                } 
                ?>
              </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>       
  <div class="tab-pane mt-2 fade" id="end">
    <div class="as-table" data-code="modend">
    <div class="container">
        <h1 class="mb-4">Закрытые</h1>
          <div class="row">
            <div class="col">
              <table class="table table-striped">
              <thead>
                <tr>
                  <th><?php echo sort_link_th('Дилер', 'NAME_asc', 'NAME_desc'); ?></th>
                  <th><?php echo sort_link_th('Дата начала', 'dayfrom_asc', 'dayfrom_desc'); ?></th>
                  <th><?php echo sort_link_th('Дата конца', 'dayto_asc', 'dayto_desc'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "scripts\bd_incl.php";
                $sort_list = array(
                  'NAME_asc'   => '`NAME`',
                  'NAME_desc'  => '`NAME` DESC',
                  'dayfrom_asc'  => '`dayfrom`',
                  'dayfrom_desc' => '`dayfrom` DESC',
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
                  $sql = "SELECT contragents.NAME, dayfrom, dayto
                            from `contracts`, `contragents`
                            where contracts.man_id = {$mid}
                            and contragents.contr_id = contracts.contr_id
                            and contracts.dayto <= sysdate()
                            ORDER BY {$sort_sql}";
                  $res = $mysqli->query($sql);
                  $data = $res->fetch_all();
                  $mysqli->close(); 
                  foreach ($data as $row){
                    echo "<tr>";
                        echo "<td>" . $row[0] . "</td>";
                        echo "<td>" . $row[1]. "</td>";
                        echo "<td>" . $row[2] . "</td>";
                    echo "</tr>";
                  }
                } 
                ?>
              </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="tab-pane mt-2 fade" id="new">
    <div class="as-table" data-code="modnew">
    <div class ="container">
    <div class="row w=150">
      <div class="col">
        <div class="card">
          <div class="card-body" id="sandbox-container">
            <h4>Заключить новый контракт </h4>
            <form>
            <div class="input-group pt-3">
            <select class="form-select" aria-label="Пример выбора по умолчанию" id="new_contr">
            <option selected value=0> Выбирите контрагента </option>
            <?php
              include "scripts\bd_incl.php";
              if (isset($login)){
                $mysqli->query("SET @p0='".$mid."'");
                $res = $mysqli->query("CALL `contrag`(@p0)");  
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
              <span class="input-group-text" id="basic-addon1">с</span>
              <input type="date" class="input-sm form-control" id="start" />
              <span class="input-group-text" id="basic-addon1">по</span>
              <input type="date" class="input-sm form-control" id="end_"/>
              <button type="button" class="btn btn-primary" id="accept">Заключить</button>
            </div>
          </form>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>

</div>
</div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
              <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="me-auto">УВЕДОМЛЕНИЕ</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
                </div>
                <div class="toast-body" id="errorMess">
                </div>
              </div>
            </div>

<script src="js\new_contr.js"> </script>



<!-- <script src="js\bootstrap-datepicker.js" ></script>
<script src="js\bootstrap-datepicker.ru.min.js"> </script>
<script>
 $('#sandbox-container .input-daterange').datepicker({
    format: "yyyy-mm-dd",
    maxViewMode: 0,
    clearBtn: true,
    language: "ru",
    orientation: "bottom left",
    daysOfWeekDisabled: "0,6",
    daysOfWeekHighlighted: "0,6",
    autoclose: true,
    todayHighlight: true
});
</script>
 -->
<script>
$(document).ready(function(){
	$('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('#myTab a[href="' + activeTab + '"]').tab('show');
	}
});
</script>
<?php
include_once 'footer.php';
?>