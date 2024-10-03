<?php

use Abc\Utility\Stringify;

require_once ROOT_PATH . '/App/Views/start.php'; ?>

<div class="container-fluid">
    <div class="row bg-light py-2 px-5 rounded">
        <div class="col-sm-8 mx-auto">
            <h1>All Employees</h1>
            <p><?= $data['total_records']; ?> record(s) found</p>
        </div>
        <div class="col-sm-4 mx-auto pt-5">
            <a href="/employee/add" class="btn btn-success">Add Employee</a>
        </div>
    </div>

    <?php if ($data['total_records'] > 0) { ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <?php
                    foreach (array_keys($data['results'][0]) as $result) {
                        echo "<th scope='col'>" . strtoupper(Stringify::titlelize($result)) . "</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['results'] as $result) {
                    // print_r($result);
                    echo '<tr>';
                    foreach ($result as $key => $value) {
                        echo '<td>' . $result[$key] . '</td>';
                    }
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                echo '<li class="page-item' . $data['previous_disabled'] . '"><a class="page-link" href="/' . $data['module_lowercase'] . '/index/' . $data['first'] . '">&laquo;</a></li>';
                echo '<li class="page-item' . $data['previous_disabled'] . '"><a class="page-link" href="/' . $data['module_lowercase'] . '/index/' . $data['previous'] . '">Previous</a></li>';
                for ($i = 1; $i <= $data['total_pages']; $i++) {
                    $active = ($i == $data['current_page']) ? ' active' : '';
                    echo '<li class="page-item' . $active . '"><a class="page-link" href="/' . $data['module_lowercase'] . '/index/' . $i . '">' . $i . '</a></li>';
                }
                echo '<li class="page-item' . $data['next_disabled'] . '"><a class="page-link" href="/' . $data['module_lowercase'] . '/index/' . $data['next'] . '">Next</a></li>';
                echo '<li class="page-item' . $data['next_disabled'] . '"><a class="page-link" href="/' . $data['module_lowercase'] . '/index/' . $data['last'] . '">&raquo;</a></li>';
                ?>
            </ul>
        </nav>
    <?php } else { ?>
        <div class="bg-light p-5 rounded">
            <div class="col-sm-8 mx-auto">
                <h1>No Records Found</h1>
                <p>To view some records, <a href='/employee/add'>add a new entry</a> to the corresponding table</p>
            </div>
        </div>
    <?php } ?>
</div>

<?php require_once ROOT_PATH . '/App/Views/end.php'; ?>