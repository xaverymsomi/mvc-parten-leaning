<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only.
 * It is not recommended using it in production as it is.
 */

namespace App\Controllers;

use Abc\Base\BaseController;
use Abc\Utility\Log;
use Abc\Utility\RandomCharGenerator;
use Abc\Utility\Stringify;

class EmployeeController extends BaseController
{
    public function __construct()
    {
        parent::__construct('employee');
    }

    public function index()
    {
        $total_records = $this->model->count();
        
        if ($total_records > 0) {
            $data_array = $this->paginate($total_records);
        }

        $limit = $data_array['limit'] ?? null;

        $data_array['results'] = $this->model->read($limit);
        $data_array['total_records'] = $total_records;

        $this->view('employee/index', $data_array);
    }

    public function add()
    {
        $data = [
            'name' => Stringify::titlelize(RandomCharGenerator::name(6) . ' ' . RandomCharGenerator::name(7)),
            'company' => Stringify::titlelize(RandomCharGenerator::name(9)) . ' Company Ltd.',
        ];

        if ($this->model->create($data)) {
            Log::write('Employee added successfully');
        } else {
            Log::write('Employee creation failed');
        }
        header('Location: /employee');
    }
}
