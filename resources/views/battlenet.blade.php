@extends('layouts.app')

@section('content')
<div class="mx-auto mt-2 news w-75 text-justify">
<h1 class="mt-5">Battle.net Bejelentkezes</h1>

A Guild honlap megujjulasanak egyik alapkove az uj felhasznalo kezeles. Amint azt mar eszre vehettetek a regi felhasznalonev es jelszo kombinacio eltunt es a helyet a Battle.net altal nyujtott OAuth modszer vette.

<h2 class="mt-5">OAuth mi?? Borogasd majd elmulik!</h2>

Az OAuth egy nyílt szabvány engedélyezési folyamatokra. Lehetővé teszi a felhasználók számára, hogy megosszák saját adataikat egy harmadik fél számára anélkül, hogy azonosítási adataikat kiadnák.

Akit bovebben erdekel a tema <a href="https://hu.wikipedia.org/wiki/OAuth">ITT</a> utana olvashat bovebben.

<h2 class="mt-5">Miert van erre szukseg</h2>

A Guild eletenek termesztes resze hogy a tagok ossztetele valtozik. Vannak akik sajnos mar nem jatszanak velunk, vannak uj tagok, vannak a nagy visszaterok es termeszetesen akik epp szuntetet tartanak. 

Idealis esetben ezen valtozasokat a guild honlapja is tukrozi, elerheto teve ezaltal a szukseges informaciokat vagy eppen elrejtve azokat ha az illeto annak megtekintesere mar nem jogosult.

Eddig ennek a karbantartasa a Vezetoseg feladata volt, amit kezzel minden egyes felhasznalora kulon kelett karbantartson. Ez egy elegge sziszifuszi melo - nem is nagyon jeleskedtunk benne :) - ami a mai eszkozokkel mar nagyon konnyen es biztonsagosan automatizalhato. Megkonnyitve evvel a Vezetoseg munkalyat es a Latogatok elet.

Erre a problemara kinal megoldast a Battle.net altal biztositott OAuth engedelyezesi folyamat.

<h2 class="mt-5">Mit jelent ez szamotokra</h2>

Innentol kezdve nem egy kulon erre a celra fenntartott felhasznalo nevvel es jelszoval fogtok belepni az oldalra, hanem a Blizzard oldalan az ottani adatokkal - termeszetesen az autentikatort is bele ertve.

Amenyibben hozza ferest biztositasz a Guild szamara hogy lassa a WoW profilodat akkor ahogy a Blizzard oldalan itt is latni fogod az osszes karateredet. Ezek kozul pedig kivalaszthatod hogy melyik karakter jelenjen meg amikor peldaul kommentelsz valamit.

Az elso belepes alkalmaval a Blizzard meg fogja kerdezni milyen adatokhoz akarsz hozzaferest adni a guildnek. Ahogy akepen is latjatok ebbol jelenleg kett van - WoW profil, Starcraft profil -, az alap adatokhoz mindenfele keppen hozza ferest adsz. Akkor is ha esetleg az egyeb profilokat nem engedelyezed.

A guild azon tagjaitol akik aktivan raidelnek velunk azt kerjuk hogy a WoW profilhoz adjanak hozzaferest, mert ez alapjan lesznek kezelve az esetleges szavazasok es altos kerdesek.

Ha ugy gondolod hogy tobbet nem akarod ezeket az adatokat megosztani veelunk termeszetesen ezt barmikor meg teheted. Errol majd kicsit reszletesebben kesobb.

<h2 class="mt-5">Milyen adataim valnak igy lathatova</h2>

<h3 class="mt-5">A Battle.net felhasznalomrol</h3>

A Battle.net felszahanalokrol a Blizzard minimalis mennyisegu adatot szolgaltat ki. Tulajdonkeppen egy ID-n es a BattleTag-en kivul semmi mast. A lenti peldaban lathatjatok pontosan milyen adatokat is adnak ki:
{
    "id": 18***05,
    "battletag": "At*****s#2**4"
}

id: Ez az ID a blizzard rendszereben azonist teged es lehetove teszi szamunkra hogy meggyozodjunk rola hogy te telleg az vagy akinek mondod magad.
battletag: Ezt asszem senkinek nem kell bemutatni. A Battle.net-es friendek koze lehet vele valakit felvenni. Ezt az informaciot mindenkeppen megosztja a Blizzard, de jelenleg mi nem taroljuk el.

<h3 class="mt-5">A WoW profilomrol</h3>

A World of Warcraft profilban a karaktereiddel kapcsolatos publikus informaciokat osztja meg a Blizzard. Mint peldaul a Karakter neve, szintje, faja, stb. Ezek mind olyan adatok amik barki szamara elerhetok az Armoryn.

Az egyetlen plussz informacio amihez ezaltal hozza jutunk az a karater viszonya a tobbi karakterhez. Tehat tudni fogjuk hogy XYZ az Joskapista altja.

Akit erdekel bovebben itt van egy komplett pelda egy felhasznalo karaktereirol:
<a href="https://codebeautify.org/jsonviewer/cb002f8f">https://codebeautify.org/jsonviewer/cb002f8f</a>

<h3 class="mt-5">A Starcraft profilomrol</h3>

A Stracraft profilban a jatekkal kapcsolatos achievementek, kapmany informaciok es ertelemszeruen a kompetitiv statisztikak talalhatok.

Ha gondolod megoszthatod velunk, de jelenleg semmit nem hasznalunk ezekbol.
<h2 class="mt-5">Hogyan tudom ezt visszavonni</h2>

Ezen jogosultsagok visszavonasa nagyon egyszeru. Szimplan be kell lepni a <a href="https://eu.battle.net/account/management/">Battle.net oldalra</a> es megkeresni a Security Options > Authorized Applications menupontot.

Itt lathathato az osszes olyan alkalmazas akik hozzaferhetnek a Battle.net adataidhoz. A listabol ki kell keresni a Rise Legacy Portalt es a Remove gombbal vissza vonni a jogosultsagot.

A jogosultsag visszavonasa utan meg eltelhet 3-5 perc mire a rendszer tenylegesen vissza vonja a jogosultsagot.

Addig is a Guild oldalan a Karakter menuben az Account Torlese opciot valasztva erdemes minden adatot kitorolni a mi adatbazisunkbol is. Ez automatikusan is meg fog tortenik 1-2 napon belul, de fo a biztonsag.

Nem all szandekunkban semmilyen olyan adatot tarolni amit annak tulajdonosa nem akar velunk megosztani.
<h2 class="mt-5">FAQ</h2>

<h3 class="mt-5">Evval barki mas hozza ferhet a wow accountomhoz</h3>

Nem a WoW es barmi mas accountodhoz tovabbra is - remelhetoleg - csak te ferhersz hozza. A Blizzard semmi olyan adatot nem oszt meg velunk amivel be tudnank lepni az accountodra.

<h3 class="mt-5">Lathatja barki a bankkartya adataimat/paypal useremet</h3>

Termesztesen nem. A Blizzard semmi ilyesmi informaciot nem oszt meg.

<h3 class="mt-5">Lathatja barki az email cimemet?</h3>

Nem. A Blizzard nem teszi lehetove semmilyen modon hogy a regisztralt profilodhoz tartozo emailt megszerezzuk - termesztesen nem is vagyunk ra kivancsiak. :)
</div>
@endsection