CREATE VIEW `sales_all` AS select convert(ltrim(rtrim(((`d`.`First Name` + ' ') + `d`.`Last Name`))) using latin1),`S`.`Name` 
AS `MD Name`,`d`.`Specialty` AS `specialty`,`d`.`Frequency` AS `frequency`,`S`.`item_name` AS `Product`,
(case when (`d`.`City` > '') then `d`.`City` else '(Unknown City)' end) AS `City`,`d`.`Medrep Name` AS 
`Medrep Name`,`d`.`Manager Name` AS `Manager Name`,`P`.`class` AS `TC`,`P`.`subclass` AS `subclass`,`d`.`MD Class` AS 
`MD Class`,`S`.`Qty` AS `Volume`,`S`.`Amount` AS `Value` from ((`SalesByRep` `S` join `Doctor` `d` 
on((`S`.`MD ID` = `d`.`MD ID`))) join `PRODUCT_TC` `P` on((`P`.`item_code` = `S`.`item_code`)));