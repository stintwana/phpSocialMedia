<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting up database</title>
</head>
<body>
<!---Created Tables In The Database--->
    <h3>Setting things up</h3>
    <?php
    require_once 'functions.php';
    
    createTable('members',
    'user_id int(16) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_token VARCHAR(100) NOT NULL,
    user VARCHAR(20) UNIQUE NOT NULL,
    full_names VARCHAR(40) NOT NULL,
    pass VARCHAR(100) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    date_of_birth VARCHAR(20) NOT NULL,
    contact_number VARCHAR(15) NOT NULL,
    email_address VARCHAR(50) NOT NULL,
    area_location VARCHAR(100) NOT NULL,
    created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX(user(6)),
    INDEX(full_names(6)),
    INDEX(email_address(6)),
    INDEX(area_location(6))'); 

    createTable('friend_list',
    'friend_list_id int(16) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_token VARCHAR(100) NOT NULL,
    user VARCHAR(100) NOT NULL,
    friend_token VARCHAR(100) NOT NULL,
    friend VARCHAR(40)');

    createTable('profiles',
    'profile_id int(16) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_token VARCHAR(100) NOT NULL,
    full_names VARCHAR(40) NOT NULL,
    description VARCHAR(4096) NOT NULL,
    INDEX(full_names(6)),
    INDEX(description(6))');

    createTable('posts',
    '
    post_id int(16) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_token VARCHAR(100) NOT NULL,
    user VARCHAR(40) NOT NULL,
    associated_field VARCHAR(50) NOT NULL,
    post_body VARCHAR(4096) NOT NULL,
    created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX(user(6)),
    INDEX(associated_field(6)),
    INDEX(post_body(20))');

    createTable('comments',
    'comment_id int(16) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     post_id int(16) NOT NULL,
     user_token VARCHAR(100) NOT NULL,
     user VARCHAR(40) NOT NULL,
     comment VARCHAR(4096) NOT NULL, 
     created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     INDEX(user(6)),
     INDEX(comment(20))');

    createTable('interests',
    'interest_id int(16) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    interest_name VARCHAR(50) NOT NULL,
    INDEX(interest_name(6))');

    createTable('users_interests',
   'user_interests_id int(16) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_token VARCHAR(100) NOT NULL,
    interest_name VARCHAR(30) NOT NULL,
    INDEX(interest_name(6))');

    createTable('chat_message',
    'chat_message_id int(16) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    to_user_token VARCHAR(100) NOT NULL,
    from_user_token VARCHAR(10) NOT NULL,
    chat_message text NOT NULL,
    timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status int(1) NOT NULL');

    createTable('online_status',
    'online_status_id int(16) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_token VARCHAR(100) NOT NULL,
    last_activity timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_type enum("no","yes") NOT NULL');
/*
    createTable('user_ratings',
    'user_ratings_id int(16) PRIMARY KEY,
    rated_user_id int(16),
    ratings INT(11)');

    createTable('reactions',
    'reaction_id int(16) PRIMARY KEY,
    user_id int(16),
    post_id int(16)');

    createTable('populate',
'id INT UNSIGNED PRIMARY KEY,
users_id INT UNSIGNED,
post_id INT UNSIGNED,
entity_recommended VARCHAR(30),
comment VARCHAR(255)');

createTable('saved_posts',
'id INT UNSIGNED PRIMARY KEY,
    users_id INT UNSIGNED,
    username VARCHAR(40),
    associated_field VARCHAR(50),
    post_body VARCHAR(4096),
    created DATETIME,
    modified DATETIME,
    INDEX(username(6)),
    INDEX(associated_field(6)),
    INDEX(post_body(20))');
*/


    ?>
    <br/>....done
</body>
</html>