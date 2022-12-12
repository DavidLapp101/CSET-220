@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<link rel="stylesheet" href="{{ asset('css/role.css') }}">
    <h1>Role</h1>

    <div>
        <table>
            <tr>
                <th>Role</th>
                <th>Access Level</th>
            </tr>
        </table>
    </div>

    <div>
        <form action="">
            <input type="text" placeholder="New Role">
            <label for="accessLevel">Access Level</label>
            <select name="accessLevel" id="">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
            <input type="submit" value="OK">
            <a href="">Cancel</a>
        </form>
    </div>
@stop