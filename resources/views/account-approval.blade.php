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
                <?php
                    for($i=0; $i< count($pendingUsers); $i++){
                        echo '<tr>';
                        echo '<td>'. $pendingUsers[$i]['userID']. '</td>';
                        echo '<td>'. $pendingUsers[$i]['name']. '</td>';
                        echo '<td>'. $pendingUsers[$i]['roleName']. '</td>';
                        echo '</tr>';
                    };
                ?>
            </tr>
        </table>
    </div>

    <div>
        <form action="/api/acceptDecline" method="post">
            <input type="number" name="user" placeholder="Patient ID">
            <select name="approve/decline">
                <option value="accept">Accept</option>
                <option value="decline">Decline</option>
            </select>
            <input type="submit" value="Approve/Decline">
        </form>
    </div>
@stop