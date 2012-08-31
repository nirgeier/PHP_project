; test query to see if the DB exists or not
test='select * from users'

;Create the needed schema
create.db='CREATE DATABASE my_db'

;Actions
users.check_username='select count(1) as count from users where username=:username'
users.check_email='select count(1) as count from users where email=:email'
users.select_user='select * from users where username=:username and password=:password'
users.select_user_by_id='select * from users where id=:user_id'
users.register='INSERT INTO `users` (`username`, `password`, `email`,`first_name`, `last_name`, `nick_name`, `image`) VALUES ( :username, :password, :email, :first_name, :last_name, :nick_name, :image)'
users.update='UPDATE `users` SET password=:password, email=:email, first_name=:first_name, last_name=:last_name, nick_name=:nick_name, image=:image WHERE id=:id'
users.playlists='SELECT id, name from playlists pl JOIN users_playlists upl on pl.id=upl.playlist_id where upl.user_id=:user_id'
users.playlists.summary='SELECT Name, ( SELECT count(playlist_id) FROM playlists_songs pls WHERE pls.playlist_id = pl.id ) AS `Number of songs`, id FROM playlists pl JOIN users_playlists upl ON pl.id = upl.playlist_id WHERE upl.user_id =:user_id'
playlists.add='call add_playlist(:user_id, :name)'
playlists.add.song='call add_song(:pId, :videoId, :title)'
playlists.delete='call delete_playlist(:user_id, :p_id)'
playlists.songs='SELECT video_id, title FROM songs LEFT JOIN playlists_songs ON playlists_songs.song_id = songs.id WHERE playlist_id = :pId'


;Backoffice queries
backoffice.users='select id, username, email, first_name, last_name, nick_name, is_admin, DATE(last_login) as last_login, image from users'
backoffice.login='SELECT * FROM users WHERE username=:username and password=:password and is_admin=1'
