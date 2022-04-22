-- TIETOKANNAN LUONTI
DROP DATABASE IF EXISTS kukkakauppa;
CREATE DATABASE kukkakauppa;
USE kukkakauppa;

-- TUOTERYHMÄ-TAULUN LUONTI
CREATE TABLE tuoteryhma (
    trnro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    trnimi VARCHAR(255) NOT NULL
);

-- UUTIS-TAULUN LUONTI
CREATE TABLE uutiset (
    id INT NOT NULL, PRIMARY KEY,
    otsikko VARCHAR(150) NOT NULL,
    pvm VARCHAR(100) NOT NULL,
    viesti VARCHAR(10000) NOT NULL
);

-- TUOTE-TAULUN LUONTI
CREATE TABLE tuote (
    tuotenro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    tuotenimi VARCHAR(255) NOT NULL,
    tuotekuvaus TEXT,
    trnro INT,
    hinta DECIMAL(4,2),
    CONSTRAINT `fk_trnro` FOREIGN KEY (trnro) REFERENCES tuoteryhma(trnro)
);

-- HOITOOHJE-TAULUN LUONTI
CREATE TABLE hoitoohje (
    ohjenro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    ohje TEXT NOT NULL,
    tuote_id INT,
    CONSTRAINT `fk_tuote_id` FOREIGN KEY (tuote_id) REFERENCES tuote(tuotenro)
);

-- TIETEELLINEN_NIMI-TAULUN LUONTI
CREATE TABLE tieteellinen_nimi (
    tieteellinen_nimi VARCHAR(255) NOT NULL,
    tuote_id INT,
    CONSTRAINT `fk_tuote_tieteellinen_id` FOREIGN KEY (tuote_id) REFERENCES tuote(tuotenro)
);

-- ASIAKAS-TAULUN LUONTI
CREATE TABLE asiakas(
    asiakasnro INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    etunimi VARCHAR(50) NOT NULL,
    sukunimi VARCHAR(50) NOT NULL,
    osoite VARCHAR(50) NOT NULL,
    postinro VARCHAR(50) NOT NULL,
    postitmp VARCHAR(50) NOT NULL,
    sposti VARCHAR(50) NOT NULL
);

-- TUNNUS-TAULUN LUONTI
CREATE TABLE tunnus(
    ktunnus VARCHAR(50) NOT NULL PRIMARY KEY,
    asiakasnro INT,
    admincheck BOOLEAN,
    salasana VARCHAR(50),
    CONSTRAINT `fk_tunnus_asiakas` FOREIGN KEY (asiakasnro) REFERENCES asiakas(asiakasnro)
    ON DELETE RESTRICT
);

-- TILAUS-TAULUN LUONTI
DROP TABLE IF EXISTS tilaus;
CREATE TABLE tilaus(
    tilausnro INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    asiakas_id INT NOT NULL,
    tilausaika TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    kasitelty BOOLEAN NOT NULL DEFAULT 0,
    CONSTRAINT `fk_tilaus_asiakas` FOREIGN KEY (asiakas_id)
    REFERENCES asiakas(asiakasnro)
    ON DELETE RESTRICT
);

-- TILAUSRIVI-TAULUN LUONTI
CREATE TABLE tilausrivi(
    tilaus_id INT NOT NULL,
    tuote_id INT NOT NULL,
    kpl INT NOT NULL,
    CONSTRAINT `fk_tilausrivi_tilaus` FOREIGN KEY (tilaus_id)
    REFERENCES tilaus(tilausnro),
    CONSTRAINT `fk_tilausrivi_tuote` FOREIGN KEY (tuote_id)
    REFERENCES tuote(tuotenro),
    CONSTRAINT `pk_tilausrivi` PRIMARY KEY (tilaus_id, tuote_id)
);

-- TUOTERYHMÄ -> ALOITUSDATAN SYÖTTÖ
INSERT INTO tuoteryhma (trnimi)
VALUES ("Viherkasvit"), 
("Mehikasvit"), 
("Kaktukset"),
("Tarvikkeet");

