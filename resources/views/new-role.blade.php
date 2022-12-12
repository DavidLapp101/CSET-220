@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<div>
<h1>Add new Role</h1>

<form action="/api/addRole" method="post">
    <input type="text" placeholder="Role Name" id="role" name="role">
    <select name="accessLevel" id="accessLevel">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
    </select>
    <input type="submit" value="Create Role">
</form>
    <table>
        <tr>
            <th>Role</th>
            <th>Access Level</th>
        </tr>

   

    <?php
        for($i = 0; $i < count($roles); $i++){
            echo '<tr>';
            echo '<td>'.$roles[$i]['roleName'].'</td>';
            echo '<td>'.$roles[$i]['accessLevel'].'</td>';
            echo '</tr>';
        }
    ?>
    </table>
</div>

@stop