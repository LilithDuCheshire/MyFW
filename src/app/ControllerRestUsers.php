<?php

namespace MyFW\App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use \MyFW\Core\Request;

class ControllerRestUsers
{

    private $_request;

    public function __construct(Request $r)
    {
        $this->_request = $r;
    }

    function defaut($params = NULL)
    {
        header('Content-Type: application/json');
        // 8 cas REST
        switch ($this->_request->getMethod()) {
            case 'GET':
                if (is_null($params)) {
                    echo 'List all users';
                    echo Users::all()->toJson();
                } else {
                    try {
                        echo Users::findOrFail($params)->toJson();
                    } catch (ModelNotFoundException $e) {
                        echo '{"success": "fail", "message":"not found"}';
                    }
                }
                break;
            case 'POST':
                print_r($this->_request->getArguments()['data']);
                $data = $this->_request->getArguments()['data'];
                $u = new Users();
                $u->firstname = $data['firstname'];
                $u->lastname = $data['lastname'];
                $u->roles_id = $data['roles_id'];
                $u->save();
                break;
            case 'PUT':
                if (is_null($params)) {
                    echo '{"success":"failed","message":"function restricted"}';
                } else {

                    print_r($this->_request->getArguments()['data']);
                    print_r($params);
                    $u = Users::find($params);
                    $data = $this->_request->getArguments()['data'];
                    if (isset($u)) {
                        if (isset($data['firstname'])) $u->firstname = $data['firstname'];
                        if (isset($data['lastname'])) $u->lastname = $data['lastname'];
                        if (isset($data['roles_id'])) $u->roles_id = $data['roles_id'];
                        $u->save();
                    } else {
                        $u = new Users();
                        $u->id = $params;
                        $u->firstname = $data['firstname'];
                        $u->lastname = $data['lastname'];
                        $u->roles_id = $data['roles_id'];
                        $u->save();
                    }
                }
                break;
            case 'PATCH':
                print_r($this->_request->getArguments()['data']);
                print_r($params);
                $u = Users::find($params);
                $u->firstname = $this->_request->getArguments()['data']['firstname'];
                $u->lastname = $this->_request->getArguments()['data']['lastname'];
                $u->save();
                break;
            case 'DELETE':
                if (is_null($params)) {
                    echo '{"success":"failed","message":"function restricted"}';
                } elseif (is_callable($params)) {
                    echo 'Delete user #' . $params;
                    Users::destroy($params);
                    echo '{"success": "true", "item' . $params . '":"deleted"}';
                } else {
                    echo '{"success":"failed","message":"function restricted"}';
                }
                break;
        }


    }
}
