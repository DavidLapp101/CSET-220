@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
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
                    echo '<td class="adminReportList-morningMed">'. $dailyTask[$i]['morningMed']. '</td>';
                    echo '<td class="adminReportList-afternoonMed">'. $dailyTask[$i]['afternoonMed']. '</td>';
                    echo '<td class="adminReportList-eveningMed">'. $dailyTask[$i]['eveningMed']. '</td>';
                    echo '<td class="adminReportList-breakfast">'. $dailyTask[$i]['breakfast']. '</td>';
                    echo '<td class="adminReportList-lunch">'. $dailyTask[$i]['lunch']. '</td>';
                    echo '<td class="adminReportList-dinner">'. $dailyTask[$i]['dinner']. '</td>';
                }
            ?>
        </table>
    </div>
@stop