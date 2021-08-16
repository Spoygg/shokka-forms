CREATE TABLE `tablename` (
  `ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` BIGINT(20) UNSIGNED NOT NULL,
  `submission_text` LONGTEXT NOT NULL,
  `submission_date` DATETIME NOT NULL,
  PRIMARY KEY (`ID`, `form_id`),
  INDEX `form_id_idx` (`form_id` ASC)
);