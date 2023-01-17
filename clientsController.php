<?php
include "init.php";

if (isset($_GET["request"])) {
    switch ($_GET["request"]) {
        case 'get':

            $draw = $_GET['draw'];
            $row = $_GET['start'];
            $rowperpage = $_GET['length'];
            $columnIndex = $_GET['order'][0]['column'];
            $columnName = $_GET['columns'][$columnIndex]['data'];
            $columnSortOrder = $_GET['order'][0]['dir'];
            $searchQuery = '';

            if (isset($_GET['id'])) {
                $name = $_GET['id'];
                $searchQuery = " AND id = $id ";
            }
            if (isset($_GET['name'])) {
                $name = $_GET['name'];
                $searchQuery = " AND name LIKE '%$name%' ";
            }
            if (isset($_GET['email'])) {
                $name = $_GET['email'];
                $searchQuery = " AND email LIKE '%$email%' ";
            }
            if (isset($_GET['city'])) {
                $name = $_GET['city'];
                $searchQuery = " AND city LIKE '%$city%' ";
            }

            $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM clients ");
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecords = $records['allcount'];

            $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM clients WHERE 1 = 1 " . $searchQuery);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];

            $stmt = $conn->prepare("SELECT * FROM clients WHERE 1 = 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

            foreach ($searchArray as $key => $search) {
                $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
            $stmt->execute();
            $empRecords = $stmt->fetchAll();

            $data = array();

            foreach ($empRecords as $row) {
                $data[] = array(
                    "id" => $row['id'],
                    "email" => $row['email'],
                    "name" => $row['name'],
                    "city" => $row['city'],
                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );

            echo json_encode($response);
            break;
        case 'add':
            $name = $_POST["name"];
            $email = $_POST["email"];
            $city = $_POST["city"];
            
            $sql = "INSERT INTO `clients`(`name`, `email`, `city`) VALUES (?, ?, ?)";
            $stmt= $conn->prepare($sql);
            echo $stmt->execute([$name, $email, $city]) ? 1 : 0;
            break;
        case 'update':
            $name = $_POST["name"];
            $email = $_POST["email"];
            $city = $_POST["city"];
            $id = $_POST["clientId"];
            
            $sql = "UPDATE `clients` SET `name` = '$name', `email` = '$email', `city` = '$city' WHERE `clients`.`id` = $id;";
            $stmt= $conn->prepare($sql);
            echo $stmt->execute() ? 1 : 0;
            break;
        case 'delete':
            $id = $_POST["id"];
            
            $sql = "DELETE FROM `clients` WHERE id = ?";
            $stmt= $conn->prepare($sql);
            echo $stmt->execute([$id]) ? 1 : 0;
            break;
    }
}
