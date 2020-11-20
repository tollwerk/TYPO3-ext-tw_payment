#
# Table structure for table 'tx_twpayment_domain_model_transaction'
#
CREATE TABLE tx_twpayment_domain_model_transaction (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	sender varchar(255) DEFAULT '' NOT NULL,
	amount double(11,2) DEFAULT '0.00' NOT NULL,
	description varchar(255) DEFAULT '' NOT NULL,
	text text DEFAULT '' NOT NULL,
	image varchar(255) DEFAULT '' NOT NULL,
	template tinyint(1) unsigned DEFAULT '0' NOT NULL,
	token varchar(255) DEFAULT '' NOT NULL,
	error text NOT NULL,
	charged int(11) DEFAULT '0' NOT NULL,
	created int(11) DEFAULT '0' NOT NULL,
	ip varchar(15) DEFAULT '' NOT NULL,
	currency int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_twpayment_domain_model_currency'
#
CREATE TABLE tx_twpayment_domain_model_currency (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	currency int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);
