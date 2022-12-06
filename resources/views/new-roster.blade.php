@extends('header')
 
@section('title', 'Page Title')


@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('css/newRoster.css') }}">  --}}
    <h1>New Roster</h1>
    <form action="/api/newRoster" method="POST" id="new-roster-form">
        <input type="date" name="date" required>
        <br>
        <label for="supervisor">Supervisor:</label>
        <select class="new-roster-select" name="supervisor" id="supervisor" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($supervisor); $i++){
                    echo "<option name='supervisor' value=".$supervisor[$i]['userID'].">".$supervisor[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="doctor1">Doctor:</label>
        <select class="new-roster-select" name="doctor1" id="doctor1" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($doctor); $i++){
                    echo "<option value=".$doctor[$i]['userID'].">".$doctor[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="doctor2">Doctor:</label>
        <select class="new-roster-select" name="doctor2" id="doctor2" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($doctor); $i++){
                    echo "<option value=".$doctor[$i]['userID'].">".$doctor[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="caregiver1">Caregiver 1:</label>
        <select class="new-roster-select" name="caregiver1" id="caregiver1" onclick="checkIfUsed(this)" onchange="disableValues()" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($caregiver); $i++){
                    echo "<option value=".$caregiver[$i]['userID'].">".$caregiver[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="caregiver2">Caregiver 2:</label>
        <select class="new-roster-select" name="caregiver2" id="caregiver2" onclick="checkIfUsed(this)" onchange="disableValues()" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($caregiver); $i++){
                    echo "<option value=".$caregiver[$i]['userID'].">".$caregiver[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="caregiver3">Caregiver 3:</label>
        <select class="new-roster-select" name="caregiver3" id="caregiver3" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($caregiver); $i++){
                    echo "<option value=".$caregiver[$i]['userID'].">".$caregiver[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="caregiver4">Caregiver 4:</label>
        <select class="new-roster-select" name="caregiver4" id="caregiver4" required>
            <option selected disabled>select</option>
            <?php 
                for($i=0; $i<count($caregiver); $i++){
                    echo "<option value=".$caregiver[$i]['userID'].">".$caregiver[$i]['name']."</option>";
                }
            ?>
        </select>
        <br>
        <input type="submit" value="OK">
        <button onclick="clearForm()">Cancel</button>
    </form>
    <script>
        $(".new-roster-select").each(function () {
            $(this).on('input', function () {
                let value = $(this).val();
                $(".new-roster-select").each(function () {
                    $(this).children().each(function () {
                        $(this).prop("disabled", false);
                        if ($(this).val() == value) {
                            $(this).prop("disabled", true);
                        }
                    });
                });
            });
        })

        function clearForm() {
            document.getElementById("new-roster-form").reset();
            $(".new-roster-select").each(function () {
                $(this).children().each(function () {
                    $(this).prop("disabled", false);
                })
            })
        }
    </script>
@stop