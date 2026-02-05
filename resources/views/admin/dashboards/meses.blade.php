<?php

if(isset($_POST['data_fim'])){

    //echo 'Data Base'.$database;
    $databaseex = explode('/',$_POST['data_fim']);
    $databaseano = $databaseex[2];
    $databasemes = $databaseex[1];
    $databasedia = $databaseex[0];
    //Data para consultas
    $database = $databaseex[2].'-'.$databaseex[1].'-'.$databaseex[0];
    
    $datafinal_mes1 = date("Y-m-d", strtotime("+0 day",strtotime($database))); 
    $datainicial_mes1 = date("Y-m-01", strtotime("+0 day",strtotime($database)));
    $mes1 = date("m", strtotime("+0 day",strtotime($database)));
    
    if($databaseex[0] == 30){
        //Menos 1 Mes
        
        $rec_data2 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 1 MONTH)) as data');
        $rec_data2->execute();
        $row_rec_data2 = $rec_data2->fetch(PDO::FETCH_ASSOC);
        $mes_explodir2 = explode('-', $row_rec_data2['data']);
        $mes2 = $mes_explodir2[1];
        $datafinal_mes2 = $row_rec_data2['data'];
        $datainicial_mes2 = $mes_explodir2[0].'-'.$mes_explodir2[1].'-1';
    
        //Menos 2 Meses
        $rec_data3 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 2 MONTH)) as data');
        $rec_data3->execute();
        $row_rec_data3 = $rec_data3->fetch(PDO::FETCH_ASSOC);
        $mes_explodir3 = explode('-', $row_rec_data3['data']);
        $mes3 = $mes_explodir3[1];
        $datafinal_mes3 = $row_rec_data3['data'];
        $datainicial_mes3 = $mes_explodir3[0].'-'.$mes_explodir3[1].'-1';
    
        //Menos 3 Meses
        $rec_data4 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 3 MONTH)) as data');
        $rec_data4->execute();
        $row_rec_data4 = $rec_data4->fetch(PDO::FETCH_ASSOC);
        $mes_explodir4 = explode('-', $row_rec_data4['data']);
        $mes4 = $mes_explodir4[1];
        $datafinal_mes4 = $row_rec_data4['data'];
        $datainicial_mes4 = $mes_explodir4[0].'-'.$mes_explodir4[1].'-1';
    
        //Menos 4 Meses
        $rec_data5 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 4 MONTH)) as data');
        $rec_data5->execute();
        $row_rec_data5 = $rec_data5->fetch(PDO::FETCH_ASSOC);
        $mes_explodir5 = explode('-', $row_rec_data5['data']);
        $mes5 = $mes_explodir5[1];
        $datafinal_mes5 = $row_rec_data5['data'];
        $datainicial_mes5 = $mes_explodir5[0].'-'.$mes_explodir5[1].'-1';
    
        //Menos 5 Meses
        $rec_data6 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 5 MONTH)) as data');
        $rec_data6->execute();
        $row_rec_data6 = $rec_data6->fetch(PDO::FETCH_ASSOC);
        $mes_explodir6 = explode('-', $row_rec_data6['data']);
        $mes6 = $mes_explodir6[1];
        $datafinal_mes6 = $row_rec_data6['data'];
        $datainicial_mes6 = $mes_explodir6[0].'-'.$mes_explodir6[1].'-1';
    
        //Menos 6 Meses
        $rec_data7 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 6 MONTH)) as data');
        $rec_data7->execute();
        $row_rec_data7 = $rec_data7->fetch(PDO::FETCH_ASSOC);
        $mes_explodir7 = explode('-', $row_rec_data7['data']);
        $mes7 = $mes_explodir7[1];
        $datafinal_mes7 = $row_rec_data7['data'];
        $datainicial_mes7 = $mes_explodir7[0].'-'.$mes_explodir7[1].'-1';
    
        //Menos 7 Meses
        $rec_data8 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 7 MONTH)) as data');
        $rec_data8->execute();
        $row_rec_data8 = $rec_data8->fetch(PDO::FETCH_ASSOC);
        $mes_explodir8 = explode('-', $row_rec_data8['data']);
        $mes8 = $mes_explodir8[1];
        $datafinal_mes8 = $row_rec_data8['data'];
        $datainicial_mes8 = $mes_explodir8[0].'-'.$mes_explodir8[1].'-1';
    
        //Menos 8 Meses
        $rec_data9 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 8 MONTH)) as data');
        $rec_data9->execute();
        $row_rec_data9 = $rec_data9->fetch(PDO::FETCH_ASSOC);
        $mes_explodir9 = explode('-', $row_rec_data9['data']);
        $mes9 = $mes_explodir9[1];
        $datafinal_mes9 = $row_rec_data9['data'];
        $datainicial_mes9 = $mes_explodir9[0].'-'.$mes_explodir9[1].'-1';
    
        //Menos 9 Meses
        $rec_data10 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 9 MONTH)) as data');
        $rec_data10->execute();
        $row_rec_data10 = $rec_data10->fetch(PDO::FETCH_ASSOC);
        $mes_explodir10 = explode('-', $row_rec_data10['data']);
        $mes10 = $mes_explodir10[1];
        $datafinal_mes10 = $row_rec_data10['data'];
        $datainicial_mes10 = $mes_explodir10[0].'-'.$mes_explodir10[1].'-1';
    
        //Menos 10 Meses
        $rec_data11 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 10 MONTH)) as data');
        $rec_data11->execute();
        $row_rec_data11 = $rec_data11->fetch(PDO::FETCH_ASSOC);
        $mes_explodir11 = explode('-', $row_rec_data11['data']);
        $mes11 = $mes_explodir11[1];
        $datafinal_mes11 = $row_rec_data11['data'];
        $datainicial_mes11 = $mes_explodir11[0].'-'.$mes_explodir11[1].'-1';
    
        //Menos 11 Meses
        $rec_data12 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 11 MONTH)) as data');
        $rec_data12->execute();
        $row_rec_data12 = $rec_data12->fetch(PDO::FETCH_ASSOC);
        $mes_explodir12 = explode('-', $row_rec_data12['data']);
        $mes12 = $mes_explodir12[1];
        $datafinal_mes12 = $row_rec_data12['data'];
        $datainicial_mes12 = $mes_explodir12[0].'-'.$mes_explodir12[1].'-1';
    
        //Menos 12 Meses
        $rec_data13 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 12 MONTH)) as data');
        $rec_data13->execute();
        $row_rec_data13 = $rec_data13->fetch(PDO::FETCH_ASSOC);
        $mes_explodir13 = explode('-', $row_rec_data13['data']);
        $mes13 = $mes_explodir13[1];
        $datafinal_mes13 = $row_rec_data13['data'];
        $datainicial_mes13 = $mes_explodir13[0].'-'.$mes_explodir13[1].'-1';
    
        //Menos 13 Meses
        $rec_data14 = $pdo->prepare('SELECT last_day(DATE_SUB('."'$database'".', INTERVAL 13 MONTH)) as data');
        $rec_data14->execute();
        $row_rec_data14 = $rec_data14->fetch(PDO::FETCH_ASSOC);
        $mes_explodir14 = explode('-', $row_rec_data14['data']);
        $mes14 = $mes_explodir14[1];
        $datafinal_mes14 = $row_rec_data14['data'];
        $datainicial_mes14 = $mes_explodir14[0].'-'.$mes_explodir14[1].'-1';
            
    }else{
   
        //Menos 1 Mes
        $rec_data2 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -1 month) as data');
        $rec_data2->execute();
        $row_rec_data2 = $rec_data2->fetch(PDO::FETCH_ASSOC);
        $mes_explodir2 = explode('-', $row_rec_data2['data']);
        $mes2 = $mes_explodir2[1];
        $datafinal_mes2 = $row_rec_data2['data'];
        $datainicial_mes2 = $mes_explodir2[0].'-'.$mes_explodir2[1].'-1';
        
        //Menos 2 Meses
        $rec_data3 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -2 month) as data');
        $rec_data3->execute();
        $row_rec_data3 = $rec_data3->fetch(PDO::FETCH_ASSOC);
        $mes_explodir3 = explode('-', $row_rec_data3['data']);
        $mes3 = $mes_explodir3[1];
        $datafinal_mes3 = $row_rec_data3['data'];
        $datainicial_mes3 = $mes_explodir3[0].'-'.$mes_explodir3[1].'-1';
        
        //Menos 3 Meses
        $rec_data4 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -3 month) as data');
        $rec_data4->execute();
        $row_rec_data4 = $rec_data4->fetch(PDO::FETCH_ASSOC);
        $mes_explodir4 = explode('-', $row_rec_data4['data']);
        $mes4 = $mes_explodir4[1];
        $datafinal_mes4 = $row_rec_data4['data'];
        $datainicial_mes4 = $mes_explodir4[0].'-'.$mes_explodir4[1].'-1';
        
        //Menos 4 Meses
        $rec_data5 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -4 month) as data');
        $rec_data5->execute();
        $row_rec_data5 = $rec_data5->fetch(PDO::FETCH_ASSOC);
        $mes_explodir5 = explode('-', $row_rec_data5['data']);
        $mes5 = $mes_explodir5[1];
        $datafinal_mes5 = $row_rec_data5['data'];
        $datainicial_mes5 = $mes_explodir5[0].'-'.$mes_explodir5[1].'-1';
        
        //Menos 5 Meses
        $rec_data6 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -5 month) as data');
        $rec_data6->execute();
        $row_rec_data6 = $rec_data6->fetch(PDO::FETCH_ASSOC);
        $mes_explodir6 = explode('-', $row_rec_data6['data']);
        $mes6 = $mes_explodir6[1];
        $datafinal_mes6 = $row_rec_data6['data'];
        $datainicial_mes6 = $mes_explodir6[0].'-'.$mes_explodir6[1].'-1';
        
        //Menos 6 Meses
        $rec_data7 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -6 month) as data');
        $rec_data7->execute();
        $row_rec_data7 = $rec_data7->fetch(PDO::FETCH_ASSOC);
        $mes_explodir7 = explode('-', $row_rec_data7['data']);
        $mes7 = $mes_explodir7[1];
        $datafinal_mes7 = $row_rec_data7['data'];
        $datainicial_mes7 = $mes_explodir7[0].'-'.$mes_explodir7[1].'-1';
        
        //Menos 7 Meses
        $rec_data8 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -7 month) as data');
        $rec_data8->execute();
        $row_rec_data8 = $rec_data8->fetch(PDO::FETCH_ASSOC);
        $mes_explodir8 = explode('-', $row_rec_data8['data']);
        $mes8 = $mes_explodir8[1];
        $datafinal_mes8 = $row_rec_data8['data'];
        $datainicial_mes8 = $mes_explodir8[0].'-'.$mes_explodir8[1].'-1';
        
        //Menos 8 Meses
        $rec_data9 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -8 month) as data');
        $rec_data9->execute();
        $row_rec_data9 = $rec_data9->fetch(PDO::FETCH_ASSOC);
        $mes_explodir9 = explode('-', $row_rec_data9['data']);
        $mes9 = $mes_explodir9[1];
        $datafinal_mes9 = $row_rec_data9['data'];
        $datainicial_mes9 = $mes_explodir9[0].'-'.$mes_explodir9[1].'-1';
        
        //Menos 9 Meses
        $rec_data10 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -9 month) as data');
        $rec_data10->execute();
        $row_rec_data10 = $rec_data10->fetch(PDO::FETCH_ASSOC);
        $mes_explodir10 = explode('-', $row_rec_data10['data']);
        $mes10 = $mes_explodir10[1];
        $datafinal_mes10 = $row_rec_data10['data'];
        $datainicial_mes10 = $mes_explodir10[0].'-'.$mes_explodir10[1].'-1';
        
        //Menos 10 Meses
        $rec_data11 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -10 month) as data');
        $rec_data11->execute();
        $row_rec_data11 = $rec_data11->fetch(PDO::FETCH_ASSOC);
        $mes_explodir11 = explode('-', $row_rec_data11['data']);
        $mes11 = $mes_explodir11[1];
        $datafinal_mes11 = $row_rec_data11['data'];
        $datainicial_mes11 = $mes_explodir11[0].'-'.$mes_explodir11[1].'-1';
        
        //Menos 11 Meses
        $rec_data12 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -11 month) as data');
        $rec_data12->execute();
        $row_rec_data12 = $rec_data12->fetch(PDO::FETCH_ASSOC);
        $mes_explodir12 = explode('-', $row_rec_data12['data']);
        $mes12 = $mes_explodir12[1];
        $datafinal_mes12 = $row_rec_data12['data'];
        $datainicial_mes12 = $mes_explodir12[0].'-'.$mes_explodir12[1].'-1';
        
        //Menos 12 Meses
        $rec_data13 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -12 month) as data');
        $rec_data13->execute();
        $row_rec_data13 = $rec_data13->fetch(PDO::FETCH_ASSOC);
        $mes_explodir13 = explode('-', $row_rec_data13['data']);
        $mes13 = $mes_explodir13[1];
        $datafinal_mes13 = $row_rec_data13['data'];
        $datainicial_mes13 = $mes_explodir13[0].'-'.$mes_explodir13[1].'-1';
    }
}else{
	
    //acumulado
    $data1Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL 0 MONTH) AS data");
    $data1Acumulado->execute();
    $row1Acumulado = $data1Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir1Acumulado = explode('-', $row1Acumulado['data']);
    $mes1Acumulado = $mes_explodir1Acumulado[1];
    $datafinal_mes1Acumulado = $row1Acumulado['data'];
    $datainicial_mes1Acumulado = $mes_explodir1Acumulado[0].'-'.$mes_explodir1Acumulado[1].'-1';
        
    //Menos 1 Mes
    $data2Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -1 MONTH) AS data");
    $data2Acumulado->execute();
    $row2Acumulado = $data2Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir2Acumulado = explode('-', $row2Acumulado['data']);
    $mes2Acumulado = $mes_explodir2Acumulado[1];
    $datafinal_mes2Acumulado = $row2Acumulado['data'];
    $datainicial_mes2Acumulado = $mes_explodir2Acumulado[0].'-'.$mes_explodir2Acumulado[1].'-1';
    
    
    //Menos 2 Mes
    $data3Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -2 MONTH) AS data");
    $data3Acumulado->execute();
    $row3Acumulado = $data3Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir3Acumulado = explode('-', $row3Acumulado['data']);
    $mes3Acumulado = $mes_explodir3Acumulado[1];
    $datafinal_mes3Acumulado = $row3Acumulado['data'];
    $datainicial_mes3Acumulado = $mes_explodir3Acumulado[0].'-'.$mes_explodir3Acumulado[1].'-1';
    
    //Menos 3 Mes
    $data4Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -3 MONTH) AS data");
    $data4Acumulado->execute();
    $row4Acumulado = $data4Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir4Acumulado = explode('-', $row4Acumulado['data']);
    $mes4Acumulado = $mes_explodir4Acumulado[1];
    $datafinal_mes4Acumulado = $row4Acumulado['data'];
    $datainicial_mes4Acumulado = $mes_explodir4Acumulado[0].'-'.$mes_explodir4Acumulado[1].'-1';
    
    
    //Menos 4 Mes
    $data5Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -4 MONTH) AS data");
    $data5Acumulado->execute();
    $row5Acumulado = $data5Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir5Acumulado = explode('-', $row5Acumulado['data']);
    $mes5Acumulado = $mes_explodir5Acumulado[1];
    $datafinal_mes5Acumulado = $row5Acumulado['data'];
    $datainicial_mes5Acumulado = $mes_explodir5Acumulado[0].'-'.$mes_explodir5Acumulado[1].'-1';
    
    //Menos 5 Mes
    $data6Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -5 MONTH) AS data");
    $data6Acumulado->execute();
    $row6Acumulado = $data6Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir6Acumulado = explode('-', $row6Acumulado['data']);
    $mes6Acumulado = $mes_explodir6Acumulado[1];
    $datafinal_mes6Acumulado = $row6Acumulado['data'];
    $datainicial_mes6Acumulado = $mes_explodir6Acumulado[0].'-'.$mes_explodir6Acumulado[1].'-1';
    
    
    //Menos 6 Mes
    $data7Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -6 MONTH) AS data");
    $data7Acumulado->execute();
    $row7Acumulado = $data7Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir7Acumulado = explode('-', $row7Acumulado['data']);
    $mes7Acumulado = $mes_explodir7Acumulado[1];
    $datafinal_mes7Acumulado = $row7Acumulado['data'];
    $datainicial_mes7Acumulado = $mes_explodir7Acumulado[0].'-'.$mes_explodir7Acumulado[1].'-1';
    
    //Menos 7 Mes
    $data8Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -7 MONTH) AS data");
    $data8Acumulado->execute();
    $row8Acumulado = $data8Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir8Acumulado = explode('-', $row8Acumulado['data']);
    $mes8Acumulado = $mes_explodir8Acumulado[1];
    $datafinal_mes8Acumulado = $row8Acumulado['data'];
    $datainicial_mes8Acumulado = $mes_explodir8Acumulado[0].'-'.$mes_explodir8Acumulado[1].'-1';
    
    //Menos 8 Mes
    $data9Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -8 MONTH) AS data");
    $data9Acumulado->execute();
    $row9Acumulado = $data9Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir9Acumulado = explode('-', $row9Acumulado['data']);
    $mes9Acumulado = $mes_explodir9Acumulado[1];
    $datafinal_mes9Acumulado = $row9Acumulado['data'];
    $datainicial_mes9Acumulado = $mes_explodir9Acumulado[0].'-'.$mes_explodir9Acumulado[1].'-1';
    
    //Menos 9 Mes
    $data10Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -9 MONTH) AS data");
    $data10Acumulado->execute();
    $row10Acumulado = $data10Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir10Acumulado = explode('-', $row10Acumulado['data']);
    $mes10Acumulado = $mes_explodir10Acumulado[1];
    $datafinal_mes10Acumulado = $row10Acumulado['data'];
    $datainicial_mes10Acumulado = $mes_explodir10Acumulado[0].'-'.$mes_explodir10Acumulado[1].'-1';
    
    //Menos 10 Mes
    $data11Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -10 MONTH) AS data");
    $data11Acumulado->execute();
    $row11Acumulado = $data11Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir11Acumulado = explode('-', $row11Acumulado['data']);
    $mes11Acumulado = $mes_explodir11Acumulado[1];
    $datafinal_mes11Acumulado = $row11Acumulado['data'];
    $datainicial_mes11Acumulado = $mes_explodir11Acumulado[0].'-'.$mes_explodir11Acumulado[1].'-1';
    
    //Menos 11 Mes
    $data12Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -11 MONTH) AS data");
    $data12Acumulado->execute();
    $row12Acumulado = $data12Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir12Acumulado = explode('-', $row12Acumulado['data']);
    $mes12Acumulado = $mes_explodir12Acumulado[1];
    $datafinal_mes12Acumulado = $row12Acumulado['data'];
    $datainicial_mes12Acumulado = $mes_explodir12Acumulado[0].'-'.$mes_explodir12Acumulado[1].'-1';
    
    //Menos 12 Mes
    $data13Acumulado = $pdo->prepare("SELECT LAST_DAY(CURDATE() + INTERVAL -12 MONTH) AS data");
    $data13Acumulado->execute();
    $row13Acumulado = $data13Acumulado->fetch(PDO::FETCH_ASSOC);
    
    $mes_explodir13Acumulado = explode('-', $row13Acumulado['data']);
    $mes13Acumulado = $mes_explodir13Acumulado[1];
    $datafinal_mes13Acumulado = $row13Acumulado['data'];
    $datainicial_mes13Acumulado = $mes_explodir13Acumulado[0].'-'.$mes_explodir13Acumulado[1].'-1';
    //fim acumulado
    
    //Pega a data atual
    $datafinal_mes1 = date('Y-m-d'); 
    $datainicial_mes1 = date('Y-m-01');

    //Menos 1 Mes
    $rec_data2 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -1 month) as data');
    $rec_data2->execute();
    $row_rec_data2 = $rec_data2->fetch(PDO::FETCH_ASSOC);
    $mes_explodir2 = explode('-', $row_rec_data2['data']);
    $mes2 = $mes_explodir2[1];
    $datafinal_mes2 = $row_rec_data2['data'];
    $datainicial_mes2 = $mes_explodir2[0].'-'.$mes_explodir2[1].'-1';
    
    //Menos 2 Meses
    $rec_data3 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -2 month) as data');
    $rec_data3->execute();
    $row_rec_data3 = $rec_data3->fetch(PDO::FETCH_ASSOC);
    $mes_explodir3 = explode('-', $row_rec_data3['data']);
    $mes3 = $mes_explodir3[1];
    $datafinal_mes3 = $row_rec_data3['data'];
    $datainicial_mes3 = $mes_explodir3[0].'-'.$mes_explodir3[1].'-1';
    
    //Menos 3 Meses
    $rec_data4 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -3 month) as data');
    $rec_data4->execute();
    $row_rec_data4 = $rec_data4->fetch(PDO::FETCH_ASSOC);
    $mes_explodir4 = explode('-', $row_rec_data4['data']);
    $mes4 = $mes_explodir4[1];
    $datafinal_mes4 = $row_rec_data4['data'];
    $datainicial_mes4 = $mes_explodir4[0].'-'.$mes_explodir4[1].'-1';
    
    //Menos 4 Meses
    $rec_data5 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -4 month) as data');
    $rec_data5->execute();
    $row_rec_data5 = $rec_data5->fetch(PDO::FETCH_ASSOC);
    $mes_explodir5 = explode('-', $row_rec_data5['data']);
    $mes5 = $mes_explodir5[1];
    $datafinal_mes5 = $row_rec_data5['data'];
    $datainicial_mes5 = $mes_explodir5[0].'-'.$mes_explodir5[1].'-1';
    
    //Menos 5 Meses
    $rec_data6 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -5 month) as data');
    $rec_data6->execute();
    $row_rec_data6 = $rec_data6->fetch(PDO::FETCH_ASSOC);
    $mes_explodir6 = explode('-', $row_rec_data6['data']);
    $mes6 = $mes_explodir6[1];
    $datafinal_mes6 = $row_rec_data6['data'];
    $datainicial_mes6 = $mes_explodir6[0].'-'.$mes_explodir6[1].'-1';
    
    //Menos 6 Meses
    $rec_data7 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -6 month) as data');
    $rec_data7->execute();
    $row_rec_data7 = $rec_data7->fetch(PDO::FETCH_ASSOC);
    $mes_explodir7 = explode('-', $row_rec_data7['data']);
    $mes7 = $mes_explodir7[1];
    $datafinal_mes7 = $row_rec_data7['data'];
    $datainicial_mes7 = $mes_explodir7[0].'-'.$mes_explodir7[1].'-1';
    
    //Menos 7 Meses
    $rec_data8 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -7 month) as data');
    $rec_data8->execute();
    $row_rec_data8 = $rec_data8->fetch(PDO::FETCH_ASSOC);
    $mes_explodir8 = explode('-', $row_rec_data8['data']);
    $mes8 = $mes_explodir8[1];
    $datafinal_mes8 = $row_rec_data8['data'];
    $datainicial_mes8 = $mes_explodir8[0].'-'.$mes_explodir8[1].'-1';
    
    //Menos 8 Meses
    $rec_data9 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -8 month) as data');
    $rec_data9->execute();
    $row_rec_data9 = $rec_data9->fetch(PDO::FETCH_ASSOC);
    $mes_explodir9 = explode('-', $row_rec_data9['data']);
    $mes9 = $mes_explodir9[1];
    $datafinal_mes9 = $row_rec_data9['data'];
    $datainicial_mes9 = $mes_explodir9[0].'-'.$mes_explodir9[1].'-1';
    
    //Menos 9 Meses
    $rec_data10 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -9 month) as data');
    $rec_data10->execute();
    $row_rec_data10 = $rec_data10->fetch(PDO::FETCH_ASSOC);
    $mes_explodir10 = explode('-', $row_rec_data10['data']);
    $mes10 = $mes_explodir10[1];
    $datafinal_mes10 = $row_rec_data10['data'];
    $datainicial_mes10 = $mes_explodir10[0].'-'.$mes_explodir10[1].'-1';
    
    //Menos 10 Meses
    $rec_data11 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -10 month) as data');
    $rec_data11->execute();
    $row_rec_data11 = $rec_data11->fetch(PDO::FETCH_ASSOC);
    $mes_explodir11 = explode('-', $row_rec_data11['data']);
    $mes11 = $mes_explodir11[1];
    $datafinal_mes11 = $row_rec_data11['data'];
    $datainicial_mes11 = $mes_explodir11[0].'-'.$mes_explodir11[1].'-1';
    
    //Menos 11 Meses
    $rec_data12 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -11 month) as data');
    $rec_data12->execute();
    $row_rec_data12 = $rec_data12->fetch(PDO::FETCH_ASSOC);
    $mes_explodir12 = explode('-', $row_rec_data12['data']);
    $mes12 = $mes_explodir12[1];
    $datafinal_mes12 = $row_rec_data12['data'];
    $datainicial_mes12 = $mes_explodir12[0].'-'.$mes_explodir12[1].'-1';
    
    //Menos 12 Meses
    $rec_data13 = $pdo->prepare('SELECT DATE_ADD(CURDATE(), INTERVAL -12 month) as data');
    $rec_data13->execute();
    $row_rec_data13 = $rec_data13->fetch(PDO::FETCH_ASSOC);
    $mes_explodir13 = explode('-', $row_rec_data13['data']);
    $mes13 = $mes_explodir13[1];
    $datafinal_mes13 = $row_rec_data13['data'];
    $datainicial_mes13 = $mes_explodir13[0].'-'.$mes_explodir13[1].'-1';
    
    
}
switch (date("m")) {
    case "01":    $mes = 'Jan'; break;
    case "02":    $mes = 'Fev'; break;
    case "03":    $mes = 'Mar'; break;
    case "04":    $mes = 'Abr'; break;
    case "05":    $mes = 'Mai'; break;
    case "06":    $mes = 'Jun'; break;
    case "07":    $mes = 'Jul'; break;
    case "08":    $mes = 'Ago'; break;
    case "09":    $mes = 'Set'; break;
    case "10":    $mes = 'Out'; break;
    case "11":    $mes = 'Nov'; break;
    case "12":    $mes = 'Dez'; break;
}