-- TUOTE -> ALOITUSDATAN SYÖTTÖ
INSERT INTO tuote (tuotenimi, tuotekuvaus, trnro, hinta)
VALUES ("Peikonlehti", "Peikonlehti kasvaa kookkaaksi kauniine, vihreine lehtineen. Komeimmillaan lehdet ovat 70x100 cm kokoiset ja niissä voi olla jopa 50 erikokoista reikää.Peikonlehti kasvaa kookkaaksi kauniine, vihreine lehtineen. Komeimmillaan lehdet ovat 70x100 cm kokoiset ja niissä voi olla jopa 50 erikokoista reikää.", 1, 19.95),
("Kultaköynnös", "Kultaköynnöksen sydämenmuotoiset vihreät lehdet ovat valkoisella marmoroidut. Väritys on parhaimmillaan valoisassa paikassa.", 1, 12.50),
("Kilpipiilea", "Kilpipiilea kuuluu niihin kasveihin, jotka viihtyvät vaatimattomammissakin olosuhteissa ilman erityistä vaivannäköä. Saat kilpipiileasi kukoistamaan pitämällä sitä puolivarjoisassa paikassa", 1, 09.15),
("Juurakkovehka", "Alokasian (juurakkovehka) tummat lehdet vaaleine lehtisuonineen ovat kuin lohikäärmeen päitä pitkien varsien huippuina.", 1, 29.90),
("Jukkapalmu", "Jukkapalmu on kestävä, helppohoitoinen ja sopeutuvainen kasvi, jolla on tummanvihreät, ruusukemaisesti kasvavat miekkamaiset lehdet.", 1, 25.99),
("Silkkimaija", "Kasvi on marantakasvien heimoon kuuluva kasvi. Se kasvaa luontaisesti luoteisessa Brasiliassa ja sen lähialueilla. Huonekasvina se kasvaa noin 50 cm korkeaksi.", 1, 20.00),
("Viirivehka", "Viirivehka on helppo ja yleinen viherkasvi. Sen kukinto muodostuu valkoiseksi värittyneestä suojuslehdestä ja kellanvalkeasta puikelokukasta.", 1, 25.00),
("Paavonnukkumatti", "Nukkumatti eli paavonnukkumatti on veikeä huonekasvi, joka illan tullen nostaa lehdet pystyyn ja kääntää ne suppuun.", 1, 13.00),
("Rahapuu", "Rahapuu on erittäin kestävä ja helppohoitoinen. Se kasvaa ja kukoistaa useimmissa ympäristöissä, ja tuottaa huoneilmaan runsaasti happea varsinkin öisin.", 2, 08.50),
("Aloe vera", "Aloe vera ei vaadi hoitajaltaan paljon, ja siksi se sopiikin mainiosti myös niille, joiden viherpeukalo kasvaa keskellä kämmentä.", 2, 10.00),
("Anopinkieli", "Anopinkieli on ollut rakastettu huonekasvi Suomessa jo ainakin 1950-luvulta lähtien. Suosion salaisuus pilee todennäköisesti anopinkielen selkeän graafisessa kasvutavassa sekä helppohoitoisuudessa. Se on kuin tehty keskuslämmitteisiin asuntoihin, missä huoneen lämpötila pysyy samana ympäri vuoden.", 2, 19.90),
("Mehiruusuke", "Mehiruusukkeet ovat mehikasveja, joilla on kauniinväriset, ruusukkeiksi kerääntyneet lehdet. Mehiruusukkeissa on paljon lajikkeita ja vaihtoehtoja.", 2, 05.00),
("Mehipuu", "Mehipuiden paksut lehdet kasvavat kauniina ruusukkeena paljaan varren päässä. Lehdet ovat joko yksivärisiä tai niissä voi olla valkoisia, punaisia tai keltaisia kuvioita lajista riippuen. ", 2, 09.00),
("Nukkaitulehti", "Nukkaitulehti on helppo huonekasvi, jolla on paksut mehevät, harmaanvihreät lehdet.", 2, 10.00),
("Paunikko", "Paunikot ovat maksaruohoihin kuuluvia helppohoitoisia huonekasveja. Paunikot ovat kotoisin Aasiasta ja Afrikasta, suurin osa lajikkeista tulee kuitenkin Etelä-Afrikasta.", 2, 12.00),
("Marraskuunkaktus", "Marraskuunkaktus on hiukan hennompi kuin joulukaktus. Versojen kärjet ovat halkoiset ja kasvavat pystyssä. Lehtimäiset varret ovat litteät ja hammaslaitaiset.", 3, 23.00),
("Jänönopuntia", "Opuntia kasvaa luonnossa hyvin kuivilla alueilla.", 3, 10.00),
("Kultasiilikaktus", "Kultasiilikaktus eli anopinjakkara. Kultasiilikaktus viihtyy kaktusten tavoin aurinkoisella ja lämpimällä kasvupaikalla.", 3, 12.00),
("Kalanruotokaktus", "Näyttävä amppelikasvi.", 3, 26.90),
("Pylvästyräkki", "Pylvästyräkki on komea huonekasvi, joka kuuluu tyräkkien heimoon.", 3, 30.00),
("Lapakaktus", "Helppohoitoinen lapakaktus on epifyyttinen kaktus, jolla ei ole varsinaisia piikkejä. Kaktuksen varsissa on piikkien sijaan hiusmaisia karvatuppoja. Varret ovat kulmikkaita ja vihreitä. Runsaassa auringonpaisteessa väri muuttuu pinkistä kastanjanruskeaan.", 3, 19.99),
("Apinanhäntäkaktus", "Apinanhäntäkaktus elää luonnossa trooppisissa metsissä.", 3, 11.50),
("Keraaminen ruukku terrakotta", "Linjakas pyöreä ruukku italialaista terrakottaa. Halkaisija 25cm. Muista aluslautanen!", 4, 06.00),
("Keraaminen aluslautanen", "Aluslautanen terrakotta ruukulle.", 4, 03.00),
("Rottinkinen kukkateline", "50cm korkea kukkateline. Materiaali on kaunista rottinkia.", 4, 35.00),
("Biolan musta multa 4L", "Biolan Musta Multa on yleismulta kaikille viherkasveille ja kukkiville ruukkukasveille. Kompostoimalla kypsytetty multaseos on lannoitettu broilerinlantakompostilla ja kalkittu magnesiumpitoisella kalkkikivijauheella. Kompostoinnin ansiosta multaan muodostuu kestävä mururakenne.", 4, 10.00);

