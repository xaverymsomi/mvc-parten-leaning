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

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct('user');
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

        $this->view('user/index', $data_array);
    }

    public function index_old()
    {
        $records_per_page = RECORDS_PER_PAGE;
        $total_records = $this->model->count();

        if ($total_records > 0) {
            $total_pages = ceil($total_records / $records_per_page);

            $current_page = (isset($_GET) && !empty($_GET)) ? preg_replace("/[A-Za-z\/]/", '', array_keys($_GET)[0]) : 1;
            $current_page = (empty($current_page) || $current_page < 1) ? 1 : $current_page;
            $current_page = $current_page > $total_pages ? $total_pages : $current_page;

            $limit['from'] = ($current_page - 1) * $records_per_page;
            $limit['to'] = $records_per_page;

            $previous = ($current_page > 1) ? $current_page - 1 : 1;
            $next = ($current_page >= $total_pages) ? $total_pages : $current_page + 1;

            $previous_disabled = ($current_page == 1) ? ' disabled' : '';
            $next_disabled = ($current_page == $total_pages) ? ' disabled' : '';
        }

        $results = $this->model->read($limit);



        $this->view('user/index', [
            'results' => $results,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'total_records' => $total_records,
            'previous' => $previous,
            'next' => $next,
            'previous_disabled' => $previous_disabled,
            'next_disabled' => $next_disabled,
        ]);
    }

    public function add()
    {
        $data = [
            'name' => Stringify::titlelize(RandomCharGenerator::name() . ' ' . RandomCharGenerator::name()),
            'address' => Stringify::titlelize(RandomCharGenerator::address()),
            'location' => Stringify::titlelize(RandomCharGenerator::address()),
        ];

        if ($this->model->create($data)) {
            Log::write('User added successfully');
        } else {
            Log::write('User creation failed');
        }
        header('Location: /user');
    }
}
