
<!DOCTYPE html>
<html>
<head>
    <title>Admin Blog List</title>
</head>
<body>
    <h1 style='color:red;'>Admin Blog List</h1>
    <table border='1'>
        <tr><th>Title</th><th>Actions</th></tr>
        @foreach($posts as $post)
        <tr>
            <td>{{ $post->title }}</td>
            <td><a href="#">Edit</a> | <a href="#">Delete</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>
