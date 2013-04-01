DROP TABLE IF EXISTS "acl_user_role";
DROP TABLE IF EXISTS "acl_role_task";
DROP TABLE IF EXISTS "acl_task_op";
DROP TABLE IF EXISTS "acl_role";
DROP TABLE IF EXISTS "acl_task";
DROP TABLE IF EXISTS "acl_op";

-- ----------------------------
--  Sequence structure for "acl_op_id_seq"
-- ----------------------------
DROP SEQUENCE IF EXISTS "acl_op_id_seq";
CREATE SEQUENCE "acl_op_id_seq" INCREMENT 1 START 11 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_op_id_seq" OWNER TO "dev";

-- ----------------------------
--  Sequence structure for "acl_role_id_seq"
-- ----------------------------
DROP SEQUENCE IF EXISTS "acl_role_id_seq";
CREATE SEQUENCE "acl_role_id_seq" INCREMENT 1 START 3 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_role_id_seq" OWNER TO "dev";

-- ----------------------------
--  Sequence structure for "acl_role_task_id_seq"
-- ----------------------------
DROP SEQUENCE IF EXISTS "acl_role_task_id_seq";
CREATE SEQUENCE "acl_role_task_id_seq" INCREMENT 1 START 1 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_role_task_id_seq" OWNER TO "dev";

-- ----------------------------
--  Sequence structure for "acl_task_id_seq"
-- ----------------------------
DROP SEQUENCE IF EXISTS "acl_task_id_seq";
CREATE SEQUENCE "acl_task_id_seq" INCREMENT 1 START 5 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_task_id_seq" OWNER TO "dev";

-- ----------------------------
--  Sequence structure for "acl_task_op_id_seq"
-- ----------------------------
DROP SEQUENCE IF EXISTS "acl_task_op_id_seq";
CREATE SEQUENCE "acl_task_op_id_seq" INCREMENT 1 START 1 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_task_op_id_seq" OWNER TO "dev";

-- ----------------------------
--  Sequence structure for "acl_user_role_id_seq"
-- ----------------------------
DROP SEQUENCE IF EXISTS "acl_user_role_id_seq";
CREATE SEQUENCE "acl_user_role_id_seq" INCREMENT 1 START 1 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_user_role_id_seq" OWNER TO "dev";

