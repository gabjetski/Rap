# Cheatsheet

## ITP Projekt Rap

Hier sind sämtliche infos die nicht direkt im Code erkennbar sind. (z.B die verschiedenen Fehlercodes)

<br>
<br>

## Modules

Die verschiedenen Module für die die Permissions vergeben werden können und ihre Nummern.
<br>

### Zum verwenden der Permission:

require_once 'permissions.php';

### Zum checken, ob ein User Permission hat

permission(**_User-Id_**, **_Modul-Nummer_**);  
--> returned ein boolean

### die Module:

| **Modul-Name** | **Modul-Nummer** |
| -------------- | ---------------- |
| Download       | 1                |
| Upload         | 2                |
| LoginRegister  | 3                |
| adminEdit      | 4                |

<br>
<br>
 
## Fehlercodes

### SQL Procedure _addUser_

| **Error-code** | **short term**          | **description**                                                                                                             |
| -------------- | ----------------------- | --------------------------------------------------------------------------------------------------------------------------- |
| -1             | username taken          | The given username is already taken by another user.                                                                        |
| -2             | email taken             | The given email is already taken by another user.                                                                           |
| -3             | non valid email         | The given email doesnt match our email validation.                                                                          |
| -4             | username is valid email | The given username matches our email validation. In order to have only one input field when loging in, this is not allowed. |
| -5             | first name non valid    | The given first name doesnt match our first-name validation.                                                                |
| -6             | last name non valid     | The given last name doesnt match our last-name validation.                                                                  |
| -7             | username non valid      | The given username doesnt match our username validation.                                                                    |
| -8             | passwords doesnt match  | The given password doesnt match the given second password.                                                                  |
