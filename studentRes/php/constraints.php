<?php
    function checkConstraints() {
        $table = $_SESSION['table'];
        switch ($table) {
            case 'User':
                $msg = checkUserConstraints();
                if ($msg != '')
                    return "<div class='msg red'>
                            $msg
                        </div>";
                break;

            case 'Activity':
                $msg =  checkActivityConstraints();
                if ($msg != '')
                    return "<div class='msg red'>
                            $msg
                        </div>";
                break;
        }
        return '';
    }

    function checkInteger($var) {
        return (preg_match('/[^0-9]/', $var) ? " must be an integer. " : false);
    }
    
    function checkNumber($var) {
        return (preg_match('/[^0-9.-]/', $var) ? " must be a number.  " : false);
    }

    function checkSpecialCharacters($var) {
        return (preg_match('/[^a-zA-Z\d -]/', $var) ? ' cannot contain any special characters.' : false);
    }

    function checkLength($var, $len) {
        return (strlen($var) > $len ? " max size of $len characters. " : false); 
    }

    function containNumber($var) {
        return (preg_match('/[0-9]/', $var) ? false : " must contain a number. ");
    }

    function notNull($var) {
        return ($var === '' ? " is a required field." : false);
    }

    function checkDates($start, $end) {
        $diff = $end - $start;
        return ($diff < 0 ? date('m/d/Y', $start) . ' must be before ' . date('m/d/Y', $end) . ". " : false);
    }


    function checkUserConstraints() {
        $studentID = $_POST['studentID'];
        $studentName = $_POST['studentName'];
        $passwrd = $_POST['passwrd'];
        $DOB = $_POST['DOB'];
        $GPA = $_POST['GPA'];

        $msg = '';

        if ($err = notNull($studentID)) {
            $msg .= 'studentID' . $err;
            return $msg;
        }

        if ($err = checkInteger($studentID))
            $msg .= 'studentID' . $err;
        
        if ($err = checkSpecialCharacters($studentName))
            $msg .= 'studentName ' . $err;

        if($err = checkLength($studentName, 45))
            $msg .= 'studentName' . $err;

        if ($err = containNumber($passwrd))
            $msg .= 'passwrd' . $err;

        $today = time();
        $DOB = strtotime($DOB);
        if ($err = checkDates($DOB, $today))
            $msg .= 'DOB ' . $err;

        if ($GPA < 0 or $GPA > 4.01)
            $msg .= "GPA must be between 0 and 4.0. ";

        return $msg;
    }


    function checkActivityConstraints() {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        $msg = '';
        if ($err = checkDates(strtotime($startDate), strtotime($endDate)))
            $msg .= "$startDate must be before $endDate";

        return $msg;
    }