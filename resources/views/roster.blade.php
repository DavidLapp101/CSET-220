@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
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
                <th>caregiver1</th>
                <th>caregiver2</th>
                <th>caregiver3</th>
                <th>caregiver4</th>
            </tr>
            <tr>
                <?php 
                    if(isset($_GET['date'])){
                        $i=$_GET['date'];
                    }
                    else{
                        $i = date("Y-m-d");
                    }
                    $findDate=0;
                    for($k=0; $k<count($supervisor); $k++){
                        if($supervisor[0]['date']==$i){
                            $findDate=$k;
                        }
                    }
                    echo "<td>".$supervisor[$findDate]['name']."</td>";
                    echo "<td>".$doc1[$findDate]['name']."</td>";
                    echo "<td>".$doc2[$findDate]['name']."</td>";
                    echo "<td>".$care1[$findDate]['name']."</td>";
                    echo "<td>".$care2[$findDate]['name']."</td>";
                    echo "<td>".$care3[$findDate]['name']."</td>";
                    echo "<td>".$care4[$findDate]['name']."</td>";
                ?>
            </tr>
        </table>
    </div>
@stop