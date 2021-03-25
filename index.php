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
            <button id="btnGetCreateForm" type="button" class="btn btn-primary">Create Post</button>
            <table class="table" style="margin-top:10px !important">
                <thead>
                    <tr>
                        <th>SNo</th>
                        <th>Title</th>
                        <th>Body</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    
                </tbody>
            </table>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    //Get List
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "http://localhost:8080",
            success: function(response) {
                var stringfied = JSON.stringify(response)
                var result = JSON.parse(stringfied);
                var posts = result['posts'];
                var Sno = 1;
                posts.forEach(value => {
                    var RowTemplate = "<tr><td>"+Sno+"</td><td>"+value['title']+"</td><td>"+value['body']+"</td></tr>";
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
    $(document).on('click', '#btnGetCreateForm', function(){
        $.ajax({
            type: "GET",
            url: "CreatePost.php",
            success: function(response){
                $('#root').html(response);
            },
            error: function(error){
                console.log("error: " + error)
            }
        })
    })

    //Show Table
    $(document).on('click', '#btnBack', function(){
        
    })
</script>

</html>