@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
    <h1>Employee</h1>
    <div>
        <form action="" class="search-form">
            <select name="employeeSearch" class="search-filter" required>
                <option selected disabled>Filter By</option>
                <option value="ID">ID</option>
                <option value="name">Name</option>
                <option value="role">Role</option>
                <option value="salary">Salary</option>
            </select>
            <input type="text" class="search-input" placeholder="Search" required>
            <button type="submit" class="search-submit"><ion-icon name="search-outline"></ion-icon></button>
        </form>
    </div>
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Salary</th>
            </tr>
        
        </table>
    </div>

    <div>
        <form action="">
            <input type="text" placeholder="Employee ID">
            <input type="number" placeholder="New Salary">
            <input type="submit" value="OK">
            <a href="">Cancel</a>
        </form>
    </div>
@stop