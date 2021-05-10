#-- TESTS, DIE IN DAS REGISTER FORMULAR DER WEBSITE COPY PASTET WERDEN MÜSSEN ZUM TESTEN-- 

#-- ANCHOR Validierung für die Tests
/* Formatierung immer
FirstName LastName Username Email Passwort PasswortRepeat*/ --

/* TODO wenn man z.B. ins Formular beim Vornamen schreibt 
-> Günther und danach einmal Space drückt, steht Use a real first name 
müssen wir fixen, dass es bei Leerzeichen halt nt aufmuckt */


# -- ANCHOR FirstName Validations -- 

# -- Kein Fehler expected --  
# -- -> Kein Fehler im Test - Wird in DB eingetragen -- 
Hans Peter hanspeter1 hanspeter1@gmail.com HalloPeter123 HalloPeter123

# -- Kein Fehler expected - Mit Umlauten --
# -- -> Kein Fehler im Test - Wird in DB eingetragen -- 
Günther Baüer guntherus1 guenterus@gmail.com Guntherus123 Guntherus123

# -- Falsche FirstName Validation expected - Zahl im Namen -- 
# -- -> Kein Fehler im Test - "use a real first name"  -- 
Hans1 Peter hanspeter2 hanspeter2@gmail.com HalloPeter123 HalloPeter123

# -- Falsche FirstName Validation expected - Special Character verwendet --
# -- -> Kein Fehler im Test - "use a real first name"  -- 
Hans: Peter hanspeter3 hanspeter3@gmail.com HalloPeter123 HalloPeter123

# -- Falsche FirstName Validation expected - zu langer Vorname -- 
# -- -> Kein Fehler im Test - "your name is too long"  -- 
/* TODO vll einstellen im Input, dass man einfach nt mehr als 50 schreiben kann, dann fällt auch die Validation weg? */
HansHansHansHansHansHansHansHansHansHansHansHansHan Peter hanspeter4 hanspeter4@gmail.com HalloPeter123 HalloPeter123

# -- Falsche FirstName Validation expected - Firstname ist leer --
# -- -> Kein Fehler im Test - "your first name cant be empty "  -- 
'' Peter hanspeter5 hanspeter5@gmail.com HalloPeter123 HalloPeter123

# -- ANCHOR LastName Validations --

# -- Kein Fehler expected -- 
# -- -> Kein Fehler im Test - Wird in DB eingetragen  -- 
Hans Peterus hanspeter2 hanspeter2@gmail.com HalloPeter123 HalloPeter123

# -- Kein Fehler expected - Mit Umlauten -- 
# -- -> Kein Fehler im Test - Wird in DB eingetragen  -- 
Bauer Güntherus guntherus2 guenterus2@gmail.com Guntherus123 Guntherus123

# -- Falsche LastName Validation expected - Zahl im Namen --
# -- -> Kein Fehler im Test - "use a real last name"  -- 
Hans Peter2 hanspeter3 hanspeter3@gmail.com HalloPeter123 HalloPeter123

# -- Falsche LastName Validation expected - Special Character verwendet -- 
# -- -> Kein Fehler im Test - "use a real last name"  -- 
Hans Peter: hanspeter3 hanspeter3@gmail.com HalloPeter123 HalloPeter123

# -- Falsche LastName Validation expected - zu langer Vorname -- 
# -- -> Kein Fehler im Test - "your last name is too long"  --
/* TODO Validation Nachricht falsch, steht nur your last is too long */ 
Peter HansHansHansHansHansHansHansHansHansHansHansHansHan hanspeter4 hanspeter4@gmail.com HalloPeter123 HalloPeter123

# -- Falsche LastName Validation expected - LastName ist leer -- 
# -- -> Kein Fehler im Test - "your last name cant be empty "  -- 
Peter ''  hanspeter5 hanspeter5@gmail.com HalloPeter123 HalloPeter123

# -- ANCHOR Username Validations --

# -- Kein Fehler expected - Username mit Umlauten und Special Character -- 
Bauer Güntherus G_üntherus.2-bauer guenterus2@gmail.com Guntherus123 Guntherus123

