<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Model
{
    protected $db;
    protected $table;

    /**
     * calling database object and setting table name
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->db = new Database;
        if (!isset($_SESSION['store']) && !isset($_COOKIE['store'])) { // craeting empty object
            $_SESSION['store'] = new stdClass();
            $_SESSION['store']->store_id = null;
        }
        $this->extendStoreSession();
    }
    /**
     * extend store session for a month
     *
     * @return void
     */
    public function extendStoreSession()
    {
        if (isset($_COOKIE['store'])) {
            $_SESSION['store'] = $this->getSingle('*', ['store_id' => $_COOKIE['store']], 'stores');
        }
    }

    /**
     * do query that return result
     *
     * @param string$query
     * @return object
     */
    public function queryResult($query)
    {
        //setting the query
        $this->db->query($query);
        if ($this->db->excute()) {
            return $this->db->resultSet();
        } else {
            return false;
        }
    }


    /**
     * get record by value @example getby([id=>5])
     *
     * @param  array $bind
     *
     * @return void
     */
    public function getBy($bind)
    {
        return $this->getSingle('*', $bind);
    }

    /**
     * get record with WHERE condation with In
     *
     * @param  array $in values
     * @param  string $colomn
     *
     * @return void
     */
    public function getWhereIn($colomn, $in)
    {
        return $this->getWhereInTable($this->table, $colomn, $in);
    }

    /**
     * get record with WHERE condation with In
     *
     * @param  array $in values
     * @param  string $colomn
     *
     * @return void
     */
    public function getWhereInTable($table, $colomn, $in)
    {

        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($in); $index++) {
            $id_num[] = ":in" . $index;
        }
        //setting the query
        $this->db->query('SELECT * FROM  ' . $table . '  WHERE ' . $colomn . ' IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($in as $key => $value) {
            $this->db->bind(':in' . ($key + 1), $value);
        }
        if ($this->db->excute()) {
            return $this->db->resultSet();
        } else {
            return false;
        }
    }
    /**
     * get data From Table
     *
     * @param  string $table required
     * @param  string $colomns
     * @param  array associative  $bind
     * @param  int $start
     * @param  int $perPage
     * @param  string $orderBy colomn
     * @param  string $order desc/asc
     *
     * @return object
     */
    public function get($colomns, $bind = '', $start = 1, $perPage = '', $table = null, $orderBy = 'create_date', $order = 'DESC')
    {
        $table ?: $table = $this->table;
        //check for pagination
        if (!empty($perPage)) {
            $limit = ' LIMIT :start, :perpage';
        } else {
            $limit = '';
        }
        //prepar condation for binding
        $cond = '';
        if (!empty($bind)) {
            $cond = ' WHERE ';
            foreach ($bind as $key => $value) {
                $cond .= "$key =:$key AND ";
            }
            $cond = rtrim($cond, 'AND ');
        }
        // prepare Query
        $query = 'SELECT ' . $colomns . ' FROM ' . $table . ' ' . $cond . ' ORDER BY ' . $orderBy . ' ' . $order . ' ' . $limit;
        $this->db->query($query);
        //bind values
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        // bind pagination LIMIT values
        if (!empty($perPage)) {
            $this->db->bind(':start', ($start - 1) * $perPage);
            $this->db->bind(':perpage', $perPage);
        }
        return $this->db->resultSet();
    }

    /**
     * get single record
     *
     * @param  string $colomns
     * @param  array $bind
     * @param  string $table
     *
     * @return object
     */
    public function getSingle($colomns, $bind = '', $table = null)
    {
        $table ?: $table = $this->table;
        //prepar condation for binding
        $cond = '';
        if (!empty($bind)) {
            $cond = ' WHERE ';
            foreach ($bind as $key => $value) {
                $cond .= "$key =:$key AND ";
            }
            $cond = rtrim($cond, 'AND ');
        }
        // prepare Query
        $query = 'SELECT ' . $colomns . ' FROM ' . $table . ' ' . $cond . ' ' . ' LIMIT 1 ';
        $this->db->query($query);
        //bind values
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        return $this->db->single();
    }
    /**
     * get From deferant Table same as get
     *
     * @param  string $table required
     * @param  string $colomns
     * @param  array associative  $bind
     * @param  int $start
     * @param  int $perPage
     * @param  string $orderBy colomn
     * @param  string $order desc/asc
     *
     * @return object
     */
    public function getFromTable($table, $colomns = '*', $bind = '', $start = 1, $perPage = '', $orderBy = 'create_date', $order = 'DESC')
    {
        return $this->get($colomns, $bind, $start, $perPage, $table, $orderBy, $order);
    }
    /**
     * get count of all records
     * @param string $bind
     * @return array $table
     */
    public function countAll($bind = '', $table = null)
    {
        $table ?? $this->table;
        return $this->getSingle(' count(*) as count ', $bind, $table);
    }

    /**
     * clear HTML string with html purifier
     * @param type $stringHTML
     * @return string HTML
     */
    public function cleanHTML($stringHTML)
    {
        if (!empty($stringHTML)) {
            require_once '../helpers/htmlpurifier/HTMLPurifier.auto.php';
            $config = HTMLPurifier_Config::createDefault();
            $config->set('HTML.SafeIframe', true);
            $config->set('URI.SafeIframeRegexp', '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%');
            $purifier = new HTMLPurifier($config);
            return $purifier->purify($stringHTML);
        } else {
            return null;
        }
    }

    /**
     * validate Image and upload
     *
     * @param  string $imageName
     * @return array name or error
     */
    public function validateImage($imageName)
    {
        if ($_FILES[$imageName]['error'] == 0) {
            $image = uploadImage($imageName, MAINPATH . '/', 5000000, true);
            if (empty($image['error'])) {
                return [true, $image['filename']];
            } else {
                if (!isset($image['error']['nofile'])) {
                    return [false, implode(',', $image['error'])];
                }
            }
        }
    }
    /**
     * get the latest id
     * @return int id
     */
    public function lastId()
    {
        return $this->db->lastId();
    }

    /**
     * get all menu links from datatbase
     * @return object links data
     */
    public function getMenu()
    {
        return $this->getFromTable('menus', '*', ['status' => 1], '', '', 'arrangement', 'ASC');
    }

    /**
     * get Settings
     *
     * @param  mixed $type
     * @return object
     */
    public function getSettings($type = null)
    {
        if ($type) {
            return $this->getSingle('*', ['alias' => $type], 'settings');
        } else {
            $stngs = $this->getFromTable('settings');
            $settings = [];
            foreach ($stngs as $setting) {
                $settings[$setting->alias] = json_decode($setting->value);
            }
            unset($settings['api'], $settings['sms']);
            return $settings;
        }
    }

    /**
     * sending Html Email
     *
     * @param string $to
     * @param string $subject
     * @param string $msg
     * @param string|boolen $attachment
     * @param boolen $debug
     * @return boolen
     */
    public function Email($to, $subject, $msg, $attachment = false, $debug = false)
    {
        $emailSettings = $this->getSettings('email');
        $email = json_decode($emailSettings->value);
        if ($email->smtp) {
            $to = explode(',', $to);          // load email setting 
            $mail = new PHPMailer(true);                                // load php mailer 
            try {
                //Server settings
                $mail->CharSet = 'UTF-8';
                if ($debug) $mail->SMTPDebug = 4;                                //Enable verbose debug output
                $mail->isSMTP();                                        //Send using SMTP
                $mail->Host       = $email->host;                       //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                               //Enable SMTP authentication
                $mail->AuthType = 'LOGIN';
                $mail->Username   = $email->user;                       //SMTP username
                $mail->Password   = $email->password;                   //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $email->port;                       //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($email->sending_email, $email->sending_name);
                foreach ($to as $index => $reciver) {
                    if ($index == 0) {
                        $mail->addAddress($reciver);
                    } else {
                        $mail->addCC($reciver);
                    }
                }
                //Add a recipient
                // $mail->addAddress('ellen@example.com');               //Name is optional
                $mail->addReplyTo($email->sending_email, $email->sending_name);
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                // //Attachments
                if ($attachment) $mail->addAttachment($attachment);         //Add attachments

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $msg;

                return $mail->send();
            } catch (Exception $e) {
                if ($debug) echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $separator = md5(time());   // carriage return type (RFC)
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= 'From: ' . $email->sending_name . '<' . $email->sending_email . '>' . "\r\n";
            $headers .= 'Reply-To: ' . $email->sending_email . '' . "\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . "\r\n";
            $headers .= "Content-Transfer-Encoding: 7bit" . "\r\n";
            $headers .= "This is a MIME encoded message." . "\r\n";

            // message
            $body = "--" . $separator . "\r\n";
            $body .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . "\r\n";
            $body .= "Content-Transfer-Encoding: 8bit" . "\r\n";
            $body .= $msg . "\r\n";

            // attachment
            if ($attachment) {
                $filename = basename($attachment);
                $attachment = file_get_contents($attachment);
                $attachment = chunk_split(base64_encode($attachment));  // a random hash will be necessary to send mixed content
                // attachment
                $body .= "--" . $separator . "\r\n";
                $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . "\r\n";
                $body .= "Content-Transfer-Encoding: base64" . "\r\n";
                $body .= "Content-Disposition: attachment" . "\r\n";
                $body .= $attachment . "\r\n";
                $body .= "--" . $separator . "--";
            }
            return mail($to, $subject, $body, $headers); // sending Email

        }
    }

    /**
     * Sending SMS message
     *
     * @param string$to
     * @param string$msg
     * @return void
     */
    public function SMS($to, $msg)
    {
        $smsSettings = $this->getSettings('sms'); // load sms setting 
        $sms = json_decode($smsSettings->value);
        if (!$sms->smsenabled) {
            flash('msg', 'هناك خطأ ما بوابة الارسال غير مفعلة', 'alert alert-danger');
            redirect('donations');
        }
        return sendSMS($sms->sms_username, $sms->sms_password, $msg, $to, $sms->sender_name, $sms->gateurl, $sms->gateway);
    }

}
