<?php
namespace App;

class soal1
{

    public $action, $form2;

    public function __construct()
    {
        if (!empty($_POST['submit'])) {
            $this->action = $_POST['submit'];
        }
        $this->render();
    }

    public function render()
    {

        switch ($this->action) {
            case 'step2':
                $this->step2();
            break;
            
            case 'step3':
                $this->step3();
            break;

            default:
                $this->step1();
                break;
        }
        
    }

    private function step1(){
        echo $this->view("form-1");
    }

    private function step2(){
        $row = $_POST['baris'];
        $col = $_POST['kolom'];
        $html = "";
        for ($r=0; $r < $row; $r++) {
            $rx = $r+1;
            $html .= "<div class='row'>";
            for ($c=0; $c < $col; $c++) {
                $cx = $c+1;
                $html .= "
                    <div class='col'>
                        <div class='mb-3'>
                            <label for='".$rx.".".$cx."' class='form-label'>Input Form ". $rx .".". $cx ." </label>
                            <input type='text' class='form-control' id='".$rx.".".$cx."' name='".$rx.".".$cx."' placeholder='Form Input Baris ". $rx ." kolom ". $cx ."'>
                        </div>
                    </div>";
            }
            $html .= "<div>";

        }
        $view = $this->view('form-2');
        echo str_replace('{{form}}',$html,$view);
    }

    private function step3(){
        $data = $_POST;
        unset($data['submit']);
        $html = "";
        
        foreach ($data as $k => $v) {
            $html .= "<b>".str_replace("_",".",$k) . " : ". $v."</b><br>";
        }
        $view = $this->view('form-3');
        echo str_replace('{{hasil}}',$html,$view);
    }



    private function view($view)
    {
        return file_get_contents($view.".view");
    }

    private function dd(...$var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
}


new soal1;