<?php
class ApiController
{
    protected $model;

    /**
     * load model
     * @param string $model
     * @return object
     */
    public function model($model, $vars = '')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
        } else {
            return $this->error('HTTP POST method only supported by this endpoint.');
        }
        // require model file
        require_once '../app/models/' . $model . '.php';
        //instatiate model
        return new $model($vars);
    }

    /**
     * Return error
     *
     * @param string $msg
     * @param integer $code
     * @return void
     */
    public function error($msg = 'Error Accourd.', $code = 404)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        $response = [
            "success" => false,
            "error" => [
                "code" => $code,
                "message" => $msg
            ]
        ];
        return exit(json_encode($response));
    }
    /**
     * return response message
     *
     * @param string $response
     * @param integer $code
     * @return string JSON
     */
    public function response($response, $code = 200, $msg = null)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        $response = [
            "success" => true,
            "data" => $response
        ];
        if ($msg) $response['msg'] = $msg;
        return exit(json_encode($response));
    }
    /**
     * displaying not found response page
     *
     * @return void
     */
    public function notFound()
    {
        return $this->error('Page not found');
    }

    /**
     * check if fieled is mandatory
     *
     * @param string $fieled
     * @return error|string
     */
    public function required($fieled)
    {
        if (!@exist($_POST[$fieled])) {
            return $this->error($fieled . ' field is mandatory');
        } else {
            return $_POST[$fieled];
        }
    }

    /**
     * check if array of fields is exist or not
     *
     * @param array $fieleds
     * @return array|response
     */
    public function requiredArray(array $fieleds)
    {
        $msg = '';
        foreach ($fieleds as $fieled) {
            if (!@exist($_POST[$fieled])) {
                $msg .=  "$fieled field is mandatory. ";
            }
            @$post_fields[$fieled] = $_POST[$fieled];
        }
        if (!empty($msg)) {
            return $this->error($msg);
        } else {
            return $post_fields;
        }
    }

    /**
     * return Bearer token if it has been sent
     *
     * @return string|null
     */
    protected function bearerToken()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        if ($headers) {
            return substr($headers, 7);
        }
        return $headers;
    }
}
