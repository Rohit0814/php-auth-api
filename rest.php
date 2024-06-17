<?php
class Rest
{
    protected $request;
    protected $serviceName;
    protected $param;
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->throwError(100, "This is Not a Proper Methods");
        }
        $handler = fopen('php://input', 'r');
        $this->request = stream_get_contents($handler);
        $this->validateRequest();
        //echo $request;
    }

    public function validateRequest()
    {
        if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
            $this->throwError(101, "Request Content type is invalid");
        }

        $data = json_decode($this->request, true);
        $this->serviceName = $data['name'];
        $this->param = $data['param'];
        //print_r($data);
    }

    public function processApi()
    {
        $api = new Api();
        $rMethods = new ReflectionMethod('Api', $this->serviceName);
        if (!method_exists($api, $this->serviceName)) {
            $this->throwError(107, "Api doesn't exist...");
        }

        $rMethods->invoke($api);
    }

    public function validateParameter($fieldName, $value, $datatype, $required = true)
    {
        if ($required == true && empty($value) == true) {
            $this->throwError(103, $fieldName . ' is required....');
        }
    }

    public function throwError($code, $message)
    {
        header("content-type:application/json");
        $errorMsg = json_encode(['status' => $code, 'message' => $message]);
        echo $errorMsg;
        exit;
    }

    public function returnResponse($code, $data)
    {
        header("content-type: application/json");
        $response = json_encode(['response' => ['status' => $code, $data]]);

        return $response;
        exit;
    }
}
