<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .signal {
            height: 80px;
            aspect-ratio: 1/1;
            border-radius: 50%;
            background: #f00;
            margin: 10px auto;
        }

        .green {
            background: #green;
        }

        .yellow {
            background: #ff0
        }
    </style>
</head>

<body>
    <br>
    <div class="output"></div>
    <form action="ajax.php" method="POST" id="testForm">
        <div class="col-12 col-md-6">
            <div class="row">
                <?php $a=[4,3,1,2]; for($i=0;$i<4;$i++){ ?>
                    <div class="col-sm-3 card  p-5">
                        <div class="signal"></div>
                        <input type="text" class="form-control border-2 border-dark"  value="<?php echo $a[$i]?>" name="signal[]">
                    </div>
                <?php } ?>
            </div>
        </div>
        <br>
        <h4 class="col-12 col-md-6 px-3 status text-end"></h4>
        <div class="col-12 col-md-6 px-3">
            <div class="form-floating">
                <input type="text" class="form-control border-2 border-dark" name="GreenTime" value="5" placeholder="">
                <label for="">Green Signal Timing</label>
            </div>
        </div>
        <br>
        <div class="col-6 px-3">
            <div class="form-floating">
                <input type="text" class="form-control border-2 border-dark" name="YellowTime" value="3" placeholder="">
                <label for="">Yellow Signal Timing</label>
            </div>
        </div>
        <div class="row col-12 col-md-6 mt-3">
            <div class="col-6 col-md-6"></div>
            <div class="col-3">
                <label id="stop" class="btn btn-lg btn-danger w-100">Stop</label>
            </div>
            <div class="col-3">
                <label id="start" class="btn btn-lg btn-success w-100">Start</label>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            let polling = false;
            let requestInProgress = false;

            function getData(flag='') {
                if (!polling && flag !== 'start') return;

                if (requestInProgress) return;
                requestInProgress = true;

                formData = $('form').serialize();
                formData += (flag != '' ? '&flag='+flag:'');

                $.ajax({
                    url: 'ajax.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        requestInProgress = false;
                        const res = JSON.parse(response);
                        if(!polling){
                            return;
                        }
                        if('open' in res){
                            $('.signal').removeClass('bg-warning');
                            $('.signal').removeClass('bg-success');
                            $('.signal').eq(res.open).addClass('bg-success');
                            setTimeout(function(){
                               $('.signal').eq(res.next).addClass('bg-warning');
                            }, (res.GreenTime - res.YellowTime) * 1000);
                        }
                        if('stop' in res){
                            $('.status').html('<i class="text-danger">Stopped<i>');
                            polling = false;
                            return false;
                        }else if('invalid' in res){
                            alert('Please Enter Valid Data');
                            return;
                        }else{
                            setTimeout(() => {
                                getData();
                            }, (res.GreenTime * 1000));
                        }
                    },
                    error: function(xhr, status, error) {
                    },
                });
            }
            $('#start').on('click', function(e) {
                $('.status').html('<i class="text-success">Signal Started<i>');
                polling = true;
                getData('start');
            });
            
            $('#stop').on('click', function() {
                $('.status').html('<i class="text-danger">Stopped<i>');
                $('.signal').removeClass('bg-success bg-warning');
                polling = false;
                getData('stop');
            });
        });
    </script>

</body>

</html>


<?php

if (!function_exists('prd')) {
    function prd($a, $die = false)
    {
        echo '<pre>';
        print_r($a);
        echo '</pre>';
        if ($die) {
            die();
        }
    }
}
?>