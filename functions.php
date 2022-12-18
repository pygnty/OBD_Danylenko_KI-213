<?php
$tables = array("clients", "filiation", "transactions", "workers");
foreach ($tables as $val) {
    pg_prepare($connection, "display_table_" . $val, "SELECT * FROM " . $val . " ORDER BY id LIMIT $1 OFFSET $2");
    pg_prepare($connection, "delete_" . $val, "DELETE FROM " . $val . " CASCADE WHERE id = $1 ");
    pg_prepare($connection, "get_" . $val, "SELECT * FROM " . $val . " WHERE id = $1");
}
pg_prepare($connection, "insert_clients", "INSERT INTO clients (name, worker_id) VALUES ($1,$2)");
pg_prepare($connection, "insert_filiation", "INSERT INTO filiation (address, boss_id) VALUES ($1,$2)");
pg_prepare($connection, "insert_transactions", "INSERT INTO transactions (sender_id, recipient_id, amount, comment) VALUES ($1,$2,$3,$4); ");
pg_prepare($connection, "insert_workers", "INSERT INTO workers (name, position, sallary, boss_id, filiation_id,login,password,rights) VALUES ($1,$2,$3,$4,$5,$6,$7,$8)");

pg_prepare($connection, "update_clients", "UPDATE clients SET name = $2, balance = $3, worker_id = $4 where id=$1");
pg_prepare($connection, "update_filiation", "UPDATE filiation SET address = $2, boss_id = $3 where id=$1");
pg_prepare($connection, "update_workers", "UPDATE workers SET name = $2, sallary = $3, position = $4, boss_id = $5, filiation_id = $6 where id=$1");

pg_prepare($connection, "login", "SELECT sha256((login || password)::bytea)::text as hash, rights FROM workers WHERE login = $1 and password = $2");
pg_prepare($connection, "get_rights", "SELECT rights FROM workers WHERE sha256((login || password)::bytea)::text = $1");

function escape_arr($connection, $arr)
{
    foreach($arr as $key => &$value){
        $value=pg_escape_string($connection, $value);
    }
    return $arr;
}

function display_column_names($data, $table_name)
{
    $output = '<tr>';
    if (!isset($data[0])) {
        return '<tr><th>NO DATA FOUND</th></tr>';
    }
    foreach ($data[0] as $k => $v) {
        $output .= '<th>' . $k . '</th>';
    }
    if (isset($data[0]["id"])) {
        $output .= '<th>Update</th>';
        $output .= '<th>Delete</th>';
    }
    $output .= '</tr>';
    return $output;
}
function display_data($data, $table_name)
{
    $output = '<table>';
    $output .= display_column_names($data, $table_name);
    
    foreach ($data as $var) {
        $output .= '<tr>';
        foreach ($var as $key => $value) {
            if ($key == "password")
                $value = "***";
            $output .= '<td>' . $value . '</td>';
        }
        if (isset($var["id"])) {
            $output .= '<td><a href="update_'.$table_name.'.php?id='.$var["id"].'">update</a></td>';
            $output .= '<td><a href="index.php?table='.$table_name.'&id='.$var["id"].'&action=delete">x</a></td>';
        }
        $output .= '</tr>';
    }
    $output .= '</table>';
    echo $output;
}

function display_table($connection, $name, $limit = 30, $offset = 0)
{
    global $tables;
    if(!in_array($name, $tables)){
        echo "<table><tr><th>TABLE NOT ALLOWED</th></tr></table>";
        return;
    }
    $data = pg_fetch_all(pg_execute($connection, "display_table_" . $name, array($limit, $offset)));
    display_data($data, $name);
    // var_dump($data);
}


?>