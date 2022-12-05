@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/patientinfo.css') }}">
    <h1>Additional Patient Information</h1>
    <hr>
</head>
<body>
    <form action = "patientinfo">
        <div class="container">

        <br>
            User ID: <input type="text">
        <br>
            Family Code: <input type="text">
        <br>
            Emergency Contact: <input type="text">
        <br>
            Contact Name: <input type="text">
        <br>
            Contact Relation: <input type="text">
        <br>
            Group Number: <input type="text">
        <br>
            Admission Date: <input type="text">
        <br>
            Balance: <input type="text">
        <br>
            <input type="submit" name="submit">
            <button>Cancel</button>
        </div>
    </form>
</body>
@stop

