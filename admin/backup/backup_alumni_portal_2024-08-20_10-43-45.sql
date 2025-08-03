

CREATE TABLE `course_duration` (
  `duration_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `duration` int(1) NOT NULL,
  `start_year` year(4) NOT NULL,
  `end_year` year(4) DEFAULT NULL,
  PRIMARY KEY (`duration_id`),
  KEY `fk_co` (`course_id`),
  CONSTRAINT `fk_co` FOREIGN KEY (`course_id`) REFERENCES `course_master` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `course_duration` (`duration_id`, `course_id`, `duration`, `start_year`, `end_year`) VALUES ('1', '2', '1', '2000', '');
INSERT INTO `course_duration` (`duration_id`, `course_id`, `duration`, `start_year`, `end_year`) VALUES ('2', '1', '2', '2000', '');
INSERT INTO `course_duration` (`duration_id`, `course_id`, `duration`, `start_year`, `end_year`) VALUES ('3', '5', '2', '2000', '');
INSERT INTO `course_duration` (`duration_id`, `course_id`, `duration`, `start_year`, `end_year`) VALUES ('4', '3', '5', '2000', '');
INSERT INTO `course_duration` (`duration_id`, `course_id`, `duration`, `start_year`, `end_year`) VALUES ('5', '4', '2', '2000', '');




CREATE TABLE `course_master` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_nm` varchar(150) NOT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `course_nm` (`course_nm`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `course_master` (`course_id`, `course_nm`) VALUES ('5', 'M.Tech');
INSERT INTO `course_master` (`course_id`, `course_nm`) VALUES ('1', 'MCA');
INSERT INTO `course_master` (`course_id`, `course_nm`) VALUES ('4', 'MSC AI&ML');
INSERT INTO `course_master` (`course_id`, `course_nm`) VALUES ('3', 'MSC. CS.');
INSERT INTO `course_master` (`course_id`, `course_nm`) VALUES ('2', 'PGDCSA');




CREATE TABLE `event_day` (
  `day_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  PRIMARY KEY (`day_id`),
  KEY `event` (`event_id`),
  CONSTRAINT `event` FOREIGN KEY (`event_id`) REFERENCES `event_master` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `event_day` (`day_id`, `event_id`, `event_date`) VALUES ('49', '8', '2024-09-14');
INSERT INTO `event_day` (`day_id`, `event_id`, `event_date`) VALUES ('74', '7', '2024-07-19');
INSERT INTO `event_day` (`day_id`, `event_id`, `event_date`) VALUES ('75', '9', '2024-08-12');
INSERT INTO `event_day` (`day_id`, `event_id`, `event_date`) VALUES ('76', '9', '2024-08-13');
INSERT INTO `event_day` (`day_id`, `event_id`, `event_date`) VALUES ('77', '9', '2024-08-14');
INSERT INTO `event_day` (`day_id`, `event_id`, `event_date`) VALUES ('78', '9', '2024-08-15');
INSERT INTO `event_day` (`day_id`, `event_id`, `event_date`) VALUES ('79', '9', '2024-08-16');
INSERT INTO `event_day` (`day_id`, `event_id`, `event_date`) VALUES ('80', '9', '2024-08-17');




CREATE TABLE `event_gallary` (
  `gallary_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`gallary_id`),
  KEY `fk_ev` (`event_id`),
  CONSTRAINT `fk_ev` FOREIGN KEY (`event_id`) REFERENCES `event_master` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `event_gallary` (`gallary_id`, `event_id`, `image`) VALUES ('3', '7', 'event gallary/alumni meet gallary.jpg');
INSERT INTO `event_gallary` (`gallary_id`, `event_id`, `image`) VALUES ('5', '8', 'event gallary/annual dinners.jpg');
INSERT INTO `event_gallary` (`gallary_id`, `event_id`, `image`) VALUES ('6', '7', 'event gallary/istockphoto-639698498-612x612.jpg');
INSERT INTO `event_gallary` (`gallary_id`, `event_id`, `image`) VALUES ('7', '9', 'event gallary/og_image.jpg');




CREATE TABLE `event_master` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(200) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `event_image` varchar(250) NOT NULL,
  `reg_status` enum('open','closed') NOT NULL DEFAULT 'closed',
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `event_master` (`event_id`, `event_title`, `description`, `location`, `start_date`, `end_date`, `event_image`, `reg_status`, `deleted`) VALUES ('7', 'Alumni Meet', '<blockquote data-placeholder=\"Type or paste your content here!\"><h3 data-placeholder=\"Type or paste your content here!\">Alumni Meet 2024 Event Description</h3></blockquote><p><strong>Event Name:</strong> Alumni Meet 2024</p><p><strong>Event Overview:</strong> The Alumni Meet 2024 is a grand gathering of our esteemed alumni community, designed to reconnect, celebrate, and inspire. This event is an opportunity for alumni from various batches to reunite, reminisce about their college days, and build new memories together.</p><blockquote><p><span style=\"font-size:18px;\"><strong>Event Highlights:</strong></span></p></blockquote><p><strong>Welcome Ceremony:</strong></p><ol><ul><li>A warm welcome by the organizing committee.</li><li>Opening address by the Dean/Principal.</li></ul></ol><p><strong>Keynote Speech:</strong></p><ol><ul><li>Inspiring talks by distinguished alumni and special guests.</li></ul></ol><p><strong>Networking Sessions:</strong></p><ol><ul><li>Dedicated time slots for alumni to network and reconnect with classmates, faculty, and current students.</li></ul></ol><p><strong>Panel Discussions:</strong></p><ol><ul><li>Interactive sessions featuring successful alumni sharing their experiences and insights on various professional fields.</li></ul></ol><p><strong>Cultural Performances:</strong></p><ol><ul><li>Dance, music, and drama performances by current students and alumni.</li></ul></ol><p><strong>Campus Tour:</strong></p><ol><ul><li>A nostalgic tour of the campus showcasing new developments and facilities.</li></ul></ol><p><strong>Awards and Recognition:</strong></p><ol><ul><li>Honoring notable alumni for their achievements and contributions to the community and society.</li></ul></ol><p><strong>Dinner and Social Gathering:</strong></p><ol><ul><li>A grand dinner with an opportunity to socialize and enjoy a relaxed evening.</li></ul></ol><p><strong>Special Features:</strong></p><ul><li><strong>Photo Booths:</strong> Capture memories with friends at themed photo booths.</li><li><strong>Merchandise Stalls:</strong> Exclusive alumni merchandise available for purchase.</li><li><strong>Memory Lane:</strong> A walk through the history of the institution with old photographs and memorabilia on display.</li></ul><p><strong>Registration:</strong></p><ul><li><strong>Online Registration:</strong> [Alumni Portal]</li><li><strong>Contact Information:</strong> For any queries, please contact [xyz@gmail.com].</li></ul><p>Join us for a memorable evening filled with laughter, nostalgia, and inspiration. Let’s celebrate the legacy and achievements of our alumni community together!</p>', 'Rajpath Club,Ahmedabad', '2024-07-19 19:00:00', '2024-07-19 22:00:00', 'event/alumni meet.jpg', 'closed', '0');
INSERT INTO `event_master` (`event_id`, `event_title`, `description`, `location`, `start_date`, `end_date`, `event_image`, `reg_status`, `deleted`) VALUES ('8', 'Annual Dinner', '<blockquote><h3><strong>Event Title: Alumni Annual Dinner</strong></h3></blockquote><p><strong>Description:</strong></p><p>Join us for a memorable evening at the Annual Alumni Dinner, where we celebrate the achievements and memories of our distinguished alumni. This event is a wonderful opportunity to reconnect with former classmates, network with fellow alumni, and engage with current faculty and students.</p><p>The evening will feature:</p><ul><li><strong>Welcome Reception:</strong> Begin the evening with a cocktail hour where you can mingle with old friends and make new connections.</li><li><strong>Dinner:</strong> Enjoy a gourmet meal prepared by [Insert Chef/Catering Service], featuring a variety of delicious options to cater to all tastes.</li><li><strong>Keynote Address:</strong> Hear from our special guest speaker, [Insert Speaker\'s Name and Title], who will share insights and experiences that inspire and entertain.</li><li><strong>Alumni Awards:</strong> Celebrate the accomplishments of our alumni with the presentation of awards recognizing outstanding achievements in various fields.</li><li><strong>Entertainment:</strong> Delight in performances by talented alumni and current students, showcasing the vibrant culture of our community.</li><li><strong>Networking Opportunities:</strong> Take advantage of the structured networking sessions to expand your professional connections and explore new opportunities.</li></ul><p><strong>Attire:</strong> Formal/Business Casual</p><p><strong>RSVP:</strong> Please confirm your attendance by [Insert RSVP Deadline] by visiting [Insert RSVP Link] or contacting [Insert Contact Information].</p><p>We look forward to an evening of celebration, connection, and shared memories. Don\'t miss this chance to be a part of our cherished alumni tradition!</p>', 'Patang Hotel,Ahmedabad', '2024-09-14 20:00:00', '2024-09-14 23:00:00', 'event/annual dinner.jpg', 'open', '0');
INSERT INTO `event_master` (`event_id`, `event_title`, `description`, `location`, `start_date`, `end_date`, `event_image`, `reg_status`, `deleted`) VALUES ('9', 'Coding Event', '<h2>Event Introduction: CodeFest 2024</h2><p>Welcome to CodeFest 2024, the ultimate coding extravaganza designed to ignite the passion for technology and innovation among college students! This year\'s event promises to be bigger, bolder, and more exciting than ever before.</p><p>CodeFest 2024 is a premier coding competition that brings together the brightest minds from various disciplines to collaborate, innovate, and showcase their programming skills. Whether you\'re a seasoned coder or a beginner eager to learn, this event offers something for everyone.</p><h3>Highlights of CodeFest 2024:</h3><p><strong>Hackathon:</strong> Engage in a 24-hour hackathon where teams will brainstorm, develop, and present groundbreaking software solutions to real-world problems. Creativity and innovation are key!</p><p><strong>Workshops and Seminars:</strong> Attend workshops and seminars led by industry experts on the latest trends in technology, programming languages, and development tools. Expand your knowledge and gain valuable insights.</p><p><strong>Coding Challenges:</strong> Test your coding skills in a series of challenges designed to push your problem-solving abilities to the limit. Compete individually or in teams to win exciting prizes.</p><p><strong>Networking Opportunities:</strong> Connect with fellow coders, industry professionals, and recruiters. Build your network, share ideas, and explore potential career opportunities.</p><p><strong>Tech Expo:</strong> Discover cutting-edge technologies and products from leading tech companies at the Tech Expo. Get hands-on experience with the latest gadgets and software.</p><h3>Who Can Participate?</h3><p>CodeFest 2024 is open to all college students with a passion for coding and technology. Whether you\'re an undergraduate, graduate, or Ph.D. student, you are welcome to join us and compete for glory.</p><h3>Why Participate?</h3><ul><li><strong>Learn and Grow:</strong> Enhance your coding skills and learn from the best in the industry.</li><li><strong>Win Prizes:</strong> Compete for cash prizes, internships, and job offers from top tech companies.</li><li><strong>Showcase Talent:</strong> Demonstrate your skills and creativity to potential employers.</li><li><strong>Have Fun:</strong> Enjoy a vibrant and dynamic environment filled with tech enthusiasts like yourself.</li></ul><h3>How to Register?</h3><p>Visit our official website at <a rel=\"noreferrer\" target=\"_new\">CodeFest2024.com</a> to register and get more information about the event schedule, rules, and prizes. Don’t miss this opportunity to be a part of the most exciting coding event of the year!</p><p>Join us at CodeFest 2024 and be a part of the future of technology!</p><figure class=\"table\"><table><tbody><tr><td><strong>DAY</strong></td><td><strong>EVENT</strong></td></tr><tr><td>12-08-2024</td><td>Hackethon</td></tr><tr><td>13-08-2024</td><td>Workshop&nbsp;</td></tr><tr><td>14-08-2024</td><td>Coding challenge</td></tr><tr><td>15-08-2024</td><td>Tech Expo</td></tr><tr><td>16-08-2024</td><td>Seminar</td></tr><tr><td>17-08-2024</td><td>Falicitation</td></tr></tbody></table></figure>', 'Ahmedabad', '2024-08-12 09:00:00', '2024-08-17 21:00:00', 'event/coding event.jpg', 'closed', '0');




CREATE TABLE `event_registration` (
  `user_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`day_id`),
  KEY `fk_day` (`day_id`),
  CONSTRAINT `fk_day` FOREIGN KEY (`day_id`) REFERENCES `event_day` (`day_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_u` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `event_registration` (`user_id`, `day_id`) VALUES ('8', '49');
INSERT INTO `event_registration` (`user_id`, `day_id`) VALUES ('8', '75');
INSERT INTO `event_registration` (`user_id`, `day_id`) VALUES ('8', '76');
INSERT INTO `event_registration` (`user_id`, `day_id`) VALUES ('8', '77');
INSERT INTO `event_registration` (`user_id`, `day_id`) VALUES ('8', '80');




CREATE TABLE `role_master` (
  `role_id` int(2) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `role_master` (`role_id`, `role_name`) VALUES ('1', 'admin');
INSERT INTO `role_master` (`role_id`, `role_name`) VALUES ('2', 'student');




CREATE TABLE `user_master` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(32) NOT NULL,
  `status` enum('v','un') DEFAULT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `u_state` varchar(20) NOT NULL,
  `u_city` varchar(20) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `start_year` year(4) DEFAULT NULL,
  `duration_id` int(11) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `profession` varchar(20) DEFAULT NULL,
  `role_id` int(2) NOT NULL,
  `image` varchar(250) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_rol` (`role_id`),
  KEY `fk_c` (`course_id`),
  KEY `fk_du` (`duration_id`),
  CONSTRAINT `fk_c` FOREIGN KEY (`course_id`) REFERENCES `course_master` (`course_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_du` FOREIGN KEY (`duration_id`) REFERENCES `course_duration` (`duration_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_rol` FOREIGN KEY (`role_id`) REFERENCES `role_master` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('1', '081a5f4bae48ecdf3786905d8f7cb7e1', '', 'Jignal', 'Gajjar', '2003-08-12', 'Gujarat', 'Ahmedabad', '', 'gajjarjignal2020@gmail.com', '7383813834', '', '', '', 'Male', '', '1', './user_image/jignal.jpg', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('2', 'f4d9c5c4dd3a4d7e505092e34d47e19a', 'v', 'tejas', 'solanki', '2003-06-10', 'Gujarat', 'Ahmedabad', 'Ellis bridge ,ahmedabad', 'tejassolanki7878@gmail.com', '8799646168', '2', '2023', '1', 'Male', 'student', '2', './user_image/tejas.jpg', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('3', '36ae05f8375ca48fc4624105f7eae28e', 'un', 'khushi', 'gajjar', '2003-08-12', 'Gujarat', 'Ahmedabad', '5,prabhu nagar Tenement,opp sanjay gandhi school,sabarmati', 'gajjarkj2020@gmail.com', '8401939545', '1', '2022', '2', 'Female', 'student', '2', './user_image/khushi.jpeg', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('5', 'baa59ef2657751681efd08c526c7be29', 'un', 'rahul', 'nai', '2000-08-10', 'Gujarat', 'Ahmedabad', '            ', 'gokubeinggoku@gmail.com', '7383438280', '2', '2016', '1', 'Male', 'student', '2', './user_image/rahul.jpg', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('8', 'e85332e5f9097e4a51c416811c0db971', 'v', 'bansari', 'kyada', '2002-08-30', 'Delhi', 'Central Delhi', '            ', 'bansari3008kyada@gmail.com', '9714353685', '1', '2023', '2', 'Female', 'student', '2', './user_image/bansari.jpg', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('9', 'a9b500302358d83ffa83f16a585eced9', 'un', 'heta', 'patel', '2001-07-12', 'Gujarat', 'Ahmedabad', '', 'gajjarkhushi576@gmail.com', '9737578058', '4', '2017', '5', 'Female', 'student', '2', './user_image/heta.jpg', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('10', '45251e8ad0287cd3ec529ae0e57ec429', 'un', 'jaymin', 'solanki', '2001-10-12', 'Gujarat', 'Junagadh', '            ', 'nikeair5352@gmail.com', '9328535703', '3', '2018', '4', 'Male', 'student', '2', './user_image/jaymin.jpg', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('11', 'd131ca80456ba8485d54a79ed6ea251c', 'un', 'javal', 'gajjar', '2003-08-12', 'Maharashtra', 'Mumbai City', ' ', 'javalgajjar747@gmail.com', '9099244737', '5', '2017', '3', 'Male', 'student', '2', './user_image/javal.png', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('12', '41b046191358d2415a4bfd551656c061', 'un', 'rohan', 'patel', '2002-01-23', 'Punjab', 'Amritsar', '            ', 'abc@gmail.com', '1234567890', '5', '2018', '3', 'Male', 'student', '2', './user_image/rohan.png', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('13', '89e244d27f4e0f6db49342beef9183f7', 'un', 'jinay', 'tandel', '1998-03-19', 'Gujarat', 'Surat', '            ', 'tandel.jinay77@gmail.com', '5658568992', '3', '2003', '4', 'Male', '', '2', './user_image/jinay.jpg', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('14', 'b24331b1a138cde62aa1f679164fc62f', 'un', 'priyanka', 'vania', '2003-06-18', 'Delhi', 'Central Delhi', '            ', 'aba@dhd.com', '5967825955', '4', '2014', '5', 'Female', 'student', '2', './user_image/priyanka.jpg', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('15', '417434084cc1ebc55311e61c6ceeb36c', 'un', 'vidhi', 'joshi', '2003-07-18', 'Goa', 'North Goa', '', 'vjjoshi2003@gmail.com', '1256668989', '2', '2023', '1', 'Female', 'student', '2', './user_image/vidhi.png', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('17', '762f44c342a9580748ef0cfaa527adf5', 'un', 'Bhavana', 'Gajjar', '1987-07-28', 'Gujarat', 'Ahmedabad', '5,prabhu nagar Tenement,opp sanjay gandhi school,sabarmati', 'xyz@gmail.com', '9727349169', '4', '2007', '5', 'Female', 'IT head', '2', './user_image/bhavana.png', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('24', '7f8199312f2c0cf56ef85ad625be6aaa', 'un', 'abc', 'xyz', '1995-02-02', 'Karnataka', 'Bangalore Urban', '            ', 'a@gmail.com', '1234567890', '3', '2019', '4', 'Male', 'Manager', '2', './user_image/abc.png', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('27', '4640543a2644cf85072e1bd3ced27a16', 'v', 'Trisha', 'Parekh', '2002-08-08', 'Punjab', 'Amritsar', '            ', 'parekhtrisha0101@gmail.com', '1023456789', '2', '2023', '1', 'Female', 'student', '2', './user_image/user.png', '0');
INSERT INTO `user_master` (`user_id`, `password`, `status`, `first_name`, `last_name`, `dob`, `u_state`, `u_city`, `address`, `email`, `phone`, `course_id`, `start_year`, `duration_id`, `gender`, `profession`, `role_id`, `image`, `deleted`) VALUES ('28', '4640543a2644cf85072e1bd3ced27a16', 'un', 'hardik', 'joshi', '1996-06-14', 'Gujarat', 'Mehsana', '', 'hardikjoshi@gujaratuniversity.ac.in', '9662111721', '4', '1991', '5', 'Male', 'Web Developer', '2', './user_image/user.png', '0');


