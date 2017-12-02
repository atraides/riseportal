@extends('layouts.app')
@section('content')
<div class="news-bg mb-5" style="background-image: url('/storage/images/rise-battlenet-auth-xl.png');">
	<div class="h-100 contain-max">
		<div class="mt-auto font-title-large-onDark">
			Battle.net Integracio
		</div>
		<ul class="p-0 additional-details">
			<li class="font-rise-light-small-beige news-owner">June 15th by <a href="#!">Rise Legacy</a>
			<span class="ml-2 badge badge-default badge-pill">91</span>
			</li>
		</ul>
	</div>
</div>

<div class="mx-auto mt-2 mb-5 news text-justify">
A Guild honlap megújulásának egyik alapköve az új felhasználó kezelés. Amint azt már észre vehettétek a régi felhasználó név és jelszó kombináció eltűnt, helyét a Battle.net által nyújtott OAuth módszer vette át.

<h4 class="mt-5">OAuth mi?? Borogasd majd elmúlik!</h4>

<p>Az OAuth egy nyílt szabvány engedélyezési folyamatokra. Lehetővé teszi a felhasználók számára, hogy megosszák saját adataikat egy harmadik fél számára anélkül, hogy azonosítási adataikat kiadnák.</p>

<p>Akit bővebben érdekel a téma <a href="https://hu.wikipedia.org/wiki/OAuth">ITT</a> utána olvashat a technikai részleteknek.</p>
<h4 class="mt-5">Miért van erre szűkség</h4>

<p>A Guild életének természetes része hogy tagsága változik. Vannak akik sajnos már nem játszanak velünk, vannak új tagok, vannak a nagy visszatérők vagy akik épp szünetet tartanak.</p>

<p>Ideális esetben ezen változásokat a guild honlapja is tükrözi, elérhetővé téve ezáltal a szükséges információkat vagy éppen elrejtve azokat ha az illető annak megtekintésére már nem jogosult.</p>

<p>Eddig ennek a karban tartása a vezetőség feladata volt, amit kézzel minden egyes felhasználóra külön kellett karbantartson. Ez egy eléggé sziszifuszi meló - nem is nagyon jeleskedtünk benne :) - ami a mai eszközökkel már nagyon könnyen és biztonságosan automatizálható. Megkönnyítve evvel a vezetőség munkáját és a látogatók életét.</p>

<p>Erre a problémára kínál megoldást a Battle.net által biztosított OAuth engedélyezési folyamat.</p>

<h4 class="mt-5">Mit jelent ez számotokra</h4>

<p>Innentől kezdve nem egy külön erre a célra fenntartott felhasználó névvel és jelszóval fogtok belépni az oldalra, hanem a Battle.net által biztosított authentikáció segítségével- természetesen az authentikátort is beleértve.</p>

<p>Amennyiben hozzáférést biztosítasz a Guild számára hogy lássa a WoW profilodat akkor ahogy a Blizzard oldalán itt is látni fogod az összes karakteredet. Ezek közül pedig kiválaszthatod hogy melyik karakter jelenjen meg amikor például kommentálsz valamit.</p>

<p>Az első belépés alkalmával a Blizzard meg fogja kérdezni milyen adatokhoz akarsz hozzáférést adni a guildnek. Ahogy a képen is látjátok ebből jelenleg kettő van - WoW profil, Starcraft profil -, az alap adatokhoz mindenféle képpen hozzáférést adsz. Akkor is ha esetleg az egyéb profilokat nem engedélyezed.</p>

<p>A guild azon tagjaitól akik aktívan raidelnek velünk azt kérjük hogy a WoW profilhoz adjanak hozzáférést, mert ez alapján lesznek kezelve az esetleges szavazások és altos kérdések.</p>

<p>Ha úgy gondolod hogy többet nem akarod ezeket az adatokat megosztani velünk természetesen ezt bármikor megteheted. Erről majd kicsit részletesebben később.</p>

<h4 class="mt-5">Milyen adataim válnak így láthatóvá</h4> <h4 class="mt-5">a Battle.net felhasználómról</h4>

