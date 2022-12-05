@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
    <h1>Employee</h1>
    <div>
        <form action="" class="search-form">
            <select id="employeeSearch" name="employeeSearch" class="search-filter" required>
                <option selected disabled>Filter By</option>
                <option value="ID">ID</option>
                <option value="name">Name</option>
                <option value="role">Role</option>
                <option value="salary">Salary</option>
            </select>
            <input type="text" placeholder="search" oninput="searchEmp(this.value)">
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

            <?php
                for($i=0; $i< count($employeeList); $i++){
                    echo '<tr class="changeSalaryEmployee">';
                    echo '<td class="changeSalaryEmployee-ID">'. $employeeList[$i]['userID']. '</td>';
                    echo '<td class="changeSalaryEmployee-name">'. $employeeList[$i]['name']. '</td>';
                    echo '<td class="changeSalaryEmployee-role">'. $employeeList[$i]['roleName']. '</td>';
                    echo '<td class="changeSalaryEmployee-salary">'. $employeeList[$i]['salary']. '</td>';
                    echo '</tr>';
                };
            ?>
        </table>
    </div>

    <div>
        <form action="/api/changeSalary" method="post">
            <input type="number" name="employee" placeholder="Employee ID">
            <input type="number" name="salary" placeholder="New Salary">
            <input type="submit" value="OK">
            <a href="">Cancel</a>
        </form>
    </div>

    <script>
        function searchEmp(value) {
            $(".changeSalaryEmployee-" + $("#employeeSearch").val()).each(function() {
                if ($(this).text().includes(value)) {
                    $(this).parent().css("display", "block");
                }
                else {
                    $(this).parent().css("display", "none");
                }
            });
        }
    </script>

@stop