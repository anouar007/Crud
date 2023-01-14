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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.min.css"/>
</head>

<body>
    <div class="container">
        <div class="row mb-2 mt-4">
            <div class="col col-12">
                <h1>CRUD Project</h1>
            </div>
            <div class="col col-12">
                <button class="btn btn-primary float-end btn-sm" id="newClient" data-bs-toggle="modal" data-bs-target="#newClientModal">Add Client</button>
            </div>
        </div>
        <div class="row pt-2 pb-2" style="box-shadow: 1px 1px 3px 0px #c3c3c3;">
            <table class="table w-100 table-striped table-hover " id="clientsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Client Email</th>
                        <th>Client City</th>
                        <th></th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- New Client -->
    <div class="modal fade" id="newClientModal" tabindex="-1" aria-labelledby="newClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="enewClientModalLabel">Create new Client</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Client Name</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">city</label>
                            <input type="city" class="form-control" id="city">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addClient">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            let table = $("#clientsTable").DataTable({
                'processing': true,
                'serverSide': true,
                "searching": false,
                'ajax': {
                    'url': 'clientsController.php?request=get',
                },
                'columns': [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'city'
                    },
                    {
                        data: null,
                        render: (data) => {
                            return `<div class="text-center">
                                <button class="btn btn-primary edit" data-id="${data.id}">edit</button> 
                                <button class="btn btn-danger delete" data-id="${data.id}">delete</button>
                                </div>`
                        }
                    }
                ]
            });

            $("#addClient").on("click", function() {
                const name = $("#name").val();
                const email = $("#email").val();
                const city = $("#city").val();

                $.ajax({
                    url: 'clientsController.php?request=add',
                    type: "post",
                    data: {
                        name,
                        email,
                        city
                    },
                    success: (data) => {
                        if (data) {
                            $("#newClientModal").modal('hide');
                            $('#clientsTable').DataTable();
                            table.ajax.reload();
                        }
                    }
                });
            })

            $(document).on("click", ".delete", function() {
                const id = $(this).data("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: 'clientsController.php?request=delete',
                            type: "post",
                            data: {
                                id
                            },
                            success: (data) => {
                                if (data) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                    $('#clientsTable').DataTable();
                                    table.ajax.reload();
                                }
                            }
                        });

                    }
                })
            });

        });
    </script>
</body>

</html>