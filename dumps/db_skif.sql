CREATE TABLE redirect_rewrites (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* c982h38h23h032 */;
ALTER TABLE redirect_rewrites ADD COLUMN src varchar(255) NOT NULL /* c03094vj34v */;
ALTER TABLE redirect_rewrites ADD COLUMN dst varchar(255) NOT NULL /* 3454t4b45b */;
ALTER TABLE redirect_rewrites ADD COLUMN code int NOT NULL /* n394hv043hg0 */;
ALTER TABLE redirect_rewrites ADD COLUMN kind int NOT NULL /* v3h09430v9304 */;
ALTER TABLE redirect_rewrites ADD UNIQUE KEY src (src,kind) /* nv309j40j334b */;
CREATE TABLE template (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* cj09jc09jf44v */;
ALTER TABLE template ADD COLUMN name varchar(50) NOT NULL DEFAULT '' /* 2dh30f90323 */;
ALTER TABLE template ADD COLUMN title varchar(100) NOT NULL DEFAULT '' /* 290hf09cjc */;
ALTER TABLE template ADD COLUMN css varchar(50) NOT NULL DEFAULT '' /* 384ch039h043 */;
ALTER TABLE template ADD COLUMN is_default smallint DEFAULT '0' /* 0h340h0gv3h */;
ALTER TABLE template ADD COLUMN layout_template_file varchar(50) NOT NULL DEFAULT '' /* c0j3j0943j0 */;
ALTER TABLE template ADD UNIQUE KEY name (name) /* 3c984hj943g03 */;
ALTER TABLE template ADD KEY is_default (is_default) /* 0c34hj09j03 */;
INSERT INTO template (id, name, title, css, is_default, layout_template_file) VALUES (1, 'main', 'Сайт. Три колонки', 'main.css', 1, 'layout.main.tpl.php') /* ncj40404039j */;
INSERT INTO template (id, name, title, css, is_default, layout_template_file) VALUES (2, 'admin', 'Система управления сайтом', 'skif.css', 0, 'layout.admin.tpl.php') /* cn983h04h23 */;
CREATE TABLE page_regions (id int NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE InnoDB DEFAULT CHARSET utf8 /* cj08j094jf0349 */;
ALTER TABLE page_regions ADD COLUMN name varchar(100) DEFAULT NULL /* c0j9k4039044 */;
ALTER TABLE page_regions ADD COLUMN template_id int DEFAULT NULL /* c03j094j03 */;
ALTER TABLE page_regions ADD COLUMN title varchar(100) DEFAULT NULL /* m09v3-490kg9 */;
ALTER TABLE page_regions ADD UNIQUE KEY name_template_id (name,template_id) /* v0j309j0394j3 */;
ALTER TABLE page_regions ADD KEY template_id (template_id) /* cj093j494j304j */;
INSERT INTO page_regions (id, name, template_id, title) VALUES (1, 'right_column', 1, 'Правая колонка') /* v43k-vk34-0-40kv */;
INSERT INTO page_regions (id, name, template_id, title) VALUES (2, 'left_column', 1, 'Левая колонка') /* cm92-k-230k-30k */;
INSERT INTO page_regions (id, name, template_id, title) VALUES (3, 'under_content', 1, 'Под контентом') /* -c92k3-023-f3 */;
INSERT INTO page_regions (id, name, template_id, title) VALUES (4, 'above_content', 1, 'Над контентом') /* cyvw8f32gf83gf */;
INSERT INTO page_regions (id, name, template_id, title) VALUES (5, 'inside_head', 1, 'Внутри head') /* 9cj-k03kc-320k-4 */;
INSERT INTO page_regions (id, name, template_id, title) VALUES (6, 'right_column', 3, 'Правая колонка') /* j32f-09j-3v9j */;
INSERT INTO page_regions (id, name, template_id, title) VALUES (7, 'above_content', 3, 'Над контентом') /*-2j-0j-ck23kk02f */;
INSERT INTO page_regions (id, name, template_id, title) VALUES (8, 'under_content', 3, 'Под контентом') /* dockpk2-30c3 */;
CREATE TABLE blocks (id int NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE InnoDB DEFAULT CHARSET utf8 /* jc09j329jf039j */;
ALTER TABLE blocks ADD COLUMN template_id int DEFAULT NULL /* 2c98h283h029h0fh2 */;
ALTER TABLE blocks ADD COLUMN weight int NOT NULL DEFAULT 0 /* 2938hf283hf0932 */;
ALTER TABLE blocks ADD COLUMN pages text NOT NULL /* dkjvb8f324hf0392fr */;
ALTER TABLE blocks ADD COLUMN title varchar(255) NOT NULL DEFAULT '' /* 039f029jcc3f3 */;
ALTER TABLE blocks ADD COLUMN cache tinyint NOT NULL DEFAULT 1 /* c8h984h9438h */;
ALTER TABLE blocks ADD COLUMN body longtext NOT NULL /* 298hf09320f9 */;
ALTER TABLE blocks ADD COLUMN format smallint DEFAULT 0 /* c98h98h349hc9438 */;
ALTER TABLE blocks ADD COLUMN page_region_id int DEFAULT NULL /* 3j049j0394jg */;
ALTER TABLE blocks ADD KEY title (title) /* 932uh0f9f32jf3 */;
ALTER TABLE blocks ADD KEY list (page_region_id,weight,title) /* 283hc023h09j02 */;
ALTER TABLE blocks ADD CONSTRAINT FK_blocks_template FOREIGN KEY (template_id) REFERENCES template (id) /* c334j0493j049 */;
ALTER TABLE blocks ADD CONSTRAINT FK_blocks_page_regions FOREIGN KEY (page_region_id) REFERENCES page_regions (id) /* c334j0493j049 */;
CREATE TABLE blocks_roles (id int NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE InnoDB DEFAULT CHARSET utf8 /* c00493j0c9j034 */;
ALTER TABLE blocks_roles ADD COLUMN block_id int NOT NULL /* 320jch09j230c9j */;
ALTER TABLE blocks_roles ADD COLUMN role_id int NOT NULL /* c082j039j039j302 */;
ALTER TABLE blocks_roles ADD KEY block_id_role_id (block_id,role_id) /* 832hf0c923hj093 */;
ALTER TABLE blocks_roles ADD CONSTRAINT FK_blocks_roles_blocks FOREIGN KEY (block_id) REFERENCES blocks (id) /* 3j049vj049j403 */;
ALTER TABLE blocks_roles ADD CONSTRAINT FK_blocks_roles_roles FOREIGN KEY (role_id) REFERENCES roles (id) /* c9328h0h49hc0932j */;
CREATE TABLE content_types (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* f934f0j4034jv0i4 */;
ALTER TABLE content_types ADD COLUMN type char(20) NOT NULL DEFAULT '' /* 039fj409j49gj340g */;
ALTER TABLE content_types ADD COLUMN name varchar(100) NOT NULL DEFAULT '' /* 039fj409j49gj340g */;
ALTER TABLE content_types ADD COLUMN url varchar(255) NOT NULL DEFAULT '' /* 039fj409j49gj340g */;
ALTER TABLE content_types ADD COLUMN template_id int(11) DEFAULT NULL /* 039fj409j49gj340g */;
ALTER TABLE content_types ADD UNIQUE KEY type (type) /* 039fj409j49gj340g */;
INSERT INTO content_types (id, type, name, url, template_id) VALUES (1, 'page', 'Страницы', '/', 1) /* 349j4309j043jg */;
INSERT INTO content_types (id, type, name, url, template_id) VALUES (2, 'news', 'Новости', '/news', 1) /* 34j094039vj0439 */;
INSERT INTO content_types (id, type, name, url, template_id) VALUES (3, 'photo', 'Фото', '/photo', 1) /* 23j0f9j0239fj3f */;
ALTER TABLE content_types ADD  CONSTRAINT `FK_template_id` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) /* 23hj09j3209jf032f */;
CREATE TABLE rubrics (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* 039jc03j04439j430 */;
ALTER TABLE rubrics ADD COLUMN name varchar(255) DEFAULT '' /* d93u0d9230d9302 */;
ALTER TABLE rubrics ADD COLUMN comment text /* 3029du0932d09j320 */;
ALTER TABLE rubrics ADD COLUMN content_type_id int DEFAULT NULL /* d928h398d0329dj03 */;
ALTER TABLE rubrics ADD COLUMN template_id int DEFAULT NULL /* 238hd09823d039 */;
ALTER TABLE rubrics ADD COLUMN url varchar(1000) DEFAULT '' /* 32d0923jd0j302dj */;
ALTER TABLE rubrics ADD KEY url (url(255)) /* 32hd09j309dj32 */;
ALTER TABLE rubrics ADD CONSTRAINT FK_content_type_id FOREIGN KEY (content_type_id) REFERENCES content_types (id) /* 8d32dhj0932jd093j */;
ALTER TABLE rubrics ADD  CONSTRAINT FK_template_id FOREIGN KEY (template_id) REFERENCES template (id) /* 93j039j409cj430 */;
INSERT INTO rubrics (id, name, comment, content_type_id, template_id, url) VALUES ('3', 'Новости и объявления', NULL, '2', NULL, '/news') /* nv034j04j0g44f */;
CREATE TABLE content (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* 34j09j3049cj0 */;
ALTER TABLE content ADD COLUMN title varchar(255) NOT NULL DEFAULT '' /* 23d9j0329jd0932jd */;
ALTER TABLE content ADD COLUMN short_title varchar(255) NOT NULL DEFAULT '' /* 320dj0329dj032jd */;
ALTER TABLE content ADD COLUMN annotation text NOT NULL /* 230d9j0329jd09j32 */;
ALTER TABLE content ADD COLUMN body mediumtext NOT NULL /* 32d9u230du0932 */;
ALTER TABLE content ADD COLUMN main_rubric_id int(11) DEFAULT NULL /* 293d8h9832dh93h */;
ALTER TABLE content ADD COLUMN published_at date DEFAULT NULL /* 32du32d-3209df342 */;
ALTER TABLE content ADD COLUMN unpublished_at date DEFAULT NULL /* 0329dj3209dj0329 */;
ALTER TABLE content ADD COLUMN is_published smallint NOT NULL DEFAULT '0' /* 382h09jd09j320d9 */;
ALTER TABLE content ADD COLUMN image varchar(100) NOT NULL DEFAULT '' /* 32jd0392jd09j32 */;
ALTER TABLE content ADD COLUMN description varchar(255) NOT NULL DEFAULT '' /* 38d0932jd0932j */;
ALTER TABLE content ADD COLUMN keywords varchar(255) NOT NULL DEFAULT '' /* 9328dh0239hd033 */;
ALTER TABLE content ADD COLUMN url varchar(1000) NOT NULL DEFAULT '' /* d902j2039jd039jd */;
ALTER TABLE content ADD COLUMN content_type_id int(11) DEFAULT NULL /* 32h0f932h0f9j3200f */;
ALTER TABLE content ADD COLUMN last_modified_at datetime NOT NULL /* 2dh398hf9d328hdf9 */;
ALTER TABLE content ADD COLUMN redirect_url varchar(1000) NOT NULL DEFAULT '' /* 9f834hf09j4309fj0 */;
ALTER TABLE content ADD COLUMN template_id int(11) DEFAULT NULL /* 39j9j43f9j430f9j */;
ALTER TABLE content ADD CONSTRAINT FK_main_rubric_id FOREIGN KEY (main_rubric_id) REFERENCES rubrics (id)  /* c09j4094j09j094 */;
ALTER TABLE content ADD CONSTRAINT FK_content_type_id FOREIGN KEY (content_type_id) REFERENCES content_types (id) /* c93j0394j094f */;
ALTER TABLE content ADD CONSTRAINT FK_template_id FOREIGN KEY (template_id) REFERENCES template (id) /* 034jc09j04394j0439j */;
CREATE TABLE content_rubrics (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* 9h3298c032jc0 */;
ALTER TABLE content_rubrics ADD COLUMN content_id int(11) DEFAULT NULL /* c2039jc0932j0c */;
ALTER TABLE content_rubrics ADD COLUMN rubric_id int(11) DEFAULT NULL /* 32jc0j032cj0233 */;
ALTER TABLE content_rubrics ADD UNIQUE KEY content_id_rubric_id (content_id,rubric_id) /* 3049j043jv043iv */;
ALTER TABLE content_rubrics ADD CONSTRAINT FK_content_rubrics_rubrics FOREIGN KEY (rubric_id) REFERENCES rubrics (id) /* 32jc0j032cj0233 */;
ALTER TABLE content_rubrics ADD CONSTRAINT FK_content_id FOREIGN KEY (content_id) REFERENCES content (id) /* 32jc0j032cj0233 */;
ALTER TABLE content_rubrics ADD CONSTRAINT FK_rubric_id FOREIGN KEY (rubric_id) REFERENCES rubrics (id) /* 32jc0j032cj0233 */;
CREATE TABLE content_photo (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* ij20c32jc032c03c */;
ALTER TABLE content_photo ADD COLUMN content_id int DEFAULT NULL /* 328h032jc03j2c03j */;
ALTER TABLE content_photo ADD COLUMN is_default tinyint NOT NULL DEFAULT 0 /* d8h09832d03j2dd */;
ALTER TABLE content_photo ADD COLUMN photo varchar(255) DEFAULT NULL /* 03vj349jf0fjf094j */;
ALTER TABLE content_photo ADD CONSTRAINT FK_content_id FOREIGN KEY (content_id) REFERENCES content (id) /* i32jc32c-k32-c0 */;
CREATE TABLE form (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* c98h209230f3f */;
ALTER TABLE form ADD COLUMN title varchar(200) NOT NULL /* 0823hcj09j309cj203 */;
ALTER TABLE form ADD COLUMN email varchar(100) NOT NULL DEFAULT '' /* 2830c923j0cj032jc */;
ALTER TABLE form ADD COLUMN email_copy varchar(100) NOT NULL DEFAULT '' /* c23h0ch320ch03j */;
ALTER TABLE form ADD COLUMN button_label varchar(100) NOT NULL DEFAULT '' /* cb92u39bch9328h */;
ALTER TABLE form ADD COLUMN comment mediumtext /* cn02j09j09fj032 */;
ALTER TABLE form ADD COLUMN response_mail_message mediumtext /* diuch98h3202j3 */;
ALTER TABLE form ADD COLUMN url varchar(1000) DEFAULT NULL /* 982h3hc98h983h2 */;
CREATE TABLE form_field (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* ci093j0943j034 */;
ALTER TABLE form ADD COLUMN `form_id` int NOT NULL /* ch20hc032h0c3c */;
ALTER TABLE form ADD COLUMN `name` varchar(255) NOT NULL DEFAULT  '' /* 28ch93hc93h2c98h2 */;
ALTER TABLE form ADD COLUMN `type` tinyint NOT NULL /* v89938jh043j040v094 */;
ALTER TABLE form ADD COLUMN `required` tinyint NOT NULL DEFAULT 0 /* bc823g938hcc33 */;
ALTER TABLE form ADD COLUMN `weight` smallint NOT NULL DEFAULT 0 /* cv93c29j00jf02f0 */;
ALTER TABLE form ADD COLUMN `size` smallint DEFAULT NULL /* c382h398ch329c8 */;
ALTER TABLE form ADD COLUMN `comment` varchar(255) NOT NULL DEFAULT  '' /* 283h9h9832hc92h */;
ALTER TABLE form ADD COLUMN title varchar(200) NOT NULL /* 02jc0932j0392jc */;
ALTER TABLE form ADD CONSTRAINT FK_form_id FOREIGN KEY (form_id) REFERENCES form (id) /* j9cj0392j093j232 */;
CREATE TABLE site_menu (id int NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE InnoDB DEFAULT CHARSET utf8 /* cj0394j309cj40 */;
ALTER TABLE site_menu ADD COLUMN `name` varchar(255) NOT NULL DEFAULT '' /* 398vhv408v943v */;
ALTER TABLE site_menu ADD COLUMN `url` varchar(512) NOT NULL DEFAULT '' /* 34v09jc029j03 */;
CREATE TABLE site_menu_item (id int NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE InnoDB DEFAULT CHARSET utf8 /* 094j09vj309j */;
ALTER TABLE site_menu_item ADD COLUMN `name` varchar(512) NOT NULL DEFAULT '' /* 98h2938ch93ch9333 */;
ALTER TABLE site_menu_item ADD COLUMN `url` varchar(512) NOT NULL DEFAULT '' /* c98h9832hc9238h9c8h */;
ALTER TABLE site_menu_item ADD COLUMN `content_id` int(11) unsigned DEFAULT NULL /* ch8h398h3298ch9 */;
ALTER TABLE site_menu_item ADD COLUMN `weight` int(11) unsigned NOT NULL DEFAULT '0' /* 721g9829h8hxuu2h */;
ALTER TABLE site_menu_item ADD COLUMN `parent_id` int(11) unsigned NOT NULL DEFAULT '0' /* 0c832093c09j3209 */;
ALTER TABLE site_menu_item ADD COLUMN `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0' /* 20389f-9u230f93029 */;
ALTER TABLE site_menu_item ADD COLUMN `menu_id` int(11) DEFAULT NULL /* 0293cj0923jc09j203 */;
ALTER TABLE site_menu_item ADD KEY `parent_weight` (`parent_id`,`weight`) /* 029309f3209fj03 */;
ALTER TABLE site_menu_item ADD CONSTRAINT FK_site_menu_id FOREIGN KEY (menu_id) REFERENCES site_menu (id) /*  2j239j-23j-0f3-2f */;
ALTER TABLE site_menu_item ADD CONSTRAINT FK_content_id FOREIGN KEY (content_id) REFERENCES content (id) /* 38948hv483v34 */;
CREATE TABLE comments (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* 0cj039j4049vj04 */;
ALTER TABLE comments ADD COLUMN `parent_id` int DEFAULT NULL /* 034vj0j0439vj */;
ALTER TABLE comments ADD COLUMN `url` varchar(2000) /* 3h84vh0vh04v0 */;
ALTER TABLE comments ADD COLUMN `url_md5` varbinary(32) DEFAULT NULL /* 9438vh40vh0h43 */;
ALTER TABLE comments ADD COLUMN `user_id` int DEFAULT NULL /* 934vh0h430vh430v */;
ALTER TABLE comments ADD COLUMN `user_name` varchar(100) DEFAULT NULL /* v93h40vh3049vj0 */;
ALTER TABLE comments ADD COLUMN `user_email` varchar(100) DEFAULT NULL /* 0349v09j340v9j04 */;
ALTER TABLE comments ADD COLUMN `comment` text /* 034v09j0943j */;
ALTER TABLE comments ADD CONSTRAINT FK_user_id FOREIGN KEY (user_id) REFERENCES users (id) /* v05j4v9j04v509 */;
ALTER TABLE comments ADD KEY `parent_id` (`parent_id`) /* 934h8h344vh48hv */;
ALTER TABLE comments ADD KEY `url_md5` (`url_md5`) /* 934h8h344vh48hv */;
CREATE TABLE poll (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* c2n3hj0923hv093 */;
ALTER TABLE poll ADD COLUMN `title` varchar(255) NOT NULL DEFAULT '' /* 28fh823hf98 */;
ALTER TABLE poll ADD COLUMN `is_default` smallint(6) NOT NULL DEFAULT '0' /* 2h938fh9823hf9 */;
ALTER TABLE poll ADD COLUMN `parent_id` int DEFAULT NULL /* 923hf8932hf983hf */;
ALTER TABLE poll ADD COLUMN `is_published` smallint(6) NOT NULL DEFAULT '0' /* 2i3ugf82g39f8 */;
ALTER TABLE poll ADD COLUMN `published_at` date NOT NULL /* 928h398h3f9h */;
ALTER TABLE poll ADD COLUMN `unpublished_at` date NOT NULL /* v893vh9g3g34 */;
ALTER TABLE poll ADD KEY `is_default` (`is_default`) /* 3v98h49v8h9348hv */;
ALTER TABLE poll ADD KEY `is_published` (`is_published`) /* hc983hv84hv9 */;
CREATE TABLE poll_question (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, created_at_ts int NOT NULL DEFAULT 0) ENGINE InnoDB DEFAULT CHARSET utf8 /* 2h98hv9832h93 */;
ALTER TABLE poll_question ADD COLUMN `poll_id` int(11) DEFAULT NULL /* v98h983h98h333 */;
ALTER TABLE poll_question ADD COLUMN `title` varchar(255) NOT NULL DEFAULT '' /* s08rhvb08h038h */;
ALTER TABLE poll_question ADD COLUMN `votes` int(11) NOT NULL DEFAULT '0' /* v398hv94h3vb9h */;
ALTER TABLE poll_question ADD COLUMN `weight` smallint(6) NOT NULL DEFAULT '0' /* 0823h98hg9348 */;
ALTER TABLE poll_question ADD CONSTRAINT FK_poll_id FOREIGN KEY (poll_id) REFERENCES poll (id) /* ch928h983h933 */;
