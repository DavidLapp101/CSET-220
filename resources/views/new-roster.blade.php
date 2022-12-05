@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('css/newRoster.css') }}">  --}}
    <h1>New Roster</h1>
    <form action="/api/newRoster" method="POST">
        <input type="date" name="date" required>
        <br>
        <label for="supervisor">Supervisor:</label>
        <select name="supervisor" id="" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($supervisor); $i++){
                    echo "<option name='supervisor' value=".$supervisor[$i]['userID'].">".$supervisor[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="doctor1">Doctor:</label>
        <select name="doctor1" id="" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($doctor); $i++){
                    echo "<option name='doctor1' value=".$doctor[$i]['userID'].">".$doctor[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="doctor2">Doctor:</label>
        <select name="doctor2" id="" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($doctor); $i++){
                    echo "<option  name='doctor2' value=".$doctor[$i]['userID'].">".$doctor[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="caregiver1">Caregiver 1:</label>
        <select name="caregiver1" id="test" onclick="checkIfUsed(this)" onchange="disableValues()" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($caregiver); $i++){
                    echo "<option name='caregiver1' value=".$caregiver[$i]['userID'].">".$caregiver[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="caregiver2">Caregiver 2:</label>
        <select name="caregiver2" id="test" onclick="checkIfUsed(this)" onchange="disableValues()" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($caregiver); $i++){
                    echo "<option name='caregiver2' value=".$caregiver[$i]['userID'].">".$caregiver[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="caregiver3">Caregiver 3:</label>
        <select name="caregiver3" id="test" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($caregiver); $i++){
                    echo "<option name='caregiver3' value=".$caregiver[$i]['userID'].">".$caregiver[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="caregiver4">Caregiver 4:</label>
        <select name="caregiver4" id="test" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($caregiver); $i++){
                    echo "<option name='caregiver4' value=".$caregiver[$i]['userID'].">".$caregiver[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <input type="submit" value="OK">
        <button>Cancel</button>
    </form>
    <script>
        function checkIfUsed($value){
            
        }
    </script>
@stop