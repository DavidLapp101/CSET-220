@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <h1>Payments</h1>
    <div>
        <form action="">
            <input type="number" name="" id="" placeholder="Patient ID">
            <p>Total balance will autopopulate here:</p>
            <input type="number" name="" id="" placeholder="New Payment Amount">
            <input type="submit" value="OK" name="" id="">
            <a href="">Cancel</a>
        </form>
        
    </div>
@stop