-- ----------------------------
--  Table structure for "acl_role"
-- ----------------------------
CREATE TABLE "acl_role" (
	"id" int4 NOT NULL DEFAULT nextval('acl_role_id_seq'::regclass)
	, "name" varchar(64) NOT NULL
	, "description" varchar(255) DEFAULT NULL::character varying
	, CONSTRAINT "acl_role_pkey" PRIMARY KEY ("id") NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_role" OWNER TO "dev";

-- ----------------------------
--  Records of "acl_role"
-- ----------------------------
BEGIN;
INSERT INTO "acl_role" VALUES ('1', 'guest', 'Guest Role');
INSERT INTO "acl_role" VALUES ('2', 'member', 'Member Role');
INSERT INTO "acl_role" VALUES ('3', 'admin', 'Administrator Role');
COMMIT;

-- ----------------------------
--  Table structure for "acl_task"
-- ----------------------------
CREATE TABLE "acl_task" (
	"id" int4 NOT NULL DEFAULT nextval('acl_task_id_seq'::regclass)
	, "name" varchar(64) NOT NULL
	, "description" varchar(255) DEFAULT NULL::character varying
	, CONSTRAINT "acl_task_pkey" PRIMARY KEY ("id") NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_task" OWNER TO "dev";

-- ----------------------------
--  Records of "acl_task"
-- ----------------------------
BEGIN;
INSERT INTO "acl_task" VALUES ('2', 'main@index', 'Index all access');
INSERT INTO "acl_task" VALUES ('1', 'main@about', 'About all access');
INSERT INTO "acl_task" VALUES ('3', 'main@account', null);
INSERT INTO "acl_task" VALUES ('4', 'main@auth', null);
INSERT INTO "acl_task" VALUES ('5', 'main@dashboard', null);
COMMIT;

-- ----------------------------
--  Table structure for "acl_op"
-- ----------------------------
CREATE TABLE "acl_op" (
	"id" int4 NOT NULL DEFAULT nextval('acl_op_id_seq'::regclass)
	, "name" varchar(64) NOT NULL
	, "description" varchar(255) DEFAULT NULL::character varying
	, CONSTRAINT "acl_op_pkey" PRIMARY KEY ("id") NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_op" OWNER TO "dev";

-- ----------------------------
--  Records of "acl_op"
-- ----------------------------
BEGIN;
INSERT INTO "acl_op" VALUES ('1', 'main.index.index', null);
INSERT INTO "acl_op" VALUES ('2', 'main.about.index', null);
INSERT INTO "acl_op" VALUES ('3', 'main.about.submit', null);
INSERT INTO "acl_op" VALUES ('4', 'main.account.login', null);
INSERT INTO "acl_op" VALUES ('5', 'main.account.create', null);
INSERT INTO "acl_op" VALUES ('6', 'main.account.index', null);
INSERT INTO "acl_op" VALUES ('7', 'main.account.forgotpassword', null);
INSERT INTO "acl_op" VALUES ('8', 'main.auth.login', null);
INSERT INTO "acl_op" VALUES ('9', 'main.auth.logout', null);
INSERT INTO "acl_op" VALUES ('10', 'main.auth.create', null);
INSERT INTO "acl_op" VALUES ('11', 'main.dashboard.index', null);
COMMIT;

-- ----------------------------
--  Table structure for "acl_role_task"
-- ----------------------------
CREATE TABLE "acl_role_task" (
	"role_id" int4 NOT NULL
	, "task_id" int4 NOT NULL
	, CONSTRAINT "acl_role_task_pkey" PRIMARY KEY ("role_id", "task_id") NOT DEFERRABLE INITIALLY IMMEDIATE
	, CONSTRAINT "acl_role_task_role_id_fkey" FOREIGN KEY ("role_id") REFERENCES "acl_role" ("id") ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
	, CONSTRAINT "acl_role_task_task_id_fkey" FOREIGN KEY ("task_id") REFERENCES "acl_task" ("id") ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_role_task" OWNER TO "dev";

-- ----------------------------
--  Records of "acl_role_task"
-- ----------------------------
BEGIN;
INSERT INTO "acl_role_task" VALUES ('1', '1');
INSERT INTO "acl_role_task" VALUES ('1', '2');
INSERT INTO "acl_role_task" VALUES ('2', '1');
INSERT INTO "acl_role_task" VALUES ('2', '2');
INSERT INTO "acl_role_task" VALUES ('3', '1');
INSERT INTO "acl_role_task" VALUES ('3', '2');
INSERT INTO "acl_role_task" VALUES ('2', '5');
INSERT INTO "acl_role_task" VALUES ('1', '4');
INSERT INTO "acl_role_task" VALUES ('2', '4');
INSERT INTO "acl_role_task" VALUES ('3', '4');
COMMIT;


-- ----------------------------
--  Table structure for "acl_task_op"
-- ----------------------------
CREATE TABLE "acl_task_op" (
	"task_id" int4 NOT NULL
	, "op_id" int4 NOT NULL
	, CONSTRAINT "acl_task_op_pkey" PRIMARY KEY ("task_id", "op_id") NOT DEFERRABLE INITIALLY IMMEDIATE
	, CONSTRAINT "acl_task_op_task_id_fkey" FOREIGN KEY ("task_id") REFERENCES "acl_task" ("id") ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
	, CONSTRAINT "acl_task_op_op_id_fkey" FOREIGN KEY ("op_id") REFERENCES "acl_op" ("id") ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_task_op" OWNER TO "dev";

-- ----------------------------
--  Records of "acl_task_op"
-- ----------------------------
BEGIN;
INSERT INTO "acl_task_op" VALUES ('1', '2');
INSERT INTO "acl_task_op" VALUES ('1', '3');
INSERT INTO "acl_task_op" VALUES ('2', '1');
INSERT INTO "acl_task_op" VALUES ('3', '4');
INSERT INTO "acl_task_op" VALUES ('3', '5');
INSERT INTO "acl_task_op" VALUES ('3', '6');
INSERT INTO "acl_task_op" VALUES ('3', '7');
INSERT INTO "acl_task_op" VALUES ('4', '8');
INSERT INTO "acl_task_op" VALUES ('4', '9');
INSERT INTO "acl_task_op" VALUES ('4', '10');
INSERT INTO "acl_task_op" VALUES ('5', '11');
COMMIT;

-- ----------------------------
--  Table structure for "acl_user_role"
-- ----------------------------
CREATE TABLE "acl_user_role" (
	"user_id" int4 NOT NULL
	, "role_id" int4 NOT NULL
	, CONSTRAINT "acl_user_role_pkey" PRIMARY KEY ("user_id", "role_id") NOT DEFERRABLE INITIALLY IMMEDIATE
	, CONSTRAINT "acl_user_role_role_id_fkey" FOREIGN KEY ("role_id") REFERENCES "acl_role" ("id") ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_user_role" OWNER TO "dev";

-- ----------------------------
--  Records of "acl_user_role"
-- ----------------------------
BEGIN;
INSERT INTO "acl_user_role" VALUES ('0', '1');
INSERT INTO "acl_user_role" VALUES ('1', '1');
COMMIT;
