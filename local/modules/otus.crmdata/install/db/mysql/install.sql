CREATE TABLE `b_otus_crmdata` (
                                  `ID`        INT(11) NOT NULL AUTO_INCREMENT,
                                  `ENTITY_ID` INT(11) NOT NULL,
                                  `DATA`      VARCHAR(255) NOT NULL,
                                  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
