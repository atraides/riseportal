@extends('layouts.app')

@section('content')
<div class="mx-auto mt-2 mb-5 news w-75 text-justify">
<h1 class="mt-5">Battle.net Bejelentkezés</h1>
 
A Guild honlap megújulásának egyik alapköve az új felhasználó kezelés. Amint azt már észre vehettétek a régi felhasználó név és jelszó kombináció eltűnt, helyét a Battle.net által nyújtott OAuth módszer vette át.

<h2 class="mt-5">OAuth mi?? Borogasd majd elmúlik!</h2>
 
Az OAuth egy nyílt szabvány engedélyezési folyamatokra. Lehetővé teszi a felhasználók számára, hogy megosszák saját adataikat egy harmadik fél számára anélkül, hogy azonosítási adataikat kiadnák.
 
Akit bővebben érdekel a téma <a href="https://hu.wikipedia.org/wiki/OAuth">ITT</a> utána olvashat a technikai részleteknek.

<h2 class="mt-5">Miért van erre szűkség</h2>
 
A Guild életének természetes része hogy tagsága változik. Vannak akik sajnos már nem játszanak velünk, vannak új tagok, vannak a nagy visszatérők vagy akik épp szünetet tartanak. 
 
Ideális esetben ezen változásokat a guild honlapja is tükrözi, elérhetővé teve ezáltal a szükséges információkat vagy éppen elrejtve azokat ha az illető annak megtekintésére már nem jogosult.
 
Eddig ennek a karban tartása a vezetőség feladata volt, amit kézzel minden egyes felhasználóra külön kellett karbantartson. Ez egy eléggé sziszifuszi meló - nem is nagyon jeleskedtünk benne :) - ami a mai eszközökkel már nagyon könnyen és biztonságosan automatizálható. Megkönnyítve evvel a vezetőség munkáját és a látogatók életét.
 
Erre a problémára kínál megoldást a Battle.net által biztosított OAuth engedélyezési folyamat.

<h2 class="mt-5">Mit jelent ez számotokra</h2>
 
Innentől kezdve nem egy külön erre a célra fenntartott felhasználó névvel és jelszóval fogtok belépni az oldalra, hanem a Battle.net által biztosított authentikáció segítségével- természetesen az authentikátort is beleértve.
 
Amennyiben hozzáférést biztosítasz a Guild számára hogy lássa a WoW profilodat akkor ahogy a Blizzard oldalán itt is látni fogod az összes karakteredet. Ezek közül pedig kiválaszthatod hogy melyik karakter jelenjen meg amikor például kommentálsz valamit.
 
Az első belépés alkalmával a Blizzard meg fogja kérdezni milyen adatokhoz akarsz hozzáférést adni a guildnek. Ahogy a képen is látjátok ebből jelenleg kettő van - WoW profil, Starcraft profil -, az alap adatokhoz mindenféle képpen hozzáférést adsz. Akkor is ha esetleg az egyéb profilokat nem engedélyezed.
 
A guild azon tagjaitól akik aktívan raidelnek velünk azt kérjük hogy a WoW profilhoz adjanak hozzáférést, mert ez alapján lesznek kezelve az esetleges szavazások és altos kérdések.
 
Ha úgy gondolod hogy többet nem akarod ezeket az adatokat megosztani velünk természetesen ezt bármikor megteheted. Erről majd kicsit részletesebben később.

<h2 class="mt-5">Milyen adataim válnak így láthatóvá</h2>

<h2 class="mt-5">a Battle.net felhasználómról</h2>
 
A Battle.net felhasználókról a Blizzard minimális mennyiségű adatot szolgáltat ki. Tulajdonképpen egy ID-n és a BattleTag-en kivül semmi mást. A lenti példában láthatjátok pontosan milyen adatokat is adnak ki:
{
    "id": 18***05,
    "battletag": "At*****s#2**4"
}
 
id: Ez az ID a Blizzard rendszerében azonosít téged és lehetővé teszi számunkra hogy meggyőződjünk róla hogy te tényleg az vagy akinek mondod magad.
battletag: Ezt azt hiszem senkinek nem kell bemutatni. A Battle.net-es friendek közé lehet vele valakit felvenni. Ezt az információt mindenképpen megosztja a Blizzard, de jelenleg mi nem tároljuk el.

<h3 class="mt-5">A WoW profilomról</h3>
 
A World of Warcraft profilban a karaktereiddel kapcsolatos publikus információkat osztja meg a Blizzard. Mint például a Karakter neve, szintje, faja, stb. Ezek mind olyan adatok amik bárki számára elérhetőek az Armoryn.
 
Az egyetlen plusz információ amihez ezáltal hozzá jutunk az a karater viszonya a többi karakterhez. Tehát tudni fogjuk hogy XYZ az ABC altja.
 
Akit érdekel bővebben itt van egy komplett példa egy felhasználó karaktereiről:
<a href="https://codebeautify.org/jsonviewer/cb002f8f">https://codebeautify.org/jsonviewer/cb002f8f</a>

<h3 class="mt-5">A Starcraft profilomrol</h3>
 
A Stracraft profilban a játékkal kapcsolatos achievementek, kapmány információk és értelemszerűen a kompetitív statisztikák találhatóak.
 
Ha gondolod megoszthatod velünk, de jelenleg semmit nem használunk ezekből.

<h2 class="mt-5">Hogyan tudom ezt visszavonni</h2>
 
Ezen jogosultságok visszavonása nagyon egyszerű. Szimplán be kell lépni a <a href="https://eu.battle.net/account/management/">Battle.net oldalra</a> és megkeresni a <b>Security Options > Authorized Applications</b> menüpontot.
 
Itt láthatható az összes olyan alkalmazás ami hozzáférhet a Battle.net adataidhoz. A listából ki kell keresni a Rise Legacy Portalt és a Remove gombbal vissza vonni a jogosultságot.
 
A jogosultság visszavonása után még eltelhet 3-5 perc mire a rendszer ténylegesen vissza vonja a jogosultságot.
 
Addig is a Guild oldalán a Karakter menüben az Account Törlése opciót választva érdemes minden adatot kitörölni a mi adatbázisunkból is. Ez automatikusan is meg fog történni 1-2 napon belül, de fő a biztonság.
 
Nem áll szándékunkban semmilyen olyan adatot tárolni amit annak tulajdonosa nem akar veluük megosztani.

<h2 class="mt-5">FAQ</h2>

<h3 class="mt-5">Evvel bárki más hozzá férhet a wow accountomhoz?</h3>
 
Nem a WoW és bármi más accountodhoz továbbra is - remélhetőleg - csak te férhetsz hozzá. A Blizzard semmi olyan adatot nem oszt meg velünk amivel be tudnánk lépni az accountodra.

<h3 class="mt-5">Láthatja bárki a bankkártya adataimat/paypal useremet</h3>
 
Nem. A Blizzard semmi ilyesmi információt nem oszt meg.

<h3 class="mt-5">Láthatja bárki az email címemet?</h3>
Nem. A Blizzard nem teszi lehetővé semmilyen módon hogy a regisztrált profilodhoz tartozó emailt megszerezzük - természetesen nem is vagyunk rá kíváncsiak :)

</div>
@endsection