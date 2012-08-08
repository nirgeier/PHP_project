; test query to see if the DB exists or not
test='select * from users'

;Create the needed schema
create.db='CREATE DATABASE my_db'

;Users
users.check_username='select count(1) from users where username=?'
users.select_user='select * from users where username=:username and password=:password'
users.register='INSERT INTO `users` (`username`, `password`, `email`,`first_name`, `last_name`, `nick_name`) VALUES ( :username, :password, :email, :first_name, :last_name, :nick_name)'

