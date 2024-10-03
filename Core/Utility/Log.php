<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only.
 * It is not recommended using it in production as it is.
 */

namespace Abc\Utility;

class Log
{
    public static $request_number;

    static function write($data, $log_type = NOTICE_LOG, $extra_info = null) {
        $log_type_uc = strtoupper($log_type);
        $system_audits_directory = 'system';

        date_default_timezone_set('Africa/Dar_es_Salaam');

        if (!file_exists(LOG_PATH . DS . $system_audits_directory)) {
            mkdir(LOG_PATH . DS . $system_audits_directory, 0777, true);
        }

        if ($log_type == 'plain') {
            $log = $data;
        } else {
            $log = '[' . date('Y-m-d H:i:s') . '] | ' . self::$request_number . ' - ' . '[' . $log_type_uc . ']' . ': ' . $data . "\n";
        }
        if ($extra_info !== null && $extra_info !== '') {
            if (!file_exists(LOG_PATH . DS . $log_type)) {
                mkdir(LOG_PATH . DS . $log_type, 0777, true);
            }

            $log_trace_file = LOG_PATH . DS . $log_type . DS . $log_type . '_trace_' . date('Y-m-d') . LOG_EXTENSION;
            $log_trace = '[' . date('Y-m-d H:i:s') . '] | ' . self::$request_number . ' - ' . '[' . $log_type_uc . ']' . ': ' . "\n" . $extra_info;
            $log_trace .= "\n\n**************************************************************************************************\n\n";
            file_put_contents($log_trace_file, $log_trace, FILE_APPEND | LOCK_EX);
        }

        $system_audits_file = LOG_PATH . DS . $system_audits_directory . DS . $system_audits_directory . '_log_' . date('Y-m-d') . LOG_EXTENSION;
        file_put_contents($system_audits_file, $log, FILE_APPEND | LOCK_EX);
    }
}