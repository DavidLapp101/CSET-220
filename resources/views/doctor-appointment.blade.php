@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<div>
<h1>Doctor's Appointment:</h1>
</div>
<div>
    <form action="">
        <input type="text" placeholder="Patient ID">
        <p>Patient Name will Autopopulate Here:</p>
        <label for="Date">Choose a Date</label>
        <input type="date" name="Date">
        <label for="availableDoctors">Doctor:</label>
        <select name="availableDoctors" id="">
            <option value=""></option>
        </select>
        <input type="submit" value="OK">
        <a href="">Cancel</a>

    </form>
</div>
@stop