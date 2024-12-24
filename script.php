<?php
$servername = 'localhost';
$username   = 'root';
$password   = '123';
$dbname     = 'dev_local';
// Create connection
$conn = new mysqli( $servername, $username, $password, $dbname );
// Check connection
if ( $conn->connect_error ) {
	die( 'Connection failed: ' . $conn->connect_error );
}
for ( $i = 0; $i < 20000; $i++ ) {
	// Insert comment
	$sql = 'INSERT INTO wp_comments( comment_post_ID, comment_author, comment_author_email, comment_author_url, comment_author_IP, comment_date, comment_date_gmt, comment_content, comment_karma, comment_approved, comment_agent, comment_type, comment_parent, user_id ) VALUES( 1, ‘Author Name’, ‘author@example . com’, ‘’, ‘127.0.0.1’, NOW(), NOW(), ‘This is a comment . ', 0, 1, ‘’, ‘modula_comment’, 0, 0 )';
	if ( $conn->query( $sql ) === true ) {
		$comment_id = $conn->insert_id;
		// Insert commentmeta
		$meta_sql = “INSERT INTO wp_commentmeta( comment_id, meta_key, meta_value ) VALUES( $comment_id, ‘modula_image_id’, ‘94’ )“;
		$conn->query( $meta_sql );
	} else {
		echo ‘Error: ’ . $sql . ' < br > ’ . $conn->error;
}
}
// Close connection
$conn->close();
echo '20, 000 comments added successfully . ';
