<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<html>
<head>
    <title>App Name - @yield('title')</title>
    <link rel="stylesheet" href="/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<body>

    <p id="test-user-name" style="display: none"><?php echo($_SESSION["name"]); ?></p>
    <p id="test-userID" style="display: none"><?php echo($_SESSION["userID"]); ?></p>
    <p id="test-user-level" style="display: none"><?php echo($_SESSION["accessLevel"]); ?></p>

    <div class="master-header">
        <div class="master-header-left">
            <p></p>
        </div>
        <div class="master-header-right">
            <form class="master-header-form">
                <select name="mh-page" onchange="location = this.value;">
                    <option value="/land">Home</option>
                    <option value="/newAppointment" style="display: none;" id="mh-doctor-appointment">Doctor Appointment</option>
                    <option value="/newRole" style="display: none" id="mh-add-role">Add Role</option>
                    <option value="/employees" style="display: none;" id="mh-employee">Employee</option>
                    <option value="/patientSearch" style="display: none;" id="mh-patients">Patients</option>
                    <option value="/accountApproval" style="display: none;" id="mh-registration-approval">Registration Approval</option>
                    <option value="/assignGroup" style="display: none;" id="mh-assign-group">Assign Group</option>
                    <option value="/roster" id="mh-roster">Roster</option>
                    <option value="/newRoster" style="display: none;" id="mh-new-roster">New Roster</option>
                    <option value="/adminReport" style="display: none;" id="mh-admin-report">Admins Report</option>
                    <option value="/payments" style="display: none;" id="mh-payment">Payment</option>
                    <option value="/">Logout</option>
                </select>
            </form> 
        </div>
    </div>
    <div class="container">
        @yield('content')
    </div>
    <script>

        let dropdownAccess = parseInt(document.getElementById("test-user-level").innerHTML);


        const docAppointment = document.getElementById('mh-doctor-appointment');
        const role = document.getElementById('mh-role');
        const employee = document.getElementById('mh-employee');
        const patients = document.getElementById('mh-patients');
        const regApproval = document.getElementById('mh-registration-approval');
        const roster = document.getElementById('mh-roster')
        const newRoster = document.getElementById('mh-new-roster');
        const adminReport = document.getElementById('mh-admin-report');
        const payment = document.getElementById('mh-payment');
        const addRole = document.getElementById('mh-add-role');
        const assignGroup = document.getElementById('mh-assign-group');

        //Checks what Page user is on to set dropdown value
        if(document.URL.includes('/patientSearch')){
            patients.selected = 'true';
        }
        else if(document.URL.includes('/newAppointment')){
            docAppointment.selected = 'true'
        }
        else if(document.URL.includes('/employees')){
            employee.selected = 'true'
        }
        else if(document.URL.includes('/patientSearch')){
            patients.selected = 'true'
        }
        else if(document.URL.includes('/accountApproval')){
            regApproval.selected = 'true'
        }
        else if(document.URL.includes('/#')){
            roster.selected = 'true'
        }
        else if(document.URL.includes('/newRoster')){
            newRoster.selected = 'true'
        }
        else if(document.URL.includes('/adminReport')){
            adminReport.selected = 'true'
        }
        else if(document.URL.includes('/payments')){
            payment.selected = 'true'
        }
        else if(document.URL.includes('/newRole')){
            addRole.selected = 'true'
        }
        else if(document.URL.includes('/assignGroup')){
            assignGroup.selected = 'true'
        }


        //Checks users access level to figure out what the dropdown has
        //ADMIN
        if(dropdownAccess==1){
            docAppointment.style.display = 'block';
            employee.style.display = 'block';
            patients.style.display = 'block';
            regApproval.style.display = 'block';
            newRoster.style.display = 'block';
            adminReport.style.display = 'block';
            payment.style.display = 'block';
            addRole.style.display = 'block';
            assignGroup.style.display = "block";
        }
        //SUPERVISOR
        else if(dropdownAccess==2){
            docAppointment.style.display = 'block';
            employee.style.display = 'block';
            patients.style.display = 'block';
            regApproval.style.display = 'block';
            newRoster.style.display = 'block';
            assignGroup.style.display = "block";
        }
        //DOCTOR
        else if(dropdownAccess==3){
            patients.style.display = 'block';
        }
        //CAREGIVER
        else if(dropdownAccess==4){
            patients.style.display = 'block';
        }
        //PATIENT
        else if(dropdownAccess==5){
            patients.style.display = 'block';
        }
        //PATIENT FAMILY
        else if(dropdownAccess==6){
            let access6 = document.getElementById('land_level6');
            access6.style.display = 'block';
        }
    </script>
</body>
</html>