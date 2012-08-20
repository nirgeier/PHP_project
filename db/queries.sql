; test query to see if the DB exists or not
test='select * from users'

;Create the needed schema
create.db='CREATE DATABASE my_db'

;Users
users.check_username='select count(1) as count from users where username=:username'
users.check_email='select count(1) as count from users where email=:email'
users.select_user='select * from users where username=:username and password=:password'
users.select_user_by_id='select * from users where id=:id'
users.register='INSERT INTO `users` (`username`, `password`, `email`,`first_name`, `last_name`, `nick_name`, `image`) VALUES ( :username, :password, :email, :first_name, :last_name, :nick_name, :image)'
users.update='UPDATE `users` SET password=:password, email=:email, first_name=:first_name, last_name=:last_name, nick_name=:nick_name, image=:image WHERE id=:id'

;Backoffice queries
backoffice.users='select id, username, email, first_name, last_name, nick_name, is_admin, DATE(last_login) as last_login, image from users'
backoffice.login='SELECT * FROM users WHERE username=:username and password=:password and is_admin=1'
