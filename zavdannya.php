<?php
    header('Content-Type: application/json; charset=utf-8');
    $text_data = file_get_contents('data.txt');
    $lines = explode("\n", $text_data);

    $clean_lines = [];

    foreach ($lines as $line){
        $current_line = trim($line);

        if(!empty($current_line)){
            $clean_lines[] = $current_line;
        }
    }

    $sections = [];
    $current_category = "";
    $current_sub_type = "";

    foreach($clean_lines as $line){
       if (preg_match('/^\d+\.\d+\./', $line)){
        $current_category = $line;
        $sections[$current_category] = [];
       }
       else if (mb_strpos($line, "завданнями") !== false){
        $current_sub_type = "tasks";
       }
       else if (mb_strpos($line, "Шляхи виконання") !== false){
        $current_sub_type = "methods";
       }
       else if (mb_strpos($line, "результати") !== false){
        $current_sub_type = "results";
       }
       else if(mb_strpos($line, '') !== false){
        $clean_item = trim(str_replace('', '', $line));
            if ($current_category && $current_sub_type) {
                $sections[$current_category][$current_sub_type][] = $clean_item;
            }
        }
    }
    $api_response = [
    "city" => "Суми",
    "document" => "Програма розвитку 2024",
    "data" => $sections 
];
echo json_encode($api_response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>