# test query to see if the DB exists or not
test='select * from users'

#Create the needed schema
create.db='CREATE DATABASE my_db'

# Users
users.select_user='select * from users where username=? and password=?'
