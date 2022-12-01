<html>
    <?php session_start() ?>
    <head>
        <title>App Name - @yield('title')</title>
        <link rel="stylesheet" href="/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    </head>
    <body>
        <p id="test-user-name"><?php echo($_SESSION["name"]); ?></p>
        <p id="test-user-level"><?php echo($_SESSION["accessLevel"]); ?></p>
        <div class="master-header">
            <div class="master-header-left">
                Welcome!!
            </div>
            <div class="master-header-right">
                <form class="master-header-form">
                    <select name="mh-page" onchange="location = this.value;">
                        <option value="/land">Home</option>
                        <option value="#" style="display: none;" id="mh-doctor-appointment">Doctor Appointment</option>
                        <option value="#" style="display: none;" id="mh-additional-info">Additional Info</option>
                        <option value="#" style="display: none;" id="mh-role">Role</option>
                        <option value="#" style="display: none;" id="mh-employee">Employee</option>
                        <option value="#" style="display: none;" id="mh-patients">Patients</option>
                        <option value="#" style="display: none;" id="mh-registration-approval">Registration Approval</option>
                        <option value="#">Roster</option>
                        <option value="#" style="display: none;" id="mh-new-roster">New Roster</option>
                        <option value="#" style="display: none;" id="mh-admin-report">Admins Report</option>
                        <option value="#" style="display: none;" id="mh-payment">Payment</option>
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
            const addInfo = document.getElementById('mh-additional-info');
            const role = document.getElementById('mh-role');
            const employee = document.getElementById('mh-employee');
            const patients = document.getElementById('mh-patients');
            const regApproval = document.getElementById('mh-registration-approval');
            const newRoster = document.getElementById('mh-new-roster');
            const adminReport = document.getElementById('mh-admin-Report');
            const payment = document.getElementById('mh-payment');

            //ADMIN
            if(dropdownAccess==1){
                docAppointment.style.display = 'block';
                addInfo.style.display = 'block';
                role.style.display = 'block';
                employee.style.display = 'block';
                patients.style.display = 'block';
                regApproval.style.display = 'block';
                newRoster.style.display = 'block';
                adminReport.style.display = 'block';
                payment.style.display = 'block';
            }
            //SUPERVISOR
            else if(dropdownAccess==2){
                docAppointment.style.display = 'block';
                addInfo.style.display = 'block';
                employee.style.display = 'block';
                patients.style.display = 'block';
                regApproval.style.display = 'block';
                newRoster.style.display = 'block';
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