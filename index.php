<html>
<head>
    <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>

    <style>
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
        td.selected {
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
    </style>
    <script>
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
        $(document).ready(function() {
            $( "td" ).clickToggle(
                function() {
                    $( this ).addClass( "selected" );
                    recinput();
                }, function() {
                    $( this ).removeClass( "selected" );
                    recinput();
                }
            );
        });
        function  recinput(){
            $('.i').each(function( i ) {
             $('#in'+$(this).data('i')).html($(this).hasClass('selected'));

            });

        }
    </script>
</head>
<body>
<input type="text">
<button>read</button>
<button>write</button>



<table class="tb">
    <tr>
        <td data-i="1" class="h i" colspan="3">1</td>
    </tr>
    <tr>
        <td data-i="2" class="v i">2</td>
        <td></td>
        <td data-i="3" class="v i">3</td>
    </tr>
    <tr>
        <td data-i="4" class="h i" colspan="3">4</td>
    </tr>
    <tr>
        <td data-i="5" class="v i">5</td>
        <td></td>
        <td data-i="6" class="v i">6</td>
    </tr>
    <tr>
        <td  data-i="7" class="h i" colspan="3">7</td>
    </tr>

</table>


<table class="res">
    <tr>
        <th># </th>
        <th>input </th>
        <th> neural 1</th>
        <th> </th>
        <th> output </th>
    </tr>
    <tr>
        <td>1</td>
        <td id="in1"> </td>
        <td id="n1"></td>
        <td id="n1_2"> </td>
        <td> </td>
    </tr>

    <tr>
        <td>2</td>
        <td id="in2"> </td>
        <td id="n2"></td>
        <td id="n2_2"> </td>
        <td> </td>
    </tr>
    <tr>
        <td>3</td>
        <td id="in3"> </td>
        <td id="n3"></td>
        <td id="n3_2"> </td>
        <td> </td>
    </tr>
    <tr>
        <td>4</td>
        <td id="in4"> </td>
        <td id="n4"></td>
        <td id="n4_2"> </td>
        <td> </td>
    </tr>
    <tr>
        <td>5</td>
        <td id="in5"> </td>
        <td id="n5"></td>
        <td id="n5_2"> </td>
        <td> </td>
    </tr>
    <tr>
        <td>6</td>
        <td id="in6"> </td>
        <td id="n6"></td>
        <td id="n6_2"> </td>
        <td> </td>
    </tr>
    <tr>
        <td>7</td>
        <td id="in7"> </td>
        <td id="n7"></td>
        <td id="n7_2"> </td>
        <td> </td>
    </tr>
    <tr>
        <td>8</td>
        <td id="in8"> </td>
        <td id="n8"></td>
        <td id="n8_2"> </td>
        <td> </td>
    </tr>
    <tr>
        <td>9</td>
        <td id="in9"> </td>
        <td id="n9"></td>
        <td id="n9_2"> </td>
        <td> </td>
    </tr>
    <tr>
        <td>10</td>
        <td id="in10"> </td>
        <td id="n10"></td>
        <td id="n10_2"> </td>
        <td> </td>
    </tr>



</table>




</body>
</html>
