CREATE DATABASE `music_store` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `music_store`;

CREATE TABLE IF NOT EXISTS `song_artists` (
  `artist_id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_name` varchar(25) NOT NULL,
  `artist_image` varchar(25) NOT NULL,
  PRIMARY KEY (`artist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `song_artists` (`artist_id`, `artist_name`, `artist_image`) VALUES
(1, 'Weiver', 'default_image.png');

CREATE TABLE IF NOT EXISTS `song_genres` (
  `genre_id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_name` varchar(25) NOT NULL,
  `genre_order` int(11) NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `song_genres` (`genre_id`, `genre_name`, `genre_order`) VALUES
(1, 'Rock', 1),
(2, 'Heavy Metal', 2),
(3, 'Musical', 3),
(4, 'Country', 4),
(5, 'Western', 5);

CREATE TABLE IF NOT EXISTS `song_lyrics` (
  `song_id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `song_title` varchar(25) NOT NULL,
  `song_release_year` year(4) NOT NULL,
  `song_lyrics` text NOT NULL,
  PRIMARY KEY (`song_id`),
  FULLTEXT KEY `song_title` (`song_title`,`song_lyrics`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `song_lyrics` (`song_id`, `artist_id`, `genre_id`, `song_title`, `song_release_year`, `song_lyrics`) VALUES
(1, 1, 2, 'Imagi apona ban', 2007, 'Zu abuni gelen ade, fin cigi imagi imaji zn, du ilu cigi unama rubada. Sir vari imaji kizinda ne, in mon juda ziri pegun, pogin kayasada vi imi. Noci cigi uga ri. Ili vari gonyo lakada pe, pe din cagun velen pasuna, tan zn uaci suhum likada. Sun ruba riko cagun ne.\n\nVia sane tolen di, tu vio ille manze, in udeni ikuxin vio. Ipe cina denda hinne on, tebin pazocan adusinyo te sen. Mon si poru imagi apona, ban co para fonograf. Unya zate riko zi ipe, ubo ri puro tane tebin, ruta vema upive co tan. Don co jakine ikibani, ade je gala mendi, don zu itoni isuje agaden. Vi ubo cobi vema adani, keya nusi mesenyo izo co, xau visu zate berove zu. Aga itone sogane melangi vi, te moko adeya azucio ilu, in fin gala runbi dilakada.\n\nTu kenda udena zumeni puo, ila in malen urazo, uci renni imagi giuma hu. Ruba aniten cokolat in jio, bia co nuda abuni universita, zali vunna vio in. Apa on veca irida gadio, zin vi mate cena, te hun nuru isuje peceko. Kon apona iraxin cokolat hu, uga ni lasin azucio vedaya. Apa pila hala abuni si, muga mendi pasuna ta zin, tu dun zina keni universita. Zn ili nuru pogin lukaca, ri gase xinte lindi vin, veca asekio xau on. Ban zu huro asoyo finyuri.'),,
(2, 1, 2, 'Awesome Song', 1988, 'I had a feeling which lasted a life time...... and this feeling is as good as a lifetime.');

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_first_name` varchar(15) NOT NULL,
  `user_last_name` varchar(15) NOT NULL,
  `user_email_address` varchar(25) NOT NULL,
  `user_favourite_genre` int(11) NOT NULL,
  `user_phone_number` char(10) NOT NULL,
  `user_account_password` char(40) NOT NULL,
  `user_account_type` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `user_accounts` (`user_id`, `user_first_name`, `user_last_name`, `user_email_address`, `user_favourite_genre`, `user_phone_number`, `user_account_password`, `user_account_type`) VALUES
(1, 'Test', 'Test', 'test@test.com', 0, '0000000000', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', 2);


CREATE TABLE IF NOT EXISTS `user_panel_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(25) NOT NULL,
  `link_settings` varchar(25) NOT NULL,
  `user_account_type` int(11) NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


INSERT INTO `user_panel_links` (`link_id`, `link_name`, `link_settings`, `user_account_type`) VALUES
(1, 'page_profile', '', 1),
(2, 'page_register', '', 0),
(3, 'admin_artists', 'rows=3', 2),
(4, 'admin_lyrics', 'rows=5', 2);

CREATE TABLE IF NOT EXISTS `user_song_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `log_date` date NOT NULL,
  `log_status` int(11) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `user_song_log` (`log_id`, `user_id`, `log_date`, `log_status`) VALUES
(1, 1, '2009-11-12', 1);

CREATE TABLE IF NOT EXISTS `user_song_log_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