# -- Falsche Username Validation expected - zu kurzer Username -- 
Bauer Güntherus gü guenterus3@gmail.com Guntherus123 Guntherus123

# -- Falsche Username Validation expected - zu langer Username -- 
Bauer Güntherus günthergünthergünther guenterus3@gmail.com Guntherus123 Guntherus123

# -- Falsche Username Validation expected - Special Character die wir nt unterstützen im Namen -- 
Bauer Güntherus günter%bauer!3 guenterus3@gmail.com Guntherus123 Guntherus123

# -- Falsche Username Validation expected - Username bereits vergeben -- 
Bauer Güntherus user guenterus3@gmail.com Guntherus123 Guntherus123

# -- Falsche Username Validation expected - Leer -- 
Bauer Güntherus '' guenterus3@gmail.com Guntherus123 Guntherus123


# -- ANCHOR E-Mail Validations -- 

# -- Kein Fehler expected - E-Mail mit Special Character -- 
Gab Jetski gabjetski gab-rie%l1@htl-rennweg1.at Hallo123 Hallo123 

# -- Falsche E-Mail Validation expected -- 
Gab Jetski gabjetski gabjetski.gmail.com Hallo123 Hallo123

# -- Falsche E-Mail Validation expected -- 
Gab Jetski gabjetski gabjetski@gmail.a Hallo123 Hallo123

# -- Falsche E-Mail Validation expected -- 
Gab Jetski gabjetski gabjetski@gmail.commm Hallo123 Hallo123

# -- Falsche E-Mail Validation expected -- 
Gab Jetski gabjetski gäbjetskü@gmail.at Hallo123 Hallo123

# -- Falsche E-Mail Validation expected -- 
Gab Jetski gabjetski gab%jetski@gmail.at Hallo123 Hallo123

# -- Falsche E-Mail Validation expected -- 
Gab Jetski gabjetski @gmail.at Hallo123 Hallo123

# -- Falsche E-Mail Validation expected -- 
Gab Jetski gabjetski hallo1@gmail.at1 Hallo123 Hallo123

# -- Falsche E-Mail Validation expected -- 
Gab Jetski gabjetski hallo1@at Hallo123 Hallo123

# -- Falsche E-Mail Validation expected -- 
Gab Jetski gabjetskiii '' Hallo123 Hallo123

# -- ANCHOR Passwort Validations

# -- Kein Fehler expected - Passwort mit Umlauten und Special Character -- 
Elias Samuel eliassamuel eliassam@gmail.com 2äSamElias3Ni!?ce_.$ 2äSamElias3Ni!?ce_.$

# -- Falsche Passwort Validation expected -- 
Eliass Saamuel eliassammuel eliassam1@gmail.com Hi Hi

# -- Falsche Passwort Validation expected -- 
Eliass Saamuel eliassammuel eliassam1@gmail.com SamSamSamSamSamSamSamSamSamSamS SamSamSamSamSamSamSamSamSamSamS

# -- Falsche Passwort Validation expected -- 
Eliass Saamuel eliassammuel eliassam1@gmail.com hallo1234 hallo1234

# -- Falsche Passwort Validation expected -- 
Eliass Saamuel eliassammuel eliassam1@gmail.com HALLO1234 HALLO1234

# -- Falsche Passwort Validation expected -- 
Eliass Saamuel eliassammuel eliassam1@gmail.com Hallosamuel Hallosamuel

# -- Falsche Passwort Validation expected -- 
Eliass Saamuel eliassammuel eliassam1@gmail.com HalloSam123 HalloSam12

# -- Falsche Passwort Validation expected -- 
Eliass Saamuel eliassammuel eliassam1@gmail.com HalloSam12 HalloSam123

# -- Falsche Passwort Validation expected -- 
Eliass Saamuel eliassammuel eliassam1@gmail.com '' HalloSam123

# -- Falsche Passwort Validation expected -- 
Eliass Saamuel eliassammuel eliassam1@gmail.com HalloSam12 ''




