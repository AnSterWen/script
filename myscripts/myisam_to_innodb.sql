CREATE TABLE RU.t_ru_airank2 LIKE RU.t_ru_airank;
ALTER TABLE RU.t_ru_airank ENGINE=InnoDB;
INSERT INTO RU.t_ru_airank2 SELECT * FROM RU.t_ru_airank;
