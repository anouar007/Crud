<?php
include "init.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
</head>
<body>
<div class="container">
    <div class="row mb-2 mt-5">
        <div class="col col-12">
            <h1>CRUD Project</h1> 
        </div>
        <div class="col col-12">
            <button class="btn btn-primary float-end btn-sm" id="newClient">Add Client</button>
        </div>
    </div>
    <div class="row pt-2" style="box-shadow: 1px 1px 3px 0px #c3c3c3;">
        <table class="table w-100 table-dark table-striped table-hover " id="clientsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Client Email</th>
                    
                </tr>
            </thead>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function(){
        $("#clientsTable").DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': {
                'url': 'clientsController.php?request=get',
            },
            'columns': [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' }
            ]
        });
    });
</script>
</body>
</html>