<?php
namespace App;

use mysqli;

class soal2
{
    public $mysql, $query;


    public function __construct()
    {
        $this->connection();
        $this->render();
    }

    public function render()
    {
        if (!empty($_POST['q'])) {
            $this->query = $_POST['q'];
        }

        $view = $this->view('index');
        $data = $this->data($this->query);

        echo str_replace("{{table}}",$data,$view);
    }

    private function view($view)
    {
        return file_get_contents($view.".view");
    }

    private function connection(){
        $svr = "localhost";
        $usr = "root";
        $psw = "";
        $dbs = "testdb";

        
        // Create connection
        $conn = new mysqli($svr, $usr, $psw,$dbs);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $this->mysql = $conn;
    }

    private function data($q){
        $table = "";

        $query = "select a.hobi,count(b.id) as count_person
        from hobi a
        join person b
        on b.id=a.person_id
        where a.hobi like '%".$q."%'
        group by a.hobi order by count_person desc";

        $result = mysqli_query($this->mysql, $query);
        $table .= "
            <table class='table table-hover'>
                <thead>
                    <th>Hobi</th>
                    <th>Jumlah Person</th>
                </thead>
                <tbody>
                
        ";
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $table .= "<tr>
                                <td>".$row['hobi']."</td>
                                <td>".number_format($row['count_person'])."</td>
                           </tr>";
            }
        } else {
            $table .= "<tr><td colspan='2'>Tidak ada Data</td></tr>";
        }
        $table .= "
                </tbody>
            </table>
        ";

        return $table;
    }

    private function dd(...$var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
}

new soal2;