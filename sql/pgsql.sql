-- ----------------------------
-- Drop and create sequences
-- ----------------------------
DROP TABLE IF EXISTS "acl_user_role";
DROP TABLE IF EXISTS "acl_role";
DROP TABLE IF EXISTS "acl_role_task";
DROP TABLE IF EXISTS "acl_task";
DROP TABLE IF EXISTS "acl_task_op";
DROP TABLE IF EXISTS "acl_op";

DROP SEQUENCE IF EXISTS "acl_user_role_seq";
DROP SEQUENCE IF EXISTS "acl_role_seq";
DROP SEQUENCE IF EXISTS "acl_role_task_seq";
DROP SEQUENCE IF EXISTS "acl_task_seq";
DROP SEQUENCE IF EXISTS "acl_task_op_seq";
DROP SEQUENCE IF EXISTS "acl_op_seq";

CREATE SEQUENCE "acl_user_role_id_seq" INCREMENT 1 START 1 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_user_role_id_seq" OWNER TO "dev";

CREATE SEQUENCE "acl_role_id_seq" INCREMENT 1 START 1 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_role_id_seq" OWNER TO "dev";

CREATE SEQUENCE "acl_role_task_id_seq" INCREMENT 1 START 1 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_role_task_id_seq" OWNER TO "dev";

CREATE SEQUENCE "acl_task_id_seq" INCREMENT 1 START 1 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_task_id_seq" OWNER TO "dev";

CREATE SEQUENCE "acl_task_op_id_seq" INCREMENT 1 START 1 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_task_op_id_seq" OWNER TO "dev";

CREATE SEQUENCE "acl_op_id_seq" INCREMENT 1 START 1 MAXVALUE 9223372036854775807 MINVALUE 1 CACHE 1 CYCLE;
ALTER TABLE "acl_op_id_seq" OWNER TO "dev";

-- ----------------------------
--  Table structure for "acl_user_role"
-- ----------------------------
CREATE TABLE "acl_user_role" (
	"user_id" int4 NOT NULL
	, "role_id" int4 NOT NULL
	, CONSTRAINT "acl_user_role_pkey" PRIMARY KEY ("user_id", "role_id") NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_user_role" OWNER TO "dev";
-- ----------------------------
--  Table structure for "acl_role"
-- ----------------------------
CREATE TABLE "acl_role" (
	"id" int4 NOT NULL DEFAULT nextval('acl_role_id_seq'::regclass)
	, "name" varchar(64) NOT NULL
	, "description" varchar(255) DEFAULT NULL
	, CONSTRAINT "acl_role_pkey" PRIMARY KEY ("id") NOT DEFERRABLE INITIALLY IMMEDIATE
	, CONSTRAINT "U_acl_role_name" UNIQUE ("name") NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_role" OWNER TO "dev";

-- ----------------------------
--  Table structure for "acl_role_task"
-- ----------------------------
CREATE TABLE "acl_role_task" (
	"role_id" int4 NOT NULL
	, "task_id" int4 NOT NULL
	, CONSTRAINT "acl_role_task_pkey" PRIMARY KEY ("role_id", "task_id") NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_role_task" OWNER TO "dev";

-- ----------------------------
--  Table structure for "acl_task"
-- ----------------------------
CREATE TABLE "acl_task" (
	"id" int4 NOT NULL DEFAULT nextval('acl_task_id_seq'::regclass)
	, "name" varchar(64) NOT NULL
	, "description" varchar(255) DEFAULT NULL
	, CONSTRAINT "acl_task_pkey" PRIMARY KEY ("id") NOT DEFERRABLE INITIALLY IMMEDIATE
	, CONSTRAINT "U_acl_task_name" UNIQUE ("name") NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_task" OWNER TO "dev";

-- ----------------------------
--  Table structure for "acl_task_op"
-- ----------------------------
CREATE TABLE "acl_task_op" (
	"task_id" int4 NOT NULL
	, "op_id" int4 NOT NULL
	, CONSTRAINT "acl_task_op_pkey" PRIMARY KEY ("task_id", "op_id") NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_task_op" OWNER TO "dev";

-- ----------------------------
--  Table structure for "acl_op"
-- ----------------------------
CREATE TABLE "acl_op" (
	"id" int4 NOT NULL DEFAULT nextval('acl_op_id_seq'::regclass)
	, "name" varchar(64) NOT NULL
	, "description" varchar(255) DEFAULT NULL
	, CONSTRAINT "acl_op_pkey" PRIMARY KEY ("id") NOT DEFERRABLE INITIALLY IMMEDIATE
	, CONSTRAINT "U_acl_op_name" UNIQUE ("name") NOT DEFERRABLE INITIALLY IMMEDIATE
)
WITH (OIDS=FALSE);
ALTER TABLE "acl_op" OWNER TO "dev";
