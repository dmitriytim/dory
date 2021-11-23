<?php
class Perceptron{
    public $mul; //отмасштабированные сигналы
    public $weight; //коэфициенты связей
    public $sinaps; //синапсы
    public $sizeX;
    public $sizeY;
    public $filename;
    public $sum; //сумма сигналов
    public $limit; //порог

    public function __construct($filename){
        $this->sizeX=3;
        $this->sizeY=5;
        $this->limit=100;
        $this->filenameW="wp/w".$filename.".txt";
    }
    public function set_filenameP($filename){
        $this->filenameP=$filename;
    }
    public function save_weight_file(){
        $serialize = serialize($this->weight);
        fwrite( fopen($this->filenameW,"w"), $serialize);
    }
    public function load_weight_file(){
        if(file_exists($this->filenameW)){
            $this->weight = unserialize(file_get_contents($this->filenameW));
        }else{
            for($x=0;$x<$this->sizeX;$x++){
                for($y=0;$y<$this->sizeY;$y++){
                    $this->weight[$x][$y]="0";
                }
            }
        }
        //echo $this->filenameW;
        //print_r($this->weight);
    }
    public function load_file(){
        $im = imagecreatefrompng($this->filenameP);
        for($x=0;$x<$this->sizeX;$x++){
            for($y=0;$y<$this->sizeY;$y++){
                $rgb = imagecolorat($im, $x, $y);
                $color=imagecolorsforindex($im, $rgb);
                if($color['red']>127){
                    $color=0;
                }else{
                    $color=1;
                }
                $this->sinaps[$x][$y]=$color;
            }
        }
        imagedestroy($im);
    }
    public function mul_weights(){
        for($x=0;$x<$this->sizeX;$x++){
            for($y=0;$y<$this->sizeY;$y++){
                $this->mul[$x][$y]=$this->sinaps[$x][$y]*$this->weight[$x][$y];
            }
        }
    }
    public function sum_muls(){
        $this->sum=0;
        for($x=0;$x<$this->sizeX;$x++){
            for($y=0;$y<$this->sizeY;$y++){
                $this->sum+=$this->mul[$x][$y];
            }
        }
    }
    public function porog(){
        if($this->sum >= $this->limit){
            return true; //true - отнимаем
        }else{
            return false; //false - прибавляем
        }
    }
    public function teach_plus(){
        for($x=0;$x<$this->sizeX;$x++){
            for($y=0;$y<$this->sizeY;$y++){
                $this->weight[$x][$y]+=$this->sinaps[$x][$y];
            }
        }
    }
    public function teach_minus(){
        for($x=0;$x<$this->sizeX;$x++){
            for($y=0;$y<$this->sizeY;$y++){
                $this->weight[$x][$y]-=$this->sinaps[$x][$y];
            }
        }
    }
}
  function load_file($filenameP){
        $sinaps=[];
        $im = imagecreatefrompng($filenameP);
        $sizeX=imagesx($im);
        $sizeY=imagesy($im);

        for($x=0;$x<$sizeX;$x++){
            $sinaps[$x]=[];
            for($y=0;$y<$sizeY;$y++){
                $rgb = imagecolorat($im, $x, $y);
                $color=imagecolorsforindex($im, $rgb);
                if($color['red']>127){
                    $color=0;
                }else{
                    $color=1;
                }
                $sinaps[$x][$y]=$color;
            }
        }
        imagedestroy($im);
      //  print_r($sinaps);


      $errors_str='';




do {
          $errors = 0;
          for ($i = 0; $i < 10; $i++) {
              $perc[$i] = new Perceptron($i);
              $perc[$i]->set_filenameP($filenameP);
              $perc[$i]->load_weight_file();

              $perc[$i]->load_file();
              $perc[$i]->mul_weights();
              $perc[$i]->sum_muls();
              $porog[$i] = $perc[$i]->porog();
              $say = "false";
              if ($porog[$i]) {
                  $say = "true";
              }
              //  echo "Нейрон " . $i . " сказал " . $say;
              $n_=explode("-num",$filenameP);
              $n=(int)str_replace(".png","",$n_[1]);

              if ($i == $n) {
                  if ($porog[$i] == true) {
                      /*$perc[$i]->teach_minus();*/
                  } else {
                      $perc[$i]->teach_plus();
                      //        echo ", учим нейрон " . $i . " не говорить чепуху (плюсуем веса).";
                      $errors++;
                  }
              } else {
                  if ($porog[$i] == true) {
                      $perc[$i]->teach_minus();
                      //       echo ", учим нейрон " . $i . " не говорить чепуху (минусуем веса).";
                      $errors++;
                  } else {
                      /*$perc[$i]->teach_plus();*/
                  }
              }
            //  echo "<br>\n";
              $perc[$i]->save_weight_file();
          }
      //    echo "Наша нейронная сеть ошиблася " . $errors . " раз.";
    $errors_str.="Наша нейронная сеть ошиблася " . $errors . " раз.<br>";
          if ($errors > 0) {
              $allerror=0;
        //      echo " Продолжаем обучаться<br>\n<br>\n";
          } else {
              $finded = array_search('true', $porog);
         //    echo "<br>\nНейронная сеть определила на картинке: <span style=\"font-weight: bold; font-size:18px;\">" . $finded . "</span> <br>\n";
          }



} while ($errors != 0);









    echo json_encode(['res'=>$sinaps,'data'=>['f'=>$finded,'r'=>$errors_str]]);
    }
    if(isset($_POST['request'])&&$_POST['request']=='delete'){
        unlink('uploads/'.$_POST['name']);
        exit;
    }
