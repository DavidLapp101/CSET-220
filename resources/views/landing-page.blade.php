<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
@extends('header')
 
@section('title', 'Page Title')

@section('content')
<link rel="stylesheet" href="{{ asset('css/land.css') }}">

    {{-- ADMIN HOME PAGE --}}
    <div class="land_level1" id="land_level1" style="display: none">
        <p>Admin</p>
    </div>




    {{-- SUPERVISOR HOME PAGE --}}
    <div class="land_level2" id="land_level2" style="display: none">
        <p>Supervisor</p>
    </div>




    {{-- DOCTOR HOME PAGE --}}
    <div class="land_level3" id="land_level3" style="display: none">
        <p>Doctor</p>
        <table>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
                <th></th>
            </tr>
                
            <?php
                $appointmentInfo = DB::select("select userID, name, appointments.date as 'date', comment, morningMed, afternoonMed, eveningMed from appointments left join regiments on (appointments.date=regiments.date and appointments.doctorID=regiments.doctorID) join users on (appointments.patientID = users.userID) where appointments.date != GREATEST(appointments.date, curdate()) and appointments.doctorID = 6 order by appointments.date");
                $appointmentInfo = json_decode(json_encode($appointmentInfo), true);

                $columns = ["name", "date", "comment", "morningMed", "afternoonMed", "eveningMed"];
                for ($i = 0; $i<count($appointmentInfo); $i++) {
                    echo "<tr>";
                    echo "<td><a href='/patientOfDoctor/?patient=".$appointmentInfo[$i]["userID"]."'>View Patient</a></td>";
                    for ($j = 0; $j<count($columns); $j++) {
                        echo "<td>".$appointmentInfo[$i][$columns[$j]]."</td>";
                    }
                    echo "</tr>";
                }
            ?>
        </table>

        <br><br>
        
        <h4>Appointments</h4>
        <input type="date" id="til-date" name="til-date" placeholder="Date" onchange="searchAppointments(this.value)">

        <table>
            <tr>
                <th>Patient</th>
                <th>Date</th>
            </tr>
            <?php
                $upcomingApps = DB::select("select userID, name, date from appointments join users on (users.userid = appointments.patientID) where doctorID = ".$_SESSION["userID"]." and date >= curdate() order by date");
                for ($i = 0; $i<count($upcomingApps); $i++) {
                    echo "<tr class='upcomingApp'>";
                    echo "<td><a href='/patientOfDoctor/?patient=".$upcomingApps[$i]->userID."'>View Patient</a></td>";
                    echo "<td>".$upcomingApps[$i]->name."</td>";
                    echo "<td>".$upcomingApps[$i]->date."</td>";
                    echo "</tr>";
                }
            ?>
        </table>

    </div>




    {{-- CAREGIVER HOME PAGE --}}
    <div class="land_level4" id="land_level4" style="display: none">
        <p>Caregiver</p>
        <form class="landing-page-caregiver-table">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Morning Medicine</th>
                    <th>Afternoon Medicine</th>
                    <th>Night Medicine</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
                <tr>
                    <td>######</td>
                    <td><input type="checkbox" id="morning_medicine"></td>
                    <td><input type="checkbox" id="afternoon_medicine"></td>
                    <td><input type="checkbox" id="night_medicine"></td>
                    <td><input type="checkbox" id="breakfast"></td>
                    <td><input type="checkbox" id="lunch"></td>
                    <td><input type="checkbox" id="dinner"></td>
                </tr>
            </table>
            <input type="submit" value="Submit"> 
        </form>
    </div>




    {{-- PATIENT HOME PAGE --}}
    <div class="land_level5" id="land_level5" style="display: none">
        <div class="landing-page-patient-home">
            <form action="/land" method="GET">
                <input type="date" name = "date" id="date">
                <input type="submit">
            </form>
            <?php
                if(isset($_GET['date'])){
                    $date=$_GET['date'];
                }
                else{
                    $date = date("Y-m-d");
                }
                $id = $_SESSION["userID"];
                for($i=0; $i<count($reg); $i++){
                    if(($reg[$i]['patientID']==$id) && $reg[$i]['date']==$date){
                        echo '<p>Patient ID: '.$id.'</p>';
                        echo '<p>Date:'.$date.'</p>';
                        echo '<p>Patient Name: '.$reg[$i]['patientName'].'</p>';
                    }
                }
            ?>
            <table>
                <tr>
                    <th>Doctor Name</th>
                    <th>Completed Appointment</th>
                    <th>Caregivers Name</th>
                    <th>Morning Medicine</th>
                    <th>Afternoon Medicine</th>
                    <th>Night Medicine</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
                <tr>
                    <?php
                        if(isset($_GET['date'])){
                            $date=$_GET['date'];
                        }
                        else{
                            $date = date("Y-m-d");
                        }
                        $id = $_SESSION["userID"];
                        for($i=0; $i<count($reg); $i++){
                            if(($reg[$i]['patientID']==$id) && $reg[$i]['date']==$date){
                                if(is_null($reg[$i]['doctorName'])==false){
                                    echo"<td>".$reg[$i]['doctorName']."</td>";
                                }
                                else if(is_null($reg[$i]['doctorName'])){
                                    echo"<td>NO DOCTOR</td>";
                                }
                                if($reg[$i]['docApt']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['docApt']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }
                                else{
                                    echo '-';
                                }
                                echo '<td>'.$reg[$i]['caretakerID'].'</td>';
                                if($reg[$i]['morningMed']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['morningMed']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }
                                if($reg[$i]['afternoonMed']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['afternoonMed']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }
                                if($reg[$i]['eveningMed']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['eveningMed']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }
                                if($reg[$i]['breakfast']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['breakfast']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }if($reg[$i]['lunch']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['lunch']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }if($reg[$i]['dinner']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['dinner']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }
                            }
                        }  
                    ?>
                </tr>
            </table>
        </div>
    </div>




    {{-- FAMILY MEMEBER HOME PAGE --}}
    <div class="land_level6" id="land_level6" style="display: none">
        <p>Family Member</p>
        <form class="landing-page-family-member-patient-info">
            <input type="date" id="date" required>
            <input type="text" id="family_code" required>
            <input type="test" id="patient_id" required>
            <input type="submit" value="submit">
            <button id="cancel">Cancel</button>
        </form>
        <table>
            <tr>
                <th>Doctor's Name</th>
                <th>Doctors Appointment</th>
                <th>Caregiver's Name</th>
                <th>Morning Medicine</th>
                <th>Afternoon Medicine</th>
                <th>Night Medicine</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
            <tr>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
            </tr>
        </table>
    </div>


    <script>


        let accessLevel = parseInt(document.getElementById("test-user-level").innerHTML);
        if(accessLevel==1){
            const access1 = document.getElementById('land_level1');
            access1.style.display = 'block';
        }
        else if(accessLevel==2){
            const access2 = document.getElementById('land_level2');
            access2.style.display = 'block';
        }
        else if(accessLevel==3){
            const access3 = document.getElementById('land_level3');
            access3.style.display = 'block';
        }
        else if(accessLevel==4){
            const access4 = document.getElementById('land_level4');
            access4.style.display = 'block';
        }
        else if(accessLevel==5){
            const access5 = document.getElementById('land_level5');
            access5.style.display = 'block';
        }
        else if(accessLevel==6){
            const access6 = document.getElementById('land_level6');
            access6.style.display = 'block';
        }

        function searchAppointments(date) {
            let tillDate = new Date(date);
            $(".upcomingApp").each(function () {
                let appDate = new Date(this.children[2].innerHTML);
                if (tillDate.getTime() > appDate.getTime()) {
                    $(this).css("display", "none");
                }
                else {
                    $(this).css("display", "table-row");
                }
            });
        }

    </script>

@stop