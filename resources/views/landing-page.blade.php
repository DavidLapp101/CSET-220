<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <header class="landing-page-header">
        <p>Header</p>
    </header>



    {{-- ADMIN HOME PAGE --}}
    <div class="land_level1" id="land_level1" style="display: none">
        <p>Admin</p>
        <form class="admin-choose-page">
            <select name="Page" onchange="location = this.value;">
                <option value="/land">Home</option>
                <option value="#">Doctor Appointment</option>
                <option value="#">Additional Info</option>
                <option value="#">Role</option>
                <option value="#">Employee</option>
                <option value="#">Patients</option>
                <option value="#">Registration Approval</option>
                <option value="#">Roster</option>
                <option value="#">New Roster</option>
                <option value="#">Admins Report</option>
                <option value="#">Payment</option>
                <option value="/">Logout</option>
            </select>
        </form> 
    </div>




    {{-- SUPERVISOR HOME PAGE --}}
    <div class="land_level2" id="land_level2" style="display: none">
        <p>Supervisor</p>
        <form class="supervisor-choose-page">
            <select name="Page" onchange="location = this.value;">
                <option value="/land">Home</option>
                <option value="#">Doctor Appointment</option>
                <option value="#">Additional Info</option>
                <option value="#">Employee View Only</option>
                <option value="#">Patients</option>
                <option value="#">Registration Approval</option>
                <option value="#">Roster</option>
                <option value="#">New Roster</option>
                <option value="/">Logout</option>
            </select>
        </form> 
    </div>




    {{-- DOCTOR HOME PAGE --}}
    <div class="land_level3" id="land_level3" style="display: none">
        <p>Doctor</p>
        <form class="doctor-choose-page">
            <select name="Page" onchange="location = this.value;">
                <option value="/land">Home</option>
                <option value="#">Patients</option>
                <option value="#">Roster</option>
                <option value="/">Logout</option>
            </select>
        </form> 
        <form class="landing-page-doctor-search">
            <select name="landing-page-doctor-search-filter" required>
                <option selected disabled>Filter</option>
                <option value="name">Name</option>
                <option value="date">Date</option>
                <option value="Comment">Comment</option>
                <option value="Morning_Med">Morning Med</option>
                <option value="Afternoon_Med">Afternoon Med</option>
                <option value="Evening_Med">Evening Med</option>
            </select>
            <input type="text" value="Search" required>
            <input type="submit" value="Submit">
        </form>
        <table>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
                <th></th>
            </tr>
            <tr>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td><a href="#">Edit</a></td>
            </tr>
        </table>
    </div>




    {{-- CAREGIVER HOME PAGE --}}
    <div class="land_level4" id="land_level4" style="display: none">
        <p>Caregiver</p>
        <form class="caregiver-choose-page">
            <select name="Page" onchange="location = this.value;">
                <option value="/land">Home</option>
                <option value="#">Patients</option>
                <option value="#">Roster</option>
                <option value="/">Logout</option>
            </select>
        </form>
        <form class="landing-page-caregiver-table">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Morning Medicine</th>
                    <th>Afternoon Medicine</th>
                    <th>Night Medicine</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
                <tr>
                    <td>######</td>
                    <td><input type="checkbox" id="morning_medicine"></td>
                    <td><input type="checkbox" id="afternoon_medicine"></td>
                    <td><input type="checkbox" id="night_medicine"></td>
                    <td><input type="checkbox" id="breakfast"></td>
                    <td><input type="checkbox" id="lunch"></td>
                    <td><input type="checkbox" id="dinner"></td>
                </tr>
            </table>
            <input type="submit" value="Submit"> 
        </form>
    </div>




    {{-- PATIENT HOME PAGE --}}
    <div class="land_level5" id="land_level5" style="display: none">
        <p>Patient</p>
        <form class="caregiver-choose-page">
            <select name="Page" onchange="location = this.value;">
                <option value="/land">Home</option>
                <option value="#">Patients</option>
                <option value="#">Roster</option>
                <option value="/">Logout</option>
            </select>
        </form> 
        <div class="landing-page-patient-home">
            <p>Patient ID: #############</p>
            <p>Date: #############</p>
            <p>Patient Name: #############</p>
            <table>
                <tr>
                    <th>Doctor's Name</th>
                    <th>Doctors Appointment</th>
                    <th>Caregiver's Name</th>
                    <th>Morning Medicine</th>
                    <th>Afternoon Medicine</th>
                    <th>Night Medicine</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
                <tr>
                    <td>######</td>
                    <td>######</td>
                    <td>######</td>
                    <td>######</td>
                    <td>######</td>
                    <td>######</td>
                    <td>######</td>
                    <td>######</td>
                    <td>######</td>
                </tr>
            </table>
        </div>
    </div>




    {{-- FAMILY MEMEBER HOME PAGE --}}
    <div class="land_level6" id="land_level6" style="display: none">
        <p>Family Member</p>
        <form class="family-member-choose-page">
            <select name="Page" onchange="location = this.value;">
                <option value="/land">Home</option>
                <option value="#">Roster</option>
                <option value="/">Logout</option>
            </select>
        </form> 
        <form class="landing-page-family-member-patient-info">
            <input type="date" id="date" required>
            <input type="text" id="family_code" required>
            <input type="test" id="patient_id" required>
            <input type="submit" value="submit">
            <button id="cancel">Cancel</button>
        </form>
        <table>
            <tr>
                <th>Doctor's Name</th>
                <th>Doctors Appointment</th>
                <th>Caregiver's Name</th>
                <th>Morning Medicine</th>
                <th>Afternoon Medicine</th>
                <th>Night Medicine</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
            <tr>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
                <td>######</td>
            </tr>
        </table>
    </div>




    <script>

        $userID=6;
        if($userID==1){
            const access1 = document.getElementById('land_level1');
            access1.style.display = 'block';
        }
        else if($userID==2){
            const access2 = document.getElementById('land_level2');
            access2.style.display = 'block';
        }
        else if($userID==3){
            const access3 = document.getElementById('land_level3');
            access3.style.display = 'block';
        }
        else if($userID==4){
            const access4 = document.getElementById('land_level4');
            access4.style.display = 'block';
        }
        else if($userID==5){
            const access5 = document.getElementById('land_level5');
            access5.style.display = 'block';
        }
        else if($userID==6){
            const access6 = document.getElementById('land_level6');
            access6.style.display = 'block';
        }
    </script>
</body>
</html>