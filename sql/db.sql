-- TUOTERYHMÄ
DROP DATABASE IF EXISTS kukkakauppa;
CREATE DATABASE kukkakauppa;
USE kukkakauppa;

DROP TABLE IF EXISTS tuoteryhma;
CREATE TABLE tuoteryhma (
    trnro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    trnimi VARCHAR(255) NOT NULL
);

-- TUOTE
DROP TABLE IF EXISTS tuote;
CREATE TABLE tuote (
    tuotenro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    tuotenimi VARCHAR(255) NOT NULL,
    tuotekuvaus TEXT,
    trnro INT,
    hinta DECIMAL(4,2),
    kuva_url VARCHAR(255),
    CONSTRAINT `fk_trnro` FOREIGN KEY (trnro) REFERENCES tuoteryhma(trnro)
);

INSERT INTO tuoteryhma (trnimi)
VALUES ("Viherkasvit"), 
("Mehikasvit"), 
("Kaktukset"),
("Tuotteet");

INSERT INTO tuote (tuotenimi, tuotekuvaus, trnro, hinta)
VALUES ("Peikonlehti", "Peikonlehti kasvaa kookkaaksi kauniine, vihreine lehtineen. Komeimmillaan lehdet ovat 70x100 cm kokoiset ja niissä voi olla jopa 50 erikokoista reikää.Peikonlehti kasvaa kookkaaksi kauniine, vihreine lehtineen. Komeimmillaan lehdet ovat 70x100 cm kokoiset ja niissä voi olla jopa 50 erikokoista reikää.", 1, 00.00),
("Kultaköynnös", "Kultaköynnöksen sydämenmuotoiset vihreät lehdet ovat valkoisella marmoroidut. Väritys on parhaimmillaan valoisassa paikassa.", 1, 00.00),
("Kilpipiilea", "Kilpipiilea kuuluu niihin kasveihin, jotka viihtyvät vaatimattomammissakin olosuhteissa ilman erityistä vaivannäköä. Saat kilpipiileasi kukoistamaan pitämällä sitä puolivarjoisassa paikassa", 1, 00.00),
("Juurakkovehka", "Alokasian (juurakkovehka) tummat lehdet vaaleine lehtisuonineen ovat kuin lohikäärmeen päitä pitkien varsien huippuina.", 1, 00.00),
("Jukkapalmu", "Jukkapalmu on kestävä, helppohoitoinen ja sopeutuvainen kasvi, jolla on tummanvihreät, ruusukemaisesti kasvavat miekkamaiset lehdet.", 1, 00.00),
("Silkkimaija", "Kasvi on marantakasvien heimoon kuuluva kasvi. Se kasvaa luontaisesti luoteisessa Brasiliassa ja sen lähialueilla. Huonekasvina se kasvaa noin 50 cm korkeaksi.", 1, 00.00),
("Viirivehka", "Viirivehka on helppo ja yleinen viherkasvi. Sen kukinto muodostuu valkoiseksi värittyneestä suojuslehdestä ja kellanvalkeasta puikelokukasta.", 1, 00.00),
("Paavonnukkumatti", "Nukkumatti eli paavonnukkumatti on veikeä huonekasvi, joka illan tullen nostaa lehdet pystyyn ja kääntää ne suppuun.", 1, 00.00),
("Rahapuu", "Rahapuu on erittäin kestävä ja helppohoitoinen. Se kasvaa ja kukoistaa useimmissa ympäristöissä, ja tuottaa huoneilmaan runsaasti happea varsinkin öisin.", 2, 00.00),
("Aloe vera", "Aloe vera ei vaadi hoitajaltaan paljon, ja siksi se sopiikin mainiosti myös niille, joiden viherpeukalo kasvaa keskellä kämmentä.", 2, 00.00),
("Anopinkieli", "Anopinkieli on ollut rakastettu huonekasvi Suomessa jo ainakin 1950-luvulta lähtien. Suosion salaisuus pilee todennäköisesti anopinkielen selkeän graafisessa kasvutavassa sekä helppohoitoisuudessa. Se on kuin tehty keskuslämmitteisiin asuntoihin, missä huoneen lämpötila pysyy samana ympäri vuoden.", 2, 00.00),
("Mehiruusuke", "Mehiruusukkeet ovat mehikasveja, joilla on kauniinväriset, ruusukkeiksi kerääntyneet lehdet. Mehiruusukkeissa on paljon lajikkeita ja vaihtoehtoja.", 2, 00.00),
("Mehipuu", "Mehipuiden paksut lehdet kasvavat kauniina ruusukkeena paljaan varren päässä. Lehdet ovat joko yksivärisiä tai niissä voi olla valkoisia, punaisia tai keltaisia kuvioita lajista riippuen. ", 2, 00.00),
("Nukkaitulehti", "Nukkaitulehti on helppo huonekasvi, jolla on paksut mehevät, harmaanvihreät lehdet.", 2, 00.00),
("Paunikko", "Paunikot ovat maksaruohoihin kuuluvia helppohoitoisia huonekasveja. Paunikot ovat kotoisin Aasiasta ja Afrikasta, suurin osa lajikkeista tulee kuitenkin Etelä-Afrikasta.", 2, 00.00),
("Marraskuunkaktus", "Marraskuunkaktus on hiukan hennompi kuin joulukaktus. Versojen kärjet ovat halkoiset ja kasvavat pystyssä. Lehtimäiset varret ovat litteät ja hammaslaitaiset.", 3, 00.00),
("Jänönopuntia", "Opuntia kasvaa luonnossa hyvin kuivilla alueilla.", 3, 00.00),
("Kultasiilikaktus", "Kultasiilikaktus eli anopinjakkara. Kultasiilikaktus viihtyy kaktusten tavoin aurinkoisella ja lämpimällä kasvupaikalla.", 3, 00.00),
("Kalanruotokaktus", "Näyttävä amppelikasvi.", 3, 00.00),
("Pylvästyräkki", "Pylvästyräkki on komea huonekasvi, joka kuuluu tyräkkien heimoon.", 3, 00.00),
("Lapakaktus", "Helppohoitoinen lapakaktus on epifyyttinen kaktus, jolla ei ole varsinaisia piikkejä. Kaktuksen varsissa on piikkien sijaan hiusmaisia karvatuppoja. Varret ovat kulmikkaita ja vihreitä. Runsaassa auringonpaisteessa väri muuttuu pinkistä kastanjanruskeaan.", 3, 00.00),
("Apinanhäntäkaktus", "Apinanhäntäkaktus elää luonnossa trooppisissa metsissä.", 3, 00.00),
("Keraaminen ruukku terrakotta", "Linjakas pyöreä ruukku italialaista terrakottaa. Halkaisija 25cm. Muista aluslautanen!", 4, 00.00),
("Keraaminen aluslautanen", "Aluslautanen terrakotta ruukulle.", 4, 00.00),
("Rottinkinen kukkateline", "50cm korkea kukkateline. Materiaali on kaunista rottinkia.", 4, 00.00),
("Biolan mustamulta 4L", "Biolan Musta Multa on yleismulta kaikille viherkasveille ja kukkiville ruukkukasveille. Kompostoimalla kypsytetty multaseos on lannoitettu broilerinlantakompostilla ja kalkittu magnesiumpitoisella kalkkikivijauheella. Kompostoinnin ansiosta multaan muodostuu kestävä mururakenne.", 4, 00.00);