-- ----------------------------
-- Table structure for lms_system
-- ----------------------------
DROP TABLE IF EXISTS `lms_system`;
CREATE TABLE `lms_system` (
  id         INT                  NOT NULL AUTO_INCREMENT
  COMMENT '系统ID',
  systemname NATIONAL VARCHAR(50) NOT NULL
  COMMENT '系统名称',
  memo       TEXT COMMENT '备注',
  addtime    DATETIME             NOT NULL
  COMMENT '添加时间',
  status     INT                  NOT NULL DEFAULT 1
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 20
  DEFAULT CHARSET = utf8
  COMMENT = '系统信息';

INSERT INTO `lms_system` (`id`, `systemname`, `memo`, `addtime`, `status`)
VALUES ('1', '11', '', '2017-1-1 00:00:00' ,1);

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
VALUES ('1', '管理员', '1', '');

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
VALUES ('200', '2', 'Admin/System/index', '系统管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)

VALUES ('3', '1', 'Training', '培训计划管理', '1', '1', '', 'fa fa-group', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('300', '3', 'Admin/Training/index', '培训计划管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('301', '3', 'Admin/Training/add', '添加培训计划', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('302', '3', 'Admin/Training/edit', '修改培训计划', '1', '1', '', '', '0');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('4', '1', 'Course', '课程管理', '1', '1', '', 'fa fa-book', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('400', '4', 'Admin/Course/index', '课程管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('401', '4', 'Admin/Course/add', '添加课程', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('402', '4', 'Admin/Course/edit', '修改课程', '1', '1', '', '', '0');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('410', '4', 'Admin/Bulletin/index', '论坛管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('420', '4', 'Admin/Resource/index', '资源管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('430', '4', 'Admin/QA/index', '问答管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('440', '4', 'Admin/Evaluator/index', '投票管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('450', '4', 'Admin/Exam/index', '考试管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('460', '4', 'Admin/Homework/index', '作业管理', '1', '1', '', '', '1');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('5', '1', 'Student', '学员管理', '1', '1', '', 'fa fa-slideshare', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('500', '5', 'Admin/Student/index', '学员信息管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('501', '5', 'Admin/Student/regmanager', '注册学员管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('502', '5', 'Admin/Student/import', '导入学员账号', '1', '1', '', '', '1');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('6', '1', 'Finance', '财务管理', '1', '1', '', 'fa fa-money', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('601', '6', 'Admin/Finance/index', '交费查询', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('602', '6', 'Admin/Finance/offlineconfirm', '离线交费确认', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('603', '6', 'Admin/Finance/stat', '财务统计', '1', '1', '', '', '1');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('7', '1', 'ActivationCode', '激活码管理', '1', '1', '', 'fa fa-barcode', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('700', '7', 'Admin/ActivationCode/add', '新增激活码', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('701', '7', 'Admin/ActivationCode/index', '查询激活码', '1', '1', '', '', '1');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('8', '1', 'Progress', '学习情况', '1', '1', '', 'fa fa-line-chart', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('800', '8', 'Admin/Progress/index', '学习情况查询', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('801', '8', 'Admin/Progress/stat', '学习情况统计', '1', '1', '', '', '1');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('9', '1', 'User', '用户权限管理', '1', '1', '', 'fa fa-user-md', '1');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('900', '9', 'Admin/User/index', '后台用户管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('902', '9', 'Admin/User/add', '添加用户', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('903', '9', 'Admin/User/edit', '修改用户', '1', '1', '', '', '0');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('910', '9', 'Admin/Rule/index', '权限管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('911', '9', 'Admin/Rule/add', '添加权限', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('912', '9', 'Admin/Rule/edit', '修改权限', '1', '1', '', '', '0');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('920', '9', 'Admin/Rule/group', '角色管理', '1', '1', '', '', '1');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('922', '9', 'Admin/Rule/addgroup', '添加角色', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('923', '9', 'Admin/Rule/editgroup', '修改角色', '1', '1', '', '', '0');
INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('924', '9', 'Admin/Rule/grouprule', '角色权限', '1', '1', '', '', '0');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('10', '1', 'log', '日志管理', '1', '1', '', 'fa fa-edit', '1');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('1010', '10', 'Admin/Log/adminloginlog', '管理端登录日志', '1', '1', '', '', '1');

INSERT INTO `lms_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `icon`, `isshow`)
VALUES ('1020', '10', 'Admin/Log/adminoperatelog', '管理端操作日志', '1', '1', '', '', '1');

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
-- INSERT INTO `lms_auth_group_access` (`uid` ,`group_id`) VALUES ('1', '1');

-- ----------------------------
-- Table structure for lms_user
-- ----------------------------
DROP TABLE IF EXISTS `lms_user`;
CREATE TABLE `lms_user` (
  `id`             INT(11) UNSIGNED     NOT NULL AUTO_INCREMENT,
  uid              CHAR(36)             NOT NULL
  COMMENT '用户UUID',
  loginname        NATIONAL VARCHAR(50) NOT NULL
  COMMENT '用户名',
  pwd              VARCHAR(50)          NOT NULL
  COMMENT '密码',
  realname         NATIONAL VARCHAR(20) NOT NULL
  COMMENT '真实姓名',
  systemid         INT                  NOT NULL DEFAULT 0
  COMMENT '系统ID',
  usertype         INT                  NOT NULL
  COMMENT '用户类型：0超管，1管理员，2教师，3学生',
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
  status           INT                  NOT NULL DEFAULT 1
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
                                           '2017-04-01 00:00:00', '0', '1.png', '2017-04-01 00:00:00', '1');


/*==============================================================*/
/* Table: lms_training                                          */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_training`;
CREATE TABLE lms_training
(
  id                    INT                  NOT NULL AUTO_INCREMENT
  COMMENT '培训班ID',
  systemid              INT                  NOT NULL
  COMMENT '系统ID',
  trainingname          NATIONAL VARCHAR(50) NOT NULL
  COMMENT '培训班名称',
  trainingcode          VARCHAR(50)          NOT NULL
  COMMENT '培训计划编号',
  traingtype            INT                  NOT NULL
  COMMENT '培训类别',
  registrationstarttime DATETIME             NOT NULL
  COMMENT '报名开始时间',
  registrationendtime   DATETIME             NOT NULL
  COMMENT '报名结束时间',
  starttime             DATETIME             NOT NULL
  COMMENT '培训开始时间',
  endtime               DATETIME             NOT NULL
  COMMENT '培训结束时间',
  isopen                INT                  NOT NULL DEFAULT 0
  COMMENT '是否开放（1-开放，0-未开放）',
  trainingcost          DECIMAL(9, 1)        NOT NULL
  COMMENT '培训费',
  allownumberofcourses  INT                  NOT NULL DEFAULT 0
  COMMENT '允许选课数（0-选择全部）',
  description           TEXT                 NOT NULL
  COMMENT '培训介绍',
  content               TEXT                 NOT NULL
  COMMENT '培训内容',
  memeber               TEXT                 NOT NULL
  COMMENT '培训对象',
  notice                TEXT                 NOT NULL
  COMMENT '培训须知',
  isspublishresult      INT                  NOT NULL DEFAULT 0
  COMMENT '是否发布成绩',
  minpassresult         DECIMAL(4, 1)        NOT NULL DEFAULT 60
  COMMENT '最小通过成绩',
  periodnumbercode      VARCHAR(20)          NOT NULL,
  addtime               DATETIME             NOT NULL
  COMMENT '添加时间',
  updatetime            DATETIME             NOT NULL
  COMMENT '修改时间',
  status                INT                  NOT NULL DEFAULT 1
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '培训计划';


/*==============================================================*/
/* Table: lms_TrainingType                                      */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_trainingtype`;
CREATE TABLE lms_trainingtype
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
  status     INT      NOT NULL DEFAULT 1
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
  updatetime        DATETIME             NOT NULL
  COMMENT '修改时间',
  status            INT                  NOT NULL DEFAULT 1
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
  status  INT         NOT NULL DEFAULT 1
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
  isbulletin  INT NOT NULL
  COMMENT '启用论坛',
  isresource  INT NOT NULL
  COMMENT '启用资源',
  isqa        INT NOT NULL
  COMMENT '启用问答',
  isevaluator INT NOT NULL
  COMMENT '启用评估',
  istest      INT NOT NULL
  COMMENT '启用测试',
  ishomework  INT NOT NULL
  COMMENT '启用作业',
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
  `status`    INT          NOT NULL DEFAULT 1
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
  status   INT          NOT NULL DEFAULT 1
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
  status         INT           NOT NULL DEFAULT 1
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
  COMMENT '用户UUID',
  postip   VARBINARY(50) NOT NULL
  COMMENT '发帖IP',
  istop    INT           NOT NULL DEFAULT 0
  COMMENT '是否置顶：0，否；1，是；',
  ispop    INT           NOT NULL DEFAULT 0
  COMMENT '是否精华：0，否；1，是',
  addtime  DATETIME      NOT NULL
  COMMENT '添加时间',
  status   INT           NOT NULL DEFAULT 1
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
  COMMENT '用户UUID',
  postip   VARBINARY(50) NOT NULL
  COMMENT '发帖IP',
  istopic  INT           NOT NULL DEFAULT 0
  COMMENT '是否是主贴：0，不是；1，是',
  addtime  DATETIME      NOT NULL
  COMMENT '添加时间',
  status   INT           NOT NULL DEFAULT 1
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
  COMMENT '学生UUID',
  courseid  INT      NOT NULL
  COMMENT '课程ID',
  readflag  INT COMMENT '阅读标记：0，未读；1，已读；',
  addtime   DATETIME NOT NULL
  COMMENT '添加时间',
  status    INT      NOT NULL DEFAULT 1
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
  COMMENT '学生UUID',
  courseid  INT          NOT NULL
  COMMENT '课程ID',
  title     VARCHAR(200) NOT NULL
  COMMENT '标题',
  content   TEXT         NOT NULL
  COMMENT '内容',
  addtime   DATETIME     NOT NULL
  COMMENT '添加时间',
  status    INT          NOT NULL DEFAULT 1
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
  COMMENT '学生UUID',
  addtime   DATETIME NOT NULL
  COMMENT '添加时间',
  status    INT      NOT NULL DEFAULT 1
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
  COMMENT '学生UUID',
  courseid  INT           NOT NULL
  COMMENT '课程ID',
  score     DECIMAL(3, 1) NOT NULL
  COMMENT '评价分值',
  comment   VARCHAR(500)  NOT NULL
  COMMENT '评价内容',
  addtime   DATETIME      NOT NULL
  COMMENT '添加时间',
  status    INT           NOT NULL DEFAULT 1
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
  studentid CHAR(36)             NOT NULL
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
  idtype    SMALLINT             NOT NULL
  COMMENT '证件类型：1，身份证；2，护照；3：其他；',
  idcode    VARCHAR(30)          NOT NULL
  COMMENT '证件号码',
  addtime   DATETIME             NOT NULL
  COMMENT '添加时间',
  status    INT                  NOT NULL DEFAULT 1
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '学员基本信息';

/*==============================================================*/
/* Table: lms_studentextinfo                                    */
/*==============================================================*/
DROP TABLE IF EXISTS lms_studentextinfo;
CREATE TABLE lms_studentextinfo
(
  id           CHAR(36)              NOT NULL
  COMMENT '学生UUID',
  degree       NATIONAL VARCHAR(20)  NOT NULL
  COMMENT '学历',
  company      NATIONAL VARCHAR(100) NOT NULL
  COMMENT '工作单位',
  address      NATIONAL VARCHAR(100) NOT NULL
  COMMENT '家庭地址',
  postcode     VARCHAR(10)           NOT NULL
  COMMENT '邮政编码',
  provincecode VARCHAR(10)           NOT NULL
  COMMENT '省份',
  citycode     VARCHAR(10)           NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '学员扩展信息';


/*==============================================================*/
/* Table: lms_teacher                                           */
/*==============================================================*/
DROP TABLE IF EXISTS `lms_teacher`;
CREATE TABLE lms_teacher
(
  id           INT          NOT NULL AUTO_INCREMENT
  COMMENT '教师ID',
  teacherid    CHAR(36)     NOT NULL
  COMMENT '教师UUID',
  userid       CHAR(36)     NOT NULL
  COMMENT '用户UUID',
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
  status       INT          NOT NULL DEFAULT 1
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
  teacherid CHAR(36) NOT NULL
  COMMENT '教师UUID',
  courseid  INT      NOT NULL
  COMMENT '课程ID',
  addtime   DATETIME NOT NULL
  COMMENT '添加时间',
  status    INT      NOT NULL DEFAULT 1
  COMMENT '状态：0，禁用；1，正常；-1，删除',
  PRIMARY KEY (teacherid, courseid)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '教师课程关系';


/*==============================================================*/
/* Table: lms_studenttraining                                     */
/*==============================================================*/
DROP TABLE IF EXISTS lms_studenttraining;
CREATE TABLE lms_studenttraining
(
  trainingid       INT           NOT NULL
  COMMENT '培训班ID',
  systemid         INT           NOT NULL
  COMMENT '系统ID',
  studentid        CHAR(36)      NOT NULL
  COMMENT '学生UUID',
  signintime       DATETIME      NOT NULL
  COMMENT '报名时间',
  totalscore       DECIMAL(4, 1) NOT NULL DEFAULT -1
  COMMENT '总成绩',
  ispayment        INT           NOT NULL DEFAULT 0
  COMMENT '是否交费：0，未交费；1，已交费',
  isallowlearning  TINYINT       NOT NULL DEFAULT 0
  COMMENT '是否允许学习：0，不允许；1，允许',
  isclosed         TINYINT       NOT NULL DEFAULT 0
  COMMENT '是否已经学完（只要参加了终结性考试就算学完）：0，还在学；1，已经学完，',
  isgetcertificate TINYINT       NOT NULL DEFAULT 0
  COMMENT '是否领取证书：0，未领取，1，领取',
  lastlogintime    DATETIME      NOT NULL
  COMMENT '上次登录时间',
  loginnum         INT           NOT NULL DEFAULT 0
  COMMENT '登录次数',
  totalstudytime   INT           NOT NULL DEFAULT 0
  COMMENT '学习总时长，单位为分钟',
  certificatecode  VARCHAR(30)   NOT NULL
  COMMENT '证书编号',
  PRIMARY KEY (trainingid, systemid, studentid)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '学生培训计划';


/*==============================================================*/
/* Table: lms_studentcourse                                     */
/*==============================================================*/
DROP TABLE IF EXISTS lms_studentcourse;
CREATE TABLE lms_studentcourse
(
  trainingid      INT           NOT NULL
  COMMENT '培训班ID',
  systemid        INT           NOT NULL
  COMMENT '系统ID',
  studentid       CHAR(36)      NOT NULL
  COMMENT '学生UUID',
  courseid        INT           NOT NULL
  COMMENT '课程ID',
  selecttime      DATETIME      NOT NULL
  COMMENT '选课时间',
  type            SMALLINT      NOT NULL
  COMMENT '选课类型：0，自由选单门课；1，自由选课程包；2，培训班选课',
  ispayment       TINYINT       NOT NULL DEFAULT 0
  COMMENT '是否交费：0，未交费；1，已交费',
  isallowlearning TINYINT       NOT NULL DEFAULT 0
  COMMENT '是否允许学：0，不允许；1，允许',
  score           DECIMAL(4, 1) NOT NULL DEFAULT -1
  COMMENT '成绩',
  lastlogintime   DATETIME      NOT NULL
  COMMENT '上次登录时间',
  loginnum        INT           NOT NULL DEFAULT 0
  COMMENT '登录次数',
  totalstudytime  INT           NOT NULL DEFAULT 0
  COMMENT '学习总时长，单位为分钟',
  PRIMARY KEY (trainingid, systemid, studentid, courseid)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '学生选课';


/*==============================================================*/
/* Table: lms_scoinfo                                           */
/*==============================================================*/
DROP TABLE IF EXISTS lms_scoinfo;
CREATE TABLE lms_scoinfo
(
  scoid               INT                   NOT NULL AUTO_INCREMENT,
  systemid            INT                   NOT NULL DEFAULT 1
  COMMENT '系统ID',
  courseid            INT                   NOT NULL
  COMMENT '课程ID',
  chaptertitle        NATIONAL VARCHAR(200) NOT NULL
  COMMENT '章节标题',
  scotype             VARCHAR(5)            NOT NULL DEFAULT 'sco'
  COMMENT 'SCO类型',
  launchurl           VARCHAR(255)          NOT NULL
  COMMENT '加载URL',
  manifest            VARCHAR(255) COMMENT '清单文件',
  organization        VARCHAR(255) COMMENT '组织',
  scoparentidentifier VARCHAR(255)          NOT NULL
  COMMENT 'SCO父标识符',
  scoidentifier       VARCHAR(255)          NOT NULL
  COMMENT 'SCO标识符',
  parameters          VARCHAR(255) COMMENT '参数',
  prerequisites       VARCHAR(200) COMMENT '先决条件',
  maxtimeallowed      DATETIME COMMENT '最大允许时间',
  timelimitaction     DATETIME COMMENT '时间结束行为',
  datafromlms         VARCHAR(255) COMMENT 'LMS数据',
  masteryscore        VARCHAR(200) COMMENT '通过得分',
  next                SMALLINT                       DEFAULT 0
  COMMENT '下一个',
  previous            SMALLINT                       DEFAULT 0
  COMMENT '上一个',
  PRIMARY KEY (scoid)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '课程SCO信息';


/*==============================================================*/
/* Table: lms_operatelog                               */
/*==============================================================*/
DROP TABLE IF EXISTS lms_operatelog;
CREATE TABLE lms_operatelog
(
  id                 INT                    NOT NULL AUTO_INCREMENT,
  userid             VARCHAR(36)            NOT NULL
  COMMENT '操作用户uuid',
  usertype           INT                    NOT NULL
  COMMENT '用户类型：0，admin；1，student',
  operatorip         VARCHAR(50)            NOT NULL
  COMMENT '操作IP',
  operatordate       DATETIME               NOT NULL
  COMMENT '操作日期',
  operateurl         NATIONAL VARCHAR(500)  NOT NULL
  COMMENT '操作url',
  operatememo        NATIONAL VARCHAR(5000) NOT NULL
  COMMENT '操作内容',
  operatedescription NATIONAL VARCHAR(500)  NOT NULL
  COMMENT '操作描述',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '操作日志';


/*==============================================================*/
/* Table: lms_loginlog                                          */
/*==============================================================*/
DROP TABLE IF EXISTS lms_loginlog;
CREATE TABLE lms_loginlog
(
  id            INT                   NOT NULL AUTO_INCREMENT,
  usertype      INT                   NOT NULL
  COMMENT '用户类型',
  loginname     NATIONAL VARCHAR(50)  NOT NULL
  COMMENT '用户名',
  pwd           VARCHAR(50)           NOT NULL
  COMMENT '密码',
  operatorip    VARCHAR(50)           NOT NULL
  COMMENT '操作IP',
  operatordate  DATETIME              NOT NULL
  COMMENT '操作日期',
  operateresult NATIONAL VARCHAR(500) NOT NULL
  COMMENT '操作结果',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '登录日志';

/*==============================================================*/
/* Table: lms_systemmessage                              */
/*==============================================================*/
DROP TABLE IF EXISTS lms_systemmessage;
CREATE TABLE lms_systemmessage
(
  id       INT                   NOT NULL AUTO_INCREMENT,
  userid   VARCHAR(36)           NOT NULL
  COMMENT '用户uuid',
  readflag INT                   NOT NULL DEFAULT 0
  COMMENT '是否阅读：0，未阅读；1，已阅读',
  addtime  DATETIME              NOT NULL
  COMMENT '添加日期',
  title    NATIONAL VARCHAR(100) NOT NULL
  COMMENT '消息标题',
  content  NATIONAL VARCHAR(500) NOT NULL
  COMMENT '消息',
  url      NATIONAL VARCHAR(500) NOT NULL
  COMMENT '消息url',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '系统消息';




/*==============================================================*/
/* Table: lms_activatecode                                      */
/*==============================================================*/
DROP TABLE IF EXISTS lms_activatecode;
CREATE TABLE lms_activatecode
(
  activatecode VARCHAR(50) NOT NULL
  COMMENT '激活码',
  activatedate DATETIME COMMENT '激活日期',
  adddate      DATETIME    NOT NULL
  COMMENT '添加日期',
  batchcode    VARCHAR(20) NOT NULL
  COMMENT '批次代码',
  systemid     INT         NOT NULL
  COMMENT '系统ID',
  studentid    VARCHAR(36) NOT NULL
  COMMENT '学生UUID',
  objectid     INT         NOT NULL
  COMMENT '对象id',
  objecttype   INT         NOT NULL
  COMMENT '对象类型',
  PRIMARY KEY (activatecode)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '激活码';


/*==============================================================*/
/* Table: lms_activatecodehistory                               */
/*==============================================================*/
DROP TABLE IF EXISTS lms_activatecodehistory;
CREATE TABLE lms_activatecodehistory
(
  id           INT         NOT NULL AUTO_INCREMENT
  COMMENT 'id',
  activatecode VARCHAR(50) NOT NULL
  COMMENT '激活码',
  activatedate DATETIME COMMENT '激活日期',
  adddate      DATETIME    NOT NULL
  COMMENT '添加日期',
  batchcode    VARCHAR(20) NOT NULL
  COMMENT '批次代码',
  systemid     INT         NOT NULL
  COMMENT '系统ID',
  studentid    VARCHAR(36) NOT NULL
  COMMENT '学生UUID',
  objectid     INT         NOT NULL
  COMMENT '对象id',
  objecttype   INT         NOT NULL
  COMMENT '对象类型',
  backupdate   DATETIME    NOT NULL
  COMMENT '备份时间',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '激活码历史';

/*==============================================================*/
/* Table: lms_activatecodelog                                   */
/*==============================================================*/

DROP TABLE IF EXISTS lms_activatecodelog;
CREATE TABLE lms_activatecodelog
(
  id           INT           NOT NULL AUTO_INCREMENT
  COMMENT 'id',
  generatenum  INT           NOT NULL
  COMMENT '生成数量',
  adddate      DATETIME      NOT NULL
  COMMENT '添加日期',
  batchcode    VARCHAR(20)   NOT NULL
  COMMENT '批次代码',
  systemid     INT           NOT NULL
  COMMENT '系统ID',
  objectid     INT           NOT NULL
  COMMENT '对象id',
  objecttype   INT           NOT NULL
  COMMENT '对象类型',
  paymentmoney DECIMAL(9, 1) NOT NULL
  COMMENT '交费金额',
  userid       VARCHAR(36)   NOT NULL
  COMMENT '操作用户',
  operatorip   VARCHAR(50)   NOT NULL
  COMMENT '操作IP',
  paymentid    INT           NOT NULL
  COMMENT '缴费单据ID',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '激活码生成日志';


/*==============================================================*/
/* Table: lms_removelactivatecode                               */
/*==============================================================*/
DROP TABLE IF EXISTS lms_removelactivatecode;
CREATE TABLE lms_removelactivatecode
(
  id           INT                   NOT NULL AUTO_INCREMENT,
  studentid    INT                   NOT NULL
  COMMENT '学生ID',
  activatecode VARCHAR(50)           NOT NULL
  COMMENT '激活码',
  userid       VARCHAR(36)           NOT NULL
  COMMENT '操作用户uuid',
  operatorip   VARCHAR(50) COMMENT '操作IP',
  operatordate DATETIME              NOT NULL
  COMMENT '操作日期',
  systemid     INT                   NOT NULL
  COMMENT '系统ID',
  objectid     INT                   NOT NULL
  COMMENT '对象id',
  objecttype   INT                   NOT NULL
  COMMENT '对象类型',
  removereason NATIONAL VARCHAR(200) NOT NULL
  COMMENT '撤销原因',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '取消激活码日志';

/*==============================================================*/
/* Table: lms_onlinepayinfo                                     */
/*==============================================================*/
DROP TABLE IF EXISTS lms_onlinepayinfo;
CREATE TABLE lms_onlinepayinfo
(
  orderno     VARCHAR(20)            NOT NULL
  COMMENT '订单号码',
  orderamount NUMERIC(9, 2)          NOT NULL
  COMMENT '订单金额',
  userid      INT                    NOT NULL
  COMMENT '用户ID',
  addtime     DATETIME               NOT NULL
  COMMENT '添加日期',
  txntime     VARCHAR(14)            NOT NULL
  COMMENT '订单发送时间',
  settledate  VARCHAR(4)             NOT NULL
  COMMENT '清算日期',
  respcode    VARCHAR(2)             NOT NULL
  COMMENT '响应码',
  orderstatus INT                    NOT NULL DEFAULT 0
  COMMENT '支付状态(0，未支付；1，支付成功；2，支付失败)',
  status      INT                    NOT NULL DEFAULT 0
  COMMENT '系统状态(0：未交费；1，已交费；2，单据撤销)',
  signature   VARCHAR(2000)          NOT NULL
  COMMENT '签名',
  memo        NATIONAL VARCHAR(2000) NOT NULL
  COMMENT '备注',
  feetype     INT                    NOT NULL DEFAULT 1
  COMMENT '交费类型（1-培训费，2-选课费）',
  ischeck     INT                    NOT NULL DEFAULT 0
  COMMENT '是否对账',
  payobjectid INT                    NOT NULL
  COMMENT '交费对象ID（培训班ID或课程ID）',
  systemid    INT                    NOT NULL
  COMMENT '系统ID',
  queryid     VARCHAR(30)            NOT NULL
  COMMENT '交易查询流水号',
  PRIMARY KEY (orderno)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '在线支付订单';

/*==============================================================*/
/* Table: lms_onlinepaylog                                      */
/*==============================================================*/
DROP TABLE IF EXISTS lms_onlinepaylog;
CREATE TABLE lms_onlinepaylog
(
  id          INT         NOT NULL AUTO_INCREMENT,
  orderno     VARCHAR(20) NOT NULL
  COMMENT '订单号',
  userid      INT         NOT NULL
  COMMENT '用户ID',
  addtime     DATETIME    NOT NULL
  COMMENT '添加时间',
  orderamount NUMERIC(9, 2) COMMENT '订单金额',
  indbtype    INT         NOT NULL
  COMMENT '入库类型',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '在线支付日志';

/*==============================================================*/
/* Table: lms_payresultinfo                                     */
/*==============================================================*/
DROP TABLE IF EXISTS lms_payresultinfo;
CREATE TABLE lms_payresultinfo
(
  code        VARCHAR(2)            NOT NULL
  COMMENT '返回值',
  information NATIONAL VARCHAR(200) NOT NULL
  COMMENT '说明',
  PRIMARY KEY (code)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '在线支付返回值说明';

/*==============================================================*/
/* Table: lms_payment                                             */
/*==============================================================*/
DROP TABLE IF EXISTS lms_payment;
CREATE TABLE lms_payment
(
  id            INT           NOT NULL AUTO_INCREMENT,
  userid        VARCHAR(36)   NOT NULL
  COMMENT '用户ID（如果非用户交费或批量交费则为空）',
  payobjectid   INT           NOT NULL
  COMMENT '交费对象ID（培训班ID或课程ID，非用户交费则为0）',
  payobjecttype INT           NOT NULL
  COMMENT '',
  paymoney      DECIMAL(9, 1) NOT NULL
  COMMENT '交费金额',
  account       INT           NOT NULL
  COMMENT '交费个数',
  paytype       SMALLINT      NOT NULL
  COMMENT '交费类型（1-用户在线交费、2-用户离线交费、3-批量生成用户交费）',
  paydate       DATETIME      NOT NULL
  COMMENT '交费时间',
  systemid      INT           NOT NULL
  COMMENT '系统ID',
  orderno       VARCHAR(20)   NOT NULL
  COMMENT '订单号',
  memo          VARCHAR(200)  NOT NULL
  COMMENT '备注',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '财务信息';


/*==============================================================*/
/* Table: lms_paymentlog                                        */
/*==============================================================*/
DROP TABLE IF EXISTS lms_paymentlog;
CREATE TABLE lms_paymentlog
(
  id                INT           NOT NULL AUTO_INCREMENT,
  paymentid         INT           NOT NULL
  COMMENT '财务ID',
  userid            VARCHAR(36)   NOT NULL
  COMMENT '用户ID（如果非用户交费或批量交费则为空）',
  paymentobjectid   INT           NOT NULL
  COMMENT '交费对象ID（培训班ID或课程ID，非用户交费则为0）',
  paymentobjecttype INT           NOT NULL
  COMMENT '交费对象类型（0-非用户交费，1-选培训班交费，2-选课交费）',
  paymoney          DECIMAL(8, 1) NOT NULL
  COMMENT '交费金额',
  paytype           SMALLINT      NOT NULL
  COMMENT '交费类型（1-用户在线交费、2-用户离线交费、3-生成用户交费、4-售出课程费）',
  paytdate          DATETIME      NOT NULL
  COMMENT '交费时间',
  operatoruserid    VARCHAR(36)   NOT NULL
  COMMENT '操作人用户ID',
  operatorip        VARCHAR(50)   NOT NULL
  COMMENT '操作人IP',
  systemid          INT           NOT NULL
  COMMENT '系统ID',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '财务日志';


/*==============================================================*/
/* Table: lms_cancelpaymentlog                                  */
/*==============================================================*/
DROP TABLE IF EXISTS lms_cancelpaymentlog;
CREATE TABLE lms_cancelpaymentlog
(
  id                INT            NOT NULL AUTO_INCREMENT,
  paymentid         INT            NOT NULL
  COMMENT '财务ID',
  userid            VARCHAR(36)    NOT NULL
  COMMENT '用户ID（如果非用户交费或批量交费则为空）',
  paymentobjectid   INT            NOT NULL
  COMMENT '交费对象ID（培训班ID或课程ID，非用户交费则为0）',
  paymentobjecttype INT            NOT NULL
  COMMENT '交费对象类型（0-非用户交费，1-选培训班交费，2-选课交费）',
  paymentmoney      DECIMAL(8, 1)  NOT NULL
  COMMENT '交费金额',
  paymenttype       SMALLINT       NOT NULL
  COMMENT '交费类型（1-用户在线交费、2-用户离线交费、3-生成用户交费、4-售出课程费）',
  paymentdate       DATETIME       NOT NULL
  COMMENT '交费时间',
  operatoruserid    VARCHAR(36)    NOT NULL
  COMMENT '操作人用户ID',
  operatorip        VARCHAR(50)    NOT NULL
  COMMENT '操作人IP',
  systemid          INT            NOT NULL
  COMMENT '系统ID',
  canceldate        DATETIME       NOT NULL
  COMMENT '撤销日期',
  cancelreason      VARBINARY(200) NOT NULL
  COMMENT '撤销原因',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COMMENT = '撤销财务信息日志';










