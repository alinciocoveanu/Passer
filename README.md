# Passer
Proiect Tehnologii Web - Passer

Sa se dezvolte o aplicatie Web care permite gestionarea parolelor folosite de utilizatori in cadrul unor aplicatii/situri Web. Utilizatorii vor avea acces la functionalitati pe baza unui cont. Fiecare inregistrare va avea asociate meta-date precum titlu, nume de utilizator, parola, adresa Web, comentarii, timp maxim de valabilitate a parolei etc. Informatiile de autentificare vor putea fi grupate conform diferitelor categorii (e.g., in functie de domeniul sitului, dupa “taria” parolei, frecventa utilizarii). Aplicatia va oferi si un generator de parole “sigure” si posibilitatea de a exporta datele in formatele CSV, JSON si XML. Parolele vor fi stocate intr-un mod “sigur” pe baza unui sistem de stocare persistenta (de exemplu, un server de baze de date).

Descriere:
  Aplicatia gestioneaza date de autentificare a utilizatorilor. Userul trebuie sa se autentifice sau sa se inregistreze pentru a folosi aplicatia. Odata intrat in cont, utilizatorul poate adauga date de autentificare, cu optiunea de a genera o parola sigura, poate edita date sau poate sa stearga date introduse. De asemenea, utilizatorul poate sa salveze datele introduse sub un format CSV, JSON si XML.
  Pentru dezvoltarea aplicatiei vom folosi PHP pentru back-end si pentru baza de date relationala vom folosi MySQL.

Database:
Users(user_id, username)
Passwords(id(user_id), password, hint)
WebpageItems(item_id, uid(user_id), title, username, password, url, comments, max_time)

Model:
User(username, password, hint)
Item(title, username, password, url, comments, max_time)

View:
UserView - afiseaza datele contului (pentru schimbare parola)
ItemView - afiseaza intr-o lista meta-datele asociate contului + afisare grupat(dupa domeniu, dupa taria parolei, frecventa utilizarii)

Controller:
UserController - functionalitati: inregistrare, logare, schimbare parola(prin trimitere mail)
ItemController - functionalitati: adaugare, stergere, update + generator parole sigure + export date (format: CSV/JSON/XML)

![Diagrama UML](Passer.png)