switch ($mes) {
    case "01":    $mes = Jan;     break;
    case "02":    $mes = Fev;   break;
    case "03":    $mes = Mar;       break;
    case "04":    $mes = Abr;       break;
    case "05":    $mes = Mai;        break;
    case "06":    $mes = Jun;       break;
    case "07":    $mes = Jul;       break;
    case "08":    $mes = Ago;      break;
    case "09":    $mes = Set;    break;
    case "10":    $mes = Out;     break;
    case "11":    $mes = Nov;    break;
    case "12":    $mes = Dez;    break;
}

switch ($mes2) {
    case "01":    $mes2 = 'Jan'; break;
    case "02":    $mes2 = 'Fev'; break;
    case "03":    $mes2 = 'Mar'; break;
    case "04":    $mes2 = 'Abr'; break;
    case "05":    $mes2 = 'Mai'; break;
    case "06":    $mes2 = 'Jun'; break;
    case "07":    $mes2 = 'Jul'; break;
    case "08":    $mes2 = 'Ago'; break;
    case "09":    $mes2 = 'Set'; break;
    case "10":    $mes2 = 'Out'; break;
    case "11":    $mes2 = 'Nov'; break;
    case "12":    $mes2 = 'Dez'; break;
}

switch ($mes3) {
    case "01":    $mes3 = 'Jan'; break;
    case "02":    $mes3 = 'Fev'; break;
    case "03":    $mes3 = 'Mar'; break;
    case "04":    $mes3 = 'Abr'; break;
    case "05":    $mes3 = 'Mai'; break;
    case "06":    $mes3 = 'Jun'; break;
    case "07":    $mes3 = 'Jul'; break;
    case "08":    $mes3 = 'Ago'; break;
    case "09":    $mes3 = 'Set'; break;
    case "10":    $mes3 = 'Out'; break;
    case "11":    $mes3 = 'Nov'; break;
    case "12":    $mes3 = 'Dez'; break;
}

