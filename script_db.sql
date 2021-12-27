-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema zhkh
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema zhkh
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `zhkh` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `zhkh` ;

-- -----------------------------------------------------
-- Table `zhkh`.`tb_ls`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zhkh`.`tb_ls` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `flat_number` INT(5) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 53468
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

CREATE UNIQUE INDEX `flat_number_2` ON `zhkh`.`tb_ls` (`flat_number` ASC, `address` ASC);

CREATE INDEX `flat_number` ON `zhkh`.`tb_ls` (`flat_number` ASC);


-- -----------------------------------------------------
-- Table `zhkh`.`tb_month`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zhkh`.`tb_month` (
  `id_month` INT(2) NOT NULL,
  `label_mmonth` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id_month`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `zhkh`.`tb_charges`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zhkh`.`tb_charges` (
  `id_ls` INT(11) NOT NULL,
  `smonth` INT(2) NOT NULL,
  `syear` INT(4) NOT NULL,
  `scount` FLOAT NOT NULL DEFAULT '0',
  CONSTRAINT `fk_charges_ls_id`
    FOREIGN KEY (`id_ls`)
    REFERENCES `zhkh`.`tb_ls` (`id`),
  CONSTRAINT `fk_month_id`
    FOREIGN KEY (`smonth`)
    REFERENCES `zhkh`.`tb_month` (`id_month`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

CREATE UNIQUE INDEX `id_ls` ON `zhkh`.`tb_charges` (`id_ls` ASC, `smonth` ASC, `syear` ASC);

CREATE INDEX `fk_month_id` ON `zhkh`.`tb_charges` (`smonth` ASC);


-- -----------------------------------------------------
-- Table `zhkh`.`tb_payments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zhkh`.`tb_payments` (
  `id_ls` INT(11) NOT NULL,
  `smonth` INT(2) NOT NULL,
  `syear` INT(4) NOT NULL,
  `scount` FLOAT NOT NULL DEFAULT '0',
  CONSTRAINT `fk_month_ids`
    FOREIGN KEY (`smonth`)
    REFERENCES `zhkh`.`tb_month` (`id_month`),
  CONSTRAINT `fk_payments_ls_id`
    FOREIGN KEY (`id_ls`)
    REFERENCES `zhkh`.`tb_ls` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

CREATE UNIQUE INDEX `id_ls` ON `zhkh`.`tb_payments` (`id_ls` ASC, `smonth` ASC, `syear` ASC);

CREATE INDEX `fk_month_ids` ON `zhkh`.`tb_payments` (`smonth` ASC);


-- -----------------------------------------------------
-- Table `zhkh`.`tb_saldo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zhkh`.`tb_saldo` (
  `id_ls` INT(11) NOT NULL,
  `scount_start` FLOAT NOT NULL DEFAULT '0',
  `scount_end` FLOAT NOT NULL DEFAULT '0',
  `syear_end` INT(4) NOT NULL,
  CONSTRAINT `fk_saldo_ls_id`
    FOREIGN KEY (`id_ls`)
    REFERENCES `zhkh`.`tb_ls` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

CREATE UNIQUE INDEX `id_ls` ON `zhkh`.`tb_saldo` (`id_ls` ASC, `syear_end` ASC);

USE `zhkh` ;

-- -----------------------------------------------------
-- function get_count_duty
-- -----------------------------------------------------

DELIMITER $$
USE `zhkh`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_count_duty`(`p_syear` INT(2), `p_flat_number` INT(11)) RETURNS int(2)
BEGIN
declare count_duty int(2) default 0;
select 
sum(rezult_m1 + rezult_m2 + rezult_m3 + rezult_m4 + rezult_m5 + rezult_m6
 + rezult_m7  + rezult_m8  + rezult_m9 + rezult_m10 + rezult_m11 + rezult_m12) into  count_duty
from
(
select
t.flat_number as flat_number,
case
	when t.ch_m1 > t.p_m1 then 1
    else  0
end rezult_m1,
case
	when t.ch_m2 > t.p_m2 then 1
    else  0
end rezult_m2,
case
	when t.ch_m3 > t.p_m3 then 1
    else  0
end rezult_m3,
case
	when t.ch_m4 > t.p_m4 then 1
    else  0
end rezult_m4,
case
	when t.ch_m5 > t.p_m5 then 1
    else  0
end rezult_m5,
case
	when t.ch_m6 > t.p_m6 then 1
    else  0
end rezult_m6,
case
	when t.ch_m7 > t.p_m7 then 1
    else  0
end rezult_m7,
case
	when t.ch_m8 > t.p_m8 then 1
    else  0
end rezult_m8,
case
	when t.ch_m9 > t.p_m9 then 1
    else  0
end rezult_m9,
case
	when t.ch_m10 > t.p_m10 then 1
    else  0
end rezult_m10,
case
	when t.ch_m11 > t.p_m11 then 1
    else  0
end rezult_m11,
case
	when t.ch_m12 > t.p_m12 then 1
    else  0
end rezult_m12
from
(
select 
                    ls.flat_number as flat_number,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 1), 2),0) as ch_m1,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 2), 2),0) as ch_m2,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 3), 2),0) as ch_m3,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 4), 2),0) as ch_m4,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 5), 2),0) as ch_m5,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 6), 2),0) as ch_m6,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 7), 2),0) as ch_m7,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 8), 2),0) as ch_m8,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 9), 2),0) as ch_m9,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 10), 2),0) as ch_m10,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 11), 2),0) as ch_m11,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 12), 2),0) as ch_m12,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 1), 2),0) as p_m1,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 2), 2),0) as p_m2,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 3), 2),0) as p_m3,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 4), 2),0) as p_m4,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 5), 2),0) as p_m5,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 6), 2),0) as p_m6,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 7), 2),0) as p_m7,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 8), 2),0) as p_m8,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 9), 2),0) as p_m9,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 10), 2),0) as p_m10,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 11), 2),0) as p_m11,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 12), 2),0) as p_m12
                    from tb_ls  ls
                    where ls.flat_number = p_flat_number 
                    ) as t
				) as t2
                group by t2.flat_number;
RETURN count_duty;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function get_saldo_end
-- -----------------------------------------------------

DELIMITER $$
USE `zhkh`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_saldo_end`(`p_syear` INT(2), `p_ls` INT(11)) RETURNS decimal(10,2)
BEGIN
DECLARE count_rows int(1);
DECLARE saldo decimal(10,2);

SELECT
    count(*) into count_rows
FROM
(
    SELECT
	ch.id_ls as id_ls,
    TRUNCATE(sum(ch.scount),2) as sum_charges,
    TRUNCATE(sum(p.scount),2) as sum_payments,
    ch.syear as syear
from tb_charges ch,
    tb_payments p 
where ch.id_ls = p.id_ls
	and ch.id_ls = p_ls
    and ch.syear = p_syear
group by 
    ch.id_ls, ch.syear
    ) as t;
    
    if count_rows = 1 then    
SELECT
    (t.sum_charges - t.sum_payments) into saldo
FROM
(
    SELECT
	ch.id_ls as id_ls,
    TRUNCATE(sum(ch.scount),2) as sum_charges,
    TRUNCATE(sum(p.scount),2) as sum_payments,
    ch.syear as syear
from tb_charges ch,
    tb_payments p 
where ch.id_ls = p.id_ls
	and ch.id_ls = p_ls
    and ch.syear = p_syear
group by 
    ch.id_ls, ch.syear
    ) as t;        
    return saldo;
    
    elseif count_rows = 0 then
		return 0;
    end if;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function get_saldo_start
-- -----------------------------------------------------

DELIMITER $$
USE `zhkh`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_saldo_start`(`p_syear` INT(2), `p_ls` INT(11)) RETURNS decimal(10,2)
BEGIN
DECLARE count_rows int(1);
DECLARE saldo decimal(10,2);

SELECT
    count(*) into count_rows
FROM
(
    SELECT
	ch.id_ls as id_ls,
    TRUNCATE(sum(ch.scount),2) as sum_charges,
    TRUNCATE(sum(p.scount),2) as sum_payments,
    ch.syear as syear
from tb_charges ch,
    tb_payments p 
where ch.id_ls = p.id_ls
	and ch.id_ls = p_ls
    and ch.syear = p_syear - 1
group by 
    ch.id_ls, ch.syear
    ) as t;
    
    if count_rows = 1 then    
SELECT
    (t.sum_charges - t.sum_payments) into saldo
FROM
(
    SELECT
	ch.id_ls as id_ls,
    TRUNCATE(sum(ch.scount),2) as sum_charges,
    TRUNCATE(sum(p.scount),2) as sum_payments,
    ch.syear as syear
from tb_charges ch,
    tb_payments p 
where ch.id_ls = p.id_ls
	and ch.id_ls = p_ls
    and ch.syear = p_syear - 1
group by 
    ch.id_ls, ch.syear
    ) as t;        
    return saldo;
    
    elseif count_rows = 0 then
		return 0;
    end if;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function get_sum_charges
-- -----------------------------------------------------

DELIMITER $$
USE `zhkh`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_sum_charges`(p_ls int(11), p_syear int(4)) RETURNS decimal(10,2)
BEGIN
declare sum_charges decimal(10,2) default 0;
                    SELECT
                     TRUNCATE(sum(ch.scount),2) into sum_charges
                from tb_charges ch
                where ch.id_ls = p_ls 
                and ch.syear = p_syear
                group by 
                    ch.id_ls, ch.syear
                    ;
                    return sum_charges;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function get_sum_duty
-- -----------------------------------------------------

DELIMITER $$
USE `zhkh`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_sum_duty`(`p_syear` INT(2), `p_flat_number` INT(11)) RETURNS decimal(10,2)
BEGIN
declare sum_duty int(2) default 0;
select 
sum(rezult_m1 + rezult_m2 + rezult_m3 + rezult_m4 + rezult_m5 + rezult_m6
 + rezult_m7  + rezult_m8  + rezult_m9 + rezult_m10 + rezult_m11 + rezult_m12) into sum_duty
from
(
select
t.flat_number as flat_number,
case
	when t.ch_m1 > t.p_m1 then t.ch_m1-t.p_m1
    else  t.p_m1-t.ch_m1
end rezult_m1,
case
	when t.ch_m2 > t.p_m2 then t.ch_m2-t.p_m2
    else  t.p_m2-t.ch_m2
end rezult_m2,
case
	when t.ch_m3 > t.p_m3 then t.ch_m3-t.p_m3
    else  t.p_m3-t.ch_m3
end rezult_m3,
case
	when t.ch_m4 > t.p_m4 then t.ch_m4-t.p_m4
    else  t.p_m4-t.ch_m4
end rezult_m4,
case
	when t.ch_m5 > t.p_m5 then t.ch_m5-t.p_m5
    else  t.p_m5-t.ch_m5
end rezult_m5,
case
	when t.ch_m6 > t.p_m6 then t.ch_m6-t.p_m6
    else  t.p_m6-t.ch_m6
end rezult_m6,
case
	when t.ch_m7 > t.p_m7 then t.ch_m7-t.p_m7
    else  t.p_m7-t.ch_m7
end rezult_m7,
case
	when t.ch_m8 > t.p_m8 then t.ch_m8-t.p_m8
    else  t.p_m8-t.ch_m8
end rezult_m8,
case
	when t.ch_m9 > t.p_m9 then t.ch_m9-t.p_m9
    else  t.p_m9-t.ch_m9
end rezult_m9,
case
	when t.ch_m10 > t.p_m10 then t.ch_m10-t.p_m10
    else  t.p_m10-t.ch_m10
end rezult_m10,
case
	when t.ch_m11 > t.p_m11 then t.ch_m11-t.p_m11
    else  t.p_m11-t.ch_m11
end rezult_m11,
case
	when t.ch_m12 > t.p_m12 then t.ch_m12-t.p_m12
    else  t.p_m12-t.ch_m12
end rezult_m12
from
(
select 
                    ls.flat_number as flat_number,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 1), 2),0) as ch_m1,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 2), 2),0) as ch_m2,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 3), 2),0) as ch_m3,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 4), 2),0) as ch_m4,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 5), 2),0) as ch_m5,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 6), 2),0) as ch_m6,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 7), 2),0) as ch_m7,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 8), 2),0) as ch_m8,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 9), 2),0) as ch_m9,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 10), 2),0) as ch_m10,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 11), 2),0) as ch_m11,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 12), 2),0) as ch_m12,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 1), 2),0) as p_m1,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 2), 2),0) as p_m2,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 3), 2),0) as p_m3,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 4), 2),0) as p_m4,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 5), 2),0) as p_m5,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 6), 2),0) as p_m6,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 7), 2),0) as p_m7,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 8), 2),0) as p_m8,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 9), 2),0) as p_m9,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 10), 2),0) as p_m10,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 11), 2),0) as p_m11,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 12), 2),0) as p_m12
                    from tb_ls  ls
                    where ls.flat_number = p_flat_number
                    ) as t
				) as t2
                group by t2.flat_number;
RETURN sum_duty;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function get_sum_payments
-- -----------------------------------------------------

DELIMITER $$
USE `zhkh`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_sum_payments`(p_ls int(11), p_syear int(4)) RETURNS decimal(10,2)
BEGIN
declare sum_payments decimal(10,2) default 0;
                    SELECT
                     TRUNCATE(sum(p.scount),2) into sum_payments
                from tb_payments p 
                where p.id_ls = p_ls 
                and p.syear = p_syear
                group by 
                    p.id_ls, p.syear
                    ;
                    return sum_payments;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure proc_form_1
-- -----------------------------------------------------

DELIMITER $$
USE `zhkh`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_form_1`(in p_syear int(4))
BEGIN
select distinct
                    ls.flat_number as flat_number,
                    get_saldo_start(p_syear, ls.id) as saldo_start,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 1), 2),0) as m1,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 2), 2),0) as m2,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 3), 2),0) as m3,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 4), 2),0) as m4,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 5), 2),0) as m5,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 6), 2),0) as m6,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 7), 2),0) as m7,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 8), 2),0) as m8,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 9), 2),0) as m9,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 10), 2),0) as m10,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 11), 2),0) as m11,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 12), 2),0) as m12,
                    get_saldo_end(p_syear, ls.id) as saldo_end
                    from tb_ls  ls ;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure proc_form_2
-- -----------------------------------------------------

DELIMITER $$
USE `zhkh`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_form_2`(in p_syear int(4), in p_flat_number int(5))
BEGIN
select 
                    ls.flat_number as flat_number,
                    get_saldo_start(p_syear, ls.id) as saldo_start,
                    get_saldo_end(p_syear, ls.id) as saldo_end,
                    get_sum_charges(ls.id, p_syear) as sum_charges,
                    get_sum_payments(ls.id, p_syear) as sum_payments,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 1), 2),0) as ch_m1,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 2), 2),0) as ch_m2,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 3), 2),0) as ch_m3,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 4), 2),0) as ch_m4,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 5), 2),0) as ch_m5,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 6), 2),0) as ch_m6,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 7), 2),0) as ch_m7,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 8), 2),0) as ch_m8,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 9), 2),0) as ch_m9,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 10), 2),0) as ch_m10,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 11), 2),0) as ch_m11,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 12), 2),0) as ch_m12,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 1), 2),0) as p_m1,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 2), 2),0) as p_m2,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 3), 2),0) as p_m3,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 4), 2),0) as p_m4,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 5), 2),0) as p_m5,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 6), 2),0) as p_m6,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 7), 2),0) as p_m7,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 8), 2),0) as p_m8,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 9), 2),0) as p_m9,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 10), 2),0) as p_m10,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 11), 2),0) as p_m11,
                    ifnull(truncate((select scount from tb_payments where syear = p_syear and `id_ls` = ls.id and `smonth` = 12), 2),0) as p_m12,
                    (get_sum_charges(ls.id, 2021) - get_sum_payments(ls.id, 2021)) + get_saldo_start(2021, ls.id) as sum_all
                    from tb_ls  ls
                    where ls.flat_number = p_flat_number ;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure proc_form_3
-- -----------------------------------------------------

DELIMITER $$
USE `zhkh`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_form_3`(in p_syear int(4))
BEGIN
select 
                    ls.flat_number as flat_number,
                    ifnull(truncate((select scount from tb_charges where syear = p_syear and `id_ls` = ls.id and `smonth` = 12), 2),0) as ch_m12,
                    case get_count_duty(p_syear, ls.flat_number)
						when 0 then 0
						else get_sum_duty(p_syear, ls.flat_number) 
					end saldo_end,
                    case get_count_duty(p_syear, ls.flat_number)
						when 1 then get_sum_duty(p_syear, ls.flat_number)
					else 0
                    end sum_month_1,
                    case get_count_duty(p_syear, ls.flat_number)
						when 2 then  get_sum_duty(p_syear, ls.flat_number)
					else 0
                    end sum_month_2,
                    case get_count_duty(p_syear, ls.flat_number)
						when 3 then  get_sum_duty(p_syear, ls.flat_number)
					else 0
                    end sum_month_3,
                    case 
						when get_count_duty(p_syear, ls.flat_number) > 3 then  get_sum_duty(p_syear, ls.flat_number)
					else 0
                    end sum_month_more
                    from tb_ls  ls 
                    order by ls.flat_number asc;
END$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
