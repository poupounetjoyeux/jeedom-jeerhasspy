CREATE TABLE IF NOT EXISTS `JeerhasspySlot`
(
    `id` int
(
    11
) NOT NULL AUTO_INCREMENT,
    `name` TEXT NULL,
    `isSync` TINYINT
(
    1
) NULL,
    `configuration` TEXT NULL,
    PRIMARY KEY
(
    `id`
)
    ) ENGINE = InnoDB
    DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `JeerhasspyAnswer`
(
    `id` int
(
    11
) NOT NULL AUTO_INCREMENT,
    `name` TEXT NULL,
    `isSync` TINYINT
(
    1
) NULL,
    `configuration` TEXT NULL,
    PRIMARY KEY
(
    `id`
)
    ) ENGINE = InnoDB
    DEFAULT CHARSET = utf8;
