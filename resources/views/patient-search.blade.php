@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<link rel="stylesheet" href="{{ asset('css/patient.css') }}">
    <h1>Patient Search</h1>
    <div>
        <form action="" class="search-form">
                <select id="patientSearch" name="patientSearch" class="search-filter">
                    <option selected="true" value="ID">Patient ID</option>
                    <option value="name">Name</option>
                    <option value="age">Age</option>
                    <option value="eContactNum">Emergency Contact Number</option>
                    <option value="eContactName">Emergency Contact Name</option>
                    <option value="date">Admission Date</option>
                </select>
                <input type="text" class="search-input" placeholder="Search" oninput="searchPatient(this.value)">
                <button type="submit" class="search-submit"><ion-icon name="search-outline"></ion-icon></button>
        </form>
    </div>

    <div>
        <table>
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Emergency Contact Phone Number</th>
                <th>Emergency Contact</th>
                <th>Admission Date</th>
            </tr>
            <?php
                for($i=0; $i < count($patientList); $i++){
                    echo '<tr class="patientSearchList">';
                    echo '<td class="patientSearchList-ID">'. $patientList[$i]['userID']. '</td>';
                    echo '<td class="patientSearchList-name">'. $patientList[$i]['name']. '</td>';
                    echo '<td class="patientSearchList-age">'. $patientList[$i]['age']. '</td>';
                    echo '<td class="patientSearchList-contactNumber">'. $patientList[$i]['emergencyContact']. '</td>';
                    echo '<td class="patientSearchList-eContactName">'. $patientList[$i]['contactName']. '</td>';
                    echo '<td class="patientSearchList-date">'. $patientList[$i]['admissionDate']. '</td>';
                    echo '</tr>';
                }
            ?>



        </table>
    </div>
        <script>
            // const patients = document.getElementById('mh-patients');
            // patients.selected = 'true';
            function searchPatient(value) {
                $(".patientSearchList-" + $("#patientSearch").val()).each(function() {
                    if ($(this).text().includes(value)) {
                        $(this).parent().css("display", "table-row");
                    }
                    else {
                        $(this).parent().css("display", "none");
                    }
                });
            }
        </script>
@stop