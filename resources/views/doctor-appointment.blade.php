@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<link rel="stylesheet" href="{{ asset('css/doctor.css') }}">
<div>
<h1>Doctor's Appointment:</h1>
</div>
<div>
    <form action="/api/newAppointment" method="POST">
        <input type="text" placeholder="Patient ID" name="patientID" onchange="checkName(this.value)">
        <p id="newName"></p>

        <label for="Date">Choose a Date</label> 
        <input type="date" name="date" onchange="checkDate(this.value)">

        <label for="availableDoctors">Doctor:</label>
        <select name="doctorID" id="doctorID">
            <option disabled selected>Pick One</option>
        </select>
        <input type="submit" value="OK">
        <a href="">Cancel</a>
    </form>


    <script>
        var patNames = JSON.parse('<?php echo json_encode($pat) ?>');
        name = document.getElementById('name');
        function checkName(val){
            for(let i=0; i<patNames.length; i++){
                if(patNames[i]['userID']==val){
                    $("#newName").text(patNames[i]['name']);
                }
            }
        }

        var doc1 = JSON.parse('<?php echo json_encode($doc1) ?>')
        var doc2 = JSON.parse('<?php echo json_encode($doc2) ?>')
        console.log(doc1);
        console.log(doc2)
        var x = document.getElementById("doctorID");
        var option = document.createElement("option");
        var option2 = document.createElement("option");
        function checkDate(val){
            for(let i=0; i<doc1.length; i++){
                console.log('hello')
                if(doc1[i]['date'] == val){
                    option.text=doc1[i]['name'];
                    option.value=doc1[i]['userID'];
                    console.log('hello2')
                }
            }
            console.log('hello5')
            for(let i=0; i<doc2.length; i++){
                console.log('hello3')
                if(doc2[i]['date'] == val){
                    console.log('hello4')
                    option2.text=doc2[i]['name'];
                    option2.value=doc2[i]['userID'];
                }
            }
            console.log(option);
            console.log(option2);
            x.add(option);
            x.add(option2);
        }
    </script>
</div>
@stop