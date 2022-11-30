<html>
    <head>
        <title>App Name - @yield('title')</title>
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>
        <div class="master-header">
            <div class="master-header-left">
                <p></p>
            </div>
            <div class="master-header-right">
                <form class="master-header-form">
                    <select name="mh-page" onchange="location = this.value;">
                        <option value="/land">Home</option>
                        <option value="/newAppointment" style="display: none;" id="mh-doctor-appointment">Doctor Appointment</option>
                        <option value="/patientInfo" style="display: none;" id="mh-additional-info">Additional Info</option>
                        <option value="/role" style="display: none;" id="mh-role">Role</option>
                        <option value="/employees" style="display: none;" id="mh-employee">Employee</option>
                        <option value="/patientSearch" style="display: none;" id="mh-patients">Patients</option>
                        <option value="/accountApproval" style="display: none;" id="mh-registration-approval">Registration Approval</option>
                        <option value="#" id="mh-roster">Roster</option>
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
            let accessLevel=1; //INSERT ACCESS LEVEL HERE FROM SESSION

            const docAppointment = document.getElementById('mh-doctor-appointment');
            const addInfo = document.getElementById('mh-additional-info');
            const role = document.getElementById('mh-role');
            const employee = document.getElementById('mh-employee');
            const patients = document.getElementById('mh-patients');
            const regApproval = document.getElementById('mh-registration-approval');
            const roster = document.getElementById('mh-roster')
            const newRoster = document.getElementById('mh-new-roster');
            const adminReport = document.getElementById('mh-admin-report');
            const payment = document.getElementById('mh-payment');

            //Checks what Page user is on to set dropdown value
            if(document.URL.includes('/patientSearch')){
                patients.selected = 'true';
            }
            else if(document.URL.includes('/newAppointment')){
                docAppointment.selected = 'true'
            }
            else if(document.URL.includes('/patientInfo')){
                addInfo.selected = 'true'
            }
            else if(document.URL.includes('/role')){
                role.selected = 'true'
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

            //Checks users access level to figure out what the dropdown has
            //ADMIN
            if(accessLevel==1){
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
            else if(accessLevel==2){
                docAppointment.style.display = 'block';
                addInfo.style.display = 'block';
                employee.style.display = 'block';
                patients.style.display = 'block';
                regApproval.style.display = 'block';
                newRoster.style.display = 'block';
            }
            //DOCTOR
            else if(accessLevel==3){
                patients.style.display = 'block';
            }
            //CAREGIVER
            else if(accessLevel==4){
                patients.style.display = 'block';
            }
            //PATIENT
            else if(accessLevel==5){
                patients.style.display = 'block';
            }
            //PATIENT FAMILY
            else if(accessLevel==6){
                let access6 = document.getElementById('land_level6');
                access6.style.display = 'block';
            }
        </script>
    </body>
</html>