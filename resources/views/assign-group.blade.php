@extends('header')
 
@section('title', 'Page Title')

 
@section('content')

<h1>Assign group to new patients</h1>

<form action="/api/assignGroup" method="post">
    <input type="number" name="patient" id="patient" placeholder="Patient ID">
    <input type="number" name="groupNum" id="groupNum" placeholder="Group">
    <input type="submit" value="Assign to Group">
</form>

<table>
    <tr>
        <th>Patient ID</th>
        <th>Patient Name</th>
    </tr>
    <?php
        for($i=0; $i < count($groupless); $i++){
            echo '<tr>';
            echo '<td>'.$groupless[$i]['userID'].'</td>';
            echo '<td>'.$groupless[$i]['name'].'</td>';
            echo '</tr>';
        }
    ?>
</table>


@stop