# Passer
Proiect Tehnologii Web - Passer

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

