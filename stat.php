<?php
    include_once 'header.php';

    $serverName = "localhost";
    $userName = "root";
    $pass = "";
    $bdName = "app_db";
    $charset = "utf8";

    $dsn = "mysql:host=$serverName;dbname=$bdName;charset=$charset";

    $opt = [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $userName, $pass, $opt);

    function debug($data) {
        echo '<pre>'.print_r($data, return: 1),'</pre>';
    } 

    function get_open(int $id) : array{
        global $pdo;
        $res = $pdo->query("SELECT managers.name as name, count(contr_id) as count_c
        from `managers`, `contracts`
        where parent_id = $id and managers.Man_Id = contracts.man_id and contracts.DayTo >= sysdate()
        GROUP by (managers.name);");
        $data = [];
        while($row = $res->fetch()) {
            $data[$row['name']] = $row['count_c'];
        }
        return $data;

    }
    function get_close(int $id) : array{
      global $pdo;
      $res = $pdo->query("SELECT managers.name as name, count(contr_id) as count_c
      from `managers`, `contracts`
      where parent_id = $id and managers.Man_Id = contracts.man_id and contracts.DayTo < sysdate()
      GROUP by (managers.name);");
      $data = [];
      while($row = $res->fetch()) {
          $data[$row['name']] = $row['count_c'];
      }
      return $data;

  }

    $mid = $_SESSION['mid'];
    //debug(get_open($mid));
    $managers_op = get_open($mid);
    $labels_op = "'".implode("', '", array_keys($managers_op))."'";
    $values_op = implode(', ',  $managers_op);


    $managers_cl = get_close($mid);
    $labels_cl = "'".implode("', '", array_keys($managers_cl))."'";
    $values_cl = implode(', ',  $managers_cl);
    //echo $values_cl;


?>






<div class='container'> 
        <div class='row mb-3'>
            <div class='col-md-6'>
              <label class="form-label"> Открытые контракты </label> <br>
              <div class='Open' style='padding : 10px'>
                  <canvas id='open'></canvas>
              </div>
            </div>
            <div class='col-md-6' >
              <label class="form-label"> Закрытые контракты </label> <br>
                <div class='Close' style='padding: 10px'>
                    <canvas id='close'> </canvas>
                </div>
            </div>
        </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = [<?= $labels_op ?>];
const data = {
  labels: labels,
  datasets: [{  
    label: "Количество контрактов",
    data: [<?= $values_op ?>],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
    ],
    borderWidth: 1
  }]
};

const config = {
  type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    },
    plugins: {
            legend: {
                display: true,
            }
        }
    
  },
};

const myChart = new Chart(
  document.getElementById('open'), 
  config
)
</script>

<script>
const labels1 = [<?= $labels_cl ?>];
const data1 = {
  labels: labels1,
  datasets: [{
    label: "Количество контрактов",
    data: [<?= $values_cl ?>],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
    ],
    borderWidth: 1
  }]
};

const config1 = {
  type: 'bar',
  data: data1,
  options: {
    scales: {
      y: {
        beginAtZero: true,
      }
    },
    plugins: {
            legend: {
                display: true,
            }
        }
  },
};

const myChart1 = new Chart(
  document.getElementById('close'), 
  config1
)
</script>
<?php
include_once 'footer.php';
?>