@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
    <h1>Registration Approval</h1>
    <link rel="stylesheet" href="{{ asset('css/accountApproval.css') }}"> 
    <div>
        <table>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Role</th>
            </tr>
            <tr>

            </tr>
        </table>
    </div>

    <div>
        <form action="">
            <input type="number" placeholder="Patient ID">
            <select name="approve/decline" id="">
                <option value="accept">Accept</option>
                <option value="decline"></option>
            </select>
            <input type="submit" value="Approve/Decline">
        </form>
    </div>
@stop