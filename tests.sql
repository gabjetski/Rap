
/* main.sql zeile 27, sollte noch geändert werden zu not null oder? */
/* UND in sql steht bei first und lastname z.B. varchar(30), in js aber mit regex {1,}, ändern auf {1,30}? 
Falls ja -> muss ich dann in js ändern */

#-- TESTS, DIE IN DAS REGISTER FORMULAR DER WEBSITE COPY PASTET WERDEN MÜSSEN ZUM TESTEN-- 

#-- ANCHOR Validierung für die Tests
/* Formatierung immer
FirstName LastName Username Email Passwort PasswortRepeat*/ --

# -- ANCHOR FirstName Validations -- 

# -- Kein Fehler expected -- 
Hans Peter hanspeter1 hanspeter1@gmail.com HalloPeter123 HalloPeter123

# -- Kein Fehler expected - Mit Umlauten -- 
Günther Bauer guntherus1 guenterus@gmail.com Guntherus123 Guntherus123

# -- Falsche FirstName Validation expected - Zahl im Namen -- 
Hans1 Peter hanspeter2 hanspeter2@gmail.com HalloPeter123 HalloPeter123

# -- Falsche FirstName Validation expected - Special Character verwendet -- 
Hans: Peter hanspeter3 hanspeter3@gmail.com HalloPeter123 HalloPeter123

# -- Falsche FirstName Validation expected - zu langer Vorname -- 
HansHansHansHansHansHansHansHans Peter hanspeter4 hanspeter4@gmail.com HalloPeter123 HalloPeter123

# -- Falsche FirstName Validation expected - Firstname ist leer -- 
'' Peter hanspeter5 hanspeter5@gmail.com HalloPeter123 HalloPeter123

# -- ANCHOR LastName Validations --

# -- Kein Fehler expected -- 
Hans Peterus hanspeter2 hanspeter2@gmail.com HalloPeter123 HalloPeter123

# -- Kein Fehler expected - Mit Umlauten -- 
Bauer Güntherus guntherus2 guenterus2@gmail.com Guntherus123 Guntherus123

# -- Falsche LastName Validation expected - Zahl im Namen -- 
Hans1 Peter hanspeter3 hanspeter3@gmail.com HalloPeter123 HalloPeter123

# -- Falsche LastName Validation expected - Special Character verwendet -- 
Hans: Peter hanspeter3 hanspeter3@gmail.com HalloPeter123 HalloPeter123

# -- Falsche LastName Validation expected - zu langer Vorname -- 
Peter HansHansHansHansHansHansHansHans hanspeter4 hanspeter4@gmail.com HalloPeter123 HalloPeter123

# -- Falsche LastName Validation expected - LastName ist leer -- 
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

# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 


# -- Kein Fehler expected -- 