// Check if image file is a actual image or fake image
if(isset($_FILES["file"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$check = getimagesize($_FILES["file"]["tmp_name"]);
if($check !== false) {
//echo "File is an image - " . $check["mime"] . ".";
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
     //   echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";

        load_file('uploads/'.$_FILES["file"]["name"]);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }




$uploadOk = 1;
} else {
echo "File is not an image.";
$uploadOk = 0;
}
exit;
}
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="./bootstrap-5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
       <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="js/dropzone.min.js"></script>
    <link href="css/dropzone.min.css" rel="stylesheet" type="text/css" />

    <style>
        .dz-error-mark {
            display: none;
        }
        .dz-success-mark {
            display: none;
        }
        table.tb tr td {
            align-content: center;
            text-align: center;
        }
        table.tb {
            width: 100px;
            float: left;
            margin-right: 25px;
        }
        td.v {
            width: 15px;
            height: 60px;
        }
        .selected {
            background-color: black;
            color: white;
        }
        table.res {
            width: 200px;

            margin-right: 25px;

        }
        table.res {
            border: 1px solid black;
        }

        .dz-image img {
            min-width: 59px;
        }
        .x {
            float: left;

        }
        .y{
            text-align: center;
            height: 4px;
            width: 4px;
        }
    </style>
    <script>
        class Dory {
             mul=[]; //отмасштабированные сигналы
             weight= []; //коэфициенты связей
             sinaps=[]; //синапсы
             sizeX;
             sizeY;
             filename;
             sum; //сумма сигналов
             limit; //порог

            constructor() {
                this.sizeX=3;
                this.sizeY=5;
                this.mul=Array(this.sizeX);
                this.weight=new Array(this.sizeX);
                this.sinaps=Array(this.sizeX);
                for(let x=0;x<this.sizeX;x++){
                    this.mul[x]=new Array(this.sizeY);
                    this.weight[x]=new Array(this.sizeY);
                    this.sinaps[x]=new Array(this.sizeY);
                    for(let y=0;y<this.sizeY;y++){
                        this.mul[x][y]  =1;
                        this.weight[x][y]  =1;
                    }
                }

                this.limit=100;

            }

            mul_weights(){
                for(let x=0;x<this.sizeX;x++){
                    for(let y=0;y<this.sizeY;y++){
                        this.mul[x][y]=this.sinaps[x][y]*this.weight[x][y];
                    }
                }
            }
             sum_muls(){
                this.sum=0;
                for(let x=0; x< this.sizeX;x++){
                    for(let y=0;y<this.sizeY;y++){
                        this.sum+=this.mul[x][y];
                    }
                }
            }
             porog(){
                if(this.sum >= this.limit){
                    return true; //true - отнимаем
                }else{
                    return false; //false - прибавляем
                }
            }
             teach_plus(){
                for(let x=0;x<this.sizeX;x++){
                    for(let y=0;y<this.sizeY;y++){
                        this.weight[x][y]+=this.sinaps[x][y];
                    }
                }
            }
             teach_minus(){
                for(let x=0;x<this.sizeX;x++){
                    for(let y=0;y<this.sizeY;y++){
                        this.weight[x][y]-=this.sinaps[x][y];
                    }
                }
            }



             save_weight_file(){
               console.log(this.weight)
            }
             load_weight_file(){
                if(this.weight.length){
                    console.log(this.weight);
                }else{
                    for(let x=0; x<this.sizeX;x++){
                        for(let y=0;y<this.sizeY;y++){
                            this.weight[x][y]=0;
                        }
                    }
                }
            }


        }

        perc = new Dory();
        let mind= [];
        let i_input= [];
        (function($) {
            $.fn.clickToggle = function(func1, func2) {
                var funcs = [func1, func2];
                this.data('toggleclicked', 0);
                this.click(function() {
                    var data = $(this).data();
                    var tc = data.toggleclicked;
                    $.proxy(funcs[tc], this)();
                    data.toggleclicked = (tc + 1) % 2;
                });
                return this;
            };
        }(jQuery));
        function  recinput(){
            $('.i').each(function( i ) {
             $('#in'+$(this).data('i')).html($(this).hasClass('selected'));
                i_input[$(this).data('i')]=$(this).hasClass('selected');
            });
        }
        function iread(){
            console.log($('#input').val());
            console.log(i_input);
        }
        function iwrite(){
            perc.load_weight_file();
            for (let i = 0; i < 10; i++) {
            perc.mul_weights();
            perc.sum_muls();
            porog = perc.porog();
                let say = "false";
                if (porog) {
                    say = "true";
                }
                let n = parseInt($('#input').val());
                if (i == n) {
                    if (porog == true) {
                        /*$perc[$i]->teach_minus();*/
                    } else {
                        perc.teach_plus();
                        //        echo ", учим нейрон " . $i . " не говорить чепуху (плюсуем веса).";
                        errors++;
                    }
                } else {
                    if (porog == true) {
                        perc.teach_minus();
                        //       echo ", учим нейрон " . $i . " не говорить чепуху (минусуем веса).";
                        errors++;
                    } else {
                        /*$perc[$i]->teach_plus();*/
                    }
                }


            console.log($('#input').val());
            console.log(i_input);
            }
          //  perc.teach_plus();
         //   perc.teach_minus();
        }

        $(document).ready(function() {

            var isDown = false;   // Tracks status of mouse button

            $(document).mousedown(function() {
                isDown = true;      // When mouse goes down, set isDown to true
            })
                .mouseup(function() {
                    isDown = false;    // When mouse goes up, set isDown to false
                });



            Dropzone.autoDiscover = false;


            $("div#my-awesome-dropzone").dropzone({
                 url: "index.php",
                maxFilesize: 10,
                acceptedFiles: ".png",
                success: function(file, response){

                    var arr_ = jQuery.parseJSON(response)
                    arr=arr_.res;
                    $('.res').html(arr_.data.f +' <br>'+arr_.data.r);
                    let str='';
                    for (var x = 0; x < arr.length; x++){
                        str+='<div class="x">';
                        for (var y = 0; y < arr[x].length; y++){
                            str+='<div data-i="'+arr[x][y]+'" class="y '+(arr[x][y]?'selected':'')+'"></div>';
                        }
                        str+='</div>';

                    }
                   // console.log(str);
                    $('.tb').html(str);
                    $(".y").mouseover(function() {
                        if (isDown) {        // Only change css if mouse is down
                            $(this).css({background: "#333333"});
                            console.log($(this).hasClass('selected'));
                            if($(this).hasClass('selected')){
                                $(this).removeClass("selected");
                                $(this).data("i",0);

                            }else{
                                $(this).addClass("selected");
                                $(this).data("i",1);
                            }
                            recinput();
                        }
                    });
                },
                addRemoveLinks: true,
                removedfile: function(file) {
                    var fileName = file.name;
                    $.ajax({
                        type: 'POST',
                        url: 'index.php',
                        data: {name: fileName,request: 'delete'},
                        sucess: function(data){
                            console.log('success: ' + data);
                        }
                    });

                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                }
            });


        });

    </script>

</head>
<body>

<div class="container">
    <div class="row text-center">
        <div class="col">
            <h1>Dory</h1>
        </div>
    </div>
    <div class="row text-center">
        <div class="col ">
            <div  id="my-awesome-dropzone">
drop
            </div>

            <input id="name" type="text">
            <button onclick="iread()">read</button>
            <button onclick="iwrite()">write</button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            Column
            <div class="tb">
            </div>
        </div>
        <div class="col">
            Column
            <div class="res">
            </div>
        </div>

    </div>
</div>










</body>
</html>
