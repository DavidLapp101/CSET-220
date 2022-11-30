@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
    <h1>Patient Search</h1>
    <div>
        <form action="">
            <label for="patientSearch">Search By:</label>
            <select name="patientSearch">
                <option selected="true" value="ID">Patient ID</option>
                <option value="name">Name</option>
                <option value="age">Age</option>
                <option value="eContactNum">Emergency Contact Number</option>
                <option value="eContactName">Emergency Contact Name</option>
                <option value="date">Admission Date</option>
            </select>
            <input type="text">
        </form>
        <script>
            // const patients = document.getElementById('mh-patients');
            // patients.selected = 'true';
        </script>
    </div>
@stop