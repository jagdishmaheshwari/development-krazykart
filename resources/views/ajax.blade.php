<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Data = [];
    $file_path = 'data.json';
    $signalArray = $_POST['signal'];
    asort($signalArray);
    if(isset($_POST['GreenTime']) && $_POST['GreenTime'] != '' && isset($_POST['YellowTime']) != '' && $_POST['YellowTime'] && isset($_POST['signal']) && count($_POST['signal']) == 4 && array_values($signalArray) == [1,2,3,4]){
        if(isset($_POST['flag']) && $_POST['flag'] == 'stop'){
            file_put_contents($file_path, json_encode(''));
            echo json_encode(['stop' => 1]);
            exit();
        }else{
            if(isset($_POST['flag']) && $_POST['flag'] == 'start'){
                $Data['GreenTime'] = $_POST['GreenTime'];
                $Data['YellowTime'] = $_POST['YellowTime'];
                $Data['sequence'] = $_POST['signal'];
                
                $open = array_search(1 , $_POST['signal']);
                $next = array_search(2 , $_POST['signal']);
                $Data['open'] = 1;
                file_put_contents($file_path, json_encode($Data));
                echo json_encode(['open' => $open, 'GreenTime' => $Data['GreenTime'], 'YellowTime' => $Data['YellowTime'] ,'next' => $next]);
                exit();
            }

            $FileData = json_decode(file_get_contents($file_path) , true);
            
            // if($FileData['open'] == 3){
            //     $FileData['open'] = 0;
            // }else{
            //     $FileData['open'] = $FileData['open'] + 1;
            // }

            $Response = [];

            $Prev = $FileData['open']; // $FileData['sequence'][$FormData['open']];

            $Curr = $Prev + 1 >= 4 ? 0 : $Prev + 1;
            $CurrKey = array_search($Curr, $FileData['sequence']);
            $Response['open'] = $CurrKey;
            $FileData['open'] = $Curr;
            
            $Next = $Prev + 2 >= 4 ? 0 : $Prev + 2; 
            $NextKey = array_search($Next, $FileData['sequence']);
            $Response['next'] = $NextKey;


            // $openIndex = $FileData['sequence'][$FileData['open']]; // array_search($FileData['open'], $FileData['sequence']);
            // $openIndex = $openIndex < 4 ? $openIndex : 1;
            
            // $nextIndex =  array_search($FileData['open'], $FileData['sequence']);
            // $nextIndex = $nextIndex !== false ? $nextIndex : 1;
            $Reponse['GreenTime'] = $FileData['GreenTime'];
            $Reponse['YellowTime'] = $FileData['YellowTime'];
            echo json_encode($Reponse
                // 'open' => $CurrKey,
                // 'GreenTime' => $FileData['GreenTime'],
                // 'YellowTime' => $FileData['YellowTime'],
                // 'next' => $NextKey
            );
            file_put_contents($file_path, json_encode($FileData));

        }
    }else{
        echo json_encode(['invalid' => 1]);
        die();
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>