switch ($mes4) {
    case "01":    $mes4 = 'Jan'; break;
    case "02":    $mes4 = 'Fev'; break;
    case "03":    $mes4 = 'Mar'; break;
    case "04":    $mes4 = 'Abr'; break;
    case "05":    $mes4 = 'Mai'; break;
    case "06":    $mes4 = 'Jun'; break;
    case "07":    $mes4 = 'Jul'; break;
    case "08":    $mes4 = 'Ago'; break;
    case "09":    $mes4 = 'Set'; break;
    case "10":    $mes4 = 'Out'; break;
    case "11":    $mes4 = 'Nov'; break;
    case "12":    $mes4 = 'Dez'; break;
}

switch ($mes5) {
    case "01":    $mes5 = 'Jan'; break;
    case "02":    $mes5 = 'Fev'; break;
    case "03":    $mes5 = 'Mar'; break;
    case "04":    $mes5 = 'Abr'; break;
    case "05":    $mes5 = 'Mai'; break;
    case "06":    $mes5 = 'Jun'; break;
    case "07":    $mes5 = 'Jul'; break;
    case "08":    $mes5 = 'Ago'; break;
    case "09":    $mes5 = 'Set'; break;
    case "10":    $mes5 = 'Out'; break;
    case "11":    $mes5 = 'Nov'; break;
    case "12":    $mes5 = 'Dez'; break;
}
switch ($mes6) {
    case "01":    $mes6 = 'Jan'; break;
    case "02":    $mes6 = 'Fev'; break;
    case "03":    $mes6 = 'Mar'; break;
    case "04":    $mes6 = 'Abr'; break;
    case "05":    $mes6 = 'Mai'; break;
    case "06":    $mes6 = 'Jun'; break;
    case "07":    $mes6 = 'Jul'; break;
    case "08":    $mes6 = 'Ago'; break;
    case "09":    $mes6 = 'Set'; break;
    case "10":    $mes6 = 'Out'; break;
    case "11":    $mes6 = 'Nov'; break;
    case "12":    $mes6 = 'Dez'; break;
}
switch ($mes7) {
    case "01":    $mes7 = 'Jan'; break;
    case "02":    $mes7 = 'Fev'; break;
    case "03":    $mes7 = 'Mar'; break;
    case "04":    $mes7 = 'Abr'; break;
    case "05":    $mes7 = 'Mai'; break;
    case "06":    $mes7 = 'Jun'; break;
    case "07":    $mes7 = 'Jul'; break;
    case "08":    $mes7 = 'Ago'; break;
    case "09":    $mes7 = 'Set'; break;
    case "10":    $mes7 = 'Out'; break;
    case "11":    $mes7 = 'Nov'; break;
    case "12":    $mes7 = 'Dez'; break;
}
switch ($mes8) {
    case "01":    $mes8 = 'Jan'; break;
    case "02":    $mes8 = 'Fev'; break;
    case "03":    $mes8 = 'Mar'; break;
    case "04":    $mes8 = 'Abr'; break;
    case "05":    $mes8 = 'Mai'; break;
    case "06":    $mes8 = 'Jun'; break;
    case "07":    $mes8 = 'Jul'; break;
    case "08":    $mes8 = 'Ago'; break;
    case "09":    $mes8 = 'Set'; break;
    case "10":    $mes8 = 'Out'; break;
    case "11":    $mes8 = 'Nov'; break;
    case "12":    $mes8 = 'Dez'; break;
}
switch ($mes9) {
    case "01":    $mes9 = 'Jan'; break;
    case "02":    $mes9 = 'Fev'; break;
    case "03":    $mes9 = 'Mar'; break;
    case "04":    $mes9 = 'Abr'; break;
    case "05":    $mes9 = 'Mai'; break;
    case "06":    $mes9 = 'Jun'; break;
    case "07":    $mes9 = 'Jul'; break;
    case "08":    $mes9 = 'Ago'; break;
    case "09":    $mes9 = 'Set'; break;
    case "10":    $mes9 = 'Out'; break;
    case "11":    $mes9 = 'Nov'; break;
    case "12":    $mes9 = 'Dez'; break;
}
switch ($mes10) {
    case "01":    $mes10 = 'Jan'; break;
    case "02":    $mes10 = 'Fev'; break;
    case "03":    $mes10 = 'Mar'; break;
    case "04":    $mes10 = 'Abr'; break;
    case "05":    $mes10 = 'Mai'; break;
    case "06":    $mes10 = 'Jun'; break;
    case "07":    $mes10 = 'Jul'; break;
    case "08":    $mes10 = 'Ago'; break;
    case "09":    $mes10 = 'Set'; break;
    case "10":    $mes10 = 'Out'; break;
    case "11":    $mes10 = 'Nov'; break;
    case "12":    $mes10 = 'Dez'; break;
}
switch ($mes11) {
    case "01":    $mes11 = 'Jan'; break;
    case "02":    $mes11 = 'Fev'; break;
    case "03":    $mes11 = 'Mar'; break;
    case "04":    $mes11 = 'Abr'; break;
    case "05":    $mes11 = 'Mai'; break;
    case "06":    $mes11 = 'Jun'; break;
    case "07":    $mes11 = 'Jul'; break;
    case "08":    $mes11 = 'Ago'; break;
    case "09":    $mes11 = 'Set'; break;
    case "10":    $mes11 = 'Out'; break;
    case "11":    $mes11 = 'Nov'; break;
    case "12":    $mes11 = 'Dez'; break;
}
switch ($mes12) {
    case "01":    $mes12 = 'Jan'; break;
    case "02":    $mes12 = 'Fev'; break;
    case "03":    $mes12 = 'Mar'; break;
    case "04":    $mes12 = 'Abr'; break;
    case "05":    $mes12 = 'Mai'; break;
    case "06":    $mes12 = 'Jun'; break;
    case "07":    $mes12 = 'Jul'; break;
    case "08":    $mes12 = 'Ago'; break;
    case "09":    $mes12 = 'Set'; break;
    case "10":    $mes12 = 'Out'; break;
    case "11":    $mes12 = 'Nov'; break;
    case "12":    $mes12 = 'Dez'; break;
}

switch ($mes13) {
    case "01":    $mes13 = 'Jan'; break;
    case "02":    $mes13 = 'Fev'; break;
    case "03":    $mes13 = 'Mar'; break;
    case "04":    $mes13 = 'Abr'; break;
    case "05":    $mes13 = 'Mai'; break;
    case "06":    $mes13 = 'Jun'; break;
    case "07":    $mes13 = 'Jul'; break;
    case "08":    $mes13 = 'Ago'; break;
    case "09":    $mes13 = 'Set'; break;
    case "10":    $mes13 = 'Out'; break;
    case "11":    $mes13 = 'Nov'; break;
    case "12":    $mes13 = 'Dez'; break;
}