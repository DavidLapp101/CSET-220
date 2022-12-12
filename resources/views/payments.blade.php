@extends('header')
 
@section('title', 'Page Title')

 
@section('content')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <h1>Payments</h1>
    <?php
    if (isset($_POST["success"])){
        echo $_POST['success'];
    }
    ?>
    <div>
        <form action="/api/makePayment" method="post">
            <input type="number" name="searchBalance" placeholder="Patient ID" id='searchBalance' onchange=patientBalance(this.value)>
            <p>Total balance will autopopulate here:</p>
            <table>
            <?php
                for($i = 0; $i<count($balances); $i++){
                    echo '<tr style="display:none" class="userBalance-' .$balances[$i]["userID"].' userBalance" ><td>';
                    echo $balances[$i]['balance'];
                    echo '</td></tr>';
                }
            ?>
            </table>
            <input type="number" name="paymentAmount" id="paymentAmount" placeholder="Payment Amount">
            <input type="submit" value="OK" name="" id="">
            <a href="">Cancel</a>
        </form>

        <form action="/api/updateBalance" method="post">
            <input type="submit" value="update" name="" id="">
        </form>
        
    </div>
    <script>
        function patientBalance(value) {
            $(".userBalance").each(function() {
                if ($(this).hasClass("userBalance-"+value)) {
                    $(this).css("display", "block");
                }
                else {
                    $(this).css("display", "none");
                }
            });
        }
    </script>
@stop