<?php

$tablesSQL = "CREATE TABLE tuoteryhma (
  trnro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  trnimi VARCHAR(255) NOT NULL
);
CREATE TABLE tuote (
  tuotenro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  tuotenimi VARCHAR(255) NOT NULL,
  tuotekuvaus TEXT,
  trnro INT,
  hinta DECIMAL(4,2),
  CONSTRAINT `fk_trnro` FOREIGN KEY (trnro) REFERENCES tuoteryhma(trnro)
);
CREATE TABLE hoitoohje (
  ohjenro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  ohje TEXT NOT NULL,
  tuote_id INT,
  CONSTRAINT `fk_tuote_id` FOREIGN KEY (tuote_id) REFERENCES tuote(tuotenro)
);
CREATE TABLE tieteellinen_nimi (
  tieteellinen_nimi VARCHAR(255) NOT NULL,
  tuote_id INT,
  CONSTRAINT `fk_tuote_tieteellinen_id` FOREIGN KEY (tuote_id) REFERENCES tuote(tuotenro)
);
CREATE TABLE asiakas(
  asiakasnro INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  etunimi VARCHAR(50) NOT NULL,
  sukunimi VARCHAR(50) NOT NULL,
  osoite VARCHAR(50) NOT NULL,
  postinro VARCHAR(50) NOT NULL,
  postitmp VARCHAR(50) NOT NULL,
  sposti VARCHAR(50) NOT NULL
);
CREATE TABLE kayttaja (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  tunnus VARCHAR(25) NOT NULL UNIQUE,
  salasana VARCHAR(255) NOT NULL,
  sposti VARCHAR(50) NOT NULL,
  asiakasnro INT,
  CONSTRAINT `fk_kayttaja_asiakas` FOREIGN KEY (asiakasnro) REFERENCES asiakas(asiakasnro)
  ON DELETE RESTRICT
);
CREATE TABLE tilaus(
  tilausnro INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  asiakas_id INT NOT NULL,
  tilausaika TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  kasitelty BOOLEAN NOT NULL DEFAULT 0,
  kasittelyaika DATETIME,
  CONSTRAINT `fk_tilaus_asiakas` FOREIGN KEY (asiakas_id)
  REFERENCES asiakas(asiakasnro)
  ON DELETE RESTRICT
);
CREATE TABLE tilausrivi(
  tilaus_id INT NOT NULL,
  tuote_id INT NOT NULL,
  kpl INT NOT NULL,
  CONSTRAINT `fk_tilausrivi_tilaus` FOREIGN KEY (tilaus_id)
  REFERENCES tilaus(tilausnro),
  CONSTRAINT `fk_tilausrivi_tuote` FOREIGN KEY (tuote_id)
  REFERENCES tuote(tuotenro),
  CONSTRAINT `pk_tilausrivi` PRIMARY KEY (tilaus_id, tuote_id)
);";

