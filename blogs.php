<?php
$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASS;
$dbname = DB_TABLE;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}

$sql = "
    SELECT blogs.id, blogs.title, blogs.content, blogs.created_at, blogs.updated_at, users.firstname, users.lastname, categories.title AS category
    FROM blogs
    INNER JOIN blog_user ON blogs.id = blog_user.blog_id
    INNER JOIN users ON blog_user.user_id = users.id
    INNER JOIN blog_category ON blogs.id = blog_category.blog_id
    INNER JOIN categories ON blog_category.category_id = categories.id
    WHERE blogs.deleted = false";

$result = $conn->query($sql);

$blogs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogId = $row['id'];

        if (!isset($blogs[$blogId])) {
            $blog = [
                'id' => $blogId,
                'title' => $row['title'],
                'content' => $row['content'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
                'author' => $row['firstname'] . ' ' . $row['lastname'],
                'categories' => []
            ];

            $blogs[$blogId] = $blog;
        }

        $blogs[$blogId]['categories'][] = $row['category'];
    }
}

foreach ($blogs as $blog) {
    echo 'ID: ' . $blog['id'] . '<br>';
    echo 'Title: ' . $blog['title'] . '<br>';
    echo 'Content: ' . $blog['content'] . '<br>';
    echo 'Created_at: ' . $blog['created_at'] . '<br>';
    echo 'Updated_at: ' . $blog['updated_at'] . '<br>';
    echo 'Author ' . $blog['author'] . '<br>';
    echo 'Categories: ' . implode(', ', $blog['categories']) . '<br>';
    echo '<br>';
}

$conn->close();