-- HOITOOHJE -> ALOITUSDATAN SYÖTTÖ
INSERT INTO hoitoohje (ohje, tuote_id)
VALUES ("Huoneenlämpö riittää peikonlehdelle. Lehtiä suihkutetaan. Kesällä kastellaan runsaasti, eikä multa saa kuivua talvellakaan. Lannoitetaan kerran viikossa seoslannoitteella kasvun aikana. Hauraita ilmajuuria ei saa leikata.
", 1), 
("Kultaköynnös viihtyy parhaiten puolivarjoisassa paikassa suojassa suoralta auringonpaisteelta. Lehtien kirjavuus on silloin voimakkaimmillaan, kun varjossa lehdet ovat vihreämmät. Valoisassa lehdet taas muuttuvat hyvin vaaleiksi. Kultaköynnöstä kastellaan kohtuudella ja pintamulta saa kuivahtaa kastelukertojen välissä.", 2),
("Vältä paikkaa, johon lankeaa suoraa auringonvaloa. Se nimittäin kasvattaa suurempia lehtiä saadessaan niukemmin valoa. Vuoden lämpimämmällä puoliskolla voit lannoittaa kasvia noin kahden viikon välein ja kastella kohtuullisesti. Multa saa kuivua kastelukertojen välillä.", 3), 
("Alokasia pitää lämmöstä, kosteudesta ja kohtalaisesta valosta. Liika kosteus voi aiheuttaa juurimätää.", 4), 
("Kastele kohtuudella, talvella niukasti. Lannoita kahdesti kuussa keväästä syksyyn.", 5), 
("Ei siedä suoraa auringonpaistetta. Se suosii korkeaa ilmankosteutta. Maijat viihtyvät happamassa mullassa. Kasvin juuret kasvavat nopeasti täyttäen ruukun.", 6), 
("Kastele viirivehkaa säännöllisesti läpi vuoden. Multa saa kevyesti kuivahtaa kastelujen välillä, mutta paha kuivuminen aiheuttaa lehtien kärkien ruskettumista.", 7), 
("Kostea ilma saa kasvin kukoistamaan, joten nukkumattia kannattaa suihkutella ja sumutella usein.", 8), 
("Kastele rahapuuta niukasti ja varo istuttamasta sitä liian ravinteikkaaseen multaan.", 9), 
("Helppohoitoinen kasvi sietää hyvin kuivuutta ja altistuu ani harvoin tuholaisille tai kasvitaudeille.", 10), 
("Kastele anopinkieliä kasvukaudella, eli maaliskuusta syyskuuhun, noin parin viikon välein. Tällöin voit sekoittaa kasteluveteen nestemäistä lannoitetta. Kastele anopinkieliä talvisin harvemmin. Anna mullan kuivahtaa kastelukertojen välissä. Jos satut unohtamaan kastelun, kasvi yleensä toipuu tästä, sillä se varastoi lehtiinsä vettä.
", 11), 
("Viihtyy valoisassa paikassa. Kesällä suojattava voimakkaalta auringonpaisteelta. Mehikasvit varastoivat kosteutta lehtiinsä ja voivat siksi selviytyä parikin viikkoa ilman kastelua.", 12), 
("Sijoita mehipuut aurinkoiselle paikalla. Pyri pitämään kasvualusta niukan kosteana. Mehipuut varastoivat vettä lehtiinsä ja varsiinsa, joten ne ovat herkkiä liikakastelulle. Ne kuitenkin tarvitsevat enemmän kosteutta kuin useimmat muut mehikasvit. Lannoita kasvukaudella miedolla lannoitteella noin kerran kuukaudessa.", 13), 
("Nukkaitulehti menestyy parhaiten aurinkoisella tai puolivarjoisella kasvupaikalla. Kastelun tulee olla niukkaa, sillä kasvi varastoi paksuihin lehtiinsä vettä.", 14),
("Paunikot menestyvät parhaiten aurinkoisilla kasvupaikoilla, voimakkainta paahdetta tulee kuitenkin välttää. Ne kastellaan kerralla runsaasti, ja sen jälkeen mullan annetaan kuivahtaa hyvin.", 15), 
("Säännöllinen kastelu ja lannoitus kasvukaudella huhti-elokuu sekä kukinnan aikana, multa saa kuivahtaa.", 16), 
("kastellaan niukahkosti välttäen ylikastelua, mutta kuitenkin niin, että kaktus pysyy elinvoimaisena. Kesällä kastelu voi olla reilumpaa, kunhan multa kuivuu kunnolla kasteluiden välissä.", 17), 
("Keväisin kasvun alkaessa kultasiilikaktus suojataan paahteelta. Kun se tottuu UV-säteilyyn vähitellen, se kestää kesällä jo paahteenkin.", 18), 
("Sijoitetaan puolivarjoiseen tai valoisaan paikkaan, ei kuitenkaan suoraan auringonvaoon. Kastellaan harvoin, mutta kerralla kunnolla mieluiten altapäin. Pintamullan tulee kuivua ennen kastelua. Lannoitus keväästä syksyyn.", 19), 
("Pylvästyräkki sijoitetaan valoisaan paikkaan. Se viihtyy normaalissa huoneenlämmössä, talvella lämpötila voi olla viileämpikin. Vetoista paikkaa tulee kuitenkin välttää. Tyräkki sietää hyvin huoneilman kuivuutta.", 20), 
("Lapakaktus ei viihdy suorassa auringonpaahteessa, mutta sen kasvupaikan tulisi kuitenkin olla runsasvaloinen. Suorassa paahteessa lehdet saattavat palaa tai kellastua. Pärjää myös varjoisemmalla paikalla, mutta ei kuki.", 21), 
("Menestyy auringossa ja hieman varjoisemmassa kasvupaikassa. Kastellaan vasta kun kasvualasta on kuivunut kokonaan. Vältettävä liikakastelua.", 22);

-- TIETEELLINEN NIMI -> ALOITUSDATAN SYÖTTÖ
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
("Aloë vera", 10),
("Sansevieria trifasciata", 11),
("Purple pearl", 12),
("Aeonium", 13),
("Kalanchoë tomentosa", 14),
("Crassula hobbit", 15),
("Schlumbergera", 16),
("Opuntia microdasys", 17),
("Echinocactus grusonii", 18),
("Epiphyllum anguliger", 19),
("Euphorbia trigona", 20),
("Lepismium cruciforme", 21),
("Cleistocactus winteri", 22);