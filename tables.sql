CREATE TABLE IF NOT EXISTS calculator_logs
(
	cl_id int unsigned NOT NULL auto_increment,
	expression varchar(255) NULL,
	created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(cl_id)
);