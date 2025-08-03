<?php
if (isset($_POST['backup']) && $_POST["backup"] == "yes") {
    // Database configuration
    include "../dbconfig.php";
    try {

        // Get all tables
        $tables = [];
        $result = query("SHOW TABLES");
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        // File to save the backup
        $date = date('Y-m-d_H-i-s');
        $backupFile = './backup/backup_alumni_portal' . '_' . $date . '.sql';
        $handle = fopen($backupFile, 'w+');

        // Loop through each table
        foreach ($tables as $table) {
            // Get CREATE TABLE statement
            $createTableResult = query("SHOW CREATE TABLE $table");
            $createTableRow = $createTableResult->fetch(PDO::FETCH_ASSOC);
            fwrite($handle, "\n\n" . $createTableRow['Create Table'] . ";\n\n");

            // Get INSERT INTO statements for each row
            $result = query("SELECT * FROM $table");
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $columns = array_keys($row);
                $columnsList = implode('`, `', $columns);
                $valuesList = array_map([$con, 'quote'], array_values($row));
                $valuesList = implode(", ", $valuesList);
                fwrite($handle, "INSERT INTO `$table` (`$columnsList`) VALUES ($valuesList);\n");
            }
            fwrite($handle, "\n\n");
        }

        fclose($handle);
        $output = array(
            "title" => "Backed Up",
            "icon" => "success",
            "msg" => "Backup successfully created!"
        );
        echo json_encode($output);
    } catch (PDOException $e) {
        $output = array(
            "title" => "Error",
            "icon" => "error",
            "msg" => $e->getMessage()
        );
        echo json_encode($output);
    } catch (Exception $e) {
        $output = array(
            "title" => "Error",
            "icon" => "error",
            "msg" => $e->getMessage()
        );
        echo json_encode($output);
    }
}
?>