<p>A Battle.net felhasználókról a Blizzard minimális mennyiségű adatot szolgáltat ki. Tulajdonképpen egy ID-n és a BattleTag-en kivül semmi mást. A lenti példában láthatjátok pontosan milyen adatokat is adnak ki:</p>

<pre>
{
"id": 18***05,
"battletag": "At*****s#2**4"
}
</pre>

<p><b>id</b>: Ez az ID a Blizzard rendszerében azonosít téged és lehetővé teszi számunkra hogy meggyőződjünk róla hogy te tényleg az vagy akinek mondod magad.<br/>
<b>battletag</b>: Ezt azt hiszem senkinek nem kell bemutatni. A Battle.net-es friendek közé lehet vele valakit felvenni. Ezt az információt mindenképpen megosztja a Blizzard, de jelenleg mi nem tároljuk el.</p>

<h5 class="mt-5">A WoW profilomról</h5>

<p>A World of Warcraft profilban a karaktereiddel kapcsolatos publikus információkat osztja meg a Blizzard. Mint például a Karakter neve, szintje, faja, stb. Ezek mind olyan adatok amik bárki számára elérhetőek az Armoryn.</p>

<p>Az egyetlen plusz információ amihez ezáltal hozzá jutunk az a karater viszonya a többi karakterhez. Tehát tudni fogjuk hogy XYZ az ABC altja.</p>

<p>Akit érdekel bővebben itt van egy komplett példa egy felhasználó karaktereiről:
<a href="https://codebeautify.org/jsonviewer/cb002f8f">https://codebeautify.org/jsonviewer/cb002f8f</a></p>

<h5 class="mt-5">A Starcraft profilomrol</h5>

<p>A Stracraft profilban a játékkal kapcsolatos achievementek, kapmány információk és értelemszerűen a kompetitív statisztikák találhatóak.</p>

<p>Ha gondolod megoszthatod velünk, de jelenleg semmit nem használunk ezekből.</p>

<h4 class="mt-5">Hogyan tudom ezt visszavonni</h4>

<p>Ezen jogosultságok visszavonása nagyon egyszerű. Szimplán be kell lépni a <a href="https://eu.battle.net/account/management/">Battle.net oldalra</a> és megkeresni a <b>Security Options &gt; Authorized Applications</b> menüpontot.</p>

<p>Itt láthatható az összes olyan alkalmazás ami hozzáférhet a Battle.net adataidhoz. A listából ki kell keresni a Rise Legacy Portalt és a Remove gombbal vissza vonni a jogosultságot.</p>

<p>A jogosultság visszavonása után még eltelhet 3-5 perc mire a rendszer ténylegesen vissza vonja a jogosultságot.</p>

<p>Addig is a Guild oldalán a Karakter menüben az Account Törlése opciót választva érdemes minden adatot kitörölni a mi adatbázisunkból is. Ez automatikusan is meg fog történni 1-2 napon belül, de fő a biztonság.</p>

<p>Nem áll szándékunkban semmilyen olyan adatot tárolni amit annak tulajdonosa nem akar veluük megosztani.</p>

<h4 class="mt-5">FAQ</h4>

<h5 class="mt-5">Evvel bárki más hozzá férhet a wow accountomhoz?</h5>
<p>Nem a WoW és bármi más accountodhoz továbbra is - remélhetőleg - csak te férhetsz hozzá. A Blizzard semmi olyan adatot nem oszt meg velünk amivel be tudnánk lépni az accountodra.</p>

<h5 class="mt-5">Láthatja bárki a bankkártya adataimat/paypal useremet</h5>
<p>Nem. A Blizzard semmi ilyesmi információt nem oszt meg.</p>

<h5 class="mt-5">Láthatja bárki az email címemet?</h5>
<p>Nem. A Blizzard nem teszi lehetővé semmilyen módon hogy a regisztrált profilodhoz tartozó emailt megszerezzük - természetesen nem is vagyunk rá kíváncsiak :)</p>

</div>
@endsection