$dummydataSQL = 'INSERT INTO tuoteryhma (trnimi)
VALUES ("Viherkasvit"), 
("Mehikasvit"), 
("Kaktukset"),
("Tarvikkeet");
INSERT INTO tuote (tuotenimi, tuotekuvaus, trnro, hinta)
VALUES ("Peikonlehti", "Peikonlehti kasvaa kookkaaksi kauniine, vihreine lehtineen. Komeimmillaan lehdet ovat 70x100 cm kokoiset ja niiss?? voi olla jopa 50 erikokoista reik????.Peikonlehti kasvaa kookkaaksi kauniine, vihreine lehtineen. Komeimmillaan lehdet ovat 70x100 cm kokoiset ja niiss?? voi olla jopa 50 erikokoista reik????.", 1, 19.95),
("Kultak??ynn??s", "Kultak??ynn??ksen syd??menmuotoiset vihre??t lehdet ovat valkoisella marmoroidut. V??ritys on parhaimmillaan valoisassa paikassa.", 1, 12.50),
("Kilpipiilea", "Kilpipiilea kuuluu niihin kasveihin, jotka viihtyv??t vaatimattomammissakin olosuhteissa ilman erityist?? vaivann??k????. Saat kilpipiileasi kukoistamaan pit??m??ll?? sit?? puolivarjoisassa paikassa", 1, 09.15),
("Juurakkovehka", "Alokasian (juurakkovehka) tummat lehdet vaaleine lehtisuonineen ovat kuin lohik????rmeen p??it?? pitkien varsien huippuina.", 1, 29.90),
("Jukkapalmu", "Jukkapalmu on kest??v??, helppohoitoinen ja sopeutuvainen kasvi, jolla on tummanvihre??t, ruusukemaisesti kasvavat miekkamaiset lehdet.", 1, 25.99),
("Silkkimaija", "Kasvi on marantakasvien heimoon kuuluva kasvi. Se kasvaa luontaisesti luoteisessa Brasiliassa ja sen l??hialueilla. Huonekasvina se kasvaa noin 50 cm korkeaksi.", 1, 20.00),
("Viirivehka", "Viirivehka on helppo ja yleinen viherkasvi. Sen kukinto muodostuu valkoiseksi v??rittyneest?? suojuslehdest?? ja kellanvalkeasta puikelokukasta.", 1, 25.00),
("Paavonnukkumatti", "Nukkumatti eli paavonnukkumatti on veike?? huonekasvi, joka illan tullen nostaa lehdet pystyyn ja k????nt???? ne suppuun.", 1, 13.00),
("Rahapuu", "Rahapuu on eritt??in kest??v?? ja helppohoitoinen. Se kasvaa ja kukoistaa useimmissa ymp??rist??iss??, ja tuottaa huoneilmaan runsaasti happea varsinkin ??isin.", 2, 08.50),
("Aloe vera", "Aloe vera ei vaadi hoitajaltaan paljon, ja siksi se sopiikin mainiosti my??s niille, joiden viherpeukalo kasvaa keskell?? k??mment??.", 2, 10.00),
("Anopinkieli", "Anopinkieli on ollut rakastettu huonekasvi Suomessa jo ainakin 1950-luvulta l??htien. Suosion salaisuus pilee todenn??k??isesti anopinkielen selke??n graafisessa kasvutavassa sek?? helppohoitoisuudessa. Se on kuin tehty keskusl??mmitteisiin asuntoihin, miss?? huoneen l??mp??tila pysyy samana ymp??ri vuoden.", 2, 19.90),
("Mehiruusuke", "Mehiruusukkeet ovat mehikasveja, joilla on kauniinv??riset, ruusukkeiksi ker????ntyneet lehdet. Mehiruusukkeissa on paljon lajikkeita ja vaihtoehtoja.", 2, 05.00),
("Mehipuu", "Mehipuiden paksut lehdet kasvavat kauniina ruusukkeena paljaan varren p????ss??. Lehdet ovat joko yksiv??risi?? tai niiss?? voi olla valkoisia, punaisia tai keltaisia kuvioita lajista riippuen. ", 2, 09.00),
("Nukkaitulehti", "Nukkaitulehti on helppo huonekasvi, jolla on paksut mehev??t, harmaanvihre??t lehdet.", 2, 10.00),
("Paunikko", "Paunikot ovat maksaruohoihin kuuluvia helppohoitoisia huonekasveja. Paunikot ovat kotoisin Aasiasta ja Afrikasta, suurin osa lajikkeista tulee kuitenkin Etel??-Afrikasta.", 2, 12.00),
("Marraskuunkaktus", "Marraskuunkaktus on hiukan hennompi kuin joulukaktus. Versojen k??rjet ovat halkoiset ja kasvavat pystyss??. Lehtim??iset varret ovat litte??t ja hammaslaitaiset.", 3, 23.00),
("J??n??nopuntia", "Opuntia kasvaa luonnossa hyvin kuivilla alueilla.", 3, 10.00),
("Kultasiilikaktus", "Kultasiilikaktus eli anopinjakkara. Kultasiilikaktus viihtyy kaktusten tavoin aurinkoisella ja l??mpim??ll?? kasvupaikalla.", 3, 12.00),
("Kalanruotokaktus", "N??ytt??v?? amppelikasvi.", 3, 26.90),
("Pylv??styr??kki", "Pylv??styr??kki on komea huonekasvi, joka kuuluu tyr??kkien heimoon.", 3, 30.00),
("Lapakaktus", "Helppohoitoinen lapakaktus on epifyyttinen kaktus, jolla ei ole varsinaisia piikkej??. Kaktuksen varsissa on piikkien sijaan hiusmaisia karvatuppoja. Varret ovat kulmikkaita ja vihreit??. Runsaassa auringonpaisteessa v??ri muuttuu pinkist?? kastanjanruskeaan.", 3, 19.99),
("Apinanh??nt??kaktus", "Apinanh??nt??kaktus el???? luonnossa trooppisissa metsiss??.", 3, 11.50),
("Keraaminen ruukku terrakotta", "Linjakas py??re?? ruukku italialaista terrakottaa. Halkaisija 25cm. Muista aluslautanen!", 4, 06.00),
("Keraaminen aluslautanen", "Aluslautanen terrakotta ruukulle. Italialaista k??sity??t?? suoraan Amaflin rannikolta. Tuhansia vuosia vanhoja perinteit?? noudattaen ja kest??v???? kehityst?? k??ytt??en valmistettu. Rajoitettu er??m????r??, toimi siis nopeasti ja hanki omasi!", 4, 03.00),
("Rottinkinen kukkateline", "50cm korkea kukkateline. Materiaali on kaunista rottinkia.", 4, 35.00),
("Biolan musta multa 4L", "Biolan Musta Multa on yleismulta kaikille viherkasveille ja kukkiville ruukkukasveille. Kompostoimalla kypsytetty multaseos on lannoitettu broilerinlantakompostilla ja kalkittu magnesiumpitoisella kalkkikivijauheella. Kompostoinnin ansiosta multaan muodostuu kest??v?? mururakenne.", 4, 10.00);
INSERT INTO hoitoohje (ohje, tuote_id)
VALUES ("Huoneenl??mp?? riitt???? peikonlehdelle. Lehti?? suihkutetaan. Kes??ll?? kastellaan runsaasti, eik?? multa saa kuivua talvellakaan. Lannoitetaan kerran viikossa seoslannoitteella kasvun aikana. Hauraita ilmajuuria ei saa leikata.
", 1), 
("Kultak??ynn??s viihtyy parhaiten puolivarjoisassa paikassa suojassa suoralta auringonpaisteelta. Lehtien kirjavuus on silloin voimakkaimmillaan, kun varjossa lehdet ovat vihre??mm??t. Valoisassa lehdet taas muuttuvat hyvin vaaleiksi. Kultak??ynn??st?? kastellaan kohtuudella ja pintamulta saa kuivahtaa kastelukertojen v??liss??.", 2),
("V??lt?? paikkaa, johon lankeaa suoraa auringonvaloa. Se nimitt??in kasvattaa suurempia lehti?? saadessaan niukemmin valoa. Vuoden l??mpim??mm??ll?? puoliskolla voit lannoittaa kasvia noin kahden viikon v??lein ja kastella kohtuullisesti. Multa saa kuivua kastelukertojen v??lill??.", 3), 
("Alokasia pit???? l??mm??st??, kosteudesta ja kohtalaisesta valosta. Liika kosteus voi aiheuttaa juurim??t????.", 4), 
("Kastele kohtuudella, talvella niukasti. Lannoita kahdesti kuussa kev????st?? syksyyn.", 5), 
("Ei sied?? suoraa auringonpaistetta. Se suosii korkeaa ilmankosteutta. Maijat viihtyv??t happamassa mullassa. Kasvin juuret kasvavat nopeasti t??ytt??en ruukun.", 6), 
("Kastele viirivehkaa s????nn??llisesti l??pi vuoden. Multa saa kevyesti kuivahtaa kastelujen v??lill??, mutta paha kuivuminen aiheuttaa lehtien k??rkien ruskettumista.", 7), 
("Kostea ilma saa kasvin kukoistamaan, joten nukkumattia kannattaa suihkutella ja sumutella usein.", 8), 
("Kastele rahapuuta niukasti ja varo istuttamasta sit?? liian ravinteikkaaseen multaan.", 9), 
("Helppohoitoinen kasvi siet???? hyvin kuivuutta ja altistuu ani harvoin tuholaisille tai kasvitaudeille.", 10), 
("Kastele anopinkieli?? kasvukaudella, eli maaliskuusta syyskuuhun, noin parin viikon v??lein. T??ll??in voit sekoittaa kasteluveteen nestem??ist?? lannoitetta. Kastele anopinkieli?? talvisin harvemmin. Anna mullan kuivahtaa kastelukertojen v??liss??. Jos satut unohtamaan kastelun, kasvi yleens?? toipuu t??st??, sill?? se varastoi lehtiins?? vett??.
", 11), 
("Viihtyy valoisassa paikassa. Kes??ll?? suojattava voimakkaalta auringonpaisteelta. Mehikasvit varastoivat kosteutta lehtiins?? ja voivat siksi selviyty?? parikin viikkoa ilman kastelua.", 12), 
("Sijoita mehipuut aurinkoiselle paikalla. Pyri pit??m????n kasvualusta niukan kosteana. Mehipuut varastoivat vett?? lehtiins?? ja varsiinsa, joten ne ovat herkki?? liikakastelulle. Ne kuitenkin tarvitsevat enemm??n kosteutta kuin useimmat muut mehikasvit. Lannoita kasvukaudella miedolla lannoitteella noin kerran kuukaudessa.", 13), 
("Nukkaitulehti menestyy parhaiten aurinkoisella tai puolivarjoisella kasvupaikalla. Kastelun tulee olla niukkaa, sill?? kasvi varastoi paksuihin lehtiins?? vett??.", 14),
("Paunikot menestyv??t parhaiten aurinkoisilla kasvupaikoilla, voimakkainta paahdetta tulee kuitenkin v??ltt????. Ne kastellaan kerralla runsaasti, ja sen j??lkeen mullan annetaan kuivahtaa hyvin.", 15), 
("S????nn??llinen kastelu ja lannoitus kasvukaudella huhti-elokuu sek?? kukinnan aikana, multa saa kuivahtaa.", 16), 
("kastellaan niukahkosti v??ltt??en ylikastelua, mutta kuitenkin niin, ett?? kaktus pysyy elinvoimaisena. Kes??ll?? kastelu voi olla reilumpaa, kunhan multa kuivuu kunnolla kasteluiden v??liss??.", 17), 
("Kev??isin kasvun alkaessa kultasiilikaktus suojataan paahteelta. Kun se tottuu UV-s??teilyyn v??hitellen, se kest???? kes??ll?? jo paahteenkin.", 18), 
("Sijoitetaan puolivarjoiseen tai valoisaan paikkaan, ei kuitenkaan suoraan auringonvaoon. Kastellaan harvoin, mutta kerralla kunnolla mieluiten altap??in. Pintamullan tulee kuivua ennen kastelua. Lannoitus kev????st?? syksyyn.", 19), 
("Pylv??styr??kki sijoitetaan valoisaan paikkaan. Se viihtyy normaalissa huoneenl??mm??ss??, talvella l??mp??tila voi olla viile??mpikin. Vetoista paikkaa tulee kuitenkin v??ltt????. Tyr??kki siet???? hyvin huoneilman kuivuutta.", 20), 
("Lapakaktus ei viihdy suorassa auringonpaahteessa, mutta sen kasvupaikan tulisi kuitenkin olla runsasvaloinen. Suorassa paahteessa lehdet saattavat palaa tai kellastua. P??rj???? my??s varjoisemmalla paikalla, mutta ei kuki.", 21), 
("Menestyy auringossa ja hieman varjoisemmassa kasvupaikassa.?? Kastellaan vasta kun kasvualasta on kuivunut kokonaan. V??ltett??v?? liikakastelua.", 22);
INSERT INTO tieteellinen_nimi
VALUES ("Monstera deliciosa", 1),
("Epipremnum aureum", 2),
("Pilea peperomioides", 3),
("Alocasia", 4),
("Yucca gigantea", 5),
("Calathea orbifolia", 6),
("Spathiphyllum wallisii", 7),
("Maranta leuconeura", 8),
("Crassula portulacea", 9),
("Alo?? vera", 10),
("Sansevieria trifasciata", 11),
("Purple pearl", 12),
("Aeonium", 13),
("Kalancho?? tomentosa", 14),
("Crassula hobbit", 15),
("Schlumbergera", 16),
("Opuntia microdasys", 17),
("Echinocactus grusonii", 18),
("Epiphyllum anguliger", 19),
("Euphorbia trigona", 20),
("Lepismium cruciforme", 21),
("Cleistocactus winteri", 22);
INSERT INTO asiakas (etunimi, sukunimi, osoite, postinro, postitmp, sposti)
VALUES ("Matti", "Meik??l??inen", "Matinkotikuja 3", "00001", "Meik??l??iskyl??", "matti.meikalainen@meikalainen.com"), 
("Teija", "Teik??l??inen", "Teijantorpantie 5", "00002", "Teik??l??isi??", "teija.teikalainen@teijanfirma.fi"), 
("Nakke", "Nakuttaja", "Joku Kolo Puussa", "12345", "Mett??", "nakke@nakuttaja.com");
INSERT INTO tilaus (asiakas_id, tilausaika, kasitelty)
VALUES (1, "2022-04-09 08:03:12", 0), (1, "2022-03-12 11:53:08", 1), (2, "2022-04-03 15:17:09", 0), (3, "2022-05-03 12:29:45", 0);
UPDATE tilaus SET kasittelyaika = "2022-03-15 09:34:14" WHERE tilausnro = 2;
INSERT INTO tilausrivi (tilaus_id, tuote_id, kpl)
VALUES (1, 12, 5), (1, 13, 2), (1, 1, 1), (2, 17, 3), (2, 2, 1), (3, 21, 5), (4, 5, 3), (4, 25, 2), (4, 16, 1), (4, 26, 4);';