<?php
require_once("Crud.php");

class PostController
{

    public $crud;

    public function __construct()
    {
        $this->crud = new Crud();
    }

    public function getPosts()
    {
        // Whenever you use a count function you must use a GROUP BY
        $query = "SELECT posts.id, posts.post_title, posts.post_content,
                    count(comments.post_id) as nu_comment,
                    posts.is_featured, posts.post_image, posts.created_at, categories.cat_name
                    FROM posts 
                    LEFT JOIN comments ON comments.post_id = posts.id
                    LEFT JOIN categories ON categories.id = posts.cat_id
                    GROUP BY posts.id LIMIT  4";

        $post = $this->crud->read($query);
        return $post;
    }

    public function getPost($post_id)
    {
        // Whenever you use a count function you must use a GROUP BY
        $query = "SELECT posts.id, posts.post_title, posts.post_content, posts.cat_id,
                    count(comments.post_id) as nu_comment,
                    posts.is_featured, posts.post_image, posts.created_at, categories.cat_name
                    FROM posts 
                    LEFT JOIN comments ON comments.post_id = posts.id
                    LEFT JOIN categories ON categories.id = posts.cat_id
                    WHERE posts.id = $post_id
                    GROUP BY posts.id";

        $post = $this->crud->read($query);
        return $post;
    }

    public function addPosts()
    {
        $image_name = basename($_FILES["post_image"]["name"]);
        $posts = [
            "post_title" => $_POST["post_title"],
            "post_content" => $_POST["post_content"],
            "post_image" => $image_name,
            "cat_id" => $_POST["cat_id"],
        ];

        $post_id = $this->crud->create($posts, "posts");
        // Invoke the image
        $this->moveUploadedImage($post_id);
    }

    public function moveUploadedImage($post_id)
    {
        // We define a directory where we are going to
        // upload the image to
        $dir = "../../post_images/post_$post_id";
        // Get the image name
        $image_name = basename($_FILES["post_image"]["name"]);
        // Create the directory if it doesn't exist
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        // Append the image name to the directory
        $dir = $dir . "/" . $image_name;
        // Finally, we want to move the uploaded image
        // to the directory
        move_uploaded_file($_FILES["post_image"]["tmp_name"], $dir);
    }

    public function editPost($post_id)
    {
        $post_title = $_POST['post_title'];
        $cat_id = $_POST['cat_id'];
        $post_content = $_POST['post_content'];

        $query = "UPDATE posts SET post_title = '$post_title',
                    cat_id = '$cat_id', post_content = '$post_content'
                    WHERE id = $post_id";

        $this->crud->update($query);

        // Get the Post image if there is one
        $post_image = basename($_FILES["post_image"]["name"]);

        // If the user selected a new or image
        if (!empty($post_image)) {
            $query = "UPDATE posts SET post_image = '$post_image'
            WHERE id = $post_id";

            $this->crud->update($query);
            //  $this->deleteOldImage($post_id);
        }
        // If it is not empty move the new image to the new directory
        if (!empty($_FILES["post_image"]["name"])) {
            $this->moveUploadedImage($post_id);
        }
    }

    public function deletePost($post_id)
    {
        $query = "DELETE FROM posts WHERE id = $post_id";

        $this->crud->delete($query);
    }

    public function markPostAsFeatured($post_id)
    {
        $query = "UPDATE posts SET is_featured = '1' WHERE id = $post_id";

        $this->crud->update($query);
    }

    public function getFeaturedPosts()

    {
        $query = "SELECT  posts.id, posts.post_title, posts.post_content, posts.cat_id,
                    posts.is_featured, posts.post_image, posts.created_at, categories.cat_name 
                     FROM posts 
                LEFT JOIN categories ON categories.id = posts.cat_id
                WHERE is_featured = '1' ";

        $posts = $this->crud->read($query);

        return $posts;
    }

    public function getCategories()

    {
        $query = "SELECT categories.id, posts.id, posts.cat_id, categories.cat_name, count(posts.cat_id) as num_of_posts
                FROM categories 
                LEFT JOIN posts ON posts.cat_id = categories.id
                GROUP BY categories.id ";

        $categories = $this->crud->read($query);

        return $categories;
    }

    public function getPostsByCategory($cat_id)

    {
        $query = "SELECT posts.id, posts.created_at, posts.post_content, posts.post_title, posts.post_image, categories.cat_name 
                FROM posts 
                LEFT JOIN categories ON categories.id = posts.cat_id   WHERE posts.cat_id = $cat_id";

        $categories = $this->crud->read($query);

        return $categories;
    }

    public function getAllCategories()
    {
        $query = "SELECT * FROM categories";
        $categories = $this->crud->read($query);
        return $categories;
    }
}
