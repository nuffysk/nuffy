@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Zásady ochrany osobných údajov</h1>
        <p class="mt-1 text-sm text-muted-foreground">Komunitná platforma pre milovníkov psov · Platnosť od 20. 5. 2026</p>

        <article class="prose-sm mt-4 space-y-3 text-sm leading-relaxed text-foreground">
            <p class="italic">V súlade s nariadením GDPR (EÚ) 2016/679</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Prevádzkovateľ:</strong> cari s.r.o., IČO: 56 427 565</li>
                <li><strong>Webová stránka:</strong> https://nuffy.sk</li>
                <li><strong>Kontakt – GDPR:</strong> nuffy@nuffy.sk</li>
                <li><strong>Platnosť od:</strong> 20. 5. 2026</li>
            </ul>

            <h2 class="font-display text-lg font-semibold mt-6">1. Úvod a rozsah týchto zásad</h2>
            <p>Tieto Zásady ochrany osobných údajov (ďalej len „Zásady") vysvetľujú, ako webová stránka nuffy.sk (ďalej len „Platforma", alebo nuffy.sk) zhromažďuje, spracúva, uchováva a chráni osobné údaje svojich používateľov. Zásady sú vypracované v súlade s Nariadením Európskeho parlamentu a Rady (EÚ) 2016/679 o ochrane fyzických osôb pri spracúvaní osobných údajov a o voľnom pohybe takýchto údajov (ďalej len „GDPR"), ako aj v súlade so zákonom č. 18/2018 Z. z. o ochrane osobných údajov v znení neskorších predpisov.</p>
            <p>nuffy.sk je komunitná sociálna platforma určená pre milovníkov psov, kde si registrovaní používatelia môžu vytvoriť profil pre seba a svojho psa, nadväzovať priateľstvá, diskutovať na fóre, zdieľať fotografie a odkazovať na externé sociálne siete. Vzhľadom na charakter Platformy sú spracúvané osobné údaje fyzických osôb, vrátane citlivejších kategórií informácií (napr. poloha, dátum narodenia), a preto pristupujeme k ochrane súkromia s maximálnou zodpovednosťou.</p>
            <p>Tieto Zásady sa vzťahujú na:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>všetkých registrovaných používateľov Platformy,</li>
                <li>návštevníkov webovej stránky nuffy.sk,</li>
                <li>všetky osobné údaje spracúvané prostredníctvom Platformy alebo v súvislosti s ňou.</li>
            </ul>
            <p>Pred použitím Platformy si tieto Zásady dôkladne prečítajte. Registráciou a používaním Platformy potvrdzujete, že ste si Zásady prečítali a rozumiete im. Súhlas so spracovaním osobných údajov, kde je vyžadovaný, udeľujete výslovne a informovane pri registrácii, prípadne pri konkrétnej funkcii Platformy.</p>

            <h2 class="font-display text-lg font-semibold mt-6">2. Identifikácia prevádzkovateľa</h2>
            <p>Prevádzkovateľom osobných údajov v zmysle čl. 4 ods. 7 GDPR je:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Obchodné meno:</strong> cari s. r. o.</li>
                <li><strong>IČO:</strong> 56 427 565</li>
                <li><strong>Sídlo / adresa:</strong> Boženy Němcovej 962/26, 990 01 Veľký Krtíš, Slovenská republika; zapísaná v Obchodnom registri Okresného súdu Banská Bystrica, oddiel Sro, vložka č. 49988/S</li>
                <li><strong>E-mail (GDPR):</strong> nuffy@nuffy.sk</li>
                <li><strong>Webová stránka:</strong> https://nuffy.sk</li>
            </ul>
            <p>Prevádzkovateľ zodpovedá za zákonnosť spracúvania osobných údajov a za plnenie všetkých povinností vyplývajúcich z GDPR a zákona č. 18/2018 Z. z. Prevádzkovateľ môže v prípade potreby ustanoviť zodpovednú osobu (DPO – Data Protection Officer). Informácia o DPO, ak bude ustanovená, bude zverejnená na stránke www.nuffy.sk.</p>

            <h2 class="font-display text-lg font-semibold mt-6">3. Kategórie spracúvaných osobných údajov</h2>
            <p>Na Platforme nuffy.sk spracúvame nasledujúce kategórie osobných údajov v závislosti od toho, ako Platformu používate:</p>

            <h3 class="font-display text-base font-semibold mt-4">3.1 Identifikačné a registračné údaje</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>Meno a priezvisko alebo prezývka (nick),</li>
                <li>e-mailová adresa,</li>
                <li>heslo (uložené výhradne v hashovanej podobe, nikdy v čitateľnej forme),</li>
                <li>dátum a čas registrácie,</li>
                <li>unikátny identifikátor používateľského účtu.</li>
            </ul>

            <h3 class="font-display text-base font-semibold mt-4">3.2 Profilové a biografické údaje</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>Fotografický avatar / profilová fotografia,</li>
                <li>text „O mne" – bio (osobný opis, záujmy, informácie, ktoré sa používateľ rozhodne zdieľať),</li>
                <li>dátum narodenia (rok, mesiac, deň) – slúži na overenie veku a prípadné personalizované funkcie,</li>
                <li>pohlavie (voliteľné),</li>
                <li>odkaz na Instagram profil (voliteľný).</li>
            </ul>

            <h3 class="font-display text-base font-semibold mt-4">3.3 Lokalizačné a geografické údaje</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>Mesto alebo obec bydliska (zadávané manuálne používateľom),</li>
                <li>geografická poloha (voliteľná – len ak používateľ výslovne súhlasí s jej zdieľaním prostredníctvom nastavení prehliadača alebo zariadenia),</li>
                <li>krajina a región (odvodené z mesta alebo IP adresy).</li>
            </ul>

            <h3 class="font-display text-base font-semibold mt-4">3.4 Údaje o psovi</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>Meno psa,</li>
                <li>plemeno, vek, pohlavie psa,</li>
                <li>fotografie psa (fotografie nahraté používateľom),</li>
                <li>opis / bio psa (text zadaný používateľom),</li>
                <li>zdravotné poznámky alebo iné informácie o psovi (voliteľné, zadávané samotným používateľom).</li>
            </ul>
            <p class="italic">Poznámka: Informácie o psovi nepredstavujú osobné údaje v zmysle GDPR (týkajú sa zvieraťa, nie fyzickej osoby). Napriek tomu ich spracúvame s rovnakou starostlivosťou, pretože sú prepojené s profilom konkrétneho používateľa.</p>

            <h3 class="font-display text-base font-semibold mt-4">3.5 Komunikačné a interakčné údaje</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>Súkromné správy zasielané medzi používateľmi (obsah, odosielateľ, príjemca, čas),</li>
                <li>žiadosti o priateľstvo a zoznam priateľov (kontaktov),</li>
                <li>príspevky, komentáre a reakcie na fóre (text, čas, IP adresa pri uverejnení),</li>
                <li>nahlásenia obsahu (informácia o nahlásenom príspevku a dôvode nahlásenia).</li>
            </ul>

            <h3 class="font-display text-base font-semibold mt-4">3.6 Technické a prevádzkové údaje</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>IP adresa pri prihlásení a aktívnych reláciách,</li>
                <li>typ a verzia webového prehliadača,</li>
                <li>operačný systém zariadenia,</li>
                <li>čas a trvanie relácie,</li>
                <li>záznamy o aktivitách (logy) – pre bezpečnostné a diagnostické účely,</li>
                <li>súbory cookies a podobné sledovacie technológie (podrobne pozri časť 10).</li>
            </ul>

            <h3 class="font-display text-base font-semibold mt-4">3.7 Platobné údaje (ak sú relevantné)</h3>
            <p>Ak Platforma v budúcnosti zaviedla platené funkcie, platobné údaje (číslo karty, fakturačné údaje) sú spracúvané výhradne prostredníctvom certifikovaného platobného procesora a prevádzkovateľ k nim nemá priamy prístup. Tieto zásady budú aktualizované pri zavedení platených funkcií.</p>

            <h2 class="font-display text-lg font-semibold mt-6">4. Účely spracúvania a právne základy</h2>
            <p>Každé spracúvanie osobných údajov je podložené konkrétnym právnym základom podľa čl. 6 GDPR. Prehľad účelov a príslušných právnych základov:</p>
            <div class="overflow-x-auto">
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-border">
                            <th class="text-left p-2">Účel spracúvania</th>
                            <th class="text-left p-2">Právny základ (čl. 6 GDPR)</th>
                            <th class="text-left p-2">Doba uchovávania</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ([
                            ['Registrácia a správa používateľského účtu', 'čl. 6 ods. 1 písm. b) – plnenie zmluvy (Podmienky používania)', 'Po dobu trvania účtu + 3 roky po vymazaní'],
                            ['Poskytovanie funkcií Platformy (profil, fórum, priatelia, správy)', 'čl. 6 ods. 1 písm. b) – plnenie zmluvy', 'Po dobu aktívneho účtu'],
                            ['Overenie veku (dátum narodenia)', 'čl. 6 ods. 1 písm. c) – zákonná povinnosť; prípadne písm. b)', 'Po dobu trvania účtu'],
                            ['Zobrazenie polohy a mesta na profile (verejné / komunitné)', 'čl. 6 ods. 1 písm. a) – súhlas používateľa', 'Do odvolania súhlasu alebo vymazania účtu'],
                            ['Zdieľanie odkazu na Instagram', 'čl. 6 ods. 1 písm. a) – súhlas / písm. b) – zmluva (voliteľné)', 'Do odstránenia odkazu alebo vymazania účtu'],
                            ['Zasielanie systémových notifikácií (žiadosti o priateľstvo, odpovede na fóre)', 'čl. 6 ods. 1 písm. b) – plnenie zmluvy', 'Po dobu trvania účtu'],
                            ['Bezpečnosť, prevencia podvodov, moderovanie obsahu', 'čl. 6 ods. 1 písm. f) – oprávnený záujem prevádzkovateľa', 'Logy max. 12 mesiacov; záznamy o nahláseniach 3 roky'],
                            ['Štatistika a analytika Platformy (anonymizovaná)', 'čl. 6 ods. 1 písm. f) – oprávnený záujem', 'V anonymizovanej forme neurčito'],
                            ['Marketing a zasielanie newslettra (ak ste súhlasili)', 'čl. 6 ods. 1 písm. a) – súhlas', 'Do odvolania súhlasu'],
                            ['Plnenie zákonných povinností (napr. uchovávanie záznamov)', 'čl. 6 ods. 1 písm. c) – zákonná povinnosť', 'Podľa príslušného zákona (zvyčajne 5–10 rokov)'],
                            ['Riešenie sťažností a právnych nárokov', 'čl. 6 ods. 1 písm. f) – oprávnený záujem', '3 roky od vyriešenia (premlčacia doba)'],
                            ['Zverejnenie tel. čísla — stratený pes', 'čl. 6 ods. 1 písm. a) GDPR — výslovný súhlas používateľa', '30 dní od zverejnenia inzerátu, alebo do odvolania súhlasu na nuffy@nuffy.sk'],
                            ['Zverejnenie tel. čísla — nájdený pes', 'čl. 6 ods. 1 písm. a) GDPR — výslovný súhlas používateľa', '30 dní od zverejnenia inzerátu, alebo do odvolania súhlasu na nuffy@nuffy.sk'],
                        ] as $row)
                            <tr class="border-b border-border align-top">
                                <td class="p-2">{{ $row[0] }}</td>
                                <td class="p-2">{{ $row[1] }}</td>
                                <td class="p-2">{{ $row[2] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p>Pri nahlásení strateného, alebo nájdeného psa môže používateľ dobrovoľne zverejniť svoje telefónne číslo. Spracovanie tohto čísla sa riadi Zásadami ochrany osobných údajov dostupnými na www.nuffy.sk.</p>
            <p><strong>Dôležité – spracúvanie na základe súhlasu.</strong> Ak spracúvame vaše osobné údaje na základe vášho súhlasu, máte právo tento súhlas kedykoľvek odvolať. Odvolanie súhlasu nemá vplyv na zákonnosť spracúvania, ktoré prebiehalo pred jeho odvolaním. Súhlas môžete odvolať v Nastaveniach účtu alebo zaslaním e-mailu na nuffy@nuffy.sk.</p>

            <h2 class="font-display text-lg font-semibold mt-6">5. Príjemcovia osobných údajov a sprostredkovatelia</h2>
            <p>Vaše osobné údaje nepredávame, nevymieňame ani neprenajímame tretím stranám na komerčné účely. Môžeme ich poskytnúť iba v nasledujúcich prípadoch:</p>
            <h3 class="font-display text-base font-semibold mt-4">5.1 Sprostredkovatelia (spracovatelia dát v mene nuffy.sk)</h3>
            <p>S vybranými dôveryhodnými poskytovateľmi služieb uzatvárame Zmluvy o spracovaní osobných údajov (DPA) v súlade s čl. 28 GDPR. Tieto subjekty spracúvajú údaje výhradne podľa našich pokynov:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Hostingový provider / cloudová infraštruktúra – na uloženie dát a prevádzku Platformy,</li>
                <li>Poskytovateľ e-mailovej služby – na zasielanie systémových notifikácií a prípadného newslettra,</li>
                <li>Analytická platforma – na meranie návštevnosti v anonymizovanej forme,</li>
                <li>Systém na správu obsahu / CDN – na rýchle doručovanie médií (fotografií),</li>
                <li>Platobný procesor – ak sú zavedené platené funkcie.</li>
            </ul>
            <h3 class="font-display text-base font-semibold mt-4">5.2 Iní príjemcovia</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>Orgány verejnej správy a orgány činné v trestnom konaní – ak nám to prikazuje zákon alebo súdny príkaz,</li>
                <li>Advokáti a právni poradcovia – pri uplatňovaní alebo obhajovaní právnych nárokov, výhradne v nevyhnutnom rozsahu,</li>
                <li>Nástupca / nadobúdateľ – pri prípadnej fúzii, akvizícii alebo prevode Platformy; používatelia budú informovaní vopred.</li>
            </ul>
            <h3 class="font-display text-base font-semibold mt-4">5.3 Externé odkazy a sociálne siete (Instagram, YouTube)</h3>
            <p>Platforma obsahuje externé odkazy, ktoré presmerujú používateľa na Instagram alebo YouTube. Upozorňujeme, že:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Platforma nemá kontrolu nad spracúvaním osobných údajov na platformách Instagram (Meta Platforms Ireland Ltd.) a YouTube (Google LLC),</li>
                <li>pri kliknutí na externý odkaz opúšťate nuffy.sk a vzťahujú sa na vás zásady ochrany súkromia príslušnej tretej strany,</li>
                <li>pokiaľ používateľ zadal odkaz na vlastný Instagram profil v nastaveniach svojho nuffy.sk profilu, tento odkaz je zobrazovaný verejne (alebo len priateľom, podľa nastavení súkromia); ide o dobrovoľné zdieľanie informácií samotným používateľom,</li>
                <li>nuffy.sk nezhromažďuje údaje o vašom správaní na externých platformách a ani inak nezdieľa vaše údaje s týmito platformami bez vášho výslovného súhlasu.</li>
            </ul>
            <h3 class="font-display text-base font-semibold mt-4">5.4 Verejne viditeľné informácie na Platforme</h3>
            <p>Niektoré informácie, ktoré používateľ zadá na profil, sú štandardne viditeľné pre ostatných registrovaných používateľov alebo pre verejnosť (neregistrovaných návštevníkov), pokiaľ ich používateľ v nastaveniach súkromia neobmedzí. Medzi takéto informácie môže patriť:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>prezývka / nick,</li>
                <li>profilová fotografia,</li>
                <li>mesto / obec,</li>
                <li>bio / opis,</li>
                <li>informácie o psovi a fotografie psa,</li>
                <li>príspevky a komentáre na verejnom fóre,</li>
                <li>telefónne číslo.</li>
            </ul>
            <p>Používateľ má možnosť nastaviť si viditeľnosť profilových údajov v Nastaveniach súkromia svojho účtu.</p>

            <h2 class="font-display text-lg font-semibold mt-6">6. Prenos osobných údajov do tretích krajín</h2>
            <p>nuffy.sk sa snaží spracúvať osobné údaje výhradne v rámci Európskeho hospodárskeho priestoru (EHP). Ak niektorý z našich sprostredkovateľov (napr. cloudový provider) prenáša údaje mimo EHP, zabezpečíme, aby bol takýto prenos realizovaný s primeranými zárukami podľa čl. 46 GDPR, najmä:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Rozhodnutím Komisie o primeranosti ochrany (napr. EÚ-USA Data Privacy Framework),</li>
                <li>Štandardnými zmluvnými doložkami (SCC) schválenými Európskou komisiou,</li>
                <li>Záväznými vnútropodnikovými pravidlami (BCR).</li>
            </ul>
            <p>Konkrétny zoznam tretích krajín a príslušných záruk je dostupný na vyžiadanie na adrese nuffy@nuffy.sk.</p>

            <h2 class="font-display text-lg font-semibold mt-6">7. Vaše práva ako dotknutej osoby</h2>
            <p>Ako dotknutá osoba máte podľa GDPR nasledujúce práva, ktoré môžete uplatniť kedykoľvek:</p>
            <h3 class="font-display text-base font-semibold mt-4">7.1 Právo na prístup (čl. 15 GDPR)</h3>
            <p>Máte právo získať od nás potvrdenie, či spracúvame vaše osobné údaje, a ak áno, získať prístup k týmto údajom vrátane informácií o účeloch, kategóriách údajov, príjemcoch, dobe uchovávania a vašich právach. Na požiadanie vám poskytneme kópiu spracúvaných osobných údajov (prvá kópia bezplatne).</p>
            <h3 class="font-display text-base font-semibold mt-4">7.2 Právo na opravu (čl. 16 GDPR)</h3>
            <p>Máte právo na opravu nesprávnych alebo neúplných osobných údajov, ktoré sa vás týkajú. Väčšinu údajov si môžete opraviť priamo v nastaveniach svojho profilu. V prípade potreby nás kontaktujte na nuffy@nuffy.sk.</p>
            <h3 class="font-display text-base font-semibold mt-4">7.3 Právo na vymazanie – „právo byť zabudnutý" (čl. 17 GDPR)</h3>
            <p>Máte právo požiadať o vymazanie svojich osobných údajov, ak:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>údaje už nie sú potrebné na účely, na ktoré boli zhromaždené,</li>
                <li>odvoláte súhlas a neexistuje iný právny základ na spracúvanie,</li>
                <li>vznesiete námietku a neexistujú žiadne prevažujúce oprávnené dôvody,</li>
                <li>údaje boli spracúvané nezákonne.</li>
            </ul>
            <p>Právo na vymazanie môžete uplatniť priamo cez funkciu „Vymazať účet" v Nastaveniach účtu alebo zaslaním žiadosti na nuffy@nuffy.sk. Upozorňujeme, že právo na vymazanie sa nevzťahuje na prípadné zákonné povinnosti uchovávať určité údaje (napr. pre účtovné alebo daňové účely).</p>
            <h3 class="font-display text-base font-semibold mt-4">7.4 Právo na obmedzenie spracúvania (čl. 18 GDPR)</h3>
            <p>Máte právo požiadať o obmedzenie spracúvania vašich osobných údajov, napríklad počas overovania ich správnosti alebo keď vznesiete námietku voči spracúvaniu. Počas obmedzenia môžeme údaje iba uchovávať, nie ďalej spracúvať.</p>
            <h3 class="font-display text-base font-semibold mt-4">7.5 Právo na prenosnosť údajov (čl. 20 GDPR)</h3>
            <p>Máte právo získať vaše osobné údaje, ktoré ste nám poskytli, v štruktúrovanom, bežne používanom a strojovo čitateľnom formáte (napr. JSON alebo CSV) a preniesť ich inému prevádzkovateľovi. Túto funkciu môžete využiť priamo v Nastaveniach účtu prostredníctvom funkcie „Stiahnuť moje údaje". Právo na prenosnosť sa vzťahuje na údaje spracúvané na základe súhlasu alebo zmluvy a automatizovanými prostriedkami.</p>
            <h3 class="font-display text-base font-semibold mt-4">7.6 Právo namietať (čl. 21 GDPR)</h3>
            <p>Máte právo kedykoľvek namietať voči spracúvaniu vašich osobných údajov, ktoré je založené na oprávnenom záujme prevádzkovateľa (čl. 6 ods. 1 písm. f) GDPR), vrátane profilovania. Prevádzkovateľ zastaví spracúvanie, pokiaľ nepreukáže presvedčivé oprávnené dôvody, ktoré prevažujú nad vašimi záujmami, právami a slobodami, alebo pre preukazovanie, uplatňovanie alebo obhajovanie právnych nárokov.</p>
            <h3 class="font-display text-base font-semibold mt-4">7.7 Práva súvisiace s automatizovaným rozhodovaním a profilovaním (čl. 22 GDPR)</h3>
            <p>nuffy.sk v súčasnosti nevykonáva automatizované rozhodovanie s právnymi alebo podobne závažnými účinkami vrátane profilovania. Ak by sme takéto spracúvanie zaviedli, budeme vás o tom vopred informovať a zabezpečíme vám príslušné záruky.</p>
            <h3 class="font-display text-base font-semibold mt-4">7.8 Ako uplatniť vaše práva</h3>
            <p>Svoju žiadosť môžete podať:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>E-mailom na: nuffy@nuffy.sk</li>
                <li>Priamo v nastaveniach vášho účtu (pre funkcie dostupné online: stiahnutie údajov, vymazanie účtu, zmena hesla),</li>
                <li>Poštou na adresu prevádzkovateľa.</li>
            </ul>
            <p>Na vašu žiadosť odpovieme bez zbytočného odkladu, najneskôr do 30 dní od jej prijatia. V zložitých prípadoch alebo pri väčšom počte žiadostí môžeme túto lehotu predĺžiť o ďalších 60 dní, pričom vás o takomto predĺžení a jeho dôvodoch vopred informujeme. Odpoveď vám poskytneme bezplatne; ak by bola žiadosť zjavne neopodstatnená alebo neprimeraná (opakovaná), môžeme účtovať primeraný administratívny poplatok.</p>
            <p><strong>Právo podať sťažnosť.</strong> Ak sa domnievate, že spracúvanie vašich osobných údajov je v rozpore s GDPR, máte právo podať sťažnosť na Úrad na ochranu osobných údajov Slovenskej republiky, Hraničná 12, 820 07 Bratislava, webová stránka: dataprotection.gov.sk, e-mail: statny.dozor@pdp.gov.sk, tel.: +421 2 3231 3214.</p>

            <h2 class="font-display text-lg font-semibold mt-6">8. Bezpečnosť osobných údajov</h2>
            <p>Prijali sme primerané technické a organizačné opatrenia na ochranu vašich osobných údajov pred neoprávneným prístupom, zmenou, zverejnením, stratou alebo zničením v súlade s čl. 32 GDPR. Medzi kľúčové bezpečnostné opatrenia patria:</p>
            <h3 class="font-display text-base font-semibold mt-4">8.1 Technické opatrenia</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>Šifrované heslo: heslá sú ukladané výhradne vo forme kryptografického hashu (bcrypt/Argon2) – heslo v čitateľnej forme nikdy neukladáme,</li>
                <li>HTTPS / TLS: veškerá komunikácia medzi vaším zariadením a Platformou je šifrovaná pomocou TLS 1.2 alebo vyššej verzie,</li>
                <li>Šifrovanie databázy: citlivé polia databázy sú šifrované v pokoji (encryption at rest),</li>
                <li>Firewall a ochrana pred DDoS útokmi,</li>
                <li>Pravidelné zálohovanie dát s testovaním obnovy,</li>
                <li>Dvojfaktorová autentifikácia (2FA) – dostupná ako voliteľná funkcia pre všetkých používateľov,</li>
                <li>Automatické odhlásenie po dlhšej nečinnosti relácie,</li>
                <li>Obmedzenie prístupu k databázam podľa princípu minimálnych oprávnení (least privilege).</li>
            </ul>
            <h3 class="font-display text-base font-semibold mt-4">8.2 Organizačné opatrenia</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>Prístup k osobným údajom majú výhradne poverení zamestnanci a spolupracovníci, ktorí sú zmluvne viazaní mlčanlivosťou,</li>
                <li>Pravidelné školenia zamestnancov v oblasti ochrany osobných údajov a kybernetickej bezpečnosti,</li>
                <li>Interné bezpečnostné smernice a politiky,</li>
                <li>Vedenie záznamu o spracovateľských činnostiach (čl. 30 GDPR),</li>
                <li>Postup reakcie na bezpečnostné incidenty a porušenia ochrany osobných údajov.</li>
            </ul>
            <h3 class="font-display text-base font-semibold mt-4">8.3 Postup pri porušení ochrany osobných údajov</h3>
            <p>V prípade zistenia porušenia ochrany osobných údajov (data breach), ktoré môže predstavovať riziko pre práva a slobody fyzických osôb, sme povinní:</p>
            <ol class="list-decimal pl-5 space-y-1">
                <li>Nahlásiť porušenie Úradu na ochranu osobných údajov SR do 72 hodín od jeho zistenia (čl. 33 GDPR),</li>
                <li>Informovať dotknuté osoby bez zbytočného odkladu, ak porušenie môže predstavovať vysoké riziko (čl. 34 GDPR).</li>
            </ol>
            <p><strong>Upozornenie pre používateľov:</strong> aj napriek všetkým prijatým opatreniam nie je možné zaručiť stopercentnú bezpečnosť v internetovom prostredí. Odporúčame vám používať silné unikátne heslá a pravidelne ich meniť, aktivovať 2FA a nezverejňovať citlivé osobné informácie na verejných častiach Platformy.</p>

            <h2 class="font-display text-lg font-semibold mt-6">9. Správa používateľského účtu</h2>
            <p>Platforma nuffy.sk vám poskytuje nasledujúce funkcie na správu vašich osobných údajov priamo bez potreby kontaktovať nás:</p>
            <h3 class="font-display text-base font-semibold mt-4">9.1 Zmena hesla</h3>
            <p>Heslo si môžete kedykoľvek zmeniť v sekcii Nastavenia &gt; Bezpečnosť. Pri zmene hesla si zvoľte silné heslo – minimálne 8 znakov kombinujúcich veľké a malé písmená, čísla a špeciálne znaky. Odporúčame použiť správcu hesiel. Po zmene hesla budú z bezpečnostných dôvodov ukončené všetky aktívne relácie okrem tej aktuálnej.</p>
            <h3 class="font-display text-base font-semibold mt-4">9.2 Stiahnutie vlastných údajov (dátový export)</h3>
            <p>Máte právo kedykoľvek stiahnuť kópiu všetkých osobných údajov, ktoré o vás uchovávame. Export môžete iniciovat v sekcii Nastavenia &gt; Súkromie &gt; Stiahnuť moje údaje. Export obsahuje:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>profilové informácie (meno, bio, dátum narodenia, telefónne číslo (ak ste ho zadávali), mesto, odkaz na Instagram),</li>
                <li>informácie o psovi (meno, plemeno, bio, vek),</li>
                <li>nahrané fotografie (vo forme stiahnuteľného archívu),</li>
                <li>zoznam priateľov (prezývky kontaktov),</li>
                <li>históriu zaslaných a prijatých správ,</li>
                <li>príspevky a komentáre na fóre,</li>
                <li>záznamy o nahlásenom obsahu.</li>
            </ul>
            <p>Export bude pripravený do 72 hodín a zaslaný na vašu registrovanú e-mailovú adresu vo forme šifrovaného archívu alebo dostupný na stiahnutie zo zabezpečeného odkazu. Budú odoslané len informácie, ktoré ste v ramci platformy zadávali.</p>
            <h3 class="font-display text-base font-semibold mt-4">9.3 Vymazanie účtu</h3>
            <p>Svoj účet môžete trvalo vymazať v sekcii Nastavenia &gt; Účet &gt; Vymazať účet. Vymazanie účtu je nevratné. Po potvrdení vymazania:</p>
            <ol class="list-decimal pl-5 space-y-1">
                <li>Váš verejný profil bude okamžite skrytý a nebude dostupný pre ostatných používateľov,</li>
                <li>Osobné údaje prepojené s vašim profilom budú zmazané do 30 dní,</li>
                <li>Anonymizované štatistické dáta (napr. počet príspevkov bez identifikátora) môžu zostať zachované,</li>
                <li>Zákonné záznamy (napr. na daňové alebo právne účely) budú uchovávané počas zákonom stanovenej doby napriek vymazaniu účtu,</li>
                <li>Príspevky na verejnom fóre môžu byť anonymizované (autor nahradený textom „Vymazaný používateľ") namiesto úplného odstránenia, aby sa zachovala súdržnosť diskusií – môžete požiadať o úplné odstránenie svojich príspevkov cez nuffy@nuffy.sk,</li>
                <li>Prijaté správy druhej strany konverzácie môžu zostať v doručenej pošte adresáta; tento aspekt je súčasťou funkcionality zasielania správ a bol vám oznámený pri registrácii.</li>
            </ol>
            <h3 class="font-display text-base font-semibold mt-4">9.4 Priateľstvá a sociálne prepojenia</h3>
            <p>Funkcia „Priatelia" na nuffy.sk umožňuje používateľom posielať a prijímať žiadosti o priateľstvo (friend requests). Spracúvanie v tejto súvislosti zahŕňa:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>uchovávanie informácií o odoslaných a prijatých žiadostiach o priateľstvo (odosielateľ, príjemca, stav, čas),</li>
                <li>zoznam potvrdených priateľov (kontaktov) – viditeľný pre príslušného používateľa a voliteľne pre ostatných,</li>
                <li>notifikácie o nových žiadostiach a prijatiach.</li>
            </ul>
            <p>Môžete kedykoľvek odmietnuť žiadosť, odobrať priateľa zo zoznamu alebo zablokovať iného používateľa. Tieto akcie sú dostupné priamo z profilu daného používateľa alebo z nastavení.</p>
            <h3 class="font-display text-base font-semibold mt-4">9.5 Telefónne číslo pri nahlásení strateného alebo nájdeného psa</h3>
            <p>Telefónne číslo je zadávané dobrovoľne používateľom pri vyplnení formulára „Stratený pes" alebo „Nahlásiť nález". Číslo je zverejnené výhradne pre registrovaných používateľov nuffy.sk za účelom umožnenia priameho kontaktu medzi majiteľom strateného psa a nálezníkom. Telefónne číslo nie je viditeľné pre neregistrovaných návštevníkov, nie je indexované vyhľadávačmi a nie je poskytované tretím stranám. Používateľ udeľuje súhlas so zverejnením čísla výslovným zaškrtnutím súhlasového checkboxu priamo vo formulári pred jeho odoslaním. Súhlas je možné kedykoľvek odvolať kontaktovaním prevádzkovateľa na nuffy@nuffy.sk, pričom dôjde k okamžitému odstráneniu telefónneho čísla. Telefónne číslo je vymazané spolu s celým inzerátom automaticky po uplynutí 30 dní od jeho zverejnenia.</p>

            <h2 class="font-display text-lg font-semibold mt-6">10. Súbory cookies a podobné technológie</h2>
            <p>Webová stránka nuffy.sk používa súbory cookies a podobné sledovacie technológie v súlade so zákonom č. 351/2011 Z. z. o elektronických komunikáciách a smernicou ePrivacy.</p>
            <h3 class="font-display text-base font-semibold mt-4">10.1 Čo sú cookies</h3>
            <p>Cookies sú malé textové súbory, ktoré sa ukladajú vo vašom webovom prehliadači alebo zariadení pri návšteve webovej stránky. Pomáhajú nám zabezpečiť správne fungovanie Platformy, zapamätať si vaše preferencie a analyzovať návštevnosť.</p>
            <h3 class="font-display text-base font-semibold mt-4">10.2 Typy cookies, ktoré používame</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-border">
                            <th class="text-left p-2">Typ</th>
                            <th class="text-left p-2">Účel</th>
                            <th class="text-left p-2">Právny základ</th>
                            <th class="text-left p-2">Platnosť</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ([
                            ['Nevyhnutné (session)', 'Prihlásenie, relácia, bezpečnosť (CSRF token)', 'Oprávnený záujem / nevyhnutné pre fungovanie', 'Relácia'],
                            ['Funkčné', 'Pamätanie jazykových a zobrazovacích preferencií', 'Súhlas', '12 mesiacov'],
                            ['Analytické', 'Anonymizovaná štatistika návštevnosti (napr. Google Analytics / Plausible)', 'Súhlas', '24 mesiacov'],
                            ['Marketingové', 'Zobrazovanie relevantných reklám (ak sú zavedené)', 'Súhlas', 'Podľa nastavenia'],
                        ] as $row)
                            <tr class="border-b border-border align-top">
                                <td class="p-2">{{ $row[0] }}</td>
                                <td class="p-2">{{ $row[1] }}</td>
                                <td class="p-2">{{ $row[2] }}</td>
                                <td class="p-2">{{ $row[3] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <h3 class="font-display text-base font-semibold mt-4">10.3 Správa cookies</h3>
            <p>Pri prvej návšteve nuffy.sk vám zobrazíme banner na správu súhlasu s cookies (Consent Management Platform – CMP). Súhlas môžete kedykoľvek zmeniť alebo odvolať v nastaveniach cookies dostupných v päte stránky (odkaz „Nastavenia cookies"). Cookies môžete tiež spravovať alebo odstrániť priamo vo vašom prehliadači; upozorňujeme, že zakázanie nevyhnutných cookies môže ovplyvniť fungovanie Platformy.</p>

            <h2 class="font-display text-lg font-semibold mt-6">11. Fórum, komentáre a nahlasovanie obsahu</h2>
            <p>Platforma prevádzkuje verejné fórum, kde môžu registrovaní používatelia zverejňovať príspevky a komentáre. V tejto súvislosti upozorňujeme na nasledujúce:</p>
            <h3 class="font-display text-base font-semibold mt-4">11.1 Verejný charakter príspevkov</h3>
            <p>Príspevky a komentáre na fóre sú štandardne verejné – môžu ich vidieť iní registrovaní aj neregistrovaní návštevníci Platformy. Pri zverejňovaní príspevkov sa riaďte zdravým úsudkom a nezverejňujte informácie, ktoré nechcete sprístupniť verejnosti.</p>
            <h3 class="font-display text-base font-semibold mt-4">11.2 Spracúvanie údajov v rámci fóra</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>text príspevku / komentára,</li>
                <li>prezývku autora (zobrazovaná verejne),</li>
                <li>čas a dátum uverejnenia,</li>
                <li>IP adresu (ukladaná interne na bezpečnostné a anti-spam účely, nezobrazovaná verejne).</li>
            </ul>
            <h3 class="font-display text-base font-semibold mt-4">11.3 Nahlasovanie obsahu</h3>
            <p>Používatelia môžu nahlásiť príspevky alebo komentáre, ktoré porušujú pravidlá komunity alebo právne predpisy. Nahlásenie zahŕňa:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>identifikáciu nahláseného príspevku a jeho autora (interné spracúvanie),</li>
                <li>dôvod nahlásenia zadaný nahlasovateľom,</li>
                <li>identitu nahlasovateľa (interná – nie je zverejnená autorovi nahláseného príspevku).</li>
            </ul>
            <p>Záznamy o nahláseniach uchovávame po dobu 3 rokov na účely moderovacích rozhodnutí a prípadných právnych sporov.</p>
            <h3 class="font-display text-base font-semibold mt-4">11.4 Moderovanie obsahu</h3>
            <p>Tím moderátorov nuffy.sk má prístup k príspevkom, nahláseniam a v odôvodnených prípadoch k ďalším informáciám o aktivite používateľa v rozsahu nevyhnutnom na rozhodnutie o nahlásenom obsahu. Moderátori sú viazaní mlčanlivosťou a internými smernicami.</p>

            <h2 class="font-display text-lg font-semibold mt-6">12. Ochrana maloletých osôb</h2>
            <p>Platforma nuffy.sk nie je určená pre osoby mladšie ako 18 rokov. Registráciou používateľ potvrdzuje, že dovŕšil 18 rokov veku. Dátum narodenia zadaný pri registrácii slúži okrem iného na overenie tohto minimálneho veku.</p>
            <p>Ak zistíme, že osobné údaje patriace osobe mladšej ako 18 rokov boli zhromaždené bez overiteľného súhlasu zákonného zástupcu, takéto údaje bezodkladne vymažeme. Ak máte podozrenie, že na Platforme je registrovaná osoba mladšia ako 18 rokov, kontaktujte nás na nuffy@nuffy.sk.</p>

            <h2 class="font-display text-lg font-semibold mt-6">13. Zmeny týchto Zásad ochrany osobných údajov</h2>
            <p>Tieto Zásady môžeme priebežne aktualizovať v súvislosti so zmenami Platformy, zákonných požiadaviek alebo našich interných postupov. O každej podstatnej zmene vás budeme informovať:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>upozornením na Platforme (banner alebo oznámenie v dashboarde) minimálne 14 dní pred nadobudnutím účinnosti zmeny,</li>
                <li>e-mailom na vašu registrovanú e-mailovú adresu v prípade zásadných zmien týkajúcich sa vašich práv.</li>
            </ul>
            <p>Aktuálna verzia Zásad je vždy dostupná na adrese: https://nuffy.sk/gdpr. Dátum poslednej aktualizácie je vždy uvedený v záhlaví dokumentu. Pokračovaním v používaní Platformy po nadobudnutí účinnosti zmien vyjadrujete súhlas s aktualizovanými Zásadami, pokiaľ nie je pre konkrétne spracúvanie vyžadovaný výslovný súhlas.</p>

            <h2 class="font-display text-lg font-semibold mt-6">14. Záverečné ustanovenia</h2>
            <p>Tieto Zásady sa riadia právnym poriadkom Slovenskej republiky a právom Európskej únie, najmä GDPR a zákonom č. 18/2018 Z. z. o ochrane osobných údajov.</p>
            <p>Ak je niektoré ustanovenie týchto Zásad neplatné alebo nevykonateľné, zostávajúce ustanovenia zostávajú v plnej platnosti a účinnosti.</p>
            <p>V prípade akýchkoľvek otázok týkajúcich sa ochrany vašich osobných údajov nás neváhajte kontaktovať:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>E-mail:</strong> nuffy@nuffy.sk</li>
                <li><strong>Webová stránka:</strong> https://nuffy.sk/</li>
                <li><strong>Poštová adresa:</strong> Boženy Němcovej 962/26, 990 01 Veľký Krtíš, Slovenská republika</li>
                <li><strong>Dátum vydania:</strong> 20. 5. 2026</li>
                <li><strong>Verzia:</strong> 1.0</li>
            </ul>
            <p class="italic mt-4">
                Ďakujeme, že nám dôverujete a používate nuffy.sk zodpovedne.
                <br>
                nuffy.sk – Komunitná platforma pre milovníkov psov
            </p>
        </article>
    </div>
@endsection
