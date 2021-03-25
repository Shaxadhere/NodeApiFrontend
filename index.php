<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div id="root" class="container" style="margin-top:80px !important">
        </div>
    </div>
</body>

<!--   Delete Modal   -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete <strong id="modal-title"></strong>?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-footer">
                    <input type="hidden" id="modal-id" value="" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" id="confirm" class="btn btn-danger" data-dismiss="modal">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    //Empty Table Template
    var EmptyTable = "<button id='btnGetCreateForm' type='button' class='btn btn-primary'>Create Post</button>" +
        "<table class='table' style='margin-top:10px !important'>" +
        "<thead>" +
        "<tr>" +
        "<th>SNo</th>" +
        "<th>Title</th>" +
        "<th>Body</th>" +
        "<th>Actions</th>" +
        "</tr>" +
        "</thead>" +
        "<tbody id='table-body'>" +
        "</tbody>" +
        "</table>";

    //Get List
    $(document).ready(function() {
        $('#root').html(EmptyTable);
        $.ajax({
            type: "GET",
            url: "http://localhost:8080",
            success: function(response) {
                var stringfied = JSON.stringify(response)
                var result = JSON.parse(stringfied);
                var posts = result['posts'];
                var Sno = 1;
                posts.forEach(value => {
                    var RowTemplate = "<tr>"+
                    "<td>" + Sno + "</td>"+
                    "<td>" + value['title'] + "</td>"+
                    "<td>" + value['body'] + "</td>"+
                    "<td>"+
                    "<button class='btn btn-link EditPost'>Edit</button>"+
                    "<button data-id='"+value['_id']+"' data-title='"+value['title']+"' class='btn btn-link text-danger DeletePost' data-toggle='modal' data-target='.bd-example-modal-sm'>Delete</button>"+
                    "</td>"+
                    "</tr>";
                    $('#table-body').append(RowTemplate)
                    Sno++;
                });

            },
            error: function(error) {
                console.log("error: " + error)
            }
        })
    })

    //Show Add Form
    $(document).on('click', '#btnGetCreateForm', function() {
        $.ajax({
            type: "GET",
            url: "CreatePost.php",
            success: function(response) {
                $('#root').html(response);
            },
            error: function(error) {
                console.log("error: " + error)
            }
        })
    })

    //Show Table
    $(document).on('click', '#btnBack', function() {
        $('#root').html(EmptyTable);
        $.ajax({
            type: "GET",
            url: "http://localhost:8080",
            success: function(response) {
                var stringfied = JSON.stringify(response)
                var result = JSON.parse(stringfied);
                var posts = result['posts'];
                var Sno = 1;
                posts.forEach(value => {
                    var RowTemplate = "<tr>"+
                    "<td>" + Sno + "</td>"+
                    "<td>" + value['title'] + "</td>"+
                    "<td>" + value['body'] + "</td>"+
                    "<td>"+
                    "<button class='btn btn-link EditPost'>Edit</button>"+
                    "<button class='btn btn-link text-danger DeletePost'>Delete</button>"+
                    "</td>"+
                    "</tr>";
                    $('#table-body').append(RowTemplate)
                    Sno++;
                });

            },
            error: function(error) {
                console.log("error: " + error)
            }
        })
    })

    //Create Post
    $(document).on('click', '#CreatePost', function() {
        var title = $('#Title').val();
        var body = $('#Body').val();

        $.ajax({
            type: "POST",
            url: "http://localhost:8080/post",
            dataType: "json",
            contentType: "application/json",
            data: '{"title" : "' + title + '", "body" : "' + body + '" }',
            success: function(response) {
                console.log(response)
            },
        }).fail(function(response) {
            var data = response.responseJSON;
            console.log(response)
            var stringfied = JSON.stringify(data)
            var result = JSON.parse(stringfied);
            $('#error').html(result['error'])
        });
    })

    //Show Delete Modal
    $('.modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)

        var id = button.data('id');
        var title = button.data('title');
        console.log(title)
        $('#modal-id').val(id);
        $('#modal-title').html(title);
    })
</script>

</html>