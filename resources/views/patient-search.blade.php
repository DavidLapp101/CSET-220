@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
    <h1>Patient Search</h1>
    <div>
        <form action="" class="search-form">
            <label for="patientSearch">Search By:</label>
            <div>
                <select name="patientSearch" class="search-filter">
                    <option selected="true" value="ID">Patient ID</option>
                    <option value="name">Name</option>
                    <option value="age">Age</option>
                    <option value="eContactNum">Emergency Contact Number</option>
                    <option value="eContactName">Emergency Contact Name</option>
                    <option value="date">Admission Date</option>
                </select>
                <input type="text" class="search-input" placeholder="Search">
                <button type="submit" class="search-submit"><ion-icon name="search-outline"></ion-icon></button>
            </div>
        </form>
        <script>
            // const patients = document.getElementById('mh-patients');
            // patients.selected = 'true';
        </script>
    </div>
@stop