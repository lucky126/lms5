-- ----------------------------
-- Table structure for lms_system
-- ----------------------------
DROP TABLE IF EXISTS `lms_system`;
CREATE TABLE `lms_system`(
   id                   int not null auto_increment comment '系统ID',
   systemname           national varchar(50) not null comment '系统名称',
   systemidentity       varchar(50) not null comment '系统标识',
   memo                 text comment '备注',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='系统信息';


-- ----------------------------
-- Table structure for lms_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `lms_auth_group`;
CREATE TABLE `lms_auth_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text COMMENT '规则id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Table structure for lms_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `lms_auth_rule`;
CREATE TABLE `lms_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `icon` char(50) NOT NULL DEFAULT '' COMMENT 'menu icon',
  `isshow` int(11) NOT NULL DEFAULT '0' COMMENT '是否显示：1 显示，0 不显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=utf8 COMMENT='规则表';


-- ----------------------------
-- Records of lms_auth_rule
-- ----------------------------

INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('1', '0', 'Admin/Index/index', '控制台', '1', '1', '','','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('2', '1', 'System', '系统管理', '1', '1','', 'fa fa-cloud','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('3', '2', 'Admin/System/index', '系统管理', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('4', '1', 'Training', '培训计划管理', '1', '1','', 'fa fa-group','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('5', '4', 'Admin/Training/index', '培训计划管理', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('6', '1', 'Course', '课程管理', '1', '1', '','fa fa-book','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('7', '6', 'Admin/Course/index', '课程管理', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('8', '1', 'Student', '学员管理', '1', '1','', 'fa fa-slideshare','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('9', '8', 'Admin/Student/index', '学员信息管理', '1', '1', '','','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('10', '8', 'Admin/Student/RegManager', '注册学员管理', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('11', '8', 'Admin/Student/Import', '导入学员账号', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('12', '1', 'Finance', '财务管理', '1', '1','', 'fa fa-money','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('13', '12', 'Admin/Finance/index', '交费查询', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('14', '12', 'Admin/Finance/OfflineConfirm', '离线交费确认', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('15', '12', 'Admin/Finance/Stat', '财务统计', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('16', '1', 'ActivationCode', '激活码管理', '1', '1','','fa fa-barcode','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('17', '16', 'Admin/ActivationCode/index', '查询激活码', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('18', '16', 'Admin/ActivationCode/Revoke', '撤销激活码', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('19', '1', 'Progress', '学习情况', '1', '1','', 'fa fa-line-chart','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('20', '19', 'Admin/Progress/index', '学习情况查询', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('21', '19', 'Admin/Progress/stat', '学习情况统计', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('22', '1', 'User', '用户权限管理', '1', '1','', 'fa fa-user-md','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('23', '22', 'Admin/User/index', '后台用户管理', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('24', '22', 'Admin/Pages/index', '页面管理', '1', '1','', '','1');
INSERT INTO `lms_auth_rule` (`id`,`pid`,`name`,`title`,`status`,`type`,`condition`,`icon`,`isshow`) VALUES ('25', '22', 'Admin/Pages/UserType', '用户类型权限', '1', '1','', '','1');

-- ----------------------------
-- Table structure for lms_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `lms_auth_group_access`;
CREATE TABLE `lms_auth_group_access` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `group_id` int(11) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

-- ----------------------------
-- Table structure for lms_user
-- ----------------------------
DROP TABLE IF EXISTS `lms_user`;
CREATE TABLE `lms_user`(
   id                   char(36) not null comment '用户ID',
   loginname            national varchar(50) not null comment '用户名',
   pwd                  varchar(50) not null comment '密码',
   realname             national varchar(20) not null comment '真实姓名',
   systemid             int not null default 0 comment '系统ID',
   usertype             int not null comment '用户类型：0超管（测试帐号），1系统管理员，2教务管理员，3教师，4学生',
   registiontime        datetime not null comment '注册日期',
   logincount           int not null default 0 comment '登录次数',
   lastlogintime        datetime not null comment '最后登录日期',
   currentlogintime     datetime not null comment '当前登录时间',
   istestuser           int not null default 0 comment '是否测试帐号：0，不是；1，是',
   avator               varchar(100) not null,
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户信息';



/*==============================================================*/
/* Table: lms_training                                          */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_training`;
create table lms_training
(
   ID                   int not null auto_increment comment '培训班ID',
   SystemID             int not null comment '系统ID',
   TrainingName         national varchar(50) not null comment '培训班名称',
   TrainingCode         varchar(50) not null comment '培训计划编号',
   TraingType           int not null comment '培训类别',
   RegistrationStartTime datetime not null comment '报名开始时间',
   RegistrationEndTime  datetime not null comment '报名结束时间',
   StartTime            datetime not null comment '培训开始时间',
   EndTime              datetime not null comment '培训结束时间',
   IsOpen               int not null default 0 comment '是否开放（1-开放，0-未开放）',
   TrainingCost         decimal(9,1) not null comment '培训费',
   AllowNumberOfCourses int not null default 0 comment '允许选课数（0-选择全部）',
   Description          text not null comment '培训介绍',
   Content              text not null comment '培训内容',
   Memeber              text not null comment '培训对象',
   Notice               text not null comment '培训须知',
   IsPublishResult      int not null default 0 comment '是否发布成绩',
   MinPassResult        decimal(4,1) not null default 60 comment '最小通过成绩',
   PeriodNumberCode     varchar(20) not null,
   AddTime              datetime not null comment '添加时间',
   Status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='培训计划';


/*==============================================================*/
/* Table: lms_TrainingType                                      */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_TrainingType`;
create table lms_TrainingType
(
   ID                   int not null comment '类别ID',
   Name                 varchar(50) not null comment '类别名称',
   AddTime              datetime not null comment '添加时间',
   Status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (ID)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='培训类别';



/*==============================================================*/
/* Table: lms_trainingcourse                                    */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_trainingcourse`;
create table lms_trainingcourse
(
   systemid             int not null comment '系统ID',
   trainingid           int not null comment '培训班ID',
   scormid              int not null comment '课程ID',
   isrequired           int not null default 1 comment '是否必修课程（1-是，0-否）',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (systemid, trainingid, scormid)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='培训课程';


/*==============================================================*/
/* Table: lms_course                                            */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_course`;
create table lms_course
(
   id                   int not null auto_increment comment '课程ID',
   systemid             int not null comment '系统ID',
   coursecode           varchar(30) not null comment '课程代码',
   coursename           national varchar(50) not null comment '课程名称',
   typeid               int not null comment '课程类别',
   courseurl            varchar(255) not null comment '课程地址',
   democourseurl        varchar(255) not null comment '试听课程地址',
   coursehours          int not null comment '课程学时(单位分钟)',
   coursefee            decimal(9,1) not null comment '选课费',
   isscormcourse        int not null default 0 comment '1-是SCORM课程，0-不是SCORM课程',
   coursedescription    text not null comment '课程介绍',
   isopenselection      int not null default 1 comment '是否开放选课（1-开放，0-不开放）',
   isrecommand          int not null comment '是否推荐：0，否；1，是',
   ishot                int not null default 0 comment '是否热门：0，否；1，是',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程';

/*==============================================================*/
/* Table: lms_coursetype                                        */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_coursetype`;
create table lms_coursetype
(
   id                   int not null comment '类别ID',
   name                 varchar(50) not null comment '类别名称',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程类别';


/*==============================================================*/
/* Table: lms_coursesetting                                     */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_coursesetting`;
create table lms_coursesetting
(
   id                   int not null auto_increment comment '课程ID',
   isbulletin           int not null,
   isresource           int not null,
   isqa                 int not null,
   isevaluator          int not null,
   istest               int not null,
   ishomework           int not null,
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程设置';


/*==============================================================*/
/* Table: lms_coursebulletin                                    */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_coursebulletin`;
create table lms_coursebulletin
(
   `id`                   int not null auto_increment comment '公告ID',
   `courseid`             int not null comment '课程ID',
   `title`                varchar(200) not null comment '公告标题',
   `content`              text not null comment '公告内容',
   `type`                 int not null comment '公告类别',
   `endtime`              datetime not null comment '添加时间',
   `isdisplay`            int not null default 0 comment '显示状态：0，不显示；1，显示；',
   `addtime`              datetime not null comment '添加时间',
   `status`               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程公告';



/*==============================================================*/
/* Table: lms_courseresource                                    */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_courseresource`;
create table lms_courseresource
(
   id                   int not null auto_increment comment '资源ID',
   courseid             int not null comment '课程ID',
   title                varchar(200) not null comment '资源标题',
   content              text not null comment '资源内容',
   type                 int not null comment '资源类别',
   isurl                int not null default 0 comment '是否是URL：0，不是；1，是',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程资源';


/*==============================================================*/
/* Table: lms_courseevaluator                                   */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_courseevaluator`;
create table lms_courseevaluator
(
   id                   int not null auto_increment,
   courseid             int not null comment '课程ID',
   score                decimal(3,1) not null,
   lastmodifytime       datetime not null,
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程评价';

/*==============================================================*/
/* Table: lms_topic                                             */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_topic`;
create table lms_topic
(
   id                   int not null auto_increment comment '主题ID',
   courseid             int not null comment '课程ID',
   title                varchar(200) not null comment '标题',
   userid               char(36) not null comment '用户ID',
   postip               varbinary(50) not null comment '发帖IP',
   istop                int not null default 0 comment '是否置顶：0，否；1，是；',
   ispop                int not null default 0 comment '是否精华：0，否；1，是',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程答疑';


/*==============================================================*/
/* Table: lms_reply                                             */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_reply`;
create table lms_reply
(
   id                   int not null auto_increment comment '回帖ID',
   topicid              int not null comment '主题ID',
   courseid             int not null comment '课程ID',
   content              text not null comment '内容',
   userid               char(36) not null comment '用户ID',
   postip               varbinary(50) not null comment '发帖IP',
   istopic              int not null default 0 comment '是否是主贴：0，不是；1，是',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程答疑回帖';

/*==============================================================*/
/* Table: lms_studentbulletinreadinfo                           */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_studentbulletinreadinfo`;
create table lms_studentbulletinreadinfo
(
   id                   int not null auto_increment comment '公告ID',
   studentid            char(36) not null comment '学生ID',
   courseid             int not null comment '课程ID',
   readflag             int comment '阅读标记：0，未读；1，已读；',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id, studentid, courseid)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='学生课程公告阅读信息表';

/*==============================================================*/
/* Table: lms_note                                              */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_note`;
create table lms_note
(
   id                   int not null auto_increment,
   studentid            char(36) not null comment '学生ID',
   courseid             int not null comment '课程ID',
   title                varchar(200) not null,
   content              text not null,
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程笔记';

/*==============================================================*/
/* Table: lms_notefavorite                                      */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_notefavorite`;
create table lms_notefavorite
(
   id                   int not null auto_increment,
   noteid               int not null,
   studentid            char(36) not null comment '学生ID',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程笔记收藏';

/*==============================================================*/
/* Table: lms_studentcourseevaluate                             */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_studentcourseevaluate`;
create table lms_studentcourseevaluate
(
   id                   int not null auto_increment,
   studentid            char(36) not null comment '学生ID',
   courseid             int not null  comment '课程ID',
   score                decimal(3,1) not null comment '评价分值',
   comment              varchar(500) not null comment '评价内容',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='学生课程评价';



/*==============================================================*/
/* Table: e_studentbasicinfo                                    */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_studentbasicinfo`;
create table lms_studentbasicinfo
(
   id                   int not null auto_increment comment '学生ID',
   uid                  char(36) not null comment '学生UUID',
   userid               char(36) not null comment '用户ID',
   systemid             int not null comment '系统ID',
   name                 national varchar(50) not null comment '学生姓名',
   gender               national varchar(2) not null comment '性别',
   photo                varchar(100) not null comment '照片',
   tel                  varchar(20) not null comment '手机',
   email                varchar(50) not null comment 'Email',
   birthdate            datetime comment '生日',
   idtype               smallint not null comment '证件类型：1，身份证；2，护照；3：其他；',
   idcode               varchar(30) not null comment '证件号码',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='学员基本信息';

/*==============================================================*/
/* Table: lms_teacher                                           */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_teacher`;
create table lms_teacher
(
   id                   int not null auto_increment comment '教师ID',
   uid                  char(36) not null comment '教师UUID',
   userid               char(36) not null comment '用户ID',
   name                 varchar(50) not null comment '教师姓名',
   position             varchar(50) not null comment '教师职位',
   organization         varchar(50) not null comment '教师所属机构',
   description          text not null comment '教师简介',
   phone                varchar(50) not null comment '电话',
   email                varchar(50) not null comment 'Email',
   isrecommand          int not null comment '是否推荐：0，否；1，是',
   avator               varchar(200) not null comment '头像',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='教师信息';

/*==============================================================*/
/* Table: lms_teachercourse                                     */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_teachercourse`;
create table lms_teachercourse
(
   userid               char(36) not null comment '用户ID',
   scormid              int not null comment '课程ID',
   addtime              datetime not null comment '添加时间',
   status               int not null default 0 comment '状态：0，禁用；1，正常；-1，删除',
   primary key (userid, scormid)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='教师课程关系';








