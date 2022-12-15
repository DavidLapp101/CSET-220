<?php
    session_start(); 
    use App\Models\User;
    use App\Models\Regiment;
?>
@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
    <?php
        $user = User::where("userID", $_GET["patient"])->first();
        echo "<h1>Patient of Doctor</h1><div><h2>Patient name here:".$user->name."</h2></div>"
    ?>
    
    <div>
        <table>
            <tr>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>
            <?php
                $columns = ["date", "comment", "morningMed", "afternoonMed", "eveningMed"];
                $regiments = json_decode(json_encode(DB::select("select * from regiments where patientID = ".$user->userID." order by date")), true);
                for ($i=0; $i<count($regiments); $i++) {
                    echo "<tr>";
                    for ($j=0; $j<count($columns); $j++) {
                        echo "<td>".$regiments[$i][$columns[$j]]."</td>";
                    }
                    echo "<tr>";
                }
            ?>
        </table>
    </div>
    <h1>Start New Prescription Regiment</h1>
    <div>
        <?php
            $medications = json_decode(json_encode(DB::select("select * from medications")), true);
        ?>
        <form action="/api/newRegiment" method="post">
            <?php
                echo '<input type="number" name="patientID" id="patientID" readonly value='.$user->userID.'>'
            ?>
            <input type="text" name="comment" id="comment" placeholder="Notes/Comments">
            <select name="morningMed" id="morningMed">
                <option value="" selected>None</option>
                <?php
                    for ($i=0; $i<count($medications); $i++) {
                        echo "<option value='".$medications[$i]['medicationID']."'>".$medications[$i]["medicationName"]."</option>";
                    }
                ?>
            </select>
            <select name="afternoonMed" id="afternoonMed">
                <option value="" selected>None</option>
                <?php
                    for ($i=0; $i<count($medications); $i++) {
                        echo "<option value='".$medications[$i]['medicationID']."'>".$medications[$i]["medicationName"]."</option>";
                    }
                ?>
            </select>
            <select name="eveningMed" id="eveningMed">
                <option value="" selected>None</option>
                <?php
                    for ($i=0; $i<count($medications); $i++) {
                        echo "<option value='".$medications[$i]['medicationID']."'>".$medications[$i]["medicationName"]."</option>";
                    }
                ?>
            </select>
            <input type="submit" value="Start Regiment">
            <a href="">Cancel</a>

        </form>
    </div>
@stop