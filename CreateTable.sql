-- ----------------------------
-- Table structure for lms_system
-- ----------------------------
DROP TABLE IF EXISTS `lms_system`;
CREATE TABLE `lms_system` (
  id             INT                  NOT NULL AUTO_INCREMENT
  COMMENT '系统ID',
  systemname     NATIONAL VARCHAR(50) NOT NULL
  COMMENT '系统名称',
  memo           TEXT COMMENT '备注',
  addtime        DATETIME             NOT NULL
  COMMENT '添加时间',
  status         INT                  NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 20
  DEFAULT CHARSET = utf8
  COMMENT = '系统信息';

-- ----------------------------
-- Table structure for lms_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `lms_auth_group`;
CREATE TABLE `lms_auth_group` (
  `id`     INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`  CHAR(100)        NOT NULL DEFAULT '',
  `status` TINYINT(1)       NOT NULL DEFAULT '1',
  `rules`  TEXT COMMENT '规则id',
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 20
  DEFAULT CHARSET = utf8
  COMMENT = '用户组表';

INSERT INTO `lms_auth_group` (`id`, `title`, `status`, `rules`)
VALUES ('1', '超级管理员', '1', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33');

-- ----------------------------
-- Table structure for lms_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `lms_auth_rule`;
CREATE TABLE `lms_auth_rule` (
  `id`        INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `pid`       INT(11) UNSIGNED    NOT NULL DEFAULT '0'
  COMMENT '父级id',
  `name`      CHAR(80)            NOT NULL DEFAULT ''
  COMMENT '规则唯一标识',
  `title`     CHAR(20)            NOT NULL DEFAULT ''
  COMMENT '规则中文名称',
  `status`    TINYINT(1)          NOT NULL DEFAULT '1'
  COMMENT '状态：为1正常，为0禁用',
  `type`      TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  `condition` CHAR(100)           NOT NULL DEFAULT ''
  COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `icon`      CHAR(50)            NOT NULL DEFAULT ''
  COMMENT 'menu icon',
  `isshow`    INT(11)             NOT NULL DEFAULT '0'
  COMMENT '是否显示：1 显示，0 不显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 149
  DEFAULT CHARSET = utf8
  COMMENT = '规则表';

-- ----------------------------
-- Records of lms_auth_rule
-- ----------------------------

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('1', '0', 'Admin/Index/index', '控制台', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('2', '1', 'System', '系统管理', '1', '1', '', 'fa fa-cloud', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('3', '2', 'Admin/System/index', '系统管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)

VALUES ('4', '1', 'Training', '培训计划管理', '1', '1', '', 'fa fa-group', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('5', '4', 'Admin/Training/index', '培训计划管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('32', '4', 'Admin/Training/Add', '添加培训计划', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('33', '4', 'Admin/Training/Edit', '修改培训计划', '1', '1', '', '', '0');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('6', '1', 'Course', '课程管理', '1', '1', '', 'fa fa-book', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('7', '6', 'Admin/Course/index', '课程管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('8', '1', 'Student', '学员管理', '1', '1', '', 'fa fa-slideshare', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('9', '8', 'Admin/Student/index', '学员信息管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('10', '8', 'Admin/Student/RegManager', '注册学员管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('11', '8', 'Admin/Student/Import', '导入学员账号', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('12', '1', 'Finance', '财务管理', '1', '1', '', 'fa fa-money', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('13', '12', 'Admin/Finance/index', '交费查询', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('14', '12', 'Admin/Finance/OfflineConfirm', '离线交费确认', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('15', '12', 'Admin/Finance/Stat', '财务统计', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('16', '1', 'ActivationCode', '激活码管理', '1', '1', '', 'fa fa-barcode', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('17', '16', 'Admin/ActivationCode/index', '查询激活码', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('18', '16', 'Admin/ActivationCode/Revoke', '撤销激活码', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('19', '1', 'Progress', '学习情况', '1', '1', '', 'fa fa-line-chart', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('20', '19', 'Admin/Progress/index', '学习情况查询', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('21', '19', 'Admin/Progress/stat', '学习情况统计', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('22', '1', 'User', '用户权限管理', '1', '1', '', 'fa fa-user-md', '1');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('23', '22', 'Admin/User/index', '后台用户管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('24', '22', 'Admin/User/Add', '添加用户', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('25', '22', 'Admin/User/Edit', '修改用户', '1', '1', '', '', '0');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('26', '22', 'Admin/Rule/index', '权限管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('27', '22', 'Admin/Rule/Add', '添加权限', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('28', '22', 'Admin/Rule/Edit', '修改权限', '1', '1', '', '', '0');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('29', '22', 'Admin/Rule/Group', '角色管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('30', '22', 'Admin/Rule/Addgroup', '添加角色', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('31', '22', 'Admin/Rule/Editgrou', '修改角色', '1', '1', '', '', '0');

-- ----------------------------
-- Table structure for lms_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `lms_auth_group_access`;
CREATE TABLE `lms_auth_group_access` (
  `uid`      INT(11) UNSIGNED NOT NULL
  COMMENT '用户id',
  `group_id` INT(11) UNSIGNED NOT NULL
  COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`, `group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '用户组明细表';

-- ----------------------------
-- Records of admin_auth_group_access
-- ----------------------------
INSERT INTO `lms_auth_group_access` (`uid` ,`group_id`) VALUES ('1', '1');

-- ----------------------------
-- Table structure for lms_user
-- ----------------------------
DROP TABLE IF EXISTS `lms_user`;
CREATE TABLE `lms_user` (
  `id`        INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  uid               CHAR(36)             NOT NULL
  COMMENT '用户ID',
  loginname        NATIONAL VARCHAR(50) NOT NULL
  COMMENT '用户名',
  pwd              VARCHAR(50)          NOT NULL
  COMMENT '密码',
  realname         NATIONAL VARCHAR(20) NOT NULL
  COMMENT '真实姓名',
  systemid         INT                  NOT NULL DEFAULT 0
  COMMENT '系统ID',
  usertype         INT                  NOT NULL
  COMMENT '用户类型：0超管（测试帐号），1系统管理员，2教务管理员，3教师，4学生',
  registiontime    DATETIME             NOT NULL
  COMMENT '注册日期',
  logincount       INT                  NOT NULL DEFAULT 0
  COMMENT '登录次数',
  lastlogintime    DATETIME             NOT NULL
  COMMENT '最后登录日期',
  currentlogintime DATETIME             NOT NULL
  COMMENT '当前登录时间',
  istestuser       INT                  NOT NULL DEFAULT 0
  COMMENT '是否测试帐号：0，不是；1，是',
  avator           VARCHAR(100)         NOT NULL,
  addtime          DATETIME             NOT NULL
  COMMENT '添加时间',
  status           INT                  NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '用户信息';

INSERT INTO `lms_user` (`uid`, `loginname`, `pwd`, `realname`, `systemid`, `usertype`, `registiontime`, `logincount`, `lastlogintime`, `currentlogintime`, `istestuser`, `avator`, `addtime`, `status`)
VALUES
  ('1D4AB851-0D0D-1CC4-BC8D-F908C750F53A', 'admin', 'a2b44a387185a1263de5a8806655419c', 'admin', '0', '0',
                                           '2017-04-01 00:00:00', '0', '2017-04-01 00:00:00',
                                           '2017-04-01 00:00:00', '0', '1.png', '2017-04-01 00:00:00', '0');


/*==============================================================*/
/* Table: lms_training                                          */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_training`;
CREATE TABLE lms_training
(
  ID                    INT                  NOT NULL AUTO_INCREMENT
  COMMENT '培训班ID',
  SystemID              INT                  NOT NULL
  COMMENT '系统ID',
  TrainingName          NATIONAL VARCHAR(50) NOT NULL
  COMMENT '培训班名称',
  TrainingCode          VARCHAR(50)          NOT NULL
  COMMENT '培训计划编号',
  TraingType            INT                  NOT NULL
  COMMENT '培训类别',
  RegistrationStartTime DATETIME             NOT NULL
  COMMENT '报名开始时间',
  RegistrationEndTime   DATETIME             NOT NULL
  COMMENT '报名结束时间',
  StartTime             DATETIME             NOT NULL
  COMMENT '培训开始时间',
  EndTime               DATETIME             NOT NULL
  COMMENT '培训结束时间',
  IsOpen                INT                  NOT NULL DEFAULT 0
  COMMENT '是否开放（1-开放，0-未开放）',
  TrainingCost          DECIMAL(9, 1)        NOT NULL
  COMMENT '培训费',
  AllowNumberOfCourses  INT                  NOT NULL DEFAULT 0
  COMMENT '允许选课数（0-选择全部）',
  Description           TEXT                 NOT NULL
  COMMENT '培训介绍',
  Content               TEXT                 NOT NULL
  COMMENT '培训内容',
  Memeber               TEXT                 NOT NULL
  COMMENT '培训对象',
  Notice                TEXT                 NOT NULL
  COMMENT '培训须知',
  IsPublishResult       INT                  NOT NULL DEFAULT 0
  COMMENT '是否发布成绩',
  MinPassResult         DECIMAL(4, 1)        NOT NULL DEFAULT 60
  COMMENT '最小通过成绩',
  PeriodNumberCode      VARCHAR(20)          NOT NULL,
  AddTime               DATETIME             NOT NULL
  COMMENT '添加时间',
  Status                INT                  NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (ID)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '培训计划';


/*==============================================================*/
/* Table: lms_TrainingType                                      */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_TrainingType`;
CREATE TABLE lms_TrainingType
(
  ID      INT         NOT NULL
  COMMENT '类别ID',
  Name    VARCHAR(50) NOT NULL
  COMMENT '类别名称',
  AddTime DATETIME    NOT NULL
  COMMENT '添加时间',
  Status  INT         NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (ID)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '培训类别';


/*==============================================================*/
/* Table: lms_trainingcourse                                    */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_trainingcourse`;
CREATE TABLE lms_trainingcourse
(
  systemid   INT      NOT NULL
  COMMENT '系统ID',
  trainingid INT      NOT NULL
  COMMENT '培训班ID',
  scormid    INT      NOT NULL
  COMMENT '课程ID',
  isrequired INT      NOT NULL DEFAULT 1
  COMMENT '是否必修课程（1-是，0-否）',
  addtime    DATETIME NOT NULL
  COMMENT '添加时间',
  status     INT      NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (systemid, trainingid, scormid)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '培训课程';


/*==============================================================*/
/* Table: lms_course                                            */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_course`;
CREATE TABLE lms_course
(
  id                INT                  NOT NULL AUTO_INCREMENT
  COMMENT '课程ID',
  systemid          INT                  NOT NULL
  COMMENT '系统ID',
  coursecode        VARCHAR(30)          NOT NULL
  COMMENT '课程代码',
  coursename        NATIONAL VARCHAR(50) NOT NULL
  COMMENT '课程名称',
  typeid            INT                  NOT NULL
  COMMENT '课程类别',
  courseurl         VARCHAR(255)         NOT NULL
  COMMENT '课程地址',
  democourseurl     VARCHAR(255)         NOT NULL
  COMMENT '试听课程地址',
  coursehours       INT                  NOT NULL
  COMMENT '课程学时(单位分钟)',
  coursefee         DECIMAL(9, 1)        NOT NULL
  COMMENT '选课费',
  isscormcourse     INT                  NOT NULL DEFAULT 0
  COMMENT '1-是SCORM课程，0-不是SCORM课程',
  coursedescription TEXT                 NOT NULL
  COMMENT '课程介绍',
  isopenselection   INT                  NOT NULL DEFAULT 1
  COMMENT '是否开放选课（1-开放，0-不开放）',
  isrecommand       INT                  NOT NULL
  COMMENT '是否推荐：0，否；1，是',
  ishot             INT                  NOT NULL DEFAULT 0
  COMMENT '是否热门：0，否；1，是',
  addtime           DATETIME             NOT NULL
  COMMENT '添加时间',
  status            INT                  NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程';

/*==============================================================*/
/* Table: lms_coursetype                                        */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_coursetype`;
CREATE TABLE lms_coursetype
(
  id      INT         NOT NULL
  COMMENT '类别ID',
  name    VARCHAR(50) NOT NULL
  COMMENT '类别名称',
  addtime DATETIME    NOT NULL
  COMMENT '添加时间',
  status  INT         NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程类别';


/*==============================================================*/
/* Table: lms_coursesetting                                     */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_coursesetting`;
CREATE TABLE lms_coursesetting
(
  id          INT NOT NULL AUTO_INCREMENT
  COMMENT '课程ID',
  isbulletin  INT NOT NULL,
  isresource  INT NOT NULL,
  isqa        INT NOT NULL,
  isevaluator INT NOT NULL,
  istest      INT NOT NULL,
  ishomework  INT NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程设置';


/*==============================================================*/
/* Table: lms_coursebulletin                                    */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_coursebulletin`;
CREATE TABLE lms_coursebulletin
(
  `id`        INT          NOT NULL AUTO_INCREMENT
  COMMENT '公告ID',
  `courseid`  INT          NOT NULL
  COMMENT '课程ID',
  `title`     VARCHAR(200) NOT NULL
  COMMENT '公告标题',
  `content`   TEXT         NOT NULL
  COMMENT '公告内容',
  `type`      INT          NOT NULL
  COMMENT '公告类别',
  `endtime`   DATETIME     NOT NULL
  COMMENT '添加时间',
  `isdisplay` INT          NOT NULL DEFAULT 0
  COMMENT '显示状态：0，不显示；1，显示；',
  `addtime`   DATETIME     NOT NULL
  COMMENT '添加时间',
  `status`    INT          NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程公告';


/*==============================================================*/
/* Table: lms_courseresource                                    */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_courseresource`;
CREATE TABLE lms_courseresource
(
  id       INT          NOT NULL AUTO_INCREMENT
  COMMENT '资源ID',
  courseid INT          NOT NULL
  COMMENT '课程ID',
  title    VARCHAR(200) NOT NULL
  COMMENT '资源标题',
  content  TEXT         NOT NULL
  COMMENT '资源内容',
  type     INT          NOT NULL
  COMMENT '资源类别',
  isurl    INT          NOT NULL DEFAULT 0
  COMMENT '是否是URL：0，不是；1，是',
  addtime  DATETIME     NOT NULL
  COMMENT '添加时间',
  status   INT          NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程资源';


/*==============================================================*/
/* Table: lms_courseevaluator                                   */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_courseevaluator`;
CREATE TABLE lms_courseevaluator
(
  id             INT           NOT NULL AUTO_INCREMENT,
  courseid       INT           NOT NULL
  COMMENT '课程ID',
  score          DECIMAL(3, 1) NOT NULL,
  lastmodifytime DATETIME      NOT NULL,
  addtime        DATETIME      NOT NULL
  COMMENT '添加时间',
  status         INT           NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程评价';

/*==============================================================*/
/* Table: lms_topic                                             */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_topic`;
CREATE TABLE lms_topic
(
  id       INT           NOT NULL AUTO_INCREMENT
  COMMENT '主题ID',
  courseid INT           NOT NULL
  COMMENT '课程ID',
  title    VARCHAR(200)  NOT NULL
  COMMENT '标题',
  userid   CHAR(36)      NOT NULL
  COMMENT '用户ID',
  postip   VARBINARY(50) NOT NULL
  COMMENT '发帖IP',
  istop    INT           NOT NULL DEFAULT 0
  COMMENT '是否置顶：0，否；1，是；',
  ispop    INT           NOT NULL DEFAULT 0
  COMMENT '是否精华：0，否；1，是',
  addtime  DATETIME      NOT NULL
  COMMENT '添加时间',
  status   INT           NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程答疑';


/*==============================================================*/
/* Table: lms_reply                                             */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_reply`;
CREATE TABLE lms_reply
(
  id       INT           NOT NULL AUTO_INCREMENT
  COMMENT '回帖ID',
  topicid  INT           NOT NULL
  COMMENT '主题ID',
  courseid INT           NOT NULL
  COMMENT '课程ID',
  content  TEXT          NOT NULL
  COMMENT '内容',
  userid   CHAR(36)      NOT NULL
  COMMENT '用户ID',
  postip   VARBINARY(50) NOT NULL
  COMMENT '发帖IP',
  istopic  INT           NOT NULL DEFAULT 0
  COMMENT '是否是主贴：0，不是；1，是',
  addtime  DATETIME      NOT NULL
  COMMENT '添加时间',
  status   INT           NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程答疑回帖';

/*==============================================================*/
/* Table: lms_studentbulletinreadinfo                           */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_studentbulletinreadinfo`;
CREATE TABLE lms_studentbulletinreadinfo
(
  id        INT      NOT NULL AUTO_INCREMENT
  COMMENT '公告ID',
  studentid CHAR(36) NOT NULL
  COMMENT '学生ID',
  courseid  INT      NOT NULL
  COMMENT '课程ID',
  readflag  INT COMMENT '阅读标记：0，未读；1，已读；',
  addtime   DATETIME NOT NULL
  COMMENT '添加时间',
  status    INT      NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id, studentid, courseid)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '学生课程公告阅读信息表';

/*==============================================================*/
/* Table: lms_note                                              */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_note`;
CREATE TABLE lms_note
(
  id        INT          NOT NULL AUTO_INCREMENT,
  studentid CHAR(36)     NOT NULL
  COMMENT '学生ID',
  courseid  INT          NOT NULL
  COMMENT '课程ID',
  title     VARCHAR(200) NOT NULL,
  content   TEXT         NOT NULL,
  addtime   DATETIME     NOT NULL
  COMMENT '添加时间',
  status    INT          NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程笔记';

/*==============================================================*/
/* Table: lms_notefavorite                                      */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_notefavorite`;
CREATE TABLE lms_notefavorite
(
  id        INT      NOT NULL AUTO_INCREMENT,
  noteid    INT      NOT NULL,
  studentid CHAR(36) NOT NULL
  COMMENT '学生ID',
  addtime   DATETIME NOT NULL
  COMMENT '添加时间',
  status    INT      NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程笔记收藏';

/*==============================================================*/
/* Table: lms_studentcourseevaluate                             */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_studentcourseevaluate`;
CREATE TABLE lms_studentcourseevaluate
(
  id        INT           NOT NULL AUTO_INCREMENT,
  studentid CHAR(36)      NOT NULL
  COMMENT '学生ID',
  courseid  INT           NOT NULL
  COMMENT '课程ID',
  score     DECIMAL(3, 1) NOT NULL
  COMMENT '评价分值',
  comment   VARCHAR(500)  NOT NULL
  COMMENT '评价内容',
  addtime   DATETIME      NOT NULL
  COMMENT '添加时间',
  status    INT           NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '学生课程评价';


/*==============================================================*/
/* Table: e_studentbasicinfo                                    */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_studentbasicinfo`;
CREATE TABLE lms_studentbasicinfo
(
  id        INT                  NOT NULL AUTO_INCREMENT
  COMMENT '学生ID',
  uid       CHAR(36)             NOT NULL
  COMMENT '学生UUID',
  userid    CHAR(36)             NOT NULL
  COMMENT '用户ID',
  systemid  INT                  NOT NULL
  COMMENT '系统ID',
  name      NATIONAL VARCHAR(50) NOT NULL
  COMMENT '学生姓名',
  gender    NATIONAL VARCHAR(2)  NOT NULL
  COMMENT '性别',
  photo     VARCHAR(100)         NOT NULL
  COMMENT '照片',
  tel       VARCHAR(20)          NOT NULL
  COMMENT '手机',
  email     VARCHAR(50)          NOT NULL
  COMMENT 'Email',
  birthdate DATETIME COMMENT '生日',
  idtype    SMALLINT             NOT NULL
  COMMENT '证件类型：1，身份证；2，护照；3：其他；',
  idcode    VARCHAR(30)          NOT NULL
  COMMENT '证件号码',
  addtime   DATETIME             NOT NULL
  COMMENT '添加时间',
  status    INT                  NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '学员基本信息';

/*==============================================================*/
/* Table: lms_teacher                                           */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_teacher`;
CREATE TABLE lms_teacher
(
  id           INT          NOT NULL AUTO_INCREMENT
  COMMENT '教师ID',
  uid          CHAR(36)     NOT NULL
  COMMENT '教师UUID',
  userid       CHAR(36)     NOT NULL
  COMMENT '用户ID',
  name         VARCHAR(50)  NOT NULL
  COMMENT '教师姓名',
  position     VARCHAR(50)  NOT NULL
  COMMENT '教师职位',
  organization VARCHAR(50)  NOT NULL
  COMMENT '教师所属机构',
  description  TEXT         NOT NULL
  COMMENT '教师简介',
  phone        VARCHAR(50)  NOT NULL
  COMMENT '电话',
  email        VARCHAR(50)  NOT NULL
  COMMENT 'Email',
  isrecommand  INT          NOT NULL
  COMMENT '是否推荐：0，否；1，是',
  avator       VARCHAR(200) NOT NULL
  COMMENT '头像',
  addtime      DATETIME     NOT NULL
  COMMENT '添加时间',
  status       INT          NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '教师信息';

/*==============================================================*/
/* Table: lms_teachercourse                                     */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_teachercourse`;
CREATE TABLE lms_teachercourse
(
  userid  CHAR(36) NOT NULL
  COMMENT '用户ID',
  scormid INT      NOT NULL
  COMMENT '课程ID',
  addtime DATETIME NOT NULL
  COMMENT '添加时间',
  status  INT      NOT NULL DEFAULT 0
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (userid, scormid)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '教师课程关系';








