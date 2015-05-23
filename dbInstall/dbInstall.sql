DROP SCHEMA IF EXISTS mydb ;
CREATE SCHEMA IF NOT EXISTS mydb DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

use mydb;

-- -----------------------------------------------------
-- katedra
-- -----------------------------------------------------
DROP TABLE IF EXISTS katedra ;

CREATE  TABLE IF NOT EXISTS katedra (
  id INT NOT NULL ,
  naziv VARCHAR(45) NOT NULL ,
  PRIMARY KEY (id) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- nalog
-- -----------------------------------------------------
DROP TABLE IF EXISTS nalog ;

CREATE  TABLE IF NOT EXISTS nalog (
  korisnickoIme VARCHAR(20) NOT NULL ,
  ime VARCHAR(45) NOT NULL ,
  prezime VARCHAR(100) NOT NULL ,
  email VARCHAR(45) NOT NULL ,
  telefon VARCHAR(20) NOT NULL ,
  lozinka VARCHAR(32) NOT NULL ,
  katedra INT NOT NULL ,
  jeDezurni TINYINT(1) NOT NULL ,
  jeAdministrator TINYINT(1) NOT NULL ,
  jeKoordinator TINYINT(1) NOT NULL ,
  opterecenje DECIMAL(3,2) NOT NULL ,
  status TINYINT(1) NOT NULL ,
  napomena VARCHAR(100) NULL ,
  koeficijentAngazovanja FLOAT NOT NULL ,
  PRIMARY KEY (korisnickoIme) ,
  INDEX fk_Nalog_Katedra_idx (katedra ASC) ,
  CONSTRAINT fk_Nalog_Katedra
    FOREIGN KEY (katedra )
    REFERENCES katedra (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- lokacija
-- -----------------------------------------------------
DROP TABLE IF EXISTS lokacija ;

CREATE  TABLE IF NOT EXISTS lokacija (
  id INT NOT NULL AUTO_INCREMENT ,
  sifra VARCHAR(5) NOT NULL ,
  opis VARCHAR(45) NOT NULL ,
  adresa VARCHAR(45) NOT NULL ,
  email VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- sala
-- -----------------------------------------------------
DROP TABLE IF EXISTS sala ;

CREATE  TABLE IF NOT EXISTS sala (
  id INT NOT NULL AUTO_INCREMENT ,
  oznaka VARCHAR(45) NOT NULL ,
  kapacitet INT NOT NULL ,
  racunariKapacitet VARCHAR(45) NOT NULL ,
  lokacija INT NOT NULL ,
  PRIMARY KEY (id) ,
  INDEX fk_Sala_Lokacija1_idx (lokacija ASC) ,
  CONSTRAINT fk_Sala_Lokacija1
    FOREIGN KEY (lokacija )
    REFERENCES lokacija (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- obaveza
-- -----------------------------------------------------
DROP TABLE IF EXISTS obaveza ;

CREATE TABLE IF NOT EXISTS obaveza (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nazivObaveze VARCHAR(45) NOT NULL,
  korisnickoImeGlavnogDezurnog VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX fk_Obaveza_Nalog1_idx (korisnickoImeGlavnogDezurnog ASC),
  CONSTRAINT fk_Obaveza_Nalog1
    FOREIGN KEY (korisnickoImeGlavnogDezurnog)
    REFERENCES nalog (korisnickoIme)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- najavljenaGrupa
-- -----------------------------------------------------
DROP TABLE IF EXISTS najavljenagrupa ;

CREATE  TABLE IF NOT EXISTS najavljenagrupa (
  rbrNajave INT NOT NULL AUTO_INCREMENT ,
  grupa INT NOT NULL ,
  obaveza INT NOT NULL ,
  oznaka VARCHAR(45) NOT NULL ,
  datum DATE NULL ,
  pocetakRezervacije TIME NULL ,
  krajRezervacije TIME NULL ,
  trajanjeDezurstvaPredmetnogAsistenta TINYINT NOT NULL ,
  pocetakDezurstvaPomocnogDezurnog TIME NULL ,
  trajanjeDezurstvaPomocnogDezurnog TINYINT NOT NULL ,
  radNaRacunarima TINYINT(1) NOT NULL ,
  brojDezurnih TINYINT NOT NULL ,
  napomenaZaKoordinatora VARCHAR(45) NULL ,
  napomenaZaDezurne VARCHAR(45) NULL ,
  brojOcekivanihStudenata INT NULL ,
  datumNajave DATE NOT NULL ,
  status TINYINT(1) NOT NULL ,
  INDEX fk_Grupa_Obaveza2_idx (obaveza ASC) ,
  INDEX `key` (rbrNajave ASC) ,
  PRIMARY KEY (rbrNajave) ,
  CONSTRAINT fk_Grupa_Obaveza2
    FOREIGN KEY (obaveza )
    REFERENCES obaveza (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- predmetniAsistentiNaObavezi
-- -----------------------------------------------------
DROP TABLE IF EXISTS predmetniasistentinaobavezi ;

CREATE  TABLE IF NOT EXISTS predmetniasistentinaobavezi (
  id INT NOT NULL AUTO_INCREMENT,  
  korisnickoIme VARCHAR(20) NOT NULL ,
  obaveza INT NOT NULL ,
  PRIMARY KEY (id) ,
  INDEX fk_asistentiNaObavezi_Obaveza1_idx (obaveza ASC) ,
  CONSTRAINT fk_asistentiNaObavezi_Nalog1
    FOREIGN KEY (korisnickoIme )
    REFERENCES nalog (korisnickoIme)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_asistentiNaObavezi_Obaveza1
    FOREIGN KEY (obaveza)
    REFERENCES obaveza (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT uc_korisnickoImeObaveza UNIQUE (korisnickoIme,obaveza)
  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- zakazanagrupa
-- -----------------------------------------------------
DROP TABLE IF EXISTS zakazanagrupa ;
CREATE  TABLE IF NOT EXISTS zakazanagrupa (
  rbrZakazivanja INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  rbrNajave int NOT NULL,
  grupa INT NOT NULL ,
  obaveza INT NOT NULL,
  oznaka VARCHAR(45) NOT NULL ,
  datum DATE NOT NULL ,
  pocetakRezervacije TIME NOT NULL ,
  krajRezervacije TIME NOT NULL ,
  trajanjeDezurstvaPredmetnogAsistenta TINYINT NOT NULL ,
  pocetakDezurstvaPomocnogDezurnog TIME NOT NULL ,
  trajanjeDezurstvaPomocnogDezurnog TINYINT NOT NULL ,
  radNaRacunarima TINYINT(1) NOT NULL ,
  brojDezurnih TINYINT NOT NULL ,
  napomenaZaDezurne VARCHAR(45) NULL ,
  brojOcekivanihStudenata INT NULL ,
  brojPrijavljenih INT NULL ,
  brojIzaslih INT NULL ,
  datumObrade DATE NOT NULL ,
  `status` TINYINT(1) NOT NULL ,
  PRIMARY KEY (rbrZakazivanja) ,
  INDEX fk_ZakazanaGrupa_NajavljenaGrupa1_idx (rbrNajave ASC) ,
  CONSTRAINT fk_ZakazanaGrupa_NajavljenaGrupa1
    FOREIGN KEY (rbrNajave)
    REFERENCES najavljenagrupa (rbrNajave )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
 CONSTRAINT fk_ZakazanaGrupa_Obaveza
    FOREIGN KEY (obaveza)
    REFERENCES obaveza (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`NajavljenaGrupaSala`
-- -----------------------------------------------------
DROP TABLE IF EXISTS najavljenagrupasala ;

CREATE  TABLE IF NOT EXISTS najavljenagrupasala (
  id INT NOT NULL AUTO_INCREMENT,  
  sala INT NOT NULL ,
  rbrNajave INT NOT NULL ,
  PRIMARY KEY (id) ,
  INDEX fk_NajavljenaGrupaSala_NajavljenaGrupa1_idx (rbrNajave ASC) ,
  CONSTRAINT fk_NajavljenaGrupaSala_Sala1
    FOREIGN KEY (sala)
    REFERENCES sala (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_NajavljenaGrupaSala_NajavljenaGrupa1
    FOREIGN KEY (rbrNajave)
    REFERENCES najavljenagrupa (rbrNajave )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT uc_salaRbrNajave UNIQUE (sala, rbrNajave)
  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- zakazanagrupasala
-- -----------------------------------------------------
DROP TABLE IF EXISTS zakazanagrupasala ;


CREATE  TABLE IF NOT EXISTS zakazanagrupasala (
  id INT NOT NULL AUTO_INCREMENT,
  sala INT NOT NULL ,
  rbrZakazivanja INT UNSIGNED NOT NULL ,
  PRIMARY KEY (id) ,
  INDEX fk_ZakazanaGrupaSala_ZakazanaGrupa1_idx (rbrZakazivanja ASC) ,
  CONSTRAINT fk_ZakazanaGrupaSala_Sala1
    FOREIGN KEY (sala)
    REFERENCES sala (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_ZakazanaGrupaSala_ZakazanaGrupa1
    FOREIGN KEY (rbrZakazivanja)
    REFERENCES zakazanagrupa (rbrZakazivanja)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT uc_salaRbrZakazivanja UNIQUE (sala, rbrZakazivanja)
	)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- zakazanagrupadezurni
-- -----------------------------------------------------
DROP TABLE IF EXISTS zakazanagrupadezurni ;

CREATE  TABLE IF NOT EXISTS zakazanagrupadezurni (
  id INT NOT NULL AUTO_INCREMENT ,
  korisnickoIme VARCHAR(20) NOT NULL ,
  rbrZakazivanja INT UNSIGNED NOT NULL ,
  PRIMARY KEY (id) ,
  INDEX fk_ZakazanaGrupaDezurni_Nalog1_idx (korisnickoIme ASC) ,
  INDEX fk_ZakazanaGrupaDezurni_ZakazanaGrupa1_idx (rbrZakazivanja ASC) ,
  CONSTRAINT fk_ZakazanaGrupaDezurni_Nalog1
    FOREIGN KEY (korisnickoIme)
    REFERENCES nalog (korisnickoIme)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_ZakazanaGrupaDezurni_ZakazanaGrupa1
    FOREIGN KEY (rbrZakazivanja )
    REFERENCES zakazanagrupa (rbrZakazivanja)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT uc_korisnickoImeRbrZakazivanja UNIQUE (korisnickoIme, rbrZakazivanja)
  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- napomenagrupadezurni
-- -----------------------------------------------------
DROP TABLE IF EXISTS napomenagrupadezurni ;

CREATE  TABLE IF NOT EXISTS napomenagrupadezurni (
  id INT NOT NULL AUTO_INCREMENT,
  korisnickoImeGlavnogDezurnog VARCHAR(20) NOT NULL ,
  napomena VARCHAR(100) NOT NULL ,
  datumNapomene TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  vidljivost TINYINT(1) NULL ,
  procitano TINYINT(1) NULL ,
  zakazanaGrupaDezurniId INT NOT NULL,
  PRIMARY KEY (id) ,
  INDEX fk_NapomenaGrupaDezurni_ZakazanaGrupaDezurni1_idx (zakazanaGrupaDezurniId ASC) ,
  CONSTRAINT fk_NapomenaGrupaDezurni_ZakazanaGrupaDezurni1
    FOREIGN KEY (zakazanaGrupaDezurniId)
    REFERENCES zakazanagrupadezurni (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT uc_korisnickoImeGlavnogDezurnogKorisnickoImeRbrZakazivanja UNIQUE (zakazanaGrupaDezurniId, korisnickoImeGlavnogDezurnog)
  )
ENGINE = InnoDB;



-- -----------------------------------------------------
-- napomenagrupa
-- -----------------------------------------------------
DROP TABLE IF EXISTS napomenagrupa ;

CREATE  TABLE IF NOT EXISTS napomenagrupa (
  id INT NOT NULL AUTO_INCREMENT,
  korisnickoImeGlavnogDezurnog VARCHAR(20) NOT NULL ,
  rbrZakazivanja INT UNSIGNED NOT NULL ,
  napomena VARCHAR(100) NOT NULL ,
  datumNapomene DATE NOT NULL ,
  vidljivost TINYINT(1) NULL ,
  PRIMARY KEY (id) ,
  INDEX fk_NapomenaGrupa_ZakazanaGrupa1_idx (rbrZakazivanja ASC) ,
  CONSTRAINT fk_NapomenaGrupa_ZakazanaGrupa1
    FOREIGN KEY (rbrZakazivanja)
    REFERENCES zakazanagrupa (rbrZakazivanja)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT uc_korisnickoImeGlavnogDezurnogRbrZakazivanja UNIQUE (korisnickoImeGlavnogDezurnog,rbrZakazivanja)
  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- ponudjenezamene
-- -----------------------------------------------------
DROP TABLE IF EXISTS ponudjenezamene ;

CREATE  TABLE IF NOT EXISTS ponudjenezamene (
  id INT NOT NULL AUTO_INCREMENT,
  korisnickoImePrimaoca VARCHAR(20) NOT NULL ,
  `status` TINYINT(1) NOT NULL ,
  zakazanaGrupaDezurniId INT NOT NULL,
  INDEX fk_PonudjeneZamene_Nalog1_idx (korisnickoImePrimaoca ASC) ,
  PRIMARY KEY (id) ,
  CONSTRAINT fk_PonudjeneZamene_Nalog1
    FOREIGN KEY (korisnickoImePrimaoca)
    REFERENCES nalog (korisnickoIme )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_PonudjeneZamene_ZakazanaGrupaDezurni1
    FOREIGN KEY (zakazanaGrupaDezurniId)
    REFERENCES zakazanagrupadezurni (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT uc_korisnickoImePosiljaocaKorisnickoImePrimaocaRbrZakazivanja UNIQUE (zakazanaGrupaDezurniId, korisnickoImePrimaoca)

	)
ENGINE = InnoDB;
