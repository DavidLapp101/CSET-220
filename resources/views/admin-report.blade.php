@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <h1>Admin's Report</h1>

    <h2>Date: <?php echo date("Y-m-d"); ?></h2>

    <div>
        <table>
            <tr>
                <th>Patient's Name</th>
                <th>Doctor's Name</th>
                <th>Caregiver's Name</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
            <?php
                for($i=0; $i<count($dailyTask); $i++){
                    echo '<tr class="adminReportList">';
                    echo '<td class="adminReportList-patientName">'. $dailyTask[$i]['patientName']. '</td>';
                    echo '<td class="adminReportList-doctorName">'. $dailyTask[$i]['doctorName']. '</td>'; 
                    echo '<td class="adminReportList-cargiver">'. $dailyTask[$i]['caregiverName']. '</td>';
                    if(is_null($regiments[$i][0]['morningMed'])){
                        echo '<td> - </td>';
                    }
                    else if($dailyTask[$i]['morningMed']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                     else if($dailyTask[$i]['morningMed']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if(is_null($regiments[$i][0]['afternoonMed'])){
                        echo '<td> - </td>';
                    }
                    else if($dailyTask[$i]['afternoonMed']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                     else if($dailyTask[$i]['afternoonMed']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if(is_null($regiments[$i][0]['eveningMed'])){
                        echo '<td> - </td>';
                    }
                    else if($dailyTask[$i]['eveningMed']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                     else if($dailyTask[$i]['eveningMed']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if($dailyTask[$i]['breakfast']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                     else if($dailyTask[$i]['breakfast']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if($dailyTask[$i]['lunch']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                     else if($dailyTask[$i]['lunch']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if($dailyTask[$i]['dinner']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                     else if($dailyTask[$i]['dinner']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }

                    }
                
            ?>
        </table>
    </div>
@stop