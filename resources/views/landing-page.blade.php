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
            <table>
                <tr>
                    <th>Name</th>
                    <th>Doctors Appointment</th>
                    <th>Morning Medicine</th>
                    <th>Afternoon Medicine</th>
                    <th>Night Medicine</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
                <?php
                    $date = date("Y-m-d");
                    $groupNum = 0;
                    for($i=0; $i<count($caregiverAll); $i++){
                        if($caregiverAll[$i]['date'] == $date){
                            if($caregiverAll[$i]['groupOneCarer'] == $_SESSION["userID"]){
                                $groupNum = 1;
                            }
                            else if($caregiverAll[$i]['groupTwoCarer'] == $_SESSION["userID"]){
                                $groupNum = 2;
                            }
                            else if($caregiverAll[$i]['groupThreeCarer'] == $_SESSION["userID"]){
                                $groupNum = 3;
                            }
                            else if($caregiverAll[$i]['groupFourCarer'] == $_SESSION["userID"]){
                                $groupNum = 4;
                            }
                        }
                    }
                    // echo $groupNum;
                    // echo print_r($regiments);
                    // echo '<br><br>';
                    // echo print_r($caregiverPatientInfo);
                    for($i=0; $i<count($caregiverPatientInfo); $i++){
                        echo '<form class="landing-page-caregiver-table" action="/api/updatePatient" method="POST">';
                            if($caregiverPatientInfo[$i]['groupNum']== $groupNum){
                                echo '<tr>
                                    <td style="display: none"><input type="text" value='.$caregiverPatientInfo[$i]['patientID'].' name="patientID" ></td>
                                    <td>'.$caregiverPatientInfo[$i]['patientName'].'</td>';
                                    //Checks if patient attended appointment
                                    if($caregiverPatientInfo[$i]['docApt']==1){
                                        echo'<td><input type="checkbox" name="docApt" checked></td>';
                                    }
                                    else if($caregiverPatientInfo[$i]['docApt']==0){
                                        echo'<td><input type="checkbox" name="docApt"></td>';
                                    }

                                    //Checks if morning medication was taken
                                    if(is_null($regiments[$i][0]['morningMed'])){
                                        echo'<td>-</td>';
                                    }
                                    else if($caregiverPatientInfo[$i]['morningMed']==1){
                                        echo'<td><input type="checkbox" name="morningMed" checked></td>';
                                    }
                                    else if($caregiverPatientInfo[$i]['morningMed']==0){
                                        echo'<td><input type="checkbox" name="morningMed"></td>';
                                    }

                                    //checks if afternoon medication was taken
                                    if(is_null($regiments[$i][0]['afternoonMed'])){
                                        echo'<td>-</td>';
                                    }
                                    elseif($caregiverPatientInfo[$i]['afternoonMed']==1){
                                        echo'<td><input type="checkbox" name="afternoonMed" checked></td>';
                                    }
                                    else if($caregiverPatientInfo[$i]['afternoonMed']==0){
                                        echo'<td><input type="checkbox" name="afternoonMed"></td>';
                                    }

                                    //checks if evening medication was taken
                                    if(is_null($regiments[$i][0]['eveningMed'])){
                                        echo'<td>-</td>';
                                    }
                                    else if($caregiverPatientInfo[$i]['eveningMed']==1){
                                        echo'<td><input type="checkbox" name="eveningMed" checked></td>';
                                    }
                                    else if($caregiverPatientInfo[$i]['eveningMed']==0){
                                        echo'<td><input type="checkbox" name="eveningMed"></td>';
                                    }

                                    //Checks if breakfast was eaten
                                    if($caregiverPatientInfo[$i]['breakfast']==1){
                                        echo'<td><input type="checkbox" name="breakfast" checked></td>';
                                    }
                                    else if($caregiverPatientInfo[$i]['breakfast']==0){
                                        echo'<td><input type="checkbox" name="breakfast" ></td>';
                                    }
                                    
                                    //checks if lunch was eaten
                                    if($caregiverPatientInfo[$i]['lunch']==1){
                                        echo'<td><input type="checkbox" name="lunch" checked></td>';
                                    }
                                    else if($caregiverPatientInfo[$i]['lunch']==0){
                                        echo'<td><input type="checkbox" name="lunch"></td>';
                                    }
                                    
                                    //checks if dinner was eaten
                                    if($caregiverPatientInfo[$i]['dinner']==1){
                                        echo'<td><input type="checkbox" name="dinner" checked></td>';
                                    }
                                    else if($caregiverPatientInfo[$i]['dinner']==0){
                                        echo'<td><input type="checkbox" name="dinner" ></td>';
                                    }
                                    echo '<td><input type="submit" value="Submit"></td>
                                </tr>';
                            echo '</form>';
                        }
                    }
                ?>
            </table>
    </div>




    {{-- PATIENT HOME PAGE --}}
    <div class="land_level5" id="land_level5" style="display: none">
        <div class="landing-page-patient-home">
            <form action="/land" method="GET">
                <input type="date" name = "date" id="date">
                <input type="submit">
            </form>
            <?php
            if ($_SESSION["accessLevel"] == 5) {
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
                    if ($_SESSION["accessLevel"] == 5) {
                        if(isset($_GET['date'])){
                            $date=$_GET['date'];
                        }
                        else{
                            $date = date("Y-m-d");
                        }
                        $id = $_SESSION["userID"];
                        for($i=0; $i<count($reg); $i++){
                            if(($reg[$i]['patientID']==$id) && $reg[$i]['date']==$date){
                                //shows doctors name
                                if(is_null($reg[$i]['doctorName'])==false){
                                    echo"<td>".$reg[$i]['doctorName']."</td>";
                                }
                                else if(is_null($reg[$i]['doctorName'])){
                                    echo"<td>NO DOCTOR</td>";
                                }

                                //shows if appoinment was attended
                                if(is_null($reg[$i]['doctorName'])){
                                    echo"<td>-</td>";
                                }
                                else if($reg[$i]['docApt']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['docApt']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }
                                
                                for($j=0; $j<count($caregiverOneName); $j++){
                                    if($caregiverOneName[$j]['date']==$date){
                                        if($reg[$i]['groupNum']==1){
                                            echo '<td>'.$caregiverOneName[$j]['name'].'</td>';
                                        }
                                        else if($reg[$i]['groupNum']==2){
                                            echo '<td>'.$caregiverTwoName[$j]['name'].'</td>';
                                        }
                                        else if($reg[$i]['groupNum']==3){
                                            echo '<td>'.$caregiverThreeName[$j]['name'].'</td>';
                                        }
                                        else if($reg[$i]['groupNum']==4){
                                            echo '<td>'.$caregiverFourName[$j]['name'].'</td>';
                                        }
                                    }
                                }

                                //Checks if morning medication was taken
                                if(is_null($takeMeds[0]['morningMed'])){
                                    echo'<td>-</td>';
                                }
                                else if($reg[$i]['morningMed']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['morningMed']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }

                                //checks if afternoon medication was taken
                                if(is_null($takeMeds[0]['afternoonMed'])){
                                    echo'<td>-</td>';
                                }
                                elseif($reg[$i]['afternoonMed']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['afternoonMed']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }

                                //checks if evening medication was taken
                                if(is_null($takeMeds[0]['eveningMed'])){
                                    echo'<td>-</td>';
                                }
                                else if($reg[$i]['eveningMed']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['eveningMed']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }

                                //Checks if breakfast was eaten
                                if($reg[$i]['breakfast']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['breakfast']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }
                                
                                //checks if lunch was eaten
                                if($reg[$i]['lunch']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['lunch']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }
                                
                                //checks if dinner was eaten
                                if($reg[$i]['dinner']==1){
                                    echo'<td><input type="checkbox" checked disabled></td>';
                                }
                                else if($reg[$i]['dinner']==0){
                                    echo'<td><input type="checkbox" disabled></td>';
                                }
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
        <form class="landing-page-family-member-patient-info" action="/api/viewFamilyTasks" method="post">
            <input type="date" name="date" id="date" required>
            <input type="text" name="family-code" id="family-code" required placeholder="Family Code">
            <input type="number" name="patient-id" id="patient-id" required placeholder="Patient ID">
            <input type="submit" value="submit">
            <button id="cancel">Cancel</button>
        </form>
        <table>
            <tr>
                <th>Patient Name</th>
                <th>Doctor Appointment</th>
                <th>Caregiver Name</th>
                <th>Morning Medicine</th>
                <th>Afternoon Medicine</th>
                <th>Night Medicine</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
            <tr class="familyReportList">
            <?php
                if (isset($_POST["patient-id"])) {
                    echo '<td class="familyReportList-patientName">'. $dailyTasks['patientName']. '</td>';
                    echo '<td class="familyReportList-doctorName">'. $dailyTasks['doctorName']. '</td>'; 
                    echo '<td class="familyReportList-cargiver">'. $dailyTasks['caretakerID']. '</td>';
                    if(is_null($regiment['morningMed'])){
                        echo '<td> - </td>';
                    }
                    else if($dailyTasks['morningMed']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                        else if($dailyTasks['morningMed']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if(is_null($regiment['afternoonMed'])){
                        echo '<td> - </td>';
                    }
                    else if($dailyTasks['afternoonMed']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                        else if($dailyTasks['afternoonMed']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if(is_null($regiment['eveningMed'])){
                        echo '<td> - </td>';
                    }
                    else if($dailyTasks['eveningMed']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                        else if($dailyTasks['eveningMed']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if($dailyTasks['breakfast']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                        else if($dailyTasks['breakfast']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if($dailyTasks['lunch']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                        else if($dailyTasks['lunch']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                    if($dailyTasks['dinner']== 1){
                        echo'<td><input type="checkbox" checked disabled></td>';
                    }
                        else if($dailyTasks['dinner']==0){
                        echo'<td><input type="checkbox" disabled></td>';
                    }
                }
            ?>
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


