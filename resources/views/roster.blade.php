@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<link rel="stylesheet" href="{{ asset('css/roster.css') }}">
    <h1>Roster</h1>
    <form action="/roster" method="GET">
        <input type="date" name = "date" id="date">
        <input type="submit">
    </form>

    <div>
        <p>DATE: <?php if(isset($_GET['date'])){echo $_GET['date'];}else{echo date("Y-m-d");} ?></p>
        <table>
            <tr>
                <th>Supervisor</th>
                <th>Doctor1</th>
                <th>Doctor2</th>
                <th>Group One Caregiver</th>
                <th>Group Two Caregiver</th>
                <th>Group Three Caregiver</th>
                <th>Group Four Caregiver</th>
            </tr>
            <tr>
                <?php 
                    if(isset($_GET['date'])){
                        $i=$_GET['date'];
                    }
                    else{
                        $i = date("Y-m-d");
                    }
                    $findDate="";
                    for($k=0; $k<count($supervisor); $k++){
                        if($supervisor[$k]['date']==$i){
                            $findDate=$k;
                        }
                    }
                    if ($findDate != "") {
                        echo "<td>".$supervisor[$findDate]['name']."</td>";
                        echo "<td>".$doc1[$findDate]['name']."</td>";
                        echo "<td>".$doc2[$findDate]['name']."</td>";
                        echo "<td>".$care1[$findDate]['name']."</td>";
                        echo "<td>".$care2[$findDate]['name']."</td>";
                        echo "<td>".$care3[$findDate]['name']."</td>";
                        echo "<td>".$care4[$findDate]['name']."</td>";
                    }
                ?>
            </tr>
        </table>
    </div>
@stop