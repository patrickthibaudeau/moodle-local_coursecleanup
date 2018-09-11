<?php
/**
 * *************************************************************************
 * *                          coursecleanup                               **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  coursecleanup                                             **
 * @name        coursecleanup                                             **
 * @copyright   Glendon York University                                   **
 * @link        http://www.glendon.yorku.ca                               **
 * @author                                                                **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * *************************************************************************/

namespace local_coursecleanup;

/**
 * Description of Message output
 *
 * @author johanna
 */
class Notifications {

    /**
     * Sends an email to a user without have to create a user account in Moodle
     * @param \stdClass $user Moodle User object
     * @param string $subject The email subject
     * @param string $message The email message
     * @param string $path TPath file attachement. Must be Relative to $CFG->dataroot or $CFG->tempdir
     * @return string $html
     */
    private function sendEmail($user, $subject, $message, $attachement = '', $attachename = '') {
        global $CFG;

        if (email_to_user($user, '', $subject, null, $message, $attachement, $attachename)) {
            return true;
        } else {
            return false;
        }
    }

    public function sendEmailToUser($data) {
        global $CFG, $DB, $USER;
        /*
         * Create user object so
         */
        $user = new \stdClass();
        $user->id = rand(2000000, 999999);
        /* If in dev mode, send to logged in user. */
        if ($CFG->coursecleanup_devmode == '1') {
            $user->email = $CFG->coursecleanup_devmode_email;
        } else {
            $user->email = $data['email'];
        }
        $user->deleted = 0;
        $user->auth = 'manual';
        $user->mailformat = 1;
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
       

        $message = $this->getMessage($data);

        if ($this->sendEmail($user, $message['subject'], $message['message'])) {
            $log = array(
                'userid' => $USER->id,
                'uid' => $data['uid'],
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'cn' => $data['cn'],
                'messageid' => $message['id'],
                'timecreated' => time(),
            );

            $DB->insert_record('local_coursecleanup_maillogs', $log);
        }
    }

    /**
     * Returns array with id, subject and message body
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function getMessage($data) {
        global $CFG, $DB;

        $LDAP = new ldap();

        /*
         * Always return the closest date to now
         */
        $sql = 'SELECT * FROM {local_coursecleanup_messages} WHERE dropdate >= ? ORDER BY dropdate LIMIT 1';

        /*
         * If a message is found, prepare the message.
         */
        if ($messageToSend = $DB->get_record_sql($sql, array(time()))) {
            $professor = Base::getUserRecord($data['from']);
            $teacherFirstName = $professor->firstname;
            $teacherLastName = $professor->lastname;
            $course = $LDAP->getCourseInfo($data['cn']);
            $courseName = $course[0]['pycourseacademicyear'][0] . ' '
                    . $course[0]['pycourseperiodfaculty'][0] . ' '
                    . $course[0]['pycoursesubject'][0] . ' '
                    . $course[0]['pycoursecourseid'][0] . ' '
                    . $course[0]['pycoursesection'][0] . ' '
                    . $course[0]['pycourseinstructionalformat'][0] . ' '
                    . $course[0]['pycoursegroupnumber'][0] . ' '
                    . $course[0]['description'][0] . ' '
                    . '(' . $course[0]['pycourseperiod'][0] . ')';
            $firstName = $data['firstname'];
            $lastName = $data['lastname'];

            $subject = $messageToSend->subjectfr . ' / ' . $messageToSend->subjecten;
            $messageFr = $messageToSend->contentfr;
            $messageEn = $messageToSend->contenten;
            //Replace placeholders in French
            $messageFr = str_replace('[firstname]', $firstName, $messageFr);
            $messageFr = str_replace('[lastname]', $lastName, $messageFr);
            $messageFr = str_replace('[teacherfirstname]', $teacherFirstName, $messageFr);
            $messageFr = str_replace('[teacherlastname]', $teacherLastName, $messageFr);
            $messageFr = str_replace('[coursename]', $courseName, $messageFr);
            //Replace placeholders in English
            $messageEn = str_replace('[firstname]', $firstName, $messageEn);
            $messageEn = str_replace('[lastname]', $lastName, $messageEn);
            $messageEn = str_replace('[teacherfirstname]', $teacherFirstName, $messageEn);
            $messageEn = str_replace('[teacherlastname]', $teacherLastName, $messageEn);
            $messageEn = str_replace('[coursename]', $courseName, $messageEn);

            $message = $messageFr;
            $message .= '<hr>';
            $message .= $messageEn;

            $return = array(
                'id' => $messageToSend->id,
                'subject' => $subject,
                'message' => $message
            );

            return $return;
        }
    }

}
