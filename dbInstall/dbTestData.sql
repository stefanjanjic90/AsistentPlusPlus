use mydb;

insert into katedra values (1,"Računarsto i informatika"), (2,"Verovatnoća i statistika"), (3,"Numerička matematika"), (4,"Kompleksna analiza");

insert into nalog values ("andjelkaz","Andjelka","Zečević","andjelkaz@matf.bg.ac.rs","060123456","andjelka",1,true,false,false,0.8,true,"superiska",1.0);

insert into nalog values ("aspasic","Ana","Spasić","aspasic@matf.bg.ac.rs","060123456","anas",2,true,false,false,0.2,true,"napomena",1.0);

insert into obaveza values (1,"Kolokvijum iz UVITa","andjelkaz"),(2,"Kolokvijum iz PPJa","aspasic"), (3, "Kolokvijum iz PWEB", "andjelkaz");

insert into predmetniasistentinaobavezi values (1,"andjelkaz",1),(2,"aspasic",1),(3,"andjelkaz",2),(4,"aspasic",2),(5,"andjelkaz",3);

insert into najavljenagrupa values (1,1,1,"UVIT prva grupa","2014-03-15",null,null,2,null,2,true,2,null,"Njo njo net",20,"2014-02-12",false),
(2,2,1,"UVIT druga grupa","2014-03-15",null,null,2,null,2,true,2,null,"Njo njo net",20,"2014-02-12",false),
(3,3,1,"UVIT treca grupa","2014-03-15",null,null,2,null,2,true,2,null,"Njo njo net",20,"2014-02-12",false),
(4,1,3,"PWEB prva grupa","2015-05-18",null,null,3,null,3,true,2,null,"Bez neta",25,"2015-05-10",false),
(5,2,3,"PWEB druga grupa","2015-05-20",null,null,3,null,3,true,2,null,"Bez neta",25,"2015-05-10",false);



insert into lokacija values (1,"Trg","Studentski trg 16","Stud trg","studentski@matf.bg.ac.rs"), (2,"Jag","Jag","Vatroslava Jagića 5","jagic@matf.bg.ac.rs");

insert into sala values (1,"718", 40, "25", 1), (2,"706", 90, "0", 1), (3,"830", 35, "25", 1), (4,"Jag1", 80, "0", 2),(5,"Jag3", 20, "20", 2);


insert into zakazanagrupa values (1,1,1,1,"Oznaka obaveze br 1", "2014-03-15", "09:00", "12:00", 3, "09:00", 3, true, 3, "Bez neta i literature", 45,null, null,
"2014-02-12", false);

insert into zakazanagrupa values (2,1,1,2,"Oznaka obaveze br 1/2 PPJ", "2014-03-15", "09:00", "12:00", 3, "09:00", 3, true, 3, "Bez neta ", 30,null, null,
"2014-02-12", true);

insert into zakazanagrupa values (3,1,2,2,"Oznaka obaveze br 2/2 PPJ", "2014-03-15", "09:00", "12:00", 3, "09:00", 3, true, 3, "Bez neta ", 30,null, null,
"2014-02-12", true);

insert into najavljenagrupasala values (1,1,1), (2,1,2);

insert into zakazanagrupasala values (1,1,1);

insert into zakazanagrupasala values (2,4,2);

insert into zakazanagrupasala values (3,5,3);

insert into zakazanagrupadezurni values (1,"aspasic",1);
insert into zakazanagrupadezurni values (2,"andjelkaz",2);
insert into zakazanagrupadezurni values (3,"andjelkaz",3);

