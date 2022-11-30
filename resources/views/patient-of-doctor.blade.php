<!DOCTYPE html>
<html>
    <h1>Patient of Doctor</h1>
    <div>
        <h2>Patient name here:</h2>
    </div>
    <div>
        <table>
            <tr>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>
        </table>
    </div>
    <h1>Start New Prescription Regiment</h1>
    <div>
        <form action="">
            <input type="text" placeholder="Notes/Comments">
            {{-- list of medications in the med table for all 3 selects --}}
            <select name="morningMed" id="">
                <option value=""></option>
            </select>
            <select name="morningMed" id="">
                <option value=""></option>
            </select>
            <select name="morningMed" id="">
                <option value=""></option>
            </select>
            <input type="submit" value="Start Regiment">
            <a href="">Cancel</a>

        </form>
    </div>
</html>